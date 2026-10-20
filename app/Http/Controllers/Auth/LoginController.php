<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

use App\Usuario, App\UsuarioInstitucion, App\Estado, App\RegistroSesion, App\Institucion, App\Credencial, App\TipoCredencial;

use Auth, Socialite, Log, Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $username = 'correo_electronico';

    protected $maxLoginAttempts = 3;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    // Throttling logic simplified
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return \Illuminate\Support\Facades\RateLimiter::tooManyAttempts($this->throttleKey($request), 5);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey($request), 60);
    }

    protected function clearLoginAttempts(Request $request)
    {
        \Illuminate\Support\Facades\RateLimiter::clear($this->throttleKey($request));
    }

    protected function throttleKey(Request $request)
    {
        return \Illuminate\Support\Str::transliterate(\Illuminate\Support\Str::lower($request->input($this->username())).'|'.$request->ip());
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Validate user
        $user = Usuario::getUserMail($request->get( $this->username() ));
        if(!$user instanceof Usuario) {
            throw ValidationException::withMessages([
                $this->username() => [transtp('auth.user')],
            ]);
        }

        // Validate state user
        $userInstitution = UsuarioInstitucion::where('codigo_usuario', '=', $user->codigo_usuario)->where('codigo_institucion', '=', RegistroSesion::getInstitution())->first();
        if(!$userInstitution instanceof UsuarioInstitucion) {
            throw ValidationException::withMessages([
                $this->username() => [transtp('auth.user')],
            ]);
        }

        // Validate state user
        if( in_array($userInstitution->codigo_estado, [Estado::getState('locked'), Estado::getState('inactive')]) ) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.locked')],
            ]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
			'password' => 'required|string',
            'g-recaptcha-response'=>'required|recaptcha'
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Remove cookie
        Cookie::queue(Cookie::forget('_user_id'));

        $this->guard()->logout();

        return redirect('/');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'correo_electronico';
    }

    /**
     * Used to start session with Twitter.
     *
     * @param  \Illuminate\Http\Request  $reques
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try{
            $user = Socialite::with($provider)->user();
            if(is_object($user) && isset($user->id)) {
                $data['correo_electronico'] = $user->getEmail() ?: '';
                $data['tipo_credencial'] = $provider;
                $data['credencial'] = $user->id;
                $data['nombre_usuario'] = $user->name;
                $data['primer_apellido_persona'] = '-';
                $data['nickname_usuario'] = $user->nickname ?: '';
                $data['imagen_usuario'] = $user->getAvatar() ?: '';

                $user = $this->socialAuth($data);
                if(isset($user['success']) && $user['success'] == true) {
                    return redirect()->intended(RegistroSesion::getInstitutionHome());
                }
                Log::error($user);
                return redirect()->route('login')->with(['login_error' => $user['errors']]);
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * Used to start session with Twitter, Linkedin and Facebook.
     *
     * @param  array $data
     * @return array $response
     */
    public function socialAuth($data)
    {
        $states = Institucion::getStateValidation(RegistroSesion::getInstitution());
        // Evaluate credencial
        $credential = Credencial::where('credencial', '=', $data['credencial'])
            ->where('codigo_tipo_credencial', '=', TipoCredencial::getType($data['tipo_credencial']))
            ->first();
        // Credential
        if(!$credential instanceof Credencial) {
            // Get user
            $user = Usuario::getUserMail(isset($data['correo_electronico']) ? $data['correo_electronico']: '');
            if(!$user instanceof Usuario) {
                $user = Usuario::store($data);
                // Different state depending on whether the mail is empty
                if( empty($user->correo_electronico) ) {
                    $user->codigo_estado = Estado::getState('confirm');
                }
                // Nickname twitter default
                if( (TipoCredencial::getType($data['tipo_credencial']) == TipoCredencial::getType('twitter')) && (isset($data['nickname_usuario'])) ) {
                    if(!Usuario::getUser($data['nickname_usuario']) instanceof Usuario){
                        $user->nickname_usuario = $data['nickname_usuario'];
                    }
                }
                $user->save();
            }
        }else{
            $user = Usuario::find($credential->codigo_usuario);
            if(isset($data['imagen_usuario']) && !empty($data['imagen_usuario']) && $data['imagen_usuario'] != $user->imagen_usuario) {
                $user->imagen_usuario = $data['imagen_usuario'];
                $user->save();
            }
        }

        // Evaluate credencial
        $credential = Credencial::where('credencial', '=', $data['credencial'])
            ->where('codigo_tipo_credencial', '=', TipoCredencial::getType($data['tipo_credencial']))
            ->where('codigo_institucion', '=', RegistroSesion::getInstitution())
            ->first();
        if(!$credential instanceof Credencial) {
            $credential = new Credencial();
            $credential->codigo_institucion = RegistroSesion::getInstitution();
            $credential->codigo_tipo_credencial = TipoCredencial::getType($data['tipo_credencial']);
            $credential->codigo_usuario = $user->codigo_usuario;
            $credential->codigo_estado = Estado::getState('active');
            $credential->credencial = $data['credencial'];
            $credential->save();
        }

        // User institution
        $userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario);
        if($userInstitution instanceof UsuarioInstitucion) {
            if( !in_array($userInstitution->codigo_estado, [Estado::getState('locked'), Estado::getState('inactive')]) ) {
                Auth::loginUsingId($userInstitution->codigo_usuario);
                return ['success' => true, 'codigo_credencial' => $credential->codigo_credencial, 'redirect' => session('url.intended', url(RegistroSesion::getInstitutionHome()))];
            }
            return ['success' => false, 'errors' => trans('app.error.user.locked')];
        }
        return ['success' => false, 'errors' => trans('app.error.userinstitution')];
    }

    /**
     * Used to start social session.
     * Redirect to Twitter, Linkedin and Facebook url.
     *
     * @param  \Illuminate\Http\Request  $reques
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended(RegistroSesion::getInstitutionHome());
    }
}
