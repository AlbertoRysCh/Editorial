<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',30)->unique();
            $table->string('descripcion',100)->nullable();
            $table->boolean('condicion')->default(1);
        });

        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador','descripcion'=>'Administrador'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Community manager','descripcion'=>'Community manager'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Jefe de ventas','descripcion'=>'Jefe de ventas'));
        DB::table('roles')->insert(array('id'=>'4','nombre'=>'Vendedor','descripcion'=>'Vendedor'));
        DB::table('roles')->insert(array('id'=>'5','nombre'=>'Teleoperador','descripcion'=>'Teleoperador'));
        DB::table('roles')->insert(array('id'=>'6','nombre'=>'Repartidor','descripcion'=>'Repartidor'));
        DB::table('roles')->insert(array('id'=>'7','nombre'=>'Jefe de operaciones','descripcion'=>'Jefe de operaciones'));
        DB::table('roles')->insert(array('id'=>'8','nombre'=>'Gerente comercial','descripcion'=>'Gerente comercial'));
        DB::table('roles')->insert(array('id'=>'9','nombre'=>'No asignado','descripcion'=>'No asignado'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
