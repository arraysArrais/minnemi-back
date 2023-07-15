<?php

namespace App\Mail;

use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Letter $letter)
    {
        
    }

    // /**
    //  * Get the message envelope.
    //  */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->letter['title'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'LetterMail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
