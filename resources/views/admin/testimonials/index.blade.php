@extends('admin.layouts.app')
@section('title', 'Testimonials')

@section('content')
<div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold mb-0">Testimonials</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Testimonials</li>
        </ol>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                <h4 class="header-title">Testimonials List</h4>
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus me-1"></i> Add Testimonial
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-3" style="width: 50px;">#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Message</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td>
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}"
                                             class="avatar-sm rounded-circle" alt="{{ $testimonial->name }}"
                                             style="width:40px;height:40px;object-fit:cover;">
                                    @else
                                        <span class="avatar avatar-sm d-inline-flex">
                                            <span class="avatar-title bg-warning rounded-circle fw-bold">
                                                {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                            </span>
                                        </span>
                                    @endif
                                </td>
                                <td class="fw-medium">{{ $testimonial->name }}</td>
                                <td>{{ $testimonial->location ?? '—' }}</td>
                                <td style="max-width:300px;">
                                    <span class="text-muted" style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:280px;">
                                        {{ $testimonial->message }}
                                    </span>
                                </td>
                                <td>{{ $testimonial->sort_order }}</td>
                                <td>
                                    @if($testimonial->is_active)
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="pe-3">
                                    <div class="hstack gap-1 justify-content-end">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                           class="btn btn-soft-primary btn-icon btn-sm rounded-circle" title="Edit">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                              onsubmit="return confirm('Delete this testimonial?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-soft-danger btn-icon btn-sm rounded-circle" title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No testimonials found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection