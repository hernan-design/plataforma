<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgrupacionPreguntasEval extends Model
{
    protected $table = 'core.agrupacion_preguntas_eval';

    protected $primaryKey = 'codigo_agru_preg_eval';

    public $incrementing = false;

	public $timestamps = false;
}
