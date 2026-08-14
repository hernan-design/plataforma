<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use TuProyecto;

use Request, Response, DB, Log, Lang, Input, Auth, App;

use App\Mentoria, App\Estado, App\TareaMentoria, App\RegistroSesion;

class TareaMentoriaController extends Controller {

    /**
     * Instantiate a new MentoriaController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::ajax()) {
			if(Input::has('codigo_mentoria')) {
				// Decrypt src-params
				list($codigo_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_mentoria'));
				if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
					App::abort(403);
				}

				$taskMentoring = Mentoria::find($codigo_mentoria);
				if(!$taskMentoring instanceof Mentoria) {
		            App::abort(404);
				}
				return Response::json(TareaMentoria::getTasksMentoring($taskMentoring->codigo_mentoria));
			}
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

		 	// Decrypt src-params
			list($codigo_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_mentoria'));
			if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
				App::abort(403);
			}
			$mentoring = Mentoria::find($codigo_mentoria);
			if(!$mentoring instanceof Mentoria) {
	            return;
			}
			$taskMentoring = new TareaMentoria;
			if ($taskMentoring->isValid($data)) {
				DB::beginTransaction();
	        	try {
					// Task mentoring
					$taskMentoring->codigo_mentoria = $mentoring->codigo_mentoria;
					$taskMentoring->descripcion_tarea_mentoria = Input::get('descripcion_tarea_mentoria');
					$taskMentoring->codigo_estado = Estado::getState('active');
		   			$taskMentoring->save();

		   			// Prepare response
					$response = TareaMentoria::buildTaskMentoring(TareaMentoria::find($taskMentoring->codigo_tarea_mentoria), $mentoring->seg_codigo_usuario);

					$response->success = true;


					// Commit Transaction
					DB::commit();
					return Response::json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error(sprintf('%s:%s', 'TareaMentoriaController store', $e->getMessage()));
					return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
			return Response::json(array('success' => false, 'errors' => $taskMentoring->errors));
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
		if (Request::ajax()) {

			// Decrypt src-params
	        list($codigo_tarea_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_tarea_mentoria'));
	        if(!$codigo_tarea_mentoria || !is_numeric($codigo_tarea_mentoria)) {
	            App::abort(403);
	        }
			$taskMentoring = TareaMentoria::find($codigo_tarea_mentoria);
			if(!$taskMentoring instanceof TareaMentoria) {
				App::abort(404);
			}

			$mentoring = Mentoria::find($taskMentoring->codigo_mentoria);
			if(!$mentoring instanceof Mentoria) {
				App::abort(404);
			}
			if(Auth::user()->codigo_usuario == $mentoring->seg_codigo_usuario)
			{
				DB::beginTransaction();
				try {
					// Set removed state
					TareaMentoria::where('codigo_tarea_mentoria', '=', $taskMentoring->codigo_tarea_mentoria)
						->update(array('codigo_estado' => Estado::getState('removed')));

					DB::commit();
					return Response::json(array('success' => true));
				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'TareaMentoriaController update', $e->getMessage()));
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}
			App::abort(403);
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

			// Decrypt src-params
	        list($codigo_tarea_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_tarea_mentoria'));
	        if(!$codigo_tarea_mentoria || !is_numeric($codigo_tarea_mentoria)) {
				$errormsg = "El codigo de tarea de mentoria es inválido" + $codigo_tarea_mentoria;
				Log::error(sprintf('%s:%s', ' App\Http\ControllersTareaMentoriaController@destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
	        }
			$taskMentoring = TareaMentoria::find($codigo_tarea_mentoria);
			if(!$taskMentoring instanceof TareaMentoria) {
				$errormsg = "No se encuentra tarea de mentoria de codigo " + $codigo_tarea_mentoria;
				Log::error(sprintf('%s:%s', 'TareaMentoriaController destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
			$mentoring = Mentoria::find($taskMentoring->codigo_mentoria);
			if(!$mentoring instanceof Mentoria) {
				$errormsg = "No se encuentra mentoria de codigo " + $taskMentoring->codigo_mentoria;
				Log::error(sprintf('%s:%s', 'TareaMentoriaController destroy', $errormsg));
				App::abort(404);
			}

			$authorized = False;

			switch(Auth::user()->codigo_usuario){
				case $mentoring->codigo_usuario:
					$authorized = True;
					break;
				case $mentoring->seg_codigo_usuario:
					$authorized = True;
					break;
				default:
					$authorized = False;
					break;

			}

			// Auth 45379  codigo_usuario 357190  seg_codigo_usuario = 45379


			if($authorized)
			{
				DB::beginTransaction();
				try {
					// Set removed state
					TareaMentoria::where('codigo_tarea_mentoria', '=', $taskMentoring->codigo_tarea_mentoria)
						->update(array('codigo_estado' => Estado::getState('removed')));

					DB::commit();
					return Response::json(array('success' => true));
				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'TareaMentoriaController destroy', $e->getMessage()));
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}

			$errormsg = "El usuario no esta autorizado para realizar esta acción";
			Log::error(sprintf('%s:%s', 'TareaMentoriaController destroy', $errormsg));
			return Response::json(array('success' => false, 'errors' => $errormsg ));
		}
    	App::abort(404);
	}


}
