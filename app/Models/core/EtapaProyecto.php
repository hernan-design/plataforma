<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Input, Auth, Lang, URL, DB, Request, Cache, Log;

class EtapaProyecto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.etapa_proyecto';

   	protected $primaryKey = 'codigo_etapa_proyecto';

	public static function getStages()
    {
        $query = EtapaProyecto::query();
        $query->where('codigo_estado', Estado::getState('active'));
        $query->where('codigo_institucion', RegistroSesion::getInstitution());
        $query->orderby('codigo_etapa_proyecto','asc');
        return $query->get();
    }

    /**
	 * @return array list of stages for selector list
	 */
	public static function getStagesSelectorList(array $filters = []){
		$query = EtapaProyecto::query();
        $query->select('etapa_proyecto.codigo_etapa_proyecto as id', 'nombre_etapa_proyecto as text');
        $query->where('etapa_proyecto.codigo_institucion', '=',RegistroSesion::getInstitution());
		$query->where('etapa_proyecto.codigo_estado', '=', Estado::getState('active'));



		if(Input::has('id') ){
			$query->where("etapa_proyecto.codigo_etapa_proyecto", "=", Input::get('id'));
		}

		if(Input::has('q')) {
			$query->whereRaw("nombre_etapa_proyecto ilike '%".Input::get('q')."%'");
		}

		if(Input::has('dataId')) {
			$query->where("etapa_proyecto.codigo_etapa_proyecto", "=",Input::get('dataId'));
		}


		$query->orderby('nombre_etapa_proyecto','asc');
		$data = $query->limit( 50 )->get();
		$data = $query->get();

		return $data;
	}

    /**
    * Stages List.
    */
    public static function getStagesList()
    {
        $query = EtapaProyecto::query();
        $query->where('codigo_estado', Estado::getState('active'));
        $query->where('codigo_institucion', RegistroSesion::getInstitution());
        $query->orderby('codigo_etapa_proyecto','asc');
        return $query->pluck('nombre_etapa_proyecto','codigo_etapa_proyecto')->toArray();
    }
}
