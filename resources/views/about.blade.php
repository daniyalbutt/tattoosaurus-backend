@extends('layouts.app')
@section('title', 'About - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>About US</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>AbOUt</h6>
                    <h2>Your Top Tattoos Deserve The <span class="gold-line">Spotlight</span></h2>
                    <p>At Tattoosaurus, we believe that every tattoo tells a unique story and deserves to be shown in the best possible light. That’s why we’ve created a platform where tattoo artists can showcase their top work and gain the recognition they deserve, free from the noise of social media algorithms. We provide tattoo enthusiasts with a curated space to discover the best artists and designs, making it easier for both artists and clients to connect.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="{{ asset('img/about-img-1.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="choose">
    <div class="choose-img">
        <img src="{{ asset('img/choose-img-1.png') }}" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="section-heading section-heading-white">
                    <h6>Why Choose</h6>
                    <h2>Why Choose <br> <span class="gold-line">Tattoosaurus</span></h2>
                    <p>Tattoosaurus is not just another tattoo platform; it’s a community where artists and clients can thrive together. We understand the need for artists to have a space where they can control their presence, manage bookings, and interact with clients without the pressure of social media. For clients, it’s about finding the right artist and style in an easy-to-navigate environment.</p>
                    <ul class="list">
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Dedicated to Tattoo Artists </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Easy Booking System </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Verified Artists </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Secure Payments </p>
                        </li>
                    </ul>
                    <ul class="list-box">
                        <li>
                            <p><img src="{{ asset('img/award-img.png') }}" alt=""> Verified Tattoo Artist Directory</p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/award-img.png') }}" alt=""> Secure Payment Gateway Certification</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="goal">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>Our Goal</h6>
                    <h2>Creating Bold Art That <span class="gold-line">Speaks</span> Without Words</h2>
                    <p>At Tattoosaurus, we aim to create a space where tattoo artists and enthusiasts can build lasting relationships through the art they love. Our goal is to empower artists to showcase their work without the stress of traditional social media platforms and to give clients the tools to discover unique, quality tattoos.</p>
                    <ul class="list">
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Showcase your best work without algorithm interference </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Connect with clients who appreciate your craft </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Streamline your booking process </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Get paid securely with flexible payment options </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Discover tattoo events and conventions </p>
                        </li>
                        <li>
                            <p><img src="{{ asset('img/checked.png') }}" alt=""> Build a reputation within a community-focused platform </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="goal-img">
                    <img src="{{ asset('img/goal-img.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection