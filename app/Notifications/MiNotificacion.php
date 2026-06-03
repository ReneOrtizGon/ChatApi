<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MiNotificacion extends Notification
{
    use Queueable;
    var $message="";
    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
     $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public  function  toDatabase ( $notifiable )
     {

        return [
            'message' => 'Introducción a la notificación para la base de datos.' ,
            'chat_id' => $this->message->id,

            // Agregue cualquier dato adicional que desee almacenar en la base de datos
         ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
         return [
            'message' => 'Introducción a la notificación para la base de datos.' ,
            'user_id' => $notifiable->id,

            // Agregue cualquier dato adicional que desee almacenar en la base de datos
         ];
    }
}
