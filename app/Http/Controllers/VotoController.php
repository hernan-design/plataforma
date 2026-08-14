<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;
use DB, Log, Auth, Lang, SendEmail, URL;

use App\Usuario, App\Estado,  App\Voto, App\Like, App\PuntoUsuario, App\Entidad, App\Recurso, App\RegistroSesion;

class VotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
        if ($request->ajax()) {
            DB::beginTransaction();
            try {

                // Decrypt src-params
                list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams($request->input('srcparams'));
                if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
                    throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
                }
                if(!$id_recurso || !is_numeric($id_recurso)) {
                    throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso']));
                }

                if($id_recurso === Recurso::getResource('proyectos.gestion')){
                    // Voto Proyecto
                    $objResource = Entidad::find($codigo_recurso_modulo);
                    if(!$objResource instanceof Entidad) {
                       return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                    $dataUser = Usuario::find($objResource->codigo_usuario);
                }

                if($request->has('email')) {
                    if(Usuario::validateMailtoVote($request->input('email'))){
                        $user = Usuario::getUserMail($request->input('email'));
                        if(!$user instanceof Usuario){
                            // Add new user
                            $data = [];
                            $data['nombre_usuario'] = $request->input('nombre_usuario');
                            $data['primer_apellido_persona'] = $request->input('primer_apellido_persona');
                            $data['correo_electronico'] = $request->input('email');
                            $data['codigo_clase_usuario'] = Usuario::classUser('contact');

                            $user = Usuario::store($data);
                        }

                        // Mail notification
                        $data = [];
                        $data['_subject'] = Lang::get('vote.mail.subject', ['project' => $dataUser->nombre_usuario]);
                        $data['_template'] = 'emails.vote.confirmvote';
                        $data['_to'] = $request->input('email');
                        $data['_name_project'] = $dataUser->nombre_usuario;
                        $data['_url_confirm'] = URL::route('voto.confirmar',['srcparams' => $request->input('srcparams'), 'user' => TuProyecto::encryptSrcParams([$user->codigo_usuario])], false);
                        $data['_to_name'] = sprintf('%s %s', $request->input('nombre_usuario'),$request->input('primer_apellido_persona'));

                        SendEmail::notification($data);
                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'requestPost' => true, 'message' => Lang::get('vote.email.success', ['user' => $data['_to_name'], 'mail' => $data['_to']])]);
                    }else{
                        DB::rollback();
                        return response()->json(['success' => false, 'requestPost' => true, 'errors' => 'No se permite las votaciones con cuentas de correo temporal']);
                    }
               	}
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


    /**
     * Send confirmation mail message.
     *
     * @return Response
     */
    public function confirmVote(Request $request, $id, $user)
    {
        if (!$request->ajax()) {
            try {
                // Decrypt src-params
                list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams($id);
                if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
                    throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
                }
                if(!$id_recurso || !is_numeric($id_recurso)) {
                    throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso']));
                }

                if($id_recurso === Recurso::getResource('proyectos.gestion')){
                    // Voto Proyecto
                    $objResource = Entidad::find($codigo_recurso_modulo);
                    if(!$objResource instanceof Entidad) {
                        throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource entity']));
                    }
                    $dataUser = Usuario::find($objResource->codigo_usuario);
                }

				// Decrypt src-params
                list($codigo_usuario) = TuProyecto::decryptSrcParams($user);
                if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
                    throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_usuario']));
                }
                $user = Usuario::find($codigo_usuario);
                if(!$user instanceof Usuario) {
                    throw new \Exception("Error recuperando usuario para voto");
                }

                $query = Like::query();
                $query->where('codigo_recurso_modulo', $codigo_recurso_modulo);
                $query->where('id_recurso', $id_recurso);
                $query->where('codigo_usuario', $user->codigo_usuario);
                $query->where('codigo_estado', Estado::getState('active'));
                $query->where('codigo_institucion', RegistroSesion::getInstitution());
                $like = $query->first();

                if(!$like instanceof Like) {
                    // Like
                    $like = new Like;
                    $like->codigo_institucion = RegistroSesion::getInstitution();
                    $like->codigo_recurso_modulo = $codigo_recurso_modulo;
                    $like->id_recurso = $id_recurso;
                    $like->codigo_estado = Estado::getState('active');
                    $like->codigo_usuario = $user->codigo_usuario;
                    $like->fecha_like = date('Y-m-d');
                    $like->hora_like = date('H:i:s');
                    $like->save();
                }

                // Commit Transaction
                DB::commit();
                return redirect()->route( 'proyecto.proyecto',['proyecto'=> $dataUser->nickname_usuario] );

            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                abort(500);
            }
        }
        abort(401);
    }

    // View of verify vote

    public function verify(Request $request, $id) {
		$data = $request->all();
		// Decrypt src-params
		list($codigo_voto) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_voto|| !is_numeric($codigo_voto)) {
			abort(403);
		}

		$voto = Voto::buildVoto( Voto::find($codigo_voto));
		$entidad = Usuario::select('usuario.nombre_usuario','usuario.nickname_usuario')->join('core.usuario_institucion', 'usuario_institucion.codigo_usuario', 'usuario.codigo_usuario')
        ->where('usuario_institucion.codigo_usuario_institucion', '=', $voto->codigo_usuario_institucion)->first();

        return view('core.project.vote.verify', compact('voto','entidad'));
    }
}
