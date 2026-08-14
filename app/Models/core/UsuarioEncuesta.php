<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use DB, Auth;

class UsuarioEncuesta extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.usuario_encuesta';

   	protected $primaryKey = 'codigo_usuario_encuesta';

	public $timestamps = false;

	/**
	* Total answers
	*/
   	public function answers($version)
   	{
   		$query = RespuestaEncuesta::query();
		$query->join('core.ver_preg_encuesta', function($join) use($version) {
       		$join->on('respuesta_encuesta.codigo_pregunta_encuesta', '=', 'ver_preg_encuesta.codigo_pregunta_encuesta')
				->where('ver_preg_encuesta.codigo_version_encuesta', '=', $version);
      	});
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $this->codigo_usuario_encuesta);
		$query->where('ver_preg_encuesta.clase_pregunta_encuesta', PreguntaEncuesta::getClass('question'));
		return $query->count( DB::raw('DISTINCT(respuesta_encuesta.codigo_pregunta_encuesta)') );
   	}

	/**
	* Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }
}
