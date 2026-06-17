@extends('layouts.app')

@section('title', 'Home - Tattoosaurus')

@section('content')
    <section class="banner home-banner">
        <!-- Video Background -->
        <video class="video-background" autoplay muted loop playsinline>
            <source src="{{ asset('img/banner-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h6>WELCOME TO TATTOOSAURUS</h6>
                        <h1>Find the Best Tattoo <span class="gold-line">Artists</span> Near You</h1>
                        <p>Looking for a skilled tattoo artist? Tattoosaurus is your one-stop destination to find talented tattoo artists, explore portfolios, and book appointments with ease. Whether you’re looking to get your first tattoo or add to your existing collection, our platform makes it simple and convenient to get inked.</p>
                        <div class="button-wrapper">
                            <a href="{{ route('artist.search') }}" class="btn btn-white">EXPLORE ARTISTS</a>
                            <a href="{{ route('tattoo.gallery') }}" class="btn btn-white">TATTOO GALLERY</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="platform">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="section-heading text-center">
                        <h6>WHY CHOOSE TATTOOSAURUS</h6>
                        <h2>The <span class="gold-line">Ultimate</span> Platform for Tattoo Artists and Clients</h2>
                        <p>Tattoosaurus is a dedicated platform that connects tattoo artists and clients, offering a seamless experience for both. We understand the importance of showcasing your art and discovering the perfect tattoo artist, and we’ve built a space that’s tailored to the tattoo community. Here’s why Tattoosaurus stands out:</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="platform-box">
                        <div class="platform-img">
                            <img src="{{ asset('img/platform-1.png') }}" alt="">
                        </div>
                        <h4>Trusted Tattoo<br>Artists</h4>
                        <p>Every tattoo artist on our platform is carefully selected and verified for their skill and professionalism. This ensures that you’ll find high-quality tattoos and a memorable experience.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="platform-box">
                        <div class="platform-img">
                            <img src="{{ asset('img/platform-2.png') }}" alt="">
                        </div>
                        <h4>Secure & Flexible<br>Payments</h4>
                        <p>Our platform offers secure, easy-to-use payment options with flexible financing, making it easier to pay for your tattoos in a way that suits your budget.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="platform-box">
                        <div class="platform-img">
                            <img src="{{ asset('img/platform-3.png') }}" alt="">
                        </div>
                        <h4>Seamless Booking & Customer Support</h4>
                        <p>Booking a tattoo appointment is a breeze with our integrated booking system. Plus, our customer support team is available to help with any questions or concerns, ensuring your tattoo experience is smooth from start to finish.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="showcase">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="section-heading section-white">
                        <h6>EXPLORE OUR GALLERY</h6>
                        <h2>Discover <span class="gold-line">Unique</span> and <span>Timeless Tattoo Art</span></h2>
                        <p>Tattoosaurus features a stunning collection of tattoo designs that will inspire you. Explore our top tattoo galleries, showcasing artwork from talented tattoo artists across different styles. Browse, save your favorite designs, and find the perfect tattoo for your next ink.</p>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="showcase-btn">
                        <a href="{{ route('tattoo.gallery') }}" class="btn btn-gradient">Top Tattoo Galleries</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="gallery-slider slick-slider">
                        @forelse($topArtists as $artist)
                            @php
                                $img = $artist->artistProfile?->featured_image
                                    ? asset('storage/'.$artist->artistProfile->featured_image)
                                    : ($artist->artistProfile?->avatar
                                        ? asset('storage/'.$artist->artistProfile->avatar)
                                        : asset('img/gallery-1.png'));
                            @endphp
                            <div class="gallery-box">
                                <div class="gallery-box-inner">
                                    <a href="{{ route('artist.public.show', $artist) }}">
                                        <img src="{{ $img }}" alt="{{ $artist->name }}">
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="gallery-box">
                                <div class="gallery-box-inner">
                                    <img src="{{ asset('img/gallery-1.png') }}" alt="Gallery">
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center mt-4">
                        <a href="" class="btn btn-gradient">VIEW ALL TATTOOS</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>ABOUT</h6>
                        <h2>Your Top Tattoos Deserve the <span class="gold-line">Spotlight</span></h2>
                        <!-- <div class="line">
                            <img src="{{ asset('img/line-bg.png') }}" alt="">
                            </div> -->
                        <p>Welcome to Tattoosaurus, the ultimate platform designed for tattoo artists to showcase their work and grow their business. At Tattoosaurus, we recognize the struggles artists face with overcrowded social media platforms and unreliable booking systems. That’s why we created a dedicated space for tattoo artists to shine.</p>
                        <div class="testimonials-button justify-content-start">
                            <a href="{{ route('about') }}" class="btn btn-gradient">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-img">
                        <img src="{{ asset('img/about-img.png') }}" alt="About Image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="artist">
        <div class="container">
            <div class="row">
                <div class="col-xl-7">
                    <div class="section-heading section-white">
                        <h6>MEET THE TATTOO ARTISTS</h6>
                        <h2>Discover the <br><span class="gold-line">Masters</span> of Ink</h2>
                        <p>Tattoosaurus is home to some of the best tattoo artists in the industry. Our platform features a curated selection of talented artists who specialize in various tattoo styles. Whether you're looking for realism, traditional, black & grey, or abstract tattoos, you’ll find the perfect match.</p>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="showcase-btn artist-showcase-btn">
                        <a href="{{ route('tattoo.gallery') }}" class="btn btn-gradient">Artist Gallery</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="artist-slider slick-slider">
                        @forelse($featuredArtists as $artist)
                            @php
                                $img = $artist->artistProfile?->featured_image
                                    ? asset('storage/'.$artist->artistProfile->featured_image)
                                    : ($artist->artistProfile?->avatar
                                        ? asset('storage/'.$artist->artistProfile->avatar)
                                        : asset('img/artist-img-1.png'));
                                $loc = collect([
                                    $artist->artistProfile?->city?->name,
                                    $artist->artistProfile?->country?->name,
                                ])->filter()->implode(', ');
                            @endphp
                            <div class="artist-wrapper">
                                <div class="artist-box">
                                    <a href="{{ route('artist.public.show', $artist) }}">
                                        <img src="{{ $img }}" alt="{{ $artist->name }}">
                                        <div class="artist-lower">
                                            <h6>{{ $loc ?: '—' }}</h6>
                                            <h4>{{ $artist->name }}</h4>
                                            <p>{{ \Illuminate\Support\Str::limit($artist->artistProfile?->bio, 45) }}</p>
                                            <div class="star-container d-none">
                                                <p>Rating</p>
                                                <div class="star-rating">
                                                    <i class="fas fa-star star"></i>
                                                    <i class="fas fa-star star"></i>
                                                    <i class="fas fa-star star"></i>
                                                    <i class="fas fa-star star"></i>
                                                    <i class="fas fa-star star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="artist-wrapper">
                                <div class="artist-box">
                                    <img src="{{ asset('img/artist-img-1.png') }}" alt="">
                                    <div class="artist-lower"><h4>No featured artists yet</h4></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center mt-4">
                        <a href="{{ route('artist.search') }}" class="btn btn-gradient">VIEW ALL ARTISTS</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="section-heading text-center">
                        <h6>FEATURED</h6>
                        <h2><span class="gold-line">Empowering</span> Tattoo Artists with Powerful Tools</h2>
                        <p>Tattoosaurus offers tattoo artists the tools they need to manage their art, business, and client relationships. We streamline the booking process, help you manage events, and give you the control to personalize your profile for maximum exposure.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs-wrapper">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="event-wrapper">
                                    <div class="event-slider slick-slider">
                                        <div class="event-box">
                                            <a href="event-details.php">
                                                <div class="event-img">
                                                    <img src="{{ asset('img/event-img-1.png') }}" alt="Event Image 1">
                                                </div>
                                                <div class="event-lower">
                                                    <h6>April 28, 2026 – 10:00 AM PDT</h6>
                                                    <p class="location"><i class="fa-solid fa-location-dot"></i> Los Angeles</p>
                                                    <p class="content">Explore conventions, workshops, and artist meetups near you</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="event-box">
                                            <a href="event-details.php">
                                                <div class="event-img">
                                                    <img src="{{ asset('img/event-img-2.png') }}" alt="Event Image 2">
                                                </div>
                                                <div class="event-lower">
                                                    <h6>April 28, 2026 – 10:00 AM PDT</h6>
                                                    <p class="location"><i class="fa-solid fa-location-dot"></i> Los Angeles</p>
                                                    <p class="content">Explore conventions, workshops, and artist meetups near you</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="event-box">
                                            <a href="event-details.php">
                                                <div class="event-img">
                                                    <img src="{{ asset('img/event-img-3.png') }}" alt="Event Image 3">
                                                </div>
                                                <div class="event-lower">
                                                    <h6>April 28, 2026 – 10:00 AM PDT</h6>
                                                    <p class="location"><i class="fa-solid fa-location-dot"></i> Los Angeles</p>
                                                    <p class="content">Explore conventions, workshops, and artist meetups near you</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="event-box">
                                            <a href="event-details.php">
                                                <div class="event-img">
                                                    <img src="{{ asset('img/event-img-1.png') }}" alt="Event Image 1">
                                                </div>
                                                <div class="event-lower">
                                                    <h6>April 28, 2026 – 10:00 AM PDT</h6>
                                                    <p class="location"><i class="fa-solid fa-location-dot"></i> Los Angeles</p>
                                                    <p class="content">Explore conventions, workshops, and artist meetups near you</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="event-box">
                                            <a href="event-details.php">
                                                <div class="event-img">
                                                    <img src="{{ asset('img/event-img-2.png') }}" alt="Event Image 2">
                                                </div>
                                                <div class="event-lower">
                                                    <h6>April 28, 2026 – 10:00 AM PDT</h6>
                                                    <p class="location"><i class="fa-solid fa-location-dot"></i> Los Angeles</p>
                                                    <p class="content">Explore conventions, workshops, and artist meetups near you</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="event-box">
                                            <a href="event-details.php">
                                                <div class="event-img">
                                                    <img src="{{ asset('img/event-img-3.png') }}" alt="Event Image 3">
                                                </div>
                                                <div class="event-lower">
                                                    <h6>April 28, 2026 – 10:00 AM PDT</h6>
                                                    <p class="location"><i class="fa-solid fa-location-dot"></i> Los Angeles</p>
                                                    <p class="content">Explore conventions, workshops, and artist meetups near you</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center mt-5 testimonials-button justify-content-center">
                                        <a href="{{ route('events') }}" class="btn btn-gradient">VIEW ALL EVENTS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials d-none">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="section-heading section-white">
                        <h6>TESTIMONIALS</h6>
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
                        <div class="testimonial-box-wrapper">
                            <div class="testimonial-box">
                                <p>Tattoosarus completely transformed how I showcase my work. The gallery feature is stunning, and the ability to promote events helped me connect with more clients than ever. Love this platform Tattoosarus completely transformed how I showcase my work. The gallery feature is stunning, and the ability to promote events helped me connect!.</p>
                                <div class="testimonial-image">
                                    <img src="{{ asset('img/testi-img-1.png') }}" alt="Testimonial Image 1">
                                    <h1>Joel Jensen <span>Los Angeles</span></h1>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-box-wrapper">
                            <div class="testimonial-box">
                                <p>Tattoosarus completely transformed how I showcase my work. The gallery feature is stunning, and the ability to promote events helped me connect with more clients than ever. Love this platform Tattoosarus completely transformed how I showcase my work. The gallery feature is stunning, and the ability to promote events helped me connect!.</p>
                                <div class="testimonial-image">
                                    <img src="{{ asset('img/testi-img-1.png') }}" alt="Testimonial Image 1">
                                    <h1>Joel Jensen <span>Los Angeles</span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection