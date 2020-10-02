<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('botones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('habilitar_directa')->nullable();
            $table->string('habilitar_tiendas')->nullable();
            $table->string('habilitar_indirecta')->nullable();
            $table->string('habilitar_directa_anterior')->nullable();
            $table->string('habilitar_tiendas_anterior')->nullable();
            $table->string('habilitar_indirecta_anterior')->nullable();

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
        Schema::dropIfExists('botones');
    }
}
