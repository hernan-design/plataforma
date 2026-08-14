<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto, Input, URL, SendEmail, Hash, Crypt, Log;

use App\Usuario, App\Ciudad, App\UsuarioInstitucion, App\Persona, App\UserOauth, App\TerminosCondiciones, App\AceptacionTerminos, App\RegistroSesion, App\Institucion, App\Estado, App\DatoEntidad, App\Entidad;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
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

	public function my_encrypt($data, $key) {
		// Remove the base64 encoding from our key
		$encryption_key = base64_decode($key);
		// Generate an initialization vector
		// $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		// Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
		// The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
		return base64_encode($encrypted . '::' . $iv);
	}

	public function my_decrypt($data, $key) {
		// Remove the base64 encoding from our key
		$encryption_key = base64_decode($key);

		// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
		list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
	}

	public function store(Request $request)
	{
		$key = 'zdk8Q7EzeCHYiyABbVDOgwOvS8b547R1';
		$response = new \stdClass();

		// $response->email = $this->my_decrypt(Input::get('email'), $key);
		// $response->city = $this->my_decrypt(Input::get('city'), $key);
		// $response->phone = $this->my_decrypt(Input::get('phone'), $key);
		// $response->password = $this->my_decrypt(Input::get('password'), $key);
		// $response->name = $this->my_decrypt(Input::get('name'), $key);
		// $response->position = $this->my_decrypt(Input::get('position'), $key);
		// $response->company = $this->my_decrypt(Input::get('company'), $key);
		// $response->identification = $this->my_decrypt(Input::get('identification'), $key);
		// $response->ip = $this->my_decrypt(Input::get('ip'), $key);

		// return response()->json($response);

		$correo = "";
		$nombre = "";
		$ciudad = "";
		$cargo = "";
		$celular = "";
		$empresa = "";
		$nit = "";
		$contrase = "";
		$ip = "";

		if(Input::has('email'))
			$correo = $this->my_decrypt(Input::get ('email'), $key);

		if(Input::has('name'))
			$nombre = $this->my_decrypt(Input::get ('name'), $key);

		$porciones = explode(" ", $nombre);
		$nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";

		if(count($porciones)==1){
			$nombre = $porciones[0];
		}else if(count($porciones)==2){
			$nombre = $porciones[0];
			$primer_apellido = $porciones[1];
		}else if(count($porciones)==3){
			$nombre = $porciones[0];
			$primer_apellido = $porciones[1];
			$segundo_apellido = $porciones[2];
		}else if(count($porciones)==4){
			$nombre = $porciones[0]." ".$porciones[1];
			$primer_apellido = $porciones[2];
			$segundo_apellido = $porciones[3];
		}else{
			$nombre = $porciones[0]." ".$porciones[1]." ".$porciones[2];
			$primer_apellido = $porciones[3];
			$segundo_apellido = $porciones[4];
		}

		$fullname = $nombre." ".$primer_apellido." ".$segundo_apellido;

		$ciudad = $this->my_decrypt(Input::get ('city'), $key);

		if($ciudad == 'Bogotá'){
			$codigo_ciudad = 2257;
		}else if($ciudad == 'Bucaramanga'){
			$codigo_ciudad = 2263;
		}else if($ciudad == 'Santa Marta'){
			$codigo_ciudad = 2266;
		}else {
			$codigo_ciudad = 2257;
		}

		if(Input::has('position'))
			$cargo = $this->my_decrypt(Input::get ('position'), $key);
		if(Input::has('phone'))
			$celular = $this->my_decrypt(Input::get ('phone'), $key);
		if(Input::has('company'))
			$empresa = $this->my_decrypt(Input::get ('company'), $key);
		if(Input::has('identification'))
			$nit = $this->my_decrypt(Input::get ('identification'), $key);
		if(Input::has('password'))
			$contrase = $this->my_decrypt(Input::get('password'), $key);
		if(Input::has('ip'))
			$ip = $this->my_decrypt(Input::get ('ip'), $key);

		$filter_mail = filter_var($correo, FILTER_VALIDATE_EMAIL);
		if(!$filter_mail){
			$response->success = false;
			$response->message = "mail_format";
			return response()->json($response);
		}

		if(strlen($contrase) < 6 || strlen($contrase) > 12){
			$response->success = false;
			$response->message = "lenpassword_format";
			return response()->json($response);
		}

		if(!preg_match ("/^[a-zA-Z0-9.]+$/", $contrase)) {
			$response->success = false;
			$response->message = "password_format";
			return response()->json($response);
		}

		$usuario = Usuario::getUserMail($correo);
		$correo_electronico_usuario = "";
		if(!$usuario instanceof Usuario){


			$data_user = [];
			$data_user['nombre_usuario'] = $nombre;
			$data_user['correo_electronico'] = $correo;
			if($celular!="")
				$data_user['movil_usuario'] = $celular;
			$data_user['codigo_estado'] = 8;
			$data_user['codigo_ciudad'] = $codigo_ciudad;
			$data_user['password'] = $contrase;			
			if($cargo)
				$data_user['cargo'] = $cargo;

			if($primer_apellido!="")
				$data_user['primer_apellido_persona'] = $primer_apellido;
			if($segundo_apellido!="")
				$data_user['segundo_apellido_persona'] = $segundo_apellido;
			
			$nusuario = Usuario::storeApi($data_user);			

			$codigo_usuario = $nusuario->codigo_usuario;
			$correo_electronico_usuario = $nusuario->correo_electronico;			

			$nusuario_institucion = new UsuarioInstitucion;
			$nusuario_institucion->codigo_usuario = $codigo_usuario;
			$nusuario_institucion->codigo_institucion = 38;
			$nusuario_institucion->codigo_estado = 8;
			$nusuario_institucion->fecha_registro_usuario = date('Y-m-d');
			$nusuario_institucion->hora_registro_usuario = date('H:m:i');
			$nusuario_institucion->save();

			$codigo_usuario_institucion = $nusuario_institucion->codigo_usuario_institucion;

			$terms = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('terms'));
			if($terms instanceof TerminosCondiciones) {
				$acceptanceTerms = new AceptacionTerminos();
				$acceptanceTerms->codigo_usuario_institucion = $codigo_usuario_institucion;
				$acceptanceTerms->codigo_version_terminos = $terms->codigo_version_terminos;
				$acceptanceTerms->codigo_estado = Estado::getState('active');
				$acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
				$acceptanceTerms->direccion_ip = $ip;
				$acceptanceTerms->save();
			}

			// Privacy
			$privacy = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('privacy'));
			if($privacy instanceof TerminosCondiciones) {
				$acceptanceTerms = new AceptacionTerminos();
				$acceptanceTerms->codigo_usuario_institucion = $codigo_usuario_institucion;
				$acceptanceTerms->codigo_version_terminos = $privacy->codigo_version_terminos;
				$acceptanceTerms->codigo_estado = Estado::getState('active');
				$acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
				$acceptanceTerms->direccion_ip = $ip;
				$acceptanceTerms->save();
			}

			// Send notification
			$data = [];
			$data['_template'] = 'emails.user.usercreate';
			$data['_subject'] = 'Haz dado el primer paso hacia Emprende País.';
			$data['_to'] = $correo;
			SendEmail::notification($data);

			$response->success = true;
			$response->message = "create";
		}
		else{
			$codigo_usuario = $usuario->codigo_usuario;
			$nuevo_usuario = Usuario::find($codigo_usuario);
			if($nuevo_usuario instanceof Usuario){
				$correo_electronico_usuario = $nuevo_usuario->correo_electronico;
				if($empresa)
					$nuevo_usuario->empresa = $empresa;
				if($nit)
					$nuevo_usuario->nit = $nit;
				if($cargo)
					$nuevo_usuario->cargo = $cargo;
				if($celular!="")
					$nuevo_usuario->movil_usuario = $celular;
				$nuevo_usuario->codigo_ciudad = $codigo_ciudad;
				$nuevo_usuario->nombre_usuario = $nombre;
				$nuevo_usuario->password = bcrypt($contrase);
				$nuevo_usuario->save();

				$nueva_persona = Persona::where('codigo_usuario',$codigo_usuario)->first();
				if($nueva_persona instanceof Persona){
					if($primer_apellido!="")
						$nueva_persona->primer_apellido_persona = $primer_apellido;
					if($segundo_apellido!="")
						$nueva_persona->segundo_apellido_persona = $segundo_apellido;
					$nueva_persona->save();
				}
			}

			$usuario_institucion = $this->getusuarioInstitucion($codigo_usuario, 38);
			if(!$usuario_institucion instanceof UsuarioInstitucion){
				$nusuario_institucion = new UsuarioInstitucion;
				$nusuario_institucion->codigo_usuario = $codigo_usuario;
				$nusuario_institucion->codigo_institucion = 38;
				$nusuario_institucion->codigo_estado = 8;
				$nusuario_institucion->codigo_rol = 3;
				$nusuario_institucion->fecha_registro_usuario = date('Y-m-d');
				$nusuario_institucion->hora_registro_usuario = date('H:m:i');
				$nusuario_institucion->save();
				$codigo_usuario_institucion = $nusuario_institucion->codigo_usuario_institucion;

				$terms = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('terms'));
				if($terms instanceof TerminosCondiciones) {
					$acceptanceTerms = new AceptacionTerminos();
					$acceptanceTerms->codigo_usuario_institucion = $codigo_usuario_institucion;
					$acceptanceTerms->codigo_version_terminos = $terms->codigo_version_terminos;
					$acceptanceTerms->codigo_estado = Estado::getState('active');
					$acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
					$acceptanceTerms->direccion_ip = $ip;
					$acceptanceTerms->save();
				}

				// Privacy
				$privacy = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('privacy'));
				if($privacy instanceof TerminosCondiciones) {
					$acceptanceTerms = new AceptacionTerminos();
					$acceptanceTerms->codigo_usuario_institucion = $codigo_usuario_institucion;
					$acceptanceTerms->codigo_version_terminos = $privacy->codigo_version_terminos;
					$acceptanceTerms->codigo_estado = Estado::getState('active');
					$acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
					$acceptanceTerms->direccion_ip = $ip;
					$acceptanceTerms->save();
				}

				$response->success = true;
				$response->message = "create";
			}
			else{
				$codigo_usuario_institucion = $usuario_institucion->codigo_usuario_institucion;

				$response->success = false;
				$response->message = "exist";
			}
		}

		if($empresa){
			$newnickname_entidad = substr($this->unwantedCharacters($empresa), 0, 16);
			$nickname_entidad = $this->validateUserNickname(str_replace(" ", "", $newnickname_entidad));
			
			$nusuario_entidad = new Usuario;
			$nusuario_entidad->nombre_usuario = $empresa;		    		
			$nusuario_entidad->nickname_usuario = $nickname_entidad;
			$nusuario_entidad->codigo_ciudad = $codigo_ciudad;		
			$nusuario_entidad->identificacion_usuario = $nit;
			$nusuario_entidad->tipo_usuario = 2;
			$nusuario_entidad->codigo_estado = 8;						
			$nusuario_entidad->save();

			$codigo_usuario_entidad = $nusuario_entidad->codigo_usuario;						

			$nusuario_institucion_entidad = new UsuarioInstitucion;
			$nusuario_institucion_entidad->codigo_usuario = $codigo_usuario_entidad;
			$nusuario_institucion_entidad->codigo_institucion = 38;	    			
			$nusuario_institucion_entidad->codigo_estado = 8;
			$nusuario_institucion_entidad->save();

			$codigo_usuario_institucion_entidad = $nusuario_institucion_entidad->codigo_usuario_institucion;
			
			$ndato_entidad = new DatoEntidad;
			$ndato_entidad->codigo_usuario_institucion = $codigo_usuario_institucion_entidad;
			$ndato_entidad->codigo_privacidad_contenido = 2;
			$ndato_entidad->codigo_etapa_proyecto = 66;
			$ndato_entidad->codigo_estado = 8;		    			
			$ndato_entidad->save();
					
			$nentidad = new Entidad;
			$nentidad->codigo_usuario = $codigo_usuario_entidad;
			$nentidad->seg_codigo_usuario = $codigo_usuario;
			$nentidad->codigo_clase_empre_insti = 35;			
			$nentidad->save();

			$codigo_prestador_servicio = $codigo_usuario_entidad;
		}		

		return response()->json($response);
	}

	public function decryptData($data){
		$response = new \stdClass();
		// return $plaintext1;
		$password = 'zdk8Q7EzeCHYiyABbVDOgwOvS8b547R1';

		// CBC has an IV and thus needs randomness every time a message is encrypted
		$method = 'aes-256-cbc';

		// Must be exact 32 chars (256 bit)
		// You must store this secret random key in a safe place of your system.
		$key = substr(hash('sha256', $password, true), 0, 32);

		// Most secure key
		//$key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		// Most secure iv
		// Never ever use iv=0 in real life. Better use this iv:
		// $ivlen = openssl_cipher_iv_length($method);
		// $iv = openssl_random_pseudo_bytes($ivlen);

		// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
		//$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

		// My secret message 1234
		// $decrypted = openssl_decrypt(base64_decode($data->nombre), $method, $key, OPENSSL_RAW_DATA, $iv);

		$response->nombre = openssl_decrypt(base64_decode($data->nombre), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->correo = openssl_decrypt(base64_decode($data->correo), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->contrase = openssl_decrypt(base64_decode($data->contrase), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->cargo = openssl_decrypt(base64_decode($data->cargo), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->celular = openssl_decrypt(base64_decode($data->celular), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->empresa = openssl_decrypt(base64_decode($data->empresa), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->nit = openssl_decrypt(base64_decode($data->nit), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->ip = openssl_decrypt(base64_decode($data->ip), $method, $key, OPENSSL_RAW_DATA, $iv);
		return $response;
	}

	public function decryptString($plaintext1){
		$response = new \stdClass();
		$plaintext = 'hqYqR4lIpzdY/z61dscOct39P4DJcMlryMHC214YnLY=';
		// return $plaintext1;
		$password = 'zdk8Q7EzeCHYiyABbVDOgwOvS8b547R1';

		// CBC has an IV and thus needs randomness every time a message is encrypted
		$method = 'aes-256-cbc';

		// Must be exact 32 chars (256 bit)
		// You must store this secret random key in a safe place of your system.
		$key = substr(hash('sha256', $password, true), 0, 32);

		// Most secure key
		//$key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		// Most secure iv
		// Never ever use iv=0 in real life. Better use this iv:
		// $ivlen = openssl_cipher_iv_length($method);
		// $iv = openssl_random_pseudo_bytes($ivlen);

		// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
		//$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

		// My secret message 1234
		$decrypted = openssl_decrypt(base64_decode($plaintext1), $method, $key, OPENSSL_RAW_DATA, $iv);
		$response->password = $password;
		$response->decrypt = $decrypted;
		$response->plaintext = $plaintext;
		return $decrypted;
	}

	public static function unwantedCharacters($string)
	{
		$string = trim($string);
		// Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
		$string = strtolower($string);
		// Strip accents
		$string = strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
		// Strip any unwanted characters
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		return $string;
	}

	public function validateUserNickname($nombre_categoria, $contador = 0)
	{
		if(isset($nombre_categoria) && !empty($nombre_categoria)){

			$url_categoria_producto = $contador > 0 ? (strlen($nombre_categoria) >= 16) ? sprintf("%s%d",substr($nombre_categoria,0,-strlen($contador)),$contador) : sprintf("%s%d",$nombre_categoria, $contador) : $nombre_categoria;

			$query = Usuario::query();
			$query->select('usuario.*');
			$query->whereRaw("trim(lower(nickname_usuario)) ilike trim(lower('$url_categoria_producto'))");
			$categoria_producto = $query->first();

			$contador ++;
			if($categoria_producto instanceof Usuario){
				$url_categoria_producto = $this->validateUserNickname($nombre_categoria, $contador);
			}
			return $url_categoria_producto;
		}
		return str_random(16);
	}

	public static function getCityByName($city_name)
	{
		$query = Ciudad::query();
		$query->whereRaw("nombre_ciudad like '%$city_name%'");
		return $query->first();
	}

	public static function getusuarioInstitucion($codigo_usuario,$codigo_institucion){
		return UsuarioInstitucion::where('codigo_usuario', '=', $codigo_usuario)
		->where('codigo_institucion', '=', $codigo_institucion)
		->first();
	}
}
