<?php
namespace App\Mail;

use App\Models\Consult;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultSubmitted extends Mailable
{
    use Queueable, SerializesModels;
    public $consult;
    public function __construct(Consult $consult)
    {
        $this->consult = $consult;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Inquiry Request Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-submitted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}