<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdentrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordentrabajo', function (Blueprint $table) {
            $table->bigIncrements('idordentrabajo');
            $table->string('codigo')->unique();
            $table->boolean('condicion')->default(0); // En proceso
            $table->decimal('precio', 11, 2);
            $table->unsignedBigInteger('idrevision');
            $table->foreign('idrevision')->references('id')->on('revisiones');
            $table->date('fechaorden');
            $table->string('zonaventa');
            $table->unsignedBigInteger('asesorventas')->unsigned();
            $table->foreign('asesorventas')->references('id')->on('users');
            $table->integer('idproducto');
            $table->bigInteger('aprobado_por')->nullable();
            $table->boolean('tipo_contrato')->default(0);
            $table->string('titulo_coautoria',255);
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
        Schema::dropIfExists('ordentrabajo');
    }
}
