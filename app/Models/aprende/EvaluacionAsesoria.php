<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator;

class EvaluacionAsesoria extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.evaluacion_asesoria';

   	protected $primaryKey = 'codigo_evaluacion_asesoria';

   	public $timestamps = false;

    protected $fillable = ['comentario_evaluacion_asesoria', 'tipo_comentario_evaluacion'];

    public function isValid($data)
    {
        $rules = array(
            'codigo_asesoria' => 'required',
            'comentario_evaluacion_asesoria' => 'required|string',
            'tipo_comentario_evaluacion' => 'integer|min:1|max:10'
        );

      	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
        	return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	public static function getEvaluationAdvice($codigo_asesoria) 
   	{
   		return EvaluacionAsesoria::where('codigo_asesoria','=', $codigo_asesoria)->first();
   	}
}
