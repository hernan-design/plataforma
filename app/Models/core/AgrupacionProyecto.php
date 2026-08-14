<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB, Input, Auth, App, TuProyecto;

class AgrupacionProyecto extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.agrupacion_proyecto';

	public $incrementing = false;

	public $timestamps = false;

	public static function getClustersProject()
   	{
   		$clusters = [];
   		if(Input::has('codigo_proyecto')) {
			$query = AgrupacionProyecto::query();
			$query->select('proyecto.codigo_usuario', 'agrupacion_proyecto.codigo_proyecto','proyecto.nombre_proyecto','proyecto.imagen_proyecto','proyecto.url_proyecto','agrupacion_proyecto.cor_codigo_proyecto');
			$query->join('core.proyecto', 'agrupacion_proyecto.cor_codigo_proyecto', '=', 'proyecto.codigo_proyecto');	
			
			// Decrypt src-params
			list($codigo_proyecto) = TuProyecto::decryptSrcParams(Input::get('codigo_proyecto'));
			if(!$codigo_proyecto || !is_numeric($codigo_proyecto)) {
				App::abort(403);
			}

			$query->where('agrupacion_proyecto.codigo_proyecto', $codigo_proyecto);
			$query->where('agrupacion_proyecto.codigo_estado', Estado::getState('active'));

			// Get count posts 
			$total_entries = $query->count();

			// Get posts
			$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

			if(count($data) > 0) {
				foreach ($data as $clusterProject) {
					$clusters[] = AgrupacionProyecto::buildClusterProject($clusterProject);
				}
			}

			$response = new \stdClass();
			$response->total_entries = $total_entries;
			$response->items = $clusters;
	   		return $response;
		}
		return $clusters;
   	}

   	/**
	 * Build ClusterProject.
	 */
   	public static function buildClusterProject($clusterProject)
   	{
		$object = new \stdClass();
		$object->codigo_proyecto = TuProyecto::encryptSrcParams([$clusterProject->codigo_proyecto]);
		$object->cor_codigo_proyecto = $clusterProject->cor_codigo_proyecto;
		$object->nombre_proyecto = $clusterProject->nombre_proyecto;
		$object->imagen_proyecto = $clusterProject->imagen_proyecto;
		$object->url_proyecto = $clusterProject->url_proyecto;
		$object->owner = (Auth::check() && in_array(Auth::user()->codigo_usuario, [$clusterProject->owner])) ? true : false;
		return $object;
   	}


   	public static function addJoinGroup($project)
   	{
		// Verify User Group
		$userGroup = AgrupacionProyecto::where('codigo_proyecto', $project->codigo_proyecto)->where('codigo_usuario', Auth::user()->codigo_usuario)->first();
		if ($userGroup instanceof AgrupacionProyecto ) {
			AgrupacionProyecto::where('codigo_proyecto', $userGroup->codigo_proyecto)->where('codigo_usuario', Auth::user()->codigo_usuario)
			->update(['codigo_estado' => Estado::getState('active')]);
		}else{
			$groupProject = new AgrupacionProyecto;
			$groupProject->codigo_proyecto = $project->codigo_proyecto;
            $groupProject->codigo_usuario = Auth::user()->codigo_usuario;
            $groupProject->codigo_estado = Estado::getState('active');
            $groupProject->save();
		}
   	}

   	public static function cancelJoinGroup($project){
   		// Set removed grupo proyecto
		AgrupacionProyecto::where('codigo_usuario', Auth::user()->codigo_usuario)->where('codigo_proyecto', $project->codigo_proyecto)
			->update(['codigo_estado' => Estado::getState('removed')]);
   	}
}
