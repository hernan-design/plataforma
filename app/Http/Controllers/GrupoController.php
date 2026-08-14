<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;
use Auth, Input, DB, Log, Lang;
use App\Grupo, App\Entidad, App\Estado, App\UsuarioInstitucion, App\RegistroSesion, App\PrivacidadContenido, App\ClaseEmprendimiento, App\GrupoUsuario, App\Tag, App\TagUsuario, App\Usuario, App\DatoEntidad;

class GrupoController extends Controller
{

    /**
     * Instantiate a new GrupoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','showUrl']]);
        $this->middleware('intended', ['only' => ['index', 'showUrl']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(Grupo::getGroups());
        }
        return view('core/group/main');
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
        if($request->ajax()) {

            // Decrypt src-params
            list($codigo_entidad) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_entidad || !is_numeric($codigo_entidad)) {
                abort(403);
            }
            $dataentity = Entidad::find($codigo_entidad);
            if(!$dataentity instanceof Entidad) {
                abort(404);
            }

            $datauser = Usuario::find($dataentity->codigo_usuario);
            if(!$datauser instanceof Usuario) {
                abort(404);
            }

            $entity = Entidad::getEntityUrl($datauser->nickname_usuario);
            if(!$entity instanceof Entidad) {
                abort(404);
            }

            // Validate users update entity
            if(in_array(Auth::user()->codigo_usuario, $entity->getAllowedUsers())) {
                $data = $request->all();

                DB::beginTransaction();
                try{
                    
                    $entity->fill($data);
                    $datauser->fill($data);

                    if ($request->has('nombre_usuario')) {
                        $datauser->nombre_usuario = $request->input('nombre_usuario');
                    }

                    // user Institution
                    $userIntitution = UsuarioInstitucion::where('codigo_usuario',Auth::user()->codigo_usuario)->where('codigo_institucion', RegistroSesion::getInstitution())->where('codigo_estado', Estado::getState('active'))->first();

                    //data Entity
                    $dataEntity = DatoEntidad::where('codigo_usuario_institucion',$userIntitution->codigo_usuario_institucion)->where('codigo_estado', Estado::getState('active'))->first();

                    if($dataEntity instanceof DatoEntidad) {

                        $data = [];
                        if($request->has('codigo_categoria_proyecto') && $request->has('codigo_categoria_proyecto')!=0){
                            $data['codigo_categoria_proyecto'] = $request->input('codigo_categoria_proyecto');
                        }
                        if($request->has('codigo_privacidad_contenido') && $request->input('codigo_privacidad_contenido')!=0 ){
                            $data['codigo_privacidad_contenido'] = $request->input('codigo_privacidad_contenido');
                        }
                        if($request->has('codigo_etapa_proyecto') && $request->input('codigo_etapa_proyecto')!=0){
                            $data['codigo_etapa_proyecto'] = $request->input('codigo_etapa_proyecto');
                        }

                        // Set data
                        if(is_array($data) && count($data)) {
                            DatoEntidad::where('codigo_dato_entidad', '=', $dataEntity->codigo_dato_entidad)->where('codigo_estado', '=', Estado::getState('active'))
                            ->update($data);
                        }
                    }

                    $entity->save();
                    $datauser->save();

                    // Tags user
                    if(Input::get('update_tags')){
                        $inputTags = explode(',', $request->input('tags_usuario'));
                        $tags = $datauser->tags()->get();
                        foreach ($tags as $tag) {
                            if(!in_array($tag->texto_tag, $inputTags)) {
                                $datauser->tags()->detach($tag);
                            }
                        }
                    }

                    if(Input::has('tags_usuario') && is_array($inputTags) && count($inputTags) > 0) {
                        foreach($inputTags as $item) {
                            if(!$tags->contains('texto_tag', $item)){
                                $tag = Tag::firstOrCreate(['texto_tag' => $item]);
                                if(!$tag instanceof Tag) {
                                    throw new Exception('tag not found');
                                }
                                $datauser->tags()->attach($tag);
                            }
                        }
                    }

                    // Prepare response
                    $response = Entidad::buildEntity(Entidad::getEntityUrl($datauser->nickname_usuario));
                    $response->success = true;

                    DB::commit();
                    return response()->json($response);

                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'erros' => Lang::get('app.exception')]);
                }
            }
            abort(403);
        }
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
    * Display the resource from url.
    *
    * @param  String  $tab
    * @param  String  $group
    * @return Response
    */
    public function showUrl(Request $request, $group, $tab = null)
    {
        $group = Grupo::getGroupUrl($group);

        if(!$group instanceof Grupo) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json(Grupo::buildGroup($group));
        }
        $data = [];
        $data['group'] = $group;
        return view('core/group/main', $data);  
    }
}
