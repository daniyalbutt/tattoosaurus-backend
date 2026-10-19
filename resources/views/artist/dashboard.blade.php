@extends('artist.layouts.app')
@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="title">Welcome, {{ auth()->user()->name }}</h2>
        </div>
    </div>

    @php $completion = $profile?->completion ?? 0; @endphp

    @if($completion < 100)
        <div class="discount-box mb-4">
            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <p>Complete Your Profile</p>
                        <h4>You've completed <strong>{{ $completion }}%</strong></h4>
                        <h6 class="mt-2">Complete your profile to get discovered by clients</h6>
                    </div>
                    <div class="col-md-4">
                        <div class="discount-img">
                            <a href="{{ route('artist.profile.edit') }}" class="btn btn-white mt-2 mt-md-0">
                                Update Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="progress mt-3" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $completion }}%;"
                        aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-body">
                        <h4 class="mb-0">Your profile is 100% complete 🎉</h4>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Live stat cards --}}
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('artist.requests') }}">
                <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                    <span class="msg-count">{{ $stats['new_requests'] }}</span>
                    <div class="ms-panel-body d-flex align-items-start">
                        <i class="material-icons">inbox</i>
                        <div class="flex-grow-1">
                            <h6>New Requests</h6>
                            <span>Review incoming</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('artist.requests.approved') }}">
                <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                    <span class="msg-count">{{ $stats['approved'] }}</span>
                    <div class="ms-panel-body d-flex align-items-start">
                        <i class="material-icons">task_alt</i>
                        <div class="flex-grow-1">
                            <h6>Approved</h6>
                            <span>Approved requests</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('artist.requests.approved') }}">
                <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                    <span class="msg-count">{{ $stats['upcoming'] }}</span>
                    <div class="ms-panel-body d-flex align-items-start">
                        <i class="material-icons">event_available</i>
                        <div class="flex-grow-1">
                            <h6>Upcoming Bookings</h6>
                            <span>Deposit paid</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('artist.requests.approved') }}">
                <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                    <span class="msg-count">{{ $stats['completed'] }}</span>
                    <div class="ms-panel-body d-flex align-items-start">
                        <i class="material-icons">check_circle</i>
                        <div class="flex-grow-1">
                            <h6>Completed</h6>
                            <span>Paid in full</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Booking tabs --}}
    <div class="booking-tabs">
        <div class="row">
            <div class="col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body clearfix">
                        <div class="nav-tabs-upper">
                            <h3>Booking</h3>
                            <ul class="nav nav-tabs d-flex nav-justified" role="tablist">
                                <li role="presentation">
                                    <a href="#tab-request" aria-controls="tab-request" class="active" role="tab" data-toggle="tab">
                                        Request ({{ $pending->count() }})
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#tab-approved" aria-controls="tab-approved" role="tab" data-toggle="tab">
                                        Approved ({{ $approved->count() }})
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#tab-upcoming" aria-controls="tab-upcoming" role="tab" data-toggle="tab">
                                        Upcoming ({{ $upcoming->count() }})
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#tab-completed" aria-controls="tab-completed" role="tab" data-toggle="tab">
                                        Completed ({{ $completed->count() }})
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active show fade in" id="tab-request">
                                <div class="row">
                                    @forelse($pending as $req)
                                        @include('artist.partials._request-card', ['req' => $req])
                                    @empty
                                        <div class="col-12"><p class="text-muted py-4 text-center mb-0">No pending requests.</p></div>
                                    @endforelse
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-approved">
                                <div class="row">
                                    @forelse($approved as $req)
                                        @include('artist.partials._request-card', ['req' => $req])
                                    @empty
                                        <div class="col-12"><p class="text-muted py-4 text-center mb-0">No approved requests.</p></div>
                                    @endforelse
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-upcoming">
                                <div class="row">
                                    @forelse($upcoming as $req)
                                        @include('artist.partials._request-card', ['req' => $req])
                                    @empty
                                        <div class="col-12"><p class="text-muted py-4 text-center mb-0">No upcoming bookings.</p></div>
                                    @endforelse
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-completed">
                                <div class="row">
                                    @forelse($completed as $req)
                                        @include('artist.partials._request-card', ['req' => $req])
                                    @empty
                                        <div class="col-12"><p class="text-muted py-4 text-center mb-0">No completed bookings yet.</p></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .custom-tattoo-design { cursor: pointer; }
    #ms-recent-activity .rd-loading { padding: 2rem 0; text-align: center; color: #999; }

    /* Self-driven slide-out (independent of framework.js) */
    #ms-recent-activity {
        position: fixed;
        top: 0; right: 0; bottom: 0;
        transform: translateX(110%);
        transition: transform .3s ease;
        will-change: transform;
        z-index: 1030;
        overflow: visible !important;
    }

    .ms-close-activity{
        position: absolute;
        top: 14px;
        left: -21px;
        z-index: 999999999;
        color: #2C2B2B;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        background-color: black;
        padding: 5px;
        border-radius: 50px;
    }

    #ms-recent-activity.is-open { transform: translateX(0); }

    #rd-backdrop {
        position: fixed; inset: 0;
        background: rgb(0 0 0 / 94%);
        opacity: 0; visibility: hidden;
        transition: opacity .3s ease;
        z-index: 1029;   /* just under the panel */
    }
    #rd-backdrop.is-open { opacity: 1; visibility: visible; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const panel = document.getElementById('ms-recent-activity');
    if (!panel) return;

    const body = panel.querySelector('#rd-detail-body');

    function money(v) {
        if (v === null || v === undefined || v === '') return null;
        return '$' + parseFloat(v).toFixed(2);
    }

    const designer     = document.getElementById('rd-designer');
    const designerImg  = document.getElementById('rd-designer-img');
    const designerName = document.getElementById('rd-designer-name');
    const designerChat = document.getElementById('rd-designer-chat');

    function render(d) {
        const imgs = (d.images || []).map(u =>
            `<img src="${u}" alt="">`).join('');

        const pricing = d.tattoo_price ? `
            <div class="booking-box">
                <h6>Pricing</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="pl-0">Tattoo Price</td><td class="text-right">${money(d.tattoo_price)}</td></tr>
                    <tr><td class="pl-0">Deposit</td><td class="text-right">${money(d.deposit)}</td></tr>
                    <tr><td class="pl-0">Platform Fee</td><td class="text-right">${money(d.platform_fee)}</td></tr>
                    <tr class="border-top"><td class="pl-0"><strong>Remaining</strong></td>
                        <td class="text-right"><strong>${money(d.remaining)}</strong></td></tr>
                </table>
            </div>` : '';

        body.innerHTML = `
            <div class="booking-information">
                <h3>${d.customer}</h3>
                <span class="badge badge-${d.status_color}">${d.status_label}</span>
            </div>
            ${imgs ? `<div class="booking-images">${imgs}</div>` : ''}
            <div class="booking-box"><h6>Description</h6><p>${d.idea || '—'}</p></div>
            <div class="booking-box"><h6>Placement</h6><p>${d.placement || '—'}</p></div>
            <div class="booking-box"><h6>Size</h6><p>${d.size || '—'}</p></div>
            <div class="booking-box"><h6>Budget</h6><p>${d.budget || '—'}</p></div>
            <div class="booking-box"><h6>Available days</h6><p>${d.days || '—'}</p></div>
            <div class="booking-box"><h6>Time</h6><p>${d.time_pref || '—'}</p></div>
            ${pricing}
        `;

        // customer footer
        if (designer) {
            designerName.textContent = d.customer;
            if (d.avatar) designerImg.src = d.avatar;
            designerChat.href = d.chat_url;
            designer.style.display = '';
        }
    }

    // ── Own the open/close, don't depend on framework.js ──
    let backdrop = document.getElementById('rd-backdrop');
    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.id = 'rd-backdrop';
        document.body.appendChild(backdrop);
    }

    function openPanel() {
        panel.classList.add('is-open');
        backdrop.classList.add('is-open');
    }
    function closePanel() {
        panel.classList.remove('is-open');
        backdrop.classList.remove('is-open');
    }

    document.querySelectorAll('.open-request').forEach(a => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            openPanel();
            const url = this.dataset.url;
            body.innerHTML = '<div class="rd-loading">Loading…</div>';
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(render)
                .catch(() => { body.innerHTML = '<div class="rd-loading">Could not load details.</div>'; });
        });
    });

    // Close: × button, the circle-left overlay link, the backdrop, and Esc
    document.querySelectorAll('#ms-recent-activity .ms-close-activity, .ms-overlay-right, .ms-overlay-right a')
        .forEach(el => el.addEventListener('click', function (e) { e.preventDefault(); closePanel(); }));
    backdrop.addEventListener('click', closePanel);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closePanel(); });
})();
</script>
@endpush