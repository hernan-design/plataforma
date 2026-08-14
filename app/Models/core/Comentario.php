<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Comentario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.comentario';

	protected $primaryKey = 'codigo_comentario';

	public $timestamps = false;

	public static $evaluation = [ 1 => 'Positivo', 2 => 'Negativo', 3 => 'Neutro'];

   	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function discusion()
    {
    	return $this->hasOne('App\ComentarioDiscusion', 'codigo_comentario', 'codigo_comentario');
    }
}
