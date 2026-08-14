<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use Auth, Validator, DB;

class AcuerdoCompra extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.acuerdo_compra';

	protected $primaryKey = 'codigo_acuerdo_compra';

	public $timestamps = false;


	public function isValid($data)
    {
        $rules = array(
            'codigo_compra' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    /**
	* Get agreement.
	*/
   	public static function getAgreement($agreement)
   	{
   		$query = AcuerdoCompra::query();
   		$query->select('acuerdo_compra.*', 'compra.codigo_usuario as comprador', 'compra.seg_codigo_usuario as vendedor');
   		$query->join('core.compra', 'compra.codigo_compra', '=', 'acuerdo_compra.codigo_compra');
   		$query->where('acuerdo_compra.codigo_acuerdo_compra', $agreement);
		return $query->first();
    }

    /**
	* Build Purchase Agreement.
	*/
   	public static function buildPurchaseAgreement($agreement)
   	{
		$object = new \stdClass();
		$object->acuerdo_compra = $agreement->codigo_acuerdo_compra;
		$object->url_acuerdo_compra = $agreement->url_acuerdo_compra;
		$object->codigo_acuerdo_compra = TuProyecto::encryptSrcParams([$agreement->codigo_acuerdo_compra]);
		$object->codigo_compra = TuProyecto::encryptSrcParams([$agreement->codigo_compra]);
		$object->comprador = (Auth::user()->codigo_usuario == $agreement->comprador) ? true : false;
		$object->codigo_estado = $agreement->codigo_estado;
		$object->alcance_acuerdo_compra = $agreement->alcance_acuerdo_compra;
		$object->resultados_acuerdo_compra = $agreement->resultados_acuerdo_compra;

		// Get activitys agreement
		$object->actividad_acuerdo = $agreement->activityAgreement()->where('codigo_estado', '=', Estado::getState('active'))->get();

		// Get users agreement
		$object->asesor_acuerdo = $agreement->userTeamAgreement();

		// Get deliverables agreement
		$object->entregable_acuerdo = $agreement->deliverableAgreement()->where('codigo_estado', '=', Estado::getState('active'))->get();
		// Get work team agreement
		$object->equipo_trabajo_acuerdo = $agreement->workteamAgreement()->where('codigo_estado', '=', Estado::getState('active'))->get();
		return $object;
   	}

   	public static function getAttachment($codigo) {
		$attachedPurchase = [];
		$query = AcuerdoCompra::query();
		$query->select('*');
		$query->join('core.adjunto', 'adjunto.codigo_adjunto', '=', 'acuerdo_compra.codigo_adjunto');
		$query->where('codigo_compra', '=', $codigo);
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedPurchase[] = AcuerdoCompra::buildAttached($attached);
			}
		}

		return $attachedPurchase;
	}

	public static function getAttachmentCertificate($codigo) {
		$attachedPurchase = [];
		$query = AcuerdoCompra::query();
		$query->select('*');
		$query->join('core.adjunto', 'adjunto.codigo_adjunto', '=', 'acuerdo_compra.camara_comercio_asesor');
		$query->where('codigo_compra', '=', $codigo);
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedPurchase[] = AcuerdoCompra::buildAttached($attached);
			}
		}

		return $attachedPurchase;
	}

	public static function getAttachmentBill($codigo) {
		$attachedPurchase = [];
		$query = AcuerdoCompra::query();
		$query->select('*');
		$query->join('core.adjunto', 'adjunto.codigo_adjunto', '=', 'acuerdo_compra.cor_codigo_adjunto');
		$query->where('codigo_compra', '=', $codigo);
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedPurchase[] = AcuerdoCompra::buildAttached($attached);
			}
		}

		return $attachedPurchase;
	}

	public static function buildAttached($attached)
	{
		$object = new \stdClass();
		$object->uuid = TuProyecto::encryptSrcParams([$attached->codigo_compra]);
		$object->codigo_compra = TuProyecto::encryptSrcParams([$attached->codigo_compra]);
		$object->direccion_adjunto = $attached->direccion_adjunto;
		$object->name = $attached->nombre_adjunto;

		return $object;
	}

	public function userTeamAgreement()
	{
		$query = UsuarioAcuerdo::query();
		$query->select('usuario_acuerdo.codigo_usuario_acuerdo', 'grupo_usuario.codigo_grupo_usuario', 'correo_electronico as correo_usuario_acuerdo', 'nombre_rol_usuario_grupo as cargo_usuario_acuerdo',
			DB::raw("(nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as nombre_usuario_acuerdo"));
		$query->join('core.grupo_usuario', 'usuario_acuerdo.codigo_grupo_usuario', '=', 'grupo_usuario.codigo_grupo_usuario');
		$query->join('seguridad.usuario', 'grupo_usuario.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftjoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftjoin('core.rol_usuario_grupo_insti', 'grupo_usuario.codigo_rol_usuario_grupo_insti', '=', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo_insti');
		$query->leftjoin('core.rol_usuario_grupo', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo', '=', 'rol_usuario_grupo.codigo_rol_usuario_grupo');

		$query->where('usuario_acuerdo.codigo_acuerdo_compra', $this->codigo_acuerdo_compra);
		$query->where('usuario_acuerdo.codigo_estado', '=', Estado::getState('active'));
		return $query->get();
	}

   	public function activityAgreement()
    {
        return $this->hasMany('App\ActividadAcuerdo','codigo_acuerdo_compra','codigo_acuerdo_compra')->orderBy('codigo_actividad_acuerdo', 'asc');
    }

    public function userAgreement()
    {
        return $this->hasMany('App\UsuarioAcuerdo','codigo_acuerdo_compra','codigo_acuerdo_compra');
    }

    public function deliverableAgreement()
    {
        return $this->hasMany('App\EntregableAcuerdo','codigo_acuerdo_compra','codigo_acuerdo_compra');
    }

	public function workteamAgreement()
	{
		return $this->hasMany('App\UsuarioEmpresario','codigo_acuerdo_compra','codigo_acuerdo_compra');
	}
}
