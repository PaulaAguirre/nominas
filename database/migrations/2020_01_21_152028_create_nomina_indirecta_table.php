<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominaIndirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina_indirecta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mes');
            $table->integer('impulsador_id');
            $table->integer('impulsador_mes');
            $table->integer('consideracion_id')->nullable();
            $table->string('estado_consideracion')->nullable();
            $table->string('detalles_consideracion')->nullable();
            $table->string('comentarios_consideracion')->nullable();
            $table->string('motivo_inactivacion')->nullable();
            $table->string('detalles_inactivacion')->nullable();
            $table->string('comentarios_inactivacion')->nullable();
            $table->string('fecha_aprobacion_consideracion')->nullable();
            $table->string('fecha_aprobacion_inactivacion')->nullable();
            $table->string('porcentaje_objetivo')->default('100%')->nullable();

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
        Schema::dropIfExists('nomina_indirecta');
    }
}
