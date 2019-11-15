<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCargoJefeAnteriorToAsesoresTiendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asesores_tienda', function (Blueprint $table) {
            $table->integer('id_anterior_teamleader')->nullable()->after('id_teamleader');
            $table->string('cargo_anterior')->nullable()->after('cargo_go');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asesores_tienda', function (Blueprint $table) {
            //
        });
    }
}
