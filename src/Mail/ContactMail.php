<?php

namespace Ro749\FullListingTemplate\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Ro749\SharedUtils\Mail\Mailable;
class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $m_name;
    public string $m_phone;
    public string $m_email;
    public string $m_unit;
    public string $m_message;
    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $phone, string $email, string $unit, string $message)
    {
        $this->m_name = $name;
        $this->m_phone = $phone;
        $this->m_email = $email;
        $this->m_unit = $unit;
        $this->m_message = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').': '. $this->m_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'full-listing-template::mail.mail-open',
            with: [
                'name'=>$this->m_name,
                'phone'=>$this->m_phone,
                'email'=>$this->m_email,
                'unit'=>$this->m_unit,
                'msg'=>$this->m_message
            ]
        );
    }
}
