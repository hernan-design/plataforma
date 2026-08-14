<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, Lang, Log, DB, TuProyecto, Input, SendEmail;

use App\RegistroSesion, App\Producto, App\ClaseProducto, App\Compra, App\DetalleCompra, App\Estado, App\DetalleVoucher, App\Usuario;

use App\Rules\ValidIfLower;

class OfertaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		abort(404);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->ajax()) {
            $data = $request->all();
            $purchase = new Compra;

            // Decrypt src-params
            list($codigo_producto) = TuProyecto::decryptSrcParams($request->codigo_producto);
            if(!$codigo_producto || !is_numeric($codigo_producto)) {
                abort(403);
            }

            $product = Producto::find($codigo_producto);
            if(!$product instanceof Producto) {
                abort(404);
            }
            
            $data['precio_producto'] = $product->producto_sin_precio ? 0: $product->precio_producto;
			if ($purchase->isValid($data)) {
            
                $class = ClaseProducto::find($product->codigo_clase_producto);
                if(!$class instanceof ClaseProducto) {
                    abort(404);
                }
                
                $seller = Usuario::find($product->codigo_usuario);
                if(!$seller instanceof Usuario){
                    abort(404);
                }

                // Only units to validate product classes that require it
                if($class->manejo_unidades) {
                    if( intval($request->unidades) === 0) {
                        return response()->json([ 'success' => false, 'errors' => trans('validation.required', ['attribute' => 'unidades']) ]);
                    }

                    if( intval($request->unidades) > $product->cantidad_producto) {
                        return response()->json([ 'success' => false, 'errors' => trans('purchase.units.insufficient', ['units' => $product->cantidad_producto]) ]);
                    }
                }

                DB::beginTransaction();
                try {
                    // Purchase
                    $purchase->codigo_producto = $product->codigo_producto;
                    $purchase->valor_total_compra = $request->valor_total_compra;
                    if($class->manejo_unidades) {
                        $purchase->unidad_producto = intval($request->unidades);
                    }
                    $purchase->codigo_usuario = Auth::user()->codigo_usuario;
                    $purchase->seg_codigo_usuario = $seller->codigo_usuario;
                    $purchase->codigo_estado = Estado::getState('offer');
                    $purchase->fecha_compra = date('Y-m-d');
                    $purchase->hora_compra = date('H:i:s');
                    $purchase->codigo_institucion = RegistroSesion::getInstitution();
                    $purchase->tipo_compra = Compra::getTypePurchase('oferta');
                    $purchase->save();

                    // Send notification
                    $data = [];
                    $data['_template'] = 'emails.marketplace.offer';
                    $data['_inst'] = RegistroSesion::getInstitution();
                    $data['_subject'] = 'Oferta';
                    $data['_to'] = $seller->correo_electronico;
                    $data['_to_name'] = ucwords(strtolower($seller->nombre_usuario));
                    $data['_url_action'] = route('marketplace.ventas.index');
                    SendEmail::notification($data);

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'codigo_compra' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
			}
			return response()->json(['success' => false, 'errors' => $purchase->errors]);
		}
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
