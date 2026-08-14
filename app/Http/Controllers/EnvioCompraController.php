<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto, Log, Lang, Auth;

use App\RegistroSesion, App\Institucion, App\Estado, App\Producto, App\TipoPago, App\ClaseProducto, App\DetalleVoucher, App\Compra, App\Promocion, Custom\Innpulsa;

class EnvioCompraController extends Controller
{
    /**
     * Instantiate a new CompradorController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('ability:super-admin,view,marketplace');
        $this->middleware('ability:super-admin,purchase,marketplace');

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

        // Validate secure transaction, only the buyer
        if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ) {
            abort(403);
        }

       //  Check If exists promotion code
        if($request->has('promotion_code') && !empty($request->promotion_code)){
            $promotion = Promocion::find($request->promotion_code);
            if(!$promotion instanceof Promocion) {
                abort(404);
            }
            $data['promotion_code'] = $request->promotion_code;
        }

       // Find product
        $product = Producto::getProductUrl(Producto::find($purchase->codigo_producto)->url_producto);
        if(!$product instanceof Producto) {
            abort(404);
        }

        $institution = Institucion::find(RegistroSesion::getInstitution());
        if(!$institution instanceof Institucion){
            abort(404);
        }

        // If is a request from an Innpulsa offer then complete purchase and redirect
        if(!$institution->pasos_compra) {

            $totalVoucher = DetalleVoucher::getBalanceVoucher();
            $purchase->codigo_tipo_pago = TipoPago::getTypePayment('voucher');
            $payment = TipoPago::find($purchase->codigo_tipo_pago);

            if(!$totalVoucher < $purchase->valor_total_compra){
                return redirect()->route('marketplace.compras.index')->withErrors(trans('purchase.voucher.insufficient', ['mediopago' => $payment->nombre_tipo_pago]),'purchase');
            }


            $purchase->codigo_estado = Estado::getState('confirm');
            $purchase->save();

            // Recursive function valid vouchers
             $purchase->consumeVoucher();

            // Send email notification
            $purchase->sendEmailPurchase($payment,false);

            return redirect()->route( 'marketplace.compras.success', ['purchase' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])] );
        }

        // If not shippment then redirect to next step  ( codigo_clase_producto es 3 para Servicios)
        // if($product->codigo_clase_producto == ClaseProducto::getClassProduct('service') ) {
        //     try {

        //         $data = [
        //             'codigo_compra' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])
        //         ];

        //         return redirect()->route('marketplace.compras.payment.edit', $data);
        //     }catch(\Exception $e){
        //         Log::error($e->getMessage());
        //         abort(500);
        //     }
        // }

        $data['action']= 'shipping' ;
        $data['purchase'] = $purchase;
        $data['product'] = $product;

        return view('public/marketplace/purchase/purchase', $data);
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
                abort(403);
            }

            $purchase = Compra::find($codigo_compra);
            if(!$purchase instanceof Compra) {
                abort(404);
            }

            // Validate secure transaction, only the buyer
            if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ) {
                abort(403);
            }

            try {
                if($request->has('shipping-type')) {
                    $request->session()->put("shipping_$purchase->codigo_compra", $request->get('shipping-type'));
                }

                $data = [
                    'codigo_compra' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])
                ];

                if($request->has('promotion_code') && !empty($request->promotion_code)){
                    $data['promotion_code'] = $request->promotion_code;
                }

                return redirect()->route('marketplace.compras.payment.edit', $data['codigo_compra']);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                abort(500);
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
