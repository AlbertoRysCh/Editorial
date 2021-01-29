<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_llamadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idllamada')->unsigned();
            $table->foreign('idllamada')->references('id')->on('registrosllamadas');
            $table->unsignedBigInteger('idtipocontactos');
            $table->foreign('idtipocontactos')->references('id')->on('tipocontactos');
            $table->date('fecha_llamada');
            $table->string('duracion')->nullable();
            $table->longText('observacion')->nullable();
            $table->unsignedBigInteger('idstatus');
            $table->foreign('idstatus')->references('id')->on('statusllamadas');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_llamadas');
    }
}
