<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Log;

class AsignacionMarketplace extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.asignacion_marketplace';

    protected $primaryKey = 'codigo_asignacion_mp';

    public $timestamps = false;

	public static function getAssignmentsMember($agreement)
	{
		$query = AsignacionMarketplace::query();
		$query->select('usuario.codigo_usuario', 'correo_electronico', 'nombre_usuario', 'codigo_acuerdo_compra');
		$query->join('core.carta_compormiso_compra', function($join) {
			$join->on('asignacion_marketplace.codigo_registro_fase_usuario', '=','carta_compormiso_compra.codigo_registro_fase_usuario')
				->where('asignacion_marketplace.codigo_estado', '=', Estado::getState('active'));
		});

		$query->join('core.detalle_voucher', 'carta_compormiso_compra.codigo_registro_fase_usuario', '=', 'detalle_voucher.codigo_registro_fase_usuario');
		$query->join('core.consumo_voucher', 'detalle_voucher.codigo_detalle_voucher', '=', 'consumo_voucher.codigo_detalle_voucher');
		$query->join('core.compra', 'consumo_voucher.codigo_compra', '=', 'compra.codigo_compra');
		$query->join('core.acuerdo_compra', 'compra.codigo_compra', '=', 'acuerdo_compra.codigo_compra');
        $query->join('seguridad.usuario', function($join) {
			$join->on('asignacion_marketplace.codigo_usuario', '=','usuario.codigo_usuario')
				->where('usuario.codigo_estado', '=', Estado::getState('active'));
		});

		$query->where('acuerdo_compra.codigo_acuerdo_compra', '=', $agreement);
        return $query->get();
	}

}
