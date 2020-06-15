<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlquileresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('precio_diario', 10, 2);
            $table->decimal('saldo_actual', 10, 2);
            $table->foreignId('id_chofer');
            $table->foreignId('id_vehiculo');
            $table->boolean('descuento_semanal');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('id_chofer')->references('id')->on('choferes');
            $table->foreign('id_vehiculo')->references('id')->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alquileres');
    }
}
