@extends('admin.layouts.app')
@section('title', 'Tattoo Artists List')

@section('content')
<div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold mb-0">Tattoo Artists</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Tattoo Artists</li>
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
                <h4 class="header-title">Tattoo Artists List</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-3" style="width: 50px;">#</th>
                            <th>Artist</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-center" style="width: 140px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($artists as $artist)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td>
                                    @if($artist->artistProfile?->avatar)
                                        <img src="{{ asset('storage/'.$artist->artistProfile->avatar) }}"
                                             class="avatar-sm rounded-circle me-2" alt="">
                                    @else
                                        <span class="avatar avatar-sm d-inline-flex me-2">
                                            <span class="avatar-title bg-warning rounded-circle fw-bold">
                                                {{ strtoupper(substr($artist->name, 0, 1)) }}
                                            </span>
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.artists.show', $artist) }}" class="text-dark fw-medium">
                                        {{ $artist->name }}
                                    </a>
                                </td>
                                <td>{{ $artist->username }}</td>
                                <td>{{ $artist->phone ?? '—' }}</td>
                                <td>{{ $artist->email }}</td>
                                <td>
                                    @php
                                        $p = $artist->artistProfile;
                                        $parts = array_filter([
                                            $p?->city?->name,
                                            $p?->state?->name,
                                            $p?->country?->name,
                                        ]);
                                    @endphp
                                    {{ $parts ? implode(', ', $parts) : '—' }}
                                </td>
                                <td>
                                    @php
                                        $badge = match($artist->status) {
                                            'active'   => 'success',
                                            'pending'  => 'warning',
                                            'rejected' => 'danger',
                                            default    => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}-subtle text-{{ $badge }}">
                                        {{ ucfirst($artist->status) }}
                                    </span>

                                    @if($artist->artistProfile?->is_top)
                                        <span class="badge bg-warning-subtle text-warning"><i class="ti ti-star-filled"></i> Top</span>
                                    @endif
                                    @if($artist->artistProfile?->is_featured)
                                        <span class="badge bg-info-subtle text-info"><i class="ti ti-award"></i> Featured</span>
                                    @endif
                                </td>
                                <td>{{ $artist->created_at->format('d M Y') }}</td>
                                <td class="pe-3">
                                    <div class="hstack gap-1 justify-content-end">
                                        <a href="{{ route('admin.artists.show', $artist) }}"
                                        class="btn btn-soft-primary btn-icon btn-sm rounded-circle" title="View">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        @if($artist->status !== 'active')
                                            <form method="POST" action="{{ route('admin.artists.approve', $artist) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-soft-success btn-icon btn-sm rounded-circle" title="Approve">
                                                    <i class="ti ti-check fs-16"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($artist->status !== 'rejected')
                                            <form method="POST" action="{{ route('admin.artists.reject', $artist) }}"
                                                onsubmit="return confirm('Reject this artist?');">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-soft-danger btn-icon btn-sm rounded-circle" title="Reject">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Top + Featured toggles ONLY for active artists --}}
                                        @if($artist->status === 'active')
                                            {{-- Top Tattoo Artist --}}
                                            <form method="POST" action="{{ route('admin.artists.toggleTop', $artist) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-icon btn-sm rounded-circle {{ $artist->artistProfile?->is_top ? 'btn-warning' : 'btn-soft-warning' }}"
                                                        title="{{ $artist->artistProfile?->is_top ? 'Remove from Top Artists' : 'Mark as Top Artist' }}">
                                                    <i class="ti ti-star{{ $artist->artistProfile?->is_top ? '-filled' : '' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Featured --}}
                                            <form method="POST" action="{{ route('admin.artists.toggleFeatured', $artist) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-icon btn-sm rounded-circle {{ $artist->artistProfile?->is_featured ? 'btn-info' : 'btn-soft-info' }}"
                                                        title="{{ $artist->artistProfile?->is_featured ? 'Remove Featured' : 'Mark as Featured' }}">
                                                    <i class="ti ti-award"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">No artists found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    {{ $artists->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection