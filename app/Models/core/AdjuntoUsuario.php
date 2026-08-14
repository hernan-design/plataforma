<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Input, Validator;
use \Carbon\Carbon;

use TuProyecto, Auth, App, DB;

class AdjuntoUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.adjunto_usuario';

	public $timestamps = false;

	public $incrementing = false;

	protected $fillable = ['codigo_usuario', 'codigo_documento'];

	public function isValid($data)
    {
        $rules = array(
            'codigo_usuario' => 'required',
            'codigo_documento' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

	public static function getAttachedUser($tipo_adjunto = null)
   	{
		// Decrypt src-params
		list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
		if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
			App::abort(403);
		}
		$user = Usuario::find($codigo_usuario);
		if(!$user instanceof Usuario) {
            App::abort(404);
		}

   		$attachedUser = [];
		$query = AdjuntoUsuario::query();
		$query->select('adjunto_usuario.codigo_adjunto','codigo_tipo_adjunto','direccion_adjunto','nombre_adjunto','adjunto_usuario.codigo_usuario', 'privacidad_contenido.codigo_privacidad_contenido', 'privacidad_contenido.nombre_privacidad_contenido', 'documento.codigo_documento', 'documento.nombre_documento',
		'usuario.codigo_usuario', 'institucion_documento.documento_unico',
		 DB::raw('(CASE WHEN entidad.codigo_usuario IS NOT NULL THEN true ELSE false END) AS entity'));
    	$query->join('core.adjunto', 'adjunto_usuario.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
    	$query->join('param.documento', 'adjunto_usuario.codigo_documento', '=', 'documento.codigo_documento');
		$query->join('param.institucion_documento', function($join) {
			$join->on('institucion_documento.codigo_documento', '=', 'documento.codigo_documento')
			 ->where('institucion_documento.codigo_institucion', '=', RegistroSesion::getInstitution())
			 ->where('institucion_documento.codigo_estado', '=', Estado::getState('active'));
	   });
		$query->join('core.privacidad_contenido', 'adjunto_usuario.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');
    	$query->join('seguridad.usuario', 'adjunto_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
    	$query->leftJoin('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('adjunto_usuario.codigo_estado', '=', Estado::getState('active'));
 		$query->where('adjunto_usuario.codigo_usuario', '=', $user->codigo_usuario);

 		if( !Auth::check() || ( Auth::check() && !in_array(Auth::user()->codigo_usuario, $user->getAllowedUsers()))) {
 			$query->where('adjunto_usuario.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
 		}

 		if(!is_null($tipo_adjunto)) {
			$query->where('codigo_tipo_adjunto', '=', $tipo_adjunto);
 		}else{
			$query->where('codigo_tipo_adjunto', '!=', TipoAdjunto::getTypeAttached('gallery'));
 		}

 		$query->orderBy('adjunto_usuario.codigo_usuario','desc');
        // Get posts
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedUser[] = AdjuntoUsuario::buildAttached($attached);
			}
		}
   		return $attachedUser;
   	}

	public static function getEntregableUser($tipo_adjunto = null, int $codigo_compra)
   	{

		$user = Usuario::find(Auth::user()->codigo_usuario);

   		$attachedUser = [];
		$query = AdjuntoUsuario::query();
		$query->select(
			'adjunto_usuario.codigo_adjunto',
			'codigo_tipo_adjunto',
			'direccion_adjunto',
			'nombre_adjunto',
			'adjunto_usuario.codigo_usuario',
			'privacidad_contenido.codigo_privacidad_contenido',
			'privacidad_contenido.nombre_privacidad_contenido',
			'documento.codigo_documento',
			'documento.nombre_documento',
			'usuario.codigo_usuario',
			'entregable_acuerdo.descripcion_entregable as observacion',
			'entregable_acuerdo.codigo_adjunto',
			'adjunto.fecha_adjunto'
			// DB::raw('(CASE WHEN entidad.codigo_usuario IS NOT NULL THEN true ELSE false END) AS entity')
		);
		$query->join('core.adjunto', 'adjunto_usuario.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
		$query->join('param.documento', 'adjunto_usuario.codigo_documento', '=', 'documento.codigo_documento');
		$query->join('core.privacidad_contenido', 'adjunto_usuario.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');
		$query->join('seguridad.usuario', 'adjunto_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		// $query->leftJoin('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->join('core.acuerdo_compra', function($join) use($codigo_compra){
			$join->on('acuerdo_compra.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('acuerdo_compra.codigo_adjunto','=', DB::raw('adjunto.codigo_adjunto::INTEGER'))
				->where('acuerdo_compra.codigo_compra','=', $codigo_compra);
		});
		$query->join('core.entregable_acuerdo', 'entregable_acuerdo.codigo_acuerdo_compra', '=', 'acuerdo_compra.codigo_acuerdo_compra');
		$query->where('adjunto_usuario.codigo_estado', '=', Estado::getState('active'));
		$query->where('adjunto_usuario.codigo_usuario', '=', $user->codigo_usuario);
		$query->where('adjunto_usuario.codigo_institucion', '=', RegistroSesion::getInstitution());

		if(!is_null($tipo_adjunto)) {
			$query->where('codigo_tipo_adjunto', '=', $tipo_adjunto);
		} else {
			$query->where('codigo_tipo_adjunto', '!=', TipoAdjunto::getTypeAttached('gallery'));
		}

		$query->orderBy('adjunto_usuario.codigo_adjunto','desc');
		// Get posts
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedUser[] = AdjuntoUsuario::buildEntregable($attached);
			}
		}
		return $attachedUser;
   	}

	/**
	 * Build Attached User.
	 */
	public static function buildEntregable($attached)
	{
		$object = new \stdClass();
		$object->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->codigo_adjunto = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
		$object->codigo_privacidad_contenido = $attached->codigo_privacidad_contenido;
		$object->label_privacidad_contenido = $attached->nombre_privacidad_contenido;
		$object->codigo_documento = $attached->codigo_documento;
		$object->label_documento = $attached->nombre_documento;
		$object->documento_unico = $attached->documento_unico;
		$object->direccion_adjunto = $attached->direccion_adjunto;
		$object->nombre_entregable = $attached->nombre_adjunto;
		$object->observacion = $attached->observacion;

		$date = date_create($attached->fecha_adjunto);
		$fecha = explode('-', date_format($date,"Y-n-j"));
		$object->year = $fecha[0];
		$object->month = $fecha[1];
		$object->day = $fecha[2];
		$object->name = $attached->nombre_adjunto;
		$object->success = true;
		$object->owner = Auth::check() && Auth::user()->codigo_usuario == $attached->codigo_usuario ? true : false;
		return $object;
	}

   	/**
	 * Build Attached User.
	 */
   	public static function buildAttached($attached)
   	{
		$object = new \stdClass();
		$object->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->codigo_adjunto = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
		$object->codigo_privacidad_contenido = $attached->codigo_privacidad_contenido;
		$object->label_privacidad_contenido = $attached->nombre_privacidad_contenido;
		$object->codigo_documento = $attached->codigo_documento;
		$object->label_documento = $attached->nombre_documento;
		$object->direccion_adjunto = $attached->direccion_adjunto;
		$object->documento_unico = $attached->documento_unico;
		$object->name = $attached->nombre_adjunto;

		$object->owner = Auth::check() && Auth::user()->codigo_usuario == $attached->codigo_usuario ? true : false;
		return $object;
   	}

   	public static function getDataAttached($attached, $user)
   	{
   		$query = AdjuntoUsuario::query();
		$query->select('adjunto_usuario.codigo_adjunto','codigo_tipo_adjunto','direccion_adjunto','nombre_adjunto','adjunto_usuario.codigo_usuario', 'privacidad_contenido.codigo_privacidad_contenido', 'privacidad_contenido.nombre_privacidad_contenido', 'documento.codigo_documento', 'documento.nombre_documento');
    	$query->join('core.adjunto', 'adjunto_usuario.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
    	$query->join('param.documento', 'adjunto_usuario.codigo_documento', '=', 'documento.codigo_documento');
    	$query->join('core.privacidad_contenido', 'adjunto_usuario.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');
    	$query->join('seguridad.usuario', 'adjunto_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
    	$query->leftJoin('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('adjunto_usuario.codigo_estado', '=', Estado::getState('active'));
		$query->where('adjunto_usuario.codigo_usuario', '=', $user);
		$query->where('adjunto.codigo_adjunto', '=', $attached);
 		return $query->first();
   	}

   	/**
	* Defining Relations
	*/

	public function entidad()
    {
        return $this->hasOne('App\Entidad','codigo_usuario','codigo_usuario');
    }
}
