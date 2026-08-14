<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

use App\Models;

class TipoContenido extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.tipo_contenido';

   	protected $primaryKey = 'codigo_tipo_contenido';

	public $timestamps = false;

	protected $fillable = ['codigo_tipo_contenido'];

    public static function getType($attached) {
        switch ($attached) :
            case 'platform': return 3;
            default: return 'Not type identified';
        endswitch;
    }

	public static function getTypeContent($category)
   	{
		return TipoContenido::where('url_tipo_contenido', '=', strtolower(trim($category)))->first();
   	}

    public static function getTypes()
    {
        $cache = sprintf('_%s_%s', 'blog_content_type', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);    
        }

        return Cache::rememberForever($cache, function() {
            $query = TipoContenido::query();
            $query->join('param.tipo_contenido_insti', function($join) {
                $join->on('tipo_contenido.codigo_tipo_contenido', '=', 'tipo_contenido_insti.codigo_tipo_contenido')
                    ->where('tipo_contenido_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
                    ->where('tipo_contenido_insti.codigo_estado', '=', Estado::getState('active'));
            });
            
            $query->orderby('nombre_tipo_contenido', 'asc');
            return $query->get();      
        });
    }
}
