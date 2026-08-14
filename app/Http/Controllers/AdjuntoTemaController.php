<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Response, Auth, Input, App, DB, Log, Lang, SendEmail;

use TuProyecto;
use App\UsuarioEncuesta;
use App\Curso;

use App\EstadoAdjuntoUsuario, App\Estado;

class AdjuntoTemaController extends Controller {

	/**
     * Instantiate a new AdjuntoTemaController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


	public function index()
	{
		//
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
	public function update(Request $request, $id)
    {
        $data = $request->all();
    //    dd('en controller ',$data);
		if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_tema_curso, $codigo_adjunto) = TuProyecto::decryptSrcParams(Input::get('srcparams'));
			if(!$codigo_tema_curso || !is_numeric($codigo_tema_curso)) {
				App::abort(403);
			}
			if(!$codigo_adjunto || !is_numeric($codigo_adjunto)) {
				App::abort(403);
			}

			DB::beginTransaction();
        	try {
				// Estado Adjunto Usuario
        		$attachedUser = EstadoAdjuntoUsuario::stateAttachedUser(Auth::user()->codigo_usuario, $codigo_adjunto, $codigo_tema_curso);
				$estado_adjunto = Estado::getState('active');
        		if($attachedUser instanceof EstadoAdjuntoUsuario) {
        			if($attachedUser->codigo_estado == Estado::getState('active')){
                        if(empty($data['activate']))
                        {
                            $estado_adjunto = Estado::getState('inactive');
                        }
        			}
    				$attachedUser->codigo_estado = $estado_adjunto;
        		}else{
        			$attachedUser = new EstadoAdjuntoUsuario;
					$attachedUser->codigo_adjunto = $codigo_adjunto;
					$attachedUser->codigo_tema_curso = $codigo_tema_curso;
		   			$attachedUser->codigo_usuario = Auth::user()->codigo_usuario;
					$attachedUser->codigo_estado = $estado_adjunto;
        		}
	   			$attachedUser->save();


				//validar si cursos están completos
				if(Auth::check()){

					$isCoursesComplete = Curso::getCoursesComplete([263, 266]); // cursos 263, 264, 265, 266

					Log::info('Cursos incompletos');

					if ( isset( $isCoursesComplete ) AND $isCoursesComplete ) { //cursos completos ?
						//send email link test zarit
						Log::info('Enviando correo test zarit');
						$data = [];
						$data['_template'] = 'emails.program.propace.notification_test_propace';
						$data['_subject'] = 'Programa de formación a cuidadores';
						$data['comment'] = Lang::get('program.mail.body.propaceTestZaritCierre');
						$data['_to'] = Auth::user()->correo_electronico;
						$data['_to_name'] = ucwords(strtolower(Auth::user()->nombre_usuario));
						// $data['_inst'] = session('institution')->codigo_institucion;
						$data['_url_action'] = sprintf("/%s/%s/%s", 'proyecto', Auth::user()->nickname_usuario,'convocatorias');
						SendEmail::notification($data);

					}

					//
				}

				   //end validacion

				// Commit Transaction
				DB::commit();
	   			return Response::json(array('success' => true, 'state_review' => ($attachedUser->codigo_estado == Estado::getState('active') ? true : false)));
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
		}
    	App::abort(404);
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
}
