<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaCanal extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.categoria_canal';

   	protected $primaryKey = 'codigo_categoria_canal';

   	public static function getCategories() {
   		$query = self::query();
   		$query->select('codigo_categoria_canal', 'nombre_categoria_canal');
   		$query->where('codigo_institucion', RegistroSesion::getInstitution());
   		$query->where('codigo_estado', Estado::getState('active'));
   		return $query->get();
   	}
}
