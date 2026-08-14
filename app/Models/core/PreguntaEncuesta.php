<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaEncuesta extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'core.pregunta_encuesta';

   	protected $primaryKey = 'codigo_pregunta_encuesta';

    public $timestamps = false;

    public static function getType($type) {
        switch ($type) :
            case 'open': return 1;
            case 'single': return 2;
            case 'multiple': return 3;
            case 'upload': return 4;
            case 'matriz': return 5;
            default: return 'Not type identified';
        endswitch;
    }

    public static function getTypeField($type) {
        switch ($type) :
            case 'select': return 15;
            case 'currency': return 19;
            default: return 'Not field type identified';
        endswitch;
    }

	public static function getClass($class) {
    	switch ($class) :
		    case 'question': return 1;
		    case 'subquestion': return 2;
			default: return 'Not class question identified';
		endswitch;
    }

   	/**
	 * Defining Relations
	*/

    public function choices()
    {
        return $this->hasMany('App\OpcionPreguntaEncuesta', 'codigo_pregunta_encuesta', 'codigo_pregunta_encuesta');
    }
}
