<?php

use Illuminate\Support\Facades\Route;
// INICIO DE SESION
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'AuthController@index')->name('login.principal');
    Route::post('/login', 'AuthController@postLogin')->name('login');

    // REESTABLECER CONTRASEÑA
    Route::group([
        'prefix' => 'password'
    ], function () {
        Route::get('reset','ResetPasswordController@showFormReset')->name('password.reset');
        Route::post('email', 'ResetPasswordController@emailReset')->name('password.email');
        Route::get('reset/{token}', 'ResetPasswordController@showResetPassword');
        Route::post('resetpassword', 'ResetPasswordController@resetPassword')->name('resetpassword');
    });
});

Route::group(['middleware' => ['auth']], function () {

    // CIERRE DE SESION
    Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::get('edit-profile/{id}', 'UserController@editProfile')->name('edit.profile');
    Route::post('update-profile/{id}', 'UserController@updateProfile')->name('update.profile');
    Route::post('update-password', 'UserController@updatePassword')->name('update.password');
    // INICIO - PRINCIPAL
    Route::get('/inicio/{fecha_dia?}', 'InicioController@index')->name('inicio');
    Route::post('dynamic-date', 'InicioController@dynamicDate')->name('inicio.dynamic-date');
    // USUARIOS
    Route::resource('usuarios', 'UserController');
    Route::group([
        'prefix' => 'usuarios'
    ], function () {
    Route::post('indexTable', 'UserController@indexTable')->name('usuarios.indexTable');
    Route::get('act-desac/{id}', 'UserController@activarDesactivar')->name('usuarios.act.desac');
    Route::get('search-user-num-doc/{id}', 'UserController@searchUserNumDocumento')->name('search.user.numdoc');
    Route::get('search-username/{id}', 'UserController@searchUserName')->name('search.username');
    Route::get('search-useremail/{id}', 'UserController@searchUserEmail')->name('search.useremail');
    });

    // POSIBLES CLIENTES
    Route::group([
        'prefix' => 'posibles-clientes'
    ], function () {
    Route::get('/', 'PosibleClienteController@index')->name('posibles.clientes');
    Route::post('indexTable', 'PosibleClienteController@indexTable')->name('posibles.clientes.indexTable');
    Route::get('create', 'PosibleClienteController@create')->name('posibles.clientes.create');
    Route::post('store', 'PosibleClienteController@store')->name('posibles.clientes.store');
    Route::post('update/{id}', 'PosibleClienteController@update')->name('posibles.clientes.update');
    Route::get('edit/{id}', 'PosibleClienteController@edit')->name('posibles.clientes.edit');
    Route::get('gestionar-llamada/{id}', 'PosibleClienteController@gestionarLlamada')->name('gestionar.llamada');
    Route::post('gestionar-llamada', 'PosibleClienteController@actualizarLlamada')->name('actualizar.llamada');
    Route::get('get-vendedor/{distrito}', 'PosibleClienteController@getVendedor')->name('get.vendedor');
    Route::get('show/{id}', 'PosibleClienteController@show')->name('posibles.clientes.show');
    Route::get('search_client/{id}', 'PosibleClienteController@searchClient');
    Route::get('act-desac/{id}', 'PosibleClienteController@activarDesactivar')->name('posibles.clientes.act.desac');
    Route::get('visita/{id}', 'PosibleClienteController@visitaCliente')->name('posibles.clientes.visita');
    Route::post('exportar-excel/{fecha_inicio}/{fecha_fin}/{estado}/{estado_cliente}','PosibleClienteController@exportarExcel');
    });

    // LOGS DEL SISTEMA
    Route::get('log-systems', 'LogSystemController@index')->name('log-systems.index');
    Route::post('log-systems', 'LogSystemController@indexTable')->name('log-systems.indexTable');
    Route::post('log-systems/exportar-excel/{fecha_inicio}/{fecha_fin}/{estado}/{anio}/{search}','LogSystemController@exportarExcel');

    // CONFIGURACIONES
    Route::resource('configuraciones', 'ConfiguracionController');
    Route::group([
        'prefix' => 'configuraciones'
    ], function () {
    Route::post('indexTable', 'ConfiguracionController@indexTable')->name('configuraciones.indexTable');
    Route::get('act-desac/{id}', 'ConfiguracionController@activarDesactivar')->name('configuraciones.act.desac');
    });
    // MANTENIMIENTO
    Route::get('mantenimiento-show', 'ConfiguracionController@showMantenimiento')->name('configuraciones.mantenimiento-show');
    Route::get('mantenimiento-update/{value}', 'ConfiguracionController@updateMantenimiento')->name('configuraciones.updateMantenimiento');




    // REPORTES
    Route::group([
        'prefix' => 'reportes'
    ], function () {
        // VENDEDORES
    Route::get('vendedores', 'ReporteController@reporteVendedor')->name('reportes.vendedores');
    Route::post('vendedoresAjax', 'ReporteController@indexTable');
    Route::post('vendedores/excel/{fecha_inicio}/{fecha_fin}/{vendedor}/{anio}/{search}','ReporteController@exportarVendedores');

    });

    //PROSPECTOS
    Route::resource('prospecto', 'ProspectoController');
    //REGISTRO LLAMADA
    Route::resource('RegistrarLlamada', 'RegistrollamadaController');
});
