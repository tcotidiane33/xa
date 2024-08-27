<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class RelationUpdated extends Notification
{
    use Queueable;

    private $action;
    private $detailsMessage;

    public function __construct($action, $detailsMessage)
    {
        $this->action = $action;
        $this->detailsMessage = $detailsMessage;
    }

    public function via($notifiable)
    {
        return ['database', 'log'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Une action a été effectuée sur une relation Gestionnaire-Client.')
                    ->line('Action : ' . $this->action)
                    ->line('Détails : ' . $this->detailsMessage);
    }

    public function toArray($notifiable)
    {
        return [
            'action' => $this->action,
            'details' => $this->detailsMessage,
        ];
    }

    public function toLog($notifiable)
    {
        return [
            'action' => $this->action,
            'details' => $this->detailsMessage,
            'notifiable' => $notifiable->id
        ];
    }
}