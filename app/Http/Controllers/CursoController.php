<?php

namespace App\Http\Controllers;

use App\UsuarioEncuesta;
use App\Estado;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Like;
use App\RegistroSesion;
use Request, Response, Auth, Input, DB, TuProyecto, App, AWS;

use App\Curso, App\InscripcionCurso;

class CursoController extends Controller {

    /**
     * Instantiate a new CursoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'showUrl']]);
		$this->middleware('intended', ['only' => ['index', 'showUrl']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if(Request::ajax()){
			return Response::json(Curso::getCourses( Request::all() ));
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
	public function update($id)
	{
		if (Request::ajax()) {
			$data = Input::all();
			DB::beginTransaction();
			try {
				// Decrypt src-params
				list($codigo_curso, $id_recurso) = TuProyecto::decryptSrcParams(Input::get('srcparams'));
				if(!$codigo_curso || !is_numeric($codigo_curso)) {
					throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_curso']));
				}
				if(!$id_recurso || !is_numeric($id_recurso)) {
					throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso']));
				}

				$query = Like::query();
				$query->where('like.codigo_recurso_modulo', $codigo_curso);
				$query->where('like.id_recurso', $id_recurso);
				$query->where('like.codigo_usuario', Auth::user()->codigo_usuario);
				$query->where('like.codigo_estado', Estado::getState('active'));
				$query->where('like.codigo_institucion', RegistroSesion::getInstitution());
				$like = $query->first();

				if(!$like instanceof Like) {
					// Like
					$like = new Like;
					$like->codigo_recurso_modulo = $codigo_curso;
					$like->id_recurso = $id_recurso;
					$like->codigo_estado = Estado::getState('active');
					$like->codigo_usuario = Auth::user()->codigo_usuario;
					$like->fecha_like = date('Y-m-d');
					$like->hora_like = date('H:i:s');
					$like->codigo_institucion = RegistroSesion::getInstitution();
					$like->save();

					// Gamification (Depending of resource)
					// $object = Like::getResourceLike($like->id_recurso, $like->codigo_recurso_modulo);
					// if(!is_null($object) && !is_null($object->gamification_class) && !is_null($object->resource)){
					// 	PuntoUsuario::gamification($object->gamification_class, Estado::getState('active'), $object->resource->codigo_usuario, $like->codigo_like);
					// }
				}

				// Prepare response
				$response = Like::buildLike($like);
				$response->success = true;

				// Commit Transaction
				DB::commit();

				// Get count likes
				$response->contador_like = Like::contador($like);
				return Response::json($response);

			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => $e->getMessage()]);
			}
		}
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
	public function showUrl($course)
	{
		$course = Curso::getCourseUrl($course);
		if(!$course instanceof Curso) {
            abort(404);
		}
		if (Request::ajax()) {

			return Response::json(Curso::buildCourse($course));
		}
		return view('core/learn/main');
	}

	/**
	 * Generate certificate
	 */
	public function certificate() {
		// Decrypt src-params
		list($codigo_curso) = TuProyecto::decryptSrcParams(Request::get('data'));
		$course = Curso::find($codigo_curso);
		if (!$course instanceof Curso) {
			return Response::json(['success' => false, 'errors' => 'No se encontro el curso']);
		}

		$data = [];
		$data['title'] = "Certificado";
		$data['userName'] = Auth::user()->nombre_usuario.' '.Auth::user()->primer_apellido_usuario_v1;
		$data['course'] = $course->nombre_curso;

		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML(view('reports.courses.course', $data))->setPaper('a4', 'landscape');

		$s3 = AWS::createClient('s3');

		$bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');

		$filename = sprintf('%s_%s_%s_%s.pdf', 'certificado_', $course->nombre_curso.'_', Auth::user()->codigo_usuario.'_', RegistroSesion::getInstitution());
		$key = sprintf('%s/%s/%s/%s', 'documents', 'certificados', 'cursos', $filename);

		$result = $s3->putObject([
			'Bucket' =>  $bucket,
			'Key'    =>  $key,
			'Body'   =>  $pdf->output(),
			'ACL'    => 'public-read'
		]);

		return Response::json(['success' => true, 'url' => $result['ObjectURL']]);
	}

	/* Certificate Total| */

	public function certificateTotal() {
		$dataCourse = Curso::getTotalCertificate();
		$date = $dataCourse['date'];
		$data = [];
		$data['title'] = "Certificado";
		$data['userName'] = Auth::user()->nombre_usuario.' '.Auth::user()->primer_apellido_usuario_v1;
		$data['course'] = transtp('learn.type.courses');
		$data['date'] = $date;
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML(view('reports.courses.course', $data))->setPaper('A4', 'landscape');

		$s3 = AWS::createClient('s3');

		$bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');

		$filename = sprintf('%s_%s_%s_%s.pdf', 'certificado_', transtp('learn.type.courses').'_', Auth::user()->codigo_usuario.'_', RegistroSesion::getInstitution());
		$key = sprintf('%s/%s/%s/%s', 'documents', 'certificados', 'cursos', $filename);

		$result = $s3->putObject([
			'Bucket' =>  $bucket,
			'Key'    =>  $key,
			'Body'   =>  $pdf->output(),
			'ACL'    => 'public-read'
		]);

		return Response::json(['success' => true, 'url' => $result['ObjectURL']]);
	}
}
