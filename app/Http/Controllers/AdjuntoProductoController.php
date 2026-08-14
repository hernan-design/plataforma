<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB, TuProyecto;

use App\AdjuntoProducto, App\Producto, App\Adjunto, App\Estado;

class AdjuntoProductoController extends Controller
{
    /**
     * Instantiate a new CompradorController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() && $request->has('product')) {
            list($codigo_producto) = TuProyecto::decryptSrcParams($request->input('product'));
            if(!$codigo_producto || !is_numeric($codigo_producto)) {
                abort(403);
            }

            $product = Producto::find($codigo_producto);
            if(!$product instanceof Producto) {
                abort(404);
            }
            return response()->json(AdjuntoProducto::getAttached($product->codigo_producto));
        }
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
        if (Request::ajax()) {

            $attached = Adjunto::find($id);
            if(!$attached instanceof Adjunto) {
                abort(404);
            }

            $product = Producto::find($request->input('codigo_proyecto'));
            if(!$product instanceof Producto) {
                App::abort(404);
            }

            DB::beginTransaction();
            try {

                // Update Product Image
                if($request->has('imagen_producto')){
                    Producto::where('codigo_producto', $product->codigo_producto)
                        ->update(['imagen_producto' => $request->input('imagen_producto')]);  
                }

                // Images gallery
                $images_gallery = Input::get('images_gallery');
                if(is_array($images_gallery)) { 
                    foreach ($images_gallery as $image) {
                        if(isset($image['direccion_adjunto']) && !empty($image['direccion_adjunto'])){

                            $validationAttached = AdjuntoProducto::getAttachedProduct($image['codigo_adjunto'], $product->codigo_producto);

                            if($validationAttached instanceof AdjuntoProducto){
                                // Update Attached Image
                                AdjuntoProducto::where('codigo_adjunto', $image['codigo_adjunto'] )->where('codigo_producto', $product->codigo_producto)->update(['direccion_adjunto' => $image['direccion_adjunto']]); 
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
                $response = Producto::buildProduct($product);
                $response->success = true;

                // Commit Transaction
                DB::commit();
                return response()->json($response);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }
        App::abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (Request::ajax()) {
            
            // // Decrypt src-params
            // list($codigo_adjunto) = TuProyecto::decryptSrcParams($id);
            // if(!$codigo_adjunto || !is_numeric($codigo_adjunto)) {
            //     abort(403);
            // }

            $attached = Adjunto::find($id);
            if(!$attached instanceof Adjunto) {
                abort(404);
            }

            $product = Producto::find($request->input('codigo_proyecto'));
            if(!$product instanceof Producto) {
                abort(404);
            }

            // Validate user update Images Product
            if(in_array(Auth::user()->codigo_usuario, [$product->codigo_usuario])) {
                DB::beginTransaction();
                try {

                    // Set removed Attached
                    Adjunto::where('codigo_adjunto', '=', $attached->codigo_adjunto)
                        ->update(['codigo_estado' => Estado::getState('removed')]);

                    // Update Attached Product
                    AdjuntoProducto::where('codigo_adjunto', $attached->codigo_adjunto )->where('codigo_producto', $product->codigo_producto)
                        ->update(['codigo_estado' => Estado::getState('removed')]); 

                    DB::commit();
                    return response()->json(['success' => true]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
            }
            abort(403);
        }
        abort(404);
    }
}
