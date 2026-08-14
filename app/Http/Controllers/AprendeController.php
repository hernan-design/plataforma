<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View, Auth, App, Log, DB;


use App\Curso, App\CategoriaCurso, App\InscripcionCurso, App\Encuesta, App\UsuarioEncuesta, App\EstadoAdjuntoUsuario, App\Estado;

class AprendeController extends Controller {

	/**
     * Instantiate a new ProyectoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'showUrl', 'filterCategory', 'showCategoryCourse']]);
		$this->middleware('intended', ['only' => ['index', 'showUrl', 'filterCategory', 'showCategoryCourse']]);
		$this->middleware('subscription', ['only' => ['showCategoryCourse']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()){
			dd(Curso::getCourses());
			return Response::json(Curso::getCourses());
		}
		return view('core/learn/main');
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
	public function show(Request $request,$url)
	{
		if ($request->ajax()) {
			$course = Curso::getCourseUrl($url);

			if(!$course instanceof Curso) {
	            App::abort(404);
			}
			return Response::json(Curso::buildCourse($course));
		}
		App::abort(404);
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
		//
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

	/**
	* Display the resource from url.
	*
	* @param  String  $course
	* @return Response
	*/
	public function filterCategory($type, $category)
	{
		$category = CategoriaCurso::getCategory($category);
		if(!$category instanceof CategoriaCurso) {
            App::abort(404);
		}
		return view('core/learn/main');
	}

	/**
	* Display the resource from url.
	*
	* @param  String  $course
	* @return Response
	*/
	public function showUrl(Request $request, $course)
	{

		$course = Curso::getCourseUrl($course);
		if(!$course instanceof Curso) {
            App::abort(404);
		}
		if ($request->ajax()) {
			return Response::json(Curso::buildCourse($course));
		}

		return view('core/learn/main');
	}

	public function showCategoryCourse($type, $category, $course)
	{
		$course = Curso::getCourseUrl($course, $category);
		if(!$course instanceof Curso) {
            App::abort(404);
		}

		$course= Curso::buildCourse($course);

		return view('core/learn/main', compact('course'));
	}

	public function showContentCourse($type, $category, $course)
	{
		$dataCourse = Curso::getCourseUrl($course, $category);
		if(!$dataCourse instanceof Curso) {
            App::abort(404);
		}

		$registrationCourse = InscripcionCurso::registrationCourse($dataCourse->codigo_curso, Auth::user()->codigo_usuario );
		if(!$registrationCourse instanceof InscripcionCurso) {
			return redirect()->route('aprende.categoria.curso', ['type' => $type, 'category' => $category, 'course' => $course]);
		}

		$data['course'] = Curso::buildCourse($dataCourse);

		return view('core/learn/main', $data);
	}

	public function showCourseThemeClass($type,$category,$course, $theme, $class)
	{
		$dataCourse = Curso::getCourseUrl($course, $category, $theme, $class);
		if(!$dataCourse instanceof Curso) {
            App::abort(404);
		}
		$registrationCourse = InscripcionCurso::registrationCourse($dataCourse->codigo_curso, Auth::user()->codigo_usuario );
		if(!$registrationCourse instanceof InscripcionCurso) {
			return redirect()->route('aprende.categoria.curso', ['type' => $type, 'category' => $category, 'course' => $course]);
		}
		return view('core/learn/main');
    }

	public function biometricValidation($uri)
	{

		//Paso 1: Se conecta al api de melmac para traer el token_api
		// Datos para la solicitud en formato JSON
		$requestData = json_encode([
			'ent' => 2,
			'user' => 'juanjose@tuproyecto.com'
		]);

		// Endpoint del API
		$url = 'https://demomelmac.co/mel-api/api/v2/auth/set/';

		// Iniciar sesión cURL
		$ch = curl_init();

		// Establecer las opciones de la solicitud
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		// Ejecutar la solicitud
		$response = curl_exec($ch);

		// Obtener el código de estado de la respuesta
		// $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$responseAuth = json_decode($response, true);

		// Cerrar la sesión cURL
		curl_close($ch);

		//Se toma la data de la respuesta
		$tokenApi = $responseAuth["data"]["token_api"];


		//Se arma la información para hacer login al servicio
		// Datos para la solicitud en formato JSON
		$requestDataLogin = json_encode([
			'api_key' => $tokenApi,
			'user' => 'juanjose@tuproyecto.com'
		]);

		// Endpoint del API
		$url = 'https://demomelmac.co/mel-api/api/v2/auth/login/';

		// Iniciar sesión cURL
		$ch = curl_init();

		// Establecer las opciones de la solicitud
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataLogin);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		// Ejecutar la solicitud
		$responseLogin = curl_exec($ch);

		// Obtener el código de estado de la respuesta
		// $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$responseAuthLogin = json_decode($responseLogin, true);

		//Se toma el token
		$responseAuthLoginToken = $responseAuthLogin["data"]["token"];

		// Cerrar la sesión cURL
		curl_close($ch);

		// Endpoint del API
		$url = 'https://demomelmac.co/mel-api/api/v2/auth/data/';

		// Iniciar sesión cURL
		$ch = curl_init();

		// Establecer las opciones de la solicitud
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Token ' . $responseAuthLoginToken
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

		// Ejecutar la solicitud
		$responseServiceHash = curl_exec($ch);

		// Manejar errores de cURL
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}

		// Obtener el código de estado de la respuesta
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		// Cerrar la sesión cURL
		curl_close($ch);

		// Decodificar la respuesta JSON
		$responseDataFrame = json_decode($responseServiceHash, true);

		$identificacionUsuario = Auth::user()->identificacion_usuario;

		return view('core/learn/biometric', compact('uri', 'responseDataFrame', 'responseAuthLoginToken', 'identificacionUsuario'));
    }

	public function validationBio(Request $request){
		// Convertir la imagen y el video a base64
		$token = $request->token;
		$hash = $request->hash;

		// Endpoint del API
		$url = 'https://demomelmac.co/mel-api/api/v2/auth/data/'.$hash.'/';

		// Iniciar sesión cURL
		$ch = curl_init();

		// Establecer las opciones de la solicitud
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Token '.$token
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

		// Ejecutar la solicitud
		$response = curl_exec($ch);

		// Obtener el código de estado de la respuesta
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		// Cerrar la sesión cURL
		curl_close($ch);

		// Verificar el código de estado de la respuesta
		// if ($statusCode == 200) {
			return json_decode($response, true);
		// } else {
			// return response()->json(['error' => 'Error en la validación'], $statusCode);
		// }
	}

    public function showCourseThemeSurvey(Request $request,$type,$category,$course, $survey)
	{
        $surveyItem = Encuesta::getCompletedSurveyUrl($survey);
		if(!$surveyItem instanceof Encuesta) {
            Log::error(sprintf('%s:%s', 'AprendeController::showCourseThemeSurvey', 'survey not found'));
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => 'survey not found']);
            }

			abort(404,'Survey not found');
        }

        $codigo_usuario = Auth::user()->codigo_usuario;
        $resource = $surveyItem->getResource($request);
        $userSurvey = null;
        if(!is_null($resource->resource) && !is_null($resource->module)) {
            // Usuario encuesta
            $userSurvey = UsuarioEncuesta::where('codigo_encuesta', $surveyItem->codigo_encuesta)->where('codigo_usuario', $codigo_usuario)->where('codigo_modulo', $resource->module)->where('id_recurso', $resource->resource)->whereNotIn('codigo_estado',[ Estado::getState('inactive'), Estado::getState('removed')])->first();

        }else{
            $errmsg = "survey doesn't belongs to current module or resource";
            Log::error(sprintf('%s:%s', 'AprendeController::showCourseThemeSurvey',$errmsg));
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $errmsg]);
            }

			abort(404,'Survey not found');
        }

       /* if(Auth::check() && $userSurvey instanceof UsuarioEncuesta && $userSurvey->codigo_estado == Estado::getState('complete'))
		{
            if(isset($resource->resource) && !empty($resource->resource)){
                $codigo_adjunto = $resource->resource;

                DB::beginTransaction();
                try {
                    // Estado Adjunto Usuario
                    $attachedUser = EstadoAdjuntoUsuario::stateAttachedUser(Auth::user()->codigo_usuario, $codigo_adjunto);


                    if($attachedUser instanceof EstadoAdjuntoUsuario) {
                        if($attachedUser->codigo_estado == Estado::getState('inactive')){
                            $attachedUser->codigo_estado = Estado::getState('active');
                        }
                    }else{
                        $attachedUser = new EstadoAdjuntoUsuario;
                        $attachedUser->codigo_adjunto = $codigo_adjunto;
                        $attachedUser->codigo_tema_curso = $codigo_tema_curso;
                        $attachedUser->codigo_usuario = Auth::user()->codigo_usuario;
                        $attachedUser->codigo_estado = Estado::getState('active');
                    }
                    $attachedUser->save();

                    // Commit Transaction
                    DB::commit();

                } catch(\Exception $e){
                    DB::rollback();
                    Log::error(sprintf('%s:%s', 'AprendeController::showCourseThemeSurvey',$e->getMessage()));
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                    }
                    abort(404,'Resource not found');
                }
            }

            return redirect()->route('encuesta.revision', ['encuesta' => $surveyItem->url_encuesta, 'usuario' => \TuProyecto::encryptSrcParams([$userSurvey->codigo_usuario_encuesta]) ]);

        }*/

        if($request->has('iframe') && $request->input('iframe'))
        {
            return view('core/survey/surveyiframe');
        }

        return view('core/survey/main');

    }


}
