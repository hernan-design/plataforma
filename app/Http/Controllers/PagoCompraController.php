<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto, Log, Auth;

use App\Producto, App\ClaseProducto, App\Compra, App\TipoPago, App\DetalleVoucher, App\TipoPagoInstitucion, App\RegistroSesion, App\Promocion;

class PagoCompraController extends Controller
{
    /**
     * Instantiate a new CompradorController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('ability:super-admin,view,marketplace');
        $this->middleware('ability:super-admin,purchase,marketplace');
        $this->middleware('pasos_compra');
        //$this->middleware('subscription');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function edit(Request $request, $id)
    {
        // Decrypt src-params
        list($codigo_compra) = TuProyecto::decryptSrcParams($id);
        if(!$codigo_compra || !is_numeric($codigo_compra)) {
            abort(403);
        }


        $purchase = Compra::find($codigo_compra);
        if(!$purchase instanceof Compra) {
            abort(404);
        }

        // Validate existence of product
        $product = Producto::find($purchase->codigo_producto);
        if(!$product instanceof Producto) {
            abort(404);
        }

        $productItem = Producto::buildProduct($product);

        // Validate secure transaction, only the buyer
        if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ) {
            abort(403);
        }

        // Check if shipping exists for Servicios
        if ( ($product->codigo_clase_producto != ClaseProducto::getClassProduct('service')) && !$request->session()->has("shipping_$purchase->codigo_compra") ) {
            return redirect()->route('marketplace.compras.shipping.edit', TuProyecto::encryptSrcParams([$purchase->codigo_compra]));
        }



        // Validate previus requierements

        $typePayment = TipoPagoInstitucion::where('codigo_tipo_pago', '=', TipoPago::getTypePayment('voucher'))->where('codigo_institucion', '=', RegistroSesion::getInstitution())->first();

        if($typePayment instanceof TipoPagoInstitucion) {
            $totalvoucher = DetalleVoucher::getBalanceVoucher();
            $data['totalvoucher'] = $totalvoucher;
        }

        $data['action'] = 'payment';
        $data['purchase'] = $purchase;
        $data['product'] = $productItem;


        if($request->has('promotion_code') && !empty($request->promotion_code)){
            $promotion = Promocion::find($request->promotion_code);
            if(!$promotion instanceof Promocion) {
                abort(404);
            }

            $data['promotion_code'] = $request->promotion_code;
        }

        return view('public/marketplace/purchase/purchase')->with($data);
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
        if (!$request->ajax()) {

            // Decrypt src-params
            list($codigo_compra) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_compra || !is_numeric($codigo_compra)) {
                $errmsg = sprintf('%s %s', 'No es valido el codigo de compra ', $codigo_compra);
                Log::error(sprintf('%s:%s', 'PagoCompraController@update',  $errmsg));
                abort(404, $errmsg );
            }

            $purchase = Compra::find($codigo_compra);
            if(!$purchase instanceof Compra) {
                $errmsg = sprintf('%s %s', 'No existe la compra de codigo ', $codigo_compra);
                Log::error(sprintf('%s:%s', 'PagoCompraController@update',  $errmsg));
                abort(404);
            }

            // Validate secure transaction, only the buyer
            if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ) {
                $errmsg = sprintf('%s %s', 'No esta autorizado ', Auth::user()->codigo_usuario);
                Log::error(sprintf('%s:%s', 'PagoCompraController@update',  $errmsg));
                abort(403);
            }

            try {
            	// Validate payment type
	            $payment = null;
	            if($request->has('payment')) {
	            	$payment = TipoPagoInstitucion::join('core.tipo_pago', 'tipo_pago_institucion.codigo_tipo_pago', '=', 'tipo_pago.codigo_tipo_pago')
	            		->where('tipo_pago_institucion.codigo_tipo_pago', '=', $request->payment)
	            		->where('tipo_pago_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())->first();
                }

	            if(!$payment instanceof TipoPagoInstitucion) {
                    $errmsg = sprintf('%s %s', 'No existe el medio de pago ',  $payment);
                    Log::error(sprintf('%s:%s', 'PagoCompraController@update',  $errmsg));
                     return redirect()->route( 'marketplace.compras.payment.edit', ['payment' => TuProyecto::encryptSrcParams([$purchase->codigo_compra]), 'payment_error' => $errmsg] );
                }


	            // Validate
	            $totalVoucher = DetalleVoucher::getBalanceVoucher();
	            if($payment->moneda_virtual && ($totalVoucher < (float) $purchase->valor_total_compra) ){
                    $errmsg = trans('purchase.voucher.insufficient', ['mediopago' => $payment->nombre_tipo_pago]);
                    Log::error(sprintf('%s:%s', 'PagoCompraController@update',  $errmsg));
    	            return redirect()->route( 'marketplace.compras.payment.edit', ['payment' => TuProyecto::encryptSrcParams([$purchase->codigo_compra]), 'payment_error' => $errmsg] );
	            }

                if($request->has('payment')) {
                    $request->session()->put("payment_$purchase->codigo_compra", $request->get('payment'));
                }

                $data = [
                    'codigo_compra' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])
                ];

                if($request->has('promotion_code') && !empty($request->promotion_code)){
                    $data['promotion_code'] = $request->promotion_code;
                }

                return redirect()->route('marketplace.compras.confirm.edit', $data['codigo_compra']);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                abort(500,$e->getMessage());
            }
        }
        abort(404);
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
