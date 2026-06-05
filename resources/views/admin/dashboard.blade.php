@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 text-center">
        <div class="col">
            <div class="card"><div class="card-body">
                <h5 class="text-muted fs-13 text-uppercase">Total Artists</h5>
                <h3 class="mb-0 fw-bold">{{ $totalArtists ?? 0 }}</h3>
            </div></div>
        </div>
        <div class="col">
            <div class="card"><div class="card-body">
                <h5 class="text-muted fs-13 text-uppercase">Pending Review</h5>
                <h3 class="mb-0 fw-bold text-warning">{{ $pendingCount ?? 0 }}</h3>
            </div></div>
        </div>
        <div class="col">
            <div class="card"><div class="card-body">
                <h5 class="text-muted fs-13 text-uppercase">Active Artists</h5>
                <h3 class="mb-0 fw-bold text-success">{{ $activeArtists ?? 0 }}</h3>
            </div></div>
        </div>
        <div class="col">
            <div class="card"><div class="card-body">
                <h5 class="text-muted fs-13 text-uppercase">Total Customers</h5>
                <h3 class="mb-0 fw-bold">{{ $totalCustomers ?? 0 }}</h3>
            </div></div>
        </div>
    </div>
@endsection