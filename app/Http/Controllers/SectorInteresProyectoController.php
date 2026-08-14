<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Response, Auth, App, Input, DB, Lang;

use App\SectorInteresProyecto, App\Estado, App\SectorInteres;

class SectorInteresProyectoController extends Controller
{

    /**
     * Instantiate a new SectorInteresProyectoController instance.
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
            return response()->json(SectorInteresProyecto::getInterests( $request->all() ));
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
            $sector = SectorInteres::find($id);
            if(!$sector instanceof SectorInteres) {
                abort(404);
            }

            DB::beginTransaction();
            try {
                $sectorProject = SectorInteresProyecto::where('codigo_sector_interes', '=', $sector->codigo_sector_interes)->where('codigo_proyecto','=', $request->codigo_proyecto)->first();
                if($sectorProject instanceof SectorInteresProyecto) {
                    if($sectorProject->codigo_estado != Estado::getState('active')) {
                        SectorInteresProyecto::where('codigo_sector_interes', '=', $sectorProject->codigo_sector_interes)->where('codigo_proyecto', '=', $sectorProject->codigo_proyecto)->update(['codigo_estado' => Estado::getState('active')]);
                    }
                }else{
                    $sectorUser = new SectorInteresProyecto;
                    $sectorUser->codigo_sector_interes = $sector->codigo_sector_interes;
                    $sectorUser->codigo_proyecto = $request->codigo_proyecto;
                    $sectorUser->codigo_estado = Estado::getState('active');
                    $sectorUser->save();
                }

                // Commit Transaction
                DB::commit();
               return response()->json(['success' => true, 'codigo_sector_interes' => $sector->codigo_sector_interes, 'nombre_sector_interes' => $sector->nombre_sector_interes]);

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
                // Set removed state
                SectorInteresProyecto::where('codigo_sector_interes', '=', $id)->where('codigo_proyecto', '=', $request->codigo_proyecto)->update(['codigo_estado' => Estado::getState('removed')]);

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
