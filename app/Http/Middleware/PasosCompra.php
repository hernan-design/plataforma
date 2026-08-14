<?php

namespace App\Http\Middleware;

use TuProyecto, Closure, Log;

use Custom\Innpulsa;

use App\RegistroSesion, App\Institucion, App\Compra, App\Producto;

class PasosCompra
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
    
		    if(!$institucion->pasos_compra){

                $params = $request->route()->parameters();

                $actions = ['shipping','payment', 'confirm', 'purchase','codigo_compra'];
                $action = array_keys($params)[0];

                $purchase_id = null;
                if (!empty($action) && in_array($action, $actions)) {
                    $purchase_id = $request->route($action);
                }elseif ($request->query('purchase')) {
                    $purchase_id = $request->query('purchase');
                }elseif ($request->query('codigo_compra')) {
                    $purchase_id = $request->query('codigo_compra');
                }

                if($purchase_id) {
                    list($codigo_compra) = TuProyecto::decryptSrcParams($purchase_id);
                    if(!$codigo_compra || !is_numeric($codigo_compra)) {
                        Log::error(sprintf('%s:%s', 'App\Http\Middleware\PasosCompra', 'El código de la compra no es válido'));
                        abort(404);
                    }

                    $purchase = Compra::find($codigo_compra);
                    if(!$purchase instanceof Compra) {
                        Log::error(sprintf('%s:%s', 'App\Http\Middleware\PasosCompra', 'No existe la compra'));
                        abort(404);
                    }

                    // Find product
                    $product = Producto::find($purchase->codigo_producto);
                    if(!$product instanceof Producto) {
                        Log::error(sprintf('%s:%s', 'App\Http\Middleware\PasosCompra', 'No se encuentra al producto'));
                        abort(404);
                    }
                }

                return redirect()->route('marketplace.compras.offer.create', ['product'=>$product->url_producto, 'purchase'=>$purchase_id]);
            }        				
		}
        
		return $next($request);
	}
}
