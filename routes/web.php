<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
| Authentication Routes
*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
/*
| Registration Routes
*/
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

/*
| Password Reset Routes
*/
Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
| Prefix Auth
*/
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function()
{
	/*
	| Used to start session social with Twitter, Linkedin and Facebook
	*/
	Route::get('{provider}', ['as' => 'provider', 'uses' => 'Auth\LoginController@redirectToProvider']);
	Route::get('{provider}/callback', ['as' => 'provider.callback', 'uses' => 'Auth\LoginController@handleProviderCallback']);
});
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);

/*
|--------------------------------------------------------------------------
| Secure Routes Application
|--------------------------------------------------------------------------
*/
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::group(['middleware' => 'auth'], function()
{
	/*
	| Prefix Chat
	*/
	Route::resource('chat', 'Chat\ChatController', ['only' => ['index']]);

    /*
	| Prefix Comunidad
	*/
	Route::group(['prefix' => 'comunidad', 'as' => 'comunidad.'], function()
	{
		Route::resource('canalusuario', 'CanalUsuarioController', ['only' => ['index','store','update']]);

		Route::get('{canal}/create', ['as' => 'create', 'uses' => 'MuroController@index']);
	});
	Route::resource('comunidad', 'MuroController', ['only' => ['index','store','destroy','update','show']]);

	/*
	| Prefix Mentoring
	*/
	Route::group(['prefix' => 'mentoria', 'as' => 'mentoria.'], function()
	{
		/*
		| Prefix Mentoring Answers
		*/
		Route::group(['prefix' => 'preguntas', 'as' => 'preguntas.'], function()
		{
			Route::get('rechazar/{asesoria}', ['as' => 'rechazar', 'uses' => 'AsesoriaController@destroy']);
			Route::get('aceptar/{asesoria}', ['as' => 'aceptar', 'uses' => 'AsesoriaController@aceptar']);
			// Evaluation
			Route::group(['prefix' => 'evaluacion', 'as' => 'evaluacion.'], function()
			{
				Route::get('mentor/create/{user}', ['as' => 'mentor.create', 'uses' => 'EvaluacionAsesoriaController@create']);
				Route::resource('mentor', 'EvaluacionAsesoriaController', ['only' => ['index', 'store']]);
			});
		});

		Route::group(['prefix' => 'mentores', 'as' => 'mentores.'], function() {
			Route::resource('procesos', 'ProcesoMentoriaController', ['only' => ['index', 'show']]);
		});

		Route::resource('preguntas', 'AsesoriaController', ['only' => ['index','show', 'create','store','update']]);
		Route::resource('mentores', 'MentorController', ['only' => ['index', 'show', 'create', 'store', 'update']]);
		Route::group(['prefix' => 'sesiones', 'as' => 'sesiones.'], function() {
			Route::resource('tarea', 'TareaMentoriaController', ['only' => ['index','store', 'destroy','update']]);
			Route::resource('tags', 'TagsMentoriaController', ['only' => ['index','store', 'destroy','update']]);
			Route::post('objetivo', ['as' => 'objetivo', 'uses' => 'MentoriaSessionesController@generalObjetive']);
			Route::post('descripcion', ['as' => 'descripcion', 'uses' => 'MentoriaSessionesController@descriptionMentoring']);
			Route::post('finalizar', ['as' => 'finalizar', 'uses' => 'MentoriaSessionesController@finishedMentoring']);
			Route::post('duration', ['as' => 'duration', 'uses' => 'MentoriaSessionesController@durationMentoring']);
			Route::post('phase', ['as' => 'phase', 'uses' => 'MentoriaSessionesController@phaseMentoring']);
			Route::post('recommends', ['as' => 'recommends', 'uses' => 'MentoriaSessionesController@recommendsMentoring']);
			Route::post('tracing', ['as' => 'tracing', 'uses' => 'MentoriaSessionesController@tracingMentoring']);
			Route::post('assigvoucher', ['as' => 'assigvoucher', 'uses' => 'MentoriaSessionesController@assigvoucherMentoring']);
			Route::post('diagnosis', ['as' => 'diagnosis', 'uses' => 'MentoriaSessionesController@diagnosisMentoring']);
		});
		Route::resource('sessiones', 'MentoriaSessionesController', ['except' => ['edit']]);
	});
	Route::resource('mentoria', 'MentoriaController', ['only' => ['index']]);



	/*
	| Prefix File
	*/
	Route::group(['prefix' => 'file', 'as' => 'file.'], function()
	{
		Route::post('temp', ['as' => 'temp', 'uses' => 'FileController@temp']);
		Route::post('crop', ['as' => 'crop', 'uses' => 'FileController@crop']);
		Route::post('upload', ['as' => 'upload', 'uses' => 'FileController@upload']);
	});

});

/*
|--------------------------------------------------------------------------
| Public Routes Application
|--------------------------------------------------------------------------
| Prefix User
*/
Route::group(['prefix' => 'usuario', 'as' => 'usuario.'], function()
{
	Route::resource('identificacion', 'TipoIdentificacionController', ['only' => ['index']]);

	Route::group(['prefix' => 'economicos', 'as' => 'economicos.'], function()
	{
		Route::get('selectorlist', ['as' => 'selector.list', 'uses' => 'SectorEconomicoPersonaController@selectorlist']);
	});
	Route::resource('economicos', 'SectorEconomicoPersonaController', ['only' => ['index', 'update', 'destroy']]);

	Route::resource('razones', 'RazonRegistroUsuarioController', ['only' => ['index', 'update', 'destroy']]);

	Route::group(['prefix' => 'especialidades', 'as' => 'especialidades.'], function()
	{
		Route::get('selectorlist', ['as' => 'selector.list', 'uses' => 'EspecialidadUsuarioController@selectorlist']);
	});
	Route::resource('especialidades', 'EspecialidadUsuarioController', ['only' => ['index', 'update', 'destroy']]);
	Route::resource('intereses', 'SectorInteresUsuarioController', ['only' => ['index', 'update', 'destroy']]);
	Route::resource('educaciones', 'NivelEducacionUsuarioController', ['only' => ['index', 'store', 'destroy']]);
	Route::resource('conceptos', 'ConceptoController', ['only' => ['index']]);
	Route::resource('convocatorias', 'RegistroFaseUsuarioController', ['only' => ['index']]);
	Route::patch('socialnetworks/{usuario}', ['as' => 'socialnetworks', 'uses' => 'UsuarioController@socialNetworks']);
	Route::get('auth', ['as' => 'auth', 'uses' => 'UsuarioController@auth']);
	Route::get('confirmdeactivation', ['as' => 'confirmdeactivation', 'uses' => 'UsuarioController@confirmdeactivation']);
	Route::get('usernameavailable', ['as' => 'usernameavailable', 'uses' => 'UsuarioController@usernameAvailable']);

	/*
	| Prefix Verify email user
	*/
	Route::get('valid', ['as' => 'valid.email', 'uses' => 'UsuarioController@verifyEmail']);

    /*
	| Prefix RedUsuario
	*/
	Route::group(['prefix' => 'redusuario', 'as' => 'redusuario.'], function()
	{
        Route::get('confirmar', ['as' => 'confirmar', 'uses' => 'RedUsuarioController@confirm']);
    });
    Route::resource('redusuario', 'RedUsuarioController', ['only' => ['index','store', 'show', 'update']]);

	/*
	| Prefix Confirmar Email
	*/
	Route::group(['prefix' => 'confirmacion', 'as' => 'confirmacion.'], function()
	{
        Route::get('{email}', ['as' => 'confirmar', 'uses' => 'UsuarioController@confirmAccount']);
		Route::post('correo', ['as' => 'email', 'uses' => 'UsuarioController@sendMailConfirmation']);
	});

	/*
	| Prefix team
	*/
	Route::group(['prefix' => 'equipo', 'as' => 'equipo.'], function()
	{
		Route::get('confirmar', ['as' => 'confirmar', 'uses' => 'GrupoUsuarioController@confirmar']);
	});
	Route::resource('equipo', 'GrupoUsuarioController', ['only' => ['index', 'store', 'show', 'destroy']]);

	Route::get('{nickname}', ['as' => 'nickname', 'uses' => 'UsuarioController@showUrl']);
	Route::get('{nickname}/{tab?}', ['as' => 'nickname.tab', 'uses' => 'UsuarioController@showUrl'])->where('tab', 'basico|comunidad|calendario|proyectos|preferencias|contactos|mensajes|productos|convocatorias');
});
Route::resource('usuario', 'UsuarioController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::get('deactivation', ['as' => 'deactivation', 'uses' => 'UsuarioController@deactivation']);

/*
| Prefix VerifyAccount
*/
Route::group(['prefix' => 'verifyaccount'], function()
{
	Route::get('{user}', ['as' => 'verify.account.mail', 'uses' => 'UsuarioController@verifyaccountmail']);
});
Route::get('verifyaccount', ['as' => 'verify.account', 'uses' => 'UsuarioController@verifyaccount']);

/*
| Ciudades
*/
Route::resource('ciudades', 'CiudadController', ['only' => ['index']]);

/*
| Profesiones
*/
Route::resource('profesiones', 'ProfesionController', ['only' => ['index']]);

/*
| Ocupaciones
*/
Route::resource('ocupaciones', 'OcupacionController', ['only' => ['index']]);

/*
| Prefix Like
*/
Route::resource('like', 'LikeController', ['only' => ['index','store','show','destroy']]);

/*
| Prefix Fav
*/
Route::resource('fav', 'FavController', ['only' => ['index','store','update']]);

/*
| Prefix Tag
*/
Route::resource('tag', 'TagController', ['only' => ['index']]);

/*
| Prefix Forum
*/
Route::resource('foro', 'ForoController', ['only' => ['index','show','store','update','destroy']]);
Route::group(['prefix' => 'foro', 'as' => 'foro.'], function()
{
	Route::get('{category}/{theme}', ['as' => 'categoria.tema', 'uses' => 'ForoController@showUrl']);
});

/*
| Prefix Project
*/
Route::resource('proyecto', 'ProyectoController', ['only' => ['index','create','store','update', 'destroy']]);
Route::group(['prefix' => 'proyecto', 'as' => 'proyecto.'], function()
{
	Route::resource('etapa', 'EtapaProyectoController', ['only' => ['index']]);
	Route::resource('intereses', 'SectorInteresProyectoController', ['only' => ['index', 'update', 'destroy']]);
	Route::resource('patrocinador', 'PatrocinadorEntidadController', ['only' => ['index', 'update', 'destroy']]);
	Route::resource('categoriaclase', 'CategoriaClaseEspacioController', ['only' => ['show']]);
	Route::resource('modelodenegocio', 'ModeloNegocioController', ['only' => ['index']]);

	/*
	| Prefix Mentor Emprendimiento
	*/
	Route::group(['prefix' => 'mentoremprendimiento', 'as' => 'mentoremprendimiento.'], function()
	{
		Route::get('confirmar', ['as' => 'confirmar', 'uses' => 'MentorEmprendimientoController@confirm']);
	});
	Route::resource('mentoremprendimiento', 'MentorEmprendimientoController', ['only' => ['index','store']]);

	Route::get('{type}', ['as' => 'tipo', 'uses' => 'ProyectoController@index'])->where('type', 'micontenido');
	Route::get('{proyecto}', ['as' => 'proyecto', 'uses' => 'ProyectoController@showUrl']);

	Route::get('{proyecto}/{tab?}', ['as' => 'proyecto.tab', 'uses' => 'ProyectoController@showUrl'])->where('tab', 'basico|integrantes|productos|discusiones|encuestas');
	Route::get('{proyecto}/{privadetab?}', ['as' => 'proyecto.privadetab', 'uses' => 'ProyectoController@showPrivadeUrl'])->where('tab', 'documentos|convocatorias');
});

/*
 Citas
*/
Route::resource('citas', 'CitasController', ['only' => ['index','create','store','update', 'destroy']]);
Route::group(['prefix' => 'citas', 'as' => 'citas.'], function()
{
	Route::get('agendar', 'CitasController@create');
	Route::post('save', ['as' => 'save', 'uses' => 'CitasController@store']);
	Route::post('availability', ['availability' => 'save', 'uses' => 'CitasController@availability']  );
});

/*
| Prefix Group
*/
Route::group(['prefix' => 'grupo', 'as' => 'grupo.'], function()
{
	Route::resource('equipo', 'GrupoEquipoController', ['only' => ['index', 'store', 'update']]);
	Route::resource('cluster', 'AgrupacionProyectoController', ['only' => ['index']]);

	Route::get('{grupo}', ['as' => 'grupo', 'uses' => 'GrupoController@showUrl']);
	Route::get('{grupo}/{tab?}', ['as' => 'grupo.tab', 'uses' => 'GrupoController@showUrl'])->where('tab', 'basico|integrantes|discusiones');

});
Route::resource('grupo', 'GrupoController', ['only' => ['index', 'update']]);

/*
| Prefix Calls
*/
Route::group(['prefix' => 'convocatoria', 'as' => 'convocatoria.'], function()
{
	Route::get('selectorlist', ['as' => 'selector.list', 'uses' => 'ConvocatoriaController@selectorlist']);
	Route::get('aplicar/validacion', ['as' => 'aplicar.validacion', 'uses' => 'ConvocatoriaController@validApply']);
	Route::get('{convocatoria}/aplicar/{step}', ['as' => 'aplicar', 'uses' => 'ConvocatoriaController@apply'])->where('step', 'terminos|entidad|formulario');
	Route::group(['prefix' => 'fase', 'as' => 'fase.'], function()
	{
		Route::resource('adjunto', 'AdjuntoFaseUsuarioController', ['only' => ['index', 'store', 'update']]);
	});
	Route::resource('fase', 'FaseController', ['only' => ['index', 'update']]);
	Route::resource('usuario', 'FaseUsuarioController', ['only' => ['index']]);
	Route::get('{convocatoria}', ['as' => 'convocatoria', 'uses' => 'ConvocatoriaController@showUrl']);
});
Route::resource('convocatoria', 'ConvocatoriaController', ['only' => ['index']]);

/*
| Prefix Learn
*/
Route::group(['prefix' => 'aprende', 'as' => 'aprende.'], function()
{
    Route::get('{type}/{category}/{course}/contenido/{theme}/{class}', array('as' => 'curso.tema.clase', 'uses' => 'AprendeController@showCourseThemeClass'))->where('type', 'cursos|webinars|conferencias|micontenido|capacitacion|bienestar');
    Route::get('{type}/{category}/{course}/formulario/{survey}', array('as' => 'curso.tema.formulario', 'uses' => 'AprendeController@showCourseThemeSurvey'))->where('type', 'cursos|webinars|conferencias|micontenido|capacitacion|bienestar');
	Route::get('{type}/{category}/{course}/contenido', ['as' => 'contenido', 'uses' => 'AprendeController@showContentCourse'])->where('type', 'cursos|webinars|conferencias|micontenido|capacitacion|bienestar');
	Route::get('{type}/{category}/{course}', ['as' => 'categoria.curso', 'uses' => 'AprendeController@showCategoryCourse'])->where('type', 'cursos|webinars|conferencias|micontenido|capacitacion|bienestar');
	Route::get('{type}/{category}', ['as' => 'categoria', 'uses' => 'AprendeController@filterCategory'])->where('type', 'cursos|webinars|conferencias|micontenido|capacitacion|bienestar');
	Route::get('{type}', ['as' => 'tipo', 'uses' => 'CursoController@index'])->where('type', 'cursos|webinars|conferencias|micontenido|cursosColaboradores|bienestar');
	Route::get('biometric/{uri}', array('as' => 'curso.biometric', 'uses' => 'AprendeController@biometricValidation'));
	Route::post('validate', ['as' => 'validate', 'uses' => 'AprendeController@validationBio']);

	//Prefix Curso
	Route::group(['prefix' => 'curso', 'as' => 'curso.'], function()
	{
		Route::resource('inscripcioncurso', 'InscripcionCursoController', ['only' => ['index','store','update','destroy']]);
		Route::resource('adjunto', 'AdjuntoCursoController', ['only' => ['index']]);
		Route::resource('notausuario', 'NotaUsuarioController', ['only' => ['index','store','destroy']]);
		Route::post('certificado', ['as' => 'certificado', 'uses' => 'CursoController@certificate']);
		Route::post('certificadoTotal', ['as' => 'certificadoTotal', 'uses' => 'CursoController@certificateTotal']);

		//Prefix tema
		Route::group(['prefix' => 'tema', 'as' => 'tema.'], function()
		{
			Route::resource('adjunto', 'AdjuntoTemaController', ['only' => ['index', 'update']]);
		});
		Route::resource('tema', 'TemaCursoController', ['only' => ['index']]);
	});
	Route::resource('curso', 'CursoController', ['only' => ['index', 'update']]);
	Route::get('curso/{curso}', ['as' => 'curso', 'uses' => 'CursoController@showUrl']);
});
Route::resource('aprende', 'AprendeController', ['only' => ['index']]);

//Prefix Discusion
Route::group(['prefix' => 'discusion', 'as' => 'discusion.'], function()
{
	Route::resource('participantes', 'ParticipanteDiscusionController', ['only' => ['index']]);
	Route::resource('comentario', 'ComentarioDiscusionController', ['only' => ['index','store','destroy']]);
});
Route::resource('discusion', 'DiscusionController', ['only' => ['index', 'show', 'store', 'destroy']]);

/*
| Prefix Blog
*/
Route::resource('blog', 'BlogController', ['only' => ['index', 'create', 'store', 'update']]);
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function()
{
	Route::get('{category}', ['as' => 'categoria', 'uses' => 'BlogController@filterCategory']);
	Route::get('{category}/{article}', ['as' => 'categoria.articulo', 'uses' => 'BlogController@showUrl']);
});

/*
| Prefix Calendar
*/
Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function()
{
	Route::group(['prefix' => 'evento', 'as' => 'evento.'], function()
	{
		Route::resource('participar', 'UsuarioEventoController', ['only' => ['index', 'store', 'show', 'destroy']]);
		Route::get('tema', ['as' => 'tema', 'uses' => 'EventoController@temaseventolist']);
	});
	Route::resource('evento', 'EventoController', ['only' => ['index','show','update','store','destroy']]);
});
Route::resource('calendario', 'CalendarioController', ['only' => ['index', 'show']]);

/*
| Prefix Marketplace
*/
Route::group(['prefix' => 'marketplace', 'as' => 'marketplace.'], function()
{
	//Prefix Eval Purchase
	Route::resource('evaluacion', 'EvaluacionCompraController', ['only' => ['index', 'store']]);
	//Prefix Eval Purchase
	Route::resource('voucher', 'VoucherController', ['only' => ['index']]);
	Route::resource('categoriaproducto', 'CategoriaProductoController', ['only' => ['index']]);
	Route::get('{tab}/evaluacion/{purchase}', ['as' => 'evaluacion.purchase', 'uses' => 'EvaluacionCompraController@evaluate'])->where('tab', 'compras|ventas');
	Route::get('compras/evaluaciongeneral', ['as' => 'evaluaciongeneral', 'uses' => 'EvaluacionGeneralCompraController@evaluate']);
	Route::get('providerlist', ['as' => 'provider.index', 'uses' => 'UsuarioController@listProviders']);

	// Marketplace deliberables agreement purchase
	Route::get('{tab}/entregables/{purchase}', ['as' => 'entregables.purchase', 'uses' => 'AdjuntoEntregableAcuerdoController@deliberable'])->where('tab', 'compras|ventas');
	Route::get('entregables/compra',  'AdjuntoEntregableAcuerdoController@getEntregables');
	Route::post('entregables/compra/storeAdjuntoRutan',  'AdjuntoEntregableAcuerdoController@storeEntregables');
	Route::post('entregables/compra/sendDeliverables',  'AdjuntoEntregableAcuerdoController@sendDeliverables');
	Route::post('entregables/compra/storeAdjuntoEntregables',  'AdjuntoEntregableAcuerdoController@storeAdjuntoEntregables');

	//Prefix Seller
	Route::group(['prefix' => 'ventas', 'as' => 'ventas.'], function()
	{
		Route::group(['prefix' => 'acuerdo', 'as' => 'acuerdo.'], function()
		{
			Route::get('create/{venta}', ['as' => 'create', 'uses' => 'AcuerdoController@create']);
		});
		Route::resource('acuerdo', 'AcuerdoController', ['only' => ['index','store','edit','update','show']]);
		Route::resource('promocion', 'PromocionController', ['except' => ['destroy']]);
		Route::resource('informe', 'AdjuntoAcuerdoController', ['only' => ['index','store','update','destroy']]);
	});
	Route::resource('ventas', 'VendedorController', ['only' => ['index','create','store']]);

	//Prefix Purchaser
	Route::group(['prefix' => 'compras', 'as' => 'compras.'], function()
	{
		Route::group(['prefix' => 'acuerdo', 'as' => 'acuerdo.'], function()
		{
			Route::post('confirmar', ['as' => 'confirmar', 'uses' => 'AcuerdoController@confirmar']);
		});

		Route::resource('acuerdo', 'AcuerdoController', ['only' => ['show']]);
        Route::resource('offer', 'OfertaController', ['only' => ['index', 'store']]);

        Route::group(['middleware' => ['pasos_compra']], function () {
            Route::resource('shipping', 'EnvioCompraController', ['only' => ['edit','update'] ]);
		    Route::resource('payment', 'PagoCompraController', ['only' => ['edit','update']]);
		    Route::resource('confirm', 'ConfirmarCompraController', ['only' => ['edit','update']]);

        });

      	Route::get('{purchase}/create', ['as' => 'offer.create', 'uses' => 'CompraController@create']);
		Route::get('success/{purchase}', ['as' => 'success', 'uses' => 'ConfirmarCompraController@success']);
		Route::get('validvoucher/{purchase}', ['as' => 'validvoucher', 'uses' => 'CompraController@validVoucher']);
	});

	Route::resource('compras', 'CompraController', ['only' => ['index', 'create', 'store', 'update', 'show']]);
	Route::get('{tab}', ['as' => 'tab', 'uses' => 'ProductoController@index'])->where('tab', 'favoritos|misproductos');
});
Route::resource('marketplace', 'ProductoController', ['except' => ['edit']]);

/*
| Prefix Evaluador
*/
Route::group(['prefix' => 'evaluacion', 'as' => 'evaluacion.'], function()
{
	Route::patch('categoria/{entity}', ['as' => 'categoria', 'uses' => 'EvaluacionEmprendimientoController@entity']);
	Route::get('terminos/{assignment}', ['as' => 'terminos', 'uses' => 'EvaluacionEmprendimientoController@terminos']);
});
Route::resource('evaluacion', 'EvaluacionEmprendimientoController', ['only' => ['index', 'show', 'update', 'destroy']]);


/*
| Prefix Attached
*/
Route::group(['prefix' => 'adjunto', 'as' => 'adjunto.'], function()
{
	Route::resource('producto', 'AdjuntoProductoController', ['only' => ['index','update', 'destroy']]);
	Route::resource('usuario', 'AdjuntoUsuarioController', ['only' => ['index', 'store', 'update', 'destroy']]);
	Route::resource('asesoria', 'AdjuntoAsesoriaController', ['only' => ['index', 'store', 'destroy']]);
	Route::resource('encuesta', 'AdjuntoEncuestaController', ['only' => ['index', 'store']]);
	Route::resource('entregable', 'AdjuntoEntregableAcuerdoController', ['only' => ['index', 'store']]);
	Route::resource('evaluacion', 'AdjuntoEvaluacionController', ['only' => ['index', 'update', 'store']]);
});
Route::resource('adjunto', 'AdjuntoController', ['only' => ['index']]);

/*
| Prefix Faq
*/
Route::group(['prefix' => 'faq', 'as' => 'faq.'], function()
{
	Route::resource('faqconvocatoria', 'FaqConvocatoriaController', ['only' => ['index']]);
});
Route::resource('faq', 'PreguntaFrecuenteController', ['only' => ['index']]);

/*
| Prefix Survey
*/
Route::group(['prefix' => 'encuesta', 'as' => 'encuesta.'], function()
{
	Route::get('register', ['as' => 'register', 'uses' => 'EncuestaController@register']);
	Route::get('aplicar/{encuesta}/{usuario?}', ['as' => 'aplicar', 'uses' => 'EncuestaController@aplicar']);
	Route::get('responder/{encuesta}', ['as' => 'responder', 'uses' => 'EncuestaController@responder']);
	Route::get('revision/{encuesta}/{usuario}', ['as' => 'revision', 'uses' => 'EncuestaController@revision']);
	Route::get('cancelar/{encuesta}', ['as' => 'cancelar', 'uses' => 'EncuestaController@cancelar']);
	Route::get('informe', ['as' => 'informe', 'uses' => 'EncuestaController@informe']);
});
Route::resource('encuesta', 'EncuestaController', ['only' => ['index', 'show', 'update']]);

/*
| Prefix messaging
*/
Route::resource('messaging', 'MessagingController', ['only' => ['index']]);

/*
| Prefix payments
*/
Route::get('precios', ['as' => 'precios', 'uses' => 'PaymentsController@pricing']);
Route::get('reserva', ['as' => 'reserva', 'uses' => 'PaymentsController@reserve']);
Route::resource('comprar', 'PaymentsController', ['only' => ['index', 'store']]);

/*
| Prefix Vote
*/
Route::group(['prefix' => 'voto', 'as' => 'voto.'], function()
{
	Route::get('confirmar/{srcparams}/{user}', ['as' => 'confirmar', 'uses' => 'VotoController@confirmVote']);
	Route::resource('voto', 'VotoController', ['only' => ['store']]);
	Route::get('verify/{vote}', ['as' => 'verify', 'uses' => 'VotoController@verify']);
});

/*
| Prefix Recommendation
*/
Route::resource('recomendacion', 'RecomendacionController', ['only' => ['index', 'store']]);

/*
| Prefix Search
*/
Route::resource('search', 'SearchController', ['only' => ['index']]);

/*
| Prefix Live
*/
Route::resource('live', 'LiveController', ['only' => ['index']]);
Route::resource('enlaconversa', 'EnLaConversaController', ['only' => ['index']]);
Route::get('laconversa', ['as' => 'laconversa', 'uses' => 'EnLaConversaController@index']);

/*
| NotificacionesController
*/
Route::resource('notificaciones', 'NotificacionesController', ['only' => ['index', 'update', 'destroy']]);

/*
| CaracteristicasController
*/
Route::resource('caracteristicas', 'CaracteristicasController', ['only' => ['index', 'show']]);

/*
| HomeController
*/
Route::get('breadcrumb', ['as' => 'breadcrumb', 'uses' => 'HomeController@breadcrumb']);
Route::get('terminos', ['as' => 'terminos', 'uses' => 'HomeController@terminos']);
Route::get('privacidad', ['as' => 'privacidad', 'uses' => 'HomeController@privacidad']);
Route::get('politicaventas', ['as' => 'politicaventas', 'uses' => 'HomeController@politicaventas']);
Route::get('terminos-mentoria', ['as' => 'terminos-mentoria', 'uses' => 'HomeController@terminosmentoria']);

Route::resource('entidad', 'EntidadController', ['only' => ['index']]);

/*
| Middlewares
*/
Route::group(['prefix' => 'step', 'as' => 'step.', 'middleware' => 'auth'], function()
{
	Route::get('confirmar', ['as' => 'confirmar', 'uses' => 'UsuarioController@confirm']);
	Route::get('perfil', ['as' => 'perfil', 'uses' => 'UsuarioController@confirmprofile']);
	Route::get('canales', ['as' => 'canales', 'uses' => 'UsuarioController@channelschoice']);
	Route::get('entidad', ['as' => 'entidad', 'uses' => 'UsuarioController@createentity']);

	Route::resource('terminos', 'TerminosController', ['only' => ['index', 'store']]);
	Route::resource('politicaventas', 'PoliticaVentasController', ['only' => ['index', 'store']]);
	Route::resource('compromiso', 'CartaCompromisoController', ['only' => ['index', 'edit', 'show', 'store']]);
});

/*
| HelpDesk
*/
Route::resource('ayuda', 'AyudaController', ['only' => ['index']]);

/*
| LandingPage
*/
Route::get('{category}/{slug}', ['as' => 'landingpage', 'uses' => 'HomeController@landing'])->where('category', '^(?!.*api).*$');

/*
| Auth Landing
*/
Route::get('{slug}', ['as' => 'landing', 'uses' => 'HomeController@show']);

Route::resource('log_curso', 'LogCursoController', ['only' => ['index', 'create', 'store', 'update']]);

Route::get('/debug-config', function() { return [ 'port' => config('database.connections.pgsql.port'), 'db' => config('database.connections.pgsql.database') ]; });
