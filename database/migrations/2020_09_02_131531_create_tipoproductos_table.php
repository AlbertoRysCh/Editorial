<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoproductos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
        });
        DB::table('tipoproductos')->insert(array('id'=>'1','nombre'=>'No Asignado','descripcion'=>'Sin descripción'));
        DB::table('tipoproductos')->insert(array('id'=>'2','nombre'=>'Artículo','descripcion'=>'Sin descripción'));
        DB::table('tipoproductos')->insert(array('id'=>'3','nombre'=>'Editorial','descripcion'=>'Sin descripción'));
        DB::table('tipoproductos')->insert(array('id'=>'4','nombre'=>'Investigacion','descripcion'=>'Sin descripción'));
        DB::table('tipoproductos')->insert(array('id'=>'5','nombre'=>'Academia','descripcion'=>'Sin descripción'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoproductos');
    }
}
