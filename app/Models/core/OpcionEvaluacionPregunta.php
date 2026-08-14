<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

use App\Estado;
class OpcionEvaluacionPregunta extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.opc_eval_pregunta';

   	protected $primaryKey = 'codigo_opc_eval_pregunta';

   	public $timestamps = false;

   	public static function getOpcEvaluationQuestion($group)
	{
	    $cache = sprintf('_%s_%s', '_get_opc_eval_question', $group);
        if (Cache::has($cache)) {
            return Cache::get($cache);    
        }
        return Cache::rememberForever($cache, function() use($group) {
  
            $query = OpcionEvaluacionPregunta::query();
			$query->where('codigo_grup_opc_eval_pregunta', $group);
			$query->where('codigo_estado', Estado::getState('active'));
			$query->orderby('nombre_opc_eval_pregunta', 'asc');
			return $query->get();
        });
    }

}
