<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entidad;

class EntidadController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()){
			return response()->json( Entidad::getEntitysList( $request->all() ) );
		}
	}
}
