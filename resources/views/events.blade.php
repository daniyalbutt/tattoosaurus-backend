@extends('layouts.app')
@section('title', 'Events - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>Events</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="events">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-heading">
                    <h6>Events</h6>
                    <h2>Experience What's New in the <span class="gold-line">World</span> of Tattoos</h2>
                    <p>Stay connected with the latest happenings in the tattoo community through our event listings. Tattoosaurus brings you an up-to-date guide to all major tattoo events, expos, conventions, and workshops, allowing you to discover new trends, meet renowned artists, and immerse yourself in the vibrant tattoo culture.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="filter-wrapper">
                    <a href="" class="btn btn-event-filter"><i class="fa-solid fa-filter"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="event-box">
                    <div class="event-img">
                        <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/img/event-1.png" alt="">
                    </div>
                    <div class="event-lower">
                        <p class="location">Los Angeles</p>
                        <h4>Girl Tattoo Artist</h4>
                        <p class="content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been </p>
                        <span class="date">Feb - 2025 - Artist Name</span>
                        <a href="event-details.php" class="btn btn-black-yellow btn-border-black" tabindex="0">More Details</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="event-box">
                    <div class="event-img">
                        <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/img/event-2.png" alt="">
                    </div>
                    <div class="event-lower">
                        <p class="location">Los Angeles</p>
                        <h4>New Shop</h4>
                        <p class="content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been </p>
                        <span class="date">Feb - 2025 - Artist Name</span>
                        <a href="event-details.php" class="btn btn-black-yellow btn-border-black" tabindex="0">More Details</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="event-box">
                    <div class="event-img">
                        <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/img/event-3.png" alt="">
                    </div>
                    <div class="event-lower">
                        <p class="location">Los Angeles</p>
                        <h4>Private Facility</h4>
                        <p class="content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been </p>
                        <span class="date">Feb - 2025 - Artist Name</span>
                        <a href="event-details.php" class="btn btn-black-yellow btn-border-black" tabindex="0">More Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection