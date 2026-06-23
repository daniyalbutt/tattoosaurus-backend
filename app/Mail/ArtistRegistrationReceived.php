<?php
// app/Mail/ArtistRegistrationReceived.php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArtistRegistrationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $artist) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Tattoosaurus Application is Under Review');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.artist-registration-received', with: [
            'artist' => $this->artist,
        ]);
    }
}