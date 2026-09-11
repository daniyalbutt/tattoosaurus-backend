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
            ->with(['artist.artistProfile', 'request',
                    'messages' => fn ($q) => $q->oldest()])
            ->latest()
            ->get();

        $active = $conversation->load([
            'artist.artistProfile',
            'request',
            'messages' => fn ($q) => $q->oldest()->with('sender'),
        ]);

        return view('customer.requests', compact('conversations', 'active'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->customer_id === auth()->id(), 403);

        $data = $request->validate([
            'body'       => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'max:10240'],
        ]);

        if (empty($data['body']) && !$request->hasFile('attachment')) {
            return back();
        }

        $path = $name = $type = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat-attachments', 'public');
            $name = $file->getClientOriginalName();
            $type = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'file';
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'body'            => $data['body'] ?? null,
            'attachment_path' => $path,
            'attachment_name' => $name,
            'attachment_type' => $type,
        ]);

        return redirect()->route('customer.requests.show', $conversation);
    }
}