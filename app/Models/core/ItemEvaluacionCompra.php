<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, DB, Log;

use App\Estado, App\RegistroSesion;

class ItemEvaluacionCompra extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.item_evaluacion_compra';

	protected $primaryKey = 'codigo_item_evaluacion_compra';

	public $timestamps = false;

	/**
    * getItemEvalPurchaseList List.
    */
    public static function getItemEvalPurchaseList()
    {
        $cache = sprintf('_%s_%s', 'itemevalpurchase_list', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = ItemEvaluacionCompra::query();
            $query->where('codigo_institucion', '=', RegistroSesion::getInstitution());
            $query->where('codigo_estado', '=', Estado::getState('active'));
            $query->orderby('nombre_item_evaluacion_compra', 'asc');
            return $query->get();
        });
    }
}
