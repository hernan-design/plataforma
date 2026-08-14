<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, Lang;

use App\CategoriaClaseEspacio, App\ClaseEmprendimientoInstitucion;

class CategoriaClaseEspacioController extends Controller
{
    /**
     * Instantiate a new CategoriaClaseEspacioController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(Request $request, $id)
    {
    	if($request->ajax()) {
	    	$query = ClaseEmprendimientoInstitucion::query();
			$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
			$query->where('codigo_clase_empre_insti', $id);
	    	$category = $query->first();

	    	if($category instanceof ClaseEmprendimientoInstitucion) {
		    	// Prepare response
		        $response = ClaseEmprendimientoInstitucion::build($category);
				$response->success = true;

	        	return response()->json($response);
	    	}
            return response()->json(['success' => false, 'errors' => 'Clase entidad no identificada']);
   		}
   		abort(404);
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
