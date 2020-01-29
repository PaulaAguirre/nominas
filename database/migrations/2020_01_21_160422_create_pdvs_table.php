<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdvs;', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pdv');
            $table->string('nombre');
            $table->integer('circuito_id');
            $table->integer('circuito_anterior_id')->nullable();
            $table->string('fecha_cambio_circuito')->nullable();
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
        Schema::dropIfExists('pdvs;');
    }
}
