<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use Auth, Validator;

class TareaMentoria extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.tarea_mentoria';

	protected $primaryKey = 'codigo_tarea_mentoria';

	public $timestamps = false;

	public function isValid($data)
    {
        $rules = array(
            'codigo_mentoria' => 'required',
            'descripcion_tarea_mentoria' => 'required|max:1200|string'
        );

		$messages = [
			'descripcion_tarea_mentoria.max' => 'Se ha excedido la cantidad de palabras para el campo <b>Acuerdos/Plan de acción</b> Máximo :max  caracteres',
		];

     	$validator = Validator::make($data, $rules, $messages);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	public static function getTasksMentoring($mentoring)
   	{
		$taskMentoring = [];
		$query = TareaMentoria::query();
		$query->select('tarea_mentoria.codigo_tarea_mentoria', 'tarea_mentoria.descripcion_tarea_mentoria','estado.nombre_estado','mentoria.seg_codigo_usuario as mentor');
		$query->join('core.estado', 'tarea_mentoria.codigo_estado', '=', 'estado.codigo_estado');
		$query->join('aprende.mentoria', 'tarea_mentoria.codigo_mentoria', '=', 'mentoria.codigo_mentoria');
		$query->where('tarea_mentoria.codigo_mentoria', '=', $mentoring);
		$query->where('tarea_mentoria.codigo_estado', '=', Estado::getState('active'));

		// Get posts
		$query->orderBy('tarea_mentoria.codigo_tarea_mentoria', 'asc');
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $task) {
				$tarea = new \stdClass();
				$tarea->codigo_tarea_mentoria = TuProyecto::encryptSrcParams([$task->codigo_tarea_mentoria]);
				$tarea->descripcion_tarea_mentoria = $task->descripcion_tarea_mentoria;
				$tarea->nombre_estado = $task->nombre_estado;
				$tarea->mentor = Auth::user()->codigo_usuario == $task->mentor ? true : false;
				$tarea->item = $task->codigo_tarea_mentoria;
				$taskMentoring[] = $tarea;
			}
		}
   		return $taskMentoring;
   	}

   /**
   * Build Task Mentoring.
   */

   	public static function buildTaskMentoring($taskMentoring, $usermentoring)
   	{
		$object = new \stdClass();
		$object->codigo_tarea_mentoria = TuProyecto::encryptSrcParams([$taskMentoring->codigo_tarea_mentoria]);
		$object->descripcion_tarea_mentoria = $taskMentoring->descripcion_tarea_mentoria;
		$object->codigo_mentoria = $taskMentoring->codigo_mentoria;
		$object->mentor = Auth::user()->codigo_usuario == $usermentoring ? true : false;
		$object->item = $taskMentoring->codigo_tarea_mentoria;
		return $object;
   	}

}
