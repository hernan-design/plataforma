<?php

namespace App\Http\Controllers;

use App\AcuerdoCompra;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Log, Auth, Lang, Validator;

use App\Compra, App\EvaluacionCompra, App\ItemEvaluacionCompra, App\RespuestaEvalCompra, App\Estado;

class EvaluacionCompraController extends Controller
{

    /**
     * Instantiate a new EvaluacionCompraController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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


        if($request->ajax()) {
            $data = $request->all();

            $evaluationPurchase = new EvaluacionCompra;
            if ($evaluationPurchase->isValid($data)) {
                // Decrypt src-params
                list($codigo_compra) = TuProyecto::decryptSrcParams($request->input('codigo_compra'));
                if(!$codigo_compra || !is_numeric($codigo_compra)) {
                    abort(403);
                }

                // Validation user
                $purchase = Compra::find($codigo_compra);
                if(!$purchase instanceof Compra) {
                    abort(403);
                }

                // // Validate users update purchase
                if(in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario, $purchase->seg_codigo_usuario]) )
                {
                    $items = ItemEvaluacionCompra::getItemEvalPurchaseList();
                    DB::beginTransaction();
                    try {
                        // Insert Evaluation Purchase
                        $evaluationPurchase->fill($data);
                        switch ( $request->get('referee') ) {
                            case 'compras':
								$countItemsBuyer = 0;
								$valueItemsBuyer = [];
								if( in_array($purchase->codigo_estado, [Estado::getState('confirmed')] )) {
									foreach ($items as $item) {
										if($request->has("evaluacion_item_compra_$item->codigo_item_evaluacion_compra")) {
											$countItemsBuyer++;
											array_push($valueItemsBuyer, $request->get("evaluacion_item_compra_$item->codigo_item_evaluacion_compra"));
										}
									}
                                }
                                if( $countItemsBuyer > 0){
                                    $averageItemsBuyer = array_sum($valueItemsBuyer) / $countItemsBuyer;
                                }else{
                                    $averageItemsBuyer = 0;
                                   }

								$evaluationPurchase->promedio_evaluacion = round($averageItemsBuyer, 2);
                                $evaluationPurchase->tipo_evaluacion_compra = Compra::getTypeUser('seller');
                            break;

                            case 'ventas':
                            	$countItemsSeller = 0;
                            	$valueItemsSeller = [];
								if( in_array($purchase->codigo_estado, [Estado::getState('confirmed')] )) {
									foreach ($items as $item) {
										if($request->has("evaluacion_item_compra_$item->codigo_item_evaluacion_compra")) {
											$countItemsSeller++;
											array_push($valueItemsSeller, $request->get("evaluacion_item_compra_$item->codigo_item_evaluacion_compra"));
										}
									}
                                }
                               if( $countItemsSeller > 0){
                                $averageItemsSeller = array_sum($valueItemsSeller) / $countItemsSeller;
                               }else{
                                $averageItemsSeller = 0;
                               }


								$evaluationPurchase->promedio_evaluacion = round($averageItemsSeller, 2);
                                $evaluationPurchase->tipo_evaluacion_compra = Compra::getTypeUser('purchaser');
                            break;

                            default:
                                DB::rollback();
                                Log::error('Origen evaluacion no definido');
                                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                            break;
                        }

						$agreement = AcuerdoCompra::where('codigo_compra', $purchase->codigo_compra)->first();

                        $evaluationPurchase->codigo_compra = $purchase->codigo_compra;
                        $evaluationPurchase->codigo_estado = Estado::getState('active');
                        $evaluationPurchase->fecha_evaluacion_compra = date('Y-m-d H:m:s');
                        $evaluationPurchase->save();



                        if ($request->has('referee')) {
							if ($request->referee === 'compras') {
								if ($agreement != null) {
									$agreement->codigo_estado = Estado::getState('to_finalize');
									$agreement->save();
								}
							} else {
								if ($agreement != null) {
                                    if (\App\RegistroSesion::getInstitutionSlug() == 'rutan') {
									    $agreement->codigo_estado = Estado::getState('finalized');
                                    } else {
                                        $agreement->codigo_estado = Estado::getState('review_deliverables');
                                    }
									$agreement->save();
								}
							}
						}



                        if( in_array($purchase->codigo_estado, [Estado::getState('confirmed')] )) {
                            foreach ($items as $item) {
                                if($request->has("evaluacion_item_compra_$item->codigo_item_evaluacion_compra")) {
                                    $responseEvalPurchase = new RespuestaEvalCompra;
                                    $responseEvalPurchase->codigo_evaluacion_compra = $evaluationPurchase->codigo_evaluacion_compra;
                                    $responseEvalPurchase->codigo_item_evaluacion_compra = $item->codigo_item_evaluacion_compra;
                                    $responseEvalPurchase->valor_respuesta_eval_compra = $request->input("evaluacion_item_compra_$item->codigo_item_evaluacion_compra");
                                    $responseEvalPurchase->save();
                                }
                            }
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'message' => Lang::get('purchase.evaluation.success')]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                    }
                }
                abort(403);
            }
            return response()->json(['success' => false, 'errors' => $evaluationPurchase->errors]);
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
    public function update($id)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $tab
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function evaluate($tab, $id)
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

        // Only the user evaluate the buyer
        if( in_array($tab, ['compras'])) {
            if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ){
                abort(404);
            }
        }
        // Only the user evaluate the seller
        if( in_array($tab, ['ventas'])) {
            if( !in_array(Auth::user()->codigo_usuario, [$purchase->seg_codigo_usuario]) ){
                abort(404);
            }
        }
        return view('public/marketplace/main');
    }
}
