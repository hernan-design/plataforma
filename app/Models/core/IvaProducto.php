<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

use App\Models;

class IvaProducto extends Model {

    protected $table = 'core.iva_producto';

    protected $primaryKey = 'codigo_iva_producto';

	public $timestamps = false;

	public static function getIva()
    {
        $cache = sprintf('_%s', 'iva_product');
        if (Cache::has($cache)) {
            return Cache::get($cache);    
        }

        return Cache::rememberForever($cache, function() {
            $query = IvaProducto::query();
            $query->select('codigo_iva_producto', 'valor_iva_producto');  
            $query->orderby('valor_iva_producto','asc');
            return $query->pluck('valor_iva_producto', 'codigo_iva_producto')->toArray(); 
        });
    }
}
