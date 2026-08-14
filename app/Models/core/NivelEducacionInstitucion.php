<?php

namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use App\Estado, App\RegistroSesion;

class NivelEducacionInstitucion extends Model {

    protected $table = 'core.nivel_educacion_institucion';

   	protected $primaryKey = 'codigo_nivel_educacion_institucion';

    public static function getLevelEducation()
    {
            $query = NivelEducacionInstitucion::query();
            $query->select('nivel_educacion.codigo_nivel_educacion', 'nombre_nivel_educacion');
            $query->join('core.nivel_educacion', 'nivel_educacion.codigo_nivel_educacion', '=', 'nivel_educacion_institucion.codigo_nivel_educacion');
            $query->where('codigo_estado', Estado::getState('active'));
            $query->where('codigo_institucion', RegistroSesion::getInstitution());
            return $query->get();
    }
}
