@extends('customer.layouts.app')
@section('title', 'My Dashboard')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Welcome, {{ auth()->user()->name }}</h2>
    </div>
</div>

{{-- My Requests --}}
<div class="row">
    <div class="col-md-12">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>My Tattoo Requests</h6>
            </div>
            <div class="ms-panel-body">
                @forelse($requests as $req)
                    <div class="d-flex align-items-center justify-content-between border-bottom py-2 flex-wrap">
                        <div class="d-flex align-items-center" style="gap:12px;">
                            <img src="{{ $req->artist->artistProfile?->avatar
                                        ? asset('storage/'.$req->artist->artistProfile->avatar)
                                        : asset('portal/img/people-5.jpg') }}"
                                 style="width:42px;height:42px;border-radius:50%;object-fit:cover;" alt="">
                            <div>
                                <strong>{{ $req->artist->name }}</strong><br>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($req->idea, 50) ?: 'Tattoo request' }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $req->status === 'pending' ? 'warning' : ($req->status === 'accepted' ? 'success' : 'secondary') }}">
                                {{ ucfirst($req->status) }}
                            </span>
                            <br><small class="text-muted">{{ $req->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">You haven't sent any tattoo requests yet.
                        <a href="{{ route('home') }}">Browse artists</a> to get started.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- My Chats --}}
<div class="row">
    <div class="col-md-12">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>My Conversations</h6>
            </div>
            <div class="ms-panel-body">
                @forelse($conversations as $conv)
                    <a href="{{ route('chat.show', $conv) }}"
                       class="d-flex align-items-center justify-content-between border-bottom py-2 text-dark text-decoration-none">
                        <div class="d-flex align-items-center" style="gap:12px;">
                            <img src="{{ $conv->artist->artistProfile?->avatar
                                        ? asset('storage/'.$conv->artist->artistProfile->avatar)
                                        : asset('portal/img/people-5.jpg') }}"
                                 style="width:42px;height:42px;border-radius:50%;object-fit:cover;" alt="">
                            <strong>{{ $conv->artist->name }}</strong>
                        </div>
                        <i class="flaticon-chat"></i>
                    </a>
                @empty
                    <p class="text-muted mb-0">No conversations yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection