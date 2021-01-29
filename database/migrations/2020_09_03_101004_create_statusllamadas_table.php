<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statusllamadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });

        DB::table('statusllamadas')->insert(array('id'=>'1','nombre'=>'Interesado','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'2','nombre'=>'No interesado','descripcion'=>'Sin descripción'));
    
        DB::table('statusllamadas')->insert(array('id'=>'3','nombre'=>'Indeciso','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'4','nombre'=>'Teléfono Incorrecto','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'5','nombre'=>'No responde','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'6','nombre'=>'Cobranza','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'7','nombre'=>'Pendiente de Manuscrito','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'8','nombre'=>'Pendiente Datos Clientes','descripcion'=>'Sin descripción'));
        DB::table('statusllamadas')->insert(array('id'=>'9','nombre'=>'Confirmación de Contrato','descripcion'=>'Sin descripción'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_llamadas');
    }
}
