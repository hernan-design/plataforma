<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Cache;

class TipoEvento extends Model {

    protected $table = 'core.tipo_evento';

    protected $primaryKey = 'codigo_tipo_evento';

    public $timestamps = false;

    public static function getTypeEvent($type) {
    	switch ($type) :
		    case 'mentoring': return 1;
		    case 'call': return 2;
		    case 'meeting': return 3;
			default: return 'Not event identified';
		endswitch;
    }

    public static function getTypes($class = 'platform', $calendar = null)
    {
        $cache = sprintf('_%s_%s_%s', 'event_types', RegistroSesion::getInstitution(), $class);
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }
        return Cache::rememberForever($cache, function() use($class, $calendar) {
            $query = TipoEvento::query();
            $query->select('nombre_tipo_evento', 'tipo_evento.codigo_tipo_evento', 'icono_tipo_evento');
            $query->join('core.tipo_evento_calendario', 'tipo_evento.codigo_tipo_evento', '=', 'tipo_evento_calendario.codigo_tipo_evento');
            $query->join('core.calendario', 'tipo_evento_calendario.codigo_calendario', '=', 'calendario.codigo_calendario');

            // Filters
            $query->where('calendario.codigo_institucion', RegistroSesion::getInstitution());
            $query->where('tipo_evento_calendario.codigo_clase_tipo_evento', ClaseTipoEvento::getClass($class));
            $query->where('tipo_evento_calendario.codigo_estado', Estado::getState('active'));

            // Filter to Calendar
            if (isset($calendar) && !empty($calendar)) {
                $calendar = Calendario::select('codigo_calendario')->where('url_calendario', $calendar)->first();
                $query->where('calendario.codigo_calendario', $calendar->codigo_calendario);
            }


            $query->orderby('nombre_tipo_evento','asc');
            return $query->get();
        });
    }
}
