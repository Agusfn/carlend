<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Lib\Notificaciones\AdministradorNotificaciones;

class NotificacionTareaPendiente extends Mailable
{
    use Queueable, SerializesModels;



    /**
     * La tareapendiente asociada a este mensaje.
     * @var App\TareaPendiente
     */
    public $tareaPendiente;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tareaPendiente)
    {
        $this->tareaPendiente = $tareaPendiente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $subject = AdministradorNotificaciones::obtenerTextoNotificacionTareaPendiente($this->tareaPendiente);

        return $this->subject($subject)
            ->markdown('emails.notificacion-tarea-pendiente');
    }
}
