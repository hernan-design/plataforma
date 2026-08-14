<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use MongoDB\BSON\ObjectID;

use Auth, Log;

use App\Models\mongodb\Notificacion, App\Models\mongodb\Usuario;

class NotificacionesController extends Controller
{
    /**
     * Instantiate a new NotificacionesController instance.
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
            return response()->json(Notificacion::getNotifications());
        }
        return view('core.notification.main');
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
            try
            {
                $notification = Notificacion::find($id);
                if($notification instanceof Notificacion)
                {
	                $user = Usuario::where('cod', Auth::user()->codigo_usuario)->first();
	                if(!$user instanceof Usuario) {
	                    abort(404);
	                }

	                $notification->push('readBy', new ObjectID($user->_id), true);
	            }
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json(['success' => false]);
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
            try
            {
                $notification = Notificacion::find($id);
                if($notification instanceof Notificacion)
                {
	                $user = Usuario::where('cod', Auth::user()->codigo_usuario)->first();
	                if(!$user instanceof Usuario) {
	                    abort(404);
	                }

	                if($notification->isGlobal) {
	                    $notification->push('deletedBy', new ObjectID($user->_id), true);

	                }else{
	                    if(in_array(new ObjectID($user->_id), $notification->receivedBy)) {
	                        $notification->delete();
	                    }
	                }
               	}
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json(['success' => false]);
            }
        }
        abort(404);
    }
}
