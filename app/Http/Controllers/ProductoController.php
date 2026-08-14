<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Request, Response, Redirect, View, Auth, Input, App, DB, Log, Lang, URL, stdClass;

use Custom\Innpulsa, TuProyecto;

use App\Producto, App\Estado, App\ClaseProducto, App\RegistroSesion, App\Compra, App\Usuario, App\Adjunto, App\AdjuntoProducto, App\TipoAdjunto, App\PrivacidadContenido, App\Institucion;

class ProductoController extends Controller {

    /**
     * Instantiate a new ProductoController instance.
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
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()){
			if(Request::has('user')){
				return Response::json(Producto::productsByUser());
			}
			if(Request::has('list') || Request::has('dataId')){
				return Response::json(Producto::productsList());
			}
			return Response::json(Producto::getProducts());
		}
		return View::make('public/marketplace/main');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
       // Only create products when institucion has permission create-products
        if(!Institucion::hasPermission('create-products')) {
            abort(403);
        }

		// Only create products when user contains seller role
		if( Auth::user()->hasRole(['seller']) === false) {
        	return redirect()->route( 'marketplace.ventas.create' );
		}

		return View::make('public/marketplace/main');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        // Only create products when institucion has permission create-products
        if(!Institucion::hasPermission('create-products')) {
            abort(403);
        }

		if (Request::ajax()) {
		 	$data = Input::all();

			$product = new Producto;
			if ($product->isValid($data)) {

				if(Input::has('seg_codigo_usuario') && Input::get('seg_codigo_usuario')){
					// Decrypt src-params
					list($seg_codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('seg_codigo_usuario'));
					if(!$seg_codigo_usuario || !is_numeric($seg_codigo_usuario)) {
						abort(403);
					}
				}

				// Validate unique url
				$seo_url = TuProyecto::seoUrl(Input::get('nombre_producto'));



				DB::beginTransaction();
	        	try {
					// Product
					$product->fill($data);

					$product->seg_codigo_usuario = Input::has('type_owner') && Input::get('type_owner') == Usuario::typeUser('person') ? Auth::user()->codigo_usuario : $seg_codigo_usuario;
					$product->codigo_estado = Estado::getState('pending');
					$product->codigo_usuario = Auth::user()->codigo_usuario;
					$product->url_producto = Producto::validateUrl($seo_url);
                    $product->codigo_institucion = RegistroSesion::getInstitution();
                    $product->precio_producto = Input::has('producto_sin_precio') && Input::get('producto_sin_precio') ? 0 : Input::get('precio_producto');
		   			$product->save();

					// Images gallery
					$images_gallery = Input::get('images_gallery');
					if(is_array($images_gallery)) {
						foreach ($images_gallery as $image) {
							if(isset($image['direccion_adjunto']) && !empty($image['direccion_adjunto'])){
								// Attached
								$attached = new Adjunto();
								$attached->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('image');
					   			$attached->direccion_adjunto = $image['direccion_adjunto'];
					   			$attached->codigo_privacidad_contenido =  PrivacidadContenido::getPrivacy('public');
                                $attached->fecha_adjunto = date('Y-m-d H:i:s');
					   			$attached->save();

								// Product Attached
								$attachedProduct = new AdjuntoProducto();
								$attachedProduct->codigo_adjunto = $attached->codigo_adjunto;
								$attachedProduct->codigo_producto = $product->codigo_producto;
								$attachedProduct->codigo_estado = Estado::getState('active');
					   			$attachedProduct->save();
					   		}
						}
					}

		   			// Prepare response
					$response = Producto::buildProduct($product);
					$response->success = true;

					// Commit Transaction
					DB::commit();
					return Response::json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return Response::json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			return Response::json(array('success' => false, 'errors' => $product->errors));
		}
    	App::abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($url)
	{
		$product = Producto::getProductUrl($url);
		if(!$product instanceof Producto) {
            abort(404);
		}

		// Only owner user and product active
		if(!in_array($product->codigo_estado, [Estado::getState('active')])) {
			if( !Auth::check() || !in_array(Auth::user()->codigo_usuario, [$product->codigo_usuario, $product->seg_codigo_usuario]) ) {
				abort(404);
			}
		}

		if (Request::ajax()) {
            $response = Producto::buildProduct($product);
			$response->averagepurchase = $product->usuario->getAveragePurchase(Compra::getTypeUser('purchaser'));
            return Response::json($response);
        }

		return View::make('public/marketplace/main');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        // Only create products when institucion has permission edit
        if(!Institucion::hasPermission('edit')) {
            abort(403);
        }

		if (Request::ajax()) {

			// Decrypt src-params
            list($codigo_producto) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_producto || !is_numeric($codigo_producto)) {
                App::abort(403);
            }

			$product = Producto::find($codigo_producto);
			if(!$product instanceof Producto) {
	            App::abort(404);
			}

            $class = ClaseProducto::find($product->codigo_clase_producto);
            if(!$class instanceof ClaseProducto) {
                abort(404);
            }

			// Get all data
			$data = Input::all();

			// Validate users update product
			if(Auth::user()->codigo_usuario == $product->codigo_usuario) {
				DB::beginTransaction();
	        	try {
					$product->fill($data);

					// seg_codigo_usuario
					if(isset($data['seg_codigo_usuario'])) {
						$product->seg_codigo_usuario = $data['seg_codigo_usuario'];
					}

					// Domicile
					$product->domicilio_producto = false;
					if(Input::has('domicilio_producto')) {
						$product->domicilio_producto = true;
					}

					switch (Input::get('state_product')) {
					    case 'pending':
					    	// Valid publication
					    	if(Input::has('add_request')){

					    		if ( $product->isValidPublication($product->toArray()) ) {
	    			                // Only units to validate product classes that require it
					                if($class->manejo_unidades) {
					                    if( intval($product->cantidad_producto) === 0) {
					                        DB::rollback();
					                        return response()->json([ 'success' => false, 'errors' => trans('validation.required', ['attribute' => 'unidades']) ]);
					                    }
					                }

									// Valid state edit fields institution
									$institution = RegistroSesion::institution();
									switch ($institution->codigo_institucion) {
										case Institucion::getInstitution('innpulsa'):
											$product->codigo_estado = Estado::getState('active');
										break;
										default:
											$product->codigo_estado = Estado::getState('review');
										break;
									}
					    		}else{
					    			DB::rollback();
	    							return response()->json(['success' => false, 'errors' => $product->errors]);
					    		}
					    	}
				        break;
				        case 'review':
				        	if(Input::has('cancel_request')){
				        		$product->codigo_estado = Estado::getState('pending');
					    	}
					    case 'published':
				        	if(Input::has('finish_request')){
				        		$product->codigo_estado = Estado::getState('pending');
					    	}
			        	break;
					}
					$product->save();

		            // Images gallery
					$images_gallery = Input::get('images_gallery');
					if(is_array($images_gallery)) {
						foreach ($images_gallery as $image) {
							if(isset($image['direccion_adjunto']) && !empty($image['direccion_adjunto'])) {
								if(isset($image['codigo_adjunto']) && $image['codigo_adjunto'] != null && is_numeric($image['codigo_adjunto']) ) {
									// Attached
									$attached = Adjunto::find($image['codigo_adjunto']);
									if($attached instanceof Adjunto) {
										$attached->direccion_adjunto = $image['direccion_adjunto'];
							   			$attached->save();
									}
								}else{
									// Attached
									$attached = new Adjunto();
									$attached->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('image');
						   			$attached->direccion_adjunto = $image['direccion_adjunto'];
						   			$attached->codigo_privacidad_contenido =  PrivacidadContenido::getPrivacy('public');
                                    $attached->fecha_adjunto = date('Y-m-d H:i:s');
						   			$attached->save();

									// Product Attached
									$attachedProduct = new AdjuntoProducto();
									$attachedProduct->codigo_adjunto = $attached->codigo_adjunto;
									$attachedProduct->codigo_producto = $product->codigo_producto;
									$attachedProduct->codigo_estado = Estado::getState('active');
						   			$attachedProduct->save();
								}
					   		}
						}
					}

					// Prepare response
		   			$response = Producto::buildProduct(Producto::getProductUrl($product->url_producto));
					$response->success = true;
					$response->state_product = $response->state_product;

					// Commit Transaction
					DB::commit();
					return Response::json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return Response::json(array('success' => false, 'errors' => trans('app.exception')));
				}
			}
			return Response::json(array('success' => false, 'errors' => $product->errors));
		}
		App::abort(404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        // Only create products when institucion has permission create-products
        if(!Institucion::hasPermission('create-products')) {
            abort(403);
        }

		if (Request::ajax()) {

			$product = Producto::find(Input::get('codigo_producto'));
			if(!$product instanceof Producto) {
				App::abort(404);
			}

			// Validate users update proyect
			if(in_array(Auth::user()->codigo_usuario, $user->getAllowedUsers())) {
				DB::beginTransaction();
				try {
					// Set removed state
					Producto::where('codigo_producto', '=', $product->codigo_producto)
						->update(array('codigo_estado' => Estado::getState('removed')));

					DB::commit();
					return Response::json(array('success' => true));
				}catch(\Exception $e){
					DB::rollback();
					Log::error($e->getMessage());
					return Response::json(array('success' => false, 'errors' => trans('app.exception')));
				}
			}
			App::abort(403);
		}
    	App::abort(404);
	}

}
