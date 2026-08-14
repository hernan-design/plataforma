<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Log, Auth, Lang, Input;

use App\Usuario, App\Persona, App\Estado, App\RegistroSesion, App\Rol, App\RolUsuario, App\EtapaMentoria, App\EtapaProyecto, App\UsuarioInstitucion, App\TerminosCondiciones, App\AceptacionTerminos;

class MentorController extends Controller
{
    /**
     * Instantiate a new MentorController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
        $this->middleware('subscription', ['only' => ['create','show']]);
		$this->middleware('ability:super-admin,assign-mentor,mentoria', ['only' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(Persona::getMentorsList());
        }

        $mentor = Auth::user()->hasRole(['mentor']);
        return view('core/mentoring/main', compact('mentor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if( Auth::user()->hasRole(['mentor']) === false ) {
        	return view('core/mentoring/main');
        }
		return redirect()->route('mentoria.mentores.show', [ 'mentores' => Auth::user()->nickname_usuario ]);
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
            $data = $request->all();
            $user = Usuario::find(Auth::user()->codigo_usuario);
            if(!$user instanceof Usuario) {
                abort(404);
            }

            if ($user->isValidMentor($data)) {
                DB::beginTransaction();
                try {

                    $user->experiencia_usuario = $request->input("experiencia_usuario");
                    $user->imagen_usuario = $request->input("imagen_usuario");
                    $user->linkedin_usuario = $request->input("linkedin_usuario");
                    $user->save();

                    $person = Persona::where('codigo_usuario', '=', $user->codigo_usuario)->first();
                    if(!$person instanceof Persona) {
                        abort(404);
                    }

                    $person->codigo_especialidad = $request->input("codigo_especialidad_destacada");
                    $person->forma_ayuda_mentoria = $request->input("forma_ayuda_mentoria");
                    $person->save();

                    // Stage Mentoring
                    $items = EtapaProyecto::getStages();

                    foreach ($items as $item) {
                        if($request->has("codigo_etapa_proyecto_$item->codigo_etapa_proyecto")) {
                            //Stage mentoring for user
                            $stageMentorinUser = EtapaMentoria::where('codigo_usuario', '=', $user->codigo_usuario)->where('codigo_etapa_proyecto', $item->codigo_etapa_proyecto)->first();
                            if(!$stageMentorinUser instanceof EtapaMentoria){
                                $stageMentoring = new EtapaMentoria();
                                $stageMentoring->codigo_usuario = $user->codigo_usuario;
                                $stageMentoring->codigo_etapa_proyecto = $request->input("codigo_etapa_proyecto_$item->codigo_etapa_proyecto");
                                $stageMentoring->codigo_estado = Estado::getState('active');
                                $stageMentoring->save();
                            }
                        }
                    }

                    // Get user institution
                    $userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario);

                    // Terms and sales policies
                    $terms = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('mentoring'));
                    if($terms instanceof TerminosCondiciones) {
                        $acceptanceTerms = AceptacionTerminos::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)->where('codigo_version_terminos', $terms->codigo_version_terminos)->first();
                        if(!$acceptanceTerms instanceof AceptacionTerminos) {
                            $acceptanceTerms = new AceptacionTerminos();
                            $acceptanceTerms->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
                            $acceptanceTerms->codigo_version_terminos = $terms->codigo_version_terminos;
                            $acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
                            $acceptanceTerms->codigo_estado = Estado::getState('active');
                            $acceptanceTerms->save();
                        }


                        $user->sync_algolia = 1;
                        $user->save();
                    }

                    // Role User
                    $user->attachRole(Rol::find( Rol::getRole('mentor') ), Estado::getState('review'));

                    // Commit Transaction
                    DB::commit();
                    $user->syncIndex();
                    return response()->json(['success' => true, 'message' => 'Hemos recibido tu solicitud para registrarte como Mentor, te estaremos notificando la respuesta posterior a nuestro proceso de valoración. Gracias']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $user->errors]);
        }
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //$mentor = Auth::user()->hasRole(['mentor']);

        // Type encrypt params
        switch (Input::has('type')) {
            case 'encrypt':
                // Decrypt src-params
                list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
                if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
                    App::abort(403);
                }
                $mentorItem = Usuario::find($codigo_usuario);
                $mentor = Usuario::getDataUser($mentorItem->nickname_usuario);
                break;
            default:
                $mentor = Usuario::getDataUser($id);
                break;
        }

        if(!$mentor instanceof Usuario) {
            abort(404);
        }
        $mentorUser = $mentor;
        if ($request->ajax()) {
            return response()->json(Usuario::buildUser($mentor));
        }


        return view('core/mentoring/main', compact('mentorUser'));
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
            $data = $request->all();

            // Decrypt src-params
            list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
                abort(403);
            }
            $user = Usuario::find($codigo_usuario);
            if(!$user instanceof Usuario) {
                abort(404);
            }
            $person = Persona::find($user->persona->codigo_persona);
            if(!$person instanceof Persona) {
                App::abort(404);
            }

            // Validate users update mentor
            if(in_array(Auth::user()->codigo_usuario, $user->getAllowedUsers())) {

                DB::beginTransaction();
                try{
                    $person->fill($data);

                    if($request->has('forma_ayuda_mentoria')){
                        $person->forma_ayuda_mentoria = $request->input("forma_ayuda_mentoria");
                    }else{
                        $data['forma_ayuda_mentoria'] =  $person->forma_ayuda_mentoria;
                    }

                    $user->fill($data);
                    // Prepare response
					$person->save();
                    $user->save();

                    // Stage Mentoring
                    $items = EtapaProyecto::getStages();

                    if($request->has('changed_level_attributes') &&  $request->input("changed_level_attributes") )
                    foreach ($items as $item) {
                        if($request->has("codigo_etapa_proyecto_$item->codigo_etapa_proyecto")) {
                            //Stage mentoring for user
                            $stageMentorinUser = EtapaMentoria::where('codigo_usuario', '=', $user->codigo_usuario)->where('codigo_etapa_proyecto', $item->codigo_etapa_proyecto)->first();
                            if(!$stageMentorinUser instanceof EtapaMentoria){
                                $stageMentoring = new EtapaMentoria();
                                $stageMentoring->codigo_usuario = $user->codigo_usuario;
                                $stageMentoring->codigo_etapa_proyecto = $request->input("codigo_etapa_proyecto_$item->codigo_etapa_proyecto");
                                $stageMentoring->codigo_estado = Estado::getState('active');
                                $stageMentoring->save();
                            }
                        }else{
                            $user->estapamentoria()->detach($item->codigo_etapa_proyecto);
                        }
                    }


					// Get user institution
					$userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario);

                        // Terms and sales policies
                        $terms = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('mentoring'));
                        if($terms instanceof TerminosCondiciones && isset($data['aceptacion_terminos']) && $data['aceptacion_terminos']) {
                            $acceptanceTerms = AceptacionTerminos::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)
                                ->where('codigo_version_terminos', $terms->codigo_version_terminos)->first();


                            if(!$acceptanceTerms instanceof AceptacionTerminos) {
                                if ($user->isValidMentor($data)) {
                                    $acceptanceTerms = new AceptacionTerminos();
                                    $acceptanceTerms->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
                                    $acceptanceTerms->codigo_version_terminos = $terms->codigo_version_terminos;
                                    $acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
                                    $acceptanceTerms->codigo_estado = Estado::getState('active');
                                    $acceptanceTerms->save();
                                } else {
                                    DB::rollback();
                                    $errmsg = $user->errors;
                                    Log::error(sprintf('%s:%s', 'MentorController::update', $errmsg));
                                    return response()->json(['success' => false, 'errors' => $errmsg]);
                                }
                            }

                            $user->sync_algolia = 1;
                        }





                    // Prepare response
					$person->save();
                    $user->save();

					$response = Usuario::buildUser(Usuario::getDataUser($user->nickname_usuario));
                    $response->success = true;
                    $response->message= 'Los datos del usuario fueron actualizados';
                    DB::commit();
                    $user->syncIndex();

                    return response()->json($response);
                } catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
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
}
