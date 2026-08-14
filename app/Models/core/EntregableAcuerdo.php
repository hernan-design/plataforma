<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregableAcuerdo extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.entregable_acuerdo';

	protected $primaryKey = 'codigo_entregable_acuerdo';

	public $timestamps = false;

	public static function getDeliverableAttachment($agreement)
   	{
   		$query = EntregableAcuerdo::query();
		$query->select('descripcion_entregable', 'direccion_adjunto', 'nombre_adjunto', 'entregable_acuerdo_fijo','codigo_entregable_acuerdo');
		$query->leftjoin('core.adjunto', 'entregable_acuerdo.codigo_adjunto', '=', 'adjunto.codigo_adjunto');

        $query->where('entregable_acuerdo.codigo_acuerdo_compra', '=', $agreement);
        $query->where('entregable_acuerdo.codigo_estado', '=', Estado::getState('active'));
   		$query->orderby('codigo_entregable_acuerdo','asc');
   		return $query->get()->toArray();
   	}

   	public static function getDeliverableFinal($agreement) {
		$query = AcuerdoCompra::query();
		$query->select('adjunto.codigo_adjunto', 'adjunto.direccion_adjunto', 'adjunto.nombre_adjunto');
		$query->join('core.adjunto', 'adjunto.codigo_adjunto', '=', 'acuerdo_compra.codigo_adjunto');
		$query->where('acuerdo_compra.codigo_acuerdo_compra', '=', $agreement);
		$result = $query->first();

		return $result;
	}

	public static function getDeliverableCertificate($agreement) {
		$query = AcuerdoCompra::query();
		$query->select('adjunto.codigo_adjunto', 'adjunto.direccion_adjunto', 'adjunto.nombre_adjunto');
		$query->join('core.adjunto', 'adjunto.codigo_adjunto', '=', 'acuerdo_compra.camara_comercio_asesor');
		$query->where('acuerdo_compra.codigo_acuerdo_compra', '=', $agreement);
		$result = $query->first();

		return $result;
	}
}
