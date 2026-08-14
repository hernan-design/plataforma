<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TuProyecto;

class EvaluacionItemEmprendimiento extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.evaluacion_item_emprendimiento';

   	protected $primaryKey = 'codigo_evaluacion_item';

	   public $timestamps = false;
	   
	public static function getAttachedEval($code) {
		$query = EvaluacionItemEmprendimiento::select();
		$query->where('codigo_item_evaluacion', '=', $code);

		return $query->first();
	}

	public static function buildAttached($attached) {
		$object = new \stdClass();
		$object->uuid = TuProyecto::encryptSrcParams([$attached->codigo_evaluacion_item]);
		$object->direccion_adjunto = $attached->comentario_evaluacion_item;
		$object->name = 'Documento Adjunto';
        // $object->owner = $attached->codigo_usuario == Auth::user()->codigo_usuario ? true : false;
        // $object->fecha_adjunto = $attached->fecha_adjunto;
		return $object;
	}
}
