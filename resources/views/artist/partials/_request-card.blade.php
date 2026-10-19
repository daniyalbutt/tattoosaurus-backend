{{-- resources/views/artist/partials/_request-card.blade.php --}}
@php
    $conv     = $req->conversation;
    $customer = $conv?->customer;
    [$cardStatus, ] = $req->status_label;
    $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($customer->name ?? 'Customer') . '&size=80';
@endphp
<div class="col-md-3">
    <div class="custom-tattoo-design">
        <a href="javascript:;" class="open-request"
           data-url="{{ route('artist.request.detail', $req) }}">
            <h4>{{ $req->idea ? \Illuminate\Support\Str::limit($req->idea, 24) : 'Custom Tattoo Design' }}</h4>
            <p>{{ $cardStatus }}</p>
            <div class="user-img">
                <img src="{{ $avatar }}" alt="">
                <p>{{ $customer->name ?? 'Username' }}</p>
            </div>
        </a>
    </div>
</div>