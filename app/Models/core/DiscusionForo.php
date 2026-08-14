<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscusionForo extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discusion_foro';

   	protected $primaryKey = 'codigo_discusion_foro';

	public $timestamps = false;
}
