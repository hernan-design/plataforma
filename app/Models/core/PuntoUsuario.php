<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

// use Auth;

class PuntoUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.punto_usuario';

   	protected $primaryKey = 'codigo_punto_usuario';

   	public $timestamps = false;

   	public static function gamification($action, $state, $user, $recurso, $subrecurso = NULL)
   	{
   		$action = Accion::getAction($action);
		if($action instanceof Accion) {
			if($state === Estado::getState('active')) {
				$puntousuario = new PuntoUsuario();
				$puntousuario->codigo_usuario = $user;
				$puntousuario->codigo_estado = $state;
				$puntousuario->codigo_accion = $action->codigo_accion;
				$puntousuario->codigo_recurso = $recurso;
				if($subrecurso != NULL) {
					$puntousuario->codigo_subrecurso = $subrecurso;
				}
				$puntousuario->fecha_punto_usuario = date('Y-m-d');
				$puntousuario->hora_punto_usuario = date('H:i:s');
				$puntousuario->save();
			}else if($state === Estado::getState('removed')) {
				$query = PuntoUsuario::query();
				$query->where('codigo_usuario', $user);
				$query->where('codigo_estado', Estado::getState('active'));
				$query->where('codigo_accion', $action->codigo_accion);
				$query->where('codigo_recurso', $recurso);
				if($subrecurso != NULL) {
					$query->where('codigo_subrecurso', $subrecurso);
				}
				$puntousuario = $query->first();

				if($puntousuario instanceof PuntoUsuario) {
					$puntousuario->codigo_estado = Estado::getState('removed');
					$puntousuario->save();
				}
			}else{
				throw new \Exception('state not found gamification');
			}
		}else{
     	   throw new \Exception('action not found gamification');
		}
	}

	public static function getTopGamification()
	{
		$query = Usuario::query();
		$query->join('param.institucion', 'usuario.codigo_institucion', '=', 'institucion.codigo_institucion');
		$query->select('codigo_usuario', 'posicion_gamification', 'nombre_usuario', 'primer_apellido_usuario', 'nickname_usuario', 'imagen_usuario', 'contador_gamification',
			'sigla_institucion');
		if (Auth::check() && Auth::user()->posicion_gamification!=0) {
			$posicion = Auth::user()->posicion_gamification - 6;
			$query->skip($posicion);
		}

		$query->whereNotNull('posicion_gamification');
		$query->where('posicion_gamification','!=',0);

		$query->orderBy('posicion_gamification','asc');
		return $query->take(10)->get();
	}

	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('Usuario','codigo_usuario','codigo_usuario');
    }
}
