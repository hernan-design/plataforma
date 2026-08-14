<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TuProyecto;

use Response, Auth, App, Input, DB, Lang, Log;

use App\EspecialidadUsuario, App\Especialidad, App\Estado;

class EspecialidadUsuarioController extends Controller {

    /**
     * Instantiate a new EspecialidadUsuarioController instance.
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
	public function index(Request $request)
	{
		if($request->ajax()){
			return Response::json(EspecialidadUsuario::getSpecialties());
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
	public function update(Request $request, $id)
	{
		if ($request->ajax()) {
			$specialty = Especialidad::find($id);
			if(!$specialty instanceof Especialidad) {
				App::abort(404);
			}

			DB::beginTransaction();
        	try {
        		$userSpecialty = EspecialidadUsuario::where('codigo_especialidad', '=', $specialty->codigo_especialidad)->where('codigo_usuario','=',Auth::user()->codigo_usuario)->first();

				$specialtyDescription = Input::has('descripcion_especialidad') ? Input::get('descripcion_especialidad') : '';

				if($userSpecialty instanceof EspecialidadUsuario) {
	      			if($userSpecialty->codigo_estado != Estado::getState('active')) {
	      				EspecialidadUsuario::where('codigo_especialidad', '=', $specialty->codigo_especialidad)->where('codigo_usuario', '=', $userSpecialty->codigo_usuario)->update([
							'codigo_estado' => Estado::getState('active'),
							'descripcion_especialidad' => $specialtyDescription
						]);
	      			}
	      		}else{
	      			$userSpecialty = new EspecialidadUsuario;
		            $userSpecialty->codigo_especialidad = $specialty->codigo_especialidad;
		            $userSpecialty->descripcion_especialidad = $specialtyDescription;
		           	$userSpecialty->codigo_usuario = Auth::user()->codigo_usuario;
		  			$userSpecialty->codigo_estado = Estado::getState('active');
		  			$userSpecialty->save();
	      		}

				$specialtyName = !empty($specialtyDescription) ? $specialtyDescription : $specialty->nombre_especialidad;

				// Commit Transaction
				DB::commit();
				return Response::json(['success' => true, 'codigo_especialidad' => $specialty->codigo_especialidad, 'nombre_especialidad' => $specialtyName]);

			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
			}
		}
		App::abort(404);
	}

	 /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function selectorlist(Request $request)
    {	
        
        if($request->ajax()){
            $data = $request->all();
                
                $return = Especialidad::getSpecialtiesSelectorList($data);
                
                return response()->json($return);
            }
            
            abort('404');
                
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		if ($request->ajax()) {
			DB::beginTransaction();
			try {
				// Set removed state
				EspecialidadUsuario::where('codigo_especialidad', '=', $id)->where('codigo_usuario', '=', Auth::user()->codigo_usuario)
					->update([
						'codigo_estado' => Estado::getState('removed'),
						'descripcion_especialidad' => ''
					]);

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
