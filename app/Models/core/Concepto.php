<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, Input;

use App\Estado, App\RegistroSesion, App\TipoConcepto, App\Concepto;

class Concepto extends Model
{
	protected $table = 'core.concepto';

	protected $primaryKey = 'codigo_concepto';

	public $timestamps = false;

	public static $sitePage = 30;

	public static function getConceptList()
	{
		$query = Concepto::query();
		$query->join('param.concepto_institucion', 'concepto.codigo_concepto', '=', 'concepto_institucion.codigo_concepto');
		$query->where('codigo_tipo_concepto', TipoConcepto::getTypeConcept(Input::get('type')));
		$query->where('concepto_institucion.codigo_estado', Estado::getState('active'));
		$query->where('concepto_institucion.codigo_institucion', RegistroSesion::getInstitution());
		$query->whereRaw("trim(lower(nombre_concepto)) ilike trim(lower('%".Input::get('q')."%'))");

		$response = new \stdClass();
		$response->total_count = $query->count();

		$offset = Concepto::$sitePage * Input::has('page') ? Input::get('page'): 1;
		$query->take(Concepto::$sitePage)->skip($offset);

		$query->select('codigo_concepto_institucion as id', 'nombre_concepto as text');
		$query->orderby('nombre_concepto','asc');
		$response->items = $query->get();

		return $response;
	}
}
