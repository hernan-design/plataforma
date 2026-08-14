<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Validator;

use TuProyecto;

use App\Usuario, App\Contenido, App\RegistroSesion;

class ModeloNegocio extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.modelo_negocio';

	protected $primaryKey = 'codigo_modelo_negocio';

	public $timestamps = false;


	protected $fillable = ['codigo_modelo_negocio','nombre_modelo_negocio','descripcion_modelo_negocio'];

	public function isValid($data)
	{
		$rules = array(
			'nombre_modelo_negocio' => 'required|max:100',
			'resumen_modelo_negocio' => 'required|max:300'
			);

		  $validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getBusinessModels()
	{
		// $cache = sprintf('_%s_%s', 'business_models', Cookie::get('_inst_key'));
  //       if (Cache::has($cache)) {
  //           return Cache::get($cache);    
  //       }

  //       return Cache::rememberForever($cache, function() {
    		$query = ModeloNegocio::query();
			$query->select('modelo_negocio.codigo_modelo_negocio', 'nombre_modelo_negocio');

			$query->join('core.modelo_negocio_institucion', function($join) {
       		$join->on('modelo_negocio.codigo_modelo_negocio', '=', 'modelo_negocio_institucion.codigo_modelo_negocio')
					->where('modelo_negocio_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
	      	});

			$query->orderby('nombre_modelo_negocio','asc');
			return $query->pluck('nombre_modelo_negocio', 'codigo_modelo_negocio')->toArray();      
        // });
	}
}
