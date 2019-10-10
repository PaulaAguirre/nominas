<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonasTiendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zonas_tienda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_region');
            $table->string('zona');
            $table->string('estado')->nullable();
            $table->integer('representante_zonal_ch')->nullable();
            $table->string('representante_zonal_nombre')->nullable();
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
        Schema::dropIfExists('zonas_tienda');
    }
}
