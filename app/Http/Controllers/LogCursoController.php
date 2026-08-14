<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Contenido;
use App\TipoContenido;
use App\Estado;
use App\ContenidoInstitucion;
use App\RegistroSesion;
use App\LogCurso;
use App\PrivacidadContenido;

class LogCursoController extends Controller {

    /**
     * Instantiate a new BlogController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'showUrl', 'filterCategory']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()){
			return Response::json(Contenido::getArticles());
		}

		return View::make('public/blog/main');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('public/blog/main');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
    {
        // Obtener todos los datos de la solicitud
        $data = $request->all();

        // Obtener el código del curso encriptado desde el array de datos
        $encryptedCodigoCurso = $data['codigo_curso'];
        $encryptedCodigoUsuario = $data['codigo_usuario'];
        $tipoLog = $data['tipo_log'];

		$logCurso = new LogCurso;

		DB::beginTransaction();
        // Desencriptar el código del curso
        try {
            $codigoCurso = Crypt::decrypt($encryptedCodigoCurso);
            $codigoUsuario = Crypt::decrypt($encryptedCodigoUsuario);
			// Guardar los datos en la base de datos
			$logCurso->codigo_curso = $codigoCurso;
			$logCurso->codigo_usuario = $codigoUsuario;
			$logCurso->fecha_log = date('Y-m-d H:m:s');
			$logCurso->tipo_log = $tipoLog;
			$logCurso->save();
			// Confirmar la transacción
			DB::commit();

			return response()->json(['success' => true, 'message' => 'Log guardado exitosamente.']);
        } catch (DecryptException $e) {
			DB::rollback();
            Log::error('Error al guardar el log del curso: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Log no se puede guardar.'], 500);
        }

    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($url)
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
			// Decrypt src-params
            list($codigo_contenido) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_contenido || !is_numeric($codigo_contenido)) {
                App::abort(403);
            }

			$article = Contenido::find($codigo_contenido);
			if(!$article instanceof Contenido){
				App::abort(403);
			}

			$institutionContent = $article->institutions->where('codigo_institucion', RegistroSesion::getInstitution())->first();

			if(!$institutionContent instanceof ContenidoInstitucion) {
				App::abort(403);
			}

			$data = Input::all();

			DB::beginTransaction();
			try {
				$article->fill($data);
				$article->save();

				if(Input::has('state_article')){
					switch (Input::get('state_article')) {
						case 'pending':
    						if(Input::has('add_request')){
								if ( $article->isValidPublication($article->toArray()) ) {
	    							$codigo_estado = Estado::getState('review');
								}else{
									DB::rollback();
									return response()->json(['success' => false, 'errors' => $article->errors]);
								}
    						}
						break;
						case 'inactive':
    						if(Input::has('add_request')) {
								if ( $article->isValidPublication($article->toArray()) ) {
	    							$codigo_estado = Estado::getState('review');
								}else{
									DB::rollback();
									return response()->json(['success' => false, 'errors' => $article->errors]);
								}
    						}
						break;
						case 'review':
    						if(Input::has('cancel_request')){
    							$codigo_estado = Estado::getState('pending');
    						}
    					break;
						case 'published':
    						if(Input::has('finish_request')){
    							$codigo_estado = Estado::getState('pending');
    						}
						break;
					}

					ContenidoInstitucion::where('codigo_institucion', $institutionContent->codigo_institucion)
					->where('codigo_contenido', $institutionContent->codigo_contenido)
					->update([
						'codigo_estado' => $codigo_estado
					]);
				}

				// Prepare response
				$response = Contenido::buildArticle(Contenido::getArticle($article->url_contenido));
				$response->success = true;

				// Commit Transaction
				DB::commit();
				return response()->json($response);

			}catch(\Exception $e){
				DB::rollback();
				Log::error(sprintf('%s:%s', 'BlogController:update', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
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
	* @param  String  $article
	* @return Response
	*/
	public function showUrl($category, $article)
	{

		$article = Contenido::getArticle($article);
		if(!$article instanceof Contenido) {
            App::abort(404);
		}

		if($article->url_tipo_contenido != $category) {
            App::abort(404);
		}

		if (Request::ajax()) {
			return Response::json(Contenido::buildArticle($article));
		}
		$data = [];
		$data['article'] = Contenido::buildArticle($article);

		return View::make('public/blog/main', $data);
	}

	/**
	 * Url the form for category.
	 *
	 * @return Response
	 */
    public function filterCategory($category)
	{
		$typeCategory = TipoContenido::getTypeContent($category);
		if(!$typeCategory instanceof TipoContenido) {
            App::abort(404);
		}
		$institution = RegistroSesion::getInstitution();
		switch ($institution) {
			case 75:
				$user_type = ' cuidadores';
				break;

			default:
				$user_type = ' emprendedores';
				break;
		}

		return View::make('public/blog/main', compact('user_type'));
	}
}
