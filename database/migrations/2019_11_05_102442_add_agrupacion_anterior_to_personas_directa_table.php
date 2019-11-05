<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgrupacionAnteriorToPersonasDirectaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas_directa', function (Blueprint $table) {
            $table->string('agrupacion_anterior')->nullable()->after('agrupacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas_directa', function (Blueprint $table) {
            //
        });
    }
}
