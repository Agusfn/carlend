<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Cron\Notificaciones;

class EnviarEmailsNotificaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaciones:enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia los e-mails pendientes de envio de notificaciones de tareas pendientes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Notificaciones::enviarEmailsPendientes();
    }
}
