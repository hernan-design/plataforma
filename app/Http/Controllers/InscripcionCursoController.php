<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, View, Input, Response, Auth, App, Log, Lang;

use TuProyecto;

use App\InscripcionCurso, App\Estado, App\Curso, App\Usuario, App\RegistroSesion;

class InscripcionCursoController extends Controller {

    /**
     * Instantiate a new InscripcionCursoController instance.
     */
    public function __construct()
    {
		$this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()) {
            if($request->has('course')) {
                $course = Curso::getCourseUrl($request->course);
                if(!$course instanceof Curso) {
                    abort(404);
                }
                return response()->json(InscripcionCurso::getRegistrationCourse($course->codigo_curso));
            }
        }
        abort(404);
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
	public function store(Request $request)
	{
		if($request->ajax()) {
			// Decrypt src-params
	        list($codigo_curso) = TuProyecto::decryptSrcParams($request->input('codigo_curso'));
	        if(!$codigo_curso || !is_numeric($codigo_curso)) {
	            App::abort(403);
	        }
			DB::beginTransaction();
        	try {
        		// Curse
				$curse = Curso::find($codigo_curso);

				// Inscripcion Curso
        		$registrationCourse = InscripcionCurso::where('codigo_curso', '=', $codigo_curso)->where('codigo_institucion', '=', RegistroSesion::getInstitution())->where('codigo_usuario', '=', Auth::user()->codigo_usuario)->first();
        		if($registrationCourse instanceof InscripcionCurso) {
        			$registrationCourse->codigo_estado = Estado::getState('active');
        			$registrationCourse->save();

					activity()
						->performedOn($registrationCourse)
						->withProperties([
							'attributes' => [
								'title' => $curse->nombre_curso,
								'user' => Auth::user()->nombre_usuario,
								'user_id' => Auth::user()->codigo_usuario
							] ])
						->log('activitylog.curse.inscription');
        		}else{
	    			$inscripcioncurso = new InscripcionCurso;
					$inscripcioncurso->codigo_curso = $codigo_curso;
		   			$inscripcioncurso->codigo_usuario = Auth::user()->codigo_usuario;
					$inscripcioncurso->codigo_institucion = RegistroSesion::getInstitution();
					$inscripcioncurso->codigo_estado = Estado::getState('active');
		   			$inscripcioncurso->fecha_inscripcion_curso = date('Y-m-d');
		   			$inscripcioncurso->hora_inscripcion_curso = date('H:i:s');
		   			$inscripcioncurso->save();

					activity()
						->performedOn($inscripcioncurso)
						->withProperties([
							'attributes' => [
								'title' => $curse->nombre_curso,
								'user' => Auth::user()->nombre_usuario,
								'user_id' => Auth::user()->codigo_usuario
							] ])
						->log('activitylog.curse.inscription');
	   			}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'inscripcion' => true]);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
			}
		}
    	abort(404);
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
		if($request->ajax()) {
			// Decrypt src-params
	        list($codigo_curso) = TuProyecto::decryptSrcParams($id);
	        if(!$codigo_curso || !is_numeric($codigo_curso)) {
	            App::abort(403);
	        }
			DB::beginTransaction();
        	try {
				// Inscripcion Curso
        		$registrationCourse = InscripcionCurso::where('codigo_curso', '=', $codigo_curso)->where('codigo_institucion', '=', RegistroSesion::getInstitution())->where('codigo_usuario', '=', Auth::user()->codigo_usuario)->first();
        		if($registrationCourse instanceof InscripcionCurso) {
        			$registrationCourse->codigo_estado = Estado::getState('active');
        			$registrationCourse->save();
        		}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'inscripcion' => true]);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
			}
		}
    	abort(404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		if ($request->ajax()) {
            // Decrypt src-params
            list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
	        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
	            App::abort(403);
	        }
            $user = Usuario::find($codigo_usuario);
            if(!$user instanceof Usuario) {
                abort(404);
            }
            $course = Curso::getCourseUrl($request->course);
            if(!$course instanceof Curso) {
                abort(404);
            }

            $registerCourse = InscripcionCurso::registrationCourse($course->codigo_curso, $user->codigo_usuario);
            if(!$registerCourse instanceof InscripcionCurso) {
				abort(404);
			}

            if(Auth::user()->codigo_usuario == $registerCourse->codigo_usuario)
			{
				DB::beginTransaction();
				try {
					if($request->has('inscripcion') && $request->inscripcion == true) {
						$registerCourse->codigo_estado = Estado::getState('inactive');
						$registerCourse->save();

						activity()
							->performedOn($registerCourse)
							->withProperties([
								'attributes' => [
									'title' => $course->nombre_curso,
									'user' => Auth::user()->nombre_usuario,
									'user_id' => Auth::user()->codigo_usuario
								] ])
							->log('activitylog.curse.unsuscribe');
					}
					DB::commit();
					return response()->json(['success' => true, 'inscripcion' => false, 'contador_inscritos' => $course->contador_inscritos - 1]);
				}catch(\Exception $e){
					DB::rollback();
					Log::error($e->getMessage());
					return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
            abort(403);
        }
        abort(404);
	}

}
