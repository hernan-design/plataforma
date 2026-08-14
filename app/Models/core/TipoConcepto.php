<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoConcepto extends Model
{
    protected $table = 'core.tipo_concepto';

    protected $primaryKey = 'codigo_tipo_concepto';

	public $timestamps = false;

	public static function getTypeConcept($typeconcept) {
    	switch ($typeconcept) :
        case 'education': return 1;
			default: return 'Not type identified';
		endswitch;
    }
}
