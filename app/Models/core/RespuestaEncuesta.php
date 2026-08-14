<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class RespuestaEncuesta extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'core.respuesta_encuesta';

   	protected $primaryKey = 'codigo_respuesta_encuesta';

    public $timestamps = false;

    public static function buildAnswer(Collection $arAnswers, $tipo_pregunta, $codigo_pregunta)
    {
    	$respuesta = null;
       	switch ($tipo_pregunta) {
			case PreguntaEncuesta::getType('open'):
				$filter = $arAnswers->where('codigo_pregunta_encuesta', $codigo_pregunta)->first();
				$respuesta = $filter['texto_respuesta_encuesta'];
			break;

			case PreguntaEncuesta::getType('single'):
				$filter = $arAnswers->where('codigo_pregunta_encuesta', $codigo_pregunta)->first();
				$respuesta = $filter['codigo_opcion_encuesta'];
			break;

			case PreguntaEncuesta::getType('multiple'):
				$answers = [];
				$filter = $arAnswers->where('codigo_pregunta_encuesta', $codigo_pregunta);
				foreach ($filter as $answer) {
					$answers[] = $answer->codigo_opcion_encuesta;
				}
				$respuesta = $answers;
			break;

			case PreguntaEncuesta::getType('upload'):
				$filter = $arAnswers->where('codigo_pregunta_encuesta', $codigo_pregunta)->first();
				$respuesta = $filter['texto_respuesta_encuesta'];
			break;

			case PreguntaEncuesta::getType('matriz'):
				$answers = [];
				$filter = $arAnswers->where('codigo_pregunta_encuesta', $codigo_pregunta);
				foreach ($filter as $answer) {
					$respuesta_item = "";
					$opcion = OpcionPreguntaEncuesta::find($answer->codigo_opcion_encuesta);
					if($opcion->tipo_campo_opcion == TipoCampoPregunta::getTypeQuestion('select')){
						$campo_respuesta = ItemOpcionEncuesta::where('codigo_item_opcion_encuesta',(int)$answer->texto_respuesta_encuesta)->first();
						if($campo_respuesta instanceof ItemOpcionEncuesta){
							$respuesta_item = $campo_respuesta->nombre_item_opcion_encuesta;
						}
					}
					else{
						$respuesta_item = $answer->texto_respuesta_encuesta;
					}
					$answers["{$answer->codigo_opcion_encuesta}_{$answer->cor_codigo_opcion_encuesta}"] = $respuesta_item;
				}
				$respuesta = $answers;
			break;
		}
		return $respuesta;
    }

    public static function getUserResponseSurvey(UsuarioEncuesta $userSurvey)
    {
    	return RespuestaEncuesta::select(
    			'pe.codigo_pregunta_encuesta as question_id',
    			'pe.tipo_pregunta_encuesta as question_type',
    			'pe.tipo_campo_pregunta as field_type',
    			'pe.texto_pregunta_encuesta as question',
    			'respuesta_encuesta.texto_respuesta_encuesta as answer',
    			'ro.texto_opcion_encuesta as text_option_y',
                'ro.puntaje_opcion_encuesta as score_option',
    			'oex.texto_opcion_encuesta as text_option_x',
                'respuesta_encuesta.codigo_opcion_encuesta as option_code_y',
                'respuesta_encuesta.cor_codigo_opcion_encuesta as option_code_x'
    		)
    		->join('core.pregunta_encuesta as pe','respuesta_encuesta.codigo_pregunta_encuesta','=','pe.codigo_pregunta_encuesta')
    		->leftjoin('core.opcion_encuesta as ro','respuesta_encuesta.codigo_opcion_encuesta','=','ro.codigo_opcion_encuesta')
    		->leftjoin('core.opcion_encuesta as oex','respuesta_encuesta.cor_codigo_opcion_encuesta','=','oex.codigo_opcion_encuesta')
            ->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta)
            ->where('pe.codigo_estado', '=', Estado::getState('active'))
            ->orderby('pe.numero_pregunta_encuesta','ASC')
        ->get();
    }
	/**
	 * Obtiene respuestas de evaluaciòn mediante el codigo_usuario_encuesta.
	 *
	 * @access public
	 * @static function
	 * @param int $id_user_survey
	 * @return object $answers
	 */
	public static function getAnswers($id_user_survey)
	{
		$query = RespuestaEncuesta::query();
        $query->where('codigo_usuario_encuesta', $id_user_survey);
        $query->where('codigo_estado', Estado::getState('active'));
        $query->orderBy('codigo_pregunta_encuesta', 'asc');
        $answers = $query->get();

		return $answers;
	}

}
