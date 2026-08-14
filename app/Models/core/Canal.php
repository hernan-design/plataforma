<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.canal';

   	protected $primaryKey = 'codigo_canal';

   	public static function getChannels() {
   		$query = self::query();
		$query->select('codigo_canal', 'nombre_canal', 'descripcion_canal', 'canal_abierto', 'canal.codigo_categoria_canal', 'contador_inscritos', 'url_canal');
		$query->leftJoin('core.categoria_canal', function($join) {
       		$join->on('canal.codigo_categoria_canal', '=', 'categoria_canal.codigo_categoria_canal')
				->where('categoria_canal.codigo_estado', '=', Estado::getState('active'));
      	});
		$query->where('canal.codigo_institucion', RegistroSesion::getInstitution());
		$query->where('canal.codigo_estado', Estado::getState('active'));

   		return $query->get();
   	}
}
