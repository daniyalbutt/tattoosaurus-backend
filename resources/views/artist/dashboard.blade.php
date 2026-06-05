@extends('artist.layouts.app')
@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="title">Welcome, {{ auth()->user()->name }}</h2>
        </div>
    </div>

    @php $completion = $profile?->completion ?? 0; @endphp

    @if($completion < 100)
        <div class="discount-box mb-4">
            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <p>Complete Your Profile</p>
                        <h4>You've completed <strong>{{ $completion }}%</strong></h4>
                        <h6 class="mt-2">Complete your profile to get discovered by clients</h6>
                    </div>
                    <div class="col-md-4">
                        <div class="discount-img">
                            <a href="{{ route('artist.profile.edit') }}" class="btn btn-white mt-2 mt-md-0">
                                Update Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="progress mt-3" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $completion }}%;"
                        aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-body">
                        <h4 class="mb-0">Your profile is 100% complete 🎉</h4>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Quick stat cards (placeholder counts until bookings exist) --}}
    <div class="row">
        <div class="col-md-4">
            <div class="ms-panel">
                <div class="ms-panel-body text-center">
                    <h3 class="mb-1">0</h3>
                    <p class="mb-0">New Requests</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ms-panel">
                <div class="ms-panel-body text-center">
                    <h3 class="mb-1">0</h3>
                    <p class="mb-0">Upcoming Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ms-panel">
                <div class="ms-panel-body text-center">
                    <h3 class="mb-1">0</h3>
                    <p class="mb-0">Completed</p>
                </div>
            </div>
        </div>
    </div>

@endsection