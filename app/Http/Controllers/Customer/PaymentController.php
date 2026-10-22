<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PaymentController extends Controller
{
    public function __construct()
    {
        putenv('STRIPE_SUPPRESS_NOTICES=true');
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function payDeposit(Conversation $conversation)
    {
        abort_unless($conversation->customer_id === auth()->id(), 403);

        $req = $conversation->request;
        abort_unless($req && $req->payment_status === 'deposit_pending', 403, 'Deposit is not payable right now.');

        $artistProfile = $req->artist->artistProfile;
        abort_unless($artistProfile?->stripe_account_id && $artistProfile->stripe_onboarded, 403, 'Artist is not ready to receive payments.');

        $platformFee = (float) config('services.stripe.platform_fee', 10);
        $depositAmount = (float) $req->deposit_amount;          // artist's share
        $totalCharged  = $depositAmount + $platformFee;         // what the customer pays

        // record the pending payment
        $payment = Payment::create([
            'tattoo_request_id' => $req->id,
            'customer_id'       => auth()->id(),
            'artist_id'         => $req->artist_id,
            'type'              => 'deposit',
            'amount'            => $depositAmount,
            'platform_fee'      => $platformFee,
            'total_charged'     => $totalCharged,
            'status'            => 'pending',
        ]);

        // Stripe Checkout — destination charge (artist gets deposit, platform keeps fee)
        $session = CheckoutSession::create([
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => ['name' => 'Tattoo Deposit — ' . $req->artist->name],
                    'unit_amount'  => (int) round($totalCharged * 100), // cents
                ],
                'quantity' => 1,
            ]],
            'payment_intent_data' => [
                'application_fee_amount' => (int) round($platformFee * 100),  // platform keeps this
                'transfer_data' => [
                    'destination' => $artistProfile->stripe_account_id,       // rest goes to artist
                ],
            ],
            'metadata' => [
                'payment_id' => $payment->id,   // webhook reads this
                'type'       => 'deposit',
            ],
            'success_url' => route('customer.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('customer.payment.cancel'),
        ]);

        $payment->update(['stripe_checkout_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function success()
    {
        return redirect()->route('customer.requests')
            ->with('success', 'Payment successful! Your booking is confirmed.');
    }

    public function cancel()
    {
        return redirect()->route('customer.requests')
            ->with('error', 'Payment was cancelled.');
    }

    public function payBalance(Conversation $conversation)
    {
        abort_unless($conversation->customer_id === auth()->id(), 403);

        $req = $conversation->request;
        abort_unless($req && $req->payment_status === 'balance_pending', 403, 'Balance is not payable right now.');

        $artistProfile = $req->artist->artistProfile;
        abort_unless($artistProfile?->stripe_account_id && $artistProfile->stripe_onboarded, 403, 'Artist is not ready to receive payments.');

        $balance = (float) $req->remaining_balance;   // price − deposit
        abort_unless($balance > 0, 403, 'No balance remaining.');

        $payment = Payment::create([
            'tattoo_request_id' => $req->id,
            'customer_id'       => auth()->id(),
            'artist_id'         => $req->artist_id,
            'type'              => 'balance',
            'amount'            => $balance,
            'platform_fee'      => 0,            // no platform fee on the balance
            'total_charged'     => $balance,
            'status'            => 'pending',
        ]);

        $session = CheckoutSession::create([
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => ['name' => 'Tattoo Balance — ' . $req->artist->name],
                    'unit_amount'  => (int) round($balance * 100),
                ],
                'quantity' => 1,
            ]],
            'payment_intent_data' => [
                // no application_fee_amount → artist gets the full balance
                'transfer_data' => [
                    'destination' => $artistProfile->stripe_account_id,
                ],
            ],
            'metadata' => [
                'payment_id' => $payment->id,
                'type'       => 'balance',
            ],
            'success_url' => route('customer.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('customer.payment.cancel'),
        ]);

        $payment->update(['stripe_checkout_session_id' => $session->id]);

        return redirect($session->url);
    }
}