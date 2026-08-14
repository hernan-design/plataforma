<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Validator;

class EvaluacionTarea extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.evaluacion_tarea';

   	protected $primaryKey = 'codigo_evaluacion_tarea';

   	public $timestamps = false;

   	public function isValid($data)
    {
        $rules = array(
            'codigo_mentoria' => 'required',
            'comentario_evaluacion_tarea' => 'required|string|words:1,200'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
 }
