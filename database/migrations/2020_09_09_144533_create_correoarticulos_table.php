<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreoarticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correoarticulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idautor')->unsigned();
            $table->foreign('idautor')->references('id')->on('autores');
            $table->string('correo');
            $table->string('contraseña');
            $table->string('celularrelacionado');
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
        Schema::dropIfExists('correoarticulos');
    }
}
