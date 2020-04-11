<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominaDirectaRplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina_directa_rpl', function (Blueprint $table) {
            $table->increments('id_nomina');
            $table->integer('id_persona_directa');
            $table->integer('mes');
            $table->string('persona_mes');
            $table->string('estado_nomina')->nullable();
            $table->string('motivo_rechazo')->nullable();
            $table->integer('id_consideracion')->nullable();
            $table->string('detalles_consideracion')->nullable();
            $table->string('motivo_rechazo_consideracion')->nullable();
            $table->string('estado_consideracion')->nullable();
            $table->string('activo')->nullable();
            $table->string('agrupacion')->nullable();
            $table->string('agrupacion_anterior')->nullable();
            $table->string('regularizacion')->nullable();
            $table->string('regularizacion_consideracion')->nullable();
            $table->string('regularizacion_nomina')->nullable();
            $table->string('motivo_inactivacion')->nullable();
            $table->string('detalles_inactivacion')->nullable();
            $table->string('estado_inactivacion')->nullable();
            $table->string('regularizacion_inactivacion')->nullable();
            $table->string('motivo_rechazo_inactivacion')->nullable();
            $table->string('comentario_consideracion')->nullable();
            $table->string('comentario_inactivacion')->nullable();
            $table->string('fecha_aprobacion_consideracion')->nullable();
            $table->integer('porcentaje_id')->nullable();
            $table->string('porcentaje_objetivo')->nullable();
            $table->string('fecha_carga_consideracion')->nullable();
            $table->string('fecha_carga_inactivacion')->nullable();

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
        Schema::dropIfExists('nomina_directa_rpl');
    }
}
