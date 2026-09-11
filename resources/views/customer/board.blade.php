@extends('customer.layouts.app')
@section('title', 'My Board')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="title border-title">My Board</h2>
    </div>
</div>
<div class="board-gallery">
    <div class="row">
        @forelse($items as $item)
            @php
                $artistAvatar = $item->artist->artistProfile?->avatar
                    ? asset('storage/'.$item->artist->artistProfile->avatar)
                    : 'https://ui-avatars.com/api/?name='.urlencode($item->artist->name).'&size=60';
            @endphp
            <div class="col-md-3">
                <a href="{{ route('artist.public.show', $item->artist->artistProfile) }}" class="board-gallery-img">
                    <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->artist->name }}">
                    <div class="board-artist-name">
                        <img src="{{ $artistAvatar }}" alt="">
                        <div>
                            <h2>{{ $item->artist->name }}</h2>
                            <span>{{ $item->artist->artistProfile?->shop_name ?: '—' }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-md-12">
                <p>You haven't saved any images to your board yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection