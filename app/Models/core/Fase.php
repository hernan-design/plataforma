<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models, App\RegistroSesion;

use Cache;

use TuProyecto;

use Request, View, Response, App, Lang, Log, DB, Input, Auth;

class Fase extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.fase';

   	protected $primaryKey = 'codigo_fase';

   	public static function getIdPhase($phase) {
    	switch ($phase) :
		    case 'general': return 1;
		    case 'one_challenge': return 134;
		    case 'two_challenge': return 137;
		    case 'three_challenge': return 138;
		    case 'four_challenge': return 139;
			case 'challenge_1.2': return 150;
			case 'empodera2020_register': return 249;
			case 'empodera2020_two': return 250;
			case 'empodera2020_1_2': return 251;
			case 'moment_3__Aldea20': return 255;
			case 'reto3_aldea20': return 271;
			default: return null;
		endswitch;
    }


   	public static function getRequirementProgram($program)
    {
        $cache = sprintf('_%s_%s', 'requirement_program', $program);
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() use ($program)  {
            $query = Fase::query();
            $query->select('requisito_convocatoria.codigo_requisito_convocatoria', 'nombre_requisito_convocatoria');
        	$query->join('core.requisito_fase','fase.codigo_fase', '=', 'requisito_fase.codigo_fase');
            $query->join('core.requisito_convocatoria','requisito_fase.codigo_requisito_convocatoria', '=', 'requisito_convocatoria.codigo_requisito_convocatoria');

            $query->where('fase.codigo_convocatoria', $program);
            $query->orderby('nombre_requisito_convocatoria','asc');
        	return $query->get();
        });
    }

	public static function getResourceOfPhase($convocatoria, $fase) {
		$query = Fase::query();
		$query->select('fase.*','adjunto_fase.*','adjunto.*','tipo_recurso_fase.*',
			DB::raw("afu.codigo_adjunto_fase_usuario IS  NOT NULL as  recurso_fase_completada")
			);
		$query->join('core.adjunto_fase', 'adjunto_fase.codigo_fase', '=', 'fase.codigo_fase');
		$query->join('core.adjunto', 'adjunto.codigo_adjunto', '=', 'adjunto_fase.codigo_adjunto');
		$query->leftjoin('core.tipo_recurso_fase', 'tipo_recurso_fase.codigo_tipo_recurso_fase', '=', 'adjunto_fase.codigo_tipo_recurso_fase');
		$query->leftjoin(DB::raw('(SELECT DISTINCT ON (codigo_adjunto_fase, adjunto_fase_usuario.codigo_usuario_institucion) codigo_adjunto_fase,adjunto_fase_usuario.codigo_adjunto_fase_usuario FROM core.adjunto_fase_usuario 
										JOIN core.usuario_institucion 
											ON usuario_institucion.codigo_usuario_institucion = adjunto_fase_usuario.codigo_usuario_institucion
									WHERE codigo_usuario = ' .  Auth::user()->codigo_usuario .  ' 
									AND usuario_institucion.codigo_institucion = ' .  RegistroSesion::getInstitution()  .   ')
               				as afu'),
			function($leftJoin)
			{
				$leftJoin->on('afu.codigo_adjunto_fase', '=', 'adjunto_fase.codigo_adjunto_fase');
			});
		$query->where('fase.codigo_convocatoria', '=', $convocatoria);
		$query->where('fase.codigo_fase', '=', $fase);
		$data = $query->get();
		$totalRecord = $data->count();

		if ($totalRecord > 0) {
			$collection = collect([]);
			foreach ($data as $item)
			{
				$obj =  new \stdClass();
				$obj->codigo_adjunto = $item->codigo_adjunto;
				$obj->codigo_tipo_adjunto = $item->codigo_tipo_adjunto;
				$obj->direccion_adjunto = $item->direccion_adjunto;
				$obj->nombre_adjunto = $item->nombre_adjunto;
				$obj->nombre_tipo_recurso_fase = $item->nombre_tipo_recurso_fase;
				$obj->icono_tipo_recurso_fase = $item->icono_tipo_recurso_fase;
				$obj->recurso_fase_completada = $item->recurso_fase_completada;
				$obj->codigo_adjunto_fase = $item->codigo_adjunto_fase;
				$obj->descripcion_adjunto_fase = $item->descripcion_adjunto_fase;

				$collection->push($obj);
			}

			return $collection;
		} else {
			return null;
		}
	}

    /**
     * Defining Relations
    */
    public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }
}
