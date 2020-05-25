<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpulsadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impulsadores;', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ch');
            $table->string('fecha_ingreso')->nullable();
            $table->string('nombre');
            $table->integer('documento');
            $table->integer('coordinador_id');
            $table->integer('zona_id');
            $table->integer('coordinador_anterior_id')->nullable();
            $table->string('fecha_cambio_coordinador')->nullable();
            $table->string('activo')->default('ACTIVO')->nullable();
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
        Schema::dropIfExists('impulsadores;');
    }
}
