<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto, Request, View, Response, Auth, Input, DB, Log, Lang, App, SendEmail, Redirect;

use App\Asesoria, App\Estado, App\Tag, App\TagAsesoria, App\AsesoriaInstitucion, App\RegistroSesion, App\Usuario, App\Entidad, App\Modulo;
use App\Events\Notification;
use App\Institucion;

class AsesoriaController extends Controller {

    /**
     * Instantiate a new MentoriaController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscription', ['only' => ['store', 'create']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()){
			return Response::json(Asesoria::getPostsMentoring());
		}
		$mentor = Auth::user()->hasRole(['mentor']);
		return View::make('core/mentoring/main', compact('mentor'));
   	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('core.mentoring.main');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Request::ajax()) {
			$data = Input::all();
			// Decrypt src-params
            list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
            if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
                $errormsg = "El codigo de mentor es inválido: " + $codigo_usuario;
				Log::error(sprintf('%s:%s', 'AsesoriaController@store', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
            }

            // Decrypt src-params
            list($user_entity) = TuProyecto::decryptSrcParams(Input::get('codigo_entidad'));
            if(!$user_entity || !is_numeric($user_entity)) {
                $errormsg = "No se encuentra el empredimiento de codigo: " . $user_entity;
				Log::error(sprintf('%s:%s', 'AsesoriaController@store', $errormsg));
				return Response::json(array('success' => false, 'errors' =>  $errormsg));
            }

            $user = Usuario::find($codigo_usuario);
            if(!$user instanceof Usuario) {
                $errormsg = "No se encuentra el usuario del mentor de codigo: " + $codigo_usuario;
				Log::error(sprintf('%s:%s', 'AsesoriaController@store', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
            }

            $user_mentoring = Usuario::find(Auth::user()->codigo_usuario);
            if(!$user_mentoring instanceof Usuario) {
                $errormsg = "No se encuentra el usuario de codigo: " + $codigo_usuario;
				Log::error(sprintf('%s:%s', 'AsesoriaController@store', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
            }

            $entity = Entidad::select('usuario.codigo_usuario','usuario.nombre_usuario','entidad.codigo_entidad')->where('entidad.codigo_usuario', '=', $user_entity)->join('seguridad.usuario','entidad.codigo_usuario','=','usuario.codigo_usuario')->first();
            if(!$entity instanceof Entidad) {
                $errormsg = "No se encuentra el la entidad de codigo: " + $codigo_usuario;
				Log::error(sprintf('%s:%s', 'AsesoriaController@store', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
			}

			$asesoria = new Asesoria;
			if ($asesoria->isValid($data)) {
				DB::beginTransaction();
	        	try {
					// Asesoria
					$asesoria->fill($data);
					$asesoria->codigo_estado = Estado::getState('active');
		   			$asesoria->codigo_usuario = Auth::user()->codigo_usuario;
		   			$asesoria->fecha_asesoria = date('Y-m-d');
		   			$asesoria->hora_asesoria = date('H:i:s');
		   			$asesoria->seg_codigo_usuario = $user->codigo_usuario;
		   			$asesoria->codigo_entidad = $entity->codigo_entidad;
		   			$asesoria->save();

					// Tags
		   			$inputTags = explode(',', Input::get('tags_asesoria'));
					$tags = $asesoria->tags()->get();

					if(Input::has('tags_asesoria') && is_array($inputTags) && count($inputTags) > 0) {
				   		foreach($inputTags as $item) {
							if(!$tags->contains('texto_tag', $item)){
		   			  			$tag = Tag::firstOrCreate(['texto_tag' => $item]);
								if(!$tag instanceof Tag) {
									throw new Exception('tag not found');
								}
								$asesoria->tags()->attach($tag);
							}
					   	}
					}

		   			$questionInstitution = new AsesoriaInstitucion;
		   			$questionInstitution->codigo_asesoria = $asesoria->codigo_asesoria;
		   			$questionInstitution->codigo_institucion = RegistroSesion::getInstitution();
					$questionInstitution->codigo_estado = Estado::getState('pending');
		   			$questionInstitution->save();

		   			// Send notification
					$data = [];
					$data['_template'] = 'emails.mentoring.requestprocess';
					$data['_inst'] = RegistroSesion::getInstitution();
					$data['_subject'] = 'Solicitud de proceso de acompañamiento';
					$data['_to'] = $user->correo_electronico;
					$data['_to_name'] = ucwords(strtolower($user->nombre_usuario));
                    $data['_url_action_refuse'] = route('mentoria.preguntas.rechazar', ['asesoria' => TuProyecto::encryptSrcParams([$asesoria->codigo_asesoria])]);
					$data['_url_action'] = route('mentoria.preguntas.aceptar', ['asesoria' => TuProyecto::encryptSrcParams([$asesoria->codigo_asesoria])]);
					$data['_requesting'] = ucwords(strtolower($user_mentoring->nombre_usuario));
					$data['_entity'] = ucwords(strtolower($entity->nombre_usuario));
					$data['_desc'] = $asesoria->descripcion_asesoria;
					SendEmail::notification($data);

					// Commit Transaction
					DB::commit();
					return Response::json(['success' => true, 'codigo_asesoria' => TuProyecto::encryptSrcParams([$asesoria->codigo_asesoria]), 'message' => Lang::get('tuproyecto.mentoring.notification', ['mentor' => ucwords(strtolower($user->nombre_usuario))] )]);

				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return Response::json(array('success' => false, 'errors' => $e->getMessage()));
				}
			}
			return Response::json(array('success' => false, 'errors' => $asesoria->errors));
		}
    	abort(404);
	}

	/**
	 * Display the resource from id.
	 *
	 * @param  String  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Type encrypt params
        switch (Input::has('type')) {
            case 'encrypt':
                // Decrypt src-params
                list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
                if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
                    abort(403);
                }
                break;
            default:
                // Decrypt url
				list($url, $codigo_asesoria) = explode('-', $id);
				if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
					abort(403);
				}
                break;
        }

		$advice = Asesoria::getMentoring($codigo_asesoria);
		if(!$advice instanceof Asesoria) {
            abort(404);
		}

        if(!in_array(Auth::user()->codigo_usuario, $advice->getAllowedUsers())) {
			abort(403);
		}

		if(Request::ajax()){
			return Response::json(Asesoria::buildAdvice($advice));
		}
       	return View::make('core/mentoring/main');
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

        // Decrypt src-params
		list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
			abort(403);
		}

		$advice = Asesoria::getMentoring($codigo_asesoria);
		if(!$advice instanceof Asesoria) {
            abort(404);
		}

        if(Request::ajax()) {
            $data = Input::all();
            try{
                AsesoriaInstitucion::where('codigo_asesoria', '=', $advice->codigo_asesoria)
                ->where('codigo_institucion', '=', RegistroSesion::getInstitution())
                ->update(['codigo_estado' => Estado::getState('closed')]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s:%s', 'AsesoriaController update', $e->getMessage()));
                return Response::json(array('success' => false, 'errors' => $e->getMessage()));
            }

            return Response::json(['success' => true, 'codigo_asesoria' => TuProyecto::encryptSrcParams([$advice->codigo_asesoria]), 'message' => Lang::get('tuproyecto.mentoring.closed')]);
        }

        abort(404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Decrypt src-params
		list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
			abort(403);
		}

		$advice = Asesoria::getMentoring($codigo_asesoria);
		if(!$advice instanceof Asesoria) {
            abort(404);
		}

		if($advice->mentor == Auth::user()->codigo_usuario){
			if($advice->codigo_estado == Estado::getState('pending')){
				DB::beginTransaction();
				try {
					// rejected advice
					$advice->codigo_estado = Estado::getState('rejected');
					$advice->save();

					// rejected institution advice
					AsesoriaInstitucion::where('codigo_asesoria', '=', $advice->codigo_asesoria)
					    ->where('codigo_institucion', '=', RegistroSesion::getInstitution())
					    ->update(['codigo_estado' => Estado::getState('rejected')]);

					// Send notification
					$data = [];
					$data['_template'] = 'emails.mentoring.rejectadvice';
					$data['_inst'] = RegistroSesion::getInstitution();
					$data['_subject'] = 'Solicitud de mentoría rechazada';
					$data['_to'] = $advice->correo_emprendedor;
					$data['_to_name'] = ucwords(strtolower($advice->short_name_emprendedor));
					$data['_url_action'] = route('mentoria.index');
					$data['_requesting'] = ucwords(strtolower($advice->short_name_mentor));
					SendEmail::notification($data);

                    // Broadcasting event
                    event(new Notification([
                        'title' => 'Solicitud de mentoría rechazada',
                        'content' => sprintf('Tu solicitud realizada al mentor %s, de a cuerdo a su criterio de evaluacion no ha sido aceptada.', ucwords(strtolower($advice->short_name_mentor))),
                        'url' => route('mentoria.preguntas.index'),
                        'receivedBy' => $advice->emprendedor,
                        'module' => Modulo::getModule('mentoring'),
                        'resource' => $advice->codigo_asesoria
                    ]));

					// Commit Transaction
					DB::commit();
					return redirect('/mentoria/preguntas');

				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'AsesoriaController destroy', $e->getMessage()));
					abort(500);
				}
			}
			return redirect('/mentoria/preguntas');
		} else if($advice->emprendedor == Auth::user()->codigo_usuario){

			return redirect('/mentoria/preguntas');
		}
		abort(403);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function aceptar($id)
	{
		// Decrypt src-params
		list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
		// $codigo_asesoria = $id;
		if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
			abort(403);
		}

		$advice = Asesoria::getMentoring($codigo_asesoria);
		if(!$advice instanceof Asesoria) {
            abort(404);
		}

		if($advice->mentor == Auth::user()->codigo_usuario){
			if($advice->codigo_estado == Estado::getState('pending')){
				DB::beginTransaction();
				try {
					AsesoriaInstitucion::where('codigo_asesoria', '=', $advice->codigo_asesoria)
					    ->where('codigo_institucion', '=', RegistroSesion::getInstitution())
					    ->update(['codigo_estado' => Estado::getState('active')]);

					// Prepare data institution
					$institution = Institucion::find(RegistroSesion::getInstitution());

					// Send notification
					$data = [];
					$data['_template'] = 'emails.mentoring.acceptadvice';
					$data['_inst'] = RegistroSesion::getInstitution();
					// $data['_subject'] = 'Solicitud de mentoría aceptada';
					$data['_subject'] = transtp('mentoring.subjectAcceptMentoring', ['institution' => $institution->nombre_institucion]);
					$data['_to'] = $advice->correo_emprendedor;
					$data['_to_name'] = ucwords(strtolower($advice->short_name_emprendedor));
					$data['_url_action'] = route('mentoria.mentores.procesos.show', ['procesos' => $id]);
					$data['_requesting'] = ucwords(strtolower($advice->short_name_mentor));
					SendEmail::notification($data);

                    // Broadcasting event
                    event(new Notification([
                        'title' => 'Solicitud de mentoría aceptada',
                        'content' => sprintf('Tu solicitud realizada al mentor %s ha sido aceptada para iniciar el proceso de acompañamiento.', ucwords(strtolower($advice->short_name_mentor))),
                        'url' => route('mentoria.mentores.procesos.show', ['procesos' => $codigo_asesoria ]),
                        'receivedBy' => $advice->emprendedor,
                        'module' => Modulo::getModule('mentoring'),
                        'resource' => $advice->codigo_asesoria
					]));

					// Commit Transaction
					DB::commit();
					return redirect()->route('mentoria.mentores.procesos.show', ['procesos' => $id]);

				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'AsesoriaController aceptar', $e->getMessage()));
					abort(500);
				}
			}
			return redirect('/mentoria/preguntas');
		}
		abort(403);
	}
}
