<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("alquileres:terminar-programados")->dailyAt("00:00");
        $schedule->command("alquileres:cobrar")->dailyAt("00:00");

        $schedule->command("vehiculos:actualizar-flag-kms")->dailyAt("00:00");
        $schedule->command("notificaciones:enviar")->dailyAt("00:00");
        $schedule->command("gastos-adicionales:registrar-debitos")->dailyAt("00:00");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
