<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, DB;

use App\Models;

class ClaseEmprendimiento extends Model {

	protected $table = 'core.clase_emprendimiento';

	protected $primaryKey = 'codigo_clase_emprendimiento';

	public $timestamps = false;

	public static function getClass($class) {
		switch ($class) :
			case 'idea': return 1;
			case 'entrepreneurship': return 2;
			case 'group': return 3;
			case 'company': return 4;
			default: return 'Not class identified';
		endswitch;
	}

	public static function getTypeClass($class) {
		switch ($class) :
			case 'idea': return 1;
			case 'project': return 2;
			case 'group': return 3;
			case 'company': return 4;
			case 'entrepreneurship': return 5;
			default: return 'Not class identified';
		endswitch;
	}

	public static function getClasses()
	{
		$cache = sprintf('_%s_%s', 'classes_project', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() {
            $query = ClaseEmprendimiento::query();
            $query->select('clase_emprendimiento_insti.codigo_clase_empre_insti', DB::raw('COALESCE(clase_emprendimiento_insti.nombre_clase_empren_insti, clase_emprendimiento.nombre_clase_emprendimiento) AS class_name'));
			$query->join('core.clase_emprendimiento_insti', function($join) {
				$join->on('clase_emprendimiento.codigo_clase_emprendimiento', '=', 'clase_emprendimiento_insti.codigo_clase_emprendimiento')
					->where('clase_emprendimiento_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('clase_emprendimiento_insti.codigo_estado', '=', Estado::getState('active'));
			});

			$query->orderby('nombre_clase_emprendimiento', 'asc');
			return $query->get();
		});
	}

	public static function getClassEntity()
	{
		$cache = sprintf('_%s_%s', 'class_entity', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() {
			$query = ClaseEmprendimiento::query();
			$query->select('clase_emprendimiento.*', DB::raw('COALESCE(clase_emprendimiento_insti.descripcion_clase_emprendimiento, clase_emprendimiento.descripcion_clase_emprendimiento) AS descripcion_clase_emprendimiento'));
			$query->join('core.clase_emprendimiento_insti', function($join) {
				$join->on('clase_emprendimiento.codigo_clase_emprendimiento', '=', 'clase_emprendimiento_insti.codigo_clase_emprendimiento')
					->where('clase_emprendimiento_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('clase_emprendimiento_insti.codigo_estado', '=', Estado::getState('active'));
			});
			return $query->get();
		});
	}
}
