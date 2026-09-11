<?php
namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('artist_id', auth()->id())
            ->with(['customer', 'request', 'messages' => fn ($q) => $q->latest()->limit(1)])
            ->latest()
            ->get();

        $active = $conversations->first();

        return view('artist.requests', compact('conversations', 'active'));
    }

    public function show(Conversation $conversation)
    {
        abort_unless($conversation->artist_id === auth()->id(), 403);

        $conversations = Conversation::where('artist_id', auth()->id())
            ->with(['customer', 'request', 'messages' => fn ($q) => $q->latest()->limit(1)])
            ->latest()
            ->get();

        $active = $conversation->load(['customer', 'request', 'messages.sender']);

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
}