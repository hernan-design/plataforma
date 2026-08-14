<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request, Response, Input, Auth, DB, App, Log, Lang, Validator;

use App\Proyecto, App\ModeloNegocio, App\RespuestaModeloNegocio;

class RespuestaModeloNegocioController extends Controller {

    /**
     * Instantiate a new RespuestaModeloNegocioController instance.
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
			if(Input::has('codigo_proyecto') && Input::has('codigo_modelo_negocio')) {
				$model = Input::get('codigo_modelo_negocio');

				$project = Proyecto::find(Input::get('codigo_proyecto'));
				if(!$project instanceof Proyecto){
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}

				$response = new \stdClass();
				$response->codigo_proyecto = $project->codigo_proyecto;
				$response->codigo_modelo_negocio = $model;
				$response->items = RespuestaModeloNegocio::getAnswersBusinessModel($project->codigo_proyecto, $model);
				$response->updated_at = $project->updated_at;

				return Response::json($response);
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
			if(Input::has('items')) {
				$questioning = Input::get('items');

				$project = Proyecto::find(Input::get('codigo_proyecto'));
				if(!$project instanceof Proyecto){
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}

				$model = ModeloNegocio::find(Input::get('codigo_modelo_negocio'));
				if(!$model instanceof ModeloNegocio){
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}

				// Validate users update proyect
				if(in_array(Auth::user()->codigo_usuario, $project->getAllowedUsers())) {
					DB::beginTransaction();
		        	try {
						$rules = array('respuesta' => 'required|string|words:1,200');
						foreach ($questioning as $question) {
							if(Input::has('respuesta_'.$question['codigo_pregunta_modelo_negocio'])){
								$answer = Input::get('respuesta_'.$question['codigo_pregunta_modelo_negocio']);
								$validator = Validator::make(['respuesta' => $answer], $rules);
						        if (!$validator->passes()) {
					     		 	DB::rollback();
     		 						return Response::json(['success' => false, 'errors' => Lang::get('validation.words',['attribute' => $question['pregunta_modelo_negocio']])]);
								}

								$objAnswer = RespuestaModeloNegocio::where('codigo_pregunta_modelo_negocio', $question['codigo_pregunta_modelo_negocio'])
									->where('codigo_proyecto', $project->codigo_proyecto)->first();
								if($objAnswer instanceof RespuestaModeloNegocio) {
									$objAnswer->texto_respuesta_modelo_negocio = $answer;
									$objAnswer->save();
								}else{
									$objAnswer = new RespuestaModeloNegocio;
									$objAnswer->codigo_proyecto = $project->codigo_proyecto;
									$objAnswer->codigo_pregunta_modelo_negocio = $question['codigo_pregunta_modelo_negocio'];
								}
								$objAnswer->texto_respuesta_modelo_negocio = $answer;
								$objAnswer->save();
							}
						}

						// Set last update project
						$project->updated_at = date('Y-m-d H:i:s');
						$project->save();

						// Prepare response
						$response = new \stdClass();
						$response->codigo_proyecto = $project->codigo_proyecto;
						$response->codigo_modelo_negocio = $model->codigo_modelo_negocio;
						$response->items = RespuestaModeloNegocio::getAnswersBusinessModel($project->codigo_proyecto, $model->codigo_modelo_negocio);
						$response->updated_at = $project->updated_at;
						$response->success = true;

						DB::commit();
						return Response::json($response);
					}catch(\Exception $e){
					    DB::rollback();
						Log::error($e->getMessage());
						return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
					}
				}
				App::abort(403);
			}
			return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
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
