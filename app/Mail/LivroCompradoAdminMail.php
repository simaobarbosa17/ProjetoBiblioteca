<?php

namespace App\Mail;

use App\Models\Encomendas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LivroCompradoAdminMail extends Mailable
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

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📦 Novo Pedido Realizado - #' . $this->encomenda->id
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.livro_comprado_admin',
            with: [
                'encomenda' => $this->encomenda,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}