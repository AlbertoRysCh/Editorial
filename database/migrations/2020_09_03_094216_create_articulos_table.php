<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->longText('titulo')->nullable();
            $table->integer('idarea')->unsigned();
            $table->foreign('idarea')->references('id')->on('areas');
            $table->unsignedBigInteger('idtipoarticulo');
            $table->foreign('idtipoarticulo')->references('id')->on('tipoarticulos');
            $table->unsignedBigInteger('idnivelarticulo');
            $table->foreign('idnivelarticulo')->references('id')->on('nivelesarticulos');
            $table->unsignedBigInteger('idasesor')->unsigned();
            $table->foreign('idasesor')->references('id')->on('asesors');
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
            $table->unsignedBigInteger('idclasificacion');
            $table->foreign('idclasificacion')->references('id')->on('clasificaciones');
            $table->unsignedBigInteger('idrevista');
            $table->foreign('idrevista')->references('id')->on('revistas');
            $table->unsignedBigInteger('idmodalidad');
            $table->foreign('idmodalidad')->references('id')->on('modalidades');
            $table->string('carta')->nullable();
            $table->string('usuario')->nullable();
            $table->string('contrasenna')->nullable();
            $table->string('pais')->nullable();
            $table->string('archivo')->nullable();
            $table->longText('observacion')->nullable();
            $table->boolean('condicion')->default(1);
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
        Schema::dropIfExists('articulos');
    }
}
