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
		if ($request->has('data')) {
			$date = $request->all();
			$values = explode('-', $date['data']);
			if (empty($values[0]) || empty($values[1]) || empty($values[2])) {
				return;
			}
		}

		if($request->ajax()){
			return response()->json( TipoIdentificacion::identificationType( $request->all() ) );
		}
		abort(404);
	}
}
