<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Auth, Lang;

use App\Usuario, App\Rol, App\TerminosCondiciones, App\RegistroSesion, App\Estado, App\UsuarioInstitucion, App\AceptacionTerminos, App\Compra;

class VendedorController extends Controller
{

    /**
     * Instantiate a new VendedorController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(Compra::getProductsUser(Compra::getTypeUser('seller')));
        }
        return view('public/marketplace/main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Auth::user()->hasRole(['seller']) ) {
            return redirect()->route( 'marketplace.ventas.index' );
        }
        return view('public/marketplace/main');
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
                // Get session user
                $user = Auth::user();

                // Set phone and cellphone
                $user->telefono_usuario = $request->telefono_usuario;
                $user->movil_usuario = $request->movil_usuario;
                $user->correo_electronico = $request->correo_electronico;
                $user->save();

                // Get user institution
                $userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario);

                // Terms and sales policies
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

                // Role seller
                $role = Rol::join('core.rol_institucion', 'rol.id', '=', 'rol_institucion.codigo_rol')->where('rol.id', Rol::getRole('seller'))->where('codigo_institucion', $userInstitution->codigo_institucion)->first();
                if(!$role instanceof Rol){
                    DB::rollback();
                    Log::error('Institucion no contiene rol seller');
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
                $user->attachRole($role);

                // Commit Transaction
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
