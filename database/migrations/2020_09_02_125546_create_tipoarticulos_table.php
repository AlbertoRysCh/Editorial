<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoarticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoarticulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('tipoarticulos')->insert(array('id'=>'1','nombre'=>'Producción Foránea','descripcion'=>'Material de afuera'));
        DB::table('tipoarticulos')->insert(array('id'=>'2','nombre'=>'Innova Colaboradores','descripcion'=>'Coautoría'));
        DB::table('tipoarticulos')->insert(array('id'=>'3','nombre'=>'Innova Scientific Interno','descripcion'=>'Artículos desde cero'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoarticulos');
    }
}
