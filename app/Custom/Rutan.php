<?php

/**
 * Permite personalizar procesos para la institución Ruta N.
 * @author Ayriel Noriega <ayrieltuproyecto@gmail.com>
 * @author Harold Rodríguez <hartuproyecto@gmail.com>
 */
namespace App\Custom;

use App,
	Auth,
	AWS,
	DB,
	Lang,
	Log,
	SendEmail;

use App\AsignacionGestorVoucher,
	App\Asesoria,
	App\Ciudad,
	App\ConvocatoriaMentoria,
	App\Compra,
	App\DatoEntidad,
	App\DetalleVoucher,
	App\Entidad,
	App\Estado,
	App\Fase,
	App\Mentoria,
	App\OpcionEvaluacionPregunta,
	App\PreguntaEncuesta,
	App\RegistroFaseUsuario,
	App\RegistroSesion,
	App\ResultadoEvaluacionEmprendimiento,
	App\Usuario,
	App\UsuarioEncuesta,
	App\EdicionEvaluacion;

class Rutan
{
	/**
	 * Se definen atributos.
	 * @Annotation atributo $id_institution equivale al codigo_institucion de Ruta N.
	 * @access public
	 */
	public static $program_ruta_del_emprendimiento = 249;
	public static $codigo_evaluacion_emprendimiento_rutan = 28;
	public static $id_institution = 61;
    public static $id_group = [64,65,66,67,68];
	public static $codigo_evaluacion_preincubacion = 31;
    public static $codigo_evaluacion_incubacion = 32;
	public static $codigo_evaluacion_aceleracion = 33;
	public static $codigo_evaluacion_consolidacion = 34;


    public static function validFirstRutaEmprendimiento(UsuarioEncuesta $userSurvey, $request)
	{
		$response = new \stdClass();
		$response->success = true;

		// Get user entity
		$query = Usuario::query();
		$query->select(
            'entidad.codigo_entidad',
            'entidad.codigo_usuario',
            'entidad.codigo_clase_empre_insti'
        );
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('usuario.codigo_usuario', $userSurvey->codigo_usuario);
		$user = $query->first();

		if(!$user instanceof Usuario) {
			$response->success = false;
			$response->data = trans('app.exception');
			return $response;
		}

		// Validacion inconsistencia empresa, pagina 3
		if(isset($request['current_page']) && $request['current_page'] == 3) {
			if($user->codigo_clase_empre_insti == 60) { // es proyecto?
                if($request['pregunta_6044_opcion'] == 12261){ // ¿Tienes empresa constituida y registrada? si
                    $response->success = false;
                    $response->data = "Usted está registrando datos de una empresa, sin embargo,
                        su registro se realizó con un proyecto. Por favor validar.";
                    return $response;
                }
			}

			if($user->codigo_clase_empre_insti == 61) { // es empresa?
                if($request['pregunta_6044_opcion'] == 12262){ // ¿Tienes empresa constituida y registrada? no
                    $response->success = false;
                    $response->data = "Usted está realizando el registro con una empresa, sin embargo,
					está indicando \"No\" en la pregunta ¿Tienes empresa constituida y registrada?. Por favor validar.";
                    return $response;
                }
			}
		}

		return $response;
	}

	public static function notificationsOfEvaluation(
		int $codigo_evaluacion_emprendimiento,
		$data,
		Usuario $user_project,
		$codigo_registro_convocatoria
	): void {
		switch ($codigo_evaluacion_emprendimiento) {
			case '28':
				switch ($data['codigo_evaluacion_item_259']) {
					case 608: //ideacion
						Log::info("ideacion");
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.ideacion.subject');
						$info['template'] = 'Ideacion';
						$name_imail = 'Ideación';
						self::updateToPhase($user_project, 'ideacion_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						break;
					case 609: //preincubacion
						Log::info("preincubacion");
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.preincubacion.subject');
						$info['template'] = 'Preincubacion';
						self::updateToPhase($user_project, 'preincubacion_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Preincubación';
						break;
					case 611: //incubacion
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.incubacion.subject');
						$info['template'] = 'Incubacion';
						self::updateToPhase($user_project, 'incubacion_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Incubación';
						break;
					case 612: //aceleracion
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.aceleracion.subject');
						$info['template'] = 'Aceleracion';
						self::updateToPhase($user_project, 'aceleracion_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Aceleración';
						break;
					case 613: //consolidacion
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.consolidacion.subject');
						$info['template'] = 'Consolidacion';
						self::updateToPhase($user_project, 'consolidacion_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Consolidación';
						break;
					case 619: //no aplica por edad
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.edad.subject');
						$info['template'] = 'Edad';
						self::updateToPhase($user_project, 'na_edad_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'No aplica por edad';
						break;
					case 620: //no aplica ciudad residencia
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.ciudad.subject');
						$info['template'] = 'Ciudad';
						self::updateToPhase($user_project, 'na_ciudad_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'No aplica por ciudad de residencia';
						break;
					case 621: //sin base tecnológica
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.sin_base_tecnologica.subject');
						$info['template'] = 'BaseTecnologica';
						self::updateToPhase($user_project, 'sin_base_tecnologica_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Sin base tecnológica';
						break;
					case 623: //no edad no ciudad => No aplica por camara de comercion en Medellin
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.SinCamaraComercio.subject');
						$info['template'] = 'SinCamaraComercio';
						self::updateToPhase($user_project, 'na_camara_comercio', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Sin cámara de comercio en Medellín';
					break;
					case 614: //laboratorio innovación
						$emprendedor = self::getUser($user_project->codigo_usuario);
						$info = [];
						$info['to_name'] = $emprendedor['nombre_usuario'] . ' 🧠⚡️';
						$info['to'] = $emprendedor['correo_electronico'];
						$info['subject'] = Lang::get('rutan.evaluation.notification.lab_innovacion.subject');
						$info['template'] = 'LabInnovacion';
						self::updateToPhase($user_project, 'laboratorio_innovacion_ruta_emprendimiento', $codigo_registro_convocatoria);
						//self::sendNotification($info);
						$name_imail = 'Laboratorio Innovacion';
					return;
					break;
					default:
						return;
				}
			break;
			default:
				return;
		}

		$user = Usuario::find(\Auth::user()->codigo_usuario);
		if(!$user instanceof Usuario) {
			throw new \Exception("Error recuperando reporte registros convocatoria ".\Auth::user()->codigo_usuario);
		}

/* 		activity()
			->performedOn($user)
			->withProperties([
				'attributes' => [
					'name_email' => $name_imail,
					'project' => $user_project->nombre_usuario

				] ])
			->log('activitylog.assign.notification'); */
		//return;
	}


	/*public static function sendNotification($info)
	{
		// User Mail Notification
		$data = [];
		$data['_subject'] = $info['subject'];
		$data['_template'] = 'emails.project.evaluation.notification'.$info['template'];
		$data['_to'] = $info['to'];
		$data['_to_name'] = $info['to_name'];
		SendEmail::notification($data);

		return;
	}*/

	private static function getUser(int $codigo_usuario)
	{
		$query = Usuario::select('usuario1.*', 'persona.*')
			->join('core.entidad', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario')
			->join('core.persona as persona', 'persona.codigo_usuario', '=', 'entidad.seg_codigo_usuario')
			->join('seguridad.usuario as usuario1', 'usuario1.codigo_usuario', '=', 'persona.codigo_usuario')
			->where('usuario.codigo_usuario', $codigo_usuario);
		return $data = $query->first();
	}

	public static function updateToPhase($user_project, string $perfilamiento, $codigo_registro_convocatoria)
	{
			DB::beginTransaction();
		try {
			//recuperar ultima phase que tiene registrada el usuario
			$registerPhase = RegistroFaseUsuario::join('core.registro_convocatoria',
														'registro_convocatoria.codigo_registro_convocatoria',
														'=', 'registro_fase_usuario.codigo_registro_convocatoria'
														)
													->where('registro_fase_usuario.codigo_usuario', $user_project->codigo_usuario)
													->where('registro_fase_usuario.codigo_registro_convocatoria', $codigo_registro_convocatoria)
													->orderBy('codigo_registro_fase_usuario', 'desc')
													->first();

			$phase = Fase::find($registerPhase->codigo_fase);
			if(!$phase instanceof Fase) {
				DB::rollback();
				return response()->json(['success' => false, 'errors' => 'No se encontró la fase']);
			}


			if(!$registerPhase instanceof RegistroFaseUsuario) {
				DB::rollback();
				return response()->json(['success' => false, 'errors' => "No se encontró codigo registro fase usuario."]);
			}

			//actualizamos phase actual
			$registerPhase->codigo_estado = Estado::getState('finalized');
			$registerPhase->visualizacion_usuario = true;
			$registerPhase->notificacion_cambio_registro_fase = date('Y-m-d H:m:s');
			$registerPhase->notificacion_registro_fase_usuario = true;
			$registerPhase->seg_codigo_usuario = Auth::user()->codigo_usuario;
			$registerPhase->save();

			//creamos nueva phase
			$register = new RegistroFaseUsuario;
			$register->codigo_fase = self::getIdPhase($perfilamiento);
			$register->codigo_usuario = $registerPhase->codigo_usuario;
			$register->fecha_registro_fase_usuario = date('Y-m-d');
			$register->hora_registro_fase_usuario = date('H:i:s');
			$register->codigo_estado = Estado::getState('active');
			$register->codigo_registro_convocatoria = $registerPhase->codigo_registro_convocatoria;
			$register->visualizacion_usuario = false;
			$register->save();

			// Commit Transaction
			DB::commit();
		}catch(\Exception $e){
			DB::rollback();
			Log::error(sprintf('%s:%s', 'Actualizar perfilamiento: ', $e->getMessage()));
			return response()->json([
										'success' => false,
										'errors' => 'Ocurrio un error al momento de actualizar phase en perfilamiento.'
									]);
		}

	}

	public static function getIdPhase(string $phase): int
	{
    	switch ($phase) :
		    case 'registro_ruta_emprendimiento': return 345;
		    case 'ideacion_ruta_emprendimiento': return 350;
		    case 'preincubacion_ruta_emprendimiento': return 351;
		    case 'incubacion_ruta_emprendimiento': return 352;
		    case 'aceleracion_ruta_emprendimiento': return 353;
		    case 'consolidacion_ruta_emprendimiento': return 354;
		    case 'sin_base_tecnologica_ruta_emprendimiento': return 355;
		    case 'na_edad_ruta_emprendimiento': return 356;
		    case 'na_ciudad_ruta_emprendimiento': return 357;
		    case 'laboratorio_innovacion_ruta_emprendimiento': return 364;
		    case 'na_camara_comercio': return 363;
			default: return 'Not phase identified';
		endswitch;
    }

	/**
	 * validar si usuario está participando en convocatoria
	 *
	 * @return bool
	 */
	public static function validateApplication()
	{
		//obtiene las entidades del usuario autenticado
		$entyties = Entidad::getEntitysList();

		if ($entyties->count() == 0) {
			return false;
		}
		$count = 0;

		//valida si existe registro en la ruta emprendedora, encuesta 249
		foreach ($entyties as $entiti) {

			$query = PreguntaEncuesta::query();
			$query->join('core.respuesta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta','=', 'pregunta_encuesta.codigo_pregunta_encuesta');
			$query->where("pregunta_encuesta.codigo_encuesta", 249);
			$query->where("respuesta_encuesta.codigo_usuario", $entiti->key);
			$query->where("pregunta_encuesta.codigo_estado", Estado::getState('active'));
			$query = $query->get();

			if ($query->count() == 0) {
				$count ++;
			}
		}

		if ($count == $entyties->count()){
			return true;
		}

		return false;
    }

	/**
     * Envia correo al gestor de voucher.
     * @Annotation esto ocurre en caso de que se haya asignado voucher al emprendedor.
	 * @access public
	 * @static function
	 * @static var $id_institution
     */
	public static function sendEmailAfterAcceptMentoring(int $codigo_mentoria, $data_advice) {
		$sesion_de_mentoria = Mentoria::find($codigo_mentoria);
        $advice = Asesoria::getMentoring($sesion_de_mentoria->codigo_asesoria);
		if ($sesion_de_mentoria instanceof Mentoria) {
			if (!empty($sesion_de_mentoria->asignacion_voucher)) {

				$voucher_manager = self::getVoucherManager();
				$phase = self::getPhase($sesion_de_mentoria->codigo_asesoria);

				if (!is_null($voucher_manager)) {

					//Envía notificación al gestor de voucher.
					$data = [];
					$data['_template']					 = 'emails.mentoring.emailtogestor';
					$data['_inst']						 = self::$id_institution;
					$data['_subject']					 = transtp('mentoring.subjectAcceptMentoringEntrepreneur', ['nameEntrepreneur'  => ucwords(strtolower($advice->short_name_emprendedor))]);
					$data['_to']						 = $voucher_manager->correo_electronico;
					$data['_to_name'] 					 = $voucher_manager->nombre_usuario;
					$data['_categorias_sugeridas'] 		 = $sesion_de_mentoria->asignacion_voucher ? json_decode($sesion_de_mentoria->asignacion_voucher) : false;
					$data['_fecha_aceptacion'] 			 = $sesion_de_mentoria->fecha_finalizo_mentoria;
					$data['_codigo_asesoria'] 			 = $sesion_de_mentoria->codigo_asesoria;
					$data['_codigo_mentoria']			 = $codigo_mentoria;
					$data['_fase']						 = $phase;
					$data['_nombre_usuario_mentor'] 	 = $data_advice->nombre_usuario_mentor;
					$data['_nombre_usuario_emprendedor'] = $data_advice->nombre_usuario_emprendedor;
					$data['_nombre_emprendimiento']      = $data_advice->nombre_emprendimiento;
					SendEmail::notification($data);
				}
			}
		}
	}
	/**
	 * Obtiene un gestor de voucher según la última actualización del registro.
	 * @access private
	 * @static function getVoucherManager
	 * @static var $id_institution
	 * @return Usuario|null
	 */
	private static function getVoucherManager()
	{
		$query = AsignacionGestorVoucher::where('codigo_institucion', self::$id_institution)
		->oldest('updated_at')
		->first();

		if (isset($query)) {
			//Actualiza el campo updated_at y asignaciones.
			$query->asignaciones = $query->asignaciones + 1;
			$query->save();

			return $query->user;
		}
		return null;
	}
	/**
	 * Obtiene la etapa en la que se encuentra el emprendedor.
	 * @access private
	 * @static function getPhase
	 * @return string
	 */
	private static function getPhase($id_advice) : string
	{
		$query = ConvocatoriaMentoria::query();
		$query->select('f.nombre_fase', 'f.codigo_fase');
		$query->join('core.fase as f', 'convocatoria_mentoria.codigo_fase', '=', 'f.codigo_fase' );
		$query->where('convocatoria_mentoria.codigo_asesoria', $id_advice);
		$phase = $query->first();

		return $phase->nombre_fase;
	}

	/**
	 * Obtiene datos del usuario (entidad).
	 * @access public
	 * @return object Usuario|Entidad
	 */
	public static function getProyectEntity(Compra $purchase)
	{
		$query = DetalleVoucher::query();
		$query->select('rf.*');
		$query->join('core.voucher as v','v.codigo_voucher', '=', 'detalle_voucher.codigo_voucher');
		$query->join('core.registro_fase_usuario as rf', 'rf.codigo_registro_fase_usuario', '=', 'detalle_voucher.codigo_registro_fase_usuario');
		$query->where('v.codigo_institucion', self::$id_institution);
		$query->where('detalle_voucher.codigo_usuario', $purchase->codigo_usuario);
		$query->where('detalle_voucher.codigo_estado', Estado::getState('active'));
		$data = $query->first();

		$query_entity = Usuario::query();
		$query_entity->select(
		'entidad.codigo_clase_empre_insti as type_entity',
		'usuario.nombre_usuario as name_entity',
		'usuario.identificacion_usuario as identify_entity'
		);
		$query_entity->join('core.entidad', 'usuario.codigo_usuario' , '=', 'entidad.codigo_usuario');
		$query_entity->where('usuario.codigo_usuario', $data->codigo_usuario);
		$data_entity = $query_entity->first();

		return $data_entity;
    }

	/**
     * guarda ediciones de las evaluaciones
     */
    public static function storeEvaluations(RegistroFaseUsuario $register, $data, $user_project, $id_eval_result)
    {
		//quitamos algunos datos que no nos interesa
		unset($data['seg_codigo_usuario']);
		unset($data['evaluation']);
		unset($data['url_fase']);
		unset($data['_token']);

		if (
			($register->codigo_fase == 351
			|| $register->codigo_fase == 352
			|| $register->codigo_fase == 353
			|| $register->codigo_fase == 354)
			&&
			($data['codigo_evaluacion_emprendimiento'] == 31
			|| $data['codigo_evaluacion_emprendimiento'] == 32
			|| $data['codigo_evaluacion_emprendimiento'] == 33
			|| $data['codigo_evaluacion_emprendimiento'] == 34)
		) {

			$url_pdf = self::getScoring($register, $data, $user_project, $id_eval_result);

			$new_edicion = new EdicionEvaluacion;
			$new_edicion->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
			$new_edicion->codigo_fase = $register->codigo_fase;
			$new_edicion->codigo_usuario =  $register->codigo_usuario;//codigo usuario de la entidad/proyecto
			$new_edicion->seg_codigo_usuario = \Auth::user()->codigo_usuario; //evaluador
			$new_edicion->respuestas_evaluacion = json_encode($data);
			$new_edicion->pdf_evaluacion = $url_pdf;
			$new_edicion->codigo_registro_convocatoria = $register->codigo_registro_convocatoria;
			$new_edicion->save();
		}

    }
	/**
	 * Calcula el scoring por evaluación.
	 *
	 * @access private
	 * @static function
	 * @param mixed $register, $data, $user_project
	 * @return
	 */
	private static function getScoring($register, $data, $user_project, $id_eval_result)
	{
		$data_user = self::getUser($user_project->codigo_usuario);
		$full_name = $data_user->nombre_usuario . $data_user->primer_apellido_persona . $data_user->segundo_apellido_persona;
		$name_project = mb_convert_case($user_project->nombre_usuario, MB_CASE_TITLE, "UTF-8");
		$nit = $user_project->identificacion_usuario;
		$name_evaluation = self::getNameEvaluation((int) $data['codigo_evaluacion_emprendimiento']);
		$city = Ciudad::getCity($user_project->codigo_ciudad);
		$str_city = $city->nombre_ciudad . "-" . $city->distrito_ciudad . "-" . $city->codigo_pais;
		$full_city = mb_convert_case($str_city, MB_CASE_TITLE, "UTF-8");
		$web = $user_project->pagina_web_usuario;
		$project_description = $user_project->biografia_usuario;
		$date_init_project = $user_project->fecha_nacimiento_usuario;
		$emails_contacts = $data_user->correo_electronico . ", " .$user_project->correo_electronico;
		$data_entity = DatoEntidad::getDataEntity($user_project->codigo_usuario);
		$category_name = $data_entity->nombre_categoria_proyecto;
		$name_evaluator = Auth::user()->nombre_usuario . Auth::user()->primer_apellido_persona . Auth::user()->segundo_apellido_persona;
		$full_name_evaluator = mb_convert_case($name_evaluator, MB_CASE_TITLE, "UTF-8");
		$email_evaluator = Auth::user()->correo_electronico;
		$answers = self::calculateScoring($id_eval_result);
		$calculate = self::calculateTotal($answers, $data['codigo_evaluacion_emprendimiento']);
		$description_257 = self::getName_257($answers, $data['codigo_evaluacion_emprendimiento']);
		$description_263 = self::getName_263($answers, $data['codigo_evaluacion_emprendimiento']);

		//Preparando los datos que contendrá el pdf.
		$data_pdf = [];
		$data_pdf['_logo']            	  = RegistroSesion::getInstitutionImg();
		$data_pdf['_title_diagnosis'] 	  = $name_evaluation;
		$data_pdf['_id_eval_result']  	  = $id_eval_result;
		$data_pdf['_name_project']    	  = $name_project;
		$data_pdf['_nit']    		  	  = $nit;
		$data_pdf['_city']    		  	  = $full_city;
		$data_pdf['_web']    		  	  = $web;
		$data_pdf['_project_description'] = $project_description;
		$data_pdf['_date_init_project']   = $date_init_project;
		$data_pdf['_emails_contacts']     = $emails_contacts;
		$data_pdf['_category_name']       = $category_name;
		$data_pdf['_name_evaluator']      = $full_name_evaluator;
		$data_pdf['_email_evaluator']     = $email_evaluator;
		$data_pdf['_answers_eval']     	  = $answers;
		$data_pdf['_calculate']     	  = $calculate;
		$data_pdf['_description_257']     = $description_257;
		$data_pdf['_description_263']     = $description_263;

		//Prepara pdf.
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML(view('emails.diagnosis.rutanpdf.layout', $data_pdf));

		$s3 = AWS::createClient('s3');
		$bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');
		if(!$s3->doesBucketExist($bucket)) {
			$s3->createBucket(['Bucket' => $bucket]);
		}

		$file_name = sprintf('%s_%s_%s.pdf', 'diagnostico', 'rutan'.'_', date('YmdHms'));
		$key = sprintf('%s/%s/%s/%s', 'documents', 'diagnosticos', 'rutan', $file_name);

		$result = $s3->putObject([
			'Bucket' => $bucket,
			'Key'    => $key,
			'Body'   => $pdf->output(),
			'ACL'    => 'public-read'
		]);

		$url_pdf = $result['ObjectURL'];

		//Envía correo con diagnóstico adjunto .pdf al emprendedor.
		$data = [];
		$data['_inst']     		  = self::$id_institution;
		$data['_to']       		  = $data_user->correo_electronico;
		$data['_to_name']  		  = mb_convert_case($full_name, MB_CASE_TITLE, "UTF-8");
		$data['_subject']  		  = 'REPORTE ' . $name_evaluation;
		$data['_template'] 		  = 'emails.user.diagnosis';
		$data['_fileurl']  		  = $url_pdf;
		$data['_id_eval_result']  = $id_eval_result;
		SendEmail::notification($data);

		//Envía correo con diagnóstico adjunto .pdf al evaluador.
		$data = [];
		$data['_inst']     		  = self::$id_institution;
		$data['_to']       		  = Auth::user()->correo_electronico;
		$data['_to_name']  		  = $full_name_evaluator;
		$data['_subject']  		  = 'REPORTE ' . $name_evaluation;
		$data['_template'] 		  = 'emails.user.diagnosis';
		$data['_fileurl']  		  = $url_pdf;
		$data['_id_eval_result']  = $id_eval_result;
		SendEmail::notification($data);

		return $url_pdf;
	}
    /**
     * Obtiene el nombre de la evaluación.
     *
     * @access private
	 * @static function
     * @param int $id_evaluation
     * @return null|string
     */
	private static function getNameEvaluation(int $id_evaluation)
	{
		$id_evaluation = mb_strtoupper(trim($id_evaluation));

        $name_evaluation = [
            31 => 'DIAGNÓSTICO PREINCUBACIÓN',
            32 => 'DIAGNÓSTICO INCUBACIÓN',
            33 => 'DIAGNÓSTICO ACELERACIÓN',
            34 => 'DIAGNÓSTICO CONSOLIDACIÓN'
        ];

        if (array_key_exists($id_evaluation, $name_evaluation)) {
            return $name_evaluation[$id_evaluation];
        }

        return null;
	}
	/**
     * Obtiene puntaje para el diagnóstico.
	 *
     * @access private
	 * @static function
     * @param int $id_answer_evcode_evaluationaluation
     * @return object|boolean $answers|false
     */
    private static function calculateScoring($id_eval_result)
    {
        if ( !is_null($id_eval_result) ) {

            $query = ResultadoEvaluacionEmprendimiento::query();
            $query->select('resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion',
                'opc_eval_pregunta.nombre_opc_eval_pregunta as respuesta', 'grup_opc_eval_pregunta.nombre_grup_opc_eval_pregunta',
                'opc_eval_pregunta.valor_opc_eval_pregunta as puntaje', 'item_evaluacion_emprendimiento.codigo_item_evaluacion',
                'item_evaluacion_emprendimiento.codigo_grupo_item_eval',
                'item_evaluacion_emprendimiento.codigo_tipo_evaluacion_item',
                'resultado_evaluacion_emprendimiento.comentario_resultado_evaluacion as observacion',
				'evaluacion_item_emprendimiento.valores_evaluacion_item',
				'evaluacion_item_emprendimiento.puntajes_resul_eval_empren'
            );
            $query->leftJoin('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
            $query->leftJoin('core.item_evaluacion_emprendimiento', 'item_evaluacion_emprendimiento.codigo_item_evaluacion', '=', 'evaluacion_item_emprendimiento.codigo_item_evaluacion');
            $query->leftJoin('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
            $query->leftJoin('core.grup_opc_eval_pregunta', 'grup_opc_eval_pregunta.codigo_grup_opc_eval_pregunta', '=', 'item_evaluacion_emprendimiento.codigo_grup_opc_eval_pregunta');
            $query->where('resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion', $id_eval_result);
            $query->whereIn('item_evaluacion_emprendimiento.codigo_grupo_item_eval', self::$id_group);
            $query->orderBy('item_evaluacion_emprendimiento.codigo_item_evaluacion','ASC');
            $answers = $query->get();
            return $answers;
        } else {
            return false;
        }
	}
	/**
     * Obtiene total por evaluación.
	 *
     * @access private
	 * @static function
     * @param object $answers
     * @param int $id_evaluation
     * @return array $data
     */
    private static function calculateTotal($answers, $id_evaluation)
    {
		//Diagnóstico Preincubación.
		if ($id_evaluation == 31) {
			foreach ($answers as $answer => $value) {

				//Items de producto o servicio.
				if ($value['codigo_item_evaluacion'] == 342) {
					$score_item_342 = $value['puntaje'] * 0.5; // Peso del 50%.
				} elseif ($value['codigo_item_evaluacion'] == 343) {
					$score_item_343 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 344) {
					$score_item_344 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 345) {
					$score_item_345 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de comercial y de mercardo.
				elseif ($value['codigo_item_evaluacion'] == 351) {
					$score_item_351 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 354) {
					$score_item_354 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 357) {
					$score_item_357 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 358) {
					$score_item_358 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 363) {
					$score_item_363 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 364) {
					$score_item_364 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de financiero.
				elseif ($value['codigo_item_evaluacion'] == 365) {
					$score_item_365 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 366) {
					$score_item_366 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 367) {

					if (is_array(json_decode($value['puntajes_resul_eval_empren']))) {

						$score_item_367 = 0;

						foreach (json_decode($value['puntajes_resul_eval_empren']) as $_value) {
							$score_item_367 += $_value;
						}
						$score_item_367 = $score_item_367 * 0.2; //Peso del 20%.

					} else {
						$score_item_367 = json_decode($value['puntajes_resul_eval_empren']) * 0.2; //Peso del 20%.
					}

				}
				//Items de equipo de trabajo.
				elseif ($value['codigo_item_evaluacion'] == 368) {
					$score_item_368 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 371) {
					$score_item_370 = $value['puntaje'] * 0.10; //Peso del 10%.
				} elseif ($value['codigo_item_evaluacion'] == 372) {
					$score_item_372 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 373) {
					$score_item_372 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 374) {
					$score_item_374 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 375) {
					$score_item_375 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 376) {
					$score_item_376 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
			}
			//Producto o servicio.
			$data['score_group_65'] = $score_item_342 + $score_item_343 + $score_item_344 + $score_item_345;
			//Comercial y de mercardo.
			$data['score_group_66'] = $score_item_351 + $score_item_354 + $score_item_357 + $score_item_358 + $score_item_363 + $score_item_364;
			//Financiero.
			$data['score_group_67'] = $score_item_365 + $score_item_366 + $score_item_367;
			//Equipo de trabajo.
			$data['score_group_68'] = $score_item_368 + $score_item_370 + $score_item_372 + $score_item_374 + $score_item_375 + $score_item_376;
		}
		//Diagnóstico Incubación.
		elseif ($id_evaluation == 32) {
			foreach ($answers as $answer => $value) {

				//Items de producto o servicio.
				if ($value['codigo_item_evaluacion'] == 377) {
					$score_item_377 = $value['puntaje'] * 0.5; // Peso del 50%.
				} elseif ($value['codigo_item_evaluacion'] == 378) {
					$score_item_378 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 379) {
					$score_item_379 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 380) {
					$score_item_380 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de comercial y de mercardo.
				elseif ($value['codigo_item_evaluacion'] == 386) {
					$score_item_386 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 389) {
					$score_item_389 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 392) {
					$score_item_392 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 393) {
					$score_item_393 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 398) {
					$score_item_398 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 399) {
					$score_item_399 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de financiero.
				elseif ($value['codigo_item_evaluacion'] == 400) {
					$score_item_400 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 401) {
					$score_item_401	 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 402) {

					if (is_array(json_decode($value['puntajes_resul_eval_empren']))) {

						$score_item_402 = 0;

						foreach (json_decode($value['puntajes_resul_eval_empren']) as $_value) {
							$score_item_402 += $_value;
						}
						$score_item_402 = $score_item_402 * 0.2; //Peso del 20%.

					} else {
						$score_item_402 = json_decode($value['puntajes_resul_eval_empren']) * 0.2; //Peso del 20%.
					}

				}
				//Items de equipo de trabajo.
				elseif ($value['codigo_item_evaluacion'] == 403) {
					$score_item_403 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 406) {
					$score_item_406 = $value['puntaje'] * 0.10; //Peso del 10%.
				} elseif ($value['codigo_item_evaluacion'] == 407) {
					$score_item_407 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 408) {
					$score_item_408 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 409) {
					$score_item_409 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 410) {
					$score_item_410 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 411) {
					$score_item_411 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
			}
			//Producto o servicio.
			$data['score_group_65'] = $score_item_377 + $score_item_378 + $score_item_379 + $score_item_380;
			//Comercial y de mercardo.
			$data['score_group_66'] = $score_item_386 + $score_item_389 + $score_item_392 + $score_item_393 + $score_item_398 + $score_item_399;
			//Financiero.
			$data['score_group_67'] = $score_item_400 + $score_item_401 + $score_item_402;
			//Equipo de trabajo.
			$data['score_group_68'] = $score_item_403 + $score_item_406 + $score_item_407 + $score_item_408 + $score_item_409 + $score_item_410 +
									$score_item_411;
		}
		//Diagnóstico Aceleración.
		elseif ($id_evaluation == 33) {
			foreach ($answers as $answer => $value) {

				//Items de producto o servicio.
				if ($value['codigo_item_evaluacion'] == 412) {
					$score_item_412 = $value['puntaje'] * 0.5; // Peso del 50%.
				} elseif ($value['codigo_item_evaluacion'] == 413) {
					$score_item_413 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 414) {
					$score_item_414 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 415) {
					$score_item_415 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de comercial y de mercardo.
				elseif ($value['codigo_item_evaluacion'] == 421) {
					$score_item_421 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 424) {
					$score_item_424 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 427) {
					$score_item_427 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 428) {
					$score_item_428 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 433) {
					$score_item_433 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 434) {
					$score_item_434 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de financiero.
				elseif ($value['codigo_item_evaluacion'] == 435) {
					$score_item_435 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 436) {
					$score_item_436	 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 437) {

					if (is_array(json_decode($value['puntajes_resul_eval_empren']))) {

						$score_item_437 = 0;

						foreach (json_decode($value['puntajes_resul_eval_empren']) as $_value) {
							$score_item_437 += $_value;
						}
						$score_item_437 = $score_item_437 * 0.2; //Peso del 20%.

					} else {
						$score_item_437 = json_decode($value['puntajes_resul_eval_empren']) * 0.2; //Peso del 20%.
					}

				}
				//Items de equipo de trabajo.
				elseif ($value['codigo_item_evaluacion'] == 438) {
					$score_item_438 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 441) {
					$score_item_441 = $value['puntaje'] * 0.10; //Peso del 10%.
				} elseif ($value['codigo_item_evaluacion'] == 442) {
					$score_item_442 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 443) {
					$score_item_443 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 444) {
					$score_item_444 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 445) {
					$score_item_445 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 446) {
					$score_item_446 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
			}
			//Producto o servicio.
			$data['score_group_65'] = $score_item_412 + $score_item_413 + $score_item_414 + $score_item_415;
			//Comercial y de mercardo.
			$data['score_group_66'] = $score_item_421 + $score_item_424 + $score_item_427 + $score_item_428 + $score_item_433 + $score_item_434;
			//Financiero.
			$data['score_group_67'] = $score_item_435 + $score_item_436 + $score_item_437;
			//Equipo de trabajo.
			$data['score_group_68'] = $score_item_438 + $score_item_441 + $score_item_442 + $score_item_443 + $score_item_444 + $score_item_445 +
									$score_item_446;
		}
		//Diagnóstico Consolidación.
		elseif ($id_evaluation == 34) {
			foreach ($answers as $answer => $value) {

				//Items de producto o servicio.
				if ($value['codigo_item_evaluacion'] == 447) {
					$score_item_447 = $value['puntaje'] * 0.5; // Peso del 50%.
				} elseif ($value['codigo_item_evaluacion'] == 448) {
					$score_item_448 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 449) {
					$score_item_449 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 450) {
					$score_item_450 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de comercial y de mercardo.
				elseif ($value['codigo_item_evaluacion'] == 456) {
					$score_item_456 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 459) {
					$score_item_459 = $value['puntaje'] * 0.3; //Peso del 30%.
				} elseif ($value['codigo_item_evaluacion'] == 462) {
					$score_item_462 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 463) {
					$score_item_463 = $value['puntaje'] * 0.05; //Peso del 5%.
				} elseif ($value['codigo_item_evaluacion'] == 468) {
					$score_item_468 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 469) {
					$score_item_469 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
				//Items de financiero.
				elseif ($value['codigo_item_evaluacion'] == 470) {
					$score_item_470 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 471) {
					$score_item_471	 = $value['puntaje'] * 0.4; //Peso del 40%.
				} elseif ($value['codigo_item_evaluacion'] == 472) {

					if (is_array(json_decode($value['puntajes_resul_eval_empren']))) {

						$score_item_472 = 0;

						foreach (json_decode($value['puntajes_resul_eval_empren']) as $_value) {
							$score_item_472 += $_value;
						}
						$score_item_472 = $score_item_472 * 0.2; //Peso del 20%.

					} else {
						$score_item_472 = json_decode($value['puntajes_resul_eval_empren']) * 0.2; //Peso del 20%.
					}

				}
				//Items de equipo de trabajo.
				elseif ($value['codigo_item_evaluacion'] == 473) {
					$score_item_473 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 476) {
					$score_item_476 = $value['puntaje'] * 0.10; //Peso del 10%.
				} elseif ($value['codigo_item_evaluacion'] == 477) {
					$score_item_477 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 478) {
					$score_item_478 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 479) {
					$score_item_479 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 480) {
					$score_item_480 = $value['puntaje'] * 0.15; //Peso del 15%.
				} elseif ($value['codigo_item_evaluacion'] == 481) {
					$score_item_481 = $value['puntaje'] * 0.15; //Peso del 15%.
				}
			}
			//Producto o servicio.
			$data['score_group_65'] = $score_item_447 + $score_item_448 + $score_item_449 + $score_item_450;
			//Comercial y de mercardo.
			$data['score_group_66'] = $score_item_456 + $score_item_459 + $score_item_462 + $score_item_463 + $score_item_468 + $score_item_469;
			//Financiero.
			$data['score_group_67'] = $score_item_470 + $score_item_471 + $score_item_472;
			//Equipo de trabajo.
			$data['score_group_68'] = $score_item_473 + $score_item_476 + $score_item_477 + $score_item_478 + $score_item_479 + $score_item_480 +
									$score_item_481;
		}

		return $data;
	}
	/**
     * Obtiene nombres respuestas tipo checkbox evaluación emprendimiento de pregunta 263.
	 *
     * @access private
	 * @static function
     * @param object $answers
     * @param int $id_evaluation
     * @return string $answers
     */
    private static function getName_263($answers, $id_evaluation) //¿Cómo se encuentra la estructura financiera de la empresa/emprendimiento?.
    {
		Log::info('entro');
		//Diagnóstico Preincubación.
		if ($id_evaluation == 31 || $id_evaluation == 32 || $id_evaluation == 33 || $id_evaluation == 34 ) {

			$description = [];
			$_description_estructura = '';

			foreach ($answers as $answer => $value) {

				//Items de financiero.
				if ($value['codigo_item_evaluacion'] == 367 || $value['codigo_item_evaluacion'] == 402 ||
					$value['codigo_item_evaluacion'] == 437 || $value['codigo_item_evaluacion']== 472
				) {
					Log::info($value['codigo_item_evaluacion']);

					if (is_array(json_decode($value['valores_evaluacion_item']))) {
						foreach (json_decode($value['valores_evaluacion_item']) as $_value) {
							$query = OpcionEvaluacionPregunta::query();
							$query->select('nombre_opc_eval_pregunta');
							$query->where('codigo_opc_eval_pregunta',$_value);
							array_push($description, $query->first());
						}

						foreach ($description as $key => $value) {

							$_description_estructura .= "-" . $value['nombre_opc_eval_pregunta'];
						}


					} else {
						$query = OpcionEvaluacionPregunta::query();
						$query->select('nombre_opc_eval_pregunta');
						$query->where('codigo_opc_eval_pregunta',json_decode($value['valores_evaluacion_item']));
						$query = $query->first();
						$_description_estructura = $query->nombre_opc_eval_pregunta;
					}
				}
			}
			return $_description_estructura;

		}
	}
	/**
     * Obtiene nombres respuestas tipo checkbox evaluación emprendimiento de pregunta 257.
	 *
     * @access private
	 * @static function
     * @param object $answers
     * @param int $id_evaluation
     * @return string $answers
     */
    private static function getName_257($answers, $id_evaluation) //Barreras de mercado.
    {
		Log::info('entro');
		//Diagnóstico Preincubación.
		if ($id_evaluation == 31 || $id_evaluation == 32 || $id_evaluation == 33 || $id_evaluation == 34 ) {

			$description = [];
			$_description_barreras = '';

			foreach ($answers as $answer => $value) {

				//Items de financiero.
				if ($value['codigo_item_evaluacion'] == 361 || $value['codigo_item_evaluacion'] == 396 ||
					$value['codigo_item_evaluacion'] == 431 || $value['codigo_item_evaluacion']== 466)
				{
					Log::info($value['codigo_item_evaluacion']);

					if (is_array(json_decode($value['valores_evaluacion_item']))) {
						foreach (json_decode($value['valores_evaluacion_item']) as $_value) {
							$query = OpcionEvaluacionPregunta::query();
							$query->select('nombre_opc_eval_pregunta');
							$query->where('codigo_opc_eval_pregunta',$_value);
							array_push($description, $query->first());
						}

						foreach ($description as $key => $value) {

							$_description_barreras .= "-" . $value['nombre_opc_eval_pregunta'];
						}


					} else {
						$query = OpcionEvaluacionPregunta::query();
						$query->select('nombre_opc_eval_pregunta');
						$query->where('codigo_opc_eval_pregunta',json_decode($value['valores_evaluacion_item']));
						$query = $query->first();
						$_description_barreras = $query->nombre_opc_eval_pregunta;
					}
				}
			}
			return $_description_barreras;

		}
	}
}
