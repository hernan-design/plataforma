<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use TuProyecto, Request, View, Response, Auth, App, Input, DB, Log;

use App\Contenido, App\TipoContenido, App\Estado, App\ContenidoInstitucion, App\RegistroSesion, App\PrivacidadContenido;

class BlogController extends Controller {

    /**
     * Instantiate a new BlogController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'showUrl', 'filterCategory']]);
        $this->middleware('intended', ['only' => ['index', 'show', 'showUrl', 'filterCategory']]);

        $this->middleware('subscription', ['only' => ['create', 'store', 'update']]);
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
	public function store()
	{
		if(Request::ajax()){
			$data = Input::all();
			$article = new Contenido;
			if ($article->isValid($data)) {
	            DB::beginTransaction();
				try {
					$article->fill($data);
					$article->codigo_institucion = RegistroSesion::getInstitution();
					$article->codigo_estado = Estado::getState('active');
					$article->codigo_usuario = Auth::user()->codigo_usuario;
					$article->fecha_contenido = date('Y-m-d');
					$article->hora_contenido = date('H:m:s');
					$article->privacidad_contenido = PrivacidadContenido::getPrivacy('public');
					$article->url_contenido = slugtp(Input::get('nombre_contenido'), $article->getTable(), 'url_contenido');
					$article->save();

					$institutionArticle = new ContenidoInstitucion;
					$institutionArticle->codigo_institucion = RegistroSesion::getInstitution();
					$institutionArticle->codigo_estado = Estado::getState('pending');
					$institutionArticle->codigo_contenido = $article->codigo_contenido;
					$institutionArticle->codigo_tipo_cont_institucion = Input::get('codigo_tipo_cont_institucion');
					$institutionArticle->save();

					// Prepare response
		   			$response = Contenido::buildArticle(Contenido::getArticle($article->url_contenido));
					$response->message = 'El artículo ha sido creado correctamente!!';
					$response->success = true;

					// Commit Transaction
					DB::commit();
					return response()->json($response);

				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'BlogController:store', $e->getMessage()));
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			return Response::json(array('success' => false, 'errors' => $article->errors));
		}
		App::abort(404);
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
