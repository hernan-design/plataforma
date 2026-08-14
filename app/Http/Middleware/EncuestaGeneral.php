<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Auth, TuProyecto, Log;

use App\Voucher, App\RegistroSesion, App\Institucion, App\Estado;

class EncuestaGeneral
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
		'marketplace/compras/evaluaciongeneral',
		'marketplace/compras/evaluaciongeneral/*',
		'marketplace/voucher/*'
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
       
		if ($this->auth->check() && !$this->shouldPassThrough($request) && !$request->ajax() && in_array(RegistroSesion::getInstitution(), [Institucion::getInstitution('innpulsa')]) && !Auth::user()->hasRole('seller'))
		{
            
			if($request->segment(1) == 'marketplace' && Voucher::isVoucherFinalized()) {
				return redirect()->route('marketplace.evaluaciongeneral');
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
