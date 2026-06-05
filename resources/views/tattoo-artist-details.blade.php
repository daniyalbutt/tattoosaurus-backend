@extends('layouts.app')

@section('title', $user->name . ' - Tattoosaurus')

@section('content')

@php
    $avatar = $profile?->avatar
        ? asset('storage/'.$profile->avatar)
        : asset('img/artist-detail-img.png');
    $portfolio = $profile?->portfolio_images ?? [];
    $faqs      = $profile?->faqs ?? [];
    $styles    = $profile?->styles ?? [];
    $links     = $profile?->social_links ?? [];
    $location  = collect([$profile?->city?->name, $profile?->country?->name])->filter()->implode(', ');
@endphp

<section class="banner inner-banner artists-detail-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading"></div>
            </div>
        </div>
    </div>
</section>

<section class="artists-detail">
    <div class="container">
        <div class="row">
            <div class="col-xl-9">
                <div class="artists-info">
                    <div class="artists-left">
                        <div class="artist-detail-img">
                            <img src="{{ $avatar }}" alt="{{ $user->name }}">
                        </div>
                        <p><i class="fa-solid fa-star"></i> 4.7 | Rating</p>
                    </div>
                    <div class="artists-right">
                        <h4>{{ $user->name }}</h4>
                        <div class="line">
                            <img src="{{ asset('img/line-bg.png') }}" alt="">
                        </div>
                        <p>{{ $profile?->bio ?: 'This artist has not added a bio yet.' }}</p>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-gradient">Tattoo Request</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="artist-social">
                    <ul class="footer-social">
                        @if(!empty($links['facebook']))
                            <li><a href="{{ $links['facebook'] }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                        @endif
                        @if(!empty($links['twitter']))
                            <li><a href="{{ $links['twitter'] }}" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                        @endif
                        @if(!empty($links['linkedin']))
                            <li><a href="{{ $links['linkedin'] }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        @endif
                        @if(!empty($links['instagram']))
                            <li><a href="{{ $links['instagram'] }}" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                        @endif
                    </ul>
                    <ul class="artist-list">
                        <li><p><i class="fa-solid fa-calendar"></i> {{ $profile?->availability ?: 'Availability not set' }}</p></li>
                        <li><p><i class="fa-solid fa-paper-plane"></i> {{ $profile?->response_time ?: 'Response time not set' }}</p></li>
                        <li><p><i class="fa-solid fa-comment"></i> Chat With Me</p></li>
                        @if($profile?->hourly_rate)
                            <li><p><i class="fa-solid fa-percent"></i> Hourly Rate - ${{ number_format($profile->hourly_rate, 0) }}</p></li>
                        @endif
                        @if(!empty($styles))
                            <li><p><i class="fa-solid fa-pen-nib"></i> {{ collect($styles)->map(fn($s) => ucfirst($s))->implode(', ') }}</p></li>
                        @endif
                    </ul>
                    <a href="#">Report Artist</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gallery pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="section-heading section-white">
                    <h4>Artist Gallery</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="masonry-grid">
                    {{-- sizer defines column width: 3 columns = 33.333% --}}
                    <div class="masonry-sizer"></div>

                    @forelse($portfolio as $item)
                        <div class="masonry-item">
                            <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['description'] ?? '' }}">
                            <div class="artist-name">
                                <img src="{{ $avatar }}" alt="">
                                <h1>{{ $user->name }} <span>{{ $location }}</span></h1>
                            </div>
                            <div class="artist-bottom">
                                <ul>
                                    <li><a href="#"><i class="fa-solid fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa-solid fa-comment-dots"></i></a></li>
                                    <li><a href="#"><i class="fa-solid fa-share-nodes"></i></a></li>
                                    <li><a href="#"><i class="fa-solid fa-flag"></i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="#"><i class="fa-solid fa-bookmark"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    @empty
                        <p class="text-center w-100 text-white">No gallery images yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<section class="artist-testimonials">
    <section class="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="section-heading section-white">
                        <h6>Testimonials</h6>
                        <h2>What Our Clients Say <span>About Tattoosaurus</span></h2>
                        <div class="line">
                            <img src="{{ asset('img/line-bg.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="testimonials-slider slick-slider">
                        @include('components.testimonials')
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<section class="faqs">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="section-heading text-center">
                    <h6>FAQ</h6>
                    <h2>Artist FAQ’s</h2>
                    <div class="line">
                        <img src="{{ asset('img/line-bg.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="faqs-wrapper">
                    <div class="accordion" id="accordionExample">
                        @forelse($faqs as $i => $faq)
                            @if(!empty($faq['q']))
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $i !== 0 ? 'collapsed' : '' }}" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}"
                                                aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                                            {{ $faq['q'] }}
                                        </button>
                                    </h2>
                                    <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}">
                                        <div class="accordion-body">
                                            <p>{{ $faq['a'] ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-center">No FAQs added yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection