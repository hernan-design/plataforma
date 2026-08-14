<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class OrganizadorEvento extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.organizador_evento';

	public $incrementing = false;

   	public $timestamps = false;

 	/**
	 * Defining Relations
	 */
	public function organizador()
    {
        return $this->hasOne('App\Patrocinador','codigo_patrocinador','codigo_patrocinador');
    }
}
