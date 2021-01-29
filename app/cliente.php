<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    //
    protected $table='clientes';

    protected $fillable = [
        'id','tipo_documento','num_documento','nombres','apellidos','correocontacto','telefono', 'correogmail', 'contrasena', 'resumen','orcid', 'universidad','orcid','idgrado','especialidad','condicion','autor','aviso_id','asesor_venta_id'];

        public function grados(){

            return $this->belongsTo('App\Grado');
        }

        public function revisiones(){

            return $this->hasMany('App\Revision');
        }
}
