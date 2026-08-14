<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Response, Auth, Input, App, DB, Log, Lang;

use TuProyecto, SendEmail;

use App\Adjunto, App\AdjuntoAsesoria, App\TipoAdjunto, App\Asesoria, App\Estado, App\RegistroSesion, App\Usuario;

class AdjuntoAsesoriaController extends Controller
{
    /**
     * Instantiate a new AdjuntoAsesoriaController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(AdjuntoAsesoria::getAttachedAdvice());
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
        if($request->ajax()) {
            $data = $request->all();
            // Decrypt src-params
            list($codigo_asesoria) = TuProyecto::decryptSrcParams($request->input('codigo_asesoria'));
            if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
                abort(403);
            }
            $advice = Asesoria::find($codigo_asesoria);
            if(!$advice instanceof Asesoria) {
                abort(404);
            }

			$mentor = Usuario::find($advice->seg_codigo_usuario);
			if(!$mentor instanceof Usuario){
				abort(404);
			}

			$user = Usuario::find($advice->codigo_usuario);
			if(!$user instanceof Usuario){
				abort(404);
			}

            $attachedAdvice = new AdjuntoAsesoria;
            if ($attachedAdvice->isValid($data)) {
                DB::beginTransaction();
                try {
                    if ($request->hasFile('file'))
                    {
                        $file = $request->file('file');
                        $result = Adjunto::upload($file->getRealPath(), $file->getClientOriginalName(), 'document');

                        if(is_object($result) && $result->success === true) {
                            // Adjunto
                            $attached = new Adjunto();
                            $attached->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('document');
                            $attached->direccion_adjunto = $result->file_path;
                            $attached->nombre_adjunto = $file->getClientOriginalName();
                            $attached->fecha_adjunto = date('Y-m-d H:i:s');
                            $attached->save();

                            // Adjunto Asesoria
                            $attachedAdvice->codigo_adjunto = $attached->codigo_adjunto;
                            $attachedAdvice->codigo_asesoria = $advice->codigo_asesoria;
                            $attachedAdvice->codigo_estado = Estado::getState('active');
                            $attachedAdvice->fecha_adjunto_asesoria = date('Y-m-d');
                            $attachedAdvice->codigo_usuario  = Auth::user()->codigo_usuario;
                            $attachedAdvice->save();

							if($mentor->codigo_usuario == Auth::user()->codigo_usuario){
								$receiver = $user;
							}

							if($user->codigo_usuario == Auth::user()->codigo_usuario){
								$receiver = $mentor;
							}

							$data = [];
							$data['_inst'] = RegistroSesion::getInstitution();
							$data['_template'] = 'emails.mentoring.atachment.atachmentnotification';
							$data['_subject'] = 'Notificación adjunto';
							$data['_to'] = $receiver->correo_electronico;
							$data['_to_name'] = ucwords(strtolower($receiver->nombre_usuario));
							$data['url_discusion'] = route('mentoria.mentores.procesos.show', ['procesos' => TuProyecto::encryptSrcParams([$attachedAdvice->codigo_asesoria])]  );

                            SendEmail::notification($data);

                            // Prepare response
                            $response = AdjuntoAsesoria::buildAttached(AdjuntoAsesoria::getDataAttached($attachedAdvice->codigo_adjunto, $attachedAdvice->codigo_asesoria));
                            $response->success = true;

                            // Commit Transaction
                            DB::commit();
                            return response()->json($response);
                        }
                    }
                    DB::rollback();
                      return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(array('success' => false, 'errors' => $attachedAdvice->errors));
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
        if($request->ajax()) {
            DB::beginTransaction();
            try {
                // Decrypt src-params
                list($codigo_asesoria) = TuProyecto::decryptSrcParams(Input::get('codigo_asesoria'));
                if(!$codigo_asesoria || !is_numeric($codigo_asesoria)) {
                    abort(403);
                }

                $advice = Asesoria::find($codigo_asesoria);
                if(!$advice instanceof Asesoria) {
                    abort(404);
                }

                // Validate users update attach
                if(in_array(Auth::user()->codigo_usuario, $advice->getAllowedUsers())) {
                    // Decrypt src-params
                    list($codigo_adjunto) = TuProyecto::decryptSrcParams($id);
                    if(!$codigo_adjunto || !is_numeric($codigo_adjunto)) {
                        abort(403);
                    }

                    $attachedAdvice = AdjuntoAsesoria::getDataAttached($codigo_adjunto, $advice->codigo_asesoria);
                    if(!$attachedAdvice instanceof AdjuntoAsesoria) {
                        abort(404);
                    }

                    if($attachedAdvice->codigo_usuario != Auth::user()->codigo_usuario){
                        abort(403);
                    }

                    // Set removed state
                    AdjuntoAsesoria::where('codigo_adjunto', '=', $attachedAdvice->codigo_adjunto)->where('codigo_asesoria', '=', $attachedAdvice->codigo_asesoria)
                        ->update(['codigo_estado' => Estado::getState('removed')]);

                    DB::commit();
                    return response()->json(['success' => true]);
                }
                DB::rollback();
                abort(403);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s:%s', 'AdjuntoAsesoriaController destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }
        abort(404);
    }
}
