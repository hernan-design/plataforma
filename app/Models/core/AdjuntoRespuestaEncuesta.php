<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use TuProyecto;

use Input, Auth;

use App\Models;

class AdjuntoRespuestaEncuesta extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.adjunto_respuesta_encuesta';

	public $timestamps = false;

	public $incrementing = false;

	public static function getAttachedAnswer(Request $request)
   	{
		// Decrypt src-params
		list($codigo_encuesta) = TuProyecto::decryptSrcParams(Input::get('codigo_encuesta'));
		if(!$codigo_encuesta || !is_numeric($codigo_encuesta)) {
			App::abort(403);
		}
		$survey = Encuesta::find($codigo_encuesta);
		if(!$survey instanceof Encuesta) {
			abort(404);
		}

		$user = $userSurvey = null;
		if(Input::has('codigo_usuario_encuesta')) {
			// Detail form
			list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario_encuesta'));
			if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
				abort(403);
			}
			$userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);

		}else{
			// Decrypt src-params
			if($request->has('codigo_usuario')) {
				list($codigo_usuario) = TuProyecto::decryptSrcParams($request->codigo_usuario);
				if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
					abort(403);
				}
				$user = Usuario::findOrfail($codigo_usuario);
			}

			// Active form
			$codigo_usuario = (isset($user) && $user instanceof Usuario) ? $user->codigo_usuario : Auth::user()->codigo_usuario;
			$resource = $survey->getResource($request);
			if(!is_null($resource->resource) && !is_null($resource->module)) {
				// Usuario encuesta
				$userSurvey = UsuarioEncuesta::where('codigo_encuesta', $survey->codigo_encuesta)->where('codigo_usuario', $codigo_usuario)->where('codigo_modulo', $resource->module)->where('id_recurso', $resource->resource)->where('codigo_estado', Estado::getState('active'))->first();
			}
		}

   		$attachedAnswer = [];
		if(Auth::check() && $userSurvey instanceof UsuarioEncuesta)
		{
			$query = AdjuntoRespuestaEncuesta::query();
			$query->select('adjunto.codigo_adjunto', 'direccion_adjunto', 'nombre_adjunto');
	    	$query->join('core.adjunto', 'adjunto_respuesta_encuesta.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
	    	$query->join('core.respuesta_encuesta', 'adjunto_respuesta_encuesta.codigo_respuesta_encuesta', '=', 'respuesta_encuesta.codigo_respuesta_encuesta');
	    	$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');

			$query->where('pregunta_encuesta.codigo_encuesta', '=', $survey->codigo_encuesta);
			$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', Input::get('codigo_pregunta_encuesta'));
			$query->where('adjunto_respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
			$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);

			$query->orderBy('adjunto_respuesta_encuesta.codigo_adjunto','desc');

	        // Get posts
			$data = $query->get();

			if(count($data) > 0) {
				foreach ($data as $attached) {
					$attachedAnswer[] = self::buildAttached($attached);
				}
			}
		}

   		return $attachedAnswer;
   	}

   	/**
	 * Build Attached User.
	 */
   	public static function buildAttached($attached)
   	{
		$object = new \stdClass();
		$object->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->name = trim($attached->nombre_adjunto) != '' ? $attached->nombre_adjunto : $attached->direccion_adjunto;
		$object->direccion_adjunto = $attached->direccion_adjunto;
		return $object;
   	}
}
