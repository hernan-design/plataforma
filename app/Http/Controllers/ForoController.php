<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TuProyecto;
use DB, Lang, Log, Auth, App, URL;

use App\Foro, App\Estado, App\TagForo, App\Tag, App\ForoInstitucion, App\RegistroSesion, App\PuntoUsuario, App\CategoriaForo, App\Muro, App\Modulo, App\Canal, App\ContenidoCanal;

class ForoController extends Controller {

    /**
     * Instantiate a new ForoController instance.
     */
    public function __construct()
    {
        $this->middleware('intended', ['only' => ['index', 'show', 'showUrl']]);
		$this->middleware('react', ['only' => ['index', 'show', 'showUrl']]);
		$this->middleware('subscription', ['only' => ['store', 'update']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$forum = Foro::getGlobalData();
		return view('layout.document.layout', compact('forum'));
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
		if ($request->ajax()) {
			$data = $request->all();
			$foro = new Foro;

			if ($foro->isValid($data)) {
				// Validate unique url
				$seo_url = TuProyecto::seoUrl($request->titulo_foro);
				$objForo = Foro::getForum($seo_url);
				if($objForo instanceof Foro) {
					$forum_url = URL::route('foro.categoria.tema', array('category' => $objForo->url_categoria_foro, 'theme' => $objForo->url_foro));
					return response()->json(array('success' => false, 'errors' => Lang::get('forum.error.title', array('url' => $forum_url))));
				}

				DB::beginTransaction();
	        	try {
	        		$category = CategoriaForo::find($request->codigo_categoria_foro);
					if(!$category instanceof CategoriaForo) {
			           	throw new \Exception("No existe la categoría");
					}

					// Foro
					$foro->fill($data);
					$foro->url_foro = $seo_url;
					$foro->codigo_estado = Estado::getState('active');
		   			$foro->codigo_usuario = Auth::user()->codigo_usuario;
		   			$foro->fecha_apertura_foro = date('Y-m-d');
		   			$foro->hora_apertura_foro = date('H:i:s');
		   			$foro->save();

	   				// Tags forum
		   			$inputTags = explode(',', $request->tags_foro);
					$tags = $foro->tags()->get();
					// foreach ($tags as $tag) {
					// 	if(!in_array($tag->texto_tag, $inputTags)) {
					// 		$foro->tags()->detach($tag);
					// 	}
					// }

					if($request->has('tags_foro') && !empty($request->tags_foro) && is_array($inputTags) && count($inputTags) > 0) {
				   		foreach($inputTags as $item) {
							if(!$tags->contains('texto_tag', $item)){
		   			  			$tag = Tag::firstOrCreate(['texto_tag' => $item]);
								if(!$tag instanceof Tag) {
									throw new \Exception('tag not found');
								}
								$foro->tags()->attach($tag);
							}
					   	}
					}

		   			$forumInstitution = new ForoInstitucion;
		   			$forumInstitution->codigo_foro = $foro->codigo_foro;
		   			$forumInstitution->codigo_institucion = RegistroSesion::getInstitution();
					$forumInstitution->codigo_estado = Estado::getState('active');
		   			$forumInstitution->save();

		   			// Channel
		   			$channel = null;
		   			if($request->has('url_canal') && !empty($request->url_canal)) {
		   				$channel = Canal::where('url_canal', $request->url_canal)->where('canal.codigo_institucion', RegistroSesion::getInstitution())->first();
		   				if(!$channel instanceof Canal) {
		   					throw new \Exception("No existe el canal ".$request->url_canal);
		   				}

		   				$cchannel = new ContenidoCanal;
		   				$cchannel->codigo_canal = $channel->codigo_canal;
		   				$cchannel->codigo_estado = Estado::getState('active');
		   				$cchannel->codigo_modulo = Modulo::getModule('forum');
		   				$cchannel->codigo_recurso_modulo = $foro->codigo_foro;
		   				$cchannel->save();
		   			}

		   			$response = new \stdClass();
		   			switch ($request->has('action')) {
		   				case 'wall':
		   					// Prepare data wall
							$data = [];
							$data['codigo_canal'] = $channel instanceof Canal ?  $channel->codigo_canal : null;
							$data['codigo_modulo'] = Modulo::getModule('forum');
							$data['codigo_recurso_modulo'] = $foro->codigo_foro;

							$muro = Muro::store($data);
							if( !$muro instanceof Muro ) {
								throw new \Exception("Error creando post muro");
							}
							$response = Muro::buildPosts(Muro::getPosts($muro->codigo_muro));
		   					break;
		   				default:
		   					$response->codigo_foro = TuProyecto::encryptSrcParams([$foro->codigo_foro]);
		   					$response->url_foro = $foro->url_foro;
		   					$response->url_categoria_foro = $category->url_categoria_foro;
							$response->success = true;
		   					break;
		   			}

		   			// Gamification
		   			// PuntoUsuario::gamification('foro.gestion.crear', Estado::getState('active'), Auth::user()->codigo_usuario, $foro->codigo_foro);
					// Commit Transaction
					DB::commit();
					return response()->json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return response()->json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}
			return response()->json(array('success' => false, 'errors' => $foro->errors));
		}
    	abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request, $id)
	{
		$forumCategory = CategoriaForo::getCategory($id);
		if(!$forumCategory instanceof CategoriaForo) {
            abort(404);
		}

		$forum = Foro::getGlobalData();
		$forum['category'] = $forumCategory;

		return view('layout.document.layout', compact('forum'));
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
			list($codigo_foro) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_foro || !is_numeric($codigo_foro)) {
				abort(403);
	 		}
			$data = $request->all();

			// Foro
			$foro = Foro::find($codigo_foro);
			if(!$foro instanceof Foro) {
				return response()->json(['success' => false, 'errors' => "La publicación para esta entrada de foro, no fue encontrada"]);
			}

			if(!$foro->isValid($data)) {
				return response()->json(['success' => false, 'errors' => $foro->errors]);
			}

			$category = CategoriaForo::find($request->codigo_categoria_foro);
			if(!$category instanceof CategoriaForo) {
				return response()->json(['success' => false, 'errors' => "No existe la categoría"]);
			}

			DB::beginTransaction();
			try {
				// fill forum data
				$foro->fill($data);
	   			$foro->save();

   				// Tags forum
	   			$inputTags = explode(',', $request->tags_foro);
				$tags = $foro->tags()->get();

				foreach ($tags as $tag) {
					if(!in_array($tag->texto_tag, $inputTags)) {
						$foro->tags()->detach($tag);
					}
				}
				if($request->has('tags_foro') && !empty($request->tags_foro) && is_array($inputTags) && count($inputTags) > 0) {
			   		foreach($inputTags as $item) {
						if(!$tags->contains('texto_tag', $item)) {
	   			  			$tag = Tag::firstOrCreate(['texto_tag' => $item]);
							if(!$tag instanceof Tag) {
								throw new \Exception('tag not found');
							}
							$foro->tags()->attach($tag);
						}
				   	}
				}

				// Channel
	   			$channel = null;
	   			if($request->has('url_canal') && !empty($request->url_canal)) {
	   				$channel = Canal::where('url_canal', $request->url_canal)->where('canal.codigo_institucion', RegistroSesion::getInstitution())->first();
	   				if(!$channel instanceof Canal) {
	   					throw new \Exception("No existe el canal ".$request->url_canal);
	   				}

	   				$cchannel = ContenidoCanal::where('codigo_modulo', Modulo::getModule('forum'))->where('codigo_recurso_modulo', $foro->codigo_foro)->first();
	   				if(!$cchannel instanceof ContenidoCanal) {
		   				$cchannel->codigo_estado = Estado::getState('inactive');
	   					// throw new \Exception("No se puede asociar el canal con el contenido");
	   				}else {
		   				$cchannel->codigo_canal = $channel->codigo_canal;
		   				$cchannel->codigo_estado = Estado::getState('active');
	   				}
	   				$cchannel->save();
	   			}

	   			$response = new \stdClass();
	   			switch ($request->has('action')) {
	   				case 'wall':
	   					// Prepare data wall
	   					$muro = Muro::find($request->codigo_muro);
						if(!$muro instanceof Muro) {
							throw new \Exception("Error actualizando post muro");
						}

						$muro->codigo_canal = null;
						if($channel instanceof Canal) {
		   					$muro->codigo_canal = $channel->codigo_canal;
						}
		   				$muro->save();

						$response = Muro::buildPosts(Muro::getPosts($muro->codigo_muro));
						$response->success = true;
	   					break;
	   				default:
	   					$response->codigo_foro = TuProyecto::encryptSrcParams([$foro->codigo_foro]);
						$response->success = true;
						break;
	   			}

				DB::commit();
				return response()->json($response);
			}catch (\Exception $e) {
				DB::rollback();
				Log::error($e->getMessage());
				return response()->json(array('success' => false, 'errors' => Lang::get('app.exception')));
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
			DB::beginTransaction();

			list($codigo_foro) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_foro || !is_numeric($codigo_foro)) {
				abort(403);
	 		}

			try {
				$forum = Foro::find($codigo_foro);
				if(!$forum instanceof Foro) {
					throw new \Exception("Error deleting forum theme");
				}
				if(Auth::user()->codigo_usuario == $forum->codigo_usuario){
					// Set removed state
					ForoInstitucion::where('codigo_foro', '=', $forum->codigo_foro)
						->where('codigo_institucion', '=', RegistroSesion::getInstitution())
						->update(['codigo_estado' => Estado::getState('removed')]);

					DB::commit();
				}else {
					DB::rollback();
				}
				return response()->json(['success' => true]);
			}catch (\Exception $e) {
				DB::rollback();
				Log::error($e->getMessage());
	            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}

	/**
	 * Get forum theme by url
	 * @param $category
	 * @param $theme
	 */
	public function showUrl($category, $theme)
	{
		$theme = Foro::getForum($theme);
		if(!$theme instanceof Foro) {
            abort(404);
		}

		$forum = Foro::getGlobalData();
		$forum['forum'] = Foro::buildForum($theme);

		return view('layout.document.layout', compact('forum'));
	}
}
