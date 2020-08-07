<?php

use Illuminate\Database\Seeder;

class ActualizacionKmVehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('actualizacion_km_vehiculos')->insert([

        	[
	            'id_vehiculo' => 1,
	            'fecha' => '2020-05-05',
	            'kilometros' => 75000
       		],

        	[
	            'id_vehiculo' => 1,
	            'fecha' => '2020-06-02',
	            'kilometros' => 82000
       		],

        	[
	            'id_vehiculo' => 2,
	            'fecha' => '2020-06-10',
	            'kilometros' => 55000
       		]

        ]);
    }
}
