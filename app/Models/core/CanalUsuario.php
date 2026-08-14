<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanalUsuario extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.canal_usuario';

   	protected $primaryKey = 'codigo_canal_usuario';

	public $timestamps = false;
}
