<?php

namespace App\Mail;

use App\Models\Encomendas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LivroCompradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Encomendas $encomenda;

    /**
     * Create a new message instance.
     */
    public function __construct(Encomendas $encomenda)
    {
        $this->encomenda = $encomenda;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📚 Confirmação de Compra - Biblioteca'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.livro_comprado', 
            with: [
                'encomenda' => $this->encomenda,
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