<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Cache;

class PrivacidadContenido extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.privacidad_contenido';

   	protected $primaryKey = 'codigo_privacidad_contenido';

    public static function getPrivacy($privacy)
    {
        switch ($privacy) :
            case 'private': return 1;
            case 'public': return 2;
            case 'hidden': return 3;
            default: return 'Not privacy identified';
        endswitch;
    }

    public static function getPrivaciesContent()
    {
        if (Cache::has('_get_privacies_content')) {
            return Cache::get('_get_privacies_content');
        }

        return Cache::rememberForever('_get_privacies_content', function() {
            $query = PrivacidadContenido::query();
            $query->select('codigo_privacidad_contenido', 'nombre_privacidad_contenido');
            $query->orderby('nombre_privacidad_contenido', 'asc');
            return $query->pluck('nombre_privacidad_contenido', 'codigo_privacidad_contenido')->toArray();
        });
    }

    public static function getPrivacyContent()
    {
        $cache = sprintf('_%s', 'privacy_content');
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = PrivacidadContenido::query();
            $query->orderby('codigo_privacidad_contenido','asc');
            return $query->get();
        });
    }
}
