<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto, SendEmail;
use DB, Log, Auth, Lang;

use App\Discusion, App\DiscusionMuro, App\DiscusionAcuerdoCompra, App\DiscusionProducto, App\DiscusionUsuario, App\DiscusionAsesoria, App\DiscusionEvento, App\DiscusionContenido, App\DiscusionCurso, App\DiscusionForo, App\DiscusionConvocatoria, App\Estado, App\DiscusionInstitucion, App\RegistroSesion, App\Convocatoria, App\Modulo, App\Foro, App\Muro, App\Evento, App\Contenido, App\Asesoria, App\Usuario, App\Curso, App\Producto, App\AcuerdoCompra;

class DiscusionController extends Controller
{
	/**
	 * Instantiate a new DiscusionController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'show']]);
	    $this->middleware('subscription', ['only' => ['store']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()) {
			return response()->json(Discusion::getDiscussions($request->all()));
		}

		abort(404);
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
		if ($request->ajax()) {
			$data = $request->all();
			$discussion = new Discusion;
			if ($discussion->isValid($data)) {

				// Module
				$module = Modulo::find($request->codigo_modulo);
				if(!$module instanceof Modulo) {
					abort(403);
				}

				if(is_numeric($request->codigo_recurso_modulo)) {
					$codigo_recurso_modulo = $request->codigo_recurso_modulo;
				} else {
					list($codigo_recurso_modulo) = TuProyecto::decryptSrcParams($request->codigo_recurso_modulo);
				}
				if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
					abort(403);
				}
				DB::beginTransaction();
				try {
					// Discussion
					$discussion->fill($data);
					$discussion->codigo_estado = Estado::getState('active');
					$discussion->codigo_usuario = Auth::user()->codigo_usuario;
					$discussion->codigo_modulo = $module->codigo_modulo;
					$discussion->fecha_discucion = date('Y-m-d H:i:s');
					$discussion->save();

					switch ($discussion->codigo_modulo) {
						// Wall
						case Modulo::getModule('wall'):
							$wall = Muro::find($codigo_recurso_modulo);
							if(!$wall instanceof Muro) {
							   throw new \Exception('Recurso muro no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionMuro();
							$resourceDiscussion->codigo_muro = $wall->codigo_muro;
							break;

						// Forum
						case Modulo::getModule('forum'):
							$forum = Foro::find($codigo_recurso_modulo);
							if(!$forum instanceof Foro) {
							   throw new \Exception('Recurso foro no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionForo();
							$resourceDiscussion->codigo_foro = $forum->codigo_foro;
							break;

						// Calendar
						case Modulo::getModule('calendar'):
							$event = Evento::find($codigo_recurso_modulo);
							if(!$event instanceof Evento) {
							   throw new \Exception('Recurso evento no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionEvento();
							$resourceDiscussion->codigo_evento = $event->codigo_evento;
							break;

						// Blog
						case Modulo::getModule('blog'):
							$blog = Contenido::find($codigo_recurso_modulo);
							if(!$blog instanceof Contenido) {
							   throw new \Exception('Recurso blog no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionContenido();
							$resourceDiscussion->codigo_contenido = $blog->codigo_contenido;
							break;

						// Mentoring
						case Modulo::getModule('mentoring'):
							$mentoring = Asesoria::find($codigo_recurso_modulo);
							if(!$mentoring instanceof Asesoria) {
							   throw new \Exception('Recurso asesoría no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionAsesoria();
							$resourceDiscussion->codigo_asesoria = $mentoring->codigo_asesoria;
							break;

						// User
						case Modulo::getModule('users'):
							$user = Usuario::find($codigo_recurso_modulo);
							if(!$user instanceof Usuario) {
							   throw new \Exception('Recurso usuario no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionUsuario();
							$resourceDiscussion->codigo_usuario = $user->codigo_usuario;
							break;

						// Learn
						case Modulo::getModule('learn'):
							$curso = Curso::find($codigo_recurso_modulo);
							if(!$curso instanceof Curso) {
							   throw new \Exception('Recurso curso no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionCurso();
							$resourceDiscussion->codigo_curso = $curso->codigo_curso;
							break;

						// Marketplace
						case Modulo::getModule('marketplace'):
							$product = Producto::find($codigo_recurso_modulo);
							if(!$product instanceof Producto) {
							   throw new \Exception('Recurso producto no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionProducto();
							$resourceDiscussion->codigo_producto = $product->codigo_producto;
							break;

						// Programs
						case Modulo::getModule('calls'):
							$program = Convocatoria::find($codigo_recurso_modulo);
							if(!$program instanceof Convocatoria) {
							   throw new \Exception('Recurso convocatoria no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionConvocatoria();
							$resourceDiscussion->codigo_convocatoria = $program->codigo_convocatoria;
							break;

						// Marketplace
						case Modulo::getModule('agreements'):
							$agreement = AcuerdoCompra::find($codigo_recurso_modulo);
							if(!$agreement instanceof AcuerdoCompra) {
							   throw new \Exception('Recurso acuerdo no identificado para discusión.');
							}

							$resourceDiscussion = new DiscusionAcuerdoCompra();
							$resourceDiscussion->codigo_acuerdo_compra = $agreement->codigo_acuerdo_compra;
							break;

						default:
						   throw new \Exception('Módulo no identificado para discusión.');
						   break;
					}

					$resourceDiscussion->codigo_discucion = $discussion->codigo_discucion;
					$resourceDiscussion->codigo_estado = Estado::getState('active');
					$resourceDiscussion->save();

					$discussionInstitution = new DiscusionInstitucion();
					$discussionInstitution->codigo_discucion = $discussion->codigo_discucion;
					$discussionInstitution->codigo_institucion = RegistroSesion::getInstitution();
					$discussionInstitution->codigo_estado = Estado::getState('active');
					$discussionInstitution->save();

					// Prepare response
					$response = Discusion::buildResults(Discusion::getDataDiscussion($discussion->codigo_discucion));
					$response->success = true;

					// Commit Transaction
					DB::commit();
					return response()->json($response);
				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'DiscusionController store', $e->getMessage()));
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			return response()->json(['success' => false, 'errors' => $discussion->errors]);
		}
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		// Decrypt url
		list($url, $codigo_discusion) = explode('-', $id);
		if(!$codigo_discusion || !is_numeric($codigo_discusion)) {
			abort(403);
		}

		$discussion = Discusion::getDataDiscussion($codigo_discusion);
		if(!$discussion instanceof Discusion) {
			abort(404);
		}

		switch ($discussion->origin) {
			case 'advice':
				$advice = Asesoria::find($discussion->codigo_asesoria);
				if(!in_array(Auth::user()->codigo_usuario, $advice->getAllowedUsers())) {
					abort(403);
				}
			break;
			default:
				//
			break;
		}

		if ($request->ajax()) {
			return response()->json(Discusion::buildDiscussion(Discusion::getDataDiscussion($discussion->codigo_discucion)));
		}
		return view('core/discussion/main');
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
	public function destroy(Request $request, $id)
	{
	   if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_discusion) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_discusion || !is_numeric($codigo_discusion)) {
				abort(403);
			}
			$discussion = Discusion::find($codigo_discusion);
			if(!$discussion instanceof Discusion) {
				abort(404);
			}
			// Validate user update discussion
			if(Auth::user()->codigo_usuario == $discussion->codigo_usuario) {
				DB::beginTransaction();
				try {
					// Set removed discussion
					Discusion::where('codigo_discucion', '=', $discussion->codigo_discucion)
						->update(['codigo_estado' => Estado::getState('removed')]);

					// Update Discussion institution
                    DiscusionInstitucion::where('codigo_discucion', $discussion->codigo_discucion)->where('codigo_institucion', RegistroSesion::getInstitution())
                        ->update(['codigo_estado' => Estado::getState('removed')]);

					DB::commit();
					return response()->json(['success' => true]);
				}catch(\Exception $e){
					DB::rollback();
					Log::error($e->getMessage());
					return response()->json(['success' => false, 'errors' => trans('app.exception')]);
				}
			}
			abort(403);
		}
		abort(404);
	}
}
