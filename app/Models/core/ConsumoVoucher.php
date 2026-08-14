<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumoVoucher extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.consumo_voucher';

   	protected $primaryKey = 'codigo_consumo_voucher';
	
    public $timestamps = false;
    
     /**
     * Get the App\Compra that owns the comment.
     */
    public function compra()
    {
        return $this->belongsTo('App\Compra');
    }
}
