<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $subject;
    public $userMessage;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->subject = $data['subject'];
        $this->userMessage = $data["message"];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->email,
            to: ['support@tiarshop.com'],
            replyTo: $this->email,
            subject: "[Contact Form] {$this->subject}",
            tags: ['contact-form'],
            metadata: [
                'source' => 'website-contact-form',
                'user_email' => $this->email,
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'userMessage' => $this->userMessage,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}