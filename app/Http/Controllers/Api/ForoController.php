<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TuProyecto;
use Lang;

use App\Foro;

class ForoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()) {
			$response = null;

			switch ($request->type) {
				case 'related':
					if(!$request->has('url_foro')) {
						$response = array('success' => false, 'errors' => "Necesita pasar el parametro 'url_foro'");
					}else{
						$response = Foro::getRelatedThemes(Foro::getForum($request->url_foro), $request->all());
					}
					break;

				case 'author':
					if(!$request->has('nickname') || empty($request->nickname)) {
						$response = array('success' => false, 'errors' => "Necesita pasar el parametro 'nickname'");
					}else{
						$response = Foro::themesByAuthor($request->all());
					}
					break;

				case 'moreCommented':
					$response = Foro::getMostCommentedPost();
					break;

				case 'latest':
					$response = Foro::getLastPost();
					break;

				default:
					$response = Foro::getPosts($request->all());
					break;
			}

			return response()->json($response);
		}
		abort(404);
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
		// Filters
		switch ($request->has('type')) {
		    case 'encrypt':
				list($codigo_foro) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_foro || !is_numeric($codigo_foro)) {
					abort(403);
		 		}

		 		$forum = Foro::find($codigo_foro);
		        break;

		    default:
				$forum = Foro::getForum($id);
				break;
		}

		if(!$forum instanceof Foro) {
            abort(404);
		}

		$forum = Foro::buildForum($forum);

		return response()->json($forum);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
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
	public function destroy(Request $request, $id)
	{
		//
	}
}
