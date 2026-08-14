<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Request, Response, Auth, App, Input, DB, Lang, TuProyecto;

use App\NivelEducacionUsuario, App\Estado, App\NivelEducacion, App\Persona;

class NivelEducacionUsuarioController extends Controller {

    /**
     * Instantiate a new NivelEducacionUsuarioController instance.
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
			return Response::json(NivelEducacionUsuario::getLevels());
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

			DB::beginTransaction();
        	try {
				
				$person = Persona::where('codigo_usuario', Auth::user()->codigo_usuario )->first();
				if(!$person instanceof Persona) {
	    			App::abort(404);
				}

      			$userEducationLevel = new NivelEducacionUsuario;
	            $userEducationLevel->codigo_nivel_educacion = Input::get('codigo_nivel_educacion');
	            $userEducationLevel->nombre_nivel_educacion = Input::get('nombre_nivel_educacion');
	           	$userEducationLevel->codigo_usuario = $person->codigo_usuario;
	           	$userEducationLevel->codigo_persona = $person->codigo_persona;
	  			$userEducationLevel->codigo_estado = Estado::getState('active');
	  			$userEducationLevel->save();

	  			$level = NivelEducacion::find($userEducationLevel->codigo_nivel_educacion);
				if(!$level instanceof NivelEducacion) {
					App::abort(404);
				}

				// Commit Transaction
				DB::commit();
				return Response::json(['success' => true, 'codigo_nivel_educacion' => $userEducationLevel->codigo_nivel_educacion, 'codigo_nivel_educacion_usuario' => $userEducationLevel->codigo_nivel_educacion_usuario, 'nombre_nivel_educacion' => $level->nombre_nivel_educacion, 'disciplina' => $userEducationLevel->nombre_nivel_educacion]);

			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
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

				$person = Persona::where('codigo_usuario', Auth::user()->codigo_usuario )->first();
				if(!$person instanceof Persona) {
	    			App::abort(404);
				}

				// Set removed state
				NivelEducacionUsuario::where('codigo_nivel_educacion_usuario', '=', $id)->where('codigo_persona', '=',$person->codigo_persona)->update(['codigo_estado' => Estado::getState('removed')]);

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
