<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(Conversation $conversation)
    {
        $this->authorizeAccess($conversation);
        $conversation->load(['customer','artist','request']);
        $messages = $conversation->messages()->oldest()->get();
        return view('chat', compact('conversation','messages'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $this->authorizeAccess($conversation);
        $data = $request->validate(['body' => ['required','string','max:2000']]);

        $msg = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'body'            => $data['body'],
        ]);

        return response()->json(['id' => $msg->id, 'body' => $msg->body, 'mine' => true]);
    }

    public function poll(Conversation $conversation)
    {
        $this->authorizeAccess($conversation);
        $messages = $conversation->messages()->oldest()->get()->map(fn($m) => [
            'id'   => $m->id,
            'body' => $m->body,
            'mine' => $m->sender_id === auth()->id(),
        ]);
        return response()->json($messages);
    }

    private function authorizeAccess(Conversation $c)
    {
        abort_unless(in_array(auth()->id(), [$c->customer_id, $c->artist_id]), 403);
    }
}