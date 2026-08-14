<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaMentoria extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.etapa_mentoria';

	public $incrementing = false;

	public $timestamps = false;
	
    /**
	* Defining Relations
	*/
	public function estapamentoria()
    {
        return $this->hasOne('App\EtapaMentoria','codigo_etapa_proyecto','codigo_etapa_proyecto');
    }
}
