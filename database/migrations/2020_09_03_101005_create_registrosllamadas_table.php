<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosllamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrosllamadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idclientes')->unsigned();
            $table->foreign('idclientes')->references('id')->on('clientes');
            $table->unsignedBigInteger('iduser')->unsigned();
            $table->foreign('iduser')->references('id')->on('users');
            $table->unsignedBigInteger('idtipocontactos');
            $table->foreign('idtipocontactos')->references('id')->on('tipocontactos');
            $table->date('fecha_llamada');
            $table->string('duracion')->nullable();
            $table->longText('observacion')->nullable();
            $table->unsignedBigInteger('idstatus');
            $table->foreign('idstatus')->references('id')->on('statusllamadas');
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
        Schema::dropIfExists('registrollamadas');
    }
}
