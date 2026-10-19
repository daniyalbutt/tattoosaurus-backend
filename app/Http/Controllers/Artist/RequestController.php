<?php
namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\TattooRequest;


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

        // Optional: notify the customer by email
        // Mail::to($conversation->customer->email)->send(new RequestApproved($req));

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
}