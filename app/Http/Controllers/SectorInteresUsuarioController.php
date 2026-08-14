<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Request, Response, Auth, App, Input, DB, Lang;

use TuProyecto;

use App\SectorInteresUsuario, App\Estado, App\SectorInteres;

class SectorInteresUsuarioController extends Controller {

    /**
     * Instantiate a new SectorInteresUsuarioController instance.
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
			return Response::json(SectorInteresUsuario::getInterests());
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
			$sector = SectorInteres::find($id);
			if(!$sector instanceof SectorInteres) {
				App::abort(404);
			}

			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				App::abort(403);
			}

			DB::beginTransaction();
        	try {
        		$sectorUser = SectorInteresUsuario::where('codigo_sector_interes', '=', $sector->codigo_sector_interes)->where('codigo_usuario','=',$codigo_usuario)->first();
				if($sectorUser instanceof SectorInteresUsuario) {
	      			if($sectorUser->codigo_estado != Estado::getState('active')) {
	      				SectorInteresUsuario::where('codigo_sector_interes', '=', $sectorUser->codigo_sector_interes)->where('codigo_usuario', '=', $sectorUser->codigo_usuario)->update(['codigo_estado' => Estado::getState('active')]);
	      			}
	      		}else{
	      			$sectorUser = new SectorInteresUsuario;
	            	$sectorUser->codigo_sector_interes = $sector->codigo_sector_interes;
		           	$sectorUser->codigo_usuario = $codigo_usuario;
		  			$sectorUser->codigo_estado = Estado::getState('active');
		  			$sectorUser->save();
	      		}

				// Commit Transaction
				DB::commit();
				return Response::json(['success' => true, 'codigo_sector_interes' => $sector->codigo_sector_interes, 'nombre_sector_interes' => $sector->nombre_sector_interes]);

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

			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				App::abort(403);
			}

			try {
				// Set removed state
				SectorInteresUsuario::where('codigo_sector_interes', '=', $id)->where('codigo_usuario', '=', $codigo_usuario)->update(['codigo_estado' => Estado::getState('removed')]);

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
