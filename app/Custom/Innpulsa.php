<?php

namespace Custom;

use Illuminate\Support\Collection;

use TuProyecto;

use Auth, Log, DB, URL, SendEmail, Lang, DateTime;

use App\Entidad, App\OrientacionConvocatoria, App\Ciudad, App\Usuario, App\Encuesta, App\SectorInteres, App\AgrupacionItemEval, App\RespuestaEncuesta, App\AgrupacionPreguntasEval, App\PreguntaEncuesta, App\OpcionPreguntaEncuesta, App\PuntajeRegistroFase, App\EvaluacionItemEmprendimiento, App\ItemEvaluacionEmprendimiento, App\Estado, App\RegistroFaseUsuario, App\GrupoItemEval, App\ResultadoEvaluacionEmprendimiento, App\AsignacionJurado, App\UsuarioEncuesta, App\RegistroConvocatoria, App\Fase, App\RegistroSesion, App\Compra, App\Producto, App\ClaseProducto, App\Institucion, App\TipoPago, App\DetalleCompra, App\DetalleVoucher;

class Innpulsa
{
    public static $challenge = 49;

    public static $program_challenge = 113;

	public static $stage_challenge = 134;

	public static $stage_challenge_1_2 = 150;

    public static $stage_challenge_3 = 138;

    public static $stage_challenge_2 = 137;

	public static $evaluation_challenge_2 = 10;

	public static $evaluation_challenge_1_2 = 9;

	public static $email_user_institution = 'ruben.gantiva@innpulsacolombia.com';

    public static $email_user_institution_linking = 'maria.soler@innpulsacolombia.com';

    public static $challenge_empodera = 92;

    public static $program_challenge_empodera = 198;

    public static $stage_challenge_empodera = 204;

    public static $stage_challenge_empodera_1_2 = 212;

    public static $stage_challenge_empodera_2 = 213;

	public static $evaluation_challenge_empodera_1_2 = 18;

	public static $program_challenge_empodera_2020 = 471;

	public static $challenge_empodera_2020 = 124;

	public static $challenge_innpulsa_20 = 126;

	public static $evaluaction_empodera_2020 = 20;

	public static $final_evaluation_empresarios = 113;

	public static $evaluation_aldea_20 = 22;

	public static $evaluation_aldea_20_moment_3 = 23;

	public static $evaluation_aldea_20_moment_4 = 24;

	public static $program_aldea_20 = 504;

	public static $program_nucleo = 164;

	public static $program_appsco = 245;

	public static function getRegion__Moment_Four__Aldea20($type) {
		switch($type) {
			case 'bajo':
				return 3;
			break;
			case 'medioBajo':
				return 2;
			break;
			case 'medio':
				return 1;
			break;
		}
	}

	/**
	 * Custom actions send mail challenge.
	 *
	 */
	public function notification($job, $parameters)
	{
   		try {
   			// Data User
   			$query = Usuario::query();
			$query->select('owner.nombre_usuario as nombre_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento');

			$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
			$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
			$query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');

			$query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
			$user = $query->first();

			// Mail notification
			$data = [];
			$data['_subject'] = trans('innpulsa.mail.subject');
			$data['_template'] = 'emails.custom.innpulsa.notification';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];
			$data['_nombre_convocatoria'] = $parameters['nombre_convocatoria'];

			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Innpulsa notification', $e->getMessage()));
		}
	}

	public function notificationEmpodera2020($job, $parameters)
	{
   		try {
   			// Data User
   			$query = Usuario::query();
			$query->select('owner.nombre_usuario as nombre_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento');

			$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
			$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
			$query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');

			$query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
			$user = $query->first();

			// Mail notification
			$data = [];
			$data['_subject'] = trans('innpulsa.mail.subject');
			$data['_template'] = 'emails.custom.empodera2020.notification';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];

			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Innpulsa notification', $e->getMessage()));
		}
	}

	public function notificationAldea20($job, $parameters)
	{
   		try {
   			// Data User
   			$query = Usuario::query();
			$query->select('owner.nombre_usuario as nombre_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento');

			$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
			$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
			$query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');

			$query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
			$user = $query->first();

			// Mail notification
			$data = [];
			$data['_subject'] = trans('innpulsa.mail.subject');
			$data['_template'] = 'emails.custom.innpulsa.aldea20';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];

			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Innpulsa notification', $e->getMessage()));
		}
	}

	public function notificationNucleo($job, $parameters)
	{
		$program_aplication_number = "";
        $program_aplication_date = "";
   		try {
            // Data User
            $query = Usuario::query();
            if($parameters['codigo_orientacion_convocatoria'] == OrientacionConvocatoria::getOrientation('entity')){
                $query->select('owner.nombre_usuario as nombre_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento');

                $query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
                $query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
                $query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
                $query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');
                $query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
            }else{
                $query->select('usuario.nombre_usuario as nombre_usuario', 'usuario.correo_electronico as correo_electronico');
                $query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
            }
            $user = $query->first();

            $program_register = RegistroConvocatoria::getUsersPrograms($parameters['codigo_convocatoria'], $parameters['codigo_usuario']);

            if($program_register instanceof RegistroConvocatoria){
                $program_aplication_number = $program_register->numero_registro_convocatoria;
                $program_aplication_date = $program_register->fecha_registro_convocatoria;
             	$nombre_aplicante = $program_register->nombre_usuario.' '.$program_register->primer_apellido_persona;
            }
			// Mail notification
			$data = [];
			$data['_subject'] = trans('innpulsa.mail.program');
			$data['_template'] = 'emails.custom.innpulsa.nucleo';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];
            $data['program_name'] = $parameters['nombre_convocatoria'];
            $data['program_aplication_number'] = $program_aplication_number;
            $data['program_aplication_date'] = $program_aplication_date;
			$data['nombre_aplicante'] = $nombre_aplicante;

			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Notification general', $e->getMessage()));
		}
	}


   	/**
	 * Custom valid create survey first challenge.
	 *
 	 * @var Array request $request
 	 * @var Encuesta $survey data
	 */
	public static function validFirstChallenge(UsuarioEncuesta $userSurvey, $request)
	{
		$response = new \stdClass();
		$response->success = true;

		// Get user entity
		$query = Usuario::query();
		$query->select('entidad.codigo_entidad', 'entidad.codigo_usuario', 'entidad.codigo_clase_empre_insti');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('usuario.codigo_usuario', $userSurvey->codigo_usuario);
		$user = $query->first();

		if(!$user instanceof Usuario) {
			$response->success = false;
			$response->data = trans('app.exception');
			return $response;
		}

		// Empresas Aldea
		if($user->codigo_clase_empre_insti == 2) {
			// Numero contacto
			if(isset($request['pregunta_1232']) && (trim($request['pregunta_1232']) == '' || trim($request['pregunta_1232']) == '____-__-__')) {
				$response->success = false;
				$response->data = "Por favor ingrese fecha de constitución legal de la Empresa (registro ante la Cámara de Comercio). ";
				return $response;
			}

			// Fecha registro empresa
			$error = "La fecha de constitución legal de la Empresa (registro ante la Cámara de Comercio) no puede ser mayor a %s. (Valor actual %s)";
			if(isset($request['pregunta_1232']) && ($request['pregunta_1232'] == '' || $request['pregunta_1232'] > date('Y-m-d'))) {
				$response->success = false;
				$response->data = sprintf($error, date('Y-m-d'), $request['pregunta_1232']);
				return $response;
			}
		}

		// Fecha inicio operacion
		$error = "La fecha en la que la empresa o negocio inició operaciones no puede ser mayor a %s. (Valor actual %s)";
		if(isset($request['pregunta_1231']) && ($request['pregunta_1231'] == '' || $request['pregunta_1231'] > date('Y-m-d'))) {
			$response->success = false;
			$response->data = sprintf($error, date('Y-m-d'), $request['pregunta_1231']);
			return $response;
		}

		// Numero contacto
		if(isset($request['pregunta_1225']) && ($request['pregunta_1225'] == '' || strlen(trim($request['pregunta_1225'])) != 10)) {
			$response->success = false;
			$response->data = "Por favor ingrese un número de teléfono de contacto válido, (Indicativo del país + Indicativo de la ciudad) + Número de teléfono.";
			return $response;
		}

		// Numero celular contacto
		if(isset($request['pregunta_1226']) && ($request['pregunta_1226'] == '' || strlen(trim($request['pregunta_1226'])) != 10)) {
			$response->success = false;
			$response->data = "Por favor ingrese un número celular de contacto válido, (Indicativo operador) + Número de celular.";
			return $response;
		}
		return $response;
	}

	/**
	 * Custom data report.
	 *
	 */
	public static function aldeaReport(Collection $answers, UsuarioEncuesta $userSurvey)
	{
        $report = new \stdClass();

        switch ($userSurvey->codigo_encuesta) {
			case self::$challenge:
				// Empresa
                $report->sector_interes = SectorInteres::getSectorByActivity($answers->where('question_id', 1234)->first()->answer)->nombre_sector_economico;

                // Diagnostico
                $report->data_admin_management = self::getResultScoreAdminManagement($answers, $userSurvey);
                $report->data_human_management = self::getResultScoreHumanManagement($answers, $userSurvey);
                $report->data_financial_management = self::getResultScoreFinancialManagement($answers, $userSurvey);
                $report->data_commercial_management = self::getResultScoreCommercialManagement($answers, $userSurvey);
                $report->data_production_management = self::getResultScoreProductionManagement($answers, $userSurvey);
                $report->data_general = self::getResultGeneral($answers, $userSurvey, $report);
                return $report;
            break;
            case self::$challenge_empodera:
                $report->sector_interes = SectorInteres::getSectorByActivity($answers->where('question_id', 2805)->first()->answer)->nombre_sector_economico;

                // Diagnostico
                $report->data_admin_management = self::getResultScoreAdminManagement($answers, $userSurvey);
                $report->data_human_management = self::getResultScoreHumanManagement($answers, $userSurvey);
                $report->data_financial_management = self::getResultScoreFinancialManagement($answers, $userSurvey);
                $report->data_commercial_management = self::getResultScoreCommercialManagement($answers, $userSurvey);
                $report->data_production_management = self::getResultScoreProductionManagement($answers, $userSurvey);
                $report->data_general = self::getResultGeneral($answers, $userSurvey, $report);
                return $report;
			break;
		}

		// Financiero
		// $report->cash_flow = self::getCashFlow($answers);
		// @$report->ebita_2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer;
		// @$report->ebita_2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer;

		// $report->interpretation_cash_flow = self::getInterpretationCashFlow($answers, $report->cash_flow);
		// $report->financial_reasons = self::getFinancialReasons($answers, $report->cash_flow);
		// $report->interpretation_financial_reasons = self::getInterpretationFinancialReasons($answers, $report->financial_reasons);

	}

	public static function getResultGeneral(Collection $answers, UsuarioEncuesta $userSurvey, $report)
	{
		$result = new \stdClass();
		$texto_respuesta = '';
        $texto_carta = '';

        switch ($userSurvey->codigo_encuesta) {
            case Innpulsa::$challenge:
                $general_program_challenge = self::$program_challenge;
                $general_stage_challenge = self::$stage_challenge;
                $general_stage_challenge_1_2 = self::$stage_challenge_1_2;

                $validacion_comercial_1 = 1256;
                $validacion_comercial_2 = 1667;

                $validacion_venta_1 = 1395;
                $validacion_venta_2 = 1851;
                $validacion_venta_3 = 1258;
                $validacion_venta_4 = 1259;
                $validacion_venta_5 = 1260;
            break;
            case Innpulsa::$challenge_empodera:
                $general_program_challenge = self::$program_challenge_empodera;
                $general_stage_challenge = self::$stage_challenge_empodera;
                $general_stage_challenge_1_2 = self::$stage_challenge_empodera_1_2;

                $validacion_comercial_1 = 2817;
                $validacion_comercial_2 = '';

                $validacion_venta_1 = 2878;
                $validacion_venta_2 = '';
                $validacion_venta_3 = 2875;
                $validacion_venta_4 = 2876;
                $validacion_venta_5 = 2877;
            break;
        }

		// Nombre usuario
		$query = Usuario::query();
		$query->select(DB::raw("initcap(owner.nombre_usuario) as nombre_usuario"), 'owner.correo_electronico as correo_electronico');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');
		$query->where('usuario.codigo_usuario', $userSurvey->codigo_usuario);
		$founder = $query->first();

		// Proxima aplicacion
		$query = RegistroFaseUsuario::query();
		$query->select('tiempo_espera_nueva_aplicacion', 'fecha_registro_convocatoria', DB::raw('COALESCE(registro_fase_usuario.rango_inferior_eval_fase, fase.rango_inferior_evaluacion) as rango_inferior_eval_fase'));
        $query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
		$query->join('core.convocatoria','registro_convocatoria.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('seguridad.usuario','registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.fase','registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
        $query->where('registro_convocatoria.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
        $query->where('registro_convocatoria.codigo_convocatoria', $general_program_challenge);
        $query->where('registro_fase_usuario.codigo_fase', $general_stage_challenge);
        $registered = $query->first();
        $proximo_registro = date('Y-m-d', strtotime("+$registered->tiempo_espera_nueva_aplicacion day", strtotime($registered->fecha_registro_convocatoria)));

		$carta = '
			<div class="inner-section-program-review text-justify">
				<div class="text-md lighter-text">
					<label class="label title text-md lighter-text">Estimado(a), <strong>%s</strong></label>

					<p class="lighter-text">Recibe un afectuoso saludo de <strong>iNNpulsa Colombia</strong>, la agencia del Gobierno Nacional que trabaja para forjar las empresas del futuro, empresas preparadas para asumir el reto de crecer colaborando y conectándose.</p>
					%s
				</div>
				<br />
				<ul class="list-detail-program-review no-bullet">
					<li>
						<div class="heavy-text dark-text text-md">ALDEA de iNNpulsa Colombia</div>
					</li>
				</ul>
			</div>
			%s';

		$recomendacion_a = "
			<p>Aunque nos dijiste que tu producto tiene validación comercial, no nos reportaste la información de ventas de tu negocio, por lo que no fue posible encontrar soporte a esa validación comercial.</p>
			<p>Te invitamos a seguir avanzando con tu iniciativa, es importante materializar la idea y no esperar a tener la versión final del producto (bien o servicio) para probarlo con posibles clientes, ellos pueden ser una fuente de mejora y representan el punto de partida de tu negocio.</p>
			<p>Cuando hayas validado comercialmente tu producto, puedes volver a presentarte.</p>";

		$recomendacion_b = "
			<p>Todavía estás en etapa de idea y no has validado comercialmente tu producto, por eso te invitamos a seguir avanzando con tu iniciativa, es importante materializar la idea y no esperar a tener la versión final del producto (bien o servicio) para probarlo con posibles clientes, ellos pueden ser una fuente de mejora y representan el punto de partida de tu negocio.</p>
			<p>Cuando tengas un producto (bien o servicio) desarrollado, con un diferencial para el mercado y lo hayas validado comercialmente, puedes volver a presentarte.</p>";

		$recomendacion_c = "
			<p>Te recomendamos fortalecer  el valor agregado que tu producto o servicio aporta a los clientes, para que puedas identificar cómo tu  producto resuelve la necesidad de tu cliente, qué beneficios debe esperar el cliente de tu producto y por qué te debe elegir a ti y no a tu competencia.</p>
			<p>Te invitamos a seguir adelante y a  incluir mejoras que le aporten un mayor valor a tu oferta y te diferencien de la competencia, y a su vez, te permitan tener una mejor percepción de tus clientes.</p>";

		// Scoring reto 1
		$scoring_1 = $userSurvey->puntaje_total_encuesta;

        // Scoring reto 1.2
        $query = RegistroFaseUsuario::query();
        $query->select(DB::raw('COALESCE(registro_fase_usuario.rango_inferior_eval_fase, fase.rango_inferior_evaluacion) as rango_inferior_eval_fase'), DB::raw('COALESCE(registro_fase_usuario.rango_superior_eval_fase, fase.rango_superior_evaluacion) as rango_superior_eval_fase'), 'puntaje_total_eval_emprendi');
        $query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
        $query->join('core.asignacion_jurado', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
        $query->join('core.resultado_evaluacion_emprendimiento', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.fase','registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
        $query->where('registro_convocatoria.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
        $query->where('registro_convocatoria.codigo_convocatoria', $general_program_challenge);
        $query->where('registro_fase_usuario.codigo_fase', $general_stage_challenge_1_2);
        $scoring_1_2 = $query->first();

        // Registe reto 1.2
        $query = RegistroFaseUsuario::query();
        $query->select('registro_fase_usuario.*');
        $query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
		$query->join('core.fase','registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
        $query->where('registro_convocatoria.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
        $query->where('registro_convocatoria.codigo_convocatoria', $general_program_challenge);
        $query->where('registro_fase_usuario.codigo_fase', $general_stage_challenge_1_2);
        $register_1_2 = $query->first();

        // Validaciones
		if( $scoring_1 <= $registered->rango_inferior_eval_fase || ($scoring_1_2 != null && ($scoring_1_2->puntaje_total_eval_emprendi < $scoring_1_2->rango_inferior_eval_fase || $scoring_1_2->puntaje_total_eval_emprendi > $scoring_1_2->rango_superior_eval_fase)) || ($register_1_2 instanceof RegistroFaseUsuario && $register_1_2->codigo_estado == Estado::getState('returned')) || (!$scoring_1_2 instanceof RegistroFaseUsuario))
		{
			// Carta no pasan
			$texto_carta = sprintf($carta, $founder->nombre_usuario, '
				<p class="lighter-text">En esta ocasión, el área emprendimiento de iNNpulsa Colombia te informa que <strong>no has sido seleccionado(a)</strong> para participar en el segundo reto "Conversa con expertos". Sin embargo, tienes en tus manos algunos consejos de acuerdo a las respuestas que nos diste en el primer reto "Conozcámonos", que esperamos sean de gran utilidad.</p>

				<p class="lighter-text">Que puedes hacer ahora:</p>

				<ul class="disc">
					<li>Seguir los consejos que te entrega ALDEA <span class="text-sm">(Ver sección Diagnóstico)</span>.</li>
					<li>Desarrollar los cursos virtuales de nuestros aliados y conocer la oferta pública de programas para el fomento empresarial <span class="text-sm">(Ver sección Oportunidades)</span>.</li>
					<li>Profundizar en las finanzas de tu negocio.</li>
				</ul>
				<br/>
				<p class="lighter-text">Gracias por mostrar interés en ser parte de ALDEA. ¡Recuerda que eres el motor de nuestra organización!</p>',

				'<hr class="no-margin">
				<div class="inner-section-program-review">
					<ul class="no-bullet text-md lighter-text">
						<li class="heavy-text dark-text">
							Solo podrás volver a aplicar a esta convocatoria desde el <span class="text-md lighter-text">'.$proximo_registro.'</span>.
						</li>
						<li>
							Para volver a aplicar a esta convocatoria <a href="'.route('convocatoria.convocatoria', ['convocatoria' => 'reto1-aldea-innpulsa']).'" target="_blank" title="Invitación para empresarios y emprendedores">haz clic aquí</a>.
						</li>
					</ul>
				</div>'
			);

			// Validacion comercial
			if($answers->where('question_id', $validacion_comercial_1)->first()->option_code_y == $validacion_comercial_2)
			{
				// Validacion con ventas
				$vcomencial = $answers->where('question_id', $validacion_venta_1)->first();
				if($vcomencial instanceof RespuestaEncuesta && $vcomencial->option_code_y == $validacion_venta_2)
				{
					$_1258 = $answers->where('question_id', $validacion_venta_3)->first();
					$_1259 = $answers->where('question_id', $validacion_venta_4)->first();
					$_1260 = $answers->where('question_id', $validacion_venta_5)->first();

					$ventas = 0;
					if($_1258 instanceof RespuestaEncuesta) $ventas += $_1258->answer;
					if($_1259 instanceof RespuestaEncuesta) $ventas += $_1259->answer;
					if($_1260 instanceof RespuestaEncuesta) $ventas += $_1260->answer;

					if($ventas <= 300000) {
						$texto_respuesta = $recomendacion_a;
					}else{
						$texto_respuesta = $recomendacion_c;
					}
				}else{
					$texto_respuesta = $recomendacion_c;
				}
			}else{
				$_1258 = $answers->where('question_id', $validacion_venta_1)->first();
				$_1259 = $answers->where('question_id', $validacion_venta_2)->first();
				$_1260 = $answers->where('question_id', $validacion_venta_3)->first();
				$ventas = 0;
				if($_1258 instanceof RespuestaEncuesta) $ventas += $_1258->answer;
				if($_1259 instanceof RespuestaEncuesta) $ventas += $_1259->answer;
				if($_1260 instanceof RespuestaEncuesta) $ventas += $_1260->answer;

				if($ventas <= 300000) {
					$texto_respuesta = $recomendacion_b;
				}else{
					$texto_respuesta = $recomendacion_c;
				}
			}
		}else{
			// Avanzan a segunda fase
			$texto_respuesta = '';
			$texto_carta = sprintf($carta, $founder->nombre_usuario, '
				<p class="lighter-text">El área de emprendimiento de iNNpulsa Colombia te informa que <strong>has sido seleccionado(a)</strong> para participar en el segundo reto "Conversemos con expertos". Tienes en tus manos algunos consejos de acuerdo a las respuestas que nos diste en el primer reto "Conozcámonos", que esperamos sean de gran utilidad.</p>

				<p class="lighter-text">Que puedes hacer ahora:</p>

				<ul class="disc">
					<li>Seguir los consejos que te entrega ALDEA <span class="text-sm">(Ver sección Diagnóstico)</span>.</li>
					<li>Desarrollar los cursos virtuales de nuestros aliados y conocer la oferta pública de programas para el fomento empresarial <span class="text-sm">(Ver sección Oportunidades)</span>.</li>
					<li>Profundizar en las finanzas de tu negocio.</li>
				</ul>
				<br/>
				<p class="lighter-text">En un plazo máximo de 60 días estaremos en contacto contigo para indicarte lugar, fecha y hora de tu cita para conversar con expertos, el segundo reto de Aldea, en el que tendrás la oportunidad de competir para ganarte una llave de acceso a servicios especializados.</p>',
				''
			);
		}

		$result->texto_carta = $texto_carta;
		$result->texto_respuesta = $texto_respuesta;
		$result->oportunidades = self::getOportunidades($answers, $report);
		return $result;
	}

	public static function getOportunidades(Collection $answers, $report)
	{
		$oportunidades = $cursos = [];

		$cursos['derechos_de_autor_y_emprendimiento_digital'] = ['url' => 'https://apps.co/cursos/propiedad-intelectual-derecho-de-autor-y-emprendim/', 'titulo' => 'Derechos de autor y emprendimiento digital', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/motivacion-emprendedores.jpg'];

		$cursos['pacto_de_socios'] = ['url' => 'https://apps.co/cursos/el-pacto-de-socios/', 'titulo' => 'Pacto de socios', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/plan-financiero-servicios.jpg'];

		// $cursos['introduccion_a_la_inversion_angel'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/introduccion-a-la-inversion-angel', 'titulo' => 'Introducción a la inversión Ángel', 'descripcion' => '', 'imagen' => 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/2016/05/rnai-vehiculos-Inversion-angel.png'];

		// $cursos['negociacion_con_inversionistas'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/negociacion-con-inversionistas', 'titulo' => 'Negociación con inversionistas', 'descripcion' => 'Fortalecer competencias en cuento a la negociación con inversionistas, mejora las habilidades para un proceso de negociación exitoso.', 'imagen' => 'http://static.tuproyecto.com/images/courses/negociacion-inversionistas.jpg'];

		// $cursos['planeacion_financiera_para_emprendedores'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/planeacion-financiera-emprendedores', 'titulo' => 'Planeación financiera para emprendedores', 'descripcion' => 'Fortalecer competencias en cuanto a la planeación financiera.', 'imagen' => 'http://static.tuproyecto.com/images/courses/planeacion-financiera.jpg'];

		// $cursos['persuasion_para_ser_mas_efectivo_en_tu_negocio'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/persuasion', 'titulo' => 'Persuasión para ser mas efectivo en tu negocio', 'descripcion' => 'Persuasión para ser mas efectivo en tu negocio al interactuar con clientes, inversionistas y colaboradores.', 'imagen' => 'http://static.tuproyecto.com/images/courses/persuasion.jpg'];

		// $cursos['marca_personal'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/marca-personal', 'titulo' => 'Marca personal', 'descripcion' => 'Fortalecer competencia respecto al uso de la marca para fortalecer las acciones de la empresa.', 'imagen' => 'http://static.tuproyecto.com/images/courses/marca-personal.jpg'];

		// $cursos['investigacion_de_mercados_para_emprendedores'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/investigacion-mercados-emprendedores', 'titulo' => 'Investigación de mercados para emprendedores', 'descripcion' => 'La investigación de mercados nos da la fuente principal de la información, para analizar la pertinencia y validez de los supuestos planteados en tu modelo de negocios.', 'imagen' => 'http://static.tuproyecto.com/images/courses/investigacion-mercado-emprende.jpg'];

		// $cursos['accion_comercial_y_la_venta_moderna'] = ['url' => 'http://aldeainnpulsa.com/aprende/cursos/emprendimiento/accion-comercia-venta-moderna', 'titulo' => 'Acción comercial y la venta moderna', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/e-comerce.jpg'];

		$cursos['how_to_build_a_startup'] = ['url' => 'https://classroom.udacity.com/courses/ep245/lessons/48743167/concepts/487500570923', 'titulo' => 'How to build a startup',  'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/canvas-model-1.jpg'];

		$cursos['app_marketing'] = ['url' => 'https://classroom.udacity.com/courses/ud719', 'titulo' => 'App Marketing', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/industry-1.jpg'];

		$cursos['monetize_your_android_app_with_ads'] = ['url' => 'https://classroom.udacity.com/courses/ud876-3/lessons/3987338872/concepts/58279000180923', 'titulo' => 'Monetize your android App with ads', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/e-comerce.jpg'];

		$cursos['get_your_startup_started'] = ['url' => 'https://classroom.udacity.com/courses/ud806/lessons/7585925729/concepts/77601697060923', 'titulo' => 'Get your startup started', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/comunicacion-escrita.jpg'];

		$cursos['generacion_de_idea_de_negocio'] = ['url' => 'http://www.unimooc.com/course/generacion-de-ideas-de-negocio/', 'titulo' => 'Generación de idea de negocio', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/investigacion-mercado-emprende.jpg'];

		$cursos['coaching_para_emprendedores'] = ['url' => 'http://www.cursopedia.com/Ficha-Curso-de-coaching-para-emprendedores', 'titulo' => 'Coaching para emprendedores', 'descripcion' => '', 'imagen' => 'http://static.tuproyecto.com/images/courses/plan-financiero-comerciales.jpg'];

		// Administrativo 0 - 8
		if($report->data_admin_management->total < 8)
		{
			$oportunidades[] = $cursos['derechos_de_autor_y_emprendimiento_digital'];
			$oportunidades[] = $cursos['pacto_de_socios'];
		}

		// Financiera 0 - 16

		// if($report->data_financial_management->total < 16)
		// {
		// 	$oportunidades[] = $cursos['introduccion_a_la_inversion_angel'];
		// 	$oportunidades[] = $cursos['negociacion_con_inversionistas'];
		// 	$oportunidades[] = $cursos['planeacion_financiera_para_emprendedores'];
		// }

		// Comercial 0 - 16
		// if($report->data_commercial_management->total < 16)
		// {
		// 	$oportunidades[] = $cursos['persuasion_para_ser_mas_efectivo_en_tu_negocio'];
		// 	$oportunidades[] = $cursos['marca_personal'];
		// 	$oportunidades[] = $cursos['investigacion_de_mercados_para_emprendedores'];
		// 	$oportunidades[] = $cursos['accion_comercial_y_la_venta_moderna'];
		// 	// $oportunidades[] = $cursos['app_marketing'];
		// 	// $oportunidades[] = $cursos['monetize_your_android_app_with_ads'];
		// }

		// Humano 0 - 16
		if($report->data_human_management->total < 16)
		{
			$oportunidades[] = $cursos['coaching_para_emprendedores'];
		}

		// $oportunidades[] = $cursos['get_your_startup_started'];
		$oportunidades[] = $cursos['generacion_de_idea_de_negocio'];
		$oportunidades[] = $cursos['how_to_build_a_startup'];
		return $oportunidades;
	}

	public static function getAverages($questions, $sector = null)
	{
		$query = RegistroFaseUsuario::query();

		$query->select(DB::raw('SUM(puntaje_opcion_encuesta) / 4 as promedio', 'registro_fase_usuario.codigo_usuario'));

		$query->join('core.respuesta_encuesta','registro_fase_usuario.codigo_usuario','=','respuesta_encuesta.codigo_usuario');
		$query->join('core.pregunta_encuesta','respuesta_encuesta.codigo_pregunta_encuesta','=','pregunta_encuesta.codigo_pregunta_encuesta');
     	$query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');

        $query->where('pregunta_encuesta.codigo_encuesta', '=', self::$challenge);
        $query->where('pregunta_encuesta.codigo_estado', '=', Estado::getState('active'));
        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
        $query->where('registro_fase_usuario.codigo_estado', Estado::getState('active'));
        $query->where('registro_fase_usuario.codigo_fase', self::$stage_challenge);
        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', $questions);

        if($sector != ''){
        	$query->whereIn('registro_fase_usuario.codigo_usuario', function($query) use ($sector)
		    {
		        $query->select(DB::raw(' codigo_usuario
			 		from "core"."respuesta_encuesta"
					left join "core"."sector_interes" on "respuesta_encuesta"."texto_respuesta_encuesta"::integer = "sector_interes"."codigo_sector_interes"
					where respuesta_encuesta.codigo_pregunta_encuesta = 1234
			 		and sector_interes.codigo_sector_economico = '.$sector.' '));
		    });
        }

        $query->groupBy('registro_fase_usuario.codigo_usuario');

        $average = DB::table( DB::raw("({$query->toSql()}) as query") )
		    ->mergeBindings($query->getQuery())
		    ->avg('promedio');

	    return round($average,1);
	}

	public static function getResultScoreAdminManagement(Collection $answers, UsuarioEncuesta $userSurvey)
	{
        switch ($userSurvey->codigo_encuesta) {
            case Innpulsa::$challenge:
                $general_1 = 1261;
                $general_2 = 1262;
                $general_3 = 1263;
                $general_4 = 1264;
                $average_general = [$general_1, $general_2, $general_3, $general_4];
                $answer_sector = 1234;
            break;
            case Innpulsa::$challenge_empodera:
                $general_1 = 2865;
                $general_2 = 2866;
                $general_3 = 2867;
                $general_4 = 2868;
                $average_general = [$general_1, $general_2, $general_3, $general_4];
                $answer_sector = 2805;
            break;
        }
		$result = new \stdClass();
		$score_admin_management = $answers->where('question_id', $general_1)->first()->score_option+$answers->where('question_id', $general_2)->first()->score_option+$answers->where('question_id', $general_3)->first()->score_option + $answers->where('question_id', $general_4)->first()->score_option;
		$texto_respuesta = "";

		// Average General
		$averageGeneral = Innpulsa::getAverages($average_general);

		// Answer Sector
		$sector = $answers->where('question_id', $answer_sector)->first();
		// Sector Economic
		$activityEconomic = SectorInteres::find($sector->answer)->first();

		if($activityEconomic instanceof SectorInteres){
			// Average Sector
			$averageEconomy = Innpulsa::getAverages($average_general, $activityEconomic->codigo_sector_economico);
		}

		if($score_admin_management<8){
			$texto_respuesta = "<p>Para el crecimiento de una compañía es muy importante definir un norte claro y una meta de hacia dónde quiere llevar su empresa, el cual debe ser comunicado e interiorizado por cada uno de los colaboradores de la compañía.</p><p>Estar en contacto con sus clientes permanentemente es primordial, para identificar que les “duele” y como el producto o servicio desarrollado por su empresa ayuda a resolver ese dolor,  preparare un discurso de su propuesta de valor, claro y contundente, que le permita explicarle a sus clientes por qué deben comprarle su producto o servicio y no el de la competencia. Fortalecer esta área de la compañía le permitirá aprovechar de mejor manera las oportunidades y amenazas que constantemente influirán en el desempeño de su compañía.</p>";
		}else if($score_admin_management<16){
			$texto_respuesta = "<p>Es importante revisar las metas de crecimiento de mediano plazo de su empresa, teniendo en cuenta  el diferencial, el potencial de mercado, y la retroalimentación que realizan los clientes de su producto o servicio.</p><p>Fortalecer constantemente esta área de la compañía le permitirá aprovechar de mejor manera las oportunidades y amenazas que constantemente influirán en el desempeño de su compañía.</p>";
		}else{
			$texto_respuesta = "<p>Su empresa tiene claramente definido el norte y las metas a alcanzar en el mediano plazo, es importante asegurarse que este norte y las metas sean conocidas y acogidas por cada uno de los colaboradores de su empresa, que cada uno de ellos se sienta identificado con la razón de ser de la compañía, y  que este sentido de pertenencia se trasmita a sus clientes y aliados.</p><p>Es primordial seguir fortaleciendo las relaciones con sus clientes, pues ellos son la fuente de potenciales mejoras a sus productos y servicios actuales, y junto con información del entorno ofrecerán insumos para desarrollar nuevos productos o servicios.</p>";
		}
		$result->texto_respuesta = $texto_respuesta;
		$result->total = $score_admin_management;
		$result->score = round($score_admin_management/4);
		$result->score_general = $averageGeneral;
		$result->score_economy = $averageEconomy;
		return $result;
	}

	public static function getResultScoreHumanManagement(Collection $answers, UsuarioEncuesta $userSurvey)
	{
        switch ($userSurvey->codigo_encuesta) {
            case Innpulsa::$challenge:
                $general_1 = 1265;
                $general_2 = 1266;
                $general_3 = 1267;
                $general_4 = 1268;
                $average_general = [1265, 1266, 1267, 1268];
                $answer_sector = 1234;
            break;
            case Innpulsa::$challenge_empodera:
                $general_1 = 2861;
                $general_2 = 2862;
                $general_3 = 2863;
                $general_4 = 2864;
                $average_general = [$general_1, $general_2, $general_3, $general_4];
                $answer_sector = 2805;
            break;
        }

		$result = new \stdClass();
		$score_human_management = $answers->where('question_id', $general_1)->first()->score_option+$answers->where('question_id', $general_2)->first()->score_option+$answers->where('question_id', $general_3)->first()->score_option+$answers->where('question_id', $general_4)->first()->score_option;

		$averageGeneral = Innpulsa::getAverages($average_general);

		// Answer Sector
		$sector = $answers->where('question_id', $answer_sector)->first();
		// Sector Economic
		$activityEconomic = SectorInteres::find($sector->answer)->first();

		if($activityEconomic instanceof SectorInteres){
			// Average Sector
			$averageEconomy = Innpulsa::getAverages($average_general, $activityEconomic->codigo_sector_economico);
		}

		$texto_respuesta = "";
		if($score_human_management<8){
			$texto_respuesta = "<p>La empresa cuenta con oportunidades de crecer y ser más competitiva en el mercado si empieza a innovar en su interior, estas innovaciones puede ser enfocadas en productos/servicios, procesos o modelo de negocio. Es importante que, en primera medida, la compañía establezca mecanismos para que los colaboradores planteen sus ideas; y procesos para evaluar, seleccionar y ejecutar las ideas con mayor potencial, y de esta manera comenzar a crear una cultura innovadora dentro la compañía.</p><p>Para esto es primordial ejecutar acciones encaminadas a fortalecer el desarrollo del capital humano de la empresa, en pro de un mayor sentido de pertenencia, una mayor motivación y un clima laboral óptimo para el libre desarrollo profesional.</p>";
		}else if($score_human_management<16){
			$texto_respuesta = "<p>La empresa cuenta con oportunidades de crecer y ser más competitiva en el mercado si fortalece la innovación en su interior, estas innovaciones puede ser enfocadas en productos, procesos o modelo de negocio. Es importante acelerar las acciones que están implementando para fortalecer el desarrollo del capital humano de la empresa, y hacer de las innovaciones una realidad en la compañía.</p>";
		}else{
			$texto_respuesta = "<p>La empresa ya implementa innovaciones al interior de la compañía, es recomendable que fortalezcan su articulación con el ecosistema de innovación y emprendimiento, y se apalanquen en instrumentos de fomento a la Ciencia, tecnología e innovación, lo cual les permitirá acelerar este proceso innovador y mantenerse a la vanguardia en su industria.</p>";
		}
		$result->texto_respuesta = $texto_respuesta;
		$result->total = $score_human_management;
		$result->score = round($score_human_management/4);
		$result->score_general = $averageGeneral;
		$result->score_economy = $averageEconomy;
		return $result;
	}

	public static function getResultScoreFinancialManagement(Collection $answers, UsuarioEncuesta $userSurvey)
	{
        switch ($userSurvey->codigo_encuesta) {
            case Innpulsa::$challenge:
                $general_1 = 1269;
                $general_2 = 1270;
                $general_3 = 1271;
                $general_4 = 1272;
                $average_general = [1269, 1270, 1271, 1272];
                $answer_sector = 1234;
            break;
            case Innpulsa::$challenge_empodera:
                $general_1 = 2840;
                $general_2 = 2841;
                $general_3 = 2842;
                $general_4 = 2843;
                $average_general = [$general_1, $general_2, $general_3, $general_4];
                $answer_sector = 2805;
            break;
        }
		$result = new \stdClass();
		@$score_financial_management = $answers->where('question_id', $general_1)->first()->score_option + $answers->where('question_id', $general_2)->first()->score_option + $answers->where('question_id', $general_3)->first()->score_option+$answers->where('question_id', $general_4)->first()->score_option;

		$averageGeneral = Innpulsa::getAverages($average_general);

		// Answer Sector
		$sector = $answers->where('question_id', $answer_sector)->first();
		// Sector Economic
		$activityEconomic = SectorInteres::find($sector->answer)->first();

		if($activityEconomic instanceof SectorInteres){
			// Average Sector
			$averageEconomy = Innpulsa::getAverages($average_general, $activityEconomic->codigo_sector_economico);
		}

		$texto_respuesta = "";
		if($score_financial_management<8){
			$texto_respuesta = "<p>Es primordial que siempre la compañía maneje cuentas separadas de las cuentas personales de sus dueños, pues esto le permite conocer,  analizar y tomar los correctivos necesarios para tener una buena salud financiera de la empresa.</p><p>Es importante implementar un mecanismo financiero en su empresa que le permita identificar de manera clara cuáles son sus ingresos, costos  y gastos,  para establecer si su negocio es rentable o no, es decir, saber si está perdiendo o ganando dinero.</p><p>Es recomendable construir estados financieros como balance, estado de resultados y flujo de caja, los cuales le permitirán organizar la información financiera de su empresa de manera periódica para tomar decisiones estratégicas e inteligentes que lo lleven al crecimiento económico de su empresa.</p>";
		}else if($score_financial_management<16){
			$texto_respuesta = "<p>La organización de la información financiera en una empresa es un factor determinante para el funcionamiento de la misma, llevar un control diario de los costos, gastos, ingresos  es imprescindible para estar al tanto de todas las transacciones y poder solventar de forma rápida los problemas de liquidez que puedan darse durante la operación de la empresa.</p><p>Es recomendable implementar al interior de su empresa procedimientos, normas o políticas para el manejo de las diferentes transacciones como: compras, ventas, entradas y salidas de caja, pagos, etc.; esto le permitirá mantener unificada la información.</p>";
		}else{
			$texto_respuesta = "<p>Su empresa cuenta con una organización financiera que le permite estar al tanto de las transacciones realizadas por su empresa, se recomienda hacer una revisión y comparación periódica de estos y utilizar y analizar  indicadores  que le permitan determinar el estado de su empresa en términos de crecimiento,  liquidez, eficiencia, desempeño, productividad, entre otros. Se recomienda hacer una revisión periódica de los indicadores financieros para medir la efectividad de sus acciones en el mercado y de su negocio en el tiempo.</p>";
		}
		$result->texto_respuesta = $texto_respuesta;
		$result->total = $score_financial_management;
		$result->score = round($score_financial_management/4);
		$result->score_general = $averageGeneral;
		$result->score_economy = $averageEconomy;
		return $result;
	}

	public static function getResultScoreCommercialManagement(Collection $answers, UsuarioEncuesta $userSurvey)
	{
        switch ($userSurvey->codigo_encuesta) {
            case Innpulsa::$challenge:
                $general_1 = 1273;
                $general_2 = 1274;
                $general_3 = 1275;
                $general_4 = 1276;
                $average_general = [1273, 1274, 1275, 1276];
                $answer_sector = 1234;
            break;
            case Innpulsa::$challenge_empodera:
                $general_1 = 2853;
                $general_2 = 2854;
                $general_3 = 2855;
                $general_4 = 2856;
                $average_general = [$general_1, $general_2, $general_3, $general_4];
                $answer_sector = 2805;
            break;
        }
		$result = new \stdClass();
		$score_comercial_management = $answers->where('question_id', $general_1)->first()->score_option + $answers->where('question_id', $general_2)->first()->score_option + $answers->where('question_id', $general_3)->first()->score_option + $answers->where('question_id', $general_4)->first()->score_option;

		$averageGeneral = Innpulsa::getAverages($average_general);

		// Answer Sector
		$sector = $answers->where('question_id', $answer_sector)->first();
		// Sector Economic
		$activityEconomic = SectorInteres::find($sector->answer)->first();

		if($activityEconomic instanceof SectorInteres){
			// Average Sector
			$averageEconomy = Innpulsa::getAverages($average_general, $activityEconomic->codigo_sector_economico);
		}

		$texto_respuesta = "";
		if($score_comercial_management<8){
			$texto_respuesta = "<p>Su empresa debe concentrar esfuerzos en definir e identificar con claridad a su cliente, sus necesidades, sus gustos y sus patrones de comportamiento, de manera que pueda garantizar que su oferta de productos y/o servicios es adecuada para su cliente objetivo. Una vez usted conoce a su cliente, es importante diseñar estrategias adecuadas para encontrar los canales para poder llegar a él y de ésta manera aumentar la probabilidad de incrementar  sus ventas.</p><p>Es importante  estar en constante contacto con su cliente validando que sus productos y/o servicios sean adecuados para él, pues es por éste que su compañía se mantiene en el mercado.</p>";
		}else if($score_comercial_management<16){
			$texto_respuesta = "<p>La empresa debe fortalecer su estrategia  para llegar a sus clientes, utilizando los canales óptimos y manteniendo un diferencial claro de sus productos y/o servicios frente a los de su competencia. Es importante  estar en constante contacto con su cliente validando que sus productos y/o servicios sean adecuados para él, pues es por éste que su compañía se mantiene en el mercado.</p>";
		}else{
			$texto_respuesta = "<p>Su empresa se encuentra en un nivel óptimo en el  área de mercadeo y ventas dado que tiene plenamente identificado a su cliente objetivo y su diferencial vs la competencia. No obstante, es importante que la empresa alimente el deseo de ser la número uno en el mercado que atiende, para lo cual se le recomienda que desarrolle plan de expansión de mercado, en dónde contemple nuevos nichos de mercado, posibilidades de internacionalización y su potencial de desarrollar nuevos productos y/o servicios.</p>";
		}
		$result->texto_respuesta = $texto_respuesta;
		$result->total = $score_comercial_management;
		$result->score = round($score_comercial_management/4);
		$result->score_general = $averageGeneral;
		$result->score_economy = $averageEconomy;
		return $result;
	}

	public static function getResultScoreProductionManagement(Collection $answers, UsuarioEncuesta $userSurvey)
	{
        switch ($userSurvey->codigo_encuesta) {
            case Innpulsa::$challenge:
                $general_1 = 1277;
                $general_2 = 1278;
                $general_3 = 1279;
                $general_4 = 1280;
                $average_general = [1277, 1278, 1279, 1280];
                $answer_sector = 1234;
            break;
            case Innpulsa::$challenge_empodera:
                $general_1 = 2857;
                $general_2 = 2858;
                $general_3 = 2859;
                $general_4 = 2860;
                $average_general = [$general_1, $general_2, $general_3, $general_4];
                $answer_sector = 2805;
            break;
        }
		$result = new \stdClass();
		$score_production_management = $answers->where('question_id', $general_1)->first()->score_option+$answers->where('question_id', $general_2)->first()->score_option+$answers->where('question_id', $general_3)->first()->score_option+$answers->where('question_id', $general_4)->first()->score_option;

		$averageGeneral = Innpulsa::getAverages($average_general);

		// Answer Sector
		$sector = $answers->where('question_id', $answer_sector)->first();
		// Sector Economic
		$activityEconomic = SectorInteres::find($sector->answer)->first();

		if($activityEconomic instanceof SectorInteres){
			// Average Sector
			$averageEconomy = Innpulsa::getAverages($average_general, $activityEconomic->codigo_sector_economico);
		}

		$texto_respuesta = "";
		if($score_production_management<8){
			$texto_respuesta = "<p>La empresa debe conocer en detalle cómo calcular los precios de venta de sus productos y servicios, partiendo del cálculo de los costos y gastos de producción como pueden ser las materias primas, mano de obra, infraestructura, entre otros; y la rentabilidad que esperan obtener, sin dejar de lado que esta información debe ser contrastada con los precios de mercado y de la competencia.</p><p>El ciclo productivo y la capacidad instalada de la compañía debe ser estimada adecuadamente por la empresa, pues esta información es útil para gestionar mejoras que le permitan capturar eficiencias de producción que redunden en una mayor productividad.</p>";
		}else if($score_production_management<16){
			$texto_respuesta = "<p>La empresa debe identificar oportunidades de mejora dentro de su proceso productivo que le permitan  ser más eficiente y alcanzar las metas futuras de la compañía,  partiendo del conocimiento de los precios de venta de sus productos y servicios, así como del cumplimiento de la normatividad vigente.</p>";
		}else{
			$texto_respuesta = "<p>Su empresa se encuentra en un nivel óptimo en el área de producción, puesto que tiene plenamente definido un proceso de cálculo de precio de venta de sus productos y servicios, determinada su capacidad instalada, y cumple con la normatividad vigente.</p><p>Es importante, gestionar una comunicación eficiente entre las áreas de mercadeo y la de producción para incorporar mejora a sus procesos de cara a la satisfacción de los clientes.</p>";
		}
		$result->texto_respuesta = $texto_respuesta;
		$result->total = $score_production_management;
		$result->score = round($score_production_management/4);
		$result->score_general = $averageGeneral;
		$result->score_economy = $averageEconomy;
		return $result;
	}

	public static function getCashFlow(Collection $answers)
	{
		$cash_flow = new \stdClass();

		@$disminucion_cartera2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1813)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1813)->first()->answer;
		@$disminucion_cartera2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1813)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1813)->first()->answer;

		@$disminucion_inventarios2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1814)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1814)->first()->answer;
		@$disminucion_inventarios2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1814)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1814)->first()->answer;

		@$disminucion_otros_activos_corrientes2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1815)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1815)->first()->answer;
		@$disminucion_otros_activos_corrientes2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1815)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1815)->first()->answer;

		@$disminucion_proveedores2014 = $answers->where('question_id', 1391)->where('option_code_x', 1833)->where('option_code_y', 1828)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1828)->first()->answer;
		@$disminucion_proveedores2015 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1828)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1828)->first()->answer;

		@$disminucion_otros_pasivos_corrientes2014 = $answers->where('question_id', 1391)->where('option_code_x', 1833)->where('option_code_y', 1830)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1830)->first()->answer;
		@$disminucion_otros_pasivos_corrientes2015 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1830)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1830)->first()->answer;

		$inversion_capital_trabajo2014 = $disminucion_cartera2014 + $disminucion_inventarios2014 + $disminucion_otros_activos_corrientes2014 + $disminucion_proveedores2014 + $disminucion_otros_pasivos_corrientes2014;
		$inversion_capital_trabajo2015 = $disminucion_cartera2015 + $disminucion_inventarios2015 + $disminucion_otros_activos_corrientes2015 + $disminucion_proveedores2015 + $disminucion_otros_pasivos_corrientes2015;

		@$impuestos2014 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1829)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1833)->where('option_code_y', 1829)->first()->answer - $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1855)->first()->answer;
		@$impuestos2015 = $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1829)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1829)->first()->answer - $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1855)->first()->answer;

		@$efectivo_neto_operacional2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer + $inversion_capital_trabajo2014 + $impuestos2014;
		@$efectivo_neto_operacional2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer + $inversion_capital_trabajo2015 + $impuestos2015;

		@$ventas_activos_fijos_2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1820)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1820)->first()->answer;
		@$ventas_activos_fijos_2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1820)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1820)->first()->answer;

		@$disminuciones_inversiones_permanentes2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1819)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1819)->first()->answer;
		@$disminuciones_inversiones_permanentes2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1819)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1819)->first()->answer;

		@$disminuciones_activos_diferidos2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1817)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1817)->first()->answer;
		@$disminuciones_activos_diferidos2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1817)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1817)->first()->answer;

		$efectivo_neto_actividdes_inversion2014 = $ventas_activos_fijos_2014+$disminuciones_inversiones_permanentes2014+$disminuciones_activos_diferidos2014;
		$efectivo_neto_actividdes_inversion2015 = $ventas_activos_fijos_2015+$disminuciones_inversiones_permanentes2015+$disminuciones_activos_diferidos2015;

		$flujo_caja_libre2014 = $efectivo_neto_operacional2014 + $efectivo_neto_actividdes_inversion2014;
		$flujo_caja_libre2015 = $efectivo_neto_operacional2015 + $efectivo_neto_actividdes_inversion2015;

		@$gastos_financieros2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer * -1;
		@$gastos_financieros2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer * -1;

		@$amortizacion_bancos_bonos_cp2014 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1827)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1833)->where('option_code_y', 1827)->first()->answer;
		@$amortizacion_bancos_bonos_cp2015 = $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1827)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1827)->first()->answer;

		@$amortizacion_bancos_bonos_lp2014 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1831)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1833)->where('option_code_y', 1831)->first()->answer;
		@$amortizacion_bancos_bonos_lp2015 = $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1831)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1831)->first()->answer;

		$efectivo_neto_actividades_financiacion2014 = $gastos_financieros2014 + $amortizacion_bancos_bonos_cp2014 + $amortizacion_bancos_bonos_lp2014;
		$efectivo_neto_actividades_financiacion2015 = $gastos_financieros2015 + $amortizacion_bancos_bonos_cp2015 + $amortizacion_bancos_bonos_lp2015;

		$flujo_caja_libre_despues_financiacion2014 = $flujo_caja_libre2014 + $efectivo_neto_actividades_financiacion2014;
		$flujo_caja_libre_despues_financiacion2015 = $flujo_caja_libre2015 + $efectivo_neto_actividades_financiacion2015;

		$cash_flow->disminucion_cartera2014 = $disminucion_cartera2014;
		$cash_flow->disminucion_cartera2015 = $disminucion_cartera2015;
		$cash_flow->disminucion_inventarios2014 = $disminucion_inventarios2014;
		$cash_flow->disminucion_inventarios2015 = $disminucion_inventarios2015;
		$cash_flow->disminucion_otros_activos_corrientes2014 = $disminucion_otros_activos_corrientes2014;
		$cash_flow->disminucion_otros_activos_corrientes2015 = $disminucion_otros_activos_corrientes2015;
		$cash_flow->disminucion_proveedores2014 = $disminucion_proveedores2014;
		$cash_flow->disminucion_proveedores2015 = $disminucion_proveedores2015;
		$cash_flow->disminucion_otros_pasivos_corrientes2014 = $disminucion_otros_pasivos_corrientes2014;
		$cash_flow->disminucion_otros_pasivos_corrientes2015 = $disminucion_otros_pasivos_corrientes2015;
		$cash_flow->inversion_capital_trabajo2014 = $inversion_capital_trabajo2014;
		$cash_flow->inversion_capital_trabajo2015 = $inversion_capital_trabajo2015;
		$cash_flow->impuestos2014 = $impuestos2014;
		$cash_flow->impuestos2015 = $impuestos2015;
		$cash_flow->efectivo_neto_operacional2014 = $efectivo_neto_operacional2014;
		$cash_flow->efectivo_neto_operacional2015 = $efectivo_neto_operacional2015;
		$cash_flow->ventas_activos_fijos_2014 = $ventas_activos_fijos_2014;
		$cash_flow->ventas_activos_fijos_2015 = $ventas_activos_fijos_2015;
		$cash_flow->disminuciones_inversiones_permanentes2014 = $disminuciones_inversiones_permanentes2014;
		$cash_flow->disminuciones_inversiones_permanentes2015 = $disminuciones_inversiones_permanentes2015;
		$cash_flow->disminuciones_activos_diferidos2014 = $disminuciones_activos_diferidos2014;
		$cash_flow->disminuciones_activos_diferidos2015 = $disminuciones_activos_diferidos2015;
		$cash_flow->efectivo_neto_actividdes_inversion2014 = $efectivo_neto_actividdes_inversion2014;
		$cash_flow->efectivo_neto_actividdes_inversion2015 = $efectivo_neto_actividdes_inversion2015;
		$cash_flow->flujo_caja_libre2014 = $flujo_caja_libre2014;
		$cash_flow->flujo_caja_libre2015 = $flujo_caja_libre2015;
		$cash_flow->gastos_financieros2014 = $gastos_financieros2014;
		$cash_flow->gastos_financieros2015 = $gastos_financieros2015;
		$cash_flow->amortizacion_bancos_bonos_cp2014 = $amortizacion_bancos_bonos_cp2014;
		$cash_flow->amortizacion_bancos_bonos_cp2015 = $amortizacion_bancos_bonos_cp2015;
		$cash_flow->amortizacion_bancos_bonos_lp2014 = $amortizacion_bancos_bonos_lp2014;
		$cash_flow->amortizacion_bancos_bonos_lp2015 = $amortizacion_bancos_bonos_lp2015;
		$cash_flow->efectivo_neto_actividades_financiacion2014 = $efectivo_neto_actividades_financiacion2014;
		$cash_flow->efectivo_neto_actividades_financiacion2015 = $efectivo_neto_actividades_financiacion2015;
		$cash_flow->flujo_caja_libre_despues_financiacion2014 = $flujo_caja_libre_despues_financiacion2014;
		$cash_flow->flujo_caja_libre_despues_financiacion2015 = $flujo_caja_libre_despues_financiacion2015;

		@$ingresos_financieros2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1848)->first()->answer;
		@$ingresos_financieros2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1848)->first()->answer;

		@$otros_neto_no_operacional2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1850)->first()->answer;
		@$otros_neto_no_operacional2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1850)->first()->answer;

		@$aumento_disminucion_otros_activos2014 = ($answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1816)->first()->answer + $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1818)->first()->answer) - ($answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1816)->first()->answer + $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1818)->first()->answer);
		@$aumento_disminucion_otros_activos2015 = ($answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1816)->first()->answer + $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1818)->first()->answer) - ($answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1816)->first()->answer + $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1818)->first()->answer);

		@$aumento_disminucion_otros_pasivos2014 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1832)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1833)->where('option_code_y', 1832)->first()->answer;
		@$aumento_disminucion_otros_pasivos2015 = $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1832)->first()->answer - $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1832)->first()->answer;

		@$capital_social2014 = $answers->where('question_id', 1392)->where('option_code_x', 1840)->where('option_code_y', 1836)->first()->answer - $answers->where('question_id', 1392)->where('option_code_x', 1839)->where('option_code_y', 1836)->first()->answer;
		@$capital_social2015 = $answers->where('question_id', 1392)->where('option_code_x', 1841)->where('option_code_y', 1836)->first()->answer - $answers->where('question_id', 1392)->where('option_code_x', 1840)->where('option_code_y', 1836)->first()->answer;

		@$aumento_disminucion_patrimonio_accionistas2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1846)->first()->answer + $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1847)->first()->answer + $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1819)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1819)->first()->answer + $disminuciones_inversiones_permanentes2014 + $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1919)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1919)->first()->answer + $ventas_activos_fijos_2014 + $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1823)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1823)->first()->answer + $answers->where('question_id', 1392)->where('option_code_x', 1839)->where('option_code_y', 1928)->first()->answer - $answers->where('question_id', 1392)->where('option_code_x', 1840)->where('option_code_y', 1928)->first()->answer + $capital_social2014 + $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1937)->first()->answer;

		@$aumento_disminucion_patrimonio_accionistas2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1846)->first()->answer + $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1847)->first()->answer + $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1819)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1819)->first()->answer + $disminuciones_inversiones_permanentes2015 + $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1919)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1919)->first()->answer + $ventas_activos_fijos_2015 + $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1823)->first()->answer - $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1823)->first()->answer + $answers->where('question_id', 1392)->where('option_code_x', 1840)->where('option_code_y', 1928)->first()->answer - $answers->where('question_id', 1392)->where('option_code_x', 1841)->where('option_code_y', 1928)->first()->answer + $capital_social2015 + $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1937)->first()->answer;

		$efectivo_neto_otros2014 = $ingresos_financieros2014 + $otros_neto_no_operacional2014 + $aumento_disminucion_otros_activos2014 + $aumento_disminucion_otros_pasivos2014 + $capital_social2014 + $aumento_disminucion_patrimonio_accionistas2014;
		$efectivo_neto_otros2015 = $ingresos_financieros2015 + $otros_neto_no_operacional2015 + $aumento_disminucion_otros_activos2015 + $aumento_disminucion_otros_pasivos2015 + $capital_social2015 + $aumento_disminucion_patrimonio_accionistas2015;

		$flujo_caja_neto_2014 = $flujo_caja_libre_despues_financiacion2014 + $efectivo_neto_otros2014;
		$flujo_caja_neto_2015 = $flujo_caja_libre_despues_financiacion2015 + $efectivo_neto_otros2015;

		@$saldo_inicial_disponible_inv_termporales2014 = $answers->where('question_id', 1390)->where('option_code_x', 1824)->where('option_code_y', 1812)->first()->answer;
		@$saldo_inicial_disponible_inv_termporales2015 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1812)->first()->answer;
		@$saldo_final_disponible_inv_termporales2014 = $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1812)->first()->answer;
		@$saldo_final_disponible_inv_termporales2015 = $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1812)->first()->answer;

		$aumento_disminucion_disponibles_2014 = $saldo_inicial_disponible_inv_termporales2014 + $saldo_final_disponible_inv_termporales2014;
		$aumento_disminucion_disponibles_2015 = $saldo_inicial_disponible_inv_termporales2015 + $saldo_final_disponible_inv_termporales2015;

		$cash_flow->ingresos_financieros2014 = $ingresos_financieros2014;
		$cash_flow->ingresos_financieros2015 = $ingresos_financieros2015;

		$cash_flow->otros_neto_no_operacional2014 = $otros_neto_no_operacional2014;
		$cash_flow->otros_neto_no_operacional2015 = $otros_neto_no_operacional2015;

		$cash_flow->aumento_disminucion_otros_activos2014 = $aumento_disminucion_otros_activos2014;
		$cash_flow->aumento_disminucion_otros_activos2015 = $aumento_disminucion_otros_activos2015;

		$cash_flow->aumento_disminucion_otros_pasivos2014 = $aumento_disminucion_otros_pasivos2014;
		$cash_flow->aumento_disminucion_otros_pasivos2015 = $aumento_disminucion_otros_pasivos2015;

		$cash_flow->capital_social2014 = $capital_social2014;
		$cash_flow->capital_social2015 = $capital_social2015;

		$cash_flow->aumento_disminucion_patrimonio_accionistas2014 = $aumento_disminucion_patrimonio_accionistas2014;
		$cash_flow->aumento_disminucion_patrimonio_accionistas2015 = $aumento_disminucion_patrimonio_accionistas2015;

		$cash_flow->efectivo_neto_otros2014 = $efectivo_neto_otros2014;
		$cash_flow->efectivo_neto_otros2015 = $efectivo_neto_otros2015;

		$cash_flow->flujo_caja_neto_2014 = $flujo_caja_neto_2014;
		$cash_flow->flujo_caja_neto_2015 = $flujo_caja_neto_2015;

		$cash_flow->saldo_inicial_disponible_inv_termporales2014 = $saldo_inicial_disponible_inv_termporales2014;
		$cash_flow->saldo_inicial_disponible_inv_termporales2015 = $saldo_inicial_disponible_inv_termporales2015;

		$cash_flow->saldo_final_disponible_inv_termporales2014 = $saldo_final_disponible_inv_termporales2014;
		$cash_flow->saldo_final_disponible_inv_termporales2015 = $saldo_final_disponible_inv_termporales2015;

		$cash_flow->aumento_disminucion_disponibles_2014 = $aumento_disminucion_disponibles_2014;
		$cash_flow->aumento_disminucion_disponibles_2015 = $aumento_disminucion_disponibles_2015;

		return $cash_flow;
	}

	public static function getInterpretationCashFlow(Collection $answers, $cash_flow){

		$date = "diciembre de 2015";
		@$ebitda_2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer;
		$efectivo_neto_operacional_2015 = $cash_flow->efectivo_neto_operacional2015;
		$efectivo_neto_actividades_inversion_2015 = $cash_flow->efectivo_neto_actividdes_inversion2015;
		$flujo_caja_libre_2015 = $cash_flow->flujo_caja_libre2015;
		$efectivo_neto_Actividades_financiacion_2015 = $cash_flow->efectivo_neto_actividades_financiacion2015;
		$caja_libre_despues_financiacion_2015 = $cash_flow->flujo_caja_libre_despues_financiacion2015;
		$efectivo_neto_otros_2015 = $cash_flow->efectivo_neto_otros2015;
		$flujo_caja_neto_2015 = $cash_flow->flujo_caja_neto_2015;

		$interpretation_cash_flow = new \stdClass();

		$interpretation_cash_flow->definition_ebitda = "El EBITDA (por sus siglas en ingles, se traduce como Utilidades antes de intereses, impuestos, depreciación y amortización) es un indicador del desempeño financiero de la empresa y se utiliza para medir el potencial de ingresos del negocio. Generalmente se utiliza para analizar la rentabilidad de una empresa, y compararla frente a otras y a la industria.";
		$interpretation_cash_flow->interpretation_ebitda = "Para ".$date." la empresa generó un EBITDA de $ ".number_format($ebitda_2015,2,'.',',').", es decir que, después de restarle a las ventas / ingresos de la empresa los costos y gastos de operación, y sin tener en cuenta los gastos que no implican salida de efectivo  como son las depreciaciones y amortizaciones, la empresa cuenta con $ ".number_format($ebitda_2015,2,'.',',')." para atender los requerimientos de efectivo del negocio.";
		$interpretation_cash_flow->plan_ebitda = "ESTRATÉGICO";


		$interpretation_cash_flow->definition_efectivo_neto_operacional = "El efectivo neto operacional, está relacionado con la adquisición, gestión y disposición de activos de corto plazo (inferiores a un año). Muestra cómo, operativamente, se esta gestionando la compañía.";
		$interpretation_cash_flow->interpretation_efectivo_neto_operacional = "Luego de descontar los requerimientos operativos del negocio la empresa cuenta en ".$date." con $ ".number_format($efectivo_neto_operacional_2015,2,'.',',').", para atender los requerimientos de efectivo para activos de largo plazo y atención de actividades de financiación.";
		$interpretation_cash_flow->plan_efectivo_neto_operacional = "TÁCTICO";

		$interpretation_cash_flow->definition_efectivo_actividades_inversion = "El flujo de efectivo en actividades de inversión, está relacionado con la adquisición y disposición de activos a largo plazo, no relacionadas con el equivalente a efectivo";
		if($efectivo_neto_actividades_inversion_2015>0){
			$interpretation_cash_flow->interpretation_efectivo_actividades_inversion = "Para ".$date." hubo una aumento en los activos  por un valor de $ ".number_format($efectivo_neto_actividades_inversion_2015,2,'.',',').", catalogados como inversión a largo plazo.";
		}else{
			$interpretation_cash_flow->interpretation_efectivo_actividades_inversion = "Para ".$date." hubo una disminución en los activos  por un valor de $ ".number_format($efectivo_neto_actividades_inversion_2015,2,'.',',').", catalogados como inversión a largo plazo.";
		}
		$interpretation_cash_flow->plan_efectivo_actividades_inversion = "ESTRATÉGICO";

		$interpretation_cash_flow->definition_flujo_caja_libre = "El flujo de caja libre es un indicador que muestra la cantidad de dinero disponible que tiene la empresa  para pagar los accionistas y para cubrir el servicio de deuda";
		if($flujo_caja_libre_2015>0){
			$interpretation_cash_flow->interpretation_flujo_caja_libre = "Para ".$date." se tuvo un monto de $ ".number_format($flujo_caja_libre_2015,2,'.',',')." para atender la deuda y pagar a los accionistas.";
		}else{
			$interpretation_cash_flow->interpretation_flujo_caja_libre = "Para ".$date." se tuvo un monto de $ ".number_format($flujo_caja_libre_2015,2,'.',',')." para atender la deuda y pagar a los accionistas.";
		}
		$interpretation_cash_flow->plan_flujo_caja_libre = "ESTRATÉGICO";


		$interpretation_cash_flow->definition_efectivo_actividades_financiacion = "El flujo de efectivo en actividades de financiación está relacionado con el endeudamiento financiero de la empresa.";
		if($efectivo_neto_Actividades_financiacion_2015>0){
			$interpretation_cash_flow->interpretation_efectivo_actividades_financiacion = "Para ".$date." se requirío un monto de $ ".number_format($efectivo_neto_Actividades_financiacion_2015,2,'.',',')." para atender la deuda y pagar a los accionistas";
		}else{
			$interpretation_cash_flow->interpretation_efectivo_actividades_financiacion = "Para ".$date." no se requirió apalancar la operación con fuentes externas";
		}

		$interpretation_cash_flow->plan_efectivo_actividades_financiacion = "TÁCTICO";


		$interpretation_cash_flow->definition_caja_libre_despues_financiacion = "El flujo de caja libre despues de financiación muestra de manera clara la cantidad de efectivo que posee la empresa, incluyendo el que proviene de fuentes externas, es un índice que sirve para medir la liquidez de la empresa ";
		$interpretation_cash_flow->interpretation_caja_libre_despues_financiacion = "Para ".$date." el monto disponible es de $ ".number_format($caja_libre_despues_financiacion_2015,2,'.',',');
		$interpretation_cash_flow->plan_caja_libre_despues_financiacion = "TÁCTICO";


		$interpretation_cash_flow->definition_efectivo_neto_otros = "El efectivo neto en otros, refleja el ingreso o salida de efectivo por el comportamiento de otras cuentas no corrientes del activo, pasivo o patrimonio de la empresa, adicionando los ingresos financieros. ";
		$interpretation_cash_flow->interpretation_efectivo_neto_otros = "Los requerimientos no operativos de la empresa a ".$date." son $ ".number_format($efectivo_neto_otros_2015,2,'.',',');
		$interpretation_cash_flow->plan_efectivo_neto_otros = "TÁCTICO";


		$interpretation_cash_flow->definition_flujo_caja_neto = "Flujo de caja neto es el efectivo disponible después de atender deuda y requerimientos operativos";
		$interpretation_cash_flow->interpretation_flujo_caja_neto = "Para ".$date." generó disponibilidad de recursos por un monto de $ ".number_format($flujo_caja_neto_2015,2,'.',',');
		$interpretation_cash_flow->plan_flujo_caja_neto = "ESTRATÉGICO";

		return $interpretation_cash_flow;
	}

	public static function getFinancialReasons(Collection $answers, $cash_flow)
	{
		$financial_reasons = new \stdClass();
		@$evolucion_ventas2014 = ($answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1856)->where('option_code_y', 1842)->first()->answer) - 1;

		@$evolucion_ventas2015 = ($answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer) - 1;

		@$evolucion_ebitda2014 = ($answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1856)->where('option_code_y', 1934)->first()->answer) - 1;

		@$evolucion_ebitda2015 = ($answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer) - 1;

		$capex_ventas2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer == 0){
			$capex_ventas2014 = 0;
		}else{
			@$capex_ventas2014 = (-1*$cash_flow->ventas_activos_fijos_2014)/$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer;
		}

		$capex_ventas2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer == 0){
			$capex_ventas2015 = 0;
		}else{
			@$capex_ventas2015 = (-1*$cash_flow->ventas_activos_fijos_2015)/$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer;
		}

		$roa2014 = 0;
		if(@$answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1921)->first()->answer == 0){
			$roa2014 = 0;
		}else{
			@$roa2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1937)->first()->answer / $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1921)->first()->answer;
		}

		$roa2015 = 0;
		if(@$answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1921)->first()->answer == 0){
			$roa2015 = 0;
		}else{
			@$roa2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1937)->first()->answer / $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1921)->first()->answer;
		}

		$roe2014 = 0;
		if(@$answers->where('question_id', 1392)->where('option_code_x', 1840)->where('option_code_y', 1928)->first()->answer == 0){
			$roe2014 = 0;
		}else{
			@$roe2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1937)->first()->answer / $answers->where('question_id', 1392)->where('option_code_x', 1840)->where('option_code_y', 1928)->first()->answer;
		}

		$roe2015 = 0;
		if(@$answers->where('question_id', 1392)->where('option_code_x', 1841)->where('option_code_y', 1928)->first()->answer == 0){
			$roe2015 = 0;
		}else{
			@$roe2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1937)->first()->answer / $answers->where('question_id', 1392)->where('option_code_x', 1841)->where('option_code_y', 1928)->first()->answer;
		}

		$grado_endeudamiento2014 = 0;
		if(@$answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1921)->first()->answer == 0){
			$grado_endeudamiento2014 = 0;
		}else{
			@$grado_endeudamiento2014 = $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1924)->first()->answer / $answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1921)->first()->answer;
		}

		$grado_endeudamiento2015 = 0;
		if(@$answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1921)->first()->answer == 0){
			$grado_endeudamiento2015 = 0;
		}else{
			@$grado_endeudamiento2015 = $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1924)->first()->answer / $answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1921)->first()->answer;
		}

		$obligaciones_financieras_ventas2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer == 0){
			$obligaciones_financieras_ventas2014 = 0;
		}else{
			@$obligaciones_financieras_ventas2014 = ($answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1827)->first()->answer + $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1831)->first()->answer) / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer;
		}

		$obligaciones_financieras_ventas2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer == 0){
			$obligaciones_financieras_ventas2015 = 0;
		}else{
			@$obligaciones_financieras_ventas2015 = ($answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1827)->first()->answer + $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1831)->first()->answer) / $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer;
		}

		$obligaciones_financieras_ebitda2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer == 0){
			$obligaciones_financieras_ebitda2014 = 0;
		}else{
			@$obligaciones_financieras_ebitda2014 = ($answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1827)->first()->answer + $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1831)->first()->answer) / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer;
		}

		$obligaciones_financieras_ebitda2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer == 0){
			$obligaciones_financieras_ebitda2015 = 0;
		}else{
			@$obligaciones_financieras_ebitda2015 = ($answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1827)->first()->answer + $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1831)->first()->answer) / $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer;
		}

		$ebitda_gastos_financieros2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer == 0){
			$ebitda_gastos_financieros2014 = 0;
		}else{
			@$ebitda_gastos_financieros2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer;
		}

		$ebitda_gastos_financieros2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer == 0){
			$ebitda_gastos_financieros2015 = 0;
		}else{
			@$ebitda_gastos_financieros2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer;
		}

		$ebitda_gastos_tdcp_gf2014 = 0;
		if((@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer + @$answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1827)->first()->answer) == 0){
			$ebitda_gastos_tdcp_gf2014 = 0;
		}else{
			@$ebitda_gastos_tdcp_gf2014 = $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1934)->first()->answer / ($answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer + $answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1827)->first()->answer);
		}

		$ebitda_gastos_tdcp_gf2015 = 0;
		if((@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer + @$answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1827)->first()->answer) == 0){
			$ebitda_gastos_tdcp_gf2015 = 0;
		}else{
			@$ebitda_gastos_tdcp_gf2015 = $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1934)->first()->answer / ($answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer + $answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1827)->first()->answer);
		}

		$flujo_caja_libre2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer == 0){
			$flujo_caja_libre2014 = 0;
		}else{
			@$flujo_caja_libre2014 = $cash_flow->flujo_caja_libre2014/$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1849)->first()->answer;
		}

		$flujo_caja_libre2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer == 0){
			$flujo_caja_libre2015 = 0;
		}else{
			@$flujo_caja_libre2015 = $cash_flow->flujo_caja_libre2015/$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1849)->first()->answer;
		}

		$dias_plazo_cobro2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer == 0){
			$dias_plazo_cobro2014 = 0;
		}else{
			@$dias_plazo_cobro2014 = ($answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1813)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1842)->first()->answer)*(12*30);
		}

		$dias_plazo_cobro2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer == 0){
			$dias_plazo_cobro2015 = 0;
		}else{
			@$dias_plazo_cobro2015 = ($answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1813)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1842)->first()->answer)*(12*30);
		}

		$dias_inventario2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1843)->first()->answer == 0){
			$dias_inventario2014 = 0;
		}else{
			@$dias_inventario2014 = ($answers->where('question_id', 1390)->where('option_code_x', 1825)->where('option_code_y', 1814)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1843)->first()->answer)*(12*30);
		}

		$dias_inventario2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1843)->first()->answer == 0){
			@$dias_inventario2015 = 0;
		}else{
			@$dias_inventario2015 = ($answers->where('question_id', 1390)->where('option_code_x', 1826)->where('option_code_y', 1814)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1843)->first()->answer)*(12*30);
		}

		$dias_plazo_pago2014 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1843)->first()->answer == 0){
			$dias_plazo_pago2014 = 0;
		}else{
			@$dias_plazo_pago2014 = ($answers->where('question_id', 1391)->where('option_code_x', 1834)->where('option_code_y', 1828)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1857)->where('option_code_y', 1843)->first()->answer)*(12*30);
		}

		$dias_plazo_pago2015 = 0;
		if(@$answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1843)->first()->answer == 0){
			$dias_plazo_pago2015 = 0;
		}else{
			@$dias_plazo_pago2015 = ($answers->where('question_id', 1391)->where('option_code_x', 1835)->where('option_code_y', 1828)->first()->answer / $answers->where('question_id', 1393)->where('option_code_x', 1858)->where('option_code_y', 1843)->first()->answer)*(12*30);
		}

		$ciclo_operacional2014 = $dias_plazo_cobro2014 + $dias_inventario2014 - $dias_plazo_pago2014;
		$ciclo_operacional2015 = $dias_plazo_cobro2015 + $dias_inventario2015 - $dias_plazo_pago2015;

		$financial_reasons->evolucion_ventas2014 = $evolucion_ventas2014*100;
		$financial_reasons->evolucion_ventas2015 = $evolucion_ventas2015*100;
		$financial_reasons->evolucion_ebitda2014 = $evolucion_ebitda2014*100;
		$financial_reasons->evolucion_ebitda2015 = $evolucion_ebitda2015*100;
		$financial_reasons->capex_ventas2014 = $capex_ventas2014*100;
		$financial_reasons->capex_ventas2015 = $capex_ventas2015*100;
		$financial_reasons->roa2014 = $roa2014*100;
		$financial_reasons->roa2015 = $roa2015*100;
		$financial_reasons->roe2014 = $roe2014*100;
		$financial_reasons->roe2015 = $roe2015*100;
		$financial_reasons->grado_endeudamiento2014 = $grado_endeudamiento2014*100;
		$financial_reasons->grado_endeudamiento2015 = $grado_endeudamiento2015*100;
		$financial_reasons->obligaciones_financieras_ventas2014 = $obligaciones_financieras_ventas2014;
		$financial_reasons->obligaciones_financieras_ventas2015 = $obligaciones_financieras_ventas2015;
		$financial_reasons->obligaciones_financieras_ebitda2014 = $obligaciones_financieras_ebitda2014;
		$financial_reasons->obligaciones_financieras_ebitda2015 = $obligaciones_financieras_ebitda2015;
		$financial_reasons->ebitda_gastos_financieros2014 = $ebitda_gastos_financieros2014;
		$financial_reasons->ebitda_gastos_financieros2015 = $ebitda_gastos_financieros2015;
		$financial_reasons->ebitda_gastos_tdcp_gf2014 = $ebitda_gastos_tdcp_gf2014;
		$financial_reasons->ebitda_gastos_tdcp_gf2015 = $ebitda_gastos_tdcp_gf2015;
		$financial_reasons->flujo_caja_libre2014 = $flujo_caja_libre2014;
		$financial_reasons->flujo_caja_libre2015 = $flujo_caja_libre2015;
		$financial_reasons->dias_plazo_cobro2014 = $dias_plazo_cobro2014;
		$financial_reasons->dias_plazo_cobro2015 = $dias_plazo_cobro2015;
		$financial_reasons->dias_inventario2014 = $dias_inventario2014;
		$financial_reasons->dias_inventario2015 = $dias_inventario2015;
		$financial_reasons->dias_plazo_pago2014 = $dias_plazo_pago2014;
		$financial_reasons->dias_plazo_pago2015 = $dias_plazo_pago2015;
		$financial_reasons->ciclo_operacional2014 = $ciclo_operacional2014;
		$financial_reasons->ciclo_operacional2015 = $ciclo_operacional2015;
		return $financial_reasons;
	}

	public static function getInterpretationFinancialReasons(Collection $answers, $financial_reasons)
	{
		$interpretation_financial_reasons = new \stdClass();
		$date = "diciembre de 2015";

		if($financial_reasons->evolucion_ventas2015 > 0){
			$interpretation_financial_reasons->interpretacion_evluacion_ventas = "Para ".$date." existe un crecimiento en ventas del ".round(number_format($financial_reasons->evolucion_ventas2015,2,'.',','))."%";
		}else{
			$interpretation_financial_reasons->interpretacion_evluacion_ventas = "Para ".$date." existe una disminución de las ventas del ".round(number_format($financial_reasons->evolucion_ventas2015,2,'.',','))."%";
		}
		$interpretation_financial_reasons->plan_interpretacion_evluacion_ventas = "OPERATIVO";

		if($financial_reasons->evolucion_ebitda2015 > 0){
			$interpretation_financial_reasons->interpretacion_evolucion_ebitda = "Para ".$date." existe un crecimiento en el ebitda de ".round(number_format($financial_reasons->evolucion_ebitda2015,2,'.',','))."%";
		}else{
			$interpretation_financial_reasons->interpretacion_evolucion_ebitda = "Para ".$date." existe una disminución del ebitda en ".round(number_format($financial_reasons->evolucion_ebitda2015,2,'.',','))."%";
		}
		$interpretation_financial_reasons->plan_interpretacion_evolucion_ebitda = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_roa = "Para ".$date." hubo una rentabilidad de ".round(number_format($financial_reasons->roa2015,2,'.',','))."% con respecto al activo total de la empresa.";
		$interpretation_financial_reasons->plan_roa = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_roe = "Para ".$date." hubo una rentabilidad de ".round(number_format($financial_reasons->roe2015,2,'.',','))."% del patrimonio de la empresa.";
		$interpretation_financial_reasons->plan_roe = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_grado_endeudamiento = "Para ".$date." el nivel de endeudamiento de la empresa es de ".round(number_format($financial_reasons->grado_endeudamiento2015,2,'.',','))."%";
		$interpretation_financial_reasons->plan_grado_endeudamiento = "OPERATIVO";

		if($financial_reasons->obligaciones_financieras_ventas2015 > 0){
			$interpretation_financial_reasons->interpretacion_obligaciones_financieras_ventas = "Para ".$date." las obligaciones financieras representa ".round(number_format($financial_reasons->obligaciones_financieras_ventas2015,2,'.',','))." veces las ventas";
		}else{
			$interpretation_financial_reasons->interpretacion_obligaciones_financieras_ventas = "Para ".$date." las obligaciones financieras son menores en ".round(number_format($financial_reasons->obligaciones_financieras_ventas2015,2,'.',','))." veces las ventas";
		}
		$interpretation_financial_reasons->plan_obligaciones_financieras_ventas = "OPERATIVO";

		if($financial_reasons->obligaciones_financieras_ebitda2015 > 0){
			$interpretation_financial_reasons->interpretacion_obligaciones_financieras_ventas = "Para ".$date." las obligaciones financieras representa ".round(number_format($financial_reasons->obligaciones_financieras_ebitda2015,2,'.',','))." veces el ebitda";
		}else{
			$interpretation_financial_reasons->interpretacion_obligaciones_financieras_ebitda = "Para ".$date." las obligaciones financieras son menores en ".round(number_format($financial_reasons->obligaciones_financieras_ebitda2015,2,'.',','))." veces el ebitda";
		}
		$interpretation_financial_reasons->plan_obligaciones_financieras_ebitda = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_ebitda_gf = "Para ".$date." el ebitda que atiende la deuda ".round(number_format($financial_reasons->ebitda_gastos_financieros2015,2,'.',','))." veces";
		$interpretation_financial_reasons->plan_ebitda_gf = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_ebitda_gf_dt = "Para ".$date." el ebitda da cobertura a la deuda de corto plazo más sus gastos financieros ".round(number_format($financial_reasons->ebitda_gastos_tdcp_gf2015,2,'.',','))." veces";
		$interpretation_financial_reasons->plan_ebitda_gf_dt = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_flujo_caja_libre = "Para ".$date." el flujo de caja para atender la deuda es de ".round(number_format($financial_reasons->flujo_caja_libre2015,2,'.',','))." veces";
		$interpretation_financial_reasons->plan_flujo_caja_libre = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_dias_plazo_cobro = "Para ".$date." el promedio de días de cobro de la cartera es de ".round(number_format($financial_reasons->dias_plazo_cobro2015,2,'.',','))." días";
		$interpretation_financial_reasons->plan_dias_plazo_cobro = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_dias_inventario = "Para ".$date." los días de inventario acumulados son ".round(number_format($financial_reasons->dias_inventario2015,2,'.',','))." días";
		$interpretation_financial_reasons->plan_dias_inventario = "OPERATIVO";

		$interpretation_financial_reasons->interpretacion_dias_plazo_pago = "Para ".$date." el pago promedio de proveedores en días es de ".round(number_format($financial_reasons->dias_plazo_pago2015,2,'.',','));
		$interpretation_financial_reasons->plan_dias_plazo_pago = "OPERATIVO";

		if($financial_reasons->ciclo_operacional2015 < 0){
			$interpretation_financial_reasons->interpretacion_ciclo_operacional = "Para ".$date." el pago a proveedores está tomando mayor tiempo que la recolección de cartera, indicando mayor liquidez (deseable)";
		}else{
			$interpretation_financial_reasons->interpretacion_ciclo_operacional = "Para ".$date." el cobro de cartera toma más tiempo que el pago a proveedores poniéndolo en riesgo de liquidez";
		}
		$interpretation_financial_reasons->plan_ciclo_operacional = "OPERATIVO";

		return $interpretation_financial_reasons;
	}

	public static function averageGroup(GrupoItemEval $group, RegistroFaseUsuario $register)
	{
		switch ($group->codigo_grupo_item_eval) :
		    // Evaluacion reto 1.2
		    case GrupoItemEval::getGroup('average_differential'):
			    $query = RespuestaEncuesta::query();
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [1245, 1249, 1246, 1247]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge);
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        return $query->sum('puntaje_opcion_encuesta');
		    break;

		    case GrupoItemEval::getGroup('average_commercial'):
		    	$query = RespuestaEncuesta::query();
		    	$query->select(
		            DB::raw('
		                SUM((CASE pregunta_encuesta.codigo_pregunta_encuesta
							WHEN 1395
							THEN (
								(CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 1395 and respuesta_encuesta.codigo_opcion_encuesta = 1851)
									THEN ( CASE
										WHEN (
											(SELECT COALESCE(r1260.texto_respuesta_encuesta::double precision, 0)
												FROM core.respuesta_encuesta as r1260
												INNER JOIN core.usuario_encuesta as ue1260 ON r1260.codigo_usuario_encuesta = ue1260.codigo_usuario_encuesta
												INNER JOIN core.registro_convocatoria as rc1260 ON ue1260.codigo_usuario_encuesta = rc1260.codigo_usuario_encuesta
												WHERE rc1260.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria AND r1260.codigo_pregunta_encuesta = 1260

											) >= 300000
										)
									THEN 7.5 ELSE -7.5 END)
								ELSE 0 END)
							)
							ELSE puntaje_opcion_encuesta
						END)) as total_average_commercial'
		           	)
		        );
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge);
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [1395, 1252, 1253, 1248]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        $scoring = $query->first();
		        return $scoring->total_average_commercial;
		    break;

		    case GrupoItemEval::getGroup('validation_commercial'):
		    	$query = RespuestaEncuesta::query();
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge);
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [1254, 1395, 1256]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        return $query->sum('puntaje_opcion_encuesta');
		    break;

		    case GrupoItemEval::getGroup('average_work_team'):
				$query = RespuestaEncuesta::query();
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge);
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [1250, 1251]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        return $query->sum('puntaje_opcion_encuesta');
		    break;

		    // Evaluacion reto 2
		    case GrupoItemEval::getGroup('enterprising_team'):
				$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('resultado_evaluacion_emprendimiento.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('enterprising_team'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round(($query->sum('puntaje_resul_eval_empren') / 40) * 100);
		    break;

		    case GrupoItemEval::getGroup('market'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
				$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('resultado_evaluacion_emprendimiento.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('market'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round(($query->sum('puntaje_resul_eval_empren') / 25) * 100);
		    break;

		    case GrupoItemEval::getGroup('product'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('resultado_evaluacion_emprendimiento.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('product'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round(($query->sum('puntaje_resul_eval_empren') / 25) * 100);
		    break;

		    case GrupoItemEval::getGroup('productive_chains'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('resultado_evaluacion_emprendimiento.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('productive_chains'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round(($query->sum('puntaje_resul_eval_empren') / 10) * 100);
            break;

            // Evaluacion 1.2 Empodera
		    case GrupoItemEval::getGroup('average_differential_empodera'):
			    $query = RespuestaEncuesta::query();
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [2809, 2821, 2814, 2831]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge_empodera);
                $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        return $query->sum('puntaje_opcion_encuesta');
		    break;

		    case GrupoItemEval::getGroup('average_commercial_empodera'):
		    	$query = RespuestaEncuesta::query();
		    	$query->select(
		            DB::raw('
		                SUM((CASE pregunta_encuesta.codigo_pregunta_encuesta
							WHEN 2878
							THEN (
								(CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 2878 and respuesta_encuesta.codigo_opcion_encuesta = 4084)
									THEN ( CASE
										WHEN (
											(SELECT COALESCE(r2877.texto_respuesta_encuesta::double precision, 0)
												FROM core.respuesta_encuesta as r2877
												INNER JOIN core.usuario_encuesta as ue2877 ON r2877.codigo_usuario_encuesta = ue2877.codigo_usuario_encuesta
												INNER JOIN core.registro_convocatoria as rc2877 ON ue2877.codigo_usuario_encuesta = rc2877.codigo_usuario_encuesta
												WHERE rc2877.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria AND r2877.codigo_pregunta_encuesta = 2877

											) >= 300000
										)
									THEN 7.5 ELSE -7.5 END)
								ELSE 0 END)
							)
							ELSE puntaje_opcion_encuesta
						END)) as total_average_commercial'
		           	)
		        );
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge_empodera);
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [2878, 2829, 2825, 2823]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        $scoring = $query->first();
		        return $scoring->total_average_commercial;
		    break;

		    case GrupoItemEval::getGroup('validation_commercial_empodera'):
		    	$query = RespuestaEncuesta::query();
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge_empodera);
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [2815, 2878, 2817]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        return $query->sum('puntaje_opcion_encuesta');
		    break;

		    case GrupoItemEval::getGroup('average_work_team_empodera'):
				$query = RespuestaEncuesta::query();
		        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		        $query->join('core.usuario_encuesta', 'respuesta_encuesta.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta');
		        $query->join('core.registro_convocatoria', 'usuario_encuesta.codigo_usuario_encuesta', '=', 'registro_convocatoria.codigo_usuario_encuesta');
		        $query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
		        $query->where('pregunta_encuesta.codigo_encuesta', self::$challenge_empodera);
		        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [2832, 2834]);
		        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		        $query->where('registro_convocatoria.codigo_registro_convocatoria', $register->codigo_registro_convocatoria);
		        return $query->sum('puntaje_opcion_encuesta');
            break;

			default:
				return null;
			break;
		endswitch;
	}

	public static function generalAverageGroup(GrupoItemEval $group, RegistroFaseUsuario $register) {

		switch ($group->codigo_grupo_item_eval) :
		    // Evaluacion reto 2
		    case GrupoItemEval::getGroup('enterprising_team'):
				$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('enterprising_team'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( ($query->sum('valor_opc_eval_pregunta') / 3) / 40) * 100);
		    break;

		    case GrupoItemEval::getGroup('market'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
				$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('market'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( ($query->sum('valor_opc_eval_pregunta') / 3) / 25) * 100);
		    break;

		    case GrupoItemEval::getGroup('product'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('product'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( ($query->sum('valor_opc_eval_pregunta') / 3) / 25) * 100);
		    break;

		    case GrupoItemEval::getGroup('productive_chains'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 10);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('productive_chains'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( ($query->sum('valor_opc_eval_pregunta') / 3) / 10) * 100);
		    break;

			default:
				return null;
			break;
		endswitch;
	}

	public static function generalAverageGroupAldea2020(GrupoItemEval $group, RegistroFaseUsuario $register) {

		switch ($group->codigo_grupo_item_eval) :
		    // Evaluacion reto 2 Aldea 2020
		    case GrupoItemEval::getGroup('innovation_component'):
				$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 24);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('innovation_component'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( ($query->sum('valor_opc_eval_pregunta') / 3) * 0.32) * 10);
		    break;

		    case GrupoItemEval::getGroup('market_2020'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
				$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 24);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('market_2020'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round((($query->sum('valor_opc_eval_pregunta')/3 )*0.11)*10);
		    break;

		    case GrupoItemEval::getGroup('enterprising_team_2020'):
				$query = ResultadoEvaluacionEmprendimiento::query();
				$query->select(
					DB::raw("SUM(CASE WHEN item_evaluacion_emprendimiento.codigo_item_evaluacion = 182 THEN valor_opc_eval_pregunta*0.10*10 ELSE valor_opc_eval_pregunta*0.05*10 END)/3 as valor_opc_eval_pregunta")
				);
				$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 24);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('enterprising_team_2020'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( $query->first()->valor_opc_eval_pregunta);
		    break;

		    case GrupoItemEval::getGroup('objetives'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 24);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('objetives'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( (($query->sum('valor_opc_eval_pregunta') / 3) * 0.12) * 100)/12);
		    break;

			case GrupoItemEval::getGroup('recomendations'):
		    	$query = ResultadoEvaluacionEmprendimiento::query();
		        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		        $query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		        $query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 24);
				$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('recomendations'));
				$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
				return round( ( (($query->sum('valor_opc_eval_pregunta') / 3) * 0.08) * 100)/8);
			break;

			default:
				return null;
			break;
		endswitch;
	}

	/**
	 * Custom scoring reto 1.
	 */
	public static function scoreChallenge_1(UsuarioEncuesta $userSurvey)
	{
		$query = RespuestaEncuesta::query();
        $query->select(
            DB::raw('
                SUM(
                    COALESCE(puntaje_respuesta_encuesta, 0) +
                    (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 1395 and respuesta_encuesta.codigo_opcion_encuesta = 1851)
                        THEN ( CASE
                            WHEN (
                                (SELECT COALESCE(r1260.texto_respuesta_encuesta::double precision, 0)
                                FROM core.respuesta_encuesta as r1260
                                WHERE r1260.codigo_usuario = respuesta_encuesta.codigo_usuario
                                AND r1260.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
                                AND r1260.codigo_pregunta_encuesta = 1260) >= 300000
                            )
                            THEN 7.5 ELSE -7.5
                        END)
                    ELSE 0 END) +
                    (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 1256 and respuesta_encuesta.codigo_opcion_encuesta = 1668)
                        THEN ( CASE
                            WHEN (
                                (
                                    SELECT COALESCE( SUM(COALESCE(resp.texto_respuesta_encuesta::double precision, 0)) ,0)
                                    FROM core.respuesta_encuesta as resp
                                    WHERE resp.codigo_usuario = respuesta_encuesta.codigo_usuario
                                    AND resp.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
                                    AND resp.codigo_pregunta_encuesta in (1258, 1259, 1260)
                                ) < 300000
                            )
                            THEN -100 ELSE 0
                        END)
						ELSE 0 END) +
					(CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 1395 and respuesta_encuesta.codigo_opcion_encuesta = 1853)
						THEN ( CASE
							WHEN (
								(
									SELECT COALESCE( SUM(COALESCE(resp.texto_respuesta_encuesta::double precision, 0)) ,0)
									FROM core.respuesta_encuesta as resp
									WHERE resp.codigo_usuario = respuesta_encuesta.codigo_usuario
									AND resp.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
									AND resp.codigo_pregunta_encuesta in (1934)
								) >= 0
							)
							THEN -100 ELSE 0
						END)
						ELSE 0 END) +
                    (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 1395 and respuesta_encuesta.codigo_opcion_encuesta = 1851)
            		    THEN (
							CASE WHEN (
								SELECT COALESCE( SUM(COALESCE(resp.texto_respuesta_encuesta::double precision, 0)) ,0)
								FROM core.respuesta_encuesta as resp
								WHERE resp.codigo_usuario = respuesta_encuesta.codigo_usuario
								AND resp.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
								AND resp.codigo_pregunta_encuesta in (1258, 1259, 1260)
							) < 300000 THEN -100 ELSE 0 END)
					    ELSE 0 END
                    )
                ) AS total_evaluation
            ')
        );
        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [1245, 1246, 1247, 1248, 1249, 1250, 1251, 1252, 1253, 1254, 1256, 1395]);
        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
        $query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
        return $query->first()->total_evaluation;
	}

	/**
	 * Custom scoring Aldea 20
	 */

	public static function date__4284_aldea20($usuario) {
		$query = RespuestaEncuesta::query();
		$query->select('texto_respuesta_encuesta');
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4284);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $usuario);
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));

		return $query->first();
	}

	public static function getScoring__4336__Aldea20($usuario) {
        $query = RespuestaEncuesta::query();
        $query->select('respuesta_encuesta.codigo_pregunta_encuesta', 'respuesta_encuesta.cor_codigo_opcion_encuesta', 'respuesta_encuesta.texto_respuesta_encuesta');
        $query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
        $query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4336);
        $query->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7146, 7147]);
        $query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $usuario);
        $query->whereRaw('respuesta_encuesta.texto_respuesta_encuesta::BIGINT >= 100000000');

        return $query->first();
    }

	public static function getScoring__4342__Aldea20($usuario) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.texto_respuesta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4342);
		$query->where('respuesta_encuesta.cor_codigo_opcion_encuesta', '=', 7174);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $usuario);

		$total__score = 0;
		$expected__response = 0;
		if (self::getScoring__4336__Aldea20($usuario) != null) {
			$expected__response = (int)self::getScoring__4336__Aldea20($usuario)->texto_respuesta_encuesta;

			if((int)$query->first()->texto_respuesta_encuesta > $expected__response) {
				$total__score = 10;
			}
		}

		return $total__score;
	}

	public static function getScoring__4373__Aldea20($usuario) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.texto_respuesta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7262);
		$query->where('respuesta_encuesta.cor_codigo_opcion_encuesta', '=', 7269);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $usuario);
		$query->whereRaw('respuesta_encuesta.texto_respuesta_encuesta IN (102::varchar(255), 105::varchar(255))');
		$data = $query->first();

		return $data;
	}

	public static function getScoring__4392__Aldea20($usuario) {
		$query = RespuestaEncuesta::query();
		$query->select(DB::raw('COUNT(respuesta_encuesta.codigo_respuesta_encuesta) as value'));
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4392);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '!=', 7323);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $usuario);

		return $query->first();
	}

	public static function scoringAldea20(UsuarioEncuesta $userSurvey) {
		$scoring_date = 0;
		$scoring_total_4336 = 0;
		$scoring_total_4373 = 0;
		$scoring_total_4392 = 0;
		$scoring__4336 = self::getScoring__4336__Aldea20($userSurvey->codigo_usuario_encuesta);
		$scoring__4342 = self::getScoring__4342__Aldea20($userSurvey->codigo_usuario_encuesta);
		$scoring__4373 = self::getScoring__4373__Aldea20($userSurvey->codigo_usuario_encuesta);
		$scoring__4392 = self::getScoring__4392__Aldea20($userSurvey->codigo_usuario_encuesta);
		$date__4284 = self::date__4284_aldea20($userSurvey->codigo_usuario_encuesta);
		if ($date__4284 != null) {
			$date_response = new DateTime($date__4284->texto_respuesta_encuesta);
			$today = new DateTime();
			$diff__years = $today->diff($date_response);
			if ($diff__years->y <= 7) {
				$scoring_date = 10;
			}
		}
		if ($scoring__4336 != null) {
			$scoring_total_4336 = 10;
		}
		if ($scoring__4373 != null) {
			$scoring_total_4373 = 10;
		}
		if ($scoring__4392->value > 0) {
			$scoring_total_4392 = 10;
		}
		$query = RespuestaEncuesta::query();
		$query->select(DB::raw('
			SUM(
				COALESCE(puntaje_respuesta_encuesta, 0) +
				(CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4263 AND respuesta_encuesta.codigo_opcion_encuesta = 7015
				THEN
					10
				ELSE
					0
				END ) -
				(CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 5633 AND respuesta_encuesta.codigo_opcion_encuesta = 10760
				THEN
					0
				ELSE
					0
				END ) +
				( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4282 AND respuesta_encuesta.codigo_opcion_encuesta = 7045
				THEN 10
				ELSE 0
				END ) +
				( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4372 AND respuesta_encuesta.texto_respuesta_encuesta::INTEGER >= 2
				THEN 10
				ELSE 0
				END )
			) as total_scoring
		'));
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [4263, 4282, 4336, 4342, 4372, 4373, 4392, 5633]);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$scoring = $query->first()->total_scoring;
		return $scoring += ($scoring_date + $scoring_total_4336 + $scoring__4342 + $scoring_total_4373 + $scoring_total_4392);
	}

	public static function scoringProgramAppsco(UsuarioEncuesta $userSurvey)
	{
		$query = RespuestaEncuesta::query();
		$query->select();
		//$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [5867, 5902]);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->whereIn('respuesta_encuesta.texto_respuesta_encuesta', ['4', '5', '6', '10', '11']);
		$scoring_5867_5902 = $query->count();

		if ($scoring_5867_5902 > 0) {
			$scoring_total_5867_5902 = 8;
		} else {
			$scoring_total_5867_5902 = 0;
		}

		$query = RespuestaEncuesta::query();
		$query->select();
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [5880, 5912]);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->where(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::INTEGER'), '>=', 5);
		$scoring_5880_5912 = $query->count();

		if ($scoring_5880_5912 > 0) {
			$scoring_total_5880_5912 = 8;
		} else {
			$scoring_total_5880_5912 = 0;
		}

		$query = RespuestaEncuesta::query();
		$query->select();
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [5881, 5913]);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->whereIn('respuesta_encuesta.codigo_opcion_encuesta', [11526, 11596]);
		$scoring_5881_5913 = $query->count();

		if ($scoring_5881_5913 > 0) {
			$scoring_total_5881_5913 = 8;
		} else {
			$scoring_total_5881_5913 = 0;
		}

		$query = RespuestaEncuesta::query();
		$query->select(DB::raw('(
							CASE
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11321 THEN 1
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11322 THEN 5
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11323 THEN 10
								ELSE 0
							END	) as count_5806'));
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', 5806);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$scoring_5806 = $query->first();
		$scoring_5806 = isset($scoring_5806) ? $scoring_5806->count_5806 : 0;

		$query = RespuestaEncuesta::query();
		$query->select('texto_respuesta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', 5809);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$scoring_5809 = $query->first();

		if (isset($scoring_5809) && isset($scoring_5809->texto_respuesta_encuesta)) {
			if ($scoring_5809->texto_respuesta_encuesta > 1 && $scoring_5809->texto_respuesta_encuesta <= 59) {
				$scoring_5809 = 1;
			} elseif ($scoring_5809->texto_respuesta_encuesta > 60 && $scoring_5809->texto_respuesta_encuesta <= 100) {
				$scoring_5809 = 7;
			} elseif ($scoring_5809->texto_respuesta_encuesta > 100) {
				$scoring_5809 = 14;
			} else {
				$scoring_5809 = 0;
			}
		} else {
			$scoring_5809 = 0;
		}
		//$scoring_5809 = $scoring_5809->count_5809;


		$query = RespuestaEncuesta::query();
		$query->select();
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', 5812);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->where(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::BIGINT'), '>=', 3000000);
		$scoring_5812 = $query->count();

		if ($scoring_5812 > 0) {
			$scoring_total_5812 = 10;
		} else {
			$scoring_total_5812 = 0;
		}

		$query = RespuestaEncuesta::query();
		$query->select();
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', 5819);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 11354);
		$scoring_5819 = $query->count();

		if ($scoring_5819 > 0) {
			$scoring_total_5819 = 0;
		} else {
			$scoring_total_5819 = 8;
		}

		$query = RespuestaEncuesta::query();
		$query->select(DB::raw('(
							CASE
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11394 THEN 1
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11396 THEN 1
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11397 THEN 5
								WHEN respuesta_encuesta.codigo_opcion_encuesta=11398 THEN 10
								ELSE 0
							END	) AS count_5832'));
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', 5832);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$scoring_5832 = $query->first();
		$scoring_5832 = $scoring_5832->count_5832;

		return $scoring = $scoring_total_5867_5902 + $scoring_total_5880_5912 + $scoring_total_5881_5913
			+ $scoring_5806 + $scoring_5809 + $scoring_total_5812 + $scoring_total_5819 + $scoring_5832;
	}

	/**
	 * Custom scoring empodera 2020
	 */

	 public static function getScoring__4252__Empodera2020($user) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.codigo_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4252);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $user);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '!=', 6993);
		return $query->first();
	 }

	 public static function getScoring__4251__Empodera2020($user) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.codigo_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4251);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $user);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '!=', 6983);
		return $query->first();
	 }

	 public static function getScoringFechaEmpodera2020($user) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.texto_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4211);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $user);
		return $query->first();
	 }

	 public static function getScoringWomenEmpodera2020($user) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.codigo_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4217);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $user);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 6923);
		$query->where('respuesta_encuesta.texto_respuesta_encuesta', '=', '32');
		return $query->first();
	 }

	 public static function getScoringSalesEmpodera2020($user) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.texto_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4218);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $user);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 6922);
		$ventas = $query->get();
		$total = 0;
		foreach($ventas as $venta){
			$total = $total + $venta->value;
		}
		return $total;

	 }

	 public static function getScoringPeriodoVentasEmpodera2020($user) {
		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.codigo_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4214);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $user);
		$query->whereNotIn('respuesta_encuesta.codigo_opcion_encuesta',[6894,6895]);
		return $query->first();
	 }

	 public static function scoreEmpodera2020(UsuarioEncuesta $userSurvey) {

		$scoring_periodo = isset(Innpulsa::getScoringPeriodoVentasEmpodera2020($userSurvey->codigo_usuario)->value) ? -30 : 0;
		$scoring_4252 = isset(Innpulsa::getScoring__4252__Empodera2020($userSurvey->codigo_usuario)->value) ? 5 : 0;
		$scoring_4251 = isset(Innpulsa::getScoring__4251__Empodera2020($userSurvey->codigo_usuario)->value) ? 5 : 0;
		$scoring_women = isset(Innpulsa::getScoringWomenEmpodera2020($userSurvey->codigo_usuario)->value) ? 0 : -30;
		$sales = Innpulsa::getScoringSalesEmpodera2020($userSurvey->codigo_usuario);
		$scoring_sales = 0;
		$scoring_fecha_constitucion = 0;
		if($sales <= 0){
			$scoring_sales = -30;
		}
		$respuesta_fecha = Innpulsa::getScoringFechaEmpodera2020($userSurvey->codigo_usuario)->value;

		$fecha_constitucion = new DateTime($respuesta_fecha);
		$hoy = new DateTime();
		$annos = $hoy->diff($fecha_constitucion);

		if($annos->y >= 7) {
			$scoring_fecha_constitucion = -30;
		}

		$query = RespuestaEncuesta::query();
		$query->select(
            DB::raw('
                SUM(
                    COALESCE(puntaje_respuesta_encuesta, 0) +
                    (CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4248 AND respuesta_encuesta.codigo_opcion_encuesta = 6974
						THEN
							5
						ELSE
							0
					END) +
                    (CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4234 AND respuesta_encuesta.codigo_opcion_encuesta = 6943
						THEN
							10
						ELSE
							(
								CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4234 AND respuesta_encuesta.codigo_opcion_encuesta = 6941
								THEN 5
								ELSE 0
								END
							)
					END) +
					(CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4246 AND respuesta_encuesta.codigo_opcion_encuesta = 6972
						THEN
							5
						ELSE
							0
					END) +
					(CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4209 AND respuesta_encuesta.codigo_opcion_encuesta != 6886
						THEN
							-30
						ELSE
							0
					END) +
					(CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4210 AND respuesta_encuesta.codigo_opcion_encuesta != 6889
						THEN
							-30
						ELSE
							0
					END) +
					(CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4212 AND respuesta_encuesta.codigo_opcion_encuesta != 6890
						THEN
							-30
						ELSE
							0
					END) +
					(CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4215 AND respuesta_encuesta.codigo_opcion_encuesta != 6897
						THEN
							-15
						ELSE
							0
					END) +
					(CASE WHEN pregunta_encuesta.codigo_pregunta_encuesta = 4216 AND respuesta_encuesta.texto_respuesta_encuesta::integer <= 1
						THEN
							-30
						ELSE
							0
					END)
                ) AS total_evaluation
            ')
        );
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [4251, 4252, 4248, 4234, 4246, 4209, 4210, 4212, 4215, 4216]);
        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
		$scoring = $query->first()->total_evaluation;
		$scoring += ( $scoring_4252 + $scoring_4251 + $scoring_women + $scoring_sales + $scoring_fecha_constitucion + $scoring_periodo);
		return $scoring;
	}

	public static function validateAssignPhaseTwoEmpodera2020(UsuarioEncuesta $userSurvey){

		$score = $userSurvey->puntaje_total_encuesta;

		if($score >= 0){

			// Consultar registro_fase_usuario con el detalle voucher por medio del codigo de usuario
			$registro_convocatoria = RegistroConvocatoria::where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->where('codigo_convocatoria',Innpulsa::$program_challenge_empodera_2020)->first();
			$fase = RegistroFaseUsuario::where('codigo_registro_convocatoria',$registro_convocatoria->codigo_registro_convocatoria)->where('codigo_fase', Fase::getIdPhase('empodera2020_register'))->first();

			if($fase instanceof RegistroFaseUsuario){

				$juries = collect([352236,360448]);

				// Insert Assignment
				$assignment = new AsignacionJurado;
				$assignment->codigo_usuario =  $juries->random();
				$assignment->codigo_estado = Estado::getState('active');
				$assignment->fecha_asignacion_jurado = date('Y-m-d');
				$assignment->hora_asignacion_jurado = date('H:i:s');
				$assignment->codigo_registro_fase_usuario = $fase->codigo_registro_fase_usuario;
				$assignment->save();
			}
		}
	}

	/**
	 * Custom scoring reto 1.2.
	 */
	public static function scoreChallenge_1_2(RegistroFaseUsuario $register)
	{
		// Scoring reto 1.2
		$query = RegistroFaseUsuario::query();
    	$query->select(
           DB::raw(
                "(CASE fase.codigo_fase WHEN 150 THEN (
                    SELECT ROUND(SUM( ( t.evaluacion + t.scoring ) / t.divisor ), 2)
                    FROM (
                        SELECT codigo_grupo_item_eval,
                        SUM( COALESCE(puntaje_resul_eval_empren, 0) ) AS evaluacion,
                        (CASE codigo_grupo_item_eval
                            WHEN 1 THEN (
                                SELECT SUM(puntaje_respuesta_encuesta)
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 49
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (1245, 1249, 1246, 1247)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                            WHEN 2 THEN (
                                    SELECT SUM(
                                        (CASE pregunta_encuesta.codigo_pregunta_encuesta
                                            WHEN 1395
                                            THEN (
                                                (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 1395 and respuesta_encuesta.codigo_opcion_encuesta = 1851)
                                                    THEN ( CASE
                                                        WHEN (
                                                            (SELECT COALESCE(r1260.texto_respuesta_encuesta::double precision, 0)
                                                                FROM core.respuesta_encuesta as r1260
                                                                INNER JOIN core.usuario_encuesta as ue1260 ON r1260.codigo_usuario_encuesta = ue1260.codigo_usuario_encuesta
																INNER JOIN core.registro_convocatoria as rc1260 ON ue1260.codigo_usuario_encuesta = rc1260.codigo_usuario_encuesta
                                                                WHERE
                                                                rc1260.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                                                AND r1260.codigo_pregunta_encuesta = 1260
                                                            ) >= 300000
                                                        )
                                                    THEN 7.5 ELSE -7.5 END)
                                                ELSE 0 END)
                                            )
                                            ELSE puntaje_respuesta_encuesta
                                        END)
                                    )
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 49
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (1252, 1253, 1248, 1395)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                            WHEN 3 THEN (
                                SELECT SUM(puntaje_respuesta_encuesta)
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 49
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (1254, 1395, 1256)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                            WHEN 4 THEN (
                                SELECT SUM(puntaje_respuesta_encuesta)
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 49
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (1250, 1251)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                        ELSE 0 END) AS scoring,
                        (CASE codigo_grupo_item_eval
                            WHEN 1 THEN 2
                            WHEN 2 THEN 2
                        ELSE 1 END) AS divisor

                        FROM core.item_evaluacion_emprendimiento
                        LEFT JOIN core.evaluacion_item_emprendimiento ON evaluacion_item_emprendimiento.codigo_item_evaluacion = item_evaluacion_emprendimiento.codigo_item_evaluacion
                        LEFT JOIN core.resultado_evaluacion_emprendimiento ON resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion = evaluacion_item_emprendimiento.codigo_resultado_evaluacion
                        LEFT JOIN core.asignacion_jurado ON resultado_evaluacion_emprendimiento.codigo_asignacion_jurado = asignacion_jurado.codigo_asignacion_jurado

                        WHERE
                        item_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento = 9
                        AND (asignacion_jurado.codigo_registro_fase_usuario = registro_fase_usuario.codigo_registro_fase_usuario OR asignacion_jurado.codigo_registro_fase_usuario IS NULL)

                        GROUP BY codigo_grupo_item_eval
                        ORDER BY codigo_grupo_item_eval
                    ) AS t
                )
            END) AS total_evaluation")
        );

        $query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
        $query->join('seguridad.usuario as entity', 'registro_fase_usuario.codigo_usuario', '=', 'entity.codigo_usuario');
        $query->join('core.entidad', 'entity.codigo_usuario', '=', 'entidad.codigo_usuario');
        $query->join('seguridad.usuario as person', 'entidad.seg_codigo_usuario', '=', 'person.codigo_usuario');
        $query->leftJoin('core.persona', 'person.codigo_usuario', '=', 'persona.codigo_usuario');
        $query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
        $query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
        $query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
        $query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
        return $query->first()->total_evaluation;
    }

	/**
	 * Custom scoring reto 2.
	 */
	public static function scoreChallenge_2(RegistroFaseUsuario $register)
	{
		// Score
		$score = 0;

		// Groups Item Evaluation
		$query = GrupoItemEval::query();
		$query->select('item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval', 'promedio_conmutado', 'sigla_grupo_item_eval');
		$query->join('core.item_evaluacion_emprendimiento', 'grupo_item_eval.codigo_grupo_item_eval', '=', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval');
		$query->where('item_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', self::$evaluation_challenge_2);
		$query->where('item_evaluacion_emprendimiento.codigo_estado', Estado::getState('active'));
		$query->orderBy('grupo_item_eval.orden_grupo_item_eval','asc');
		$query->groupBy('grupo_item_eval.codigo_grupo_item_eval','item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval');
		$groups = $query->get();

		foreach ($groups as $group) {
			if( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team')]) ) {
				$score += (self::averageGroup($group, $register) / 100) * 40;
			}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('market'), GrupoItemEval::getGroup('product')]) ) {
				$score += (self::averageGroup($group, $register) / 100) * 25;
			}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('productive_chains')]) ) {
				$score += (self::averageGroup($group, $register) / 100) * 10;
			}
		}

		return $score;
	}

	public static function scoreEvaluationEmpodera2020(RegistroFaseUsuario $register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
		$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		$query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
		$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 20);
		$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('diferential_market_empodera_2020'));
		$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
		return round( $query->sum('valor_opc_eval_pregunta') );
	}

	public static function scoreEvaluationAldea20(RegistroFaseUsuario $register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
		$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.item_evaluacion_emprendimiento', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 'item_evaluacion_emprendimiento.codigo_item_evaluacion');
		$query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
		$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 22);
		$query->where('item_evaluacion_emprendimiento.codigo_grupo_item_eval', GrupoItemEval::getGroup('aldea_20'));
		$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
		return round( $query->sum('valor_opc_eval_pregunta') );
	}

	/**
	 * Custom keys reto 2.
	 */
	public static function keysChallenge_2(RegistroFaseUsuario $register)
	{
		// Groups Item Evaluation
		$query = GrupoItemEval::query();
		$query->select('item_evaluacion_emprendimiento.codigo_grupo_item_eval', 'nombre_grupo_item_eval', 'promedio_conmutado');
		$query->join('core.item_evaluacion_emprendimiento', 'grupo_item_eval.codigo_grupo_item_eval', '=', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval');
		$query->where('item_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', self::$evaluation_challenge_2);
		$query->where('item_evaluacion_emprendimiento.codigo_estado', Estado::getState('active'));
		$query->orderBy('grupo_item_eval.orden_grupo_item_eval','asc');
		$query->groupBy('grupo_item_eval.codigo_grupo_item_eval','item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval');
		$groups = $query->get();

		$promedio_total = $llaves_acceso = 0;
		$promedio_grupos = collect([]);
		foreach ($groups as $group) {
			// Promedio grupo
			$promedio_grupo = self::generalAverageGroup($group, $register);
			if( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team')]) ) {
				$promedio_total += ( ($promedio_grupo / 100) * 40);
			}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('market'), GrupoItemEval::getGroup('product')]) ) {
				$promedio_total += ( ($promedio_grupo / 100) * 25);
			}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('productive_chains')]) ) {
				$promedio_total += ( ($promedio_grupo / 100) * 10);
			}

			// Llaves de acceso
			if($promedio_grupo >= 70) {
				if( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team'), GrupoItemEval::getGroup('market'), GrupoItemEval::getGroup('product')]) ) {

					$promedio_grupos[$group->codigo_grupo_item_eval] = $promedio_grupo;
				}
			}
		}

		// LLaves de acceso
		$_95 = $promedio_grupos->filter(function ($value) { return $value >= 95; });
		$_80 = $promedio_grupos->filter(function ($value) { return $value >= 80; });
		$_70 = $promedio_grupos->filter(function ($value) { return $value >= 70; });
		if( $_95->count() == 3 ) {
			$llaves_acceso = 60000000;

		}else if( $_80->count() >= 2 ) {
			$llaves_acceso = 40000000;

		}else if( $_70->count() >= 1 ) {
			$llaves_acceso = 20000000;
		}

		return round($promedio_total) >= 70 ? $llaves_acceso : 0;
	}

		/**
	 * Custom keys moment 4.
	 */
	public static function keysMomentFour__Aldea20(RegistroFaseUsuario $register)
	{
		$register_moment_3 = RegistroFaseUsuario::where('codigo_registro_convocatoria', $register->codigo_registro_convocatoria)->where('codigo_fase', Fase::getIdPhase('moment_3__Aldea20'))->first();
		$score_moment_3 = PuntajeRegistroFase::where('codigo_registro_fase_usuario', $register_moment_3->codigo_registro_fase_usuario)->first();
		$total_moment_3 = $score_moment_3 instanceof PuntajeRegistroFase ? round(($score_moment_3->valor_puntaje_registro_fase * 0.50), 2) : 0;
		$score_moment_4 = PuntajeRegistroFase::where('codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario)->first();
		$total_moment_4 = $score_moment_4 instanceof PuntajeRegistroFase ? round(($score_moment_4->valor_puntaje_registro_fase * 0.50), 2) : 0;
		$getCity = Innpulsa::getCityOfEntrepreneurship($register->codigo_usuario);
		$scoreCity = $getCity instanceof RespuestaEncuesta ? Innpulsa::getScore__4287__aldea20($getCity->texto_respuesta_encuesta) : 0;
		$getCIIU = Innpulsa::getCIIU($register->codigo_usuario);

		$total = 0;
		$score = 0;
		$total = round(($total_moment_3 + $total_moment_4 + $scoreCity + $getCIIU), 2);

		if($total >= 70 && $total <= 75) {
			$score = doubleval('20000000');
		}

		if($total > 75 && $total <= 79) {
			$score = doubleval('40000000');
		}

		if($total > 79 && $total <= 100) {
			$score = doubleval('60000000');
		}

		return $score;
	}

	public static function getCIIU($user) {
		$entidad = Entidad::select('sector_interes.codigo_sector_interes', 'nombre_sector_interes')->where('codigo_usuario', $user)->join('core.sector_interes', 'sector_interes.codigo_sector_interes', '=', 'entidad.codigo_sector_interes')->first();
		$query = $entidad instanceof Entidad ? SectorInteres::find($entidad->codigo_sector_interes) : null;

		$score = 0;
		if ($query instanceof SectorInteres) {
			if($query->ciiu_economia_naranja) {
				$score = 3;
			}
		}

		return $score;
	}

	public static function getCityOfEntrepreneurship($user) {
		$userSurvey = UsuarioEncuesta::where('codigo_usuario', $user)->where('codigo_encuesta', 126)->first();
		if(!$userSurvey instanceof UsuarioEncuesta) {
			abort(404);
		}

		$query = RespuestaEncuesta::query();
		$query->select('pregunta_encuesta.texto_pregunta_encuesta', DB::raw("CONCAT(ciudad.nombre_ciudad, ' - ', ciudad.distrito_ciudad) as respuesta"), 'respuesta_encuesta.texto_respuesta_encuesta');
		$query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.ciudad', 'ciudad.codigo_ciudad', '=', DB::raw('respuesta_encuesta.texto_respuesta_encuesta::INTEGER'));
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4287);
		$data = $query->first();

		return $data;
	}

	public static function getScore__4287__aldea20($city) {
		$city = Ciudad::find((int)$city);

		$score = 0;
		switch ($city->indice_innovacion) {
			case Innpulsa::getRegion__Moment_Four__Aldea20('bajo'):
				$score = 5;
			break;
			case Innpulsa::getRegion__Moment_Four__Aldea20('medioBajo'):
				$score = 3;
			break;
			case Innpulsa::getRegion__Moment_Four__Aldea20('medio'):
				$score = 2;
			break;
			default:
				$score = 0;
			break;
		}

		return $score;
	}

	public static function sendEmailConfirmAgreement($assignmentMembers, $url_admin_institucion, $agreement)
	{
		if( count($assignmentMembers) > 0 ){

			foreach ($assignmentMembers as $value) {
				// Send notification
				$data = [];
				$data['_template'] = 'emails.marketplace.agreementconfirm';
				$data['_inst'] = RegistroSesion::getInstitution();
				$data['_subject'] = 'Acuerdo de negociación por revisar';
				$data['_to'] = $value->correo_electronico;
				$data['_to_name'] = ucwords(strtolower($value->nombre_usuario));
				$data['_url_admin_institution'] = $url_admin_institucion.'/marketplace/transacciones/acuerdo/'.TuProyecto::encryptSrcParams([$value->codigo_acuerdo_compra]);
				SendEmail::notification($data);
			}
        }else{

			// Send notification
			$data = [];
			$data['_template'] = 'emails.marketplace.agreementconfirm';
			$data['_inst'] = RegistroSesion::getInstitution();
			$data['_subject'] = 'Acuerdo de negociación por revisar';
			$data['_to'] = self::$email_user_institution;
			$data['_to_name'] = 'Darlin Rodriguez';
			$data['_url_admin_institution'] = $url_admin_institucion.'/marketplace/transacciones/acuerdo/'.TuProyecto::encryptSrcParams([$agreement]);
			SendEmail::notification($data);
		}
	}

	public static function sendEmailsDocumentsToResponsables($code) {
		$user = Usuario::find($code);
		if (!$user instanceof Usuario) {
			abort(500);
			Log::error(sprintf('%s:%s', 'Usuario not found', $e->getMessage()));
		}

		$program = RegistroConvocatoria::select('numero_registro_convocatoria')
			->where('codigo_usuario', $code)
			->where('codigo_convocatoria', self::$program_aldea_20)
			->first();

		if (!$program instanceof RegistroConvocatoria) {
			abort(500);
			Log::error(sprintf('%s:%s', 'RegistroConvocatoria not found', $e->getMessage()));
		}

		$recipients = [
			'roberto.manrique@innpulsacolombia.com', 'julian.rocha@innpulsacolombia.com',
			'ruben.gantiva@innpulsacolombia.com', 'Maria.Soler@innpulsacolombia.com'
		];

		$data = [];
		$data['_subject'] = 'Vinculacion de Documentos';
		$data['_template'] = 'emails.letter.letterDocumentsAceptation';
		$data['_register'] = $program->numero_registro_convocatoria;
		$data['_name'] = $user->nombre_usuario;
		$data['_inst'] = RegistroSesion::getInstitution();

		foreach ($recipients as $recipient) {
			$data['_to'] = $recipient;
			SendEmail::notification($data);
		}
	}

	public static function sendEmailLinkingDocuments(Usuario $user)
	{
		// Institution
		$institution = RegistroSesion::institution();
		if( !$institution instanceof Institucion ){
			throw new \Exception("Ha ocurrido un error inesperado por favor recarga tú navegador.");
		}

		// Tree phase
		$query = RegistroFaseUsuario::query();
		$query->select('codigo_registro_fase_usuario', DB::raw("(CASE person.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN person.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE entity.nombre_usuario END) as nombre_usuario"));
		$query->join('core.entidad', 'registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->join('seguridad.usuario as entity', 'entidad.seg_codigo_usuario', '=', 'entity.codigo_usuario');
		$query->join('seguridad.usuario as person', 'entity.codigo_usuario', '=', 'person.codigo_usuario');
		$query->join('core.persona', 'person.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
		$query->where('registro_convocatoria.codigo_convocatoria', self::$program_challenge);
		$query->where('registro_fase_usuario.codigo_fase', self::$stage_challenge_3);
		$query->where('registro_convocatoria.codigo_usuario', '=', $user->codigo_usuario);
		$treePhase = $query->first();

		if(!is_null($treePhase)){
			// Send notification
			$data = [];
			$data['_template'] = 'emails.project.notificationlinkingdocuments';
			$data['_inst'] = $institution->codigo_institucion;
			$data['_subject'] = 'Documentos de vinculación';
			$data['_to'] = self::$email_user_institution_linking;
			$data['_to_name'] = 'Maria Angelica Soler';
			$data['_businessman'] = ucwords( strtolower( $treePhase->nombre_usuario ) );
			$data['_url_admin_institution'] = $institution->url_admin_institucion.'/convocatoria/fase/compromiso/'.TuProyecto::encryptSrcParams([$treePhase->codigo_registro_fase_usuario]);
			SendEmail::notification($data);
		}
	}

	public static function sendEmailDeliverables(Usuario $purchaser, Usuario $seller, Usuario $adviser, Compra $purchase, Producto $product, $institution)
	{
		// Send notification
		$data = [];
		$data['_template'] = 'emails.marketplace.deliverable';
		$data['_inst'] = RegistroSesion::getInstitution();
		$data['_subject'] = 'Entregables acuerdo';
		$data['_to'] = $purchaser->correo_electronico;
		$data['_to_name'] = $purchaser->nombre_usuario;
		// $data['_seller'] = ucwords(strtolower($seller->nombre_usuario));
		$data['_adviser'] = ucwords(strtolower($adviser->nombre_usuario));
		$data['_project'] = ucwords(strtolower($product->nombre_producto));
		$data['_url_action'] = $institution->url_institucion.'/marketplace/compras/entregables/'.TuProyecto::encryptSrcParams([$purchase->codigo_compra]);
		SendEmail::notification($data);
	}

	public static function sendEmailConfirmDeliverables($assignmentMembers, Compra $purchase, Usuario $purchaser, Usuario $seller, Producto $product, $institution)
	{
		if( count($assignmentMembers) > 0 ){

			foreach ($assignmentMembers as $value) {
				// Send notification
				$data = [];
				$data['_template'] = 'emails.marketplace.confirmdeliverable';
				$data['_inst'] = $institution->codigo_institucion;
				$data['_subject'] = 'Entregables acuerdo';
				$data['_to'] = $value->correo_electronico;
				$data['_to_name'] = ucwords(strtolower($value->nombre_usuario));
				$data['_seller'] = ucwords(strtolower($seller->nombre_usuario));
				$data['_project'] = ucwords(strtolower($product->nombre_producto));
				$data['_purchaser'] = ucwords(strtolower($purchaser->nombre_usuario));
				$data['_url_action'] = $institution->url_admin_institucion.'/marketplace/transacciones/evaluacion/'.$purchase->codigo_compra;
				SendEmail::notification($data);
			}
		}else{

			// Send notification
			$data = [];
			$data['_template'] = 'emails.marketplace.confirmdeliverable';
			$data['_inst'] = RegistroSesion::getInstitution();
			$data['_subject'] = 'Entregables acuerdo';
			$data['_to'] = self::$email_user_institution;
			$data['_to_name'] = 'Darlin Rodriguez';
			$data['_seller'] = ucwords(strtolower($seller->nombre_usuario));
			$data['_project'] = ucwords(strtolower($product->nombre_producto));
			$data['_purchaser'] = ucwords(strtolower($purchaser->nombre_usuario));
			$data['_url_action'] = $institution->url_admin_institucion.'/marketplace/transacciones/evaluacion/'.$purchase->codigo_compra;
			SendEmail::notification($data);
		}
	}

	public static function sendEmailRefuseDeliverables(Compra $purchase, Usuario $purchaser, Usuario $seller, Producto $product, $institution, $comment) {
		// Send notification
		$data = [];
		$data['_template'] = 'emails.marketplace.refusedeliverable';
		$data['_inst'] = RegistroSesion::getInstitution();
		$data['_subject'] = 'Rechazo Entregables acuerdo';
		$data['_to'] = $seller->correo_electronico;
		$data['_to_name'] = $seller->nombre_usuario;
		$data['_seller'] = ucwords(strtolower($seller->nombre_usuario));
		$data['_project'] = ucwords(strtolower($product->nombre_producto));
		$data['_purchaser'] = ucwords(strtolower($purchaser->nombre_usuario));
		$data['_comment'] = strtolower($comment);
		$data['_url_action'] = $institution->url_institucion.'/marketplace/ventas/entregables/'.TuProyecto::encryptSrcParams([$purchase->codigo_compra]);
		SendEmail::notification($data);
	}

	public static function getProyectEntity(Compra $purchase)
	{
		$query = Usuario::query();
		$query->select('usuario.*');
		$query->join('core.registro_convocatoria', 'usuario.codigo_usuario', '=', 'registro_convocatoria.codigo_usuario');
		$query->join('core.registro_fase_usuario', 'registro_convocatoria.codigo_registro_convocatoria', '=', 'registro_fase_usuario.codigo_registro_convocatoria');
		$query->join('core.detalle_voucher', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'detalle_voucher.codigo_registro_fase_usuario');
		$query->join('core.consumo_voucher', function($join) use($purchase){
			$join->on('detalle_voucher.codigo_detalle_voucher', '=', 'consumo_voucher.codigo_detalle_voucher')
				->where('consumo_voucher.codigo_compra', '=', $purchase->codigo_compra);
		});

		return $query->first();
    }

    public static function scoreChallengeEmpodera_1(UsuarioEncuesta $userSurvey)
	{
		$query = RespuestaEncuesta::query();
        $query->select(
            DB::raw('
                SUM(
                    COALESCE(puntaje_respuesta_encuesta, 0) +
                    (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 2878 and respuesta_encuesta.codigo_opcion_encuesta = 4084)
                        THEN ( CASE
                            WHEN (
                                (SELECT COALESCE(r2877.texto_respuesta_encuesta::double precision, 0)
                                FROM core.respuesta_encuesta as r2877
                                WHERE r2877.codigo_usuario = respuesta_encuesta.codigo_usuario
                                AND r2877.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
                                AND r2877.codigo_pregunta_encuesta = 2877) >= 300000
                            )
                            THEN 7.5 ELSE -7.5
                        END)
                    ELSE 0 END) +
                    (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 2817 and respuesta_encuesta.codigo_opcion_encuesta = 3906)
                        THEN ( CASE
                            WHEN (
                                (
                                    SELECT COALESCE( SUM(COALESCE(resp.texto_respuesta_encuesta::double precision, 0)) ,0)
                                    FROM core.respuesta_encuesta as resp
                                    WHERE resp.codigo_usuario = respuesta_encuesta.codigo_usuario
                                    AND resp.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
                                    AND resp.codigo_pregunta_encuesta in (2875, 2876, 2877)
                                ) < 300000
                            )
                            THEN -100 ELSE 0
                        END)
                        ELSE 0 END) +
                    (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 2878 and respuesta_encuesta.codigo_opcion_encuesta = 4084)
            		    THEN (
							CASE WHEN (
								SELECT COALESCE( SUM(COALESCE(resp.texto_respuesta_encuesta::double precision, 0)) ,0)
								FROM core.respuesta_encuesta as resp
								WHERE resp.codigo_usuario = respuesta_encuesta.codigo_usuario
								AND resp.codigo_usuario_encuesta = respuesta_encuesta.codigo_usuario_encuesta
								AND resp.codigo_pregunta_encuesta in (2875, 2876, 2877)
							) < 300000 THEN -100 ELSE 0 END)
					    ELSE 0 END
                    )
                ) AS total_evaluation
            ')
        );
        $query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
        $query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [2809, 2814, 2831, 2823, 2821, 2832, 2834, 2829, 2825, 2815, 2817, 2878]);
        $query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
        $query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
        return $query->first()->total_evaluation;
    }

    public static function validFirstChallengeEmpodera(UsuarioEncuesta $userSurvey, $request)
	{
		$response = new \stdClass();
		$response->success = true;

		// Get user entity
		$query = Usuario::query();
		$query->select('entidad.codigo_entidad', 'entidad.codigo_usuario', 'entidad.codigo_clase_empre_insti');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('usuario.codigo_usuario', $userSurvey->codigo_usuario);
		$user = $query->first();

		if(!$user instanceof Usuario) {
			$response->success = false;
			$response->data = trans('app.exception');
			return $response;
		}

		// Empresas Aldea
		if($user->codigo_clase_empre_insti == 2) {
			// Numero contacto
			if(isset($request['pregunta_2870']) && (trim($request['pregunta_2870']) == '' || trim($request['pregunta_2870']) == '____-__-__')) {
				$response->success = false;
				$response->data = "Por favor ingrese fecha de constitución legal de la Empresa (registro ante la Cámara de Comercio). ";
				return $response;
			}

			// Fecha registro empresa
			$error = "La fecha de constitución legal de la Empresa (registro ante la Cámara de Comercio) no puede ser mayor a %s. (Valor actual %s)";
			if(isset($request['pregunta_2870']) && ($request['pregunta_2870'] == '' || $request['pregunta_2870'] > date('Y-m-d'))) {
				$response->success = false;
				$response->data = sprintf($error, date('Y-m-d'), $request['pregunta_2870']);
				return $response;
			}
		}

		// Fecha inicio operacion
		$error = "La fecha en la que la empresa o negocio inició operaciones no puede ser mayor a %s. (Valor actual %s)";
		if(isset($request['pregunta_2804']) && ($request['pregunta_2804'] == '' || $request['pregunta_2804'] > date('Y-m-d'))) {
			$response->success = false;
			$response->data = sprintf($error, date('Y-m-d'), $request['pregunta_2804']);
			return $response;
		}

		// Numero contacto
		if(isset($request['pregunta_2797']) && ($request['pregunta_2797'] == '' || strlen(trim($request['pregunta_2797'])) != 10)) {
			$response->success = false;
			$response->data = "Por favor ingrese un número de teléfono de contacto válido, (Indicativo del país + Indicativo de la ciudad) + Número de teléfono.";
			return $response;
		}

		// Numero celular contacto
		if(isset($request['pregunta_2798']) && ($request['pregunta_2798'] == '' || strlen(trim($request['pregunta_2798'])) != 10)) {
			$response->success = false;
			$response->data = "Por favor ingrese un número celular de contacto válido, (Indicativo operador) + Número de celular.";
			return $response;
		}
		return $response;
	}

	// public static function validFirstChallengeEmpodera2020(UsuarioEncuesta $userSurvey, $request)
	// {
	// 	$response = new \stdClass();
	// 	$response->success = true;

	// 	// Get user entity
	// 	$query = Usuario::query();
	// 	$query->select('entidad.codigo_entidad', 'entidad.codigo_usuario', 'entidad.codigo_clase_empre_insti');
	// 	$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
	// 	$query->where('usuario.codigo_usuario', $userSurvey->codigo_usuario);
	// 	$user = $query->first();

	// 	if(!$user instanceof Usuario) {
	// 		$response->success = false;
	// 		$response->data = trans('app.exception');
	// 		return $response;
	// 	}

	// 	if(isset($request['current_page']) && $request['current_page'] == 1) {

	// 		if(isset($request['pregunta_4209_opcion']) && ($request['pregunta_4209_opcion'] == '' || $request['pregunta_4209_opcion'] != 6886)) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: Estar legalmente constituido en Colombia como persona jurídica ante una Cámara de Comercio o quien haga sus veces.";
	// 			return $response;
	// 		}

	// 		if(isset($request['pregunta_4210_opcion']) && ($request['pregunta_4210_opcion'] == '' || $request['pregunta_4210_opcion'] != 6889)) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: El programa esta diseñado para personas juridicas";
	// 			return $response;
	// 		}

	// 		$fecha_constitucion = new DateTime($request['pregunta_4211']);
	// 		$hoy = new DateTime();
	// 		$annos = $hoy->diff($fecha_constitucion);

	// 		if($annos->y >= 7) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: Tener menos de 7 años de operación comercial, es decir, de haber iniciado ventas.";
	// 			return $response;
	// 		}

	// 		if(isset($request['pregunta_4212_opcion']) && ($request['pregunta_4212_opcion'] == '' || $request['pregunta_4212_opcion'] != 6890)) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: El programa esta diseñado para empresas registradas en Colombia";
	// 			return $response;
	// 		}

	// 		if(isset($request['pregunta_4214_opcion']) && ($request['pregunta_4214_opcion'] == '' || ($request['pregunta_4214_opcion'] != 6894 && $request['pregunta_4214_opcion'] != 6895))) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: Tener tracción comercial (ventas) al momento de la postulación.";
	// 			return $response;
	// 		}

	// 		if(isset($request['pregunta_4215_opcion']) && ($request['pregunta_4215_opcion'] == '' || $request['pregunta_4215_opcion'] != 6897)) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: El líder del emprendimiento debe tener dedicación completa al emprendimiento.";
	// 			return $response;
	// 		}

	// 		if(isset($request['pregunta_4216']) && (trim($request['pregunta_4216']) == '' || trim($request['pregunta_4216']) <= 1)) {
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: Tener un equipo directivo heterogéneo de por lo menos 2 personas.";
	// 			return $response;
	// 		}

	// 		$numero_mujer = 0;
	// 		$lider = $request['pregunta_4217_opcion_6923_campo_6915'];
	// 		$integrante_1 = $request['pregunta_4217_opcion_6923_campo_6916'];
	// 		$integrante_2 = $request['pregunta_4217_opcion_6923_campo_6917'];
	// 		$integrante_3 = $request['pregunta_4217_opcion_6923_campo_6918'];

	// 		if($lider==32){
	// 			$numero_mujer++;
	// 		}
	// 		if($integrante_1==32){
	// 			$numero_mujer++;
	// 		}
	// 		if($integrante_2==32){
	// 			$numero_mujer++;
	// 		}
	// 		if($integrante_3==32){
	// 			$numero_mujer++;
	// 		}

	// 		if($numero_mujer == 0){
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: Tener un equipo directivo heterogéneo de por lo menos 2 personas.";
	// 			return $response;
	// 		}

	// 		$ventas_ano_1 = $request['pregunta_4218_opcion_6922_campo_6919'];
	// 		$ventas_ano_2 = $request['pregunta_4218_opcion_6922_campo_6920'];
	// 		$ventas_ano_3 = $request['pregunta_4218_opcion_6922_campo_6921'];

	// 		$ventas_totales = $ventas_ano_1+$ventas_ano_2+$ventas_ano_3;

	// 		if($ventas_totales <= 0){
	// 			$response->success = false;
	// 			$response->data = "Actualmente no cumple con el siguiente criterio para avanzar en el programa: Tener tracción comercial (ventas) al momento de la postulación.";
	// 			return $response;
	// 		}
	// 	}
	// 	return $response;
    // }

    public static function scoreChallengeEmpodera_1_2(RegistroFaseUsuario $register)
	{
		// Scoring reto 1.2 empodera
		$query = RegistroFaseUsuario::query();
    	$query->select(
           DB::raw(
                "(CASE fase.codigo_fase WHEN 212 THEN (
                    SELECT ROUND(SUM( ( t.evaluacion + t.scoring ) / t.divisor ), 2)
                    FROM (
                        SELECT codigo_grupo_item_eval,
                        SUM( COALESCE(puntaje_resul_eval_empren, 0) ) AS evaluacion,
                        (CASE codigo_grupo_item_eval
                            WHEN 20 THEN (
                                SELECT SUM(puntaje_respuesta_encuesta)
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 92
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (2809, 2821, 2814, 2831)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                            WHEN 21 THEN (
                                    SELECT SUM(
                                        (CASE pregunta_encuesta.codigo_pregunta_encuesta
                                            WHEN 2878
                                            THEN (
                                                (CASE WHEN (pregunta_encuesta.codigo_pregunta_encuesta = 2878 and respuesta_encuesta.codigo_opcion_encuesta = 4084)
                                                    THEN ( CASE
                                                        WHEN (
                                                            (SELECT COALESCE(r2877.texto_respuesta_encuesta::double precision, 0)
                                                                FROM core.respuesta_encuesta as r2877
                                                                INNER JOIN core.usuario_encuesta as ue2877 ON r2877.codigo_usuario_encuesta = ue2877.codigo_usuario_encuesta
																INNER JOIN core.registro_convocatoria as rc2877 ON ue2877.codigo_usuario_encuesta = rc2877.codigo_usuario_encuesta
                                                                WHERE
                                                                rc2877.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                                                AND r2877.codigo_pregunta_encuesta = 2877
                                                            ) >= 300000
                                                        )
                                                    THEN 7.5 ELSE -7.5 END)
                                                ELSE 0 END)
                                            )
                                            ELSE puntaje_respuesta_encuesta
                                        END)
                                    )
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 92
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (2829, 2825, 2823, 2878)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                            WHEN 22 THEN (
                                SELECT SUM(puntaje_respuesta_encuesta)
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 92
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (2815, 2878, 2817)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                            WHEN 23 THEN (
                                SELECT SUM(puntaje_respuesta_encuesta)
                                FROM core.respuesta_encuesta
                                INNER JOIN core.pregunta_encuesta ON respuesta_encuesta.codigo_pregunta_encuesta = pregunta_encuesta.codigo_pregunta_encuesta
                                INNER JOIN core.usuario_encuesta ON respuesta_encuesta.codigo_usuario_encuesta = usuario_encuesta.codigo_usuario_encuesta
								INNER JOIN core.registro_convocatoria ON usuario_encuesta.codigo_usuario_encuesta = registro_convocatoria.codigo_usuario_encuesta
                                WHERE registro_fase_usuario.codigo_registro_convocatoria = registro_convocatoria.codigo_registro_convocatoria
                                AND pregunta_encuesta.codigo_encuesta = 92
                                AND pregunta_encuesta.codigo_pregunta_encuesta in (2832, 2834)
                                AND respuesta_encuesta.codigo_estado = 8
                            )
                        ELSE 0 END) AS scoring,
                        (CASE codigo_grupo_item_eval
                            WHEN 20 THEN 2
                            WHEN 21 THEN 2
                        ELSE 1 END) AS divisor

                        FROM core.item_evaluacion_emprendimiento
                        LEFT JOIN core.evaluacion_item_emprendimiento ON evaluacion_item_emprendimiento.codigo_item_evaluacion = item_evaluacion_emprendimiento.codigo_item_evaluacion
                        LEFT JOIN core.resultado_evaluacion_emprendimiento ON resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion = evaluacion_item_emprendimiento.codigo_resultado_evaluacion
                        LEFT JOIN core.asignacion_jurado ON resultado_evaluacion_emprendimiento.codigo_asignacion_jurado = asignacion_jurado.codigo_asignacion_jurado

                        WHERE
                        item_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento = 18
                        AND (asignacion_jurado.codigo_registro_fase_usuario = registro_fase_usuario.codigo_registro_fase_usuario OR asignacion_jurado.codigo_registro_fase_usuario IS NULL)

                        GROUP BY codigo_grupo_item_eval
                        ORDER BY codigo_grupo_item_eval
                    ) AS t
                )
            END) AS total_evaluation")
        );

        $query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
        $query->join('seguridad.usuario as entity', 'registro_fase_usuario.codigo_usuario', '=', 'entity.codigo_usuario');
        $query->join('core.entidad', 'entity.codigo_usuario', '=', 'entidad.codigo_usuario');
        $query->join('seguridad.usuario as person', 'entidad.seg_codigo_usuario', '=', 'person.codigo_usuario');
        $query->leftJoin('core.persona', 'person.codigo_usuario', '=', 'persona.codigo_usuario');
        $query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
        $query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
        $query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
        $query->where('registro_fase_usuario.codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario);
        return $query->first()->total_evaluation;
	}

	public static function changePhaseFour(UsuarioEncuesta $userSurvey) {

		$query = RespuestaEncuesta::query();
		$query->select('respuesta_encuesta.codigo_respuesta_encuesta as value');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 3728);
		$query->where('respuesta_encuesta.codigo_usuario', '=', $userSurvey->codigo_usuario);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 5642);
		$invest = $query->first();

		$answer_invest = isset($invest->value) ? true : false;

		if($answer_invest){

			// Consultar registro_fase_usuario con el detalle voucher por medio del codigo de usuario

			$detalle_voucher = DetalleVoucher::where('codigo_usuario',$userSurvey->codigo_usuario)->first();
			$codigo_registro_fase_usuario = $detalle_voucher->codigo_registro_fase_usuario; // reto tres
			$fase = RegistroFaseUsuario::find($codigo_registro_fase_usuario);

			$dataUser = Usuario::find($userSurvey->codigo_usuario);
			// modificar la fase actual

			$phase_4 = Fase::find( Fase::getIdPhase('four_challenge') );

			if($fase instanceof RegistroFaseUsuario){

				$register = new RegistroFaseUsuario;
				$register->codigo_fase = $phase_4->codigo_fase;
				$register->codigo_usuario = $fase->codigo_usuario;
				$register->fecha_registro_fase_usuario = date('Y-m-d');
				$register->hora_registro_fase_usuario = date('H:i:s');
				$register->codigo_estado = Estado::getState('active');
				$register->codigo_registro_convocatoria = $fase->codigo_registro_convocatoria;
				$register->visualizacion_usuario = false;
				$register->save();

				$fase->codigo_estado = Estado::getState('finalized');
				$fase->visualizacion_usuario = true;
				$fase->notificacion_cambio_registro_fase = date('Y-m-d H:i:s');
				$fase->notificacion_registro_fase_usuario = true;
				$fase->seg_codigo_usuario = 45352;
				$fase->save();

				$data = [];
				$data['_template'] = 'emails.program.reto4';
				$data['_subject'] = '¡Levantemos Capital! - ALDEA';
				$data['_to'] = $dataUser->correo_electronico;
				$data['_to_name'] = ucwords(strtolower($dataUser->nombre_usuario));
				$data['_inst'] = Institucion::getInstitution('innpulsa');
				$data['url_action'] = sprintf('/encuesta/aplicar/aldea-reto4/%s?url_fase=%s', TuProyecto::encryptSrcParams([$fase->codigo_usuario]), $phase_4->url_fase);
				SendEmail::notification($data);
			}
		}else {
			$answer_invest = 0;
		}

		return $answer_invest;
	}

	// Innovacion

	public static function getResponseEvaluationAldea20__three__moment__innovacion($register, $title){
		$query = RespuestaEncuesta::query();
		switch($title) {
			case 'propiedad':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4357 AND respuesta_encuesta.codigo_opcion_encuesta = 7207 THEN 0.5 ELSE 0.0 END  ) as propiedad_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4357);
			break;
			case 'motivo':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4389 AND respuesta_encuesta.codigo_opcion_encuesta IN (7320, 7319, 7318)
					THEN 0.0
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4389 AND respuesta_encuesta.codigo_opcion_encuesta IN (7315, 7317)
						THEN 0.30
						ELSE
							( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4389 AND respuesta_encuesta.codigo_opcion_encuesta = 7314
							THEN
								0.75
							ELSE
								1.50
							END
							)
						END
						)
					END  ) as motivo_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4389);
			break;
			case 'tipo';
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta IN (7137, 7138)
				THEN 0.0
				ELSE
					( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta = 7139
					THEN 0.80
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta = 7140
						THEN 1.20
						ELSE
							( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta = 7141
							THEN 1.60
							ELSE 2.00
							END )
						END )
					END )
				END  ) as tipo_score'));
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4334);
			break;
		}
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));

		return $query->first();
	}

	public static function Calificacion__Aldea20__three_moment__innovacion($register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
		$query->select(
			'opc_eval_pregunta.nombre_opc_eval_pregunta', 'resultado_evaluacion_emprendimiento.comentario_resultado_evaluacion',
			'opc_eval_pregunta.valor_opc_eval_pregunta as total_scoring',
			DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')	) as nombre_usuario")
		);

		// Get items
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=','resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');

		// Get user information
		$query->leftJoin('seguridad.usuario', 'usuario.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');
		$query->leftJoin('core.persona', 'persona.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');

		$query->where('asignacion_jurado.codigo_registro_fase_usuario', '=', $register);
		$query->where('opc_eval_pregunta.codigo_grup_opc_eval_pregunta', '=', 81);
		$query->where('evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 174);

		return $query->get();
	}

	// Escalabilidad

	public static function getResponseEvaluationAldea20__three__moment__escalabilidad($register, $title){
		$query = RespuestaEncuesta::query();
		switch($title) {
			case 'idioma':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4280 AND respuesta_encuesta.codigo_opcion_encuesta = 7033 THEN 1.0 ELSE 0.0 END  ) as idioma_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4280);
			break;
			case 'metas':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4351 AND respuesta_encuesta.codigo_opcion_encuesta IN (7198, 7197)
					THEN 0.0
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4351 AND respuesta_encuesta.codigo_opcion_encuesta IN (7200, 7201, 7202)
						THEN 1.00
						ELSE 0.50
						END
						)
					END  ) as metas_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4351);
			break;
			case 'tipo';
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta IN (7137, 7138)
				THEN 0.0
				ELSE
					( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta = 7139
					THEN 0.80
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta = 7140
						THEN 1.20
						ELSE
							( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4334 AND respuesta_encuesta.codigo_opcion_encuesta = 7141
							THEN 1.60
							ELSE 2.00
							END )
						END )
					END )
				END  ) as tipo_score'));
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4334);
			break;
		}
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));

		return $query->first();
	}

	public static function Calificacion__potential__Aldea20__three_moment__equipo($register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
		$query->select(
			'opc_eval_pregunta.nombre_opc_eval_pregunta', 'resultado_evaluacion_emprendimiento.comentario_resultado_evaluacion',
			DB::raw('( CASE WHEN evaluacion_item_emprendimiento.valor_evaluacion_item = 302 OR evaluacion_item_emprendimiento.valor_evaluacion_item = 303
			THEN 0
			ELSE
				( CASE WHEN evaluacion_item_emprendimiento.valor_evaluacion_item = 304
				THEN 1.5
				ELSE
					( CASE WHEN evaluacion_item_emprendimiento.valor_evaluacion_item = 305
					THEN 3
					ELSE
						( CASE WHEN evaluacion_item_emprendimiento.valor_evaluacion_item = 306
						THEN 4
						ELSE 5
						END)
					END)
				END)
			END) as total_score'),
			DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')	) as nombre_usuario")
		);

		// Get items
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=','resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');

		// Get user information
		$query->leftJoin('seguridad.usuario', 'usuario.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');
		$query->leftJoin('core.persona', 'persona.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');

		$query->where('asignacion_jurado.codigo_registro_fase_usuario', '=', $register);
		$query->where('opc_eval_pregunta.codigo_grup_opc_eval_pregunta', '=', 83);
		$query->where('evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 176);

		return $query->get();
	}

	// Traccion

	public static function getResponseEvaluationAldea20__three__moment__traccion($register, $title) {
		$query = RespuestaEncuesta::query();
		switch($title) {
			case 'alcance':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4330 AND respuesta_encuesta.codigo_opcion_encuesta = 7133
					THEN 0.0
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4330 AND respuesta_encuesta.codigo_opcion_encuesta = 7134
						THEN 0.45
						ELSE
							( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4330 AND respuesta_encuesta.codigo_opcion_encuesta = 7135
							THEN 1.05
							ELSE 1.50
							END )
						END)
					END  ) as alcance_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4330);
			break;
			case 'cuentas':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4338 AND respuesta_encuesta.codigo_opcion_encuesta IN (7154, 7155)
					THEN 0.0
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4338 AND respuesta_encuesta.codigo_opcion_encuesta IN (7156, 7160, 7158)
						THEN 0.75
						ELSE
							( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4338 AND respuesta_encuesta.codigo_opcion_encuesta IN (7157, 7159)
							THEN 1.50
							END)
						END
						)
					END  ) as cuentas_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4338);
			break;
			case 'estados';
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4339 AND respuesta_encuesta.codigo_opcion_encuesta = 7162
				THEN 1.50
				ELSE 0.0
				END  ) as estados_score'));
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4339);
			break;
			case 'indicadores':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4367 AND respuesta_encuesta.codigo_opcion_encuesta IN (7215, 7218)
					THEN 0.20
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4367 AND respuesta_encuesta.codigo_opcion_encuesta IN (7216, 7217, 7219)
						THEN 1.00
						END
						)
					END  ) as indicadores_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4367);
			break;
		}
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));

		return $query->first();
	}

	// Equipo

	public static function getResponseEvaluationAldea20__three__moment__equipo($register, $title) {
		$query = RespuestaEncuesta::query();
		switch($title) {
			case 'laboral':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta', 'respuesta_encuesta.texto_respuesta_encuesta',
					DB::raw(DB::raw("( CASE WHEN nullif(respuesta_encuesta.texto_respuesta_encuesta,'')::INTEGER >= 7
					THEN 1.00
					ELSE
						( CASE WHEN nullif(respuesta_encuesta.texto_respuesta_encuesta,'')::INTEGER >= 3 AND nullif(respuesta_encuesta.texto_respuesta_encuesta,'')::INTEGER <= 6
						THEN 0.50
						ELSE 0.0
						END)
					END) as laboral_score"))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
				$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7637);
				$query->where('respuesta_encuesta.cor_codigo_opcion_encuesta', '=', 7269);
			break;
			case 'riesgo':
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw(DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4381 AND respuesta_encuesta.codigo_opcion_encuesta = 7302
					THEN 0.0
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4383 AND respuesta_encuesta.codigo_opcion_encuesta = 7304
						THEN 0.10
						ELSE
							( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4384 AND respuesta_encuesta.codigo_opcion_encuesta = 7306
							THEN 0.25
							ELSE
								( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4385 AND respuesta_encuesta.codigo_opcion_encuesta = 7308
								THEN
									0.40
								ELSE
									( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4387 AND respuesta_encuesta.codigo_opcion_encuesta = 7311
									THEN 0.50
									ELSE
										( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4387 AND respuesta_encuesta.codigo_opcion_encuesta = 7310
										THEN 0.50
										END )
									END )
								END)
							END)
						END)
					END  ) as riesgo_score'))
				);
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [4381, 4383, 4384, 4385, 4387]);
			break;
			case 'decisiones';
				$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
					DB::raw('( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4368 AND respuesta_encuesta.codigo_opcion_encuesta = 7220
				THEN 0.0
				ELSE
					( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4368 AND respuesta_encuesta.codigo_opcion_encuesta = 7221
					THEN 0.25
					ELSE
						( CASE WHEN respuesta_encuesta.codigo_pregunta_encuesta = 4368 AND ( respuesta_encuesta.codigo_opcion_encuesta = 7222 OR respuesta_encuesta.codigo_opcion_encuesta = 7223 OR respuesta_encuesta.codigo_opcion_encuesta = 7224 )
						THEN 0.50
						END)
					END)
				END  ) as decisiones_score'));
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
				$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4368);
			break;
		}
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));

		return $query->first();
	}

	public static function getSectorExprerienceAldea20__three__moment__equipo($register) {
		$query = RespuestaEncuesta::query();
		$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta',
			DB::raw('respuesta_encuesta.texto_respuesta_encuesta::INTEGER'));
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7264);
		$query->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269, 7270, 7271, 7272]);
		$data = $query->get();
		$response = [];

		foreach($data as $item) {
			$response['texto_pregunta_encuesta'] = $item->texto_pregunta_encuesta;
			$response['texto_opcion_encuesta'] = $item->texto_opcion_encuesta;
			$response['texto_respuesta_encuesta'] = (int)$item->texto_respuesta_encuesta;

			if ($item->texto_respuesta_encuesta >= 3) {
				$data = '1.00';
				$response['sector_scoring'] = $data;

				return $response;
			} else {
				$data = '0.0';
				$response['sector_scoring'] = $data;
			}
		}

		return $response;
	}

	public static function getEmprendorExprerienceAldea20__three__moment__equipo($register) {
		$query = RespuestaEncuesta::query();
		$query->select('pregunta_encuesta.texto_pregunta_encuesta', 'opcion_encuesta.texto_opcion_encuesta', 'item_opcion_encuesta.nombre_item_opcion_encuesta', 'respuesta_encuesta.texto_respuesta_encuesta');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->leftJoin('core.item_opcion_encuesta', function($join) {
			$join->on(DB::raw('item_opcion_encuesta.codigo_item_opcion_encuesta::varchar(255)'), '=', 'respuesta_encuesta.texto_respuesta_encuesta');
		});
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7267);
		$query->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269, 7270, 7271, 7272]);
		$data = $query->get();
		$response= [];

		foreach($data as $item) {
			$response['texto_pregunta_encuesta'] = $item->texto_pregunta_encuesta;
			$response['texto_opcion_encuesta'] = $item->texto_opcion_encuesta;
			$response['texto_respuesta_encuesta'] = $item->nombre_item_opcion_encuesta;

			if ((int)$item->texto_respuesta_encuesta == 123 || (int)$item->texto_respuesta_encuesta == 124 || (int)$item->texto_respuesta_encuesta == 125) {
				$data = '1.00';
				$response['emprendor_scoring'] = $data;

				return $response;
			} else {
				$data = '0.0';

				$response['emprendor_scoring'] = $data;
			}
		}

		return $response;
	}

	public static function getRolesAldea20__three__moment__equipo($register) {
		$cantidad_gerenciales = 0;
        $cantidad_comerciales = 0;
        $cantidad_creativas = 0;
        $cantidad_tecnicas = 0;
        $total_obligatorias = 0;
        $total_opcionales = 0;

        $gerenciales = RespuestaEncuesta::query();
		$gerenciales->select(DB::raw('COUNT(respuesta_encuesta.texto_respuesta_encuesta::INTEGER) as cantidad'));
		$gerenciales->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$gerenciales->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$gerenciales->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$gerenciales->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$gerenciales->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$gerenciales->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7263);
		$gerenciales->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269,7270,7271, 7272]);
		$gerenciales->whereIn(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::varchar(255)'), ['108']);
        $i1 = $gerenciales->first(); 

        if($i1->cantidad > 0 && $i1->cantidad != ""){
            $cantidad_gerenciales = 1;
		}
        
        $comerciales = RespuestaEncuesta::query();
		$comerciales->select(DB::raw('COUNT(respuesta_encuesta.texto_respuesta_encuesta::INTEGER) as cantidad'));
		$comerciales->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$comerciales->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$comerciales->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$comerciales->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$comerciales->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$comerciales->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7263);
		$comerciales->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269,7270,7271, 7272]);
		$comerciales->whereIn(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::varchar(255)'), ['112']);
        $i2 = $comerciales->first(); 

        if($i2->cantidad > 0 && $i2->cantidad != ""){
            $cantidad_comerciales = 1;
        }
        
        $total_obligatorias = $cantidad_gerenciales + $cantidad_comerciales;
        
        $creativas = RespuestaEncuesta::query();
		$creativas->select(DB::raw('COUNT(respuesta_encuesta.texto_respuesta_encuesta::INTEGER) as cantidad'));
		$creativas->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$creativas->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$creativas->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$creativas->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$creativas->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$creativas->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7263);
		$creativas->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269,7270,7271, 7272]);
		$creativas->whereIn(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::varchar(255)'), ['116']);
        $i3 = $creativas->first();

        if($i3->cantidad > 0 && $i3->cantidad != ""){
            $cantidad_creativas = 1;
		}
        
        $tecnicas = RespuestaEncuesta::query();
		$tecnicas->select(DB::raw('COUNT(respuesta_encuesta.texto_respuesta_encuesta::INTEGER) as cantidad'));
		$tecnicas->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$tecnicas->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$tecnicas->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$tecnicas->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$tecnicas->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$tecnicas->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7263);
		$tecnicas->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269,7270,7271, 7272]);
		$tecnicas->whereIn(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::varchar(255)'), ['113']);
        $i4 = $tecnicas->first();
        
        if($i4->cantidad > 0 && $i4->cantidad != ""){
            $cantidad_tecnicas = 1;
        }

        if($cantidad_creativas > 0){
            $total_opcionales = 1;
        }else if($cantidad_tecnicas > 0){
            $total_opcionales = 1;
        }
        
        $total_perfiles = $total_obligatorias + $total_opcionales;

		if ($total_perfiles == 3) {
			$score = '2.00';
		} else if ($total_perfiles == 2) {
			$score = '1.00';
		} else {
			$score = '0.0';
		}

		return $score;
	}

	public static function getGenderAldea20__three__moment__equipo($register) {
		$query = RespuestaEncuesta::query();
		$query->select(DB::raw('COUNT(respuesta_encuesta.texto_respuesta_encuesta::INTEGER) as gender'));
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7252);
		$query->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269, 7270, 7271, 7272]);
		$query->where(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::varchar(255)'), '=', '85');
		$data = $query->first();
		$hombre = 0;
		if($data->gender != 0 && $data->gender != ""){
			$hombre = 1;
		}

		$query = "";

		$query = RespuestaEncuesta::query();
		$query->select(DB::raw('COUNT(respuesta_encuesta.texto_respuesta_encuesta::INTEGER) as gender'));
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $register);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_pregunta_encuesta', '=', 4373);
		$query->where('respuesta_encuesta.codigo_opcion_encuesta', '=', 7252);
		$query->whereIn('respuesta_encuesta.cor_codigo_opcion_encuesta', [7269, 7270, 7271, 7272]);
		$query->where(DB::raw('respuesta_encuesta.texto_respuesta_encuesta::varchar(255)'), '=', '86');
		$data1 = $query->first();

		$mujer = 0;
		if($data1->gender != 0 && $data1->gender != ""){
			$mujer = 1;
		}

		$total = $mujer + $hombre;

		if ($total == 2) {
			$data = '1.00';
		} else {
			$data = '0.0';
		}

		return $data;
	}

	public static function Calificacion__Aldea20__three_moment__equipo($register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
		$query->select(
			'opc_eval_pregunta.nombre_opc_eval_pregunta', 'resultado_evaluacion_emprendimiento.comentario_resultado_evaluacion',
			'opc_eval_pregunta.valor_opc_eval_pregunta as total_scoring',
			DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')	) as nombre_usuario")
		);

		// Get items
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=','resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');

		// Get user information
		$query->leftJoin('seguridad.usuario', 'usuario.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');
		$query->leftJoin('core.persona', 'persona.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');

		$query->where('asignacion_jurado.codigo_registro_fase_usuario', '=', $register);
		$query->where('opc_eval_pregunta.codigo_grup_opc_eval_pregunta', '=', 84);
		$query->where('evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 177);

		return $query->get();
	}

	public static function getScoring__Aldea20__Moment__Three(RegistroFaseUsuario $register) {
		try {
			$userSurvey = UsuarioEncuesta::select('usuario_encuesta.codigo_usuario_encuesta')->join('core.registro_convocatoria', 'registro_convocatoria.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta')->where('registro_convocatoria.codigo_registro_convocatoria', '=', $register->codigo_registro_convocatoria)->first();
			if(!$userSurvey instanceof UsuarioEncuesta) {
				abort(404);
				Log::error(sprintf('%s:%s', 'Usuario Encuesta not found', $e->getMessage()));
			}

			// Innovacion
			$propiedad_innovacion = Innpulsa::getResponseEvaluationAldea20__three__moment__innovacion($userSurvey->codigo_usuario_encuesta, 'propiedad');
			$motivo_innovacion = Innpulsa::getResponseEvaluationAldea20__three__moment__innovacion($userSurvey->codigo_usuario_encuesta, 'motivo');
			$tipo_innovacion = Innpulsa::getResponseEvaluationAldea20__three__moment__innovacion($userSurvey->codigo_usuario_encuesta, 'tipo');
			$calificacion_innovacion = Innpulsa::Calificacion__Aldea20__three_moment__innovacion($register->codigo_registro_fase_usuario);
			$total_innovacion = ( ( isset($propiedad_innovacion->propiedad_score) ? $propiedad_innovacion->propiedad_score : 0 ) + ( isset($motivo_innovacion->motivo_score) ? $motivo_innovacion->motivo_score : 0 ) + ( isset($tipo_innovacion->tipo_score) ? $tipo_innovacion->tipo_score : 0 ) );

			$total_cal_innovacion = 0;
			if (count($calificacion_innovacion) > 0) {
				foreach($calificacion_innovacion as $cal) {
					$total_cal_innovacion = $total_cal_innovacion + $cal->total_scoring;
				}
			}

			$total_innovacion = $total_innovacion + ($total_cal_innovacion * 0.6);
			$total_innovacion_res = $total_innovacion * 0.3;

			// Escalabilidad

			$idioma_escalabilidad = Innpulsa::getResponseEvaluationAldea20__three__moment__escalabilidad($userSurvey->codigo_usuario_encuesta, 'idioma');
			$metas_escalabilidad = Innpulsa::getResponseEvaluationAldea20__three__moment__escalabilidad($userSurvey->codigo_usuario_encuesta, 'metas');
			$calificacion_escalabilidad = Innpulsa::Calificacion__potential__Aldea20__three_moment__equipo($register->codigo_registro_fase_usuario);
			$total_escalabilidad = ( ( isset($idioma_escalabilidad->idioma_score) ? $idioma_escalabilidad->idioma_score : 0 ) + ( isset($metas_escalabilidad->metas_score) ? $metas_escalabilidad->metas_score : 0 ) );

			$total_cal_escalabilidad = 0;
			if (count($calificacion_escalabilidad) > 0) {
				foreach($calificacion_escalabilidad as $cal) {
					$total_cal_escalabilidad = $total_cal_escalabilidad + $cal->total_score;
				}
			}

			$total_escalabilidad = $total_escalabilidad + ($total_cal_escalabilidad * 0.8);
			$total_escalabilidad_res = $total_escalabilidad * 0.15;

			 // Traccion

			$alcance_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'alcance');
			$cuentas_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'cuentas');
			$estados_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'estados');
			$indicadores_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'indicadores');
			$calificacion_traccion = Innpulsa::Calificacion__Aldea20__three_moment__traccion($register->codigo_registro_fase_usuario);
			$total_traccion = ( ( isset($alcance_traccion->alcance_score) ? $alcance_traccion->alcance_score : 0 ) + ( isset($cuentas_traccion->cuentas_score) ? $cuentas_traccion->cuentas_score : 0 ) + ( isset($estados_traccion->estados_score) ? $estados_traccion->estados_score : 0 ) + ( isset($indicadores_traccion->indicadores_score) ? $indicadores_traccion->indicadores_score : 0 ) );

			$total_cal_traccion = 0;
			if (count($calificacion_traccion) > 0) {
				foreach($calificacion_traccion as $cal_t) {
					$total_cal_traccion += (double)$cal_t->total_scoring;
				}
			}

			$total_traccion = $total_traccion + ( round($total_cal_traccion * 0.45, 2) );
			$total_traccion_res = $total_traccion * 0.1;

			// Equipo
			$experiencia_laboral_equipo = Innpulsa::getResponseEvaluationAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta, 'laboral');
			$experiencia_sector_equipo = Innpulsa::getSectorExprerienceAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$experiencia_emprendedora_equipo = Innpulsa::getEmprendorExprerienceAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$roles_equipo = Innpulsa::getRolesAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$genero_equipo = Innpulsa::getGenderAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$riesgo_equipo = Innpulsa::getResponseEvaluationAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta, 'riesgo');
			$decisiones_equipo = Innpulsa::getResponseEvaluationAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta, 'decisiones');
			$calificacion_equipo = Innpulsa::Calificacion__Aldea20__three_moment__equipo($register->codigo_registro_fase_usuario);
			$total_equipo = ( ( isset($experiencia_laboral_equipo->laboral_score) ? $experiencia_laboral_equipo->laboral_score : 0 ) + ( isset($experiencia_sector_equipo['sector_scoring']) ? $experiencia_sector_equipo['sector_scoring'] : 0 ) + ( isset($experiencia_emprendedora_equipo['emprendor_scoring']) ? $experiencia_emprendedora_equipo['emprendor_scoring'] : 0 ) + ( isset($roles_equipo) ? $roles_equipo : 0 ) + ( isset($genero_equipo) ? $genero_equipo : 0 ) + ( isset($riesgo_equipo->riesgo_score) ? $riesgo_equipo->riesgo_score : 0 ) + ( isset($decisiones_equipo->decisiones_score) ?  $decisiones_equipo->decisiones_score : 0 ) );

			$total_cal_equipo= 0;
			if (count($calificacion_equipo) > 0) {
				foreach($calificacion_equipo as $cal) {
					$total_cal_equipo = $total_cal_equipo + (int)$cal->total_scoring;
				}
			}

			$total_equipo = $total_equipo + ($total_cal_equipo * 0.3);
			$total_equipo_res = $total_equipo * 0.45;

			$total_score = ( $total_equipo_res + $total_traccion_res + $total_escalabilidad_res + $total_innovacion_res );
			$total_score_res = $total_score * 10;

			return $total_score_res;
		} catch (\Exception $e) {
			Log::error(sprintf('%s:%s', 'Innpulsa notification', $e->getMessage()));
		}
	}

	public static function get__Aldea20__IndicatorsTotalScore_1_3(RegistroFaseUsuario $register) {
		try {
			$userSurvey = UsuarioEncuesta::select('usuario_encuesta.codigo_usuario_encuesta')->join('core.registro_convocatoria', 'registro_convocatoria.codigo_usuario_encuesta', '=', 'usuario_encuesta.codigo_usuario_encuesta')->where('registro_convocatoria.codigo_registro_convocatoria', '=', $register->codigo_registro_convocatoria)->first();
			if(!$userSurvey instanceof UsuarioEncuesta) {
				abort(404);
				Log::error(sprintf('%s:%s', 'Usuario Encuesta not found', $e->getMessage()));
			}

			// Innovacion
			$propiedad_innovacion = Innpulsa::getResponseEvaluationAldea20__three__moment__innovacion($userSurvey->codigo_usuario_encuesta, 'propiedad');
			$motivo_innovacion = Innpulsa::getResponseEvaluationAldea20__three__moment__innovacion($userSurvey->codigo_usuario_encuesta, 'motivo');
			$tipo_innovacion = Innpulsa::getResponseEvaluationAldea20__three__moment__innovacion($userSurvey->codigo_usuario_encuesta, 'tipo');
			$calificacion_innovacion = Innpulsa::Calificacion__Aldea20__three_moment__innovacion($register->codigo_registro_fase_usuario);
			$total_innovacion = ( ( isset($propiedad_innovacion->propiedad_score) ? $propiedad_innovacion->propiedad_score : 0 ) + ( isset($motivo_innovacion->motivo_score) ? $motivo_innovacion->motivo_score : 0 ) + ( isset($tipo_innovacion->tipo_score) ? $tipo_innovacion->tipo_score : 0 ) );

			$total_cal_innovacion = 0;
			if (count($calificacion_innovacion) > 0) {
				foreach($calificacion_innovacion as $cal) {
					$total_cal_innovacion = $total_cal_innovacion + $cal->total_scoring;
				}
			}

			$total_innovacion = $total_innovacion + ($total_cal_innovacion * 0.6);
			$total_innovacion_res = $total_innovacion * 0.3;

			// Escalabilidad

			$idioma_escalabilidad = Innpulsa::getResponseEvaluationAldea20__three__moment__escalabilidad($userSurvey->codigo_usuario_encuesta, 'idioma');
			$metas_escalabilidad = Innpulsa::getResponseEvaluationAldea20__three__moment__escalabilidad($userSurvey->codigo_usuario_encuesta, 'metas');
			$calificacion_escalabilidad = Innpulsa::Calificacion__potential__Aldea20__three_moment__equipo($register->codigo_registro_fase_usuario);
			$total_escalabilidad = ( ( isset($idioma_escalabilidad->idioma_score) ? $idioma_escalabilidad->idioma_score : 0 ) + ( isset($metas_escalabilidad->metas_score) ? $metas_escalabilidad->metas_score : 0 ) );

			$total_cal_escalabilidad = 0;
			if (count($calificacion_escalabilidad) > 0) {
				foreach($calificacion_escalabilidad as $cal) {
					$total_cal_escalabilidad = $total_cal_escalabilidad + $cal->total_score;
				}
			}

			$total_escalabilidad = $total_escalabilidad + ($total_cal_escalabilidad * 0.8);
			$total_escalabilidad_res = $total_escalabilidad * 0.15;

			 // Traccion

			$alcance_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'alcance');
			$cuentas_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'cuentas');
			$estados_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'estados');
			$indicadores_traccion = Innpulsa::getResponseEvaluationAldea20__three__moment__traccion($userSurvey->codigo_usuario_encuesta, 'indicadores');
			$calificacion_traccion = Innpulsa::Calificacion__Aldea20__three_moment__traccion($register->codigo_registro_fase_usuario);
			$total_traccion = ( ( isset($alcance_traccion->alcance_score) ? $alcance_traccion->alcance_score : 0 ) + ( isset($cuentas_traccion->cuentas_score) ? $cuentas_traccion->cuentas_score : 0 ) + ( isset($estados_traccion->estados_score) ? $estados_traccion->estados_score : 0 ) + ( isset($indicadores_traccion->indicadores_score) ? $indicadores_traccion->indicadores_score : 0 ) );

			$total_cal_traccion = 0;
			if (count($calificacion_traccion) > 0) {
				foreach($calificacion_traccion as $cal_t) {
					$total_cal_traccion += (double)$cal_t->total_scoring;
				}
			}

			$total_traccion = $total_traccion + ( round($total_cal_traccion * 0.45, 2) );
			$total_traccion_res = $total_traccion * 0.1;

			// Equipo
			$experiencia_laboral_equipo = Innpulsa::getResponseEvaluationAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta, 'laboral');
			$experiencia_sector_equipo = Innpulsa::getSectorExprerienceAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$experiencia_emprendedora_equipo = Innpulsa::getEmprendorExprerienceAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$roles_equipo = Innpulsa::getRolesAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$genero_equipo = Innpulsa::getGenderAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta);
			$riesgo_equipo = Innpulsa::getResponseEvaluationAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta, 'riesgo');
			$decisiones_equipo = Innpulsa::getResponseEvaluationAldea20__three__moment__equipo($userSurvey->codigo_usuario_encuesta, 'decisiones');
			$calificacion_equipo = Innpulsa::Calificacion__Aldea20__three_moment__equipo($register->codigo_registro_fase_usuario);
			$total_equipo = ( ( isset($experiencia_laboral_equipo->laboral_score) ? $experiencia_laboral_equipo->laboral_score : 0 ) + ( isset($experiencia_sector_equipo['sector_scoring']) ? $experiencia_sector_equipo['sector_scoring'] : 0 ) + ( isset($experiencia_emprendedora_equipo['emprendor_scoring']) ? $experiencia_emprendedora_equipo['emprendor_scoring'] : 0 ) + ( isset($roles_equipo) ? $roles_equipo : 0 ) + ( isset($genero_equipo) ? $genero_equipo : 0 ) + ( isset($riesgo_equipo->riesgo_score) ? $riesgo_equipo->riesgo_score : 0 ) + ( isset($decisiones_equipo->decisiones_score) ?  $decisiones_equipo->decisiones_score : 0 ) );

			$total_cal_equipo= 0;
			if (count($calificacion_equipo) > 0) {
				foreach($calificacion_equipo as $cal) {
					$total_cal_equipo = $total_cal_equipo + (int)$cal->total_scoring;
				}
			}

			$total_equipo = $total_equipo + ($total_cal_equipo * 0.3);
			$total_equipo_res = $total_equipo * 0.45;

			$total_score = ( $total_equipo_res + $total_traccion_res + $total_escalabilidad_res + $total_innovacion_res );
			$total_score_res = $total_score * 10;

			$object = new \stdClass();
			$object->total_equipo = round($total_equipo_res, 3);
			$object->total_traccion = round($total_traccion_res, 3);
			$object->total_escalabilidad = round($total_escalabilidad_res, 3);
			$object->total_innovacion = round($total_innovacion_res, 3);
			$object->total = round($total_score_res, 3);

			return $object;
		} catch (\Exception $e) {
			Log::error(sprintf('%s:%s', 'Innpulsa notification', $e->getMessage()));
		}
	}

	public static function Calificacion__Aldea20__three_moment__traccion($register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
		$query->select(
			'opc_eval_pregunta.nombre_opc_eval_pregunta', 'resultado_evaluacion_emprendimiento.comentario_resultado_evaluacion',
			'opc_eval_pregunta.valor_opc_eval_pregunta as total_scoring',
			DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')	) as nombre_usuario")
		);

		// Get items
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=','resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');

		// Get user information
		$query->leftJoin('seguridad.usuario', 'usuario.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');
		$query->leftJoin('core.persona', 'persona.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');

		$query->where('asignacion_jurado.codigo_registro_fase_usuario', '=', $register);
		$query->where('opc_eval_pregunta.codigo_grup_opc_eval_pregunta', '=', 82);
		$query->where('evaluacion_item_emprendimiento.codigo_item_evaluacion', '=', 175);

		return $query->get();
	}

	public static function getScoring__Aldea20__Moment__Four($result) {
		// Get Items Evatualition
		$query = ItemEvaluacionEmprendimiento::query();
		$query->select('item_evaluacion_emprendimiento.codigo_grupo_item_eval','grupo_item_eval.nombre_grupo_item_eval', 'item_evaluacion_emprendimiento.codigo_item_evaluacion', 'item_evaluacion_emprendimiento.codigo_tipo_evaluacion_item','item_evaluacion_emprendimiento.codigo_grup_opc_eval_pregunta', 'item_evaluacion_emprendimiento.nombre_item_evaluacion', 'nombre_grup_opc_eval_pregunta');
		$query->leftJoin('core.grup_opc_eval_pregunta', 'item_evaluacion_emprendimiento.codigo_grup_opc_eval_pregunta', '=', 'grup_opc_eval_pregunta.codigo_grup_opc_eval_pregunta');
		$query->leftJoin('core.grupo_item_eval', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval', '=', 'grupo_item_eval.codigo_grupo_item_eval');
		$query->where('item_evaluacion_emprendimiento.codigo_estado', '=', Estado::getState('active'));
		$query->where('codigo_evaluacion_emprendimiento', $result->codigo_evaluacion_emprendimiento);
		$query->orderBy('item_evaluacion_emprendimiento.orden_item_eval_emprendi','asc');
		$arItems = $query->get();

		// Groups Item Evaluation
		$query = GrupoItemEval::query();
		$query->select('texto_comentario_documentador','item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval', 'promedio_conmutado');
		$query->join('core.item_evaluacion_emprendimiento', 'grupo_item_eval.codigo_grupo_item_eval', '=', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval');

		$query->leftjoin('core.comen_documentador', function($join) use($result){
			$join->on('comen_documentador.codigo_grupo_item_eval', '=', 'grupo_item_eval.codigo_grupo_item_eval')
				->where('comen_documentador.codigo_estado', '=', Estado::getState('active'))
				->where('comen_documentador.codigo_registro_fase_usuario', '=', $result->codigo_registro_fase_usuario);
        });

		$query->where('codigo_evaluacion_emprendimiento', $result->codigo_evaluacion_emprendimiento);
		$query->where('item_evaluacion_emprendimiento.codigo_estado', Estado::getState('active'));
		$query->orderBy('grupo_item_eval.orden_grupo_item_eval','asc');
		$query->groupBy('grupo_item_eval.codigo_grupo_item_eval','item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval','texto_comentario_documentador');
		$groups = $query->get();

		$query = EvaluacionItemEmprendimiento::query();
		$query->select('asignacion_jurado.codigo_usuario', 'evaluacion_item_emprendimiento.codigo_item_evaluacion', 'valor_evaluacion_item', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval', DB::raw('COALESCE(opc_eval_pregunta.valor_opc_eval_pregunta, 0) AS valor_opc_eval_pregunta'));
		$query->join('core.item_evaluacion_emprendimiento', 'item_evaluacion_emprendimiento.codigo_item_evaluacion', '=', 'evaluacion_item_emprendimiento.codigo_item_evaluacion');
		$query->leftJoin('core.opc_eval_pregunta', 'evaluacion_item_emprendimiento.valor_evaluacion_item', '=', 'opc_eval_pregunta.codigo_opc_eval_pregunta');
        $query->join('core.resultado_evaluacion_emprendimiento', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion', '=', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion');
		$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
		$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
		$query->join('core.registro_convocatoria', 'registro_convocatoria.codigo_registro_convocatoria', '=', 'registro_fase_usuario.codigo_registro_convocatoria');
		$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', $result->codigo_evaluacion_emprendimiento);
		$query->where('registro_convocatoria.codigo_registro_convocatoria', $result->codigo_registro_convocatoria);
		$califications = $query->get();

		// Experts
		$query = AsignacionJurado::query();
		$query->select('asignacion_jurado.codigo_usuario', 'usuario.nombre_usuario', 'fecha_resultado_evaluacion', 'hora_resultado_evaluacion');
		$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
		$query->join('seguridad.usuario', 'usuario.codigo_usuario', '=', 'asignacion_jurado.codigo_usuario');
		$query->leftJoin('core.resultado_evaluacion_emprendimiento', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado', '=', 'asignacion_jurado.codigo_asignacion_jurado');
		$query->where('registro_fase_usuario.codigo_registro_fase_usuario',  $result->codigo_registro_fase_usuario);
		$query->where('asignacion_jurado.codigo_estado', '!=',  Estado::getState('removed'));
		$experts = $query->get();

		$total = 0;
		foreach ($groups as $group) {
			$itemsEval = $arItems->where('codigo_grupo_item_eval', $group->codigo_grupo_item_eval);
			if($itemsEval->count() > 0) {
				foreach ($itemsEval as $itemeval) {
					// Porcentajes
					foreach ($experts as $expert) {
						unset($calification);

						$itemx = new \stdClass();
						$itemx->codigo_usuario = $expert->codigo_usuario;
						$calification = $califications->where('codigo_usuario', $expert->codigo_usuario)->where('codigo_item_evaluacion', $itemeval->codigo_item_evaluacion)->where('codigo_grupo_item_eval', $group->codigo_grupo_item_eval)->first();
						$valor_experto = 0;

						if($calification instanceof EvaluacionItemEmprendimiento) {

							if ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('innovation_component')]) ) {
								$valor_experto = round((($calification->valor_opc_eval_pregunta * 0.32) * 10), 2);
								$total += $valor_experto;
							}
							elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('market_2020')]) ) {
								$valor_experto = round((($calification->valor_opc_eval_pregunta * 0.11) * 10), 2);
								$total += $valor_experto;
							}
							elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team_2020')]) ) {
								switch ($calification->codigo_item_evaluacion) {
									case 182:
										$valor_experto = round((($calification->valor_opc_eval_pregunta * 0.10) * 10), 2);
									break;
									case 183:
										$valor_experto = round((($calification->valor_opc_eval_pregunta * 0.05) * 10), 2);
									break;
								}
								$total += $valor_experto;
							}
							elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('objetives')]) ) {
								$valor_experto = round(((($calification->valor_opc_eval_pregunta * 0.12) * 100) / 12), 2);
								$total += $valor_experto;
							}
							elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('recomendations')]) ) {
								$valor_experto = round(((($calification->valor_opc_eval_pregunta * 0.08) * 100) / 8), 2);
								$total += $valor_experto;
							}
						}
					}
				}
			}
		}

		$total = $total / 3;
		$score_total = PuntajeRegistroFase::where('codigo_registro_fase_usuario', $result->codigo_registro_fase_usuario)->first();
		if($score_total instanceof PuntajeRegistroFase) {
			$score_total->valor_puntaje_registro_fase = round($total, 2);
			$score_total->save();
		} else {
			$score_total_new = new PuntajeRegistroFase();
			$score_total_new->codigo_registro_fase_usuario = $result->codigo_registro_fase_usuario;
			$score_total_new->codigo_estado = Estado::getState('active');
			$score_total_new->valor_puntaje_registro_fase = round($total, 2);
			$score_total_new->save();
		}
	}

	public static function validFirstChallengeAldea(UsuarioEncuesta $userSurvey, $request)
	{
		$response = new \stdClass();
		$response->success = true;

		// Get user entity
		$query = Usuario::query();
		$query->select('entidad.codigo_entidad', 'entidad.codigo_usuario', 'entidad.codigo_clase_empre_insti');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where('usuario.codigo_usuario', $userSurvey->codigo_usuario);
		$user = $query->first();

		if(!$user instanceof Usuario) {
			$response->success = false;
			$response->data = trans('app.exception');
			return $response;
		}

		// Validacion inconsistencia empresa
		if(isset($request['current_page']) && $request['current_page'] == 1) {
			if($user->codigo_clase_empre_insti == 1) {
				// Numero contacto
				if(isset($request['pregunta_4263_opcion']) && (trim($request['pregunta_4263_opcion']) == '')) {
					$response->success = false;
					$response->data = "Debe seleccionar el tipo de emprendimiento que quieres postular";
					return $response;
				}
				else{
					if($request['pregunta_4263_opcion'] == 7015){
						$response->success = false;
						$response->data = "Seleccionaste un proyecto para aplicar, pero en el formulario estas indicando que eres una empresa. Por favor valida en el paso anterior ".$request['pregunta_4263_opcion'];
						return $response;
					}
				}
			}
		}

		// Validadación equipo
		if(isset($request['current_page']) && $request['current_page'] == 5) {
			$lider = trim($request['pregunta_4373_opcion_7251_campo_7269']);
			$integrante1 = trim($request['pregunta_4373_opcion_7251_campo_7270']);
			$integrante2 = trim($request['pregunta_4373_opcion_7251_campo_7271']);
			$integrante3 = trim($request['pregunta_4373_opcion_7251_campo_7272']);

			if($lider != ""){
				$columna_lider = 7251;
				while($columna_lider <= 7268){
					$columna_lider++;
					if(isset($request['pregunta_4373_opcion_'.$columna_lider.'_campo_7269']) && (trim($request['pregunta_4373_opcion_'.$columna_lider.'_campo_7269']) == '')){
						$response->success = false;
						$response->data = "Faltan completar campos de para el integrante ".$lider;
						return $response;
					}
				}
			}
			else{
				$response->success = false;
				$response->data = "Se debe diligenciar por lo menos la información completa de quien lidera";
				return $response;
			}
			if($integrante1 != ""){
				$columna_integrante1 = 7251;
				while($columna_integrante1 <= 7268){
					$columna_integrante1++;
					if(isset($request['pregunta_4373_opcion_'.$columna_integrante1.'_campo_7270']) && (trim($request['pregunta_4373_opcion_'.$columna_integrante1.'_campo_7270']) == '')){
						$response->success = false;
						$response->data = "Faltan completar campos de para el integrante ".$integrante1;
						return $response;
					}
				}
			}
			if($integrante2 != ""){
				$columna_integrante2 = 7251;
				while($columna_integrante2 <= 7268){
					$columna_integrante2++;
					if(isset($request['pregunta_4373_opcion_'.$columna_integrante2.'_campo_7271']) && (trim($request['pregunta_4373_opcion_'.$columna_integrante2.'_campo_7271']) == '')){
						$response->success = false;
						$response->data = "Faltan completar campos de para el integrante ".$integrante2;
						return $response;
					}
				}
			}
			if($integrante3 != ""){
				$columna_integrante3 = 7251;
				while($columna_integrante3 <= 7268){
					$columna_integrante3++;
					if(isset($request['pregunta_4373_opcion_'.$columna_integrante3.'_campo_7272']) && (trim($request['pregunta_4373_opcion_'.$columna_integrante3.'_campo_7272']) == '')){
						$response->success = false;
						$response->data = "Faltan completar campos de para el integrante ".$integrante3;
						return $response;
					}
				}
			}
		}

		return $response;
	}

	public static function getExtraQuestionsEvaluation($evaluation) {
		// Get Answers
		$query = RespuestaEncuesta::query();
		$query->select('pregunta_encuesta.codigo_pregunta_encuesta', 'respuesta_encuesta.texto_respuesta_encuesta', 'respuesta_encuesta.codigo_opcion_encuesta', 'respuesta_encuesta.cor_codigo_opcion_encuesta');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('pregunta_encuesta.codigo_encuesta', $evaluation->codigo_encuesta);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $evaluation->codigo_usuario_encuesta);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
		$answers = $query->get();

		$query = AgrupacionPreguntasEval::query();
		$query->select('pregunta_encuesta.*', 'sigla_moneda', 'agrupacion_preguntas_eval.codigo_evaluacion_emprendimiento');
		$query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'agrupacion_preguntas_eval.codigo_pregunta_encuesta');
		$query->leftJoin('core.moneda', 'pregunta_encuesta.codigo_moneda', '=', 'moneda.codigo_moneda');
		$query->where('agrupacion_preguntas_eval.codigo_evaluacion_emprendimiento', $evaluation->codigo_evaluacion_emprendimiento);
		$query->where('agrupacion_preguntas_eval.codigo_estado', '=', Estado::getState('active'));
		$query->orderBy('agrupacion_preguntas_eval.orden_agru_preg_eval', 'ASC');
		$argquestions = $query->get();

		$questions = [];
		foreach($argquestions as $item) {
			$object = new \stdClass();
			$object->codigo_pregunta_encuesta = $item->codigo_pregunta_encuesta;
			$object->texto_pregunta_encuesta = $item->texto_pregunta_encuesta;
			$object->texto_opcional_pregunta = $item->texto_opcional_pregunta;
			$object->tipo_pregunta_encuesta = $item->tipo_pregunta_encuesta;
			$object->titulo_opciones_pregunta = $item->titulo_opciones_pregunta;
			$object->tipo_campo_pregunta = $item->tipo_campo_pregunta;
			$object->sigla_moneda = $item->sigla_moneda;
			$object->numero_pregunta_encuesta = $item->numero_pregunta_encuesta;

			$respuesta = [];
			// Build answer
			if($answers instanceof Collection) {
				$respuesta = RespuestaEncuesta::buildAnswer($answers, $item->tipo_pregunta_encuesta, $item->codigo_pregunta_encuesta);
			}

			// Options questions closed, unique or mulplique answer (y-axis)
			if(in_array($item->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('single'), PreguntaEncuesta::getType('multiple'), PreguntaEncuesta::getType('matriz')])) {
				// Choices closed questions
				$arChoicesy = OpcionPreguntaEncuesta::where('codigo_pregunta_encuesta',$item->codigo_pregunta_encuesta)->where('codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')->get();

				if($arChoicesy->count() > 0) {
					$options = [];
					foreach ($arChoicesy as $choice) {
						$choiceItem = new \stdClass();
						$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
						$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
						$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
						$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
						$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
						$choiceItem->codigo_pregunta_encuesta = $choice->codigo_pregunta_encuesta;
						if($choice->calculado_opcion_encuesta == true){
							$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
						}

						$options[] = $choiceItem;
					}
				}
			}

			// Options questions matriz (x-axis)
			$campos_opciones = [];
			if(in_array($item->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('matriz')])) {
				// Choices closed questions
				$arChoicesx = OpcionPreguntaEncuesta::where('eje_opcion', OpcionPreguntaEncuesta::getAxis('x'))
				->where('codigo_pregunta_encuesta', $item->codigo_pregunta_encuesta)
				->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')
				->get();
				if($arChoicesx->count() > 0) {
					foreach ($arChoicesx as $choice) {
						$choiceItem = new \stdClass();
						$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
						$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
						$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
						$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
						$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
						if($choice->calculado_opcion_encuesta == true){
							$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
						}
						$campos_opciones[] = $choiceItem;
					}
				}
			}

			$agrupaciones = [];
			$query = AgrupacionItemEval::query();
			$query->select('agrupacion_item_ejex', 'agrupacion_item_ejey');
			$query->where('codigo_pregunta_encuesta', $item->codigo_pregunta_encuesta);
			$query->where('agrupacion_item_eval.codigo_estado', Estado::getState('active'));
			$agrupaciones = $query->get();

			$object->respuesta = $respuesta;
			$object->agrupaciones = isset($agrupaciones) ? $agrupaciones : null;
			$object->opciones = isset($options) ? $options : null;
			$object->campos_opciones = isset($campos_opciones) ? $campos_opciones : null;

			$questions[] = $object;
		}

		return $questions;
	}
}
