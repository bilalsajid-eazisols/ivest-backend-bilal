<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class generalnotification extends Notification
{
    use Queueable;

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    // Define the channels for the notification
    public function via($notifiable)
    {
        return ['database']; // This enables storing in the database
    }

    // Define the data to be stored in the database
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'user_id' => $notifiable->id,
            'time' => now()
        ];
    }
}
