<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idarticulo');
            $table->foreign('idarticulo')->references('id')->on('articulos');
            $table->unsignedBigInteger('idasesor')->unsigned();
            $table->foreign('idasesor')->references('id')->on('asesors');
            $table->unsignedBigInteger('idclasificacion');
            $table->foreign('idclasificacion')->references('id')->on('clasificaciones');
            $table->longText('titulo')->nullable();
            $table->date('fechaOrden')->nullable();
            $table->date('fechaLlegada')->nullable();
            $table->date('fechaAsignacion')->nullable();
            $table->date('fechaCulminacion')->nullable();
            $table->date('fechaRevisionInterna')->nullable();
            $table->date('fechaEnvioPro')->nullable();
            $table->date('fechaHabilitacion')->nullable();
            $table->date('fechaEnvio')->nullable();
            $table->date('fechaAjustes')->nullable();
            $table->date('fechaAceptacion')->nullable();
            $table->date('fechaRechazo')->nullable();
            $table->unsignedBigInteger('idstatu');
            $table->foreign('idstatu')->references('id')->on('status');
            $table->unsignedBigInteger('idrevista');
            $table->foreign('idrevista')->references('id')->on('revistas');
            $table->string('usuario')->nullable();
            $table->string('contrasenna')->nullable();
            $table->string('archivo')->nullable();
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historiales');
    }
}
