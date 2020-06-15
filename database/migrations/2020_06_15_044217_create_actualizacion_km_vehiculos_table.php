<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualizacionKmVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actualizacion_km_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vehiculo');
            $table->date('fecha');
            $table->integer('kilometros');
            $table->timestamps();

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
        Schema::dropIfExists('actualizacion_km_vehiculos');
    }
}
