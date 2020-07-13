<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTlsRetencionCallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tls_retencion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ch');
            $table->string('documento')->nullable();
            $table->string('nombre');
            $table->integer('clasificacion_retencion_id')->nullable();
            $table->string('canal')->nullable();
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
        Schema::dropIfExists('tls_retencion_call');
    }
}
