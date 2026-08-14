<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Cache;

class TemaMentoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.tipo_asesoria';

	protected $primaryKey = 'codigo_tipo_asesoria';

	public $timestamps = false;

	protected $fillable = ['codigo_tipo_asesoria', 'nombre_tipo_asesoria', 'descripcion_tipo_asesoria', 'color_tipo_asesoria', 'imagen_tipo_asesoria', 'codigo_estado', 'url_tipo_asesoria'];

	/**
	* Themes theme.
	*/
	public static function getThemeUrl($theme)
	{
		return TemaMentoria::where('url_tipo_asesoria', '=', strtolower(trim($theme)))->first();
	}

   	/**
	* Themes Mentoring list.
	*/
	public static function getThemesList()
	{
        $cache = sprintf('_%s_%s', '_themes_mentoring_list', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);    
        }

        return Cache::rememberForever($cache, function() {
            $query = TemaMentoria::query();
			$query->where('codigo_institucion', RegistroSesion::getInstitution());
            $query->where('codigo_estado', Estado::getState('active'));
            $query->orderby('nombre_tipo_asesoria', 'asc');
            return $query->get();
        });
   	}

	/**
	* Defining Relations
	*/
	public function mentorias()
	{
		return $this->hasMany('Asesoria','codigo_tipo_asesoria','codigo_tipo_asesoria');
	}
}
