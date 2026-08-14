<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscusionEvento extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discusion_evento';

   	protected $primaryKey = 'codigo_discusion_evento';

	public $timestamps = false;
}
