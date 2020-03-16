<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasDirectaRplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas_directa_rpl', function (Blueprint $table) {
            $table->increments('id_persona');
            $table->integer('mes')->nullable();
            $table->integer('ch');
            $table->string('fecha_ingreso')->nullable();
            $table->string('documento_persona')->nullable();
            $table->string('nombre');
            $table->integer('id_representante_jefe')->nullable();
            $table->integer('id_representante_jefe_nuevo')->nullable();
            $table->string('cargo')->nullable();
            $table->integer('id_zona');
            $table->integer('id_zona_nuevo')->nullable();
            $table->string('cargo_go')->nullable();
            $table->string('agrupacion')->nullable();
            $table->string('activo')->nullable()->default('activo');
            $table->string('estado_cambio')->nullable()->default('aprobado');
            $table->string('motivo_rechazo')->nullable();
            $table->string('regularizacion_cambio')->nullable();
            $table->string('staff')->nullable();
            $table->integer('id_consideracion')->nullable();
            $table->string('detalles_consideracion')->nullable();
            $table->integer('id_responsable_cambio')->nullable();
            $table->string('agrupacion_anterior')->nullable();

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
        Schema::dropIfExists('personas_directa_rpl');
    }
}
