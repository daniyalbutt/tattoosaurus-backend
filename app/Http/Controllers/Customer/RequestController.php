<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        // all this customer's conversations (each tied to a request)
        $conversations = Conversation::where('customer_id', auth()->id())
            ->with(['artist.artistProfile', 'request', 'messages'])
            ->latest()
            ->get();

        // default to the most recent
        $active = $conversations->first();

        return view('customer.requests', compact('conversations', 'active'));
    }

    public function show(Conversation $conversation)
    {
        abort_unless($conversation->customer_id === auth()->id(), 403);

        $conversations = Conversation::where('customer_id', auth()->id())
            ->with(['artist.artistProfile', 'request', 'messages'])
            ->latest()
            ->get();

        $active = $conversation->load(['artist.artistProfile', 'request', 'messages.sender']);

        return view('customer.requests', compact('conversations', 'active'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->customer_id === auth()->id(), 403);

        $data = $request->validate(['body' => ['required','string','max:2000']]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'body'            => $data['body'],
        ]);

        return redirect()->route('customer.requests.show', $conversation);
    }
}