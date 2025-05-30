<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reviews;

class ReviewEstado extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public $aprovada;

    /**
     * Create a new message instance.
     */
    public function __construct(Reviews $review, bool $aprovada)
    {
        $this->review = $review;
        $this->aprovada = $aprovada;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Estado da sua Review'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.review_estado',
            with: [
                'review' => $this->review,
                'user' => $this->review->user,
                'livro' => $this->review->livro,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}