<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use DB, Log;

class EstadoAdjuntoUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.estado_adjunto_usuario';

   	protected $primaryKey = 'codigo_estado_adjunto';

   	public $timestamps = false;

   	public static function stateAttachedUser($user, $attached, $theme = null){

        $query = EstadoAdjuntoUsuario::select('estado_adjunto_usuario.*')
            ->where('codigo_adjunto', '=', $attached)
            ->where('codigo_usuario', '=', $user);

        if(!empty($theme))
        {
            $query->where('codigo_tema_curso', '=', $theme);
        }
        
        return $query->first();    
    }
}
