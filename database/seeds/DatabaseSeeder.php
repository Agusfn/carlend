<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuariosSeeder::class);
        $this->call(ProveedoresSeeder::class);
        $this->call(VehiculosSeeder::class);
        $this->call(ActualizacionKmVehiculosSeeder::class);
        $this->call(TrabajosVehiculosSeeder::class);
        $this->call(ChoferesSeeder::class);
        $this->call(AlquileresSeeder::class);
        $this->call(MovimientosAlquilerSeeder::class);
        $this->call(GastosAdicionalesSeeder::class);
    }
}
