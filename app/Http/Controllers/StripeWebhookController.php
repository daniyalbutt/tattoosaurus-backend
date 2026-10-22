<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ArtistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Notifications\GeneralNotification;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('STRIPE WEBHOOK HIT', ['type' => json_decode($request->getContent())->type ?? 'unknown']);
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        switch ($event->type) {

            // ── A payment (deposit or balance) succeeded ──
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;

            // ── A payment failed ──
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            // ── Artist's Connect account status changed ──
            case 'account.updated':
                $this->handleAccountUpdated($event->data->object);
                break;

            // ── A refund was issued ──
            case 'charge.refunded':
                $this->handleRefund($event->data->object);
                break;
        }

        return response('Webhook handled', 200);
    }

    private function handleCheckoutCompleted($session)
    {
        // we stored our Payment id in metadata when creating the session
        $paymentId = $session->metadata->payment_id ?? null;
        if (! $paymentId) return;

        $payment = Payment::find($paymentId);
        if (! $payment || $payment->status === 'paid') return;

        $payment->update([
            'status'                   => 'paid',
            'paid_at'                  => now(),
            'stripe_payment_intent_id' => $session->payment_intent ?? null,
        ]);

        // advance the request's payment_status
        $req = $payment->request;
        if ($payment->type === 'deposit') {
            $req->update(['payment_status' => 'booking_confirmed']);

            // notify the artist
            $payment->artist->notify(new GeneralNotification(
                title: 'Deposit received',
                body:  'Deposit of $' . number_format($payment->amount, 2) . ' paid — booking confirmed.',
                url:   route('artist.requests.show', $req->conversation),
                icon:  'payments',
            ));

            // notify the customer (receipt / confirmation)
            $payment->customer->notify(new GeneralNotification(
                title: 'Booking confirmed',
                body:  'Your deposit of $' . number_format($payment->amount, 2) . ' was received. Booking confirmed!',
                url:   route('customer.requests.show', $req->conversation),
                icon:  'check_circle',
            ));
        } elseif ($payment->type === 'balance') {
            $req->update(['payment_status' => 'fully_paid']);

            // notify the artist
            $payment->artist->notify(new GeneralNotification(
                title: 'Balance paid in full',
                body:  'Remaining balance of $' . number_format($payment->amount, 2) . ' paid.',
                url:   route('artist.requests.show', $req->conversation),
                icon:  'verified',
            ));

            // notify the customer (receipt / confirmation)
            $payment->customer->notify(new GeneralNotification(
                title: 'Payment complete',
                body:  'Your balance of $' . number_format($payment->amount, 2) . ' was paid. Thank you!',
                url:   route('customer.requests.show', $req->conversation),
                icon:  'verified',
            ));
        }

        // ── system message into the chat (from the customer, to the artist) ──
        $conversation = $req->conversation;
        if ($conversation) {
            $body = $payment->type === 'deposit'
                ? 'Deposit of $' . number_format($payment->amount, 2)
                    . ' paid — booking confirmed. Looking forward to the session!'
                : 'Remaining balance of $' . number_format($payment->amount, 2)
                    . ' paid in full. Thank you!';

            $conversation->messages()->create([
                'sender_id' => $payment->customer_id,   // the customer (no auth user in a webhook)
                'body'      => $body,
            ]);
        }
    }

    private function handlePaymentFailed($intent)
    {
        $payment = Payment::where('stripe_payment_intent_id', $intent->id)->first();
        if (! $payment) return;

        $payment->update(['status' => 'failed']);
        $req = $payment->request;
        $req->update(['payment_status' => 'payment_failed']);

        // notify the customer to retry
        $payment->customer->notify(new GeneralNotification(
            title: 'Payment failed',
            body:  'Your ' . $payment->type . ' payment could not be processed. Please try again.',
            url:   route('customer.requests.show', $req->conversation),
            icon:  'error',
        ));

        // notify the artist
        $payment->artist->notify(new GeneralNotification(
            title: 'Customer payment failed',
            body:  'A ' . $payment->type . ' payment from the customer failed.',
            url:   route('artist.requests.show', $req->conversation),
            icon:  'error',
        ));
    }

    private function handleAccountUpdated($account)
    {
        $profile = ArtistProfile::where('stripe_account_id', $account->id)->first();
        if (! $profile) return;

        $wasOnboarded = (bool) $profile->stripe_onboarded;
        $nowOnboarded = ($account->details_submitted && $account->charges_enabled);

        $profile->update(['stripe_onboarded' => $nowOnboarded]);

        // notify the artist only on the transition to "ready"
        if (! $wasOnboarded && $nowOnboarded && $profile->user) {
            $profile->user->notify(new GeneralNotification(
                title: 'Stripe account ready',
                body:  'Your Stripe account is active and ready to receive payouts.',
                url:   route('artist.payouts'),
                icon:  'account_balance',
            ));
        }
    }

    private function handleRefund($charge)
    {
        $payment = Payment::where('stripe_payment_intent_id', $charge->payment_intent)->first();
        if (! $payment) return;

        $payment->update(['status' => 'refunded']);
        $req = $payment->request;
        $req->update(['payment_status' => 'refunded']);

        // notify the customer
        $payment->customer->notify(new GeneralNotification(
            title: 'Payment refunded',
            body:  'Your ' . $payment->type . ' payment of $' . number_format($payment->amount, 2) . ' was refunded.',
            url:   route('customer.requests.show', $req->conversation),
            icon:  'undo',
        ));

        // notify the artist
        $payment->artist->notify(new GeneralNotification(
            title: 'Payment refunded',
            body:  'A ' . $payment->type . ' payment of $' . number_format($payment->amount, 2) . ' was refunded.',
            url:   route('artist.requests.show', $req->conversation),
            icon:  'undo',
        ));
    }
}