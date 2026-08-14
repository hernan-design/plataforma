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
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["GET","HEAD"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/email","name":"password.request","action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":"password.email","action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"password.reset","action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}","name":"auth.provider","action":"App\Http\Controllers\Auth\LoginController@redirectToProvider"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}\/callback","name":"auth.provider.callback","action":"App\Http\Controllers\Auth\LoginController@handleProviderCallback"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home","action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"chat","name":"chat.index","action":"App\Http\Controllers\Chat\ChatController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.index","action":"App\Http\Controllers\CanalUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.store","action":"App\Http\Controllers\CanalUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/canalusuario\/{canalusuario}","name":"comunidad.canalusuario.update","action":"App\Http\Controllers\CanalUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{canal}\/create","name":"comunidad.create","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad","name":"comunidad.index","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["POST"],"uri":"comunidad","name":"comunidad.store","action":"App\Http\Controllers\MuroController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{comunidad}","name":"comunidad.show","action":"App\Http\Controllers\MuroController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/{comunidad}","name":"comunidad.update","action":"App\Http\Controllers\MuroController@update"},{"host":null,"methods":["DELETE"],"uri":"comunidad\/{comunidad}","name":"comunidad.destroy","action":"App\Http\Controllers\MuroController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/rechazar\/{asesoria}","name":"mentoria.preguntas.rechazar","action":"App\Http\Controllers\AsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/aceptar\/{asesoria}","name":"mentoria.preguntas.aceptar","action":"App\Http\Controllers\AsesoriaController@aceptar"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor\/create\/{user}","name":"mentoria.preguntas.evaluacion.mentor.create","action":"App\Http\Controllers\EvaluacionAsesoriaController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.index","action":"App\Http\Controllers\EvaluacionAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.store","action":"App\Http\Controllers\EvaluacionAsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/procesos","name":"mentoria.mentores.procesos.index","action":"App\Http\Controllers\ProcesoMentoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/procesos\/{procesos}","name":"mentoria.mentores.procesos.show","action":"App\Http\Controllers\ProcesoMentoriaController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.index","action":"App\Http\Controllers\AsesoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/create","name":"mentoria.preguntas.create","action":"App\Http\Controllers\AsesoriaController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.store","action":"App\Http\Controllers\AsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.show","action":"App\Http\Controllers\AsesoriaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.update","action":"App\Http\Controllers\AsesoriaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores","name":"mentoria.mentores.index","action":"App\Http\Controllers\MentorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/create","name":"mentoria.mentores.create","action":"App\Http\Controllers\MentorController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/mentores","name":"mentoria.mentores.store","action":"App\Http\Controllers\MentorController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.show","action":"App\Http\Controllers\MentorController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.update","action":"App\Http\Controllers\MentorController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sesiones\/tarea","name":"mentoria.sesiones.tarea.index","action":"App\Http\Controllers\TareaMentoriaController@index"},{"host":null,"methods":["POST"],"uri":"mentoria\/sesiones\/tarea","name":"mentoria.sesiones.tarea.store","action":"App\Http\Controllers\TareaMentoriaController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/sesiones\/tarea\/{tarea}","name":"mentoria.sesiones.tarea.update","action":"App\Http\Controllers\TareaMentoriaController@update"},{"host":null,"methods":["DELETE"],"uri":"mentoria\/sesiones\/tarea\/{tarea}","name":"mentoria.sesiones.tarea.destroy","action":"App\Http\Controllers\TareaMentoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sesiones\/tags","name":"mentoria.sesiones.tags.index","action":"App\Http\Controllers\TagsMentoriaController@index"},{"host":null,"methods":["POST"],"uri":"mentoria\/sesiones\/tags","name":"mentoria.sesiones.tags.store","action":"App\Http\Controllers\TagsMentoriaController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/sesiones\/tags\/{tags}","name":"mentoria.sesiones.tags.update","action":"App\Http\Controllers\TagsMentoriaController@update"},{"host":null,"methods":["DELETE"],"uri":"mentoria\/sesiones\/tags\/{tags}","name":"mentoria.sesiones.tags.destroy","action":"App\Http\Controllers\TagsMentoriaController@destroy"},{"host":null,"methods":["POST"],"uri":"mentoria\/sesiones\/objetivo","name":"mentoria.sesiones.objetivo","action":"App\Http\Controllers\MentoriaSessionesController@generalObjetive"},{"host":null,"methods":["POST"],"uri":"mentoria\/sesiones\/descripcion","name":"mentoria.sesiones.descripcion","action":"App\Http\Controllers\MentoriaSessionesController@descriptionMentoring"},{"host":null,"methods":["POST"],"uri":"mentoria\/sesiones\/finalizar","name":"mentoria.sesiones.finalizar","action":"App\Http\Controllers\MentoriaSessionesController@finishedMentoring"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sessiones","name":"mentoria.sessiones.index","action":"App\Http\Controllers\MentoriaSessionesController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sessiones\/create","name":"mentoria.sessiones.create","action":"App\Http\Controllers\MentoriaSessionesController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/sessiones","name":"mentoria.sessiones.store","action":"App\Http\Controllers\MentoriaSessionesController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sessiones\/{sessiones}","name":"mentoria.sessiones.show","action":"App\Http\Controllers\MentoriaSessionesController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/sessiones\/{sessiones}","name":"mentoria.sessiones.update","action":"App\Http\Controllers\MentoriaSessionesController@update"},{"host":null,"methods":["DELETE"],"uri":"mentoria\/sessiones\/{sessiones}","name":"mentoria.sessiones.destroy","action":"App\Http\Controllers\MentoriaSessionesController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria","name":"mentoria.index","action":"App\Http\Controllers\MentoriaController@index"},{"host":null,"methods":["POST"],"uri":"file\/temp","name":"file.temp","action":"App\Http\Controllers\FileController@temp"},{"host":null,"methods":["POST"],"uri":"file\/crop","name":"file.crop","action":"App\Http\Controllers\FileController@crop"},{"host":null,"methods":["POST"],"uri":"file\/upload","name":"file.upload","action":"App\Http\Controllers\FileController@upload"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/identificacion","name":"usuario.identificacion.index","action":"App\Http\Controllers\TipoIdentificacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/economicos\/selectorlist","name":"usuario.economicos.selector.list","action":"App\Http\Controllers\SectorEconomicoPersonaController@selectorlist"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/economicos","name":"usuario.economicos.index","action":"App\Http\Controllers\SectorEconomicoPersonaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.update","action":"App\Http\Controllers\SectorEconomicoPersonaController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.destroy","action":"App\Http\Controllers\SectorEconomicoPersonaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/razones","name":"usuario.razones.index","action":"App\Http\Controllers\RazonRegistroUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/razones\/{razones}","name":"usuario.razones.update","action":"App\Http\Controllers\RazonRegistroUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/razones\/{razones}","name":"usuario.razones.destroy","action":"App\Http\Controllers\RazonRegistroUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/especialidades\/selectorlist","name":"usuario.especialidades.selector.list","action":"App\Http\Controllers\EspecialidadUsuarioController@selectorlist"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/especialidades","name":"usuario.especialidades.index","action":"App\Http\Controllers\EspecialidadUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/especialidades\/{especialidades}","name":"usuario.especialidades.update","action":"App\Http\Controllers\EspecialidadUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/especialidades\/{especialidades}","name":"usuario.especialidades.destroy","action":"App\Http\Controllers\EspecialidadUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/intereses","name":"usuario.intereses.index","action":"App\Http\Controllers\SectorInteresUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/intereses\/{intereses}","name":"usuario.intereses.update","action":"App\Http\Controllers\SectorInteresUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/intereses\/{intereses}","name":"usuario.intereses.destroy","action":"App\Http\Controllers\SectorInteresUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/educaciones","name":"usuario.educaciones.index","action":"App\Http\Controllers\NivelEducacionUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/educaciones","name":"usuario.educaciones.store","action":"App\Http\Controllers\NivelEducacionUsuarioController@store"},{"host":null,"methods":["DELETE"],"uri":"usuario\/educaciones\/{educaciones}","name":"usuario.educaciones.destroy","action":"App\Http\Controllers\NivelEducacionUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/conceptos","name":"usuario.conceptos.index","action":"App\Http\Controllers\ConceptoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/convocatorias","name":"usuario.convocatorias.index","action":"App\Http\Controllers\RegistroFaseUsuarioController@index"},{"host":null,"methods":["PATCH"],"uri":"usuario\/socialnetworks\/{usuario}","name":"usuario.socialnetworks","action":"App\Http\Controllers\UsuarioController@socialNetworks"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/auth","name":"usuario.auth","action":"App\Http\Controllers\UsuarioController@auth"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/confirmdeactivation","name":"usuario.confirmdeactivation","action":"App\Http\Controllers\UsuarioController@confirmdeactivation"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/usernameavailable","name":"usuario.usernameavailable","action":"App\Http\Controllers\UsuarioController@usernameAvailable"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/valid","name":"usuario.valid.email","action":"App\Http\Controllers\UsuarioController@verifyEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario\/confirmar","name":"usuario.redusuario.confirmar","action":"App\Http\Controllers\RedUsuarioController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario","name":"usuario.redusuario.index","action":"App\Http\Controllers\RedUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/redusuario","name":"usuario.redusuario.store","action":"App\Http\Controllers\RedUsuarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario\/{redusuario}","name":"usuario.redusuario.show","action":"App\Http\Controllers\RedUsuarioController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/redusuario\/{redusuario}","name":"usuario.redusuario.update","action":"App\Http\Controllers\RedUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/confirmacion\/{email}","name":"usuario.confirmacion.confirmar","action":"App\Http\Controllers\UsuarioController@confirmAccount"},{"host":null,"methods":["POST"],"uri":"usuario\/confirmacion\/correo","name":"usuario.confirmacion.email","action":"App\Http\Controllers\UsuarioController@sendMailConfirmation"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo\/confirmar","name":"usuario.equipo.confirmar","action":"App\Http\Controllers\GrupoUsuarioController@confirmar"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo","name":"usuario.equipo.index","action":"App\Http\Controllers\GrupoUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/equipo","name":"usuario.equipo.store","action":"App\Http\Controllers\GrupoUsuarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo\/{equipo}","name":"usuario.equipo.show","action":"App\Http\Controllers\GrupoUsuarioController@show"},{"host":null,"methods":["DELETE"],"uri":"usuario\/equipo\/{equipo}","name":"usuario.equipo.destroy","action":"App\Http\Controllers\GrupoUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/{nickname}","name":"usuario.nickname","action":"App\Http\Controllers\UsuarioController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/{nickname}\/{tab?}","name":"usuario.nickname.tab","action":"App\Http\Controllers\UsuarioController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario","name":"usuario.index","action":"App\Http\Controllers\UsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario","name":"usuario.store","action":"App\Http\Controllers\UsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/{usuario}","name":"usuario.update","action":"App\Http\Controllers\UsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/{usuario}","name":"usuario.destroy","action":"App\Http\Controllers\UsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"deactivation","name":"deactivation","action":"App\Http\Controllers\UsuarioController@deactivation"},{"host":null,"methods":["GET","HEAD"],"uri":"verifyaccount\/{user}","name":"verify.account.mail","action":"App\Http\Controllers\UsuarioController@verifyaccountmail"},{"host":null,"methods":["GET","HEAD"],"uri":"verifyaccount","name":"verify.account","action":"App\Http\Controllers\UsuarioController@verifyaccount"},{"host":null,"methods":["GET","HEAD"],"uri":"ciudades","name":"ciudades.index","action":"App\Http\Controllers\CiudadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"profesiones","name":"profesiones.index","action":"App\Http\Controllers\ProfesionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ocupaciones","name":"ocupaciones.index","action":"App\Http\Controllers\OcupacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"like","name":"like.index","action":"App\Http\Controllers\LikeController@index"},{"host":null,"methods":["POST"],"uri":"like","name":"like.store","action":"App\Http\Controllers\LikeController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"like\/{like}","name":"like.show","action":"App\Http\Controllers\LikeController@show"},{"host":null,"methods":["DELETE"],"uri":"like\/{like}","name":"like.destroy","action":"App\Http\Controllers\LikeController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"fav","name":"fav.index","action":"App\Http\Controllers\FavController@index"},{"host":null,"methods":["POST"],"uri":"fav","name":"fav.store","action":"App\Http\Controllers\FavController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"fav\/{fav}","name":"fav.update","action":"App\Http\Controllers\FavController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tag","name":"tag.index","action":"App\Http\Controllers\TagController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"foro","name":"foro.index","action":"App\Http\Controllers\ForoController@index"},{"host":null,"methods":["POST"],"uri":"foro","name":"foro.store","action":"App\Http\Controllers\ForoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"foro\/{foro}","name":"foro.show","action":"App\Http\Controllers\ForoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"foro\/{foro}","name":"foro.update","action":"App\Http\Controllers\ForoController@update"},{"host":null,"methods":["DELETE"],"uri":"foro\/{foro}","name":"foro.destroy","action":"App\Http\Controllers\ForoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"foro\/{category}\/{theme}","name":"foro.categoria.tema","action":"App\Http\Controllers\ForoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto","name":"proyecto.index","action":"App\Http\Controllers\ProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/create","name":"proyecto.create","action":"App\Http\Controllers\ProyectoController@create"},{"host":null,"methods":["POST"],"uri":"proyecto","name":"proyecto.store","action":"App\Http\Controllers\ProyectoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/{proyecto}","name":"proyecto.update","action":"App\Http\Controllers\ProyectoController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/{proyecto}","name":"proyecto.destroy","action":"App\Http\Controllers\ProyectoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/etapa","name":"proyecto.etapa.index","action":"App\Http\Controllers\EtapaProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/intereses","name":"proyecto.intereses.index","action":"App\Http\Controllers\SectorInteresProyectoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/intereses\/{intereses}","name":"proyecto.intereses.update","action":"App\Http\Controllers\SectorInteresProyectoController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/intereses\/{intereses}","name":"proyecto.intereses.destroy","action":"App\Http\Controllers\SectorInteresProyectoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/patrocinador","name":"proyecto.patrocinador.index","action":"App\Http\Controllers\PatrocinadorEntidadController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/patrocinador\/{patrocinador}","name":"proyecto.patrocinador.update","action":"App\Http\Controllers\PatrocinadorEntidadController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/patrocinador\/{patrocinador}","name":"proyecto.patrocinador.destroy","action":"App\Http\Controllers\PatrocinadorEntidadController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/categoriaclase\/{categoriaclase}","name":"proyecto.categoriaclase.show","action":"App\Http\Controllers\CategoriaClaseEspacioController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/modelodenegocio","name":"proyecto.modelodenegocio.index","action":"App\Http\Controllers\ModeloNegocioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/mentoremprendimiento\/confirmar","name":"proyecto.mentoremprendimiento.confirmar","action":"App\Http\Controllers\MentorEmprendimientoController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/mentoremprendimiento","name":"proyecto.mentoremprendimiento.index","action":"App\Http\Controllers\MentorEmprendimientoController@index"},{"host":null,"methods":["POST"],"uri":"proyecto\/mentoremprendimiento","name":"proyecto.mentoremprendimiento.store","action":"App\Http\Controllers\MentorEmprendimientoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{type}","name":"proyecto.tipo","action":"App\Http\Controllers\ProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}","name":"proyecto.proyecto","action":"App\Http\Controllers\ProyectoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}\/{tab?}","name":"proyecto.proyecto.tab","action":"App\Http\Controllers\ProyectoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}\/{privadetab?}","name":"proyecto.proyecto.privadetab","action":"App\Http\Controllers\ProyectoController@showPrivadeUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/equipo","name":"grupo.equipo.index","action":"App\Http\Controllers\GrupoEquipoController@index"},{"host":null,"methods":["POST"],"uri":"grupo\/equipo","name":"grupo.equipo.store","action":"App\Http\Controllers\GrupoEquipoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"grupo\/equipo\/{equipo}","name":"grupo.equipo.update","action":"App\Http\Controllers\GrupoEquipoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/cluster","name":"grupo.cluster.index","action":"App\Http\Controllers\AgrupacionProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/{grupo}","name":"grupo.grupo","action":"App\Http\Controllers\GrupoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/{grupo}\/{tab?}","name":"grupo.grupo.tab","action":"App\Http\Controllers\GrupoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo","name":"grupo.index","action":"App\Http\Controllers\GrupoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"grupo\/{grupo}","name":"grupo.update","action":"App\Http\Controllers\GrupoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/selectorlist","name":"convocatoria.selector.list","action":"App\Http\Controllers\ConvocatoriaController@selectorlist"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/aplicar\/validacion","name":"convocatoria.aplicar.validacion","action":"App\Http\Controllers\ConvocatoriaController@validApply"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/{convocatoria}\/aplicar\/{step}","name":"convocatoria.aplicar","action":"App\Http\Controllers\ConvocatoriaController@apply"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/fase\/adjunto","name":"convocatoria.fase.adjunto.index","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"convocatoria\/fase\/adjunto","name":"convocatoria.fase.adjunto.store","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"convocatoria\/fase\/adjunto\/{adjunto}","name":"convocatoria.fase.adjunto.update","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/fase","name":"convocatoria.fase.index","action":"App\Http\Controllers\FaseController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"convocatoria\/fase\/{fase}","name":"convocatoria.fase.update","action":"App\Http\Controllers\FaseController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/usuario","name":"convocatoria.usuario.index","action":"App\Http\Controllers\FaseUsuarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/{convocatoria}","name":"convocatoria.convocatoria","action":"App\Http\Controllers\ConvocatoriaController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria","name":"convocatoria.index","action":"App\Http\Controllers\ConvocatoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/contenido\/{theme}\/{class}","name":"aprende.curso.tema.clase","action":"App\Http\Controllers\AprendeController@showCourseThemeClass"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/formulario\/{survey}","name":"aprende.curso.tema.formulario","action":"App\Http\Controllers\AprendeController@showCourseThemeSurvey"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/contenido","name":"aprende.contenido","action":"App\Http\Controllers\AprendeController@showContentCourse"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}","name":"aprende.categoria.curso","action":"App\Http\Controllers\AprendeController@showCategoryCourse"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}","name":"aprende.categoria","action":"App\Http\Controllers\AprendeController@filterCategory"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}","name":"aprende.tipo","action":"App\Http\Controllers\CursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/inscripcioncurso","name":"aprende.curso.inscripcioncurso.index","action":"App\Http\Controllers\InscripcionCursoController@index"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/inscripcioncurso","name":"aprende.curso.inscripcioncurso.store","action":"App\Http\Controllers\InscripcionCursoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/inscripcioncurso\/{inscripcioncurso}","name":"aprende.curso.inscripcioncurso.update","action":"App\Http\Controllers\InscripcionCursoController@update"},{"host":null,"methods":["DELETE"],"uri":"aprende\/curso\/inscripcioncurso\/{inscripcioncurso}","name":"aprende.curso.inscripcioncurso.destroy","action":"App\Http\Controllers\InscripcionCursoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/adjunto","name":"aprende.curso.adjunto.index","action":"App\Http\Controllers\AdjuntoCursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/notausuario","name":"aprende.curso.notausuario.index","action":"App\Http\Controllers\NotaUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/notausuario","name":"aprende.curso.notausuario.store","action":"App\Http\Controllers\NotaUsuarioController@store"},{"host":null,"methods":["DELETE"],"uri":"aprende\/curso\/notausuario\/{notausuario}","name":"aprende.curso.notausuario.destroy","action":"App\Http\Controllers\NotaUsuarioController@destroy"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/certificado","name":"aprende.curso.certificado","action":"App\Http\Controllers\CursoController@certificate"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/certificadoTotal","name":"aprende.curso.certificadoTotal","action":"App\Http\Controllers\CursoController@certificateTotal"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/tema\/adjunto","name":"aprende.curso.tema.adjunto.index","action":"App\Http\Controllers\AdjuntoTemaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/tema\/adjunto\/{adjunto}","name":"aprende.curso.tema.adjunto.update","action":"App\Http\Controllers\AdjuntoTemaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/tema","name":"aprende.curso.tema.index","action":"App\Http\Controllers\TemaCursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso","name":"aprende.curso.index","action":"App\Http\Controllers\CursoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/{curso}","name":"aprende.curso.update","action":"App\Http\Controllers\CursoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/{curso}","name":"aprende.curso","action":"App\Http\Controllers\CursoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende","name":"aprende.index","action":"App\Http\Controllers\AprendeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/participantes","name":"discusion.participantes.index","action":"App\Http\Controllers\ParticipanteDiscusionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/comentario","name":"discusion.comentario.index","action":"App\Http\Controllers\ComentarioDiscusionController@index"},{"host":null,"methods":["POST"],"uri":"discusion\/comentario","name":"discusion.comentario.store","action":"App\Http\Controllers\ComentarioDiscusionController@store"},{"host":null,"methods":["DELETE"],"uri":"discusion\/comentario\/{comentario}","name":"discusion.comentario.destroy","action":"App\Http\Controllers\ComentarioDiscusionController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion","name":"discusion.index","action":"App\Http\Controllers\DiscusionController@index"},{"host":null,"methods":["POST"],"uri":"discusion","name":"discusion.store","action":"App\Http\Controllers\DiscusionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/{discusion}","name":"discusion.show","action":"App\Http\Controllers\DiscusionController@show"},{"host":null,"methods":["DELETE"],"uri":"discusion\/{discusion}","name":"discusion.destroy","action":"App\Http\Controllers\DiscusionController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"blog","name":"blog.index","action":"App\Http\Controllers\BlogController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/create","name":"blog.create","action":"App\Http\Controllers\BlogController@create"},{"host":null,"methods":["POST"],"uri":"blog","name":"blog.store","action":"App\Http\Controllers\BlogController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"blog\/{blog}","name":"blog.update","action":"App\Http\Controllers\BlogController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/{category}","name":"blog.categoria","action":"App\Http\Controllers\BlogController@filterCategory"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/{category}\/{article}","name":"blog.categoria.articulo","action":"App\Http\Controllers\BlogController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/participar","name":"calendario.evento.participar.index","action":"App\Http\Controllers\UsuarioEventoController@index"},{"host":null,"methods":["POST"],"uri":"calendario\/evento\/participar","name":"calendario.evento.participar.store","action":"App\Http\Controllers\UsuarioEventoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/participar\/{participar}","name":"calendario.evento.participar.show","action":"App\Http\Controllers\UsuarioEventoController@show"},{"host":null,"methods":["DELETE"],"uri":"calendario\/evento\/participar\/{participar}","name":"calendario.evento.participar.destroy","action":"App\Http\Controllers\UsuarioEventoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/tema","name":"calendario.evento.tema","action":"App\Http\Controllers\EventoController@temaseventolist"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento","name":"calendario.evento.index","action":"App\Http\Controllers\EventoController@index"},{"host":null,"methods":["POST"],"uri":"calendario\/evento","name":"calendario.evento.store","action":"App\Http\Controllers\EventoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.show","action":"App\Http\Controllers\EventoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.update","action":"App\Http\Controllers\EventoController@update"},{"host":null,"methods":["DELETE"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.destroy","action":"App\Http\Controllers\EventoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario","name":"calendario.index","action":"App\Http\Controllers\CalendarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/{calendario}","name":"calendario.show","action":"App\Http\Controllers\CalendarioController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/evaluacion","name":"marketplace.evaluacion.index","action":"App\Http\Controllers\EvaluacionCompraController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/evaluacion","name":"marketplace.evaluacion.store","action":"App\Http\Controllers\EvaluacionCompraController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/voucher","name":"marketplace.voucher.index","action":"App\Http\Controllers\VoucherController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/categoriaproducto","name":"marketplace.categoriaproducto.index","action":"App\Http\Controllers\CategoriaProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}\/evaluacion\/{purchase}","name":"marketplace.evaluacion.purchase","action":"App\Http\Controllers\EvaluacionCompraController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/evaluaciongeneral","name":"marketplace.evaluaciongeneral","action":"App\Http\Controllers\EvaluacionGeneralCompraController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/providerlist","name":"marketplace.provider.index","action":"App\Http\Controllers\UsuarioController@listProviders"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}\/entregables\/{purchase}","name":"marketplace.entregables.purchase","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@deliberable"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/create\/{venta}","name":"marketplace.ventas.acuerdo.create","action":"App\Http\Controllers\AcuerdoController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo","name":"marketplace.ventas.acuerdo.index","action":"App\Http\Controllers\AcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/acuerdo","name":"marketplace.ventas.acuerdo.store","action":"App\Http\Controllers\AcuerdoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}","name":"marketplace.ventas.acuerdo.show","action":"App\Http\Controllers\AcuerdoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}\/edit","name":"marketplace.ventas.acuerdo.edit","action":"App\Http\Controllers\AcuerdoController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}","name":"marketplace.ventas.acuerdo.update","action":"App\Http\Controllers\AcuerdoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion","name":"marketplace.ventas.promocion.index","action":"App\Http\Controllers\PromocionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/create","name":"marketplace.ventas.promocion.create","action":"App\Http\Controllers\PromocionController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/promocion","name":"marketplace.ventas.promocion.store","action":"App\Http\Controllers\PromocionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/{promocion}","name":"marketplace.ventas.promocion.show","action":"App\Http\Controllers\PromocionController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/{promocion}\/edit","name":"marketplace.ventas.promocion.edit","action":"App\Http\Controllers\PromocionController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/promocion\/{promocion}","name":"marketplace.ventas.promocion.update","action":"App\Http\Controllers\PromocionController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/informe","name":"marketplace.ventas.informe.index","action":"App\Http\Controllers\AdjuntoAcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/informe","name":"marketplace.ventas.informe.store","action":"App\Http\Controllers\AdjuntoAcuerdoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/informe\/{informe}","name":"marketplace.ventas.informe.update","action":"App\Http\Controllers\AdjuntoAcuerdoController@update"},{"host":null,"methods":["DELETE"],"uri":"marketplace\/ventas\/informe\/{informe}","name":"marketplace.ventas.informe.destroy","action":"App\Http\Controllers\AdjuntoAcuerdoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas","name":"marketplace.ventas.index","action":"App\Http\Controllers\VendedorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/create","name":"marketplace.ventas.create","action":"App\Http\Controllers\VendedorController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas","name":"marketplace.ventas.store","action":"App\Http\Controllers\VendedorController@store"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras\/acuerdo\/confirmar","name":"marketplace.compras.acuerdo.confirmar","action":"App\Http\Controllers\AcuerdoController@confirmar"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/acuerdo\/{acuerdo}","name":"marketplace.compras.acuerdo.show","action":"App\Http\Controllers\AcuerdoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/offer","name":"marketplace.compras.offer.index","action":"App\Http\Controllers\OfertaController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras\/offer","name":"marketplace.compras.offer.store","action":"App\Http\Controllers\OfertaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/shipping\/{shipping}\/edit","name":"marketplace.compras.shipping.edit","action":"App\Http\Controllers\EnvioCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/shipping\/{shipping}","name":"marketplace.compras.shipping.update","action":"App\Http\Controllers\EnvioCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/payment\/{payment}\/edit","name":"marketplace.compras.payment.edit","action":"App\Http\Controllers\PagoCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/payment\/{payment}","name":"marketplace.compras.payment.update","action":"App\Http\Controllers\PagoCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/confirm\/{confirm}\/edit","name":"marketplace.compras.confirm.edit","action":"App\Http\Controllers\ConfirmarCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/confirm\/{confirm}","name":"marketplace.compras.confirm.update","action":"App\Http\Controllers\ConfirmarCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/{purchase}\/create","name":"marketplace.compras.offer.create","action":"App\Http\Controllers\CompraController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/success\/{purchase}","name":"marketplace.compras.success","action":"App\Http\Controllers\ConfirmarCompraController@success"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/validvoucher\/{purchase}","name":"marketplace.compras.validvoucher","action":"App\Http\Controllers\CompraController@validVoucher"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras","name":"marketplace.compras.index","action":"App\Http\Controllers\CompraController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/create","name":"marketplace.compras.create","action":"App\Http\Controllers\CompraController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras","name":"marketplace.compras.store","action":"App\Http\Controllers\CompraController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/{compras}","name":"marketplace.compras.show","action":"App\Http\Controllers\CompraController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/{compras}","name":"marketplace.compras.update","action":"App\Http\Controllers\CompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}","name":"marketplace.tab","action":"App\Http\Controllers\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace","name":"marketplace.index","action":"App\Http\Controllers\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/create","name":"marketplace.create","action":"App\Http\Controllers\ProductoController@create"},{"host":null,"methods":["POST"],"uri":"marketplace","name":"marketplace.store","action":"App\Http\Controllers\ProductoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{marketplace}","name":"marketplace.show","action":"App\Http\Controllers\ProductoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/{marketplace}","name":"marketplace.update","action":"App\Http\Controllers\ProductoController@update"},{"host":null,"methods":["DELETE"],"uri":"marketplace\/{marketplace}","name":"marketplace.destroy","action":"App\Http\Controllers\ProductoController@destroy"},{"host":null,"methods":["PATCH"],"uri":"evaluacion\/categoria\/{entity}","name":"evaluacion.categoria","action":"App\Http\Controllers\EvaluacionEmprendimientoController@entity"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion\/terminos\/{assignment}","name":"evaluacion.terminos","action":"App\Http\Controllers\EvaluacionEmprendimientoController@terminos"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion","name":"evaluacion.index","action":"App\Http\Controllers\EvaluacionEmprendimientoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.show","action":"App\Http\Controllers\EvaluacionEmprendimientoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.update","action":"App\Http\Controllers\EvaluacionEmprendimientoController@update"},{"host":null,"methods":["DELETE"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.destroy","action":"App\Http\Controllers\EvaluacionEmprendimientoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/producto","name":"adjunto.producto.index","action":"App\Http\Controllers\AdjuntoProductoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/producto\/{producto}","name":"adjunto.producto.update","action":"App\Http\Controllers\AdjuntoProductoController@update"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/producto\/{producto}","name":"adjunto.producto.destroy","action":"App\Http\Controllers\AdjuntoProductoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/usuario","name":"adjunto.usuario.index","action":"App\Http\Controllers\AdjuntoUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/usuario","name":"adjunto.usuario.store","action":"App\Http\Controllers\AdjuntoUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/usuario\/{usuario}","name":"adjunto.usuario.update","action":"App\Http\Controllers\AdjuntoUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/usuario\/{usuario}","name":"adjunto.usuario.destroy","action":"App\Http\Controllers\AdjuntoUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/asesoria","name":"adjunto.asesoria.index","action":"App\Http\Controllers\AdjuntoAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/asesoria","name":"adjunto.asesoria.store","action":"App\Http\Controllers\AdjuntoAsesoriaController@store"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/asesoria\/{asesoria}","name":"adjunto.asesoria.destroy","action":"App\Http\Controllers\AdjuntoAsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/encuesta","name":"adjunto.encuesta.index","action":"App\Http\Controllers\AdjuntoEncuestaController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/encuesta","name":"adjunto.encuesta.store","action":"App\Http\Controllers\AdjuntoEncuestaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/entregable","name":"adjunto.entregable.index","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/entregable","name":"adjunto.entregable.store","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/evaluacion","name":"adjunto.evaluacion.index","action":"App\Http\Controllers\AdjuntoEvaluacionController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/evaluacion","name":"adjunto.evaluacion.store","action":"App\Http\Controllers\AdjuntoEvaluacionController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/evaluacion\/{evaluacion}","name":"adjunto.evaluacion.update","action":"App\Http\Controllers\AdjuntoEvaluacionController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto","name":"adjunto.index","action":"App\Http\Controllers\AdjuntoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"faq\/faqconvocatoria","name":"faq.faqconvocatoria.index","action":"App\Http\Controllers\FaqConvocatoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"faq","name":"faq.index","action":"App\Http\Controllers\PreguntaFrecuenteController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/register","name":"encuesta.register","action":"App\Http\Controllers\EncuestaController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/aplicar\/{encuesta}\/{usuario?}","name":"encuesta.aplicar","action":"App\Http\Controllers\EncuestaController@aplicar"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/responder\/{encuesta}","name":"encuesta.responder","action":"App\Http\Controllers\EncuestaController@responder"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/revision\/{encuesta}\/{usuario}","name":"encuesta.revision","action":"App\Http\Controllers\EncuestaController@revision"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/cancelar\/{encuesta}","name":"encuesta.cancelar","action":"App\Http\Controllers\EncuestaController@cancelar"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/informe","name":"encuesta.informe","action":"App\Http\Controllers\EncuestaController@informe"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta","name":"encuesta.index","action":"App\Http\Controllers\EncuestaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/{encuesta}","name":"encuesta.show","action":"App\Http\Controllers\EncuestaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"encuesta\/{encuesta}","name":"encuesta.update","action":"App\Http\Controllers\EncuestaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"messaging","name":"messaging.index","action":"App\Http\Controllers\MessagingController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"precios","name":"precios","action":"App\Http\Controllers\PaymentsController@pricing"},{"host":null,"methods":["GET","HEAD"],"uri":"reserva","name":"reserva","action":"App\Http\Controllers\PaymentsController@reserve"},{"host":null,"methods":["GET","HEAD"],"uri":"comprar","name":"comprar.index","action":"App\Http\Controllers\PaymentsController@index"},{"host":null,"methods":["POST"],"uri":"comprar","name":"comprar.store","action":"App\Http\Controllers\PaymentsController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"voto\/confirmar\/{srcparams}\/{user}","name":"voto.confirmar","action":"App\Http\Controllers\VotoController@confirmVote"},{"host":null,"methods":["POST"],"uri":"voto\/voto","name":"voto.voto.store","action":"App\Http\Controllers\VotoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"voto\/verify\/{vote}","name":"voto.verify","action":"App\Http\Controllers\VotoController@verify"},{"host":null,"methods":["GET","HEAD"],"uri":"recomendacion","name":"recomendacion.index","action":"App\Http\Controllers\RecomendacionController@index"},{"host":null,"methods":["POST"],"uri":"recomendacion","name":"recomendacion.store","action":"App\Http\Controllers\RecomendacionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"search","name":"search.index","action":"App\Http\Controllers\SearchController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"live","name":"live.index","action":"App\Http\Controllers\LiveController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"enlaconversa","name":"enlaconversa.index","action":"App\Http\Controllers\EnLaConversaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"laconversa","name":"laconversa","action":"App\Http\Controllers\EnLaConversaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"notificaciones","name":"notificaciones.index","action":"App\Http\Controllers\NotificacionesController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"notificaciones\/{notificaciones}","name":"notificaciones.update","action":"App\Http\Controllers\NotificacionesController@update"},{"host":null,"methods":["DELETE"],"uri":"notificaciones\/{notificaciones}","name":"notificaciones.destroy","action":"App\Http\Controllers\NotificacionesController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"caracteristicas","name":"caracteristicas.index","action":"App\Http\Controllers\CaracteristicasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"caracteristicas\/{caracteristicas}","name":"caracteristicas.show","action":"App\Http\Controllers\CaracteristicasController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"breadcrumb","name":"breadcrumb","action":"App\Http\Controllers\HomeController@breadcrumb"},{"host":null,"methods":["GET","HEAD"],"uri":"terminos","name":"terminos","action":"App\Http\Controllers\HomeController@terminos"},{"host":null,"methods":["GET","HEAD"],"uri":"privacidad","name":"privacidad","action":"App\Http\Controllers\HomeController@privacidad"},{"host":null,"methods":["GET","HEAD"],"uri":"politicaventas","name":"politicaventas","action":"App\Http\Controllers\HomeController@politicaventas"},{"host":null,"methods":["GET","HEAD"],"uri":"terminos-mentoria","name":"terminos-mentoria","action":"App\Http\Controllers\HomeController@terminosmentoria"},{"host":null,"methods":["GET","HEAD"],"uri":"entidad","name":"entidad.index","action":"App\Http\Controllers\EntidadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/confirmar","name":"step.confirmar","action":"App\Http\Controllers\UsuarioController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/perfil","name":"step.perfil","action":"App\Http\Controllers\UsuarioController@confirmprofile"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/canales","name":"step.canales","action":"App\Http\Controllers\UsuarioController@channelschoice"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/entidad","name":"step.entidad","action":"App\Http\Controllers\UsuarioController@createentity"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/terminos","name":"step.terminos.index","action":"App\Http\Controllers\TerminosController@index"},{"host":null,"methods":["POST"],"uri":"step\/terminos","name":"step.terminos.store","action":"App\Http\Controllers\TerminosController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/politicaventas","name":"step.politicaventas.index","action":"App\Http\Controllers\PoliticaVentasController@index"},{"host":null,"methods":["POST"],"uri":"step\/politicaventas","name":"step.politicaventas.store","action":"App\Http\Controllers\PoliticaVentasController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso","name":"step.compromiso.index","action":"App\Http\Controllers\CartaCompromisoController@index"},{"host":null,"methods":["POST"],"uri":"step\/compromiso","name":"step.compromiso.store","action":"App\Http\Controllers\CartaCompromisoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso\/{compromiso}","name":"step.compromiso.show","action":"App\Http\Controllers\CartaCompromisoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso\/{compromiso}\/edit","name":"step.compromiso.edit","action":"App\Http\Controllers\CartaCompromisoController@edit"},{"host":null,"methods":["GET","HEAD"],"uri":"ayuda","name":"ayuda.index","action":"App\Http\Controllers\AyudaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"{category}\/{slug}","name":"landingpage","action":"App\Http\Controllers\HomeController@landing"},{"host":null,"methods":["GET","HEAD"],"uri":"{slug}","name":"landing","action":"App\Http\Controllers\HomeController@show"},{"host":null,"methods":["POST"],"uri":"api\/login","name":"api.","action":"App\Http\Controllers\Api\Security\AuthController@authenticate"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/convocatoria\/informe\/{informe}","name":"api.convocatoria.informe.show","action":"App\Http\Controllers\Api\Convocatoria\InformeController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/comunidad","name":"api.comunidad.index","action":"App\Http\Controllers\Api\ComunidadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/curso","name":"api.curso.index","action":"App\Http\Controllers\Api\CursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/blog","name":"api.blog.index","action":"App\Http\Controllers\Api\BlogController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/evento","name":"api.evento.index","action":"App\Http\Controllers\Api\EventoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/foro","name":"api.foro.index","action":"App\Http\Controllers\Api\ForoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/foro\/{foro}","name":"api.foro.show","action":"App\Http\Controllers\Api\ForoController@show"},{"host":null,"methods":["POST"],"uri":"api\/voto\/resend","name":"api.voto.resend","action":"App\Http\Controllers\Api\Voto\VotoController@resend"},{"host":null,"methods":["POST"],"uri":"api\/voto\/verifycode","name":"api.voto.verifycode","action":"App\Http\Controllers\Api\Voto\VotoController@verifycode"},{"host":null,"methods":["POST"],"uri":"api\/user","name":"api.user.store","action":"App\Http\Controllers\Api\User\UserController@store"},{"host":null,"methods":["POST"],"uri":"api\/voto","name":"api.voto.store","action":"App\Http\Controllers\Api\Voto\VotoController@store"}],
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

            getPhases: {
		        'general': 1,
		        'one_challenge': 134,
		        'two_challenge': 137,
		        'three_challenge': 138,
		        'four_challenge': 139,
				'challenge_1.2': 150,
				'empodera2020_two':250,
                'aldea_20__challenge_1_3': 255
		    },

		    getProgram: {
				'invitation_entrepreneurs': 113,
				'empodera': 198,
				'empodera2020': 471 ,
                'specialized_service_advisors': 185,
		        'club_best': 115,
		        'award_innova': 121,
				'participants_only': 122,
				'register': 196,
                'reg_mentores_provedores': 350,
                'reg_entidades_provedores': 351
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
                'cenisoft': 46,
                'compensar': 30
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
                'stars': 3,
                'upload': 4
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
            if( this.$('.widget-login-recaptcha').length && !this.$('.widget-vote-recaptcha').length && !window.Misc.checkSession(false) )
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

            // Google recaptcha vote

            if ( this.$('.widget-vote-recaptcha').length ) {
                var widgetGRecaptchaVote = this.$('.widget-vote-recaptcha')[0];
                setTimeout(function() {
                    grecaptcha.render(widgetGRecaptchaVote, {
                        'sitekey' : $(widgetGRecaptchaVote).data('key-recaptcha'),
                        'callback' : this.onVote,
                        'error-callback': this.onError
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
        },

        /**
         * Error
         */
        onError: function() {
            console.log('On error');
        },

        /**
         * Send vote
         */
        onVote: function(token) {
            // Google recaptcha
            this.$('#form-user-vote').submit();
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
            'codigo_especialidad_destacada': 0,
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
            'descripcion_adicional_usuario': '',
            'stage_mentoring': 0,
            'aceptacion_terminos':false
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
            'codigo_tipo_asesoria': null,
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
            'porcentaje_progreso': 0,
            'certificado_curso': false
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

(function (window, document, undefined) {

     app.MentoringEvaluationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.evaluacion.sesion.index') );
        },
        idAttribute: 'codigo_evaluacion_mentoria',
        defaults: {
            'codigo_mentoria' : '',
            'comentario__evaluacion_mentoria': ''
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
* Class ProjectTeamModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.ProjectTeamModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.equipo.index') );
        },
        idAttribute: 'seg_codigo_usuario',
        defaults: {
            'codigo_usuario': 0,
            'codigo_rol_usuario_grupo_insti': 0,
            'administracion_grupo_usuario': false,
            'fecha_hora_grupo_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_rol_usuario_grupo': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'owner': false,
            'ownerlist':false,
            'nickname_usuario': '',
            'statejoin': ''  
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
* Class MentorModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.MentorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.mentores.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            'nombre_usuario': '',
            'id_usuario': 0,
            'codigo_persona': 0,
            'experiencia_usuario': '',
            'forma_ayuda_mentoria': '',
            'descripcion_adicional_usuario': '',
            'nombre_especialidad': '',
            'codigo_especialidad': 0,
            'codigo_especialidad_destacada': 0,
            'imagen_usuario': '',
            'nickname_usuario': '',
            'url_profile': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'institucion': '',
            'owner': false,
            'aceptacion_terminos':false,
            'specialties': []
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
* Class MentoringTaskModel extend of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTagsModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tags.index') );
        },
        idAttribute: 'codigo_tag_sesion_mentoria',
        defaults: {
            'codigo_mentoria': 0,
            'nombre_tag_sesion_mentoria': '',
            'valor_tag_sesion_mentoria': '',
            'mentor': false,
            'item': 0
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
            var err = new Error();
            if( ! attrs.nombre_tag_sesion_mentoria.length && attrs.valor_tag_sesion_mentoria.length){
                err.message = "No existen tags.";
                return err;
            }
        }
    });

})(this, this.document);

/**
* Class MentoringTaskModel extend of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTaskModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tarea.index') );
        },
        idAttribute: 'codigo_tarea_mentoria',
        defaults: {
            'codigo_mentoria': 0,
            'descripcion_tarea_mentoria': '',
            'mentor': false,
            'item': 0
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
            var err = new Error();
            if( ! attrs.descripcion_tarea_mentoria.length ){
                err.message = "No hay tareas.";
                return err;
            }
        }
    });

})(this, this.document);

/**
* Class MentoringCalificationTaskModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringCalificationTaskModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.calificacion.tarea.index') );
        },
        idAttribute: 'codigo_calificacion_tarea',
        defaults: {
        	'codigo_tarea_mentoria': 0,
            'codigo_usuario': 0,
            'calificacion_tarea calificacion': '',
            'cumplimiento_tarea': ''
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
        }
    });

})(this, this.document);

/**
* Class MentoringItemModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringProcess = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.mentores.procesos.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            //
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
            var err = new Error();
            if( ! attrs.nombre_item_general_mentoria.length ){
                err.message = "No hay items.";
                return err;
            }
        }
    });

})(this, this.document);

/**
* Class MentoringItemModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringItemModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.item.index') );
        },
        idAttribute: 'codigo_item_general_mentoria',
        defaults: {
            'nombre_item_general_mentoria': '',
            'descripcion_item_general_mentoria': ''
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
            var err = new Error();
            if( ! attrs.nombre_item_general_mentoria.length ){
                err.message = "No hay items.";
                return err;
            }
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
* Class MentoringModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.MentoringSessionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sessiones.index') );
        },
        idAttribute: 'codigo_mentoria',
        defaults: {
            owner: false
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
* Class MarketPlaceModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MarketPlaceModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.index') );
        },
        idAttribute: 'codigo_producto',
        defaults: {
            'url_producto': '',
            'id_producto': 0,
            'codigo_clase_producto': 0,
            'nombre_producto': '',
            'descripcion_producto': '',
            'purchase':'',
            'precio_producto': 0,
            'codigo_iva_producto': 0,
            'imagen_producto': '',
            'privacidad_producto': '',
            'nombre_privacidad_producto': '',
            'nombre_categoria_producto': '',
            'codigo_categoria_prod_insti': 0,
            'valor_iva_producto': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_ciudad': '',
            'rol_usuario_institucion': 0,
            'profesion_usuario': '',
            'state_product': 0,
            'resumen_producto': '',
            'nombre_clase_producto': '',
            'puntos_producto': 0,
            'cantidad_producto': 0,
            'codigo_clase_producto': 0,
            'manejo_unidades': false,
            'owner': false,
            'producto_sin_precio':false,
            'averagepurchase': [],
            'srcparams': '',
            'contador_like': 0,
            'nombre_pais': '',
            'url_profile': '',
            'seg_codigo_usuario': 0,
            'nombre_entidad': '',
            'nickname_entidad': '',
            'avg_purchase_user': 0,
            'message_categorias_marketplace': false,
			'modalidad_prestacion_servicio': '',
            'modalidad_texto': '',
            'descuento': 0,
            'porcentaje_descuento': ''
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
* Class MarketPlaceAgreementModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MarketPlaceAgreementModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.ventas.acuerdo.index') );
        },
        idAttribute: 'codigo_acuerdo_compra',
        defaults: {
            'alcance_acuerdo_compra': '',
            'resultados_acuerdo_compra': '',
            'actividad_acuerdo': [],
            'asesor_acuerdo': [],
            'entregable_acuerdo': [],
            'codigo_compra': null,
            'comprador': false,
            'codigo_estado': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
           //
        }
    });

})(this, this.document);

/**
* Class PurchaseModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PurchaseModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.compras.index') );
        },
        idAttribute: 'codigo_compra',
        defaults: {
        	'valor_total_compra' : 0,
            'valor_total_iva' : 0,
            'valor_total_puntos': 0,
            'fecha_compra' : '',
        	'hora_compra' : '',
            'nickname_usuario': '',
            'nombre_usuario': '',
            'imagen_usuario': '',
            'telefono_usuario': 0,
            'movil_usuario': 0,
            'correo_electronico': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'id': 0,
            'state_purchase': '',
            'nombre_tipo_pago': '',
            'nombre_tipo_envio': '',
            'unidad_producto': 0,
            'imagen_producto': '',
            'url_producto': 0,
            'nombre_producto': '',
            'resumen_producto': '',
            'evaluation_purchase': false,
            'url_profile': '',
            'nombre_entidad': '',
            'imagen_entidad': '',
            'codigo_usuario_entidad': '',
            'codigo_adjunto': '',
            'codigo_adjunto_informe_final': '',
            'nombre_adjunto_informe_final': '',
            'direccion_adjunto_informe_final': '',
            'codigo_adjunto_certificate': '',
            'nombre_adjunto_certificate': '',
            'direccion_adjunto_certificate': '',
            'codigo_acuerdo_compra_decrypt': '',
        }
    });

})(this, this.document);

/**
* Class MentorEntrepreneurModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.MentorEntrepreneurModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.mentoremprendimiento.index') );
        },
        defaults: {
            'codigo_proyecto': 0,
            'codigo_usuario': 0
            
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
* Class UserReasonModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserReasonModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.razones.index') );
        },
        idAttribute: 'codigo_razon_registro',
        defaults: {
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_razon_registro': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

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
* Class UserEducationModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserEducationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.educaciones.index') );
        },
        idAttribute: 'codigo_nivel_educacion_usuario',
        defaults: {
            'codigo_nivel_educacion': 0,
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_nivel_educacion': '',
            'disciplina': ''

        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

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
* Class UserSpecialityModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserSpecialityModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.especialidades.index') );
        },
        idAttribute: 'codigo_especialidad',
        defaults: {
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_especialidad': '',
            'descripcion_especialidad': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

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
* Class UserInterestModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserInterestModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.intereses.index') );
        },
        idAttribute: 'codigo_sector_interes',
        defaults: {
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_sector_interes': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

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
* Class UserNetworkModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserNetworkModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.redusuario.index') );
        },
        idAttribute: 'seg_codigo_usuario',
        defaults: {
            'state_friendship': '',
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'profesion_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'rol_usuario_institucion': '',
            'owner': false
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        }
    });

})(this, this.document);

/**
* Class DiscussionCommentModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionCommentModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('discusion.comentario.index') );
        },
        idAttribute: 'codigo_comentario',
        defaults: {
            'codigo_discucion': 0,
            'texto_comentario': '',
            'imagen_usuario': '',
            'nickname_usuario': '',
            'contador_like': 0,            
            'fecha_comentario': '',
            'hora_comentario': '',
            'srcparams': '',
            'nombre_usuario': '',
            'owner': false,
            'id_comentario': 0,
            'url_profile': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        },
    });

})(this, this.document);

/**
* Class UserNoteModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserNoteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.notausuario.index') );
        },
        idAttribute: 'codigo_nota_usuario',
        defaults: {
            'codigo_estado': 0,
            'texto_nota_usuario': '',
            'codigo_usuario': '',
            'codigo_curso': '',
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': ''
        }
    });

})(this, this.document);
/**
* Class AttachmentModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	app.AttachmentModel = Backbone.Model.extend({

		// urlRoot: function () {
		//     return window.Misc.urlFull( Route.route('adjunto.index') );
		// },
		idAttribute: 'codigo_adjunto',
		defaults: {
			'codigo_adjunto': null,
			'direccion_adjunto': '',
			'owner': false
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
			var err = new Error();

			// if( ! attrs.direccion_adjunto.length ){
			//     err.message = "No hay items.";
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
		}
	});

})(this, this.document);

/**
* Class EvaluationPurchaseModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.EvaluationPurchaseModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.evaluacion.index') );
        },
        idAttribute: 'codigo_evaluacion_compra',
        defaults: {
            'codigo_compra' : '',
            'cometario_evaluacion_compra': ''
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
* Class FaqModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FaqModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('faq.index') );
        },
        idAttribute: 'codigo_preguntas_frecuentes',
        defaults: {
            'codigo_estado': 0,
            'texto_preguntas_frecuentes': '',
            'respuesta_preguntas_frecuentes': ''
        }
    });

})(this, this.document);
/**
* Class ProjectInterestModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectInterestModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.intereses.index') );
        },
        idAttribute: 'codigo_sector_interes',
        defaults: {
            'codigo_proyecto': 0,
            'codigo_estado': 0,
            'nombre_sector_interes': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

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
* Class ProjectSponsorModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.ProjectSponsorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.patrocinador.index') );
        },
        idAttribute: 'codigo_patrocinador',
        defaults: {
            'codigo_entidad': 0,
            'nombre_patrocinador': '',
            'imagen_patrocinador': '',
            'url_patrocinador': '',
            'owner': false     
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
* Class GroupModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.GroupModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('grupo.index') );
        },
        idAttribute: 'codigo_entidad',
        defaults: {
            'id_entidad': 0,
            'nombre_usuario': '',
            'biografia_usuario': '',
            'descripcion_entidad': null,
            'codigo_etapa_proyecto': 0,
            'codigo_categoria_proyecto': 0,
            'codigo_clase_emprendimiento': 0,
            'codigo_ciudad': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'codigo_privacidad_contenido': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_institucion': '',
            'slug_institucion': '',
            'background_body': null,
            'tags': null,
            'video_entidad': null,
            'facebook_usuario': null,
            'twitter_usuario': null,
            'linkedin_usuario': null,
            'pagina_web_usuario': null,
            'contador_comentario': 0,
            'contador_like': 0,
            'srcparams': '',
            'updated_at': '', 
            'nombre_clase_emprendimiento': '', 
            'identificacion_usuario': '', 
            'codigo_categoria_clase_espacio': 0, 
            'owner': false,
            'codigo_usuario': 0,
            'nombre_privacidad_contenido': '',
            'icono_privacidad_contenido':'',
            'nombre_categoria_proyecto': '',
            'orientacion_clase_espacio':0,
            'statejoin': '',
            'nombre_categoria_clase_espacio': ''

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
* Class GroupProjectModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.GroupProjectModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('grupo.equipo.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            'codigo_proyecto': 0,
            'statejoin': ''
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
* Class GroupClusterModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GroupClusterModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('grupo.cluster.index') );
        },
        idAttribute: 'codigo_proyecto',
        defaults: {
            'cor_codigo_proyecto': 0,
            'codigo_estado': 0,
            'statejoin': ''
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
* Class NotificationModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina & @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
window.app || (window.app = {});

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery', 'underscore', 'backbone'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		exports = module.exports = factory(require('jquery'), require('underscore'), require('backbone'));
	} else {
		// Browser globals
		factory(jQuery, window._, window.Backbone);
	}
}(function ($, _, Backbone) {

	window.app.NotificationModel = Backbone.Model.extend({

		urlRoot: function () {
		    return window.Misc.urlFull( Route.route('notificaciones.index') );
		},
		idAttribute: '_id',
		defaults: {
		    'title': '',
		    'content': '',
		    'image': '',
		    'created': ''
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

	return window.app.NotificationModel;
}));

/**
* Class PersonEconomicSectorModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PersonEconomicSectorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.economicos.index') );
        },
        idAttribute: 'codigo_sector_economico',
        defaults: {
            'codigo_persona': 0,
            'codigo_estado': 0,
            'nombre_sector_economico': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

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
* Class RecommendationModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.RecommendationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('recomendacion.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            // 
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
* Class MentorEvaluationModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentorEvaluationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.preguntas.evaluacion.mentor.index') );
        },
        idAttribute: 'codigo_evaluacion_mentor',
        defaults: {
            // 
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
        }
    });

})(this, this.document);

/**
* Class DiscussionModel extends of Backbone Model/BaseModel
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionModel = app.BaseModel.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('discusion.index') );
        },
        idAttribute: 'codigo_discucion',
        defaults: {
            'id_discucion': 0,
            'codigo_estado': 0,
            'texto_discucion': '',
            'codigo_modulo': 0,
            'contador_comentarios_discucion': 0,
            'contador_like': 0,
            'codigo_usuario': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'fecha_discusion': '',
            'srcparams': '',
            'url_profile': '',
            'url_discusion': '',
            'origin': '',
            'owner': false
        }
    });

})(this, this.document);

/**
* Class DiscussionParticipantModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionParticipantModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('discusion.participantes.index') );
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
* Class ProjectEvaluationModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/


//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	 app.ProjectEvaluationModel = app.ProjectModel.extend({

		urlRoot: function () {
			return window.Misc.urlFull( Route.route('evaluacion.index') );
		},
		idAttribute: 'url_asignacion_jurado',
		defaults: {
			'id_proyecto': 0,
			'codigo_usuario': 0,
			'fecha_asignacion_jurado': '',
			'nombre_usuario': '',
			'url_profile': '',
			'url_fase': '',
			'imagen_usuario': '',
			'nombre_ciudad': '',
			'nombre_pais': '',
			'url_convocatoria': '',
			'nombre_convocatoria': '',
			'codigo_convocatoria': 0,
			'nombre_usuario_proyecto': '',
			'url_profile_proyecto': '',
			'biografia_usuario_proyecto': '',
			'imagen_usuario_proyecto': '',
			'nickname_usuario_proyecto': '',
			'nombre_ciudad_proyecto': '',
			'nombre_pais_proyecto': '',
			'nombre_fase': '',
			'codigo_evaluacion_emprendimiento': 0,
			'codigo_registro_fase_usuario': 0,
			'preguntas': [],
			'grupos': [],
			'evaluation': false,
			'calification': 0,
			'valor_total_evaluacion': 0,
			'category': 0
		},

		/**
		* Constructor Method
		* @param Object attrs, model attributes
		* @param Object opts, model Options
		*/
		initialize: function(attrs, opts){
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
* Class ItemEvaluationModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemEvaluationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('evaluacion.index') );
        },
        idAttribute: 'codigo_grupo_item_eval',
        defaults: {
            //
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
        }
    });

})(this, this.document);

/**
* Class EvalItemEntrepreneurModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EvalItemEntrepreneurModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('evaluacion.item.index') );
        },
        idAttribute: 'codigo_evaluacion_item',
        defaults: {
           'evaluation': false
        }
    });

})(this, this.document);
/**
* Class FavoriteModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FavoriteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('fav.index') );
        },
        idAttribute: 'codigo_favorito',
        defaults: {
            'favorito_auth': false
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
* Class OfferModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	app.OfferModel = Backbone.Model.extend({

		urlRoot: function () {
			return window.Misc.urlFull( Route.route('marketplace.compras.offer.index') );
		},
		idAttribute: 'codigo_compra',
		defaults: {
			'valor_total_compra': 0,
			'unidades': 0
		}
	});

})(this, this.document);

/**
* Class PromotionModel of Backbone Model
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PromotionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.ventas.promocion.index') );
        },
        idAttribute: 'codigo_promocion',
        defaults: {
            fecha_inicio_promocion: '',
            fecha_fin_promocion: '',
            imagen_promocion: '',
            tipo_promocion: 0,
            descripcion_promocion: '',
            codigo_usuario_institucion: 0
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
* Class PurchaseModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.VoucherModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.voucher.index') );
        },
        idAttribute: 'codigo_voucher',
        defaults: {
        	'codigo_institucion' : '',
            'codigo_usuario' : '',
            'codigo_estado': '',
            'descripcion_voucher' : '',
        	'valor_voucher' : '',
            'saldo_voucher': '',
            'fecha_voucher': '',
            'codigo_encuesta': '',
            'url_encuesta': ''

        }
    });

})(this, this.document);

/**
* Class LikeList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.LikeList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('like.index') );
        },
        model: app.LikeModel,
        
        /**
        * Constructor Method
        */
        initialize : function(){
        },
        
        /**
        * get like model by authenticated user
        */
        getModelLikeAuth: function () {
            
            return this.find(function (model) {
                return model.get('auth_like') === true;
            });
        }
   });

})(this, this.document);

/**
* Class UserLikesList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserLikesList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function () {
            return window.Misc.urlFull( Route.route('like.index') );
        },
        model: app.LikeModel,

        state: {
            firstPage: 0,
            pageSize: 20 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        },

        /**
        * get like model by authenticated user
        */
        getModelLikeAuth: function () {

            return this.find(function (model) {
                return model.get('auth_like') === true;
            });
        }
   });

})(this, this.document);

/**
* Class ProjectList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('proyecto.index') );
        },
        model: app.ProjectModel,

        state: {
            firstPage: 0,
            pageSize: 18 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class ProjectUserList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectUserList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('proyecto.index') );
        },
        model: app.ProjectModel,

        state: {
            firstPage: 0,
            pageSize: 6 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class CallList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CallList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function() {
            return window.Misc.urlFull( Route.route('convocatoria.index') );
        },
        model: app.CallModel,
        state: {
            firstPage: 0,
            pageSize: 20 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class TeamList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TeamList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function() {
            return window.Misc.urlFull( Route.route('usuario.grupos') );
        },
        model: app.TeamModel,
        state: {
            firstPage: 0,
            pageSize: 6 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class SurveysList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SurveysList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function() {
            return window.Misc.urlFull( Route.route('encuesta.index') );
        },
        model: app.SurveyModel,
        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class surveyQuestionsList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.surveyQuestionsList = Backbone.PageableCollection.extend({

        modelId: function(attrs) {
            return attrs.codigo_pregunta_encuesta;
        },
        model: function (attrs, options) {
            var newModel = Backbone.Model.extend( {idAttribute : 'codigo_pregunta_encuesta'} );

            return new newModel(attrs, options);
        },
        mode: 'client',
        url: function () {
            return window.Misc.urlFull( Route.route('encuesta.index') );
        },

        state: {
            firstPage: 1,
            pageSize: 5 //number of records to show by page
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
           Makes a Backbone.Collection that contains all the pages || override.

           @private
           @param {Array.<Object|Backbone.Model>} models
           @param {Object} options Options for Backbone.Collection constructor.
           @return {Backbone.Collection}
        */
        _makeFullCollection: function (models, options) {

          var properties = ["url", "model", "sync", "comparator", "modelId"];
          var thisProto = this.constructor.prototype;
          var i, length, prop;

          var proto = {};
          for (i = 0, length = properties.length; i < length; i++) {
            prop = properties[i];
            if (!_.isUndefined(thisProto[prop])) {
              proto[prop] = thisProto[prop];
            }
          }

          var fullCollection = new (Backbone.Collection.extend(proto))(models, options);

          for (i = 0, length = properties.length; i < length; i++) {
            prop = properties[i];
            if (this[prop] !== thisProto[prop]) {
              fullCollection[prop] = this[prop];
            }
          }

          return fullCollection;
        }

        /**
        * order by
        */
        // comparator: function(question){

        //     // ordenamos por el atributo position
        //     if( question.get('posicion') )
        //         return question.get('posicion');
        // }
   });

})(this, this.document);

/**
* Class CourseList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.CourseList = Backbone.PageableCollection.extend({
        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('aprende.curso.index') );
        },
        model: app.CourseModel,
        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },
        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },
        /**
        * Constructor Method
        */
        initialize : function(){
        },
        /**
        * order by
        */
        // comparator: function(){
        // },
        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },
        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });
})(this, this.document);

/**
* Class CourseThemeList of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('aprende.curso.tema.index') );
        },
        model: app.CourseThemeModel,
        /**
        * Constructor Method
        */
        initialize : function(){
            // 
        },

        getLecture : function (course, theme, lecture) {
            
            var lectureModel = this.find(function (model) {
                return model.get('url_tema_curso') == theme;
            });

            return _.findWhere(lectureModel.get('adjuntos'), {url_adjunto: lecture});
        }
   });

})(this, this.document);

/**
* Class CourseAttachmentsList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseAttachmentsList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('aprende.curso.adjunto.index') );
        },
        model: app.CourseAttachmentModel,

        state: {
            firstPage: 0,
            pageSize: 20 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class BlogArticlesList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BlogArticlesList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('blog.index') );
        },
        model: app.BlogArticleModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class CourseThemeAttachedList of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeAttachedList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('aprende.curso.tema.adjunto.index') );
        },
        model: app.CourseThemeAttachedModel,
        /**
        * Constructor Method
        */
        initialize : function(){
            //
        }
   });

})(this, this.document);

/**
* Class EntitiesList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EntitiesList = Backbone.Collection.extend({

        mode: 'server',
        url: function () {
            return window.Misc.urlFull( Route.route('entidad.index') );
        },
        model: app.EntityModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        	//
        }
   });

})(this, this.document);

/**
* Class EventList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EventList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function () {
            return window.Misc.urlFull( Route.route('calendario.evento.index') );
        },
        model: app.EventModel,

        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        	//
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class UsersEventList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UsersEventList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function () {
            return window.Misc.urlFull( Route.route('calendario.evento.participar.index') );
        },
        model: app.UserEventModel,

        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        	//
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class ProjectTeamList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectTeamList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('usuario.equipo.index') );
        },
        model: app.ProjectTeamModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class MostViewedArticlesList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MostViewedArticlesList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('blog.index') );
        },
        model: app.BlogArticleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);



/**
* Class MentoringQuestionList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @Krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringQuestionList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('mentoria.preguntas.index') );
        },
        model: app.AdviceModel,

        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class MentoringSessionList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringSessionList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('mentoria.sessiones.index') );
        },
        model: app.MentoringSessionModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);
/**
* Class MentoringTaskList extend of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTaskList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tarea.index') );
        },
        model: app.MentoringTaskModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MentoringTaskList extend of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTagsList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tags.index') );
        },
        model: app.MentoringTagsModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MentoringCalificationTaskList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringCalificationTaskList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.calificacion.tarea.index') );
        },
        model: app.MentoringCalificationTaskModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MentoringItemList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentorignProcessList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.mentores.procesos.index') );
        },
        model: app.MentoringProcess,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MentoringItemList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringItemList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.item.index') );
        },
        model: app.MentoringItemModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MarketPlaceList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MarketPlaceList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('marketplace.index') );
        },
        model: app.MarketPlaceModel,

        state: {
            firstPage: 0,
            pageSize: 12 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class PromotionsList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PromotionsList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('marketplace.ventas.promocion.index') );
        },
        model: app.PromotionModel,

        state: {
            firstPage: 0,
            pageSize: 12 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class projectProductList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectProductList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('marketplace.index') );
        },
        model: app.MarketPlaceModel,

        state: {
            firstPage: 0,
            pageSize: 6 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class UserReasonList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserReasonList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.razones.index') );
        },
        model: app.UserReasonModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class UserEducationList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserEducationList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.educaciones.index') );
        },
        model: app.UserEducationModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class UserSpecialitiesList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserSpecialitiesList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.especialidades.index') );
        },
        model: app.UserSpecialityModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class UserInterestsList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserInterestsList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.intereses.index') );
        },
        model: app.UserInterestModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class DiscussionsList extends of Backbone Collection
* @author TuProyecto/Copo software || Desarrollador : @krobing
* @link https://coposoftware.com
*/

// Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionList = Backbone.PageableCollection.extend({
        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('discusion.index') );
        },
        model: app.DiscussionModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class DiscussionCommentsList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	app.DiscussionCommentsList = Backbone.PageableCollection.extend({
		mode: 'server',
		url: function (){
		   return window.Misc.urlFull( Route.route('discusion.comentario.index') );
		},
		model: app.DiscussionCommentModel,

		state: {
			firstPage: 0,
			pageSize: 15 //number of records to show by page
		},

		queryParams: {
			totalPages: null,
			totalRecords: null,
			pageSize: "limit",
			currentPage: null,
			offset: function () { return this.state.currentPage * this.state.pageSize; }
		},

		/**
		* Constructor Method
		*/
		initialize : function(){
		},

		/**
		* order by
		*/
		comparator: function(){
			// ordenamos por el atributo nombre
			// return cliente.get('nombre');
		},

		/**
		* parse state of the paginator collection
		*/
		parseState: function (resp, queryParams, state, options) {
			return {totalRecords: resp.total_entries};
		},

		/**
		* Return all the posts
		* @param Object resp, response of the server
		*/
		parseRecords: function (resp) {
			return resp.items;
		}
   });

})(this, this.document);

/**
* Class UserNotesList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserNotesList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('aprende.curso.notausuario.index') );
        },
        model: app.UserNoteModel,

        state: {
            firstPage: 0,
            pageSize: 5 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class RegistrationCourseList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RegistrationCourseList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('aprende.curso.inscripcioncurso.index') );
        },
        model: app.RegistrationCourseModel,

        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class UserNetworkList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserNetworkList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('usuario.redusuario.index') );
        },
        model: app.UserNetworkModel,

        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class UsersList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UsersList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('usuario.index') );
        },
        model: app.UserModel,

        state: {
            firstPage: 0,
            pageSize: 20 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class BuysList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BuysList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('marketplace.compras.index') );
        },
        model: app.PurchaseModel,

        state: {
            firstPage: 0,
            pageSize: 10 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class AttachmentList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AttachmentList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('adjunto.producto.index') );
        },
        model: app.AttachmentModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class SalesList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SalesList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('marketplace.ventas.index') );
        },
        model: app.PurchaseModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class SaleDetailList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SaleDetailList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('marketplace.compras.detalle.index') );
        },
        model: app.PurchaseDetailModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class FaqProgramList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FaqProgramList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('faq.faqconvocatoria.index') );
        },
        model: app.FaqModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class ParticipantsProgramUserList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	app.ParticipantsProgramUserList = Backbone.PageableCollection.extend({

		mode: 'server',
		url: function (){
		   return window.Misc.urlFull( Route.route('convocatoria.usuario.index') );
		},
		model: app.CallStageUserModel,

		state: {
			firstPage: 0,
			pageSize: 50 //number of records to show by page
		},

		queryParams: {
			totalPages: null,
			totalRecords: null,
			pageSize: "limit",
			currentPage: null,
			offset: function () { return this.state.currentPage * this.state.pageSize; }
		},

		/**
		* Constructor Method
		*/
		initialize : function(){
		},

		/**
		* order by
		*/
		comparator: function(){
			// ordenamos por el atributo nombre
			// return cliente.get('nombre');
		},

		/**
		* parse state of the paginator collection
		*/
		parseState: function (resp, queryParams, state, options) {
			return {totalRecords: resp.total_entries};
		},

		/**
		* Return all the posts
		* @param Object resp, response of the server
		*/
		parseRecords: function (resp) {
			return resp.items;
		}
   });

})(this, this.document);

/**
* Class ProjectInterestsList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectInterestsList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('proyecto.intereses.index') );
        },
        model: app.ProjectInterestModel,
        
        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class ProjectSponsorList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectSponsorList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('proyecto.patrocinador.index') );
        },
        model: app.ProjectSponsorModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);


/**
* Class ProjectAttachmentList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectAttachmentList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('adjunto.usuario.index') );
        },
        model: app.AttachmentModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class GroupList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GroupList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('grupo.index') );
        },
        model: app.GroupModel,

        state: {
            firstPage: 0,
            pageSize: 12 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class GroupClusterList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xidnykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GroupClusterList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('grupo.cluster.index') );
        },
        model: app.GroupClusterModel,

        state: {
            firstPage: 0,
            pageSize: 6 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class NotificationList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
window.app || (window.app = {});

//Global App Backbone
window.app || (window.app = {});

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery', 'underscore', 'backbone'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		exports = module.exports = factory(require('jquery'), require('underscore'), require('backbone'));
	} else {
		// Browser globals
		factory(jQuery, window._, window.Backbone);
	}
}(function ($, _, Backbone) {

    window.app.NotificationList = Backbone.PageableCollection.extend({

        mode: 'server',
        modelId: function(attrs) {
            return attrs._id;
        },
        url: function (){
           return window.Misc.urlFull( Route.route('notificaciones.index') );
        },
        model: app.NotificationModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
           Makes a Backbone.Collection that contains all the pages || override.

           @private
           @param {Array.<Object|Backbone.Model>} models
           @param {Object} options Options for Backbone.Collection constructor.
           @return {Backbone.Collection}
        */
        _makeFullCollection: function (models, options) {

          var properties = ["url", "model", "sync", "comparator", "modelId"];
          var thisProto = this.constructor.prototype;
          var i, length, prop;

          var proto = {};
          for (i = 0, length = properties.length; i < length; i++) {
            prop = properties[i];
            if (!_.isUndefined(thisProto[prop])) {
              proto[prop] = thisProto[prop];
            }
          }

          var fullCollection = new (Backbone.Collection.extend(proto))(models, options);

          for (i = 0, length = properties.length; i < length; i++) {
            prop = properties[i];
            if (this[prop] !== thisProto[prop]) {
              fullCollection[prop] = this[prop];
            }
          }

          return fullCollection;
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

	return window.app.NotificationList;
}));

/**
* Class PersonEconomicSectorList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykata
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PersonEconomicSectorList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.economicos.index') );
        },
        model: app.PersonEconomicSectorModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class MentorList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentorList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('mentoria.mentores.index') );
        },
        model: app.UserModel,

        state: {
            firstPage: 0,
            pageSize: 12 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class MentorEvaluationList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentorEvaluationList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.preguntas.evaluacion.mentor.index') );
        },
        model: app.MentorEvaluationModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class DiscussionParticipantsList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionParticipantsList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('discusion.participantes.index') );
        },
        model: app.DiscussionParticipantModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
        },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

/**
* Class ProjectEvaluationList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectEvaluationList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('evaluacion.index') );
        },
        model: app.ProjectEvaluationModel,

        state: {
            firstPage: 0,
            pageSize: 20 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

})(this, this.document);

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemEvaluationList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('evaluacion.index') );
        },
        model: app.ItemEvaluationModel,

        /**
        * Constructor Method
        */
        initialize : function(){
          //
        }
   });

})(this, this.document);



/**
* Class BreadcrumbView of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.BreadcrumbView = Backbone.View.extend({

        tagName: 'ul',
        className: 'breadcrumbs',
        template: _.template( $('#breadcrumb-tp').html() ),

        /**
        * Constructor Method
        */
        initialize : function() {

            //Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template( attributes ) );
            return this;
        }
    });


})(jQuery, this, this.document);

/**
* Class MenuFilterView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MenuFilterView = Backbone.View.extend({

		el: '#side-menu-filter',
		templateMarketplace: _.template( ($('#marketplace-sidemenu-filter-tpl').html() || '') ),
		templateLearn: _.template( ($('#learn-sidemenu-filter-tpl').html() || '') ),
		templateBlog: _.template( ($('#blog-sidemenu-filter-tpl').html() || '') ),
		templateSearch: _.template( ($('#search-sidemenu-filter-tpl').html() || '') ),
        templateStageFilter: _.template( ($('#filtro-etapa-tpl').html() || '') ),
        templateEntityFilter: _.template( ($('#filtro-entidad-tpl').html() || '') ),
        templateCategoryFilter: _.template( ($('#filtro-categoria-tpl').html() || '') ),
		templatePrograms: _.template( ($('#programs-sidemenu-filter-tpl').html() || '') ),
		templateProjects: _.template( ($('#project-sidemenu-filter-tpl').html() || '') ),
		templateGroups: _.template( ($('#group-sidemenu-filter-tpl').html() || '') ),
		templateEvaluationProject: _.template( ($('#evaluation-sidemenu-filter-tpl').html() || '') ),
		events: {
            'change select.change-choice': 'onChoice',
           // 'checked input[name=hasSpouse]': 'onFields',
		},
		parameters: {
			section: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({},this.parameters, opts.parameters);

        },

		/*
		* Render View Element
		*/
		render: function(){
			// module exceptions
			if( /^aprende\//.test(this.parameters['section']) ){
				section = 'aprende';
			}else if( /^blog\//.test(this.parameters['section']) ) {
				section = 'blog';
			}else if( /^proyecto\/(empresas|proyectos|micontenido)?/.test(this.parameters['section']) ) {
				section = 'proyecto';
			}else if( /^marketplace\/(misproductos|favoritos)?/.test(this.parameters['section']) ) {
				section = 'marketplace';
			}else {
				section = this.parameters['section'];
			}
			this.switchSection( section );
            if($("#type-programs").prop("checked")){
                var filterType= $("#type-programs").val();
                this.fieldsShow(filterType);
            }



			// reload plugins
			if( typeof window.initComponent.configSticky == 'function' && _.has($.fn, 'sticky') )
				window.initComponent.configSticky();

			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();

            if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
                window.initComponent.configInputMask();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( typeof window.initComponent.configUiSlider == 'function' && noUiSlider )
                window.initComponent.configUiSlider();

            // set the position of side navigation button collapse
            $(".button-collapse").sideNav( {edge: 'left'} );


			return this;
		},

		/**
		* Switch section
		* @param section String
		*/
		switchSection: function (section) {

			section || (section = 'default');
			var _this = this;

			toSection = {
				'marketplace': function () {
					_this.switchAction('marketplace');
				},
				'aprende': function () {
					_this.switchAction('aprende');
				},
				'blog': function () {
					_this.switchAction('blog');
				},
				'search': function () {
					_this.switchAction('search');
				},
				'convocatoria': function () {
					 _this.switchAction('convocatoria');
				},
				'proyecto': function () {
					_this.switchAction('proyecto');
				},
				'grupo': function () {
					_this.switchAction('grupo');
				},
				'evaluacion': function () {
					_this.switchAction('evaluacion');
				},
				'default' : function() {
					//
				}
			};

			if (toSection[section]) {
				toSection[section]();
			} else {
				toSection['default']();
			}
		},


        /**
         * change options on selects
         */
        onChoice: function (e) {

            var $formFilter = $(e.currentTarget).closest('form');

            //console.log(e);
            $formFilter.submit();
        },


        // Render section identification type and number
        fieldsShow: function (param) {
            // console.log(param);
            var attributes = {
                type: '',
                category: ''
            };

            _.extend(attributes, this.parameters.dataFilter);

            var stageFilter= this.$el.find('#filtro-etapa');
            var categoryFilter= this.$el.find('#filtro-categoria');
            var entityFilter= this.$el.find('#filtro-entidad');

            // render stage sub filter on this selected options
            $includeStageFilter = ['program','mentor'];

            // render category sub filter on this selected options
            $includeCategoryFilter = ['program'];

            // render entity sub filter on this selected options
            $includeEntityFilter = ['program'];

            if( _.contains($includeStageFilter, param) ){

                stageFilter.html( this.templateStageFilter(attributes) );

            }else{
                $('#filtro-etapa-section').remove();
            }

            if( _.contains($includeCategoryFilter, param) ){

               categoryFilter.html( this.templateCategoryFilter(attributes) );

            }else{
                $('#filtro-category-section').remove();
            }

            if( _.contains($includeEntityFilter, param) ){

                entityFilter.html( this.templateEntityFilter(attributes) );

            }else{
                $('#filtro-entidad-section').remove();
            }

        },

		/**
		* Switch action
		* @param action String
		*/
		switchAction: function (action) {

			action || (action = 'default');

			var _this = this;

			var toRenderView = {
				'marketplace' : function() {
					var attributes = {
						type : '',
						category: '',
						class_product: '',
						name: '',
						provider: '',
						modality: '',
                        stage:'',
                        entity:''
					};

					_.extend(attributes, _this.parameters.dataFilter);

					_this.$el.html( _this.templateMarketplace(attributes) );
				},
				'aprende' : function(){

					var attributes = {
						type : _.isString(_this.parameters.params[0]) ? _this.parameters.params[0] : 'cursos',
						category: _.isString(_this.parameters.params[1]) ? _this.parameters.params[1] : ''
					};

					_.extend(attributes, _this.parameters.dataFilter);

					_this.$el.html( _this.templateLearn(attributes) );

				},
				'blog': function () {

					var attributes = {
						category: _.isString(_this.parameters.params[0]) ? _this.parameters.params[0] : '',
						article: _.isString(_this.parameters.params[1]) ? _this.parameters.params[1] : ''
					};

					_.extend(attributes, _this.parameters.dataFilter);

					_this.$el.html( _this.templateBlog(attributes) );
				},
				'search': function () {
					var attributes = {
						search: '',
						type: '',
                        stage:'',
                        entity:''
					};

					_.extend(attributes, _this.parameters.dataFilter);


					_this.$el.html( _this.templateSearch(attributes) );
                   var filterType= 	$('input[name=type]').val();
                    _this.fieldsShow(filterType);

				},
				'convocatoria': function () {
					var attributes = {
						type: '',
						category: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templatePrograms(attributes) );
				},
				'proyecto' : function() {
					var attributes = {
						type : '',
						category: '',
						grade: '',
						name: '',
						identification: '',
						dataFilter: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templateProjects(attributes) );
				},
				'grupo' : function() {
					var attributes = {
						type : '',
						category: '',
						grade: '',
						dataFilter: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templateGroups(attributes) );
				},
				evaluacion: function () {
					var attributes = {
						state: '',
						industry: '',
						program: '',
						entrepreneurship: '',
						code: '',
						dataFilter: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templateEvaluationProject(attributes) );
				},
				'default' : function() {
					//
				}
			};



			if (toRenderView[action]) {
				toRenderView[action]();
			} else {
				toRenderView['default']();
			}
		}
	});


})(jQuery, this, this.document);

/**
* Class Paginator extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.Paginator = Backbone.View.extend({

		tagName: 'ul' ,
		className: 'pagination',
		template: _.template( ($('#pagination-tpl').html() || '') ),
		maxLen: 8,
		events: {
			'click .arrow.start-page a': 'onStartPage',
			'click .arrow.end-page a': 'onEndPage',
			'click .arrow.prev-page a': 'onPrevPage',
			'click .arrow.next-page a': 'onNextPage',
			'click li:not(.arrow) a': 'onGetPage'
		},
		parameters: {
			nameForm: '',
			data: {},
            queryParams:{}
		},

		/**
		* Constructor Method
		*/
		initialize: function(opts){
			_.bindAll(this, 'onReasignLen');

			// extend view parameters
            if( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

			if( ! this.collection instanceof Backbone.PageableCollection ) {
                return;
            }

			//Init Attributes
			this.$formFilter = this.parameters['nameForm'];

			// Events Listener
			this.listenTo( this.collection, 'reset', this.render );
            this.listenTo( this.collection, 'change', this.updatedState );

			// handler with resize window event
			this.onReasignLen();
			$(window).off('resize load', this.onReasignLen);
			$(window).on('resize load', this.onReasignLen);
		},


		/*
		* Render View Element
		*/
		render: function () {

			var items = this.buildItems();
			var attributes = { items: items };
			this.$el.html( this.template(attributes) );

			this.$el.find('li.arrow').removeClass('unavailable')
									 .addClass('waves-effect')
									 .find('a').removeClass('disabled');

			if( this.collection.state.firstPage == this.collection.state.currentPage ){
				this.$el.find('li.arrow.prev-page, li.arrow.start-page').addClass('unavailable disabled')
														.removeClass('waves-effect')
													.find('a').addClass('disabled');
			}
			if( this.collection.state.lastPage == this.collection.state.currentPage ){
				this.$el.find('li.arrow.next-page, li.arrow.end-page').addClass('unavailable disabled')
														.removeClass('waves-effect')
												   .find('a').addClass('disabled');
			}

			return this;
		},

		/**
		* to calculate split on pagination
		*/
		calSplit: function (start) {

			var splitAt = [],
				len = this.collection.state.totalPages,
				maxLen1_2 = Math.floor(this.maxLen/2),
				startPag = 0;
				maxLen1_2End = len - maxLen1_2;

			splitAt[0] = maxLen1_2;
			startPag = this.collection.state.currentPage - maxLen1_2 > 0 ? this.collection.state.currentPage - maxLen1_2 : this.collection.state.firstPage;

			if( this.collection.state.currentPage >= maxLen1_2 ){
				splitAt[0] = this.collection.state.currentPage + 1;
			}
			splitAt[1] = maxLen1_2End;

			return {
				'startPag': startPag,
				'splitAt': splitAt
			};
		},

		/**
		* build pagination items object
		*/
		buildItems: function () {
			var items = new Array(),
				startPag = 0,
				splitAt = [0,0],
				flagHellip = true;

			confPagination = this.calSplit();
			startPag = confPagination.startPag;
			splitAt = confPagination.splitAt;

			for (var i=startPag, len=this.collection.state.lastPage; i <= len; i++) {

				if( i > splitAt[0] && i <= splitAt[1] ){

					if( flagHellip ){
						items.push({
							indx: '',
							title: '...',
							classes: 'unavailable'
						});
						flagHellip = false;
					}
					continue;
				}

				items.push({
					indx: i,
					title: this.collection.state.firstPage > 0 ? i : i+1,
					classes: this.collection.state.currentPage == i ? 'current active' : ''
				});
			}

			return items;
		},

		/**
		* re asign length for mobile resolution
		*/
		onReasignLen: function (e) {

			// if browser window is least 1024px
			if( $(window).width() <= 480 ) {
				this.maxLen = 4;
			}else if( $(window).width() <= 640 ) {
				this.maxLen = 6;
			} else {
				this.maxLen = 8;
			}

			// reload pagination
			this.render();
		},

		/**
		* event to fetch start page
		*/
		onStartPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

            var parametersDataFilter = this.filterData();

			this.collection.getFirstPage({reset:true, data: _.omit(parametersDataFilter, function(value, key, object) {
                return _.isEmpty(value);
            })});
            this.updatedState();
		},

		/**
		* event to fetch end page
		*/
		onEndPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

            var parametersDataFilter = this.filterData();

			this.collection.getLastPage({reset:true, data: _.omit(parametersDataFilter, function(value, key, object) {
                return _.isEmpty(value);
            })});
            this.updatedState();
		},

		/**
		* event to fetch the previous page
		*/
		onPrevPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

			var _this = this,
                parametersDataFilter = this.filterData();

			if(this.collection.state.currentPage > this.collection.state.firstPage){
				this.collection.getPreviousPage({reset:true, data:  _.omit(parametersDataFilter, function(value, key, object) {
                    return _.isEmpty(value);
                })});
                this.updatedState();
			}
		},

		/**
		* event to fetch the next page
		*/
		onNextPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

			var _this = this,
                parametersDataFilter = this.filterData();

			if(this.collection.state.currentPage < this.collection.state.lastPage){
				this.collection.getNextPage({reset:true, data: _.omit(parametersDataFilter, function(value, key, object) {
                    return _.isEmpty(value);
                })});
                this.updatedState();
			}
		},

		/**
		* event to fecth a page
		*/
		onGetPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

			var indx = $(e.currentTarget).attr('href').replace(/^#/, ''),
                parametersDataFilter = this.filterData();

			this.collection.getPage(parseInt(indx), {reset: true, data:  _.omit(parametersDataFilter, function(value, key, object) {
                return _.isEmpty(value);
            })});
            this.updatedState();
		},

        /**
        * State change event
        */
        updatedState: function (newStates) {

            var currentPage = this.collection.state.currentPage,
                firstPage = this.collection.state.firstPage,
				params = $.param(_.extend(
				    this.parameters.queryParams,
				    currentPage > firstPage ? {page: (firstPage && currentPage) || currentPage + 1} : delete this.parameters.data.page
				));

            app.AppRouter.navigate(
				params == '' ? Backbone.history.fragment.split('?')[0] : Backbone.history.fragment.split('?')[0] + '?' + params
                , { trigger: false, replace: true }
            )
        },

        /**
        * Filter data
        */
        filterData: function ( ) {
            this.dataFilter = window.Misc.formToJson( this.$formFilter );

            if( this.dataFilter !== undefined ) {
				this.parameters.dataFilter = _.extend({}, this.parameters.data, this.dataFilter);
			}else{
				this.parameters.dataFilter = this.parameters.data;
			}

            return this.parameters.dataFilter;
        }
	});

})(jQuery, this, this.document);

/**
* Class PreviewPostView of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PreviewPostView = Backbone.View.extend({

        id: 'preview-post-view',
        className: 'row collapse wall-post-preview',
        template: _.template( ($('#preview-post').html() || '') ),
        events: {
            'click .close': 'onClear'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes
            this.$wrapperPostsWall = $('#wrapper-preview-post');//$( '#wrapper-posts-wall' );
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy invalid', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'preview', this.fetchDataUrl );
            this.on( 'reassign', this.reassign );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
                    .fadeIn('normal');

            return this;
        },

        /*
        * Remove View Element
        */
        remove: function(model){
            var _this = this;

            // if( _.isObject(model) ) 
            this.model.resetAttrs( {silent: true} );

            this.$el.slideUp('normal', function (){
                _this.$el.empty();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },

        /**
        * fetch data of url
        */
        fetchDataUrl: function (parseUrl) {

            if( this.model.previous('url') == parseUrl )
                return;

            // var previewPost = window.app.AppRouter.previewPost;
            this.$wrapperPostsWall.prepend( this.render().el );

            this.model.fetch( {data: {'url': parseUrl }, validate: true } );
        },

        /**
        * remove the item, destroy the model
        */
        onClear: function (e) {
            e.preventDefault();

            // this.model.set({success: null}, {silent: true});
            this.remove();
        },

        /**
        * Reassign elements
        */
        reassign: function () {
            this.$wrapperPostsWall = $('#wrapper-preview-post');
        }
   });

})(jQuery, this, this.document);

/**
* Class SectionTitleView extend of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo, @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.SectionTitleView = Backbone.View.extend({

        el: '.section-title',
        template: _.template( ($('#section-title-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize : function() {
            this.attributes = { subtitle: undefined };

            this.on('title:subtitle', this.buildTitle);
        },

        /*
        * Render View Element
        */
        render : function(){

            this.$el.html( this.template(this.attributes) );
            return this;
        },

        /**
        * get posts most recent
        */
        buildTitle : function (subtitle) {
            this.attributes.subtitle = subtitle;
            this.render();
        }
    });


})(jQuery, this, this.document);

/**
* Class EventModal extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventModalView = Backbone.View.extend({

        className: 'reveal-modal-main xtiny clearfix',
        attributes: {
            'data-reveal': ''
            // 'data-openauto': ''
        },
        template: _.template( ($('#event-modal-tpl').html() || '') ),
        events: {
            // 'click .open-event-info': 'onOpenEvent'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            //Initialize Attributes
            _.bindAll(this, 'onOpenEvent');

            //Events Listener
            // this.listenTo( this.model, 'change:codigo_evento', this.render );
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            $(document).on('click', '.open-event-info', this.onOpenEvent);
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON(),
                _this = this;
            this.$el.html( this.template(attributes) );

            return this;
        },

        /**
        * show modal
        */
        showModal: function () {
            this.$el.foundation('reveal','open');
        },

        /**
        * Event fecth modal data event
        */
        onOpenEvent: function (e) {

            var type = 'encrypt';
            e.preventDefault();
            e.stopPropagation();

            this.$el.foundation('reveal','close');
            var indEvent = $(e.target).data('event');

            if( indEvent !== undefined && indEvent !== '' ) {
                this.model.set({codigo_evento: indEvent}, {silent: true});
                this.showModal();
                this.model.fetch({data: {type:type , processData: true}});
            }
        }
    });
})(jQuery, this, this.document);

/**
* Class BaseMentoringView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.BaseMentoringView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#rol-switch-mentoring-tpl').html() || '') ),
        parameters: {
            tab: '',
            action: '',
            code_mentor: '',
            dataFilter: { }
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender',
                            'getCreateMentor');

            if( !_.isUndefined(opts) && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Initialize attributes
            this.mentoringQuestionList = new app.MentoringQuestionList();
            this.mentoringSessionList = new app.MentoringSessionList();
            this.mentorList = new app.MentorList();
            this.mentorSessionModel = new app.MentoringSessionModel();

            this.mentoringProcessModel = new app.MentoringProcess();
            this.mentoringProcessList = new app.MentorignProcessList();
            
            // events listener
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

        },

        /*
        * Render View Element
        */
        render: function () {
           
            var attributes =  {};
            attributes['tab'] = this.parameters['tab'];
            this.$el.html( this.template(attributes) );
            
            this.referenceToSections();

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // code goes here
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {
            this.ready();

            // get section
            this.stuffTab( this.parameters.tab, this.parameters.action );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                $(document).foundation('tab', 'reflow');
            }
        },

        /**
        * reference to sections views mentoring
        */
        referenceToSections: function () {
            
            // Reference to view mentoring questions
            if ( this.mentoringQuestions instanceof Backbone.View ){
                this.mentoringQuestions.stopListening();
                this.mentoringQuestions.undelegateEvents();
                this.mentoringQuestions.remove();
            }

            this.mentoringQuestions = new app.MentoringQuestionListView({
                collection: this.mentoringQuestionList,
                parameters: {
                    dataFilter: _.extend({
                    }, this.parameters['dataFilter'])
                }
            });
        },

        /**
        * switch tabs mentoring
        */
        stuffTab: function ( tab, action ) {
            var _this = this,
                stuffTab = {
                    'mentores' : function() {
                        action || (action = 'mentores');

                        _this.stuffAction(action);
                    },
                    'preguntas' : function() {
                        action || (action = 'preguntas');

                        _this.stuffAction(action);
                    },
                    'sesiones' : function() {
                        action || (action = 'sesiones');

                        _this.stuffAction(action);
                    },
                    'disponibilidad' : function() {
                        action || (action = 'disponibilidad');

                        _this.stuffAction(action);
                    },
                    'mentor' : function() {
                        action || (action = 'mentor');

                        _this.stuffAction(action);
                    },
                    'crearpregunta' : function() {
                        action || (action = 'crearpregunta');

                        _this.stuffAction(action);
                    },
                    'process' : function() {
                        action || (action = 'process');
                        
                        _this.stuffAction(action);
                    },
                    'default': function () {
                        action || (action = 'mentor');

                        _this.stuffAction(action);
                    }
                };

            if (stuffTab[tab]) {
                stuffTab[tab]();
            } else {
                stuffTab['default']();
            }
        },

        /**
        * switch actions mentoring
        */
        stuffAction: function ( action ) {
            var _this = this,
                stuffAction = {
                    'mentores' : function() {
                        _this.getMentors();
                    },
                    'preguntas' : function() {
                        _this.getQuestions();
                    },
                    'sesiones' : function() {
                        _this.getSessions();
                    },
                    'process' : function() {
                        _this.getProcess();
                    },
                    'disponibilidad' : function() {
                        _this.getAvailability();
                    },
                    'mentor' : function() {
                        _this.getCreateMentor();
                    },
                    'crearpregunta' : function() {
                        _this.getCreateQuestions();
                    },
                    'default': function () {
                        //
                    }
                };

            if (stuffAction[action]) {
                stuffAction[action]();
            } else {
                stuffAction['default']();
            }
        },

        /**
        * get results of mentoring questions
        */
        getQuestions: function () {
            this.mentoringQuestions.render();
            this.mentoringQuestions.trigger('getData');
            this.mentoringQuestions.trigger('getDataSessions');
            this.mentoringQuestions.trigger('getDataMentoringActive');
        },

        /**
        * get results of mentoring sessions
        */
        getSessions: function () {
            //
        },

        /**
        * get mentor calendar availability
        */
        getAvailability: function () {
            // this.mentoringAvailability.render();
        },

        /**
        * get form create mentor
        */
        getCreateMentor: function () {

            this.userProfileModel = new app.UserModel();
            this.userProfileModel.url = function () {
				return window.Misc.urlFull( Route.route('usuario.auth') );
			};

            if ( this.mentorProfileView instanceof Backbone.View ){
                this.mentorProfileView.stopListening();
                this.mentorProfileView.undelegateEvents();
            }

            this.mentorProfileView = new app.MentoringCreateMentorView({ model: this.userProfileModel });
            this.userProfileModel.fetch();
        },

        /**
        * get form create question
        */
        getCreateQuestions: function () {

            this.mentorProfileModel = new app.UserModel();
            this.mentorProfileModel.idAttribute = 'nickname_usuario';
            this.mentorProfileModel.set({'nickname_usuario': this.parameters.dataFilter['nickname']});

            // Reference to view requestMentoring
			if ( this.requestMentoring instanceof Backbone.View ){
				this.requestMentoring.stopListening();
				this.requestMentoring.undelegateEvents();
				this.requestMentoring.remove();
			}

			this.requestMentoring = new app.RequestMentoringView({
				model: this.mentorProfileModel,
				parameters: {
				   //
				}
            });
            this.mentorProfileModel.fetch();
        },

        /**
        * get list Mentors
        */
        getMentors: function () {
            
             // Reference to view list mentors
            if ( this.mentorListView instanceof Backbone.View ){
                this.mentorListView.stopListening();
                this.mentorListView.undelegateEvents();
                this.mentorListView.remove();
            }

            this.mentorListView = new app.MentorListView({
                collection: this.mentorList,
                parameters: {
                    dataFilter: _.extend({
                    }, this.parameters['dataFilter'])
                }
            });

            this.mentorListView.render();
            this.mentorListView.trigger('getData');
        },

        getProcess: function(){

            if ( this.mentoringProccessView instanceof Backbone.View ){
                this.mentoringProccessView.stopListening();
                this.mentoringProccessView.undelegateEvents();
                this.mentoringProccessView.remove();
            }

            // Reference to view proccess
            this.mentoringProccessView = new app.ProcessMentoringList({
                collection: this.mentoringSessionList,
                parameters: {
                    dataFilter: _.extend({
                    }, this.parameters['dataFilter'])
                }
            });

            this.mentoringProccessView.render();
            this.mentoringProccessView.trigger('getData');
            this.mentoringProccessView.trigger('getDataMentoringAll');
        }

    });
})(jQuery, this, this.document);

/**
* Class MentoringQuestionItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionItemView = Backbone.View.extend({
        template: _.template( ($('#active-mentoring-tpl').html() || '') ),
        templateMentoringPending: _.template( ($('#mentoring-pending-tpl').html() || '') ),
        templateMentoringFinish: _.template( ($('#mentoring-finished-tpl').html() || '') ),
        templateMentoringRejected: _.template( ($('#rejected-mentoring-tpl').html() || '') ),
        events: {
            'click .tp_link-title': 'onValidateTitle',
            'click #opt-close-mentoring-question': 'onCloseMentoringQuestion'
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            console.log('Attributes', attributes);
            this.$el.html( this.parameters.template != '' ? this[this.parameters['template']](attributes) : this.template(attributes) );
            
            if( _.has($.fn, 'foundation') ){
                $(document).foundation('dropdown', 'reflow');
            }

            return this;
        },

        onValidateTitle: function (e) {
            e.preventDefault();

            app.AppRouter.navigate( Route.route('mentoria.mentores.procesos.show', {'procesos': this.model.get('codigo_asesoria') }), {trigger: true} );
        },

        onCloseMentoringQuestion: function (e) {
            e.preventDefault();

                var data = {};
                data['codigo_estado'] = window._tp.getState['closed'];
                _this = this;
                this.model.save(data, {patch: true, wait: true,
                    success: function (model, resp) {
                        // response success or error
                        var text = resp.success ? resp.message : resp.errors,
                            type = resp.success ? 'success' : 'alert';

                        if( _.isObject(resp.errors) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }

                        var config = {
                            'text': text,
                            'type': type
                        };
                        _.extend( _this.configAlert, config );

                        if( resp.success ){
                            window.Misc.showAlertBox( _this.configAlert );
                            _this.$el.html( _this.templateRemove() );
                            _this.onInstanceViewParticipants(model);
                        }
                    }
                });
        },
    });

})(jQuery, this, this.document);

/**
* Class MentoringQuestionItemGridView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionItemGridView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentoring-question-list-tpl').html() || '') ),
        events: {
            'click .tp_link-title': 'onValidateTitle',
            'click #opt-close-mentoring-question': 'onCloseMentoringQuestion'
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        },

        onCloseMentoringQuestion: function (e) {
            e.preventDefault();

                var data = {};
                data['codigo_estado'] = window._tp.getState['closed'];
                _this = this;
                this.model.save(data, {patch: true, wait: true,
                    success: function (model, resp) {
                        // response success or error
                        var text = resp.success ? resp.message : resp.errors,
                            type = resp.success ? 'success' : 'alert';

                        if( _.isObject(resp.errors) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }

                        var config = {
                            'text': text,
                            'type': type
                        };
                        _.extend( _this.configAlert, config );

                        if( resp.success ){
                            window.Misc.showAlertBox( _this.configAlert );
                            _this.$el.html( _this.templateRemove() );
                            _this.onInstanceViewParticipants(model);
                        }
                    }
                });

        },

        onValidateTitle: function (e) {
            e.preventDefault();

            if(this.model.get('codigo_estado') == window._tp.getState['pending']){
                var conf = {
                    text: 'La solicitud de asesoría no se ha aprobado.',
                    type: 'alert'
                };
                confAlert = $.extend({}, this.configAlert, conf);
                window.Misc.showAlertBox( confAlert );
            }else if(this.model.get('codigo_estado') == window._tp.getState['closed']){
                var conf = {
                    text: 'El proceso de asesoría se encuentra cerrado.',
                    type: 'alert'
                };
                confAlert = $.extend({}, this.configAlert, conf);
                window.Misc.showAlertBox( confAlert );
            }else{
                app.AppRouter.navigate( Route.route('mentoria.preguntas.show', {'preguntas': this.model.get('url_asesoria') }), {trigger: true} );
            }
        }

    });

})(jQuery, this, this.document);

/**
* Class MentoringQuestionListView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionListView = Backbone.View.extend({

        el: '#mentoring-questions',
        template: _.template( ($('#mentoring-viewquestions-tpl').html() || '') ),
        templateNotResultMentoring: _.template( ($('#not-result-mentoring-tpl').html() || '') ),
        templateNotResultSessions: _.template( ($('#not-result-sessions-tpl').html() || '') ),
        events: {
            'click .redirect___Mentoring': 'onRedirectMentoring',
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function( opts ){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');

            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend( this.parameters, opts.parameters );
            }

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Initialize
            this.mentoringSessionList = new app.MentoringSessionList();

            // Events Listener
            this.listenTo( this.collection, 'change', this.render );
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );

            this.on('getData', this.getFirstData);
            this.on('getDataSessions', this.getFirstDataSessions);
            this.on('getDataMentoringActive', this.getFirstDataMentoringActive)

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            $( window ).off("scroll");

            if(this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid'){
                $( window ).on("scroll", this.onLoadMore);
            }
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this,
                attributes = {};

            attributes.dataFilter = this.parameters['dataFilter'];

            this.$el.html( this.template(attributes) );
            this.$wrapActiveMentoring = this.$('#container-active-mentoring');
            this.$wrapSessionMentoring = this.$('#container-session-mentoring');
            this.$wrapMentoringPending = this.$('#container-mentoring-pending');
            this.$wrapMentoringAll = this.$('#container-mentoring-all-proccess');

            this.$wrapperData = (this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid') ?
                                this.$('#list-mentoring-questions') :
                                this.$('#mentoring-questions-data > tbody');

            /* Old pagination */

            //Init Attributes
            // this.$wrapPagination = this.$('.wrap-pagination');
            // this.$blockFilters = this.$('.block-filters-choice');


            // this.$spinnerEvents = (this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid') ?
            //                     $('<div>').attr('id','spinner-load-questions') :
            //                     this.$wrapperData;

            // if(this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'list') {
            //     // set paginations
            //     this.$wrapPagination.each(function(index, el) {

            //         var pagination = new app.Paginator({
            //             className: 'right pagination inner-title-section',
            //             collection: _this.collection,
            //             parameters: {
            //                 'nameForm': '#form-filter-questions',
            //                 data: _this.parameters.dataFilter
            //             }
            //         });

            //         $(el).html( pagination.render().el );
            //     });
            // }

            // // set block filter
            // this.$blockFilters.each(function(index, el) {
            //     var blockFilter = new app.FilterData({
            //         el: el,
            //         collection: _this.collection,
            //         parameters: {
            //             'nameForm': '#form-filter-questions',
            //             'callBackFilter': function (newDataFilter) {
            //                 app.AppRouter.navigate( Route.route('mentoria.preguntas.index', newDataFilter), {trigger: false, replace: true} );
            //                 _this.trigger('getData', newDataFilter, true);
            //             },
            //             'dataFilter': _.extend({
            //             }, _this.parameters.dataFilter)
            //         }
            //     });
            // });

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            var _this = this;

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('tooltip', 'reflow');
                $(document).foundation('dropdown', 'reflow');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

        },

        /**
        * get firsts data
        * @param Object dataFilter
        */
        getFirstData: function (dataFilter, replace) {

            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }
            this.parameters.dataFilter.state = window._tp.getState['pending'];
            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
            this.parameters.fetching = 'mentoring_pending';
        },

        getFirstDataSessions: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.mentoringSessionList.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.mentoringSessionList.state.currentPage;
        },

        getFirstDataMentoringActive: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);
            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }
            this.parameters.dataFilter.state = window._tp.getState['active'];

            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
            this.parameters.fetching = 'mentoring_active';
        },

        /**
        * Render view theme by model
        * @param Object themeModel Model instance
        */
        addOne: function (questionModel) {

            var attributes = questionModel.toJSON();

            if (attributes.codigo_estado === window._tp.getState['pending']) {
                var view = new app.MentoringQuestionItemView({
                    model: questionModel,
                    parameters: {
                      template: 'templateMentoringPending'
                    }
                });

                this.$wrapMentoringPending.append( view.render().el );
            }

            if (attributes.codigo_estado === window._tp.getState['active']) {
                var view = new app.MentoringQuestionItemView({
                    model: questionModel,
                    parameters: {
                        template: ''
                    }
                });

                this.$wrapActiveMentoring.append( view.render().el );
            }


            // refresh plugins
            this.ready();
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {
            this.$wrapperData.html('');
            if (this.collection.length > 0) {
                this.collection.forEach( this.addOne, this );
            } else {
                this.notResultMentoring();
            }
        },

        notResultMentoring: function() {
            // if (this.parameters.fetching == "mentoring_active") {
            //     this.$wrapActiveMentoring.html( this.templateNotResultMentoring() );
            // } else if (this.parameters.fetching == "mentoring_pending"){
            //     this.$wrapMentoringPending.html( this.templateNotResultMentoring() );
            // }
        },

        addOneSession: function (mentoringModel) {

            var view = new app.MentoringItemSessionList({
                model: mentoringModel,
                parameters: {
                    //
                }
            });

            this.$wrapSessionMentoring.append( view.render().el );

            // refresh plugins
            this.ready();
        },

        /**
         * Render all view of Sessions
         */

        addAllSession: function() {

            this.$wrapperData.html('');

            if (this.mentoringSessionList.length > 0) {
                this.mentoringSessionList.forEach( this.addOneSession, this );
            } else {
                this.notResultSessions();
            }

        },

        notResultSessions: function() {
            this.$wrapSessionMentoring.html(this.templateNotResultSessions());
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            // if(this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid'){
            //     if( target instanceof Backbone.Collection ) {
            //         this.$spinnerEvents.appendTo( this.$('.content-data-list') );
            //     }else{
            //         this.$spinnerEvents.prependTo( this.$('.content-data-list') );
            //     }
            // }

            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        },

        /**
        * load more
        */
        onLoadMore: function (e) {

           e.preventDefault();

            var _this = this;
            var scrollHeight = $(document).height();
            var scrollPosition = $(window).height() + $(window).scrollTop();

            if ((scrollHeight - scrollPosition) / scrollHeight <= 0.001) {

                // when scroll to bottom of the page
                if( this.collection.state.currentPage < this.collection.state.lastPage && this.pageOld == this.collection.state.currentPage ){

                    this.collection.getNextPage({
                        data: _.clone(this.parameters.dataFilter),
                        wait: true,
                        success: function (collection) {
                            _this.pageOld = collection.state.currentPage;
                        }
                    });
                }
            }
        },

        onRedirectMentoring: function(e) {
            e.preventDefault();

            var mentoring = $(e.currentTarget).data('mentoring');

            // Redirect to Mentoring Content
            url = Route.route('mentoria.mentores.procesos.show', { procesos: mentoring }) ;
            Backbone.history.navigate(url, { trigger:true });
        }
    });

})(jQuery, this, this.document);

/**
* Class MentoringSessionPageListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionPageListView = Backbone.View.extend({

        el: '#mentoring-process-main',
        template: _.template( ($('#mentoring-sessions-list-tpl').html() || '') ),
        parameters: {
            rol: '',
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            // Initialize attributes

            // Events Listener
            // this.listenTo( this.collection, 'change', this.render );
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.listenTo( this.collection, 'remove', this.responseItemDelete );
            this.on('getData', this.getFirstData);
        },

        /*
        * Render View Element
        */
        render: function () {
          
            var _this = this,
                attributes = {};

            attributes.rol = this.parameters['rol'];
            attributes.dataFilter = this.parameters['dataFilter'] || null;
            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapPagination = this.$('.wrap-pagination');
            this.$wrapperData = this.$('#browse-list-mentoring-sessions');
            this.$blockFilters = this.$('.block-filters-choice');

            this.$wrapPagination.each(function(index, el) {

                var pagination = new app.Paginator({
                    className: 'right pagination inner-title-section',
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-filter-questions',
                        'data':  attributes.dataFilter
                    }
                });

                $(el).html( pagination.render().el );
            });

            // set block filter
            this.$blockFilters.each(function(index, el) {

                var blockFilter = new app.FilterData({
                    el: el,
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-filter-questions',
                        'dataFilter': _.extend({
                            'rol':_this.parameters.rol
                        }, _this.parameters.dataFilter)
                    }
                });
            });

            // trigger functions
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            return this;
        },

        getFirstData: function (dataFilter) {
            dataFilter || (dataFilter = {});

            _.extend( this.parameters.dataFilter, dataFilter );

            //Fetch data
            this.collection.getFirstPage( {reset:true, data: this.parameters.dataFilter} );
        },

        /**
        * Render view article by model
        * @param Object MentoringEvaluationModel Model instance
        */
        addOne: function (mentoringModel) {

            var view = new app.MentoringSessionItemView({
                model: mentoringModel,
                parameters: {
                    rol: this.parameters['rol']
                }
            });
            this.$wrapperData.find('tbody').append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {
            this.$wrapperData.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner( this.$wrapperData );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length && target instanceof Backbone.Collection )
                this.$noResults.fadeIn('fast');

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        },

        /**
        * response of the server item delete
        */
        responseItemDelete: function (model, resp, opts) {
            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);

  /**
* Class MentoringSessionListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionListView = Backbone.View.extend({

        el: '#mentoring-process-main',
        template: _.template( ($('#mentoring-sessions-process-list-tpl').html() || '') ),
        events: {
            'click #button-confirm-sesion': 'onConfirmSesion',
            'click #button-cancel-sesion': 'onCancelSesion'
        },
        parameters: {
            rol: '',
            dataFilter: {}
        },
      
        /**
        * Constructor Method
        */
        initialize: function(opts){

            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            // Initialize attributes

            // Events Listener
            // this.listenTo( this.collection, 'change', this.render );
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.listenTo( this.collection, 'remove', this.responseItemDelete );
            
            this.collection.fetch({reset:true});
           
        },

        /*
        * Render View Element
        */
        render: function () {
            attributes = this.collection.toJSON(); d
            var _this = this;
              
            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapperBodySesion = this.$('.body-session-content');
            this.$el.html( this.template(attributes));
           // this.$wrapperData = this.$('#browse-list-mentoring-sessions');


            return this;
        },

       
        /**
        * Render view article by model
        * @param Object MentoringEvaluationModel Model instance
        */
        addOne: function (mentoringModel) {
            var view = new app.MentoringSessionListItemView({
                model: mentoringModel,
                parameters: {
                    //rol: this.parameters['rol']
                }
            });
            this.$('.body-session-content').append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {
            this.$('.body-session-content').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length && target instanceof Backbone.Collection )
                this.$noResults.fadeIn('fast');

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        },

        /**
        * response of the server item delete
        */
        responseItemDelete: function (model, resp, opts) {
            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class MentoringQuestionView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#mentoring-feedback-tpl').html() || '') ),
        events: {
            'click #opt-close-mentoring-question': 'onCloseMentoringQuestion'
        },
        parameters: {
            rol: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters)
            }

            this.configAlert = {
                'wrapper': '#mentoring-wrapper',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attribute
            this.discussionList = new app.DiscussionList();

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.rol = this.parameters.rol;

            this.$el.html( this.template(attributes) );

            this.$wrapperDocuments = this.$('#wrap-documents');
            // redefine id attribute model
            if( this.model.changed.codigo_asesoria !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_asesoria';
                this.model.set({'codigo_asesoria': this.model.get('codigo_asesoria')},{'silent':true});

                this.referenceViews();
            }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {

            // Instance of Documents of Advice
            this.mentoringQuestionDocuments = new app.MentoringQuestionDocuments({
                el: this.$wrapperDocuments,
                model: this.model,
                parameters: {
                    //
                }
            });

            this.mentoringQuestionDocuments.render();

            this.discussionListView = new app.DiscussionListView({
                collection: this.discussionList,
                    parameters: {
                        'formDiscussion': '#form-discussion-advice',
                        dataFilter: {
                            'codigo_recurso_modulo': this.model.get('codigo_asesoria'),
                            'codigo_modulo': window._tp.getModule('mentoring')
                        }
                    }
             });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },

        /**
         * 
         */
        onCloseMentoringQuestion: function (e) {
            e.preventDefault();
                var data = {};
                data['codigo_estado'] = window._tp.getState['closed'];
                _this = this;

                this.acceptSendConfirm = new app.ConfirmWindow({
                    model: _this.model,
                    parameters: {
                        template: _.template($("#mentoring-end-confirm-tpl").html() || ""),
                        titleConfirm: "¿ Está seguro de finalizar la asesoría/mentoría ?",
                        onConfirm: function () {
                            _this.model.save(data, {patch: true, wait: true,
                                success: function (model, resp) {
                                    // response success or error
                                    var text = resp.success ? resp.message : resp.errors,
                                        type = resp.success ? 'success' : 'alert';
            
                                    if( _.isObject(resp.errors) ){
            
                                        var listError = '<ul>';
            
                                        $.each(resp.errors, function(field, item) {
                                            listError += '<li>'+ item[0] +'</li>';
                                        });
                                        listError += '</ul>';
            
                                        text = listError;
                                    }
            
                                    var config = {
                                        'text': text,
                                        'type': type
                                    };
                                    _.extend( _this.configAlert, config );

                                    Backbone.history.navigate(Route.route('mentoria.preguntas.evaluacion.mentor.create', {
                                        user: _this.model.get('codigo_asesoria') } ), { trigger:true });
                                }
                            });
                        }
                    }
                });

                this.acceptSendConfirm.render();
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringConfirmCloseView extend of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringConfirmCloseView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#mentoring-confirm-close-tpl').html() || '') ),
        events: {
            'click .confirm-action': 'onConfirm'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // 
        },

        /*
        * Render View Element
        */
        render: function() {
        	var attributes = {};
            this.$el.find('.content-modal').html( this.template(attributes) );

            return this;
        },


        /**
        * Event Close Confirm
        */
        onConfirm: function (e) {
            e.preventDefault();

            this.$el.foundation('reveal', 'close');
            this.model.closeMentoring();
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringCalendar extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {
    
    app.MentoringCalendar = Backbone.View.extend({
        el: '#modal-schedule-mentoring',
        templateCalendar: _.template( ($('#calendar-mentoring-tpl').html() || '') ),
        events: {
            'change #chosen-advisers': 'onChangeAdvisers'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'scheduleMentoring', 'onEventClick');
            // Init Attributes
            this.eventMentoring = new app.EventModel();
            this.scheduleAdviser = new app.ScheduleAdviserView({
                model:this.eventMentoring
            });

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            }); 

            // Events Listener
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
            this.listenTo( this.scheduleAdviser, 'schedule', this.setScheduleAdviser );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = {};
            attributes.codigo_proyecto = this.codigo_proyecto;

           this.$el.find('#mentor-calendar-wrap').append (this.templateCalendar(attributes) );
            this.$el.foundation('reveal', 'open');

            //Initialize Reference to elements
            this.$calendarMentoring = this.$('#calendar-mentoring');
           // this.$selectAdvisers = this.$('select#chosen-advisers');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            if( typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            $(document).on('opened.fndtn.reveal', this.$el, this.scheduleMentoring );

            // set calendar
            this.setCalendar();
        },

        setCalendar: function () {
            var _this = this;

            this.$calendarMentoring.fullCalendar({
                header: {
                  left: 'prevYear, prev,next, nextYear today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                lang: 'es',
                defaultDate: moment(),
                defaultView: 'month',
                selectable: false,
                editable: true,
                dragOpacity: .75,
                weekNumbers: false,
                aspectRatio: 650/300,
                eventClick: this.onEventClick
            });
        },

        /**
        *
        */
        onEventClick: function  (calEvent, jsEvent, view) {
            // console.log('click to event:', calEvent, jsEvent, view);
            var calendar = this.$calendarMentoring.fullCalendar('getCalendar'),
                attrsSchedule = {
                    title: calEvent.title,
                    start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
                    end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
                    stateEvent: _.find(calEvent.className, function (eventClasses) {
                        return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed';
                    })
                };

            if( calEvent.codigo_evento !== undefined && calEvent.className.indexOf('disabled') === -1 ){
                var type = 'encrypt';
                this.scheduleAdviser.attrsSchedule = attrsSchedule;
                this.scheduleAdviser.calEvent = calEvent;
                this.eventMentoring.resetAttrs({silent:true});
                this.eventMentoring.set('codigo_evento', calEvent.codigo_evento );
                this.eventMentoring.fetch({data: {type:type , processData: true}});
                
                this.scheduleAdviser.$el.dialog('open');
            }
        },

        /**
        * render calendar schedule mentoring
        */
        scheduleMentoring: function  () {
            // render calendar
            if( this.$calendarMentoring.data('fullCalendar') !== undefined ){
                this.$calendarMentoring.fullCalendar('render');
            }
        },

        /**
        * fetch advisers events calendar
        */
        onChangeAdvisers: function (e) {
            var _this = this,
                $elAdvisers = $(e.target),
                codigo_asesor = $elAdvisers.find('option:selected').val();

            if( this.$calendarMentoring.data('fullCalendar') !== undefined ){

                this.$calendarMentoring.fullCalendar('removeEventSource', {url:window.Misc.urlFull( Route.route('calendario.evento.index') )});
                this.$calendarMentoring.fullCalendar( 'addEventSource', {
                    url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                    type: 'GET',
                    data: {
                        'type': 'schedule',
                        'event': 'mentoring',
                        'codigo_usuario': codigo_asesor 
                    },
                    error: function (jqXHR, status, error) {
                        console.log('error::', status, error);
                    },
                    success: this.successRequesEvents,
                    editable: false
                });
            }
        },

        /**
        * response of events
        * @param Object resp
        */
        successRequetsEvents: function (resp) {
            // console.log(resp);
        },

        /**
        * listen when adviser was scheduled
        */
        setScheduleAdviser: function () {
            this.$calendarMentoring.fullCalendar('removeEvents');
            this.$calendarMentoring.fullCalendar('refetchEvents');
        }
    });

})(jQuery, this, this.document );
/**
* Class MentoringEvalSessionView extends of Backbone View
* @author TuProyecto || Desarrolladora : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringEvalSessionView = Backbone.View.extend({

        el: '#mentoring-sessions',
        template: _.template( ($('#mentoring-eval-session-tpl').html() || '') ),
        events: {
            'submit #form-create-eval': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            //Init Attributes
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            this.mentoringItemList = new app.MentoringItemList();

            this.mentoringEvaluationModel = new app.MentoringEvaluationModel();
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            this.$buttonRegistration = this.$('.register-calification');
            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentoringEvaluationModel, 'sync', this.responseServerRegistration );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            //get Items of mentoring
            this.getItems();

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },


        /**
        *  Get Items from mentoring
        */
        getItems: function () {
            var itemsView = new app.MentoringEvalSessionListView({
                collection: this.mentoringItemList,
                attributes: {}
            });
        },

        /**
        * Event Items Mentoring
        */
        onStore: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            this.mentoringEvaluationModel.save( data, {patch: true, wait:true} );
        },

        /**
        * response of the server model calificationTask
        */
        responseServerRegistration: function ( model, resp, opts ) {
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ? 
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            } 
             
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );
            
            this.$buttonRegistration.removeClass('disabled');
            if( resp.success ){
                // Redirect to Content Session Mentoring
                url = Route.route('mentoria.{rol?}.sesiones.index', { 'rol' : 'emprendedor' }) ;
                Backbone.history.navigate(url, { trigger:true })
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringEvalSessionItemView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringEvalSessionItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentoring-session-item-detail-tpl').html() || '') ),
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
                    .fadeIn('slow');
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$taskForm );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            // response success or error

            var text = resp.success ? '' : resp.errors,
                type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
             
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': '#mentoring-content',
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if( re.success ){
                            // $( '#form-task-mentoring [name="descripcion_tarea_mentoria"]' ).val('');
                            return;
                        }
                        _this.remove();
                        window.Misc.showAlertBox( conf );
                    }
                })(this.configAlert, resp, this)
            });
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringEvalSessionListView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringEvalSessionListView = Backbone.View.extend({

        el: '#container-session-items-mentoring',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            /* if was passed mentoring code */
            if( !_.isUndefined(this.attributes.mentoring) && !_.isNull(this.attributes.mentoring) )
                 this.confCollection.data.codigo_mentoria = this.attributes.mentoring;

            // // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );

            this.collection.fetch( this.confCollection );
        },

        /*
        * Render View Element
        */
        render: function(){
        },

        /**
        * Render view items by model
        * @param Object mentoringItemModel Model instance
        */
        addOne: function (mentoringItemModel) {
            var view = new app.MentoringEvalSessionItemView( { model: mentoringItemModel } );
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a task of mentoring
        * @param form element
        */
        storeOne: function (form) {
            var data = window.Misc.formToJson( form );
            this.collection.create( data );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server    
        */
        responseServer: function ( collection, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringSessionListItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @refo44
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionListItemView = Backbone.View.extend({
        template: _.template( ($('#mentoring-session-process-item-list-tpl').html() || '') ),
        parameters: {
            'rol': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.confirmRemove = new app.ConfirmRemoveMentoringView({
                model:this.model,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres cancelar esta mentoría?'
                }
            });
            
            this.$modalConfirm = $('#modal-base-confirm-tp');
            this.$modalBase = $('#modal-base-material');
            

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );

        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
           // attributes.rol = this.parameters['rol'];
            console.log('Attributes Session', attributes);
            this.$el.html( this.template(attributes) );
            
            return this;
        },

        /**
        * Event confirm session
        */
        onConfirmSesion: function (e) {
            e.preventDefault();
            var data = { 
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'action': 'confirm-mentoring'
            };
            this.model.save(data, {patch:true, wait:true});
        },



        /**
        * destroy Mentoring
        */
        onCancelSesion: function (e) {

            e.preventDefault();
            this.confirmRemove.render();
        },
        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class MentoringSessionItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#mentoring-session-item-list-tpl').html() || '') ),
        events: {
            'click #button-confirm-sesion': 'onConfirmSesion',
            'click #button-cancel-sesion': 'onCancelSesion'
        },
        parameters: {
            'rol': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.confirmRemove = new app.ConfirmRemoveMentoringView({
                model:this.model,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres cancelar esta mentoría?'
                }
            });
            this.$modalConfirm = $('#modal-base-confirm-tp');
            this.$modalBase = $('#modal-base-material');
            

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );

        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.rol = this.parameters['rol'];
            this.$el.html( this.template(attributes) );
            
            return this;
        },

        /**
        * Event confirm session
        */
        onConfirmSesion: function (e) {
            e.preventDefault();
            var data = { 
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'action': 'confirm-mentoring'
            };
            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * destroy Mentoring
        */
        onCancelSesion: function (e) {

            e.preventDefault();
            this.confirmRemove.render();
        },
        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class MentoringSessionView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionView = Backbone.View.extend({

        el: '#mentoring-sessions',
        template: _.template( ($('#mentoring-session-tpl').html() || '') ),
        events: {
            'submit #form-task-mentoring': 'onStore'
        },
        parameters: {
            rol: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters)
            }

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            this.mentoringTaskList = new app.MentoringTaskList();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.once( 'beforeRender', this.beforeRender );
            this.once( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.rol = this.parameters.rol;

            this.$el.html( this.template(attributes) );

            // redefine id attribute model
            // if( this.model.changed.codigo_sesion !== undefined ) {
            //     // Overwrite id attribute of the model
            //     this.model.idAttribute = 'codigo_sesion';
            //     this.model.set({'codigo_sesion': this.model.get('codigo_sesion')},{'silent':true});
            // }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            //get Tasks of mentoring
            this.getTask();

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },

        /**
        *  Get task from mentoring
        */
        getTask: function () {

            var taskView = new app.MentoringTaskListView({
                collection: this.mentoringTaskList,
                attributes: {
                    'mentoring': this.model.get('codigo_mentoria')
                }
            });
        },

        /**
        * Event Create Task Mentoring
        */
        onStore: function (e) {
            e.preventDefault();
            this.mentoringTaskList.trigger( 'store', this.$(e.target) );
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringItemSessionList extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringItemSessionList = Backbone.View.extend({
        template: _.template( ($('#session-mentorig-tpl').html() || '') ),
        events: {
            //
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();

            console.log('Session Attributes', attributes);
         
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') ){
                $(document).foundation('dropdown', 'reflow');
            }

            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class ScheduleAdviserView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ScheduleAdviserView = Backbone.View.extend({
        el: '#modal-schedule-adviser',
        template: _.template( ($('#schedule-adviser-tpl').html() || '') ),
        templateItemTarget: _.template( '<li><span><%- target_mentoring %></span><a href="#" class="remove-target right">&times;</a><input type="hidden" name="objetivos_mentoria" value="<%- target_mentoring %>"></li>' ),
        events: {
            'click .add-target-schedule': 'onAddTarget',
            'keypress #target_mentoring': 'onAddTarget',
            'click .remove-target': 'onRemoveTarget',
            'submit #form-schedule-adviser': 'onRequestSchedule'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Init Attributes

            _.bindAll(this, 'render', 'setRequest', 'onAddTarget', 'onRemoveTarget',
            'onRequestSchedule','responseServer');

            this.configAlert = {
                'wrapper': $('#modal-schedule-adviser'),
                'closeTime': 10000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.setRequest );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            _.extend( attributes, this.attrsSchedule );
            //console.log("ScheduleAdviserModel", attributes );
            this.$el.find('.content-modal').html( this.template(attributes) );

            //Initialize Reference to elements
            this.$formSchedule = this.$('#form-schedule-adviser');
            this.$targetsWrapper = this.$('.targets-schedule-mentoring');
            this.$fieldTargetMentoring = this.$('#target_mentoring');

            //initialize form settings for schedule advisor
            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }
        },

        /**
        * add a new target to the adviser schedule
        */
        onAddTarget: function (e) {
            var codeKey = e.keyCode || e.which;

            if( e.type == 'keypress' ){
                if( codeKey !== 13 )
                    return;
            }else{
                e.preventDefault();
                e.stopImmediatePropagation();
            }

            var targetMentoring = ''

            if(typeof this.$fieldTargetMentoring != 'undefined')
                targetMentoring = this.$fieldTargetMentoring.val().trim();

            if( targetMentoring.length ){
                this.$targetsWrapper.append( this.templateItemTarget({'target_mentoring': targetMentoring}) );

                this.$fieldTargetMentoring.val('');
            }

            if( codeKey === 13 ) return false;
        },

        /**
        * add a new target to the adviser schedule
        */
        onRemoveTarget: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $(e.target).parents('li').remove();
        },

        /**
        *
        */
        onRequestSchedule: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var owner =  this.model.get('owner');

            var data = window.Misc.formToJson( e.target );
            if(typeof data.objetivos_mentoria === 'string'){
                data.objetivos_mentoria = [ data.objetivos_mentoria ];
            }
            data.action = owner ? 'confirm-mentoring' : 'schedule-mentoring';

            if(owner || (typeof data.objetivos_mentoria !== 'undefined' && data.objetivos_mentoria.length && data.codigo_asesoria !== "0") ){
                this.model.save(data, {patch:true});
            } else if (data.codigo_asesoria === "0") {
                var config = {
                    'text': 'Debes seleccionar el Emprendimiento',
                    'type': 'alert'
                };

                _.extend( this.configAlert, config );

                window.Misc.showAlertBox( this.configAlert );

                this.render();
            } else {
                var config = {
                'text': 'Debe agregar al menos un objetivo',
                'type': 'alert'
                };

                _.extend( this.configAlert, config );

                window.Misc.showAlertBox( this.configAlert );

                this.render();
            }
        },

        /**
        * listens when it send request to the server
        */
        setRequest: function (target, xhr, opts) {

            this.$formSchedule.find(':submit').addClass('disabled');
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {

            this.$formSchedule.find(':submit').removeClass('disabled');
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ?
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            if( resp.success !== undefined ){
                if( resp.success ){
                    window.Misc.showAlertBox( this.configAlert );
                    this.$el.dialog('close');
                    this.trigger('schedule');
                }else{
                    window.Misc.showAlertBox( this.configAlert );
                }
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MentoringTaskView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringTaskView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentoring-task-tpl').html() || '') ),
        events: {
            'click .remove-task-mentoring': 'onHide'
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attributes
            this.$taskForm = $('#remove-mentoring');
            this.confirmRemove = new app.MentoringTaskConfirmRemoveView({
                model:this.model,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres eliminar tarea?'
                }
            });
            this.$modalConfirm = $('#modal-base-confirm-tp');
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
                    .fadeIn('slow');
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },
        /**
        * Event Remove Task Mentoring
        */
        onHide: function (e) {
            e.preventDefault();

            this.confirmRemove.render();
        },

        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$taskForm );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            // response success or error

            var text = resp.success ? '' : resp.errors,
                type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
             
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': '#mentoring-content',
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if( re.success ){
                            $( '#form-task-mentoring [name="descripcion_tarea_mentoria"]' ).val('');
                            return;
                        }
                        _this.remove();
                        window.Misc.showAlertBox( conf );
                    }
                })(this.configAlert, resp, this)
            });
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringTaskListView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringTaskListView = Backbone.View.extend({

        el: '#container-task-detail',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            /* if was passed mentoring code */
            if( !_.isUndefined(this.attributes.mentoring) && !_.isNull(this.attributes.mentoring) )
                 this.confCollection.data.codigo_mentoria = this.attributes.mentoring;

            // // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );
           
            this.collection.fetch( this.confCollection );
        },

        /*
        * Render View Element
        */
        render: function(){
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (mentoringTaskModel) {
            var view = new app.MentoringTaskView( { model: mentoringTaskModel } );
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a task of mentoring
        * @param form element
        */
        storeOne: function (form) {
            var data = window.Misc.formToJson( form );
            this.collection.create( data );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server    
        */
        responseServer: function ( collection, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringTaskConfirmRemoveView extends of Backbone View
* @author TuProyecto || Desarrolladora : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringTaskConfirmRemoveView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#task-mentoring-confirm-remove-tpl').html() || '') ),
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	
        	// extends attributtes
        	_.extend( this.parameters, opts.parameters );

        	// Init Attributes
        },

        /*
        * Render View Element
        */
        render: function() {
        	var attributes = {};
            this.$el.find('.content-modal').html( this.template(attributes) );

            // Change modal title
            this.$el.find('.inner-title-modal').html( this.parameters['titleConfirm'] );
            this.$el.foundation('reveal', 'open');

        	// delegate events
        	$(this.el).off();
            this.delegateEvents({
            	'click .confirm-action': 'onConfirm'
            });

            return this;
        },

        /**
        * Event Close Confirm
        */
        onConfirm: function (e) {
            e.preventDefault();
            this.$el.foundation('reveal', 'close');
            this.model.destroy({
            	processData: true,
            	wait: true,
            	data: { 
            		'codigo_tarea_mentoria': this.model.get('codigo_tarea_mentoria'), 
            		'_token': $('meta[name="csrf-token"]').attr('content') 
            	}
           	});
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringCalificationTaskView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringCalificationTaskView = Backbone.View.extend({
        
        el: '#mentoring-sessions',
        template: _.template( ($('#mentoring-calification-task-tpl').html() || '') ),
        events: {
            'submit #form-calification-task-mentoring': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            this.mentoringTaskList = new app.MentoringTaskList();

            this.mentoringCalificationTaskModel = new app.MentoringCalificationTaskModel();
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            this.$buttonRegistration = this.$('.register-calification');
            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentoringCalificationTaskModel, 'sync', this.responseServerRegistration );
            this.once( 'beforeRender', this.beforeRender );
            this.once( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            //get Tasks of mentoring
            this.getTask();

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },


        /**
        *  Get task from mentoring
        */
        getTask: function () {
            
            var taskView = new app.MentoringCalificationTaskListView({
                collection: this.mentoringTaskList,
                attributes: {
                    'mentoring': this.model.get('codigo_mentoria')
                }
            });
        },

        /**
        * Event Calification Task Mentoring
        */
        onStore: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            this.mentoringCalificationTaskModel.save( data, {patch: true, wait:true} );
        },

        /**
        * response of the server model calificationTask
        */
        responseServerRegistration: function ( model, resp, opts ) {
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ? 
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            } 
             
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );
            
            this.$buttonRegistration.removeClass('disabled');
            if( resp.success ){
                // Redirect to Content Session Mentoring
                url = Route.route('mentoria.{rol?}.sesiones.index', { 'rol' : 'mentor' }) ;
                Backbone.history.navigate(url, { trigger:true })
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        }

    });

})(jQuery, this, this.document);
/**
* Class MentoringCalificationTaskItemView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringCalificationTaskItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentoring-calification-task-detail-tpl').html() || '') ),
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
                    .fadeIn('slow');
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$taskForm );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            // response success or error

            var text = resp.success ? '' : resp.errors,
                type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
             
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': '#mentoring-content',
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if( re.success ){
                            $( '#form-task-mentoring [name="descripcion_tarea_mentoria"]' ).val('');
                            return;
                        }
                        _this.remove();
                        window.Misc.showAlertBox( conf );
                    }
                })(this.configAlert, resp, this)
            });
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringCalificationTaskListView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringCalificationTaskListView = Backbone.View.extend({

        el: '#container-calification-task-detail',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            /* if was passed mentoring code */
            if( !_.isUndefined(this.attributes.mentoring) && !_.isNull(this.attributes.mentoring) )
                 this.confCollection.data.codigo_mentoria = this.attributes.mentoring;

            // // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );

            this.collection.fetch( this.confCollection );
        },

        /*
        * Render View Element
        */
        render: function(){
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (mentoringTaskModel) {
            var view = new app.MentoringCalificationTaskItemView( { model: mentoringTaskModel } );
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a task of mentoring
        * @param form element
        */
        storeOne: function (form) {
            var data = window.Misc.formToJson( form );
            this.collection.create( data );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server    
        */
        responseServer: function ( collection, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        }
   });

})(jQuery, this, this.document);

/**
* Class EditMentor extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditMentor = Backbone.View.extend({

        el: '#mentoring-content',
        templateMentorTerms: _.template( ($('#edit-mentor-terms-form-tpl').html() || '') ),
        events: {
            'click .edit-field': 'onOpenEditForm',
            'change #aceptacion_terminos': 'onAcceptMentorTerms'
        },
        parameters: {
            'viewProfile': null
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.editForms = {
                'assistance': {'nameView': 'mentorEditAssistance', 'nameClassView': 'MentorEditAssistance', 'renderTo': '#mentor-asisstance-container .field-editing'},
                'experience': {'nameView': 'mentorEditExperience', 'nameClassView': 'MentorEditExperience', 'renderTo': '#mentor-experience-container .field-editing'},
                'expertise': {'nameView': 'mentorEditExpertise', 'nameClassView': 'MentorEditExpertise', 'renderTo': '#drop-edit-form-alt'},
                'specialities': {'nameView': 'mentorEditSpecialities', 'nameClassView': 'MentorEditSpecialities', 'renderTo': false},
                'economics': {'nameView': 'editPersonEconomicSectorList', 'nameClassView': 'EditPersonEconomicSectorList', 'renderTo': false},
                'level-development': {'nameView': 'mentorEditLevelDevelopment', 'nameClassView': 'MentorEditLevelDevelopment', 'renderTo': '#drop-edit-form-alt'},
                'socials': {'nameView': 'mentorEditSocials', 'nameClassView': 'MentorEditSocials', 'renderTo': '#drop-edit-form-alt'}
            };

            var _this = this;

            this.$('#mentor-terms-container').html( this.templateMentorTerms( this.model.toJSON()) );

            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

        },

        /*
        * Render View Element
        */
        render: function() {

            $(this.el).off('click', '.edit-field');
            $(this.el).off('change', '#aceptacion_terminos');

            this.delegateEvents({
                'click .edit-field': 'onOpenEditForm',
                'change #aceptacion_terminos': 'onAcceptMentorTerms'
            });



            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {

        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
        	if( _.has($.fn, 'foundation') ){
                $(document).foundation('tab', 'reflow');
                $(document).foundation('dropdown', 'reflow');
            }

            this.swicthEditForm('specialities');
            this.swicthEditForm('economics');
        },

        /**
        * open edit form
        */
        onOpenEditForm: function (e) {
            e.preventDefault();

            var nameFormTmpl = '',
                $editField = $(e.currentTarget);

            if( $editField.data('edit-template') ) {
                nameFormTmpl = $editField.data('edit-template');
            }

            this.swicthEditForm(nameFormTmpl);
        },

        /**
         * accept mentor terms
         */
        onAcceptMentorTerms: function (e) {
            e.preventDefault();
            e.stopPropagation();
            checked = e.target.checked;
            data = this.model.toJSON();
         
            if(checked)
            {      
                data['aceptacion_terminos'] = true;
                data['codigo_especialidad_destacada'] = this.model.get('codigo_especialidad');
                _this = this;
                this.model.save(data,
                    {
                        patch:true,
                        wait:true,
                        success: function(model, response){
                            if(response.success){
                                _this.$('#mentor-terms-container').html('');
                            }else{
                                console.log('error en aceptacion de terminos');
                                _this.$('#aceptacion_terminos').prop('checked', false);
                                checked = false;
                            }
                        },
                        error: function(){
                            console.log('error en aceptacion de terminos');
                            _this.$('#aceptacion_terminos').prop('checked', false);
                            checked = false;
                        }});
            }

        },


        /**
        * switch for edit forms
        * @param String nameForm
        */
        swicthEditForm: function (nameForm) {

            nameForm || (nameForm = '');

            var _this = this;

            var toRenderView = {

                'assistance' : function() {
                    _this.renderViewToEdit('assistance');

                    // React component simple-editor
                    ReactDOM.render(React.createElement(SimpleEditor, {
                        content: _this.model,
                        formCreate: nameForm,
                        value: _this.model.get('forma_ayuda_mentoria'),
                        name: "forma_ayuda_mentoria",
                        options: {
                            placeholder: 'En qué puedo ayudar',
                            toolbar: [
                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph', 'height']],
                                ['insert', ['link']]
                            ]
                        }
                    }, null), document.getElementById('form-mentor-help-editor'));
                },

                'experience' : function() {
                    _this.renderViewToEdit('experience');

                    // React component simple-editor
                    ReactDOM.render(React.createElement(SimpleEditor, {
                        content: _this.model,
                        formCreate: nameForm,
                        value: _this.model.get('experiencia_usuario'),
                        name: "experiencia_usuario",
                        options: {
                            placeholder: 'Ingresa tu experiencia',
                            toolbar: [
                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph', 'height']],
                                ['insert', ['link']]
                            ]
                        }
                    }, null), document.getElementById('form-project-editor'));
                },

                'expertise' : function() {
                    _this.renderViewToEdit('expertise', {
                        parameters: {
                            'dropdown': _this.editForms['expertise'].renderTo
                        }
                    });
                },

                'level-development' : function() {
                    _this.renderViewToEdit('level-development', {
                        parameters: {
                            'dropdown': _this.editForms['level-development'].renderTo
                        }
                    });
                },

                'specialities': function () {
                    var params = {
                        el: '#mentor-specialities-container',
                        collection: _this.parameters['specialities'],
                        parameters: {
                            'codigo_usuario': _this.parameters['user'],
                            'owner':  _this.parameters['owner']
                        }
                    };

                    _this.renderViewToEdit('specialities', params);
                },

                'economics': function () {
                    var params = {
                        el: '#mentor-economic-sector-container',
                        collection: _this.parameters['economics'],
                        parameters: {
                            'codigo_persona': _this.parameters['person'],
                            'owner':  _this.parameters['owner']
                        }
                    };

                    _this.renderViewToEdit('economics', params);
                },

                'socials' : function() {

                    _this.renderViewToEdit('socials', {
                        parameters: {
                            'dropdown': _this.editForms['socials'].renderTo
                        }
                    });
                },

                'default' : function() {
                    //
                }
            };

            if (toRenderView[nameForm]) {
                toRenderView[nameForm]();
            } else {
                toRenderView['default']();
            }
        },
       
        /**
        * to render edit view
        * @param String nameForm
        * @param Object params
        */
        renderViewToEdit: function (nameForm, params) {

            params || (params = {});

            var config = {
                model: this.model
            };
            _.extend( config, params );

            // if it exists form template
            if( this.editForms[nameForm] ) {

                if( this[this.editForms[nameForm].nameView] instanceof Backbone.View ){
                    this[this.editForms[nameForm].nameView].stopListening();
                    this[this.editForms[nameForm].nameView].undelegateEvents();
                    // this[this.editForms[nameForm].nameView].remove();
                }

                if( window.app[this.editForms[nameForm].nameClassView] !== undefined ) {

                    this[this.editForms[nameForm].nameView] = new window.app[this.editForms[nameForm].nameClassView]( config );
                    // set view inside container
                    if( this.editForms[nameForm].renderTo ){
                        this.$(this.editForms[nameForm].renderTo).html( this[this.editForms[nameForm].nameView].render().el );

                        // if( typeof this[this.editForms[nameForm].nameView].renderTagsPost == 'function' )
                        // 	this[this.editForms[nameForm].nameView].renderTagsPost();

                        // if( typeof this[this.editForms[nameForm].nameView].renderImportTags == 'function' )
                        // 	this[this.editForms[nameForm].nameView].renderImportTags();
                    }else {
                        this[this.editForms[nameForm].nameView].render();
                    }

                    // trigger fuctions plugin
                    if( _.has($.fn, 'foundation') ) {
                        this[this.editForms[nameForm].nameView].$el.foundation('abide');
                    }

                    // fire plugins
                    if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') ) {
                        window.initComponent.chosenTrigger();
                    }

                    if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') ) {
                        window.initComponent.select2Trigger();
                    }

                    if( typeof window.initComponent.initConfigForm == 'function' ) {
                        window.initComponent.initConfigForm();
                    }
                }
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MentorEditAssistance extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MentorEditAssistance = Backbone.View.extend({

		tagName: 'div',
		className: 'edit-form',
		template: _.template( ($('#edit-mentor-assistance-form-tpl').html() || '') ),
		events: {
			'submit #form-edit-mentor-assistance': 'onEditForm',
			'keydown .edit-field-text': 'revertOnEscape',
			// 'blur .edit-field-text': 'onEditForm'
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			// Init Attributes

			// Events Listener
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();
			this.$el.html( this.template(attributes) );

			// Initialize references
			this.$editFieldTxt = this.$('.edit-field-text');
			this.$formEdit = this.$('#form-edit-mentor-assistance');
			this.$wysiwygDescription = this.$('.wysiwyg-single-without-link');

			// Fire wysiwyg
			this.wysiwygTrigger();

			// reload plugins
			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();

			return this;
		},

		/**
		* update user fields
		*/
		onEditForm: function (e) {
			e.preventDefault();

			// if it is not editing
			if( !this.$el.parents('.editable-item').hasClass('editing') ){
				return;
			}

			var data = window.Misc.formToJson( this.$formEdit );
			// if the value was not modified
			if( window.Misc.trim(data['forma_ayuda_mentoria']) == window.Misc.trim(this.model.get('forma_ayuda_mentoria')) ){
				this.close();
				this.$editFieldTxt.blur();

				return;
			}

			// this.close(); // call before, because in the server response already the element doesn't exist
			this.model.save(data, {patch:true, wait:true});
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {
			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			if( resp.success ) {
				this.close();
			}
		},

		/**
		* on escape key event
		*/
		revertOnEscape: function  (e) {

			if( e.which === 27 ){
				this.close();
				this.$editFieldTxt.blur();
			}
		},

		/**
		* close field editing
		*/
		close: function () {

			this.$el.parents('.editable-item').removeClass('editing');
			this.$editFieldTxt.val( this.model.get('forma_ayuda_mentoria') );

			// if the edit field is wysiwyg
			if( this.$editFieldTxt.data('wysiwyg') ) {
				this.$editFieldTxt.data('wysiwyg').wysiwygeditor.setHTML( this.model.get('forma_ayuda_mentoria') );
			}
		},

		/**
		* Trigger wysiwyg
		*/
		wysiwygTrigger:  function () {

			window.wysiwygConfig.initialize('.wysiwyg-single-without-link', this.$wysiwygDescription);
		}
	});

})(jQuery, this, this.document);

/**
* Class MentorEditExperience extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEditExperience = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-mentor-experience-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-mentor-experience': 'onEditForm',
            'keydown .edit-field-text': 'revertOnEscape'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // Init Attributes

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Initialize references
            this.$editFieldTxt = this.$('.edit-field-text');
            this.$formEdit = this.$('#form-edit-mentor-experience');

            // reload plugins
            if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();

            return this;
        },

        /**
        * update user fields
        */
        onEditForm: function (e) {
            e.preventDefault();

            // if it is not editing
            if( !this.$el.parents('.editable-item').hasClass('editing') ){
                return;
            }

            var data = window.Misc.formToJson( this.$formEdit );
            // if the value was not modified
            if( window.Misc.trim(data['experiencia_usuario']) == window.Misc.trim(this.model.get('experiencia_usuario')) ){
                this.close();
                this.$editFieldTxt.blur();

                return;
            }

            // this.close(); // call before, because in the server response already the element doesn't exist
            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of server
        */
        responseServer: function ( target, resp, opts ) {

            if( resp.success ) {
                this.close();
            }
        },

        /**
        * on escape key event
        */
        revertOnEscape: function  (e) {

            if( e.which === 27 ){
                this.close();
                this.$editFieldTxt.blur();
            }
        },

        /**
        * close field editing
        */
        close: function () {

            this.$el.parents('.editable-item').removeClass('editing');
            this.$editFieldTxt.val( this.model.get('experiencia_usuario') );
        }
    });

})(jQuery, this, this.document);

/**
* Class MentorEditExpertise extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEditExpertise = Backbone.View.extend({

        tagName: 'div',
        id: 'container-form-expertise',
        className: 'edit-form',
        template: _.template( ($('#edit-mentor-expertise-form-tpl').html() || '') ),  
        events: {
            'submit #form-edit-mentor-expertise': 'onEditForm'
        },
        parameters: {
            'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Init Attributes

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer ); 
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

             // Initialize references

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el ); 
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            }); 

            if( this.parameters['dropdown'] !== false )           
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }

    });

})(jQuery, this, this.document);
/**
* Class MentoringCreateMentorView extends of Backbone View
* @author TuProyecto || Desarrolladores: @xindykatalina, @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringCreateMentorView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#profile-mentor-tpl').html() || '') ),
        templateMainImg: _.template( ($('#main-image-profile-mentor-tpl').html() || '') ),
        events: {
        	'submit #form-mentor-profile': 'onStore',
            'change .etapa_proyecto':'onChangeField'
        },
        parameters: {
           //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

            this.economicsList = new app.PersonEconomicSectorList();
            this.specialitiesList = new app.UserSpecialitiesList();

            this.mentorModel = new app.MentorModel();

            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);
            this.parameters['stage_mentoring'] = [];    
            //Init Attribute
            this.$modalImageCrop = $('#modal-image-mentor-profile');

            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };


            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change:codigo_usuario' , this.render );
            this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );

            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.mentorModel, 'sync', this.responseServer );

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            console.log('MentoringCreateMentorView', attributes);
            this.$el.html( this.template(attributes) );
         
            // Initialize attributes
            this.$wrapperDocuments = this.$('#wrap-documents');

            // overwrite model id attribute
            if( this.model.changed.codigo_usuario !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_usuario';
                this.model.set({'codigo_usuario': this.model.get('codigo_usuario')},{'silent':true});

                // reference to views
                this.referenceViews();
                this.renderMainImage();
            }

        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {

            // call image uploader crop
            this.setImgUploaderCrop();

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            var _this = this;

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

        },

        /**
        * reference to views
        */
        referenceViews: function () {

            this.economiccontainer = this.$('#mentor-economic-sector-container');

            this.personEconomicSectorList = new app.EditPersonEconomicSectorList( {
                el: this.economiccontainer,
                model: this.model,
                collection: this.economicsList,
                parameters: {
                    'economicsectors': this.economicsList,
                    'codigo_persona': this.model.get('codigo_persona'),
                    'owner': true
                }
            } );
            this.personEconomicSectorList.render();

            // EconomicSector
            this.economicsList.fetch({
                data: {codigo_persona: this.model.get('codigo_persona')},
                reset: true
            });

            this.specialitiescontainer = this.$('#mentor-specialities-container');


            if ( this.mentorEditSpecialities instanceof Backbone.View ){
                this.mentorEditSpecialities.stopListening();
                this.mentorEditSpecialities.undelegateEvents();

            }

            this.mentorEditSpecialities = new app.MentorEditSpecialities( {
                el: this.specialitiescontainer,
                model: this.model,
                collection: this.specialitiesList,
                parameters: {
                    'interests': this.specialitiesList,
                    'codigo_usuario': this.model.get('codigo_usuario'),
                    'owner': true
                }
            } );

            this.mentorEditSpecialities.render();

            // Specialities
            this.specialitiesList.fetch({
                data: {codigo_usuario: this.model.get('codigo_usuario')},
                reset: true
            });

            // Instance of Documents of Advice
            this.mentorAttachments = new app.MentorAttachments({
                el: this.$wrapperDocuments,
                model: this.model,
                parameters: {
                    //
                }
            });

            this.mentorAttachments.render();

            this.ready();

        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
             window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            // response success or error
            var text = resp.success ? resp.message : resp.errors,
                type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(re.success != undefined) {
                            if( re.success ){
                                // Redirect to Content Questions Mentoring
                                url = document.url + Route.route('mentoria.mentores.show', {'mentores': _this.model.get('nickname_usuario')});
                                window.Misc.showAlertBox( conf );

                                setTimeout(function(){
                                    return window.Misc.redirect(url);
                                }, 10000);
                            }else{
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * render main image
        */
        renderMainImage: function (model, value, opts) {

            this.$('#mentor-profile-main-image').html( this.templateMainImg( this.model.toJSON()) );
            this.ready();
        },


        // ===============================================================
        //              start of image uploader crop
        // ===============================================================

        /**
        * set image uploader crop
        */
        setImgUploaderCrop: function () {

            var _this = this;

            this.$el.imageUploaderCrop({
                formCrop: $('#form-mentor-profile-crop'),
                imgCrop: $('#image-mentor-profile-tocrop'),
                previewImg: $('#mentor-profile-preview-tocrop'),
                uploaderImg: $('#uploader-image-mentor-profile'),
                templateImgUploader: 'qq-img-uploader-template',
                configImg: {
                    maxWidthImg : 240 * 5,
	                maxHeightImg : 240 * 5,
	                minWidthImg : 240,
	                minHeightImg : 240
                },
                uploadding: {
                    inputName: 'file',
                    endpoint: document.url + Route.route('file.temp'),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                cropping: {
                    endpoint: document.url + Route.route('file.crop'),
                    params: {}
                },
                extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-mentor-profile')],
                // Events handlers
                callbacks: {
                    onLoadImg: function ($uploaderImg, id, name) {

                        var $areaDrop = $uploaderImg.fineUploader('getDropTarget', id);

                        if( $areaDrop !== undefined && $areaDrop.length ){
                            if( $areaDrop.hasClass('image-area-drop') ){

                                $(document).on('closed.fndtn.reveal', _this.$modalImageCrop, _this.closeModalImg);
                                _this.$modalImageCrop.foundation('reveal', 'open');
                            }
                        }

                        window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
                    },
                    onCompleteLoad: function ($uploaderImg, id, name, res) {
                        $uploaderImg.find('.qq-uploader').css( {'border': 'none'} );

                        window.Misc.removeSpinner({
                            'wrap': _this.$modalImageCrop,
                            'direct': false
                        });
                    },
                    onCropping: function (jcrop_img) {
                        window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
                    },
                    onCropComplete: function (jcrop_img, resp, jqXHR) {
                        // response success or error
                        var confCrop = {},
                            type = resp.success ? 'success' : 'alert',
                            text = resp.success ?
                                (resp.message !== undefined ? resp.message : '')
                                : resp.errors;

                        if( _.isObject( resp.errors ) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                 listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }

                        var conf = {
                            wrapper: _this.$modalImageCrop.find('.content-modal'),
                            text: text,
                            type: type
                        };
                        confCrop = $.extend({}, _this.configAlert, conf);

                        if( resp.success !== undefined ) {
                            if( resp.success ){
                                _this.model.set('imagen_usuario', resp.file_path);

                                _this.$modalImageCrop.foundation('reveal', 'close');
                            }else{
                                window.Misc.showAlertBox( confCrop );
                            }
                        }

                        window.Misc.removeSpinner({
                            'wrap': _this.$modalImageCrop,
                            'direct': false
                        });
                    },
                    onCropError: function (jcrop_img, jqXHR, error) {
                        var confCrop = {},
                            conf = {
                                wrapper: _this.$modalImageCrop.find('.content-modal'),
                                text: 'La imagen no puede ser ajustada.',
                                type: 'alert',
                                close: true
                            };

                        confCrop = $.extend({}, _this.configAlert, conf);

                        window.Misc.removeSpinner({
                            'wrap': _this.$modalImageCrop,
                            'direct': false
                        });
                        window.Misc.showAlertBox( confCrop );
                    }
                },
                messages: window._tp.messages
            });
        },

        /**
        * change project image main
        */
        onChangeImage: function (e) {

            if( e !== undefined )
                e.preventDefault();

            this.$modalImageCrop.on('opened', this.openModalImg);
            $(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

            this.$modalImageCrop.foundation('reveal', 'open');
        },

        /**
        * handler event with avatar modal is opened
        */
        openModalImg: function (e) {

            var _this = this;

            if( this.$el.data('imageUploaderCrop') !== undefined )
                this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_usuario'));
        },

        /**
        * handler event on crop modal is closed
        */
        closeModalImg: function (e) {

            if(e.namespace != 'fndtn.reveal') return;

            var $imgCrop = this.$el.imageUploaderCrop('getImgCrop'),
                jcrop_img = null;

            // check out if already was assigned the jcrop library
            if( $imgCrop.data('Jcrop') !== undefined ){
                jcrop_img = $imgCrop.data('Jcrop');
                jcrop_img.destroy();
            }

            // detach events
            this.$modalImageCrop.off('opened');
            $(document).off('closed.fndtn.reveal');
        },

        /**
        * change  fields
        */
       onChangeField: function(e) {
            e.preventDefault();        

            if( e.target.type === 'checkbox' && typeof e.target.value !== 'undefined' && !isNaN(parseInt(e.target.value))){
                this.parameters['changedLevelAttributes'] = true;
                this.parameters['stage_mentoring'].push(parseInt(e.target.value));
            }

            return;
        },

        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            var terms =  $("#aceptacion_terminos").is(":checked"); 
            data['stage_mentoring'] = this.parameters['stage_mentoring'];
            data['aceptacion_terminos'] = terms;
            console.log('onStoreData',data);
            this.mentorModel.save( data, {patch: true, wait: true} );
        }
   });

})(jQuery, this, this.document);

/**
* Class MentorEditLevelDevelopment extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEditLevelDevelopment = Backbone.View.extend({

        tagName: 'div',
        id: 'container-form-level-development',
        className: 'edit-form',
        template: _.template( ($('#edit-mentor-level-development-form-tpl').html() || '') ),  
        events: {
            'submit #form-edit-mentor-level-development': 'onEditForm',
            'change .etapa_proyecto':'onChangeField'
        },
        parameters: {
            'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            this.parameters['changedLevelAttributes'] = false;
            // Init Attributes

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer ); 
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

             // Initialize references

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            data['changed_level_attributes'] = this.parameters.changedLevelAttributes || false;   
            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el ); 
        },
        
        /**
        * change  fields
        */
       onChangeField: function(e) {
            e.preventDefault();        
            var attributes = this.model.toJSON();
            if( e.target.type === 'checkbox' ){
                this.parameters['changedLevelAttributes'] = true;
                }

            return;
        },
        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            }); 

            if( this.parameters['dropdown'] !== false )           
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }

    });

})(jQuery, this, this.document);
/**
* Class MentorEditSocials extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEditSocials = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        id: 'container-form-socials',
        template: _.template( ($('#edit-mentor-socials-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-mentor-socials': 'onEditForm'
        },
        parameters: {
            'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Init Attributes

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer ); 
        }, 

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            }); 

            if( this.parameters['dropdown'] !== false )           
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }
    });

})(jQuery, this, this.document);
/**
* Class MentorAttachments extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorAttachments = Backbone.View.extend({
        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#mentor-attachment-form-tpl').html() || '') ),
        events: {
           //
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onReadyFile', 'onCompleteLoadFile', 'onCompleteFetchFiles');

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

            // Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            // this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Initialize references
            this.$formEdit = this.$('#form-mentor-attachment');
            this.$uploaderFile = this.$('#fnuploader-attach-file');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            //trigger functions
            this.renderUploaderFile();

        	this.ready();
        },

        /**
		* execute with already
        */
        ready: function () {

        	// trigger functions
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

        	// reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'perfectScrollbar') && typeof window.initComponent.configScrollbar == 'function' )
            	window.initComponent.configScrollbar();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('normal', function (){
                _this.$el.remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            // response success or error
            var text = resp.success ? '' : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){
                var listError = '<ul>';
                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';
                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re) {
                    return function () {
                        if(!_.isUndefined(re.success)) {
                            if( !re.success ){
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp)
            });
        },

        /**
        * render files uploader
        */
        renderUploaderFile: function () {

			var _this = this;
			this.$uploaderFile.fineUploader({
				debug: false,
				template: 'qq-attachments-mentor-template',
				session: {
					endpoint: window.Misc.urlFull(Route.route('adjunto.usuario.index')),
					params: {
						'codigo_usuario': _this.model.get('codigo_usuario')
					},
					refreshOnRequest: false
				},
				request: {
					inputName: 'file',
					endpoint: window.Misc.urlFull(Route.route('adjunto.usuario.index')),
					customHeaders: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
					},
					params: {
						'_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_usuario': _this.model.get('codigo_usuario'),
                        'codigo_documento': window._tp.docAttached['curriculum'],
                        'codigo_privacidad_contenido': window._tp.typePrivacy['private']
					}
				},
				deleteFile: {
					enabled: true,
					endpoint: window.Misc.urlFull(Route.route('adjunto.usuario.index')),
					customHeaders: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
					},
					params: {
						'_token': $('meta[name="csrf-token"]').attr('content'),
						'codigo_usuario': _this.model.get('codigo_usuario')
					},
					forceConfirm: true,
                    confirmMessage: window._tp.confirmMessage
				},
				// form: {
				//     element: 'form-survey-base',
				//     interceptSubmit: false
				// },
				thumbnails: {
					placeholders: {
						waitingPath: window.Misc.urlFull('img/waiting-generic.png'),
						notAvailablePath: window.Misc.urlFull('img/not_available-generic.png')
					}
				},
				autoUpload: true,
				multiple: false,
				validation: {
					allowedExtensions: ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'pps', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'zip'],
					itemLimit: 0,
					stopOnFirstInvalidFile: false,
					sizeLimit: (12 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
				},
				// Events handlers
				callbacks: {
					onSubmitted: _this.onReadyFile,
					onComplete: _this.onCompleteLoadFile,
					onSessionRequestComplete: _this.onCompleteFetchFiles
				},
				dragAndDrop: {
					extraDropzones: []
				},
                text: window._tp.text,
                messages: window._tp.messages,
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
			});
        },

        /**
        * when the file is put over loader
        * @param Number id
        * @param String name
        */
        onReadyFile: function (id, name) {

            this.ready();
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {

            var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.uuid);
            this.itemWasLoaded($itemFile, resp);
        },

        /**
        * on complete fetch files
        * @param Array resp | object array
        * @param Boolean succcess
        */
        onCompleteFetchFiles: function (resp, success) {

            var _this = this,
                count = 0;

            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( success ) {
                _.each(resp, function(file) {

                    var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', count);
                    this.itemWasLoaded($itemFile, file);

                    count++;
                }, this);
            }
        },

        /**
        *
        */
        itemWasLoaded: function ($itemFile, fileObj) {
            $itemFile.find('.preview-link').attr('href', fileObj.direccion_adjunto);

            var $fieldFile = this.$('#direccion_adjunto');
            $fieldFile.val( fileObj.direccion_adjunto );

            this.onReadyFile();
        }
    });

})(jQuery, this, this.document);

/**
* Class MentorEditSpecialities extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MentorEditSpecialities = Backbone.View.extend({

		el: '#mentor-specialities-container',
		events: {
			'change #codigo_especialidad': 'onChangeSpecialty'
        },
		parameters: {
			codigo_usuario: '',
            owner: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onAccept');

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

			// Init Attributes
			this.$noResults = this.$('.no-results-filter');
			this.$fieldEditing = this.$('.select-specialities-mentor');
			this.$wrapperData = this.$('.list-specialities-mentor');
            this.$modalOtherSpecialty = $('#modal-mentor-other-specialty-tp');

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

            // custom event handler
            $('#form-mentor-other-specialty').off('submit', this.onAccept);
            $('#form-mentor-other-specialty').on('submit', this.onAccept);
		},

		/*
		* Render View Element
		*/
		render: function() {

			if( this.collection.length )
				this.$noResults.css('display', 'none');

			return this;
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();
		},

        onChangeSpecialty: function (e) {
            e.preventDefault();
            if( $(e.currentTarget).val() == window._tp.getTypeSpecialty['other'] ){
                this.$modalOtherSpecialty.foundation('reveal', 'open');
            }else{
                this.onEditForm();
            }
        },

        onAccept: function (e) {
            e.preventDefault();
            var descriptionSpecialty = $(e.currentTarget).find('#descripcion_especialidad').val();
            this.onEditForm( descriptionSpecialty );
        },

		/**
		* update specialities
		*/
		onEditForm: function (data) {
            data || (data = null);

			attributes = {
                'codigo_especialidad': this.$('#codigo_especialidad').find('option:selected').val(),
                'descripcion_especialidad': !_.isNull(data) ? data : '',
                'codigo_usuario': this.parameters['codigo_usuario'],
                '_token': $('meta[name="csrf-token"]').attr('content')
            }

			if( _.isUndefined(this.collection.findWhere( {'codigo_especialidad': parseInt(attributes['codigo_especialidad']) } )) ){

				this.loadSpinnerAdd();
				this.collection.create(attributes, {patch:true, wait:true});

				return;
			}

			this.render();
		},

		/**
		* Render view theme by model
		* @param Object specialitiesModel Model instance
		*/
		addOne: function (specialitiesModel) {
			var view = new app.MentorSpecialitiesItemView( {
				model: specialitiesModel,
				parameters: {
					codigo_usuario: this.parameters['codigo_usuario'],
                    owner: this.parameters['owner']
				}
			} );
			this.$wrapperData.append( view.render().el );
		},

		/**
		* Render all view theme of the collection
		*/
		addAll: function () {

			this.$wrapperData.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {

			this.$noResults.css('display', 'none');

			if( target instanceof Backbone.Collection )
				window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinnerAdd: function ( target, xhr, opts ) {

			window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length )
				this.$noResults.fadeIn('fast');

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});

            this.$modalOtherSpecialty.foundation('reveal', 'close');
            this.$modalOtherSpecialty.find('#descripcion_especialidad').val('');
		}
	});

})(jQuery, this, this.document);

/**
* Class MentorSpecialitiesItemView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorSpecialitiesItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#specialities-item-mentor-tpl').html() || '') ),
        events: {
            'click .remove-specialities': 'onRemove'
        },
        parameters: {
            codigo_usuario: '',
            owner: ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.owner = this.parameters['owner'];

            this.$el.html( this.template(attributes) );
            return this;
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Remove element
        */
        onRemove: function (e) {
            e.preventDefault();

            this.model.destroy({
                'processData': true,
                wait: true,
                data: { '_token': $('meta[name="csrf-token"]').attr('content'), codigo_usuario: this.parameters['codigo_usuario'] }
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of server
        */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class EditPersonEconomicSectorList extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/
//Global App Backbone

app || (app = {});

(function ($, window, document, undefined) {

	app.EditPersonEconomicSectorList = Backbone.View.extend({

		el: '#list-economic-sector-mentor',
		events: {
			'change #codigo_sector_economico': 'onEditForm'
		},
		parameters: {
			codigo_persona: '',
			owner: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

		    _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

			// Init Attributes
			this.$noResults = this.$('.no-results-filter');
			this.$fieldEditing = this.$('.select-economic-sector-mentor');
			this.$wrapperData = this.$('.list-economic-sector-mentor');

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function() {

			if( this.collection.length )
				this.$noResults.css('display', 'none');

			return this;
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();


		},

		/**
		* update project fields
		*/
		onEditForm: function (e) {
			e.preventDefault();

			data = {
				'codigo_sector_economico': this.$('#codigo_sector_economico').find('option:selected').val(),
				'codigo_persona': this.parameters['codigo_persona'],
				'_token': $('meta[name="csrf-token"]').attr('content')
			}
			if( _.isUndefined(this.collection.findWhere( {'codigo_sector_economico': parseInt(data['codigo_sector_economico']) } )) ){

				this.loadSpinnerAdd();
				this.collection.create(data, {patch:true, wait:true});

				return;
			}

			this.render();
		},

		/**
		* Render view theme by model
		* @param Object economicSectorModel Model instance
		*/
		addOne: function (economicSectorModel) {

			var view = new app.PersonEconomicSectorItemView( {
				model: economicSectorModel,
				parameters: { 
					codigo_persona: this.parameters['codigo_persona'],
					owner: this.parameters['owner']
				 }
			} );
			this.$wrapperData.append( view.render().el );
		},

		/**
		* Render all view theme of the collection
		*/
		addAll: function () {

			this.$wrapperData.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {

			this.$noResults.css('display', 'none');

			if( target instanceof Backbone.Collection )
				window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinnerAdd: function ( target, xhr, opts ) {

			window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length )
				this.$noResults.fadeIn('fast');

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		}
	});

})(jQuery, this, this.document);

/**
* Class PersonEconomicSectorItemView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PersonEconomicSectorItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#economic-sector-item-tpl').html() || '') ),
        events: {
            'click .remove-economic-sector': 'onRemove'
        },
        parameters: {
            codigo_usuario: '',
            owner: ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.owner = this.parameters['owner'];

            this.$el.html( this.template(attributes) );

            return this;
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Remove element
        */
        onRemove: function (e) {
            e.preventDefault();

            this.model.destroy({
                'processData': true,
                wait: true,
                data: { '_token': $('meta[name="csrf-token"]').attr('content'), codigo_persona: this.parameters['codigo_persona'] }
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of server
        */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class MentorListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MentorListView = Backbone.View.extend({

		el: '#mentoring-mentors',
		template: _.template( ($('#mentor-list-tpl').html() || '') ),
		events: {
			'keyup #mentoring-name': 'onFilterMentorName'
		},
		parameters: {
			rol: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function( opts ){
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');


			if( opts !== undefined && _.isObject(opts.parameters) ){
				_.extend( this.parameters, opts.parameters );
			}
			//Init Attributes
			// this.configAlert = {
			//     'wrapper': '#main-wrap',
			//     'closeTime': 6000,
			//     'speedOpen': 500,
			//     'speedClose': 500
			// };

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.collection, 'change', this.render );
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );
			this.on('getData', this.getFirstData);

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );


			$( window ).on("scroll", this.onLoadMore);
		},

		/*
		* Render View Element
		*/
		render: function () {

			var _this = this,
				attributes = {};

			attributes.rol = this.parameters['rol'];
			attributes.dataFilter = this.parameters['dataFilter'];

			this.$el.html( this.template(attributes) );

			//Init Attributes
			this.$blockFilters = this.$('.block-filters-choice');
			this.$formFilters =  this.$('#form-filters-mentor');
			this.$wrapperData = this.$('#list-mentoring-mentor');
			this.$spinnerEvents = $('<div>').attr('id','spinner-load-questions');

			// set block filter
			this.$blockFilters.each(function(index, el) {
				var blockFilter = new app.FilterData({
					el: el,
					collection: _this.collection,
					parameters: {
						'nameForm': '#form-filters-mentor',
						'callBackFilter': function (newDataFilter) {
							app.AppRouter.navigate( Route.route('mentoria.mentores.index', newDataFilter), {trigger: false, replace: true} );
							_this.trigger('getData', newDataFilter, true);
						},
						'dataFilter': _.extend({
							// 'rol':_this.parameters.rol
						}, _this.parameters.dataFilter)
					}
				});
			});

			return this;
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

		},

		/**
		* get firsts data
		* @param Object dataFilter
		*/
		getFirstData: function (dataFilter, replace) {

			dataFilter || (dataFilter = {});
			replace || (replace = false);

			if(replace) {
				this.parameters.dataFilter = dataFilter;
			}else{
				_.extend( this.parameters.dataFilter, dataFilter );
			}

			this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
			this.pageOld = this.collection.state.currentPage;

		},

		/**
		* Render view theme by model
		* @param Object personModel Model instance
		*/
		addOne: function (personModel) {

			var nameViewClass = 'MentorItemView';

			var view = new app[nameViewClass]({
				model: personModel,
				parameters: {
					rol: this.parameters['rol']
				}
			});
			this.$wrapperData.append( view.render().el );
		},

		/**
		* Render all view theme of the collection
		*/
		addAll: function () {

			this.$wrapperData.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (target, xhr, opts) {

			if( target instanceof Backbone.Collection ) {
				this.$spinnerEvents.appendTo( this.$('.content-data-list') );
			}else{
				this.$spinnerEvents.prependTo( this.$('.content-data-list') );
			}
			window.Misc.setSpinner( this.$spinnerEvents );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		},

		onFilterMentorName: function (e) {
			e.preventDefault();
	
			var dataFilter = window.Misc.formToJson(this.$('#form-filters-mentor'));
			//dataFilter.user = this.parameters['user'];
		
			this.getFirstData(dataFilter);
		},

		/**
		* load more
		*/
		onLoadMore: function (e) {

			e.preventDefault();

			var _this = this;
			var scrollHeight = $(document).height();
			var scrollPosition = $(window).height() + $(window).scrollTop();

			if ((scrollHeight - scrollPosition) / scrollHeight <= 0.001) {

				// when scroll to bottom of the page
				if( this.collection.state.currentPage < this.collection.state.lastPage && this.pageOld == this.collection.state.currentPage ){

					this.collection.getNextPage({
						data: _.clone(this.parameters.dataFilter),
						wait: true,
						success: function (collection) {
							_this.pageOld = collection.state.currentPage;
						}
					});
				}
			}
		}
	});

})(jQuery, this, this.document);

/**
* Class MentorItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentor-item-tpl').html() || '') ),
        events: {

        },
        parameters: {
            'rol': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.rol = this.parameters['rol'];
            
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        }

    });

})(jQuery, this, this.document);
/**
* Class ProfileMentorView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProfileMentorView = Backbone.View.extend({

		el: '#mentoring-content',
		template: _.template( ($('#mentor-detail-tpl').html() || '') ),
		templateCalendar: _.template( ($('#calendar-mentoring-tpl').html() || '') ),
		templateSessionsCalendar: _.template( ($('#mentoring-session-calendar-list-item').html() || '') ),
		templateAsisstance: _.template( ($('#info-assistance-mentor-tpl').html() || '') ),
		templateExperience: _.template( ($('#info-experience-mentor-tpl').html() || '') ),
		templateExpertise: _.template( ($('#info-expertise-mentor-tpl').html() || '') ),
		templateLevelDev: _.template( ($('#info-level-development-mentor-tpl').html() || '') ),
		templateSocials: _.template( ($('#info-socials-mentor-tpl').html() || '') ),
		templateMainImg: _.template( ($('#main-image-profile-mentor-tpl').html() || '') ),
		events: {
			'click #change-image-mentor-profile': 'onChangeImage',
			'click #recommendation-mentor': 'onRecommendationMentor',
			'click #request-advisory': 'onRequestAdvisory'
		},
		parameters: {
		   //
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg',
			'onEventSelect', 'onEventClick','renderEventEdit','renderEventSchedule', 'renderEventScheduleAdviser',
			'addAllSession', 'addOneSession', 'responseServer', 'loadSpinner');


			this.setElement( this.el );

			// extends parameters
			if( opts.parameters !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attribute
			this.$modalImageCrop = $('#modal-image-mentor-profile');
			this.$calendarMentoring = $('#calendar-mentoring');
			this.economicsList = new app.PersonEconomicSectorList();
			this.specialitiesList = new app.UserSpecialitiesList();

			this.userProfileModel = new app.UserModel();
			this.recommendationModel = new app.RecommendationModel();
			this.mentoringSessionList = new app.MentoringSessionList();

			this.eventMentoring = new app.EventModel();
			this.eventCalendarModel = new app.EventModel();
			this.scheduleMentoring = new app.ConfirmScheduleMentoringView({ model:this.eventMentoring });
            this.createEventView = new app.UserRequestMentoringView({ model:this.eventCalendarModel });
			this.scheduleAdviser = new app.ScheduleAdviserView({
                model:this.eventMentoring
            });


			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			this.$modalBase = $('#modal-base-tp');
			this.$modalBaseMaterial = $('#modal-base-message-tp');
			this.$modalAdvisory = $('#modal-request-mentor-advisory');


			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			this.$type = 'encrypt';

			// Events Listener
			this.listenTo( this.model, 'change:id', this.render );
			this.listenTo( this.model, 'change:forma_ayuda_mentoria', this.renderInfoAsisstance );
			this.listenTo( this.model, 'change:experiencia_usuario', this.renderInfoExperience );
			this.listenTo( this.model, 'change:codigo_especialidad', this.renderInfoExpertise );
			this.listenTo( this.model, 'change:stage_mentoring', this.renderInfoLevelDev );
			this.listenTo( this.model, 'change:linkedin_usuario', this.renderInfoSocials );
			this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );
			this.listenTo( this.model, 'sync', this.responseServer );
			this.listenTo( this.model, 'request', this.loadSpinner );

			// Sessions Listener
			this.listenTo( this.mentoringSessionList, 'add', this.addOneSession );
            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );
            this.listenTo( this.mentoringSessionList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringSessionList, 'sync', this.responseServer );


			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
            this.listenTo( this.scheduleAdviser, 'schedule', this.setScheduleAdviser );
            this.listenTo( this.createEventView, 'addevent', this.createEvent );
            this.listenTo( this.createEventView, 'editevent', this.editEvent );
            this.listenTo( this.createEventView, 'removeevent', this.removeEvent );


			// Change modal title
			this.$modalBase.find('.inner-title-modal').html('Solicitud Mentoria').attr('area-title');
			this.$modalBaseMaterial.find('.inner-title-modal').html('Recomendar Mentor').attr('area-title');
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();
			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$wrapperDocuments = this.$('#wrap-documents');

			this.$wrapperData = this.$('#body-sesiones-calendario');

			this.mentoringSessionList.fetch({reset:true});

			// overwrite model id attribute
			if( this.model.changed.id !== undefined ) {

				// Overwrite id attribute of the model
				this.model.idAttribute = 'codigo_usuario';
				this.model.set({'codigo_usuario': this.model.get('codigo_usuario')},{'silent':true});

				// reference to views
				this.referenceViews();
				this.renderMainImage();
				this.renderInfoAsisstance();
				this.renderInfoExperience();
				this.renderInfoExpertise();
				this.renderInfoLevelDev();
				this.renderInfoSocials();
			}
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			if(window.Misc.checkSession(false)) {
				// call image uploader crop
				 this.setImgUploaderCrop();

				// $(document).on('opened.fndtn.reveal', this.$el, this.scheduleMentoring );

				this.scheduleMentoring;
				// set calendar
				this.setCalendar();


			}

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {

			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('dropdown', 'reflow');
				$(document).foundation('tab', 'reflow');
			}

			// reload plugins
			if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'spinner') )
				window.initComponent.spinnerTrigger();

			if( typeof(window.initComponent.configSticky) == 'function' && _.has($.fn, 'sticky') )
				window.initComponent.configSticky();

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* reference to views
		*/
		referenceViews: function () {

			// Instance edit project view
			this.editMentor = new app.EditMentor({
				el: this.$el,
				model: this.model,
				parameters: {
					'economics': this.economicsList,
					'specialities': this.specialitiesList,
					'user': this.model.get('codigo_usuario'),
					'person': this.model.get('codigo_persona'),
					'owner': this.model.get('owner')
				}
			});

			// EconomicSector
			this.economicsList.fetch({
				data: {codigo_persona: this.model.get('codigo_persona')},
				reset: true
			});

			// Specialities
			this.specialitiesList.fetch({
				data: {codigo_usuario: this.model.get('codigo_usuario')},
				reset: true
			});

			// Instance of Documents of Advice
            this.mentorAttachments = new app.MentorAttachments({
                el: this.$wrapperDocuments,
                model: this.model,
                parameters: {
                    //
                }
            });


			this.mentorAttachments.render();
			var attributes = {};
			attributes.codigo_proyecto = this.codigo_proyecto;

			  this.$calendarMentoring = this.$('#calendar-mentoring');
			if( this.editMentor )
				this.editMentor.render();

		},


		/**
		 * Render all view of Sessions
		 */
        addAllSession: function() {
            this.$wrapperData.html('');

            this.mentoringSessionList.forEach( this.addOneSession, this );

		},

		/**
		 *  render session item
		 * @param {} mentoringModel
		 */
		addOneSession: function (mentoringModel) {
			this.$wrapperData.append(this.templateSessionsCalendar(mentoringModel.toJSON()));

            // // refresh plugins
            this.ready();
        },

		// ==============================================
		//           start calendar
		// ==============================================
		setCalendar: function () {
            var _this = this;

            this.$calendarMentoring.fullCalendar({
                header: {
                  left: 'prevYear, prev,next, nextYear today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                lang: 'es',
                defaultDate: moment(),
                defaultView: 'month',
                selectable: true,
                editable: true,
                dragOpacity: .75,
                weekNumbers: false,
				aspectRatio: 650/300,
				contentHeight: 'auto',
				eventSources: [
                    {
                        url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                        type: 'GET',
                        data: {
							'type': 'schedule',
							'event':'mentoring',
                            'codigo_usuario': _this.model.get('codigo_usuario')
                        },
                        error: function (jqXHR, status, error) {
                            console.log('error::', status, error);
                        },
                        success: this.successRequetsEvents,
                        editable: true
                    }
                ],
                select: this.onEventSelect,
                eventClick: this.onEventClick
			});

			if( this.$calendarMentoring.data('fullCalendar') !== undefined )
				this.$calendarMentoring.fullCalendar('render');
		},



	 /**
        * response of events
        * @param Object resp
        */
	   successRequetsEvents: function () {
		// body...
		},

		/**
        * handler zone selected on calendar
        */
	   onEventSelect: function  ( start, end, jsEvent, view ) {
		var calendar = this.$calendarMentoring.fullCalendar('getCalendar'),
			attrsEvent = {
				start: calendar.moment(start).format('YYYY-MM-DD HH:mm'),
				end: calendar.moment(end).format('YYYY-MM-DD HH:mm'),
				now: calendar.moment().format('YYYY-MM-DD HH:mm')
			};

			var owner =  this.model.get('owner');


		if( owner && attrsEvent['now'] < attrsEvent['end'])
		{
			this.renderEventEdit(attrsEvent);
		}

	},


        /**
        * handler event click on calendar
        * @param Object calEvent
        * @param Object jsEvent
        * @param Object view
        */
	   onEventClick: function  (calEvent, jsEvent, view) {
		var calendar = this.$calendarMentoring.fullCalendar('getCalendar'),
			attrsSchedule = {
				start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
				end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
				stateEvent: _.find(calEvent.className, function (eventClasses) {
					return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed' || eventClasses == 'unregistered';
				})
			};

		if( calEvent.className.indexOf('available') !== -1 && calEvent.className.indexOf('disabled') === -1  && typeof(calEvent.owner) !== 'undefined' && calEvent.owner && calEvent.clase_tipo_evento == window._tp.getClassTypeEvent['user']){
			_.extend(attrsSchedule, {
				start: calendar.moment( calEvent.start ).format('YYYY-MM-DD HH:mm'),
				end: calendar.moment( calEvent.end ).format('YYYY-MM-DD HH:mm')
			});
			this.renderEventEdit(attrsSchedule, calEvent);

		}else if( calEvent.codigo_evento !== undefined && calEvent.className.indexOf('disabled') === -1 ){
			this.renderEventScheduleAdviser(attrsSchedule, calEvent);
		}
		else if( calEvent.className.indexOf('disabled') === -1 ){
			this.renderEventSchedule(attrsSchedule, calEvent);
		}
	},

	  /**
        * render calendar schedule mentoring
        */
	   scheduleMentoring: function  () {
		// render calendar
		if( this.$calendarMentoring.data('fullCalendar') !== undefined ){
			this.$calendarMentoring.fullCalendar('render');
		}
	},

	renderEventEdit: function (attrsEvent, calEvent) {
		attrsEvent || (attrsEvent = {});
		calEvent || (calEvent = {});
		this.createEventView.attrsEvent = attrsEvent;
		this.createEventView.calEvent = calEvent;
		this.eventCalendarModel.resetAttrs({silent:true});

		if(  !_.isUndefined(calEvent) && !_.isEmpty(calEvent) &&  !_.isUndefined(calEvent.codigo_evento) ){
			this.eventCalendarModel.set('codigo_evento', calEvent.codigo_evento);
			this.eventCalendarModel.fetch({data: {type:this.$type , processData: true}});
			this.createEventView.render();
		}else{
			this.createEventView.render();
		}

		this.createEventView.$el.dialog('open');
	},

	renderEventSchedule: function (attrsSchedule, calEvent) {
		attrsSchedule || (attrsSchedule = {});
		calEvent || (calEvent = {});

		this.scheduleMentoring.attrsSchedule = attrsSchedule;
		this.scheduleMentoring.calEvent = calEvent;
		this.eventMentoring.resetAttrs({silent:true});
		this.eventMentoring.set('codigo_evento', calEvent.codigo_evento);
		this.eventMentoring.fetch({data: {type:this.$type , processData: true}});

		this.scheduleMentoring.$el.dialog('open');
	},

	renderEventScheduleAdviser: function (attrsSchedule, calEvent) {
		attrsSchedule || (attrsSchedule = {});
		calEvent || (calEvent = {});
		var type = 'encrypt';
		this.scheduleAdviser.attrsSchedule = attrsSchedule;
		this.scheduleAdviser.calEvent = calEvent;
		this.eventMentoring.resetAttrs({silent:true});
		this.eventMentoring.set('codigo_evento', calEvent.codigo_evento );
		this.eventMentoring.fetch({data: {type:type , processData: true}});
		this.scheduleAdviser.render();
		this.scheduleAdviser.$el.dialog('open');
	},




		// ==============================================
		//           start image uploader and crop
		// ==============================================

		/**
		* set image uploader crop
		*/
		setImgUploaderCrop: function () {

			var _this = this;

			this.$el.imageUploaderCrop({
				formCrop: $('#form-mentor-profile-crop'),
				imgCrop: $('#image-mentor-profile-tocrop'),
				previewImg: $('#mentor-profile-preview-tocrop'),
				uploaderImg: $('#uploader-image-mentor-profile'),
				templateImgUploader: 'qq-img-uploader-template',
				configImg: {
					maxWidthImg : 240 * 4,
					maxHeightImg : 240 * 4,
					minWidthImg : 240,
					minHeightImg : 240
				},
				uploadding: {
					inputName: 'file',
					endpoint: document.url + Route.route('file.temp'),
					customHeaders: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
					},
					params: {
						'_token': $('meta[name="csrf-token"]').attr('content')
					}
				},
				cropping: {
					endpoint: document.url + Route.route('file.crop'),
					params: {}
				},
				extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-mentor-profile')],
				// Events handlers
				callbacks: {
					onLoadImg: function ($uploaderImg, id, name) {

						var $areaDrop = $uploaderImg.fineUploader('getDropTarget', id);

						if( $areaDrop !== undefined && $areaDrop.length ){
							if( $areaDrop.hasClass('image-area-drop') ){

								$(document).on('closed.fndtn.reveal', _this.$modalImageCrop, _this.closeModalImg);
								_this.$modalImageCrop.foundation('reveal', 'open');
							}
						}

						window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
					},
					onCompleteLoad: function ($uploaderImg, id, name, res) {
						$uploaderImg.find('.qq-uploader').css( {'border': 'none'} );

						window.Misc.removeSpinner({
							'wrap': _this.$modalImageCrop,
							'direct': false
						});
					},
					onCropping: function (jcrop_img) {
						window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
					},
					onCropComplete: function (jcrop_img, resp, jqXHR) {
						// response success or error
						var confCrop = {},
							type = resp.success ? 'success' : 'alert',
							text = resp.success ?
								(resp.message !== undefined ? resp.message : '')
								: resp.errors;

						if( _.isObject( resp.errors ) ){

							var listError = '<ul>';

							$.each(resp.errors, function(field, item) {
								 listError += '<li>'+ item[0] +'</li>';
							});
							listError += '</ul>';

							text = listError;
						}

						var conf = {
							wrapper: _this.$modalImageCrop.find('.content-modal'),
							text: text,
							type: type
						};
						confCrop = $.extend({}, _this.configAlert, conf);


						if( resp.success !== undefined ) {
							if( resp.success ){

								_this.model.save({'imagen_usuario': resp.file_path}, {
									patch: true,
									wait: true
								});

								_this.$modalImageCrop.foundation('reveal', 'close');
							}else{
								window.Misc.showAlertBox( confCrop );
							}
						}

						window.Misc.removeSpinner({
							'wrap': _this.$modalImageCrop,
							'direct': false
						});
					},
					onCropError: function (jcrop_img, jqXHR, error) {
						var confCrop = {},
							conf = {
								wrapper: _this.$modalImageCrop.find('.content-modal'),
								text: 'La imagen no puede ser ajustada.',
								type: 'alert',
								close: true
							};

						confCrop = $.extend({}, _this.configAlert, conf);

						window.Misc.removeSpinner({
							'wrap': _this.$modalImageCrop,
							'direct': false
						});
						window.Misc.showAlertBox( confCrop );
					}
				},
                messages: window._tp.messages
			});
		},

		/**
		* change project image main
		*/
		onChangeImage: function (e) {

			if( e !== undefined )
				e.preventDefault();

			this.$modalImageCrop.on('opened', this.openModalImg);
			$(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

			this.$modalImageCrop.foundation('reveal', 'open');
		},

		/**
		* handler event with avatar modal is opened
		*/
		openModalImg: function (e) {

			var _this = this;

			if( this.$el.data('imageUploaderCrop') !== undefined )
				this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_usuario'));
		},

		/**
		* handler event on crop modal is closed
		*/
		closeModalImg: function (e) {

			if(e.namespace != 'fndtn.reveal') return;

			var $imgCrop = this.$el.imageUploaderCrop('getImgCrop'),
				jcrop_img = null;

			// check out if already was assigned the jcrop library
			if( $imgCrop.data('Jcrop') !== undefined ){
				jcrop_img = $imgCrop.data('Jcrop');
				jcrop_img.destroy();
			}

			// detach events
			this.$modalImageCrop.off('opened');
			$(document).off('closed.fndtn.reveal');
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function () {
			 window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': true
			});
		},

		/**
		* render main image
		*/
		renderMainImage: function (model, value, opts) {

			this.$('#mentor-profile-main-image').html( this.templateMainImg( this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info asisstance
		*/
		renderInfoAsisstance: function (model, value, opts) {

			this.$('#mentor-asisstance-container .content-assistance-mentoring').removeClass('editing').html( this.templateAsisstance(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info experience
		*/
		renderInfoExperience: function (model, value, opts) {
			this.$('#mentor-experience-container .content-experience-mentor').removeClass('editing').html( this.templateExperience(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Expertise
		*/
		renderInfoExpertise: function (model, value, opts) {

			this.$('#mentor-expertise-container').html( this.templateExpertise(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Level Development
		*/
		renderInfoLevelDev: function (model, value, opts) {

			this.$('#mentor-level-development-container').html( this.templateLevelDev(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Socials
		*/
		renderInfoSocials: function (model, value, opts) {
			this.$('#mentor-socials-container').html( this.templateSocials(this.model.toJSON()) );
			this.ready();
		},

		/**
        * listen when adviser was scheduled
        */
	   setScheduleAdviser: function () {
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

         /**
        * create event on calendar
        */
       createEvent: function (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarMentoring.fullCalendar('renderEvent', calEvent, true);
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

        /**
        * edit event on calendar
        */
        editEvent: function  (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarMentoring.fullCalendar('updateEvent', calEvent);
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

        /**
        * remove event on calendar
        */
        removeEvent: function (idEvent) {
            this.$calendarMentoring.fullCalendar('removeEvents', idEvent);
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

		/**
		* Event request mentoring
		*/
		onRecommendationMentor: function (e) {

			if( e !== undefined)
				e.preventDefault();

			// Reference to view recommendation mentor
			if ( this.recommendationMentorView instanceof Backbone.View ){
				this.recommendationMentorView.stopListening();
				this.recommendationMentorView.undelegateEvents();
				this.recommendationMentorView.remove();
			}

			this.recommendationMentorView = new app.RecommendationMentorView({
				model: this.recommendationModel,
				parameters: {
					type: 'mentor',
					institution: this.model.get('institucion')
				}
			});

			this.$modalBaseMaterial.find('.inner-title-modal').html( $(e.currentTarget).attr('area-title') ).removeClass('text-center');
			this.$modalBaseMaterial.find('.content-modal').html( this.recommendationMentorView.render().el );
			this.$modalBaseMaterial.foundation('reveal', 'open');
        },


		/**
		* Event request mentoring
		*/
		onRequestAdvisory: function (e) {

            if( e !== undefined)
            e.preventDefault();
            e.stopImmediatePropagation();

            // Reference to view requestAdvisory
			if ( this.requestAdvisory instanceof Backbone.View ){
				this.requestAdvisory.stopListening();
				this.requestAdvisory.undelegateEvents();
				this.requestAdvisory.remove();
			}

			this.requestAdvisory = new app.RequestAdvisoryView({
				model: this.model,
				parameters: {
				   //
				}
            });


           // this.$modalBase.find('.inner-title-modal').html( $(e.currentTarget).attr('area-title') ).removeClass('text-center');
            this.$modalAdvisory.find('.content-modal').html( this.requestAdvisory.render().el );
            this.$modalAdvisory.foundation('reveal', 'open');

		}


   });

})(jQuery, this, this.document);

/**
* Class MentoringAvailabilityView extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringAvailabilityView = Backbone.View.extend({

        el: '#mentoring-availability',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onEventClick', 'onEventSelect');
            //Init Attributes
            this.eventMentoring = new app.EventModel();
            this.scheduleMentoring = new app.ConfirmScheduleMentoringView({ model:this.eventMentoring });
            this.eventCalendarModel = new app.EventModel();
            this.createEventView = new app.UserCreateEventView({ model:this.eventCalendarModel });

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            this.$type = 'encrypt';

            // Events Listener
            this.listenTo( this.scheduleMentoring, 'schedule', this.setConfirmSchedule );
            this.listenTo( this.createEventView, 'addevent', this.createEvent );
            this.listenTo( this.createEventView, 'editevent', this.editEvent );
            this.listenTo( this.createEventView, 'removeevent', this.removeEvent );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this;

            //Initialize Reference to elements
            this.$calendarAvailability = this.$('#calendar-availability');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {
            // set calendar
            this.setCalendar();
        },

        /**
        * set calendar for user
        */
        setCalendar: function () {
            var _this = this;

            this.$calendarAvailability.fullCalendar({
                header: {
                  left: 'prevYear, prev,next, nextYear today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                lang: 'es',
                defaultDate: moment(),
                defaultView: 'month',
                selectable: true,
                editable: true,
                dragOpacity: .75,
                weekNumbers: false,
                aspectRatio: 650/300,
                eventSources: [
                    {
                        url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                        type: 'GET',
                        data: {
                            'type': 'schedule'
                        },
                        error: function (jqXHR, status, error) {
                            console.log('error::', status, error);
                        },
                        success: this.successRequetsEvents,
                        editable: false
                    }
                ],
                select: this.onEventSelect,
                eventClick: this.onEventClick
            });

            if( this.$calendarAvailability.data('fullCalendar') !== undefined )
                this.$calendarAvailability.fullCalendar('render');
        },

        /**
        * response of events
        * @param Object resp
        */
        successRequetsEvents: function () {
            // body...
        },

        /**
        * handler zone selected on calendar
        */
        onEventSelect: function  ( start, end, jsEvent, view ) {
            // console.log( 'event select:', start, end, jsEvent, view );
            var calendar = this.$calendarAvailability.fullCalendar('getCalendar'),
                attrsEvent = {
                    start: calendar.moment(start).format('YYYY-MM-DD HH:mm'),
                    end: calendar.moment(end).format('YYYY-MM-DD HH:mm')
                };

            this.renderEventEdit(attrsEvent);
        },

        /**
        * handler event click on calendar
        * @param Object calEvent
        * @param Object jsEvent
        * @param Object view
        */
        onEventClick: function  (calEvent, jsEvent, view) {
            var calendar = this.$calendarAvailability.fullCalendar('getCalendar'),
                attrsSchedule = {
                    start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
                    end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
                    stateEvent: _.find(calEvent.className, function (eventClasses) {
                        return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed';
                    })
                };

            if( calEvent.className.indexOf('available') !== -1 && calEvent.className.indexOf('disabled') === -1 ){
                _.extend(attrsSchedule, {
                    start: calendar.moment( calEvent.start ).format('YYYY-MM-DD HH:mm'),
                    end: calendar.moment( calEvent.end ).format('YYYY-MM-DD HH:mm')
                });
                this.renderEventEdit(attrsSchedule, calEvent);
                
            }else if( calEvent.className.indexOf('disabled') === -1 ){
                this.renderEventShedule(attrsSchedule, calEvent);
            }
        },

        renderEventEdit: function (attrsEvent, calEvent) {

            attrsEvent || (attrsEvent = {});
            calEvent || (calEvent = {});

            this.createEventView.attrsEvent = attrsEvent;
            this.createEventView.calEvent = calEvent;
            this.eventCalendarModel.resetAttrs({silent:true});

            if( !_.isEmpty(calEvent) && calEvent.codigo_evento ){
                this.eventCalendarModel.set('codigo_evento', calEvent.codigo_evento);
                this.eventCalendarModel.fetch({data: {type:this.$type , processData: true}});
            }else{
                this.createEventView.render();
            }

            this.createEventView.$el.dialog('open');
        },

        renderEventShedule: function (attrsSchedule, calEvent) {

            this.scheduleMentoring.attrsSchedule = attrsSchedule;
            this.scheduleMentoring.calEvent = calEvent;
            this.eventMentoring.resetAttrs({silent:true});
            this.eventMentoring.set('codigo_evento', calEvent.codigo_evento);
            this.eventMentoring.fetch({data: {type:this.$type , processData: true}});

            this.scheduleMentoring.$el.dialog('open');
        },

        /**
        * listen when adviser schedule was confirmed
        */
        setConfirmSchedule: function () {
            this.$calendarAvailability.fullCalendar('removeEvents');
            this.$calendarAvailability.fullCalendar('refetchEvents');
        },

        /**
        * create event on calendar
        */
        createEvent: function (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarAvailability.fullCalendar('renderEvent', calEvent, true);
        },

        /**
        * edit event on calendar
        */
        editEvent: function  (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarAvailability.fullCalendar('updateEvent', calEvent);
        },

        /**
        * remove event on calendar
        */
        removeEvent: function (idEvent) {
            this.$calendarAvailability.fullCalendar('removeEvents', idEvent);
        }
    });

})(jQuery, this, this.document);

/**
* Class ConfirmRemoveProcessMentoringView extends of Backbone View
* @author TuProyecto || Desarrollador : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ConfirmRemoveProcessMentoringView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#mentoring-confirm-remove-tpl').html() || '') ),
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
        	_.extend( this.parameters, opts.parameters );

        	// Init Attributes
        },

        /*
        * Render View Element
        */
        render: function() {
        	var attributes = {};
            this.$el.find('.content-modal').html( this.template(attributes) );

            // Change modal title
            this.$el.find('.inner-title-modal').html( this.parameters['titleConfirm'] );
            this.$el.foundation('reveal', 'open');

        	// delegate events
        	$(this.el).off();
            this.delegateEvents({
            	'click .confirm-action': 'onConfirm'
            });

            return this;
        },

        /**
        * Mentoring Close Confirm
        */
        onConfirm: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            this.$el.foundation('reveal', 'close');
            this.model.destroy({
            	processData: true,
            	wait: true,
            	data: {
            		'_token':$('meta[name="csrf-token"]').attr('content')
            	}
           	});
        }
   });

})(jQuery, this, this.document);

/**
* Class MentorEvaluationView extends of Backbone View
* @author TuProyecto || Desarrollador: @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEvaluationView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#evaluation-mentor-tpl').html() || '') ),
        events: {
        	'submit #form-mentor-evaluation': 'onStore'
        },
        parameters: {
           //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');


            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);

            //Init Attribute
            this.mentorEvaluationModel = new app.MentorEvaluationModel();
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };


            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change:codigo_asesoria' , this.render );

            // this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentorEvaluationModel, 'sync', this.responseServerRegistration );


            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );
            // Initialize attributes

            // overwrite model id attribute
            if( this.model.changed.codigo_asesoria !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_asesoria';
                this.model.set({'codigo_asesoria': this.model.get('codigo_asesoria')},{'silent':true});

                // reference to views
                this.referenceViews();
            }

        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            var _this = this;

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

        },

        /**
        * reference to views
        */
        referenceViews: function () {

            this.ready();

        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
             window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            // response success or error
            var text = resp.success ? '' : resp.errors,
                type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(re.success != undefined) {
                            if( re.success ){
                                // window.Misc.redirect(re.redirect);
                            }else{
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * response of the server model calificationTask
        */
        responseServerRegistration: function ( model, resp, opts ) {
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ?
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            if( resp.success ){
                // Redirect to Content Questions Mentoring
                url = Route.route('mentoria.preguntas.index') ;
                Backbone.history.navigate(url, { trigger:true })
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        },

        /**
        * Event Evaluation Items Mentor
        */
        onStore: function (e) {

            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            data.codigo_asesoria = this.model.get('codigo_asesoria');
            data.referee = this.model.get('emprendedor') ? window._tp.typeItemMentoring['entrepreneurship'] : window._tp.typeItemMentoring['mentor'];
            this.mentorEvaluationModel.save( data, {patch: true, wait:true} );
        }

   });

})(jQuery, this, this.document);

/**
* Class MentoringQuestionDocuments extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionDocuments = Backbone.View.extend({
        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#question-documents-form-tpl').html() || '') ),
        events: {
           //
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onReadyFile', 'onCompleteLoadFile', 'onCompleteFetchFiles');

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

            // Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Initialize references
            this.$formEdit = this.$('#form-question-documents');
            this.$uploaderFile = this.$('#fnuploader-attach-file');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            //trigger functions
            this.renderUploaderFile();
            // if(!this.model.get('owner')){
               // this.$el.find("#button-upload").css('display', 'none');
               // this.$el.find("#bar-progress").css('display', 'none');
            // }

        	this.ready();
        },

        /**
		* execute with already
        */
        ready: function () {

        	// trigger functions
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

        	// reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'perfectScrollbar') && typeof window.initComponent.configScrollbar == 'function' )
            	window.initComponent.configScrollbar();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('normal', function (){
                _this.$el.remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            // response success or error
            var text = resp.success ? '' : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){
                var listError = '<ul>';
                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';
                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re) {
                    return function () {
                        if(!_.isUndefined(re.success)) {
                            if( !re.success ){
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp)
            });
        },

        /**
        * render files uploader
        */
        renderUploaderFile: function () {

            var _this = this;
            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-attachments-advice-template',
                session: {
                    endpoint: window.Misc.urlFull(Route.route('adjunto.asesoria.index')),
                    params: {
                        'codigo_asesoria': _this.model.get('codigo_asesoria')
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('adjunto.asesoria.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_asesoria': _this.model.get('codigo_asesoria')
                    }
                },
                deleteFile: {
                    enabled: true,
                    endpoint: window.Misc.urlFull(Route.route('adjunto.asesoria.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_asesoria': _this.model.get('codigo_asesoria')
                    },
                    forceConfirm: true,
                    confirmMessage: window._tp.confirmMessage
                },
                form: {
                    element: 'form-question-documents',
                    interceptSubmit: true
                },
                thumbnails: {
                    placeholders: {
                        waitingPath: window.Misc.urlFull('img/waiting-generic.png'),
                        notAvailablePath: window.Misc.urlFull('img/not_available-generic.png')
                    }
                },
                autoUpload: false,
                multiple: true,
                validation: {
                    // allowedExtensions: ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx'],
                    itemLimit: 0,
                    sizeLimit: (12 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
                },
                // Events handlers
                callbacks: {
                    onSubmitted: _this.onReadyFile,
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onCompleteFetchFiles
                },
                dragAndDrop: {
                    extraDropzones: []
                },
                text: window._tp.text,
                messages: window._tp.messages,
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
            });
        },

        /**
        * when the file is put over loader
        * @param Number id
        * @param String name
        */
        onReadyFile: function (id, name) {

            this.ready();
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {

            var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.uuid);
            this.itemWasLoaded($itemFile, resp);
        },

        /**
        * on complete fetch files
        * @param Array resp | object array
        * @param Boolean succcess
        */
        onCompleteFetchFiles: function (resp, success) {

            var _this = this,
                count = 0;

            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' ){
                window.initComponent.chosenTrigger();
            }

            if( success ) {
                _.each(resp, function(file) {
                    var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', count);
                    this.itemWasLoaded($itemFile, file);

                    count++;
                }, this);
            }
        },

        /**
        *
        */
        itemWasLoaded: function ($itemFile, fileObj) {

            if(!fileObj.owner){
                $itemFile.find('a').remove('.qq-upload-delete-selector');
            }

            // add address from file
            $itemFile.find('.preview-link').attr('href', fileObj.direccion_adjunto);

            // add date from file
            $itemFile.find('.date-file').html('<em>' +window.moment(fileObj.fecha_adjunto).format("dddd[,] DD [de] MMMM") +'</em>, '+ window.moment(fileObj.fecha_adjunto).format("YYYY") +' - <em>'+ window.moment(fileObj.fecha_adjunto).format("hh:mm A") + ' </em>');

            // reload plugins function
            this.onReadyFile();
        }
    });

})(jQuery, this, this.document);

/**
* Class ProcessMentoringList extends of Backbone View
* @author TuProyecto || Desarrollador : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProcessMentoringList = Backbone.View.extend({
        el: '#mentoring-process-main',
        template: _.template( ($('#mentoring-process').html() || '') ),
        templateNotResultSessions: _.template( ($('#not-result-sessions-tpl').html() || '') ),
        templateNotResultMentoring: _.template( ($('#not-result-mentoring-tpl').html() || '') ),
        events: {
            'click .redirect___Mentoring': 'onRedirectMentoring',
        },
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
        	_.extend( this.parameters, opts.parameters );

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}


            // Initialize

            this.mentoringQuestionList = new app.MentoringQuestionList();

            // Initialize
            this.mentoringSessionList = new app.MentoringSessionList();

        	// Init Attributes

            this.listenTo( this.collection, 'reset', this.onReset ); // collectionSessions
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.listenTo( this.mentoringQuestionList, 'reset', this.onResetMentoring );
            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );

            this.on('getData', this.getFirstData); // getDataSessions
            
            this.on('getDataMentoringAll', this.getFirstDataMentoringAll);

          

        },

        /*
        * Render View Element
        */
        render: function() {
            this.$el.html(this.template());

            this.$wrapperData = this.$('#mentoring-process-main');
            this.$wrapperSessions = this.$('#container-sessions-proccess');
            this.$wrapperMentoringPending = this.$('#container-mentoring-pending-proccess');
            this.$wrapperMentoringAll= this.$('#container-mentoring-all-proccess');

        },

        /**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

        ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();
        },

        getFirstData: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.parameters.dataFilter.state = window._tp.getState['pending'];
            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
        },

        getFirstDataMentoringPending: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.parameters.dataFilter.state = window._tp.getState['pending'];

            this.mentoringQuestionList.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.mentoringQuestionList.state.currentPage;
        },

        getFirstDataMentoringAll: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.parameters.dataFilter.state = '';

            this.mentoringQuestionList.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.mentoringQuestionList.state.currentPage;
        },


        addOne: function(model) {

            var view = new app.MentoringItemSessionList({
                model: model,
                parameters: {
                    //
                }
            });

            this.$wrapperSessions.append( view.render().el );

            // refresh plugins
            this.ready();
        },

        onReset: function(collection) {

            this.$wrapperData.html('');

            if (this.collection.length > 0) {
                this.collection.forEach( this.addOne, this );
            } else {
                this.notResultSessions();
            }
        },

        notResultSessions: function() {
            this.$wrapperSessions.html(this.templateNotResultSessions());
        },

        addOneMentoring: function(model) {
            var attributes = model.toJSON();

            if (attributes.codigo_estado === window._tp.getState['active']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: ''
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
            }


            if (attributes.codigo_estado === window._tp.getState['pending']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringPending'
                    }
                });

                this.$wrapperMentoringPending.append( view.render().el );
            }

            if (attributes.codigo_estado === window._tp.getState['closed']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringFinish'
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
            }

            if (attributes.codigo_estado === window._tp.getState['finalized']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringFinish'
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
            }

           if (attributes.codigo_estado === window._tp.getState['rejected']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringRejected'
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
           }

            // refresh plugins
            this.ready();
        },

        onResetMentoring: function(collection) {

            this.$wrapperData.html('');

            if (this.mentoringQuestionList.length > 0) {
                this.mentoringQuestionList.forEach( this.addOneMentoring, this );
            } else {

                //this.notResultMentoring();
            }
        },

        notResultMentoring: function() {

            this.$wrapperMentoringPending.html(this.templateNotResultMentoring());
            this.$wrapperMentoringAll.html(this.templateNotResultMentoring());
        },

        addOneSession: function (mentoringModel) {

            var view = new app.MentoringItemSessionList({
                model: mentoringModel,
                parameters: {
                    //
                }
            });

            this.$wrapSessionMentoring.append( view.render().el );

            // refresh plugins
            this.ready();
        },

         /**
         * Render all view of Sessions
         */

        addAllSession: function() {
            this.$wrapperData.html('');
            this.mentoringSessionList.forEach( this.addOneSession, this );
        },

        onRedirectMentoring: function(e) {
            e.preventDefault();

            var mentoring = $(e.currentTarget).data('mentoring');

            // Redirect to Mentoring Content
            url = Route.route('mentoria.mentores.procesos.show', { procesos: mentoring }) ;
            Backbone.history.navigate(url, { trigger:true });
        },

             /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },
   });

})(jQuery, this, this.document);

/**
* Class ProcessMentor extends of Backbone View
* @author TuProyecto || Desarrollador : @rfigueredo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProcessMentor = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#mentoring-feedback-tpl').html() || '') ),
        templateAttachedMentoring: _.template( ($('#attached-mentoring-tpl').html() || '') ),
        templateDiscusionMentoring: _.template( ($('#discusion-mentoring-tpl').html() || '') ),
        templateDevelopmentSession: _.template( ($('#form-session-development').html() || '') ),
        templateTitleSession: _.template( ($('#title-session-tpl').html() || '') ),
        templateSessionProcessList: _.template( ($('#mentoring-sessions-process-list-tpl').html() || '') ),
        templateTaskItem: _.template( ($('#mentoring-task-session-item-tpl').html() || '') ),
        templateTagsItem: _.template( ($('#mentoring-tags-session-item-tpl').html() || '') ),
        templateSessionContent: _.template( ($('#session-content-tpl').html() || '') ),
        templateNotResultSessions: _.template( ($('#not-result-sessions-calendar-tpl').html() || '') ),
        events: {
            'click .modify__Session': 'onModifySession',
            'click .modify__Session_Finished': 'onModifySessionFinished',
            'click .cancel__Session': 'onCancelSesion',
            'click .back__Tosession': 'onBackSession',
            'click .conclude__Mentoring' : 'onConclude',
            'click .accept__Mentoring': 'onAccept',
            'click .refuse__Mentoring': 'onRefuse',
            'click .cancel__Mentoring': 'onRefuse',
            'click .add-mentoring-task-session': 'onAddTask',
            'click .add-mentoring-description-session': 'onAddDescription',
            'keypress #mentoring-task-session': 'onAddTask',
            'click .remove-mentoring-task-session': 'onRemoveTask',
            'click .remove-mentoring-tags-session': 'onRemoveTags',
            'click .add-mentoring-tags-session': 'onAddTag',
            'keypress #mentoring-tags-title': 'onAddTag',
            'click .add-mentoring-objetive-general-session': 'onAddGeneralObjetive',
        },
        parameters: {
        	//
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
            _.extend( this.parameters, opts.parameters );
            _.bindAll(this, 'beforeRender', 'render', 'afterRender',
            'onBackSession', 'addAllSession', 'addOneSession', 'onCancelSesion',
            'responseItemDelete', 'responseServer', 'loadSpinner');



        	//Init Attributes
            this.configAlert = {
                'wrapper': '#mentoring-wrapper',
                'closeTime': 4000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            this.confCollection = { reset: true, data: {} };

            this.$wrapperData = this.$('.body-session-content');
            this.listTaskWrapper = this.$('.body-session-content').find('#mentoring-task-session-list');
            this.listTagsWrapper = this.$('.body-session-content').find('#mentoring-tags-session-list');
            this.$noResults = this.$('.no-results-filter');
            this.discussionList = new app.DiscussionList();

            this.mentoringSessionList = new app.MentoringSessionList();

            this.mentoringTaskList = new app.MentoringTaskList();

            this.mentoringTagsList = new app.MentoringTagsList();

            this.mentoringSessionModel =   new app.MentoringModel;


            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentoringSessionList, 'add', this.addOneSession );
            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );
            this.listenTo( this.mentoringSessionList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringSessionList, 'sync', this.responseServer );
            this.listenTo( this.mentoringSessionList, 'remove', this.responseItemDelete );
            this.listenTo( this.mentoringTaskList, 'add', this.addOneTask );
            this.listenTo( this.mentoringTaskList, 'reset', this.addAllTask );
            this.listenTo( this.mentoringTaskList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringTaskList, 'sync', this.responseServer );
            this.listenTo( this.mentoringTaskList, 'remove', this.responseItemDelete );
            this.listenTo( this.mentoringTagsList, 'add', this.addOneTags );
            this.listenTo( this.mentoringTagsList, 'reset', this.addAllTags );
            this.listenTo( this.mentoringTagsList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringTagsList, 'sync', this.responseServer );
            this.listenTo( this.mentoringTagsList, 'remove', this.responseItemDelete );
        },

       /*
        * Render View Element
        */
       render: function() {
        var attributes = {};

        var attributes = this.model.toJSON();
        attributes.finished = false;

        this.$wrapperRenderSession = this.$('#mentoring-session');

        this.$wrapperRenderSession.html( this.template(attributes) );
        this.$wrapperBodySesion = this.$('.body-session-content');

        // Render attach mentoring
        this.$('#attachedMentoring').html(this.templateAttachedMentoring(attributes));

        // Render discusion mentoring
        this.$('#discusionMentoring').html(this.templateDiscusionMentoring(attributes));

        this.mentoringSessionList.fetch({reset:true, data: { advisory: attributes.codigo_asesoria }});


        this.referenceView();
    },


        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
            var _this = this;

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        referenceView: function() {
             // Reference to view mentoring sessions
            if ( this.mentoringSessions instanceof Backbone.View ){
                this.mentoringSessions.stopListening();
                this.mentoringSessions.undelegateEvents();
                this.mentoringSessions.remove();
            }


            // Instance of Discucion component
            this.discussionListView = new app.DiscussionListView({
                collection: this.discussionList,
                parameters: {
                    'formDiscussion': '#form-discussion-advice',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_mentoria'),
                        'codigo_modulo': window._tp.getModule('mentoring')
                    }
                }
            });

            // Instance of Documents of Advice
            this.mentoringQuestionDocuments = new app.MentoringQuestionDocuments({
                el: this.$wrapperRenderSession.find('#wrap-documents'),
                model: this.model,
                parameters: {
                    //
                }
            });

            this.mentoringQuestionDocuments.render();

        },

        noResultsAttached: function() {
            var attributes = this.model.toJSON();

            this.$wrapperRenderSession.find('#wrap-documents').html( this.templateNotResultSessions(attributes) );
        },

        onConclude: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("onConclude");
            var _this = this,
                data = {
                    action: 'conclude'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-end-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de finalizar la asesoría/mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

                                    var listError = '<ul>';

                                    $.each(resp.errors, function(field, item) {
                                        listError += '<li>'+ item[0] +'</li>';
                                    });
                                    listError += '</ul>';

                                    text = listError;
                                }

                                var config = {
                                    'text': text,
                                    'type': type
                                };
                                _.extend( _this.configAlert, config );

                                Backbone.history.navigate(Route.route('mentoria.preguntas.evaluacion.mentor.create', {
                                    user: model.get('codigo_asesoria') } ), { trigger:true });
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        onAccept: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this,
                data = {
                    action: 'accept'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-accept-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de aceptar la mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

                                    var listError = '<ul>';

                                    $.each(resp.errors, function(field, item) {
                                        listError += '<li>'+ item[0] +'</li>';
                                    });
                                    listError += '</ul>';

                                    text = listError;
                                }

                                var config = {
                                    'text': text,
                                    'type': type
                                };
                                _.extend( _this.configAlert, config );

                                Backbone.history.loadUrl();
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        onRefuse: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this,
                data = {
                    action: 'refuse'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-refuse-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de rechazar la mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

                                    var listError = '<ul>';

                                    $.each(resp.errors, function(field, item) {
                                        listError += '<li>'+ item[0] +'</li>';
                                    });
                                    listError += '</ul>';

                                    text = listError;
                                }

                                var config = {
                                    'text': text,
                                    'type': type
                                };
                                _.extend( _this.configAlert, config );

                                Backbone.history.loadUrl();
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        onCancel: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this,
                data = {
                    action: 'refuse'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-refuse-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de rechazar la mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

                                    var listError = '<ul>';

                                    $.each(resp.errors, function(field, item) {
                                        listError += '<li>'+ item[0] +'</li>';
                                    });
                                    listError += '</ul>';

                                    text = listError;
                                }

                                var config = {
                                    'text': text,
                                    'type': type
                                };
                                _.extend( _this.configAlert, config );

                                Backbone.history.navigate(Route.route('mentoria.preguntas.index') );
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        addOneSession: function (mentoringModel) {

            if ( view instanceof Backbone.View ){
                view.stopListening();
                view.undelegateEvents();
                view.remove();
            }

            var view = new app.MentoringSessionListItemView({
                model: mentoringModel,
                parameters: {
                    //rol: this.parameters['rol']
                }
            });
            this.$('.body-session-content').append( view.render().el );
        },

        addOneTask: function (taskModel) {

            this.listTaksWrapper = this.$('.body-session-content').find('#mentoring-task-session-list');
            this.listTaksWrapper.append(this.templateTaskItem(taskModel.toJSON()));

        },

        addOneTags: function (tagsModel) {
            var attributes = tagsModel.toJSON();
            attributes.finished = this.mentoringSessionModel.get('finished');

            this.listTagsWrapper = this.$('.body-session-content').find('#mentoring-tags-session-list');
            this.listTagsWrapper.append(this.templateTagsItem(attributes));

        },

        onModifySession: function(e) {
            e.preventDefault();
            e.stopPropagation();
            _this = this;
            this.mentoringTaskList.reset();
            this.mentoringTagsList.reset();
            this.listTaskWrapper.html("");
            this.listTagsWrapper.html("");
            var id = $(e.target).data('id') || null, finished = $(e.target).data('finished');
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            var attributes = typeof this.mentoringSessionModel !== 'undefined' ? this.mentoringSessionModel.toJSON() : {};
            attributes.finished = finished;

            var modelAttributes = this.model.toJSON();
            modelAttributes.finished = finished;

            // Set parameter in Model
            this.mentoringSessionModel.set({finished: finished});

            /* if was passed mentoring code */
            if( !_.isUndefined(attributes.codigo_mentoria) && !_.isNull(attributes.codigo_mentoria) )
            {
                this.confCollection.data.codigo_mentoria = attributes.codigo_mentoria;
                this.mentoringTaskList.fetch( this.confCollection,{success: function(model, response) {
                    attributes.tareas = _this.mentoringTaskList.toJSON();
                    _this.$('.body-session-content').html(_this.templateDevelopmentSession(attributes));
                    _this.$el.find('.title-session').html(_this.templateTitleSession({ list: true }));
                } } );
                this.mentoringTagsList.fetch(this.confCollection, { success: function(model, response) {
                    attributes.tags = _this.mentoringTagsList.toJSON();
                } });

            }

            this.$('.body-session-content').html(this.templateDevelopmentSession(attributes));
            this.$el.find('.title-session').html(this.templateTitleSession({ list: true }));

            // Render other components
            this.$('#attachedMentoring').html(this.templateAttachedMentoring(modelAttributes));
            this.$('#discusionMentoring').html(this.templateDiscusionMentoring(modelAttributes));

            this.referenceView();
        },

        /**
         * Mentoring Fisnished Session
         */
        onModifySessionFinished: function(e) {
            e.preventDefault();
            e.stopPropagation();
            _this = this;
            this.mentoringTaskList.reset();
            this.mentoringTagsList.reset();
            this.listTaskWrapper.html("");
            this.listTagsWrapper.html("");
            var id = $(e.target).data('id') || null, finished = $(e.target).data('finished');
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            var attributes = typeof this.mentoringSessionModel !== 'undefined' ? this.mentoringSessionModel.toJSON() : {};
            attributes.finished = finished;

            var modelAttributes = this.model.toJSON();
            modelAttributes.finished = finished;

            var data = {
                'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
            }

            // Method POST to change state of Mentoring
            $.post(document.url + Route.route('mentoria.sesiones.finalizar'), data, function(resp) {
                var text = resp.success ? resp.message : resp.errors,
                type = resp.success ? 'success' : 'alert';

                if( _.isObject(resp.errors) ){

                    var listError = '<ul>';

                    $.each(resp.errors, function(field, item) {
                        listError += '<li>'+ item[0] +'</li>';
                    });
                    listError += '</ul>';

                    text = listError;
                }
            });

            // Set parameter in Model
            this.mentoringSessionModel.set({finished: finished});

            /* if was passed mentoring code */
            if( !_.isUndefined(attributes.codigo_mentoria) && !_.isNull(attributes.codigo_mentoria) )
            {
                this.confCollection.data.codigo_mentoria = attributes.codigo_mentoria;
                this.mentoringTaskList.fetch( this.confCollection,{success: function(model, response) {
                    attributes.tareas = _this.mentoringTaskList.toJSON();
                    _this.$('.body-session-content').html(_this.templateDevelopmentSession(attributes));
                    _this.$el.find('.title-session').html(_this.templateTitleSession({ list: true }));
                } } );
                this.mentoringTagsList.fetch(this.confCollection, { success: function(model, response) {
                    attributes.tags = _this.mentoringTagsList.toJSON();
                } });

            }

            this.$('.body-session-content').html(this.templateDevelopmentSession(attributes));
            this.$el.find('.title-session').html(this.templateTitleSession({ list: true }));

            // Render other components
            this.$('#attachedMentoring').html(this.templateAttachedMentoring(modelAttributes));
            this.$('#discusionMentoring').html(this.templateDiscusionMentoring(modelAttributes));

            this.referenceView();
        },

        /**
        * destroy Mentoring
        */
        onCancelSesion: function (e) {

            e.preventDefault();
            e.stopPropagation();
            var id = $(e.currentTarget).data('id') || null;
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            if(typeof this.mentoringSessionModel !== 'undefined' &&  this.mentoringSessionModel instanceof Backbone.Model )
            {
                this.confirmRemove = new app.ConfirmRemoveProcessMentoringView({
                    model:   this.mentoringSessionModel ,
                    parameters: {
                    'titleConfirm' : '¿Estás seguro que quieres cancelar esta mentoría?'
                    }
                });

                this.confirmRemove.render();
                this.mentoringSessionList.reset(this.mentoringSessionList.toJSON());
            }
        },

        onBackSession: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            this.$('.body-session-content').html("");
            this.$el.find('.title-session').html(this.templateTitleSession({ list: false }));
            this.mentoringSessionList.reset(this.mentoringSessionList.toJSON());
        },

        /**
         * Render all view of Sessions
         */

        addAllSession: function() {
            //this.$wrapperData.html('');
            this.$('.body-session-content').html('');
            this.mentoringSessionList.forEach( this.addOneSession, this );
            this.$el.find('.title-session').html(this.templateTitleSession({ list: false }));
        },

        /**
         * Render all view of Sessions
         */

        addAllTask: function() {
            this.listTaskWrapper.html("");
            this.mentoringTaskList.forEach( this.addOneTask, this );

        },

        /**
         * Render all view of Sessions
         */

         addAllTags: function() {
            this.listTagsWrapper.html("");
            this.mentoringTagsList.forEach( this.addOneTags, this );

        },

        /**
        * add a new target to the adviser schedule
        */
        onAddTask: function (e) {

        var codeKey = e.keyCode || e.which;
        var _this = this;
            if( e.type == 'keypress' ){
                if( codeKey !== 13 )
                    return;
            }else{
                e.preventDefault();
                e.stopImmediatePropagation();
            }

            this.listTaskWrapper = this.$('.body-session-content').find('#mentoring-task-session-list');
            var $fieldTaskInput =  this.$('.body-session-content').find('#mentoring-task-session');

            var fieldTask = $fieldTaskInput.val() || '';
                fieldTask = fieldTask.trim();

            if( fieldTask.length ){


                var taskModel = new app.MentoringTaskModel({
                    descripcion_tarea_mentoria: fieldTask,
                    codigo_mentoria: this.mentoringSessionModel.get('codigo_mentoria')
                });

                window.Misc.setSpinner( this.$el );

                taskModel.save({
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')}
                },{success: function(model, resp) {

                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false
                    });

                    _this.mentoringTaskList.reset(_this.mentoringTaskList.toJSON());

                    var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

                                    var listError = '<ul>';

                                    $.each(resp.errors, function(field, item) {
                                        listError += '<li>'+ item[0] +'</li>';
                                    });
                                    listError += '</ul>';

                                    text = listError;
                                }

                                var config = {
                                    'text': text,
                                    'type': type
                                };
                                _.extend( _this.configAlert, config );

                    if( resp.success ){

                        _this.mentoringTaskList.add(model);
                        $fieldTaskInput.val('');

                    }else{
                        window.Misc.showAlertBox( _this.configAlert );
                    }




                }});

            }



            if( codeKey === 13 ) return false;
    },

    onAddDescription: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldDescriptionMentoring =  this.$('.body-session-content').find('#mentoring-description');
        var fieldDescriptionMentoring = $fieldDescriptionMentoring.val() || '',
        fieldDescriptionMentoring = fieldDescriptionMentoring.trim();
        var data = {
            'description': fieldDescriptionMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        $.post(document.url + Route.route('mentoria.sesiones.descripcion'), data, function(resp) {
            window.Misc.setSpinner( this.$el );

            var text = resp.success ? resp.message : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject(resp.errors) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                    listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );
        });
    },

    /**
    * add a new target to the adviser schedule
    */
    onRemoveTask: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(e.currentTarget).data('id') || null;
            var li =   $(e.target).parents('li');

            var taskModel = this.mentoringTaskList.findWhere({item: id});

            if(typeof taskModel !== 'undefined' &&  taskModel instanceof Backbone.Model )
            {
                console.log('TaskModel', taskModel.toJSON());
                taskModel.destroy({
                    processData: true,
                    wait: true,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_tarea_mentoria': taskModel.get('codigo_tarea_mentoria')
                    },
                    success: function(model, resp) {
                            console.log('sucess', resp);
                            _this.mentoringTaskList.reset(_this.mentoringTaskList.toJSON());

                            var text = resp.success ? resp.message : resp.errors,
                                            type = resp.success ? 'success' : 'alert';

                                        if( _.isObject(resp.errors) ){

                                            var listError = '<ul>';

                                            $.each(resp.errors, function(field, item) {
                                                listError += '<li>'+ item[0] +'</li>';
                                            });
                                            listError += '</ul>';

                                            text = listError;
                                        }

                                        var config = {
                                            'text': text,
                                            'type': type
                                        };
                                        _.extend( _this.configAlert, config );

                                        window.Misc.removeSpinner({
                                            'wrap': _this.$el,
                                            'direct': false
                                        });

                            if( resp.success ){
                                li.remove();
                            }else{
                                window.Misc.showAlertBox( _this.configAlert );
                            }
                    },
                    error: function (model, resp) {
                        console.log('errorResp!',resp );
                        window.Misc.removeSpinner({
                            'wrap': _this.$el,
                            'direct': false
                        });

                        _this.mentoringTaskList.reset(_this.mentoringTaskList.toJSON());

                        var text = resp.errors ? resp.errors : '' ,
                            type =  'alert';

                        if( _.isObject(resp.errors) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }

                        var config = {
                            'text': text,
                            'type': type
                        };
                        _.extend( _this.configAlert, config );

                        window.Misc.showAlertBox( _this.configAlert );
                    }});

            } else {
                    li.remove();
            }
    },

    onRemoveTags: function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var id = $(e.currentTarget).data('id') || null;
        var li =   $(e.target).parents('li');

        var tagsModel = this.mentoringTagsList.findWhere({item: id});

        if(typeof tagsModel !== 'undefined' &&  tagsModel instanceof Backbone.Model )
        {
            console.log('TagsModel', tagsModel);
            tagsModel.destroy({
                processData: true,
                wait: true,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'codigo_tags_mentoria': tagsModel.get('codigo_tag_sesion_mentoria')
                },
                success: function(model, resp) {
                    console.log('sucess', resp);
                    _this.mentoringTagsList.reset(_this.mentoringTagsList.toJSON());

                    var text = resp.success ? resp.message : resp.errors,
                        type = resp.success ? 'success' : 'alert';

                    if( _.isObject(resp.errors) ){

                        var listError = '<ul>';

                        $.each(resp.errors, function(field, item) {
                            listError += '<li>'+ item[0] +'</li>';
                        });
                        listError += '</ul>';

                        text = listError;
                    }

                    var config = {
                        'text': text,
                        'type': type
                    };
                    _.extend( _this.configAlert, config );

                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false
                    });

                    if( resp.success ){
                        li.remove();
                    }else{
                        window.Misc.showAlertBox( _this.configAlert );
                    }
                },
                error: function (model, resp) {
                    console.log('errorResp!',resp );
                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false
                    });

                    _this.mentoringTagsList.reset(_this.mentoringTagsList.toJSON());

                    var text = resp.errors ? resp.errors : '' ,
                        type =  'alert';

                    if( _.isObject(resp.errors) ){

                        var listError = '<ul>';

                        $.each(resp.errors, function(field, item) {
                            listError += '<li>'+ item[0] +'</li>';
                        });
                        listError += '</ul>';

                        text = listError;
                    }

                    var config = {
                        'text': text,
                        'type': type
                    };
                    _.extend( _this.configAlert, config );

                    window.Misc.showAlertBox( _this.configAlert );
            }});

        } else {
            li.remove();
        }
    },

    /**
    ** Add logic to Add Task Mentoring
    */
    onAddTag: function (e) {
        var codeKey = e.keyCode || e.which;
        var _this = this;
        if( e.type == 'keypress' ){
            if( codeKey !== 13 )
                return;
        }else{
            e.preventDefault();
            e.stopImmediatePropagation();
        }

        this.listTagWrapper = this.$('.body-session-content').find('#mentoring-tags-list');
        var $fieldTagTitleInput =  this.$('.body-session-content').find('#mentoring-tags-title'),
            $fieldTagValueInput = this.$('.body-session-content').find('#mentoring-tags-value');

        var fieldTagTitleInput = $fieldTagTitleInput.val() || '';
            fieldTagTitleInput = fieldTagTitleInput.trim(),
            fieldTagValueInput = $fieldTagValueInput.val() || '',
            fieldTagValueInput = fieldTagValueInput.trim();

        if( fieldTagTitleInput.length && fieldTagValueInput.length ){

            var tagsModel = new app.MentoringTagsModel({
                nombre_tag_sesion_mentoria: fieldTagTitleInput,
                valor_tag_sesion_mentoria: fieldTagValueInput,
                codigo_mentoria: this.mentoringSessionModel.get('codigo_mentoria')
            });

            window.Misc.setSpinner( this.$el );

            tagsModel.save({
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')}
            },{success: function(model, resp) {

                window.Misc.removeSpinner({
                    'wrap': _this.$el,
                    'direct': false
                });

                _this.mentoringTagsList.reset(_this.mentoringTagsList.toJSON());

                var text = resp.success ? resp.message : resp.errors,
                                type = resp.success ? 'success' : 'alert';

                            if( _.isObject(resp.errors) ){

                                var listError = '<ul>';

                                $.each(resp.errors, function(field, item) {
                                    listError += '<li>'+ item[0] +'</li>';
                                });
                                listError += '</ul>';

                                text = listError;
                            }

                            var config = {
                                'text': text,
                                'type': type
                            };
                            _.extend( _this.configAlert, config );

                if( resp.success ){

                    _this.mentoringTagsList.add(model);
                    $fieldTagTitleInput.val('');
                    $fieldTagValueInput.val('');

                }else{
                    window.Misc.showAlertBox( _this.configAlert );
                }
            }});
        }

        // if( codeKey === 13 ) return false;
    },

    /**
     * Function to create General Objetive
     */
    onAddGeneralObjetive: function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldGeneralObjetiveInput =  this.$('.body-session-content').find('#mentoring-objetive-general');
        var fieldGeneralObjetiveInput = $fieldGeneralObjetiveInput.val() || '',
        fieldGeneralObjetiveInput = fieldGeneralObjetiveInput.trim();
        var data = {
            'objetive': fieldGeneralObjetiveInput,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        $.post(document.url + Route.route('mentoria.sesiones.objetivo'), data, function(resp) {
            window.Misc.setSpinner( this.$el );

            var text = resp.success ? resp.message : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject(resp.errors) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                    listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );
        });
    },


    loadSpinner: function(target, xhr, opts) {
        window.Misc.setSpinner( this.$el );
    },

        /**
    * response of the server item delete
    */
    responseItemDelete: function (model, resp, opts) {
        //complete proccess

        window.Misc.removeSpinner({
            'wrap': this.$el,
            'direct': false
        });
    },

    responseServer: function(target, resp, opts) {

        if( !target.length && target instanceof Backbone.Collection && ! _.isUndefined(this.$noResults) )
            this.$noResults.fadeIn('fast');


        window.Misc.removeSpinner({
            'wrap': this.$el,
            'direct': false
        });
    }

   });

})(jQuery, this, this.document);

/**
* Class ProccessMentorList extends of Backbone View
* @author TuProyecto || Desarrollador : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProccessMentorList = Backbone.View.extend({
        el: '#mentoring_init',
        template: _.template( ($('#mentoring-process').html() || '') ),
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
        	// _.extend( this.parameters, opts.parameters );

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

            var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

        	// Init Attributes

            // this.listenTo( this.collection, 'reset', this.onReset );
            // this.listenTo( this.collection, 'request', this.loadSpinner );
            // this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
           this.$el.html(this.template());
        },

        /**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

        ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();
		},

        onReset: function(collection) {
            var attributes = collection.toJSON();

            if (attributes[0].nombre_usuario) {
                this.$el.html(this.template());
            } else {
                console.log('No eres un mentor');
            }
        },

             /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },
   });

})(jQuery, this, this.document);

/**
* Class LikeView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.LikeView = Backbone.View.extend({

        tagName: 'a',
        className: 'TPlikelink inst-color-invert',
        attributes: {
            'href': '#',
            'data-srcparams': {}
        },
        events: {
            'click': 'onILike'
        },

        /**
        * Constructor Method
        */
        initialize: function() {

            //Init Attributes
            this.model = new window.app.LikeModel();
            this.$countLikes || (this.$countLikes = null);
            this.$modalLogin = $('#modal-login');
            this.$modalBase = $('#modal-base-tp');
            this.counterLikes = 0;

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.unLike );
            this.listenTo( this.model, 'request', this.requestLike );
            this.listenTo( this.model, 'sync', this.responseLike );

            if( window.Misc.checkSession(false) ) {
                // fetch one like
                this.fetchOneLike();
            }
        },


        /*
        * Render View Element
        */
        render: function () {

            var attributes = this.model.toJSON();
         
            // overwrite id attribute of model
            if( this.model.changed.success !== undefined ) {
                this.model.idAttribute = 'codigo_like';
                this.model.set( {codigo_like: this.model.get('codigo_like')}, {'silent':true} );
            }

            if( !this.$el.hasClass('no-text-like') ) {
                this.$el.html( attributes.value_txt );
            }else{
                this.$el.toggleClass('ilike', !!attributes.auth_like);
            }

            this.$el.attr('title', attributes.value_txt);

            if( this.model.id !== undefined ){
                this.$el.data('srcparams', attributes.srcparams);
            }else{
                this.$el.data('srcparams', this.attributes['data-srcparams']);
            }

            return this;
        },

        /**
        * remove like of the collection
        * @param Object model
        * @param Object collection
        * @param Object opts
        */
        removeOne: function (model, collection, opts) {

            this.model.destroy( {wait:true} );
        },

        /**
        * refresh count likes
        */
        refreshCountLikes: function () {

            if(typeof this.$countLikes !== 'undefined' && this.$countLikes.length) {
                this.$countLikes.html( this.counterLikes || 0 );
            }
        },

        /**
        * I Like or Unlike event
        */
        onILike: function (e) {
            e.preventDefault();
            // check out if there is session to like that
            if( window.Misc.checkSession(false) ) {
                var data = {},
                    _this = this;

                data.srcparams = this.$el.data('srcparams');
                data._token = this.$el.data('csrf-token');
                data.auth_like = !this.model.get('auth_like');

                if( !this.$el.hasClass('disabled') ) {
                    if( this.model.changed.codigo_like !== undefined && this.model.get('auth_like') === true ) {
                            this.model.destroy({
                                processData: true,
                                data: data,
                                success: function (model, resp) {
                                    if(resp.success !== undefined) {
                                        if(resp.success) {
                                            _this.counterLikes = resp.contador_like;
                                            _this.refreshCountLikes();

                                            _this.model.clear({silent:true});
                                            _this.model.set( 'value_txt', resp.value_txt );

                                        }else {
                                            ++_this.counterLikes;
                                            _this.refreshCountLikes();

                                            _this.model.set( 'auth_like', true );
                                        }
                                    }

                                    _this.$el.removeClass('disabled');
                                },
                                error: function (model, resp) {
                                    ++_this.counterLikes;
                                    _this.refreshCountLikes();
                                    _this.model.set( 'auth_like', true );

                                    _this.$el.removeClass('disabled');

                                }
                            });

                    }else {

                        // increment likes counter
                        ++this.counterLikes;
                        this.refreshCountLikes();

                        this.model.save(data, { error: function (model, resp) {
                            --_this.counterLikes;
                            _this.refreshCountLikes();
                            _this.model.set( 'auth_like', false );

                            _this.$el.removeClass('disabled');
                        }});
                    }
                }

            }else{
                this.$modalLogin.foundation('reveal','open');
            }
        },

        /**
        * Unlike
        */
        unLike: function (model, collection, opts) {
            // console.log('Unlike::', model, collection, opts);

            // decrement likes counter
            --this.counterLikes;
            this.refreshCountLikes();
            this.model.set( 'auth_like', false );
        },

        /**
        * fetch one like
        */
        fetchOneLike: function () {

            this.model.idAttribute = 'srcparams';
            this.model.set( {srcparams: this.attributes['data-srcparams']}, {'silent':true} );

            this.model.fetch();
        },

        /**
        * request one like to server
        */
        requestLike: function (target, xhr, opts) {
            this.$el.addClass('disabled');
        },

        /**
        * response one like from server
        */
        responseLike: function (target, resp, opts) {

            if(resp.success) {
                this.counterLikes = parseInt(this.model.get('contador_like'));
                this.refreshCountLikes();
            }

            this.$el.removeClass('disabled');
        }
    });

})(jQuery, this, this.document);

/**
* Class VoteView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VoteView = Backbone.View.extend({
    
        template: _.template( ($('#vote-form-tpl').html() || '') ),
        events: {
            'submit #form-vote-user': 'onStoreVote',
            'blur #email': 'onValidateEmail'
        },
        parameters: {
            'data-srcparams': 'data-srcparams'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onSuccessVote');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 15000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;

            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this,
                attributes = {};

            this.$el.html( this.template(attributes) );
            this.$formEdit = this.$('#form-vote-user');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {

            var _this = this; 

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                _this.$el.foundation('abide');
            }
        },

        /**
        * event vote user
        */
        onStoreVote: function (e) {

            e.preventDefault();
            data = window.Misc.formToJson(event.target);
            data.srcparams = this.parameters['data-srcparams'];

            this.$formEdit.find(':submit').addClass('disabled');

            $.post(document.url + Route.route('voto.voto.store'), data, this.onSuccessVote);

        },

        /**
        * success event for vote User
        * @param Object res
        */
        onSuccessVote: function (resp) {
            var _this = this;
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });

            if(resp.requestPost) {
                // response success or error
                var type = resp.success ? 'success' : 'alert',
                    text = resp.success ? 
                        (resp.message !== undefined ? resp.message : '...')
                        : resp.errors;

                if( _.isObject( resp.errors ) ){

                    var listError = '<ul>';

                    $.each(resp.errors, function(field, item) {
                         listError += '<li>'+ item[0] +'</li>';
                    });
                    listError += '</ul>';

                    text = listError;
                }
                 
                var config = {
                    'text': text,
                    'type': type
                };
                _.extend( _this.configAlert, config );
                //complete proccess
                if( resp.success !== undefined ){
                    if( resp.success ){
                        _this.$el.foundation('reveal','close');
                        window.Misc.showAlertBox( _this.configAlert );
                    }else{
                        window.Misc.showAlertBox( _this.configAlert );
                    }
                    _this.clearForm( _this.$formEdit );
                    _this.$formEdit.find(':submit').removeClass('disabled');
                }
            } 
        },

        /**
        * validate email
        */
        onValidateEmail: function (e) {

            var _this = this,
                email = (e !== undefined && e.type != 'opened' && $(e.currentTarget).length) ? 
                            $(e.currentTarget).val() : 
                                (!this.$fldEmail.length && e !== undefined ) ? 
                                        this.$('#email').val() : this.$fldEmail.val(),
                sendData = {
                    'email': email
                };

            this.validateEmail(sendData, function (respState, respAlert, resp) {

                window.Misc.removeSpinner({ 
                    'wrap': _this.$formEdit,
                    'direct': true
                });
                
                if( respState ){
                    _this.$formEdit.find('#nombre_usuario').val(resp.labelname);
                    _this.$formEdit.find('#primer_apellido_persona').val(resp.labellastname);

                }else{

                    _this.$formEdit.find('.view-input').val('');
                }

            });
        },

        /**
        * validate E-mail of the team project
        * @param String email
        * @return Array | [Boolean, Object]
        */
        validateEmail: function (sendData, callback) {

            var _this = this,
                respReturn = true,
                configAlert = this.configAlert,
                _data = {
                    'email': ''
                };

            if( _.isObject(sendData) )
                _.extend(_data, sendData);


            if( window.Misc.isEmail(_data['email']) ) {

                window.Misc.setSpinner( _this.$formEdit);
                $.get(document.url + Route.route('usuario.valid.email'), _data, function (resp) {

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

                        if (!resp.success) {

                            respReturn = false;

                        }
                    }

                    if( typeof callback == 'function' ){
                        callback.call(null, respReturn, configAlert, resp);
                    }
                });
            }
        },

        /**
        * clean form
        * @param Object | jQuery $formReset
        */
        clearForm: function ($formReset) {
            $formReset[0].reset();
        }
    });

})(jQuery, this, this.document);

/**
* Class UserLikesView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserLikesView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#user-likes-tpl').html() || '') ),
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes

            //Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class UserLikesListView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.UserLikesListView = Backbone.View.extend({

		tagName: 'ul',
		className: 'list-user-likes',
		attributes: {
			'data-srcparams': ''
		},
		parameters: {
			'data-srcparams': ''
		},
		templateBtnMore: _.template( ($('#btn-view-more-tpl').html() || '') ),
		events: {
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){
			_.bindAll(this, 'showMore');

			// Extend attributes
			if( opts.parameters !== undefined && _.isObject(opts.parameters) ){
				_.extend( this.parameters, opts.parameters );
			}else{
				_.extend( this.parameters, this.attributes );
			}

			//Init Attributes
			this.$modalBase = $('#modal-base-material');
			this.$elmSpinner = this.$el;
			this.collection = new window.app.UserLikesList();
			this.$wrapViewMore = $( this.templateBtnMore() );
			this.$spinnerUserLikes = $('<div>').attr('id','spinner-load-userlikes');

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner);
			this.listenTo( this.collection, 'sync', this.responseServer);
			this.$wrapViewMore.on( 'click', '.btn-view-more', this.showMore);
		},

		/*
		* Render View Element
		*/
		render: function(){

			this.$wrapViewMore.hide();
			this.collection.getFirstPage( {data:{'srcparams': this.parameters['data-srcparams']}, reset:true} );

			this.$modalBase.find('.content-modal').addClass('scroll-user-likes');
			// this.$modalBase.find('.content-modal').html( this.el );
			// this.$modalBase.find('.content-modal').append( this.$wrapViewMore );

			if( typeof window.initComponent.configScrollbar == 'function' )
				window.initComponent.configScrollbar();

			return this;
		},

		/**
		* Render view comment by model
		* @param Object categoryModel Model instance
		*/
		addOne: function (userLikesModel) {

			var view = new app.UserLikesView( {model: userLikesModel} );
			this.$el.append( view.render().el );
		},

		/**
		* Render all view comment of the collection
		*/
		addAll: function () {

			this.$el.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {

			if( this.collection.state.currentPage >= this.collection.state.lastPage ){
				this.$elmSpinner = this.$el;
			}else{
				this.$elmSpinner = this.$wrapViewMore;
				this.$spinnerUserLikes.appendTo( this.$elmSpinner );
			}

			window.Misc.setSpinner( this.$elmSpinner );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			// complete process
			window.Misc.removeSpinner({
				'wrap': this.$elmSpinner,
				'direct': false
			});

			if( this.collection.state.currentPage >= this.collection.state.lastPage ){
				this.$wrapViewMore.hide();
			}else{
				this.$wrapViewMore.show();
			}

		},

		/**
		* Show more users that likesd it
		*/
		showMore: function (e) {
			e.preventDefault();

			if( this.collection.hasNextPage() ){
				this.collection.getNextPage( {wait:true, data:{'srcparams': this.parameters['data-srcparams']}} );
			}
		}
   });

})(jQuery, this, this.document);

/**
* Class BaseProjectView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.BaseProjectView = Backbone.View.extend({

		el: '#project-content',
		template: _.template( ($('#project-content-tpl').html() || '') ),
		events: {
            'click #onBack': 'onBack'
		},
		parameters: {
            tab: '',
            action: '',
            project: '',
			type: 'default',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function ( opts ) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
            }

			// Init Attributes
            this.projectList = new app.ProjectList();

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listeners
			this.on('beforeRender', this.beforeRender);
			this.on('afterRender', this.afterRender);
		},

		/*
		* Render View Element
		*/
		render: function () {
			// Initialize Attributes
            var attributes = {};
            attributes = _.extend(attributes, this.parameters);

            this.$el.html( this.template(attributes) );

			$( window ).off("scroll");
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
			// code goes here
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function() {
			// get section
			this.stuffType( this.parameters.type, this.parameters.action );
		},

		/**
		* switch types mentoring
		*/
		stuffType: function ( type, action ) {
			action = (action = '');
			console.log(type);
			var _this = this,
				stuffType = {
					'principal' : function() {
						_.each(['principal'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'micontenido': function () {
						_.each(['micontenido'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'detail': function () {
						_.each(['detail'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'default': function () {
						_.each(['principal', 'micontenido'], function (value, index) {
							_this.stuffAction(value);
						});
					}
				};

			if