<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth, DB;

use  App\RegistroFaseUsuario, App\Estado, App\RegistroSesion, App\Fase;

class CartaCompromisoCompra extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.carta_compormiso_compra';

	protected $primaryKey = 'codigo_carta_compormiso_compra';

	public $timestamps = false;

	public static function getClosedCommitmentbyPhaseId($phase)
	{
		$query = CartaCompromisoCompra::query();
		$query->select('carta_compormiso_compra.*', 'registro_fase_usuario.codigo_estado as codigo_estado_fase_3');
		$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'carta_compormiso_compra.codigo_registro_fase_usuario');
		$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
		$query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('core.entidad', 'registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('entidad.seg_codigo_usuario', Auth::user()->codigo_usuario);
		$query->where('registro_fase_usuario.codigo_fase', $phase);
		$query->where('convocatoria.codigo_estado', Estado::getState('active'));
		$query->where('carta_compormiso_compra.codigo_estado', Estado::getState('closed'));
		$return = $query->first();
		return $return;
	}

	public static function getNotLinkedCommitment()
	{
		$query = CartaCompromisoCompra::query();
		$query->select('carta_compormiso_compra.*', 'registro_fase_usuario.codigo_estado as codigo_estado_fase');
		$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'carta_compormiso_compra.codigo_registro_fase_usuario');
		$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
		$query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('core.entidad', 'registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('entidad.seg_codigo_usuario', Auth::user()->codigo_usuario);
		$query->where('registro_fase_usuario.codigo_estado',  Estado::getState('no_linked') );
		$query->whereIn('registro_fase_usuario.codigo_fase', [Fase::getIdPhase('empodera2020_1_2')]);
		$query->where('convocatoria.codigo_estado', Estado::getState('active'));
		$query->where('carta_compormiso_compra.codigo_estado', Estado::getState('closed'));
		return $query->first();
	}

	public static function getDataCommitment($codigo_carta_compormiso_compra)
	{
		$query = RegistroFaseUsuario::query();
		$query->select('registro_fase_usuario.codigo_usuario', 'valor_asignacion_rfu', 'codigo_carta_compormiso_compra as id_commitment', 'clase_emprendimiento.codigo_clase_emprendimiento', 'nombre_empresa', 'carta_compormiso_compra.nombre_representante_legal', 'apellidos_representante_legal', 'identificacion_rep_legal', 'nit_empresa', 'registro_fase_usuario.codigo_registro_fase_usuario','registro_fase_usuario.codigo_fase','ciudad_empresa.nombre_ciudad as ciudad_empresa','ciudad_rep_legal.nombre_ciudad as ciudad_rep_legal', 'entidad.seg_codigo_usuario as owner', 'carta_compormiso_compra.fecha_aceptacion_carta_compormiso_compra',
			DB::raw("(CASE person.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN person.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE person.nombre_usuario END) as nombre_usuario")
		);

		$query->join('seguridad.usuario', 'registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
		$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');

		$query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('core.convocatoria_institucion', function($join) {
			$join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
				->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
		});

		$query->join('core.entidad', 'registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->join('seguridad.usuario as person', 'entidad.seg_codigo_usuario', '=', 'person.codigo_usuario');
		$query->leftJoin('core.persona', 'person.codigo_usuario', '=', 'persona.codigo_usuario');

		// User institution
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
		});
		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');

		$query->join('core.clase_emprendimiento_insti', function($join) {
			$join->on('entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti')
				->where('clase_emprendimiento_insti.codigo_institucion', '=',RegistroSesion::getInstitution());
		});

		$query->leftJoin('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
		$query->join('core.carta_compormiso_compra', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'carta_compormiso_compra.codigo_registro_fase_usuario');

		$query->leftJoin('core.ciudad as ciudad_rep_legal', 'carta_compormiso_compra.codigo_ciudad', '=', 'ciudad_rep_legal.codigo_ciudad');
		$query->leftJoin('core.ciudad as ciudad_empresa', 'carta_compormiso_compra.cor_codigo_ciudad', '=', 'ciudad_empresa.codigo_ciudad');
		$query->where('carta_compormiso_compra.codigo_carta_compormiso_compra', $codigo_carta_compormiso_compra);
		return $query->first();
	}
}
