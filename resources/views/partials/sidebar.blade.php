<div class="sidebar">
    <div class="sidebar-close">
        <a href="#"><i class="fa-solid fa-xmark"></i></a>
    </div>
    <div class="sidebar-button">
        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</a>
        <a href="#" id="register-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">SIGN UP</a>
    </div>
    <div class="sidebar-list">
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('tattoo.gallery') }}">Tattoo Gallery</a></li>
            <li><a href="{{ route('flash.gallery') }}">Flash Gallery</a></li>
            <li><a href="{{ route('artist.search') }}">Artist Search</a></li>
            <li><a href="#">Book Appointment</a></li>
            <li><a href="{{ route('events') }}">Events</a></li>
            <li><a href="#">Create a Profile</a></li>
            <li><a href="{{ route('faqs') }}">FAQ’s</a></li>
        </ul>
        <div class="line"></div>
        <h4>For Artists</h4>
        <ul>
            <li><a href="#">Manage Appointments</a></li>
        </ul>
        <div class="line"></div>
        <h4>For Members</h4>
        <ul>
            <li><a href="#">Search Artists</a></li>
            <li><a href="{{ route('flash.gallery') }}">Flash Gallery</a></li>
            <li><a href="{{ route('events') }}">Events</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
    </div>
</div>