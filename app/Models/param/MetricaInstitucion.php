<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class MetricaInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.metrica_institucion';

    public static function getStadistics()
   	{
		$query = MetricaInstitucion::query();
		$query->select('nombre_metrica', 'valor_metrica_institucion');
		$query->join('param.metrica', 'metrica_institucion.codigo_metrica', '=', 'metrica.codigo_metrica');
		$query->where('metrica_institucion.codigo_estado', Estado::getState('active'));
		$query->where('metrica.codigo_estado', Estado::getState('active'));
		$query->where('codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->orderBy('metrica.codigo_metrica','asc');
		return $query->get();
   	}
}
