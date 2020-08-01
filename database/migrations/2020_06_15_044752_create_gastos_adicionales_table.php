<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosAdicionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos_adicionales', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tipo');
            $table->string('detalle')->nullable();
            $table->foreignId('id_vehiculo')->nullable();
            $table->decimal('monto', 10, 2);
            $table->string('medio_pago');
            $table->foreignId('id_proveedor')->nullable();
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
        Schema::dropIfExists('gastos_adicionales');
    }
}
