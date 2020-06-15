<?php

use Illuminate\Database\Seeder;

class GastosAdicionalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('gastos_adicionales')->insert([

        	[
	            'fecha' => '2020-05-15',
	            'tipo' => 'impuesto_automotor',
	            'id_vehiculo' => 1,
	            'monto' => 1900,
	            'medio_pago' => 'tarjeta',
	            'id_proveedor' => null,
	            'comentario' => null
       		],
        	[
	            'fecha' => '2020-05-18',
	            'tipo' => 'seguro_vehiculo',
	            'id_vehiculo' => 1,
	            'monto' => 2900,
	            'medio_pago' => 'tarjeta',
	            'id_proveedor' => 4,
	            'comentario' => null
       		],

        	[
	            'fecha' => '2020-05-25',
	            'tipo' => 'otro',
	            'id_vehiculo' => null,
	            'monto' => 1000,
	            'medio_pago' => 'tarjeta',
	            'id_proveedor' => null,
	            'comentario' => 'Pago publicidad internet'
       		],



        	[
	            'fecha' => '2020-06-15',
	            'tipo' => 'impuesto_automotor',
	            'id_vehiculo' => 1,
	            'monto' => 1900,
	            'medio_pago' => 'tarjeta',
	            'id_proveedor' => null,
	            'comentario' => null
       		],


        	[
	            'fecha' => '2020-06-15',
	            'tipo' => 'impuesto_automotor',
	            'id_vehiculo' => 2,
	            'monto' => 2500,
	            'medio_pago' => 'tarjeta',
	            'id_proveedor' => null,
	            'comentario' => null
       		],


        ]);
    }
}
