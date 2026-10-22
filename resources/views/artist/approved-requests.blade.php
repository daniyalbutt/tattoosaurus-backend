@extends('artist.layouts.app')
@section('title', 'Approved Requests')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Approved Requests</h2>
    </div>
</div>

@if(session('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    </div>
@endif

<div class="row">
    @forelse($requests as $req)
        @php
            $conv     = $req->conversation;
            $customer = $conv?->customer;
            $platformFee = config('services.stripe.platform_fee', 10);
            [$statusLabel, $statusColor] = $req->status_label;

            $depositPaid = $req->payments->firstWhere(fn ($p) => $p->type === 'deposit' && $p->status === 'paid');
            $balancePaid = $req->payments->firstWhere(fn ($p) => $p->type === 'balance' && $p->status === 'paid');
        @endphp
        <div class="col-xl-6 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-body">

                    {{-- header: customer + status --}}
                    <div class="media mb-3">
                        <div class="ms-chat-status ms-status-online ms-chat-img mr-3 align-self-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name ?? 'Customer') }}&size=80"
                                 class="ms-img-round" alt="customer" style="width:48px;height:48px;">
                        </div>
                        <div class="media-body align-self-center">
                            <h5 class="mb-1">{{ $customer->name ?? 'Customer' }}</h5>
                            <span class="badge badge-{{ $statusColor }}">{{ $statusLabel }}</span>
                            <span class="text-muted fs-12 ml-2">Approved {{ $req->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- brief summary --}}
                    <p class="fs-13 text-muted mb-3">
                        <strong>Placement:</strong> {{ $req->placement ?: '—' }} &nbsp;·&nbsp;
                        <strong>Size:</strong> {{ $req->size ?: '—' }}
                    </p>

                    {{-- pricing table --}}
                    @if($req->tattoo_price)
                        <table class="table table-sm table-borderless mb-3">
                            <tbody>
                                <tr>
                                    <td class="pl-0"><strong>Tattoo Price</strong></td>
                                    <td class="text-right">${{ number_format($req->tattoo_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="pl-0">
                                        <strong>Deposit</strong>
                                        @if($depositPaid)
                                            <span class="badge badge-success ml-1">Paid</span>
                                        @else
                                            <span class="badge badge-warning ml-1">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="text-right">${{ number_format($req->deposit_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="pl-0"><strong>Platform Fee</strong></td>
                                    <td class="text-right">${{ number_format($platformFee, 2) }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="pl-0">
                                        <strong>Remaining Balance</strong>
                                        @if($balancePaid)
                                            <span class="badge badge-success ml-1">Paid</span>
                                        @endif
                                    </td>
                                    <td class="text-right"><strong>${{ number_format($req->remaining_balance, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-light mb-3 fs-13">Pricing not set yet.</div>
                    @endif

                    {{-- action --}}
                    @if($conv)
                        <a href="{{ route('artist.requests.show', $conv) }}" class="btn btn-black btn-sm">
                            <i class="material-icons align-middle mr-1" style="font-size:16px;">chat</i>
                            Open Conversation
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-body text-center py-5">
                    <h5 class="text-muted mb-2">No approved requests yet.</h5>
                    <p class="text-muted mb-0">Requests you approve will appear here with their payment details.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

@endsection