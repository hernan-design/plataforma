<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use App\Estado, App\RegistroSesion;

class CategoriaProyecto extends Model {

    protected $table = 'core.categoria_proyecto';

    protected $primaryKey = 'codigo_categoria_proyecto';

    public $timestamps = false;

    public static function getCategories()
    {
        $query = CategoriaProyecto::query();
        $query->select('codigo_categoria_proyecto', 'nombre_categoria_proyecto');
        $query->where('codigo_estado', Estado::getState('active'));
        $query->where('codigo_institucion', RegistroSesion::getInstitution());
        $query->orderby('nombre_categoria_proyecto', 'asc');
        return $query->pluck('nombre_categoria_proyecto', 'codigo_categoria_proyecto')->toArray();
    }

    public static function getCategoriesList()
    {
        $query = CategoriaProyecto::query();
        $query->select('codigo_categoria_proyecto as key', 'nombre_categoria_proyecto as value');
        $query->where('codigo_estado', Estado::getState('active'));
        $query->where('codigo_institucion', RegistroSesion::getInstitution());
        $query->orderby('nombre_categoria_proyecto', 'asc');
        return $query->get();
    }
}
