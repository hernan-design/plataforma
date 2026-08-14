<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitoConvocatoria extends Model
{
    protected $table = 'core.requisito_convocatoria';

    protected $primaryKey = 'codigo_requisito_convocatoria';

	public $timestamps = false;

}
