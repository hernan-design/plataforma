<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Validator;

class EvaluacionMentoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.evaluacion_mentoria';

   	protected $primaryKey = 'codigo_evaluacion_mentoria';

   	public $timestamps = false;

    public function isValid($data)
    {
        $rules = array(
            'codigo_mentoria' => 'required',
            'comentario__evaluacion_mentoria' => 'required|string|words:1,200'
        );

      $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
        return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	public static function getEvaluationMentoring($codigo_mentoria) 
   	{
   		return EvaluacionMentoria::where('codigo_mentoria','=', $codigo_mentoria)->first();
   	}
 }
