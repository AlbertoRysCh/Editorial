<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('status')->insert(array('id'=>'1','nombre'=>'Enviado a la revista','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'2','nombre'=>'Revisión','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'3','nombre'=>'Por Redireccionar','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'4','nombre'=>'Aceptado','descripcion'=>'En espera de publicación'));
        DB::table('status')->insert(array('id'=>'5','nombre'=>'Publicado','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'6','nombre'=>'Redireccionado','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'7','nombre'=>'Ajustes de Árbitro','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'8','nombre'=>'En Espera de Habilitación','descripcion'=>'Terminado pero debe venderse responsabilidad de ventas'));
        DB::table('status')->insert(array('id'=>'9','nombre'=>'En espera de cartas/firmas','descripcion'=>'Responsabilidad de Ventas'));
        DB::table('status')->insert(array('id'=>'10','nombre'=>'Falta de Datos de Investigación','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'11','nombre'=>'Habilitado para Envío','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'12','nombre'=>'En Proceso','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'13','nombre'=>'No asignados','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'14','nombre'=>'Culminado por Asesor','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'15','nombre'=>'Aceptado con Ajuste de Revista','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'16','nombre'=>'Evaluación por Pares','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'17','nombre'=>'Revisión Interna','descripcion'=>'Sin descripción'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
