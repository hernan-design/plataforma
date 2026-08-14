<?php

namespace App\Http\Controllers;

use App\RegistroSesion;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TuProyecto;

use View, Response, App, Auth, Input;
use Log;

use App\EtapaProyecto, App\Usuario, App\Estado;

class EtapaProyectoController extends Controller {

    /**
     * Instantiate a new EtapaProyectoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{	
		
		if($request->ajax()){
			$data = $request->all();
				
				$return = EtapaProyecto::getStagesSelectorList($data);
				
				return response()->json($return);
			}
			
			abort('404');
           		
	}

	
}
