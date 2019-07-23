<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasDirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas_directa', function (Blueprint $table) {
            $table->Increments('id_persona');
            $table->string('ch')->unique();
            $table->string('fecha_ingreso');
            $table->string('documento_persona')->nullable();
            $table->string('nombre');
            $table->integer('id_representante_jefe')->nullable();
            $table->string('cargo');
            $table->integer('id_zona')->nullable();
            $table->string('cargo_go')->nullable();
            $table->string('agrupacion')->nullable();
            $table->string('activo')->nullable()->default('A');
            $table->string('estado_cambio')->nullable()->default('aprobado');
            $table->string('motivo_rechazo')->nullable();
            $table->string('regularizacion_cambio')->nullable();
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
        Schema::dropIfExists('personas_directa');
    }
}
