<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonasIndirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zonas_indirecta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('region_id');
            $table->integer('familia_zona_id');
            $table->string('representante_zonal_nombre');
            $table->integer('representante_zonal_ch');
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
        Schema::dropIfExists('zonas_indirecta');
    }
}
