<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasPendientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas_pendientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vehiculo')->nullable();
            $table->foreignId('id_chofer')->nullable();
            $table->date('fecha_a_realizar');
            $table->string('tipo');
            $table->string('tipo_trabajo_vehicular')->nullable(); // solo si tipo = "trabajo_veh_programado"
            $table->string('descripcion');
            $table->date('fecha_a_notificar');
            $table->boolean('notificado')->default(false);
            $table->timestamps();

            $table->foreign('id_vehiculo')->references('id')->on('vehiculos');
            $table->foreign('id_chofer')->references('id')->on('choferes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas_pendientes');
    }
}
