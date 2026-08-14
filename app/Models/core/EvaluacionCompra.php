<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator;

class EvaluacionCompra extends BaseModel
{
  	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.evaluacion_compra';

	protected $primaryKey = 'codigo_evaluacion_compra';

	public $timestamps = false;

	protected $fillable = ['cometario_evaluacion_compra', 'cometario_calidad_compra','codigo_motivo_cancel_compra', 'tipo_comentario_evaluacion', 'cor_tipo_comentario_evaluacion'];

    protected $nullable = ['cometario_evaluacion_compra', 'cometario_calidad_compra', 'tipo_comentario_evaluacion', 'cor_tipo_comentario_evaluacion'];

    /**
	* Valid create purchase.
	*/
   	public function isValid($data)
    {
        $rules = array(
        	'codigo_compra' => 'required',
            'cometario_evaluacion_compra' => 'string',
            'tipo_comentario_evaluacion' => 'integer|min:1'
       	);

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
