<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class TipoComentarioEvaluacion extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.tipo_comentario_evaluacion';

	protected $primaryKey = 'cod_tip_comen_eval';

    public $timestamps = false;
    
    public static function getEvaluationCommitTypeClass($type) {
    	switch ($type) :
            case 'recommendation':
                return 1;
            case 'quality': 
                return 2;
		endswitch;
    }

	public static function getEvaluationCommitType($tipeUserEvaluated, string $typeClass = 'recommendation')
	{

		$query = TipoComentarioEvaluacion::query();
		$query->select('tipo_comentario_evaluacion', DB::raw("(CASE WHEN label_tipo_comen_insti IS NOT NULL THEN label_tipo_comen_insti ELSE nombre_tipo_come_eval END) as nombre_tipo_comentario"));
		$query->join('core.tipo_comen_eval_insti', function($join) use($tipeUserEvaluated, $typeClass){
			$join->on('tipo_comentario_evaluacion.cod_tip_comen_eval', '=', 'tipo_comen_eval_insti.cod_tip_comen_eval')
				->where('codigo_institucion', '=', RegistroSesion::getInstitution())
                ->where('aplicante_comentario', '=', $tipeUserEvaluated)
                ->where('clase_tipo_come_eval', '=', TipoComentarioEvaluacion::getEvaluationCommitTypeClass($typeClass) )
				->where('codigo_estado', '=', Estado::getState('active'));
		});
		$query->orderBy('tipo_comentario_evaluacion', 'asc');
		return $query->get();
    }
    
}
