<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use DB, Input, Auth, Cookie, Validator;

class LogCurso extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.log_curso';

	protected $primaryKey = 'codigo_log';

	public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['codigo_curso', 'codigo_usuario', 'fecha_log', 'tipo_log'];


}
