<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use App\Encuesta, App\Modulo, App\Usuario;

class ModeloNegocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if($request->ajax()) {
			list($codigo_usuario) = TuProyecto::decryptSrcParams($request->codigo_usuario);
            if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
          		abort(403);
            }

			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
				return response()->json(['success' => false]);
			}

			$survey = Encuesta::getSurveyApplication(Modulo::getModule('projects'), $user);
			if(!$survey instanceof Encuesta) {
				return response()->json(['success' => false]);
			}

			// Prepare response
			$response = ['success' => true, 'url_encuesta' => $survey->url_encuesta];
			if(!is_null($survey->codigo_usuario_encuesta)) {
				$response['codigo_usuario_encuesta'] = TuProyecto::encryptSrcParams([$survey->codigo_usuario_encuesta]);
			}
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
