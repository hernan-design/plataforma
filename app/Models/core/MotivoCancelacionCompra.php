<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

class MotivoCancelacionCompra extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.motivo_cancelacion_compra';

	public $incrementing = false;

	public $timestamps = false;

	/**
    * getCancellReason List, purchase cancellation reason
    */
    public static function getCancellReasonList()
    {
        if (Cache::has('_purchasecancellreason_list')) {
          return Cache::get('_purchasecancellreason_list');    
        }

        return Cache::rememberForever('_purchasecancellreason_list', function() {
            $query = MotivoCancelacionCompra::query();
            $query->orderby('nombre_motivo_cancel_compra', 'asc');
            return $query->get();  
        });
    }
}
