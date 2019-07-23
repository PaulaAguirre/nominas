<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominaDirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina_directa', function (Blueprint $table) {
            $table->increments('id_nomina');
            $table->integer('id_persona_directa');
            $table->integer('mes');
            $table->string('persona_mes')->unique();
            $table->string('estado_nomina')->default('pendiente');
            $table->string('motivo_rechazo')->nullable();
            $table->integer('id_consideracion')->nullable();
            $table->string('detalles_consideracion')->nullable();
            $table->string('motivo_rechazo_consideracion')->nullable();
            $table->string('estado_consideracion')->nullable();
            $table->string('activo')->nullable();
            $table->string('agrupacion')->nullable();
            $table->string('regularización')->nullable();
            $table->string('regularizacion_consideracion')->nullable();
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
        Schema::dropIfExists('nomina_directa');
    }
}
