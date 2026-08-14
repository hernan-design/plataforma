<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use TuProyecto;

use Request, View, Response, Auth, Input, DB, Log, Lang, App;

use App\Mentoria, App\Estado, App\EvaluacionTarea, App\CalificacionTarea, App\TareaMentoria;


class CalificacionTareaController extends Controller {

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
		return View::make('core/mentoring/main');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Decrypt url
		list($url, $codigo_mentoria) = explode('-', Input::get('m'));
		if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
			App::abort(403);
		}

		$mentoring = Mentoria::find($codigo_mentoria);
		if(!$mentoring instanceof Mentoria) {
            App::abort(404);
		}

		if (Request::ajax()) {		
			return Response::json(Mentoria::buildMentoringSession(Mentoria::getSessionMentoring($mentoring->codigo_mentoria)));
		}

		return View::make('core/mentoring/main');
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
	    	$evaluationTask = new EvaluacionTarea;
			if ($evaluationTask->isValid($data)) {
				// Decrypt src-params
				list($codigo_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_mentoria'));
				if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
					App::abort(403);
				}
		        // Validation mentoring
		        $mentoring = Mentoria::find($codigo_mentoria);
				if(!$mentoring instanceof Mentoria) {
		            App::abort(403);
				}
				$items = TareaMentoria::where('codigo_estado' , Estado::getState('active'))->where('codigo_mentoria', $mentoring->codigo_mentoria)->get();

				DB::beginTransaction();
	        	try {
					// Insert Evaluacion Mentoria
					$evaluationTask->codigo_mentoria = $mentoring->codigo_mentoria;
					$evaluationTask->codigo_usuario = Auth::user()->codigo_usuario;
		   			$evaluationTask->fecha_evaluacion_tarea = date('Y-m-d');
		   			$evaluationTask->hora_evaluacion_tarea = date('H:i:s');
		   			$evaluationTask->comentario_evaluacion_tarea = Input::get('comentario_evaluacion_tarea');
		   			$evaluationTask->save();

		   			foreach ($items as $item) {
	    				$calificationTask = new CalificacionTarea;
						$calificationTask->codigo_evaluacion_tarea = $evaluationTask->codigo_evaluacion_tarea;
						$calificationTask->codigo_tarea_mentoria = $item->codigo_tarea_mentoria;
						$calificationTask->evaluacion_tarea = Input::get('evaluacion_tarea_'.$item->codigo_tarea_mentoria) ;
	    				$calificationTask->save();
		   			}
					// Commit Transaction
					DB::commit();
					return Response::json(['success' => true, 'message' => Lang::get('mentoring.calification.mentor.success')]);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}	
			return Response::json(array('success' => false, 'errors' => $evaluationTask->errors));
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
		//
	}


}
