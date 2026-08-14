<?php

namespace App\Http\Controllers;

use App\RegistroSesion;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TuProyecto;

use View, Response, App, Auth, Input;
use Log;

use App\Convocatoria, App\OrientacionConvocatoria, App\Usuario, App\RegistroConvocatoria, App\Estado;

class ConvocatoriaController extends Controller
{

	/**
	 * Instantiate a new ConvocatoriaController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'showUrl']]);
		$this->middleware('intended', ['only' => ['index', 'showUrl']]);
		$this->middleware('subscription', ['only' => ['apply']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			// Obtener las convocatorias con los filtros proporcionados
			$response = Convocatoria::getCalls($request->all());

			// Obtener el total de entradas y los elementos de convocatorias válidos
			$total_entries = $response->total_entries;
			$calls = $response->items;

			// Recorrer los elementos de convocatorias y aplicar la validación
			foreach ($calls as $key => $call) {
				// Aplicar la lógica de validación para cada convocatoria
				if (!$call->permanente_convocatoria && $call->ocultar_al_finalizar) {
					$fecha_completa = $call->fecha_cierre_convocatoria . ' ' . $call->hora_cierre_convocatoria;
					$date = date('Y-m-d H:i:s', strtotime($fecha_completa));

					// Verificar si la fecha actual es mayor o igual a la fecha de cierre
					if (date("Y-m-d H:i:s") >= $date) {
						// Si la validación falla, eliminar este elemento del array de convocatorias
						unset($calls[$key]);
						// Decrementar el contador de total de entradas
						$total_entries--;
					}
				}
			}

			// Crear una nueva respuesta JSON con los elementos filtrados
			return response()->json([
				'total_entries' => $total_entries,
				'items' => array_values($calls), // Reindexar el array después de eliminar elementos
			]);
		}

		return View::make('core/call/main');
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
		//
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

	/**
	 * Show the form for apply the specified phase program.
	 *
	 * @param  string $program
	 * @param  string $step
	 * @return Response
	 */
	public function apply($program, $step)
	{
		$program = Convocatoria::getCall($program);
		if (!$program instanceof Convocatoria) {
			abort(404);
		} else {
			if (!$program->permanente_convocatoria && $program->ocultar_al_finalizar) {
				$fecha_completa = $program->fecha_cierre_convocatoria . ' ' . $program->hora_cierre_convocatoria;

				$date = date('Y-m-d H:i:s', strtotime($fecha_completa));

				if (date("Y-m-d H:i:s") >= $date) {
					abort(404);
				}
			}

		}

		switch ($step) {
			case 'formulario':
				return redirect()->route('convocatoria.aplicar', ['convocatoria' => $program->url_convocatoria, 'step' => 'entidad']);
				break;
		}

		return view('core.call.main');
	}


	/**
	 * Display the resource from url.
	 *
	 * @param  String  $call
	 * @return Response
	 */
	public function showUrl(Request $request, $program)
	{

		$program = Convocatoria::getCall($program);

		if (!$program instanceof Convocatoria) {
			abort(404);
		} else {
			if (!$program->permanente_convocatoria && $program->ocultar_al_finalizar) {
				$fecha_completa = $program->fecha_cierre_convocatoria . ' ' . $program->hora_cierre_convocatoria;

				$date = date('Y-m-d H:i:s', strtotime($fecha_completa));

				if (date("Y-m-d H:i:s") >= $date) {
					abort(404);
				}
			}

		}
		if ($request->ajax()) {
			return response()->json(Convocatoria::buildCall($program));
		}
		return View::make('core/call/main', ['call' => $program]);
	}

	/**
	 * Display a valid apply program.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function validApply(Request $request)
	{
		if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_convocatoria) = TuProyecto::decryptSrcParams(Input::get('codigo_convocatoria'));
			if (!$codigo_convocatoria || !is_numeric($codigo_convocatoria)) {
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
			// Valid program
			$program = Convocatoria::find($codigo_convocatoria);
			if (!$program instanceof Convocatoria) {
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}

			$user = null;
			switch ($program->codigo_orientacion_convocatoria) {
				case OrientacionConvocatoria::getOrientation('entity'):
					if (Input::has('codigo_usuario')) {
						list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
						if (!$codigo_usuario || !is_numeric($codigo_usuario)) {
							return response()->json(['success' => false, 'errors' => trans('app.exception')]);
						}
						$user = Usuario::find($codigo_usuario);
					}
					break;

				case OrientacionConvocatoria::getOrientation('user'):
					$user = Usuario::find(Auth::user()->codigo_usuario);
					break;
			}

			// Valid user
			if (!$user instanceof Usuario) {
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}

			// Validate apply
			$query = RegistroConvocatoria::query();
			if (!is_null($user->identificacion_usuario)) {
				$query->join('seguridad.usuario', 'registro_convocatoria.codigo_usuario', '=', 'usuario.codigo_usuario');
				$query->where('identificacion_usuario', $user->identificacion_usuario);
			} else {
				$query->where('codigo_usuario', $user->codigo_usuario);
			}
			$query->where('codigo_convocatoria', $program->codigo_convocatoria);
			$query->orderBy('codigo_registro_convocatoria', 'desc');
			$register = $query->first();

			if ($register instanceof RegistroConvocatoria) {
				if (!$program->permanente_convocatoria) {
					return response()->json(['success' => true, 'message' => trans('tuproyecto.programs.postregister', ['project' => $user->nombre_usuario]), 'applied' => true, 'nombre_usuario' => $user->nombre_usuario]);
				}

				// if(is_null($program->tiempo_espera_nueva_aplicacion) || $program->tiempo_espera_nueva_aplicacion <= 0) {
				// 	return response()->json(['success' => true, 'message' => trans('tuproyecto.programs.postregister', ['project' => $user->nombre_usuario]), 'applied' => true, 'nombre_usuario' => $user->nombre_usuario]);
				// }

				// Valid days next apply
				$next = date('Y-m-d', strtotime("+$program->tiempo_espera_nueva_aplicacion day", strtotime($register->fecha_registro_convocatoria)));
				if ($next > date('Y-m-d')) {
					return response()->json(['success' => true, 'message' => trans('tuproyecto.programs.postregisterapply', ['project' => $user->nombre_usuario, 'next' => $next]), 'applied' => true]);
				}

				if ($register->bloqueo_nueva_aplicacion) {
					return response()->json(['success' => true, 'message' => trans('tuproyecto.programs.postregister', ['project' => $user->nombre_usuario]), 'applied' => true, 'nombre_usuario' => $user->nombre_usuario, 'no_cancel' => $register->bloqueo_nueva_aplicacion]);
				}
			} else {

				// Valid multiple user application in program
				if ($program->reg_unico_usuario_convocatoria) {
					switch ($program->codigo_orientacion_convocatoria) {
						case OrientacionConvocatoria::getOrientation('entity'):
							$query = RegistroConvocatoria::query();
							$query->join('seguridad.usuario', 'registro_convocatoria.codigo_usuario', '=', 'usuario.codigo_usuario');
							$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
							$query->join('seguridad.usuario as person', 'entidad.seg_codigo_usuario', '=', 'person.codigo_usuario');
							$query->where('entidad.seg_codigo_usuario', Auth::user()->codigo_usuario);
							$query->where('codigo_convocatoria', $program->codigo_convocatoria);
							$query->orderBy('codigo_registro_convocatoria', 'desc');
							$register_test = $query->first();
							break;

						case OrientacionConvocatoria::getOrientation('user'):
							$query = RegistroConvocatoria::query();
							$query->where('codigo_usuario', Auth::user()->codigo_usuario);
							$query->where('codigo_convocatoria', $program->codigo_convocatoria);
							$query->orderBy('codigo_registro_convocatoria', 'desc');
							$register_test = $query->first();
							break;
					}

					if ($register_test instanceof RegistroConvocatoria) {
						return response()->json(['success' => true, 'message' => trans('tuproyecto.programs.validation_id', ['project' => $user->nombre_usuario, 'id' => $register_test->identificacion_usuario]), 'applied' => true]);
					}

				}
			}
			return response()->json(['success' => true, 'applied' => false, 'url_nickname' => $user->nickname_usuario]);
		}
		abort(404);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function selectorlist(Request $request)
	{

		if ($request->ajax()) {
			$data = $request->all();


			$return = Convocatoria::getProgramSelectorList($data);

			return response()->json($return);
		}
		abort('404');

	}


}
