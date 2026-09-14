<?php
namespace App\Mail;

use App\Models\ArtistReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArtistReported extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ArtistReport $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Artist Report on Tattoosaurus');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.artist-reported', with: [
            'report' => $this->report->load('artist', 'reporter'),
        ]);
    }
}