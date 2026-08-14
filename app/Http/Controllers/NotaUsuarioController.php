<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Log, Auth, Lang;

use App\Curso, App\NotaUsuario, App\Estado;

class NotaUsuarioController extends Controller
{

    /**
     * Instantiate a new NotaUsuarioController instance.
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
            if($request->has('course')) {
                $course = Curso::getCourseUrl($request->course);
                if(!$course instanceof Curso) {
                    abort(404);
                }
                return response()->json(NotaUsuario::getNotesUser($course->codigo_curso));
            }
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
        if ($request->ajax()) {
            $data = $request->all();
            $usernote = new NotaUsuario;
            if ($usernote->isValid($data)) {

                // Decrypt src-params
                list($codigo_curso) = TuProyecto::decryptSrcParams($request->input('codigo_curso'));
                if(!$codigo_curso || !is_numeric($codigo_curso)) {
                    App::abort(403);
                }

                DB::beginTransaction();
                try {
                    // Note User
                    $usernote->fill($data);
                    $usernote->codigo_estado = Estado::getState('active');
                    $usernote->codigo_usuario = Auth::user()->codigo_usuario;
                    $usernote->codigo_curso = $codigo_curso;
                    $usernote->fecha_hora_nota_usuario = date('Y-m-d');
                    $usernote->save();

                    // Prepare response
                    $response = NotaUsuario::buildNoteUser(NotaUsuario::getDataUserNotes($usernote->codigo_nota_usuario));
                    $response->success = true;

                    // Commit Transaction
                    DB::commit();
                    return response()->json($response);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $usernote->errors]);
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
        if ($request->ajax()) {
            // Decrypt src-params
            list($codigo_nota_usuario) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_nota_usuario || !is_numeric($codigo_nota_usuario)) {
                abort(403);
            }
            $usernote = NotaUsuario::find($codigo_nota_usuario);
            if(!$usernote instanceof NotaUsuario) {
                abort(404);
            }
            // Validate user update note user
            if(Auth::user()->codigo_usuario == $usernote->codigo_usuario) {
                DB::beginTransaction();
                try {
                    // Set removed note user
                    NotaUsuario::where('codigo_nota_usuario', '=', $usernote->codigo_nota_usuario)
                        ->update(['codigo_estado' => Estado::getState('removed')]);

                    DB::commit();
                    return response()->json(['success' => true]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
            }
            abort(403);
        }
        abort(404);
    }
}
