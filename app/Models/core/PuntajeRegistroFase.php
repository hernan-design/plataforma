<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class PuntajeRegistroFase extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.puntaje_registro_fase';

	protected $primaryKey = 'codigo_puntaje_registro_fase';

	public $timestamps = false;

	public $incrementing = false;
}
