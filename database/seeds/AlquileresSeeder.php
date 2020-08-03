<?php

use Illuminate\Database\Seeder;

class AlquileresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
		DB::table('alquileres')->insert([

        	[
	            'estado' => 'finalizado',
	            'fecha_inicio' => '2020-05-10',
	            'fecha_fin' => '2020-05-14',
	            'precio_diario' => 1500,
	            'saldo_actual' => 0,
	            'id_chofer' => 1,
	            'id_vehiculo' => 1,
	            'descuento_semanal' => true,
	            'notas' => null
       		],

        	[
	            'estado' => 'en_curso',
	            'fecha_inicio' => '2020-06-13',
	            'fecha_fin' => null,
	            'precio_diario' => 1800,
	            'saldo_actual' => 1800,
	            'id_chofer' => 1,
	            'id_vehiculo' => 1,
	            'descuento_semanal' => 1,
	            'notas' => null
       		],


        	[
	            'estado' => 'en_curso',
	            'fecha_inicio' => '2020-06-14',
	            'fecha_fin' => null,
	            'precio_diario' => 1700,
	            'saldo_actual' => 1700,
	            'id_chofer' => 3,
	            'id_vehiculo' => 2,
	            'descuento_semanal' => false,
	            'notas' => null
       		]       		


        ]);


        DB::table('vehiculos')->where('id', 1)->update(['id_alquiler_actual' => 2]);
        DB::table('vehiculos')->where('id', 2)->update(['id_alquiler_actual' => 3]);

    }
}
