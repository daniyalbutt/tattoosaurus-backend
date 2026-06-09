<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid p-0">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('img/logo.png') }}" alt="">
                            <span>TATTOOSAURUS</span>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto mb-lg-0 mt-0">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('tattoo.gallery') }}">TATTOO GALLERY</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('flash.gallery') }}">FLASH TATTOOS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('artist.search') }}">ARTIST SEARCH</a>
                                </li>
                            </ul>
                            <div class="d-flex top-right-nav">
                                <a href="#" class="nav-toggle-button">
                                    <img src="{{ asset('img/toggle-button.png') }}" alt="">
                                </a>
                                <div class="dropdown">
                                    <a href="#" class="user-button dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @auth
                                            <img src="{{ auth()->user()->avatar_url }}" alt="" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                                        @else
                                            <img src="{{ asset('img/user-button.png') }}" alt="">
                                        @endauth
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        @auth
                                            @php
                                                $portalUrl = auth()->user()->hasRole('artist')
                                                    ? route('artist.dashboard')
                                                    : (auth()->user()->hasRole('admin')
                                                        ? route('admin.dashboard')
                                                        : route('customer.dashboard'));
                                            @endphp
                                            <li><a class="dropdown-item" href="{{ $portalUrl }}">GO TO PORTAL</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">LOGOUT</button>
                                                </form>
                                            </li>
                                        @else
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">LOGIN</a></li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>