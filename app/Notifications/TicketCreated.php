<?php
namespace App\Notifications;

// app/Notifications/TicketCreated.php

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification
{
    private $ticket;
    private $user;

    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'user_avatar' => $this->user->avatar, // Assurez-vous que le modèle User a un champ avatar
        ];
    }
}
