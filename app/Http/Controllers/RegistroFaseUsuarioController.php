<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use TuProyecto;

use App\Convocatoria, App\Estado;

class RegistroFaseUsuarioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if($request->ajax())
		{
			$programs = [];
			if($request->has('codigo_usuario'))
			{
				// Decrypt src-params
				list($codigo_usuario) = TuProyecto::decryptSrcParams($request->codigo_usuario);
				if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
					abort(403);
				}

				$query = Convocatoria::query();
				$query->join('core.encuesta', 'convocatoria.codigo_encuesta', '=', 'encuesta.codigo_encuesta');
				$query->join('core.fase', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
				$query->join('core.registro_fase_usuario', function($join) use($codigo_usuario) {
				    $join->on('fase.codigo_fase', '=', 'registro_fase_usuario.codigo_fase');
				   	$join->where('registro_fase_usuario.codigo_usuario', '=', $codigo_usuario);
			       	// if(! Auth::user()->ability('admin,super-admin', 'view-programs-results', ['module'  => '/proyecto']) ) {
			       	// 	$join->where('registro_fase_usuario.visualizacion_usuario', '=', true);
			       	// }
				});
				$query->join('core.registro_convocatoria', 'registro_convocatoria.codigo_registro_convocatoria', '=', 'registro_fase_usuario.codigo_registro_convocatoria');
				$query->where('fase.fase_registro', true);
				$query->orderby('convocatoria.codigo_convocatoria', 'desc');
				$query->orderby('fecha_registro_convocatoria', 'desc');
				// dd($query->toSql(), $query->getBindings());
				$programs = $query->get();
			}

			$calls = [];
			foreach ($programs as $program) {
				$object = new \stdClass();
				$object->id_convocatoria = $program->codigo_convocatoria;
				$object->codigo_institucion = $program->codigo_institucion;
				$object->codigo_convocatoria = TuProyecto::encryptSrcParams([$program->codigo_convocatoria]);
				$object->codigo_encuesta = TuProyecto::encryptSrcParams([$program->codigo_encuesta]);
				$object->codigo_fase = TuProyecto::encryptSrcParams([$program->codigo_fase]);
				$object->codigo_usuario_encuesta = TuProyecto::encryptSrcParams([$program->codigo_usuario_encuesta]);
				$object->edicion_formulario_registro = $program->edicion_formulario_registro;
				$object->fecha_edicion_formulario_registro = $program->fecha_edicion_formulario_registro;
				$object->nombre_convocatoria = $program->nombre_convocatoria;
				$object->nombre_fase = $program->nombre_fase;
				$object->fecha_registro_convocatoria = $program->fecha_registro_convocatoria;
				$object->url_encuesta = $program->url_encuesta;

				$calls[] = $object;
			}

			$response = new \stdClass();
			$response->items = $calls;
			return response()->json($response);
		}
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
		//
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
		//
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
