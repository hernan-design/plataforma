<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Validator;

class ObligatorioProyecto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.obligatorio_proyecto';

   	protected $primaryKey = 'codigo_obligatorio_proyecto';

   	public static function validate($project, $fase) {
    	$response = new \stdClass();
        $project = Proyecto::find($project);
        
        $fields = ObligatorioProyecto::where('codigo_fase', '=', $fase)->get();
   		
   		$rules = [];
		foreach ($fields as $field) {  
   			$rules[$field->nombre_obligatorio_proyecto] = 'required'; 			
   		}

        $validator = Validator::make($project->toArray(), $rules);
        if ($validator->passes()) {
     		$response->success = true;
			return $response;
        }
        
        $response->errors = $validator->errors();
        $response->success = false;
		return $response;
   	}
}
