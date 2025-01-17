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
            $table->decimal('saldo_actual', 10, 2)->default(0);
            $table->foreignId('id_chofer');
            $table->foreignId('id_vehiculo');
            $table->boolean('descuento_semanal');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('id_chofer')->references('id')->on('choferes');
            $table->foreign('id_vehiculo')->references('id')->on('vehiculos');

        });

        Schema::table('vehiculos', function (Blueprint $table) {
            $table->foreign('id_alquiler_actual')->references('id')->on('alquileres');
        });

        Schema::table('choferes', function (Blueprint $table) {
            $table->foreign('id_alquiler_actual')->references('id')->on('alquileres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropForeign('vehiculos_id_alquiler_actual_foreign');
        });

        Schema::table('choferes', function (Blueprint $table) {
            $table->dropForeign('choferes_id_alquiler_actual_foreign');
        });


        Schema::dropIfExists('alquileres');
    }
}
