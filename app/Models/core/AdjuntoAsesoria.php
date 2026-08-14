<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Input, Validator;

use TuProyecto, Auth, App;

use App\Estado, App\Asesoria;

class AdjuntoAsesoria extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.adjunto_asesoria';

	public $timestamps = false;

	public $incrementing = false;

	public function isValid($data)
    {
        $rules = array(
            'codigo_asesoria' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

	public static function getAttachedAdvice()
   	{
		// Decrypt src-params
		list($codigo_asesoria) = TuProyecto::decryptSrcParams(Input::get('codigo_asesoria'));
		if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
			App::abort(403);
		}
		$advice = Asesoria::find($codigo_asesoria);
		if(!$advice instanceof Asesoria) {
            App::abort(404);
		}

   		$attachedUser = [];
		$query = AdjuntoAsesoria::query();
		$query->select('adjunto_asesoria.codigo_adjunto', 'codigo_tipo_adjunto', 'direccion_adjunto', 'nombre_adjunto', 'adjunto_asesoria.codigo_asesoria', 'asesoria.codigo_asesoria', 'adjunto_asesoria.codigo_usuario', 'fecha_adjunto');
    	$query->join('core.adjunto', 'adjunto_asesoria.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
    	
    	// $query->join('core.privacidad_contenido', 'adjunto_asesoria.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');
    	$query->join('core.asesoria', 'adjunto_asesoria.codigo_asesoria', '=', 'asesoria.codigo_asesoria');
		$query->where('adjunto_asesoria.codigo_estado', '=', Estado::getState('active'));

 		$query->where('adjunto_asesoria.codigo_asesoria', '=', $advice->codigo_asesoria);

 		// if( !Auth::check() || ( Auth::check() && !in_array(Auth::user()->codigo_asesoria, $advice->getAllowedUsers()))) {
 		// 	$query->where('adjunto_asesoria.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
 		// }

		$query->orderBy('adjunto_asesoria.codigo_asesoria','desc');
        // Get posts
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedUser[] = AdjuntoAsesoria::buildAttached($attached);
			}
		}
   		return $attachedUser;
   	}

   	/**
	 * Build Attached User.
	 */
   	public static function buildAttached($attached)
   	{
		$object = new \stdClass();
		$object->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
		$object->direccion_adjunto = $attached->direccion_adjunto;
		$object->name = $attached->nombre_adjunto;
        $object->owner = $attached->codigo_usuario == Auth::user()->codigo_usuario ? true : false;
        $object->fecha_adjunto = $attached->fecha_adjunto;
		return $object;
   	}

   	public static function getDataAttached($attached, $advice)
   	{
   		$query = AdjuntoAsesoria::query();
		$query->select('adjunto_asesoria.codigo_adjunto', 'codigo_tipo_adjunto', 'direccion_adjunto', 'nombre_adjunto', 'codigo_asesoria', 'adjunto_asesoria.codigo_usuario', 'fecha_adjunto');
    	$query->join('core.adjunto', 'adjunto_asesoria.codigo_adjunto', '=', 'adjunto.codigo_adjunto');

		$query->where('adjunto_asesoria.codigo_estado', '=', Estado::getState('active'));
		$query->where('adjunto_asesoria.codigo_asesoria', '=', $advice);
		$query->where('adjunto.codigo_adjunto', '=', $attached);
 		return $query->first();
   	}

}
