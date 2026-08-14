<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscusionMuro extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discucion_muro';

   	protected $primaryKey = 'codigo_discucion_muro';

	public $timestamps = false;
}
