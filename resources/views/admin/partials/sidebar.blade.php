<div class="sidenav-menu">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="width: 180px;height: auto;"></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo"></span>
        </span>
        <span class="logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo"></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo"></span>
        </span>
    </a>

    <button class="button-sm-hover"><i class="ti ti-circle align-middle"></i></button>
    <button class="button-close-fullsidebar"><i class="ti ti-x align-middle"></i></button>

    <div data-simplebar>
        <ul class="side-nav">
            <li class="side-nav-title">Main</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="side-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item {{ request()->is('admin/artists*') ? 'active' : '' }}">
                <a href="{{ route('admin.artists.index') }}"
                class="side-nav-link {{ request()->routeIs('admin.artists.*') || request()->is('admin/artists*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-brush"></i></span>
                    <span class="menu-text"> Tattoo Artists </span>
                    @isset($pendingCount)
                        @if($pendingCount > 0)
                            <span class="badge bg-danger rounded-pill">{{ $pendingCount }}</span>
                        @endif
                    @endisset
                </a>
            </li>

            <li class="side-nav-title mt-2">Website Changes</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.testimonials.index') }}"
                class="side-nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-quote"></i></span>
                    <span class="menu-text"> Testimonials </span>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>