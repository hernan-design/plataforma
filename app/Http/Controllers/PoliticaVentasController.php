<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Auth, Lang;

use App\TerminosCondiciones, App\Estado, App\AceptacionTerminos;

class PoliticaVentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('core.middleware.politicaventas');
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
        DB::beginTransaction();
        try {
            $userInstitution = Auth::user()->institucion;

            // Terms
            $terms = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('sales'));
            if($terms instanceof TerminosCondiciones) {
                $acceptanceTerms = AceptacionTerminos::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)->where('codigo_version_terminos', $terms->codigo_version_terminos)->first();
                if(!$acceptanceTerms instanceof AceptacionTerminos) {
                    $acceptanceTerms = new AceptacionTerminos();
                    $acceptanceTerms->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
                    $acceptanceTerms->codigo_version_terminos = $terms->codigo_version_terminos;
                    $acceptanceTerms->codigo_estado = Estado::getState('active');
                    $acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
                    $acceptanceTerms->save();
                }
            }

            // Disable term marketplace user
            $userInstitution->validacion_terminos_marketplace = false;
            $userInstitution->save();

            // Commit Transaction
            DB::commit();            
            return redirect('marketplace');

        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->route('step.terminos.index')->withErrors(Lang::get('app.exception'), 'terms')->withInput();
        }
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
    public function destroy($id)
    {
        //
    }
}
