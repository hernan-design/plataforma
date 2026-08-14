<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use DB, Request, Response, Input, Lang, Log, App, Queue, Auth;

use App\Foro, App\Estado, App\RespuestaForo, App\PuntoUsuario, App\RegistroSesion;

class RespuestaForoController extends Controller 
{
	/**
	 * Instantiate a new RespuestaForoController instance.
	 */
	public function __construct()
	{
        $this->middleware('auth', ['except' => ['index']]);
        $this->middleware('subscription', ['only' => ['store']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::ajax()) {
			if(Input::has('codigo_foro')) {
				$forum = Foro::find(Input::get('codigo_foro'));
				if(!$forum instanceof Foro) {
		            App::abort(404);
				}
				return Response::json($forum->getComments());
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
		$data = Input::all();
		$respuestaForo = new RespuestaForo;
		if ($respuestaForo->isValid($data)) {
			DB::beginTransaction();
        	try {
				// Foro
				$respuestaForo->fill($data);
				$respuestaForo->codigo_estado = Estado::getState('active');
	   			$respuestaForo->codigo_usuario = Auth::user()->codigo_usuario;
	   			$respuestaForo->fecha_respuesta_foro = date('Y-m-d');
	   			$respuestaForo->hora_respuesta_foro = date('H:i:s');
	   			$respuestaForo->save();

	   			// Gamification
	   			PuntoUsuario::gamification('foro.comentario.participar', Estado::getState('active'), Auth::user()->codigo_usuario, $respuestaForo->codigo_foro, $respuestaForo->codigo_respuesta_foro);

	   			// Prepare response
	   			$response = RespuestaForo::buildComment(RespuestaForo::getCommentForum($respuestaForo->codigo_respuesta_foro));
				$response->success = true;

	   			// Mail notification
				Queue::push('App\RespuestaForo@notification', ['codigo_respuesta_foro' => $respuestaForo->codigo_respuesta_foro, 'codigo_institucion' => RegistroSesion::getInstitution()]);

				// Commit Transaction
				DB::commit();
				return Response::json($response);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
		}
		return Response::json(array('success' => false, 'errors' => $respuestaForo->errors));
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
