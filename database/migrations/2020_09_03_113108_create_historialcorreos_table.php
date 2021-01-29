<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialcorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historialcorreos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idarticulos');
            $table->foreign('idarticulos')->references('id')->on('articulos');  
            $table->integer('idautor')->unsigned();
            $table->foreign('idautor')->references('id')->on('autores');
            $table->string('archivo');
            $table->date('fecha_correo');
            $table->longText('observacion')->nullable();
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
        Schema::dropIfExists('historialcorreos');
    }
}
