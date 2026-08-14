<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\RegistroSesion, App\Rol;

class EntrustAbility
{
    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @param $roles
	 * @param $permissions
	 * @param bool $validateAll
	 * @return mixed
	 */
	public function handle($request, Closure $next, $roles, $permissions, $module = null, $validateAll = false)
	{
		// module
		$module = !is_null($module) ? "/$module" : $request->route()->getCompiled()->getStaticPrefix();

		// Rol institucion
		$rol = Rol::where('name', RegistroSesion::getInstitution())->firstOrFail();
		if ( $rol->hasPermission(explode('|', $permissions), $module) || ($this->auth->check() && $request->user()->ability(explode('|', $roles), explode('|', $permissions), ['validate_all' => $validateAll, 'module' => $module])) ) {
			return $next($request);
		}
		abort(403);
	}
}
