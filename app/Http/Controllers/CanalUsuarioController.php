<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Auth;

use App\RegistroSesion, App\Estado, App\Canal, App\CanalUsuario, App\UsuarioInstitucion;

class CanalUsuarioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		abort(404);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if($request->ajax()) {
			DB::beginTransaction();
			try {
				$returnChannel = null;
				// User institution
				$userInstitution = Auth::user()->institucion;
				$channels = Canal::getChannels();
				foreach ($channels as $channel) {
					if($request->has("channel_$channel->codigo_canal")) {
						$channeluser = CanalUsuario::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)->where('codigo_canal', $channel->codigo_canal)->first();
						if(!$channeluser instanceof CanalUsuario) {
							$channeluser = new CanalUsuario();
							$channeluser->codigo_canal = $channel->codigo_canal;
							$channeluser->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
						}

						$channeluser->codigo_estado = Estado::getState('inactive');
						$channeluser->save();

						$returnChannel = $channel->codigo_canal;
					}
				}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'codigo_canal' => $returnChannel, 'codigo_estado' => $channeluser->codigo_estado,  'redirect' => url(RegistroSesion::getInstitutionHome())]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error(sprintf('%s:%s', 'CanalUsuarioController store', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}

		}
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		// 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if($request->ajax()) {
			DB::beginTransaction();
			try {
				$channeluser = CanalUsuario::where('codigo_usuario_institucion', Auth::user()->institucion->codigo_usuario_institucion)->where('codigo_canal', $id)->first();
				if($channeluser instanceof CanalUsuario) {
					$channeluser->codigo_estado = Estado::getState('inactive');
					$channeluser->save();
				}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'codigo_canal' => $channeluser->codigo_canal]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error(sprintf('%s:%s', 'CanalUsuarioController update', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
