<?php

namespace App\Http\Middleware;

use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Auth\Guard;

use GuzzleHttp\Client;
use Closure;

use App\RegistroSesion, App\Institucion;

class React
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

	/**
	 * Request Path.
	 * @var string
	 */
	protected $path;

	/**
	 * Request Query String.
	 * @var array
	 */
	protected $query;

	/**
	 * Response Object.
	 * @var \Illuminate\Http\Response
	 */
	protected $response;

	/**
	 * View Object.
	 * @var \Illuminate\View\View
	 */
	protected $view;

	/**
	 * Config Object.
	 * @var \Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * New React Compiler Middleware.
	 *
	 * @param  \Illuminate\Config\Repository  $config
     	 * @param  Illuminate\Contracts\Auth\Guard  $auth
	 * @return void
	 */
	public function __construct(Config $config, Guard $auth)
	{
		$this->config = $config;
	    $this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$this->path = $request->path();
		$this->query = $request->query();
		$this->response = $next($request);
		$this->view = $this->response->getOriginalContent();

		if (!is_a($this->view, 'Illuminate\View\View')) {
			throw new \InvalidArgumentException('React Compiler Middleware expects an instance of Illuminate\View\View.');
		}

		return $this->compile();
	}

	/**
	 * Make an HTTP request to the React compiler. Return the
	 * compiled view string.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function compile()
	{
		$content = $this->getResponse();
		$contents = !is_object($content) ? compact('content') : $content;

		foreach ($contents as $key => $value) {
			$this->view->with($key, $value);
		}
		return $this->response->setContent($this->view);
	}

	/**
	 * Make HTTP request to the React compiler URL.
	 *
	 * @param  \GuzzleHttp\Client  $client
	 * @return string|object|null
	 */
	protected function getResponse(Client $client = null)
	{
		$client = $client ?: new Client;
		try {
			$data = $this->view->getData();

			$data['session']['csrftoken'] = csrf_token();
			$data['session']['rootUrl'] = url('/');
			$data['session']['slugInstitution'] = RegistroSesion::institution()->slug_institucion;
			if( $this->auth->check() ) {
				$data['session']['user'] = $this->user();
			}
            $data['session']['institution'] = $this->institution();
            
			$content = $client->request('POST', $this->getCompilerUrl(), [
				'verify' => false,
				'query' => $this->query,
				'json' => $data,
				'connect_timeout' => $this->config->get('react.connect_timeout', 0),
				'timeout' => $this->config->get('react.timeout', 0)
			])
			->getBody()
			->getContents();
			if ($this->isJson($content)) {
				$content = json_decode($content);
			}
		} catch (Exception $e) {
			$content = null;
		}
		return $content;
	}

	/**
	 * Get the React compiler URL.
	 *
	 * @return string
	 */
	protected function getCompilerUrl()
	{
		$host = $this->config->get('react.host', 'localhost');
		$port = $this->config->get('react.port', 3001);
		$path = $this->path;
		if ($path and substr($path, 0, 1) !== '/') {
			$path = '/' . $path;
		}
		return $host . ':' . $port . $path;
	}

	/**
	 * Is the given string JSON?
	 *
	 * @param  string  $string
	 * @return boolean
	 */
	protected function isJson($string)
	{
		json_decode($string);
		return json_last_error() == JSON_ERROR_NONE;
	}

	/**
	 * Data user
	 */
	protected function user()
	{
		$user = $this->auth->user();
		$userinstitution = $user->institucion;

		return [
			'codigo_usuario' => $user->codigo_usuario,
			'nombre_usuario' => "$user->nombre_usuario {$user->persona->primer_apellido_persona}",
			'nickname_usuario' => $user->nickname_usuario,
			'imagen_usuario' => $user->imagen_usuario,
			'usuario_verificado' => ($userinstitution->institucion->verificacion_cuentas_institucion ? $user->hasRole('asociado') : true),
			'channels' => $userinstitution->canales,
			'profesion_usuario' => $user->profesion_usuario,
			'biografia_usuario' => $user->biografia_usuario,
			'experiencia_usuario' => $user->experiencia_usuario,
			'linkedin_usuario' => $user->linkedin_usuario,
            'educations' => $user->educaciones->pluck('codigo_nivel_educacion')->toArray(),
			'isAdmin' => $user->ability('admin,super-admin', 'login-admin')
		];
    }

    /**
	 * Data institution
	 */
	protected function institution()
	{
        $institution = RegistroSesion::institution();

        return [
            'social' => Institucion::getSocialLinks($institution->codigo_institucion)
        ];
    }
}
