@extends('layouts.app')
@section('title', 'FAQs - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>FAQS</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="faqs">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="section-heading text-center">
                    <h6>FAQ</h6>
                    <h2>Frequently Asked <span class="gold-line">Questions</span></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="faqs-wrapper">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is Tattoosaurus?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <p>Tattoosaurus is an online platform that connects tattoo artists with clients. Artists can showcase their portfolios, promote their flash art, and manage bookings, while clients can discover tattoo artists, find inspiration, and easily book appointments.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How do I showcase my top tattoos?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Once you create your artist profile, you can upload your best tattoos and highlight your favorite pieces. These tattoos will appear prominently in your profile, making them easy for clients to find.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Can I customize my profile?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Yes! You can personalize your profile to reflect your artistic style and brand. Add details about your tattoo specialties, your working hours, and more to help clients find the perfect match.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How do I book a tattoo artist?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Simply browse through the artist profiles, view their portfolios, and book an appointment directly through the platform. It’s quick, easy, and secure.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                How do I search for tattoo artists?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Tattoosaurus allows you to search for tattoo artists by style, location, and availability. Use the search feature to find the best artists near you or who specialize in the style you're looking for.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection