<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominasTiendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominas_tienda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_asesor');
            $table->integer('mes');
            $table->integer('asesor_mes');
            $table->integer('id_consideracion')->nullable();
            $table->string('detalles_consideracion')->nullable();
            $table->string('estado_consideracion')->nullable();
            $table->string('comentarios_consideracion')->nullable();
            $table->string('motivo_inactivacion')->nullable();
            $table->string('detalles_inactivacion')->nullable();
            $table->string('estado_inactivacion')->nullable();
            $table->string('comentarios_inactivacion')->nullable();
            $table->string('regularizacion_consideracion')->nullable();
            $table->string('regularizacion_inactivacion')->nullable();
            $table->string('fecha_aprobacion_consideracion')->nullable();
            $table->string('fecha_aprobacion_inactivacion')->nullable();
            $table->string('porcentaje_objetivo')->nullable()->default('100%');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nominas_tienda');
    }
}
