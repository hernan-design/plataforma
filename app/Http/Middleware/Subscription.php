<?php

namespace App\Http\Middleware;

use Closure;

use Custom\Propace, Custom\RedCoomeva, App\Custom\Compensar, App\Custom\Cenisoft, App\Custom\Colabora;

use App\RegistroSesion, App\Institucion, App\Pago;

class Subscription
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
    	if ($request->user()) {
			$institucion = $request->user()->institucion->institucion;
			switch ($institucion->tipo_afiliacion) {
				// Plans
				case Institucion::getTypeMembership('plans'):
					switch ($institucion->codigo_institucion) {
		    			case Institucion::getInstitution('redcoo'):
		    				$response = RedCoomeva::subscription($request, $request->user());
		    				if(!$response->success) {
					            if ($request->ajax()) {
					            	abort(402);
					            }
								return redirect()->route('precios');
		    				}
						break;
						case Institucion::getInstitution('compensar'):							
		    				$response = Compensar::subscription($request, $request->user());
		    				if(!$response->success) {
					            if ($request->ajax()) {
					            	abort(402);
					            }
								return redirect()->route('precios');
		    				}
						break;
						case Institucion::getInstitution('cenisoft'):
		    				$response = Cenisoft::subscription($request, $request->user());
		    				if(!$response->success) {
					            if ($request->ajax()) {
					            	abort(402);
					            }
								return redirect()->route('precios');
		    				}
	    				break;
						case Institucion::getInstitution('colabora'):							
		    				$response = Colabora::subscription($request, $request->user());
		    				if(!$response->success) {
					            if ($request->ajax()) {
					            	abort(402);
					            }
								return redirect()->route('precios');
		    				}
						break;
						case Institucion::getInstitution('propace'):							
		    				$response = Propace::subscription($request, $request->user());
		    				if(!$response->success) {
					            if ($request->ajax()) {
					            	abort(402);
					            }
								return redirect()->route('precios');
		    				}
	    				break;
						default:
							return redirect()->route('precios');
						
					}
				break;

				// Subscription
				case Institucion::getTypeMembership('subscription'):
					return redirect()->route('comprar.index');
				break;

				// Purchase
				case Institucion::getTypeMembership('purchase'):
					switch ($institucion->codigo_institucion) {
						case Institucion::getInstitution('propace'):
							$response = Pago::validatePayment($request, $request->user());
							if(!$response->success) {
					            if ($request->ajax()) {
									if(!$request->codigo_curso){
										abort(402);
									}										
					            }
								return redirect()->route('reserva');
							}
						break;
						default:
						return redirect()->route('reserva');
					}
				break;

				// Individual purchase
				default:
					// Evaluate purchase resource
					// return redirect()->route('comprar.index', []);
					return $next($request);
				break;
			}
		}

		return $next($request);
	}
}
