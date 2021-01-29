<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class CreateEditorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editoriales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->mediumText('lineaInvestigacion')->nullable();
            $table->string('idioma')->nullable();
            $table->string('pais')->nullable();
            $table->string('enlace')->nullable();
            $table->integer('idperiodo')->unsigned();
            $table->foreign('idperiodo')->references('id')->on('periocidades');
            $table->unsignedBigInteger('idnivelindex');
            $table->foreign('idnivelindex')->references('id')->on('niveles');
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('editoriales')->insert(array(
            'id'=>'1',
            'codigo'=>'R00000',
            'nombre'=>'Revista no asignada',
            'descripcion'=>'Falta asignar revista',
            'lineaInvestigacion'=>NULL,
            'idioma'=>NULL,
            'pais'=>NULL,
            'enlace'=>NULL,
            'idperiodo'=>2,
            'idnivelindex'=>4,
            'condicion'=>1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editoriales');
    }
}
