<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoSociedad extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.tipo_sociedad';

   	protected $primaryKey = 'codigo_tipo_sociedad';

   	public $timestamps = false;

	public static function typeSociety()
	{
		$query = TipoSociedad::query();
		$query->where('codigo_estado', '=', Estado::getState('active'));
		$query->orderBy('nombre_tipo_sociedad', 'asc');
		return $query->get();
	}
}
