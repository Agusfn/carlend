<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Cron\Alquileres;

class TerminarAlquileresProgramados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alquileres:terminar-programados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Terminar los alquileres en curso que llegaron a su fecha programada de fin.';

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
        Alquileres::terminarAlquileresProgramados();
    }
}
