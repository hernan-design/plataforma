<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TuProyecto, Auth, Log, DB;

use App\Promocion, App\DetallePromocion, App\Producto, App\Estado, App\RegistroSesion, App\UsuarioInstitucion, App\Institucion;

class PromocionController extends Controller
{
    /**
     * Instantiate a new PromocionController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('intended', ['only' => ['index', 'show']]);

        $this->middleware('ability:super-admin,view,marketplace', ['only' => ['index', 'show']]);
        $this->middleware('ability:super-admin,create,marketplace', ['only' => ['create', 'store']]);
        $this->middleware('ability:super-admin,edit,marketplace', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,remove,marketplace', ['only' => ['destroy']]);

        // $this->middleware('subscription', ['only' => ['create', 'store', 'update', 'destroy']]);
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
			return response()->json( Promocion::promotions( $request->all() ) );
		}
		return view('public/marketplace/main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Only create products when institucion has permission create-promotion
        if(!Institucion::hasPermission('create-promotion')) {
            abort(403);
        }

		// Only create promotions when user contains seller role
		if( Auth::user()->hasRole(['seller']) === false) {
        	return redirect()->route( 'marketplace.ventas.index' );
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
        // Only create products when institucion has permission create-promotion
        if(!Institucion::hasPermission('create-promotion')) {
            abort(403);
        }

        if($request->ajax()){
            $promotion_days = RegistroSesion::institution()->dias_maximos_promo;
            if(!is_null($promotion_days)){
                $validationDate = (strtotime($request->fecha_fin_promocion) - strtotime($request->fecha_inicio_promocion)) / (60 * 60 * 24);
                if($validationDate > $promotion_days){
                    return response()->json(['success' => false, 'errors' => "El intervalo entre la fecha de inicio y la fecha fin no puede ser superior a $promotion_days días, verifique."]);
                }
            }

            $data = $request->all();

			$userInstitution = UsuarioInstitucion::where('codigo_usuario', Auth::user()->codigo_usuario)
                ->where('codigo_institucion', RegistroSesion::getInstitution())->first();

            if($request->tipo_promocion == Promocion::getTypePromo('promotion')){
                $valPromotion = DetallePromocion::detailPromotionByProduct( $request->all() );
                if($valPromotion instanceof DetallePromocion){
                    return response()->json(['success' => false, 'errors' => 'Hay una promoción activa para este producto, verifique.']);
                }
            }

			$promotion = new Promocion;
			if($promotion->isValid($data)) {

				DB::beginTransaction();
	        	try {
					// Promotion
					$promotion->fill($data);
					$promotion->codigo_estado = Estado::getState('pending');
					$promotion->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
					$promotion->fecha_creacion_promocion = date("Y-m-d H:i:s");
		   			$promotion->save();

					$message = 'El anuncio se ha creado correctamente.';

					if($request->has('codigo_producto') && !empty($request->codigo_producto)){
						$product = Producto::find($request->codigo_producto);
						if(!$product instanceof Producto){
							abort(404);
                        }

                        $precio_producto = $product->producto_sin_precio ? 0 : $product->precio_producto;
						$promotionDetail = new DetallePromocion;
						$promotionDetail->codigo_producto = $request->codigo_producto;
						$promotionDetail->codigo_promocion = $promotion->codigo_promocion;
						$promotionDetail->codigo_estado = Estado::getState('pending');
						$promotionDetail->valor_detalle_promocion = ($request->porcentaje_descuento_promocion / 100) * $precio_producto;
						$promotionDetail->porcentaje_descuento_promocion = $request->porcentaje_descuento_promocion;
						$promotionDetail->save();

						$message = 'La promoción se ha creado correctamente.';
					}

		   			// Prepare response
					$response = $promotion;
					$response->codigo_promocion = TuProyecto::encryptSrcParams([$promotion->codigo_promocion]);
					$response->message = $message;
					$response->success = true;

					// Commit Transaction
					DB::commit();
					return response()->json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			return response()->json(array('success' => false, 'errors' => $promotion->errors));
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
		// Decrypt src-params
		list($codigo_promocion) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_promocion || !is_numeric($codigo_promocion)) {
			abort(403);
		}

		$validationType = Promocion::find($codigo_promocion);
		if(!$validationType instanceof Promocion){
            throw new \Exception("No se encontró el id: $codigo_promocion");
        }

        if($validationType->tipo_promocion == Promocion::getTypePromo('promotion')){
            $promotion = Promocion::promotion( $codigo_promocion );
        }

        if($validationType->tipo_promocion == Promocion::getTypePromo('advertisement')){
            $promotion = $validationType;
        }

		if($request->ajax()){
			return response()->json( Promocion::buildPromotion($promotion) );
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // Only create products when institucion has permission create-promotion
        if(!Institucion::hasPermission('create-promotion')) {
            abort(403);
        }

		// Decrypt src-params
		list($codigo_promocion) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_promocion || !is_numeric($codigo_promocion)) {
			abort(403);
        }

        $validationType = Promocion::find($codigo_promocion);
		if(!$validationType instanceof Promocion){
            throw new \Exception("No se encontró el id: $codigo_promocion");
        }

        if($validationType->tipo_promocion == Promocion::getTypePromo('promotion')){
            $promotion = Promocion::promotion( $codigo_promocion );
        }

        if($validationType->tipo_promocion == Promocion::getTypePromo('advertisement')){
            $promotion = $validationType;
        }

		if($request->ajax()){
			return response()->json( Promocion::buildPromotion($promotion) );
		}

		return view('public/marketplace/main');
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
        // Only create products when institucion has permission create-promotion
        if(!Institucion::hasPermission('create-promotion')) {
            abort(403);
        }

		if($request->ajax()){
            $promotion_days = RegistroSesion::institution()->dias_maximos_promo;
            if(!is_null($promotion_days)){
                $validationDate = (strtotime($request->fecha_fin_promocion) - strtotime($request->fecha_inicio_promocion)) / (60 * 60 * 24);
                if($validationDate > $promotion_days){
                    return response()->json(['success' => false, 'errors' => "El intervalo entre la fecha de inicio y la fecha fin no puede ser superior a $promotion_days días, verifique."]);
                }
            }

			$data = $request->all();

			// Decrypt src-params
			list($codigo_promocion) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_promocion || !is_numeric($codigo_promocion)) {
				abort(403);
			}

			$promotion = Promocion::find($codigo_promocion);
			if(!$promotion instanceof Promocion){
				abort(404);
			}

			$userInstitution = UsuarioInstitucion::where('codigo_usuario', Auth::user()->codigo_usuario)
                ->where('codigo_institucion', RegistroSesion::getInstitution())->first();

            $promotionDetail = DetallePromocion::where('codigo_promocion', $promotion->codigo_promocion)->first();

            if($request->tipo_promocion == Promocion::getTypePromo('promotion')){
                $valPromotion = DetallePromocion::detailPromotionByProduct( $promotionDetail->toArray() );
                if($valPromotion instanceof DetallePromocion){
                    return response()->json(['success' => false, 'errors' => 'Hay una promoción activa para este producto, verifique.']);
                }
            }

			if ($promotion->isValid($data)) {

				DB::beginTransaction();
	        	try {
					// Promotion
					$promotion->fill($data);
		   			$promotion->save();

					$message = 'El anuncio se ha editado correctamente.';

					if($request->has('codigo_producto') && !empty($request->codigo_producto)){
						$product = Producto::find($request->codigo_producto);
						if(!$product instanceof Producto){
							throw new \Exception("No se ha encontrado el código: $request->codigo_producto");
						}
                        $producto = $product->producto_sin_precio ? 0 : $product->precio_producto;
						$promotionDetail->codigo_producto = $request->codigo_producto;
						$promotionDetail->valor_detalle_promocion = ($request->porcentaje_descuento_promocion / 100) * $producto;
						$promotionDetail->porcentaje_descuento_promocion = $request->porcentaje_descuento_promocion;
						$promotionDetail->save();

						$message = 'La promoción se ha editado correctamente.';
					}

		   			// Prepare response
					$response = $promotion;
					$response->codigo_promocion = TuProyecto::encryptSrcParams([$promotion->codigo_promocion]);
					$response->message = $message;
					$response->success = true;

					// Commit Transaction
					DB::commit();
					return response()->json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			return response()->json(array('success' => false, 'errors' => $promotion->errors));
		}
		abort(404);
    }

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        //
    }
}
