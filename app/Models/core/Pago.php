<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use App\Estado, App\Curso, App\RegistroSesion, App\UsuarioInstitucion;

class Pago extends Model
{
    protected $table = 'core.pago';

   	protected $primaryKey = 'codigo_pago';

	public $timestamps = false;

	public static function typeResource($type) {
    	switch ($type) :
		    case 'course': return 1;
		    case 'program': return 2;
		    case 'mentoring': return 3;
			default: return 'Not type resource identified';
		endswitch;
    }

    public static function validatePaymentResource($resource, $type, $codigo_usuario_institucion) {
    	$query = Pago::query();
        $query->select('pago.codigo_pago','pago.codigo_usuario_institucion');
        $query->where('pago.codigo_recurso', '=', $resource);
        $query->where('pago.tipo_recurso', '=', $type);
        $query->where('pago.codigo_usuario_institucion', '=', $codigo_usuario_institucion);
        $query->where('pago.codigo_estado', '=', Estado::getState('active'));
        return $query->first();
    }

    public static function validatePayment($request, Usuario $user) {
		$response = new \stdClass();
        $response->success = false;
		if(in_array($request->segment(1), ['aprende'])) {
			$course = Curso::getCourseUrl($request->segment(4));
            if($course->curso_gratis) {
				$response->success = true;
				return $response;
			} else {
                $codigo_usuario_institucion = UsuarioInstitucion::where('codigo_usuario',$user->codigo_usuario)->where('codigo_institucion',RegistroSesion::getInstitution())->first();
                if(!$codigo_usuario_institucion instanceof UsuarioInstitucion){
                    return $response;
                }
                $registro_pago = Pago::validatePaymentResource($course->codigo_curso, Pago::typeResource('course'), $codigo_usuario_institucion->codigo_usuario_institucion);
                if($registro_pago instanceof Pago) {
                    $response->success = true;
                    return $response;
                }
            }
		} else{
            $response->success = true;
        }

		return $response;
	}
}
