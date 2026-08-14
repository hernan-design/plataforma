<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Auth, TuProyecto;

use App\CartaCompromisoCompra, App\RegistroSesion, App\Institucion, App\Estado, App\Fase;

class Commitment
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
			if($request->segment(1) == 'marketplace') {

				$codigo_estado_carta = "";
				$dataCommitment = CartaCompromisoCompra::getClosedCommitmentbyPhaseId(Fase::getIdPhase('three_challenge'));
				if($dataCommitment instanceof CartaCompromisoCompra){
					$codigo_estado_carta = $dataCommitment->codigo_estado_fase_3;
					$codigo_carta_compromiso = $dataCommitment->codigo_carta_compormiso_compra;
				}
				$dataCommitment2020 = CartaCompromisoCompra::getClosedCommitmentbyPhaseId(Fase::getIdPhase('reto3_aldea20'));
				// dd($dataCommitment2020);
				if($dataCommitment2020 instanceof CartaCompromisoCompra){
					$codigo_estado_carta = $dataCommitment2020->codigo_estado_fase_3;
					$codigo_carta_compromiso = $dataCommitment2020->codigo_carta_compormiso_compra;
				}
				if(!$dataCommitment instanceof CartaCompromisoCompra & !$dataCommitment2020 instanceof CartaCompromisoCompra) {
					abort(403);		
				}elseif (in_array($codigo_estado_carta, [Estado::getState('no_linked')])) {
					return redirect()->route('step.compromiso.edit',['compromiso' => TuProyecto::encryptSrcParams([$codigo_carta_compromiso])]);
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
