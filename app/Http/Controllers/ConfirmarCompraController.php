<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Custom\Innpulsa;

use TuProyecto, DB, Log, Auth, Lang, URL, SendEmail, Input, Session, App, Validator;

use App\Producto, App\Compra, App\TipoEnvio, App\TipoPago, App\ClaseProducto, App\Usuario, App\Estado, App\DetalleVoucher, App\ConsumoVoucher, App\RegistroSesion, App\Institucion;

class ConfirmarCompraController extends Controller
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

        // Validate existence of product
        $product = Producto::find($purchase->codigo_producto);
        if(!$product instanceof Producto) {
            abort(404);
        }

        // Validate secure transaction, only the buyer
        if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ) {
        abort(403);
        }

		// Validate previus requierement for Servicios
		if (($product->codigo_clase_producto != ClaseProducto::getClassProduct('service')) && !$request->session()->has("shipping_$purchase->codigo_compra")) {
			return redirect()->route('marketplace.compras.shipping.edit', TuProyecto::encryptSrcParams([$purchase->codigo_compra]));
		} 
 
		// Validate previus requierement
		if (!$request->session()->has("payment_$purchase->codigo_compra")) {
			return redirect()->route('marketplace.compras.payment.edit', TuProyecto::encryptSrcParams([$purchase->codigo_compra]));
		}

       // Check if shipping exists for Servicios
        $shipping = false;
        if($product->codigo_clase_producto != ClaseProducto::getClassProduct('service')) {

		    $shipping = TipoEnvio::find($request->session()->get("shipping_$purchase->codigo_compra"));
		    if(!$shipping instanceof TipoEnvio) {
			    abort(404);
            }
        }
 
		$payment = TipoPago::find($request->session()->get("payment_$purchase->codigo_compra"));
		if(!$payment instanceof TipoPago) {
			abort(404);
		}

		return view('public/marketplace/purchase/purchase', ['action' => 'confirm',
			'purchase' => $purchase,
			'product' => $product,
			'shipping' => $shipping,
            'payment' => $payment
		]);
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
            
			$product = Producto::find($purchase->codigo_producto);
			if(!$product instanceof Producto) {
				abort(404);
			}
            
			// Validate secure transaction, only the buyer
			if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ) {
				abort(403);
			}
           
           // Check if shipping exists for Servicio
            $shipping = false;
            if( ($product->codigo_clase_producto != ClaseProducto::getClassProduct('service')) ) {
    
                $shipping = TipoEnvio::find($request->session()->get("shipping_$purchase->codigo_compra"));
                if(!$shipping instanceof TipoEnvio) {
                    abort(404);
                }
            }


			$payment = TipoPago::find($request->session()->get("payment_$purchase->codigo_compra"));
			if(!$payment instanceof TipoPago) {
				abort(404);
			}

			DB::beginTransaction();
			try {

                
				$purchase->codigo_tipo_pago = $payment->codigo_tipo_pago;
				
				if($purchase->codigo_tipo_pago == TipoPago::getTypePayment('voucher') || $purchase->codigo_tipo_pago == TipoPago::getTypePayment('voucher-aldea')){

					// Valid balance user vouchers
					$totalVoucher = DetalleVoucher::getBalanceVoucher();
					if($totalVoucher < $purchase->valor_total_compra){
						return redirect()->route('marketplace.compras.confirm.edit', ['confirm' => $id])->withErrors(trans('purchase.voucher.insufficient', ['mediopago' => $payment->nombre_tipo_pago]),'purchase');
                    }

                    $purchase->codigo_estado = Estado::getState('confirm');
                    $purchase->save();
                
					// Recursive function valid vouchers
					$purchase->consumeVoucher();
				}else{

					if (RegistroSesion::getInstitution() == 61) {
						// Valid balance user vouchers
						$totalVoucher = DetalleVoucher::getBalanceVoucher();
						if($totalVoucher < $purchase->valor_total_compra){
							return redirect()->route('marketplace.compras.confirm.edit', ['confirm' => $id])->withErrors(trans('purchase.voucher.insufficient', ['mediopago' => $payment->nombre_tipo_pago]),'purchase');
						}

						$purchase->consumeVoucherRutan();
					}

					$purchase->codigo_estado = Estado::getState('confirm');
					$purchase->save();
				}

               
                // Send notification email 
				$purchase->sendEmailPurchase($payment, $shipping, $product);
                
                
				DB::commit();

				return redirect()->route( 'marketplace.compras.success', ['purchase' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])] );
			}catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s:%s', 'ConfirmarCompraController:update', $e->getMessage()));
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function success(Request $request, $id)
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

			$seller = Usuario::find($purchase->seg_codigo_usuario);
			if(!$seller instanceof Usuario) {
				abort(404);
			}

			return view('public/marketplace/purchase/success', [
				'purchase' => $purchase,
				'seller' => $seller
			]);

		}
		abort(404);
	}
}
