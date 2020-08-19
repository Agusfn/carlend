<?php

use Illuminate\Database\Seeder;

class ChoferesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
		DB::table('choferes')->insert([

        	[
	            'nombre_y_apellido' => 'Juan Gutierrez',
	            'dni' => '31562341',
	            'direccion' => 'Dr. Penna 650, Pilar',
	            'telefono' => '11 45631121',
	            'fecha_vto_licencia' => '2021-02-07',
	            'notas' => 'Confiable.',
	            'id_alquiler_actual' => null
       		],
        	[
	            'nombre_y_apellido' => 'Julian Fosatti',
	            'dni' => '29453394',
	            'direccion' => 'Gral. Lavalle 3620, Garín',
	            'telefono' => '03484663121',
	            'fecha_vto_licencia' => '2020-12-21',
	            'notas' => 'No dejar que se atrase con los pagos.',
	            'id_alquiler_actual' => null
       		],
        	[
	            'nombre_y_apellido' => 'Alberto Rodriguez',
	            'dni' => '35664123',
	            'direccion' => 'Chubut 1154, Pilar',
	            'telefono' => '1155428742',
	            'fecha_vto_licencia' => null,
	            'notas' => 'Recomendado por juan.',
	            'id_alquiler_actual' => null
       		]      

        ]);

    }
}
