<?php

namespace App\Http\Controllers;

use App\Discusion;
use App\DiscusionAcuerdoCompra;
use App\DiscusionInstitucion;
use App\Modulo;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, Log, Lang, DB, TuProyecto, Input, SendEmail, URL;

use App\RegistroSesion, App\Producto, App\ClaseProducto,App\TipoPago, App\Compra, App\DetalleCompra, App\Estado, App\DetalleVoucher, App\EntregableAcuerdo, App\TipoPagoInstitucion, App\Usuario, App\Institucion, Custom\Innpulsa, App\AcuerdoCompra, App\AsignacionMarketplace, App\DetallePromocion;

class CompraController extends Controller
{
	/**
	 * Instantiate a new CompradorController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');

        $this->middleware('ability:super-admin,view,marketplace');
	    $this->middleware('ability:super-admin,purchase,marketplace');

        // $this->middleware('subscription');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		// RegistroSesion::getIntitutionTypeCoin()
		if($request->ajax()) {
			return response()->json(Compra::getProductsUser(Compra::getTypeUser('purchaser')));
		}

		return view('public/marketplace/main');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if(!$request->has('product')) {
			Log::error(sprintf('%s:%s', 'App\Http\Controllers\CompraController', 'El request es incorrecto'));
			abort(404);
		}

		$product = Producto::getProductUrl($request->get('product'));
		if(!$product instanceof Producto) {
			Log::error(sprintf('%s:%s', 'App\Http\Controllers\CompraController', 'El código del producto no es válido'));
			abort(404);
        }

		return view('public/marketplace/main');
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

            // Decrypt src-params
            list($codigo_producto) = TuProyecto::decryptSrcParams($request->get('codigo_producto'));
            if(!$codigo_producto || !is_numeric($codigo_producto)) {
                Log::error(sprintf('%s:%s', 'CompraController:store', 'el codigo del producto no es numerico'));
                abort(403);
            }

            list($codigo_compra) = TuProyecto::decryptSrcParams($request->get('purchase') );
            if(!$codigo_compra || !is_numeric($codigo_compra)) {
                $codigo_compra = null;
            }

            $purchase = Compra::find($codigo_compra);
			if(!$purchase instanceof Compra) {
                $purchase = new Compra;
			}elseif ($purchase->codigo_estado === Estado::getState('offer')) {
                return response()->json([ 'success' => false, 'errors' => transtp('marketplace.offer.waiting') ]);

            }elseif ($purchase->codigo_estado !== Estado::getState('pending')) {
                return response()->json([ 'success' => false, 'errors' => transtp('marketplace.purchase.already') ]);

            }

            $product = Producto::find($codigo_producto);
            if(!$product instanceof Producto) {
                Log::error(sprintf('%s:%s', 'CompraController:store', 'No es posible encontrar el producto'));
                abort(404);
            }

            $institution = Institucion::find(RegistroSesion::getInstitution());
			if(!$institution instanceof Institucion){
                Log::error(sprintf('%s:%s', 'CompraController:store', 'No es posible encontrar la institucion'));
				abort(404);
            }

            $data['precio_producto'] = $product->producto_sin_precio ? 0 : $product->precio_producto;
			if ($purchase->isValid($data)) {

				$class = ClaseProducto::find($product->codigo_clase_producto);
				if(!$class instanceof ClaseProducto) {
                    Log::error(sprintf('%s:%s', 'CompraController:store', 'No se encuentra la clase de Producto'));
					abort(404);
				}

				$seller = Usuario::find($product->codigo_usuario);
				if(!$seller instanceof Usuario){
                    Log::error(sprintf('%s:%s', 'CompraController:store', 'No se encuentra al vendedor'));
					abort(404);
                }

                $purchaser = Usuario::find(Auth::user()->codigo_usuario);
			    if(!$purchaser instanceof Usuario){
                    Log::error(sprintf('%s:%s', 'CompraController:store', 'No se encuentra al comprador'));
				    abort(404);
			    }

				// Only units to validate product classes that require it
				if($class->manejo_unidades) {
					if( intval($request->get('unidades')) === 0) {
						return response()->json([ 'success' => false, 'errors' => trans('validation.required', ['attribute' => 'unidades']) ]);
					}

					if( intval($request->get('unidades')) > $product->cantidad_producto) {
						return response()->json([ 'success' => false, 'errors' => trans('purchase.units.insufficient', ['units' => $product->cantidad_producto]) ]);
					}
                }

				DB::beginTransaction();
				try {
					// Purchase
					$purchase->codigo_producto = $product->codigo_producto;
					if($class->manejo_unidades) {
						$purchase->unidad_producto = intval($request->unidades);
                    }

                    if(!empty($purchase->valor_total_compra) && $purchase->valor_total_compra > 0 && !$product->producto_sin_precio){
                        $valor_total_compra = $purchase->valor_total_compra;
                    }else if(!empty($product->precio_producto) && !$product->producto_sin_precio) {
                        $valor_total_compra = $product->precio_producto;
                    }else{
                        $valor_total_compra = 0;
                    }

                    if($request->has('promotion_code') && !empty($request->promotion_code)){
                        $promotion = DetallePromocion::where('codigo_promocion', $request->promotion_code)->first();
                        $valor_total_compra = doubleval($product->precio_producto - (($promotion->porcentaje_descuento_promocion / 100) * $product->precio_producto));
                    }

					$purchase->valor_total_compra = $valor_total_compra;
					$purchase->codigo_usuario = Auth::user()->codigo_usuario;
					$purchase->seg_codigo_usuario = $seller->codigo_usuario;
					$purchase->fecha_compra = date('Y-m-d');
					$purchase->hora_compra = date('H:i:s');
					$purchase->codigo_institucion = RegistroSesion::getInstitution();
                    $purchase->codigo_promocion = $request->has('promotion_code') && !empty($request->promotion_code) ? $request->promotion_code : null;
                    $purchase->codigo_estado = Estado::getState('pending');
                    $purchase->save();

                    $response = new \stdClass();

                    if($institution->pasos_compra) {

                        $response->redirect = 'marketplace.compras.shipping.edit';
                    }
                    else{

                        $purchase->codigo_tipo_pago = TipoPago::getTypePayment('voucher');
                        $payment = TipoPago::find($purchase->codigo_tipo_pago);

                        $totalVoucher = DetalleVoucher::getBalanceVoucher();

                        if($totalVoucher < $purchase->valor_total_compra){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => Lang::get('innpulsa.marketplace.purchase.voucherinsufficient')]);
                        }

                        // Recursive function valid vouchers
                        $purchase->consumeVoucher();

                        $purchase->codigo_estado = Estado::getState('confirm');
                        $purchase->save();

                        // Send email notification
                        $purchase->sendEmailPurchase($payment,false);

                        $response->redirect = 'marketplace.compras.success';

                    }

                    $response->codigo_compra = TuProyecto::encryptSrcParams([$purchase->codigo_compra]);
                    $response->success = true;

                    if($request->has('promotion_code') && !empty($request->promotion_code)){
                        $response->promotion_code = $request->promotion_code;
                    }

					// Commit Transaction
					DB::commit();
					return response()->json( $response );
				}catch(\Exception $e){
					DB::rollback();
					Log::error($e->getMessage());
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
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
	public function show(Request $request, $id)
	{

		if ($request->ajax()) {
			// Decrypt id
			list($codigo_compra) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_compra || !is_numeric($codigo_compra)) {
				abort(403);
			}

			$purchase = Compra::getPurchase($codigo_compra);
			if(!$purchase instanceof Compra) {
				abort(404);
            }

            $response = Compra::buildProductUser($purchase);

			if($request->has('type')) {

				if($purchase->codigo_estado == Estado::getState('confirm')){
					$purchase->codigo_estado = Estado::getState('confirmed');
					$purchase->save();
					$response->state_purchase = 'confirmed';
				}

                $response->acuerdos_adjuntos = [];

				if($response->acuerdo_compra){
					// Decrypt src-params
					list($codigo_acuerdo_compra) = TuProyecto::decryptSrcParams($response->codigo_acuerdo_compra);
					if(!$codigo_acuerdo_compra || !is_numeric($codigo_acuerdo_compra)) {
						abort(403);
					}
					$response->codigo_acuerdo_compra_decrypt = $codigo_acuerdo_compra;

					$deliverableFinal = EntregableAcuerdo::getDeliverableFinal($codigo_acuerdo_compra);

					$deliverableCertificate = EntregableAcuerdo::getDeliverableCertificate($codigo_acuerdo_compra);

					$response->acuerdos_adjuntos = EntregableAcuerdo::getDeliverableAttachment($codigo_acuerdo_compra);
					if ($deliverableFinal != null) {
						$response->codigo_adjunto_informe_final = $deliverableFinal->codigo_adjunto;
						$response->nombre_adjunto_informe_final = $deliverableFinal->nombre_adjunto;
						$response->direccion_adjunto_informe_final = $deliverableFinal->direccion_adjunto;
					}

					if ($deliverableCertificate != null) {
						$response->codigo_adjunto_certificate = $deliverableCertificate->codigo_adjunto;
						$response->nombre_adjunto_certificate = $deliverableCertificate->nombre_adjunto;
						$response->direccion_adjunto_certificate = $deliverableCertificate->direccion_adjunto;
					}

					$response->url_encuesta = RegistroSesion::getVoucherGeneralEvaluation();


				}else{

                }
			}

            $response->url_encuesta = RegistroSesion::getVoucherGeneralEvaluation();



			return  response()->json($response);
		}
		abort(404);
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
		if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_compra) = TuProyecto::decryptSrcParams($request->input('codigo_compra'));
			if(!$codigo_compra || !is_numeric($codigo_compra)) {
				App::abort(403);
			}

			$purchase = Compra::find($codigo_compra);
			if(!$purchase instanceof Compra) {
				abort(404);
			}

			$purchaser = Usuario::find($purchase->codigo_usuario);
			if(!$purchaser instanceof Usuario){
				abort(404);
			}

			$product = Producto::find($purchase->codigo_producto);
			if(!$product instanceof Producto) {
				abort(404);
			}

			$seller = Usuario::find($product->seg_codigo_usuario);
			if(!$seller instanceof Usuario){
				abort(404);
			}

			$sellerUser = Usuario::find($purchase->seg_codigo_usuario);
			if(!$sellerUser instanceof Usuario){
				abort(404);
			}

			$adviser = Usuario::find($product->seg_codigo_usuario);
			if(!$adviser instanceof Usuario){
				abort(404);
			}

			DB::beginTransaction();
			try {
				$state_purchase = $message = null;
				switch ($request->input('state_purchase')) {
					case 'pending':
						if($request->has('cancel_purchase')) {
							$purchase->codigo_estado = Estado::getState('removed');
							$state_purchase = 'removed';
						}
					break;

					case 'confirm':
						if($request->has('cancel_purchase') || $request->has('cancel_sale')) {
							$purchase->codigo_estado = Estado::getState('cancelled');
							$state_purchase = 'cancelled';
						}
						if($request->has('confirmed_purchase') || $request->has('confirmed_sale') ) {
							$purchase->codigo_estado = Estado::getState('confirmed');
							$state_purchase = 'confirmed';
						}
					break;

					case 'confirmed':
						$agreement = AcuerdoCompra::where('codigo_compra', $purchase->codigo_compra)->first();
						// Institution
						$institution = Institucion::find(RegistroSesion::getInstitution());
						if($purchase->seg_codigo_usuario == Auth::user()->codigo_usuario){
								if ($request->has('rejection_of_deliverables')) {
									$message = transtp('marketplace.agreement.deriverable');
									Innpulsa::sendEmailDeliverables($purchaser, $sellerUser, $adviser, $purchase, $product, $institution);

									$agreement->codigo_estado = Estado::getState('review_deliverables');
									$agreement->save();
							} else {
								// Other actions institution
								switch (RegistroSesion::getInstitution()) {
									case Institucion::getInstitution('innpulsa'):
										$message = transtp('marketplace.agreement.deriverable');
										Innpulsa::sendEmailDeliverables($purchaser, $sellerUser, $adviser, $purchase, $product, $institution);

										break;
								}
								$state_purchase = 'confirmed';
							}
						}

						if($purchase->codigo_usuario == Auth::user()->codigo_usuario){
							if ($request->has('refuse_deliverables') && $request->has('comment_refuse')) {
								$module = Modulo::find($request->codigo_modulo);
								if(!$module instanceof Modulo) {
									abort(403);
								}

								$agreement->codigo_estado = Estado::getState('rejection_of_deliverables');
								$agreement->save();

								$discussion = new Discusion();
								$discussion->codigo_estado = Estado::getState('active');
								$discussion->codigo_usuario = Auth::user()->codigo_usuario;
								$discussion->texto_discucion = $request->comment_refuse;
								$discussion->codigo_modulo = $module->codigo_modulo;
								$discussion->fecha_discucion = date('Y-m-d H:i:s');
								$discussion->save();

								$discussionInst = new DiscusionInstitucion();
								$discussionInst->codigo_discucion = $discussion->codigo_discucion;
								$discussionInst->codigo_institucion = RegistroSesion::getInstitution();
								$discussionInst->codigo_estado = Estado::getState('active');
								$discussionInst->save();

								$resourceDiscussion = new DiscusionAcuerdoCompra();
								$resourceDiscussion->codigo_acuerdo_compra = $agreement->codigo_acuerdo_compra;
								$resourceDiscussion->codigo_discucion = $discussion->codigo_discucion;
								$resourceDiscussion->codigo_estado = Estado::getState('active');
								$resourceDiscussion->fecha_discusion = date('Y-m-d H:i:s');
								$resourceDiscussion->save();

								switch (RegistroSesion::getInstitution()) {
									case Institucion::getInstitution('innpulsa'):
										$message = transtp('marketplace.agreement.deriverable');
										Innpulsa::sendEmailRefuseDeliverables($purchase, $purchaser, $sellerUser, $product, $institution, $request->comment_refuse, $codigo_compra);

										break;
								}

								$state_purchase = 'confirmed';
							} else {
								$agreement->codigo_estado = Estado::getState('to_finalize');
								$agreement->fecha_aceptacion_entregables = date('Y-m-d');

								if (date("d") > 5) {
									$month = date("m") + 1;

									$agreement->fecha_inicio_revision_entregables = date('Y').'-'.$month.'-'."06";
									$agreement->fecha_fin_revision_entregables = date("Y-m-t", strtotime($agreement->fecha_inicio_revision_entregables));
								} else {
									$agreement->fecha_inicio_revision_entregables = date('Y-m').'-'."06";
									$agreement->fecha_fin_revision_entregables = date("Y-m-t", strtotime($agreement->fecha_inicio_revision_entregables));
								}

								$agreement->save();

								$assignmentMembers = AsignacionMarketplace::getAssignmentsMember($agreement->codigo_acuerdo_compra);
								// Other actions institution
								switch (RegistroSesion::getInstitution()) {
									case Institucion::getInstitution('innpulsa'):
										$message = transtp('marketplace.agreement.deriverable');
										Innpulsa::sendEmailConfirmDeliverables($assignmentMembers, $purchase, $purchaser, $sellerUser, $product, $institution);

										$monthCurrentRevision = explode(' ', TuProyecto::dateFormat($agreement->fecha_inicio_revision_entregables, 'month'));
										$monthCurrent = explode(' ', TuProyecto::dateFormat(date('Y-m-d'), 'month'));

										// Send notification
										$data['_template'] = 'emails.marketplace.revisiondeliverables';
										$data['_to'] = $sellerUser->correo_electronico;
										$data['_to_name'] = ucwords(strtolower($sellerUser->nombre_usuario));
										$data['_subject'] = 'Revision de entregables';
										$data['_buyer'] = $purchaser->nombre_usuario;
										$data['_product'] = $product->nombre_producto;
										$data['_value_product'] = $product->producto_sin_precio ? 0 : $product->precio_producto;
										$data['_month_current'] = $monthCurrent[1];
										$data['_name_month'] = $monthCurrentRevision[1];
										$data['_date_start_revision'] = $agreement->fecha_inicio_revision_entregables;
										$data['_date_end_revision'] = $agreement->fecha_fin_revision_entregables;

										SendEmail::notification($data);

										break;
								}

								$state_purchase = 'finalized';
							}
						}
					break;

					case 'offered':
						$data = [];
						$data['_inst'] = RegistroSesion::getInstitution();

						// Only seller
						if(!in_array(Auth::user()->codigo_usuario, [$purchase->seg_codigo_usuario])) {
							throw new \Exception('La oferta solo puede ser verificada por el vendedor.');
						}

						if($request->has('confirm_offer') && $request->confirm_offer) {
							$purchase->codigo_estado = Estado::getState('pending');
							$state_purchase = 'pending';
							$message = transtp('marketplace.offer.confirmed');

							// Send notification
							$data['_template'] = 'emails.marketplace.offeracceptance';
							$data['_subject'] = 'Aceptación de oferta';
							$data['_product'] = $product->nombre_producto;
							$data['_url_action'] = route('marketplace.compras.index');

						}else if($request->has('confirm_offer') && !$request->confirm_offer) {
							$purchase->codigo_estado = Estado::getState('rejected');
							$state_purchase = 'rejected';
							$message = transtp('marketplace.offer.rejected');

							// Send notification
							$data['_template'] = 'emails.marketplace.offerrejection';
							$data['_subject'] = 'Rechazo de oferta';
							$data['_product'] = $product->nombre_producto;
						}

						$data['_to'] = $purchaser->correo_electronico;
						$data['_to_name'] = ucwords(strtolower($purchaser->nombre_usuario));
						$data['_seller'] = ucwords(strtolower($seller->nombre_usuario));
						SendEmail::notification($data);
					break;
				}

				$purchase->save();

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'state_purchase' => $state_purchase, 'message' => $message]);

			}catch(\Exception $e){
				DB::rollback();
				Log::error(sprintf('%s:%s', 'CompraController:update', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
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
	 * valid Balance Voucher.
	 *
	 * @param  int  $purchase
	 */
	public function validVoucher(Request $request, $id)
	{
		if ($request->ajax()) {
			try {
				// Decrypt id
				list($codigo_compra) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_compra || !is_numeric($codigo_compra)) {
					abort(403);
				}
				// Validate purchase
				$purchase = Compra::getPurchase($codigo_compra);
				if(!$purchase instanceof Compra) {
					abort(404);
				}

				// Validate payment type
				$payment = null;
				if($request->has('payment') && !empty($request->payment)) {
					$payment = TipoPagoInstitucion::join('core.tipo_pago', 'tipo_pago_institucion.codigo_tipo_pago', '=', 'tipo_pago.codigo_tipo_pago')
						->where('tipo_pago_institucion.codigo_tipo_pago', '=', $request->payment)
						->where('tipo_pago_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())->first();
				}
				if(!$payment instanceof TipoPagoInstitucion){
					throw new \Exception("Error recuperando tipo de pago $request->payment");
				}

				// Prepare response
				$response = new \stdClass();
				$response->success = true;

				// Validate
				$totalVoucher = DetalleVoucher::getBalanceVoucher();
				if($payment->moneda_virtual && $totalVoucher < $purchase->valor_total_compra){
					$response->errors = trans('purchase.voucher.insufficient', ['mediopago' => $payment->nombre_tipo_pago]);
                    $response->success = false;

				}
				return response()->json($response);

			}catch(\Exception $e){
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
    }

}
