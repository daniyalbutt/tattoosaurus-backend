@extends('artist.layouts.app')
@section('title', 'Requests Received')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Requests Received</h2>
    </div>
</div>

<div class="row">
    {{-- LEFT: conversation list --}}
    <div class="col-xl-4 col-md-12">
        <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-body py-3 px-0">
                <div class="ms-chat-container">
                    <div class="ms-chat-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active show fade in">
                                <ul class="ms-scrollable ps">
                                    @forelse($conversations as $conv)
                                        @php
                                            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($conv->customer->name) . '&size=80';
                                            $lastMsg = $conv->messages->last();
                                            $isActive = $active && $active->id === $conv->id;
                                        @endphp
                                        <li class="ms-chat-user-container ms-open-chat ms-deletable p-3 media clearfix {{ $isActive ? 'selected' : '' }}"
                                            onclick="window.location='{{ route('artist.requests.show', $conv) }}'"
                                            style="cursor:pointer;">
                                            <div class="ms-chat-status ms-status-online ms-chat-img mr-3 align-self-center">
                                                <img src="{{ $avatar }}" class="ms-img-round" alt="people">
                                            </div>
                                            <div class="media-body ms-chat-user-info mt-1">
                                                <h6>{{ $conv->customer->name }}</h6>
                                                <span class="ms-chat-time">{{ $conv->updated_at->diffForHumans() }}</span>
                                                <p>{{ $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->body, 40) : 'New request' }}</p>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="p-3 text-center text-muted">No requests yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: active conversation --}}
    <div class="col-xl-8 col-md-12">
        @if($active)
            @php
                $customerAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($active->customer->name) . '&size=80';
            @endphp
            <div class="ms-panel ms-chat-conversations ms-widget">
                <div class="ms-panel-header">
                    <div class="ms-chat-header justify-content-between">
                        <div class="ms-chat-user-container media clearfix">
                            <div class="ms-chat-status ms-status-online ms-chat-img mr-3 align-self-center">
                                <img src="{{ $customerAvatar }}" class="ms-img-round" alt="people">
                            </div>
                            <div class="media-body ms-chat-user-info mt-1">
                                <h6>{{ $active->customer->name }}</h6>
                                <span class="text-disabled fs-12">Customer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ms-panel-body ms-scrollable" id="chatBody">
                    {{-- Brief received card --}}
                    @if($active->request)
                        <div class="ms-chat-bubble ms-chat-message ms-chat-incoming media clearfix brief-sent">
                            <div class="media-body">
                                <div class="ms-chat-text">
                                    <h6>New request received</h6>
                                    <a href="#" data-toggle="modal" data-target="#briefModal">View brief details</a>
                                </div>
                                <p class="ms-chat-time">{{ $active->request->created_at->format('g:i a') }}</p>
                            </div>
                        </div>
                        <div class="ms-chat-bubble ms-chat-message media clearfix ms-chat-incoming">
                            <div class="media-body">
                                <div class="ms-chat-text">
                                    <p>{{ $active->customer->name }} sent you a tattoo request. Review the brief and reply to start the conversation.</p>
                                </div>
                                <p class="ms-chat-time">{{ $active->request->created_at->format('g:i a') }}</p>
                            </div>
                        </div>
                    @endif

                    @php
                        $myAvatar = auth()->user()->artistProfile?->avatar
                            ? asset('storage/'.auth()->user()->artistProfile->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=80';
                    @endphp

                    @foreach($active->messages as $msg)
                        @php $mine = $msg->sender_id === auth()->id(); @endphp
                        <div class="ms-chat-bubble ms-chat-message media clearfix {{ $mine ? 'ms-chat-outgoing' : 'ms-chat-incoming' }}">
                            <div class="ms-chat-status ms-status-online ms-chat-img">
                                <img src="{{ $mine ? $myAvatar : $customerAvatar }}" class="ms-img-round" alt="">
                            </div>
                            <div class="media-body">
                                <div class="ms-chat-text"><p>{{ $msg->body }}</p></div>
                                <p class="ms-chat-time">{{ $msg->created_at->format('g:i a') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="ms-panel-footer pt-0">
                    <form method="POST" action="{{ route('artist.requests.message', $active) }}">
                        @csrf
                        <div class="ms-chat-textbox">
                            <ul class="ms-list-flex mb-0">
                                <li class="ms-chat-input">
                                    <input type="text" name="body" placeholder="Type a message" required autocomplete="off">
                                </li>
                                <ul class="ms-chat-text-controls ms-list-flex">
                                    <li><button type="submit" class="btn btn-link p-0"><i class="material-icons">send</i></button></li>
                                </ul>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Brief modal --}}
            @if($active->request)
                @php $r = $active->request; @endphp
                <div class="modal fade" id="briefModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title has-icon ms-icon-round">
                                    <i class="flaticon-list bg-primary text-white"></i> Brief</h3>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body brief-modal">
                                <ul>
                                    @if(!empty($r->reference_images))
                                        <li><h6>Reference images</h6>
                                            @foreach($r->reference_images as $img)
                                                <img src="{{ asset('storage/'.$img) }}" style="width:80px;height:80px;object-fit:cover;margin:3px;border-radius:6px;" alt="">
                                            @endforeach
                                        </li>
                                    @endif
                                    <li><h6>Description</h6><p>{{ $r->idea ?: '—' }}</p></li>
                                    <li><h6>Placement</h6><p>{{ $r->placement ?: '—' }}</p></li>
                                    <li><h6>Size</h6><p>{{ $r->size ?: '—' }}</p></li>
                                    <li><h6>Available days</h6><p>{{ !empty($r->days) ? implode(', ', $r->days) : '—' }}</p></li>
                                    <li><h6>Time</h6><p>{{ $r->time_preference ?: '—' }}</p></li>
                                    <li><h6>Budget</h6><p>{{ $r->budget ?: '—' }}</p></li>
                                    <li><h6>Pronouns</h6><p>{{ $r->pronouns ?: '—' }}</p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @else
            <div class="ms-panel">
                <div class="ms-panel-body text-center py-5">
                    <h5 class="text-muted mb-3">No tattoo requests yet.</h5>
                    <p class="text-muted">When a customer sends you a request, it'll appear here.</p>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const body = document.getElementById('chatBody');
    if (body) body.scrollTop = body.scrollHeight;
</script>
@endpush

@endsection