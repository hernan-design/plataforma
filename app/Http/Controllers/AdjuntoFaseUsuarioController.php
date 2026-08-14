<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Request, Response, Auth, Input, App, DB, Log, Lang;

use TuProyecto, SendEmail;

use App\Adjunto, App\AdjuntoUsuario, App\TipoAdjunto, App\Usuario, App\UsuarioInstitucion,  App\Estado, App\RegistroSesion, App\Documento, App\Institucion, App\AdjuntoFaseUsuario, Custom\Innpulsa;

class AdjuntoFaseUsuarioController extends Controller
{

	/**
	 * Instantiate a new AdjuntoFaseUsuarioController instance.
	 */
	public function __construct()
	{
		//$this->middleware('auth', ['except' => ['index']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::ajax()) {
			return Response::json(AdjuntoFaseUsuario::getAttachedPhaseUser(Request::get('codigo_tipo_adjunto')));
		}
		abort(404);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

		if (Request::ajax()) {
		$data = Input::all();

		$codigo_adjunto_fase =  isset($data['codigo_adjunto_fase']) ?  (int) $data['codigo_adjunto_fase'] : '';


		if (!$codigo_adjunto_fase || !is_numeric($codigo_adjunto_fase)) {

			Log::error("el codigo adjunto fase no es válido");
			abort(403);
		}

		$codigo_usuario_institucion = Auth::user()->institucion->codigo_usuario_institucion;


		if (!$codigo_usuario_institucion || !is_numeric($codigo_usuario_institucion)) {
			Log::error("el codigo usuario institucion no es válido");
			abort(403);
		}

		$usuario_institucion = UsuarioInstitucion::find($codigo_usuario_institucion);
		if (!$usuario_institucion instanceof UsuarioInstitucion) {
			Log::error("No se encuentra al usuario institucion");
			abort(404);
		}

		DB::beginTransaction();
		try {
			$attachedPhaseUser = null;

			// Adjunto
			$attachedPhaseUser = new AdjuntoFaseUsuario();
			$attachedPhaseUser->codigo_usuario_institucion = $usuario_institucion->codigo_usuario_institucion;
			$attachedPhaseUser->codigo_adjunto_fase = $codigo_adjunto_fase;
			$attachedPhaseUser->fecha_adjunto_fase_usuario = date('Y-m-d H:i:s');
			$attachedPhaseUser->save();



			// Commit Transaction
			DB::commit();

			// Prepare response
			$response = ['success' => true, 'attached_phase_user'=> $attachedPhaseUser];

			return Response::json($response);
		} catch (\Exception $e) {
			DB::rollback();
			Log::error(sprintf('%s:%s', 'AdjuntoFaseUsuarioController:store', $e->getMessage()));
			return Response::json(['success' => false, 'errors' => trans('app.exception')]);
		}

		return Response::json(['success' => false, 'errors' => $attachedUser->errors]);

		}
		abort(400,'bad request');

	}
}
