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
            $table->string('documento_persona')->nullable();
            $table->string('nombre');
            $table->integer('id_representante_zonal')->nullable();
            $table->integer('id_presentante_jefe')->nullable();
            $table->string('cargo');
            $table->integer('id_region');
            $table->integer('id_zona');
            $table->string('cargo_go');
            $table->string('activo')->nullable()->default('A');
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
