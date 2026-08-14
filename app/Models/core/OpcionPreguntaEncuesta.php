<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpcionPreguntaEncuesta extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'core.opcion_encuesta';

   	protected $primaryKey = 'codigo_opcion_encuesta';

    public $timestamps = false;

    public static function getAxis($axis)
    {
    	switch ($axis) :
		    case 'y': return 1;
		    case 'x': return 2;
			default: return 'Not axis identified';
		endswitch;
    }

    /**
     * Defining Relations
    */

    public function choices()
    {
        return $this->hasMany('App\ItemOpcionEncuesta', 'codigo_opcion_encuesta', 'codigo_opcion_encuesta');
    }
}
