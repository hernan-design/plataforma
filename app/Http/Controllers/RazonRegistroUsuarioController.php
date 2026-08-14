<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use TuProyecto;

use Request, View, Response, Auth, App, Input, DB, Lang;

use App\RazonRegistro, App\RazonRegistroUsuario, App\Estado;

class RazonRegistroUsuarioController extends Controller {

    /**
     * Instantiate a new RazonRegistroUsuarioController instance.
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
		if(Request::ajax()){
			return Response::json(RazonRegistroUsuario::getReasons());
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
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		if (Request::ajax()) {
			$reason = RazonRegistro::find($id);
			if(!$reason instanceof RazonRegistro) {
				App::abort(404);
			}

			DB::beginTransaction();
        	try {
        		$reasonRegister = RazonRegistroUsuario::where('codigo_razon_registro', '=', $reason->codigo_razon_registro)->where('codigo_usuario','=',Auth::user()->codigo_usuario)->first();
				if($reasonRegister instanceof RazonRegistroUsuario) {
	      			if($reasonRegister->codigo_estado != Estado::getState('active')) {
	      				RazonRegistroUsuario::where('codigo_razon_registro', '=', $reasonRegister->codigo_razon_registro)->where('codigo_usuario', '=', $reasonRegister->codigo_usuario)->update(['codigo_estado' => Estado::getState('active')]);
	      			}
	      		}else{
	      			$reasonRegister = new RazonRegistroUsuario;
		            $reasonRegister->codigo_razon_registro = $reason->codigo_razon_registro;
		           	$reasonRegister->codigo_usuario = Auth::user()->codigo_usuario;
		  			$reasonRegister->codigo_estado = Estado::getState('active');
		  			$reasonRegister->save();
	      		}

				// Commit Transaction
				DB::commit();
				return Response::json(['success' => true, 'codigo_razon_registro' => $reason->codigo_razon_registro, 'nombre_razon_registro' => $reason->nombre_razon_registro]);

			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
			}
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
		if (Request::ajax()) {
			DB::beginTransaction();
			try {
				// Set removed state
				RazonRegistroUsuario::where('codigo_razon_registro', '=', $id)->where('codigo_usuario', '=', Auth::user()->codigo_usuario)->update(['codigo_estado' => Estado::getState('removed')]);

				DB::commit();
				return Response::json(array('success' => true));
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
		}
    	App::abort(404);
	}
}
