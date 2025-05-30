<?php

namespace App\Mail;

use App\Models\Reviews;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public Reviews $review;

    public function __construct(Reviews $review)
    {
        $this->review = $review;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nova Review para Aprovação',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.review_admin',
            with: [
                'review' => $this->review,
                'user' => $this->review->user,
                'livro' => $this->review->livro,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}