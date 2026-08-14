<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Input, Auth,  DB, Request, Cache, Log;

class Especialidad extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.especialidad';

   	protected $primaryKey = 'codigo_especialidad';

	public static function getSpecialty($specialty){
		switch ($specialty) {
			case 'other': return 16;
			default: return 'Not type user identified';
		}
	}

	public static function getSpecialties( $other = null )
    {
		$specialties = [];
		$cache = sprintf('_%s_%s', '_get_user_specialties_institution', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            $specialties = Cache::get($cache);
        }else{
	        $specialties = Cache::rememberForever($cache, function() {
	            $query = Especialidad::query();
	            $query->select('especialidad.codigo_especialidad', 'nombre_especialidad');
				$query->join('core.especialidad_institucion', function($join){
					$join->on('especialidad.codigo_especialidad', '=', 'especialidad_institucion.codigo_especialidad')
						->where('especialidad_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
				});
	            $query->orderby('nombre_especialidad', 'asc');
	            return $query->get();
	        });
		}

		if( $other == Especialidad::getSpecialty('other') ){
			return $specialties->filter(function ($item) use($other)
	        {
	            return $item->codigo_especialidad != $other;
	        })->pluck('nombre_especialidad', 'codigo_especialidad')->toArray();
		}
		return $specialties->pluck('nombre_especialidad', 'codigo_especialidad')->toArray();
	}
	
	/**
	 * @return array list of specialities for selector list
	 */
	public static function getSpecialtiesSelectorList(array $filters = []){
		$query = Especialidad::query();
		$query->select('especialidad.codigo_especialidad as id', 'nombre_especialidad as text');
		$query->where('codigo_estado', Estado::getState('active'));
		$query->join('core.especialidad_institucion', function($join){
			$join->on('especialidad.codigo_especialidad', '=', 'especialidad_institucion.codigo_especialidad')
				->where('especialidad_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});
        
		if(Input::has('id') ){
			$query->where("especialidad.codigo_especialidad", "=", Input::get('id'));
		}

		if(Input::has('q')) {
			$query->whereRaw("nombre_especialidad ilike '%".Input::get('q')."%'");
		}

		if(Input::has('dataId')) {
			$query->where("especialidad.codigo_especialidad", "=",Input::get('dataId'));
		}


		$query->orderby('nombre_especialidad','asc');
		$data = $query->limit( 50 )->get();
		$data = $query->get();

		return $data;
	}

}
