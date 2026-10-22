<?php
namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\TattooRequest;
use App\Notifications\GeneralNotification;


class RequestController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('artist_id', auth()->id())
            ->with(['customer', 'request',
                    'messages' => fn ($q) => $q->oldest()])
            ->latest()
            ->get();

        $active = $conversations->first()?->load([
            'customer', 'request',
            'messages' => fn ($q) => $q->oldest()->with('sender'),
        ]);

        return view('artist.requests', compact('conversations', 'active'));
    }

    public function show(Conversation $conversation)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $conversations = Conversation::where('artist_id', auth()->id())
            ->with(['customer', 'request',
                    'messages' => fn ($q) => $q->oldest()])
            ->latest()
            ->get();

        $active = $conversation->load([
            'customer',
            'request',
            'messages' => fn ($q) => $q->oldest()->with('sender'),
        ]);

        return view('artist.requests', compact('conversations', 'active'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $data = $request->validate(['body' => ['required', 'string', 'max:5000']]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'body'            => $data['body'],
        ]);

        // notify the customer of the new message
        $conversation->customer->notify(new GeneralNotification(
            title: 'New message',
            body:  auth()->user()->name . ': ' . \Illuminate\Support\Str::limit($data['body'], 40),
            url:   route('customer.requests.show', $conversation),
            icon:  'chat',
        ));

        return back();
    }

    public function setPricing(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $data = $request->validate([
            'tattoo_price'   => ['required', 'numeric', 'min:1'],
            'deposit_amount' => ['required', 'numeric', 'min:1', 'lte:tattoo_price'],
        ]);

        $req = $conversation->request;
        $req->update([
            'tattoo_price'   => $data['tattoo_price'],
            'deposit_amount' => $data['deposit_amount'],
            'payment_status' => 'deposit_pending',
        ]);

        // ── system message into the chat ──
        $conversation->messages()->create([
            'sender_id' => auth()->id(),   // the artist
            'body'      => 'I\'ve set the pricing for your tattoo: $'
                . number_format($data['tattoo_price'], 2)
                . ' total, with a $' . number_format($data['deposit_amount'], 2)
                . ' deposit to confirm your booking. You can pay the deposit from the panel above.',
        ]);

        // notify the customer: deposit is now payable
        $conversation->customer->notify(new GeneralNotification(
            title: 'Deposit requested',
            body:  'Pay a $' . number_format($data['deposit_amount'], 2)
                    . ' deposit to confirm your booking.',
            url:   route('customer.requests.show', $conversation),
            icon:  'payments',
        ));

        return back()->with('success', 'Pricing set and shared with the customer.');
    }

    public function approve(Conversation $conversation)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $req = $conversation->request;
        abort_if(!$req, 404);

        $req->update([
            'status'         => 'approved',
            'payment_status' => 'deposit_pending',   // unlocks the pricing form
        ]);

        // Optional: drop a system message into the chat so the customer sees it
        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body'      => 'Your request has been approved. I\'ll set the pricing shortly.',
        ]);

        // notify the customer
        $conversation->customer->notify(new GeneralNotification(
            title: 'Request approved',
            body:  auth()->user()->name . ' approved your tattoo request.',
            url:   route('customer.requests.show', $conversation),
            icon:  'check_circle',
        ));

        return back()->with('success', 'Request approved. You can now set the pricing.');
    }

    public function decline(Conversation $conversation, Request $request)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $req = $conversation->request;
        abort_if(!$req, 404);

        $req->update(['status' => 'declined']);

        $reason = trim((string) $request->input('reason'));
        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body'      => $reason !== ''
                ? 'Unfortunately I can\'t take this request. Reason: ' . $reason
                : 'Unfortunately I\'m unable to take this request at this time.',
        ]);

        // notify the customer
        $conversation->customer->notify(new GeneralNotification(
            title: 'Request declined',
            body:  $reason !== ''
                    ? 'Your request was declined: ' . \Illuminate\Support\Str::limit($reason, 50)
                    : 'Your request was declined.',
            url:   route('customer.requests.show', $conversation),
            icon:  'cancel',
        ));

        return back()->with('success', 'Request declined.');
    }

    public function approved()
    {
        $requests = \App\Models\TattooRequest::query()
            ->whereHas('conversation', fn ($q) => $q->where('artist_id', auth()->id()))
            ->where('status', 'approved')
            ->with(['conversation.customer', 'payments'])
            ->latest()
            ->get();

        return view('artist.approved-requests', compact('requests'));
    }

    public function requestBalance(Conversation $conversation)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $req = $conversation->request;
        abort_unless($req, 404);
        abort_unless($req->payment_status === 'booking_confirmed', 403,
            'Balance can only be requested after the deposit is paid.');

        $req->update(['payment_status' => 'balance_pending']);

        $conversation->messages()->create([
            'sender_id' => auth()->id(),   // the artist
            'body'      => 'Your tattoo is complete. The remaining balance of $'
                . number_format($req->remaining_balance, 2)
                . ' is now due — you can pay it from the panel above.',
        ]);

        // notify the customer: balance is now payable
        $conversation->customer->notify(new GeneralNotification(
            title: 'Balance due',
            body:  'Your remaining balance of $' . number_format($req->remaining_balance, 2)
                    . ' is now payable.',
            url:   route('customer.requests.show', $conversation),
            icon:  'request_quote',
        ));

        return back()->with('success', 'Balance requested. The customer has been notified.');
    }
}