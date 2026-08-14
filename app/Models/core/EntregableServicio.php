<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregableServicio extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.entregable_servicio';

	protected $primaryKey = 'codigo_entregable_servicio';

    public $timestamps = false;
    
    /**
     * Get the product that owns the model.
     */
     public function prodcut()
     {
         return $this->belongsTo('App\Producto','codigo_producto', 'codigo_producto');
     }
}
