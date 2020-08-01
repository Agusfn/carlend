<?php

use Illuminate\Database\Seeder;

class VehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


		DB::table('vehiculos')->insert([

        	[
        		'id_alquiler_actual' => 2,
	            'marca' => 'Renault',
	            'modelo' => 'Megane',
	            'anio' => 2015,
	            'dominio' => 'OVH445',
	            'costo_mensual_imp_automotor' => 1900,
	            'dia_del_mes_debito_imp_automotor' => 15,
	            'id_proveedor_seguro' => 4,
	            'costo_mensual_seguro' => 2900,
	            'dia_del_mes_debito_seguro' => 18,
	            'kms_cada_service' => 10000,
	            'kms_cada_cambio_bujias' => 10000,
	            'kms_cada_rotacion_cubiertas' => 10000,
	            'kms_cada_cambio_cubiertas' => 60000,
	            'kms_cada_cambio_correa_distr' => 60000,
	            'fecha_vto_vtv' => '2020-12-15',
	            'fecha_vto_oblea_gnc' => '2020-11-20',
	            'kilometraje_prediccion_actual' => 82000,
       		],

        	[
        		'id_alquiler_actual' => 3,
	            'marca' => 'Renault',
	            'modelo' => 'Fluence',
	            'anio' => 2016,
	            'dominio' => 'AG411CD',
	            'costo_mensual_imp_automotor' => 2500,
	            'dia_del_mes_debito_imp_automotor' => 15,
	            'id_proveedor_seguro' => 4,
	            'costo_mensual_seguro' => 4200,
	            'dia_del_mes_debito_seguro' => 18,
	            'kms_cada_service' => 10000,
	            'kms_cada_cambio_bujias' => 10000,
	            'kms_cada_rotacion_cubiertas' => 10000,
	            'kms_cada_cambio_cubiertas' => 60000,
	            'kms_cada_cambio_correa_distr' => 60000,
	            'fecha_vto_vtv' => '2020-11-20',
	            'fecha_vto_oblea_gnc' => '2021-01-15',
	            'kilometraje_prediccion_actual' => 55000,
       		],

        ]);

    }
}
