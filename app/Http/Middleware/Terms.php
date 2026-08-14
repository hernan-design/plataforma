<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Terms
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
        'politicaventas',
        'privacidad',
        'step/terminos',
        'step/politicaventas'
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
            if ( isset($this->auth->user()->institucion) && $this->auth->user()->institucion->validacion_terminos_marketplace) {
                return redirect()->route('step.politicaventas.index');
            }else if(!session('_acceptance_terms')) {
                return redirect()->route('step.terminos.index');
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
