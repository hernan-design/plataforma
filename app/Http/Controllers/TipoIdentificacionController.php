<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TipoIdentificacion;

class TipoIdentificacionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$filters = $request->all();

		// Si 'data' (fecha de nacimiento) está incompleta (ej: "--" o vacía), la descartamos para no bloquear la consulta
		if (isset($filters['data'])) {
			$values = explode('-', (string) $filters['data']);
			if (empty($values[0]) || empty($values[1]) || empty($values[2])) {
				unset($filters['data']);
			}
		}

		if ($request->ajax()) {
			return response()->json(TipoIdentificacion::identificationType($filters));
		}

		abort(404);
	}
}
