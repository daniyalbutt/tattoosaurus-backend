@extends('layouts.app')
@section('title', 'Artist Gallery - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>ARTIST GALLERY</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="tattoo-artists">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <form method="GET" action="{{ route('artist.search') }}" class="artist-search-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control"
                               value="{{ request('q') }}"
                               placeholder="Search by name, shop, or location…">
                        <button type="submit" class="btn btn-white">Search</button>
                        @if(request('q'))
                            <a href="{{ route('artist.search') }}" class="btn btn-gradient ms-2">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        @if(request('q'))
        <div class="row mb-3">
            <div class="col-md-12">
                <p class="text-white">
                    {{ $artists->count() }} result{{ $artists->count() !== 1 ? 's' : '' }} for "{{ request('q') }}"
                </p>
            </div>
        </div>
        @endif
        <div class="row">
            @forelse($artists as $artist)
            <div class="col-lg-4 mb-4">
                <div class="masonry-item masonry-item-artist">
                    <a href="{{ route('artist.public.show', $artist->artistProfile) }}">
                        <img src="{{ $artist->artistProfile?->display_image ?: asset('img/placeholder-img.jpg') }}" alt="{{ $artist->name }}">
                    </a>
                    <div class="artist-name">
                        <img src="{{ $artist->artistProfile?->display_avatar }}" alt="{{ $artist->name }}">
                        <h1>{{ $artist->name }} <span>{{ $artist->artistProfile?->location ?: '—' }}</span></h1>
                    </div>
                    <div class="artist-bottom">
                        <ul>
                            @auth
                                @if(auth()->user()->hasRole('customer'))
                                    <li>
                                        <a href="#"
                                        class="favourite-btn {{ in_array($artist->id, $favouriteIds ?? []) ? 'active' : '' }}"
                                        data-artist-id="{{ $artist->id }}">
                                            <i class="fa-solid fa-heart"></i>
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a href="#" class="favourite-guest-btn" data-artist-id="{{ $artist->id }}"
                                    data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <i class="fa-solid fa-heart"></i>
                                    </a>
                                </li>
                            @endauth
                            <li><a href="#"><i class="fa-solid fa-comment-dots"></i></a></li>
                            <li><a href="#"><i class="fa-solid fa-share-nodes"></i></a></li>
                            <li><a href="#"><i class="fa-solid fa-flag"></i></a></li>
                        </ul>
                        <ul>
                            <li><a href="#"><i class="fa-solid fa-bookmark"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p class="text-white">No artists available yet.</p>
            </div>
        @endforelse
        </div>

        <div class="row justify-content-center mt-5 pt-5">
            <div class="col-xl-7">
                <div class="section-heading text-center section-white">
                    <h6>explore Our ARTIST</h6>
                    <h2>Discover Our <span class="gold-line">Tattoo</span> Artistry</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and<br>typesetting industry. Lorem Ipsum has been </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="near-by mt-0">
                    <div class="artist-slider slick-slider">
                        @forelse($highlighted as $artist)
                            @php $profile = $artist->artistProfile; @endphp
                            <div class="artist-wrapper">
                                <div class="artist-box">
                                    <a href="{{ route('artist.public.show', $profile) }}">
                                        <img src="{{ $profile?->display_image ?: asset('img/placeholder-img.jpg') }}" alt="{{ $artist->name }}">
                                        <div class="artist-lower">
                                            <h6>{{ $profile?->location ?: '—' }}</h6>
                                            <h4>{{ $artist->name }}</h4>
                                            <p>{{ \Illuminate\Support\Str::limit($profile?->bio, 45) ?: 'Tattoo artist' }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="artist-wrapper">
                                <div class="artist-box">
                                    <img src="{{ asset('img/artist-img-1.png') }}" alt="">
                                    <div class="artist-lower">
                                        <h4>No featured artists yet</h4>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection