<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;
use Auth, DB, Lang, Log;

use App\SectorEconomicoPersona, App\SectorEconomico, App\Estado, App\Usuario, App\Persona;

class SectorEconomicoPersonaController extends Controller
{
    /**
     * Instantiate a new SectorEconomicoPersonaController instance.
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
        if($request->ajax()){
            return response()->json(SectorEconomicoPersona::getEconomicSector( $request->all() ));
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
        if ($request->ajax()) {
            $economicSector = SectorEconomico::find($id);
            if(!$economicSector instanceof SectorEconomico) {
                abort(404);
            }

            $user = Usuario::find(Auth::user()->codigo_usuario);
            if(!$user instanceof Usuario) {
                abort(404);
            }

            DB::beginTransaction();
            try {
                $personEconomic = SectorEconomicoPersona::where('codigo_sector_economico', '=', $economicSector->codigo_sector_economico)->where('codigo_persona','=',$user->persona->codigo_persona)->first();
                if($personEconomic instanceof SectorEconomicoPersona) {
                    if($personEconomic->codigo_estado != Estado::getState('active')) {
                        SectorEconomicoPersona::where('codigo_sector_economico', '=', $economicSector->codigo_sector_economico)->where('codigo_persona', '=', $personEconomic->codigo_persona)->update(['codigo_estado' => Estado::getState('active')]);
                    }
                }else{
                    $personEconomic = new SectorEconomicoPersona;
                    $personEconomic->codigo_sector_economico = $economicSector->codigo_sector_economico;
                    $personEconomic->codigo_persona = $user->persona->codigo_persona;
                    $personEconomic->codigo_estado = Estado::getState('active');
                    $personEconomic->save();
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'codigo_sector_economico' => $personEconomic->codigo_sector_economico, 'nombre_sector_economico' => $economicSector->nombre_sector_economico]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }
        abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function selectorlist(Request $request)
    {	
        
        if($request->ajax()){
            $data = $request->all();
                
                $return = SectorEconomico::getSectorSelectorList($data);
                
                return response()->json($return);
            }
            
            abort('404');
                
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {

                $user = Usuario::find(Auth::user()->codigo_usuario);
                if(!$user instanceof Usuario) {
                    abort(404);
                }

                // Set removed state
                SectorEconomicoPersona::where('codigo_sector_economico', '=', $id)->where('codigo_persona', '=', $user->persona->codigo_persona)->update(['codigo_estado' => Estado::getState('removed')]);

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }
        App::abort(404);
    }
}
