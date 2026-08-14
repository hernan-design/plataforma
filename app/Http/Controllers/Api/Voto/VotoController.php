<?php

namespace App\Http\Controllers\Api\Voto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario, App\Voto, App\Estado, App\Entidad, App\RegistroSesion;
use Tymon\JWTAuth\Exceptions\JWTException;
use  TuProyecto, Auth, JWTAuth, Lang, SendEmail, Queue, AWS, DB, Log, URL;

class VotoController extends Controller
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
    public function store(Request $request)
    {
        $key = 'zdk8Q7EzeCHYiyABbVDOgwOvS8b547R1';
        $user_mail = $request->has('correo_electronico') ? trim($request->correo_electronico) : null;
        $acepting_dates = $request->has('manejo_datos') ? trim($request->manejo_datos) : null;
        $user_name = $request->has('name') ? trim($request->name) : null;
        $user_phone = $request->has('phone') ? trim($request->phone) : null;
        $entity = $request->has('entity') ? trim($request->entity) : null;
        $credentials = null;

        if (!is_numeric($entity)) {
            abort(404);
        }

        // Get user entity
        $entity_user = Entidad::select('usuario_institucion.codigo_usuario_institucion')->join('core.usuario_institucion', 'usuario_institucion.codigo_usuario', 'entidad.codigo_usuario')
        ->where('entidad.codigo_entidad', '=', $entity)->first();

        // Get user institution
        $user_institution = Usuario::getUserMail($user_mail);

        // Verify if user vote
        $user_vote_mail = Voto::userMailVoteValidate($entity_user->codigo_usuario_institucion, $user_mail);
        if ($user_vote_mail instanceof Voto) {
            return  response()->json(['success' => false, 'error' => 'Este correo electronico ya tiene un voto registrado']);
        }

        $user_vote_phone = Voto::userPhoneVoteValidate($entity_user->codigo_usuario_institucion, $user_phone);
        if ($user_vote_phone instanceof Voto) {
            return  response()->json(['success' => false, 'error' => 'Este celular ya tiene un voto registrado']);
        }

        $user_vote_pending = Voto::userVote($entity_user->codigo_usuario_institucion, $user_institution, $user_mail, $user_phone, Estado::getState('pending'));
        if ($user_vote_pending instanceof Voto) {
            if (isset($user_phone)) {
                if (strlen($user_phone) == 10) {
                    // Ejecutar tarea en la cola de tareas
                    Queue::push('App\Voto@phoneNotification', ['codigo_voto' => $user_vote_pending->codigo_voto]);
                }
            }

            DB::commit();
			return response()->json(['success' => true, 'message' => 'Voto registrado correctamente', 'vote' => TuProyecto::encryptSrcParams([$user_vote_pending->codigo_voto]) ]);
        }


		try {
			DB::beginTransaction();
			$vote = new Voto();
			$vote->codigo_estado = Estado::getState('pending');
			$vote->codigo_usuario_institucion = $entity_user->codigo_usuario_institucion;
			$vote->cor_codigo_usuario_institucion = isset($user_institution) ? $user_institution->codigo_usuario_institucion : null;
			$vote->fecha_voto = date('Y-m-d H:m:s');
			$vote->clase_voto = isset($user_institution) ? Voto::classVote('register') : Voto::classVote('not_register');
			$vote->correo_electronico_voto = $user_mail;
			$vote->numero_celular_voto = $user_phone;
			$vote->numero_voto = mt_rand(100000, 999999);
            $vote->save();

			if ($vote instanceof Voto) {
				if (isset($user_phone)) {
					if (strlen($user_phone) == 10) {
						// Ejecutar tarea en la cola de tareas
						Queue::push('App\Voto@phoneNotification', ['codigo_voto' => $vote->codigo_voto]);
					}
				}

			} else {
				return  response()->json(['success' => false, 'error' => trans('app.exception')]);
			}

			DB::commit();

			return response()->json(['success' => true, 'message' => 'Voto registrado correctamente', 'vote' => TuProyecto::encryptSrcParams([$vote->codigo_voto]) ]);

		} catch(\Exception $e) {
			DB::rollback();
			Log::error(sprintf('%s:%s', 'App\Http\Controllers\Api\Voto\VotoController::store', $e->getMessage()));
			return response()->json(['success' => false, 'error' => Lang::get('app.exception')]);
		}

	}

    /**
     * resend verification code
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
		$data = $request->all();

		$code_vote = $request->has('vote') ? $data['vote'] : null;
		$type = $request->has('type') ? $data['type'] : 'number';

		list($code_vote) = TuProyecto::decryptSrcParams($code_vote);
        if(!$code_vote || !is_numeric($code_vote)) {
                    throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
				}

		$vote = Voto::verifyCode($code_vote);
        if (!$vote instanceof Voto) {
            return response()->json(['success' => false, 'error' => 'No existe el voto o no esta pendiente']);
		}

		try {

			$user_phone = $vote->numero_celular_voto;

			$credentials = array(
				"correo_electronico" => "pedroandl@hotmail.com",
				"password" => "1280almas"
			);

			if (! $token = JWTAuth::attempt($credentials)) {
					return response()->json(['success' => false, 'error' => trans('app.exception')], 403);
			}

			if ($vote instanceof Voto) {
				if (isset($type) && $type === 'number' ) {

					if (strlen($user_phone) == 10) {
						// Agregar notificacion por sms a la cola de tareas
						Queue::push('App\Voto@phoneNotification', ['codigo_voto' => $vote->codigo_voto]);
					}

					$mesagge = sprintf('El código fue reenviado al número %s', $user_phone );

					return response()->json(['success' => true, 'message' => $mesagge , 'vote' => TuProyecto::encryptSrcParams([$vote->codigo_voto]) ]);

				} else if(isset($type) && $type === 'email' ) {
					// Agregar notificacion por correo a la cola de tareas
					Queue::push('App\Voto@emailNotification', ['codigo_voto' => $vote->codigo_voto]);

					$mesagge = sprintf('El código fue reenviado al correo %s', $vote->correo_electronico_voto );

					return response()->json(['success' => true, 'message' => $mesagge , 'vote' => TuProyecto::encryptSrcParams([$vote->codigo_voto]) ]);
				}

			} else {
				return  response()->json(['success' => false, 'error' => trans('app.exception')]);
			}

			return response()->json(['success' => false, 'error' => 'No se pudo reenviar el código']);

		} catch (JWTException $e) {
			DB::rollback();
			Log::error(sprintf('%s:%s', 'App\Http\Controllers\Api\Voto\VotoController::resend', $e->getMessage()));
			return response()->json(['success' => false, 'error' => trans('app.exception')], 500);
		}catch (\Exception $e) {
			DB::rollback();
			Log::error(sprintf('%s:%s', 'App\Http\Controllers\Api\Voto\VotoController::resend', $e->getMessage()));
			return response()->json(['success' => false, 'error' => Lang::get('app.exception')]);
		}

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

    public function verifycode(Request $request) {
        $code_vote = $request->has('vote') ? $request->vote : null;
        $code = $request->has('code_verification') ? $request->code_verification : null;
		list($code_vote) = TuProyecto::decryptSrcParams($code_vote);
        if (!is_numeric($code) || !is_numeric($code_vote)) {
            abort(404);
        }

        // Get vote for number of code

        $vote = Voto::verifyCode($code_vote);
        if (!$vote instanceof Voto) {
            return response()->json(['success' => false, 'message' => 'No existe el voto o no esta pendiente']);
        }

        if ($code == $vote->numero_voto) {
            $vote->codigo_estado = Estado::getState('active');
            $vote->save();

            return response()->json(['success' => true, 'message' => 'Tu voto fue registrado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'Los codigos no coinciden']);
        }
    }

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
        // dd(base64_decode($data));
		list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

}
