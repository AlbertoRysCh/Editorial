<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->string('num_documento')->nullable();
            $table->string('nombres')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->boolean('condicion')->default(1);
            $table->unsignedBigInteger('idtipoproducto');
            $table->foreign('idtipoproducto')->references('id')->on('tipoproductos'); 
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
        Schema::dropIfExists('asesors');
    }
}
