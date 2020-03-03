<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClasificacionIdToImpulsadoresTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impulsadores', function (Blueprint $table) {
            $table->integer('clasificacion_id')->nullable()->after('fecha_cambio_coordinador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('impulsadores', function (Blueprint $table) {
            //
        });
    }
}
