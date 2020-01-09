<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaCargaConsideracionToNominaDirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomina_directa', function (Blueprint $table) {
            $table->string('fecha_carga_consideracion')->nullable();
            $table->string('fecha_carga_inactivacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomina_directa', function (Blueprint $table) {
            //
        });
    }
}
