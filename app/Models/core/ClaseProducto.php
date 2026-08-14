<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use DB, Cache;

class ClaseProducto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.clase_producto';

   	protected $primaryKey = 'codigo_clase_producto';

   	public $timestamps = false;

   	public static function getClassProduct($class) {
    	switch ($class) :
		    case 'product': return 1;
            case 'reward': return 2;
		    case 'service': return 3;
			default: return 'Not class product identified';
		endswitch;
    }

    /**
    * ClassProduct List.
    */
    public static function getClassProductList()
    {
        if (Cache::has('_classproduct_list')) {
          return Cache::get('_classproduct_list');    
        }

        return Cache::rememberForever('_classproduct_list', function() {
            $query = ClaseProducto::query();
            $query->select('codigo_clase_producto', 'nombre_clase_producto');
            $query->orderby('nombre_clase_producto', 'asc');
            return $query->pluck('nombre_clase_producto','codigo_clase_producto')->toArray();    
        });
    }

}
