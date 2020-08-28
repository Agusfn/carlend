<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Cron\Alquileres;

class DebitarCobroAlquileres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alquileres:cobrar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debitar monto del cobro diario de alquileres en curso de sus respectivas cuentas corrientes.';

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
        Alquileres::realizarCobrosDelDia();
    }
}
