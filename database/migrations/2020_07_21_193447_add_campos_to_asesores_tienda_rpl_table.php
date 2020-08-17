<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToAsesoresTiendaRplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asesores_tienda_rpl', function (Blueprint $table) {

            $table->string('agrupacion')->nullable();
            $table->integer('zonal2_id')->nullable();
            $table->integer('supervisor_retencion_id')->nullable();
            $table->integer('tl_retencion_call_id')->nullable();
            $table->integer('rac_retencion_tienda_id')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asesores_tienda_rpl', function (Blueprint $table) {
            //
        });
    }
}
