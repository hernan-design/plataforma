<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Request, View, Response, Input, Queue, Lang, Log, Auth, App;

use App\Mentoria, App\Estado, App\EvaluacionMentoria, App\ItemGeneralMentoria, App\CheckListCumplimiento;

class EvaluacionMentoriaController extends Controller {

    /**
     * Instantiate a new EvaluacionMentoriaController instance.
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
		App::abort(404);
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

		// $data = Asesoria::getGlobalData();
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
		    $evaluationMentoring = new EvaluacionMentoria;
	    	if ($evaluationMentoring->isValid($data)) {
				// Decrypt src-params
				list($codigo_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_mentoria'));
				if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
					App::abort(403);
				}
		        // Validation user
		        $mentoring = Mentoria::find($codigo_mentoria);
				if(!$mentoring instanceof Mentoria) {
		            App::abort(403);
				}
	   			// Validation evaluation
				$evaluation = EvaluacionMentoria::getEvaluationMentoring($mentoring->codigo_mentoria);
				if($evaluation instanceof EvaluacionMentoria) {
					App::abort(404);
				}
				// Validate users update proyect
				if(Auth::user()->codigo_usuario == $mentoring->codigo_usuario) 
				{
					$items = ItemGeneralMentoria::where('codigo_estado' , Estado::getState('active'))->orderBy('codigo_item_general_mentoria','desc')->get();
					DB::beginTransaction();
		        	try {
						// Insert Evaluacion Mentoria
						$evaluationMentoring->codigo_mentoria = $mentoring->codigo_mentoria;
						$evaluationMentoring->codigo_estado = Estado::getState('active');
			   			$evaluationMentoring->fecha_evaluacion_mentoria = date('Y-m-d');
			   			$evaluationMentoring->hora_evaluacion_mentoria = date('H:i:s');
			   			$evaluationMentoring->comentario__evaluacion_mentoria = Input::get('comentario__evaluacion_mentoria');
			   			$evaluationMentoring->save();

			   			foreach ($items as $item) {
		    				$checkList = new CheckListCumplimiento;
							$checkList->codigo_evaluacion_mentoria = $evaluationMentoring->codigo_evaluacion_mentoria;
							$checkList->codigo_item_general_mentoria = $item->codigo_item_general_mentoria;
							$checkList->codigo_estado = Estado::getState('active');
							$checkList->evaluacion_item_mentoria = Input::get('evaluacion_item_mentoria_'.$item->codigo_item_general_mentoria);
		    				$checkList->save();
			   			}
					
						// Commit Transaction
						DB::commit();
						return Response::json(['success' => true, 'message' => Lang::get('mentoring.evaluation.entrepreneur.success')]);
					}catch(\Exception $e){
					    DB::rollback();
						Log::error($e->getMessage());
						return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
					}
				}
				App::abort(403);
			}
			return Response::json(array('success' => false, 'errors' => $evaluationMentoring->errors));	
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
