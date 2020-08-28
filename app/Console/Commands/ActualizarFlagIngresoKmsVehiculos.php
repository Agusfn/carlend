<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Cron\Vehiculos;

class ActualizarFlagIngresoKmsVehiculos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehiculos:actualizar-flag-kms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar atributo de cada vehiculo que indica si se debe ingresar el kilometraje el día de hoy o no.';

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
        Vehiculos::actualizarFlagRegistroKilometraje();
    }
}
