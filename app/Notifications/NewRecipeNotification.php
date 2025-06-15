<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class NewRecipeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $recipe;

    public function __construct($recipe)
    {
        $this->recipe = $recipe;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Log::info('toMail method is called.'); // Log a message to indicate that the method is called

        return (new MailMessage)
            ->subject('New Recipe Added')
            ->line('A new recipe has been added: ' . $this->recipe->title);
    }
}
