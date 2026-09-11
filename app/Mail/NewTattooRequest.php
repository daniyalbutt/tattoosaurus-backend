<?php
namespace App\Mail;

use App\Models\User;
use App\Models\TattooRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTattooRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $artist,
        public User $customer,
        public TattooRequest $tattooRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Tattoo Request on Tattoosaurus');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-tattoo-request', with: [
            'artist'   => $this->artist,
            'customer' => $this->customer,
            'request'  => $this->tattooRequest,
        ]);
    }
}