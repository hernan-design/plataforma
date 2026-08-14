<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\Modulo, App\RegistroSesion, App\Encuesta;

class Requirements
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
        'step/perfil',
        'encuesta/*'
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
        if ($this->auth->check() && !$this->shouldPassThrough($request) && !$request->ajax()) {
            $requirements = RegistroSesion::entrySteps();
            if($requirements->count()) {
                foreach ($requirements as $requirement) {                    
                    switch ($requirement->codigo_modulo) {                        
                        case Modulo::getModule('surveys'):
                            $surveys = Encuesta::findOrFail($requirement->codigo_recurso_modulo);
                            return redirect()->route('encuesta.responder', ['encuesta' => $surveys->url_encuesta, 'module'=>'surveys']);
                        break;
                    }
                }
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
