<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Requests;
use Illuminate\Support\Facades\Validator;
use TuProyecto,  View, Response, Auth, Input, DB, Log, Lang, App, SendEmail, Redirect;
use App\Mentoria,
    App\MentoriaInstitucion,
    App\Evento,
    App\EventoInstitucion,
    App\ObjetivoMentoria,
    App\AsesoriaInstitucion,
    App\RegistroSesion,
    App\Estado,
    App\Modulo,
    App\Asesoria,
    App\Institucion;

use App\Custom\Rutan;

use App\Events\Notification;

class MentoriaSessionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscription', ['only' => ['store', 'create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
   
        if ($request->ajax() && $request->has('advisory')) {
            list($codigo_asesoria) = TuProyecto::decryptSrcParams($data['advisory']);
            $data['codigo_asesoria'] = $codigo_asesoria;
            unset($data['state']);
            unset($data['date_mentoring']);
            return Response::json(Mentoria::getMentors($data));
        } elseif ($request->ajax()) {
            return Response::json(Mentoria::getMentors($data));
        }
   
       /* if ( $request->ajax()) {
            return Response::json(Mentoria::getMentors($data));
        }*/
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
        $data = $request->all();
        list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
        if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
            abort(403);
        }

        $advice = Asesoria::getMentoring($codigo_asesoria);
        if(!$advice instanceof Asesoria) {
            abort(404);
        }

        if(!in_array(Auth::user()->codigo_usuario, $advice->getAllowedUsers())) {
            abort(403);
        }

        if($request->ajax()){
            // dd(Asesoria::buildAdvice($advice));
            return Response::json(Asesoria::buildAdvice($advice));
        }
        return View::make('core/mentoring/main');
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
        if($request->ajax()) {
			try {
                list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
                $action = $request->get('action');

                if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
                    abort(403);
                }

                $advice = Asesoria::getMentoring($codigo_asesoria);
                if(!$advice instanceof Asesoria) {
                    abort(404);
                }

                $adviceInstitution = AsesoriaInstitucion::where('codigo_asesoria', $codigo_asesoria)->where('codigo_institucion', RegistroSesion::getInstitution())->first();
                if (!$adviceInstitution instanceof AsesoriaInstitucion) {
                    abort(404);
                }
				DB::beginTransaction();
                $message = '';
                switch ($action) {
                    case 'conclude':
                        AsesoriaInstitucion::where('codigo_asesoria', $codigo_asesoria)
                            ->where('codigo_institucion', RegistroSesion::getInstitution())
                            ->update(['codigo_estado' => Estado::getState('closed')]);

                        $message = 'Proceso de mentoría finalizado correctamente';
                    break;
                    case 'accept':
                        AsesoriaInstitucion::where('codigo_asesoria', $codigo_asesoria)
                        ->where('codigo_institucion', RegistroSesion::getInstitution())
                        ->update(['codigo_estado' => Estado::getState('active')]);

						// Prepare data institution
						$institution = Institucion::find(RegistroSesion::getInstitution());

                        // Send notification
                        $data = [];
                        $data['_template'] = 'emails.mentoring.acceptadvice';
                        $data['_inst'] = RegistroSesion::getInstitution();
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

						$message = 'Proceso de mentoria aceptado correctamente';
                    break;
					case 'refuse':
					if($advice->mentor == Auth::user()->codigo_usuario){
							$advice->codigo_estado = Estado::getState('rejected');
							$advice->save();

                        AsesoriaInstitucion::where('codigo_asesoria', $codigo_asesoria)
                        ->where('codigo_institucion', RegistroSesion::getInstitution())
                        ->update(['codigo_estado' => Estado::getState('rejected')]);

                        // Send notification
                        $data = [];
                        $data['_template'] = 'emails.mentoring.rejectadvice';
                        $data['_inst'] = RegistroSesion::getInstitution();
                        $data['_subject'] = transtp('mentoring.subjectRefuseMentoting');
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

					$message = 'Proceso de mentoría rechazado correctamente';
					} elseif($advice->emprendedor == Auth::user()->codigo_usuario){

						$advice->codigo_estado = Estado::getState('finalized');
						$advice->save();

						AsesoriaInstitucion::where('codigo_asesoria', $codigo_asesoria)
                        ->where('codigo_institucion', RegistroSesion::getInstitution())
                        ->update(['codigo_estado' => Estado::getState('finalized')]);

						$message = 'Sesión de mentoria eliminada correctamente' ;

					}
                    break;
                    case 'remove':
                        $mentoringInstitution->codigo_estado = Estado::getState('finalized');
                        $mentoringInstitution->save();
                        $mentoring->codigo_estado = Estado::getState('finalized');
                        $mentoring->save();

                        $message = 'Sesión de mentoria eliminada correctamente' ;
                    break;
                }

                // Commit Transaction
                DB::commit();
                return Response::json(['success' => true, 'codigo_asesoria' => TuProyecto::encryptSrcParams([$codigo_asesoria]), 'message' => $message]);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s:%s', 'Update Mentoring', $e->getMessage()));
                return Response::json(array('success' => false, 'errors' => $e->getMessage()));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
	 * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

		if($request->ajax()) {
			$data = $request->all();

			list($codigo_mentoria) = TuProyecto::decryptSrcParams($id);

			if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
				$errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
				Log::error(sprintf('%s:%s', 'MentoriaSessionesController@destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
			}

			$mentoring = Mentoria::find($codigo_mentoria);
			if (!$mentoring instanceof Mentoria) {
				$errormsg = "No se encuentra mentoria de codigo " . $codigo_mentoria;
				Log::error(sprintf('%s:%s', 'MentoriaSessionesController@destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
			}

			$mentoringInstitution = MentoriaInstitucion::where('codigo_mentoria', $codigo_mentoria)->where('codigo_institucion', RegistroSesion::getInstitution())->first();
			if (!$mentoringInstitution instanceof MentoriaInstitucion) {
				$errormsg = "No se encuentra para esta insitucion mentoria de codigo " . $codigo_mentoria;
				Log::error(sprintf('%s:%s', 'MentoriaSessionesController@destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => $errormsg));
			}
			try {

				DB::beginTransaction();
					$mentoring->codigo_estado = Estado::getState('removed');
					$mentoring->save();

					Mentoria::where('codigo_mentoria', $codigo_mentoria)
					->update(['codigo_estado' => Estado::getState('removed')]);

					MentoriaInstitucion::where('codigo_mentoria', $codigo_mentoria)
                        ->where('codigo_institucion', RegistroSesion::getInstitution())
						->update(['codigo_estado' => Estado::getState('removed')]);

					ObjetivoMentoria::where('codigo_mentoria',$codigo_mentoria )
					->update(['codigo_estado' => Estado::getState('removed')]);

					Evento::where('codigo_evento', '=', $mentoring->codigo_evento)
					->update(['codigo_estado' => Estado::getState('removed')]);

					// Update event institution
					EventoInstitucion::where('codigo_evento', $mentoring->codigo_evento)->where('codigo_institucion', RegistroSesion::getInstitution())
						->update(['codigo_estado' => Estado::getState('active')]);
					$message = 'Sesión de mentoria eliminada correctamente' ;

					DB::commit();

				return Response::json(['success' => true, 'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]), 'message' => $message]);
			} catch (\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s:%s', 'MentoriaSessionesController@destroy', $e->getMessage()));
                return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
            }
		}
	}

    public function generalObjetive(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@generalObjetive', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@generalObjetive', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

			Mentoria::where('codigo_mentoria', $codigo_mentoria)
			->update([ 'objetivo_mentor' => $request->objetive]);


            // foreach ($mentorias as $mentoria) {
            //     Mentoria::where('codigo_asesoria', $mentoria->codigo_asesoria)
            //         ->update(['objetivo_mentor' => trim($request->objetive)]);
            // }

            DB::commit();
            return Response::json(['success' => true, 'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]), 'message' => 'Observaciones agregadas correctamente']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@generalObjetive', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
        }
    }

    public function descriptionMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@generalObjetive', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@generalObjetive', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([ 'descripcion_mentoria' => $request->description]);

            DB::commit();
            return Response::json(['success' => true, 'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]), 'message' => 'Descripcion agregada correctamente']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@descriptionMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
        }
    }

    /**
     * guarda la fase de la mentoria
     * función solicitada por Rutan para el campo fase del proceso
     * @param $request
     * @return Response
     */
    public function phaseMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@phaseMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@phaseMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([ 'fase' => $request->phase]);

            //si la fase no es "diagnostico", seteamos campo en DB a ''
            if ($request->phase !== 'diagnóstico') {
                Mentoria::where('codigo_mentoria', $codigo_mentoria)
                            ->update([ 'diagnostico' => '']);
            }

            DB::commit();
            return Response::json([
                    'success' => true,
                    'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                    'message' => 'Fase agregada correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@phaseMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
        }
    }

    /**
     * guarda pregunta : ¿Se recomienda para la siguiente etapa?, campo de rutan
     * @param Request $request
     * @return Response
     */
    public function recommendsMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@recommendsMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@recommendsMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([ 'recomendacion' => $request->recommends]);

            DB::commit();
            return Response::json([
                    'success' => true,
                    'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                    'message' => 'Recomendación agregada correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@recommendsMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
        }
    }

    /**
     * guarda pregunta : Seguimento, campo de rutan
     * @param Request $request
     * @return Response
     */
    public function tracingMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@tracingMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@tracingMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([ 'seguimiento' => $request->tracing]);

            DB::commit();
            return Response::json([
                    'success' => true,
                    'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                    'message' => 'Seguimiento agregado correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@tracingMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' => 'No se pudo agregar Seguimiento'));
        }
    }

    /**
     * guarda pregunta : Diagóstico, campo de rutan
     * @param Request $request
     * @return Response
     */
    public function diagnosisMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);
        
        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@diagnosisMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@diagnosisMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([ 'diagnostico' => $request->diagnosis]);

            DB::commit();
            return Response::json([
                    'success' => true,
                    'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                    'message' => 'Diagnóstico agregado correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@diagnosisMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' => 'No se pudo agregar Diagnóstico'));
        }
    }

    /**
     * guarda pregunta : asignacion de voucher, campo de rutan
     * @param Request $request
     * @return Response
     */
    public function assigvoucherMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if ($request->assigvoucher) {
            $data = json_encode($request->assigvoucher);
        } else {
            $data = '';
        }

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@assigvoucherMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@assigvoucherMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([ 'asignacion_voucher' => $data]);

            DB::commit();
            return Response::json([
                    'success' => true,
                    'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                    'message' => 'Voucher asignado correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@assigvoucherMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' => 'No se pudo agregar Voucher'));
        }
    }

    public function finishedMentoring(Request $request) {
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);
        list($codigo_asesoria) = TuProyecto::decryptSrcParams($request->asesoria);
        $fecha_finalizo_mentoria = date('Y-m-d');

		if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@finishedMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@finishedMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $advice = Asesoria::getMentoring($codigo_asesoria);

        if(!$advice instanceof Asesoria) {
            abort(404);
        }

        if (isset($mentorias[0]->duration_mentoring)) {
            $duracionMentoria = trim($mentorias[0]->duration_mentoring);
            $duracionMentoria = explode(',', $duracionMentoria);
            $duracionMentoria = "$duracionMentoria[0]h y $duracionMentoria[1]m";
        } else {
            $duracionMentoria = '--';
        }


        $codigoEvento = Mentoria::select('codigo_evento')->find($codigo_mentoria);
        $evento = Evento::select('nombre_evento', 'fecha_evento', 'hora_inicio_evento')
            ->find($codigoEvento->codigo_evento);

        try {
            DB::beginTransaction();

            // Prepare data institution
            $institution = Institucion::find(RegistroSesion::getInstitution());

            if ($request->has('accept')) {
                Mentoria::where('codigo_mentoria', $codigo_mentoria)
                    ->update([
								'codigo_estado' => Estado::getState('closed'),
								'fecha_finalizo_mentoria' => $fecha_finalizo_mentoria
							]);

                // Send notification
                $data = [];
                $data['_template'] = 'emails.mentoring.acceptmentoring';
                $data['_inst'] = RegistroSesion::getInstitution();
                $data['_subject'] = transtp('mentoring.subjectAcceptMentoringEntrepreneur', 
                    ['nameEntrepreneur' => ucwords(strtolower($advice->short_name_emprendedor))]);
                $data['_to'] = $advice->correo_mentor;
                $data['_to_name'] = ucwords(strtolower($advice->short_name_mentor));
                $data['_url_action'] = route('mentoria.mentores.procesos.index');
                $data['_requesting'] = ucwords(strtolower($advice->short_name_emprendedor));
                $data['_title_mentoring'] = ucwords(strtolower($evento->nombre_evento));
                $data['_sessionID'] = $codigo_mentoria;
                $data['_description_mentoring'] = $mentorias[0]->descripcion_mentoria;
                $data['_duration_mentoring'] = $duracionMentoria;
                $data['_dateAndHour'] = "$evento->fecha_evento $evento->hora_inicio_evento";
                SendEmail::notification($data);

                $this->afterAcceptMentoring($codigo_mentoria, $advice);

            } else {
                Mentoria::where('codigo_mentoria', $codigo_mentoria)
                    ->update([ 'codigo_estado' => Estado::getState('pending_accept_session')]);

                // Send notification
                $data = [];
                $data['_template'] = 'emails.mentoring.finishementoring';
                $data['_inst'] = RegistroSesion::getInstitution();
                $data['_subject'] = transtp('mentoring.subjectFinishedMentoring', 
                    ['nameMentor' => ucwords(strtolower($advice->short_name_mentor))]);
                $data['_to'] = $advice->correo_emprendedor;
                $data['_to_name'] = ucwords(strtolower($advice->short_name_emprendedor));
                $data['_url_action'] = route('mentoria.mentores.procesos.index');
                $data['_requesting'] = ucwords(strtolower($advice->short_name_mentor));
                $data['_title_mentoring'] = ucwords(strtolower($evento->nombre_evento));
                $data['_sessionID'] = $codigo_mentoria;
                $data['_description_mentoring'] = $mentorias[0]->descripcion_mentoria;
                $data['_duration_mentoring'] = $duracionMentoria;
                $data['_dateAndHour'] = "$evento->fecha_evento $evento->hora_inicio_evento";
                SendEmail::notification($data);
            }

            DB::commit();
            return Response::json([
                'success' => true,
                'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                'message' => 'Descripcion agregada correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@finishedMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
        }
    }
    public function durationMentoring(Request $request) {

        $messages = [
            'required'    => 'El campo :attribute es requerido.',
            'hour.min'    => 'El valor mínimo de la Hora es 0',
            'hour.max'    => 'El valor máximo de la Hora es 99',
            'minutes.min' => 'El valor mínimo de los Minutos es 0',
            'minutes.max' => 'El valor máximo de los Minutos es 59',
        ];

        $rules = [
            'mentoria' => 'required',
            'hour'     => 'required|integer|min:0|max:99',
            'minutes'  => 'required|integer|min:0|max:59',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $errors = $validator->errors();
        $error = '';
        foreach ($errors->all() as $message) {
            $error .= $message . '<br>';
        }
        
        if ($validator->fails()) {
            return Response::json([
                    'success' => false,
                    'errors' => $error
                ]);
        }

        $duration = [];
        array_push($duration, $request->hour, $request->minutes);
        $duration = implode(",", $duration);

        list($codigo_mentoria) = TuProyecto::decryptSrcParams($request->mentoria);

        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            $errormsg = "El codigo de mentoria es inválido" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@durationMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        $mentorias = Mentoria::where('codigo_mentoria', $codigo_mentoria)->get();
        if (!count($mentorias)) {
            $errormsg = "No se encuentra la Mentoria" . $codigo_mentoria;
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@durationMentoring', $errormsg));
            return Response::json(array('success' => false, 'errors' => $errormsg));
        }

        try {
            DB::beginTransaction();

            Mentoria::where('codigo_mentoria', $codigo_mentoria)
                ->update([
                    'duration_mentoring' => $duration
                ]);

            DB::commit();
            return Response::json([
                'success' => true,
                'codigo_mentoria' => TuProyecto::encryptSrcParams([$codigo_mentoria]),
                'message' => 'Duración de la sesión agregada correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(sprintf('%s:%s', 'MentoriaSessionesController@durationMentoring', $e->getMessage()));
            return Response::json(array('success' => false, 'errors' =>  $e->getMessage()));
        }
    }

    /**
     * Lógica después de aceptar la mentoria por parte del emprendedor.
     * @access private
     * @param int $codigo_mentoria
     */
    private function afterAcceptMentoring(int $codigo_mentoria, $advice)
    {
        switch (RegistroSesion::getInstitution()) {
            case 61:
                Rutan::sendEmailAfterAcceptMentoring($codigo_mentoria, $advice);
                break;
        }
    }
}
