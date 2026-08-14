<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Artisaninweb\SoapWrapper\SoapWrapper;

use Custom\RedCoomeva;
use App\Custom\Compensar;
use App\Custom\Cenisoft;

use App\Usuario, App\RegistroSesion, App\Estado, App\UsuarioInstitucion, App\RolUsuarioInstitucion, App\RolInstitucion, App\Persona, App\Entidad, App\DatoEntidad, App\ClaseEmprendimiento, App\PrivacidadContenido, App\Rol, App\Institucion, App\Canal, App\CategoriaCanal, App\VinculoCanal, App\ListaOcupacion, App\LocalidadCiudad, App\BarrioLocalidad, App\Estrato, App\TipoVivienda, App\SectorTrabajo, App\Autodenominacion, App\GrupoPoblacional, App\GrupoComunitario, App\GrupoSocial, App\NivelIdioma;

use TuProyecto, Request, Redirect, View, Response, Auth, App, Input, DB, Session, Validator, Log, Cache, Config;

class UsuarioController extends Controller {

	/**
	* @var SoapWrapper
	*/
	protected $soapWrapper;

    /**
     * Instantiate a new UsuarioController instance.
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->middleware('auth', ['except' => ['deactivation', 'store', 'showUrl', 'confirmAccount', 'verifyEmail','listProviders']]);
        $this->middleware('intended', ['only' => ['showUrl']]);
        $this->middleware('subscription', ['only' => ['index', 'socialNetworks']]);

        $this->soapWrapper = $soapWrapper;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()) {
		if(Input::has('data') || Input::has('dataId')){
			return response()->json(Usuario::getConsultants());
		}
		return response()->json(Usuario::getDataUsers());
	}
        return view('core.user.main');
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
		// Basic data validate
		$data = Input::all();
        $user = new Usuario;
		if ($user->isValid($data)) {
			// Advanced data validation
			$validator = Validator::make(Input::all(), [
				'password' => 'required|min:4|confirmed',
			]);

            if($validator->fails()) {
				return redirect()->route('register')->withErrors($validator->errors())->withInput();
			}

			DB::beginTransaction();
			try{
				$user = Usuario::store($data);
				// dd($user);
				if(gettype($user) != "object") {
					throw new \Exception("Error creando usuario");
				} elseif ($user->exist) {
					DB::rollback();
					Log::error(sprintf('%s:%s', 'UsuarioController store', 'Usuario ya existente'));
					return redirect()->route('register')->withErrors(trans('app.exception.userexist'))->withInput();
				}

				// Send mail confirmation
				$user->sendConfirmacionEmail($data);

				// Commit Transaction
				DB::commit();

				// Login User
	        	Auth::loginUsingId($user->codigo_usuario);
				return Redirect::intended(RegistroSesion::getInstitutionHome());

			}catch(\Exception $e) {
				DB::rollback();
				Log::error(sprintf('%s:%s', 'UsuarioController store', $e->getMessage()));
				return redirect()->route('register')->withErrors(trans('app.exception'))->withInput();
			}
		}
		return redirect()->route('register')->withErrors($user->errors)->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
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
	public function update($id)
	{
		if (Request::ajax()) {
			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				abort(403);
			}

			$attributesLog = [];

			// User
			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
    			abort(404);
            }

            // User institution
            $userInstitution = UsuarioInstitucion::where('codigo_usuario', '=', $user->codigo_usuario)
                ->where('codigo_institucion', '=', RegistroSesion::getInstitution())
                ->first();
            if(!$userInstitution instanceof UsuarioInstitucion) {
                Log::error(sprintf('%s:%s', 'UsuarioController update', 'el usuario no esta asociado a la institucion'));
                if(Request::ajax()){
                    return Response::json(['success' => false, 'errors' => trans('app.exception')]);
                }
                abort(404);
            }

			// Person
			$person = Persona::where('codigo_usuario', $user->codigo_usuario)->first();
			if(!$person instanceof Persona) {
    			abort(404);
			}

			$data = Input::all();
			if ($user->isValidUpdate($data)) {
				// Validate user update
				if(Auth::user()->codigo_usuario === $user->codigo_usuario) {
					DB::beginTransaction();
		        	try {
						if (Request::has('movil_usuario') && $user->movil_usuario !== Request::get('movil_usuario')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " movil usuario," : $attributesLog['modification'] = 'movil usuario,';
						}

						if (Request::has('direccion_usuario') && $user->direccion_usuario !== Request::get('direccion_usuario')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " direccion usuario," : $attributesLog['modification'] = 'direccion usuario,';
						}

						if (Request::has('telefono_usuario') && $user->telefono_usuario !== Request::get('telefono_usuario')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " telefono usuario," : $attributesLog['modification'] = 'telefono usuario,';
						}

						if (Request::has('genero_persona') && $person->genero_persona !== (int)Request::get('genero_persona')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " genero usuario," : $attributesLog['modification'] = 'genero usuario,';
						}

						if (Request::has('estado_civil_persona') && $person->estado_civil_persona !== (int)Request::get('estado_civil_persona')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " estado civil," : $attributesLog['modification'] = 'estado civil,';
						}

						if (Request::has('nombre_usuario') && $user->nombre_usuario !== Request::get('nombre_usuario')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " nombre usuario," : $attributesLog['modification'] = 'nombre usuario,';
						}

						if (Request::has('primer_apellido_persona') && $person->primer_apellido_persona !== Request::get('primer_apellido_persona')) {
							isset($attributesLog['modification']) ? $attributesLog['modification'] .= " primer apellido," : $attributesLog['modification'] = 'primer apellido,';
						}

						// User
						$user->fill($data);
                        $user->save();

                        // Person
                        $person->fill($data);
						$person->save();

                        // User institution
                        if(empty($userInstitution->fecha_registro_info_basica)){
                            $userInstitution->fecha_registro_info_basica = date('Y-m-d H:i:s');
                            $userInstitution->save();
                        }

						// Prepare response
						$response = Usuario::buildUser(Usuario::getDataUser($user->nickname_usuario));
						$response->success = true;


						activity()
							->performedOn($user)
							->withProperties([
								'attributes' => $attributesLog ])
							->log('activitylog.user.modifications');

						// Commit Transaction
						DB::commit();
			   			return Response::json($response);
					}catch(\Exception $e){
					    DB::rollback();
						Log::error(sprintf('%s:%s', 'UsuarioController update', $e->getMessage()));
						return Response::json(['success' => false, 'errors' => trans('app.exception')]);
					}
				}
				abort(403);
			}
			return Response::json(['success' => false, 'errors' => $user->errors]);
		}
    	abort(404);
	}

	/**
	 * Update the social networks resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function socialNetworks($id)
	{
		if (Request::ajax()) {
			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				abort(403);
			}

			// User
			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
    			abort(404);
			}

			$data = Input::all();
			if ($user->isValidUpdate($data)) {
				// Validate user update
				if(Auth::user()->codigo_usuario === $user->codigo_usuario) {
					DB::beginTransaction();
		        	try {
		        		// User
						$user->fill($data);
			   			$user->save();

						// Prepare response
						$response = Usuario::buildUser(Usuario::getDataUser($user->nickname_usuario));
						$response->success = true;

						// Commit Transaction
						DB::commit();
			   			return Response::json($response);
					}catch(\Exception $e){
					    DB::rollback();
						Log::error(sprintf('%s:%s', 'UsuarioController update', $e->getMessage()));
						return Response::json(['success' => false, 'errors' => trans('app.exception')]);
					}
				}
				abort(403);
			}
			return Response::json(['success' => false, 'errors' => $user->errors]);
		}
    	abort(404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Decrypt src-params
		list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
			abort(403);
		}
        $user = Usuario::find($codigo_usuario);
        if(!$user instanceof Usuario) {
            abort(404);
        }

        $userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario);
        // Validate user update Cancel Account
        if(in_array(Auth::user()->codigo_usuario, [$userInstitution->codigo_usuario])) {
            DB::beginTransaction();
            try {

                // Update Mentoring institution
                UsuarioInstitucion::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion )->where('codigo_institucion', RegistroSesion::getInstitution())
                    ->update(['codigo_estado' => Estado::getState('removed')]);

                DB::commit();
                Auth::logout();
                return redirect('deactivation');
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
	}

	/**
	 * Return view confirm profile.
	 *
	 * @return Response
	 */
	public function confirmprofile()
	{
        $stratum = Estrato::stratum();
        $homeboss = Persona::$homeboss;
		$zone = BarrioLocalidad::zone([]);
        $disability = Persona::$disability;
        $maritalStatus = Usuario::$maritalStatus;
		$workSector = SectorTrabajo::workSector();
		$socialGroup = GrupoSocial::socialGroup();
		$housingType = TipoVivienda::housingType();
		$locations = LocalidadCiudad::locations([]);
        $institution = RegistroSesion::institution();
        $languageLevel = NivelIdioma::languageLevel();
		$communityGroup = GrupoComunitario::communityGroup();
		$selfDomination = Autodenominacion::selfDomination();
		$populationGroup = GrupoPoblacional::populationGroup();
		$userNicknameProvisional = '';
		if (!Auth::user()->nickname_usuario) {
			$userMailExpldoe = explode('@', Auth::user()->correo_electronico);
			$userNickname = TuProyecto::unwantedCharacters($userMailExpldoe[0]);
			$userNicknameProvisional = Usuario::validateNinckname(str_slug(str_limit($userNickname, 10), ""));
		}

		$templateForm = '';
		switch ($institution->codigo_institucion) {
			case Institucion::getInstitution('siinova'):
				$templateForm = 'formSiinova';
				break;
			case Institucion::getInstitution('rutan'):
				$templateForm = 'formRutan';
					break;
			case Institucion::getInstitution('propace'):
				$templateForm = 'formPropace';
					break;
			default:
				$templateForm = 'formGeneral';
				break;
		}

		// dd($templateForm);

		return view('core.middleware.profile', compact(
												'institution',
												'zone',
												'stratum',
												'locations',
												'housingType',
												'workSector',
												'selfDomination',
												'populationGroup',
												'communityGroup',
												'socialGroup',
												'languageLevel',
												'homeboss',
												'disability',
												'maritalStatus',
												'userNicknameProvisional',
												'templateForm'
											));
	}

	/**
	 * Return view confirmdeactivation account .
	 *
	 * @return Response
	 */
	public function confirmdeactivation()
	{
		return view('core.user.confirmdeactivation');
	}

	/**
	 * Return view deactivation account .
	 *
	 * @return Response
	 */
	public function deactivation()
	{
		return view('core.user.deactivation');
	}

	/**
	 * Return view .
	 *
	 * @return Response
	 */
	public function confirm()
	{
		return view('core.middleware.confirm');
	}

	/**
	 * Return view choice channels.
	 *
	 * @return Response
	 */
	public function channelschoice()
	{
		$data = [];
		$data['channels'] = Canal::getChannels();
		$data['categories'] = CategoriaCanal::getCategories();
		$data['suggestions'] = VinculoCanal::getSuggestions();

		return view('core.middleware.channels', $data);
	}

	/**
	 * Return view choice channels.
	 *
	 * @return Response
	 */
	public function createentity()
	{
		if( !RegistroSesion::institution()->pasos_complementarios_registro ) {
			return redirect( RegistroSesion::getInstitutionHome() );
		}
		return view('core.middleware.entity');
	}

	/**
	 * Return view verify account .
	 *
	 * @return Response
	 */
	public function verifyaccount()
	{
		// Institution
		$userinstitution = Auth::user()->institucion;
		if($userinstitution->usuario_verificado) {
			return redirect( RegistroSesion::getInstitutionHome() );
		}

		// Prepare data
		$data = [];
		$data['institution'] = $userinstitution->institucion;

		// Before actions verify
		switch ($userinstitution->codigo_institucion) {
			case Institucion::getInstitution('redcoo'):
				$data['custom'] = true;
				$data['response'] = RedCoomeva::verifyaccount(Auth::user(), $this->soapWrapper);
				break;
			case Institucion::getInstitution('compensar'):
				$data['custom'] = true;
				$data['response'] = Compensar::verifyaccount(Auth::user());
				break;
			case Institucion::getInstitution('cenisoft'):
				$data['custom'] = true;
				$data['response'] = Cenisoft::verifyaccount(Auth::user());
				break;
		}
		return view('core.user.verify', $data);
	}

	/**
	 * Return view verify account email.
	 *
	 * @return Response
	 */
	public function verifyaccountmail($codigo_usuario)
	{
		// Decrypt src-params
        list($codigo_usuario) = TuProyecto::decryptSrcParams($codigo_usuario);
        if(!$codigo_usuario) {
       		abort(403);
        }

		$user = Usuario::find($codigo_usuario);
		if(!$user instanceof Usuario) {
			abort(403);
		}

		DB::beginTransaction();
		try {
			// Usuario institucion
			$userinstitution = $user->institucion;

			if(!$userinstitution->usuario_verificado) {
				// Set active state user
				$userinstitution->usuario_verificado = true;
				$userinstitution->save();

				// Others actions verify
				switch ($userinstitution->codigo_institucion) {
					case Institucion::getInstitution('redcoo'):
						RedCoomeva::verify($user);
					break;
				}

				// Commit Transaction
				DB::commit();

				Auth::loginUsingId($user->codigo_usuario);
				return redirect( RegistroSesion::getInstitutionHome() );
			}

			DB::rollback();
			return redirect( RegistroSesion::getInstitutionHome() );
		}catch(\Exception $e){
			DB::rollback();
			Log::error($e->getMessage());
			abort(500);
		}
	}

	/**
	 * Verify Email
	 *
	 * @return Response
	 */
	public function verifyEmail()
	{
		if (Request::ajax()) {
			try {
				if(Input::has('email'))
				{
					$user = Usuario::getUserMail(Input::get('email'));
					if($user instanceof Usuario)
					{
						$lastname = '';
						if($user->tipo_usuario == Usuario::typeUser('person')) {
							$person = Persona::where('codigo_usuario', $user->codigo_usuario)->first();
							$lastname = $person->primer_apellido_persona;
						}

						return Response::json(['success' => true, 'labelname' => $user->nombre_usuario, 'labellastname' => $lastname]);
					}
					return Response::json(['success' => false, 'vincular_contactos' => $institucion = Institucion::find(RegistroSesion::getInstitution())->vincular_contactos_externos]);
				}
				return Response::json(['success' => false, 'errors' => 'email no valido']);
			}catch(\Exception $e){
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
    	abort(404);
	}

	/**
	 * Verify username available
	 *
	 * @return Response
	 */
	public function usernameAvailable()
	{
		if (Request::ajax()) {
			// Path
			$path = route('usuario.nickname', ['nickname' => trim(Input::get('nickname'))]);

			// Validate nickname
			$rules = [
				'nickname' => 'required|min:3|regex:/^[a-zA-Z0-9_-]{0,15}$/'
			];
			$messages = [
				'nickname.min' => 'El nombre de usuario es demasiado corto.<br>',
				'nickname.required' => 'El nombre de usuario es requerido.<br>',
				'nickname.regex' => "Utiliza sólo letras, números y '_ -' y un máximo de 16 carácteres.<br>",
			];
			$validator = Validator::make(['nickname' => trim(Input::get('nickname'))], $rules, $messages);
			if (!$validator->passes()) {
				$messages = $validator->errors();
				return Response::json(['success' => false, 'message' => $messages->first(), 'path' => $path]);
			}

			// Validate user
			$user = Usuario::getUser(Input::get('nickname'));
			if($user instanceof Usuario) {
				if(Auth::user()->codigo_usuario == $user->codigo_usuario) {
					return Response::json(['success' => true, 'message' => '¡Este/a eres tú!', 'path' => $path]);
				}
				return Response::json(['success' => false, 'message' => 'Este nombre de usuario ya está registrado.<br>', 'path' => $path]);
			}
			return Response::json(['success' => true, 'message' => '¡Disponible!', 'path' => $path]);
		}
    	abort(404);
	}

	/**
	 * Send confirmation mail message.
	 *
	 * @return Response
	 */
	public function sendMailConfirmation()
	{
		if (Request::ajax()) {
			DB::beginTransaction();
        	try {
        		$user = Usuario::getUserMail(Input::get('correo_electronico'));
        		if( !$user instanceof Usuario || ($user instanceof Usuario && $user->codigo_usuario == Auth::user()->codigo_usuario) ) {
	        		if(!$user instanceof Usuario) {
	        			$user = Auth::user();
	        		}
	        		$user->correo_electronico = Input::get('correo_electronico');
	        		$user->save();

					// Send mail confirmation
					$user->sendConfirmacionEmail();

					// Commit Transaction
					DB::commit();
		   			return Response::json(['success' => true, 'message' => trans('app.confirm.mail.success', ['mail' => $user->correo_electronico])]);
        		}

        		DB::rollback();
	   			return Response::json(['success' => false, 'errors' => trans('validation.unique', ['attribute' => 'Correo electronico'])]);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error($e->getMessage());
				return Response::json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
    	abort(404);
	}

	/**
	 * Send confirmation account mail message.
	 *
	 * @return Response
	 */
	public function confirmAccount($correo_electronico)
	{
		// Decrypt src-params
        list($correo_electronico) = TuProyecto::decryptSrcParams($correo_electronico);
        if(!$correo_electronico) {
       		abort(403);
        }

		$user = Usuario::getUserMail($correo_electronico);
		if(!$user instanceof Usuario) {
			abort(403);
		}

		DB::beginTransaction();
		try {


			if($user->codigo_estado == Estado::getState('confirm')) {
				// Set active state user
				$user->codigo_estado = Estado::getState('active');
				$user->save();

				// Commit Transaction
				DB::commit();

				// Login user
				Auth::loginUsingId($user->codigo_usuario);
				return redirect()->intended(RegistroSesion::getInstitutionHome());
			}

			DB::rollback();
			return redirect()->intended(RegistroSesion::getInstitutionHome());
		}catch(\Exception $e){
			DB::rollback();
			Log::error($e->getMessage());
			abort(500);
		}
	}

	/**
	 * Display the resource from url.
	 *
	 * @param  String  $nickname
	 * @return Response
	 */
	public function showUrl($id, $tab = null)
	{
		// Type encrypt params
		switch (Input::has('type')) {
		    case 'encrypt':
				// Decrypt src-params
				list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
					abort(403);
		 		}
		 		$user = Usuario::select('usuario.*', 'codigo_persona', 'primer_apellido_persona', 'segundo_apellido_persona', 'genero_persona', 'estado_civil_persona','forma_ayuda_mentoria')
		 			->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario')
		 			->where('usuario.codigo_usuario', '=', $codigo_usuario)
		 			->first();
		        break;
			default:
				$user = Usuario::getDataUser($id);
				break;
		}

		if(!$user instanceof Usuario) {
            abort(404);
		}

		if (Request::ajax()) {
			return Response::json( Usuario::buildUser($user) );
		}
		return view('core/user/main');
	}

	/**
	 * Display the resource from session.
	 *
	 * @return Response
	 */
	public function auth()
	{
		if (Request::ajax()) {
			$user = Usuario::getUserId(Auth::user()->codigo_usuario);
	 		if(!$user instanceof Usuario) {
	            abort(404);
			}

			return Response::json( Usuario::buildUser($user) );
		}
		abort(404);
	}

	/**
	 * Display a listing of the sellers for filters.
	 *
	 * @return Response
	 */
	public function listProviders()
	{
		if(Request::ajax()) {
			if(Input::has('data') || Input::has('dataId')){
				$response =  Usuario::getConsultants();
				return response()->json($response);
			}
			return response()->json(Usuario::getDataUsers());
		}
		abort(404);
	}
}
