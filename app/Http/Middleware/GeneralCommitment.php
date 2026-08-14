<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Auth, TuProyecto;

use App\CartaCompromisoCompra, App\RegistroSesion, App\Institucion, App\Estado;

class GeneralCommitment
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
        'step/compromiso',
		'step/compromiso/*',
		'logout'
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
			$dataCommitment = CartaCompromisoCompra::getNotLinkedCommitment();
            if($dataCommitment instanceof CartaCompromisoCompra && in_array($dataCommitment->codigo_estado_fase, [Estado::getState('no_linked')])) {
                return redirect()->route('step.compromiso.edit',['compromiso' => TuProyecto::encryptSrcParams([$dataCommitment->codigo_carta_compormiso_compra])]);
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