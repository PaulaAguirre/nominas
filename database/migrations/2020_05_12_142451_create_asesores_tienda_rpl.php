<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsesoresTiendaRpl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesores_tienda_rpl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mes');
            $table->integer('anterior_id');
            $table->integer('id_teamleader');
            $table->integer('ch');
            $table->string('documento')->nullable();
            $table->string('nombre');
            $table->string('activo')->nullable();
            $table->string('staff')->nullable();
            $table->integer('id_tienda');
            $table->string('fecha_ingreso')->nullable();
            $table->integer('id_anterior_teamleader')->nullable();
            $table->string('cargo_go')->nullable();
            $table->integer('id_tienda_anterior')->nullable();
            $table->string('cargo_anterior')->nullable();
            $table->string('user_red')->nullable();
            $table->string('especialista')->nullable();
            $table->integer('supervisor_guiatigo_id')->nullable();
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
        Schema::dropIfExists('asesores_tienda_rpl');
    }
}
