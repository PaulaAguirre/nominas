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
            $table->string('aprobacion')->default('pendiente');
            $table->string('consideraciones')->nullable();
            $table->string('activo')->nullable();
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
