<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\Livros;

class LivroDisponivel extends Mailable
{
    use Queueable, SerializesModels;

    public $livro;

    /**
     * Create a new message instance.
     */
    public function __construct(Livros $livro)
    {
        $this->livro = $livro;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📚 O livro "' . $this->livro->nome . '" está disponível!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.livros.disponivel',
            with: [
                'livro' => $this->livro
            ]
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