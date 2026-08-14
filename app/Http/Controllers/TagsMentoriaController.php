<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use TuProyecto;

use Request, Input, Response, Lang, Log, App, DB, Auth;

use App\TagsMentoria, App\Estado, App\Mentoria;

class TagsMentoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Request::ajax()) {
            if(Input::has('codigo_mentoria')) {
				// Decrypt src-params
				list($codigo_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_mentoria'));
				if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
					App::abort(403);
				}

				$tagsMentoring = Mentoria::find($codigo_mentoria);
				if(!$tagsMentoring instanceof Mentoria) {
		            App::abort(404);
				}
				return Response::json(TagsMentoria::getTagsMentoring($tagsMentoring->codigo_mentoria));
			}
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
        $data = Input::all();
        // Decrypt src-params
        list($codigo_mentoria) = TuProyecto::decryptSrcParams($data['codigo_mentoria']);
        if(!$codigo_mentoria || !is_numeric($codigo_mentoria)) {
            App::abort(403);
        }

        $mentoring = Mentoria::find($codigo_mentoria);
        if(!$mentoring instanceof Mentoria) {
            abort(404);
        }

        $tagsMentoring = new TagsMentoria;
        if ($tagsMentoring->isValid($data)) {
            DB::beginTransaction();
            try {
                // Tags Mentoring
                $tagsMentoring->codigo_estado = Estado::getState('active');
                $tagsMentoring->nombre_tag_sesion_mentoria = $data['nombre_tag_sesion_mentoria'];
                $tagsMentoring->valor_tag_sesion_mentoria = $data['valor_tag_sesion_mentoria'];
                $tagsMentoring->codigo_mentoria = $mentoring->codigo_mentoria;
                $tagsMentoring->save();

                // Prepare Response
                $response = TagsMentoria::buildTagsMentoring(TagsMentoria::find($tagsMentoring->codigo_tag_sesion_mentoria));
                $response->success = true;

                // Commit Transaction
                DB::commit();
                return Response::json($response);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s:%s', 'TagsMentoriaController store', $e->getMessage()));
                return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }

        return Response::json(array('success' => false, 'errors' => $tagsMentoring->errors));
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
        dd('Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Request::ajax()) {
			// Decrypt src-params
	        list($codigo_tags_mentoria) = TuProyecto::decryptSrcParams(Input::get('codigo_tags_mentoria'));
	        if(!$codigo_tags_mentoria || !is_numeric($codigo_tags_mentoria)) {
				$errormsg = "El codigo de tags de mentoria es inválido" + $codigo_tags_mentoria;
				Log::error(sprintf('%s:%s', ' App\Http\ControllersTagsMentoriaController@destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
	        }
			$tagsMentoring = TagsMentoria::find($codigo_tags_mentoria);
			if(!$tagsMentoring instanceof TagsMentoria) {
				$errormsg = "No se encuentra tags de mentoria de codigo " + $codigo_tags_mentoria;
				Log::error(sprintf('%s:%s', 'TagsMentoriaController destroy', $errormsg));
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
			$mentoring = Mentoria::find($tagsMentoring->codigo_mentoria);
			if(!$mentoring instanceof Mentoria) {
				$errormsg = "No se encuentra mentoria de codigo " + $tagsMentoring->codigo_mentoria;
				Log::error(sprintf('%s:%s', 'TagsMentoriaController destroy', $errormsg));
				App::abort(404);
			}

			$authorized = False;

			switch(Auth::user()->codigo_usuario){
				case $mentoring->codigo_usuario:
					$authorized = True;
					break;
				case $mentoring->seg_codigo_usuario:
					$authorized = True;
					break;
				default:
					$authorized = False;
					break;

			}

			// Auth 45379  codigo_usuario 357190  seg_codigo_usuario = 45379


			if($authorized)
			{
				DB::beginTransaction();
				try {
					// Set removed state
					TagsMentoria::where('codigo_tag_sesion_mentoria', '=', $tagsMentoring->codigo_tag_sesion_mentoria)
						->update(array('codigo_estado' => Estado::getState('removed')));

					DB::commit();
					return Response::json(array('success' => true));
				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'TagsMentoriaController destroy', $e->getMessage()));
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}

			$errormsg = "El usuario no esta autorizado para realizar esta acción";
			Log::error(sprintf('%s:%s', 'TagsMentoriaController destroy', $errormsg));
			return Response::json(array('success' => false, 'errors' => $errormsg ));
		}
    	App::abort(404);
    }
}
