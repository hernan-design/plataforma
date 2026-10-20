<?php

namespace App;

use App\Rol;
use App\TerminosCondiciones;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use TuProyecto, SendEmail;
use Cookie, Cache, Config, DB, Auth, Lang, Input, App, Validator, Hash, URL, Log, Session;
use App\Models;
use App\RolUsuario,
	App\Producto,
	App\Estado,
	App\Models\Seguridad\SexoInstitucion;

class Usuario extends BaseModel implements AuthenticatableContract, CanResetPasswordContract, JWTSubject {
	use Authenticatable, CanResetPassword, Notifiable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'seguridad.usuario';

	protected $primaryKey = 'codigo_usuario';

	public $timestamps = false;

	public $errors;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $fillable = [
		'correo_electronico',
		'nombre_usuario',
		'nickname_usuario',
		'codigo_estado',
		'codigo_ciudad',
		'password',
		'biografia_usuario',
		'imagen_usuario',
		'codigo_canal_registro',
		'profesion_usuario',
		'codigo_ciudad',
		'telefono_usuario',
		'movil_usuario',
		'estado_civil',
		'barrio_usuario',
		'direccion_usuario',
		'pagina_web_usuario',
		'experiencia_usuario',
		'descripcion_adicional_usuario',
		'twitter_usuario',
		'facebook_usuario',
		'instagram_usuario',
		'linkedin_usuario',
		'tiktok_usuario',
		'tipo_identificacion_usuario',
		'identificacion_usuario',
		'fecha_nacimiento_usuario',
		'codigo_clase_usuario',
		'codigo_barrio_localidad',
		'codigo_localidad_ciudad',
		'sync_algolia',
		'numero_whatsapp'
	];

	/**
	 * The attributes nulleables from the model.
	 *
	 * @var array
	 */
	protected $nullable = ['fecha_nacimiento_usuario', 'codigo_barrio_localidad', 'codigo_localidad_ciudad', 'descripcion_adicional_usuario'];

 	/**
	 * Marital status
	 *
	 * @var array
	 */
 	public static $maritalStatus = [1 => 'Soltero', 2 => 'Casado', 3 => 'Divorciado', 4 => 'Viudo', 5 => 'Union Libre'];

 	/**
	 * Gender status
	 *
	 * @var array
	 */
 	public static $gender = [1 => 'Hombre', 2  => 'Mujer', 3 => 'Prefiero no decirlo'];

	public function isValid($data)
	{
		$rules = [
			'nombre_usuario' => 'max:250',
			'correo_electronico' => 'email'
		];

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) { return true; }
		$this->errors = $validator->errors();

		return false;
	}

		/**
	* Valid create content.
	*/
	public function isValidMentor($data)
	{
		$rules = [
			'experiencia_usuario'	=> 'required',
			'forma_ayuda_mentoria'	=> 'required',
			'stage_mentoring'		=> 'required',
		];

		$messages = [
			'experiencia_usuario.required'	=> 'El campo "experiencia" es obligatorio',
			'forma_ayuda_mentoria.required'	=> 'El campo "Forma de ayuda de la mentoría" es obligatorio',
			'stage_mentoring.required'		=> 'Debe seleccionar un nivel de desarrollo ',
		];


		$validator = Validator::make($data, $rules, $messages);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public function isValidUpdate($data)
	{
		$rules = array(
			'correo_electronico' => 'email|unique:pgsql.seguridad.usuario,correo_electronico,'.$this->codigo_usuario.',codigo_usuario',
			'nickname_usuario' => 'max:15|unique:pgsql.seguridad.usuario,nickname_usuario,'.$this->codigo_usuario.',codigo_usuario',
			'fecha_nacimiento_usuario' => 'date:Y-m-d'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes())
		{
			// Valid unique identification
			$institution = RegistroSesion::institution();
			if($institution->identificacion_registro && isset($data['identificacion_usuario']) && isset($data['tipo_identificacion_usuario']) && RegistroSesion::getValidateIdentification())
			{
				$query = self::query();
				$query->join('core.usuario_institucion', function($join) use ($institution) {
					$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
						->where('usuario_institucion.codigo_institucion', '=', $institution->codigo_institucion);
				});
				$query->where('usuario.identificacion_usuario', $data['identificacion_usuario']);
				$query->where('usuario.tipo_identificacion_usuario', $data['tipo_identificacion_usuario']);
				$query->where('usuario.codigo_usuario', '!=', $this->codigo_usuario);
				$exist = $query->first();

				if($exist instanceof Usuario) {
	                $this->errors = "Ya se encuentra registrado un tercero con este tipo y número de identificación.";
	                return false;
				}
			}
			return true;

		}
		$this->errors = $validator->errors();
		return false;
	}

	public function isValidEntity($data)
	{
		$rules = array(
			'nombre_usuario' => 'required|max:250'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function typeUser($type) {
    	switch ($type) :
		    case 'person': return 1;
		    case 'entity': return 2;
			default: return 'Not type user identified';
		endswitch;
    }

    public static function classUser($class) {
    	switch ($class) :
		    case 'user': return 1;
		    case 'contact': return 2;
			default: return 'Not class user identified';
		endswitch;
    }

	public static function getDataUsers()
   	{
   		$dataUsers = [];
		$query = Usuario::query();
		$query->select('usuario.*', 'persona.codigo_usuario','codigo_persona','primer_apellido_persona', 'segundo_apellido_persona', 'genero_persona', 'estado_civil_persona', DB::raw('trim(lower(nickname_usuario)) as nickname_usuario'), 'nombre_ciudad', 'nombre_pais', 'usuario_institucion.codigo_usuario_institucion', 'rol_usuario_institucion','forma_ayuda_mentoria','nombre_especialidad', DB::raw('(CASE WHEN mentor.role_id IS NOT NULL THEN true ELSE false END) AS mentor'),
			(Auth::check() ? DB::raw(sprintf('%s %s', RedUsuario::$raw_friendship, 'as state_friendship')) : DB::raw('\'\' as state_friendship'))
		);
		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->leftjoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftjoin('core.especialidad', 'persona.codigo_especialidad', '=', 'especialidad.codigo_especialidad');

		// User institution
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				// ->where('usuario_institucion.codigo_estado', '!=', Estado::getState('removed'))
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
        });

        // State friendship
        $query->leftjoin('core.red_usuario as invitation', function($join) {
			$join->on('usuario.codigo_usuario', '=', 'invitation.seg_codigo_usuario')
				->where('invitation.codigo_usuario', '=', Auth::user()->codigo_usuario)
				->where('invitation.codigo_institucion', '=', RegistroSesion::getInstitution());
        });
        $query->leftjoin('core.red_usuario as answer', function($join) {
			$join->on('usuario.codigo_usuario', '=', 'answer.codigo_usuario')
				->where('answer.seg_codigo_usuario', '=', Auth::user()->codigo_usuario)
				->where('answer.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

		$query->where('usuario.codigo_estado', Estado::getState('active'));
		$query->where('usuario.codigo_usuario', '!=', Auth::user()->codigo_usuario);
		$query->where('usuario.tipo_usuario', self::typeUser('person'));

		$query->whereRaw('(usuario.nombre_usuario IS NOT NULL and usuario.nombre_usuario != \'\')');
		$query->whereRaw('(usuario.nickname_usuario IS NOT NULL and usuario.nickname_usuario != \'\')');
		$query->whereRaw(sprintf('%s != \'friend\'', RedUsuario::$raw_friendship));

		// Mentor
		$query->leftjoin('seguridad.rol_usuario as mentor', function($join) {
			$join->on('mentor.codigo_institucion', '=', 'usuario_institucion.codigo_institucion')
				->on('mentor.user_id', '=', 'usuario_institucion.codigo_usuario')
				->where('mentor.role_id', '=',Rol::getRole('mentor'));
        });

		// Filters
		if(Input::has('city')) {
	 		$query->where('usuario.codigo_ciudad', Input::get('city'));
 		}
 		if(Input::has('rol')) {
 			$query->whereRaw("trim(usuario_institucion.rol_usuario_institucion) != ''");
			$query->whereNotNull('usuario_institucion.rol_usuario_institucion');
			$query->whereRaw("rol_to_array(usuario_institucion.rol_usuario_institucion)::integer[] @> ARRAY['".Input::get('rol')."']::integer[] = true");
	    }
	    if(Input::has('user')) {
			$query->whereRaw("(COALESCE(trim(nombre_usuario), '') || ' ' || COALESCE(trim(primer_apellido_persona), '') || ' ' || COALESCE(trim(segundo_apellido_persona), '')) ilike '%".Input::get('user')."%'");
 		}
 		if(Input::has('nickname')) {
			$query->whereRaw("trim(lower(nickname_usuario)) ilike trim(lower('%".Input::get('nickname')."%'))");
 		}

 		if(Input::has('specialty')) {
 			$specialty = Input::get('specialty');

 			$query->where(function($query) use ($specialty) {
	         	$query->where('persona.codigo_especialidad', '=', $specialty);
	            $query->orWhere(function($query) use($specialty){
                	$query->whereIn('persona.codigo_usuario', function($query) use($specialty){
					    $query->select('especialidad_usuario.codigo_usuario')
						    ->from(with(new EspecialidadUsuario)->getTable())
						    ->whereRaw('especialidad_usuario.codigo_usuario = persona.codigo_usuario')
						    ->where('especialidad_usuario.codigo_especialidad', $specialty)
						    ->where('especialidad_usuario.codigo_estado', Estado::getState('active'));
					})->get();
	            });
            });
    	}

		// Get count posts
		$total_entries = $query->count();
		// Orders
		$query->orderByRaw('COALESCE(answer.codigo_usuario, invitation.codigo_usuario, 0) desc');
		$query->orderBy('usuario.nombre_usuario', 'asc');
		$query->orderBy('persona.primer_apellido_persona', 'asc');
		$query->orderBy('persona.segundo_apellido_persona', 'asc');
		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $user) {
				$dataUsers[] = Usuario::buildUser($user);
			}
		}
		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $dataUsers;
   		return $response;
   	}

	public static function getMaritalStatus($status)
	{
		if(in_array($status, array_keys(Usuario::$maritalStatus))) {
			return Usuario::$maritalStatus[$status];
		}
		return '';
	}

	public static function getGender($gender)
	{
		if(in_array($gender, array_keys(Usuario::$gender))) {
			return Usuario::$gender[$gender];
		}
		return '';
	}

	public static function getArrayGender(): array
	{
		$query = SexoInstitucion::select('sexo.id', 'nombre_sexo')
									->where('codigo_institucion', RegistroSesion::getInstitution())
									->join('seguridad.sexo', 'sexo.id', '=', 'sexo_institucion.sexo_id')
									->get();
		if ($query->count() > 0) {
			$array = [];
			foreach ($query as $key => $value) {
				$array[$value->id] = $value->nombre_sexo;
			}
			return $array;
		}

		return self::$gender;
	}

	public function setNicknameUsuarioAttribute($nickname)
	{
		if (!empty($nickname)) {
			$this->attributes['nickname_usuario'] = trim(strtolower($nickname));
		}
	}

	public function setPasswordAttribute($pass)
	{
    	if (!empty($pass)) {
            $this->attributes['password'] = Hash::make($pass);
        }
	}

	public function setCorreoElectronicoAttribute($email)
	{
    	if (!empty($email)) {
            $this->attributes['correo_electronico'] = trim(strtolower($email));
        }
	}

	public function getDateBirth()
	{
		$date['year'] = ''; $date['month'] = '';  $date['day'] = '';
		if( $this->attributes['fecha_nacimiento_usuario'] ) {
			list($date['year'], $date['month'], $date['day']) = explode('-', $this->attributes['fecha_nacimiento_usuario']);
		}
		return (object) $date;
	}

	public function nickname(){
		return substr("@{$this->attributes['nickname_usuario']}", 0, 16);
	}

	public static function getUser($nickname)
   	{
		return Usuario::whereRaw("trim(lower(nickname_usuario)) = trim(lower('$nickname'))")
			->whereRaw("trim(lower(nickname_usuario)) != ''")
			->whereNotNull('nickname_usuario')->first();
   	}

   	public static function getDataUser($nickname)
   	{
   		$query = Usuario::query();
		$query->select('usuario.*', 'persona.codigo_persona', 'primer_apellido_persona', 'segundo_apellido_persona',
		'persona.genero_persona', 'persona.estado_civil_persona', 'persona.codigo_nivel_educacion',
		DB::raw('trim(lower(nickname_usuario)) as nickname_usuario'), 'nombre_ciudad', 'nombre_pais',
		'usuario_institucion.codigo_usuario_institucion', 'forma_ayuda_mentoria','nombre_especialidad',
		'persona.codigo_especialidad', 'persona.codigo_profesion_persona', 'persona.codigo_ocupacion_persona',
		'rol_usuario_institucion', DB::raw('(CASE WHEN mentor.role_id IS NOT NULL THEN true ELSE false END) AS mentor'),
		'forma_ayuda_mentoria','nivel_educacion_usuario.nombre_nivel_educacion', 'ultimo_ingreso_usuario',
			(Auth::check() ? DB::raw(sprintf('%s %s', RedUsuario::$raw_friendship, 'as state_friendship')) : DB::raw('\'\' as state_friendship')),
			(Auth::check() ? DB::raw(sprintf('%s %s', Auth::user()->codigo_usuario, 'as friendship_codigo_usuario')) : DB::raw('\'\' as friendship_codigo_usuario')),
			DB::raw("(SELECT CASE WHEN aceptacion_terminos.fecha_aceptacion_terminos IS NULL THEN FALSE ELSE TRUE END  FROM seguridad.aceptacion_terminos
  				JOIN param.version_terminos ON aceptacion_terminos.codigo_version_terminos = version_terminos.codigo_version_terminos
                JOIN param.terminos_condiciones ON version_terminos.codigo_terminos_condiciones = terminos_condiciones.codigo_terminos_condiciones
                AND terminos_condiciones.codigo_estado = ".Estado::getState('active')."
  				JOIN core.usuario_institucion ON usuario_institucion.codigo_usuario = usuario.codigo_usuario
  				AND usuario_institucion.codigo_institucion = ".RegistroSesion::institution()->codigo_institucion."
                WHERE terminos_condiciones.tipo_terminos ='".TerminosCondiciones::getTypeTerms('mentoring')."'
  				AND usuario_institucion.codigo_usuario_institucion = aceptacion_terminos.codigo_usuario_institucion) AS terminos_aceptados")
		);

		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->leftjoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftjoin('core.especialidad', 'persona.codigo_especialidad', '=', 'especialidad.codigo_especialidad');

		// User institution
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		// Mentor
		$query->leftjoin('seguridad.rol_usuario as mentor', function($join) {
			$join->on('mentor.codigo_institucion', '=', 'usuario_institucion.codigo_institucion')
				->on('mentor.user_id', '=', 'usuario_institucion.codigo_usuario')
				->where('mentor.role_id', '=',Rol::getRole('mentor'));
        });

		$query->leftJoin('core.nivel_educacion_usuario', 'persona.codigo_persona', '=', 'nivel_educacion_usuario.codigo_persona');
		$query->leftJoin('core.nivel_educacion', function($join){
			$join->on('nivel_educacion_usuario.codigo_nivel_educacion', '=', 'nivel_educacion.codigo_nivel_educacion')
				->where('nivel_educacion_usuario.codigo_estado', '=', Estado::getState('active'));
		});

        // State friendship
        if(Auth::check()) {
	        $query->leftjoin('core.red_usuario as invitation', function($join) {
				$join->on('usuario.codigo_usuario', '=', 'invitation.seg_codigo_usuario')
					->where('invitation.codigo_usuario', '=', Auth::user()->codigo_usuario)
					->where('invitation.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });

	        $query->leftjoin('core.red_usuario as answer', function($join) {
				$join->on('usuario.codigo_usuario', '=', 'answer.codigo_usuario')
					->where('answer.seg_codigo_usuario', '=', Auth::user()->codigo_usuario)
					->where('answer.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });
        }

		$query->whereRaw("trim(lower(nickname_usuario)) = trim(lower('$nickname'))");
		$query->whereRaw("trim(lower(nickname_usuario)) != ''");
		$query->whereNotNull('nickname_usuario');

		return $query->first();
   	}

   	public static function getUserId($id)
   	{
   		$query = Usuario::query();
		$query->select('usuario.*', 'codigo_persona', 'primer_apellido_persona', 'segundo_apellido_persona',
		'genero_persona', 'codigo_nivel_educacion', 'codigo_profesion_persona', 'codigo_ocupacion_persona',
		DB::raw('trim(lower(nickname_usuario)) as nickname_usuario'), 'jefe_hogar', 'discapacidad',
		'codigo_tipo_vivienda', 'codigo_estrato', 'codigo_lista_ocupacion', 'codigo_autodenominacion',
		'codigo_grupo_poblacional', 'codigo_grupo_comunitario', 'codigo_grupo_social', 'forma_ayuda_mentoria',
		DB::raw('(CASE WHEN mentor.role_id IS NOT NULL THEN true ELSE false END) AS mentor'),
		'codigo_sector_trabajo', 'persona.codigo_especialidad as codigo_especialidad_destacada','cor_codigo_ciudad',
		'codigo_nivel_idioma', 'estado_civil_persona');

		$query->join('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		// User institution
		$query->leftjoin('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		// Mentor
		$query->leftjoin('seguridad.rol_usuario as mentor', function($join) {
			$join->on('mentor.codigo_institucion', '=', 'usuario_institucion.codigo_institucion')
				->on('mentor.user_id', '=', 'usuario_institucion.codigo_usuario')
				->where('mentor.role_id', '=',Rol::getRole('mentor'));
        });

		$query->whereRaw("usuario.codigo_usuario = $id");
		return $query->first();
   	}

	public static function getUserById($id)
   	{
   		$query = Usuario::query();
		$query->select('usuario.codigo_usuario', 'seg_codigo_usuario');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->where("usuario.codigo_usuario", "=", $id);
		return $query->first();
   	}

   	public static function getUserMail($email)
   	{

		$institucion = Institucion::find(RegistroSesion::getInstitution());

		if (!$institucion instanceof Institucion) {
			abort(404);
		}

		if ($institucion->vincular_contactos_externos) {
			return Usuario::whereRaw("trim(lower(correo_electronico)) = trim(lower('$email'))")
			->whereRaw("trim(lower(correo_electronico)) != ''")
			->whereNotNull('correo_electronico')->first();
		} else {
			$query = Usuario::query();
			$query->select('usuario.*','usuario_institucion.codigo_usuario_institucion','usuario_institucion.codigo_institucion','usuario_institucion.fecha_registro_usuario' );
			$query->join('core.usuario_institucion', 'usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->whereRaw("trim(lower(correo_electronico)) = trim(lower('$email'))")
				->whereRaw("trim(lower(correo_electronico)) != ''")
				->whereNotNull('correo_electronico');
				// ->where('usuario_institucion.codigo_institucion', '=', $institucion->codigo_institucion);
			// dd('usuario ', $query->get());
			return $query->first();
		}

   	}

   	public static function validateUserNickName($nickname)
   	{
   		$user = Usuario::getUser($nickname);
		if(!$user instanceof Usuario) {
			return true;
		}
		return false;
   	}

	public function getReminderEmail()
	{
		return $this->correo_electronico;
	}

	/**
	* User data validate from nickname.
	*/
	public static function validateNinckname($nickname, $contador = 0)
	{
		if(isset($nickname) && !empty($nickname)){

			//$newnickname = $contador > 0 ? (strlen($nickname) >= 16) ? sprintf("%s%d",substr($nickname,0,-strlen($contador)),$contador) : sprintf("%s%d",$nickname, $contador) : $nickname;

			if ($contador > 0) {
				if (strlen($nickname) >= 16) {
					$caracter = ['_', '-', '.'];
					//$caracter = $caracter[rand(0,2)];

					$newnickname = sprintf("%s%s%d%s",
								       		substr(
												$nickname,
												0,
												-strlen($contador + 2)
											),
												$caracter[rand(0,2)],
												$contador,
												$caracter[rand(0,2)]
										);
				} else {
					$newnickname = sprintf("%s%d",$nickname, $contador);
				}
			} else {
				$newnickname = $nickname;
			}

			$query = Usuario::query();
			$query->select('nickname_usuario');
			$query->whereRaw("trim(lower(nickname_usuario)) ilike trim(lower('$newnickname'))");
			$user = $query->first();

			$contador ++;
			if($user instanceof Usuario){
				$newnickname = Usuario::validateNinckname($nickname, $contador);
			}
			return $newnickname;
		}
		return str_random(16);
	}

	public static function store($data)
	{
		try
		{
			// Valid lower mails
			$userData = Usuario::getUserMail($data['correo_electronico']);
			$userInstitution = null;

			if ($userData instanceof Usuario) { $userInstitution = UsuarioInstitucion::where('codigo_usuario', '=', $userData->codigo_usuario)->where('codigo_institucion', '=', RegistroSesion::getInstitution())->first(); }
			if(!$userInstitution instanceof UsuarioInstitucion && $userData instanceof Usuario) {
				$userInstitution = new UsuarioInstitucion();
				$userInstitution->codigo_usuario = $userData->codigo_usuario;
				$userInstitution->codigo_institucion = RegistroSesion::getInstitution();
				$userInstitution->codigo_estado = RegistroSesion::getInitState();
				$userInstitution->codigo_rol = Rol::getRole('user');
				$userInstitution->fecha_registro_usuario = date('Y-m-d');
				$userInstitution->hora_registro_usuario = date('H:i:s');
				$userInstitution->save();

				return $userInstitution;

			} else if (!$userInstitution instanceof UsuarioInstitucion && !$userData instanceof Usuario) {
				$user = new Usuario;
				// Basic data validate
				if (!$user->isValid($data)) {
					throw new \Exception($user->errors);
				}

				// User
				$user->fill($data);
				$user->codigo_estado = Estado::getState('confirm');
				$user->tipo_usuario = Usuario::typeUser('person');
				// Validate unique nickname
				if (isset($data['nombre_usuario']) && !empty($data['nombre_usuario'])) {
					$nickname_usuario = Usuario::validateNinckname(\Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($data['nombre_usuario'], 16, ''), ""));
					$user->nickname_usuario = $nickname_usuario;
				}

				$user->save();

				// Basic person validate
				$person = new Persona;
				if (!$person->isValid($data)) {
					throw new \Exception($person->errors);
				}
				// Person
				$person->fill($data);
				$person->codigo_usuario = $user->codigo_usuario;
				$person->save();

				// User institution
				UsuarioInstitucion::getUserInstitution($user->codigo_usuario);

				// Return
				return $user;
			} else if ($userInstitution instanceof UsuarioInstitucion && $userData instanceof Usuario) {
				$user = new \stdClass();
				$user->exist = true;

				return $user;
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
	}

	public static function storeApi($data)
	{
		try
		{
			$user = new Usuario;
			// Basic data validate
			if (!$user->isValid($data)) {
				throw new \Exception($user->errors);
			}

			// User
			$user->fill($data);
			$user->codigo_estado = Estado::getState('confirm');
			$user->tipo_usuario = Usuario::typeUser('person');

			if(isset($data['cargo']) && !empty($data['cargo'])) {
				$user->cargo = $data['cargo'];
			}
			$user->save();

			// Basic person validate
			$person = new Persona;
			if (!$person->isValid($data)) {
				throw new \Exception($person->errors);
			}
			// Person
			$person->fill($data);
			$person->codigo_usuario = $user->codigo_usuario;
			$person->save();

			// Return
			return $user;
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Build User.
	*/
   	public static function buildUser($user)
   	{
		$object = new \stdClass();
		$object->id = $user->codigo_usuario;
		$object->codigo_persona = TuProyecto::encryptSrcParams([$user->codigo_persona]);
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$user->codigo_usuario]);
		$object->nombre_usuario = $user->nombre_usuario;
		$object->primer_apellido_persona = $user->primer_apellido_persona;
		$object->segundo_apellido_persona = $user->segundo_apellido_persona;
		$object->nickname_usuario = $user->nickname_usuario;
		$object->imagen_usuario = $user->imagen_usuario;
		$object->biografia_usuario = $user->biografia_usuario;
		$object->experiencia_usuario = $user->experiencia_usuario;
		$object->descripcion_adicional_usuario = $user->descripcion_adicional_usuario;
		$object->fecha_nacimiento_usuario = $user->fecha_nacimiento_usuario;
		$object->forma_ayuda_mentoria = $user->forma_ayuda_mentoria;
		$object->codigo_especialidad_destacada = $user->codigo_especialidad_destacada;
		$object->pagina_web_usuario = $user->pagina_web_usuario;
		$object->profesion_usuario = $user->profesion_usuario;
		$object->codigo_ciudad = $user->codigo_ciudad;
		$object->nombre_ciudad = $user->nombre_ciudad;
		$object->nombre_pais = $user->nombre_pais;
		$object->codigo_usuario_institucion = $user->codigo_usuario_institucion;
		$object->rol_usuario_institucion = $user->rol_usuario_institucion;
		$object->codigo_concepto_institucion = $user->codigo_concepto_institucion;
		$object->cargo_entidad = $user->cargo_entidad;
		$object->codigo_nivel_educacion = $user->codigo_nivel_educacion;
		$object->codigo_profesion_persona = $user->codigo_profesion_persona;
		$object->codigo_ocupacion_persona = $user->codigo_ocupacion_persona;
		$object->last_income = session('last_income');
		$object->ultimo_ingreso_usuario = $user->ultimo_ingreso_usuario;
		if(isset($user->ultimo_ingreso_usuario) && !empty($user->ultimo_ingreso_usuario))
		{
			$object->ultimo_ingreso_usuario_ago = TuProyecto::timeAgo($user->ultimo_ingreso_usuario) ;
		}else{
			$object->ultimo_ingreso_usuario_ago = NULL;
		}


		$object->twitter_usuario = $user->twitter_usuario;
		$object->facebook_usuario = $user->facebook_usuario;
		$object->linkedin_usuario = $user->linkedin_usuario;
		$object->tiktok_usuario = $user->tiktok_usuario;

		$object->mentor = $user->mentor;
		$object->terminos_aceptados = $user->terminos_aceptados;
		$object->owner = false;
		if(Auth::check()) {
			$object->state_friendship = $user->state_friendship;

			$object->owner = Auth::user()->codigo_usuario == $user->codigo_usuario ? true : false;
			if($object->owner) {
				$object->identificacion_usuario = $user->identificacion_usuario;
				$object->tipo_identificacion_usuario = $user->tipo_identificacion_usuario;
				$object->correo_electronico = $user->correo_electronico;
				$object->direccion_usuario = $user->direccion_usuario;
				$object->barrio_usuario = $user->barrio_usuario;
				$object->telefono_usuario = $user->telefono_usuario;
				$object->movil_usuario = $user->movil_usuario;

				$object->estado_civil_persona = $user->estado_civil_persona;
				$object->nombre_estado_civil = Usuario::getMaritalStatus($user->estado_civil_persona);
				$object->genero_persona = $user->genero_persona;
				$object->nombre_genero = Usuario::getGender($user->genero_persona);
			}
		}


		$object->stage_mentoring = [];

		if($user->mentor) {
			$object->codigo_especialidad_destacada = $user->codigo_especialidad_destacada;
			$object->nombre_especialidad = $user->nombre_especialidad;
			$object->codigo_especialidad = $user->codigo_especialidad;
			// specialties
			$object->specialties = $user->specialties()->get()->take(3);
			$object->url_profile = $user->getProfileUrl();

			// stages mentoring
			$object->stage_mentoring = $user->estapamentoria()->get()->pluck('codigo_etapa_proyecto')->all();

			// attachment
			// $object->attached_curriculum = $user->adjuntos()->where('codigo_documento', '=', Documento::getTypeDocument('curriculum'))->pluck('direccion_adjunto');
		}

		// $person = $user->persona()->first();

		// if($person instanceof Persona) {
		// 	$object->forma_ayuda_mentoria = $user->forma_ayuda_mentoria ?: $person->forma_ayuda_mentoria;
		// }


        if(RegistroSesion::institution()->datos_socio_economicos){
            $object->jefe_hogar = $user->jefe_hogar;
            $object->discapacidad = $user->discapacidad;
            $object->codigo_tipo_vivienda = $user->codigo_tipo_vivienda;
            $object->codigo_estrato = $user->codigo_estrato;
            $object->codigo_lista_ocupacion = $user->codigo_lista_ocupacion;
            $object->codigo_autodenominacion = $user->codigo_autodenominacion;
            $object->codigo_grupo_poblacional = $user->codigo_grupo_poblacional;
            $object->codigo_grupo_comunitario = $user->codigo_grupo_comunitario;
            $object->codigo_grupo_social = $user->codigo_grupo_social;
            $object->codigo_sector_trabajo = $user->codigo_sector_trabajo;
            $object->cor_codigo_ciudad = $user->cor_codigo_ciudad;
            $object->codigo_nivel_idioma = $user->codigo_nivel_idioma;
            $object->codigo_localidad_ciudad = $user->codigo_localidad_ciudad;
            $object->codigo_barrio_localidad = $user->codigo_barrio_localidad;
        }

		$object->contador_gamification = $user->contador_gamification;
		$object->posicion_gamification = $user->posicion_gamification;
		$object->tipo_usuario = $user->tipo_usuario;

		$object->srcparams = TuProyecto::encryptSrcParams([$user->codigo_usuario]);
		return $object;
   	}

   	public static function newGuestUser(Usuario $user)
   	{
   		// Set temporal password
   		$password = TuProyecto::randomPassword();

		$user->password = $password;
		$user->save();

		// Mail notification
		$data = [];
		$data['_template'] = 'emails.user.acceptinvitation';

		$data['_subject'] = trans('user.mail.acceptinvitation.subject');
		$data['_to'] = $user->correo_electronico;
		$data['_to_name'] = $user->nombre_usuario;

		$data['change_password'] = trans('user.mail.acceptinvitation.password', ['password' => $password]);
		SendEmail::notification($data);
   	}

   	public function sendConfirmacionEmail()
   	{
   		// Mail notification
		$data = [];
		switch (RegistroSesion::getInstitution()) {
			case Institucion::getInstitution('redcoo'):
				$data['_template'] = 'emails.custom.redcoo.confirmmail';
				break;

			default:
				$data['_template'] = 'emails.user.confirmmail';
				$data['body'] = trans('app.confirm.mail.body');
				break;
		}

		$data['_subject'] = trans('app.confirm.mail.subject');
		$data['_to'] = $this->correo_electronico;
		$data['_url_action'] = URL::route('usuario.confirmacion.confirmar', ['email' => TuProyecto::encryptSrcParams([$this->correo_electronico])], false);

		SendEmail::notification($data);
   	}

	public function getAveragePurchase($type)
   	{
   		$query = ItemEvaluacionCompra::query();
		$query->select('nombre_item_evaluacion_compra',  DB::raw("COALESCE(valor_promedio, 0) as valor_promedio "));

		$query->leftjoin('core.promedio_compra', function($join) {
			$join->on('item_evaluacion_compra.codigo_item_evaluacion_compra', '=', 'promedio_compra.codigo_item_evaluacion_compra');
			$join->where('promedio_compra.codigo_usuario', '=', $this->codigo_usuario);
        });

        $query->where('item_evaluacion_compra.codigo_estado', '=', Estado::getState('active'));
        $query->where('item_evaluacion_compra.tipo_item_evaluacion_compra', '=', $type);
        $query->where('item_evaluacion_compra.codigo_institucion', '=', RegistroSesion::getInstitution());
   		$query->orderby('nombre_item_evaluacion_compra','asc');

   		return $query->get()->toArray();
   	}

    public function getAllowedUsers()
  	{
  		// by default, the creator of the resource is allowed
  		$allowed = [$this->attributes['codigo_usuario']];

  		// entity session
  		if(Auth::check() && $this->attributes['tipo_usuario'] == $this->typeUser('entity')){
  			$allowed[] = $this->entidad->seg_codigo_usuario;
  		}
  		return $allowed;
  	}

  	public static function getEntitysUser()
   	{
		$query = Usuario::query();
		$query->select('nombre_usuario','usuario.codigo_usuario');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->leftjoin('core.grupo_usuario', 'entidad.codigo_usuario', '=', 'grupo_usuario.seg_codigo_usuario');

		$query->join('core.usuario_institucion', function($join) {
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->where(function ($query){
			$query->where('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
		});

		$query->where('usuario.tipo_usuario',Usuario::typeUser('entity'));
		return $query->get();

   	}

	public static function getUserByEntity($codigo_usuario)
	{
		return Usuario::select(
				'usuario.identificacion_usuario as entity_id',
				'usuario.biografia_usuario as entity_description',
				DB::raw("(owner.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as user_name"),
				'usuario.codigo_usuario',
				'usuario.nickname_usuario',
				'ciudad.nombre_ciudad',
				'owner.correo_electronico',
				'persona.genero_persona',
				'owner.fecha_nacimiento_usuario',
				'owner.codigo_usuario as owner_id'
			)
			->join('core.entidad','usuario.codigo_usuario','=','entidad.codigo_usuario')
			->join('seguridad.usuario as owner','entidad.seg_codigo_usuario','=','owner.codigo_usuario')
			->join('core.persona','owner.codigo_usuario','=','persona.codigo_usuario')
			->join('core.ciudad','owner.codigo_ciudad','=','ciudad.codigo_ciudad')
			->where('usuario.codigo_usuario', '=', $codigo_usuario)
			->first();
	}

   	public function getName()
   	{
   		$name = $this->attributes['nombre_usuario'];
   		if($this->attributes['tipo_usuario'] == $this->typeUser('person')) {
   			$person = $this->persona;
   			if($person->primer_apellido_persona){
				return sprintf('%s %s', $name, $person->primer_apellido_persona);
   			}
   			if($person->segundo_apellido_persona){
				return sprintf('%s %s', $name, $person->segundo_apellido_persona);
   			}
   		}
   		return $name;
   	}

   	public function getProfileUrl()
   	{
   		switch ($this->attributes['tipo_usuario']) {
	    	case $this->typeUser('person'):
				return !empty($this->attributes['nickname_usuario']) ? route('usuario.nickname', $this->attributes['nickname_usuario']) : '#';
			case $this->typeUser('entity'):
	    		return !empty($this->attributes['nickname_usuario']) ? route('proyecto.proyecto', $this->attributes['nickname_usuario']) : '#';
	    }
   	}

	/**
	* Get consultants
	*/
	public static function getConsultants()
	{
		$query = Usuario::query();
		$query->select('usuario.codigo_usuario as id', DB::raw("initcap(CASE WHEN usuario.tipo_usuario = ".Usuario::typeUser('person')." THEN ( (COALESCE(usuario.nombre_usuario, '') || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) ) ELSE usuario.nombre_usuario END) AS text") );
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
		});

		$query->leftJoin('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->whereNotNull('usuario.nombre_usuario');

		// Institucion
		if(RegistroSesion::institution()->validacion_categorias_marketplace) {
			$query->whereIn('usuario.codigo_usuario', function($query)
		    {
		        $query->select(DB::raw(" seg_codigo_usuario
			 		from core.producto"
				));
				$query->join('core.categoria_producto_insti', 'producto.codigo_categoria_prod_insti', '=', 'categoria_producto_insti.codigo_categoria_prod_insti');
				$query->whereIn('codigo_cat_padre_producto', TipoPago::getCategoriasMarketplace());
				$query->where('producto.codigo_estado', '=', Estado::getState('active'));
				$query->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution());
		        $query->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
		    });
		}else{
			$query->join('core.producto', function($join){
				$join->on('usuario.codigo_usuario', '=', 'producto.seg_codigo_usuario')
				->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());
			});
		}

		if(Input::has('q')){
			$query->whereRaw("usuario.nombre_usuario ilike '%".trim(Input::get('q'))."%'");
		}

		if(Input::has('dataId')){
			$query->where("usuario.codigo_usuario", '=', Input::get('dataId'));
		}

		$query->distinct();
		$query->orderby('text', 'asc');

		// return $query->take(20)->get();
		return $query->get();
	}

	/**
	 * Defining Relations
	*/
	public function institucion()
    {
        $return = $this->hasOne('App\UsuarioInstitucion', 'codigo_usuario', 'codigo_usuario')
                    ->where('codigo_institucion', '=', RegistroSesion::getInstitution());

        return $return;
   	}

   	public function productos()
    {
		$countProducts = App\Producto::select()
				->where('codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('codigo_usuario', '=', Auth::user()->codigo_usuario)
				->get();
		return $countProducts->count();

   	}
   	public function productosFavoritos()
    {
		$countFavorites = Producto::select()
							->join('core.wishlist_producto', function ($join){
								$join->on('producto.codigo_producto', '=', 'wishlist_producto.codigo_producto')
								->where('wishlist_producto.codigo_usuario', '=', Auth::user()->codigo_usuario )
								->where('producto.codigo_estado', '!=', Estado::getState('removed') )
								->where('wishlist_producto.codigo_estado', '=', Estado::getState('active') )
								->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution() );
							});
		return $countFavorites->count();

   	}
   	public function persona()
    {
        return $this->hasOne('App\Persona', 'codigo_usuario', 'codigo_usuario');
   	}

	public function entidad()
    {
        return $this->hasOne('App\Entidad', 'codigo_usuario', 'codigo_usuario');
   	}

   	public function ciudad()
    {
        return $this->hasOne('App\Ciudad', 'codigo_ciudad', 'codigo_ciudad');
   	}

   	public function especialidades()
    {
        return $this->hasMany('App\EspecialidadUsuario','codigo_usuario','codigo_usuario');
    }

   	public function educaciones()
    {
        return $this->hasMany('App\NivelEducacionUsuario','codigo_usuario','codigo_usuario');
    }

    public function specialties()
    {
       return $this->belongsToMany('App\Especialidad', 'core.especialidad_usuario', 'codigo_usuario', 'codigo_especialidad');
    }

    public function razones()
    {
        return $this->hasMany('App\RazonRegistroUsuario','codigo_usuario','codigo_usuario');
    }

    public function intereses()
    {
        return $this->hasMany('App\SectorInteresUsuario','codigo_usuario','codigo_usuario');
    }

    public function promediocompra()
    {
        return $this->hasMany('App\PromedioCompra','codigo_usuario','codigo_usuario');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_usuario', 'codigo_usuario', 'codigo_tag');
    }

    public function estapamentoria()
    {
        return $this->belongsToMany('App\EtapaProyecto','core.etapa_mentoria','codigo_usuario', 'codigo_etapa_proyecto');
    }

    public function adjuntos()
    {
       return $this->belongsToMany('App\Adjunto', 'core.adjunto_usuario', 'codigo_usuario', 'codigo_adjunto');
    }

	/**
	 * Many-to-Many relations with Role.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany(config('entrust.role'), config('entrust.role_user_table'), 'user_id', 'role_id')
			->where('codigo_institucion', '=', RegistroSesion::getInstitution());
	}

	//Big block of caching functionality.
	public function cachedRoles()
	{
		$userPrimaryKey = $this->primaryKey;
		$cacheKey = "entrust_roles_for_user_{$this->$userPrimaryKey}_".RegistroSesion::getInstitution();
		return Cache::tags(Config::get('entrust.role_user_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
			return $this->roles()->get();
		});
	}

	/**
	 * Checks if the user has a role by its name (antes provisto por EntrustUserTrait).
	 *
	 * @param string|array $name       Role name or array of role names.
	 * @param bool         $requireAll All roles in the array are required.
	 *
	 * @return bool
	 */
	public function hasRole($name, $requireAll = false)
	{
		if (is_array($name)) {
			foreach ($name as $roleName) {
				$hasRole = $this->hasRole($roleName);

				if ($hasRole && !$requireAll) {
					return true;
				} elseif (!$hasRole && $requireAll) {
					return false;
				}
			}

			return $requireAll;
		}

		foreach ($this->cachedRoles() as $role) {
			if ($role->name == $name) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks role(s) and permission(s).
	 *
	 * @param string|array $roles       Array of roles or comma separated string
	 * @param string|array $permissions Array of permissions or comma separated string.
	 * @param array        $options     validate_all (true|false) or return_type (boolean|array|both)
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return array|bool
	 */
	public function ability($roles, $permissions, $options = [])
	{
		// Convert string to array if that's what is passed in.
		if (!is_array($roles)) {
			$roles = explode(',', $roles);
		}
		if (!is_array($permissions)) {
			$permissions = explode(',', $permissions);
		}

		// Set up default values and validate options.
		if (!isset($options['validate_all'])) {
			$options['validate_all'] = false;
		} else {
			if ($options['validate_all'] !== true && $options['validate_all'] !== false) {
				throw new InvalidArgumentException();
			}
		}
		if (!isset($options['return_type'])) {
			$options['return_type'] = 'boolean';
		} else {
			if ($options['return_type'] != 'boolean' &&
				$options['return_type'] != 'array' &&
				$options['return_type'] != 'both') {
				throw new InvalidArgumentException();
			}
		}

		// Loop through roles and permissions and check each.
		$checkedRoles = [];
		$checkedPermissions = [];
		foreach ($roles as $role) {
			$checkedRoles[$role] = $this->hasRole($role);
		}
		foreach ($permissions as $permission) {
			$checkedPermissions[$permission] = $this->can($permission, isset($options['module']) ? $options['module'] : null);
		}

		// If validate all and there is a false in either
		// Check that if validate all, then there should not be any false.
		// Check that if not validate all, there must be at least one true.
		if(($options['validate_all'] && !(in_array(false,$checkedRoles) || in_array(false,$checkedPermissions))) ||
			(!$options['validate_all'] && (in_array(true,$checkedRoles) || in_array(true,$checkedPermissions)))) {
			$validateAll = true;
		} else {
			$validateAll = false;
		}

		// Return based on option
		if ($options['return_type'] == 'boolean') {
			return $validateAll;
		} elseif ($options['return_type'] == 'array') {
			return ['roles' => $checkedRoles, 'permissions' => $checkedPermissions];
		} else {
			return [$validateAll, ['roles' => $checkedRoles, 'permissions' => $checkedPermissions]];
		}
	}

	/**
	 * Check if user has a permission by its name.
	 *
	 * @param string|array $permission Permission string or array of permissions.
	 * @param bool         $requireAll All permissions in the array are required.
	 *
	 * @return bool
	 */
	public function can($permission, $module = null, $requireAll = false)
	{
		if (is_array($permission)) {
			foreach ($permission as $permName) {
				$hasPerm = $this->can($permName, $module);

				if ($hasPerm && !$requireAll) {
					return true;
				} elseif (!$hasPerm && $requireAll) {
					return false;
				}
			}

			// If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
			// If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
			// Return the value of $requireAll;
			return $requireAll;
		} else {
			foreach ($this->cachedRoles() as $role) {
				// Validate against the Permission table
				foreach ($role->cachedPermissions($module) as $perm) {
					if (Str::is( $permission, $perm->name) ) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Alias to eloquent many-to-many relation's attach() method.
	 *
	 * @param mixed $role
	 */
	public function attachRole($role, $state = null)
	{
		if(is_object($role)) {
			$role =  $role->getKey();
		}

		if(is_array($role)) {
			$role = $role['id'];
		}

		$state = is_null($state) ? Estado::getState('active') : $state;

		$rol_usuario = RolUsuario::where('role_id',$role)
		->where('codigo_institucion', RegistroSesion::getInstitution())
		->where('user_id', $this->codigo_usuario)
		->first();


		if($rol_usuario instanceof RolUsuario ){
			RolUsuario::where('role_id',$role)
						->where('codigo_institucion', RegistroSesion::getInstitution())
						->where('user_id', $this->codigo_usuario)
						->update(['codigo_estado'=> $state]);
		}else{
			$this->roles()->attach($role, ['codigo_institucion' => RegistroSesion::getInstitution(), 'codigo_estado' => is_null($state) ? Estado::getState('active') : $state ]);
		}


	}

	/**
	 * Alias to eloquent many-to-many relation's detach() method.
	 *
	 * @param mixed $role
	 */
	public function detachRole($role)
	{
		if (is_object($role)) {
			$role = $role->getKey();
		}

		if (is_array($role)) {
			$role = $role['id'];
		}

		$this->roles()->detach($role, ['codigo_institucion' => RegistroSesion::getInstitution()]);
	}

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
	}

	public static function validateMailtoVote($email)
   	{
		$response = true;
		$domines = array(
			"vcbox",
			"mygeoweb",
			"hideweb",
			"mailbox",
			"yopmail",
			"emailna",
			"mohmal",
			"1blackmoon",
			"mailsac",
			"yopmail",
			"oqiwq",
			"aklqo",
			"iemclyl",
			"vcbox",
			"desoz",
			"hacku",
			"mailinbox",
			"mywrld",
			"qwhealth",
			"mail777"
		);
		$fullDomaine = trim(substr($email, strpos($email,'@')+1));
		$array_domine = explode(".", $fullDomaine);
		$domine = $array_domine[0];
		if(in_array($domine, $domines))
			$response = false;

		return $response;
	}

	public function getJWTIdentifier()
	{
		return $this->getKey();
	}
	public function getJWTCustomClaims()
	{
		return [];
    }
    	 /**
   * Sync Algolia index
   */
	public function syncIndex(){
        // run algolia sync command
        \Artisan::queue('algolia:sync');

		$user = Usuario::find(\Auth::user()->codigo_usuario);
		if(!$user instanceof Usuario) {
		$errormsg = "App\Usuario@syncIndex: Error recuperando usuario ".\Auth::user()->codigo_usuario;
		Log::error(['error'=> $errormsg]);
		throw new \Exception($errormsg);
        }

		activity()
		->performedOn($user)
		->withProperties([
			'attributes' => [
			'user' => $user->nombre_usuario,
			'user_id' => $user->codigo_usuario,
			'mentor' => $this->nickname()
			]
		])
		->log('activitylog.mentor.sync');
	}
	/**
	 * Obtiene datos del usuario (persona) mediante codigo_usuario.
	 *
	 * @access public
	 * @static function
	 * @param int $id_user
	 * @return object $data
	 */
	public static function getDataUserById(int $id_user)
	{
		$query = Usuario::select('usuario1.*', 'persona.*' , 'entidad.*')
			->join('core.entidad', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario')
			->join('core.persona as persona', 'persona.codigo_usuario', '=', 'entidad.seg_codigo_usuario')
			->join('seguridad.usuario as usuario1', 'usuario1.codigo_usuario', '=', 'persona.codigo_usuario')
			->where('usuario.codigo_usuario', $id_user);
		return $data = $query->first();

	}
	/**
	 * Obtiene datos del usuario (persona) mediante correo_electronico.
	 *
	 * @access public
	 * @static function
	 * @param string $email
	 * @return object $data
	 */
	public static function getUserByEmail(string $email)
	{
		$query = Usuario::select('usuario1.*', 'persona.*' , 'entidad.*')
			->join('core.entidad', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario')
			->join('core.persona as persona', 'persona.codigo_usuario', '=', 'entidad.seg_codigo_usuario')
			->join('seguridad.usuario as usuario1', 'usuario1.codigo_usuario', '=', 'persona.codigo_usuario')
			->where('usuario1.correo_electronico', $email);
		return $data = $query->first();

	}


	public function asignacionEvaluadores()
    {
        return $this->hasMany('App\AsignacionEvaluadores', 'codigo_usuario');
    }
	/**
	 * Define relación hasMany con modelo AsignacionGestorVoucher  y id codigo_usuario.
	 * @access public
	 */
	public function asignacionGestor()
    {
        return $this->hasMany('App\AsignacionGestorVoucher', 'codigo_usuario');
    }
}
