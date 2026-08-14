<?php

namespace App\Http\Controllers;

use App\Adjunto;
use App\AdjuntoFase;
use Illuminate\Http\Request;
use DB, Log;

use App\Convocatoria, App\Fase, App\Estado;


class FaseController extends Controller
{
	/**
	 * Instantiate a new Controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			if ($request->has('program') && $request->has('phase')) {
				$program = Convocatoria::find($request->program);
				if(!$program instanceof Convocatoria) {
					abort(404);
				}
				$phase = Fase::find($request->phase);
				if(!$phase instanceof Fase) {
					abort(404);
				}
				return response()->json(Fase::getResourceOfPhase($request->program, $request->phase));
			} else if ($request->has('program')) {
				$program = Convocatoria::find($request->program);
				if(!$program instanceof Convocatoria) {
					abort(404);
				}
				return response()->json(Fase::getPhaseProgram($program->codigo_convocatoria));
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
		if($request->ajax()){
			$data = $request->all();

			$phase = Fase::find($id);
			if(!$phase instanceof Fase ){
				throw new \Exception("Fase no encontrada {$id}");
			}

			if ($phase->isValid($data)) {
				DB::beginTransaction();
				try {
					if($request->has('change_state')){
						$phase->codigo_estado = $request->codigo_estado == Estado::getState('active') ? Estado::getState('inactive') : Estado::getState('active');
						$event = $phase->codigo_estado == Estado::getState('active') ? 'activada' : 'inactivada';
					}

					$phase->save();

					// Commit Transaction
					DB::commit();
					return response()->json(['success' => true, 'message' => trans('app.rest.success', ['resource' => 'La fase', 'event' => $event]), 'codigo_fase' => $phase->codigo_fase, 'codigo_estado' => $phase->codigo_estado, 'fase_registro' => $phase->fase_registro, 'fase_entidad_editable' => $phase->fase_entidad_editable, 'asignacion_especialidad' => $phase->asignacion_especialidad, 'fase_cancelacion' => $phase->fase_cancelacion, 'edicion_formulario_registro' => $phase->edicion_formulario_registro]);

				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'FaseController:update', $e->getMessage()));
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			return response()->json(['success' => false, 'errors' => $phase->errors]);
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

	/**
	 * Order all resources in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function order(Request $request)
	{
		if($request->ajax()){
			DB::beginTransaction();
			try {

				foreach ($request->data as $value) {
					$phase = Fase::find($value['codigo_fase']);

					if(!$phase instanceof Fase){
						return response()->json(['success' => false, 'errors' => 'La fase no se encuentra en el sistema, verifique.']);
					}

					$phase->orden_fase = $value['orden_fase'];
					$phase->save();
				}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'message' => 'Se ha cambiado la posición de la fase correctamente.']);

			}catch(\Exception $e){
				DB::rollback();
				Log::error(sprintf('%s:%s', 'FaseController:order', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}
}
