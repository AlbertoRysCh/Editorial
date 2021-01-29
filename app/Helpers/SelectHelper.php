<?php
namespace App\Helpers;
 
class SelectHelper {

    public function __construct()
    {

        $this->tipo_documentos = (object)array(
            '0' => (object)['id' => 'RUC', 'nombre' => 'RUC'],
            '1' => (object)['id' => 'DNI', 'nombre' => 'DNI'],
            '2' => (object)['id' => 'CARNET DE EXTRANJERÍA', 'nombre' => 'CARNET DE EXTRANJERÍA'],
            '3' => (object)['id' => 'PASAPORTE', 'nombre' => 'PASAPORTE'],
            '4' => (object)['id' => 'OTRO', 'nombre' => 'OTRO']
        );

        $this->mes = (object)array(
            '0' => (object)['id' => '01', 'nombre' => 'Enero'],
            '1' => (object)['id' => '02', 'nombre' => 'Febrero'],
            '2' => (object)['id' => '03', 'nombre' => 'Marzo'],
            '3' => (object)['id' => '04', 'nombre' => 'Abril'],
            '4' => (object)['id' => '05', 'nombre' => 'Mayo'],
            '5' => (object)['id' => '06', 'nombre' => 'Junio'],
            '6' => (object)['id' => '07', 'nombre' => 'Julio'],
            '7' => (object)['id' => '08', 'nombre' => 'Agosto'],
            '8' => (object)['id' => '09', 'nombre' => 'Septiembre'],
            '9' => (object)['id' => '10', 'nombre' => 'Octubre'],
            '10' => (object)['id' => '11', 'nombre' => 'Noviembre'],
            '11' => (object)['id' => '12', 'nombre' => 'Diciembre'],
        );
        $this->estado_llamada = (object)array(
            '0' => (object)['id' => '1', 'nombre' => 'Pendiente'],
            '1' => (object)['id' => '2', 'nombre' => 'Realizada'],
            '2' => (object)['id' => '3', 'nombre' => 'Llamar luego']
        );

    }
    public function listTypeDoc() {       
        
        return $this->tipo_documentos;

    }

    public function listMeses() {       
        
        return $this->mes;

    }

    public function listEstadoLlamada() {       
        
        return $this->estado_llamada;

    }

}