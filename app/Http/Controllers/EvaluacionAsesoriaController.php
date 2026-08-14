<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Lang, Log, Auth, SendEmail;

use App\Asesoria, App\Estado, App\EvaluacionAsesoria, App\TipoComentarioEvaluacion, App\ItemGeneralMentoria, App\CumpliItemsAsesoria, App\Persona, App\Usuario, App\RegistroSesion;

class EvaluacionAsesoriaController extends Controller
{
    /**
     * Instantiate a new EvaluacionAsesoriaController instance.
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
    public function create(Request $request, $id)
    {
        // Decrypt src-params
        list($codigo_asesoria) = TuProyecto::decryptSrcParams($id);
        if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
            abort(403);
        }

        $advisory = Asesoria::getMentoring($codigo_asesoria);
        if(!$advisory instanceof Asesoria) {
            abort(404);
        }

		// validation if exist evaluation
		if( $advisory->evaluation_mentor || $advisory->evaluation_entrepreneur ){
			return redirect()->route('mentoria.index');
		}

        if($request->ajax()){return $codigo_asesoria;
            return response()->json(Asesoria::buildAdvice($advisory));
        }

        return view('core/mentoring/main');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $evaluationAdvice = new EvaluacionAsesoria;
            if ($evaluationAdvice->isValid($data)) {
                // Decrypt src-params
                list($codigo_asesoria) = TuProyecto::decryptSrcParams($request->input('codigo_asesoria'));

                if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
                    Log::error(sprintf('%s:%s %s', 'EvaluacionAsesoriaController:store', 'No es valido el codigo asesoria'), $codigo_asesoria );
                    abort(403);
                }

                // Validation user
                $advice = Asesoria::getMentoringEvaluation($codigo_asesoria);
                if(!$advice instanceof Asesoria) {
                    Log::error(sprintf('%s:%s', 'EvaluacionAsesoriaController:store', 'La asesoria no existe'));
                    abort(403);
                }

                // Validate users advice
                if(in_array(Auth::user()->codigo_usuario, $advice->getAllowedUsers()))
                {
					// Default values for email
					$subject = 'Evalua a tu emprendedor';
					$template = 'emails.mentoring.evaluation.sendmentor';
					$nombre_usuario = $advice->nombre_usuario_mentor;
					$correo_electronico = $advice->correo_usuario_mentor;

					// values for email is mentor
					if(Auth::user()->codigo_usuario == $advice->seg_codigo_usuario){
						$subject = transtp('mentoring.subjectEvaluateMentor');
						$template = 'emails.mentoring.evaluation.sendentrepreneur';
						$nombre_usuario = $advice->nombre_usuario_emprendedor;
						$correo_electronico = $advice->correo_usuario_emprendedor;
					}

                    $items = ItemGeneralMentoria::where('codigo_estado' , Estado::getState('active'))->orderBy('codigo_item_general_mentoria','desc')->get();
                    DB::beginTransaction();
                    try {
                        // Insert Evaluacion Asesoria
                        $evaluationAdvice->codigo_asesoria = $advice->codigo_asesoria;
                        $evaluationAdvice->fecha_evaluacion_asesoria = date('Y-m-d');
                        $evaluationAdvice->comentario_evaluacion_asesoria = $request->input('comentario_evaluacion_asesoria');
                        $evaluationAdvice->tipo_comentario_evaluacion = $request->input('tipo_comentario_evaluacion');
                        $evaluationAdvice->tipo_evaluacion_asesoria = $request->get('referee');
                        $evaluationAdvice->save();

                        foreach ($items as $item) {
                            if($request->has("evaluacion_item_asesoria_$item->codigo_item_general_mentoria")) {
                                $checkList = new CumpliItemsAsesoria;
                                $checkList->codigo_evaluacion_asesoria = $evaluationAdvice->codigo_evaluacion_asesoria;
                                $checkList->codigo_estado = Estado::getState('active');
                                $checkList->codigo_item_general_mentoria = $item->codigo_item_general_mentoria;
                                $checkList->evaluacion_item_asesoria = $request->input('evaluacion_item_asesoria_'.$item->codigo_item_general_mentoria);
                                $checkList->save();
                            }
                        }

						if( (Auth::user()->codigo_usuario == $advice->mentor && $advice->evaluation_entrepreneur == false) || (Auth::user()->codigo_usuario == $advice->emprendedor && $advice->evaluation_mentor == false) ){
							// Send notification
							$data = [];
							$data['_subject'] = $subject;
							$data['_template'] = $template;
							$data['_inst'] = RegistroSesion::getInstitution();
							$data['_to'] = $correo_electronico;
							$data['_to_name'] = ucwords(strtolower($nombre_usuario));
							$data['_from_name'] = ucwords(strtolower(Auth::user()->nombre_usuario));
                            $data['_url_action'] = route('mentoria.preguntas.evaluacion.mentor.create', ['mentoria' => $request->input('codigo_asesoria')]);
                            SendEmail::notification($data);

                            // Send Notification Mentor
							if ( Auth::user()->codigo_usuario == $advice->mentor && $advice->evaluation_entrepreneur == false ) {
								$dataMentor = [];
								$dataMentor['_subject'] = transtp('mentoring.emails.evaluation.mentor.subjectMentorEvaluation');
								$dataMentor['_template'] = 'emails.mentoring.evaluation.mentorevaluation';
								$dataMentor['_inst'] = RegistroSesion::getInstitution();
								$dataMentor['_mentor'] = $advice->nombre_usuario_mentor;
								$dataMentor['_usuario'] = ucwords(strtolower($nombre_usuario));
								$dataMentor['_commentary'] = ucwords(trim($request->input('comentario_evaluacion_asesoria')));
								$dataMentor['_type_commentary'] = TipoComentarioEvaluacion::find($request->input('tipo_comentario_evaluacion'))->nombre_tipo_come_eval;
								$dataMentor['_to'] = $advice->correo_usuario_emprendedor;
								SendEmail::notification($dataMentor);
							}
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'message' => Lang::get('mentoring.evaluation.entrepreneur.success')]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error(sprintf('%s:%s', 'EvaluacionAsesoriaController:store', $e->getMessage()));
                        return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                    }
                }
                abort(403);
            }
            return response()->json(['success' => false, 'errors' => $evaluationAdvice->errors]);
        }
        abort(404);
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
