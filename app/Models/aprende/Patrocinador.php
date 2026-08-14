<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache;

class Patrocinador extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.patrocinador';

   	protected $primaryKey = 'codigo_patrocinador';

    public static function getSponsor($sponsor)
    {
        switch ($sponsor) :
            case 'unipymes': return 28;
            default: return 'Not sponsor course identified';
        endswitch;
    }

   	public static function getSponsors()
    {
        if (Cache::has('_get_sponsor')) {
            return Cache::get('_get_sponsor');    
        }

        return Cache::rememberForever('_get_sponsor', function() {
            $query = Patrocinador::query();
            $query->select('codigo_patrocinador', 'nombre_patrocinador');
            $query->orderby('nombre_patrocinador', 'asc');
            return $query->pluck('nombre_patrocinador', 'codigo_patrocinador')->toArray();  
        });
    }
}
