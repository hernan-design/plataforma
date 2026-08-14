<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContenidoCanal extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.contenido_canal';

	protected $primaryKey = 'codigo_contenido_canal';

	public $timestamps = false;
}
