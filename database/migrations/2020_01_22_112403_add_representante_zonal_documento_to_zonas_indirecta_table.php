<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepresentanteZonalDocumentoToZonasIndirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zonas_indirecta', function (Blueprint $table) {
            $table->integer('representante_zonal_documento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zonas_indirecta', function (Blueprint $table) {
            //
        });
    }
}
