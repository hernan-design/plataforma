<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePromocion extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.detalle_promocion';

	protected $primaryKey = 'codigo_detalle_promocion';

    public $timestamps = false;

    public static function detailPromotionByProduct(array $filters = [])
    {
        $query = DetallePromocion::query();
        $query->join('core.promocion', function($join) use($filters){
            $join->on('detalle_promocion.codigo_promocion', '=', 'promocion.codigo_promocion')
                ->where('detalle_promocion.codigo_producto', '=', $filters['codigo_producto'])
                ->where('detalle_promocion.codigo_estado', '=', Estado::getState('active'));
        });

        if(isset($filters['codigo_promocion']) && !empty($filters['codigo_promocion'])){
            $query->where('promocion.codigo_promocion', '<>', $filters['codigo_promocion']);
        }

        $query->where('detalle_promocion.codigo_estado', Estado::getState('active'));

        return $query->first();
    }
}
