/**
* @author TuProyecto | Desarrollador: @krobing
* Events ordering by Priority
*/
(function($, window, undefined){


	$.fn.bindNth = function (eTypes, selector, data, fn, index) {
		// Bind event normally.
		this.on(eTypes, selector, data, fn);
		// Move to nth position.
		this.changeEventOrder(eTypes, selector, index);

		return this;
	};

	$.fn.bindFirst = function (eTypes, selector, data, fn) {
		this.bindNth(eTypes, selector, data, fn, 0);

		return this;
	};

	$.fn.changeEventOrder = function (eTypes, selector, newIndex) {
		var that = this;
		// Allow for multiple events.
		$.each(eTypes.split(' '), function (idx, eType) {

			that.each(function () {

				var handlers = $._data(this, 'events')[eType.split('.')[0]];
				// Validate requested position.
				if( handlers ){
					newIndex = Math.min(newIndex, handlers.length - 1);
					handlers.splice(newIndex, 0, handlers.pop());
				}
			});
		});
	};

})(jQuery, this);

(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["GET","HEAD"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/email","name":"password.request","action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":"password.email","action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"password.reset","action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}","name":"auth.provider","action":"App\Http\Controllers\Auth\LoginController@redirectToProvider"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}\/callback","name":"auth.provider.callback","action":"App\Http\Controllers\Auth\LoginController@handleProviderCallback"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home","action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"chat","name":"chat.index","action":"App\Http\Controllers\Chat\ChatController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.index","action":"App\Http\Controllers\CanalUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.store","action":"App\Http\Controllers\CanalUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/canalusuario\/{canalusuario}","name":"comunidad.canalusuario.update","action":"App\Http\Controllers\CanalUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{canal}\/create","name":"comunidad.create","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad","name":"comunidad.index","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["POST"],"uri":"comunidad","name":"comunidad.store","action":"App\Http\Controllers\MuroController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{comunidad}","name":"comunidad.show","action":"App\Http\Controllers\MuroController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/{comunidad}","name":"comunidad.update","action":"App\Http\Controllers\MuroController@update"},{"host":null,"methods":["DELETE"],"uri":"comunidad\/{comunidad}","name":"comunidad.destroy","action":"App\Http\Controllers\MuroController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/rechazar\/{asesoria}","name":"mentoria.preguntas.rechazar","action":"App\Http\Controllers\AsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/aceptar\/{asesoria}","name":"mentoria.preguntas.aceptar","action":"App\Http\Controllers\AsesoriaController@aceptar"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor\/create\/{user}","name":"mentoria.preguntas.evaluacion.mentor.create","action":"App\Http\Controllers\EvaluacionAsesoriaController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.index","action":"App\Http\Controllers\EvaluacionAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.store","action":"App\Http\Controllers\EvaluacionAsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.index","action":"App\Http\Controllers\AsesoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/create","name":"mentoria.preguntas.create","action":"App\Http\Controllers\AsesoriaController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.store","action":"App\Http\Controllers\AsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.show","action":"App\Http\Controllers\AsesoriaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.update","action":"App\Http\Controllers\AsesoriaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores","name":"mentoria.mentores.index","action":"App\Http\Controllers\MentorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/create","name":"mentoria.mentores.create","action":"App\Http\Controllers\MentorController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/mentores","name":"mentoria.mentores.store","action":"App\Http\Controllers\MentorController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.show","action":"App\Http\Controllers\MentorController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.update","action":"App\Http\Controllers\MentorController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria","name":"mentoria.index","action":"App\Http\Controllers\MentoriaController@index"},{"host":null,"methods":["POST"],"uri":"file\/temp","name":"file.temp","action":"App\Http\Controllers\FileController@temp"},{"host":null,"methods":["POST"],"uri":"file\/crop","name":"file.crop","action":"App\Http\Controllers\FileController@crop"},{"host":null,"methods":["POST"],"uri":"file\/upload","name":"file.upload","action":"App\Http\Controllers\FileController@upload"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/identificacion","name":"usuario.identificacion.index","action":"App\Http\Controllers\TipoIdentificacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/economicos","name":"usuario.economicos.index","action":"App\Http\Controllers\SectorEconomicoPersonaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.update","action":"App\Http\Controllers\SectorEconomicoPersonaController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.destroy","action":"App\Http\Controllers\SectorEconomicoPersonaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/razones","name":"usuario.razones.index","action":"App\Http\Controllers\RazonRegistroUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/razones\/{razones}","name":"usuario.razones.update","action":"App\Http\Controllers\RazonRegistroUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/razones\/{razones}","name":"usuario.razones.destroy","action":"App\Http\Controllers\RazonRegistroUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/especialidades","name":"usuario.especialidades.index","action":"App\Http\Controllers\EspecialidadUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/especialidades\/{especialidades}","name":"usuario.especialidades.update","action":"App\Http\Controllers\EspecialidadUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/especialidades\/{especialidades}","name":"usuario.especialidades.destroy","action":"App\Http\Controllers\EspecialidadUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/intereses","name":"usuario.intereses.index","action":"App\Http\Controllers\SectorInteresUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/intereses\/{intereses}","name":"usuario.intereses.update","action":"App\Http\Controllers\SectorInteresUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/intereses\/{intereses}","name":"usuario.intereses.destroy","action":"App\Http\Controllers\SectorInteresUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/educaciones","name":"usuario.educaciones.index","action":"App\Http\Controllers\NivelEducacionUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/educaciones","name":"usuario.educaciones.store","action":"App\Http\Controllers\NivelEducacionUsuarioController@store"},{"host":null,"methods":["DELETE"],"uri":"usuario\/educaciones\/{educaciones}","name":"usuario.educaciones.destroy","action":"App\Http\Controllers\NivelEducacionUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/conceptos","name":"usuario.conceptos.index","action":"App\Http\Controllers\ConceptoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/convocatorias","name":"usuario.convocatorias.index","action":"App\Http\Controllers\RegistroFaseUsuarioController@index"},{"host":null,"methods":["PATCH"],"uri":"usuario\/socialnetworks\/{usuario}","name":"usuario.socialnetworks","action":"App\Http\Controllers\UsuarioController@socialNetworks"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/auth","name":"usuario.auth","action":"App\Http\Controllers\UsuarioController@auth"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/confirmdeactivation","name":"usuario.confirmdeactivation","action":"App\Http\Controllers\UsuarioController@confirmdeactivation"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/usernameavailable","name":"usuario.usernameavailable","action":"App\Http\Controllers\UsuarioController@usernameAvailable"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/valid","name":"usuario.valid.email","action":"App\Http\Controllers\UsuarioController@verifyEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario\/confirmar","name":"usuario.redusuario.confirmar","action":"App\Http\Controllers\RedUsuarioController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario","name":"usuario.redusuario.index","action":"App\Http\Controllers\RedUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/redusuario","name":"usuario.redusuario.store","action":"App\Http\Controllers\RedUsuarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario\/{redusuario}","name":"usuario.redusuario.show","action":"App\Http\Controllers\RedUsuarioController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/redusuario\/{redusuario}","name":"usuario.redusuario.update","action":"App\Http\Controllers\RedUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/confirmacion\/{email}","name":"usuario.confirmacion.confirmar","action":"App\Http\Controllers\UsuarioController@confirmAccount"},{"host":null,"methods":["POST"],"uri":"usuario\/confirmacion\/correo","name":"usuario.confirmacion.email","action":"App\Http\Controllers\UsuarioController@sendMailConfirmation"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo\/confirmar","name":"usuario.equipo.confirmar","action":"App\Http\Controllers\GrupoUsuarioController@confirmar"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo","name":"usuario.equipo.index","action":"App\Http\Controllers\GrupoUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/equipo","name":"usuario.equipo.store","action":"App\Http\Controllers\GrupoUsuarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo\/{equipo}","name":"usuario.equipo.show","action":"App\Http\Controllers\GrupoUsuarioController@show"},{"host":null,"methods":["DELETE"],"uri":"usuario\/equipo\/{equipo}","name":"usuario.equipo.destroy","action":"App\Http\Controllers\GrupoUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/{nickname}","name":"usuario.nickname","action":"App\Http\Controllers\UsuarioController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/{nickname}\/{tab?}","name":"usuario.nickname.tab","action":"App\Http\Controllers\UsuarioController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario","name":"usuario.index","action":"App\Http\Controllers\UsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario","name":"usuario.store","action":"App\Http\Controllers\UsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/{usuario}","name":"usuario.update","action":"App\Http\Controllers\UsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/{usuario}","name":"usuario.destroy","action":"App\Http\Controllers\UsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"deactivation","name":"deactivation","action":"App\Http\Controllers\UsuarioController@deactivation"},{"host":null,"methods":["GET","HEAD"],"uri":"verifyaccount\/{user}","name":"verify.account.mail","action":"App\Http\Controllers\UsuarioController@verifyaccountmail"},{"host":null,"methods":["GET","HEAD"],"uri":"verifyaccount","name":"verify.account","action":"App\Http\Controllers\UsuarioController@verifyaccount"},{"host":null,"methods":["GET","HEAD"],"uri":"ciudades","name":"ciudades.index","action":"App\Http\Controllers\CiudadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"profesiones","name":"profesiones.index","action":"App\Http\Controllers\ProfesionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ocupaciones","name":"ocupaciones.index","action":"App\Http\Controllers\OcupacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"like","name":"like.index","action":"App\Http\Controllers\LikeController@index"},{"host":null,"methods":["POST"],"uri":"like","name":"like.store","action":"App\Http\Controllers\LikeController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"like\/{like}","name":"like.show","action":"App\Http\Controllers\LikeController@show"},{"host":null,"methods":["DELETE"],"uri":"like\/{like}","name":"like.destroy","action":"App\Http\Controllers\LikeController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"fav","name":"fav.index","action":"App\Http\Controllers\FavController@index"},{"host":null,"methods":["POST"],"uri":"fav","name":"fav.store","action":"App\Http\Controllers\FavController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"fav\/{fav}","name":"fav.update","action":"App\Http\Controllers\FavController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tag","name":"tag.index","action":"App\Http\Controllers\TagController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"foro","name":"foro.index","action":"App\Http\Controllers\ForoController@index"},{"host":null,"methods":["POST"],"uri":"foro","name":"foro.store","action":"App\Http\Controllers\ForoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"foro\/{foro}","name":"foro.show","action":"App\Http\Controllers\ForoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"foro\/{foro}","name":"foro.update","action":"App\Http\Controllers\ForoController@update"},{"host":null,"methods":["DELETE"],"uri":"foro\/{foro}","name":"foro.destroy","action":"App\Http\Controllers\ForoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"foro\/{category}\/{theme}","name":"foro.categoria.tema","action":"App\Http\Controllers\ForoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto","name":"proyecto.index","action":"App\Http\Controllers\ProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/create","name":"proyecto.create","action":"App\Http\Controllers\ProyectoController@create"},{"host":null,"methods":["POST"],"uri":"proyecto","name":"proyecto.store","action":"App\Http\Controllers\ProyectoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/{proyecto}","name":"proyecto.update","action":"App\Http\Controllers\ProyectoController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/{proyecto}","name":"proyecto.destroy","action":"App\Http\Controllers\ProyectoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/intereses","name":"proyecto.intereses.index","action":"App\Http\Controllers\SectorInteresProyectoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/intereses\/{intereses}","name":"proyecto.intereses.update","action":"App\Http\Controllers\SectorInteresProyectoController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/intereses\/{intereses}","name":"proyecto.intereses.destroy","action":"App\Http\Controllers\SectorInteresProyectoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/patrocinador","name":"proyecto.patrocinador.index","action":"App\Http\Controllers\PatrocinadorEntidadController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/patrocinador\/{patrocinador}","name":"proyecto.patrocinador.update","action":"App\Http\Controllers\PatrocinadorEntidadController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/patrocinador\/{patrocinador}","name":"proyecto.patrocinador.destroy","action":"App\Http\Controllers\PatrocinadorEntidadController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/categoriaclase\/{categoriaclase}","name":"proyecto.categoriaclase.show","action":"App\Http\Controllers\CategoriaClaseEspacioController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/modelodenegocio","name":"proyecto.modelodenegocio.index","action":"App\Http\Controllers\ModeloNegocioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/mentoremprendimiento\/confirmar","name":"proyecto.mentoremprendimiento.confirmar","action":"App\Http\Controllers\MentorEmprendimientoController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/mentoremprendimiento","name":"proyecto.mentoremprendimiento.index","action":"App\Http\Controllers\MentorEmprendimientoController@index"},{"host":null,"methods":["POST"],"uri":"proyecto\/mentoremprendimiento","name":"proyecto.mentoremprendimiento.store","action":"App\Http\Controllers\MentorEmprendimientoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{type}","name":"proyecto.tipo","action":"App\Http\Controllers\ProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}","name":"proyecto.proyecto","action":"App\Http\Controllers\ProyectoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}\/{tab?}","name":"proyecto.proyecto.tab","action":"App\Http\Controllers\ProyectoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}\/{privadetab?}","name":"proyecto.proyecto.privadetab","action":"App\Http\Controllers\ProyectoController@showPrivadeUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/equipo","name":"grupo.equipo.index","action":"App\Http\Controllers\GrupoEquipoController@index"},{"host":null,"methods":["POST"],"uri":"grupo\/equipo","name":"grupo.equipo.store","action":"App\Http\Controllers\GrupoEquipoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"grupo\/equipo\/{equipo}","name":"grupo.equipo.update","action":"App\Http\Controllers\GrupoEquipoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/cluster","name":"grupo.cluster.index","action":"App\Http\Controllers\AgrupacionProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/{grupo}","name":"grupo.grupo","action":"App\Http\Controllers\GrupoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/{grupo}\/{tab?}","name":"grupo.grupo.tab","action":"App\Http\Controllers\GrupoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo","name":"grupo.index","action":"App\Http\Controllers\GrupoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"grupo\/{grupo}","name":"grupo.update","action":"App\Http\Controllers\GrupoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/aplicar\/validacion","name":"convocatoria.aplicar.validacion","action":"App\Http\Controllers\ConvocatoriaController@validApply"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/{convocatoria}\/aplicar\/{step}","name":"convocatoria.aplicar","action":"App\Http\Controllers\ConvocatoriaController@apply"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/fase\/adjunto","name":"convocatoria.fase.adjunto.index","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"convocatoria\/fase\/adjunto","name":"convocatoria.fase.adjunto.store","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"convocatoria\/fase\/adjunto\/{adjunto}","name":"convocatoria.fase.adjunto.update","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/fase","name":"convocatoria.fase.index","action":"App\Http\Controllers\FaseController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"convocatoria\/fase\/{fase}","name":"convocatoria.fase.update","action":"App\Http\Controllers\FaseController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/usuario","name":"convocatoria.usuario.index","action":"App\Http\Controllers\FaseUsuarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/{convocatoria}","name":"convocatoria.convocatoria","action":"App\Http\Controllers\ConvocatoriaController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria","name":"convocatoria.index","action":"App\Http\Controllers\ConvocatoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/contenido\/{theme}\/{class}","name":"aprende.curso.tema.clase","action":"App\Http\Controllers\AprendeController@showCourseThemeClass"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/formulario\/{survey}","name":"aprende.curso.tema.formulario","action":"App\Http\Controllers\AprendeController@showCourseThemeSurvey"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/contenido","name":"aprende.contenido","action":"App\Http\Controllers\AprendeController@showContentCourse"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}","name":"aprende.categoria.curso","action":"App\Http\Controllers\AprendeController@showCategoryCourse"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}","name":"aprende.categoria","action":"App\Http\Controllers\AprendeController@filterCategory"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}","name":"aprende.tipo","action":"App\Http\Controllers\CursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/inscripcioncurso","name":"aprende.curso.inscripcioncurso.index","action":"App\Http\Controllers\InscripcionCursoController@index"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/inscripcioncurso","name":"aprende.curso.inscripcioncurso.store","action":"App\Http\Controllers\InscripcionCursoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/inscripcioncurso\/{inscripcioncurso}","name":"aprende.curso.inscripcioncurso.update","action":"App\Http\Controllers\InscripcionCursoController@update"},{"host":null,"methods":["DELETE"],"uri":"aprende\/curso\/inscripcioncurso\/{inscripcioncurso}","name":"aprende.curso.inscripcioncurso.destroy","action":"App\Http\Controllers\InscripcionCursoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/adjunto","name":"aprende.curso.adjunto.index","action":"App\Http\Controllers\AdjuntoCursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/notausuario","name":"aprende.curso.notausuario.index","action":"App\Http\Controllers\NotaUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/notausuario","name":"aprende.curso.notausuario.store","action":"App\Http\Controllers\NotaUsuarioController@store"},{"host":null,"methods":["DELETE"],"uri":"aprende\/curso\/notausuario\/{notausuario}","name":"aprende.curso.notausuario.destroy","action":"App\Http\Controllers\NotaUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/tema\/adjunto","name":"aprende.curso.tema.adjunto.index","action":"App\Http\Controllers\AdjuntoTemaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/tema\/adjunto\/{adjunto}","name":"aprende.curso.tema.adjunto.update","action":"App\Http\Controllers\AdjuntoTemaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/tema","name":"aprende.curso.tema.index","action":"App\Http\Controllers\TemaCursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso","name":"aprende.curso.index","action":"App\Http\Controllers\CursoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/{curso}","name":"aprende.curso.update","action":"App\Http\Controllers\CursoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/{curso}","name":"aprende.curso","action":"App\Http\Controllers\CursoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende","name":"aprende.index","action":"App\Http\Controllers\AprendeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/participantes","name":"discusion.participantes.index","action":"App\Http\Controllers\ParticipanteDiscusionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/comentario","name":"discusion.comentario.index","action":"App\Http\Controllers\ComentarioDiscusionController@index"},{"host":null,"methods":["POST"],"uri":"discusion\/comentario","name":"discusion.comentario.store","action":"App\Http\Controllers\ComentarioDiscusionController@store"},{"host":null,"methods":["DELETE"],"uri":"discusion\/comentario\/{comentario}","name":"discusion.comentario.destroy","action":"App\Http\Controllers\ComentarioDiscusionController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion","name":"discusion.index","action":"App\Http\Controllers\DiscusionController@index"},{"host":null,"methods":["POST"],"uri":"discusion","name":"discusion.store","action":"App\Http\Controllers\DiscusionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/{discusion}","name":"discusion.show","action":"App\Http\Controllers\DiscusionController@show"},{"host":null,"methods":["DELETE"],"uri":"discusion\/{discusion}","name":"discusion.destroy","action":"App\Http\Controllers\DiscusionController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"blog","name":"blog.index","action":"App\Http\Controllers\BlogController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/create","name":"blog.create","action":"App\Http\Controllers\BlogController@create"},{"host":null,"methods":["POST"],"uri":"blog","name":"blog.store","action":"App\Http\Controllers\BlogController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"blog\/{blog}","name":"blog.update","action":"App\Http\Controllers\BlogController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/{category}","name":"blog.categoria","action":"App\Http\Controllers\BlogController@filterCategory"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/{category}\/{article}","name":"blog.categoria.articulo","action":"App\Http\Controllers\BlogController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/participar","name":"calendario.evento.participar.index","action":"App\Http\Controllers\UsuarioEventoController@index"},{"host":null,"methods":["POST"],"uri":"calendario\/evento\/participar","name":"calendario.evento.participar.store","action":"App\Http\Controllers\UsuarioEventoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/participar\/{participar}","name":"calendario.evento.participar.show","action":"App\Http\Controllers\UsuarioEventoController@show"},{"host":null,"methods":["DELETE"],"uri":"calendario\/evento\/participar\/{participar}","name":"calendario.evento.participar.destroy","action":"App\Http\Controllers\UsuarioEventoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento","name":"calendario.evento.index","action":"App\Http\Controllers\EventoController@index"},{"host":null,"methods":["POST"],"uri":"calendario\/evento","name":"calendario.evento.store","action":"App\Http\Controllers\EventoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.show","action":"App\Http\Controllers\EventoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.update","action":"App\Http\Controllers\EventoController@update"},{"host":null,"methods":["DELETE"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.destroy","action":"App\Http\Controllers\EventoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario","name":"calendario.index","action":"App\Http\Controllers\CalendarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/evaluacion","name":"marketplace.evaluacion.index","action":"App\Http\Controllers\EvaluacionCompraController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/evaluacion","name":"marketplace.evaluacion.store","action":"App\Http\Controllers\EvaluacionCompraController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/voucher","name":"marketplace.voucher.index","action":"App\Http\Controllers\VoucherController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/categoriaproducto","name":"marketplace.categoriaproducto.index","action":"App\Http\Controllers\CategoriaProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}\/evaluacion\/{purchase}","name":"marketplace.evaluacion.purchase","action":"App\Http\Controllers\EvaluacionCompraController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/evaluaciongeneral","name":"marketplace.evaluaciongeneral","action":"App\Http\Controllers\EvaluacionGeneralCompraController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/providerlist","name":"marketplace.provider.index","action":"App\Http\Controllers\UsuarioController@listProviders"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}\/entregables\/{purchase}","name":"marketplace.entregables.purchase","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@deliberable"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/create\/{venta}","name":"marketplace.ventas.acuerdo.create","action":"App\Http\Controllers\AcuerdoController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo","name":"marketplace.ventas.acuerdo.index","action":"App\Http\Controllers\AcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/acuerdo","name":"marketplace.ventas.acuerdo.store","action":"App\Http\Controllers\AcuerdoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}","name":"marketplace.ventas.acuerdo.show","action":"App\Http\Controllers\AcuerdoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}\/edit","name":"marketplace.ventas.acuerdo.edit","action":"App\Http\Controllers\AcuerdoController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}","name":"marketplace.ventas.acuerdo.update","action":"App\Http\Controllers\AcuerdoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion","name":"marketplace.ventas.promocion.index","action":"App\Http\Controllers\PromocionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/create","name":"marketplace.ventas.promocion.create","action":"App\Http\Controllers\PromocionController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/promocion","name":"marketplace.ventas.promocion.store","action":"App\Http\Controllers\PromocionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/{promocion}","name":"marketplace.ventas.promocion.show","action":"App\Http\Controllers\PromocionController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/{promocion}\/edit","name":"marketplace.ventas.promocion.edit","action":"App\Http\Controllers\PromocionController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/promocion\/{promocion}","name":"marketplace.ventas.promocion.update","action":"App\Http\Controllers\PromocionController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/informe","name":"marketplace.ventas.informe.index","action":"App\Http\Controllers\AdjuntoAcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/informe","name":"marketplace.ventas.informe.store","action":"App\Http\Controllers\AdjuntoAcuerdoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/informe\/{informe}","name":"marketplace.ventas.informe.update","action":"App\Http\Controllers\AdjuntoAcuerdoController@update"},{"host":null,"methods":["DELETE"],"uri":"marketplace\/ventas\/informe\/{informe}","name":"marketplace.ventas.informe.destroy","action":"App\Http\Controllers\AdjuntoAcuerdoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas","name":"marketplace.ventas.index","action":"App\Http\Controllers\VendedorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/create","name":"marketplace.ventas.create","action":"App\Http\Controllers\VendedorController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas","name":"marketplace.ventas.store","action":"App\Http\Controllers\VendedorController@store"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras\/acuerdo\/confirmar","name":"marketplace.compras.acuerdo.confirmar","action":"App\Http\Controllers\AcuerdoController@confirmar"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/acuerdo\/{acuerdo}","name":"marketplace.compras.acuerdo.show","action":"App\Http\Controllers\AcuerdoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/offer","name":"marketplace.compras.offer.index","action":"App\Http\Controllers\OfertaController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras\/offer","name":"marketplace.compras.offer.store","action":"App\Http\Controllers\OfertaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/shipping\/{shipping}\/edit","name":"marketplace.compras.shipping.edit","action":"App\Http\Controllers\EnvioCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/shipping\/{shipping}","name":"marketplace.compras.shipping.update","action":"App\Http\Controllers\EnvioCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/payment\/{payment}\/edit","name":"marketplace.compras.payment.edit","action":"App\Http\Controllers\PagoCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/payment\/{payment}","name":"marketplace.compras.payment.update","action":"App\Http\Controllers\PagoCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/confirm\/{confirm}\/edit","name":"marketplace.compras.confirm.edit","action":"App\Http\Controllers\ConfirmarCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/confirm\/{confirm}","name":"marketplace.compras.confirm.update","action":"App\Http\Controllers\ConfirmarCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/{purchase}\/create","name":"marketplace.compras.offer.create","action":"App\Http\Controllers\CompraController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/success\/{purchase}","name":"marketplace.compras.success","action":"App\Http\Controllers\ConfirmarCompraController@success"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/validvoucher\/{purchase}","name":"marketplace.compras.validvoucher","action":"App\Http\Controllers\CompraController@validVoucher"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras","name":"marketplace.compras.index","action":"App\Http\Controllers\CompraController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/create","name":"marketplace.compras.create","action":"App\Http\Controllers\CompraController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras","name":"marketplace.compras.store","action":"App\Http\Controllers\CompraController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/{compras}","name":"marketplace.compras.show","action":"App\Http\Controllers\CompraController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/{compras}","name":"marketplace.compras.update","action":"App\Http\Controllers\CompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}","name":"marketplace.tab","action":"App\Http\Controllers\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace","name":"marketplace.index","action":"App\Http\Controllers\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/create","name":"marketplace.create","action":"App\Http\Controllers\ProductoController@create"},{"host":null,"methods":["POST"],"uri":"marketplace","name":"marketplace.store","action":"App\Http\Controllers\ProductoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{marketplace}","name":"marketplace.show","action":"App\Http\Controllers\ProductoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/{marketplace}","name":"marketplace.update","action":"App\Http\Controllers\ProductoController@update"},{"host":null,"methods":["DELETE"],"uri":"marketplace\/{marketplace}","name":"marketplace.destroy","action":"App\Http\Controllers\ProductoController@destroy"},{"host":null,"methods":["PATCH"],"uri":"evaluacion\/categoria\/{entity}","name":"evaluacion.categoria","action":"App\Http\Controllers\EvaluacionEmprendimientoController@entity"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion\/terminos\/{assignment}","name":"evaluacion.terminos","action":"App\Http\Controllers\EvaluacionEmprendimientoController@terminos"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion","name":"evaluacion.index","action":"App\Http\Controllers\EvaluacionEmprendimientoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.show","action":"App\Http\Controllers\EvaluacionEmprendimientoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.update","action":"App\Http\Controllers\EvaluacionEmprendimientoController@update"},{"host":null,"methods":["DELETE"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.destroy","action":"App\Http\Controllers\EvaluacionEmprendimientoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/producto","name":"adjunto.producto.index","action":"App\Http\Controllers\AdjuntoProductoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/producto\/{producto}","name":"adjunto.producto.update","action":"App\Http\Controllers\AdjuntoProductoController@update"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/producto\/{producto}","name":"adjunto.producto.destroy","action":"App\Http\Controllers\AdjuntoProductoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/usuario","name":"adjunto.usuario.index","action":"App\Http\Controllers\AdjuntoUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/usuario","name":"adjunto.usuario.store","action":"App\Http\Controllers\AdjuntoUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/usuario\/{usuario}","name":"adjunto.usuario.update","action":"App\Http\Controllers\AdjuntoUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/usuario\/{usuario}","name":"adjunto.usuario.destroy","action":"App\Http\Controllers\AdjuntoUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/asesoria","name":"adjunto.asesoria.index","action":"App\Http\Controllers\AdjuntoAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/asesoria","name":"adjunto.asesoria.store","action":"App\Http\Controllers\AdjuntoAsesoriaController@store"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/asesoria\/{asesoria}","name":"adjunto.asesoria.destroy","action":"App\Http\Controllers\AdjuntoAsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/encuesta","name":"adjunto.encuesta.index","action":"App\Http\Controllers\AdjuntoEncuestaController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/encuesta","name":"adjunto.encuesta.store","action":"App\Http\Controllers\AdjuntoEncuestaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/entregable","name":"adjunto.entregable.index","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/entregable","name":"adjunto.entregable.store","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto","name":"adjunto.index","action":"App\Http\Controllers\AdjuntoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"faq\/faqconvocatoria","name":"faq.faqconvocatoria.index","action":"App\Http\Controllers\FaqConvocatoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"faq","name":"faq.index","action":"App\Http\Controllers\PreguntaFrecuenteController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/register","name":"encuesta.register","action":"App\Http\Controllers\EncuestaController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/aplicar\/{encuesta}\/{usuario?}","name":"encuesta.aplicar","action":"App\Http\Controllers\EncuestaController@aplicar"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/responder\/{encuesta}","name":"encuesta.responder","action":"App\Http\Controllers\EncuestaController@responder"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/revision\/{encuesta}\/{usuario}","name":"encuesta.revision","action":"App\Http\Controllers\EncuestaController@revision"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/cancelar\/{encuesta}","name":"encuesta.cancelar","action":"App\Http\Controllers\EncuestaController@cancelar"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/informe","name":"encuesta.informe","action":"App\Http\Controllers\EncuestaController@informe"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta","name":"encuesta.index","action":"App\Http\Controllers\EncuestaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/{encuesta}","name":"encuesta.show","action":"App\Http\Controllers\EncuestaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"encuesta\/{encuesta}","name":"encuesta.update","action":"App\Http\Controllers\EncuestaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"messaging","name":"messaging.index","action":"App\Http\Controllers\MessagingController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"precios","name":"precios","action":"App\Http\Controllers\PaymentsController@pricing"},{"host":null,"methods":["GET","HEAD"],"uri":"comprar","name":"comprar.index","action":"App\Http\Controllers\PaymentsController@index"},{"host":null,"methods":["POST"],"uri":"comprar","name":"comprar.store","action":"App\Http\Controllers\PaymentsController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"voto\/confirmar\/{srcparams}\/{user}","name":"voto.confirmar","action":"App\Http\Controllers\VotoController@confirmVote"},{"host":null,"methods":["POST"],"uri":"voto\/voto","name":"voto.voto.store","action":"App\Http\Controllers\VotoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"recomendacion","name":"recomendacion.index","action":"App\Http\Controllers\RecomendacionController@index"},{"host":null,"methods":["POST"],"uri":"recomendacion","name":"recomendacion.store","action":"App\Http\Controllers\RecomendacionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"search","name":"search.index","action":"App\Http\Controllers\SearchController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"live","name":"live.index","action":"App\Http\Controllers\LiveController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"enlaconversa","name":"enlaconversa.index","action":"App\Http\Controllers\EnLaConversaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"laconversa","name":"laconversa","action":"App\Http\Controllers\EnLaConversaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"notificaciones","name":"notificaciones.index","action":"App\Http\Controllers\NotificacionesController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"notificaciones\/{notificaciones}","name":"notificaciones.update","action":"App\Http\Controllers\NotificacionesController@update"},{"host":null,"methods":["DELETE"],"uri":"notificaciones\/{notificaciones}","name":"notificaciones.destroy","action":"App\Http\Controllers\NotificacionesController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"caracteristicas","name":"caracteristicas.index","action":"App\Http\Controllers\CaracteristicasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"caracteristicas\/{caracteristicas}","name":"caracteristicas.show","action":"App\Http\Controllers\CaracteristicasController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"breadcrumb","name":"breadcrumb","action":"App\Http\Controllers\HomeController@breadcrumb"},{"host":null,"methods":["GET","HEAD"],"uri":"terminos","name":"terminos","action":"App\Http\Controllers\HomeController@terminos"},{"host":null,"methods":["GET","HEAD"],"uri":"privacidad","name":"privacidad","action":"App\Http\Controllers\HomeController@privacidad"},{"host":null,"methods":["GET","HEAD"],"uri":"politicaventas","name":"politicaventas","action":"App\Http\Controllers\HomeController@politicaventas"},{"host":null,"methods":["GET","HEAD"],"uri":"terminos-mentoria","name":"terminos-mentoria","action":"App\Http\Controllers\HomeController@terminosmentoria"},{"host":null,"methods":["GET","HEAD"],"uri":"entidad","name":"entidad.index","action":"App\Http\Controllers\EntidadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/confirmar","name":"step.confirmar","action":"App\Http\Controllers\UsuarioController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/perfil","name":"step.perfil","action":"App\Http\Controllers\UsuarioController@confirmprofile"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/canales","name":"step.canales","action":"App\Http\Controllers\UsuarioController@channelschoice"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/entidad","name":"step.entidad","action":"App\Http\Controllers\UsuarioController@createentity"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/terminos","name":"step.terminos.index","action":"App\Http\Controllers\TerminosController@index"},{"host":null,"methods":["POST"],"uri":"step\/terminos","name":"step.terminos.store","action":"App\Http\Controllers\TerminosController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/politicaventas","name":"step.politicaventas.index","action":"App\Http\Controllers\PoliticaVentasController@index"},{"host":null,"methods":["POST"],"uri":"step\/politicaventas","name":"step.politicaventas.store","action":"App\Http\Controllers\PoliticaVentasController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso","name":"step.compromiso.index","action":"App\Http\Controllers\CartaCompromisoController@index"},{"host":null,"methods":["POST"],"uri":"step\/compromiso","name":"step.compromiso.store","action":"App\Http\Controllers\CartaCompromisoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso\/{compromiso}","name":"step.compromiso.show","action":"App\Http\Controllers\CartaCompromisoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso\/{compromiso}\/edit","name":"step.compromiso.edit","action":"App\Http\Controllers\CartaCompromisoController@edit"},{"host":null,"methods":["GET","HEAD"],"uri":"ayuda","name":"ayuda.index","action":"App\Http\Controllers\AyudaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"{category}\/{slug}","name":"landingpage","action":"App\Http\Controllers\HomeController@landing"},{"host":null,"methods":["GET","HEAD"],"uri":"{slug}","name":"landing","action":"App\Http\Controllers\HomeController@show"},{"host":null,"methods":["POST"],"uri":"api\/login","name":"api.","action":"App\Http\Controllers\Api\Security\AuthController@authenticate"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/convocatoria\/informe\/{informe}","name":"api.convocatoria.informe.show","action":"App\Http\Controllers\Api\Convocatoria\InformeController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/comunidad","name":"api.comunidad.index","action":"App\Http\Controllers\Api\ComunidadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/curso","name":"api.curso.index","action":"App\Http\Controllers\Api\CursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/blog","name":"api.blog.index","action":"App\Http\Controllers\Api\BlogController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/evento","name":"api.evento.index","action":"App\Http\Controllers\Api\EventoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/foro","name":"api.foro.index","action":"App\Http\Controllers\Api\ForoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/foro\/{foro}","name":"api.foro.show","action":"App\Http\Controllers\Api\ForoController@show"},{"host":null,"methods":["POST"],"uri":"api\/voto","name":"api.voto.store","action":"App\Http\Controllers\Api\Voto\VotoController@store"},{"host":null,"methods":["POST"],"uri":"api\/user","name":"api.user.store","action":"App\Http\Controllers\Api\User\UserController@store"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // Route.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // Route.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // Route.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // Route.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // Route.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // Route.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.Route = laroute;
    }

}).call(this);


// parametrization file
// --------------------

(function () {

    var _tp = (function () {
        return {
            getState: {
                'progress': 1,
                'review': 2,
                'cancelled': 3,
                'live': 4,
                'correction': 5,
                'confirm': 6,
                'confirmed': 7,
                'active': 8,
                'inactive': 9,
                'feedback': 10,
                'complete': 11,
                'qualified': 12,
                'removed': 13,
                'pending': 14,
                'evaluated': 15,
                'closed': 16,
                'rejected': 25,
                'returned': 26,
                'finalized': 29,
                'to_finalize': 30,
                'review_deliverables': 32,
                'rejection_of_deliverables': 33
            },

            getModule: function (module) {
                var moduleTypes = {
                    'forum': 1,
                    'wall': 2,
                    'header': 3,
                    'banner': 4,
                    'sitemap': 7,
                    'projects': 9,
                    'calendar': 13,
                    'blog': 14,
                    'mentoring': 20,
                    'surveys': 21,
                    'users': 22,
                    'teams': 23,
                    'learn': 24,
                    'marketplace': 25,
                    'calls': 26,
                    'discussion': 27,
                    'register': 29,
                    'comment': 31,
                    'agreements': 52,
                    'phases': 53
                };

                return moduleTypes[module];
            },

            getResource: function (resource) {
                var resourceType = {
                    'foro.gestion': 1,
                    'foro.comentario': 2,
                    'muro.gestion': 3,
                    'muro.comentario': 4,
                    'mentoria.gestion': 6,
                    'mentoria.comentario': 5,
                    'proyectos.gestion': 7,
                    'proyectos.comentario': 8,
                    'blog.gestion': 9,
                    'blog.comentario': 10,
                    'discusion.gestion': 11,
                    'discusion.comentario': 12,
                    'producto.gestion': 13,
                    'convocatoria.gestion': 14,
                    'eventos.gestion': 15,
                    'aprende.gestion': 16
                };

                return resourceType[resource];
            },

            typeEvent: {
                'mentoring': 1,
                'call': 2,
                'meeting': 3,
                'conference': 4,
                'diplomat': 5,
                'festival': 6,
                'forum': 7,
                'networking': 8,
                'seminary': 9,
                'workshop': 10,
                'symposium': 11,
                'webinar': 12,
                'program': 13
            },

             getClassTypeEvent: {
                'user': 1,
                'platform': 2
            },

            thumbs: {
                'avatar': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-user-image.svg';
                },
                'global': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-image.svg';
                },
                'creditCards': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/general/aprende-payment-cards.png';
                },
                'cvv': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/general/aprende-payment-card-2.png';
                },
                'preloadEntry': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/wall-post-basic-content-loader.svg';
                },
                'preloadItem': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/wall-general-content-loader.svg';
                }
            },

            product: {
                'class' : {
                    'product': 1,
                    'reward': 2
                }
            },

            getClassEntrepreneurship: {
                'idea': 1,
                'entrepreneurship': 2,
                'group': 3,
                'company': 4,
                'grouptwo': 5
            },

            getTypeAttached: {
                'pdf': 1,
                'youtube': 2,
                'flash': 3,
                'vimeo': 4,
                'html': 5,
                'imagen': 6,
                'gallery': 7,
                'link':8,
                'survey':9
            },

            getIconTypeAttachment: {
                1: 'mdi mdi-file',
                2: 'mdi mdi-play-circle-outline',
                3:'mdi mdi mdi-flash',
                4: 'mdi mdi-play-circle-outline',
                5: 'mdi mdi-language-html5',
                6:'mdi mdi-file-image',
                7:'mdi mdi-file-image',
                8: 'mdi mdi-link-variant',
                9: 'mdi mdi-format-list-checks'
            },

            docAttached: {
                'image': 5,
                'curriculum': 10
            },

            typePart: {
                'seller': 1,
                'purchaser': 2
            },

            typeUser: {
                'person': 1,
                'entity': 2
            },

            typeProgram: {
                'internal': 1,
                'external': 2
            },

            getRole: {
				'admin': 2,
                'mentor': 7,
                'seller': 14
            },

            orientationProgram: {
                'entity': 1,
                'user': 2
            },

            getOrientationSpace: {
                'user': 1,
                'project': 2
            },

            inDocs: [
                'pdf',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'ppt',
                'pptx'
            ],

            inVideos: [
                'swf',
                'flash',
                'youtube',
                'vimeo',
                'html',
                'mp4',
                'webm',
                'ogg',
                '3gp',
                'flv'
            ],

            typeQuestionSurvey: {
                'open': 1,
                'single': 2,
                'multiple': 3,
                'upload': 4,
                'matriz': 5
            },

            classQuestionSurvey: {
                'visible': 1,
                'hidden': 2
            },

            typeQuestionField: {
                'singleText': 1,
                'longText': 2,
                'number_format': 3,
                'full_year': 4,
                'cities': 5,
                'pass_confirm': 6,
                'agree_terms': 7,
                'email': 8,
                'url': 9,
                'url_simple': 10,
                'image': 11,
                'image_multiple': 12,
                'attachment': 13,
                'date': 14,
                'select': 15,
                'ciiu': 16,
                'education_level': 17,
                'economic_sector': 18,
                'currency': 19,
                'single_check': 20,
                'multiple_check': 21,
                'phone': 22,
                'percentage': 23,
                'integer': 24,
                'identification': 25,
                'before_date': 26,
                'negative_currency': 27
            },

            getInstitution: {
                'terpel': 37,
                'ecopetrol': 53,
                'innpulsa':51,
                'dinamiza':69,
                'cenisoft': 46
            },

            typeNotify: {
                'general': 1,
                'friendship': 2,
                'like': 3,
                'favorite': 4,
                'discussion': 5
            },

            getTypePayment: {
                'accord' : 1,
                'voucher': 2
            },

            currencyMasks : {
                'cop': 'currency-mask-cop',
                'usd': 'currency-mask-usd'
            },

            ncurrencyMasks : {
                'cop': 'ncurrency-mask-cop',
                'usd': 'ncurrency-mask-usd'
            },

            typeItemMentoring: {
                'mentor': 1,
                'entrepreneurship': 2
            },

            typeItemEvaluation: {
                'select': 1,
                'boolean': 2,
                'stars': 3
            },

            typePrivacy: {
                'private': 1,
                'public': 2
            },

            classProduct: {
                'product': 1,
                'reward': 2,
                'service': 3
            },

            modalityProduct: {
                'virtual': 1,
                'blended': 2,
                'presential': 3
            },

            levelEducation: {
                'other': 7,
                'baccalaureate': 8
            },

            messages: {
                typeError: '{file} tiene una extensión inválida. Extensiones válidas {extensions}.',
                sizeError: "{file} es demasiado grande, el tamaño máximo de archivo es {sizeLimit}.",
                minSizeError: "{file} es demasiado pequeño, el tamaño mínimo de archivo es {minSizeLimit}.",
                emptyError: "{file} está vacío, por favor seleccione los archivos nuevamente sin él.",
                noFilesError: "No hay archivos para cargar",
                tooManyItemsError: "Demasiados artículos ({netItems}) sería cargado. Límite de artículo es {itemLimit}.",
                maxHeightImageError: 'La imagen es muy alta.',
                maxWidthImageError: "La imagen es muy amplia.",
                minHeightImageError: "La imagen no es lo suficientemente alta",
                minWidthImageError: "La imagen no es lo suficientemente amplia",
                retryFailTooManyItems: "Error de reintentos - ha alcanzado el límite de su archivo.",
                onLeave: "Los archivos se cargan, si se va ahora, la carga se cancelará.",
                unsupportedBrowserIos8Safari: "Error irrecuperable: este navegador no permite la carga de archivos de ningún tipo debido a errores graves en iOS8 Safari. Utilice iOS8 Chrome hasta que Apple resuelva estos problemas."
            },

            text: {
                fileInputTitle: 'Carga un archivo',
                failUpload: 'La carga falló',
                paused: 'Pausado',
                waitingForResponse: 'Procesando...'
            },

            getTypeID: {
                'cc': 1,
                'ce': 2,
                'nit': 3,
                'ti': 4,
                'p': 5,
                'rc': 6,
                'nui': 7
            },

            getTypeSpecialty: {
                'other': 16
            },

            getTypePromo: {
                promotion: 1,
                advertisement: 2
            },

            confirmMessage: "Estás seguro de que quieres eliminar {filename}?"
        };

    }).call(this);


    /**
    * Expose the class either via AMD, CommonJS or the global object
    */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return _tp;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = exports.default = _tp;
    }
    else {
        window._tp = _tp;
    }

}).call(this);

/**
 * Utilities for seg component
 *
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery', window, window.document], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        if(global) {
            exports.default = factory(require('jquery'), global, global.document);
            module.exports = exports['default'];
        }else {
            exports.default = factory(window.jQuery || require('jquery'), window, window.document);
            module.exports = exports['default'];
        }

    } else {
        // Browser globals
        window.Misc = factory(window.jQuery, window, window.document);
    }
}(function( $, window, document, undefined ){

    var Misc = {
        /**
         *  Serialize form into json format
         *
         *  @param { string } name class or id of the html element to embed the loader
         *  @return { object } form into json
         *
         */
        formToJson: function( selector ) {

            var o = {}, a = [];

            a = $(selector).serializeArray();

            $.each( a, function() {
                if ( o[ this.name ] !== undefined ) {
                    if ( ! o[this.name].push ) {
                        o[ this.name ] = [ o[ this.name ] ];
                    }

                    o[ this.name ].push( this.value || '' );

                } else {
                    o[ this.name ] = this.value || '';
                }
            });

            return o;
        }

        /**
         * Helps in the process of making a ajax requests
         *
         * @param { object } Options for configuring the ajax request
         * @param { object } data object to be sent
         */
        , ajaxHandler: function( options, data ) {

             var result
             ,   defaults = {
                     type: 'post'
                 ,   url: 'index.php'
                 ,   data: data
                 ,   async: false
                 ,   success: function( data ) {
                             result = data;
                     }

                 ,   error: function ( XMLHttpRequest, textStatus, errorThrown ) {
                             console.log( "error :" + XMLHttpRequest.responseText );
                     }
                 }

             // Merge defaults and options
             options = $.extend( {}, defaults, options );

             // Do the ajax request
             $.ajax( options );

             // Return the response object
             return result;

        }

        /**
        * Given an array of required fields, this function
        * checks whether the second argument have them
        */
        , validateEmptyFields: function( required, objectData, errors ) {

            $.each( required, function( key, value ) {

                if ( objectData[ value ] == null || objectData[ value ] == "" ) {

                    errors.push( value );

                }

            });

            return errors;

        }

        /**
        * Given an array of required fields, this function
        * checks whether the second argument have them
        */
        , validateEmptyObjectAttrs: function( _object, errors ) {

            $.each( _object, function( key, value ) {

                if ( value == null || value == "" ) {

                    errors.push( key );

                }

            });

            return errors;

        }

        /**
        *
        * Validate only numbers
        * @param { string } the string to validate
        *
        */
        , justNumbers: function( value ){

            var pattern = /^\d+$/
            ,   exp = new RegExp( pattern );


            if( typeof value == 'undefined' )
                return false;


            return exp.test( value );

        }

        /**
        *
        * Validate only letters
        * @param { string } the string to validate
        *
        */
        , justLetters: function( value ){

            var pattern = /^[ñA-Za-z _]*[ñA-Za-z][ñA-Za-z _]*$/
            ,   exp = new RegExp( pattern );


            if( typeof value == 'undefined' )
                return false;


            return exp.test( value );

        }

        /**
        * Converts latin string to anglo
        *
        * @param { string } the string to be sanitized
        * @param { bool } numbers are allowed or not
        * @param { bool } special characters are allowed or not
        * @param { bool } blank spaces are allowed or not
        * @param { string } blank spaces are allowed or not
        * @param { string } blank spaces are replaced to
        * @return { string } the string sanitized
        *
        */
        , latinToAnglo: function( value, allowNumbers, allowSpecial, allowSpaces, replace ){

            if( typeof replace == 'undefined' || replace == null )
                replace = '';

            value = value.replace(/[ÀÁÂÃÄÅ]/,"A");
            value = value.replace(/[àáâãäå]/,"a");
            value = value.replace(/[ÈÉÊË]/,"E");
            value = value.replace(/[èéêë]/,"e");
            value = value.replace(/[íìîï]/,"i");
            value = value.replace(/[ÍÌÎÏ]/,"I");
            value = value.replace(/[óòôö]/,"o");
            value = value.replace(/[ÒÓÔÖ]/,"O");
            value = value.replace(/[úùûü]/,"u");
            value = value.replace(/[ÚÙÛÜ]/,"U");
            value = value.replace(/[çÇ]/,"c");
            value = value.replace(/[ñ]/,"n");
            value = value.replace(/[Ñ]/,"N");

            if( ! allowNumbers )
                value = value.replace(/[1234567890]/g, '');

            if( ! allowSpecial )
                value = value.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '' );

            if( ! allowSpaces )
                value = value.replace( /[  ]/g, replace);

            return value;
        }

        /**
        * Check whether an string is a correct email
        * @param { str } String to test
        * @return { bool }
        */
        , isEmail: function( string ) {

            var emailExpression = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            return emailExpression.test( string );
        }

        /**
        * Sets a countdown
        *
        * @param { object } arguments to set: count, limit, selector, callback
        * @return { function } the callback passed, return otherwise
        *
        */
        , setCountdown: function( args ){

            var counter=setInterval( reverse, 1000); //1000 will  run it every 1 second

            function reverse(){

                args.count = args.count - 1;

                if ( args.count <= args.limit    ) {

                    clearInterval( counter);

                    if ( args.callback !== null ) {

                        args.callback.call();
                    }

                    return;
                }

                $( args.selector ).text( args.count );
            }
        }

        /**
        * Sets a countdown a display the text in a HTML Object, triggers a function callback when reaches the limit
        *
        * @param { object } args with data {

                    duration: ( int ) duration in milliseconds
                ,   interval: ( int ) interval of the count down in milliseconds
                ,   limit: ( int ) limit until callback executes
                ,   selector: ( string ) jQuery selector string
                ,   callback: ( function ) function callback
            }
        *
        * @return { function } Callback function
        *
        */
        , humanCountDown: function( args ){

            var counter = setInterval( humanReverse, 1000)
            ,   _this = this;

            function humanReverse(){

                args.duration = args.duration - args.interval;

                var mom = moment( args.duration ).format( 'mm:ss' );

                if ( args.duration < args.limit ) {

                    clearInterval( counter);

                    if ( args.callback !== null ) {

                        args.callback.call();
                    }

                    return;
                }

                $( args.selector ).text( mom );
            }

        }

        , showNotification: function( type, message, time ){

            var div = $( '<div>' ),
                span = $( '<span>' ),
                elmIcon = $( '<i>' );

            span.html( message );

            div.addClass('global-notification');
            div.addClass( type ); //error, success, warning, info
            div.css('display', 'none');
            div.append(elmIcon);
            div.append(span);

            $( 'body' ).append( div );
            $( '.global-notification' ).fadeIn();

            // $( '.global-notification' ).removeClass( 'error, success, warning, info' );
            // $( '.global-notification' ).addClass( type );
            // $( '.global-notification' ).text( message );
            // $( '.global-notification' ).fadeIn();

            this.closeOnClickOut( div[0], true );

            if( time != 0 ){
                setTimeout( function(){
                        $( '.global-notification' ).fadeOut( 'normal', function(){ $(this).remove(); } );
                    }, time);
                return;
            }
        }

        /**
        * validates if object is empty
        *
        */
        , isEmptyObject: function( obj ){

            // Speed up calls to hasOwnProperty
            var hasOwnProperty = Object.prototype.hasOwnProperty;

            // null and undefined are "empty"
            if (obj == null) return true;

            // Assume if it has a length property with a non-zero value
            // that that property is correct.
            if (obj.length && obj.length > 0)    return false;
            if (obj.length === 0)  return true;

            // Otherwise, does it have any properties of its own?
            // Note that this doesn't handle
            // toString and toValue enumeration bugs in IE < 9
            for (var key in obj) {
                if (hasOwnProperty.call(obj, key)) return false;
            }

            return true;
        }

        /**
        * Hides an element when it is clicked outiside
        * @param { string } string for the jQuery selector like: ".my-class"
        * @return { null }
        */
        , closeOnClickOut: function( selector, remove, callback ) {

            if ( typeof remove == 'undefined' );
                    remove = false;

            $( document ).mouseup( function( e ) {

                if ( ! $( selector ).is( ":visible" ) ) {
                    return;
                }

                if ( $( selector ).has( e.target ).length === 0 ) {

                    if( remove ){
                        $( selector ).fadeOut('normal', function() {
                            $( this ).remove();
                        });
                    }else{
                        $( selector ).fadeOut();
                    }
                    if ( callback != null ) {
                        callback.call();
                    }
                }
            });

        }

        /**
        * Sets dots in numbers
        *
        * @param { numeric } the number to be changed
        * @return { string } the number with dots
        *
        */
        , numberDots: function( num ){

            var number = new String( num );

            var result = '';

            while( number.length > 3 ){

             result = '.' + number.substr(number.length - 3) + result;

             number = number.substring(0, number.length - 3);

            }

            result = number + result;

            return result;

        }

        /**
        * Clear all window intervals started previously
        *
        */
        , clearAllIntervals: function(){

            var interval_id = window.setInterval("", 9999);
            // Get a reference to the last interval +1
            for (var i = 1; i < interval_id; i++)
                window.clearInterval( i );
        }

        /**
        * Show modal window and render a template, runs a callback function too
        *
        * @param { object } configuration object {

              @param { string } modal header title
            , @param { string } html content
            , @param { numeric } width
            , @param { numeric } height
            , @param { function } a callback function to be called after show
        }
        *
        */
        , showModalWindow: function( config ){
            // console.log( config );

            if( !({}).toString.call(config).slice(8,-1) === 'Object' )
                return;

            var modalHtml = '<div class="modal-over-screen"></div><div class="box-modal-single">';
            modalHtml += '<a href="../images" class="close-modal-button"></a>';
            if( typeof config.title != undefined){
                modalHtml += '<h4 class="title-modal-single">'+ config.title +'</h4>';
            }
            modalHtml += '<div class="content-modal-single">'+ config.content +'</div>';
            modalHtml += '</div>';

            $( 'body ').append( modalHtml );

            //estilos a la ventana modal
            $( '.box-modal-pqr' ).css({
                'display': 'none',
                'position': 'fixed',
                'z-index': '99999',
                'left': '50%',
                'top': '50%',
                'width': config.width - 28,
                'height': config.height - 28,
                'margin-left': '-' + (config.width / 2) + 'px',
                'margin-top': '-'+ ( config.height / 2) + 'px'
            });

            //estilos a la pantalla negra de fondo
            $( '.modal-over-screen' ).css( {
                    'display': 'none',
                    'position': 'fixed',
                    'top': '0',
                    'left':'0',
                    'width': '100%',
                    'height': '100%',
                    'z-index': '9999',
                    'background-color': 'rgba(0, 0, 0, 0.5)',
                    'color': '#FFF'
                } );

            //estilos a el contenido que se le pasa
            $( '.content-modal-pqr' ).css({
                    'width': '100%',
                    'height': '100%'
            });

            $( '.titulo-modal-pqr' ).css({
                    'text-align': 'left',
                    'margin': '0px',
                    'padding': '0px',
                    'font-family': 'Open Sans',
                    'font-style': 'italic',
                    'font-weight': 'bold',
                    'font-size': '16px',
                    'color': '#E02229'
            });

            $( '.modal-over-screen' ).fadeIn();
            $( '.box-modal-pqr' ).fadeIn();

            this.closeModalWindow();

            // runs a callback after show
            if( typeof callback != 'undefined' ){
                callback.call();
            }
        }

        /**
        * Close modal window
        *
        */
        , closeModalWindow: function(){

            var callback_remove = function(){ $(this).remove(); }

            $( document ).ready( function(){

                $( 'body' ).delegate( '.close-modal-button', 'click', function( e ){

                    e.preventDefault();

                    $( '.content-modal-pqr' ).html( '' );
                    $( '.modal-over-screen' ).fadeOut( 'normal' , callback_remove);
                    $( '.box-modal-pqr' ).fadeOut( 'normal' , callback_remove);

                });

                $( 'body' ).delegate( '.modal-over-screen', 'click', function(e){

                    $( '.content-modal-pqr' ).html( '' );
                    $( '.modal-over-screen' ).fadeOut( 'normal' , callback_remove);
                    $( '.box-modal-pqr' ).fadeOut( 'normal' , callback_remove);
                });
            });


            // Esc key press
            $( document ).keyup( function( e ){

                var keyCode = e.which || e.keyCode;

                if( keyCode == 27 ){
                    $( '.content-modal-pqr' ).html( '' );
                    $( '.modal-over-screen' ).fadeOut( 'normal' , callback_remove );
                    $( '.box-modal-pqr' ).fadeOut( 'normal' , callback_remove);
                }
            });
        }

        /**
        * Close modal window
        *
        */
        , _closeModalWindow: function(){
            $( '.box-modal-pqr .body' ).html( '' );
            $( '.modal-over-screen' ).fadeOut();
            $( '.box-modal-pqr' ).fadeOut();
        }

        /**
        *
        *
        */
        , htmlEntities: function( str ) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        /**
        * Parse a json string to JS format
        *
        */
        , jsonToObject: function( text ){

            text = text.replace(/'/g, '"');

            var object = JSON.parse( text, function (key, value) {
                    var type;
                if (value && typeof value === 'object') {
                    type = value.type;
                    if (typeof type === 'string' && typeof window[type] === 'function') {
                        return new (window[type])(value);
                    }
                }
                return value;
            });

            return object;
        }

        /**
        * Gets any elements from array in random and withot repeat
        *
        * @param { array } array of elements
        * @param { numeric } number of items to be get
        *
        *
        */
        , randomFrom: function ( array, n ) {
            var at = 0;
            var tmp, current, top = array.length;

            if(top) while(--top && at++ < n) {
                current = Math.floor(Math.random() * (top - 1));
                tmp = array[current];
                array[current] = array[top];
                array[top] = tmp;
            }

            return array.slice(-n);
        }

        /**
        * Customize some functions from Date
        *
        */
        , customizeDate: function(){

            Date.prototype.getHoursTwoDigits = function(){
                var retval = this.getHours();
                if (retval < 10){
                    return ("0" + retval.toString());
                }else {
                    return retval.toString();
                }
            }

            Date.prototype.getMinutesTwoDigits = function(){
                var retval = this.getMinutes();
                if (retval < 10){
                    return ("0" + retval.toString());
                }else {
                    return retval.toString();
                }
            }
        }

        /**
        * Redirect to an specific url or refresh the page
        * @param { string } the url to be redirect to
        *
        */
        , redirect: function( url ){
            if( url != undefined && url != '' && this.isUrl(url) ){
                window.location = url;
            }else{
                window.location.reload();
            }
        }

        /**
        * random array
        *
        * @param { Array } the number to be changed
        * @return { Array } the number with dots
        *
        */
        , shuffle: function(array){
            var j, temp;
            for(var i = array.length - 1; i > 0; i--){
                j = Math.floor(Math.random() * (i + 1));
                temp = array[i];
                array[i] = array[j];
                array[j] = temp;
            }
            return array;
        }

        /**
        * metodo rtrim como el del lenguaje php
        */
        , rtrim: function( str, filter ){

            if( str === null || str === undefined)
                return str;

            filter || ( filter = '\\s|\\&nbsp;' );

            var pattern = new RegExp('(' + filter + ')*$', 'g');
            return str.toString().replace(pattern, "");
        }

        /**
        * metodo ltrim como el del lenguaje php
        */
        , ltrim: function( str, filter ){

            if( str === null || str === undefined)
                return str;

            filter || ( filter = '\\s|\\&nbsp;' );

            var pattern = new RegExp('^(' + filter + ')*', 'g');
            return str.toString().replace(pattern, "");
        }

        /**
        * metodo trim como el del lenguaje php
        */
        , trim: function( str, filter ){

            filter || ( filter = '\\s|\\&nbsp;' );
            return this.ltrim( this.rtrim(str, filter), filter );
        }

        /**
        * validate the urls
        */
        , isUrl : function( str ){

            // var patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+\.[a-zA-Z]{2,3}(\/([^\n\r\s])*)?(\?([^\n\r\s])*)?/i;
            var patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+(\/(.)*)?(\?(.)*)?/i;

            return patt.test( str );
        }

        /**
         * extrac the urls
         */
        , pullUrl : function( str ){

            var patt = /((http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+\.[a-zA-Z]{2,3}(\/([^\n\r\s])*)?(\?([^\n\r\s])*)?)/gi;

            var _return = patt.exec( str );

            if( ({}).toString.call(_return).slice(8,-1) === 'Array' )
                return _return[0];

            return _return;
        }

        /**
         * wrap url to a link element
         */
        , urlWrapLink : function( str ){

            var patt = /((http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+\.[a-zA-Z]{2,3}(\/([^\n\r\s])*)?(\?([^\n\r\s])*)?)/gi;

            return str.replace( patt, '<a href="$&" target="_blank">$&</a>' );
        }

        /**
         * Sets a loading spinner in a box
         * @param { selector } String|Object Selector jQuery
         * @param { text } String Message of alert
         */
        , setSpinner: function( selector, text ){
            text || (text = '');
            if ( !selector ) return;

            var $spinner = $(selector).find( '.wrapper-spinner' ).length ? $(selector).find( '.wrapper-spinner' ) : $('<div class="wrapper-spinner">');

            $spinner.html('<div class="inner-spinner"><div class="loader">Loading...</div></div>');
            if( text.length ){
                $spinner.find( '> .inner-spinner' ).prepend( '<p>'+ text +'</p>' );
            }

            // attach the spinner to the selector
            $spinner.appendTo( selector );

            $spinner.each(function(index, elm) {

                var $parent = $(elm).parent();
                var parentWidth = $parent.outerWidth(true);
                var parentHeight = $parent.outerHeight(true);

                $(elm).css({
                        'display': 'block',
                        'position': 'absolute',
                        'opacity': '0.9',
                        'top': '0px',
                        'left': '0px',
                        'width': parentWidth,
                        'min-height': '50px',
                        'height': '100%',
                        'z-index': '50'
                    })
                    .find('.inner-spinner')
                        .css({
                            'display': 'block',
                            'position': 'absolute',
                            'top': '50%',
                            'left': '50%'
                            // 'margin-left': function (dim) {
                            //     return '-'+ ( $(this).outerWidth(true) / 2 ) +'px';
                            // },
                            // 'margin-top': function (dim) {
                            //     return '-'+ ( $(this).outerHeight(true) / 2 ) +'px';
                            // }
                        })
                        .end().parent()
                            .css({
                                'position': function (indx, pos) {

                                    var posUp = pos;
                                    if( posUp == 'static' ) posUp = 'relative';
                                    return posUp;
                                },
                                'min-height': function (dim) {
                                    return $(elm).css('min-height');
                                }
                            });
            });
        }

        /**
         * Removes the loading spinner and trigger a callback
         * @param { time } Integer timeout
         * @param { callback } Function
         * @param { wrap } String|Object wrapper jQuery element
         * @return { type } return description
         */
        , removeSpinner: function( options ){

            options || (options = {});

            var defaults = {
                'time': 0,
                'callback': null,
                'wrap': 'body',
                'direct': false
            }, settings = {};

            settings = $.extend({}, defaults, options);

            var selector = (settings.direct && settings.wrap) ? '> .wrapper-spinner' : '.wrapper-spinner',
                $selector = null;

            // Remove spinner of parent element if wrap is passed
            if( $.prototype.isPrototypeOf(settings.wrap) ){
                $selector = settings.wrap.find( selector );

            }else if( settings.wrap ){
                $selector = $( settings.wrap ).find( selector );
            }else{
                $selector = $( selector );
            }

            setTimeout( function(){

                $selector.remove();
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback.call();

            }, settings.time );

            return;
        }

        /**
        * convierte por el momento links de youtube a url embed
        * @param { String } url video
        * @return { String } url video embed
        */
        , convertVideoEmbed: function( urlVideo, type ) {
            urlVideo = this.trim(urlVideo);
            type || (type = 'default');
            var isVideo = false;

            if( !this.isUrl(urlVideo) ){
                return '';
            }

            var patt = null;
            var convertVideo = {
                'youtube' : function(type) {
                    patt = /watch\?v\=/gi;

                    switch( type.toLowerCase() ) {
                        case 'videoid':
                            patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}youtube\.com\/(watch\?v=|v\/|embed\/)/i;
                        break;

                        case 'watch':
                            patt = /(v\/|u\/\w\/|embed\/|\&v=)/gi;
                        break;

                        case 'embed':
                            patt || (patt = patt);
                        break;

                        default: patt = ''; break;
                    }

                    var typeEmbed = {
                        'embed': 'embed/',
                        'swfobject': 'v/',
                        'videoid': '',
                        'default': 'embed/',
                        'watch': 'watch?v='
                    };

                    urlVideo = urlVideo.replace( patt, typeEmbed[type] );
                },
                'youtu.be' : function (type) {
                    patt = /^http[s]?:\/\/youtu\.be\/([\w]+)/gi;

                    switch( type.toLowerCase() ) {
                        case 'videoid':
                            patt = /^(http[s]?:\/\/youtu\.be\/)/gi;
                        break;

                        case 'embed':
                            patt || (patt = patt);
                        break;

                        default: patt = ''; break;
                    }

                    var typeEmbed = {
                        'embed': 'https://www.youtube.com/embed/$1',
                        'swfobject': 'https://www.youtube.com/v/$1',
                        'videoid': '',
                        'default': 'https://www.youtube.com/embed/$1',
                        'watch': 'https://www.youtube.com/watch?v=$1'
                    };

                    urlVideo = urlVideo.replace( patt, typeEmbed[type] );
                },
                'vimeo' : function(type) {},
                'default': function (type) { /*urlVideo = false;*/ }
            };

            $.each(convertVideo, function(index, value) {

                if( urlVideo.search(index) !== -1 ){
                    convertVideo[index](type);
                    isVideo = true;
                }
            });

            if( !isVideo ){
                convertVideo['default'](type);
            }

            return urlVideo;
        }

        /**
        * formatear fecha a lenguaje humano
        * @param { Object | String } date
        * @return { String } date formate
        */
        , formatDateSpanish: function( fecha, mark ){

            // var reg = /^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}:\d{2}$/;
            //  reg.test( fecha );

            if( typeof mark == 'undefined' )
                mark = false;

            var dayNames = [
                "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"
            ],
            monthNames = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ]

            if( ! fecha instanceof Date )
                return false;

            var curr_date = fecha.getDate();
            var curr_month = fecha.getMonth();
            var curr_year = fecha.getFullYear();

            var strReturn = monthNames[ curr_month ]+' '+curr_date+' de '+curr_year;

            if( mark ){

                var date_day = curr_date,
                    date_month = curr_month+1,
                    date_year = curr_year;

                if( date_day.length == 1 )
                    date_day = '0'+date_day;

                if( date_month.length == 1 )
                    date_month = '0'+date_month;

                strReturn = date_year+'-'+date_month+'-'+date_day;
            }

            return strReturn;
        }

        /**
         * Build URI with route and base url
         */
        , urlFull: function ( route ){
            var baseUrl = typeof process !== 'undefined' && process.env.host ?
                        (process.env.NODE_ENV !== 'production' && process.env.BASE_PATHNAME ? process.env.host /*+ process.env.BASE_PATHNAME*/ : process.env.host)
                        : document.url;

            if( !this.isUrl(baseUrl) || this.isUrl(route) ) {
                return route;
            }

            route || (route = '');
            var patt = /^\//;
            patt.test(route) || (route = '/'+route);

            return baseUrl + route;
        }

        /**
         * Show Alert box
         * @param Object options
         */
        , showAlertBox: function ( options ) {

                options || (options = {});

                var defaults = {
                    'text': '',
                    'wrapper': 'body',
                    'type': '',
                    'close': true,
                    'closeTime': 0,
                    'speedOpen': 'slow',
                    'speedClose': 'slow'
                }, settings = {};

                settings = $.extend({}, defaults, options);

                var $alertBox = $( '<div>' ),
                    contentHtml = '<i class="fa icon-alert"></i><span>'+ settings.text +'</span>';

                $alertBox.attr( {'class': 'alert-box-tp', 'tabindex':0, 'data-alert':''} )
                         .css( {'display': 'none'} )
                         .addClass( settings.type );

                if( settings.close ) contentHtml += '<a href="#" class="close">&times;</a>';

                $alertBox.html( contentHtml );

                //comprobar si ya existe la alerta en el elemento wrapper
                if( $( settings.wrapper ).find('> .alert-box-tp').length ){
                    $alertBox = $( settings.wrapper ).find( '> .alert-box-tp' );
                    $alertBox.find( '> span' ).html( settings.text )
                             .end()
                             .addClass( settings.type )
                             .slideDown( settings.speedOpen );
                } else{
                    $( settings.wrapper ).prepend( $alertBox );
                    $alertBox.slideDown( settings.speedOpen );
                }

                if( settings.closeTime > 0 && $.isNumeric(settings.closeTime) ){
                    $alertBox.delay( settings.closeTime ).slideUp( settings.speedClose );
                }

                $alertBox.foundation('alert', 'reflow');
        }

        /**
         * Show notice box
         * @param Object options
         */
        , showNoticeBox: function ( options ) {

                options || (options = {});

                var defaults = {
                    'text': '',
                    'wrapper': 'body',
                    'type': '',
                    'close': true,
                    'closeTime': 0,
                    'speedOpen': 'slow',
                    'speedClose': 'slow'
                }, settings = {};

                settings = $.extend({}, defaults, options);

                var $noticeBox = $( '<div>' ),
                    contentHtml = '<i class="fa icon-alert"></i><span>'+ settings.text +'</span>';

                $noticeBox.attr( {'class': 'notice-box-tp', 'tabindex':0, 'data-alert':''} )
                        .css({ 'display': 'none' })
                        .addClass( settings.type );

                if( settings.close ) contentHtml += '<a href="#" class="close">&times;</a>';

                $noticeBox.html(contentHtml);

                console.log(' -> ', settings.wrapper, $(settings.wrapper).find('.notice-box-tp'));

                //comprobar si ya existe la alerta en el elemento wrapper
                if( $(settings.wrapper).find('.notice-box-tp').length ){
                    $noticeBox = $(settings.wrapper).find('.notice-box-tp');
                    $noticeBox.find( '> span' ).html(settings.text)
                        .end()
                        .addClass(settings.type)
                        .slideDown(settings.speedOpen);
                } else{
                    $(settings.wrapper).prepend($noticeBox);
                    $noticeBox.slideDown(settings.speedOpen);
                }

                if( settings.closeTime > 0 && $.isNumeric(settings.closeTime) ){
                    $noticeBox.delay(settings.closeTime).slideUp(settings.speedClose);
                }

                $noticeBox.foundation('alert', 'reflow');
        }

        /**
        * Anchor with animation
        * @param Object options
        */
        , anchorJumpTo: function ( options ) {

            options || (options = {});

            var defaults = {
                'parentDelegate': 'body',
                'anchorLink': '',
                'duration': 500,
                'easing': 'swing',
                'complete': null,
                'gutter': 0,
                'activation': false
            }, settings = {};

            settings = $.extend({}, defaults, options);
            var $parentDeleg = '';

            if( $.prototype.isPrototypeOf(settings.parentDelegate) ){
                $parentDeleg = settings.parentDelegate;
            }else{
                $parentDeleg = $( settings.parentDelegate );
            }

            $parentDeleg.on('click', settings.anchorLink, function(event) {
                event.preventDefault();
                // event.stopPropagation();
                $target = $( $(this).attr("href") );

                if (navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/)) {
                    window.scrollTo(0, $target.offset().top + settings.gutter) // first value for left offset, second value for top offset
                }else{

                    $("html, body").animate({
                        scrollTop: ( $target.offset().top + settings.gutter ) + "px"
                    }, {
                        duration: settings.duration,
                        easing: settings.easing,
                        complete: settings.complete
                    });
                }

                if( settings.activation ) {
                    $parentDeleg.find(settings.anchorLink).parent().removeClass('active');
                    $(this).parent().addClass('active');
                }
            });
        }

        /**
        * Parse String True or false to Boolean value
        * @param String str
        */
        , strToBool: function (str) {

            return (/^(true|1)$/i).test( str.toString() );
        }

        /**
        * Removes html tags
        * @param str {String}
        * @param tags {String} except tags eg. '<img><a><h1>'
        */
        , stripTags: function (str, tags) {
            tags || (tags = '');

            if( str === null || str === undefined ){
                return str;
            }

            var allowedTags = tags.split(/<([^>]+)\/?>/i).filter(function (val, indx) { return indx % 2 !== 0 }).join('|');
            allowedTags || (allowedTags = '$');

            var pattern = new RegExp('<(?!\\/?('+allowedTags+')\\s*\\/?)[^>]+>', 'gi');

            return str.replace(pattern, '');
        }

        /**
        * Removes html tags
        * @param String str
        */
        , strToNickname: function (str, prefix) {
            prefix || (prefix = '@');

            return prefix + str;
        }

        /**
        * link show more
        * @param Object options
        */
        , showMore: function ( options ) {

            options || (options = {});

            var defaults = {
                'parentDelegate': document,
                'container': '.container-more',
                'maxlen': 150,
                'toggle': false

            }, settings = {};

            settings = $.extend({}, defaults, options);
            var $container = '',
                $parentDeleg = '',
                $wrapperMore = '',
                fullContent = '',
                trunk = '';

            if( $.prototype.isPrototypeOf(settings.container) ){
                $container = settings.container;
            }else{
                $container = $( settings.container );
            }

            if( $container.find( '.wrapper-more' ).length ) return;

            $container.wrapInner('<div class="wrapper-more"></div>');
            $wrapperMore = $container.find( '.wrapper-more' );

            var $moreLink = $('<a href="#" class="link-more">').text('Ver más');
            var $lessLink = $('<a href="#" class="link-less">').text('Ver menos');

            $moreLink.appendTo( $container );
            $lessLink.appendTo( $container );

            fullContent  = $wrapperMore.html();

            if( $wrapperMore.text().length > settings.maxlen ){

                trunk = $wrapperMore.text().slice(0, settings.maxlen) + "...";
                $wrapperMore.text( trunk );
            }

            $moreLink.click(function (event) {
                event.stopPropagation();
                event.preventDefault();
                $wrapperMore.html( fullContent );
                $moreLink.hide();
                $lessLink.show();
            });

            $lessLink.click(function (event) {
                event.stopPropagation();
                event.preventDefault();
                $wrapperMore.text( trunk );
                $moreLink.show();
                $lessLink.hide();
            });

            if ( $wrapperMore.text().length < settings.maxlen ) {

                $moreLink.hide();
                $lessLink.hide();
                return;
            }

            $moreLink.show();
            $lessLink.hide();
        }

        /**
        * link show more
        * @param Object options
        */
        , getCsrf: function () {

            var csrf = {};

            return csrf = {
                getCookie: function (name) {
                    var cookieValue = null;
                    if (document.cookie && document.cookie != '') {
                        var cookies = document.cookie.split(';');
                        for (var i = 0; i < cookies.length; i++) {
                            var cookie = jQuery.trim(cookies[i]);
                            // Does this cookie string begin with the name we want?
                            if (cookie.substring(0, name.length + 1) == (name + '=')) {
                                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                                break;
                            }
                        }
                    }
                    return cookieValue;
                },
                sameOrigin: function (url) {
                    // url could be relative or scheme relative or absolute
                    var host = document.location.host; // host + port
                    var protocol = document.location.protocol;
                    var sr_origin = '//' + host;
                    var origin = protocol + sr_origin;
                    // Allow absolute or scheme relative URLs to same origin
                    return (url == origin || url.slice(0, origin.length + 1) == origin + '/') ||
                        (url == sr_origin || url.slice(0, sr_origin.length + 1) == sr_origin + '/') ||
                        // or any other URL that isn't scheme relative or absolute i.e relative.
                        !(/^(\/\/|http:|https:).*/.test(url));
                },
                safeMethod: function(method) {
                    return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
                }
            };
        }

        /**
        * Check session app
        * @param { redirect } the boolean to action redirect
        */
        , checkSession: function (redirect) {
            redirect = redirect === undefined ? true : redirect;
            var login_tp = $('meta[name="login-tp"]').attr('content');

            if(parseInt(login_tp) === 1){
                return true;
            }

            if(redirect === true){
                this.redirect();
            }
            return false;
        }

        /**
        * get platform stata
        * @param String state
        */
        , getState: function( state ) {

            switch (state) {
                case 'progress': return 1;
                case 'review': return 2;
                case 'cancelled': return 3;
                case 'live': return 4;
                case 'correction': return 5;
                case 'confirm': return 6;
                case 'confirmed': return 7;
                case 'active': return 8;
                case 'inactive': return 9;
                case 'feedback': return 10;
                case 'complete': return 11;
                case 'qualified': return 12;
                case 'removed': return 13;
                case 'pending': return 14;
                case 'evaluated': return 15;
                case 'closed': return 16;
                default: return 'Not state identified';
            }
        }

        /**
        * get platform stata
        * @param String orientation
        */
        , getOrientation: function( orientation ) {

            switch (orientation) {
                case 'internal': return 1;
                case 'external': return 2;
                default: return 'Not orientation identified';
            }
        }

        /**
        * get param (Default values)
        */
        , dv: function(  ) {
            return {
                'avatar': 'http://static.tuproyecto.com/images/svg/no-user-image.svg'
            }
        }

        /**
        * reload social buttons share
        */
        , renderSocialBtns: function () {
            // Render twitter button share
            if( window.twttr && window.twttr.widgets ){
                window.twttr.widgets.load();
            }
            // Render facebook button share
            if( window.FB && window.FB.XFBML ){
                window.FB.XFBML.parse();
            }
            // Render linkedin button share
            if( window.IN && typeof(window.IN.parse) == 'function' ){
                window.IN.parse();
            }
        }

        /**
        * set max length in a string
        * @param String str
        * @param Number maxlength
        * @return String strTrunk
        */
        , maxLen: function (str, maxlength, strCont) {

            if ( ({}).toString.call(str).slice(8,-1) !== 'String' )
                return false

            maxlength || (maxlength = str.length);
            strCont || (strCont = '...');

            var strTrunk = str.slice(0, maxlength);

            if( str.length != strTrunk.length ) {
                strTrunk += '...';
            }

            return strTrunk;
        }

        /**
        * validate type file of attached
        * @param Numeric cod_type_attached
        * @return String inDoc
        */
        , codInDoc: function (cod_type_attached) {

            var inDoc = _.findIndex(window._tp.inDocs, function (value, index, list) {

                var typeFile = _.findKey(window._tp.getTypeAttached, function (v, k, o) {
                    return v == cod_type_attached;
                });

                return typeFile == value;
            });

            return inDoc;
        }

        /**
        * Format time
        * @param Numeric timeInSeconds
        * @return String
        */
        , formatTime: function (timeInSeconds) {

            var sec_numb = parseInt(timeInSeconds);
            var hours = Math.floor(sec_numb / 3600);
            var minutes = Math.floor((sec_numb - (hours * 3600)) / 60) + hours * 60;
            var seconds = sec_numb - (hours * 3600) - (minutes * 60);

            if (seconds < 10) { seconds = "0" + seconds; }
            return minutes + ':' + seconds;
        }

        /**
        * get cookies
        * @param String name
        * @return Mix cookieValue
        */
        , getCookie: function (name) {
            var cookieValue = null;

            if (document.cookie && document.cookie != '') {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = jQuery.trim(cookies[i]);
                    // Does this cookie string begin with the name we want?
                    if (cookie.substring(0, name.length + 1) == (name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }

        /**
        * get cookies as object
        * @param String name
        * @return Object list
        */
        , parseCookies: function (cookies) {
            cookies || (cookies = document && document.cookie);

            var list = {};

            cookies && cookies.split(';').forEach(function( cookie ) {
                var parts = cookie.split('=');
                list[parts.shift().trim()] = decodeURI(parts.join('='));
            });

            return list;
        }

        /**
        * validate math expressions
        * @param String optsFun
        * @return Array matchesFun
        */
        , validateMathExpressions: function (optsFun) {

            var patt = /((p\d+)?[xy]?\d+)|(\s*[\+\-\*\/]\s*)|(\((\(?(p\d+)?[xy]?\d+(\s*[\+\-\*\/]\s*(p\d+)?([xy]?\d+)?)+\)?)+\))/g,
                pattValid = /\(?(\(?(p\d+)?([xy]?\d+)?((\s*[\+\-\*\/]\s*)(p\d+)?([xy]?\d+)?)+\)?)+\)?/g,
                matchesFun = [];

            // If the function expression is valid
            if( pattValid.test(optsFun) ) {

                matchesFun = optsFun.match(patt);

                _.each(matchesFun, function (matchCal, index) {

                    if( /^\(.+\)$/.test(matchCal) ) {
                        matchesFun[index] = this.validateMathExpressions( matchCal.replace(/^\(|\)$/, '') );
                    }

                }.bind(this));
            }

            return matchesFun;
        }

        /**
         * calculate average stars
         * @param average Number|String
         * @return Number 0 - 5
         */
        , inStar: function (average) {
            average = parseFloat(average);

            if( average >= 4.3 && average <= 5 ) return 5;
            if( average >= 3.3 && average <= 4.2 ) return 4;
            if( average >= 2.3 && average <= 3.2 ) return 3;
            if( average >= 1.3 && average <= 2.2 ) return 2;
            if( average >= 0.3 && average <= 1.2 ) return 1;

            return 0;
        }

        /**
         * calculate average stars
         * @param average Number|String
         * @return Number 0 - 5
         */
        , inStarHalf: function (average) {
            average = parseFloat(average);

            if( average >= 4.3 && average < 4.8 ) return 5;
            if( average >= 3.3 && average < 3.8 ) return 4;
            if( average >= 2.3 && average < 2.8 ) return 3;
            if( average >= 1.3 && average < 1.8 ) return 2;
            if( average >= 0.3 && average < 0.8 ) return 1;

            return 0;
        }

        /**
         * set image by default
         * @param imgEl Element
         * @param imgDefault String, image's url
         */
        , imageDefault: function (imgEl, imgDefault) {
            imgDefault || (imgDefault = '');

            if (imgEl.getAttribute('src') != imgDefault) {
                imgEl.setAttribute('src', imgDefault);
            }
        }

        /**
         * return an Error witn a message for function's required arguments
         * @param message String
         * @param type String [string, number]
         * @return Error
         */
        , argIsRequired: function (message, type) {
            message || (message = 'Missing parameter.');

            if(type) message +' Expected'+ type;

            throw new Error(message);
        }
    };

    return Misc;
}));

/**
* Class WysiwygConfig
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

(function ($, window, document, undefined) {

	window.WysiwygConfig = function (setConfig, setElement) {
		// Init Attributes
		this.initialize(setConfig, setElement);
	}

	window.WysiwygConfig.prototype = {

		/**
		* Constructor Method
		* @param String setConfig
		* @param Mixin setElement
		*/
		initialize: function (setConfig, setElement) {
			setConfig || (setConfig = null);
			setElement || (setElement = null);

			var config = {
				'.wysiwyg-postwall': {
					'class': 'wrap-wysiwyg-postwall',
					toolbar: 'bottom',
					configButtons: {
						otroBoton: {
							title: 'Nombrar a alguien',
							image: '\uf007',
							click: function( $button ) {
								alert('Do something');
							},
							showselection: false  // wanted on selection
						},
						insertimage: {
							title: 'Insertar imagen', //Insert image
							image: '\uf03e',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						insertlink: false,
						fontname: false,
						fontsize: false,
						header: false,
						bold: false,
						italic: false,
						underline: false,
						strikethrough: false,
						forecolor: false,
						highlight: false,
						alignleft: false,
						aligncenter: false,
						alignright: false,
						alignjustify: false,
						subscript: false,
						superscript: false,
						indent: false,
						outdent: false,
						orderedList: false,
						unorderedList: false,
						removeformat: false
					}
				},

				'.wysiwyg-single': {
					'class': 'wrap-wysiwyg-single',
					toolbar: 'bottom-selection',
					configButtons: {
						insertimage: false,
						fontname: false,
						fontsize: false,
						header: false,
						forecolor: false,
						highlight: false,
						subscript: false,
						superscript: false,
						strikethrough: false
					}
				},

				'.wysiwyg-single-without-link': {
					'class': 'wrap-wysiwyg-single-without-link',
					toolbar: 'bottom-selection',
					configButtons: {
						insertimage: false,
						insertlink: false,
						fontname: false,
						fontsize: false,
						header: false,
						forecolor: false,
						highlight: false,
						subscript: false,
						superscript: false,
						strikethrough: false
					}
				},

				'.wysiwyg-basic': {
					'class': 'wrap-wysiwyg-basic',
					toolbar: 'bottom-selection',
					configButtons: {
						insertimage: false,
						fontname: false,
						fontsize: false,
						header: false,
						bold: false,
						italic: false,
						underline: false,
						strikethrough: false,
						forecolor: false,
						highlight: false,
						alignleft: false,
						aligncenter: false,
						alignright: false,
						alignjustify: false,
						subscript: false,
						superscript: false,
						indent: false,
						outdent: false
					}
				}
			};

			if( setConfig !== null && setConfig.length && setElement !== null ) {
				this._setWysiwyg(setElement, config[setConfig]);
				return;
			}

			for( var selector in config ){

				var _config = {};
				_config = $.extend({}, _config, config[selector]);

				this._setWysiwyg(selector, _config);
			}
		},

		/**
		* Set wysiwyg
		* @param mixin selector
		* @param Object _config
		*/
		_setWysiwyg: function (selector, _config) {

			if( !selector || !selector.length || !_config || !_.isObject(_config) )
				return false;

			$(selector).each(function(index, element) {
				var setButtons = {
						insertimage: {
							title: 'Insertar imagen', //Insert image
							image: '\uf030',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						insertlink: {
							title: 'Insertar link', //Insert Link
							image: '\uf08e'
						},
						// Fontname plugin
						fontname: {
						    title: 'Fuente', //Font
						    image: '\uf031',
						    popup: function ( $popup, $button ) {

						        var list_fontnames = {
						                // Name : Font
						                'Arial, Helvetica' : 'Arial,Helvetica',
						                'Verdana'          : 'Verdana,Geneva',
						                'Georgia'          : 'Georgia',
						                'Courier New'      : 'Courier New,Courier',
						                'Times New Roman'  : 'Times New Roman,Times'
						            };

						        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
						                               .attr('unselectable','on');

						        $.each( list_fontnames, function( name, font ){
						            var $link = $('<a/>').attr('href','#')
						                                .css( 'font-family', font )
						                                .html( name )
						                                .click(function(event){
						                                    $(element).wysiwyg('shell').fontName(font).closePopup();
						                                    // prevent link-href-#
						                                    event.stopPropagation();
						                                    event.preventDefault();
						                                    return false;
						                                });
						            $list.append( $link );
						        });

						        $popup.append( $list );
						    },
						    //showstatic: true,    // wanted on the toolbar
						    showselection: false // wanted on selection
						},
						// Fontsize plugin
						fontsize: {
						    title: 'Tamaño', //Size
						    image: '\uf034',
						    popup: function( $popup, $button ) {
						        var list_fontsizes = {
						            // Name : Size
						            'Enorme'       : 7, //Huge
						            'Más Grande'   : 6, //Larger
						            'Grande'       : 5, //Large
						            'Normal'       : 4,
						            'Pequeño'      : 3, //Small
						            'Más pequeñas' : 2, //Smaller
						            'Diminuto'     : 1  //Tiny
						        };
						        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
						                               .attr('unselectable','on');
						        $.each( list_fontsizes, function( name, size ){
						            var $link = $('<a/>').attr('href','#')
						                                .css( 'font-size', (8 + (size * 3)) + 'px' )
						                                .html( name )
						                                .click(function(event){
						                                    $(element).wysiwyg('shell').fontSize(size).closePopup();
						                                    // prevent link-href-#
						                                    event.stopPropagation();
						                                    event.preventDefault();
						                                    return false;
						                                });
						            $list.append( $link );
						        });
						        $popup.append( $list );
						   }
						    //showstatic: true,    // wanted on the toolbar
						    //showselection: true    // wanted on selection
						},
						// Header plugin
						header: {
						    title: 'Titular', //Header
						    image: '\uf1dc',
						    popup: function( $popup, $button ) {
						        var list_headers = {
						                // Name : Font
						                'Titular 1'    : '<h1>', //Header
						                'Titular 1'    : '<h2>',
						                'Titular 3'    : '<h3>',
						                'Titular 4'    : '<h4>',
						                'Titular 5'    : '<h5>',
						                'Titular 6'    : '<h6>',
						                'Preformateada' : '<pre>' //Preformatted
						            };
						        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
						                               .attr('unselectable','on');
						        $.each( list_headers, function( name, format ){
						            var $link = $('<a/>').attr('href','#')
						                                 .css( 'font-family', format )
						                                 .html( name )
						                                 .click(function(event){
						                                    $(element).css({'color': '#000'})
						                                            .wysiwyg('shell').format(format).closePopup();
						                                    // prevent link-href-#
						                                    event.stopPropagation();
						                                    event.preventDefault();
						                                    return false;
						                                });
						            $list.append( $link );
						        });
						        $popup.append( $list );
						   }
						    //showstatic: true,    // wanted on the toolbar
						    //showselection: false    // wanted on selection
						},
						bold: {
							title: 'Negrita (Ctrl+B)', //Bold
							image: '\uf032',
							hotkey: 'b'
						},
						italic: {
							title: 'Italica (Ctrl+I)', //Italic
							image: '\uf033',
							hotkey: 'i'
						},
						underline: {
							title: 'Subrayar (Ctrl+U)', //Underline
							image: '\uf0cd',
							hotkey: 'u'
						},
						strikethrough: {
							title: 'Tachado (Ctrl+S)', //Strikethrough
							image: '\uf0cc',
							hotkey: 's'
						},
						forecolor: {
							title: 'Color de texto', //Text color
							image: '\uf1fc'
						},
						highlight: {
							title: 'Color de fondo', //Background color
							image: '\uf043'
						},
						alignleft: {
							title: 'Alinear a la izquierda', //Left
							image: '\uf036',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						aligncenter: {
							title: 'Alinear al centro', //Center
							image: '\uf037',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						alignright: {
							title: 'Alinear a la derecha', //Right
							image: '\uf038',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						alignjustify: {
							title: 'Justificar', //Justify
							image: '\uf039',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						subscript: {
							title: 'Subíndice', //Subscript
							image: '\uf12c',
							//showstatic: true,    // wanted on the toolbar
							showselection: true    // wanted on selection
						},
						superscript: {
							title: 'Superíndice', //Superscript
							image: '\uf12b',
							//showstatic: true,    // wanted on the toolbar
							showselection: true    // wanted on selection
						},
						indent: {
							title: 'Indentar', // Indent
							image: '\uf03c',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						outdent: {
							title: 'Sin Indentar', //Outdent
							image: '\uf03b',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						orderedList: {
							title: 'Lista Ordenada', //Ordered list
							image: '\uf0cb',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						unorderedList: {
							title: 'Lista Desordenada', //Unordered list
							image: '\uf0ca',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						removeformat: {
							title: 'Retirar Formato', //Remove format
							image: '\uf12d'
						}
					},
					buttonsExtend = $.extend({}, setButtons, _config.configButtons ),
					defaults = {
						'class': 'some-more-classes',
						toolbar: 'top-selection',
						dropfileclick: 'Drop image or click',
						placeholderUrl: 'www.example.com',
						maxImageSize: [600,200],
						 // Submit-Button
						submit: {
							title: 'Submit',
							image: '\uf00c' // <img src="path/to/image.png" width="16" height="16" alt="" />
						},
						buttons: buttonsExtend
						// onImageUpload: this.onImageUpload,
						// onKeyEnter: function (argument) {
						//     console.log('llega', argument);
						// }
					};

				// extend defautl settings with the config defined
				var settings = $.extend({}, defaults, _.omit(_config, 'configButtons') );

				if( $(element).data('wysiwygjs') == undefined ) {

					$(element).wysiwyg(settings).change(function(e) {
						// console.log(e.target);

						var wysiwygeditor = $(e.target).data('wysiwygjs').wysiwygeditor;
						var currentEditor = wysiwygeditor.getElement();
						var linksEditor = $( currentEditor ).find('a');

						// set font size
						// wysiwygeditor.fontSize('15px');

						// define external link
						linksEditor.each(function(indx, el) {
						    var hrefLink = $(el).attr('href');

						    if( ! /^http(s)?/.test(hrefLink) )
						        hrefLink = 'http://'+ hrefLink;

						    $(el).attr({
						        'href': hrefLink,
						        'target': '_blank'
						    });
						});
					});
				}
			});
		}
	}

})(jQuery, this, this.document);

/**
* @author TuProyecto | Desarrollador: @dropecamargo
* Events mediaElementPlayer woopra analytics
*/
(function($, window, document, undefined) {

	$.extend(MediaElementPlayer.prototype, {
		buildwoopraanalytics: function(player, controls, layers, media) {
			var timeInterval = 30,
				counter, time, currentInterval, lastInterval = 0;

            _.extend(media, Backbone.Events);

			media.addEventListener('timeupdate', function(e) {
				if (typeof woopra != 'undefined') {
					time = parseInt(player.getCurrentTime());
					counter = Math.ceil(time / timeInterval);
	                currentInterval = timeInterval * counter;

	                if ( (time === currentInterval) && (lastInterval != currentInterval) ) {
						lastInterval = time;
						// Call trigger trackViewed
                        media.trigger('trackViewed', timeInterval,
                        	window.Misc.formatTime(currentInterval - timeInterval) + " - " + window.Misc.formatTime(currentInterval)
                       	);
	                }
	           	}
			}, false);
		}
	});

})(jQuery, this, this.document);

// image-uploader-crop v1.0 for jQuery, fine-uploader, jcrop
// ==========================================
// Dependencies: jQuery, fine-uploader, jcrop
// Author: TuProyecto.co
// Developer: @krobing
// Created: 04/03/2016
// Website: tuproyecto.co
// Description: cropper and uploader of images that uses another libraries

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {
	var slice = Array.prototype.slice; // save ref to original slice()
	var splice = Array.prototype.splice; // save ref to original slice()

	// default options
	var defaults = {
		formCrop: null,
        btnToCrop: null,
		imgCrop: null,
		previewImg: null,
		uploaderImg: null,
		templateImgUploader: '',
		configImg: {
			maxWidthImg : 0, // 646 * 2
			maxHeightImg : 0, // 374 * 2
			minWidthImg : 0,
			minHeightImg : 0,
			allowedExtensions: ['jpeg', 'jpg', 'png'],
			sizeLimit: 0, // 50 kB = 50 * 1024 bytes,
			sendOriginal: true, // send images original in true
			defaultQuality: 100 // quality of the image, range( 1 - 100 )
		},
		uploadding: {
			inputName: 'file',
			endpoint: '',
			params: {}
		},
		cropping: {
			endpoint: '',
			params: {}
		},
		extraDropzones: [$('#wrapper-image-crop')],
		// Events handlers
		callbacks: {
			onCropping: function (jcrop_img) {},
			onCropComplete: function (jcrop_img, resp, jqXHR) {},
			onCropError: function (jcrop_img, jqXHR, error) {},
			onLoadImg: function ($uploaderImg, id, name) {},
			onCompleteLoad: function ($uploaderImg, id, name, res) {}
		},
        messages: {},
		showMessage: function (message) {
			return alertify.alert(message);
		},
		showConfirm: function (message) {
			var promise = new qq.Promise();
			alertify.confirm(message, function(result) {
				if (result) {
					return promise.success(result);
				} else {
					return promise.failure();
				}
			});
			return promise;
		},
		showPrompt: function (message, defaultValue) {
			var promise = new qq.Promise();

			alertify.prompt(message, function(result, inStr) {
				if (result) {
					return promise.success(inStr);
				} else {
					return promise.failure(inStr);
				}
			}, defaultValue);
			return promise;
		}
	};

	// ==============
	// helpers method
	// ==============
	/**
	*  Serialize form into json format
	*  @param { string } name class or id of the html element to embed the loader
	*  @return { object } form into json
	*/
	function formToJson ( selector ){

		var o = {}, a = [];
		if( $.prototype.isPrototypeOf(selector) ){
			a = selector.serializeArray();
		}
		else{
			a = $(selector).serializeArray();
		}

		$.each( a, function() {
			if ( o[ this.name ] !== undefined ) {
				if ( ! o[this.name].push ) {
					o[ this.name ] = [ o[ this.name ] ];
				}

				o[ this.name ].push( this.value || '' );

			} else {
				o[ this.name ] = this.value || '';
			}
		});

		return o;
	}

	/**
	* Set select on image crop
	* @param Number imgWidth
	* @param Number imgHeight
	*/
	function setSquare (imgWidth, imgHeight) {
		var minDim = Math.min(imgWidth, imgHeight);

		if( imgWidth == imgHeight ){
			return [imgWidth, imgHeight];
		}

		return [minDim, minDim];
	}

	// check out if exits jQuery plugin fineuploader
	function existUploaderPlugin () {

		if( ({}).hasOwnProperty.call($.fn, 'fineUploader') ){
			return true;
		}else {
			return false;
		}
	}

	// check out if exits jQuery plugin jcrop
	function existCropPlugin () {

		if( ({}).hasOwnProperty.call($.fn, 'Jcrop') ){
			return true;
		}else {
			return false;
		}
	}

	/**
	* privates methods
	*/
	var methods = {
		/**
		* reassign events and another things
		*/
		reassignActions: function() {
            this.settings.uploaderImg.off('complete');
			this.settings.uploaderImg.on('complete', methods.onCompleteLoadImg.bind(this));

            // if was defined a button to execute action to crop
            if(this.settings.btnToCrop) {
                this.settings.btnToCrop.off('click', methods.submitCropImage.bind(this));
                this.settings.btnToCrop.on('click', methods.submitCropImage.bind(this));
            } else {
                this.settings.formCrop.off('submit');
                this.settings.formCrop.on('submit', methods.submitCropImage.bind(this));
            }
		},

		/**
		* destroy plugin
		*/
		destroy: function () {
			// destroy jcrop
			if( this.settings.imgCrop.data('Jcrop') !== undefined ){
				this.jcrop_img.destroy();
			}

			// undelegate events
			// this.settings.uploaderImg.off('upload');
			this.settings.uploaderImg.off('complete');
			this.settings.formCrop.off('submit');

			// remove object plugin in data
			this.$element.removeData('imageUploaderCrop');
		},

		/**
		* set image
		* @param urlImage
		*/
		setImage: function (urlImage, callback) {
			urlImage || (urlImage = this.settings.imgCrop.attr('src')) || (urlImage = '');

			var _this = this;

			// validates if already or not was created the crop image
			if( this.settings.imgCrop.data('Jcrop') !== undefined ){
				this.jcrop_img = this.settings.imgCrop.data('Jcrop');

				// settings image crop
				this.jcrop_img.setImage(urlImage, function () {

					var dimImg = [];
					// settings image crop
					if( this.settings.configImg.minWidthImg && this.settings.configImg.minHeightImg ) {
						dimImg = [this.settings.configImg.minWidthImg, this.settings.configImg.minHeightImg];
					}else {
						dimImg = this.jcrop_img.getBounds();
					}

					methods.changeOptsCrop.call(_this, {
						imgSet: urlImage,
						minWidth: _this.settings.configImg.minWidthImg,
						minHeight: _this.settings.configImg.minHeightImg,
						imgWidth: dimImg[0],
						imgHeight: dimImg[1]
					});

					// Add values to the crop form
					_this.settings.formCrop.find('input#crop_type').val( 'url' );
					_this.settings.formCrop.find('input#file_name').val( urlImage );
					_this.settings.formCrop.find('input#file_type').val( urlImage.split('.').slice(-1) );
				});

			}else {

				this.settings.imgCrop.attr('src', urlImage);

				// create crop if does not exist
				methods.renderImageCrop.call(this, this.settings.imgCrop, function () {

					var dimImg = [];
					// settings image crop
					if( this.settings.configImg.minWidthImg && this.settings.configImg.minHeightImg ) {
						dimImg = [this.settings.configImg.minWidthImg, this.settings.configImg.minHeightImg];
					}else {
						dimImg = this.jcrop_img.getBounds();
					}

					methods.changeOptsCrop.call(this, {
						imgSet: urlImage,
						minWidth: this.settings.configImg.minWidthImg,
						minHeight: this.settings.configImg.minHeightImg,
						imgWidth: dimImg[0],
						imgHeight: dimImg[1]
					});

					// Add values to the crop form
					this.settings.formCrop.find('input#crop_type').val( 'url' );
					this.settings.formCrop.find('input#file_name').val( urlImage );
					this.settings.formCrop.find('input#file_type').val( urlImage.split('.').slice(-1) );

				}.bind(this));
			}

			// call callback
			if( $.isFunction(callback) )
				callback.call();
		},

		/**
		* Render FineUploader plugin for user product image
		*/
		renderUploaderImg: function ($uploaderImg) {

			if( !existUploaderPlugin() ) {
				return false;
            }

			var _this = this;

			$uploaderImg.fineUploader({
				debug: false,
				template: this.settings.templateImgUploader,
				// session: {
				//     endpoint: document.url + Route.route('file.temp'),
				//     params: {
				//         'codigo_proyecto': 0
				//     }
				// },
				request: this.settings.uploadding,
				thumbnails: {
					placeholders: {
						waitingPath: window.Misc.urlFull('img/waiting-generic.png'),
						notAvailablePath: window.Misc.urlFull('img/not_available-generic.png')
					}
				},
				autoUpload: true,
				multiple: false,
				validation: {
					image: {
						// minWidth: this.settings.configImg.minWidthImg || defaults.configImg.minWidthImg,
						// minHeight: this.settings.configImg.minHeightImg || defaults.configImg.minHeightImg,
						maxWidth: this.settings.configImg.maxWidthImg || defaults.configImg.maxWidthImg,
						maxHeight: this.settings.configImg.maxHeightImg || defaults.configImg.maxHeightImg
					},
					allowedExtensions: this.settings.configImg.allowedExtensions || defaults.configImg.allowedExtensions,
					sizeLimit: this.settings.configImg.sizeLimit || defaults.configImg.sizeLimit,
                    stopOnFirstInvalidFile: false,
					itemLimit: 0
				},
				scaling: {
					sendOriginal: this.settings.configImg.sendOriginal || defaults.configImg.sendOriginal,
					defaultQuality: this.settings.configImg.defaultQuality || defaults.configImg.defaultQuality
				},
				// Events handlers
				callbacks: {
					onUpload: methods.onLoadImg.bind(this)
					// onComplete: methods.onCompleteLoadImg.bind(this)
				},
                messages: $.extend({}, this.settings.messages),
				dragAndDrop: {
					extraDropzones: this.settings.extraDropzones
				},
				showMessage: this.settings.showMessage,
				showConfirm: this.settings.showConfirm,
				showPrompt: this.settings.showPrompt
			});
		},

		/**
		* set image crop plugin
		*/
		renderImageCrop: function ($imgCrop, callback) {

			if( !existCropPlugin() )
				return false;

			//images crop
			var _this = this;

			$imgCrop.Jcrop({
				onSelect: methods.setCoords.bind(this),
				onChange: methods.setCoords.bind(this),
				onRelease: function () {
				},
				// minSize: [this.settings.configImg.minWidthImg, this.settings.configImg.minHeightImg],
				// maxSize: [this.settings.configImg.maxWidthImg, this.settings.configImg.maxHeightImg],
				bgColor: 'black',
				bgOpacity: 0.4,
				setSelect: [ 0, 0, this.settings.configImg.minWidthImg, this.settings.configImg.minHeightImg ],
				aspectRatio:  this.settings.configImg.minWidthImg / this.settings.configImg.minHeightImg,
				boxWidth: $imgCrop.parent().width(),
				boxHeight: 0,
				allowSelect: false,
				allowResize: true

			},function(){
				_this.jcrop_img = this;

				var dimDefault = _this.jcrop_img.getBounds();

				methods.changeOptsCrop.call(_this, {
					imgSet: $imgCrop.attr('src'),
					minWidth: _this.settings.configImg.minWidthImg,
					minHeight: _this.settings.configImg.minHeightImg,
					imgWidth: dimDefault[0],
					imgHeight: dimDefault[1]
				});

				if (typeof callback == 'function'){
					callback.call();
				}
			});
		},

		/**
		* Set select on image crop
		* @param Number imgWidth
		* @param Number imgHeight
		*/
		changeOptsCrop: function (options, callback) {

			var settings = {
				imgSet: '',
				minWidth: 0,
				minHeight: 0,
				imgWidth: 0,
				imgHeight: 0,
				dimSelect: [0,0],
				ix: 0,
				iy: 0
			};

			$.extend(settings, options);

			// set properties
			settings.dimSelect = setSquare(settings.imgWidth, settings.imgHeight);
			settings.ix = (settings.imgWidth - settings.dimSelect[0])/2;

			// refresh options crop
			this.jcrop_img.setOptions({
				trueSize: [ Math.floor(settings.imgWidth), Math.floor(settings.imgHeight) ]
				// outerImage: settings.imgSet
			});

			this.settings.previewImg.attr('src', settings.imgSet);

            this.jcrop_img.setSelect( [settings.ix, settings.iy, settings.dimSelect[0], settings.dimSelect[1]] );

			//run callback
			if (typeof callback == 'function') {
				callback.call();
			}
		},

		/**
		* submit event for image crop
		*/
		submitCropImage: function(e) {
			e.preventDefault();

			var _this = this;

			var data = formToJson( e.target );
			data.targ_w = this.settings.configImg.minWidthImg;
			data.targ_h = this.settings.configImg.minHeightImg;

			$.extend(data, this.settings.cropping.params);

			// emit callback
			if( $.isFunction(this.settings.callbacks['onCropping']) )
				this.settings.callbacks['onCropping'].call(this, this.jcrop_img);

			this.settings.formCrop.find(':submit').addClass('disabled');

			$.post(this.settings.cropping.endpoint, data, methods.onSuccessCrop.bind(this))
			 .fail(methods.onErrorCrop.bind(this));
		},

		// --------------
		// events handler
		// --------------
		/**
		* handler for set to coords of image crop
		* @param Object coords
		*/
		setCoords: function (coords){

			var ratioLesser = this.settings.configImg.minHeightImg / this.settings.configImg.minWidthImg;
			var dimImg = this.jcrop_img !== null ? this.jcrop_img.getBounds() : false,
				rx = $(this.settings.previewImg.parent()[0]).width() / coords.w,
				ry = (ratioLesser * $(this.settings.previewImg.parent()[0]).width()) / coords.h;

			// set content height of content preview
			// if( this.settings.previewImg.attr('src') ) {
                $(this.settings.previewImg.parent()[0]).height( ratioLesser * $(this.settings.previewImg.parent()[0]).width() );
            // }

			this.settings.formCrop.find('input.crop-x').val( coords.x );
			this.settings.formCrop.find('input.crop-y').val( coords.y );
			this.settings.formCrop.find('input.crop-w').val( coords.w );
			this.settings.formCrop.find('input.crop-h').val( coords.h );

			// set preview image
			if( dimImg ){
				this.settings.previewImg.css({
					width: Math.round(rx * dimImg[0]) + 'px',
					height: Math.round(ry * dimImg[1]) + 'px',
					minWidth: Math.round(rx * dimImg[0]) + 'px',
					minHeight: Math.round(ry * dimImg[1]) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
			}
		},

		/**
		* will upload image
		* @param Number id
		* @param String name
		*/
		onLoadImg: function (id, name) {

			var $areaDrop = this.settings.uploaderImg.fineUploader('getDropTarget', id);

			if( $areaDrop !== undefined && $areaDrop.length ){
				if( $areaDrop.hasClass('image-area-drop') || $areaDrop.hasClass('wrapper-image-crop') ){

					methods.reassignActions.call(this);
					methods.setImage.call(this);
				}
			}

			if( $.isFunction(this.settings.callbacks['onLoadImg']) ) {
				this.settings.callbacks['onLoadImg'].call(this, this.settings.uploaderImg, id, name);
            }
		},

		/**
		* complete event for upload image
		* @param Number id
		* @param String name
		* @param Object res
		* @param Object xhr
		*/
		onCompleteLoadImg: function (event, id, name, res) {

			var _this = this;

			if( !res.success ) {
				return;
            }

			// settings image crop
			if( this.settings.imgCrop.data('Jcrop') !== undefined ) {

				this.jcrop_img.setImage(res.file_path, function () {

					var dimImg = [res.file_width, res.file_height];

					methods.changeOptsCrop.call(this, {
						imgSet: res.file_path,
						minWidth: this.settings.configImg.minWidthImg,
						minHeight: this.settings.configImg.minHeightImg,
						imgWidth: res.file_width,
						imgHeight: res.file_height

					}, function () {
						// emit callback
						if( $.isFunction(this.settings.callbacks['onCompleteLoad']) )
							this.settings.callbacks['onCompleteLoad'].call(this, this.settings.uploaderImg, id, name, res);
					}.bind(this));

				}.bind(this));

			}else {

				this.settings.imgCrop.attr('src', res.file_path);

				methods.renderImageCrop.call(this, this.settings.imgCrop, function () {

					methods.changeOptsCrop.call(this, {
						imgSet: res.file_path,
						minWidth: this.settings.configImg.minWidthImg,
						minHeight: this.settings.configImg.minHeightImg,
						imgWidth: res.file_width,
						imgHeight: res.file_height
					}, function () {
						// emit callback
						if( $.isFunction(this.settings.callbacks['onCompleteLoad']) )
							this.settings.callbacks['onCompleteLoad'].call(this, this.settings.uploaderImg, id, name, res);
					}.bind(this));

				}.bind(this));
			}

			// Add values to the crop form
			this.settings.formCrop.find('input#crop_type').val( 'name' );
			this.settings.formCrop.find('input#file_name').val( res.file_name );
			this.settings.formCrop.find('input#file_type').val( res.file_type );
		},

		/**
		* success event for crop image
		* @param Object res
		* @param String status
		* @param Object jqXHR
		*/
		onSuccessCrop: function (resp, status, jqXHR) {

			this.settings.formCrop.find(':submit').removeClass('disabled');

			// call crop complete
			if( $.isFunction(this.settings.callbacks['onCropComplete']) ) {
				this.settings.callbacks['onCropComplete'].call(this, this.jcrop_img, resp, jqXHR);
            }
		},

		/**
		* error event for crop image
		* @param Object jqXHR
		* @param String status
		* @param String error
		*/
		onErrorCrop: function(jqXHR, status, error) {

			this.settings.formCrop.find(':submit').removeClass('disabled');

			// call crop error
			if( $.isFunction(this.settings.callbacks['onCropError']) ) {
				this.settings.callbacks['onCropError'].call(this, this.jcrop_img, jqXHR, error);
            }
		}
	}

	// plugin class
	// instance the plugin
	// -------------------
	$.imageUploaderCrop = function (element, options) {
		options || (options = {});

		// parameters
		var plugin = this;

		// set attributes
		this.jcrop_img = null;
		this.element = element;
		this.$element = $(element);

		// initialize plugin
		if( $.isFunction(plugin.init) )
			plugin.init(element, options);
	}

	// extends prototype of plugin
	$.imageUploaderCrop.prototype = {

		// plugin's settings
		settings : {},

		/**
		* Constructor method
		*/
		init : function(element, options) {

			this.settings = $.extend({}, defaults, options);

			// check out if already was assigned the jcrop library
			if( this.settings.imgCrop && this.settings.imgCrop.data('Jcrop') !== undefined ){
				this.jcrop_img = this.settings.imgCrop.data('Jcrop');
				this.jcrop_img.destroy();
			}

			// Init image uploader and actions
			methods.reassignActions.call(this);
			methods.renderUploaderImg.call(this, this.settings.uploaderImg);
            // methods.renderImageCrop.call(this, this.settings.imgCrop);
		},

		/**
		* -----------
		* Api methods
		* -----------
		*/

		/**
		* change Image
		* @param String urlImage
		* @param Function callback
		*/
		changeImage : function(urlImage, callback) {
			methods.reassignActions.call(this);
			methods.setImage.call(this, urlImage, callback);
		},

		/**
		* get image crop element
		*/
		getImgCrop : function () {
			return this.settings.imgCrop;
		},

		/**
		* get form crop element
		*/
		getFormCrop : function () {
			return this.settings.formCrop;
		},

		/**
		* get uploader image element
		*/
		getUploaderImg : function () {
			return this.settings.uploaderImg;
		},

		/**
		* get image preview element
		*/
		getPreviewImg : function () {
			return this.settings.previewImg
		},

		/**
		* destroy object plugin
		*/
		destroy : function () {
			methods.destroy.call(this);
		}
	};

	$.fn.imageUploaderCrop = function(optsOrCmd) {
		var self = this, selfArgs = arguments, retVals = [];

		if ( $(this).data('imageUploaderCrop') !== undefined && $.isFunction($(this).data('imageUploaderCrop')[optsOrCmd]) ) {

			var plug = $(this).data('imageUploaderCrop');
			return plug[optsOrCmd].apply(plug, slice.call(selfArgs, 1));

		} else if (typeof optsOrCmd === 'object' || !optsOrCmd) {

			return this.each(function(index, el) {

				var plugin = new $.imageUploaderCrop(this, optsOrCmd);

				$(this).data('imageUploaderCrop', plugin);
			});

		} else {
			$.error( 'Method "' +  optsOrCmd + '" does not exist in imageUploaderCrop - (krobing) plugin!');
		}
	}

}));

/**
* Class UserSingUpView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.UserSingUpView = Backbone.View.extend({

		el: 'body',
		events:{
			'submit #form-new-account': 'onValidateRegister',
			// 'blur #fld-email-register': 'onValidateEmailRegister',
			// 'blur #correo_electronico': 'onValidateEmailLogin'
		},
		templateTermsLogin: _.template( ($('#terms-policy-login-tpl').html() || '') ),
		templateTermsCheck: _.template( ($('#terms-policy-login-check-tpl').html() || '') ),

		/**
		* Constructor Method
		*/
		initialize : function() {

			_.bindAll(this, 'onValidateEmailLogin');

			var _this = this;

			//Init Attributes
			this.$modalLogin = $('#modal-login');
			this.$loginForm = $('#form-login-email');
			this.$registerForm = $('#form-new-account');
			this.$termsPolicy = this.$('#terms-policy-login');
			this.$fldEmailLogin = this.$('#correo_electronico:not([data-reveal] input)');
			this.configAlert = {
				'wrapper': this.$el,
				'closeTime': 8000,
				'speedOpen': 500,
				'speedClose': 500
			};

			if( this.$termsPolicy.length )
				this.$termsPolicy.html( this.templateTermsLogin({}) );

			// events handlers
			// $(this.$modalLogin).on('opened.fndtn.reveal', this.onValidateEmailLogin );
			// $(window).one('load', function () {
			// 	_this.onValidateEmailLogin();

   //              if( _.has($.fn, 'foundation') ) {
   //                  $(document).foundation('abide', 'reflow');
   //              }
			// })
		},

		/*
		* Render View Element
		*/
		render: function(){
			//
		},

		/**
		* validate Register
		*/
		onValidateRegister: function (event) {
			event.preventDefault();
			event.target.submit();

			// var _this = this,
			// 	validations = [],
			// 	sendData = {
			// 		'correo_electronico': ''
			// 	},
			// 	data = window.Misc.formToJson(event.target);

			// if( _.isObject(data) )
			// 	_.extend(sendData, data);

			// this.validateEmail(sendData, function (respState, respMessage, resp) {

			// 	_this.$loginForm.find(':submit').val(resp.labelbtn);

			// 	if( !respState ){
			// 		_this.$modalLogin.find('input#correo_electronico').val( data['correo_electronico'] );
			// 		_this.$modalLogin.foundation('reveal', 'open');

			// 		window.Misc.showAlertBox( respMessage );

			// 	}else {
			// 		_this.$el.find('input#fecha_nacimiento_usuario').val([data.year, data.month, data.day].join('-'));
			// 		event.target.submit();
			// 	}
			// });
		},

		/**
		* validate email register
		*/
		onValidateEmailRegister: function (e) {

			var _this = this,
				email = $(e.currentTarget).val(),
				sendData = {
					'correo_electronico': email
				};

			this.validateEmail(sendData, function (respState, respAlert, resp) {

				_this.$loginForm.find(':submit').val(resp.labelbtn);
				_this.$termsPolicy.html( _this.templateTermsLogin({}) );

				// if email exists on another institution
				if( !respState ){

					_this.$termsPolicy.html( _this.templateTermsCheck({}) );
					if(_.has($.fn, 'foundation') ) _this.$loginForm.foundation('abide');

					_this.$modalLogin.find('input#correo_electronico').val( email );
					_this.$modalLogin.foundation('reveal', 'open');


					_.extend(respAlert, {
						'closeTime': 15000
					});
					window.Misc.showAlertBox( respAlert );
				}

			});
		},

		/**
		* validate email login
		*/
		onValidateEmailLogin: function (e) {

			// if it's a opened event of foundation modal, validate to make once
			if (e !== undefined && e.type == 'opened' && e.namespace !== 'fndtn.reveal') return;

			var _this = this,
				email = (e !== undefined && e.type != 'opened' && $(e.currentTarget).length) ?
							$(e.currentTarget).val() :
								(!this.$fldEmailLogin.length && e !== undefined) ?
										this.$('#correo_electronico').val() : this.$fldEmailLogin.val(),
				sendData = {
					'correo_electronico': email
				};

			this.validateEmail(sendData, function (respState, respAlert, resp) {

				_this.$loginForm.find(':submit').val(resp.labelbtn);
				_this.$termsPolicy.html( _this.templateTermsLogin({}) );

				// if email exists on another institution
				if( !respState ){
					_this.$termsPolicy.html( _this.templateTermsCheck({}) );
					if(_.has($.fn, 'foundation') ) _this.$loginForm.foundation('abide');

					_.extend(respAlert, {
						'closeTime': 15000
					});
					window.Misc.showAlertBox( respAlert );
				}

			});

		},

		/**
		* validate E-mail of the register
		* @param String email
		* @return Array | [Boolean, Object]
		*/
		validateEmail: function (sendData, callback) {

			var _this = this,
				respReturn = true,
				configAlert = this.configAlert,
				_data = {
					'correo_electronico': ''
				};

			if( _.isObject(sendData) )
				_.extend(_data, sendData);

			if( window.Misc.isEmail(_data['correo_electronico']) ) {

				$.get(document.url + Route.route('auth.valid.exist'), _data, function (resp) {

					if( resp.success !== undefined ){

						var type = resp.success ? 'success' : 'alert',
							text = resp.success ?
								   (resp.message !== undefined ? resp.message : '')
								   : resp.errors;

						if( _.isObject(resp.errors) ){

							var listError = '<ul>';

							$.each(resp.errors, function(field, item) {
								 listError += '<li>'+ item[0] +'</li>';
							});
							listError += '</ul>';

							text = listError;
						}

						var conf = {
							'text': text,
							'type': type
						};

						_.extend(configAlert, conf);

						if (resp.success) {
							if(resp.isvalid && !resp.isjoin){

								respReturn = false;
							}

						}else {
							respReturn = false;
						}
					}

					if( typeof callback == 'function' ){
						callback.call(null, respReturn, configAlert, resp);
					}
				});
			}
		}
	});


})(jQuery, this, this.document);

/**
* Class GoogleRecaptchaView extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GoogleRecaptchaView = Backbone.View.extend({

        el: '.content-form-login',
        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;
            //Init Attributes
            this.configAlert = {
                'wrapper': '.login-alert-display',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Google recaptcha
            if( this.$('.widget-login-recaptcha').length && !window.Misc.checkSession(false) ) 
            {
                var widgetGRecaptcha = this.$('.widget-login-recaptcha')[0];
                setTimeout(function() {
                    grecaptcha.render(widgetGRecaptcha, {
                        'sitekey' : $(widgetGRecaptcha).data('key-recaptcha'),
                        'size': 'invisible',
                        'callback' : this.onLogin
                    })
                }.bind(this), 100)
            }
        },

        /*
        * Render View Element
        */
        render: function() {
            //
        },

        /*  
        * Event onLogin
        */
        onLogin: function(token) {
            // Google recaptcha
            this.$('#form-login-email').submit();
        }
    });


})(jQuery, this, this.document);

/**
* Class BaseModel extends of Backbone Model
* @author TuProyecto/Copo software || Desarrollador : @krobing
* @link https://coposoftware.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BaseModel = Backbone.Model.extend({
        /**
        * JSON object to String
        */
        toStrJSON: function () {
            return JSON.stringify( this );
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({ silent:true });
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        },

        /**
        * return to url initial
        */
        returnToUrlRoot: function () {
            // redefine the URI
            this.url = function () {
                var base =
                    _.result(this, 'urlRoot') ||
                    _.result(this.collection, 'url') ||
                    urlError();

                if (this.isNew()) return base;
                var id = this.get(this.idAttribute);
                return base.replace(/[^\/]$/, '$&/') + encodeURIComponent(id);
            };
        }
    });

})(this, this.document);

/**
* Class BreadcrumbModel of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BreadcrumbModel = Backbone.Model.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('breadcrumb') );
        },
        defaults: {
            'breadcrumbs': []
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        }
    });

})(this, this.document);

/**
* Class UrlMetaDataModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UrlMetaDataModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('muro.metadata') );
        },
        defaults: {
            'url': '',
            'status': 0,
            'success': false,
            'image': '',
            'description': '',
            'title': '',
            'author': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model options
        */
        initialize: function(attrs, opts){
            //Init attributes
        },

         /**
        * validate attributes model in the change
        * @param Object attrs. modified attributes model
        */
        validate: function (attrs) {
            
            var error = new Error();

            if( ! attrs.success ){
                error.message = "No se logro el previsualizado.";
                return error;
            }
        },

        /**
        * JSON object to String
        */
        toStrJSON: function () {
            return JSON.stringify( this );
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            this.set( this.defaults, opts );
        }

    });

})(this, this.document);
/**
* Class UserModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            'id': 0,
            'codigo_persona': 0,
            'nickname_usuario': '',
            'tipo_identificacion_usuario': '',
            'identificacion_usuario': '',
            'nombre_usuario': '',
            'primer_apellido_persona': '',
            'segundo_apellido_persona': '',
            'fecha_nacimiento_usuario': '',
            'codigo_ciudad': 0,
            'codigo_usuario_institucion': 0,
            'codigo_nivel_educacion': '',
            'codigo_especialidad': 0,
            'rol_usuario_institucion': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'biografia_usuario': '',
            'experiencia_usuario': '',
            'direccion_usuario': '',
            'barrio_usuario': '',
            'telefono_usuario': '',
            'movil_usuario': '',
            'imagen_usuario': '',
            'correo_electronico': '',
            'profesion_usuario': '',
            'pagina_web_usuario': '',
            'estado_civil_persona': 0,
            'nombre_estado_civil': '',
            'genero_persona': 0,
            'nombre_genero': '',
            'contador_gamification': '',
            'posicion_gamification': '',
            'facebook_usuario': '',
            'twitter_usuario': '',
            'linkedin_usuario': '',
            'mentor': false,
            'owner': false,
            'state_friendship': '',
            'srcparams': '',
            'codigo_concepto_institucion': 0,
            'tipo_usuario': 0,
            'forma_ayuda_mentoria': '',
            'stage_mentoring': 0,
            'codigo_especialidad': 0,
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model options
        */
        initialize: function(attrs, opts){
            //Init attributes

            //Events Listener
        },

        /**
        * validate attributes model in the change
        * @param Object attrs. modified attributes model
        */
        validate: function (attrs) {

        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        },

        /**
        * return to url initial
        */
        returnToUrlRoot: function () {
            // redefine the URI
            this.url = function () {
                var base =
                    _.result(this, 'urlRoot') ||
                    _.result(this.collection, 'url') ||
                    urlError();

                if (this.isNew()) return base;
                var id = this.get(this.idAttribute);
                return base.replace(/[^\/]$/, '$&/') + encodeURIComponent(id);
            };
        }

    });

})(this, this.document);

/**
* Class AdviceModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AdviceModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.preguntas.index') );
        },
        idAttribute: 'codigo_asesoria',
        defaults: {
            'url_asesoria': '',
            'titulo_asesoria': '',
            'descripcion_asesoria': '',
            'propuesta_asesoria': '',
            'codigo_tipo_asesoria': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'fecha_asesoria': '',
            'hora_asesoria': '',
            'tags': [],
            'nombre_tipo_asesoria': '',
            'contador_comentario': 0,
            'contador_like': 0,
            'is_open': true,
            'owner': false,
            'srcparams': '',
            'codigo_usuario': 0,
            'url_profile': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model Attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //Init attributes
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            // console.log( attrs );
        },

        /**
        * change state mentoring
        */
        closeMentoring: function () {
            this.save({
                'codigo_asesoria': this.get('codigo_asesoria'),
                'close': true,
                '_token': $('meta[name="csrf-token"]').attr('content'),
            }, {patch: true, wait: true});
        }
    });

})(this, this.document);

/**
* Class MentoringModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.MentoringModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.index') );
        },
        idAttribute: 'url_mentoria',
        defaults: {
            'url_mentoria': '',
            'descripcion_mentoria': '',
            'codigo_evento': 0,
            'nombre_usuario_emprendedor': '',
            'imagen_usuario_emprendedor': '',
            'nickname_usuario_emprendedor': '',
            'nombre_usuario_mentor': '',
            'imagen_usuario_mentor': '',
            'nickname_usuario_mentor': '',
            'codigo_evaluacion_mentoria': 0,
            'codigo_evaluacion_tarea': 0,
            'estado_evento': 0,
            'evento': 0,
            'nombre_estado': '',
            'fecha_inicio_evento': '',
            'fecha_fin_evento': '',
            'hora_inicio_evento': '',
            'hora_fin_evento': '',
            'objetivos': '',
            'evaluacion': false,
            'mentor': false
        },    

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});
            
            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        }
    });

})(this, this.document);

/**
* Class EntityModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EntityModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('entidad.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        	//
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        }
    });

})(this, this.document);

/**
* Class EventModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EventModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('calendario.evento.index') );
        },
        idAttribute: 'codigo_evento',
        defaults: {
            'nombre_evento': '',
            'descripcion_evento': '',
            'fecha_label_evento': '',
            'fecha_evento': '',
            'fecha_fin_evento': '',
            'hora_inicio_evento': '',
            'hora_fin_evento': '',
            'lugar_evento': '',
            'descripcion_mentoria': '',
            'objetivos_mentoria': [],
            'codigo_tipo_evento': 0,
            'codigo_calendario': 0,
            'codigo_ciudad': 0,
            'estado_evento': 0,
            'url_evento': '',
            'url_mentoria': '',
            'url_evento_organizador': '',
            'nombre_ciudad': '',
            'organizadores': [],
            'owner': false,
            'register': false,
            'categorias' : [],
            'etapas': [],
            'register': false,
            'view':false,
            'nombre_organizador_principal': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        	//
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        }
    });

})(this, this.document);

/**
* Class UserEventModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserEventModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('calendario.evento.participar.index') );
        },
        idAttribute: 'codigo_usuario_evento',
        defaults: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        	//
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        }
    });

})(this, this.document);

/**
* Class LikeModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.LikeModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('like.index') );
        },
        idAttribute: 'codigo_like',
        defaults: {
            'codigo_usuario': 0,
            'srcparams': '',
            'fecha_like': '',
            'hora_like': '',
            'codigo_estado': 0,
            'value_txt': '',
            'auth_like': false,
            'nickname_usuario': '',
            'nombre_usuario': '',
            'imagen_usuario': '',
            'url_profile': '',
            'contador_like': 0
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //Init attributes
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            // console.log( attrs );
        }

    });

})(this, this.document);

/**
* Class ProjectModel of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	 app.ProjectModel = Backbone.Model.extend({

		urlRoot: function () {
			return window.Misc.urlFull( Route.route('proyecto.index') );
		},
		idAttribute: 'codigo_entidad',
		defaults: {
			'id_entidad': 0,
			'url_nickname': '',
			'nickname_usuario': '',
			'nombre_usuario': '',
			'biografia_usuario': '',
			'descripcion_entidad': null,
			'codigo_etapa_proyecto': 0,
			'codigo_categoria_proyecto': 0,
			'cor_codigo_categoria_proyecto': null,
			'codigo_clase_emprendimiento': 0,
			'codigo_ciudad': '',
			'nombre_ciudad': '',
			'nombre_pais': '',
			'codigo_privacidad_contenido': 0,
			'imagen_usuario': '',
            'telefono_usuario': '',
            'correo_electronico': '',
            'fecha_nacimiento_usuario': '',
			'tags': null,
			'video_entidad': null,
			'facebook_usuario': null,
            'twitter_usuario': null,
            'linkedin_usuario': null,
            'instagram_usuario': null,
			'pagina_web_usuario': null,
			'contador_comentario': 0,
			'contador_like': 0,
			'srcparams': '',
			'updated_at': '',
			'nombre_clase_emprendimiento': '',
			'identificacion_usuario': '',
			'codigo_categoria_clase_espacio': 0,
			'owner': false,
			'creator': false,
			'codigo_usuario': 0,
			'nombre_privacidad_contenido': '',
			'icono_privacidad_contenido':'',
			'nombre_categoria_proyecto': '',
            'stage': '',
			'institution': 0,
			'nickname_founder': '',
			'codigo_founder': 0,
			'imagen_founder': '',
			'nombre_founder': '',
			'ciudad_founder': '',
			'pais_founder': '',
			'descripcion_adicional_usuario': '',
            'modelo_negocio_institucion': false,
            'codigo_tipo_id_institucion': 0,
            'cargo_entidad': 0,
            'distrito_ciudad_founder': '',
            'permissions': []
		},

		/**
		* Constructor Method
		* @param Object attrs, model attributes
		* @param Object opts, model Options
		*/
		initialize: function(attrs, opts){
			//
		},

		/**
		* validate attributes model in the change
		* @param Object. modified attributes model
		*/
		validate: function (attrs) {
			// var err = new Error();
			// err.message = "Complete los campos obligatorios";

			// if( !attrs.resumen_proyecto.length || attrs.codigo_categoria_proyecto < 1 ){
			//     return err;
			// }
		},

		/**
		* reset attributes in default
		*/
		resetAttrs: function (opts) {
			opts || (opts = {});

			var setAttrs = {};
			setAttrs[this.idAttribute] = null;

			this.clear({silent:true});
			_.extend(setAttrs, this.defaults);
			this.set( setAttrs, opts );
		}
	});

})(this, this.document);

/**
* Class ProjectBusinessModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.ProjectBusinessModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.modelodenegocio.index') );
        },
        idAttribute: 'codigo_respuesta_modelo_negocio',
        defaults: {
            'codigo_proyecto': 0,
            'codigo_modelo_negocio': 0,
            'items': [],
            'updated_at': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            //
        }
    });

})(this, this.document);

/**
* Class CallModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CallModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('convocatoria.index') );
        },
        idAttribute: 'codigo_convocatoria',
        defaults: {
            'url_convocatoria': '',
            'nombre_convocatoria' : '',
            'imagen_convocatoria' : '',
            'banner_convocatoria' : '',
            'contador_inscritos' : 0,
            'descripcion_convocatoria' : '',
            'resumen_convocatoria' : '',
            'tipo_convocatoria': '',
            'url_externa_convocatoria': '',
            'terminos_convocatoria' : '',
            'politicas_convocatoria' : '',
            'contenido_aceptacion_terminos' : '',
            'codigo_orientacion_convocatoria': 0,
            'fecha_cierre_registro': '',
            'fecha_cierre_convocatoria': '',
            'fases' : [],
            'documentos' : [],
            'categorias' : [],
            'etapas': [],
            'registered': false,
            'registered_entity': false,
            'opened': false,
            'codigo_estado': 0,
            'contador_like': 0,
            'srcparams': '',
            'userentitys': [],
            'type_user': 0,
            'url_encuesta': '',
            'url_organizador': '',
            'nombre_organizador' : '',
            'imagen_organizador' : '',
            'mensaje_tiempo_restante':'',
            'texto_alerta_convocaotoria':'',
            'permanente_convocatoria':false
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        }
    });

})(this, this.document);

/**
* Class CallStageUserModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CallStageUserModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('convocatoria.usuario.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            'nombre_usuario': '',
            'imagen_usuario': '',
            'nickname_usuario': '',
            'profesion_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'contador_inscritos': 0,
            'srcparams': '',
            'state_friendship': '',
            'url_profile': '',
            'codigo_convocatoria': 0,
            'codigo_orientacion_convocatoria': 0        
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
            
        }
    });

})(this, this.document);

/**
* Class TeamModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TeamModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.grupos') );
        },
        idAttribute: 'codigo_grupo',
        defaults: {
            'nombre_grupo': '',
            'imagen_grupo': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model options
        */
        initialize: function(attrs, opts){
            //Init attributes

            //Events Listener
        },

        /**
        * validate attributes model in the change
        * @param Object attrs. modified attributes model
        */
        validate: function (attrs) {
        }

    });

})(this, this.document);

/**
* Class SurveyModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SurveyModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('encuesta.index') );
        },
        idAttribute: 'codigo_encuesta',
        defaults: {
            'url_encuesta': '',
            'nombre_encuesta': '',
            'fecha_encuesta': '',
            'reference_encuesta': '',
            'redirect_to': '',
            'preguntas': [],
            'agrupaciones': [],
            'label_finalizar': '',
            'color_fondo_encuesta': '',
            'color_encuesta': '',
            'imagen_encuesta': '',
            'codigo_usuario': 0,
            'cancelar_encuesta': false,
            'preguardado_encuesta': false,
            'nickname_usuario': '',
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model options
        */
        initialize: function(attrs, opts){
            //Init attributes

            //Events Listener
        },

        /**
        * validate attributes model in the change
        * @param Object attrs. modified attributes model
        */
        validate: function (attrs) {
            // var err = new Error();
            // err.message = "Complete los campos obligatorios";

            // if( !attrs.nombre_encuesta.length || attrs.reference_encuesta < 1 ){
            //     return err;
            // }
        },

        /**
        * JSON object to String
        */
        toStrJSON: function () {
            return JSON.stringify( this );
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        },

        /**
        * return to url initial
        */
        returnToUrlRoot: function () {
            // redefine the URI
            this.url = function () {
                var base =
                    _.result(this, 'urlRoot') ||
                    _.result(this.collection, 'url') ||
                    urlError();

                if (this.isNew()) return base;
                var id = this.get(this.idAttribute);
                return base.replace(/[^\/]$/, '$&/') + encodeURIComponent(id);
            };
        }
    });

})(this, this.document);

/**
* Class CourseModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.CourseModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.index') );
        },
        idAttribute: 'codigo_curso',
        defaults: {
            'url_curso': '',
            'nombre_curso': '',
            'descripcion_curso': '',
            'imagen_curso': '',
            'nombre_categoria_curso': '',
            'url_categoria_curso': '',
            'nombre_patrocinador': '',
            'contador_inscritos': 0,
            'codigo_orientacion_curso':0,
            'url_externa_curso':'',
            'fecha_apertura_curso':'',
            'fecha_cierre_curso':'',
            'organizadores': [],
            'codigo_usuario':'',
            'inscripcion': false,
            'porcentaje_progreso': 0
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {

        }
    });

})(this, this.document);

/**
* Class CourseThemeModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeModel = Backbone.Model.extend({

        urlRoot: function () {
           return window.Misc.urlFull( Route.route('aprende.curso.tema.index') );
        },
        idAttribute: 'codigo_tema_curso',
        defaults: {
            'nombre_tema_curso': '',
            'url_tema_curso': '',
            'url_adjunto': '',
            'codigo_curso': 0,
            'objetivo_tema_curso': '',
            'adjuntos': [],
            'codigo_estado': '',
        },
        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        }
    });

})(this, this.document);

/**
* Class CourseThemeAttachedModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeAttachedModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.tema.adjunto.index') );
        },
        idAttribute: 'url_adjunto',
        defaults: {
            'direccion_adjunto': '',
            'nombre_adjunto': '',
            'codigo_tipo_adjunto': 0,
            'state_review': false,
            'srcparams': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        },

        /**
        * change state of review attached
        */
        changeStateReview: function () {

            this.save({
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'srcparams': this.get('srcparams')
            }, {patch: true});
        }
    });

})(this, this.document);

/**
* Class CourseAttachmentModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseAttachmentModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.adjunto.index') );
        },
        idAttribute: 'url_adjunto',
        defaults: {
        	'codigo_adjunto': '',
        	'codigo_curso': '',
            'codigo_estado': 0,
            'direccion_adjunto': '',
            'nombre_adjunto': '',
            'srcparams': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        },

        /**
        * change state of review attached
        */
        changeStateReview: function () {
            this.save({
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'srcparams': this.get('srcparams')
            }, {patch: true});
        }
    });

})(this, this.document);

/**
* Class RegistrationCourseModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RegistrationCourseModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.inscripcioncurso.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
        	'codigo_curso': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'url_profile': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
            
        }
    });

})(this, this.document);

/**
* Class BlogArticleModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.BlogArticleModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('blog.index') );
        },
        idAttribute: 'codigo_contenido',
        defaults: {
            'url_contenido': '',
            'nombre_contenido': '',
            'resumen_contenido': '',
            'texto_contenido': '',
            'imagen_contenido': '',
            'fecha_contenido': '',
            'codigo_contenido': null,
            'codigo_tipo_contenido': 0,
            'contador_comentario': 0,
            'contador_like': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'time_ago': null,
            'srcparams': '',
            'url_profile': '',
            'owner': false,
            'url_tipo_contenido': '',
            'state_product': 0,
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            //
        },

        /**
        * return to url initial
        */
        returnToUrlRoot: function () {
            // redefine the URI
            this.url = function () {
                var base =
                    _.result(this, 'urlRoot') ||
                    _.result(this.collection, 'url') ||
                    urlError();

                if (this.isNew()) return base;
                var id = this.get(this.idAttribute);
                return base.replace(/[^\/]$/, '$&/') + encodeURIComponent(id);
            };
        }
    });

})(this, this.document);

/**
* Class MentoringEvaluationModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (win