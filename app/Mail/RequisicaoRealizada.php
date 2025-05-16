<?php

namespace App\Mail;

use App\Models\requesicoes;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequisicaoRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $requisicao;


    /**
     * Create a new message instance.
     */
    public function __construct(requesicoes $requisicao)
    {
        $this->requisicao = $requisicao;




    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Requesicao Realizada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.requisicao',
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