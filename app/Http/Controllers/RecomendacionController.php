<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, Lang, SendEmail, DB, URL, Auth;

use App\Usuario, App\RegistroSesion;

class RecomendacionController extends Controller
{
    /**
     * Instantiate a new RecomendacionController instance.
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
    public function index()
    {
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
        if ($request->ajax()) {

            $user = Usuario::find(Auth::user()->codigo_usuario);
            if(!$user instanceof Usuario) {
                abort(404);
            }

            DB::beginTransaction();
            try {
                // Mail notification
                $data = [];
                switch ($request->input('type')) {
                    case 'mentor':
                        $data['_subject'] = 'Te recomendaron este mentor';
                        $data['_template'] = 'emails.recommendation.notification';
                        $data['url_recomendacion'] = URL::previous();
                    break;
                    
                    default:
                        break;
                }

                $data['_name_user'] = $user->nombre_usuario;
                $data['_to'] = $request->input('correo_electronico');
                $data['_message'] = $request->input('mensaje_recomendacion');
                $data['_to_name'] = $request->input('nombre');
                $data['_inst'] = $request->input('institucion');

                SendEmail::notification($data);

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s:%s', 'Recomendacion notification', $e->getMessage()));
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
