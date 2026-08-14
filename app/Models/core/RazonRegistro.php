<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Cache;

class RazonRegistro extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.razon_registro';

   	protected $primaryKey = 'codigo_razon_registro';

    public static function getReasons()
    {
        if (Cache::has('_get_reasons_register')) {
            return Cache::get('_get_reasons_register');    
        }

        return Cache::rememberForever('_get_reasons_register', function() {

            $razones_institucion = "";

            $query = RazonRegistro::query();
            $query->select('razon_registro.codigo_razon_registro', 'nombre_razon_registro');            
            $query->join('param.razones_institucion as ri', function($join) {
                $join->on('razon_registro.codigo_razon_registro', '=', 'ri.codigo_razon_registro')
                    ->where('ri.codigo_institucion', '=', RegistroSesion::getInstitution())
                    ->where('ri.codigo_estado', '=', Estado::getState('active'));
            });
            $query->orderby('nombre_razon_registro', 'asc');
            $razones_institucion = $query->pluck('nombre_razon_registro', 'codigo_razon_registro')->toArray();

            if(count($razones_institucion) == 0){
                $query = RazonRegistro::query();
                $query->select('codigo_razon_registro', 'nombre_razon_registro');
                $query->orderby('nombre_razon_registro', 'asc');
                $razones_institucion = $query->pluck('nombre_razon_registro', 'codigo_razon_registro')->toArray();  
            }
            return $razones_institucion;
            
        });
    }
}
