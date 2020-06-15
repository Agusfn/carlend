<?php

use Illuminate\Database\Seeder;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('proveedores')->insert([

        	[
	            'nombre' => 'Repuestos José',
	            'direccion' => 'RP26 941, Del Viso, Buenos Aires',
	            'telefono' => '2320 473999',
	            'categoria' => 'repuestos'
       		],

        	[
	            'nombre' => 'Mecánico Jorge',
	            'direccion' => 'Mariano Acha 1669, La Lonja, Buenos Aires',
	            'telefono' => '2320 1122445',
	            'categoria' => 'mecanico'
       		],

        	[
	            'nombre' => 'Lubricentro Jumax',
	            'direccion' => 'Colectora Oeste 1441, Manuel Alberti, BSAS',
	            'telefono' => '1169945302',
	            'categoria' => 'service'
       		],
       		[
	            'nombre' => 'Provincia Seguros',
	            'direccion' => 'Ruta 8 Km 50,5, Pilar, Buenos Aires',
	            'telefono' => '230 4667360',
	            'categoria' => 'aseguradora'
       		]

        ]);
    }
}
