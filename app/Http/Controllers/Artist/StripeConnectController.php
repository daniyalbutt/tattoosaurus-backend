<?php
namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;

class StripeConnectController extends Controller
{
    public function __construct()
    {
        putenv('STRIPE_SUPPRESS_NOTICES=true');
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function index()
    {
        $profile = auth()->user()->artistProfile;
        return view('artist.payouts', compact('profile'));
    }

    // Create (or reuse) the connected account, then send artist to Stripe onboarding
    public function connect()
    {
        $profile = auth()->user()->artistProfile;

        // create the Express account once
        if (! $profile->stripe_account_id) {
            $account = Account::create([
                'type'    => 'express',
                'email'   => auth()->user()->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers'     => ['requested' => true],
                ],
                'business_type' => 'individual',
                'metadata' => ['artist_id' => auth()->id()],
            ]);
            $profile->update(['stripe_account_id' => $account->id]);
        }

        // generate the onboarding link
        $link = AccountLink::create([
            'account'     => $profile->stripe_account_id,
            'refresh_url' => route('artist.payouts.refresh'),
            'return_url'  => route('artist.payouts.return'),
            'type'        => 'account_onboarding',
        ]);

        return redirect($link->url);
    }

    // Stripe sends the artist back here after onboarding
    public function return()
    {
        $profile = auth()->user()->artistProfile;

        if ($profile->stripe_account_id) {
            $account = Account::retrieve($profile->stripe_account_id);
            $profile->update([
                'stripe_onboarded' => $account->details_submitted && $account->charges_enabled,
            ]);
        }

        return redirect()->route('artist.payouts')
            ->with('success', $profile->fresh()->stripe_onboarded
                ? 'Your Stripe account is connected and ready to receive payouts.'
                : 'Onboarding started. Please complete all required steps.');
    }

    // Link expired — regenerate and retry
    public function refresh()
    {
        return redirect()->route('artist.payouts.connect');
    }
}