<?php

namespace App;

use Illuminate\Database\Eloquent\Model, DB;

class TipoPagoInstitucion extends Model
{
 
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.tipo_pago_institucion';

   	protected $primaryKey = 'codigo_tipo_pago_insti';

	public $timestamps = false;
	   
	public static function getTypePaymentInstitution($institution) {
		$query = TipoPagoInstitucion::query();
		$query->select(DB::raw('( CASE WHEN codigo_tipo_pago IS NOT NULL THEN  ( CASE WHEN codigo_tipo_pago = 2 THEN true ELSE false END ) ELSE false END ) as coin'), 'codigo_institucion');
		$query->where('codigo_institucion', '=', $institution);
		$data = $query->first();

		return $data;
	}

}
