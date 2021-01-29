<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateRevistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revistas', function (Blueprint $table) {
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
        DB::table('revistas')->insert(array(
            'id'=>'1',
            'codigo'=>'R0001',
            'nombre'=>'Revista Telos',
            'descripcion'=>'WOS',
            'lineaInvestigacion'=>'Gestión, comunicación, educación, ingeniería y der...',
            'idioma'=>'Español',
            'pais'=>'VENEZUELA',
            'enlace'=>'http://ojs.urbe.edu/index.php/telos',
            'idperiodo'=>2,
            'idnivelindex'=>2,
            'condicion'=>1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()));
        DB::table('revistas')->insert(array(
            'id'=>'2',
            'codigo'=>'R0002',
            'nombre'=>'Revista Cubana de Salud Pública',
            'descripcion'=>'Q4',
            'lineaInvestigacion'=>'Salud',
            'idioma'=>'Español',
            'pais'=>'CUBA',
            'enlace'=>'http://www.revsaludpublica.sld.cu/index.php/spu',
            'idperiodo'=>1,
            'idnivelindex'=>1,
            'condicion'=>1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()));
        DB::table('revistas')->insert(array(
            'id'=>'3',
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
        Schema::dropIfExists('revistas');
    }
}
