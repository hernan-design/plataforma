<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use TuProyecto, SendEmail;

use  Response, Auth, Input, DB, Lang, URL, Log, Redirect;

use App\RedUsuario, App\Usuario, App\RegistroSesion, App\Estado;

class RedUsuarioController extends Controller {

    /**
     * Instantiate a new RedUsuarioController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['confirm']]);
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()) {
            if($request->has('userprofile')) {
            	// Decrypt src-params
                list($codigo_usuario) = TuProyecto::decryptSrcParams($request->userprofile);
                if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
                    abort(403);
                }

                $user = Usuario::find($codigo_usuario);
                if(!$user instanceof Usuario) {
                    abort(404);
				}
				
				//$chat = RedUsuario::createUserChatRoom($user);

				//dd($chat);
                return response()->json(RedUsuario::getNetworkUsers( $request->all(), $user ));
            }
        }
        abort(404);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request, $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		if($request->ajax()) {
			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				abort(403);
			}

			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
				abort(404);
			}

			DB::beginTransaction();
			$state_friendship = null;
			try {
				switch ($request->state_friendship) {
				    case 'invitation':
				    	$state_friendship = 'waiting_answer';
				    	RedUsuario::invitationFriendship($user);
			        break;

			        case 'pending_confirm':
			        	if ($request->has('cancel_friendship')) {
				    		$state_friendship = 'invitation';
			        		RedUsuario::cancelFriendship($user);

			        	}else{
				    		$state_friendship = 'friend';
			        		RedUsuario::confirmFriendship($user, Auth::user()->codigo_usuario);
			        	}
		        	break;

			        case 'friend':
				    	$state_friendship = 'invitation';
			        	RedUsuario::cancelFriendship($user);
			    	break;

				    case 'waiting_answer':
				    	$state_friendship = 'invitation';
			        	RedUsuario::cancelFriendship($user);
			        break;
				}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'state_friendship' => $state_friendship]);

			}catch(\Predis\Connection\ConnectionException $e){
				// Commit Transaction
				DB::commit();
				Log::error($e->getMessage());
				return response()->json(['success' => true, 'state_friendship' => $state_friendship]);

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
	 * @return Response
	 */
	public function destroy(Request $request, $id)
    {
    	//
    }

	/**
	 * Confirm invitation to user network.
	 *
	 * @return Response
	 */
	public function confirm(Request $request)
	{
		try{
  			// Decrypt src-params
			list($seg_usuario) = TuProyecto::decryptSrcParams($request->seg);
			if(!$seg_usuario || !is_numeric($seg_usuario)) {
				abort(403);
			}
            
			list($codigo_usuario) = TuProyecto::decryptSrcParams($request->u);
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				abort(403);
			}

			$seg_user = Usuario::find($seg_usuario);
	        if(!$seg_user instanceof Usuario) {
				abort(403);
			}

			$user = Usuario::find($codigo_usuario);
	        if(!$user instanceof Usuario) {
				abort(403);
			}

			RedUsuario::confirmFriendship($user,$seg_user->codigo_usuario);
        	Auth::loginUsingId($seg_user->codigo_usuario);
			return Redirect::route('usuario.nickname.tab', ['nickname' => $user->nickname_usuario, 'tab'=>'basico']);

		}catch(\Exception $e){
    		Log::error($e);
    		return Redirect::route('home');
		}
	}

}
