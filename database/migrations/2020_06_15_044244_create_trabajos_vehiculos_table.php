<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->boolean('es_trabajo_previo')->default(false);
            $table->date('fecha_pagado');
            $table->foreignId('id_vehiculo');
            $table->integer('kms_vehiculo_estimados')->nullable();
            $table->string('tipo');
            $table->string('observaciones')->nullable();
            $table->foreignId('id_proveedor')->nullable();
            $table->decimal('costo_total', 10, 2);
            $table->string('medio_pago');
            $table->date('fecha_realizado')->nullable();
            $table->timestamps();

            $table->foreign('id_vehiculo')->references('id')->on('vehiculos');
            $table->foreign('id_proveedor')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos_vehiculos');
    }
}
