<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use Validator, Auth;

class TagsMentoria extends Model
{
    protected $table = 'aprende.tag_sesion_mentoria';

	protected $primaryKey = 'codigo_tag_sesion_mentoria';

	public $timestamps = false;

    public function isValid($data)
    {
        $rules = array(
            'codigo_mentoria' => 'required',
            'nombre_tag_sesion_mentoria' => 'required|string|words:1,200',
            'valor_tag_sesion_mentoria' => 'required|regex:[^[0-9]*$]|numeric'
        );

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    /**
     * Build Task Mentoring.
    */

    public static function buildTagsMentoring($tagsMentoring)
    {
        $object = new \stdClass();
        $object->codigo_tags_mentoria = TuProyecto::encryptSrcParams([$tagsMentoring->codigo_tag_sesion_mentoria]);
        $object->nombre_tag_sesion_mentoria = $tagsMentoring->nombre_tag_sesion_mentoria;
        $object->valor_tag_sesion_mentoria = $tagsMentoring->valor_tag_sesion_mentoria;
        $object->codigo_mentoria = $tagsMentoring->codigo_mentoria;
        $object->item = $tagsMentoring->codigo_tag_sesion_mentoria;

        return $object;
    }

    public static function getTagsMentoring($mentoring)
    {
		$tagsMentoring = [];
		$query = TagsMentoria::query();
		$query->select('tag_sesion_mentoria.codigo_tag_sesion_mentoria', 'tag_sesion_mentoria.codigo_mentoria', 'tag_sesion_mentoria.nombre_tag_sesion_mentoria', 'tag_sesion_mentoria.valor_tag_sesion_mentoria', 'estado.nombre_estado', 'mentoria.seg_codigo_usuario as mentor');
		$query->join('core.estado', 'tag_sesion_mentoria.codigo_estado', '=', 'estado.codigo_estado');
		$query->join('aprende.mentoria', 'tag_sesion_mentoria.codigo_mentoria', '=', 'mentoria.codigo_mentoria');
		$query->where('tag_sesion_mentoria.codigo_mentoria', '=', $mentoring);
		$query->where('tag_sesion_mentoria.codigo_estado', '=', Estado::getState('active'));

		// Get posts
		$query->orderBy('tag_sesion_mentoria.codigo_tag_sesion_mentoria', 'asc');
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $tags) {
				$tarea = new \stdClass();
				$tarea->codigo_tag_sesion_mentoria = TuProyecto::encryptSrcParams([$tags->codigo_tag_sesion_mentoria]);
                $tarea->codigo_mentoria = $tags->codigo_mentoria;
				$tarea->nombre_tag_sesion_mentoria = $tags->nombre_tag_sesion_mentoria;
                $tarea->valor_tag_sesion_mentoria = $tags->valor_tag_sesion_mentoria;
				$tarea->nombre_estado = $tags->nombre_estado;
				$tarea->mentor = Auth::user()->codigo_usuario == $tags->mentor ? true : false;
				$tarea->item = $tags->codigo_tag_sesion_mentoria;
				$tagsMentoring[] = $tarea;
			}
		}
        return $tagsMentoring;
    }
}
