<?php

namespace App\Http\Controllers\Api\Convocatoria;

use App\Custom\Cenisoft;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use App\UsuarioEncuesta, App\Usuario, App\RespuestaEncuesta, Custom\Innpulsa, Custom\Dinamiza, App\Custom\Compensar;

class InformeController extends Controller
{
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
    public function show($id)
    {
		// Decrypt src-params
        // list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams($id);
        $codigo_usuario_encuesta = $id;
        if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
            abort(403);
		}

		//$codigo_usuario_encuesta = 26752;

        $userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);
        if(!$userSurvey instanceof UsuarioEncuesta){
        	abort(403);
        }

        $user = Usuario::find($userSurvey->codigo_usuario);
        if(!$user instanceof Usuario) {
        	abort(403);
        }

        // Get data
		$answers = RespuestaEncuesta::getUserResponseSurvey($userSurvey);

		// Prepare response
		$response = new \stdClass();
		switch ($userSurvey->codigo_encuesta) {
			case Innpulsa::$challenge:
				$response->identificacion_usuario = $user->identificacion_usuario;
				$response->report = Innpulsa::aldeaReport($answers, $userSurvey);
            break;
            case Innpulsa::$challenge_empodera:
				$response->identificacion_usuario = $user->identificacion_usuario;
				$response->report = Innpulsa::aldeaReport($answers, $userSurvey);
            break;
            case Dinamiza::$diagnostic:
				$response->identificacion_usuario = $user->identificacion_usuario;
				$response->report = Dinamiza::diagnosticReport($answers, $userSurvey);
            break;
			case Cenisoft::$diagnostic:
				$response->identificacion_usuario = $user->identificacion_usuario;
				$response->report = Cenisoft::diagnosticReport($answers, $userSurvey);
            break;
            case Compensar::$diagnostic:
                $response->identificacion_usuario = $user->identificacion_usuario;
                $response->report = Compensar::diagnosticReport($answers, $userSurvey);
            break;
		}

    	return response()->json($response);
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
