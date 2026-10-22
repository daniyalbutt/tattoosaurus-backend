<div class="sidebar">
    <div class="sidebar-close">
        <a href="#"><i class="fa-solid fa-xmark"></i></a>
    </div>

    <div class="sidebar-button">
        @guest
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</a>
            <a href="#" id="register-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">SIGN UP</a>
        @else
            @php
                $portalUrl = auth()->user()->hasRole('artist')
                    ? route('artist.dashboard')
                    : (auth()->user()->hasRole('admin')
                        ? route('admin.dashboard')
                        : route('customer.dashboard'));
            @endphp
            <a href="{{ $portalUrl }}">DASHBOARD</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout').submit();">LOGOUT</a>
            <form id="sidebar-logout" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
        @endguest
    </div>

    <div class="sidebar-list">
        {{-- Public links — everyone sees these --}}
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('tattoo.gallery') }}">Tattoo Gallery</a></li>
            <li><a href="{{ route('flash.gallery') }}">Flash Gallery</a></li>
            <li><a href="{{ route('artist.search') }}">Artist Search</a></li>
            <li><a href="{{ route('events') }}">Events</a></li>
            <li><a href="{{ route('faqs') }}">FAQ’s</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>

        {{-- Role-specific links — only after login --}}
        @role('artist')
            <div class="line"></div>
            <ul>
                <li><a href="{{ route('artist.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('artist.requests') }}">Manage Appointments</a></li>
                <li><a href="{{ route('artist.requests.approved') }}">Approved Requests</a></li>
                <li><a href="{{ route('artist.availability.edit') }}">Availability</a></li>
                <li><a href="{{ route('artist.payouts') }}">Payouts</a></li>
                <li><a href="{{ route('artist.profile.edit') }}">Update Profile</a></li>
            </ul>
        @endrole

        @role('customer')
            <div class="line"></div>
            <ul>
                <li><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('customer.requests') }}">My Requests</a></li>
                <li><a href="{{ route('customer.favourites') }}">Favourites</a></li>
                <li><a href="{{ route('customer.board') }}">My Board</a></li>
            </ul>
        @endrole

        @role('admin')
            <div class="line"></div>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
            </ul>
        @endrole
    </div>
</div>