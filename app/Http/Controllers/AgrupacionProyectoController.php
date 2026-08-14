<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AgrupacionProyecto;

class AgrupacionProyectoController extends Controller
{

    /**
     * Instantiate a new AgrupacionProyectoController instance.
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
            return response()->json(AgrupacionProyecto::getClustersProject());
        }
        return view('core/group/main');
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
            // Decrypt src-params
            list($codigo_usuario) = TuProyecto::decryptSrcParams($request->codigo_usuario);
            if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
                App::abort(403);
            }

            $groupUser = Usuario::find($codigo_usuario);
            if(!$groupUser instanceof Usuario) {
                App::abort(404);
            }

            DB::beginTransaction();
            try {
               $state_join = null;
                switch ($request->statejoin) {
                    case 'desert':
                        AgrupacionProyecto::addJoinGroup($groupUser);
                        $state_join = 'join';
                    break;
                    case 'join':
                        if ($request->has('cancel_request')) {
                            AgrupacionProyecto::cancelJoinGroup($groupUser);
                            $state_join = 'desert';
                        }
                    break;
                }
                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'statejoin' => $state_join]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
            }
        }
        App::abort(404);
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
