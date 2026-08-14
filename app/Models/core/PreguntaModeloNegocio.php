<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Validator;

class PreguntaModeloNegocio extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.pregunta_modelo_negocio';

   	protected $primaryKey = 'codigo_pregunta_modelo_negocio';

   	public $timestamps = false;

   	protected $fillable = ['codigo_pregunta_modelo_negocio','codigo_modelo_negocio','pregunta_modelo_negocio','ejemplo_pregunta_modelo_negocio','descripcion_pregunta_modelo_negocio','codigo_estado'];

   	public function isValid($data)
    {
        $rules = [
            'pregunta_modelo_negocio' => 'required|max:100',
            'ejemplo_pregunta_modelo_negocio' => 'required|max:300',
            'descripcion_pregunta_modelo_negocio' => 'required|max:300'
        ];

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

}