@extends('artist.layouts.app')
@section('title', 'Notifications')

@section('content')

<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2 class="title mb-0">Notifications</h2>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('artist.notifications.readAll') }}" class="m-0">
                @csrf
                <button class="btn btn-light btn-sm">Mark all as read</button>
            </form>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="row mt-3">
        <div class="col-md-12"><div class="alert alert-success">{{ session('success') }}</div></div>
    </div>
@endif

<div class="row mt-3">
    <div class="col-md-12">
        <div class="ms-panel">
            <div class="ms-panel-body p-0">
                @forelse($notifications as $n)
                    @php
                        $d = $n->data;
                        $isUnread = is_null($n->read_at);
                    @endphp
                    <div class="notif-row d-flex align-items-start p-3 border-bottom {{ $isUnread ? 'notif-row-unread' : '' }}">
                        <span class="notif-row-icon mr-3">
                            @if(!empty($d['image']))
                                <img src="{{ $d['image'] }}" alt="">
                            @else
                                <i class="material-icons">{{ $d['icon'] ?? 'notifications' }}</i>
                            @endif
                        </span>

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1">
                                    {{ $d['title'] ?? 'Notification' }}
                                    @if($isUnread)<span class="badge badge-primary ml-1">New</span>@endif
                                </h6>
                                <span class="text-muted fs-12 ml-2">{{ $n->created_at->diffForHumans() }}</span>
                            </div>
                            @if(!empty($d['body']))
                                <p class="mb-2 text-muted fs-13">{{ $d['body'] }}</p>
                            @endif

                            <div class="d-flex" style="gap:.5rem;">
                                @if(!empty($d['url']))
                                    <form method="POST" action="{{ route('artist.notifications.read', $n->id) }}" class="m-0">
                                        @csrf
                                        <button class="btn btn-black btn-sm">View</button>
                                    </form>
                                @elseif($isUnread)
                                    <form method="POST" action="{{ route('artist.notifications.read', $n->id) }}" class="m-0">
                                        @csrf
                                        <button class="btn btn-light btn-sm">Mark read</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('artist.notifications.destroy', $n->id) }}" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mt-0">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="material-icons" style="font-size:40px;opacity:.3;">notifications_none</i>
                        <p class="mb-0 mt-2">You have no notifications yet.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="ms-panel-body">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .notif-row-unread { background: #f5f3ff; }
    .notif-row:last-child { border-bottom: 0 !important; }
    .notif-row-icon {
        flex-shrink: 0; width: 44px; height: 44px; border-radius: 50%;
        background: #efeefe; display: inline-flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .notif-row-icon img { width: 100%; height: 100%; object-fit: cover; }
    .notif-row-icon .material-icons { font-size: 22px; color: #6a5acd; }
</style>
@endpush