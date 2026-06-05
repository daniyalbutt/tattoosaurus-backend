@extends('layouts.app')
@section('title', 'Contact - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>Contact Us</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact-wrapper">
    <div class="container contact-container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="section-heading text-center">
                    <h6>Get In touch</h6>
                    <h2>Start Your <span class="gold-line">Tattoo Journey</span> Connect With Us</h2>
                    <p>Whether you’re a tattoo artist looking to join our community, a client searching for the perfect tattoo, or a sponsor interested in partnering with us, Tattoosaurus is here to help. Reach out to us with any questions, feedback, or inquiries, and our team will get back to you as soon as possible.</p>
                </div>
            </div>
        </div>
        <form action="" class="contact-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                        <img src="img/form-icon-1.png" alt="">
                        </span>
                        <input type="text" class="form-control" placeholder="Full Name *">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                        <img src="img/form-icon-2.png" alt="">
                        </span>
                        <input type="email" class="form-control" placeholder="Email ADdress *">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-text">
                        <img src="img/form-icon-4.png" alt="">
                        </span>
                        <select name="" id="" class="form-control">
                            <option value="">Select Your Service</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-text">
                        <img src="img/form-icon-5.png" alt="">
                        </span>
                        <textarea name="" id="" class="form-control" placeholder="Message *"></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn btn-gradient btn-gradient-white">Submit Now</button>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="contact-lower">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li>
                        <img src="{{ asset('img/contact-phone.png') }}" alt="">
                        <h2>
                            Phone Number 
                            <p>+1-800-555-INKS (4657)</p>
                        </h2>
                    </li>
                    <li>
                        <img src="{{ asset('img/contact-email.png') }}" alt="">
                        <h2>
                            Email Address 
                            <p>support@tattoosarus.com</p>
                        </h2>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection