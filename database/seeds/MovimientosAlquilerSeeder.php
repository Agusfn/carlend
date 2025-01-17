<?php

use Illuminate\Database\Seeder;

class MovimientosAlquilerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		DB::table('movimientos_alquiler')->insert([

        	['fecha_hora' => '2020-05-11 00:00:00', 'id_alquiler' => 1, 'tipo' => 'cobro_alquiler', 'monto' => -1500, 'nuevo_saldo' => -1500, 'medio_pago' => null, 'comentario' => null],
        	['fecha_hora' => '2020-05-12 00:00:00', 'id_alquiler' => 1, 'tipo' => 'cobro_alquiler', 'monto' => -1500, 'nuevo_saldo' => -3000, 'medio_pago' => null, 'comentario' => null],
        	['fecha_hora' => '2020-05-13 00:00:00', 'id_alquiler' => 1, 'tipo' => 'cobro_alquiler', 'monto' => -1500, 'nuevo_saldo' => -4500, 'medio_pago' => null, 'comentario' => null],
        	['fecha_hora' => '2020-05-14 00:00:00', 'id_alquiler' => 1, 'tipo' => 'cobro_alquiler', 'monto' => -1500, 'nuevo_saldo' => -6000, 'medio_pago' => null, 'comentario' => null],
        	['fecha_hora' => '2020-05-16 13:25:49', 'id_alquiler' => 1, 'tipo' => 'pago_de_chofer', 'monto' => 6000, 'nuevo_saldo' => 0, 'medio_pago' => 'efectivo', 'comentario' => null],
        	  		

        	['fecha_hora' => '2020-06-14 00:00:00', 'id_alquiler' => 2, 'tipo' => 'cobro_alquiler', 'monto' => -1800, 'nuevo_saldo' => -1800, 'medio_pago' => null, 'comentario' => null],
        	['fecha_hora' => '2020-06-15 00:00:00', 'id_alquiler' => 2, 'tipo' => 'cobro_alquiler', 'monto' => -1800, 'nuevo_saldo' => -3600, 'medio_pago' => null, 'comentario' => null],        	
        	['fecha_hora' => '2020-06-14 15:41:02', 'id_alquiler' => 2, 'tipo' => 'pago_de_chofer', 'monto' => 1800, 'nuevo_saldo' => -1800, 'medio_pago' => 'mercadopago', 'comentario' => null],

        	['fecha_hora' => '2020-06-15 00:00:00', 'id_alquiler' => 3, 'tipo' => 'cobro_alquiler', 'monto' => -1700, 'nuevo_saldo' => -3500, 'medio_pago' => null, 'comentario' => null]

        ]);

    }
}
