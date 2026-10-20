<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Request, Response, View, Auth, Input, App, DB, Log, Lang, URL;

use TuProyecto, SendEmail, Config, Queue, Session;

use App\ModeloNegocio, App\Estado, App\RegistroSesion, App\PrivacidadContenido, App\ClaseEmprendimiento, App\GrupoProyecto, App\Tag, App\TagUsuario, App\Entidad, App\Usuario, App\UsuarioInstitucion, App\Rol, App\DatoEntidad, App\Grupo, App\Institucion, App\ClaseEmprendimientoInstitucion;

class ProyectoController extends Controller {

    /**
     * Instantiate a new ProyectoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','showUrl']]);
		// $this->middleware('subscription', ['only' => ['create', 'showUrl']]);
		$this->middleware('subscription', ['only' => ['create']]);
		$this->middleware('intended', ['only' => ['index', 'showUrl']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()) {
			return Response::json(Entidad::getEntitys());
		}

		return View::make('core/project/main');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('core.project.main');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store()
	{
		if (Request::ajax()) {
			$data = Input::all();
			$entity = new Entidad;
			if ($entity->isValid($data)) {

				DB::beginTransaction();
	        	try {
	        		//User
	        		$user = new Usuario;
	        		$user->codigo_estado = Estado::getState('active');
	        		$user->nombre_usuario = Input::get('nombre_usuario');
	        		$user->biografia_usuario = Input::get('biografia_usuario');
	        		$user->codigo_ciudad = Input::get('codigo_ciudad');
	        		$user->tipo_usuario = Usuario::typeUser('entity');
	        		$user->imagen_usuario = Config::get('tuproyecto.no_project_image');
	        		$username = TuProyecto::unwantedCharacters(Input::get('nombre_usuario'));
					$usernickname= Usuario::validateNinckname(\Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($username, 16, ''), ""));
	        		$user->nickname_usuario = $usernickname;
	        		if( Input::has('identificacion_usuario') && Input::get('identificacion_usuario') != '' ){

						// Valid User
						$userValid = Usuario::join('core.usuario_institucion', 'usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
							->where('identificacion_usuario', Input::get('identificacion_usuario'))
							->where('tipo_usuario', Usuario::typeUser('entity'))
							->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())->first();

						if($userValid instanceof Usuario) {
							DB::rollback();
							Log::error(sprintf('%s:%s', 'ProyectoController:store', 'Ya existe una empresa con esa identificacion'));
							return Response::json(array('success' => false, 'errors' => 'No se puede crear la empresa, ya existe una con el mismo numero de identificacion'));
						}

	        			$user->identificacion_usuario = Input::get('identificacion_usuario');
	        		}

					if( Input::has('pagina_web_usuario') && Input::get('pagina_web_usuario') != '' ){
						$user->pagina_web_usuario = Input::get('pagina_web_usuario');
					}

					if( Input::has('facebook_usuario') && Input::get('facebook_usuario') != '' ){
						$user->facebook_usuario = Input::get('facebook_usuario');
					}

					if( Input::has('twitter_usuario') && Input::get('twitter_usuario') != '' ){
						$user->twitter_usuario = Input::get('twitter_usuario');
					}

					if( Input::has('linkedin_usuario') && Input::get('linkedin_usuario') != '' ){
						$user->linkedin_usuario = Input::get('linkedin_usuario');
					}

					if( Input::has('instagram_usuario') && Input::get('instagram_usuario') != '' ){
						$user->instagram_usuario = Input::get('instagram_usuario');
					}

					if( Input::has('tiktok_usuario') && Input::get('tiktok_usuario') != '' ){
						$user->tiktok_usuario = Input::get('tiktok_usuario');
					}

					if( Input::has('telefono_usuario') && Input::get('telefono_usuario') != '' ){
						$user->telefono_usuario = Input::get('telefono_usuario');
					}

					if( Input::has('numero_whatsapp') && Input::get('numero_whatsapp') != '' ){
						$user->numero_whatsapp = Input::get('numero_whatsapp');
					}

					if( Input::has('fecha_nacimiento_usuario') &&   preg_replace("/[^a-zA-Z0-9]/", "", Input::get('fecha_nacimiento_usuario')) != '' ){
	        			$user->fecha_nacimiento_usuario = Input::get('fecha_nacimiento_usuario');
					}

		   			$user->save();

		   			//user Institution
		   			$userInstitution = new UsuarioInstitucion;
		            $userInstitution->codigo_usuario = $user->codigo_usuario;
		            $userInstitution->codigo_institucion = RegistroSesion::getInstitution();
					$userInstitution->codigo_estado = Estado::getState('active');
					$userInstitution->fecha_registro_usuario = date('Y-m-d');
		   			$userInstitution->hora_registro_usuario = date('H:i:s');
					$userInstitution->codigo_rol = Rol::getRole('user');
		   			$userInstitution->save();

					// Entity
					$entity->fill($data);
		   			$entity->codigo_usuario = $user->codigo_usuario;
		   			$entity->seg_codigo_usuario = Auth::user()->codigo_usuario;
		   			$entity->codigo_clase_empre_insti = Input::get('codigo_clase_empre_insti');
		   			if(Input::has('codigo_categoria_clase_espacio') && Input::get('codigo_categoria_clase_espacio')!=0){
	        			$entity->codigo_categoria_clase_espacio = Input::get('codigo_categoria_clase_espacio');
	        		}

					if ( Input::has('correo_contacto') && Input::has('correo_contacto') != '' ) {
						$entity->correo_contacto_entidad = Input::get('correo_contacto');
					}

		   			$entity->save();

		   			//Data Entity
		   			$dataEntity = new DatoEntidad;
		            $dataEntity->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
					$dataEntity->codigo_privacidad_contenido = PrivacidadContenido::getPrivacy('public');
					$dataEntity->codigo_estado = Estado::getState('active');
					if(Input::has('codigo_categoria_proyecto') && Input::get('codigo_categoria_proyecto')!=0){
						$dataEntity->codigo_categoria_proyecto = Input::get('codigo_categoria_proyecto');
	        		}

					$classEntrepreneurship = ClaseEmprendimientoInstitucion::find($entity->codigo_clase_empre_insti);
					if(!$classEntrepreneurship instanceof ClaseEmprendimientoInstitucion) {
			            abort(404);
					}

		   			switch ($classEntrepreneurship->codigo_clase_emprendimiento) {
					    case ClaseEmprendimiento::getClass('entrepreneurship'):
				    		if(Input::has('codigo_etapa_proyecto')){
			            		$dataEntity->codigo_etapa_proyecto = Input::get('codigo_etapa_proyecto');
			            	}
				        break;

					    case ClaseEmprendimiento::getClass('company'):
				    		if(Input::has('codigo_etapa_proyecto')){
								$dataEntity->codigo_etapa_proyecto = Input::get('codigo_etapa_proyecto');
							}
				        break;
					}

					$dataEntity->save();

					// Queue email
					// Queue::push('App\Entidad@notification',['codigo_entidad' => $entity->codigo_entidad,'codigo_institucion' => $userInstitution->codigo_institucion]);

		   			// Prepare response
                    $response = Entidad::buildEntity(Entidad::getEntityUrl($user->nickname_usuario));
					$response->success = true;

					// Commit Transaction
					DB::commit();
					return Response::json($response);

				}catch(\Exception $e){
				    DB::rollback();
					Log::error(sprintf('%s:%s', 'ProyectoController:store', $e->getMessage()));
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}
			return Response::json(array('success' => false, 'errors' => $entity->errors));
		}
    	abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($url)
	{
		if (Request::ajax()) {
			$question = Entidad::getEntityUrl($url);

			if(!$question instanceof Entidad) {
	            abort(404);
			}

			$response =  Response::json(Entidad::buildEntity($question));

			return $response;
		}
		abort(404);
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
		if(Request::ajax()) {
			// Decrypt src-params
            list($codigo_entidad) = TuProyecto::decryptSrcParams($id);
            if(!$codigo_entidad || !is_numeric($codigo_entidad)) {
          		abort(403);
            }

            $entity = Entidad::find($codigo_entidad);
			if(!$entity instanceof Entidad) {
	            abort(404);
			}
			$user = Usuario::find($entity->codigo_usuario);
			if(!$user instanceof Usuario) {
	            abort(404);
			}

			// Validate users update entity
			if(in_array(Auth::user()->codigo_usuario, $entity->getAllowedUsers())) {
				$data = Input::all();
				DB::beginTransaction();
	        	try{
	        		$entity->fill($data);
	        		if(Input::has('codigo_clase_empre_insti')){
	        			$entity->codigo_clase_empre_insti = Input::get('codigo_clase_empre_insti');
	        		}
	        		$user->fill($data);

	        		if(Input::has('email')){
		        		$exitEmail = Usuario::getUserMail(Input::get('email'));
						if(!$exitEmail instanceof Usuario){
							// Add new user contact
			            	$data = [];
			            	$data['nombre_usuario'] = Input::get('nombre_usuario_contacto');
			            	$data['primer_apellido_persona'] = Input::get('primer_apellido_persona');
			            	$data['segundo_apellido_persona']= Input::get('segundo_apellido_persona');
			            	$data['genero_persona']= Input::get('genero_persona');
			            	$data['correo_electronico'] = Input::get('email');
			            	$usercontact = Usuario::store($data);
			            	$newcontact = $usercontact->codigo_usuario;
						}else{
							$newcontact = $exitEmail->codigo_usuario;
						}
		            	Entidad::where('seg_codigo_usuario', '=', $user->codigo_usuario)
						->update(['seg_codigo_usuario' => $newcontact ]);
						Entidad::where('codigo_usuario', '=', $user->codigo_usuario)
						->update(['codigo_clase_empre_insti' => Input::get('codigo_clase_empre_insti'), 'codigo_categoria_clase_espacio' => Input::get('codigo_categoria_clase_espacio') ]);
					}
					if (Input::has('nombre_usuario')) {
						$user->nombre_usuario = Input::get('nombre_usuario');
					}

					if (Input::has('correo_contacto')) {
						$entity->correo_contacto_entidad = Input::get('correo_contacto');
					}

					// user Institution
					$userInstitution = UsuarioInstitucion::getUserInstitution($entity->codigo_usuario);

					//data Entity
		   			$entityData = DatoEntidad::where('codigo_usuario_institucion',$userInstitution->codigo_usuario_institucion)->where('codigo_estado', Estado::getState('active'))->first();
		   			if($entityData instanceof DatoEntidad) {
		   				$data = [];
		   				if(Input::has('codigo_categoria_proyecto') && Input::get('codigo_categoria_proyecto')!=0){
		   					$data['codigo_categoria_proyecto'] = Input::get('codigo_categoria_proyecto');
						}
						if(Input::has('cor_codigo_categoria_proyecto') && Input::get('cor_codigo_categoria_proyecto')!=0){
		   					$data['cor_codigo_categoria_proyecto'] = Input::get('cor_codigo_categoria_proyecto');
						}
						if(Input::has('codigo_privacidad_contenido') && Input::get('codigo_privacidad_contenido')!=0 ){
							$data['codigo_privacidad_contenido'] = Input::get('codigo_privacidad_contenido');
						}
						if(Input::has('codigo_etapa_proyecto') && Input::get('codigo_etapa_proyecto')!=0){
							$data['codigo_etapa_proyecto'] = Input::get('codigo_etapa_proyecto');
						}
						if(Input::has('codigo_sector_economico') && Input::get('codigo_sector_economico')!=0){
							$data['codigo_sector_economico'] = Input::get('codigo_sector_economico');
						}
			         	// Set data
			         	if(is_array($data) && count($data)) {
							DatoEntidad::where('codigo_dato_entidad', '=', $entityData->codigo_dato_entidad)->where('codigo_estado', '=', Estado::getState('active'))
							->update($data);
						}
					}
					$entity->save();
					$user->save();

					// Tags user
                    $inputTags = [];
			   		if(Input::get('update_tags')){
			   			$inputTags = explode(',', Input::get('tags_usuario'));
						$tags = $user->tags()->get();
						foreach ($tags as $tag) {
							if(!in_array($tag->texto_tag, $inputTags)) {
								$user->tags()->detach($tag);
							}
						}
		   			}
					if(Input::has('tags_usuario') && is_array($inputTags) && count($inputTags) > 0) {
				   		foreach($inputTags as $item) {
							if(!$tags->contains('texto_tag', $item)){
		   			  			$tag = Tag::firstOrCreate(['texto_tag' => $item]);
								if(!$tag instanceof Tag) {
									throw new Exception('tag not found');
								}
								$user->tags()->attach($tag);
							}
					   	}
					}

					// Prepare response
					$response = Entidad::buildEntity(Entidad::getEntityUrl($user->nickname_usuario));
					$response->success = true;
					$response->redirect = url(RegistroSesion::getInstitutionHome());
					DB::commit();
					return Response::json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error(sprintf('%s:%s', 'ProyectoController:update', $e->getMessage()));
					return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
			abort(403);
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
		if (Request::ajax()) {

			// Decrypt src-params
            list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
            if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
                App::abort(403);
            }
			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
	            abort(404);
			}

			$userInstitution = UsuarioInstitucion::where('codigo_usuario',$user->codigo_usuario)->where('codigo_institucion',RegistroSesion::getInstitution())->first();

			if(!$userInstitution instanceof UsuarioInstitucion) {
				abort(404);
			}

			DB::beginTransaction();
			try {

				// Set removed state
				UsuarioInstitucion::where('codigo_usuario', '=', $userInstitution->codigo_usuario)->where('codigo_institucion', '=', $userInstitution->codigo_institucion)
					->update(array('codigo_estado' => Estado::getState('removed')));

				DB::commit();
				return Response::json(array('success' => true));
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
		}
    	abort(404);
	}

	/**
	* Display the resource from url.
	*
	* @param  String  $category
	* @param  String  $project
	* @return Response
	*/
	public function showUrl($id, $tab = null)
	{
		// Type encrypt params
		switch (Input::get('type')) {
		    case 'encrypt':
				// Decrypt src-params
				list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
					App::abort(403);
				 }

		 		$user = Entidad::select('usuario.*','entidad.codigo_entidad','entidad.seg_codigo_usuario')
		 			->join('seguridad.usuario', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario')
		 			->where('entidad.codigo_usuario', '=', $codigo_usuario)
		 			->first();
		        break;
			default:
				$user = Entidad::getEntityUrl($id);
			break;
		}

		if(!$user instanceof Entidad) {
            if (Request::ajax()) {
                Log::error(sprintf('%s:%s', 'ProyectoController::showUrl', "No se encuentra la entidad de id: ".$id));
                return Response::json(array('success' => false, 'errors' =>"No se encuentra la entidad seleccionada"));
            }

            abort(404);
		}
		if (Request::ajax()) {
			$response = Response::json(Entidad::buildEntity($user));
			return $response;
		}

		$bio = Entidad::buildEntity($user);

		$data = [];
		$data['entity'] = $user;
		$data['biografia'] = $bio->biografia_usuario;
		return View::make('core/project/main', $data);
	}

	/**
	* Display the resource from url.
	*
	* @param  String  $category
	* @param  String  $project
	* @return Response
	*/
	public function showPrivadeUrl($id)
	{
		// Type encrypt params
		switch (Input::has('type')) {
		    case 'encrypt':
				// Decrypt src-params
				list($codigo_usuario) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
					App::abort(403);
		 		}
		 		$user = Entidad::select('usuario.*','entidad.codigo_entidad','entidad.seg_codigo_usuario')
		 			->join('seguridad.usuario', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario')
		 			->where('entidad.codigo_usuario', '=', $codigo_usuario)
		 			->first();
		        break;
		    default:
				$user = Entidad::getEntityUrl($id);
				break;
		}

		if(!$user instanceof Entidad) {
            abort(404);
		}
		if (Request::ajax()) {
			return Response::json(Entidad::buildEntity($user));
		}

		$data = [];
		$data['entity'] = $user;

		return View::make('core/project/main', $data);
	}

}
