@extends('artist.layouts.app')
@section('title', 'Payouts')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="title">Payouts</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if($profile?->stripe_onboarded)
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success me-2" style="font-size:14px;color: white;font-weight: 400;display: inline-block;margin-right: 10px;">
                            <i class="fa fa-check-circle"></i> Connected
                        </span>
                        <span>Your Stripe account is active and ready to receive payouts.</span>
                    </div>
                    <p class="text-muted mb-0">
                        Payments from confirmed bookings will be deposited to your connected bank account.
                    </p>
                @elseif($profile?->stripe_account_id)
                    <div class="mb-3">
                        <span class="badge bg-warning" style="font-size:14px;">Incomplete</span>
                    </div>
                    <p>You've started connecting your Stripe account but haven't finished. Complete onboarding to receive payouts.</p>
                    <form method="POST" action="{{ route('artist.payouts.connect') }}">
                        @csrf
                        <button class="btn btn-black">Continue Stripe Setup</button>
                    </form>
                @else
                    <h4>Connect your Stripe account</h4>
                    <p class="text-muted">
                        To receive payments from your tattoo bookings, connect a Stripe account.
                        Stripe securely handles your payout details — Tattoosaurus never sees your bank information.
                    </p>
                    <form method="POST" action="{{ route('artist.payouts.connect') }}">
                        @csrf
                        <button class="btn btn-black">
                            <i class="fa-brands fa-stripe-s me-1"></i> Connect with Stripe
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection