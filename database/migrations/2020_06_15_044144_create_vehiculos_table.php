<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->integer('anio');
            $table->string('dominio');
            $table->decimal('costo_mensual_imp_automotor', 10, 2)->nullable();
            $table->integer('dia_del_mes_debito_imp_automotor')->nullable();
            $table->foreignId('id_proveedor_seguro')->nullable();
            $table->decimal('costo_mensual_seguro', 10, 2)->nullable();
            $table->integer('dia_del_mes_debito_seguro')->nullable();
            $table->integer('kms_cada_service')->nullable();
            $table->integer('kms_cada_cambio_bujias')->nullable();
            $table->integer('kms_cada_rotacion_cubiertas')->nullable();
            $table->integer('kms_cada_cambio_cubiertas')->nullable();
            $table->integer('kms_cada_cambio_correa_distr')->nullable();
            $table->date('fecha_vto_vtv')->nullable();
            $table->date('fecha_vto_oblea_gnc')->nullable();
            $table->integer('kilometraje_prediccion_actual');
            $table->timestamps();


            $table->foreign('id_proveedor_seguro')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
