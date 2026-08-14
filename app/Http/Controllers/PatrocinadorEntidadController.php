<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Response, Auth, App, Input, DB, Lang, Log, TuProyecto;

use App\PatrocinadorEntidad, App\Estado, App\Patrocinador;

class PatrocinadorEntidadController extends Controller
{

    /**
     * Instantiate a new PatrocinadorProyectoController instance.
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
        if($request->ajax()) {
            return response()->json(PatrocinadorEntidad::getSponsorsEntity());
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
            $sponsor = Patrocinador::find($id);
            if(!$sponsor instanceof Patrocinador) {
                abort(404);
            }

            // Decrypt src-params
            list($codigo_entidad) = TuProyecto::decryptSrcParams($request->codigo_entidad);
            if(!$codigo_entidad || !is_numeric($codigo_entidad)) {
                App::abort(403);
            }

            DB::beginTransaction();
            try {
                $sponsorEntity = PatrocinadorEntidad::where('codigo_patrocinador', '=', $sponsor->codigo_patrocinador)->where('codigo_entidad','=', $codigo_entidad)->first();
                if($sponsorEntity instanceof PatrocinadorEntidad) {
                    if($sponsorEntity->codigo_estado != Estado::getState('active')) {
                        PatrocinadorEntidad::where('codigo_patrocinador', '=', $sponsorEntity->codigo_patrocinador)->where('codigo_entidad', '=', $sponsorEntity->codigo_entidad)->update(['codigo_estado' => Estado::getState('active')]);
                    }
                }else{
                    $sponsorEntity = new PatrocinadorEntidad;
                    $sponsorEntity->codigo_patrocinador = $sponsor->codigo_patrocinador;
                    $sponsorEntity->codigo_entidad = $codigo_entidad;
                    $sponsorEntity->codigo_estado = Estado::getState('active');
                    $sponsorEntity->save();
                }

                // Prepare response
                $response = PatrocinadorEntidad::buildEntitySponsor($sponsor);
                $response->success = true;

                // Commit Transaction
                DB::commit();
                return Response::json($response);

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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()) {
            DB::beginTransaction();
            try {

                // Decrypt src-params
                list($codigo_entidad) = TuProyecto::decryptSrcParams($request->codigo_entidad);
                if(!$codigo_entidad || !is_numeric($codigo_entidad)) {
                    App::abort(403);
                }

                // Set removed state
                PatrocinadorEntidad::where('codigo_patrocinador', '=', $id)->where('codigo_entidad', '=', $codigo_entidad)->update(['codigo_estado' => Estado::getState('removed')]);

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }
        abort(404);
    }
}
