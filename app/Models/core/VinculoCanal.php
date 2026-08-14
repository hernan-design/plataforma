<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB, Auth;

class VinculoCanal extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.vinculo_canal';

   	protected $primaryKey = 'codigo_vinculo_canal';

	public $timestamps = false;

    public static function getType($type) {
        switch ($type) :
            case 'profession': return 1;
            case 'occupation': return 2;
            case 'education': return 3;
            default: return 'Not type identified';
        endswitch;
    }

	public static function getSuggestions()
	{		
		// Get Person
		$person = Auth::user()->persona;

		// Prepare response
		$suggestions = [];

		$query = self::query();
		$query->select(DB::raw('DISTINCT(codigo_canal)'));
		$query->join('core.tabla_vinculo_canal', 'tabla_vinculo_canal.codigo_tabla_vinculo_canal', '=', 'vinculo_canal.codigo_tabla_vinculo_canal');
		$query->where('codigo_institucion', RegistroSesion::getInstitution());
		$query->where('codigo_estado', Estado::getState('active'));
			
		$query->where(function ($query) use($person) {
			$query->where(function ($query) use($person) {
				$query->where('vinculo_canal.codigo_tabla_vinculo_canal', self::getType('profession'));
				$query->where('codigo_recurso', '=', $person->codigo_profesion_persona ?: 0);
			});

			if( $person->codigo_ocupacion_persona ) {
				$query->orWhere(function ($query) use($person) {
					$query->where('vinculo_canal.codigo_tabla_vinculo_canal', self::getType('occupation'));
					$query->where('codigo_recurso', '=', $person->codigo_ocupacion_persona);
				});
			}

			if( $person->codigo_nivel_educacion ) {
				$query->where(function ($query) use($person) {
					$query->where('vinculo_canal.codigo_tabla_vinculo_canal', self::getType('education'));
					$query->where('codigo_recurso', '=', $person->codigo_nivel_educacion);
				});
			}
		});
			
		if( $person->codigo_profesion_persona || $person->codigo_ocupacion_persona || $person->codigo_nivel_educacion) {
			$suggestions = $query->pluck('codigo_canal')->toArray();
		}

		return $suggestions;
	}
}
