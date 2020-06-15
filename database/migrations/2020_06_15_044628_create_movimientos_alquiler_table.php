<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosAlquilerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_alquiler', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_hora');
            $table->foreignId('id_alquiler');
            $table->string('concepto');
            $table->decimal('monto', 10, 2);
            $table->string('medio_pago')->nullable();
            $table->string('comentario')->nullable();
            $table->timestamps();

            $table->foreign('id_alquiler')->references('id')->on('alquileres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos_alquiler');
    }
}
