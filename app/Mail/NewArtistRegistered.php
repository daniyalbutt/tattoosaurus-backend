<?php
// app/Mail/NewArtistRegistered.php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewArtistRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $artist) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Artist Registration — Review Required');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-artist-registered', with: [
            'artist'  => $this->artist,
            'profile' => $this->artist->artistProfile,
        ]);
    }
}