<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, Lang, Input;

use App\CategoriaProducto, App\ClaseEmprendimientoInstitucion, App\RegistroSesion;

class CategoriaProductoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(\Request::ajax()) {
			if (Input::has('data') || Input::has('dataId')) {

        if (RegistroSesion::getInstitution() == 61 ) {
				  return response()->json(CategoriaProducto::getFilterCategories());
        }
				return response()->json(CategoriaProducto::getFilterCategories(true));
			}
		}
		abort(404);

    }


}
