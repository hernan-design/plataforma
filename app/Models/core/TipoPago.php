<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, Auth;

class TipoPago extends Model
{
	protected $table = 'core.tipo_pago';

	protected $primaryKey = 'codigo_tipo_pago';

	public $timestamps = false;

	public static function getTypePayment($payment) {
		switch ($payment) :
			case 'voucher': return 2;
			case 'voucher-aldea': return 3;					
			default: return 'Not payment identified';
		endswitch;
	}

	public static function getTypes()
	{

		if (RegistroSesion::getInstitution() == 61) {
			return self::getTypesRutan();
		}

		$cache = sprintf('_%s_%s', '_payment_types', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() {

			$query = TipoPago::query();
			$query->join('core.tipo_pago_institucion', function($join) {
				$join->on('tipo_pago.codigo_tipo_pago', '=', 'tipo_pago_institucion.codigo_tipo_pago')
					->where('tipo_pago_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('tipo_pago_institucion.codigo_estado', '=', Estado::getState('active'));
			});
			$query->orderby('nombre_tipo_pago','asc');
			return $query->get();
		});
	}

	private static function getTypesRutan()
	{
		$query = TipoPagoInstitucion::query();
		$query->select('tipo_pago.*');
		$query->join('core.fase', 'fase.codigo_fase', '=', 'tipo_pago_institucion.fase_asignacion_tipo_pago');
		$query->join('core.entidad', function($join) {
			$join->where('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
		});
		$query->join('core.registro_fase_usuario', function($join) {
			$join->on('registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
			$join->on('registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		});
		$query->join('core.recom_producto_eval', 'recom_producto_eval.codigo_registro_fase_usuario', '=', 'registro_fase_usuario.codigo_registro_fase_usuario');
		$query->join('core.tipo_pago', function($join) {
			$join->on('tipo_pago.codigo_tipo_pago', '=', 'tipo_pago_institucion.codigo_tipo_pago')
				->where('tipo_pago_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('tipo_pago_institucion.codigo_estado', '=', Estado::getState('active'));
		});
		$query->limit(1);
		return $query = $query->get();
	}

	public static function getCategoriasMarketplace()
	{
		$types = [];
		if(Auth::check())
		{
			$query = TipoPagoInstitucion::query();
			$query->join('core.fase', 'fase.codigo_fase', '=', 'tipo_pago_institucion.fase_asignacion_tipo_pago');
			$query->join('core.entidad', function($join) {
				$join->where('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
			});
			$query->join('core.registro_fase_usuario', function($join) {
				$join->on('registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
				$join->on('registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			});
			$query->join('core.recom_producto_eval', 'recom_producto_eval.codigo_registro_fase_usuario', '=', 'registro_fase_usuario.codigo_registro_fase_usuario');

		    $query->join('core.categoria_producto_insti', function($join) {
		        $join->on('categoria_producto_insti.codigo_categoria_producto', '=', 'recom_producto_eval.codigo_categoria_producto')
		            ->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
		            ->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
		    });

			$query->where('tipo_pago_institucion.codigo_institucion', RegistroSesion::getInstitution());
			$query->where('tipo_pago_institucion.moneda_virtual', true);
 			$types = $query->pluck('codigo_cat_padre_producto')->toArray();
		}
		return $types;
	}
}
