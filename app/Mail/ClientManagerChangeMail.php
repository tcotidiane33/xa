<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientManagerChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function build()
    {
        return $this->markdown('emails.client_manager_change')
            ->subject('Changement de gestionnaire')
            ->with([
                'managerName' => $this->manager->name,
                'managerEmail' => $this->manager->email,
                'managerPhone' => $this->manager->phone,
            ]);
    }
}
