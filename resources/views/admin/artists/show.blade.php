@extends('admin.layouts.app')
@section('title', $user->name . ' — Artist Profile')

@section('content')
@php
    $profile  = $profile ?? null;
    $avatar   = $profile?->avatar
                    ? asset('storage/' . $profile->avatar)
                    : asset('portal/img/people-5.jpg');
    $portfolio = $profile?->portfolio_images ?? [];
    $faqs      = $profile?->faqs ?? [];
    $styles    = $profile?->styles ?? [];
    $links     = $profile?->social_links ?? [];
@endphp
<div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold mb-0">{{ $user->name }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.artists.index') }}">Tattoo Artists</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
    </div>
</div>

<div class="row">

    {{-- ── LEFT COLUMN ──────────────────────────────────────────────────── --}}
    <div class="col-xl-4 col-lg-12">

        {{-- Profile Card --}}
        <div class="card">
            <div class="card-body">

                {{-- Cover + Avatar --}}
                <div class="dr-profile-bg rounded-top position-relative mx-n3 mt-n3"
                     style="height:100px;background:#1a1a1a;">
                    <img src="{{ $avatar }}"
                         alt="{{ $user->name }}"
                         class="border border-light border-3 rounded-circle position-absolute top-100 start-50 translate-middle"
                         height="100" width="100"
                         style="object-fit:cover;">
                </div>

                {{-- Name + username --}}
                <div class="mt-4 mb-2 pt-3 text-center">
                    <p class="mb-1 fs-18 fw-semibold text-dark">{{ $user->name }}</p>
                    <p class="mb-0 fw-medium text-muted">&#64;{{ $user->username }}</p>
                </div>

                {{-- Completion badge --}}
                @if($profile)
                    <div class="text-center mb-3">
                        <span class="badge {{ $profile->completion >= 80 ? 'bg-success' : ($profile->completion >= 50 ? 'bg-warning' : 'bg-danger') }}">
                            Profile {{ $profile->completion }}% complete
                        </span>
                    </div>
                @endif

                {{-- Bio --}}
                @if($profile?->bio)
                    <h5 class="card-title fw-semibold">About :</h5>
                    <p class="mt-2">{{ $profile->bio }}</p>
                @endif

                {{-- Stats row --}}
                <div class="mt-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="text-muted mb-1">Rate/hr</h6>
                            <p class="fs-15 text-dark fw-semibold mb-0">
                                {{ $profile?->hourly_rate ? '$' . number_format($profile->hourly_rate, 2) : '—' }}
                            </p>
                        </div>
                        <div class="col-4">
                            <h6 class="text-muted mb-1">Availability</h6>
                            <p class="fs-15 text-dark fw-semibold mb-0">
                                {{ $profile?->availability ?: '—' }}
                            </p>
                        </div>
                        <div class="col-4">
                            <h6 class="text-muted mb-1">Response</h6>
                            <p class="fs-15 text-dark fw-semibold mb-0">
                                {{ $profile?->response_time ?: '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tattoo Styles --}}
                @if(!empty($styles))
                    <h5 class="card-title fw-semibold mt-4 mb-2">Tattoo Styles :</h5>
                    @foreach($styles as $style)
                        <span class="badge bg-light text-dark my-1 px-2 py-1 rounded-pill fw-medium fs-12">
                            {{ ucfirst($style) }}
                        </span>
                    @endforeach
                @endif

                {{-- Social Links --}}
                @if(!empty(array_filter($links)))
                    <h5 class="card-title fw-semibold mt-4 mb-2">Social :</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach(['facebook' => 'fa-facebook','twitter' => 'fa-twitter','instagram' => 'fa-instagram','linkedin' => 'fa-linkedin'] as $platform => $icon)
                            @if(!empty($links[$platform]))
                                <a href="{{ $links[$platform] }}" target="_blank"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fab {{ $icon }}"></i> {{ ucfirst($platform) }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- Card Footer --}}
            <div class="card-footer border-top">
                {{-- Top + Featured toggles (active artists only) --}}
                @if($user->status === 'active')
                    <div class="hstack gap-1 mb-2">
                        <form method="POST" action="{{ route('admin.artists.toggleTop', $user) }}" class="w-100">
                            @csrf @method('PATCH')
                            <button class="btn w-100 {{ $profile?->is_top ? 'btn-warning' : 'btn-soft-warning' }}">
                                <i class="ti ti-star{{ $profile?->is_top ? '-filled' : '' }} me-1"></i>
                                {{ $profile?->is_top ? 'Top Artist ✓' : 'Mark as Top Artist' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.artists.toggleFeatured', $user) }}" class="w-100">
                            @csrf @method('PATCH')
                            <button class="btn w-100 {{ $profile?->is_featured ? 'btn-info' : 'btn-soft-info' }}">
                                <i class="ti ti-award me-1"></i>
                                {{ $profile?->is_featured ? 'Featured ✓' : 'Mark as Featured' }}
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Approve / Reject (for non-active artists) --}}
                @if($user->status !== 'active')
                    <div class="hstack gap-1 mb-2">
                        <form method="POST" action="{{ route('admin.artists.approve', $user) }}" class="w-100">
                            @csrf @method('PATCH')
                            <button class="btn btn-success w-100"><i class="ti ti-check me-1"></i> Approve</button>
                        </form>
                        @if($user->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.artists.reject', $user) }}" class="w-100"
                                onsubmit="return confirm('Reject this artist?');">
                                @csrf @method('PATCH')
                                <button class="btn btn-danger w-100"><i class="ti ti-x me-1"></i> Reject</button>
                            </form>
                        @endif
                    </div>
                @endif

                {{-- Email / Back --}}
                <div class="hstack gap-1">
                    <a href="mailto:{{ $user->email }}" class="btn btn-primary w-100">
                        <i class="fa fa-envelope me-1"></i> Email
                    </a>
                    <a href="{{ route('admin.artists.index') }}" class="btn btn-light w-100">
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Personal Info Card --}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Personal Information :</h4>
                <div class="table-responsive border border-dashed rounded px-2 py-1">
                    <table class="table table-borderless m-0">
                        <tbody>
                            <tr>
                                <td><p class="mb-0">Name :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">Username :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">&#64;{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">Email :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">Phone :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">{{ $user->phone ?: '—' }}</td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">Status :</p></td>
                                <td class="px-2 fw-medium fs-14">
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : ($user->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">Country :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">
                                    {{ $profile?->country?->name ?: '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">State :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">
                                    {{ $profile?->state?->name ?: '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">City :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">
                                    {{ $profile?->city?->name ?: '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td><p class="mb-0">Joined :</p></td>
                                <td class="px-2 text-dark fw-medium fs-14">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    {{-- end left col --}}

    {{-- ── RIGHT COLUMN ─────────────────────────────────────────────────── --}}
    <div class="col-xl-8 col-lg-12">

        {{-- Portfolio --}}
        @if(!empty($portfolio))
            <div class="card">
                <div class="card-header border-bottom border-dashed">
                    <h4 class="card-title mb-0">Portfolio ({{ count($portfolio) }} works)</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($portfolio as $item)
                            <div class="col-xl-3 col-md-4 col-6">
                                <a href="{{ asset('storage/' . $item['image']) }}"
                                   data-fancybox="admin-portfolio"
                                   data-caption="{{ $item['description'] ?: '' }}">
                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                         alt="{{ $item['description'] }}"
                                         class="img-fluid rounded"
                                         style="height:150px;width:100%;object-fit:cover;cursor:zoom-in;">
                                </a>
                                @if($item['description'])
                                    <p class="small text-muted mt-1 mb-0">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- FAQs --}}
        @if(!empty($faqs))
            <div class="card">
                <div class="card-header border-bottom border-dashed">
                    <h4 class="card-title mb-0">FAQs</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $i => $faq)
                            @if(!empty($faq['q']))
                                <div class="accordion-item border mb-2 rounded">
                                    <h2 class="accordion-header" id="faq-heading-{{ $i }}">
                                        <button class="accordion-button {{ $i !== 0 ? 'collapsed' : '' }} fw-medium"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#faq-collapse-{{ $i }}"
                                                aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                                            {{ $faq['q'] }}
                                        </button>
                                    </h2>
                                    <div id="faq-collapse-{{ $i }}"
                                         class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                                         data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-muted">
                                            {{ $faq['a'] ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Profile incomplete notice --}}
        @if(!$profile)
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fa fa-user-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">This artist has not completed their profile yet.</h5>
                </div>
            </div>
        @endif

    </div>
    {{-- end right col --}}

</div>

@endsection

@push('scripts')
<script>
$('[data-fancybox="admin-portfolio"]').fancybox({
    buttons: ['zoom', 'slideShow', 'fullScreen', 'download', 'close'],
    loop: true,
    animationEffect: 'zoom',
    transitionEffect: 'slide',
    caption: function () {
        return $(this).data('caption')
            ? `<div class="text-center">${$(this).data('caption')}</div>`
            : '';
    }
});
</script>
@endpush