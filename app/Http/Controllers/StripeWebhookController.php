<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ArtistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;

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
        } elseif ($payment->type === 'balance') {
            $req->update(['payment_status' => 'fully_paid']);
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
        if ($payment) {
            $payment->update(['status' => 'failed']);
            $payment->request->update(['payment_status' => 'payment_failed']);
        }
    }

    private function handleAccountUpdated($account)
    {
        $profile = ArtistProfile::where('stripe_account_id', $account->id)->first();
        if ($profile) {
            $profile->update([
                'stripe_onboarded' => ($account->details_submitted && $account->charges_enabled),
            ]);
        }
    }

    private function handleRefund($charge)
    {
        $payment = Payment::where('stripe_payment_intent_id', $charge->payment_intent)->first();
        if ($payment) {
            $payment->update(['status' => 'refunded']);
            $payment->request->update(['payment_status' => 'refunded']);
        }
    }
}