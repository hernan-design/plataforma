<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache, DB;

class Ciudad extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'core.ciudad';

    protected $primaryKey = 'codigo_ciudad';

    public $timestamps = false;

    public function cityFormat()
    {
        return "{$this->attributes['nombre_ciudad']}, {$this->pais->nombre_pais}";
    }

    public static function getCities()
    {
        $cache = sprintf('_%s_%s', '_cities_institucion_', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = Ciudad::query();
            $query->select('codigo_ciudad as key', DB::raw("trim(initcap(nombre_ciudad) || ' - ' || COALESCE(initcap(distrito_ciudad), '') || ' - ' || COALESCE(pais.codigo_pais, '')) as value"));
            $query->join('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

            $query->join('core.pais_institucion', function($join) {
                $join->on('pais.codigo_pais', '=', 'pais_institucion.codigo_pais')
                    ->where('pais_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
                    ->where('pais_institucion.codigo_estado', '=', Estado::getState('active'));
            });
            $query->where('ciudad.codigo_estado', '=', Estado::getState('active'));
            $query->whereNotNull('distrito_ciudad');
            $query->whereRaw("distrito_ciudad != ''");

            $query->orderby('distrito_ciudad','asc');
            $query->orderby('nombre_ciudad','asc');
            return $query->get();

        });
    }

    /**
    * Cities List.
    */
    public static function getCitiesList()
    {
        if (Cache::has('_cities_list')) {
          return Cache::get('_cities_list');
        }
        return Cache::rememberForever('_cities_list', function() {
            $query = Ciudad::query();
            $query->select('codigo_ciudad', DB::raw('upper(nombre_ciudad) as nombre_ciudad'));
            $query->whereRaw("ciudad.codigo_pais = 'COL'");
            $query->orderby('nombre_ciudad', 'asc');
            return $query->pluck('nombre_ciudad','codigo_ciudad')->toArray();
        });
    }
    /**
     * Obtiene la ciudad por codigo_ciudad.
     *
     * @access public
     * @static function
     * @param int $id_city
     * @return object $data
     */
    public static function getCity(int $id_city)
    {
		$query = Ciudad::query();
		$query->select('nombre_ciudad', 'codigo_pais', 'distrito_ciudad');
        $query->where('codigo_ciudad', $id_city);
        $data = $query->first();

        return $data;
    }

    /**
    * Defining Relations
    */
    public function pais()
    {
        return $this->hasOne('App\Pais', 'codigo_pais', 'codigo_pais');
    }
}
