@extends('customer.layouts.app')
@section('title', 'My Tattoo Favourite Artists')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="title border-title">Tattoo Favourite Artists</h2>
    </div>
</div>
<div class="favourite-artists-wrapper">
    <div class="row">
        @forelse($favourites as $artist)
            @php
                $profile = $artist->artistProfile;
                $featured = $profile?->featured_image;
                $featuredImage = $featured
                    ? asset('storage/'.$featured)
                    : asset('img/placeholder-img.jpg');
            @endphp
            <div class="col-md-3">
                <div class="favourite-artists-box">
                    <div class="favourite-artists-featured-image">
                        <img src="{{ $featuredImage }}" alt="{{ $artist->name }}">
                    </div>
                    <div class="favourite-user-img">
                        <img src="{{ $profile?->display_avatar ?: asset('img/placeholder-img.jpg') }}" alt="{{ $artist->name }}">
                        <div>
                            <h4>{{ $artist->name }}</h4>
                            <span>{{ $artist->artistProfile?->shop_name ?: '—' }}</span>
                        </div>
                    </div>
                    <p>{{ \Illuminate\Support\Str::limit($profile?->bio, 60) ?: 'Tattoo artist' }}</p>
                    <a href="{{ route('artist.public.show', $profile) }}" class="btn btn-dark">more details</a>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <p>You haven't favourited any artists yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection