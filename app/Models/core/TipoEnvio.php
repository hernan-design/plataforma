<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

class TipoEnvio extends Model
{
    protected $table = 'core.tipo_envio';

    protected $primaryKey = 'codigo_tipo_envio';

    public $timestamps = false;

    public static function getTypes()
    {
        if (Cache::has('_shipping_rates')) {
            return Cache::get('_shipping_rates');    
        }

        return Cache::rememberForever('_shipping_rates', function() {
            $query = TipoEnvio::query();
            $query->orderby('nombre_tipo_envio','asc');
            return $query->get();      
        });
    }

    public static function getTypeShipping($shipping) {
        switch ($shipping) :
            case 'agreement': return 1;
            case 'shippingdomicile': return 2;
            default: return 'Not shipping identified';
        endswitch;
    }
}
