<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class registerationemail extends Mailable
{
    use Queueable, SerializesModels;
    public $firstname,$lastname,$username;
    /**
     * Create a new message instance.
     */
    public function __construct($firstname = null,$lastname = null, $username = null)
    {
        //
        $this->firstname =$firstname;
        $this->lastname=$lastname;
        $this->username=$username;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->username == null) {
            # code...
            return new Envelope(
                subject: "Welcome $this->firstname $this->lastname  to IvestClub",
            );
        }else{
            return new Envelope(
                subject: "Welcome $this->username     to IvestClub",
            );
        }

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
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
