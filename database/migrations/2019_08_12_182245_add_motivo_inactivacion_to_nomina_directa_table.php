<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMotivoInactivacionToNominaDirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomina_directa', function (Blueprint $table) {
            $table->string('motivo_inactivacion')->nullable();
            $table->string('detalles_inactivacion')->nullable();
            $table->string('estado_inactivacion')->nullable();
            $table->string('regularizacion_inactivacion')->nullable();

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
