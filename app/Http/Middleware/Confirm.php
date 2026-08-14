<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\RegistroSesion;

class Confirm
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The URIs that should be excluded from Terms verification.
     *
     * @var array
     */
    protected $except = [
        'logout',
        'auth/identityswitch',
        'terminos',
        'privacidad',
        'step/terminos',
        'step/confirmar',
        'usuario/confirmacion/*',
        'step/perfil'
    ];

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check() && !$this->shouldPassThrough($request) && !$request->ajax())
        {
 			if ( empty($this->auth->user()->nombre_usuario) || empty($this->auth->user()->codigo_ciudad) || empty($this->auth->user()->fecha_nacimiento_usuario)    || empty($this->auth->user()->institucion->fecha_registro_info_basica) || (RegistroSesion::institution()->identificacion_registro && (empty   ($this->auth->user()->tipo_identificacion_usuario) || empty($this->auth->user()->identificacion_usuario) )) ) {
    			return redirect()->route('step.perfil');
			}
        }
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through Terms verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($request->is(trim($except, '/'))) {
                return true;
            }
        }
        return false;
    }
}
