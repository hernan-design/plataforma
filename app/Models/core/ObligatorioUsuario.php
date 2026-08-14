<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Validator;

class ObligatorioUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.obligatorio_usuario';

   	protected $primaryKey = 'codigo_obligatorio_usuario';

}
