@extends('admin.layouts.app')
@section('title', 'Add Testimonial')

@section('content')
<div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold mb-0">Add Testimonial</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="header-title">Testimonial Details</h4>
            </div>
            <div class="card-body">
                @include('admin.testimonials._form', [
                    'testimonial' => null,
                    'action'      => route('admin.testimonials.store'),
                    'method'      => 'POST',
                ])
            </div>
        </div>
    </div>
</div>
@endsection