<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoSupervisorToSupervisorGuiatigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supervisor_guiatigo', function (Blueprint $table) {
            $table->string('tipo_supervisor')->nullable()->after('documento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supervisor_guiatigo', function (Blueprint $table) {
            //
        });
    }
}
