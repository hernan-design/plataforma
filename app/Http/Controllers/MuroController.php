<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Auth, Input, Validator, DB, App, Queue, Log, Lang, Entrust;

use TuProyecto, MetaData, SendEmail;

use App\Muro, App\Estado, App\Modulo, App\MuroInstitucion, App\RegistroSesion, App\Canal, App\CategoriaCanal, App\TipoEvento, App\CategoriaForo;

class MuroController extends Controller {

    /**
     * Instantiate a new MuroController instance.
     */
    public function __construct()
    {
		$this->middleware('react', ['only' => ['index', 'show']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$channel['channels'] = Canal::getChannels()->toArray();
		$channel['categories'] = CategoriaCanal::getCategories()->toArray();
		$event['types'] = TipoEvento::getTypes()->toArray();
		$forum['categories'] = CategoriaForo::getForumCategories()->toArray();

		return view('layout.document.layout', compact('channel', 'event', 'forum'));
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
	public function store(Request $request)
	{
		if ($request->ajax()) {
			DB::beginTransaction();
        	try {
        		$data = $request->all();
	   			// Channel
	   			if($request->has('url_canal') && !empty($request->url_canal)) {
	   				$channel = Canal::where('url_canal', $request->url_canal)->where('canal.codigo_institucion', RegistroSesion::getInstitution())->first();
	   				if(!$channel instanceof Canal) {
	   					throw new \Exception("No existe él canal ".$request->url_canal);
	   				}
					$data['codigo_canal'] = $channel->codigo_canal;
	   			}

				$data['codigo_modulo'] = Modulo::getModule('wall');
	   			if($request->has('srcparams-user') && !empty($request->url_canal)) {
					// Decrypt src-params
					list($codigo_usuario) = TuProyecto::decryptSrcParams($request->get('srcparams-user'));
					if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
						App::abort(403);
					}
					if(Auth::user()->codigo_usuario !== $codigo_usuario) {
						$data['codigo_modulo'] = Modulo::getModule('users');
						$data['codigo_recurso_modulo'] = $codigo_usuario;
			   		}
				}

				$muro = Muro::store($data);
				if( !$muro instanceof Muro ) {
					throw new \Exception("Error creando post muro");
				}

	   			// Gamification (Replace for gamification Likes)
	   			// PuntoUsuario::gamification('muro.gestion.crear', Estado::getState('active'), Auth::user()->codigo_usuario, $muro->codigo_muro);

	   			// Prepare response
				$response = Muro::buildPosts(Muro::getPosts($muro->codigo_muro));
				$response->success = true;

	   			// Mail notification
	   			if($muro->codigo_modulo === Modulo::getModule('users') && Auth::user()->codigo_usuario !== $codigo_usuario) {
					Queue::push('App\Muro@notification', ['codigo_muro' => $muro->codigo_muro, 'codigo_institucion' => RegistroSesion::getInstitution()]);
	   			}

				// Commit Transaction
				DB::commit();
				return response()->json($response);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
	            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
    	abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$channel['channels'] = Canal::getChannels()->toArray();
		$channel['categories'] = CategoriaCanal::getCategories()->toArray();
		$event['types'] = TipoEvento::getTypes()->toArray();
		$forum['categories'] = CategoriaForo::getForumCategories()->toArray();

		return view('layout.document.layout', compact('channel', 'event', 'forum'));
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
		if($request->ajax()) {
			$data = $request->all();
			$data['codigo_modulo'] = Modulo::getModule('wall');

			$muro = Muro::find($id);
			if(!$muro instanceof Muro) {
				abort(404);
			}

			if(Auth::user()->codigo_usuario != $muro->codigo_usuario) {
				abort(403);
			}

			if(!$muro->isValidUpdate($data)) {
				return response()->json(['success' => false, 'errors' => $muro->errors]);
			}

			DB::beginTransaction();
			try {
				// Channel
				$data['codigo_canal'] = null;
	   			if($request->has('url_canal') && !empty($request->url_canal)) {
	   				$channel = Canal::where('url_canal', $request->url_canal)->where('canal.codigo_institucion', RegistroSesion::getInstitution())->first();
	   				if(!$channel instanceof Canal) {
	   					throw new \Exception("No existe él canal ".$request->url_canal);
	   				}
					$data['codigo_canal'] = $channel->codigo_canal;
	   			}

				$muro->fill($data);
				$muro->texto_muro = trim($muro->texto_muro);
				$muro->save();

				$response = new \stdClass();
				$response->success = true;
				$response->texto_muro = $muro->texto_muro;
				$response->codigo_canal = $muro->codigo_canal;

				// Commit Transaction
				DB::commit();
				return response()->json($response);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
	            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
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
				$muro = Muro::find($id);
				if(!$muro instanceof Muro) {
					throw new \Exception("Error deleting community entry");
				}
				if(Auth::user()->codigo_usuario == $muro->codigo_usuario || Auth::user()->ability('admin,super-admin', 'login-admin')) {
					// Set removed state
					$muro->codigo_estado = Estado::getState('removed');
					$muro->save();

					// Gamification (Replace for gamification Likes) (remove points)
		   			// PuntoUsuario::gamification('muro.gestion.crear', Estado::getState('removed'), Auth::user()->codigo_usuario, $muro->codigo_muro);

					// Commit Transaction
					DB::commit();
				}else{
					DB::rollback();
				}
	            return response()->json(['success' => true]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
	            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
    	abort(404);
	}
}
