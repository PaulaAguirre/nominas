<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentantesXMesDirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representantes_x_mes_directa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_representante');
            $table->integer('año_mes');
            $table->integer('id_representante_jefe');
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
        Schema::dropIfExists('representantes_x_mes_directa');
    }
}
