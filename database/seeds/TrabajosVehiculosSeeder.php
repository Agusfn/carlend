<?php

use Illuminate\Database\Seeder;

class TrabajosVehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('trabajos_vehiculos')->insert([

        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 1,
	            'kms_vehiculo_estimados' => 70000,
	            'tipo' => 'service',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 1,
	            'kms_vehiculo_estimados' => 70000,
	            'tipo' => 'cambio_bujias',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 1,
	            'kms_vehiculo_estimados' => 70000,
	            'tipo' => 'rotacion_ruedas',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 1,
	            'kms_vehiculo_estimados' => 70000,
	            'tipo' => 'cambio_cubiertas',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 1,
	            'kms_vehiculo_estimados' => 70000,
	            'tipo' => 'cambio_correa_distr',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],       		       		       		




        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 2,
	            'kms_vehiculo_estimados' => 50000,
	            'tipo' => 'service',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 2,
	            'kms_vehiculo_estimados' => 50000,
	            'tipo' => 'cambio_bujias',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 2,
	            'kms_vehiculo_estimados' => 50000,
	            'tipo' => 'rotacion_ruedas',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 2,
	            'kms_vehiculo_estimados' => 50000,
	            'tipo' => 'cambio_cubiertas',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],
        	[
        		'es_trabajo_previo' => true,
	            'id_vehiculo' => 2,
	            'kms_vehiculo_estimados' => 50000,
	            'tipo' => 'cambio_correa_distr',
	            'costo_total' => 0,
	            'medio_pago' => 'n/a',
       		],       		       		       		


        	/*[
        		'es_trabajo_previo' => false,
	            'fecha_pagado' => '2020-06-10',
	            'id_vehiculo' => 1,
	            'kms_vehiculo_estimados' => 84000,
	            'tipo' => 'service',
	            'observaciones' => 'Cambio de filtro de aire, aceite, polen, y nafta',
	            'id_proveedor' => 3,
	            'costo_total' => 2500,
	            'medio_pago' => 'efectivo',
	            'fecha_realizado' => '2020-05-25'
       		],

        	[
        		'es_trabajo_previo' => false,
	            'fecha_pagado' => '2020-06-12',
	            'id_vehiculo' => 2,
	            'kms_vehiculo_estimados' => 55000,
	            'tipo' => 'cambio_cubiertas',
	            'observaciones' => 'En Norauto Olivos',
	            'id_proveedor' => null,
	            'costo_total' => 23000,
	            'medio_pago' => 'tarjeta_credito',
	            'fecha_realizado' => '2020-06-14'
       		],*/
        	

        ]);
    }
}
