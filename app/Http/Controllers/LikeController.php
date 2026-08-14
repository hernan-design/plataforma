<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Request, Response, Input, DB, Auth, Lang, App, Log;

use TuProyecto;

use App\Like, App\Estado, App\PuntoUsuario, App\RegistroSesion;

class LikeController extends Controller {

	/**
     * Instantiate a new LikeController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::ajax()) {
			return Response::json(Like::search());
		}
    	App::abort(404);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Request::ajax()) {
			$data = Input::all();
			DB::beginTransaction();
        	try {
				// Decrypt src-params
				list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams(Input::get('srcparams'));
				if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
					throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
				}
				if(!$id_recurso || !is_numeric($id_recurso)) {
					throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso']));
				}

				$query = Like::query();
				$query->where('like.codigo_recurso_modulo', $codigo_recurso_modulo);
				$query->where('like.id_recurso', $id_recurso);
				$query->where('like.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('like.codigo_estado', Estado::getState('active'));
				$query->where('like.codigo_institucion', RegistroSesion::getInstitution());
		   		$like = $query->first();

		   		if(!$like instanceof Like) {
		 			// Like
					$like = new Like;
					$like->codigo_recurso_modulo = $codigo_recurso_modulo;
					$like->id_recurso = $id_recurso;
					$like->codigo_estado = Estado::getState('active');
		   			$like->codigo_usuario = Auth::user()->codigo_usuario;
		   			$like->fecha_like = date('Y-m-d');
		   			$like->hora_like = date('H:i:s');
		   			$like->codigo_institucion = RegistroSesion::getInstitution();
		   			$like->save();

		   			// Gamification (Depending of resource)
		   			// $object = Like::getResourceLike($like->id_recurso, $like->codigo_recurso_modulo);
		   			// if(!is_null($object) && !is_null($object->gamification_class) && !is_null($object->resource)){
			   		// 	PuntoUsuario::gamification($object->gamification_class, Estado::getState('active'), $object->resource->codigo_usuario, $like->codigo_like);
		   			// }
		   		}
	   			// Prepare response
				$response = Like::buildLike($like);
				$response->success = true;

				// Commit Transaction
				DB::commit();

				// Get count likes
				$response->contador_like = Like::contador($like);
				return Response::json($response);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => $e->getMessage()]);
			}
		}
    	App::abort(404);
   	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (Request::ajax()) {
			try {
				// Decrypt src-params
				list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
					throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
				}
				if(!$id_recurso || !is_numeric($id_recurso)) {
					throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'id_recurso']));
				}

				$query = Like::query();
				$query->where('like.codigo_recurso_modulo', $codigo_recurso_modulo);
				$query->where('like.id_recurso', $id_recurso);
				$query->where('like.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('like.codigo_estado', Estado::getState('active'));
		   		$like = $query->first();

		   		$contador_like = 0;
		   		if($like instanceof Like) {
		   			$response = Like::buildLike($like);
		   			$response->contador_like = Like::contador($like);
		   			$response->auth_like = true;
		   			$response->success = true;

		            return response()->json( $response );
		   		}else {
		   			$object = new \stdClass();
		   			$object->codigo_recurso_modulo = $codigo_recurso_modulo;
		   			$object->id_recurso = $id_recurso;
		   			$object->codigo_institucion = RegistroSesion::getInstitution();
		   			$contador_like = Like::contador($object);
		   		}

            	return response()->json(['success' => true, 'auth_like' => false, 'contador_like' => $contador_like]);

            }catch(\Exception $e){
				Log::error(sprintf('%s:%s', 'LikeController store', $e->getMessage()));
            	return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
    	abort(404);
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
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Request::ajax()) {
			DB::beginTransaction();
			try {
				$like = Like::find($id);
				if(!$like instanceof Like) {
    				App::abort(404);
				}

				if(Auth::user()->codigo_usuario == $like->codigo_usuario) {
					// Set removed state
					$like->codigo_estado = Estado::getState('removed');
					$like->save();

					// Gamification (remove points) (Depending of resource)
		   			// $object = Like::getResourceLike($like->id_recurso, $like->codigo_recurso_modulo);
		   			// if(!is_null($object) && !is_null($object->gamification_class) && !is_null($object->resource)){
			   		// 	PuntoUsuario::gamification($object->gamification_class, Estado::getState('removed'), $object->resource->codigo_usuario, $like->codigo_like);
		   			// }
					// Commit Transaction
					DB::commit();
				}else{
					DB::rollback();
				}

				return Response::json(['success' => true, 'value_txt' => Lang::get('like.like'), 'contador_like' => Like::contador($like)]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
			}
		}
    	App::abort(404);
    }


}
