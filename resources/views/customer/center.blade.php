@extends('customer.layouts.app')
@section('title', 'Account Center')

@section('content')

<div class="row">
    <!-- News Flash -->
    <div class="col-md-12">
        <h2 class="title">Account Center</h2>
    </div>
</div>
<div class="discount-box">
    <div class="col-md-12">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p>Get Discount</p>
                <h4>Up to 15% OFF</h4>
            </div>
            <div class="col-md-4">
                <div class="discount-img">
                    <img src="{{ asset('portal/img/discount-placeholder.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="booking-tabs">
    <div class="row">
        <div class="col-md-12">
            <div class="ms-panel ms-panel-fh">
                <div class="ms-panel-body clearfix">
                    <div class="nav-tabs-upper">
                        <h3>Booking</h3>
                        <ul class="nav nav-tabs d-flex nav-justified" role="tablist">
                            <li role="presentation" ><a href="#tab13" aria-controls="tab13" class="active" role="tab" data-toggle="tab">Request</a></li>
                            <li role="presentation" ><a href="#tab14" aria-controls="tab14" role="tab" data-toggle="tab">Upcoming </a></li>
                            <li role="presentation" ><a href="#tab15" aria-controls="tab15" role="tab" data-toggle="tab">Completed </a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        {{-- REQUEST tab (pending) --}}
                        <div role="tabpanel" class="tab-pane active show fade in" id="tab13">
                            <div class="row">
                                @forelse($pending as $req)
                                    @php
                                        $artistAvatar = $req->artist->artistProfile?->avatar
                                            ? asset('storage/'.$req->artist->artistProfile->avatar)
                                            : 'https://ui-avatars.com/api/?name='.urlencode($req->artist->name).'&size=60';
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="custom-tattoo-design">
                                            <a href="javascript:;" class="ms-toggler open-request-detail"
                                            data-target="#ms-recent-activity" data-toggle="slideRight"
                                            data-request-id="{{ $req->id }}">
                                                <h4>{{ \Illuminate\Support\Str::limit($req->idea, 30) ?: 'Custom Tattoo Design' }}</h4>
                                                <p>{{ ucfirst($req->status) }}</p>
                                                <div class="user-img">
                                                    <img src="{{ $artistAvatar }}" alt="">
                                                    <div>
                                                        <p>{{ $req->artist->name }}</p>
                                                        <span>{{ $req->artist->artistProfile?->shop_name ?: '—' }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12"><p class="text-muted">No pending requests.</p></div>
                                @endforelse
                            </div>
                        </div>

                        {{-- UPCOMING tab --}}
                        <div role="tabpanel" class="tab-pane fade" id="tab14">
                            <div class="row">
                                @forelse($upcoming as $req)
                                    @php
                                        $artistAvatar = $req->artist->artistProfile?->avatar
                                            ? asset('storage/'.$req->artist->artistProfile->avatar)
                                            : 'https://ui-avatars.com/api/?name='.urlencode($req->artist->name).'&size=60';
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="custom-tattoo-design">
                                            <a href="javascript:;" class="ms-toggler open-request-detail"
                                            data-target="#ms-recent-activity" data-toggle="slideRight"
                                            data-request-id="{{ $req->id }}">
                                                <h4>{{ \Illuminate\Support\Str::limit($req->idea, 30) ?: 'Custom Tattoo Design' }}</h4>
                                                <p>{{ $req->created_at->format('D, M Y') }}</p>
                                                <div class="user-img">
                                                    <img src="{{ $artistAvatar }}" alt="">
                                                    <p>{{ $req->artist->name }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12"><p class="text-muted">No upcoming bookings.</p></div>
                                @endforelse
                            </div>
                        </div>

                        {{-- COMPLETED tab --}}
                        <div role="tabpanel" class="tab-pane fade" id="tab15">
                            <div class="row">
                                @forelse($completed as $req)
                                    @php
                                        $artistAvatar = $req->artist->artistProfile?->avatar
                                            ? asset('storage/'.$req->artist->artistProfile->avatar)
                                            : 'https://ui-avatars.com/api/?name='.urlencode($req->artist->name).'&size=60';
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="custom-tattoo-design">
                                            <a href="javascript:;" class="ms-toggler open-request-detail"
                                            data-target="#ms-recent-activity" data-toggle="slideRight"
                                            data-request-id="{{ $req->id }}">
                                                <h4>{{ \Illuminate\Support\Str::limit($req->idea, 30) ?: 'Custom Tattoo Design' }}</h4>
                                                <p>{{ $req->created_at->format('D, M Y') }}</p>
                                                <div class="user-img">
                                                    <img src="{{ $artistAvatar }}" alt="">
                                                    <p>{{ $req->artist->name }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12"><p class="text-muted">No completed tattoos yet.</p></div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('click', async function (e) {
    const card = e.target.closest('.open-request-detail');
    if (!card) return;

    const id = card.dataset.requestId;
    try {
        const res = await fetch(`/requests/${id}/detail`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) return;
        const d = await res.json();

        document.getElementById('rd-status').textContent    = d.status;
        document.getElementById('rd-idea').textContent      = d.idea;
        document.getElementById('rd-placement').textContent = d.placement;
        document.getElementById('rd-size').textContent      = d.size;
        document.getElementById('rd-days').textContent      = d.days;
        document.getElementById('rd-time').textContent      = d.time;
        document.getElementById('rd-budget').textContent    = d.budget;
        document.getElementById('rd-pronouns').textContent  = d.pronouns;
        document.getElementById('rd-timeframe').textContent = d.timeframe;

        document.getElementById('rd-artist-name').childNodes[0].nodeValue = d.artist + ' ';
        document.getElementById('rd-artist-shop').textContent = d.shop;
        document.getElementById('rd-artist-avatar').src = d.artistAvatar;

        // reference images
        const imgWrap = document.getElementById('rd-images');
        imgWrap.innerHTML = '';
        d.images.forEach(url => {
            const img = document.createElement('img');
            img.src = url;
            imgWrap.appendChild(img);
        });

        // chat link
        const chatLink = document.getElementById('rd-chat-link');
        if (d.chatUrl) {
            chatLink.href = d.chatUrl;
            chatLink.style.display = '';
        } else {
            chatLink.style.display = 'none';
        }
    } catch (err) { /* silent */ }
});
</script>
@endpush

@endsection