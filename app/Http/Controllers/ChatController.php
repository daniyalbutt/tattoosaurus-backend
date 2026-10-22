<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\GeneralNotification;

class ChatController extends Controller
{
    public function show(Conversation $conversation)
    {
        $this->authorizeAccess($conversation);
        $conversation->load(['customer', 'artist', 'request']);
        $messages = $conversation->messages()->oldest()->get();
        return view('chat', compact('conversation', 'messages'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $this->authorizeAccess($conversation);

        $data = $request->validate([
            'body'       => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:jpeg,png,jpg,webp,gif,pdf,doc,docx,txt'],
        ]);

        // must have at least a message or a file
        if (empty($data['body']) && !$request->hasFile('attachment')) {
            return response()->json(['message' => 'Empty message'], 422);
        }

        $attachmentPath = $attachmentName = $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat-attachments', 'public');
            $attachmentName = $file->getClientOriginalName();
            $attachmentType = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'file';
        }

        $msg = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'body'            => $data['body'] ?? null,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
        ]);

        $conversation->touch();

        // notify the OTHER party in the conversation
        $this->notifyRecipient($conversation, $msg);

        return response()->json($this->formatMessage($msg));
    }

    public function poll(Request $request, Conversation $conversation)
    {
        $this->authorizeAccess($conversation);
        $afterId = (int) $request->query('after', 0);

        $messages = $conversation->messages()
            ->where('id', '>', $afterId)
            ->oldest()
            ->get()
            ->map(fn ($m) => $this->formatMessage($m));

        return response()->json(['messages' => $messages]);
    }

    private function notifyRecipient(Conversation $conversation, Message $msg): void
    {
        // recipient = whoever isn't the sender
        $isArtistSender = auth()->id() === $conversation->artist_id;
        $recipient = $isArtistSender ? $conversation->customer : $conversation->artist;
        if (! $recipient) return;

        // where the recipient opens this conversation
        $url = $isArtistSender
            ? route('customer.requests.show', $conversation)   // customer receives
            : route('artist.requests.show', $conversation);    // artist receives

        $preview = $msg->body
            ? Str::limit($msg->body, 40)
            : '📎 Attachment';

        $recipient->notify(new GeneralNotification(
            title: 'New message',
            body:  auth()->user()->name . ': ' . $preview,
            url:   $url,
            icon:  'chat',
        ));
    }

    private function formatMessage(Message $m): array
    {
        return [
            'id'              => $m->id,
            'body'            => $m->body,
            'mine'            => $m->sender_id === auth()->id(),
            'time'            => $m->created_at->format('g:i a'),
            'attachment_url'  => $m->attachment_path ? asset('storage/'.$m->attachment_path) : null,
            'attachment_name' => $m->attachment_name,
            'attachment_type' => $m->attachment_type,
        ];
    }

    private function authorizeAccess(Conversation $c)
    {
        abort_unless(in_array(auth()->id(), [$c->customer_id, $c->artist_id]), 403);
    }
}