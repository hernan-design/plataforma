<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Auth, Log;

use App\WishlistProducto, App\Estado;

class FavController extends Controller
{
	/**
	 * Instantiate a new LikeController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'store', 'update']]);
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
		if ($request->ajax()) {
			DB::beginTransaction();
			try {
				// Decrypt src-params
				list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams($request->srcparams);
				if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
					throw new \Exception(trans('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
				}
				if(!$id_recurso || !is_numeric($id_recurso)) {
					throw new \Exception(trans('app.exception.srcparams', ['field' => 'id_recurso']));
				}

				$fav = new WishlistProducto;
				$fav->codigo_producto = $codigo_recurso_modulo;
				$fav->codigo_usuario = Auth::user()->codigo_usuario;
				$fav->codigo_estado = $request->favorito_auth ? Estado::getState('active') : Estado::getState('removed');
				$fav->fecha_wishlist_producto = date('Y-m-d');
				$fav->save();

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'codigo_favorito' => $fav->codigo_wishlist_producto, 'favorito_auth' => true]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => $e->getMessage()]);
			}
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
		if ($request->ajax()) {
			DB::beginTransaction();
			try {
				// Decrypt src-params
				list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams($request->srcparams);
				if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
					throw new \Exception(trans('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
				}
				if(!$id_recurso || !is_numeric($id_recurso)) {
					throw new \Exception(trans('app.exception.srcparams', ['field' => 'id_recurso']));
				}

				$query = WishlistProducto::query();
				$query->where('codigo_producto', $codigo_recurso_modulo);
				$query->where('codigo_usuario', Auth::user()->codigo_usuario);
				$fav = $query->first();

				if(!$fav instanceof WishlistProducto) {
					$fav = new WishlistProducto;
					$fav->codigo_producto = $codigo_recurso_modulo;
					$fav->codigo_usuario = Auth::user()->codigo_usuario;
				}

				$fav->codigo_estado = $request->favorito_auth ? Estado::getState('active') : Estado::getState('removed');
				$fav->fecha_wishlist_producto = date('Y-m-d');
				$fav->save();

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'favorito_auth' => $fav->codigo_estado == Estado::getState('active') ? true : false]);
			}catch(\Exception $e){
				DB::rollback();
				// Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => $e->getMessage()]);
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
