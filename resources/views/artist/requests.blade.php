@extends('artist.layouts.app')
@section('title', 'Requests Received')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Requests Received</h2>
    </div>
</div>

@if(session('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    </div>
@endif

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
                                            $preview = $lastMsg
                                                ? ($lastMsg->body ? \Illuminate\Support\Str::limit($lastMsg->body, 40) : '📎 Attachment')
                                                : 'New request';
                                            [$statusLabel, $statusColor] = $conv->request
                                                ? $conv->request->status_label
                                                : ['Pending', 'warning'];
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
                                                <p class="mb-1">{{ $preview }}</p>
                                                <span class="badge bg-{{ $statusColor }}" style="color: white;font-weight: 200;padding: 6px 8px;font-size: 11px;">{{ $statusLabel }}</span>
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
                $myAvatar = auth()->user()->artistProfile?->avatar
                    ? asset('storage/'.auth()->user()->artistProfile->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=80';
            @endphp

            {{-- ── REQUEST APPROVAL ──────────────────────────────── --}}
            @if($active->request)
                @php
                    $req = $active->request;
                    $platformFee = config('services.stripe.platform_fee', 10);
                    $onboarded = auth()->user()->artistProfile?->stripe_onboarded;
                    $status = $req->status ?? 'pending';
                @endphp

                @if($status === 'pending')
                    <div class="ms-panel mb-3">
                        <div class="ms-panel-body">
                            <h5 class="mb-1">Review this request</h5>
                            <p class="text-muted fs-13 mb-3">
                                Approve to move forward and set pricing, or decline if you can't take it.
                            </p>
                            <div class="d-flex flex-wrap" style="gap:.5rem;">
                                <form method="POST" action="{{ route('artist.requests.approve', $active) }}">
                                    @csrf
                                    <button class="btn btn-success">
                                        <i class="material-icons align-middle mr-1" style="font-size:16px;">check</i>
                                        Approve Request
                                    </button>
                                </form>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#declineModal">
                                    <i class="material-icons align-middle mr-1" style="font-size:16px;">close</i>
                                    Decline
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($status === 'declined')
                    <div class="ms-panel mb-3">
                        <div class="ms-panel-body">
                            <span class="badge bg-danger mb-2">Declined</span>
                            <p class="text-muted mb-0 fs-13">You declined this request.</p>
                        </div>
                    </div>
                @endif
            @endif

            {{-- ── PRICING & DEPOSIT ──────────────────────────────── --}}
            @if($active->request && ($req->status ?? 'pending') === 'approved')
                <div class="ms-panel mb-3">
                    <div class="ms-panel-body">
                        <h5 class="mb-3">Pricing & Deposit</h5>

                        @if(!$onboarded)
                            <div class="alert alert-warning mb-0">
                                <a href="{{ route('artist.payouts') }}">Connect your Stripe account</a> before setting pricing.
                            </div>
                        @elseif($req->payment_status === 'deposit_pending' || !$req->tattoo_price)
                            <form method="POST" action="{{ route('artist.requests.pricing', $active) }}">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="small">Tattoo Price ($)</label>
                                        <input type="number" name="tattoo_price" class="form-control" step="0.01" min="1"
                                            value="{{ old('tattoo_price', $req->tattoo_price) }}" placeholder="400.00" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small">Deposit ($)</label>
                                        <input type="number" name="deposit_amount" class="form-control" step="0.01" min="1"
                                            value="{{ old('deposit_amount', $req->deposit_amount) }}" placeholder="100.00" required>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-black w-100">Set Pricing</button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Customer pays the deposit + ${{ number_format($platformFee, 2) }} platform fee up front;
                                    the remaining balance is requested after the session.
                                </small>
                            </form>
                        @else
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1"><strong>Tattoo Price:</strong> ${{ number_format($req->tattoo_price, 2) }}</p>
                                    <p class="mb-1"><strong>Deposit:</strong> ${{ number_format($req->deposit_amount, 2) }}</p>
                                    <p class="mb-0"><strong>Remaining:</strong> ${{ number_format($req->remaining_balance, 2) }}</p>
                                </div>
                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $req->payment_status)) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

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

                    @foreach($active->messages as $msg)
                        @php $mine = $msg->sender_id === auth()->id(); @endphp
                        <div class="ms-chat-bubble ms-chat-message media clearfix {{ $mine ? 'ms-chat-outgoing' : 'ms-chat-incoming' }}"
                             data-msg-id="{{ $msg->id }}">
                            <div class="ms-chat-status ms-status-online ms-chat-img">
                                <img src="{{ $mine ? $myAvatar : $customerAvatar }}" class="ms-img-round" alt="">
                            </div>
                            <div class="media-body">
                                <div class="ms-chat-text">
                                    @if($msg->body)<p>{{ $msg->body }}</p>@endif
                                    @if($msg->attachment_path)
                                        @if($msg->attachment_type === 'image')
                                            <a href="{{ asset('storage/'.$msg->attachment_path) }}" target="_blank">
                                                <img src="{{ asset('storage/'.$msg->attachment_path) }}" alt="attachment"
                                                    style="max-width:200px;border-radius:8px;margin-top:4px;">
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/'.$msg->attachment_path) }}" target="_blank"
                                               class="d-inline-flex align-items-center p-2 mt-1"
                                               style="background:#f0f0f7;border-radius:8px;color:#2C2B2B;">
                                                <i class="material-icons mr-1">insert_drive_file</i>
                                                {{ $msg->attachment_name }}
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <p class="ms-chat-time">{{ $msg->created_at->format('g:i a') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="ms-panel-footer pt-0">
                    <form id="chatForm" method="POST" action="{{ route('artist.requests.message', $active) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="ms-chat-textbox">
                            <ul class="ms-list-flex mb-0 align-items-center">
                                <li class="ms-chat-input" style="flex:1;">
                                    <input type="text" name="body" placeholder="Type a message" autocomplete="off">
                                    <span id="attachName" class="text-muted fs-12 d-block" style="padding-left:1rem;"></span>
                                </li>
                                <ul class="ms-chat-text-controls ms-list-flex align-items-center">
                                    <li>
                                        <label for="attachInput" class="btn btn-link p-0 mb-0" style="cursor:pointer;" title="Attach file">
                                            <i class="material-icons">attach_file</i>
                                        </label>
                                        <input type="file" id="attachInput" name="attachment" hidden
                                            accept="image/*,.pdf,.doc,.docx,.txt">
                                    </li>
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

            {{-- Decline modal --}}
            @if($active->request && ($active->request->status ?? 'pending') === 'pending')
                <div class="modal fade" id="declineModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('artist.requests.decline', $active) }}">
                                @csrf
                                <div class="modal-header">
                                    <h3 class="modal-title has-icon ms-icon-round">
                                        <i class="flaticon-cancel bg-danger text-white"></i> Decline Request</h3>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted fs-13">Let the customer know why (optional). This will be sent as a message.</p>
                                    <div class="form-group mb-0">
                                        <label class="small">Reason</label>
                                        <textarea name="reason" class="form-control" rows="3"
                                            placeholder="e.g. Fully booked for the next few months."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Decline Request</button>
                                </div>
                            </form>
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
    const chatBody = document.getElementById('chatBody');

    function scrollToBottom() {
        if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
    }

    scrollToBottom();
    if (chatBody) {
        chatBody.querySelectorAll('img').forEach(img => {
            if (!img.complete) {
                img.addEventListener('load', scrollToBottom);
                img.addEventListener('error', scrollToBottom);
            }
        });
    }

    @if($active)
    (function () {
        const conversationId = {{ $active->id }};
        const form  = document.getElementById('chatForm');
        const input = form.querySelector('input[name="body"]');
        const csrf  = document.querySelector('meta[name="csrf-token"]').content;

        const sendUrl = "{{ url('/chat') }}/" + conversationId;
        const pollUrl = "{{ url('/chat') }}/" + conversationId + "/poll";

        const myAvatar    = @json($myAvatar);
        const otherAvatar = @json($customerAvatar);

        let lastId = [...chatBody.querySelectorAll('[data-msg-id]')]
            .map(el => parseInt(el.dataset.msgId))
            .reduce((max, id) => Math.max(max, id), 0);

        function escapeHtml(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
        }

        function bubble(m) {
            const side   = m.mine ? 'ms-chat-outgoing' : 'ms-chat-incoming';
            const avatar = m.mine ? myAvatar : otherAvatar;

            let content = m.body ? `<p>${escapeHtml(m.body)}</p>` : '';

            if (m.attachment_url) {
                if (m.attachment_type === 'image') {
                    content += `<a href="${m.attachment_url}" target="_blank">
                        <img src="${m.attachment_url}" alt="attachment" style="max-width:200px;border-radius:8px;margin-top:4px;">
                    </a>`;
                } else {
                    content += `<a href="${m.attachment_url}" target="_blank"
                        class="d-inline-flex align-items-center p-2 mt-1"
                        style="background:#f0f0f7;border-radius:8px;color:#2C2B2B;">
                        <i class="material-icons mr-1">insert_drive_file</i>${escapeHtml(m.attachment_name || 'file')}
                    </a>`;
                }
            }

            return `
                <div class="ms-chat-bubble ms-chat-message media clearfix ${side}" data-msg-id="${m.id}">
                    <div class="ms-chat-status ms-status-online ms-chat-img">
                        <img src="${avatar}" class="ms-img-round" alt="">
                    </div>
                    <div class="media-body">
                        <div class="ms-chat-text">${content}</div>
                        <p class="ms-chat-time">${m.time}</p>
                    </div>
                </div>`;
        }

        function append(m) {
            chatBody.insertAdjacentHTML('beforeend', bubble(m));
            lastId = Math.max(lastId, m.id);
            scrollToBottom();

            const newImg = chatBody.querySelector('[data-msg-id="' + m.id + '"] .ms-chat-text img');
            if (newImg && !newImg.complete) {
                newImg.addEventListener('load', scrollToBottom);
            }
        }

        // file input → show chosen filename
        const attachInput = document.getElementById('attachInput');
        const attachName  = document.getElementById('attachName');
        attachInput.addEventListener('change', () => {
            attachName.textContent = attachInput.files.length ? '📎 ' + attachInput.files[0].name : '';
        });

        // ── Send (text and/or file) via FormData ──
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const body = input.value.trim();
            const hasFile = attachInput.files.length > 0;
            if (!body && !hasFile) return;

            const fd = new FormData();
            if (body) fd.append('body', body);
            if (hasFile) fd.append('attachment', attachInput.files[0]);

            input.value = '';
            attachInput.value = '';
            attachName.textContent = '';

            try {
                const res = await fetch(sendUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: fd,
                });
                if (res.ok) append(await res.json());
            } catch (e) { /* silent */ }
        });

        // ── Poll for new messages ──
        async function poll() {
            try {
                const res = await fetch(pollUrl + '?after=' + lastId, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();
                data.messages.forEach(m => {
                    if (!m.mine) append(m);
                    else lastId = Math.max(lastId, m.id);
                });
            } catch (e) { /* silent */ }
        }

        let timer = setInterval(poll, 3000);
        document.addEventListener('visibilitychange', () => {
            clearInterval(timer);
            if (!document.hidden) {
                poll();
                timer = setInterval(poll, 3000);
            }
        });
    })();
    @endif
</script>
@endpush

@endsection