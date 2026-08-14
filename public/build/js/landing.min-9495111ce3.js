(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["GET","HEAD"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/email","name":"password.request","action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":"password.email","action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"password.reset","action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}","name":"auth.provider","action":"App\Http\Controllers\Auth\LoginController@redirectToProvider"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}\/callback","name":"auth.provider.callback","action":"App\Http\Controllers\Auth\LoginController@handleProviderCallback"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home","action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"chat","name":"chat.index","action":"App\Http\Controllers\Chat\ChatController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.index","action":"App\Http\Controllers\CanalUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.store","action":"App\Http\Controllers\CanalUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/canalusuario\/{canalusuario}","name":"comunidad.canalusuario.update","action":"App\Http\Controllers\CanalUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{canal}\/create","name":"comunidad.create","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad","name":"comunidad.index","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["POST"],"uri":"comunidad","name":"comunidad.store","action":"App\Http\Controllers\MuroController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{comunidad}","name":"comunidad.show","action":"App\Http\Controllers\MuroController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/{comunidad}","name":"comunidad.update","action":"App\Http\Controllers\MuroController@update"},{"host":null,"methods":["DELETE"],"uri":"comunidad\/{comunidad}","name":"comunidad.destroy","action":"App\Http\Controllers\MuroController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/rechazar\/{asesoria}","name":"mentoria.preguntas.rechazar","action":"App\Http\Controllers\AsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/aceptar\/{asesoria}","name":"mentoria.preguntas.aceptar","action":"App\Http\Controllers\AsesoriaController@aceptar"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor\/create\/{user}","name":"mentoria.preguntas.evaluacion.mentor.create","action":"App\Http\Controllers\EvaluacionAsesoriaController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.index","action":"App\Http\Controllers\EvaluacionAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.store","action":"App\Http\Controllers\EvaluacionAsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/procesos","name":"mentoria.mentores.procesos.index","action":"App\Http\Controllers\ProcesoMentoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/procesos\/{procesos}","name":"mentoria.mentores.procesos.show","action":"App\Http\Controllers\ProcesoMentoriaController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.index","action":"App\Http\Controllers\AsesoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/create","name":"mentoria.preguntas.create","action":"App\Http\Controllers\AsesoriaController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.store","action":"App\Http\Controllers\AsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.show","action":"App\Http\Controllers\AsesoriaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.update","action":"App\Http\Controllers\AsesoriaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores","name":"mentoria.mentores.index","action":"App\Http\Controllers\MentorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/create","name":"mentoria.mentores.create","action":"App\Http\Controllers\MentorController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/mentores","name":"mentoria.mentores.store","action":"App\Http\Controllers\MentorController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.show","action":"App\Http\Controllers\MentorController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.update","action":"App\Http\Controllers\MentorController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sessiones","name":"mentoria.sessiones.index","action":"App\Http\Controllers\MentoriaSessionesController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sessiones\/create","name":"mentoria.sessiones.create","action":"App\Http\Controllers\MentoriaSessionesController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/sessiones","name":"mentoria.sessiones.store","action":"App\Http\Controllers\MentoriaSessionesController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/sessiones\/{sessiones}","name":"mentoria.sessiones.show","action":"App\Http\Controllers\MentoriaSessionesController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/sessiones\/{sessiones}","name":"mentoria.sessiones.update","action":"App\Http\Controllers\MentoriaSessionesController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria","name":"mentoria.index","action":"App\Http\Controllers\MentoriaController@index"},{"host":null,"methods":["POST"],"uri":"file\/temp","name":"file.temp","action":"App\Http\Controllers\FileController@temp"},{"host":null,"methods":["POST"],"uri":"file\/crop","name":"file.crop","action":"App\Http\Controllers\FileController@crop"},{"host":null,"methods":["POST"],"uri":"file\/upload","name":"file.upload","action":"App\Http\Controllers\FileController@upload"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/identificacion","name":"usuario.identificacion.index","action":"App\Http\Controllers\TipoIdentificacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/economicos\/selectorlist","name":"usuario.economicos.selector.list","action":"App\Http\Controllers\SectorEconomicoPersonaController@selectorlist"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/economicos","name":"usuario.economicos.index","action":"App\Http\Controllers\SectorEconomicoPersonaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.update","action":"App\Http\Controllers\SectorEconomicoPersonaController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.destroy","action":"App\Http\Controllers\SectorEconomicoPersonaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/razones","name":"usuario.razones.index","action":"App\Http\Controllers\RazonRegistroUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/razones\/{razones}","name":"usuario.razones.update","action":"App\Http\Controllers\RazonRegistroUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/razones\/{razones}","name":"usuario.razones.destroy","action":"App\Http\Controllers\RazonRegistroUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/especialidades\/selectorlist","name":"usuario.especialidades.selector.list","action":"App\Http\Controllers\EspecialidadUsuarioController@selectorlist"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/especialidades","name":"usuario.especialidades.index","action":"App\Http\Controllers\EspecialidadUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/especialidades\/{especialidades}","name":"usuario.especialidades.update","action":"App\Http\Controllers\EspecialidadUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/especialidades\/{especialidades}","name":"usuario.especialidades.destroy","action":"App\Http\Controllers\EspecialidadUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/intereses","name":"usuario.intereses.index","action":"App\Http\Controllers\SectorInteresUsuarioController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/intereses\/{intereses}","name":"usuario.intereses.update","action":"App\Http\Controllers\SectorInteresUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/intereses\/{intereses}","name":"usuario.intereses.destroy","action":"App\Http\Controllers\SectorInteresUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/educaciones","name":"usuario.educaciones.index","action":"App\Http\Controllers\NivelEducacionUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/educaciones","name":"usuario.educaciones.store","action":"App\Http\Controllers\NivelEducacionUsuarioController@store"},{"host":null,"methods":["DELETE"],"uri":"usuario\/educaciones\/{educaciones}","name":"usuario.educaciones.destroy","action":"App\Http\Controllers\NivelEducacionUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/conceptos","name":"usuario.conceptos.index","action":"App\Http\Controllers\ConceptoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/convocatorias","name":"usuario.convocatorias.index","action":"App\Http\Controllers\RegistroFaseUsuarioController@index"},{"host":null,"methods":["PATCH"],"uri":"usuario\/socialnetworks\/{usuario}","name":"usuario.socialnetworks","action":"App\Http\Controllers\UsuarioController@socialNetworks"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/auth","name":"usuario.auth","action":"App\Http\Controllers\UsuarioController@auth"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/confirmdeactivation","name":"usuario.confirmdeactivation","action":"App\Http\Controllers\UsuarioController@confirmdeactivation"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/usernameavailable","name":"usuario.usernameavailable","action":"App\Http\Controllers\UsuarioController@usernameAvailable"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/valid","name":"usuario.valid.email","action":"App\Http\Controllers\UsuarioController@verifyEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario\/confirmar","name":"usuario.redusuario.confirmar","action":"App\Http\Controllers\RedUsuarioController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario","name":"usuario.redusuario.index","action":"App\Http\Controllers\RedUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/redusuario","name":"usuario.redusuario.store","action":"App\Http\Controllers\RedUsuarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/redusuario\/{redusuario}","name":"usuario.redusuario.show","action":"App\Http\Controllers\RedUsuarioController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/redusuario\/{redusuario}","name":"usuario.redusuario.update","action":"App\Http\Controllers\RedUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/confirmacion\/{email}","name":"usuario.confirmacion.confirmar","action":"App\Http\Controllers\UsuarioController@confirmAccount"},{"host":null,"methods":["POST"],"uri":"usuario\/confirmacion\/correo","name":"usuario.confirmacion.email","action":"App\Http\Controllers\UsuarioController@sendMailConfirmation"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo\/confirmar","name":"usuario.equipo.confirmar","action":"App\Http\Controllers\GrupoUsuarioController@confirmar"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo","name":"usuario.equipo.index","action":"App\Http\Controllers\GrupoUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario\/equipo","name":"usuario.equipo.store","action":"App\Http\Controllers\GrupoUsuarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/equipo\/{equipo}","name":"usuario.equipo.show","action":"App\Http\Controllers\GrupoUsuarioController@show"},{"host":null,"methods":["DELETE"],"uri":"usuario\/equipo\/{equipo}","name":"usuario.equipo.destroy","action":"App\Http\Controllers\GrupoUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/{nickname}","name":"usuario.nickname","action":"App\Http\Controllers\UsuarioController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/{nickname}\/{tab?}","name":"usuario.nickname.tab","action":"App\Http\Controllers\UsuarioController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario","name":"usuario.index","action":"App\Http\Controllers\UsuarioController@index"},{"host":null,"methods":["POST"],"uri":"usuario","name":"usuario.store","action":"App\Http\Controllers\UsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/{usuario}","name":"usuario.update","action":"App\Http\Controllers\UsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/{usuario}","name":"usuario.destroy","action":"App\Http\Controllers\UsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"deactivation","name":"deactivation","action":"App\Http\Controllers\UsuarioController@deactivation"},{"host":null,"methods":["GET","HEAD"],"uri":"verifyaccount\/{user}","name":"verify.account.mail","action":"App\Http\Controllers\UsuarioController@verifyaccountmail"},{"host":null,"methods":["GET","HEAD"],"uri":"verifyaccount","name":"verify.account","action":"App\Http\Controllers\UsuarioController@verifyaccount"},{"host":null,"methods":["GET","HEAD"],"uri":"ciudades","name":"ciudades.index","action":"App\Http\Controllers\CiudadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"profesiones","name":"profesiones.index","action":"App\Http\Controllers\ProfesionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ocupaciones","name":"ocupaciones.index","action":"App\Http\Controllers\OcupacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"like","name":"like.index","action":"App\Http\Controllers\LikeController@index"},{"host":null,"methods":["POST"],"uri":"like","name":"like.store","action":"App\Http\Controllers\LikeController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"like\/{like}","name":"like.show","action":"App\Http\Controllers\LikeController@show"},{"host":null,"methods":["DELETE"],"uri":"like\/{like}","name":"like.destroy","action":"App\Http\Controllers\LikeController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"fav","name":"fav.index","action":"App\Http\Controllers\FavController@index"},{"host":null,"methods":["POST"],"uri":"fav","name":"fav.store","action":"App\Http\Controllers\FavController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"fav\/{fav}","name":"fav.update","action":"App\Http\Controllers\FavController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tag","name":"tag.index","action":"App\Http\Controllers\TagController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"foro","name":"foro.index","action":"App\Http\Controllers\ForoController@index"},{"host":null,"methods":["POST"],"uri":"foro","name":"foro.store","action":"App\Http\Controllers\ForoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"foro\/{foro}","name":"foro.show","action":"App\Http\Controllers\ForoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"foro\/{foro}","name":"foro.update","action":"App\Http\Controllers\ForoController@update"},{"host":null,"methods":["DELETE"],"uri":"foro\/{foro}","name":"foro.destroy","action":"App\Http\Controllers\ForoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"foro\/{category}\/{theme}","name":"foro.categoria.tema","action":"App\Http\Controllers\ForoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto","name":"proyecto.index","action":"App\Http\Controllers\ProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/create","name":"proyecto.create","action":"App\Http\Controllers\ProyectoController@create"},{"host":null,"methods":["POST"],"uri":"proyecto","name":"proyecto.store","action":"App\Http\Controllers\ProyectoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/{proyecto}","name":"proyecto.update","action":"App\Http\Controllers\ProyectoController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/{proyecto}","name":"proyecto.destroy","action":"App\Http\Controllers\ProyectoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/etapa","name":"proyecto.etapa.index","action":"App\Http\Controllers\EtapaProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/intereses","name":"proyecto.intereses.index","action":"App\Http\Controllers\SectorInteresProyectoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/intereses\/{intereses}","name":"proyecto.intereses.update","action":"App\Http\Controllers\SectorInteresProyectoController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/intereses\/{intereses}","name":"proyecto.intereses.destroy","action":"App\Http\Controllers\SectorInteresProyectoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/patrocinador","name":"proyecto.patrocinador.index","action":"App\Http\Controllers\PatrocinadorEntidadController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"proyecto\/patrocinador\/{patrocinador}","name":"proyecto.patrocinador.update","action":"App\Http\Controllers\PatrocinadorEntidadController@update"},{"host":null,"methods":["DELETE"],"uri":"proyecto\/patrocinador\/{patrocinador}","name":"proyecto.patrocinador.destroy","action":"App\Http\Controllers\PatrocinadorEntidadController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/categoriaclase\/{categoriaclase}","name":"proyecto.categoriaclase.show","action":"App\Http\Controllers\CategoriaClaseEspacioController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/modelodenegocio","name":"proyecto.modelodenegocio.index","action":"App\Http\Controllers\ModeloNegocioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/mentoremprendimiento\/confirmar","name":"proyecto.mentoremprendimiento.confirmar","action":"App\Http\Controllers\MentorEmprendimientoController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/mentoremprendimiento","name":"proyecto.mentoremprendimiento.index","action":"App\Http\Controllers\MentorEmprendimientoController@index"},{"host":null,"methods":["POST"],"uri":"proyecto\/mentoremprendimiento","name":"proyecto.mentoremprendimiento.store","action":"App\Http\Controllers\MentorEmprendimientoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{type}","name":"proyecto.tipo","action":"App\Http\Controllers\ProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}","name":"proyecto.proyecto","action":"App\Http\Controllers\ProyectoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}\/{tab?}","name":"proyecto.proyecto.tab","action":"App\Http\Controllers\ProyectoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"proyecto\/{proyecto}\/{privadetab?}","name":"proyecto.proyecto.privadetab","action":"App\Http\Controllers\ProyectoController@showPrivadeUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/equipo","name":"grupo.equipo.index","action":"App\Http\Controllers\GrupoEquipoController@index"},{"host":null,"methods":["POST"],"uri":"grupo\/equipo","name":"grupo.equipo.store","action":"App\Http\Controllers\GrupoEquipoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"grupo\/equipo\/{equipo}","name":"grupo.equipo.update","action":"App\Http\Controllers\GrupoEquipoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/cluster","name":"grupo.cluster.index","action":"App\Http\Controllers\AgrupacionProyectoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/{grupo}","name":"grupo.grupo","action":"App\Http\Controllers\GrupoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo\/{grupo}\/{tab?}","name":"grupo.grupo.tab","action":"App\Http\Controllers\GrupoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"grupo","name":"grupo.index","action":"App\Http\Controllers\GrupoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"grupo\/{grupo}","name":"grupo.update","action":"App\Http\Controllers\GrupoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/selectorlist","name":"convocatoria.selector.list","action":"App\Http\Controllers\ConvocatoriaController@selectorlist"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/aplicar\/validacion","name":"convocatoria.aplicar.validacion","action":"App\Http\Controllers\ConvocatoriaController@validApply"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/{convocatoria}\/aplicar\/{step}","name":"convocatoria.aplicar","action":"App\Http\Controllers\ConvocatoriaController@apply"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/fase\/adjunto","name":"convocatoria.fase.adjunto.index","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"convocatoria\/fase\/adjunto","name":"convocatoria.fase.adjunto.store","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"convocatoria\/fase\/adjunto\/{adjunto}","name":"convocatoria.fase.adjunto.update","action":"App\Http\Controllers\AdjuntoFaseUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/fase","name":"convocatoria.fase.index","action":"App\Http\Controllers\FaseController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"convocatoria\/fase\/{fase}","name":"convocatoria.fase.update","action":"App\Http\Controllers\FaseController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/usuario","name":"convocatoria.usuario.index","action":"App\Http\Controllers\FaseUsuarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria\/{convocatoria}","name":"convocatoria.convocatoria","action":"App\Http\Controllers\ConvocatoriaController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"convocatoria","name":"convocatoria.index","action":"App\Http\Controllers\ConvocatoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/contenido\/{theme}\/{class}","name":"aprende.curso.tema.clase","action":"App\Http\Controllers\AprendeController@showCourseThemeClass"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/formulario\/{survey}","name":"aprende.curso.tema.formulario","action":"App\Http\Controllers\AprendeController@showCourseThemeSurvey"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}\/contenido","name":"aprende.contenido","action":"App\Http\Controllers\AprendeController@showContentCourse"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}\/{course}","name":"aprende.categoria.curso","action":"App\Http\Controllers\AprendeController@showCategoryCourse"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}\/{category}","name":"aprende.categoria","action":"App\Http\Controllers\AprendeController@filterCategory"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/{type}","name":"aprende.tipo","action":"App\Http\Controllers\CursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/inscripcioncurso","name":"aprende.curso.inscripcioncurso.index","action":"App\Http\Controllers\InscripcionCursoController@index"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/inscripcioncurso","name":"aprende.curso.inscripcioncurso.store","action":"App\Http\Controllers\InscripcionCursoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/inscripcioncurso\/{inscripcioncurso}","name":"aprende.curso.inscripcioncurso.update","action":"App\Http\Controllers\InscripcionCursoController@update"},{"host":null,"methods":["DELETE"],"uri":"aprende\/curso\/inscripcioncurso\/{inscripcioncurso}","name":"aprende.curso.inscripcioncurso.destroy","action":"App\Http\Controllers\InscripcionCursoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/adjunto","name":"aprende.curso.adjunto.index","action":"App\Http\Controllers\AdjuntoCursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/notausuario","name":"aprende.curso.notausuario.index","action":"App\Http\Controllers\NotaUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"aprende\/curso\/notausuario","name":"aprende.curso.notausuario.store","action":"App\Http\Controllers\NotaUsuarioController@store"},{"host":null,"methods":["DELETE"],"uri":"aprende\/curso\/notausuario\/{notausuario}","name":"aprende.curso.notausuario.destroy","action":"App\Http\Controllers\NotaUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/tema\/adjunto","name":"aprende.curso.tema.adjunto.index","action":"App\Http\Controllers\AdjuntoTemaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/tema\/adjunto\/{adjunto}","name":"aprende.curso.tema.adjunto.update","action":"App\Http\Controllers\AdjuntoTemaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/tema","name":"aprende.curso.tema.index","action":"App\Http\Controllers\TemaCursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso","name":"aprende.curso.index","action":"App\Http\Controllers\CursoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"aprende\/curso\/{curso}","name":"aprende.curso.update","action":"App\Http\Controllers\CursoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende\/curso\/{curso}","name":"aprende.curso","action":"App\Http\Controllers\CursoController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"aprende","name":"aprende.index","action":"App\Http\Controllers\AprendeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/participantes","name":"discusion.participantes.index","action":"App\Http\Controllers\ParticipanteDiscusionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/comentario","name":"discusion.comentario.index","action":"App\Http\Controllers\ComentarioDiscusionController@index"},{"host":null,"methods":["POST"],"uri":"discusion\/comentario","name":"discusion.comentario.store","action":"App\Http\Controllers\ComentarioDiscusionController@store"},{"host":null,"methods":["DELETE"],"uri":"discusion\/comentario\/{comentario}","name":"discusion.comentario.destroy","action":"App\Http\Controllers\ComentarioDiscusionController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion","name":"discusion.index","action":"App\Http\Controllers\DiscusionController@index"},{"host":null,"methods":["POST"],"uri":"discusion","name":"discusion.store","action":"App\Http\Controllers\DiscusionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"discusion\/{discusion}","name":"discusion.show","action":"App\Http\Controllers\DiscusionController@show"},{"host":null,"methods":["DELETE"],"uri":"discusion\/{discusion}","name":"discusion.destroy","action":"App\Http\Controllers\DiscusionController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"blog","name":"blog.index","action":"App\Http\Controllers\BlogController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/create","name":"blog.create","action":"App\Http\Controllers\BlogController@create"},{"host":null,"methods":["POST"],"uri":"blog","name":"blog.store","action":"App\Http\Controllers\BlogController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"blog\/{blog}","name":"blog.update","action":"App\Http\Controllers\BlogController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/{category}","name":"blog.categoria","action":"App\Http\Controllers\BlogController@filterCategory"},{"host":null,"methods":["GET","HEAD"],"uri":"blog\/{category}\/{article}","name":"blog.categoria.articulo","action":"App\Http\Controllers\BlogController@showUrl"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/participar","name":"calendario.evento.participar.index","action":"App\Http\Controllers\UsuarioEventoController@index"},{"host":null,"methods":["POST"],"uri":"calendario\/evento\/participar","name":"calendario.evento.participar.store","action":"App\Http\Controllers\UsuarioEventoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/participar\/{participar}","name":"calendario.evento.participar.show","action":"App\Http\Controllers\UsuarioEventoController@show"},{"host":null,"methods":["DELETE"],"uri":"calendario\/evento\/participar\/{participar}","name":"calendario.evento.participar.destroy","action":"App\Http\Controllers\UsuarioEventoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento","name":"calendario.evento.index","action":"App\Http\Controllers\EventoController@index"},{"host":null,"methods":["POST"],"uri":"calendario\/evento","name":"calendario.evento.store","action":"App\Http\Controllers\EventoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.show","action":"App\Http\Controllers\EventoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.update","action":"App\Http\Controllers\EventoController@update"},{"host":null,"methods":["DELETE"],"uri":"calendario\/evento\/{evento}","name":"calendario.evento.destroy","action":"App\Http\Controllers\EventoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"calendario","name":"calendario.index","action":"App\Http\Controllers\CalendarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/evaluacion","name":"marketplace.evaluacion.index","action":"App\Http\Controllers\EvaluacionCompraController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/evaluacion","name":"marketplace.evaluacion.store","action":"App\Http\Controllers\EvaluacionCompraController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/voucher","name":"marketplace.voucher.index","action":"App\Http\Controllers\VoucherController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/categoriaproducto","name":"marketplace.categoriaproducto.index","action":"App\Http\Controllers\CategoriaProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}\/evaluacion\/{purchase}","name":"marketplace.evaluacion.purchase","action":"App\Http\Controllers\EvaluacionCompraController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/evaluaciongeneral","name":"marketplace.evaluaciongeneral","action":"App\Http\Controllers\EvaluacionGeneralCompraController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/providerlist","name":"marketplace.provider.index","action":"App\Http\Controllers\UsuarioController@listProviders"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}\/entregables\/{purchase}","name":"marketplace.entregables.purchase","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@deliberable"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/create\/{venta}","name":"marketplace.ventas.acuerdo.create","action":"App\Http\Controllers\AcuerdoController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo","name":"marketplace.ventas.acuerdo.index","action":"App\Http\Controllers\AcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/acuerdo","name":"marketplace.ventas.acuerdo.store","action":"App\Http\Controllers\AcuerdoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}","name":"marketplace.ventas.acuerdo.show","action":"App\Http\Controllers\AcuerdoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}\/edit","name":"marketplace.ventas.acuerdo.edit","action":"App\Http\Controllers\AcuerdoController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/acuerdo\/{acuerdo}","name":"marketplace.ventas.acuerdo.update","action":"App\Http\Controllers\AcuerdoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion","name":"marketplace.ventas.promocion.index","action":"App\Http\Controllers\PromocionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/create","name":"marketplace.ventas.promocion.create","action":"App\Http\Controllers\PromocionController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/promocion","name":"marketplace.ventas.promocion.store","action":"App\Http\Controllers\PromocionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/{promocion}","name":"marketplace.ventas.promocion.show","action":"App\Http\Controllers\PromocionController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/promocion\/{promocion}\/edit","name":"marketplace.ventas.promocion.edit","action":"App\Http\Controllers\PromocionController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/promocion\/{promocion}","name":"marketplace.ventas.promocion.update","action":"App\Http\Controllers\PromocionController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/informe","name":"marketplace.ventas.informe.index","action":"App\Http\Controllers\AdjuntoAcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas\/informe","name":"marketplace.ventas.informe.store","action":"App\Http\Controllers\AdjuntoAcuerdoController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/ventas\/informe\/{informe}","name":"marketplace.ventas.informe.update","action":"App\Http\Controllers\AdjuntoAcuerdoController@update"},{"host":null,"methods":["DELETE"],"uri":"marketplace\/ventas\/informe\/{informe}","name":"marketplace.ventas.informe.destroy","action":"App\Http\Controllers\AdjuntoAcuerdoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas","name":"marketplace.ventas.index","action":"App\Http\Controllers\VendedorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/ventas\/create","name":"marketplace.ventas.create","action":"App\Http\Controllers\VendedorController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/ventas","name":"marketplace.ventas.store","action":"App\Http\Controllers\VendedorController@store"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras\/acuerdo\/confirmar","name":"marketplace.compras.acuerdo.confirmar","action":"App\Http\Controllers\AcuerdoController@confirmar"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/acuerdo\/{acuerdo}","name":"marketplace.compras.acuerdo.show","action":"App\Http\Controllers\AcuerdoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/offer","name":"marketplace.compras.offer.index","action":"App\Http\Controllers\OfertaController@index"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras\/offer","name":"marketplace.compras.offer.store","action":"App\Http\Controllers\OfertaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/shipping\/{shipping}\/edit","name":"marketplace.compras.shipping.edit","action":"App\Http\Controllers\EnvioCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/shipping\/{shipping}","name":"marketplace.compras.shipping.update","action":"App\Http\Controllers\EnvioCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/payment\/{payment}\/edit","name":"marketplace.compras.payment.edit","action":"App\Http\Controllers\PagoCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/payment\/{payment}","name":"marketplace.compras.payment.update","action":"App\Http\Controllers\PagoCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/confirm\/{confirm}\/edit","name":"marketplace.compras.confirm.edit","action":"App\Http\Controllers\ConfirmarCompraController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/confirm\/{confirm}","name":"marketplace.compras.confirm.update","action":"App\Http\Controllers\ConfirmarCompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/{purchase}\/create","name":"marketplace.compras.offer.create","action":"App\Http\Controllers\CompraController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/success\/{purchase}","name":"marketplace.compras.success","action":"App\Http\Controllers\ConfirmarCompraController@success"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/validvoucher\/{purchase}","name":"marketplace.compras.validvoucher","action":"App\Http\Controllers\CompraController@validVoucher"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras","name":"marketplace.compras.index","action":"App\Http\Controllers\CompraController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/create","name":"marketplace.compras.create","action":"App\Http\Controllers\CompraController@create"},{"host":null,"methods":["POST"],"uri":"marketplace\/compras","name":"marketplace.compras.store","action":"App\Http\Controllers\CompraController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/compras\/{compras}","name":"marketplace.compras.show","action":"App\Http\Controllers\CompraController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/compras\/{compras}","name":"marketplace.compras.update","action":"App\Http\Controllers\CompraController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{tab}","name":"marketplace.tab","action":"App\Http\Controllers\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace","name":"marketplace.index","action":"App\Http\Controllers\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/create","name":"marketplace.create","action":"App\Http\Controllers\ProductoController@create"},{"host":null,"methods":["POST"],"uri":"marketplace","name":"marketplace.store","action":"App\Http\Controllers\ProductoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"marketplace\/{marketplace}","name":"marketplace.show","action":"App\Http\Controllers\ProductoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"marketplace\/{marketplace}","name":"marketplace.update","action":"App\Http\Controllers\ProductoController@update"},{"host":null,"methods":["DELETE"],"uri":"marketplace\/{marketplace}","name":"marketplace.destroy","action":"App\Http\Controllers\ProductoController@destroy"},{"host":null,"methods":["PATCH"],"uri":"evaluacion\/categoria\/{entity}","name":"evaluacion.categoria","action":"App\Http\Controllers\EvaluacionEmprendimientoController@entity"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion\/terminos\/{assignment}","name":"evaluacion.terminos","action":"App\Http\Controllers\EvaluacionEmprendimientoController@terminos"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion","name":"evaluacion.index","action":"App\Http\Controllers\EvaluacionEmprendimientoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.show","action":"App\Http\Controllers\EvaluacionEmprendimientoController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.update","action":"App\Http\Controllers\EvaluacionEmprendimientoController@update"},{"host":null,"methods":["DELETE"],"uri":"evaluacion\/{evaluacion}","name":"evaluacion.destroy","action":"App\Http\Controllers\EvaluacionEmprendimientoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/producto","name":"adjunto.producto.index","action":"App\Http\Controllers\AdjuntoProductoController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/producto\/{producto}","name":"adjunto.producto.update","action":"App\Http\Controllers\AdjuntoProductoController@update"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/producto\/{producto}","name":"adjunto.producto.destroy","action":"App\Http\Controllers\AdjuntoProductoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/usuario","name":"adjunto.usuario.index","action":"App\Http\Controllers\AdjuntoUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/usuario","name":"adjunto.usuario.store","action":"App\Http\Controllers\AdjuntoUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/usuario\/{usuario}","name":"adjunto.usuario.update","action":"App\Http\Controllers\AdjuntoUsuarioController@update"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/usuario\/{usuario}","name":"adjunto.usuario.destroy","action":"App\Http\Controllers\AdjuntoUsuarioController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/asesoria","name":"adjunto.asesoria.index","action":"App\Http\Controllers\AdjuntoAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/asesoria","name":"adjunto.asesoria.store","action":"App\Http\Controllers\AdjuntoAsesoriaController@store"},{"host":null,"methods":["DELETE"],"uri":"adjunto\/asesoria\/{asesoria}","name":"adjunto.asesoria.destroy","action":"App\Http\Controllers\AdjuntoAsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/encuesta","name":"adjunto.encuesta.index","action":"App\Http\Controllers\AdjuntoEncuestaController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/encuesta","name":"adjunto.encuesta.store","action":"App\Http\Controllers\AdjuntoEncuestaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/entregable","name":"adjunto.entregable.index","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/entregable","name":"adjunto.entregable.store","action":"App\Http\Controllers\AdjuntoEntregableAcuerdoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto\/evaluacion","name":"adjunto.evaluacion.index","action":"App\Http\Controllers\AdjuntoEvaluacionController@index"},{"host":null,"methods":["POST"],"uri":"adjunto\/evaluacion","name":"adjunto.evaluacion.store","action":"App\Http\Controllers\AdjuntoEvaluacionController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"adjunto\/evaluacion\/{evaluacion}","name":"adjunto.evaluacion.update","action":"App\Http\Controllers\AdjuntoEvaluacionController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"adjunto","name":"adjunto.index","action":"App\Http\Controllers\AdjuntoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"faq\/faqconvocatoria","name":"faq.faqconvocatoria.index","action":"App\Http\Controllers\FaqConvocatoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"faq","name":"faq.index","action":"App\Http\Controllers\PreguntaFrecuenteController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/register","name":"encuesta.register","action":"App\Http\Controllers\EncuestaController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/aplicar\/{encuesta}\/{usuario?}","name":"encuesta.aplicar","action":"App\Http\Controllers\EncuestaController@aplicar"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/responder\/{encuesta}","name":"encuesta.responder","action":"App\Http\Controllers\EncuestaController@responder"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/revision\/{encuesta}\/{usuario}","name":"encuesta.revision","action":"App\Http\Controllers\EncuestaController@revision"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/cancelar\/{encuesta}","name":"encuesta.cancelar","action":"App\Http\Controllers\EncuestaController@cancelar"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/informe","name":"encuesta.informe","action":"App\Http\Controllers\EncuestaController@informe"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta","name":"encuesta.index","action":"App\Http\Controllers\EncuestaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"encuesta\/{encuesta}","name":"encuesta.show","action":"App\Http\Controllers\EncuestaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"encuesta\/{encuesta}","name":"encuesta.update","action":"App\Http\Controllers\EncuestaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"messaging","name":"messaging.index","action":"App\Http\Controllers\MessagingController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"precios","name":"precios","action":"App\Http\Controllers\PaymentsController@pricing"},{"host":null,"methods":["GET","HEAD"],"uri":"comprar","name":"comprar.index","action":"App\Http\Controllers\PaymentsController@index"},{"host":null,"methods":["POST"],"uri":"comprar","name":"comprar.store","action":"App\Http\Controllers\PaymentsController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"voto\/confirmar\/{srcparams}\/{user}","name":"voto.confirmar","action":"App\Http\Controllers\VotoController@confirmVote"},{"host":null,"methods":["POST"],"uri":"voto\/voto","name":"voto.voto.store","action":"App\Http\Controllers\VotoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"voto\/verify\/{vote}","name":"voto.verify","action":"App\Http\Controllers\VotoController@verify"},{"host":null,"methods":["GET","HEAD"],"uri":"recomendacion","name":"recomendacion.index","action":"App\Http\Controllers\RecomendacionController@index"},{"host":null,"methods":["POST"],"uri":"recomendacion","name":"recomendacion.store","action":"App\Http\Controllers\RecomendacionController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"search","name":"search.index","action":"App\Http\Controllers\SearchController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"live","name":"live.index","action":"App\Http\Controllers\LiveController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"enlaconversa","name":"enlaconversa.index","action":"App\Http\Controllers\EnLaConversaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"laconversa","name":"laconversa","action":"App\Http\Controllers\EnLaConversaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"notificaciones","name":"notificaciones.index","action":"App\Http\Controllers\NotificacionesController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"notificaciones\/{notificaciones}","name":"notificaciones.update","action":"App\Http\Controllers\NotificacionesController@update"},{"host":null,"methods":["DELETE"],"uri":"notificaciones\/{notificaciones}","name":"notificaciones.destroy","action":"App\Http\Controllers\NotificacionesController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"caracteristicas","name":"caracteristicas.index","action":"App\Http\Controllers\CaracteristicasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"caracteristicas\/{caracteristicas}","name":"caracteristicas.show","action":"App\Http\Controllers\CaracteristicasController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"breadcrumb","name":"breadcrumb","action":"App\Http\Controllers\HomeController@breadcrumb"},{"host":null,"methods":["GET","HEAD"],"uri":"terminos","name":"terminos","action":"App\Http\Controllers\HomeController@terminos"},{"host":null,"methods":["GET","HEAD"],"uri":"privacidad","name":"privacidad","action":"App\Http\Controllers\HomeController@privacidad"},{"host":null,"methods":["GET","HEAD"],"uri":"politicaventas","name":"politicaventas","action":"App\Http\Controllers\HomeController@politicaventas"},{"host":null,"methods":["GET","HEAD"],"uri":"terminos-mentoria","name":"terminos-mentoria","action":"App\Http\Controllers\HomeController@terminosmentoria"},{"host":null,"methods":["GET","HEAD"],"uri":"entidad","name":"entidad.index","action":"App\Http\Controllers\EntidadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/confirmar","name":"step.confirmar","action":"App\Http\Controllers\UsuarioController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/perfil","name":"step.perfil","action":"App\Http\Controllers\UsuarioController@confirmprofile"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/canales","name":"step.canales","action":"App\Http\Controllers\UsuarioController@channelschoice"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/entidad","name":"step.entidad","action":"App\Http\Controllers\UsuarioController@createentity"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/terminos","name":"step.terminos.index","action":"App\Http\Controllers\TerminosController@index"},{"host":null,"methods":["POST"],"uri":"step\/terminos","name":"step.terminos.store","action":"App\Http\Controllers\TerminosController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/politicaventas","name":"step.politicaventas.index","action":"App\Http\Controllers\PoliticaVentasController@index"},{"host":null,"methods":["POST"],"uri":"step\/politicaventas","name":"step.politicaventas.store","action":"App\Http\Controllers\PoliticaVentasController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso","name":"step.compromiso.index","action":"App\Http\Controllers\CartaCompromisoController@index"},{"host":null,"methods":["POST"],"uri":"step\/compromiso","name":"step.compromiso.store","action":"App\Http\Controllers\CartaCompromisoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso\/{compromiso}","name":"step.compromiso.show","action":"App\Http\Controllers\CartaCompromisoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"step\/compromiso\/{compromiso}\/edit","name":"step.compromiso.edit","action":"App\Http\Controllers\CartaCompromisoController@edit"},{"host":null,"methods":["GET","HEAD"],"uri":"ayuda","name":"ayuda.index","action":"App\Http\Controllers\AyudaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"{category}\/{slug}","name":"landingpage","action":"App\Http\Controllers\HomeController@landing"},{"host":null,"methods":["GET","HEAD"],"uri":"{slug}","name":"landing","action":"App\Http\Controllers\HomeController@show"},{"host":null,"methods":["POST"],"uri":"api\/login","name":"api.","action":"App\Http\Controllers\Api\Security\AuthController@authenticate"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/convocatoria\/informe\/{informe}","name":"api.convocatoria.informe.show","action":"App\Http\Controllers\Api\Convocatoria\InformeController@show"},{"host":null,"methods":["POST"],"uri":"api\/voto\/verifycode","name":"api.voto.verifycode","action":"App\Http\Controllers\Api\Voto\VotoController@verifycode"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/comunidad","name":"api.comunidad.index","action":"App\Http\Controllers\Api\ComunidadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/curso","name":"api.curso.index","action":"App\Http\Controllers\Api\CursoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/blog","name":"api.blog.index","action":"App\Http\Controllers\Api\BlogController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/evento","name":"api.evento.index","action":"App\Http\Controllers\Api\EventoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/foro","name":"api.foro.index","action":"App\Http\Controllers\Api\ForoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/foro\/{foro}","name":"api.foro.show","action":"App\Http\Controllers\Api\ForoController@show"},{"host":null,"methods":["POST"],"uri":"api\/voto","name":"api.voto.store","action":"App\Http\Controllers\Api\Voto\VotoController@store"},{"host":null,"methods":["POST"],"uri":"api\/user","name":"api.user.store","action":"App\Http\Controllers\Api\User\UserController@store"}],
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
				'empodera2020_two':250
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

!(function ($, window, document, undefined) {
    window.onload = function () {

    	// Validate wrapper exist
    	if( !$("#innpulsa-achievements").length ) {
    		return;
    	}

        var rsr = Raphael('innpulsa-colombia-map', '100%', '400');

        rsr.setViewBox(-50, 0, '720', '750');

        rsr.canvas.setAttribute('preserveAspectRatio', 'xMidYMid');

        // document.getElementById('innpulsa-colombia-map').style.width = '100%';
        // document.getElementById('innpulsa-colombia-map').style.height = '650px';

        var colombiamap = rsr.set();

        var colombiawhitebg = rsr.path("M558.323,521.034l-0.586-1.171l-0.376-0.751l-0.121-0.583l0.688-1.358 c0.076-0.152,0.111-0.32,0.104-0.49l-0.049-1.121c-0.004-0.086-0.02-0.172-0.045-0.255l-0.354-1.141 c-0.019-0.058-0.086-0.196-0.114-0.249l-0.443-0.838c-0.043-0.082-0.098-0.158-0.161-0.226l-0.472-0.497 c-0.032-0.034-0.119-0.107-0.155-0.137l-0.412-0.33l-0.201-0.222l-0.041-0.158l0.28-1.651c0.018-0.109,0.017-0.221-0.002-0.33 l-0.184-1.039c-0.014-0.08-0.038-0.159-0.071-0.233l-0.44-0.989c-0.018-0.039-0.07-0.133-0.093-0.17l-0.909-1.5l-0.367-0.823 l-0.132-0.676l0.002-1.93c0-0.044-0.012-0.152-0.018-0.196l-0.122-0.934c-0.01-0.076-0.028-0.15-0.055-0.223l-3.929-10.435 c-0.016-0.042-0.063-0.139-0.084-0.178l-0.73-1.375l-0.081-0.359c-0.021-0.089-0.054-0.175-0.098-0.256l-0.209-0.38 c-0.074-0.135-0.179-0.251-0.306-0.339l-0.69-0.479l-0.231-0.393c-0.036-0.06-0.078-0.116-0.125-0.167l-0.387-0.456l0.403-0.518 c0.025-0.032,0.081-0.118,0.102-0.153l0.179-0.3c0.058-0.097,0.099-0.203,0.121-0.313l0.163-0.826 c0.017-0.083,0.022-0.169,0.018-0.254l-0.159-2.499c-0.007-0.104-0.029-0.206-0.067-0.304l-0.305-0.772 c-0.087-0.221-0.25-0.403-0.459-0.516l-0.722-0.385c-0.056-0.029-0.204-0.081-0.264-0.099l-0.638-0.197l-0.361-0.203l-0.181-0.288 l-0.682-1.772l-0.305-1.333c-0.013-0.058-0.062-0.192-0.085-0.246l-0.622-1.493l-0.004-0.22l1.063-1.052 c0.06-0.056,0.111-0.118,0.155-0.188l0.626-0.967c0.163-0.252,0.205-0.562,0.114-0.848l-0.307-0.961 c-0.025-0.077-0.06-0.151-0.103-0.221l-0.065-0.105l-0.051-0.649c-0.003-0.107-0.022-0.213-0.059-0.314l-0.174-0.481 c-0.051-0.144-0.135-0.272-0.244-0.379l-0.378-0.367c-0.056-0.054-0.117-0.102-0.184-0.142l-1.554-0.937 c-0.065-0.039-0.135-0.071-0.208-0.095l-1.498-0.485l-0.2-0.125l-0.773-0.776c-0.04-0.041-0.15-0.125-0.197-0.158l-0.451-0.323 c-0.089-0.063-0.188-0.112-0.294-0.144l-0.392-0.117l-0.283-0.756c-0.013-0.038-0.054-0.131-0.071-0.168l-0.206-0.436 c-0.06-0.125-0.145-0.236-0.25-0.327l-0.438-0.377c-0.056-0.048-0.117-0.091-0.183-0.126l-0.943-0.51l-0.217-0.168l-0.359-0.698 c-0.034-0.074-0.077-0.144-0.128-0.208l-0.346-0.433c-0.128-0.16-0.303-0.277-0.5-0.336l-0.303-0.089l-0.571-0.69l-0.095-0.226 c-0.02-0.047-0.082-0.153-0.108-0.197l-0.152-0.248c-0.095-0.154-0.229-0.279-0.39-0.363l-0.956-0.474l-0.146-0.109l-0.266-0.815 c-0.015-0.045-0.066-0.158-0.088-0.201l-0.167-0.338c-0.057-0.112-0.133-0.213-0.227-0.297l-0.712-0.637 c-0.107-0.097-0.235-0.169-0.373-0.212l-0.87-0.267c-0.09-0.027-0.182-0.043-0.275-0.045l-1.695-0.027l-0.143-0.567l-0.245-1.996 c-0.011-0.088-0.033-0.175-0.066-0.257l-0.334-0.831c-0.022-0.057-0.099-0.188-0.131-0.238l-0.609-0.969 c-0.057-0.09-0.128-0.171-0.211-0.238l-0.868-0.71c-0.244-0.199-0.568-0.272-0.873-0.196l-0.917,0.228 c-0.033,0.008-0.117,0.037-0.149,0.049l-0.594,0.219l-0.691-0.146l-1.569-0.765l-0.609-0.687c-0.301-0.339-0.793-0.431-1.197-0.228 l-0.915,0.463l-0.224,0.016l-0.941-0.049c-0.103-0.006-0.206,0.007-0.307,0.032l-0.946,0.251c-0.031,0.009-0.062,0.018-0.092,0.029 l0.001-0.124l0.535-0.885l17.417-16.135l0.274-0.129l0.869-0.169c0.046-0.009,0.156-0.044,0.2-0.06l0.416-0.145 c0.102-0.034,0.196-0.085,0.28-0.149l0.576-0.438c0.065-0.05,0.124-0.107,0.175-0.171l2.767-3.458 c0.027-0.034,0.084-0.122,0.107-0.158l1.158-1.878c0.077-0.126,0.126-0.267,0.143-0.413l0.225-1.961 c0.034-0.296-0.065-0.592-0.271-0.807l-1.552-1.611c-0.1-0.104-0.22-0.184-0.353-0.236l-1.624-0.641l-0.417-0.289l-0.438-0.622 l-3.031-7.912c-0.033-0.086-0.077-0.167-0.133-0.24l-1.316-1.758c-0.099-0.131-0.228-0.236-0.376-0.306l-1.751-0.82 c-0.152-0.072-0.319-0.102-0.488-0.093l-0.959,0.062c-0.04,0.003-0.138,0.019-0.177,0.025l-0.699,0.131l-0.489-0.006l-0.455-0.232 l-0.521-0.636l-0.225-0.764l-0.246-2.176c-0.01-0.085-0.03-0.168-0.062-0.247l-0.437-1.14c-0.019-0.048-0.079-0.161-0.104-0.206 l-1.713-2.977l-0.156-0.724l-0.135-2.756c-0.006-0.101-0.025-0.2-0.061-0.294c0,0-0.53-1.445-0.526-1.466 c0.03-0.158,0.021-0.321-0.025-0.476l-0.323-0.956c-0.048-0.136-0.124-0.259-0.223-0.361l-0.332-0.344l-0.311-1.214 c-0.043-0.162-0.125-0.311-0.24-0.433l-0.879-0.933c-0.027-0.029-0.106-0.097-0.138-0.123l-0.625-0.513l-0.218-0.5l-0.183-1.281 c-0.006-0.044-0.032-0.15-0.045-0.193l-0.366-1.312l-0.215-1.308l0.186-1.368l0.729-1.331c0.044-0.083,0.077-0.172,0.097-0.264 l0.123-0.572c0.032-0.149,0.03-0.304-0.007-0.452l-0.155-0.624c-0.025-0.103-0.067-0.201-0.124-0.291l-0.558-0.88l-0.047-0.198 l0.463-1.149c0.104-0.254,0.099-0.54-0.015-0.79c-0.113-0.25-0.325-0.443-0.585-0.533l-0.652-0.226l-0.271-1.167 c-0.021-0.083-0.051-0.163-0.091-0.237l-0.341-0.63c-0.071-0.13-0.17-0.243-0.29-0.33l-0.515-0.373 c-0.202-0.147-0.455-0.212-0.7-0.184l-0.268-0.247l-0.142-0.201l-0.035-0.125l0.186-0.183c0.105-0.072,0.196-0.165,0.268-0.271 l0.267-0.396c0.083-0.124,0.139-0.265,0.16-0.414l0.068-0.463c0.01-0.065,0.009-0.227,0.006-0.292l-0.056-1.23l0.259-1.068 c0.014-0.057,0.026-0.204,0.029-0.262l0.134-2.376l0.171-0.737l0.362-0.576c0.019-0.03,0.059-0.109,0.073-0.141l0.342-0.707 c0.058-0.119,0.09-0.248,0.098-0.379l0.098-1.877l0.274-0.726c0.102-0.271,0.08-0.574-0.059-0.829l-0.019-0.034l0.019-0.038 c0.06-0.125,0.093-0.261,0.097-0.399l0.018-0.598c0.003-0.13-0.02-0.26-0.065-0.381l-0.072-0.189l-0.969,0.268l0.914-0.41 c-0.014-0.034-0.054-0.116-0.07-0.148l-0.348-0.676l-0.013-0.043l0.031-0.812l0.285-1.616l0.564-1.705 c0.025-0.077,0.042-0.156,0.049-0.237l0.078-0.877c0.004-0.043,0.003-0.151,0.001-0.195c0,0-0.065-1.658-0.049-1.675 c0.034-0.037,0.155-0.208,0.184-0.25l0.432-0.634c0.255-0.374,0.227-0.871-0.067-1.214l-1.157-1.346l-0.177-0.273l-0.092-0.269 l-0.099-0.663l0.012-0.364l0.084-0.387l0.382-1.005c0.015-0.04,0.043-0.143,0.053-0.184l0.083-0.345 c0.023-0.095,0.032-0.193,0.027-0.291l-0.06-1.11c-0.003-0.052-0.027-0.184-0.039-0.234l-0.142-0.647 c0-0.003-0.021-0.096-0.022-0.099c-0.013-0.057-0.065-0.198-0.089-0.252l-0.259-0.612c-0.015-0.034-0.057-0.115-0.074-0.146 l-0.324-0.578l-0.345-1.384l0.328-1.496l0.945-1.505l1.26-1.046l0.434,0.067c0.345,0.056,0.694-0.077,0.919-0.346l0.646-0.771 l1.229-0.483c0.072-0.028,0.142-0.064,0.206-0.109l0.403-0.279c0.06-0.042,0.114-0.09,0.164-0.144l0.776-0.844l0.235-0.168 l0.581-0.148c0.338-0.086,0.606-0.343,0.709-0.678l0.517-1.705l0.364-0.363c0.047-0.043,0.146-0.17,0.183-0.222l0.576-0.796 c0.29-0.401,0.242-0.954-0.111-1.3l-0.948-0.927l-0.044-0.574c-0.003-0.031-0.016-0.111-0.021-0.141l-0.491-2.56l-0.002-1.903 l0.326-1.765l0.652-1.619l0.966-1.463l2.635-2.491c0.069-0.066,0.13-0.142,0.178-0.225l0.373-0.645l1.977-2.167l0.453-0.276 l1.586-0.675c0.086-0.037,0.167-0.086,0.239-0.146l0.592-0.486c0.171-0.141,0.29-0.334,0.339-0.55l0.187-0.824 c0.023-0.105,0.03-0.214,0.02-0.322l-0.112-1.082c-0.009-0.083-0.028-0.165-0.057-0.243l-0.358-0.955 c-0.069-0.187-0.193-0.349-0.356-0.465l-1.033-0.739l-1.406-2.219l0.002-1.278l0.077-0.238l0.887-0.965 c0.215-0.234,0.306-0.556,0.245-0.868s-0.267-0.576-0.554-0.712l-1.133-0.537l-1.128-0.854l-1.173-1.132 c-0.05-0.047-0.104-0.089-0.162-0.125l-1.342-0.844c-0.095-0.06-0.198-0.103-0.307-0.128l-7.19-1.679 c-0.046-0.011-0.164-0.024-0.211-0.028l-3.021-0.257l-0.715-0.21c-0.104-0.031-0.203-0.045-0.32-0.039l-0.424,0.018 c-0.14,0.006-0.276,0.041-0.401,0.103l-0.569,0.282c-0.104,0.051-0.199,0.121-0.28,0.205l-0.811,0.842l-0.215,0.177l-0.115,0.018 l-1.025-0.027c-0.412-0.04-0.803,0.243-0.956,0.635l-0.289,0.736c-0.017,0.041-0.03,0.083-0.041,0.125l-0.094,0.441l-0.087,0.168 l-0.554,0.16c-0.05,0.009-0.17,0.046-0.218,0.063l-1.432,0.492l-1.648,0.251l-5.688-0.547c-0.077-0.008-0.154-0.007-0.231,0.004 l-2.015,0.275c-0.07,0.009-0.14,0.026-0.206,0.051l-5.044,1.819l-1.35,0.002l-2.855-0.794c-0.048-0.013-0.172-0.031-0.22-0.037 l-0.887-0.104c-0.073-0.008-0.148-0.009-0.224-0.001l-1.001,0.109c-0.06,0.006-0.206,0.044-0.264,0.062l-3.161,0.939l-2.719,0.142 c-0.128,0.007-0.253,0.038-0.368,0.091l-0.525,0.245c-0.087,0.041-0.167,0.093-0.238,0.156l-1.097,0.964l-0.197,0.089l-0.62-0.079 l-1.741-0.817c-0.066-0.031-0.135-0.054-0.205-0.07l-0.963-0.212c-0.034-0.008-0.125-0.019-0.16-0.023l-0.882-0.095l-2.808-0.861 c-0.044-0.014-0.155-0.035-0.201-0.042l-0.92-0.151c-0.07-0.011-0.143-0.016-0.214-0.011l-2.792,0.152l-0.769-0.16l-1.022-0.364 c-0.034-0.012-0.124-0.035-0.159-0.043l-0.996-0.233c-0.165-0.039-0.339-0.034-0.506,0.012l-0.449,0.129l-1.366-0.609 c-0.059-0.025-0.213-0.068-0.274-0.082l-0.874-0.202c-0.083-0.019-0.164-0.026-0.259-0.024l-1.131,0.044 c-0.127,0.004-0.252,0.034-0.368,0.085l-0.897,0.4c-0.105,0.047-0.201,0.112-0.285,0.191l-1.211,1.159l-0.879,0.516 c-0.069,0.041-0.134,0.09-0.191,0.146l-2.614,2.545l-1.86,1.049l-0.382-0.287l-1.882-2.161c-0.085-0.096-0.187-0.176-0.301-0.234 l-0.949-0.484c-0.194-0.099-0.415-0.131-0.63-0.093l-1.26,0.225c-0.084,0.015-0.165,0.041-0.241,0.077l-2.13,0.995l-0.831,0.237 l-29.479-37.363c-0.038-0.047-0.15-0.152-0.195-0.192l-1.437-1.249c-0.12-0.104-0.264-0.178-0.417-0.216l-1.33-0.328 c-0.097-0.023-0.193-0.033-0.294-0.028l-1.716,0.091c-0.064,0.003-0.225,0.037-0.288,0.053l-1.577,0.396 c-0.087,0.022-0.171,0.056-0.249,0.1l-2.313,1.306l-0.923-0.04l-4.535-2.183c-0.032-0.016-0.116-0.048-0.15-0.06l-0.372-0.131 l-0.251-0.378c-0.176-0.265-0.467-0.43-0.784-0.445l-0.595-0.029c-0.049-0.003-0.098-0.001-0.146,0.003l-1.023,0.13l-0.278-0.005 l-0.458-0.123l-0.168-0.099l-2.444-3.115c-0.229-0.289-0.598-0.433-0.961-0.366l-0.864,0.154c-0.043,0.008-0.148,0.038-0.189,0.051 l-1.101,0.35l-0.46,0.017l-1.337-0.308l-0.189-0.07l-0.689-0.597c-0.187-0.16-0.428-0.246-0.673-0.241l-1.514,0.033 c-0.07,0.001-0.14,0.01-0.207,0.026l-2.677,0.638l-1.906,0.141c-0.083,0.006-0.165,0.022-0.244,0.049l-1.611,0.54l-1.074,0.032 c-0.375,0.012-0.711,0.233-0.872,0.572l-0.262,0.555l-0.361,0.501l-1.695,1.203l-2.028,0.757l-2.223,0.26l-3.119-0.36 c-0.229-0.026-0.465,0.029-0.66,0.156l-0.457,0.297c-0.075,0.049-0.144,0.107-0.203,0.174l-0.302,0.338l-0.346,0.245l-0.291,0.089 l-0.136-0.117c-0.065-0.057-0.139-0.104-0.216-0.142l-0.562-0.27c-0.127-0.062-0.267-0.095-0.407-0.098l-2.049-0.05l-0.038-0.32 c-0.003-0.038-0.032-0.211-0.038-0.249l-0.134-0.737c-0.08-0.437-0.438-0.769-0.88-0.816l-1.118-0.119 c-0.098-0.009-0.197-0.006-0.295,0.013l-1.777,0.341l-0.511-0.04l-1.369-0.378c-0.056-0.016-0.199-0.034-0.257-0.04l-0.646-0.062 c-0.1-0.011-0.206-0.005-0.307,0.017l-0.726,0.153c-0.074,0.016-0.146,0.04-0.215,0.071l-1.061,0.488l-0.483-0.402 c-0.113-0.094-0.245-0.162-0.388-0.198l-1.053-0.27c-0.165-0.042-0.338-0.042-0.503,0.002l-0.728,0.192 c-0.081,0.021-0.159,0.053-0.232,0.093l-0.262-0.349c-0.307-0.408-0.871-0.52-1.31-0.26l-0.794,0.47l-0.222-0.277 c-0.069-0.099-0.155-0.185-0.255-0.252l-0.389-0.266c-0.146-0.099-0.313-0.158-0.488-0.171l-2.719-0.112 c-0.323-0.019-0.615,0.126-0.812,0.37c-0.123,0.151-0.196,0.332-0.218,0.52l-1.067,0.07c-0.033,0.002-0.119,0.016-0.152,0.021 l-0.953,0.167l-1.087,0.015c-0.507,0.007-0.928,0.392-0.98,0.896l-0.379,0.019c-0.176,0.009-0.346,0.063-0.493,0.159l-0.59,0.381 c-0.037,0.024-0.121,0.091-0.154,0.12l-0.341,0.289l-0.246,0.15l-0.37,0.059l-1.284-0.109l-3.489-0.818 c-0.042-0.016-0.085-0.029-0.129-0.04l-1.455-0.343c-0.069-0.017-0.14-0.025-0.211-0.027l-1.576-0.033l-0.124-0.069 c-0.026-0.182-0.104-0.357-0.228-0.503l-1.979-2.325l-2.427-4.704l-0.448-1.183l-0.3-1.199l-0.108-1.192l0.447-2.076 c0.076-0.329-0.02-0.674-0.253-0.918l-0.337-0.351l-1.558-2.027c-0.131-0.171-0.314-0.295-0.521-0.354l-1.563-0.442 c-0.095-0.026-0.191-0.04-0.289-0.038l-3.659,0.056l-2.053-0.384l-1.778-0.603l-1.373-1l-1.017-1.666l-0.085-0.634l0.2-0.662 l0.369-0.878c0.028-0.068,0.05-0.139,0.062-0.211l0.185-1.035c0.021-0.116,0.021-0.236,0-0.352l-0.157-0.896 c-0.01-0.052-0.049-0.177-0.066-0.227l-0.565-1.641l-0.102-0.717l0.401-4.585l0.877-2.702c0.019-0.056,0.044-0.202,0.052-0.26 l0.086-0.637c0-0.001,0.013-0.1,0.013-0.102c0.009-0.063,0.005-0.225,0.001-0.289l-0.117-1.91 c-0.003-0.059-0.032-0.203-0.046-0.261l-0.174-0.731c-0.026-0.109-0.07-0.212-0.13-0.307l-0.325-0.515 c-0.027-0.044-0.106-0.143-0.141-0.182l-0.623-0.723l0.146-0.053c0.035-0.013,0.117-0.052,0.15-0.068l0.448-0.222 c0.071-0.035,0.138-0.079,0.199-0.129l0.689-0.573c0.04-0.034,0.131-0.131,0.166-0.171l0.496-0.569 c0.05-0.058,0.094-0.122,0.13-0.189l0.388-0.746c0.037-0.071,0.065-0.146,0.085-0.224l0.188-0.781l0.121-0.217l0.17-0.022 l0.801,0.137c0.054,0.009,0.188,0.014,0.244,0.014c0,0,0.746,0.003,0.751,0.003c0.326,0,0.632-0.159,0.819-0.426l0.776-1.108 c0.128-0.182,0.191-0.401,0.181-0.623l-0.089-1.805c-0.004-0.085-0.02-0.17-0.045-0.252l-0.984-3.158 c-0.019-0.061-0.087-0.201-0.116-0.256l-1.42-2.681l-0.176-0.734l0.036-0.474l0.382-1.401c0.015-0.052,0.032-0.18,0.038-0.233 l0.079-0.693c0.011-0.091,0.009-0.184-0.007-0.275l-0.129-0.793c-0.013-0.073-0.032-0.145-0.061-0.214l-0.312-0.78 c-0.023-0.06-0.104-0.196-0.138-0.25l-0.4-0.63c-0.038-0.061-0.083-0.117-0.133-0.167l-0.552-0.561 c-0.069-0.07-0.148-0.13-0.235-0.178l-0.471-0.255c-0.07-0.038-0.144-0.067-0.221-0.087l-0.629-0.198l-0.343-0.293l-8.975-9.75 l-0.778-1.328l-4.878-18.74c-0.038-0.146-0.109-0.282-0.208-0.397l-0.273-0.319l0.457-0.74c0.141-0.228,0.185-0.503,0.121-0.763 c-0.063-0.26-0.229-0.484-0.459-0.621l-1.146-0.685l-0.615-0.589c-0.271-0.26-0.67-0.346-1.021-0.22l-0.384,0.135l-0.234-0.082 c-0.097-0.034-0.198-0.052-0.301-0.054l-0.548-0.014c-0.11-0.009-0.21,0.011-0.309,0.041l-0.576,0.17 c-0.062,0.018-0.206,0.086-0.264,0.116l-0.283,0.146c-0.034,0.017-0.112,0.066-0.144,0.087l-1.429,0.948l-0.501,0.194l-0.134-0.037 l-0.48-0.665l-0.156-0.641l0.113-1.779c0.005-0.075,0.001-0.151-0.012-0.226l-0.203-1.245c-0.033-0.205-0.13-0.394-0.274-0.542 l-0.269-0.272l0.015-0.033c0.104-0.23,0.116-0.491,0.035-0.73l-0.743-2.189c-0.142-0.417-0.539-0.698-0.981-0.678l-1.29,0.044 c-0.244,0.008-0.476,0.105-0.653,0.272l-1.91,1.801l-0.812,0.458l-1.049,0.293c-0.1,0.028-0.194,0.071-0.28,0.128l-0.814,0.539 c-0.049,0.032-0.157,0.128-0.199,0.168l-1.398,1.324l-1.347,0.659l-1.662,0.229l-4.956,0.123c-0.047,0.001-0.093,0.006-0.139,0.013 l0.271-0.468l1.501-1.034c0.042-0.029,0.138-0.116,0.175-0.151l0.768-0.733c0.061-0.059,0.113-0.124,0.158-0.195l0.589-0.962 c0.029-0.047,0.086-0.177,0.106-0.229l1.5-3.785l3.589-5.312c0.036-0.054,0.105-0.201,0.131-0.26l0.744-1.767l0.425-0.383 l1.753-1.103c0.073-0.045,0.139-0.1,0.197-0.162l0.739-0.786c0.058-0.061,0.107-0.128,0.148-0.201l0.48-0.855 c0.028-0.049,0.079-0.175,0.099-0.228l1.09-2.964l2.45-3.817c0.02-0.031,0.063-0.117,0.08-0.151l1.412-2.901 c0.023-0.048,0.065-0.175,0.08-0.226l0.346-1.148c0.048-0.16,0.055-0.33,0.021-0.493l-0.186-0.878 c-0.017-0.081-0.043-0.159-0.078-0.233l-0.361-0.764l-0.234-0.945l0.029-0.707l0.363-1.731c0.013-0.063,0.02-0.128,0.021-0.193 l0.007-1.681l2.339-8.003c0.018-0.062,0.039-0.223,0.045-0.288l0.911-10.079c0.004-0.042,0.002-0.147,0-0.19l-0.045-1.293 l0.293-0.798l0.573-0.762l0.711-0.729c0.03-0.031,0.098-0.116,0.124-0.15l0.608-0.815c0.062-0.083,0.111-0.176,0.146-0.274 l0.781-2.269l2.674-3.116c0.037-0.042,0.111-0.157,0.141-0.205l1.2-1.967c0.037-0.061,0.067-0.125,0.091-0.192l2.185-6.281 l0.966-1.881l1.027-1.177l1.891-1.324c0.041-0.029,0.138-0.117,0.175-0.152l0.796-0.773c0.043-0.041,0.133-0.156,0.168-0.204 l0.782-1.078c0.048-0.066,0.087-0.138,0.118-0.213l1.531-3.794l0.256-0.362l0.818-0.885c0.029-0.032,0.096-0.121,0.121-0.157 l0.314-0.448c0.065-0.093,0.114-0.196,0.146-0.305l0.135-0.475c0.02-0.071,0.031-0.144,0.035-0.218l0.029-0.661l0.362-0.237 l0.683-0.101l1.915-0.082c0.105-0.004,0.209-0.026,0.309-0.062l2.475-0.926l0.676-0.14l0.636,0.069l1.634,0.433 c0.165,0.044,0.337,0.044,0.502,0.002l0.847-0.217c0.211-0.054,0.397-0.175,0.533-0.345l0.497-0.624 c0.039-0.048,0.116-0.181,0.146-0.236l11.287-21.155l0.645-0.926l0.573-0.382l23.635-6.176c0.052-0.013,0.173-0.061,0.222-0.082 l1.761-0.761c0.093-0.04,0.179-0.093,0.255-0.159l1.495-1.285l0.467-0.259l1.191,0.039c0.433,0.007,0.824-0.257,0.97-0.665 l0.977-2.745l0.102-0.021c0.05-0.011,0.17-0.052,0.218-0.07l0.716-0.27c0.043-0.016,0.146-0.069,0.186-0.091l0.619-0.339 c0.099-0.054,0.187-0.124,0.262-0.208l0.816-0.908l2.989-1.645c0.042-0.023,0.137-0.09,0.175-0.119l1.182-0.886 c0.074-0.055,0.139-0.12,0.195-0.192l0.559-0.732c0.025-0.034,0.083-0.128,0.104-0.166l0.539-0.94 c0.045-0.077,0.079-0.16,0.102-0.246l0.288-1.078c0.05-0.186,0.045-0.382-0.014-0.565l-0.3-0.938 c-0.028-0.089-0.069-0.173-0.121-0.251l-1.636-2.44l-0.26-1.086c-0.022-0.092-0.059-0.18-0.106-0.262l-2.685-4.602l-0.127-0.711 c-0.02-0.103-0.055-0.203-0.104-0.294l-0.217-0.398c-0.027-0.05-0.114-0.167-0.15-0.212l-0.573-0.883 c-0.067-0.109-0.154-0.204-0.257-0.28l-0.908-0.674c-0.045-0.033-0.166-0.1-0.216-0.125l-1.463-0.747 c-0.082-0.042-0.169-0.071-0.259-0.089l-2.025-0.395l-0.697-0.258l-0.78-0.593c-0.056-0.042-0.116-0.079-0.181-0.108l-0.438-0.205 c-0.139-0.064-0.271-0.091-0.445-0.094l-1.5,0.032l-0.274-0.08l-0.567-0.535c-0.001-0.001-0.071-0.07-0.073-0.071 c-0.045-0.044-0.174-0.137-0.227-0.172l-1.345-0.892c-0.042-0.028-0.153-0.084-0.198-0.105l-0.886-0.415 c-0.074-0.035-0.152-0.061-0.233-0.077l-0.846-0.168c-0.001,0-0.098-0.019-0.099-0.019c-0.063-0.013-0.228-0.019-0.292-0.019 h-3.116l-1.264-0.251c-0.301-0.058-0.613,0.022-0.846,0.222c-0.233,0.2-0.361,0.496-0.348,0.803l0.038,0.856l-0.919,0.362 c-0.062,0.02-0.121,0.045-0.177,0.076c-0.001,0-0.088,0.048-0.088,0.049l-0.828,0.458c-0.113,0.063-0.211,0.146-0.29,0.243 l-0.87-0.72c-0.272-0.228-0.647-0.291-0.982-0.168c-0.334,0.123-0.578,0.414-0.64,0.765l-0.299,1.692l-0.112,0.205l-0.955,0.566 l-0.532,0.04c-0.363,0.027-0.681,0.25-0.832,0.575l-0.129-0.147l-0.487-1.539c-0.11-0.351-0.406-0.613-0.768-0.681 c-0.366-0.065-0.733,0.068-0.964,0.355l-1.096,1.358l-2.7,2.333c-0.264,0.229-0.39,0.578-0.332,0.921 c0.058,0.344,0.29,0.633,0.614,0.763l1.904,0.764l0.202,0.268c-0.141,0.322-0.104,0.7,0.122,1.009l-0.353,0.019 c-0.149,0.007-0.295,0.049-0.426,0.12l-0.442,0.241c-0.085,0.046-0.162,0.104-0.23,0.172l-0.42,0.423 c-0.061,0.062-0.113,0.13-0.156,0.206l-0.313,0.543c-0.057,0.098-0.097,0.204-0.118,0.315l-0.024,0.129l-0.629,0.291l-0.556-0.88 l1.851-1.938c0.249-0.261,0.339-0.635,0.234-0.98c-0.104-0.345-0.386-0.607-0.738-0.686l-2.286-0.514 c-0.131-0.029-0.266-0.032-0.396-0.009l-4.432,0.79l-1.17-0.432c-0.278-0.101-0.586-0.073-0.841,0.075l-1.985,1.151 c-0.279,0.162-0.463,0.447-0.494,0.767c-0.031,0.321,0.093,0.637,0.335,0.849l1.291,1.135l0.179,0.727l0.176,2.486l-0.046,0.604 l-1.148,1.597c-0.071,0.095-0.125,0.203-0.159,0.317l-0.424,1.442l-1.554,2.439c-0.041,0.065-0.074,0.134-0.1,0.207l-0.578,1.686 c-0.017,0.046-0.042,0.163-0.052,0.211l-0.124,0.447l-0.684,0.68c-0.027,0.028-0.092,0.105-0.116,0.136l-0.369,0.475l-2.153,0.861 c-0.076,0.031-0.148,0.07-0.214,0.118l-1.833,1.336l-1.282,0.313c-0.148,0.037-0.287,0.107-0.404,0.206l-1.113,0.934l-0.52,0.302 l-0.591,0.152l-2.608,0.091c-0.099,0.004-0.195,0.021-0.288,0.054l-1.059,0.362c-0.088,0.03-0.171,0.073-0.247,0.125l-0.953,0.668 l-0.515,0.261l-0.563-0.166c-0.296-0.087-0.618-0.032-0.869,0.15l-1.337,0.968l-0.511,0.237l-2.657,0.576 c-0.039,0.009-0.134,0.039-0.172,0.052l-1.628,0.564c-0.064,0.022-0.128,0.052-0.187,0.088l-0.845,0.509 c-0.043,0.026-0.141,0.101-0.18,0.133l-7.831,6.434l-5.425,2.877c-0.083,0.044-0.16,0.1-0.228,0.165l-2.486,2.381l-1.36,0.616 c-0.085,0.039-0.164,0.09-0.235,0.151l-0.52,0.447c-0.06,0.051-0.112,0.109-0.158,0.173l-0.594,0.837l-0.137,0.131l-0.483,0.142 c-0.269,0.081-0.491,0.27-0.613,0.522l-0.555,1.14l-0.194,0.234l-1.167,0.666c-0.043,0.024-0.142,0.095-0.181,0.125l-1.344,1.028 c-0.074,0.056-0.14,0.123-0.195,0.197l-0.173,0.234l-4.829,0.777l-8.597,0.01c-0.022,0-0.082,0.004-0.104,0.006l-5.038,0.4 l-5.313-0.381l-1.56-0.496l-1.377-0.812c-0.093-0.055-0.193-0.094-0.299-0.116l-2.018-0.436l-0.739-0.638 c-0.024-0.022-0.097-0.076-0.123-0.096l-0.728-0.526c-0.068-0.049-0.142-0.09-0.22-0.121l-0.903-0.356 c-0.085-0.034-0.174-0.056-0.265-0.065l-1.176-0.124c-0.096-0.01-0.195-0.006-0.292,0.012l-0.791,0.153 c-0.293,0.057-0.541,0.239-0.684,0.494h-0.091c-0.31,0-0.603,0.144-0.791,0.389l-0.049,0.063l-0.157-0.113 c-0.26-0.188-0.595-0.238-0.896-0.139l-0.293,0.096l-0.61-0.001c-0.318,0-0.617,0.151-0.806,0.408l-0.188,0.256 c-0.116,0.028-0.229,0.077-0.329,0.145l-0.221,0.15l-0.144-0.034c-0.099-0.022-0.199-0.031-0.299-0.024l-0.766,0.051 c-0.347,0.023-0.655,0.224-0.817,0.53l-0.624,1.181c-0.059,0.112-0.097,0.234-0.11,0.36l-0.013,0.119 c-0.046,0.035-0.088,0.075-0.126,0.117l-0.25,0.275c-0.026,0.03-0.085,0.108-0.108,0.14l-0.57,0.802 c-0.023,0.033-0.073,0.118-0.093,0.154l-0.436,0.788c-0.192,0.349-0.16,0.779,0.083,1.094l-0.181,0.164 c-0.33,0.298-0.423,0.779-0.229,1.179l0.6,1.233l0.026,0.143l-0.266,0.895c-0.03,0.092-0.047,0.188-0.05,0.284l-0.014,0.531 c-0.004,0.146,0.024,0.292,0.083,0.426l0.201,0.464c0.036,0.082,0.083,0.159,0.139,0.229l0.476,0.585l-2.747,4.012 c-0.036,0.053-0.067,0.11-0.092,0.17l-0.441,1.054c-0.026,0.063-0.046,0.129-0.06,0.197l-0.311,1.622l-0.592,0.708 c-0.029,0.036-0.123,0.179-0.147,0.218l-0.093,0.149c-0.061,0.098-0.104,0.205-0.128,0.317l-0.517,1.171 c-0.075,0.149-0.112,0.315-0.107,0.482l0.038,1.226l-1.24,2.304c-0.044,0.081-0.077,0.167-0.097,0.256l-0.012,0.051 c-0.02,0.018-0.037,0.034-0.049,0.046l-0.71,0.69l-0.164,0.088l-1.698,0.108l-0.146-0.021l-0.662-1.447 c-0.138-0.317-0.43-0.541-0.772-0.59c-0.34-0.051-0.687,0.081-0.909,0.345L208.398,82c0,0-0.213,0.149-0.241,0.149l-0.163-3.608 c0.065-0.027,0.128-0.061,0.187-0.102l0.254-0.176l0.915-0.226c0.281-0.069,0.519-0.258,0.65-0.517 c0.132-0.258,0.146-0.561,0.036-0.83l-0.562-1.414l0.16-0.112c0.314-0.221,0.475-0.604,0.411-0.983l-0.098-0.615l0.375-1.114 c0.097-0.285,0.06-0.597-0.101-0.851c-0.159-0.254-0.425-0.423-0.723-0.46l-1.229-0.154l-2.112-0.551l-3.276-1.115l-4.435-1.829 c-0.019-0.008-0.101-0.039-0.12-0.045l-7.009-2.373c-0.443-0.153-0.937,0.028-1.179,0.433s-0.17,0.923,0.175,1.245l1.894,1.771 l-1.154,0.142c0,0-1.319-0.003-1.321-0.003c-0.496,0-0.917,0.363-0.989,0.854l-0.064,0.44l-0.783,0.628 c-0.049,0.039-0.155,0.152-0.195,0.2l-0.363,0.422l-0.464,0.178l-0.677,0.036c-0.12,0.007-0.237,0.035-0.348,0.083l-0.647,0.287 c-0.052,0.023-0.171,0.095-0.218,0.126l-0.379,0.25c-0.155,0.102-0.279,0.246-0.357,0.414l-0.203,0.435 c-0.03,0.065-0.053,0.132-0.068,0.202l-0.216,0.98l-0.166,0.384c-0.063,0.149-0.091,0.312-0.078,0.474l0.025,0.314l-0.22,0.255 l-0.638,0.368l-1.592,0.385c-0.116,0.028-0.226,0.076-0.324,0.143l-2.814,1.882l-0.674,0.212l-0.443,0.035 c-0.103,0.008-0.202,0.032-0.297,0.071l-0.525,0.215c-0.154,0.063-0.291,0.165-0.397,0.295l-0.546,0.673 c-0.185,0.227-0.26,0.523-0.207,0.811l0.034,0.186c-0.053,0.04-0.102,0.086-0.146,0.137l-2.796,3.184l-0.21,0.167l-2.771,0.699 c-0.062,0.016-0.206,0.077-0.263,0.103l-1.184,0.553c-0.18,0.084-0.33,0.219-0.434,0.389c0,0-0.132,0.218-0.13,0.219 c-0.017,0.024-0.03,0.048-0.039,0.062l-0.25,0.417l-0.437,0.472c-0.036,0.036-0.07,0.074-0.101,0.114l-1.003-0.081 c-0.323-0.033-0.645,0.108-0.852,0.36c-0.208,0.252-0.279,0.59-0.191,0.905l0.256,0.92l-0.243,0.142l-0.369,0.131l-1.799,0.24 c-0.347,0.047-0.644,0.271-0.783,0.59c-0.141,0.32-0.103,0.69,0.098,0.976l0.89,1.265l0.031,0.072l-0.002,0.273 c0,0.046,0.013,0.157,0.02,0.203l0.033,0.244l-0.182,0.565c-0.151,0.468,0.061,0.977,0.499,1.199l0.404,0.205l0.049,0.408 l-0.03,0.954c0,0-0.128,0.445-0.128,0.445c-0.001,0.005-1.216-0.182-1.368-0.169c-0.588,0.05-1.147,0.441-1.342,1.007 c-0.352,1.019,0.538,1.753,1.199,2.367l0.058,0.67c0.003,0.034,0.019,0.12,0.025,0.154l0.22,1.122l0.014,0.424l-1.516,0.971 l-1.056,0.245c-0.279,0.065-0.512,0.246-0.646,0.489l-0.184-0.011c-0.277-0.018-0.546,0.083-0.746,0.271 c-0.2,0.19-0.313,0.454-0.312,0.729l0.003,0.938c0,0-0.041,0.169-0.041,0.169c-0.12,0.493-0.612,0.741-0.838,1.158 c-0.246,0.453-0.337,1.199-0.125,1.674c0.167,0.373,0.52,0.637,0.901,0.786c0.365,0.142,0.917,0.299,1.297,0.201 c0.283-0.073,0.749-0.6,1.043-0.245c0.125,0.151,0.131,0.372,0.067,0.557c-0.253,0.73-0.866,1.256-1.173,1.972 c-0.253,0.59-0.338,1.281-0.087,1.871c0.194,0.456,0.667,0.884,0.678,1.401c0.006,0.268-0.141,0.604-0.202,0.863 c-0.135,0.568-0.27,1.136-0.406,1.704c-0.02,0.083-0.028,0.167-0.026,0.252l0.018,0.853l-0.155,0.757l-0.466,1.444l-0.558,1.229 c-0.02,0.043-0.057,0.159-0.069,0.205l-0.27,0.94c-0.028,0.099-0.041,0.201-0.037,0.304l0.03,0.914l-0.719,2.337l-0.35,1.021 l-1.861,1.878c-0.251,0.255-0.348,0.625-0.252,0.97c0.096,0.345,0.368,0.612,0.715,0.702l1.555,0.399l0.862,0.605 c0.178,0.135,0.422,0.195,0.614,0.206l0.108-0.001l0.214,0.381c0.055,0.099,0.127,0.188,0.212,0.263l0.68,0.724l0.353,0.917 l-0.035,2.365l-0.815,2.696l-0.964,1.863l-1.504,1.318l-0.204,0.147l-0.742-0.218c-0.082-0.024-0.165-0.036-0.248-0.037 l-0.551-0.154c-0.036-0.01-0.126-0.027-0.163-0.033l-0.984-0.162c-0.112-0.019-0.227-0.019-0.337,0.001l-1.061,0.185 c-0.097,0.017-0.189,0.047-0.277,0.091l-0.886,0.443c-0.041,0.021-0.138,0.084-0.176,0.11l-0.21,0.144 c-0.07-0.076-0.152-0.141-0.244-0.192c-0.232-0.13-0.508-0.161-0.765-0.088l-0.393,0.113l-0.025-0.32 c-0.023-0.285-0.167-0.545-0.396-0.717c-0.229-0.171-0.519-0.239-0.798-0.182l-1.031,0.207l-0.977,0.057l-0.2-0.182 c-0.155-0.14-0.351-0.229-0.559-0.252l-1.385-0.158c-0.271-0.029-0.535,0.048-0.743,0.217c-0.208,0.169-0.34,0.415-0.365,0.682 l-0.14,1.453l-0.679,0.576l-1.106,0.643l-3.214,1.004c-0.038,0.012-0.131,0.052-0.167,0.069l-0.347,0.159 c-0.058,0.027-0.19,0.114-0.242,0.151l-0.288,0.206c0,0-0.081,0.059-0.082,0.059c-0.054,0.039-0.103,0.083-0.148,0.131l-0.513,0.55 c-0.087,0.092-0.154,0.199-0.201,0.317l-0.182,0.46c-0.032,0.082-0.053,0.167-0.063,0.254l-0.095,0.82 c-0.006,0.044-0.007,0.158-0.006,0.203l0.009,0.428l-0.085,0.03c-0.06,0.021-0.2,0.098-0.255,0.13l-1.551,0.597 c-0.242,0.092-0.439,0.274-0.55,0.508l-0.301,0.636c-0.043,0.091-0.072,0.188-0.086,0.287l-0.517,3.734l-0.174,0.424l-0.271,0.349 l-1.459,1.296c-0.037,0.032-0.117,0.122-0.148,0.16l-0.858,1.017c-0.077,0.092-0.137,0.198-0.177,0.312l-0.472,1.358 c-0.063,0.183-0.073,0.381-0.026,0.569l0.283,1.14l-1.529,1.106c-0.085,0.062-0.16,0.136-0.223,0.221l-0.429,0.588 c-0.028,0.038-0.087,0.144-0.109,0.186l-0.084,0.16l-0.545,0.062c-0.136,0.016-0.267,0.061-0.385,0.129l-0.967,0.567l-2.911,0.719 c-0.516,0.128-0.842,0.638-0.74,1.16l0.115,0.6l-0.329,0.31l-2.58,1.796c-0.052,0.036-0.165,0.143-0.209,0.187l-1.883,1.913 l-0.429,0.292l-3.521,1.306c-0.364,0.136-0.617,0.47-0.648,0.858l-0.01,0.127c-0.146,0.108-0.261,0.253-0.331,0.421l-0.112,0.27 c-0.001,0.001-0.039,0.093-0.039,0.093l-0.051,0.122c-0.034,0.081-0.057,0.165-0.068,0.25l-0.073,0.544 c-0.005,0.039-0.01,0.133-0.011,0.172l-0.002,0.083l-4.422,1.304l-0.997,0.078c-0.075,0.006-0.149,0.021-0.221,0.043l-4.554,1.43 c-0.235,0.074-0.435,0.231-0.561,0.442l-0.55,0.924l-2.195,2.595c-0.238,0.282-0.302,0.673-0.165,1.016 c0.137,0.343,0.451,0.583,0.818,0.624l2.131,0.236l1.422,0.676l1.266,0.862l0.686,0.739l0.183,0.512l0.16,0.757 c0.015,0.069,0.037,0.136,0.065,0.2l0.306,0.681c0.106,0.235,0.298,0.419,0.536,0.516l0.372,0.151l0.368,0.177l0.078,0.312 l-0.006,6.305c0,0.055,0.019,0.193,0.027,0.248l0.243,1.443c0.011,0.062,0.027,0.124,0.05,0.183l0.556,1.442l0.111,0.623 l-0.441,1.283c-0.037,0.108-0.055,0.221-0.054,0.335l0.014,1.495c0.004,0.452,0.311,0.844,0.747,0.958l0.271,0.071l0.238,0.47 l0.042,0.974l-0.264,2.699l-0.398,0.492c-0.197,0.213-0.293,0.502-0.261,0.791l0.079,0.711c0.007,0.058,0.042,0.197,0.059,0.254 l0.015,0.054l-0.075,0.088l-0.592,0.26l-0.345,0.06l-2.587-0.066l-1.957-0.623l-0.678-0.899l0.59-1.836 c0.064-0.2,0.063-0.413,0.001-0.61l1.175-0.043c0.464,0,0.867-0.319,0.974-0.771l0.115-0.49l0.094-0.091 c0.18-0.174,0.287-0.409,0.302-0.657c0.356-0.157,0.591-0.508,0.597-0.901l0.01-0.746l-0.002-0.086l0.368-1.296 c0.086-0.302,0.025-0.626-0.164-0.876s-0.484-0.397-0.798-0.397h-2.698c-0.51,0-0.938,0.384-0.994,0.89l-0.835-0.521l-0.064-0.819 c0,0-0.008-0.099-0.008-0.1c-0.005-0.066-0.017-0.131-0.035-0.195l-0.258-0.901c-0.01-0.036-0.046-0.127-0.061-0.161l-0.262-0.62 l-0.548-2.376c-0.104-0.449-0.501-0.769-0.962-0.775l-1.464-0.02l-0.293-0.05l-0.595-0.469l-3.58-5.924 c-0.027-0.045-0.108-0.148-0.143-0.188l-0.453-0.537c-0.052-0.062-0.11-0.116-0.175-0.164l-0.688-0.501 c-0.067-0.049-0.14-0.089-0.217-0.12l-2.211-0.892l-2.611-1.785l-0.22-0.571l-0.368-1.716c-0.011-0.045-0.05-0.159-0.066-0.202 l-0.307-0.812c-0.018-0.046-0.074-0.155-0.099-0.198l-0.347-0.621c-0.027-0.049-0.11-0.161-0.146-0.205l-0.407-0.51 c-0.024-0.031-0.092-0.101-0.12-0.128l-0.442-0.44l-0.394-0.636l-0.416-1.519c-0.084-0.309-0.312-0.558-0.611-0.67 c-0.299-0.113-0.634-0.076-0.901,0.1l-0.985,0.647c-0.041,0.021-0.081,0.046-0.118,0.073l-0.367,0.261l-0.45,0.04 c-0.04,0.004-0.138,0.023-0.177,0.032l-0.692,0.154c-0.113,0.025-0.222,0.07-0.319,0.132l-0.954,0.603 c-0.417,0.263-0.579,0.791-0.384,1.244l0.271,0.624l0.021,0.364l-0.362,0.744l-1.689,1.802c-0.108,0.117-0.188,0.258-0.231,0.411 l-0.388,1.396c-0.023,0.085-0.036,0.174-0.037,0.263l-0.007,1.458c-0.001,0.282,0.117,0.552,0.325,0.742 c0.207,0.19,0.484,0.282,0.768,0.258l1.655-0.154l0.356,0.123l0.176,0.151l0.62,1.067l0.581,1.412l0.356,3.014 c0.005,0.039,0.025,0.135,0.034,0.173l0.384,1.603c0.026,0.111,0.071,0.216,0.133,0.311l0.526,0.823 c0.117,0.183,0.29,0.323,0.494,0.398l0.617,0.23c0.092,0.034,0.187,0.054,0.284,0.06l0.444,0.027l0.135,0.059l1.055,2.163 c0.021,0.046,0.089,0.154,0.117,0.196l1.531,2.269l1.246,2.396l0.92,3.389l0.077,1.016c0.008,0.115,0.036,0.228,0.083,0.333 l0.311,0.697c0.054,0.119,0.129,0.227,0.224,0.317c0,0,0.336,0.321,0.316,0.325l-1.384,0.291c-0.037,0.008-0.13,0.036-0.166,0.048 l-1.487,0.497c-0.053,0.017-0.176,0.077-0.225,0.103l-1.343,0.708c-0.09,0.047-0.172,0.108-0.244,0.18l-0.984,0.989 c-0.087,0.087-0.156,0.188-0.206,0.3l-1.123,2.535l-1.267,1.612c-0.083,0.105-0.144,0.227-0.179,0.356l-0.162,0.601 c-0.062,0.225-0.042,0.463,0.055,0.674l0.628,1.39c0.053,0.117,0.128,0.222,0.221,0.311l0.71,0.677l-0.73,0.665l-6.324,3.942 c-0.066,0.042-0.127,0.09-0.182,0.146l-2.05,2.069l-0.856,0.694l-0.129,0.012l-0.467-1.97c-0.021-0.09-0.056-0.176-0.102-0.257 l-0.349-0.614c-0.021-0.038-0.079-0.121-0.104-0.155l-1.302-1.772c-0.044-0.06-0.094-0.114-0.149-0.162 c0.048-0.3-0.044-0.61-0.257-0.838l-0.388-0.415c-0.02-0.022-0.087-0.097-0.109-0.118l-2.757-2.369 c-0.317-0.271-0.769-0.318-1.135-0.115l-1.275,0.705c-0.267,0.147-0.452,0.409-0.503,0.709l-0.294,1.736 c-0.017,0.093-0.019,0.187-0.009,0.28l0.218,1.978c0.006,0.055,0.04,0.193,0.056,0.247l0.39,1.351 c0.018,0.063,0.086,0.21,0.115,0.268l0.914,1.784l0.074,0.556l-0.27,0.762l-0.448,0.557l-0.531,0.315l-0.592,0.09l-0.959-0.213 c-0.506-0.112-1.018,0.183-1.171,0.68l-3.401,10.971c-0.096,0.309-0.036,0.644,0.159,0.901l1.063,1.398 c0.049,0.064,0.105,0.122,0.168,0.172l0.545,0.441c0.102,0.082,0.218,0.144,0.343,0.181l0.072,0.021 c0.066,0.109,0.153,0.205,0.257,0.282l0.129,0.096l0.476,0.87c0.084,0.168,0.214,0.309,0.375,0.406l0.477,0.289 c0.122,0.074,0.259,0.121,0.4,0.138l0.643,0.075l0.156,0.091l3.217,3.453c0.245,0.262,0.611,0.375,0.961,0.291l0.031-0.007 l1.032,1.963l0.375,1.199l-0.089,0.132l-0.992,0.42c-0.266,0.115-0.469,0.341-0.557,0.618l-0.431,1.373 c-0.038,0.121-0.054,0.248-0.044,0.374l0.165,2.293c0.021,0.308,0.185,0.588,0.441,0.76c0.256,0.172,0.58,0.213,0.871,0.117 l0.709-0.236c0.126,0.104,0.276,0.175,0.438,0.208l0.993,0.229l0.409,0.274l1.168,1.148l0.795,1.091l1.828,3.94l0.492,1.226 c0.117,0.293,0.366,0.513,0.672,0.594c0.306,0.082,0.631,0.013,0.878-0.184l1.521-1.196l0.426-0.1l1.192,0.676 c0.067,0.039,0.14,0.069,0.215,0.091l0.15,0.043l-0.367,1.651c-0.102,0.417,0.073,0.853,0.436,1.083l0.49,0.311l0.287,0.387 c0.026,0.04,0.105,0.132,0.138,0.167l0.271,0.3c0.037,0.041,0.139,0.129,0.182,0.164l1.324,1.065l0.156,0.33l0.068,0.678 l-0.121,0.586l-0.425,0.488c-0.15,0.176-0.235,0.4-0.24,0.632l-0.015,0.827l-0.146,0.467l-0.745,1.259 c-0.255,0.432-0.15,0.986,0.245,1.296l0.494,0.387l-0.289-0.024c-0.346-0.031-0.684,0.125-0.89,0.405 c-0.205,0.281-0.251,0.648-0.119,0.97l0.584,1.43l0.095,0.337l0.04,0.512l-0.033,0.67l-0.127,0.698l-0.512,1.368l-0.254-0.325 c-0.045-0.057-0.095-0.109-0.15-0.156l-1.537-1.285c-0.272-0.228-0.645-0.294-0.978-0.175c-0.334,0.119-0.58,0.406-0.646,0.754 l-0.615,3.222c-0.009,0.051-0.016,0.185-0.018,0.236l-0.043,1.752c-0.002,0.094,0.008,0.188,0.032,0.279l0.176,0.695 c0.024,0.097,0.063,0.189,0.116,0.275l0.502,0.816c0.024,0.041,0.095,0.131,0.125,0.167l2.725,3.332l1.07,1.654l0.281,0.765 c0.157,0.427,0.579,0.696,1.035,0.649l0.273-0.028l1.478,4.05l0.026,0.828c0.009,0.286,0.141,0.554,0.36,0.737l0.301,0.247 l1.794,2.874l0.589,1.377l0.099,1.594l-0.19,0.76l-0.168,0.376l-0.158,0.239l-0.783,0.52c-0.031,0.02-0.111,0.081-0.141,0.105 l-0.476,0.382c-0.126,0.102-0.225,0.232-0.289,0.38l-0.061,0.14l-0.147,0.026c-0.399,0.071-0.716,0.375-0.803,0.771l-0.143,0.655 l-0.146,0.336c-0.037,0.075-0.064,0.155-0.082,0.237l-0.039,0.187l-0.409,0.132l-0.276-0.1l-0.582-0.381 c-0.081-0.053-0.171-0.094-0.264-0.122l-0.833-0.245c-0.149-0.044-0.31-0.053-0.461-0.024l-0.704,0.128 c-0.143,0.026-0.277,0.083-0.396,0.166l-0.458,0.323c-0.047,0.033-0.153,0.132-0.193,0.172l-0.286,0.287l-0.316,0.227l-1.053,0.094 c-0.075,0.004-0.148,0.018-0.22,0.039l-0.42,0.123c-0.191,0.056-0.362,0.167-0.49,0.321l-0.618,0.785 c-0.043,0.055-0.079,0.115-0.108,0.177l-2.116,4.443c-0.174,0.366-0.11,0.8,0.161,1.101c0.272,0.302,0.702,0.407,1.078,0.271 l2.223-0.796l0.321-0.093l0.34,0.001l0.239,0.075l0.381,0.526c0.041,0.062,0.089,0.119,0.144,0.17l0.533,0.511 c0.099,0.095,0.216,0.167,0.344,0.215l0.284,0.105c0.044,0.016,0.089,0.029,0.135,0.039l0.417,0.077 c0.006,0.03,0.013,0.06,0.021,0.09l0.319,1.343c0.015,0.062,0.108,0.292,0.135,0.35l0.063,0.145 c-0.308,0.388-0.286,0.95,0.063,1.314l0.395,0.411l0.098,1.438c0.004,0.065,0.04,0.223,0.057,0.287l0.22,0.832 c0.051,0.192,0.158,0.365,0.308,0.496l0.266,0.233l-0.083,0.723c-0.006,0.049-0.004,0.173-0.002,0.222l0.042,0.967 c0.013,0.29,0.15,0.557,0.373,0.735l-0.213,0.485c-0.02,0.045-0.056,0.162-0.069,0.21l-0.389,1.42 c-0.012,0.041-0.029,0.144-0.035,0.186l-0.22,1.509c-0.009,0.062-0.009,0.219-0.006,0.282l0.28,6.814 c0.005,0.104,0.025,0.207,0.062,0.305l0.24,0.642l0.527,5.741c0.004,0.036,0.021,0.128,0.028,0.163l0.393,1.859 c0.059,0.276,0.23,0.515,0.474,0.657c0.216,0.126,0.47,0.167,0.71,0.115l0.079,0.395c0.033,0.161,0.104,0.312,0.21,0.439 l1.212,1.466c-0.158,0.032-0.31,0.102-0.438,0.208c-0.277,0.228-0.411,0.588-0.35,0.942l0.266,1.54l-0.024,0.137l-0.239,0.003 c-0.549,0.007-0.989,0.457-0.986,1.006l0.006,0.97l-0.018,3.964l-0.684,2.956c-0.049,0.213-0.026,0.436,0.062,0.633l-0.38,0.589 c-0.072,0.111-0.121,0.235-0.145,0.364l-0.346,1.889l-0.19,0.485l-1.237,1.756c-0.227,0.323-0.242,0.749-0.04,1.087l1.712,2.863 c0.023,0.039,0.094,0.131,0.122,0.167l0.609,0.753c0.156,0.194,0.38,0.322,0.626,0.359l0.744,0.114 c0.047,0.007,0.164,0.012,0.212,0.013l1.278,0.015l-0.607,1.815l-0.493-0.512c-0.226-0.234-0.554-0.344-0.873-0.294l-0.883,0.137 c-0.17,0.027-0.331,0.097-0.467,0.204l-1.84,1.456l-1.633,0.276c-0.481,0.083-0.831,0.502-0.829,0.99l0.006,1.333 c0,0.043,0.011,0.146,0.016,0.188l0.174,1.352c0.006,0.042,0.03,0.146,0.041,0.187l0.26,0.982c-0.199,0.065-0.376,0.193-0.5,0.368 c-0.174,0.242-0.229,0.549-0.153,0.837l0.399,1.507c0.03,0.116,0.081,0.225,0.15,0.322l0.274,0.389 c0.057,0.08,0.124,0.151,0.201,0.212l2.238,1.755l0.847,1.246c0.199,0.292,0.539,0.448,0.889,0.436 c0.301-0.019,0.574-0.171,0.748-0.41l-0.038,0.291c-0.05,0.379,0.12,0.753,0.439,0.964l1.003,0.664 c0.016,0.011,0.043,0.026,0.072,0.042l-0.216,0.316c-0.162,0.238-0.214,0.534-0.143,0.812c0.072,0.279,0.261,0.514,0.518,0.644 l1.69,0.862c0.192,0.1,0.411,0.131,0.626,0.098l3.324-0.563c0.118-0.02,0.23-0.061,0.334-0.12c0,0,1.427-0.816,1.43-0.797 l0.154,0.912c0.007,0.041,0.037,0.155,0.049,0.194l0.077,0.254l-0.637,0.55c-0.315,0.261-0.439,0.688-0.314,1.077l0.044,0.135 l-0.662,0.9c-0.168,0.225-0.234,0.51-0.182,0.786s0.219,0.517,0.457,0.664l0.334,0.206c-0.001,0.074,0.007,0.148,0.022,0.222 l-0.708,0.98c-0.187,0.259-0.238,0.593-0.13,0.921l-0.093,0.086l-0.593-0.159c-0.516-0.14-1.047,0.151-1.211,0.659l-0.291,0.904 l-0.259,0.578l-1.049,1.248c-0.07,0.084-0.126,0.179-0.165,0.278l-2.277-1.462c-0.376-0.242-0.868-0.204-1.204,0.094 c-0.335,0.297-0.431,0.781-0.236,1.184l1.409,2.907l-0.008,0.064c-0.021,0.189,0.013,0.381,0.096,0.55l-0.106,0.521 c-0.021,0.099-0.025,0.198-0.016,0.296c-0.167,0.015-0.328,0.071-0.468,0.165l-0.175,0.116l-0.522-0.012 c-0.387-0.017-0.718,0.19-0.897,0.517l-0.642,1.161c-0.044,0.078-0.076,0.161-0.098,0.248l-0.192,0.774l-0.952-0.385 c-0.397-0.161-0.859-0.048-1.139,0.283c-0.278,0.331-0.313,0.804-0.086,1.171l0.615,0.993l-0.526,0.479l-0.387,0.05 c-0.038,0.005-0.131,0.026-0.168,0.035l-0.454,0.117l-0.228-0.051c-0.249-0.058-0.511-0.016-0.729,0.116l-0.575,0.341 c-0.075,0.044-0.145,0.099-0.206,0.161l-0.519,0.528c-0.039,0.039-0.12,0.146-0.152,0.19l-0.331,0.465 c-0.11,0.154-0.174,0.337-0.185,0.526l-0.053,0.993c0,0.018-0.001,0.034-0.001,0.051c-0.024,0.014-0.047,0.027-0.062,0.036 l-0.69,0.423c-0.046,0.028-0.151,0.114-0.192,0.149l-1.51,1.308c-0.279,0.241-0.402,0.616-0.321,0.976 c0.081,0.36,0.354,0.646,0.709,0.744l0.691,0.191c-0.421-0.083-0.866,0.109-1.08,0.501l-1.608,2.973l-3.321,2.795 c-0.029,0.025-0.097,0.092-0.122,0.12l-0.632,0.668c-0.034,0.036-0.108,0.137-0.137,0.177l-2.527,3.628 c-0.25,0.358-0.238,0.838,0.029,1.184s0.729,0.476,1.14,0.325l2.025-0.753c-0.099,0.163-0.149,0.353-0.145,0.547 c0.01,0.316,0.169,0.61,0.429,0.791l0.656,0.458l-0.168,0.167c-0.071,0.07-0.131,0.151-0.179,0.239l-0.234,0.442 c-0.05,0.094-0.085,0.194-0.103,0.299l-0.585,0.664c-0.089,0.1-0.155,0.214-0.197,0.337c-0.085,0.051-0.164,0.115-0.232,0.191 l-0.405,0.454l-2.611,0.677c-0.392,0.103-0.683,0.431-0.737,0.831c-0.056,0.4,0.136,0.795,0.484,0.999l0.244,0.144l-0.147,0.636 l-0.172,0.021c-0.084,0.011-0.165,0.031-0.243,0.062l-0.646,0.255c-0.094,0.037-0.182,0.088-0.26,0.151l-0.475,0.382l-0.66,0.28 c-0.34,0.144-0.572,0.463-0.605,0.83l-0.033,0.368l-0.377,0.626c-0.283,0.472-0.132,1.085,0.338,1.37l0.035,0.021l-0.097,0.238 c-0.11,0.271-0.096,0.578,0.04,0.837c0.136,0.26,0.378,0.447,0.663,0.513l0.122,0.028c-0.04,0.321,0.078,0.646,0.325,0.868 l0.418,0.374l0.521,0.737l0.15,0.312l0.003,0.302l-0.196,0.375l-0.434,0.34l-0.796,0.177l-0.443,0.034 c-0.043,0.003-0.149,0.021-0.192,0.03l-1.009,0.211l-0.345-0.008l-0.811-0.19c-0.04-0.01-0.139-0.023-0.179-0.027l-0.349-0.038 l-0.099-0.039l0.42-1.05c0.106-0.266,0.095-0.563-0.033-0.819s-0.359-0.444-0.635-0.519l-0.786-0.212l-0.538-0.95 c-0.055-0.099-0.125-0.188-0.209-0.263l-0.665-0.595c-0.158-0.141-0.357-0.229-0.567-0.249l-0.938-0.091 c-0.209-0.019-0.417,0.024-0.599,0.13l-1.441,0.862l-2.809,0.148l-2.746-1.831c-0.39-0.26-0.911-0.216-1.248,0.111 c-0.338,0.325-0.404,0.843-0.159,1.243l2.373,3.874l0.357,1.189l-0.013,1.294l-0.094,0.179c-0.097,0.183-0.134,0.391-0.106,0.596 l0.007,0.054l-0.203,0.062c-0.089,0.028-0.174,0.068-0.252,0.12l-0.522,0.343l-0.433-0.131l-1.467-0.729l-0.238-0.171l-0.473-0.516 l-0.458-1.071c-0.211-0.488-0.772-0.727-1.268-0.54l-1.871,0.699c-0.023,0.009-0.046,0.018-0.068,0.028l-0.443-0.623l-0.674-1.113 l-1.047-2.577c-0.108-0.272-0.332-0.483-0.61-0.576c-0.28-0.095-0.586-0.06-0.835,0.093l-1.698,1.027 c-0.06,0.037-0.116,0.08-0.168,0.129l-1.636,1.556l-0.793,0.305c-0.187,0.073-0.346,0.2-0.459,0.364l-1.087,1.584l-1.126,1.33 l-0.715,0.898l-0.233-0.059c-0.445-0.112-0.901,0.09-1.12,0.488l-0.543,0.989c-0.053,0.097-0.09,0.201-0.109,0.31l-0.278,1.552 c-0.133-0.072-0.283-0.115-0.441-0.12c-0.401-0.031-0.754,0.201-0.929,0.551l-0.98,1.953l-1.86,3.456 c-0.034,0.062-0.061,0.126-0.081,0.193l-0.243,0.814l-0.789,0.325c-0.285,0.118-0.5,0.361-0.582,0.659l-0.311,1.123l-1.056,2.299 c-0.07,0.151-0.102,0.316-0.091,0.482l0.121,1.993c0.004,0.063,0.037,0.219,0.053,0.279l0.364,1.413l0.4,2.165 c0.01,0.056,0.053,0.187,0.072,0.239l0.495,1.37l0.348,2.832c0.051,0.42,0.361,0.762,0.774,0.854 c0.41,0.096,0.84-0.086,1.064-0.443l1.402-2.229c0,0,0.223,0.273,0.228,0.285l-0.244,1.297c-0.009,0.04-0.02,0.137-0.022,0.178 l-0.05,0.575l-0.186,0.86c-0.018,0.081-0.025,0.164-0.022,0.248l0.049,1.53c0.017,0.54,0.459,0.969,0.999,0.969h0.972 c0.013,0.107,0.043,0.213,0.09,0.311l0.191,0.405l-0.148,0.539l-0.447,0.483c-0.113,0.124-0.194,0.274-0.233,0.438 c0,0-0.103,0.423-0.106,0.419c-0.163-0.192-0.392-0.316-0.642-0.347l-1.407-0.169l-1.013-0.224 c-0.047-0.01-0.169-0.022-0.217-0.026l-1.378-0.095l-0.789-0.191l-0.779-0.353c-0.062-0.028-0.128-0.05-0.195-0.064l-1.018-0.222 c-0.109-0.025-0.223-0.029-0.335-0.016l-0.667,0.081l-0.883-0.143c-0.127-0.021-0.254-0.018-0.378,0.012l-2.162,0.484 c-0.15,0.034-0.291,0.103-0.41,0.199l-0.96,0.778c-0.035,0.029-0.114,0.11-0.146,0.143l-1.501,1.678l-1.163,1.164 c-0.035,0.035-0.113,0.135-0.143,0.176l-0.592,0.804c-0.03,0.041-0.093,0.154-0.116,0.199l-0.604,1.169l-0.472,0.442l-0.618,0.147 c-0.037,0.009-0.125,0.039-0.16,0.053l-0.688,0.258c-0.167,0.062-0.314,0.169-0.427,0.309l-0.382,0.475 c-0.081,0.102-0.142,0.218-0.179,0.343l-0.238,0.806c-0.079,0.269-0.043,0.559,0.102,0.799l0.425,0.707 c0.036,0.061,0.079,0.117,0.127,0.168l0.688,0.732c0.057,0.061,0.122,0.114,0.192,0.158l1.206,0.76 c0.037,0.024,0.127,0.07,0.167,0.09l1.193,0.635l0.364,0.332c0.147,0.134,0.332,0.221,0.53,0.249l0.298,0.042l0.696,0.643 c0.292,0.265,0.715,0.332,1.077,0.175l0.579-0.257l-0.099,0.995c-0.008,0.062-0.001,0.22,0.004,0.282l0.047,0.634 c0.015,0.204,0.093,0.399,0.222,0.558l0.447,0.548c0.065,0.08,0.144,0.15,0.231,0.207l0.559,0.357l0.304,0.262l0.064,0.18 l-0.129,0.362c-0.151,0.427,0.003,0.903,0.377,1.159l2.099,1.44l0.845,1.185c0.054,0.074,0.117,0.142,0.188,0.198l1.215,0.979 l0.329,0.547l0.424,0.956c0.029,0.066,0.066,0.128,0.109,0.187l0.697,0.935c0.055,0.073,0.118,0.139,0.189,0.195l0.916,0.712 c0.094,0.073,0.201,0.129,0.314,0.164l1.104,0.342c0.147,0.046,0.303,0.057,0.455,0.031l0.667-0.11 c0.008,0.033,0.019,0.066,0.03,0.099l0.184,0.495c0.047,0.126,0.119,0.241,0.212,0.339l0.909,0.954l0.375,0.473 c0.223,0.28,0.574,0.421,0.935,0.367l1.062-0.127l2.13,0.492l0.568,0.447l4.234,4.709c0.044,0.049,0.169,0.15,0.222,0.19 l1.012,0.762c0.053,0.04,0.195,0.117,0.255,0.146l0.791,0.385c0.059,0.029,0.212,0.076,0.274,0.094l2.52,0.679l0.749,0.399 l5.867,4.438c0.054,0.041,0.2,0.119,0.262,0.149l1.854,0.902c0.126,0.062,0.265,0.096,0.405,0.101l3.085,0.111l2.939,1.112 c0.105,0.04,0.218,0.062,0.331,0.064l0.172,0.004c0.001,0,0.1,0.002,0.101,0.002l0.24,0.004l-0.009,0.249 c-0.002,0.07,0.004,0.142,0.017,0.211l0.099,0.526c0.042,0.227,0.161,0.431,0.337,0.58l0.514,0.438 c0.086,0.073,0.184,0.132,0.289,0.172l1.08,0.416c0.045,0.018,0.163,0.049,0.211,0.06l0.916,0.206 c0.065,0.015,0.133,0.022,0.2,0.024l0.943,0.017c0.072-0.002,0.143-0.006,0.212-0.02l0.944-0.193 c0.05-0.011,0.175-0.054,0.222-0.072l3.396-1.289l0.567,0.008l0.692,0.555l0.258,2.849c0.016,0.167,0.072,0.327,0.166,0.467 l0.989,1.465c0.07,0.104,0.16,0.194,0.264,0.266l3.02,2.083c0.062,0.042,0.127,0.077,0.196,0.104l1.692,0.673 c0.162,0.064,0.338,0.086,0.51,0.061l1.378-0.194l1.061,0.27l0.42,1.512l0.284,4.684c0.004,0.068,0.015,0.137,0.032,0.203 l0.4,1.483l0.191,1.307c0.012,0.079,0.032,0.155,0.062,0.229l0.484,1.194c0.067,0.165,0.178,0.31,0.319,0.418l1.256,0.964 c0.079,0.06,0.166,0.107,0.259,0.142l1.61,0.591c0.048,0.019,0.172,0.048,0.222,0.059l4.718,0.956l0.722,0.262l0.614,0.317 c0.055,0.027,0.198,0.076,0.256,0.094l0.646,0.193c0.109,0.032,0.225,0.046,0.34,0.039l1.021-0.058 c0.101-0.006,0.2-0.026,0.295-0.062l2.229-0.836L89.791,562l0.792,0.273l1.556,1.77c0.115,0.131,0.263,0.229,0.429,0.286 l1.392,0.469c0.096,0.032,0.196,0.05,0.298,0.052l1.765,0.031l0.403,0.067l0.527,0.185l0.261,0.187l0.934,0.944 c0.036,0.036,0.138,0.116,0.18,0.146l0.728,0.534c0.077,0.056,0.161,0.102,0.251,0.134l0.674,0.243 c0.098,0.036,0.201,0.056,0.305,0.06l0.707,0.029c0.066,0.001,0.222-0.015,0.284-0.024l2.96-0.444l0.271,0.027l2.289,1.03 c0.319,0.143,0.689,0.108,0.979-0.091c0.287-0.199,0.45-0.535,0.428-0.885l-0.074-1.16l0.724,0.204 c0.05,0.014,0.179,0.032,0.23,0.038l2.064,0.227l0.399,0.118l0.51,0.359l1.175,1.097c0.103,0.095,0.223,0.167,0.354,0.213 l0.894,0.309c0.146,0.051,0.3,0.065,0.453,0.047l0.7-0.089c0.115-0.016,0.227-0.05,0.33-0.104l1.031-0.53l4.342-0.498 c0.158-0.018,0.31-0.073,0.442-0.162l0.86-0.573c0.324-0.216,0.493-0.601,0.434-0.986l-0.465-2.983l0.084-2.511l0.42-0.026 c0.043-0.003,0.149-0.021,0.192-0.029l0.439-0.085c0.05-0.01,0.173-0.051,0.221-0.068l0.375-0.137 c0.164-0.061,0.311-0.163,0.423-0.297l1.103-1.316l0.258-0.189c0.035-0.021,0.114-0.077,0.146-0.102l0.551-0.418l1.034,1.1 c0.055,0.059,0.116,0.109,0.183,0.153l0.894,0.585c0.045,0.029,0.171,0.089,0.22,0.11l0.849,0.369 c0.054,0.023,0.109,0.042,0.166,0.055c0.003,0.001,0.096,0.023,0.099,0.023l0.908,0.208c0.052,0.012,0.184,0.025,0.236,0.029 l1.052,0.07c0.042,0.004,0.14-0.001,0.178-0.002l0.872-0.046l0.163,0.013l0.311,1.466c0.103,0.479,0.513,0.819,1.026,0.79 l1.064-0.053c0.085-0.005,0.169-0.021,0.25-0.046l1.077-0.344l0.253-0.031l0.169,0.454c0.036,0.102,0.09,0.196,0.156,0.281 l2.975,3.761l0.137,0.352l0.192,0.815c0.028,0.118,0.077,0.23,0.146,0.332l0.518,0.758c0.042,0.061,0.09,0.116,0.144,0.166 l1.151,1.062c0.046,0.043,0.179,0.132,0.232,0.165l2.488,1.536l0.248,0.416c0.067,0.109,0.155,0.206,0.259,0.282l1.849,1.367 c0.033,0.024,0.124,0.078,0.161,0.099l1.235,0.69c0.037,0.021,0.136,0.063,0.176,0.079l0.701,0.282 c0.045,0.018,0.159,0.05,0.206,0.062l0.828,0.202c0.05,0.012,0.179,0.027,0.23,0.031l0.956,0.08 c0.061,0.007,0.204-0.005,0.26-0.011l0.97-0.091c0.044-0.004,0.151-0.025,0.195-0.035l1.857-0.424l0.577-0.069l0.462,0.155 l0.501,0.457l0.55,0.617c0.062,0.069,0.133,0.129,0.21,0.178l0.484,0.307c0.068,0.044,0.143,0.079,0.22,0.104l0.627,0.208 l1.97,1.766c0.045,0.04,0.169,0.122,0.221,0.153l2.596,1.596c0.06,0.036,0.121,0.065,0.187,0.089l0.971,0.339l0.767,0.555 c0.119,0.086,0.256,0.145,0.401,0.172l2.487,0.474l2.723,0.998l0.783,0.467c0.254,0.15,0.558,0.182,0.839,0.084l0.738-0.258 c0.102-0.035,0.197-0.087,0.282-0.153l0.735-0.568c0.056-0.043,0.106-0.091,0.151-0.145l0.581-0.692 c0.07-0.083,0.127-0.179,0.167-0.28l0.199-0.51c0.001-0.001,0.037-0.095,0.037-0.095c0.023-0.061,0.041-0.124,0.053-0.188 l0.101-0.574l0.194-0.038l0.664,0.074l1.87,0.508l0.765,0.389l0.669,0.529l1.704,2.346c0.034,0.048,0.136,0.152,0.178,0.193 l0.48,0.465c0.103,0.1,0.227,0.176,0.361,0.224l0.412,0.146c0.1,0.036,0.205,0.056,0.312,0.059l0.677,0.017l0.1,0.03l1.853,2 c0.039,0.043,0.148,0.134,0.194,0.169l0.558,0.432c0.063,0.049,0.132,0.09,0.205,0.122l0.994,0.438 c0.062,0.027,0.127,0.048,0.193,0.062l1.501,0.322l1.002,0.362c0.325,0.117,0.684,0.061,0.955-0.152l0.732-0.57 c0.094-0.073,0.174-0.162,0.236-0.263l0.716-1.146l0.219,0.193l0.525,0.743l1.126,2.285l-1.37,1.035 c-0.307,0.231-0.453,0.618-0.378,0.994s0.359,0.677,0.731,0.772l2.673,0.688c0.05,0.013,0.18,0.029,0.231,0.034l0.84,0.081 c0.017,0.017,0.033,0.034,0.036,0.037c0.037,0.038,0.143,0.122,0.186,0.154l0.207,0.155l0.321,0.422 c0.177,0.263,0.468,0.426,0.783,0.44l0.905,0.045c0.232,0.002,0.468-0.059,0.654-0.199l0.409-0.308l1.096,1.851 c0.038,0.064,0.084,0.125,0.136,0.18l1.924,2.034c0.033,0.035,0.126,0.113,0.164,0.144l1.144,0.902 c0.032,0.025,0.121,0.082,0.157,0.104l2.645,1.59l0.418,0.365l0.497,0.557l0.427,0.686c0.176,0.281,0.479,0.457,0.81,0.47 l0.062,0.003c-0.02,0.178,0.01,0.36,0.087,0.526l2.137,4.607l-0.164,0.141c-0.092,0.079-0.169,0.174-0.227,0.28l-0.229,0.42 c-0.075,0.14-0.117,0.295-0.121,0.453l-0.02,0.915c-0.003,0.156,0.03,0.311,0.098,0.451l0.33,0.69 c0.041,0.087,0.095,0.167,0.159,0.238l1.561,1.729c0.055,0.061,0.116,0.114,0.184,0.16l0.329,0.221 c0.082,0.055,0.172,0.098,0.267,0.126l0.381,0.114c-0.026,0.285,0.07,0.575,0.278,0.79l0.135,0.139h-2.123 c-0.439,0-0.828,0.287-0.956,0.708c-0.129,0.42,0.032,0.875,0.396,1.121l2.57,1.733l0.235,0.318l0.596,1.898 c0.035,0.111,0.089,0.216,0.16,0.309l1.036,1.354c0.085,0.112,0.192,0.204,0.315,0.271l1.234,0.678 c0.097,0.053,0.2,0.09,0.309,0.108l2.64,0.48l2.698,1.031c0.122,0.047,0.258,0.064,0.385,0.065l1.306-0.041 c0.222-0.007,0.431-0.087,0.598-0.222l0.576,1.733c0.001,0.003,0.032,0.094,0.033,0.096c0.02,0.058,0.09,0.193,0.119,0.247 l0.183,0.327c0.061,0.109,0.142,0.206,0.238,0.285l0.418,0.345c0.093,0.078,0.2,0.138,0.315,0.177l0.694,0.235 c0.077,0.025,0.156,0.042,0.235,0.048c-0.127,0.328-0.073,0.703,0.148,0.982c0.239,0.305,0.634,0.44,1.013,0.354l2.417-0.564 l0.096,0.037l0.645,1.66c0,0.001,0.036,0.096,0.037,0.097c0.023,0.06,0.052,0.117,0.086,0.171l0.831,1.302 c0.032,0.052,0.133,0.167,0.175,0.212l0.394,0.424c0.053,0.057,0.112,0.106,0.177,0.149l0.653,0.431 c0.068,0.045,0.143,0.082,0.221,0.108l1.226,0.432c0.04,0.015,0.145,0.04,0.187,0.049l0.682,0.146 c0.061,0.013,0.215,0.021,0.277,0.023l0.479,0.012c0.188-0.003,0.36-0.041,0.518-0.13l0.792-0.446 c0.145-0.082,0.267-0.197,0.354-0.337l0.218-0.344l0.544,0.592c0.072,0.078,0.156,0.145,0.248,0.196l0.888,0.498 c0.1,0.056,0.208,0.095,0.32,0.113l1.018,0.174l0.27,0.077l0.716,0.534c0.095,0.069,0.201,0.122,0.314,0.155l0.636,0.184 l0.062,0.268c0.016,0.068,0.039,0.134,0.069,0.197l0.299,0.637l0.195,0.693c0.131,0.46,0.572,0.757,1.045,0.726l0.058-0.005 l0.037,0.684c0.004,0.074,0.017,0.147,0.036,0.219l0.092,0.325c0.023,0.084,0.058,0.165,0.103,0.24l0.22,0.375 c0.029,0.051,0.12,0.165,0.159,0.21l0.214,0.252l-0.597,0.723c-0.197,0.238-0.273,0.554-0.205,0.855 c0.067,0.302,0.271,0.556,0.551,0.687l2.228,1.044l0.338,0.54c0.066,0.104,0.151,0.196,0.251,0.27l0.844,0.62l0.113,0.159 l0.018,0.104l-0.009,0.381c-0.001,0.04,0.008,0.144,0.013,0.184l0.057,0.539c0.005,0.05,0.03,0.167,0.043,0.216l0.427,1.696 l-0.007,0.128l-0.631,0.374c-0.15,0.089-0.274,0.215-0.361,0.367l-0.403,0.714c-0.032,0.055-0.087,0.197-0.107,0.257l-0.497,1.442 c-0.029,0.086-0.047,0.177-0.052,0.268l-0.102,1.806c-0.015,0.247,0.064,0.491,0.22,0.684l0.94,1.164 c0.072,0.09,0.16,0.167,0.259,0.227l2.613,1.601l0.121,0.495c0.107,0.437,0.491,0.748,0.939,0.762l0.713,0.021l0.661,0.074 c0.054,0.006,0.191,0.004,0.245,0.002l0.339-0.016l0.227,0.032l0.287,0.187l1.271,1.156c0.391,0.356,0.99,0.346,1.37-0.024 l1.148-1.12l0.148-0.019l1.66,0.435c0.274,0.071,0.564,0.022,0.802-0.133c0.159-0.105,0.283-0.252,0.36-0.423l0.137,0.153 c0.048,0.055,0.102,0.104,0.161,0.146l0.449,0.326c0.058,0.042,0.12,0.078,0.187,0.106l0.411,0.188l-0.252,1.271 c-0.037,0.186-0.021,0.379,0.048,0.556l0.258,0.666c0.039,0.103,0.096,0.198,0.167,0.282l0.963,1.136l0.092,0.271l-0.445,1.126 c-0.035,0.088-0.058,0.18-0.066,0.274l-0.065,0.663c-0.011,0.111-0.003,0.225,0.023,0.333l0.18,0.739 c0.019,0.076,0.046,0.151,0.082,0.222l0.321,0.621c0.017,0.032,0.067,0.11,0.087,0.141l0.692,1.025l0.239,0.669l0.234,0.984 c0.01,0.042,0.044,0.142,0.059,0.183l0.346,0.925c0.053,0.141,0.136,0.267,0.244,0.37l-0.897,1.479 c-0.022,0.038-0.07,0.141-0.088,0.181l-0.317,0.732l-1.485,1.333c-0.035,0.031-0.112,0.118-0.142,0.154l-0.378,0.453 c-0.052,0.062-0.096,0.131-0.131,0.203l-0.158,0.327c-0.046,0.095-0.076,0.195-0.09,0.3l-0.062,0.473 c-0.015,0.111-0.011,0.225,0.012,0.334l0.099,0.477c0.024,0.115,0.067,0.224,0.129,0.323l0.379,0.607l0.115,0.338 c0.063,0.186,0.181,0.348,0.337,0.467l0.517,0.396l0.232,1.436c0.045,0.271,0.199,0.512,0.427,0.666l0.848,0.571 c0.097,0.065,0.204,0.113,0.317,0.142l1.719,0.428l0.985,0.992c0.226,0.226,0.546,0.331,0.858,0.282 c0.315-0.047,0.589-0.242,0.736-0.524l0.46-0.878c0,0,1.808,0.993,1.815,1.006c0.055,0.095,0.124,0.18,0.207,0.252l0.478,0.418 l0.667,1.838c0.02,0.055,0.085,0.18,0.113,0.23l0.646,1.141c0.213,0.377,0.64,0.567,1.067,0.488l2.55-0.511 c0.048-0.01,0.165-0.048,0.212-0.064l0.58-0.209c0.134-0.048,0.256-0.124,0.357-0.223l0.396-0.382l1.078-0.375 c0.04-0.015,0.134-0.06,0.172-0.078l0.677-0.339l0.192,0.067l0.975,0.692c0.229,0.162,0.514,0.219,0.789,0.161 c0.273-0.059,0.51-0.23,0.651-0.472l0.113-0.192l0.198,1.494c0.049,0.37,0.301,0.683,0.652,0.809 c0.351,0.126,0.743,0.049,1.019-0.207l1.622-1.502c0.092-0.085,0.167-0.187,0.222-0.3l1.164-2.411l0.111-0.144l0.585,0.305 l2.005,1.623c0.098,0.078,0.208,0.138,0.327,0.176l0.872,0.277c0.05,0.017,0.177,0.04,0.229,0.049l4.302,0.677l0.137,0.329 c0.057,0.132,0.14,0.25,0.246,0.347l0.619,0.567c0.065,0.061,0.139,0.112,0.217,0.153l0.817,0.435 c0.079,0.042,0.163,0.073,0.251,0.093l0.859,0.196c0.101,0.023,0.204,0.029,0.31,0.023l1.037-0.086 c0.061-0.005,0.206-0.037,0.265-0.053l1.672-0.441l1.58-0.17c0.524-0.056,0.915-0.509,0.893-1.036l-0.025-0.619l0.461-0.092 l0.235-0.02l2.792,0.648c0.176,0.042,0.355,0.034,0.525-0.02l0.719-0.225c0.177-0.055,0.335-0.158,0.457-0.298l1.979-2.271 l1.087-0.939l0.922-0.36l1.202-0.011l2.789,0.397c0.129,0.019,0.259,0.011,0.383-0.02l0.84-0.209 c0.176-0.043,0.335-0.134,0.463-0.261l0.594-0.594c0.138-0.138,0.232-0.313,0.272-0.505l0.154-0.746l2.167-1.692 c0.089-0.069,0.165-0.151,0.226-0.245l1.654-2.529c0.008-0.012,0.018-0.029,0.028-0.049c0.11-0.024,0.216-0.068,0.312-0.129 l2.315-1.464l-0.049,1.144c-0.013,0.299,0.108,0.588,0.331,0.787c0.223,0.2,0.525,0.291,0.818,0.244l1.362-0.206 c0.083-0.013,0.165-0.036,0.243-0.069l1.347-0.676l0.517,0.101l0.673,0.407l0.802,0.62c0.043,0.033,0.159,0.101,0.207,0.127 l0.884,0.479c0.087,0.048,0.182,0.082,0.28,0.103l2.407,0.497l0.113,0.397l0.227,7.538c0.016,0.497,0.394,0.907,0.888,0.963 c0.496,0.062,0.954-0.258,1.08-0.739l0.208-0.795c0.231,0.207,0.551,0.299,0.872,0.232l4.209-0.885 c0.076-0.018,0.151-0.043,0.222-0.077l2.404-1.172c0.232,0.234,0.568,0.347,0.906,0.276l0.961-0.199 c0.081-0.02,0.159-0.049,0.232-0.088l0.911-0.479l0.297-0.116l0.347,0.262c0.084,0.062,0.178,0.111,0.276,0.145l0.515,0.172 c0.168,0.056,0.349,0.067,0.522,0.03l0.494-0.104c0.128-0.027,0.25-0.079,0.358-0.154l0.885-0.667l1.22-0.618 c0.217-0.109,0.386-0.294,0.476-0.519l0.725-1.796l0.54-0.255l1.018-0.176l0.217,0.006l3.09,1.862 c0.362,0.218,0.823,0.184,1.149-0.085c0.327-0.269,0.449-0.714,0.306-1.111l-0.944-2.619l-0.032-0.347l0.454,0.012l1.742,0.744 c0.065,0.027,0.134,0.048,0.203,0.062l1.173,0.228c0.202,0.038,0.407,0.014,0.596-0.068l0.451-0.201l0.788,0.48l2.267,2.419 c0.053,0.056,0.111,0.104,0.175,0.146l1.593,1.047c0.065,0.043,0.135,0.078,0.208,0.104l1.708,0.609 c0.031,0.011,0.114,0.032,0.146,0.04l0.802,0.192c0.035,0.008,0.125,0.021,0.161,0.026l0.541,0.069l-0.001,0.438l0.001,0.469 c0.001,0.297,0.133,0.577,0.36,0.767l1.496,1.243l0.077,0.139l0.021,0.18l-0.003,1.448c0,0.266,0.105,0.521,0.293,0.708 s0.441,0.293,0.707,0.293h2.874c0.278,0,0.544-0.116,0.733-0.32s0.284-0.478,0.264-0.755l-0.036-0.484l0.137,0.161 c0.088,0.103,0.194,0.186,0.315,0.246l0.728,0.364c0.102,0.051,0.21,0.084,0.323,0.099l0.694,0.089l0.693,0.213l0.605,0.302 l0.315,0.27l0.255,0.626c0.028,0.084,0.068,0.164,0.117,0.238l0.269,0.404c0.098,0.146,0.231,0.265,0.389,0.344l0.566,0.283 c0.163,0.081,0.342,0.115,0.525,0.103l0.507-0.039c0.111-0.009,0.221-0.035,0.323-0.08l1.005-0.438l0.296-0.068l0.796-0.007 l0.373,0.041l-1.902,3.305c-0.229,0.396-0.161,0.898,0.167,1.218c0.33,0.322,0.832,0.375,1.222,0.137l3.558-2.185l0.337-0.111 l0.365,0.181l0.321,0.483l0.597,1.808c0.024,0.075,0.059,0.148,0.102,0.216l0.53,0.846c0.116,0.185,0.29,0.327,0.494,0.404 l0.9,0.34c0.253,0.095,0.534,0.086,0.778-0.03l0.713-0.333l0.163-0.047l0.223,0.176l0.546,1.824 c0.113,0.379,0.438,0.655,0.831,0.706c0.4,0.046,0.776-0.135,0.982-0.474l0.954-1.572l0.314,1.078 c0.011,0.036,0.047,0.127,0.062,0.162l0.23,0.539c0.001,0,0.04,0.092,0.04,0.093c0.026,0.06,0.114,0.197,0.151,0.252l0.332,0.484 c0.054,0.079,0.119,0.15,0.193,0.211l-30.723,48.029c-0.187,0.291-0.209,0.658-0.059,0.97c0.149,0.312,0.449,0.524,0.793,0.562 l1.915,0.21l5.947,3.13l0.445,0.305c0.098,0.067,0.207,0.117,0.323,0.146l2.458,0.611c0.077,0.02,0.156,0.029,0.235,0.03 l1.236,0.015c0.189,0.015,0.281-0.025,0.409-0.081l1.199-0.517c0.104-0.045,0.2-0.107,0.284-0.185l1.727-1.581l0.694-0.419 l0.806-0.081l1.375,0.487l1.505,1.1l1.368,1.442l0.963,1.378l0.482,1.375l0.242,1.555c0.008,0.048,0.043,0.168,0.058,0.213 l0.464,1.456c0.049,0.153,0.134,0.294,0.248,0.407l1.237,1.239c0.074,0.074,0.159,0.136,0.252,0.184l4.537,2.317l1.206,0.985 l0.822,0.959l0.724,1.069l1.714,3.434c0.171,0.342,0.52,0.553,0.895,0.553c0.047,0,0.094-0.003,0.142-0.01 c0.426-0.062,0.766-0.388,0.843-0.812l22.414-123.258l0.649-2.253c0.026-0.093,0.039-0.19,0.038-0.287l-0.014-0.803l0.811-2.98 c0.025-0.092,0.037-0.188,0.035-0.282l-0.033-2.002l0.732-4.12c0.013-0.075,0.018-0.152,0.013-0.229l-0.114-1.859l0.914-2.355 c0.088-0.228,0.09-0.479,0.006-0.708l-0.516-1.4c-0.023-0.063-0.053-0.124-0.088-0.181l-1.573-2.531l0.244-0.831 c0.012-0.037,0.031-0.128,0.039-0.166l0.093-0.477c0.021-0.106,0.023-0.216,0.009-0.323l-0.345-2.48 c-0.06-0.438-0.4-0.783-0.837-0.852l-0.56-0.087l-0.889-1.295c-0.076-0.109-0.173-0.203-0.285-0.274l-0.438-0.278 c-0.047-0.03-0.171-0.088-0.223-0.11l-0.791-0.338l-0.156-0.221l0.095-0.409c0.029-0.113,0.039-0.231,0.027-0.348l-0.053-0.56 c-0.013-0.135-0.053-0.266-0.117-0.385l-0.287-0.525c-0.065-0.118-0.153-0.222-0.259-0.305l-0.332-0.262 c-0.052-0.041-0.194-0.121-0.254-0.151l-0.132-0.067l-0.328-0.461l-0.023-0.101l0.118-0.998c0.024-0.208-0.018-0.42-0.121-0.604 l-0.38-0.676c-0.035-0.062-0.076-0.121-0.124-0.175l-1.615-1.821l-0.219-0.516l0.112-0.316l1.357-2.044 c0.059-0.089,0.103-0.187,0.131-0.289l0.305-1.107c0.043-0.156,0.047-0.321,0.012-0.479l-0.131-0.587 c-0.027-0.125-0.079-0.243-0.151-0.349l-0.268-0.391c-0.021-0.032-0.08-0.104-0.105-0.134l-0.191-0.223l-0.113-0.221l-0.06-1.453 c-0.001-0.065-0.027-0.223-0.041-0.287l-0.194-0.93c-0.012-0.059-0.062-0.198-0.084-0.254l-0.339-0.846 c-0.028-0.071-0.064-0.139-0.108-0.202l-0.576-0.825c-0.047-0.067-0.103-0.129-0.165-0.183l-0.811-0.693 c-0.056-0.048-0.117-0.089-0.182-0.124l-0.78-0.418c-0.04-0.021-0.146-0.064-0.189-0.08l-3.438-1.285l-0.484-0.395l-1.312-1.437 c-0.049-0.054-0.104-0.102-0.163-0.144l-0.476-0.335c-0.05-0.035-0.184-0.104-0.239-0.13l-0.897-0.419l-0.24-0.169l-0.158-0.214 l-0.379-0.907c-0.026-0.061-0.058-0.119-0.096-0.173l-0.306-0.447c-0.077-0.113-0.177-0.209-0.293-0.282l-0.803-0.508 c-0.097-0.062-0.203-0.105-0.315-0.131l-1.751-0.393l-0.619-0.244l-0.237-0.198l-0.931-1.389c-0.043-0.064-0.094-0.124-0.151-0.177 l-2.291-2.099l-1.661-1.911l-0.388-0.695l-0.212-1.32l0.849-30.847l0.791-0.221c0.053-0.015,0.178-0.067,0.228-0.091l0.721-0.334 l0.691-0.014l0.965,0.192c0.12,0.024,0.243,0.025,0.363,0.006l0.892-0.15c0.035-0.007,0.124-0.029,0.158-0.039l0.73-0.21 l3.006-0.18c0.048-0.002,0.165-0.022,0.213-0.032l1.793-0.365c0.049-0.011,0.166-0.049,0.213-0.066l1.665-0.605 c0.043-0.016,0.146-0.066,0.187-0.087l1.526-0.806c0.055-0.028,0.176-0.116,0.224-0.153l1.438-1.12l0.096-0.007l1.037,0.474 c0.064,0.029,0.132,0.051,0.201,0.065l1.52,0.317c0.351,0.076,0.721-0.049,0.959-0.322l0.697-0.802 c0.061-0.069,0.111-0.146,0.15-0.229l0.309-0.646l0.403-0.175l0.702-0.081c0.15-0.019,0.294-0.07,0.422-0.152l1.42-0.915 l0.682-0.299l0.825-0.101l0.543,0.131l0.574,0.394l3.387,3.419c0.297,0.3,0.747,0.378,1.128,0.206l0.99-0.456l0.708-0.194 l-0.06,0.394c-0.04,0.263,0.026,0.53,0.184,0.744s0.394,0.355,0.656,0.396l2.55,0.381c0.069,0.011,0.142,0.012,0.212,0.009 l0.962-0.061c0.302-0.02,0.578-0.174,0.753-0.42l0.482-0.681l0.618,0.231c0.064,0.024,0.131,0.041,0.199,0.052l0.442,0.064 c0.15,0.021,0.309,0.009,0.458-0.039l1.303-0.428c0.482-0.158,0.77-0.652,0.668-1.149l-0.275-1.354 c-0.017-0.084-0.045-0.164-0.082-0.241l-0.505-1.038c-0.056-0.115-0.133-0.219-0.228-0.305l-0.353-0.322 c-0.076-0.07-0.162-0.128-0.256-0.172l-0.616-0.288l0.112-0.082c0.098-0.072,0.183-0.162,0.248-0.265l0.33-0.515 c0.104-0.161,0.158-0.348,0.158-0.539v-1.078c0-0.072-0.008-0.145-0.023-0.215l-0.416-1.884l0.026-0.233l1.557-0.926 c0.329-0.195,0.518-0.562,0.485-0.943c-0.031-0.382-0.279-0.711-0.636-0.849l-2.682-1.036l-0.166-0.161l0.18-1.148 c0.062-0.397-0.119-0.793-0.461-1.005l-0.685-0.425l-0.026-0.308c0-0.002-0.009-0.102-0.009-0.104 c-0.006-0.061-0.017-0.121-0.033-0.18c-0.001-0.004-0.028-0.101-0.029-0.104l-0.102-0.351c-0.048-0.163-0.136-0.312-0.256-0.432 l-0.354-0.351c-0.047-0.047-0.18-0.143-0.234-0.179l-0.569-0.38l-0.676-0.846c-0.059-0.073-0.128-0.137-0.204-0.191l-0.674-0.475 c-0.038-0.027-0.14-0.083-0.182-0.104l-2.234-1.148c-0.089-0.046-0.184-0.078-0.281-0.096l-0.764-0.138 c-0.142-0.025-0.288-0.021-0.429,0.016l-0.755,0.193c-0.122,0.032-0.236,0.086-0.339,0.16l-1.746,1.27l-0.487-0.292l-0.115-0.141 c-0.033-0.05-0.129-0.156-0.171-0.199l-0.128-0.133c-0.069-0.073-0.15-0.135-0.238-0.184l-0.521-0.261 c-0.093-0.043-0.191-0.072-0.293-0.085l-0.456-0.059c-0.09-0.012-0.183-0.012-0.274,0.002l-1.396,0.199l-1.359,0.021l-0.289-0.035 l-1.884-0.656c-0.092-0.031-0.188-0.049-0.285-0.053l-1.071-0.039c-0.06-0.001-0.217,0.014-0.278,0.023l-3.627,0.534l-0.019-0.262 c-0.031-0.461-0.374-0.839-0.829-0.916l-1.034-0.177c-0.041-0.008-0.146-0.015-0.188-0.017l-0.542-0.023 c-0.103-0.008-0.206,0.007-0.306,0.034l-1.173,0.321c-0.098,0.027-0.191,0.069-0.276,0.124l-1.294,0.838l0.151-26.631 c0.001-0.065-0.023-0.227-0.036-0.291l-0.078-0.411l0.947,0.006c0.094,0,0.188-0.014,0.278-0.039l0.857-0.253 c0.063-0.019,0.211-0.088,0.27-0.119l1.757-0.919l0.518-0.113l0.61,0.018l0.914,0.131c0.077,0.011,0.155,0.016,0.232,0.007 l1.894-0.16c0.115-0.01,0.228-0.039,0.333-0.088l2.979-1.356l1.405-0.086l3.075,0.649l3.369,1.431 c0.085,0.035,0.174,0.06,0.265,0.071l1.899,0.233c0.037,0.005,0.137,0.007,0.174,0.007l53.073-0.048 c0.274,0,0.536-0.113,0.726-0.312c0.188-0.199,0.287-0.468,0.272-0.741l-0.054-0.982l0.093-1.175 c0.021-0.271-0.068-0.538-0.249-0.74c-0.18-0.203-0.435-0.324-0.706-0.336l-1.37-0.059l0.125-1.242 c0.054-0.54-0.333-1.024-0.872-1.091c0,0-0.365-0.046-0.354-0.063c0.037-0.056,0.069-0.116,0.095-0.179l1.994-4.975l0.107,0.102 c0.077,0.072,0.165,0.132,0.261,0.177l0.349,0.164c0.075,0.036,0.154,0.062,0.236,0.078l0.854,0.173l0.78,0.318l0.407,0.378 l0.319,0.599l0.979,2.856c0.012,0.032,0.048,0.113,0.062,0.145l0.921,1.95c0.022,0.049,0.096,0.163,0.126,0.208l1.192,1.725 c0.052,0.075,0.114,0.143,0.184,0.2l1.554,1.276c0.104,0.085,0.223,0.147,0.351,0.186l1.552,0.458 c0.103,0.029,0.22,0.04,0.312,0.04l1.663-0.052c0.068-0.003,0.137-0.012,0.204-0.027l1.642-0.389 c0.036-0.008,0.125-0.038,0.159-0.051l1.444-0.522c0.054-0.02,0.18-0.085,0.229-0.113l1.748-0.991 c0.069-0.039,0.135-0.086,0.193-0.141l1.395-1.312c0.044-0.041,0.137-0.155,0.173-0.203l5.431-7.236l3.333-3.538l1.582-0.747 c0.08-0.038,0.155-0.087,0.223-0.146l1.188-1.029l0.518-0.328l1.356-0.167c0.109-0.014,0.215-0.045,0.313-0.093l0.447-0.22 c0.104-0.051,0.199-0.12,0.28-0.204l0.685-0.718l1.986,0.666l0.524,0.255l0.908,0.902l0.813,1.496l1.424,3.509 c0.017,0.043,0.068,0.14,0.091,0.18l1.059,1.88c0.022,0.041,0.09,0.135,0.118,0.173l4.885,6.476l1.68,3.415l1.511,4.647 l0.395,2.687l-1.114,13.018c-0.005,0.053,0.001,0.184,0.005,0.237l0.165,2.317c0.005,0.083,0.021,0.165,0.048,0.243l0.399,1.207 c0.118,0.355,0.425,0.615,0.796,0.673l1.013,0.158c0.143,0.022,0.285,0.015,0.421-0.024l6.878-1.913l1.853-0.371 c0.306-0.062,0.565-0.261,0.702-0.541S558.463,521.312,558.323,521.034z").attr({id: 'colombiawhitebg', class: 'st0', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#ffffff'}).data('id', 'colombiawhitebg');

        var santander = rsr.path("M215.282,284.221c-0.043,0.109-0.105,0.209-0.185,0.295l-0.38,0.408 c-0.109,0.118-0.248,0.205-0.401,0.253l-0.473,0.148c-0.09,0.028-0.184,0.042-0.277,0.042c-0.043,0-0.085-0.003-0.128-0.009 l-1.695,2.612c-0.03,0.047-0.065,0.091-0.103,0.131l-1.163,1.233c-0.042,0.044-0.087,0.084-0.137,0.119l-1.078,0.767l0.094,0.441 c0.004,0.018,0.007,0.037,0.01,0.056l0.05,0.334l0.343,1.259l0.413,0.796c0.023,0.045,0.043,0.092,0.059,0.141l0.653,2.01 l1.647,2.559l0.887,0.904l0.504,0.414l0.547,0.301c0.025,0.014,0.05,0.029,0.074,0.045l0.348,0.236l0.305,0.163l0.306,0.129 l0.135,0.029l0.253-0.064l1.017-0.773c0.045-0.034,0.093-0.064,0.144-0.09l0.636-0.32c0.093-0.047,0.192-0.077,0.295-0.091 l0.592-0.078c0.04-0.005,0.081-0.008,0.122-0.008c0.182,0,0.361,0.054,0.514,0.156l0.506,0.338c0.1,0.066,0.185,0.151,0.252,0.25 l0.42,0.619c0.038,0.056,0.07,0.117,0.095,0.18l0.511,1.296l0.457,0.788c0.021,0.036,0.039,0.073,0.055,0.112l0.379,0.919 c0.051,0.124,0.075,0.258,0.069,0.393l-0.035,0.819c-0.006,0.136-0.042,0.269-0.105,0.39l-1.048,1.999l-0.206,0.727l-0.021,0.407 l0.343,0.934l0.059,0.011l0.321-0.21l0.481-0.412l0.534-0.887c0.074-0.123,0.175-0.227,0.296-0.303l0.911-0.58 c0.153-0.097,0.325-0.145,0.497-0.145c0.221,0,0.441,0.079,0.615,0.234l0.807,0.716l1.728,0.468 c0.166,0.045,0.317,0.136,0.435,0.261l0.632,0.676c0.101,0.108,0.175,0.239,0.215,0.382l0.222,0.788l0.132,0.001 c0.07,0,0.139,0.008,0.207,0.024l0.487,0.114c0.127,0.03,0.246,0.086,0.35,0.164l0.474,0.36c0.108,0.082,0.196,0.186,0.259,0.306 l0.759,1.443l0.872,1.092l1.211,0.675l0.095-0.006l0.396-0.166c0.057-0.024,0.115-0.042,0.176-0.054l0.305-0.061l0.859-0.308 c0.072-0.026,0.148-0.043,0.225-0.05l0.783-0.075c0.029-0.003,0.059-0.004,0.088-0.004c0.041,0,0.082,0.003,0.123,0.008 l0.479,0.064c0.092,0.012,0.181,0.038,0.265,0.077l0.471,0.217c0.083,0.038,0.16,0.089,0.229,0.15l0.283,0.253 c0.079,0.07,0.144,0.152,0.194,0.242l0.689-0.43c0.081-0.05,0.169-0.088,0.261-0.112l2.974-0.758 c0.023-0.006,0.045-0.011,0.068-0.015l1.444-0.254c0.053-0.009,0.107-0.014,0.16-0.014c0.033,0,0.067,0.002,0.1,0.005l1.029,0.111 c0.066,0.007,0.131,0.021,0.194,0.042l0.926,0.31c0.065,0.022,0.128,0.051,0.186,0.086l0.816,0.494 c0.044,0.027,0.085,0.057,0.124,0.09l0.444,0.383l0.003-0.788c0-0.056,0.006-0.112,0.016-0.168l0.43-2.292 c0.007-0.039,0.017-0.078,0.03-0.116l0.405-1.242l0.04-0.892l-0.049-0.786l-0.179-0.661c-0.044-0.162-0.043-0.332,0.002-0.493 l0.225-0.801c0.026-0.091,0.065-0.177,0.117-0.256l0.786-1.2l0.188-1.471c0.016-0.126,0.058-0.247,0.123-0.356l0.501-0.844 c0.056-0.093,0.127-0.177,0.212-0.245l1.78-1.448l0.107-0.266c0.017-0.041,0.036-0.081,0.058-0.119l1.445-2.498 c0.145-0.25,0.397-0.418,0.683-0.455c0.04-0.005,0.079-0.008,0.118-0.008c0.245,0,0.483,0.098,0.658,0.274l0.595,0.601l1.944,0.942 c0.083,0.04,0.16,0.093,0.227,0.156l1.857,1.729c0.059,0.055,0.11,0.117,0.153,0.185l0.549,0.872 c0.045,0.071,0.08,0.148,0.104,0.229l0.163,0.546c0.025,0.085,0.038,0.173,0.039,0.261l0.003,0.806 c0,0.054-0.004,0.109-0.014,0.162l-0.164,0.943c-0.01,0.057-0.025,0.113-0.046,0.168l-0.702,1.867 c-0.022,0.058-0.049,0.113-0.082,0.166l-0.678,1.083c-0.09,0.144-0.218,0.26-0.369,0.336l-0.604,0.303l-0.045,0.284 c-0.005,0.034-0.013,0.068-0.022,0.101l-0.054,0.196c-0.06,0.215-0.195,0.401-0.381,0.525l-0.887,0.587l0.069,0.727l1.505,1.897 l0.317-0.847c0.048-0.129,0.125-0.246,0.224-0.342l0.797-0.769l0.371-0.856l0.138-0.917c0.027-0.18,0.107-0.348,0.229-0.483 l0.177-0.196c0.146-0.161,0.344-0.266,0.559-0.296l0.28-0.039c0.043-0.006,0.085-0.009,0.128-0.009c0.09,0,0.179,0.013,0.266,0.039 l1.359,0.407l0.533-0.052l1.953-3.046l0.766-2.194c0.084-0.239,0.262-0.434,0.493-0.538l0.837-0.379 c0.1-0.045,0.207-0.072,0.316-0.08l0.251-0.018c0.022-0.002,0.044-0.002,0.066-0.002c0.079,0,0.158,0.01,0.235,0.03l0.515,0.135 c0.098,0.026,0.191,0.067,0.276,0.123l1.087,0.72l1.299,0.662l3.995,0.641h0.359l0.013-0.013l0.603-2.028 c0.036-0.121,0.096-0.233,0.177-0.33l3.379-4.042l0.448-0.758c0.021-0.036,0.045-0.071,0.071-0.104l0.595-0.751 c0.104-0.132,0.243-0.233,0.4-0.292l1.26-0.475c0.033-0.012,0.066-0.023,0.1-0.031l1.229-0.309l0.452-0.305l0.725-1.974 c0.075-0.205,0.221-0.377,0.41-0.485l0.811-0.463c0.04-0.023,0.081-0.042,0.123-0.059l0.381-0.148l0.469-0.379l0.171-0.296 l0.062-0.213l-0.029-0.697c-0.002-0.059,0.001-0.119,0.01-0.178l0.093-0.614l-0.495-1.17c-0.091-0.215-0.097-0.455-0.018-0.675 l0.859-2.384l-0.199-1.735c-0.01-0.089-0.008-0.179,0.008-0.268l0.274-1.538l-0.105-0.356l-0.241-0.537l-0.233-0.268l-0.365-0.245 c-0.049-0.033-0.095-0.071-0.137-0.112l-1.407-1.398c-0.094-0.093-0.166-0.205-0.213-0.328l-0.327-0.86 c-0.105-0.276-0.072-0.586,0.089-0.834l0.454-0.698c0.114-0.175,0.284-0.307,0.483-0.373l0.894-0.299 c0.095-0.032,0.194-0.048,0.294-0.048h0.447c0.239,0,0.469,0.093,0.642,0.258l0.823,0.791l1.543,1.209 c0.061,0.048,0.116,0.103,0.163,0.165l0.759,0.988c0.035,0.045,0.065,0.093,0.091,0.144l0.494,0.97 c0.015,0.029,0.028,0.058,0.039,0.088l0.738,1.917l0.099,0.026l0.763-0.222l1.47-1.511c0.079-0.081,0.172-0.147,0.275-0.195 l0.84-0.389l0.266-0.166l0.107-0.161v-2.423c0-0.122,0.024-0.244,0.071-0.356l0.314-0.753c0.013-0.031,0.027-0.061,0.044-0.09 l1.658-3.009l0.72-3.307l0.172-1.524l-0.414-1.389c-0.022-0.073-0.034-0.148-0.038-0.224l-0.03-0.7 c-0.002-0.057,0-0.115,0.009-0.172l0.087-0.606c0.009-0.062,0.024-0.123,0.045-0.182l0.244-0.679l-0.517-1.373l-0.232,0.158 c-0.126,0.086-0.271,0.139-0.422,0.155l-0.875,0.094c-0.034,0.004-0.067,0.005-0.1,0.005c-0.451,0-0.843-0.328-0.914-0.783 l-0.19-1.215c-0.013-0.084-0.015-0.169-0.005-0.254l0.157-1.301l-0.023-0.608l-0.154-0.944l-0.096-0.31l-0.002-0.002l-0.127-0.018 l-0.195,0.02l-0.17,0.034l-0.436,0.161c-0.043,0.016-0.087,0.028-0.131,0.038l-1.292,0.271c-0.063,0.013-0.126,0.02-0.19,0.02 c-0.035,0-0.071-0.002-0.106-0.006l-0.404-0.046c-0.053-0.006-0.105-0.017-0.155-0.032l-0.003-0.001 c-0.025,0.054-0.055,0.106-0.09,0.155l-0.153,0.214c-0.058,0.081-0.129,0.152-0.209,0.21l-0.207,0.15 c-0.159,0.115-0.349,0.176-0.543,0.176c-0.052,0-0.103-0.004-0.155-0.013c-0.245-0.042-0.463-0.18-0.605-0.384l-0.119-0.171 c-0.053-0.076-0.094-0.159-0.122-0.246l-0.193-0.603l-0.122,0.022c-0.051,0.009-0.102,0.014-0.153,0.015l-0.457,0.006l-0.015,0.005 l-0.257,0.14l-0.793,0.405c-0.133,0.068-0.278,0.101-0.421,0.101c-0.224,0-0.445-0.081-0.619-0.237l-1.143-1.026l-0.459-0.29 c-0.067-0.042-0.129-0.093-0.183-0.151l-0.364-0.391l-0.151-0.079l-0.959-0.252l-1.012-0.142c-0.087-0.012-0.171-0.037-0.251-0.073 l-1.215-0.547c-0.084-0.038-0.162-0.088-0.231-0.149l-0.166-0.146c-0.096-0.084-0.174-0.188-0.228-0.304l-0.3-0.642 c-0.133-0.284-0.112-0.616,0.053-0.882l1.671-2.681c0.015-0.024,0.032-0.048,0.049-0.071l0.54-0.709l0.095-0.199 c-0.032-0.066-0.056-0.135-0.072-0.207l-0.072-0.328c-0.017-0.079-0.024-0.16-0.021-0.24l0.027-0.594l-0.046-0.022 c-0.064-0.03-0.124-0.067-0.18-0.111l-0.276-0.218c-0.057-0.045-0.109-0.097-0.155-0.155l-0.163-0.207 c-0.02-0.026-0.039-0.053-0.057-0.081l-0.274-0.438l-0.151-0.175c-0.018-0.021-0.034-0.042-0.05-0.064l-0.627-0.872 c-0.245-0.341-0.23-0.804,0.037-1.129l1.489-1.812l0.064-1.644l-0.024-0.01c-0.176-0.072-0.326-0.196-0.429-0.355l-0.06-0.093 c-0.087-0.135-0.138-0.29-0.147-0.45l-0.281-0.321c-0.029-0.033-0.056-0.069-0.08-0.106l-1.333-2.051 c-0.052-0.079-0.091-0.166-0.116-0.257l-0.262-0.943c-0.036-0.13-0.043-0.267-0.021-0.401l0.072-0.433l-0.021-0.174l-2.992-2.35 c-0.088-0.07-0.164-0.155-0.222-0.251l-0.395-0.657c-0.029-0.048-0.053-0.098-0.073-0.15l-0.243-0.644 c-0.019-0.049-0.033-0.1-0.043-0.152l-0.283-1.472c-0.012-0.06-0.017-0.121-0.017-0.183l0.002-0.234l-0.518-0.115l-0.477,0.138 l-0.269,0.233c-0.171,0.148-0.387,0.226-0.606,0.226c-0.092,0-0.186-0.014-0.276-0.042l-0.661-0.207l-0.146-0.021l-0.51-0.008 c-0.046-0.001-0.092-0.005-0.137-0.013l-0.2-0.033c-0.095-0.016-0.186-0.046-0.271-0.09l-0.091-0.047l-0.157-0.053l-0.321-0.044 h-0.957c-0.039,0-0.079-0.002-0.118-0.007l-1.398-0.179l-0.764,0.039c-0.016,0.001-0.031,0.001-0.047,0.001 c-0.06,0-0.12-0.006-0.179-0.017l-0.273-0.054c-0.057-0.011-0.112-0.028-0.166-0.049l-0.249-0.1 c-0.027-0.011-0.054-0.023-0.08-0.037l-0.024-0.012l-0.176-0.03l-0.093,0.09l-0.57,0.842l-0.398,1.892 c-0.014,0.068-0.036,0.135-0.066,0.199l-0.154,0.332c-0.153,0.33-0.483,0.537-0.84,0.537c-0.034,0-0.068-0.002-0.102-0.006 l-0.843-0.093l-1.225-0.105l-1.45,0.115c-0.024,0.002-0.049,0.003-0.073,0.003c-0.047,0-0.095-0.004-0.142-0.011l-0.854-0.132 c-0.042-0.006-0.082-0.016-0.123-0.028l-0.467-0.139c-0.24-0.071-0.44-0.236-0.556-0.458l-0.13-0.249l-0.424-0.254l-2.29-0.31 c-0.034-0.005-0.068-0.011-0.101-0.02l-0.886-0.223c-0.039-0.01-0.078-0.022-0.116-0.037l-0.657-0.261 c-0.056-0.022-0.11-0.05-0.16-0.083l-0.676-0.436c-0.038-0.024-0.074-0.052-0.108-0.081l-0.347-0.303 c-0.07-0.061-0.13-0.132-0.178-0.211l-0.468-0.758c-0.02-0.032-0.037-0.064-0.053-0.098l-0.071-0.154 c-0.064-0.139-0.093-0.291-0.084-0.444l0.001-0.018l-0.042-0.079l-0.983-1.154l-0.969-0.849l-0.992-0.471 c-0.057-0.027-0.111-0.06-0.162-0.098l-0.453-0.343c-0.028-0.021-0.054-0.043-0.079-0.067l-0.323-0.307 c-0.024-0.023-0.047-0.047-0.068-0.072l-0.444-0.524l-5.374-0.273c-0.51-0.026-0.902-0.459-0.878-0.969l0.064-1.344 c0.009-0.185,0.073-0.363,0.183-0.511l0.154-0.206l0.113-0.225l-0.008-0.141l-0.057-0.368l-0.159-0.614 c-0.034-0.133-0.039-0.273-0.012-0.408l0.089-0.457c0.016-0.082,0.043-0.161,0.08-0.235l0.22-0.444 c0.04-0.081,0.092-0.155,0.153-0.221l0.759-0.811c0.033-0.035,0.069-0.068,0.107-0.097l0.229-0.179 c0.028-0.022,0.057-0.042,0.087-0.06l0.517-0.316l1.053-0.902l0.166-0.413l-0.009-0.514l-0.165-0.489l-0.059-0.071 c-0.031-0.038-0.06-0.078-0.085-0.12l-0.043-0.073l-0.129-0.116l-0.126-0.079c-0.067-0.042-0.129-0.092-0.183-0.15l-0.253-0.268 l-0.203-0.022c-0.071-0.008-0.141-0.024-0.209-0.048l-0.195-0.069c-0.14-0.05-0.266-0.133-0.367-0.242l-0.183-0.197 c-0.018-0.019-0.035-0.039-0.051-0.06l-0.213-0.272c-0.118-0.151-0.186-0.334-0.196-0.525l-0.031-0.624l-1.796-3.113 c-0.026-0.045-0.048-0.092-0.066-0.141l-0.354-0.956c-0.031-0.085-0.05-0.173-0.056-0.264l-0.038-0.598l-0.071-0.616l-0.152,0.266 c-0.02,0.035-0.042,0.069-0.067,0.101l-0.392,0.516c-0.128,0.168-0.309,0.288-0.514,0.339l-0.098,0.024l-0.411,0.199l-0.386,1.006 l-0.289,1.29l-0.054,0.739l0.057,0.705l0.753,2.449c0.047,0.152,0.054,0.314,0.02,0.469l-0.086,0.396l0.534,2.267l0.228,0.214 c0.07,0.066,0.13,0.142,0.176,0.227l0.234,0.423c0.046,0.082,0.078,0.171,0.097,0.264l0.559,2.754 c0.009,0.043,0.014,0.086,0.017,0.129l0.06,1.009c0.004,0.065,0.001,0.131-0.009,0.195l-0.4,2.61 c-0.006,0.039-0.014,0.077-0.025,0.115l-0.159,0.555c-0.032,0.112-0.085,0.217-0.156,0.309l-0.07,0.091l0.125,0.2 c0.021,0.034,0.04,0.069,0.057,0.106l0.202,0.441c0.079,0.172,0.103,0.364,0.069,0.55l-0.079,0.436 c-0.012,0.066-0.031,0.131-0.057,0.193l-0.15,0.359l-0.054,0.222l0.027,1.463c0.002,0.1-0.012,0.199-0.042,0.294l-0.214,0.682 c-0.077,0.246-0.254,0.449-0.487,0.56l-0.264,0.125l-0.037,0.095c-0.033,0.085-0.079,0.164-0.135,0.236l-2.446,3.099l-0.15,0.4 l0.005,1.535l0.039,0.177l0.33,0.492c0.069,0.103,0.117,0.218,0.14,0.34l0.098,0.503c0.021,0.108,0.023,0.219,0.005,0.328 l-0.073,0.441c-0.012,0.073-0.033,0.145-0.062,0.213l-0.525,1.228l-0.481,1.796l-0.265,1.848l-0.025,0.172l-0.274,1.885 l0.461,5.719l0.151,0.722l0.342,0.533l0.488,0.598c0.036,0.044,0.068,0.092,0.095,0.142l0.378,0.692 c0.057,0.105,0.094,0.219,0.107,0.338l0.217,1.89c0.02,0.173-0.009,0.347-0.084,0.504l-0.591,1.241 c-0.063,0.133-0.158,0.249-0.275,0.339l-1.11,0.845c-0.048,0.037-0.1,0.069-0.155,0.095l-3.653,1.782l-0.141,0.11l-0.183,0.463 c-0.044,0.111-0.108,0.212-0.19,0.298l-1.813,1.904l-1.38,2.686c-0.022,0.043-0.048,0.084-0.076,0.123l-0.6,0.821 c-0.055,0.075-0.121,0.141-0.195,0.197l-8.409,6.248c-0.048,0.036-0.1,0.067-0.154,0.092l-1.738,0.829 c-0.091,0.043-0.187,0.071-0.287,0.083l-1.725,0.21l-0.254,0.086l-0.078,0.17l-0.055,0.288c-0.013,0.066-0.033,0.131-0.06,0.194 l-0.538,1.241l-0.033,0.158l0.128,4.04l0.051,0.279l0.565,0.604c0.044,0.047,0.083,0.099,0.117,0.154l0.289,0.48 c0.066,0.109,0.108,0.23,0.125,0.356l0.065,0.487c0.021,0.155,0.002,0.312-0.055,0.458L215.282,284.221z").attr({id: 'santander', class: 'st1', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#F4C83D'}).data({'id': 'santander', 'region':'Santander', 'benefited-companies':'24', 'benefited-projects': '$660.000.000'});

        var risaralda = rsr.path("M133.206,332.63l0.109,1.585l3.64,5.936c0.048,0.078,0.083,0.162,0.106,0.25l0.435,1.664 c0.024,0.093,0.034,0.189,0.029,0.286l-0.058,1.047l0.536,0.94c0.083,0.145,0.125,0.31,0.121,0.477l-0.037,1.855l0.089,0.098 c0.053,0.058,0.099,0.123,0.136,0.193l1.309,2.475c0.013,0.025,0.025,0.051,0.036,0.077l0.211,0.506l0.441,0.71l1.183,1.009 l0.341,0.28c0.217,0.178,0.342,0.445,0.339,0.726l-0.012,1.073l0.013,0.022l0.044,0.028l0.194,0.067l0.769-0.019l0.398-0.219 c0.135-0.074,0.286-0.114,0.44-0.115l0.149-0.001c0.002,0,0.005,0,0.007,0c0.484,0,0.887,0.373,0.923,0.856l0.026,0.343 c0.004,0.051,0.004,0.102-0.001,0.153l-0.092,1.023c-0.01,0.113-0.041,0.222-0.09,0.324l-0.282,0.577 c-0.032,0.066-0.072,0.128-0.119,0.184c0.007,0.013,0.014,0.026,0.021,0.04l0.323,0.646c0.051,0.102,0.083,0.213,0.094,0.327 l0.032,0.334c0.005,0.053,0.005,0.106,0.001,0.158l0.128,0.083l0.337,0.057l0.051-0.006l0.048-0.035l0.154-0.136l0.133-0.146 c0.099-0.109,0.222-0.193,0.36-0.245l0.208-0.078c0.059-0.022,0.121-0.038,0.183-0.048l0.408-0.064 c0.047-0.007,0.095-0.011,0.143-0.011c0.073,0,0.146,0.009,0.217,0.026l0.22,0.053c0.173,0.042,0.33,0.132,0.453,0.261l0.186,0.195 c0.119,0.125,0.201,0.28,0.236,0.448l0.113,0.536c0.013,0.06,0.019,0.121,0.02,0.183l0.002,0.243l0.313,0.049 c0.043,0.007,0.085,0.016,0.127,0.029l1.674,0.509l2.738,0.398l0.202-0.135c0.153-0.102,0.332-0.157,0.516-0.157 c0.019,0,0.037,0.001,0.056,0.002l0.351,0.021c0.117,0.007,0.232,0.036,0.338,0.086l0.317,0.149 c0.024,0.011,0.048,0.024,0.071,0.037l0.79,0.459l0.163,0.035l3.955-0.048c0.004,0,0.008,0,0.011,0c0.04,0,0.079,0.003,0.119,0.008 l1.727,0.224c0.158,0.02,0.307,0.081,0.435,0.176l1.427,1.064l0.012-0.007c0.045-0.027,0.092-0.05,0.14-0.069l0.336-0.131 c0.062-0.024,0.126-0.042,0.192-0.052l0.673-0.106l0.251-0.066l0.078-0.037l0.181-0.152c0.054-0.046,0.113-0.085,0.176-0.117 l0.181-0.092c0.036-0.018,0.073-0.034,0.112-0.048l0.298-0.106l0.129-0.076l0.14-0.125c0.038-0.035,0.08-0.066,0.123-0.094 l0.642-0.408l0.434-2.937l-0.778-0.783l-1.325-1.043c-0.03-0.023-0.058-0.049-0.085-0.076l-0.786-0.792 c-0.022-0.022-0.043-0.046-0.063-0.071l-0.617-0.765c-0.02-0.024-0.038-0.049-0.055-0.075l-0.805-1.233l-0.14-0.106l-0.22-0.059 l-0.875-0.062c-0.061-0.004-0.121-0.015-0.179-0.031l-1.136-0.312l-0.349-0.032l-0.963,0.079c-0.025,0.002-0.05,0.003-0.076,0.003 c-0.042,0-0.084-0.003-0.126-0.009l-1.186-0.163c-0.263-0.036-0.498-0.184-0.645-0.405l-0.184-0.277 c-0.096-0.144-0.149-0.312-0.154-0.485l-0.003-0.114l-0.018-0.061l-0.066-0.113l-0.502,0.455c-0.04,0.036-0.083,0.069-0.128,0.097 l-0.25,0.157c-0.071,0.045-0.148,0.08-0.228,0.104l-0.333,0.099c-0.057,0.017-0.117,0.029-0.176,0.034l-0.629,0.061 c-0.03,0.003-0.059,0.004-0.089,0.004c-0.059,0-0.118-0.006-0.176-0.017l-0.46-0.089c-0.08-0.016-0.158-0.042-0.231-0.078 l-0.341-0.167c-0.086-0.042-0.165-0.097-0.234-0.164l-0.168-0.161c-0.082-0.079-0.149-0.172-0.197-0.274l-0.205-0.437l-1.03-2.473 l-0.47,0.73l-0.048,0.149l-0.07,1.42c-0.003,0.064-0.013,0.128-0.03,0.191l-0.125,0.474c-0.022,0.084-0.056,0.165-0.101,0.24 l-0.252,0.419c-0.041,0.069-0.091,0.132-0.148,0.188l-0.69,0.671c-0.063,0.061-0.134,0.113-0.211,0.154l-0.349,0.186 c-0.135,0.072-0.284,0.108-0.435,0.108c-0.062,0-0.125-0.006-0.186-0.019l-0.972-0.2c-0.06-0.012-0.118-0.03-0.174-0.054 l-0.84-0.355c-0.215-0.091-0.388-0.26-0.484-0.473l-0.064-0.142l-0.878-0.684c-0.072-0.056-0.136-0.123-0.189-0.198l-0.49-0.696 c-0.036-0.052-0.067-0.107-0.092-0.164l-0.301-0.694c-0.017-0.039-0.031-0.079-0.043-0.121l-0.078-0.281 c-0.011-0.038-0.019-0.077-0.024-0.117l-0.048-0.338c-0.005-0.032-0.007-0.064-0.009-0.097l-0.019-0.499l-0.186-0.315l-0.487-0.453 c-0.278-0.259-0.37-0.663-0.231-1.017l1.017-2.586c0.018-0.046,0.04-0.091,0.066-0.134l0.569-0.957 c0.055-0.092,0.125-0.174,0.208-0.242l0.203-0.167c0.134-0.11,0.295-0.18,0.467-0.203l0.376-0.05 c0.04-0.005,0.081-0.008,0.122-0.008c0.016,0,0.032,0,0.048,0.001l0.822,0.043c0.096,0.005,0.192,0.025,0.282,0.059l0.096,0.037 l0.096-0.462c0.016-0.078,0.043-0.154,0.078-0.225l0.973-1.946l0.087-0.242l0.028-0.19l-0.022-0.55l-0.018-0.012 c-0.066-0.044-0.126-0.096-0.179-0.155l-0.184-0.206c-0.096-0.108-0.166-0.236-0.203-0.376l-0.092-0.341 c-0.009-0.033-0.016-0.066-0.021-0.099l-0.078-0.502c-0.026-0.167-0.006-0.339,0.059-0.495l0.205-0.498 c0.059-0.144,0.154-0.271,0.276-0.368l0.88-0.708c0.137-0.11,0.302-0.179,0.477-0.199l0.222-0.025 c0.035-0.004,0.069-0.006,0.104-0.006c0.056,0,0.112,0.005,0.168,0.015l0.315,0.058c0.076,0.014,0.149,0.037,0.219,0.069 l0.499,0.229l0.422-0.122c0.085-0.024,0.171-0.036,0.256-0.036c0.237,0,0.469,0.091,0.644,0.261l0.578,0.56l0.026,0.015l0.28,0.112 l1.114,0.238l0.543-0.213c0.034-0.013,0.069-0.025,0.104-0.034l0.543-0.798l-0.09-0.096c-0.026-0.028-0.051-0.058-0.073-0.089 l-0.269-0.373c-0.075-0.104-0.127-0.222-0.154-0.346l-0.129-0.597c-0.016-0.073-0.023-0.148-0.02-0.223v-0.008l-0.036-0.052 l-1.245-1.283l-0.393-0.309l-0.027-0.014l-0.292,0.222c-0.066,0.05-0.138,0.091-0.214,0.122l-0.202,0.082 c-0.11,0.045-0.228,0.067-0.347,0.067c-0.002,0-0.004,0-0.006,0l-0.318-0.002l-1.613,0.731c-0.061,0.028-0.125,0.049-0.191,0.063 l-0.338,0.071c-0.029,0.006-0.058,0.011-0.087,0.014l-1.663,0.188c-0.035,0.004-0.07,0.006-0.104,0.006 c-0.205,0-0.406-0.068-0.569-0.196l-0.786-0.613c-0.232-0.181-0.364-0.46-0.356-0.754l0.003-0.115l-0.045-0.357 c-0.008-0.063-0.01-0.126-0.005-0.189l0.037-0.474l-0.041-3.101c-0.025,0.002-0.049,0.003-0.074,0.003 c-0.045,0-0.09-0.003-0.135-0.01l-2.101-0.31c-0.065-0.01-0.129-0.026-0.191-0.049l-1.601-0.601 c-0.06-0.023-0.118-0.052-0.173-0.087l-1.01-0.645c-0.056-0.036-0.108-0.078-0.156-0.125l-0.838-0.836 c-0.067-0.067-0.124-0.144-0.167-0.228l-0.418-0.803l-0.459-0.231l-1.014,1.072l-0.042,0.881c-0.002,0.049-0.009,0.098-0.019,0.146 l-0.536,2.548c-0.054,0.257-0.214,0.478-0.441,0.61l-2.317,1.346l-0.644,0.532L133.206,332.63z").attr({id: 'risaralda', class: 'st2', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#FF6A29'}).data({'id': 'risaralda', 'region':'Risaralda', 'benefited-companies':'19', 'benefited-projects': '$520.000.000'});

        var boyaca = rsr.path("M205.61,307.329c-0.098,0.192-0.26,0.344-0.458,0.43l-0.411,0.178l-0.434,0.423l-0.45,0.611 l-0.235,0.452l-0.415,2.739c-0.014,0.092-0.041,0.181-0.082,0.264l-0.245,0.507c0.04-0.013,0.081-0.023,0.122-0.03l2.377-0.419 l0.859-0.39l0.454-0.355c0.108-0.084,0.232-0.143,0.365-0.174l0.303-0.069c0.067-0.015,0.136-0.023,0.205-0.023 c0.051,0,0.102,0.004,0.153,0.013l0.818,0.136c0.079,0.013,0.156,0.037,0.229,0.069l0.62,0.28l0.528,0.156l1.874,0.389l0.725-0.216 l0.292-0.231c0.026-0.021,0.054-0.04,0.082-0.058l0.608-0.382l1.326-1.145c0.03-0.026,0.062-0.05,0.096-0.072l0.653-0.43 c0.152-0.1,0.329-0.153,0.509-0.153c0.025,0,0.051,0.001,0.076,0.003l0.386,0.032c0.22,0.018,0.426,0.114,0.582,0.271l0.294,0.297 c0.082,0.082,0.147,0.179,0.193,0.286l0.122,0.284c0.013,0.03,0.025,0.062,0.034,0.093l0.056,0.183l0.085,0.034 c0.127,0.051,0.242,0.13,0.335,0.23l0.099,0.107c0.123,0.133,0.205,0.299,0.234,0.478l0.028,0.171 c0.019,0.116,0.016,0.234-0.009,0.348l-0.034,0.158l-0.003,0.26l0.029,0.142l0.214,0.292c0.08,0.109,0.136,0.235,0.162,0.368 l0.071,0.359c0.007,0.035,0.012,0.071,0.015,0.106l0.046,0.577c0.004,0.045,0.004,0.089,0.001,0.134l-0.041,0.622l0.135,0.404 l0.263,0.367c0.079,0.11,0.133,0.236,0.158,0.37l0.079,0.423c0.024,0.128,0.021,0.259-0.01,0.385l-0.135,0.563 c-0.033,0.139-0.098,0.268-0.189,0.377l-0.382,0.459l-0.439,0.776l-0.036,0.256l0.028,0.188l0.49,0.999l1.844,1.784 c0.099,0.096,0.176,0.213,0.224,0.343l0.347,0.933c0.041,0.11,0.06,0.227,0.058,0.344l-0.007,0.313 c-0.001,0.027-0.002,0.053-0.005,0.08l-0.051,0.465l1.021,0.035c0.15,0.005,0.296,0.046,0.426,0.12l1.453,0.826l0.751,0.389 l0.264,0.091l2.08-0.112c0.017-0.001,0.033-0.001,0.05-0.001c0.243,0,0.477,0.096,0.651,0.267c0.186,0.183,0.285,0.437,0.275,0.697 l-0.027,0.64l0.223,0.342l0.325,0.263l0.478,0.281l0.492,0.048c0.127,0.012,0.25,0.051,0.361,0.113l1.56,0.869l2.487-2.293 c0.108-0.099,0.237-0.172,0.378-0.211l0.819-0.229l0.136-0.389l-0.006-0.67c-0.002-0.243,0.091-0.477,0.26-0.651l2.532-2.62 c0.017-0.018,0.035-0.034,0.053-0.051l1.012-0.894c0.082-0.072,0.175-0.129,0.277-0.169l0.411-0.16 c0.044-0.017,0.089-0.031,0.134-0.041l0.445-0.099c0.066-0.015,0.134-0.022,0.202-0.022c0.01,0,0.02,0,0.03,0l0.211,0.007 c0.202,0.007,0.396,0.079,0.552,0.206l0.308,0.249c0.217,0.176,0.344,0.44,0.344,0.72v1.742l1.568,0.763l0.649-0.151 c0.07-0.016,0.14-0.024,0.21-0.024c0.235,0,0.463,0.089,0.637,0.254l0.902,0.856l0.388,0.149l0.235,0.003l0.224-0.068 c0.088-0.027,0.179-0.04,0.27-0.04c0.035,0,0.07,0.002,0.105,0.006l0.281,0.032c0.403,0.046,0.729,0.349,0.805,0.747l0.066,0.346 l0.33,0.681l1.735,1.548l0.374,0.277c0.086,0.064,0.16,0.142,0.219,0.231l0.045,0.067c0.101,0.152,0.155,0.33,0.155,0.513v0.066 l0.163,0.231c0.196,0.277,0.224,0.64,0.073,0.944l-0.247,0.5l-0.148,0.46l-0.002,0.222l0.106,0.447l0.117,0.255l1.035,0.811 l0.774,0.651c0.046,0.039,0.089,0.082,0.126,0.129l0.228,0.284c0.03,0.038,0.058,0.078,0.082,0.12l0.699,1.224 c0.1,0.176,0.14,0.379,0.114,0.58l-0.134,1.022l0.257,0.942l1.064,1.831c0.039,0.067,0.069,0.138,0.09,0.212l0.149,0.522 c0.05,0.175,0.047,0.362-0.009,0.535l-0.15,0.47l0.087,0.609l0.628,1.151c0.102,0.187,0.136,0.402,0.098,0.611l-0.113,0.616 c-0.043,0.232-0.173,0.439-0.363,0.579l-1.361,0.999l0.098,0.966c0.018,0.181-0.017,0.364-0.102,0.525l-1.31,2.493v0.075l0.566,0.8 l3.295,0.065c0.087,0.002,0.173,0.016,0.255,0.041l1.332,0.412c0.093,0.029,0.18,0.072,0.259,0.127l0.409,0.288 c0.101,0.071,0.186,0.161,0.251,0.265l0.652,1.038l0.608,0.687c0.032,0.036,0.06,0.074,0.086,0.114l0.335,0.522 c0.14,0.218,0.182,0.484,0.116,0.735l-0.036,0.139l1.13,0.404c0.21,0.075,0.386,0.223,0.495,0.417l0.903,1.601 c0.014,0.025,0.027,0.05,0.039,0.076l0.157,0.351l0.02,0.02l0.023,0.003l0.632-0.195c0.076-0.023,0.156-0.037,0.235-0.04 l0.442-0.018c0.013,0,0.025-0.001,0.037-0.001c0.019,0,0.038,0.001,0.057,0.002l0.461,0.028c0.087,0.005,0.173,0.023,0.255,0.052 l0.427,0.153c0.087,0.031,0.168,0.075,0.242,0.13l0.414,0.309c0.199,0.149,0.33,0.371,0.364,0.618l0.162,1.196l0.047,0.129 l0.402,0.014c0.105,0.004,0.209,0.025,0.307,0.064l1.678,0.659l1.469-0.113l0.307-0.173l0.127-0.123l0.07-0.178 c0.018-0.047,0.04-0.092,0.066-0.135l0.528-0.885l0.02-0.042l-0.012-0.046c-0.052-0.197-0.037-0.406,0.042-0.593l0.097-0.231 c0.039-0.092,0.092-0.177,0.158-0.252l0.243-0.277c0.146-0.167,0.346-0.274,0.563-0.306l-0.772-2.281 c-0.044-0.131-0.059-0.269-0.042-0.406l0.105-0.884c0.009-0.075,0.027-0.148,0.053-0.218l0.718-1.902l0.129-1.936 c0.003-0.051,0.011-0.102,0.023-0.152l0.71-3.001c0.027-0.114,0.075-0.222,0.142-0.317l0.261-0.373 c0.151-0.217,0.388-0.358,0.651-0.389l0.634-0.075c0.036-0.004,0.072-0.006,0.108-0.006c0.125,0,0.25,0.025,0.366,0.075l1.11,0.477 l0.633-0.705c0.02-0.023,0.042-0.044,0.064-0.065l0.655-0.599l0.135-0.261l0.228-0.966c0.02-0.083,0.05-0.163,0.092-0.237 l0.451-0.811l-0.982-0.781c-0.087-0.07-0.161-0.154-0.219-0.25l-0.463-0.776c-0.033-0.056-0.06-0.115-0.081-0.176l-0.224-0.659 c-0.035-0.103-0.051-0.211-0.049-0.319l0.014-0.633c0.001-0.061,0.009-0.122,0.022-0.181l0.226-1.014 c0.008-0.037,0.019-0.073,0.031-0.108l0.144-0.405c0.013-0.037,0.029-0.073,0.046-0.108l0.135-0.267 c0.04-0.08,0.092-0.153,0.153-0.218l0.052-0.055l-0.123-1.197c-0.027-0.262,0.059-0.523,0.236-0.718l0.341-0.374l2.508-3.534 c0.022-0.031,0.046-0.061,0.072-0.089l0.765-0.836c0.025-0.027,0.051-0.053,0.079-0.077l0.694-0.597 c0.036-0.031,0.075-0.06,0.115-0.085l0.45-0.28l1.008-0.809c0.167-0.134,0.373-0.204,0.58-0.204c0.126,0,0.252,0.026,0.371,0.078 l0.925,0.405c0.121,0.053,0.228,0.131,0.316,0.228l0.36,0.4c0.028,0.031,0.054,0.064,0.077,0.099l1.012,1.486l0.753,0.615 c0.056,0.046,0.107,0.098,0.151,0.156l1.035,1.36l0.076,0.006l2.35-2.134c0.05-0.046,0.105-0.086,0.164-0.119l1.725-0.982 l0.512-0.782l0.959-1.645c0.034-0.059,0.075-0.114,0.122-0.164l5.049-5.431l1.049-1.222c0.085-0.099,0.19-0.179,0.309-0.235 l0.53-0.249c0.091-0.043,0.189-0.071,0.289-0.082l0.48-0.055c0.035-0.004,0.07-0.006,0.104-0.006c0.195,0,0.387,0.062,0.546,0.178 l0.328,0.239c0.087,0.063,0.162,0.141,0.222,0.23l0.259,0.384c0.018,0.027,0.035,0.055,0.05,0.083l0.351,0.66l0.163,0.172 l0.912,0.702l0.02,0.013l0.45-2.39c0.011-0.059,0.028-0.116,0.05-0.172l0.168-0.42c0.012-0.031,0.026-0.061,0.042-0.09l0.275-0.52 c0.053-0.1,0.123-0.189,0.208-0.263l0.422-0.37l0.101-0.261l0.154-0.54l0.137-0.782c0.017-0.098,0.05-0.192,0.097-0.28l0.243-0.452 c0.033-0.061,0.072-0.118,0.117-0.17l0.326-0.373c0.057-0.065,0.122-0.122,0.194-0.168l-0.147-0.125 c-0.061-0.051-0.114-0.11-0.16-0.175l-0.973-1.385l-0.793-0.611c-0.151-0.116-0.263-0.277-0.32-0.459l-0.245-0.786l-1.537-1.117 l-4.328-2.317c-0.297-0.159-0.485-0.467-0.489-0.805l-0.012-0.922c-0.003-0.222,0.074-0.437,0.217-0.607l0.3-0.357 c0.034-0.041,0.072-0.078,0.112-0.113l0.439-0.37c0.077-0.065,0.163-0.116,0.256-0.153l0.728-0.288 c0.052-0.021,0.106-0.036,0.16-0.047l0.549-0.109l0.95-3.15l0.395-2.261c0.017-0.097,0.049-0.19,0.095-0.277l0.573-1.074 l0.038-0.27l-1.055-1.063c-0.07-0.071-0.128-0.152-0.172-0.241l-0.289-0.584c-0.027-0.054-0.048-0.111-0.064-0.169l-0.143-0.53 l-0.253-0.543c-0.026-0.055-0.046-0.113-0.06-0.173l-0.207-0.855l-0.56-0.303c-0.21-0.114-0.367-0.304-0.44-0.531l-0.107-0.331 c-0.037-0.116-0.051-0.239-0.041-0.361l0.039-0.47c0.006-0.067,0.018-0.133,0.038-0.197l0.902-2.915 c0.023-0.075,0.056-0.146,0.097-0.213l1.899-3.077c0.088-0.143,0.213-0.259,0.362-0.336l1.384-0.718l0.919-0.842l0.229-0.764 l0.041-0.506c0.01-0.12,0.043-0.238,0.098-0.345l0.233-0.456c0.04-0.079,0.091-0.151,0.152-0.215l0.427-0.452 c0.056-0.059,0.12-0.111,0.189-0.154l0.374-0.229c0.085-0.052,0.177-0.09,0.274-0.112l0.26-0.061 c0.069-0.016,0.14-0.024,0.21-0.024c0.119,0,0.237,0.023,0.349,0.068l0.184,0.075c0.118,0.048,0.224,0.12,0.313,0.21l0.056,0.057 l0.251-0.27l0.383-0.526c0.052-0.072,0.115-0.136,0.185-0.19l0.428-0.328c0.071-0.054,0.15-0.098,0.233-0.13l0.509-0.194 c0.081-0.031,0.166-0.05,0.252-0.057l0.487-0.041l0.439-0.184l0.36-0.434l0.311-0.538l0.437-1.412l1.078-8.657 c0.009-0.075,0.028-0.149,0.056-0.22l0.314-0.81c0.086-0.222,0.255-0.403,0.471-0.504l0.834-0.39l0.626-0.834l0.532-1.808 c0.019-0.063,0.044-0.124,0.075-0.182l0.867-1.59l1.705-4.38c0.012-0.031,0.026-0.062,0.042-0.092l0.445-0.854l0.082-0.273 l-0.318-0.075l-1.722-0.036c-0.148-0.003-0.294-0.042-0.424-0.113l-0.809-0.442l-0.777-0.282l-1.127-0.291l-3.453-0.085 l-0.597,0.216l-0.028,0.027l-0.048,0.112l-0.034,0.219c-0.011,0.068-0.029,0.134-0.054,0.198l-0.147,0.371 c-0.03,0.075-0.069,0.145-0.117,0.21l-0.287,0.387c-0.027,0.037-0.058,0.072-0.09,0.104l-0.426,0.424 c-0.045,0.045-0.094,0.085-0.147,0.119l-0.426,0.278c-0.095,0.062-0.2,0.106-0.311,0.13l-0.429,0.093 c-0.065,0.014-0.13,0.021-0.195,0.021c-0.194,0-0.384-0.061-0.543-0.176l-0.29-0.21c-0.148-0.107-0.261-0.256-0.325-0.427 l-0.082-0.22l-0.386,0.761l-0.47,1.239c-0.025,0.065-0.057,0.127-0.096,0.186l-0.458,0.686c-0.016,0.025-0.034,0.048-0.053,0.071 l-0.552,0.677c-0.029,0.036-0.061,0.069-0.094,0.1l-1.244,1.132c-0.047,0.043-0.098,0.081-0.153,0.113l-0.8,0.472 c-0.099,0.058-0.207,0.098-0.32,0.116l-0.826,0.136c-0.05,0.008-0.1,0.012-0.15,0.012c-0.054,0-0.109-0.005-0.162-0.014 l-0.982-0.175c-0.098-0.017-0.192-0.051-0.28-0.098l-1.747-0.949l0.536,1.425c0.078,0.206,0.079,0.433,0.005,0.64l-0.328,0.911 l-0.061,0.427l0.022,0.499l0.435,1.46c0.035,0.119,0.047,0.244,0.033,0.368l-0.198,1.758c-0.004,0.031-0.009,0.062-0.015,0.093 l-0.759,3.485c-0.019,0.087-0.051,0.172-0.094,0.25l-1.698,3.083l-0.223,0.536v2.518c0,0.183-0.054,0.361-0.155,0.513l-0.373,0.56 c-0.073,0.11-0.169,0.203-0.28,0.272l-0.485,0.303c-0.033,0.021-0.067,0.039-0.102,0.055l-0.738,0.341l-1.521,1.563 c-0.112,0.115-0.252,0.199-0.406,0.244l-1.244,0.361c-0.084,0.024-0.171,0.037-0.258,0.037c-0.079,0-0.157-0.01-0.234-0.03 l-0.806-0.21c-0.289-0.075-0.523-0.285-0.63-0.563l-0.891-2.315l-0.434-0.851l-0.636-0.827l-1.488-1.166 c-0.025-0.019-0.048-0.04-0.071-0.061l-0.568-0.546l-0.388,0.13l-0.022,0.033l0.089,0.233l1.202,1.194l0.393,0.264 c0.068,0.045,0.129,0.099,0.182,0.161l0.404,0.464c0.06,0.069,0.11,0.146,0.147,0.23l0.322,0.72 c0.017,0.037,0.031,0.076,0.043,0.115l0.185,0.624c0.041,0.138,0.049,0.284,0.024,0.425l-0.288,1.621l0.209,1.816 c0.016,0.142,0,0.285-0.049,0.42l-0.809,2.247l0.456,1.078c0.067,0.158,0.088,0.33,0.063,0.5l-0.119,0.784l0.032,0.759 c0.004,0.101-0.008,0.201-0.036,0.298l-0.136,0.466c-0.021,0.072-0.05,0.14-0.088,0.205l-0.314,0.542 c-0.057,0.099-0.132,0.186-0.22,0.257l-0.715,0.577c-0.074,0.06-0.157,0.108-0.246,0.142l-0.451,0.175l-0.458,0.261l-0.712,1.937 c-0.067,0.182-0.19,0.339-0.351,0.448l-0.834,0.564c-0.089,0.06-0.188,0.105-0.293,0.131l-1.335,0.336l-0.97,0.365l-0.396,0.5 l-0.454,0.769c-0.026,0.043-0.055,0.085-0.087,0.123l-3.305,3.954l-0.615,2.068c-0.044,0.146-0.123,0.28-0.23,0.388l-0.448,0.452 c-0.174,0.175-0.411,0.274-0.658,0.274h-0.819c-0.049,0-0.098-0.004-0.147-0.012l-4.212-0.676 c-0.095-0.015-0.188-0.045-0.274-0.089l-1.476-0.752c-0.031-0.016-0.062-0.034-0.091-0.053l-1.004-0.664l-0.184-0.048l-0.293,0.133 l-0.671,1.922c-0.024,0.068-0.056,0.134-0.095,0.194l-2.254,3.516c-0.153,0.239-0.407,0.394-0.689,0.422l-1.162,0.114 c-0.03,0.003-0.06,0.004-0.09,0.004c-0.09,0-0.179-0.013-0.266-0.039l-0.914-0.274l-0.05,0.336 c-0.012,0.08-0.034,0.157-0.066,0.231l-0.493,1.136c-0.049,0.112-0.119,0.213-0.206,0.298l-0.779,0.752l-0.53,1.417 c-0.124,0.332-0.427,0.564-0.779,0.597l-0.562,0.054c-0.029,0.003-0.059,0.004-0.088,0.004c-0.181,0-0.359-0.053-0.51-0.153 l-0.616-0.407c-0.082-0.054-0.154-0.121-0.215-0.197l-1.804-2.274c-0.111-0.14-0.18-0.31-0.196-0.488l-0.149-1.57 c-0.033-0.352,0.137-0.692,0.438-0.877l0.374-0.229l0.637-0.422l0.085-0.529c0.047-0.294,0.233-0.548,0.499-0.681l0.796-0.4 l0.491-0.784l0.639-1.699l0.135-0.777l-0.002-0.591l-0.089-0.297l-0.417-0.662l-1.667-1.552l-1.961-0.95 c-0.033-0.016-0.066-0.034-0.097-0.054l-0.817,1.411l-0.171,0.427c-0.059,0.146-0.153,0.275-0.275,0.374l-1.838,1.495l-0.319,0.537 l-0.19,1.492c-0.018,0.139-0.067,0.273-0.144,0.39l-0.824,1.259l-0.117,0.417l0.137,0.505c0.016,0.06,0.027,0.122,0.03,0.185 l0.058,0.93c0.002,0.033,0.002,0.066,0.001,0.099l-0.048,1.068c-0.004,0.083-0.019,0.166-0.045,0.245l-0.425,1.304l-0.404,2.15 l-0.003,0.916c0,0.06-0.006,0.12-0.018,0.178l-0.096,0.478c-0.005,0.028-0.012,0.055-0.02,0.082l-0.14,0.473 c-0.059,0.198-0.182,0.371-0.351,0.491l-0.47,0.334c-0.162,0.115-0.35,0.172-0.537,0.172c-0.253,0-0.504-0.103-0.685-0.303 l-0.341-0.374l-0.789-0.679l-0.662-0.401l-0.734-0.245l-0.799-0.087l-1.281,0.225l-2.801,0.714l-1.917,1.195 c-0.15,0.093-0.32,0.14-0.49,0.14c-0.161,0-0.322-0.042-0.466-0.126c-0.297-0.173-0.473-0.496-0.459-0.839l0.029-0.678 l-0.069-0.032l-0.235-0.031l-0.562,0.054l-0.814,0.292c-0.043,0.015-0.086,0.027-0.13,0.036l-0.281,0.056l-0.453,0.19 c-0.094,0.039-0.194,0.063-0.295,0.07l-0.523,0.035c-0.021,0.001-0.042,0.002-0.063,0.002c-0.158,0-0.313-0.04-0.451-0.117 l-1.61-0.898c-0.105-0.059-0.198-0.137-0.273-0.231l-1.041-1.303c-0.037-0.046-0.069-0.095-0.096-0.147l-0.704-1.339l-0.154-0.117 l-0.193-0.045l-0.726-0.003c-0.413-0.002-0.776-0.277-0.888-0.675l-0.35-1.243l-0.298-0.319l-1.684-0.456 c-0.138-0.037-0.266-0.106-0.373-0.201l-0.447-0.397l-0.137,0.088l-0.499,0.829c-0.051,0.085-0.116,0.161-0.191,0.226l-0.64,0.548 c-0.03,0.026-0.062,0.05-0.095,0.071l-0.545,0.357c-0.104,0.068-0.221,0.115-0.344,0.137l-0.316,0.057 c-0.054,0.01-0.109,0.015-0.163,0.015c-0.057,0-0.114-0.005-0.171-0.016l-0.764-0.143c-0.321-0.06-0.586-0.285-0.699-0.591 l-0.59-1.606c-0.043-0.118-0.062-0.243-0.056-0.368l0.037-0.701c0.004-0.069,0.015-0.138,0.034-0.204l0.261-0.92 c0.017-0.061,0.041-0.121,0.071-0.177l0.996-1.901l0.018-0.408l-0.277-0.673l-0.461-0.794c-0.023-0.04-0.043-0.082-0.06-0.125 l-0.499-1.266l-0.261-0.385l-0.066-0.044l-0.091,0.012l-0.42,0.211l-1.099,0.836c-0.099,0.075-0.212,0.13-0.333,0.161l-0.645,0.164 c-0.075,0.019-0.151,0.028-0.228,0.028c-0.065,0-0.13-0.007-0.194-0.021l-0.432-0.092c-0.057-0.012-0.112-0.03-0.166-0.052 l-0.426-0.179c-0.026-0.011-0.052-0.023-0.077-0.037l-0.386-0.206c-0.029-0.015-0.056-0.032-0.083-0.05l-0.352-0.239l-0.584-0.321 c-0.05-0.027-0.097-0.059-0.141-0.095l-0.609-0.499c-0.026-0.021-0.05-0.044-0.074-0.067l-0.989-1.007 c-0.044-0.045-0.084-0.095-0.118-0.148l-1.763-2.74c-0.043-0.067-0.077-0.139-0.102-0.215l-0.666-2.052l-0.424-0.816 c-0.03-0.058-0.054-0.12-0.072-0.183l-0.383-1.408c-0.007-0.027-0.013-0.054-0.018-0.081l-0.014,0.01l-0.738,0.828l-0.478,0.927 l-0.325,1.844c-0.018,0.105-0.055,0.206-0.108,0.298l-0.56,0.982l-0.117,0.366l0.015,0.309l0.094,0.169l0.589,0.67 c0.066,0.075,0.119,0.159,0.157,0.251l0.317,0.75c0.035,0.082,0.058,0.169,0.067,0.258l0.076,0.679 c0.005,0.047,0.007,0.095,0.005,0.143l-0.078,1.799l0.029,0.188l0.073,0.247c0.02,0.069,0.033,0.139,0.037,0.211l0.019,0.329 c0.008,0.135-0.014,0.271-0.065,0.397l-0.163,0.407c-0.068,0.169-0.183,0.314-0.333,0.418l-0.23,0.159 c-0.058,0.04-0.12,0.073-0.186,0.099l-0.456,0.181l-0.008,0.17l0.631,1.737c0.088,0.241,0.071,0.508-0.045,0.736L205.61,307.329z").attr({id: 'boyaca', class: 'st3', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#B2E274'}).data({'id': 'boyaca', 'region':'Boyacá', 'benefited-companies':'8', 'benefited-projects': '$200.000.000'});

        var nortedesantander = rsr.path("M314.978,254.053c0.008,0,0.015,0,0.023,0l3.686,0.091l-0.604-0.71 c-0.046-0.054-0.085-0.112-0.117-0.175l-2.515-4.87c-0.016-0.031-0.03-0.063-0.043-0.096l-0.493-1.299 c-0.013-0.034-0.024-0.069-0.033-0.104l-0.335-1.339c-0.012-0.046-0.02-0.093-0.024-0.141l-0.125-1.368 c-0.005-0.054-0.005-0.108-0.001-0.162l0.033-0.395c0.004-0.044,0.011-0.087,0.02-0.13l0.324-1.405 c-0.026-0.027-0.051-0.055-0.073-0.085l-1.389-1.808l-1.103-0.312l-3.614,0.055c-0.005,0-0.009,0-0.014,0 c-0.057,0-0.114-0.005-0.169-0.016l-2.237-0.416c-0.043-0.008-0.086-0.019-0.128-0.033l-1.143-0.387l-0.858-0.291 c-0.088-0.03-0.171-0.073-0.247-0.128l-1.676-1.216c-0.098-0.071-0.182-0.161-0.245-0.265l-1.25-2.037 c-0.067-0.109-0.11-0.23-0.128-0.357l-0.151-1.085c-0.018-0.13-0.008-0.263,0.029-0.389l0.279-0.95 c0.01-0.033,0.021-0.066,0.035-0.098l0.349-0.831l0.134-0.751l-0.114-0.647l-0.597-1.731c-0.019-0.056-0.033-0.113-0.041-0.171 l-0.134-0.94c-0.01-0.07-0.012-0.141-0.006-0.211l0.42-4.829c0.006-0.07,0.02-0.139,0.042-0.206l0.887-2.736l0.086-0.637 l-0.112-1.828l-0.137-0.573l-0.203-0.322l-0.913-1.06c-0.048-0.055-0.089-0.116-0.122-0.181l-0.208-0.405 c-0.108-0.21-0.131-0.454-0.066-0.68l0.156-0.538c0.058-0.2,0.182-0.375,0.352-0.496l0.411-0.293 c0.067-0.048,0.141-0.087,0.219-0.115l0.471-0.173l0.347-0.172l0.537-0.446l0.417-0.478l0.274-0.526l0.19-0.79 c0.019-0.08,0.049-0.158,0.089-0.23l0.458-0.83c0.142-0.258,0.399-0.433,0.692-0.471l0.856-0.111 c0.04-0.005,0.079-0.008,0.119-0.008c0.051,0,0.102,0.004,0.153,0.013l0.89,0.149l0.224,0.001l0.28-0.399l-0.066-1.337 l-0.921-2.953l-1.48-2.793c-0.036-0.068-0.064-0.141-0.082-0.217l-0.248-1.028c-0.022-0.093-0.03-0.189-0.023-0.284l0.054-0.747 c0.004-0.059,0.014-0.118,0.03-0.175l0.39-1.442l0.063-0.554l-0.09-0.55l-0.24-0.6l-0.345-0.542l-0.375-0.381l-0.232-0.126 l-0.325-0.086c-0.034-0.009-0.068-0.02-0.101-0.033l-0.462-0.181c-0.095-0.037-0.182-0.089-0.26-0.155l-0.536-0.453 c-0.029-0.025-0.057-0.051-0.083-0.08l-1.081-1.172l-0.896-0.976l-0.897-0.972l-0.897-0.974l-0.899-0.974l-0.895-0.979 l-0.896-0.972l-0.896-0.975l-0.9-0.975l-0.839-0.911c-0.044-0.048-0.084-0.101-0.117-0.158l-0.913-1.553 c-0.043-0.074-0.076-0.153-0.098-0.236l-0.484-1.856l-0.524-2.019l-0.526-2.016l-0.524-2.02l-0.528-2.015l-0.524-2.02l-0.526-2.019 l-0.526-2.017l-0.524-2.02l-0.174-0.665l-0.635-0.74c-0.263-0.306-0.297-0.748-0.085-1.091l0.336-0.543l-0.372-0.222 c-0.06-0.036-0.115-0.078-0.166-0.126l-0.264-0.252c-0.097,0.034-0.2,0.051-0.305,0.051c-0.007,0-0.013,0-0.02,0l-0.337-0.007 c-0.095-0.002-0.189-0.019-0.279-0.049l-0.266-0.091l-0.235-0.006l-0.337,0.1l-0.241,0.125l-1.52,1.008 c-0.055,0.037-0.114,0.067-0.176,0.091l-0.923,0.36c-0.108,0.042-0.222,0.063-0.336,0.063c-0.077,0-0.155-0.01-0.231-0.029 l-0.864-0.222c-0.209-0.054-0.393-0.179-0.52-0.355l-0.816-1.13c-0.069-0.096-0.119-0.204-0.148-0.319l-0.25-1.004 c-0.023-0.092-0.031-0.187-0.026-0.281l0.114-1.838l-0.135-0.826l-0.333-0.339c-0.04-0.041-0.076-0.085-0.108-0.132l-0.156-0.232 c-0.11-0.164-0.165-0.358-0.157-0.555l0.007-0.174c0.005-0.118,0.032-0.234,0.081-0.342l0.076-0.169l-0.377-1.111l-0.173,0.006 l-1.725,1.626c-0.054,0.051-0.115,0.096-0.179,0.132l-1.038,0.587c-0.065,0.037-0.133,0.065-0.205,0.085l-1.029,0.29l-0.612,0.405 l-1.508,1.429c-0.068,0.064-0.145,0.118-0.229,0.159l-1.647,0.809c-0.088,0.043-0.183,0.072-0.28,0.086l-1.899,0.265 c-0.035,0.005-0.07,0.008-0.105,0.009l-4.918,0.122l-1.85,0.436l-0.047,0.021l-0.601,1.068l0.154,1.449 c0.006,0.06,0.007,0.121,0.001,0.181l-0.565,6.267l0.182,1.77c0.003,0.032,0.005,0.065,0.005,0.098l-0.001,0.348 c0,0.073-0.009,0.146-0.026,0.217l-0.259,1.063l0.538,2.043l0.345,1.036c0.03,0.091,0.046,0.186,0.047,0.281l0.006,0.499 c0.002,0.131-0.025,0.26-0.077,0.38l-0.206,0.473c-0.048,0.112-0.119,0.213-0.206,0.297l-0.647,0.624 c-0.045,0.044-0.095,0.083-0.148,0.117l-1.053,0.666l-0.009,0.009l0.018,0.066c0.016,0.06,0.026,0.122,0.03,0.184l0.019,0.315 c0.008,0.137-0.014,0.275-0.066,0.402l-0.135,0.334c-0.043,0.105-0.104,0.202-0.182,0.285l-0.451,0.484 c-0.034,0.037-0.071,0.07-0.11,0.101l-1.639,1.269l-0.547,0.545l-0.265,0.332l-0.281,0.426l-0.16,0.344l-0.081,0.463l-0.016,0.405 l0.015,0.261l0.324,0.872l1.245,1.772c0.038,0.054,0.07,0.111,0.095,0.171l0.755,1.783c0.152,0.084,0.277,0.209,0.361,0.361 l0.326,0.587c0.118,0.212,0.148,0.462,0.083,0.697l-0.543,1.964c-0.037,0.135-0.105,0.26-0.197,0.365l-0.382,0.434l0.24,0.072 c0.068,0.02,0.133,0.048,0.194,0.083l0.331,0.189c0.066,0.038,0.128,0.084,0.183,0.137l0.185,0.178l0.653,0.42 c0.158,0.101,0.279,0.247,0.351,0.415c0.021-0.02,0.042-0.039,0.065-0.057l0.934-0.752l-0.182-1.144l-0.015-0.052l-0.253-0.417 c-0.045-0.075-0.08-0.156-0.102-0.24l-0.207-0.773c-0.033-0.121-0.04-0.248-0.022-0.372l0.028-0.197 c0.02-0.137,0.07-0.267,0.146-0.382l0.212-0.318c0.145-0.217,0.374-0.362,0.631-0.402l0.384-0.059 c0.046-0.007,0.093-0.011,0.139-0.011c0.008,0,0.017,0,0.025,0l0.658,0.018c0.035,0.001,0.071,0.004,0.106,0.009l1.034,0.148 c0.133,0.019,0.261,0.067,0.374,0.141l0.517,0.336c0.059,0.039,0.114,0.084,0.163,0.135l0.295,0.308 c0.149,0.155,0.239,0.357,0.255,0.571l0.156,2.049c0.007,0.09,0,0.181-0.019,0.27l-0.632,2.864 c-0.013,0.06-0.032,0.118-0.057,0.174l-0.689,1.561l-0.355,1.304c-0.018,0.068-0.045,0.133-0.078,0.195l-0.466,0.868l-0.293,0.789 l-0.135,0.798l0.174,3.054l0.228,0.148c0.151,0.098,0.27,0.239,0.343,0.404l0.691,1.575c0.051,0.116,0.078,0.242,0.078,0.369 l0.001,0.252l0.052,0.317c0.01,0.062,0.014,0.124,0.011,0.186l-0.04,1.011l0.081,0.302l0.192,0.207l1.629,0.165 c0.268,0.027,0.51,0.169,0.665,0.39l0.46,0.656l0.11,0.048l0.107,0.029c0.081,0.022,0.159,0.055,0.231,0.098l0.185,0.111 c0.158,0.094,0.284,0.234,0.363,0.4l0.106,0.225c0.039,0.083,0.066,0.171,0.079,0.261l0.053,0.366 c0.011,0.073,0.012,0.147,0.006,0.22l-0.054,0.576c-0.005,0.05-0.014,0.1-0.027,0.149l-0.176,0.666 c-0.03,0.112-0.08,0.218-0.149,0.312l-0.572,0.779c-0.018,0.025-0.038,0.049-0.058,0.072l-0.41,0.455 c-0.034,0.037-0.07,0.072-0.109,0.103l-0.553,0.443c-0.073,0.059-0.155,0.106-0.242,0.14l-0.709,0.277l-0.056,0.043l-0.085,0.213 l-0.107,0.613l0.127,1.516c0.005,0.054,0.004,0.108-0.001,0.162l-0.088,0.961c-0.006,0.065-0.019,0.13-0.039,0.193l-0.143,0.455 c-0.022,0.072-0.054,0.14-0.093,0.205l-0.236,0.386c-0.016,0.026-0.033,0.052-0.052,0.076l-0.972,1.285l-0.339,0.656 c-0.047,0.091-0.109,0.173-0.182,0.244l-0.48,0.459l-0.421,0.557c-0.028,0.037-0.058,0.071-0.091,0.103l-0.668,0.653 c-0.043,0.042-0.089,0.079-0.139,0.112l-0.918,0.604c-0.039,0.026-0.08,0.049-0.123,0.068l-1.413,0.648 c-0.046,0.021-0.093,0.038-0.142,0.052l-0.563,0.153c-0.08,0.022-0.161,0.033-0.244,0.033c-0.038,0-0.075-0.002-0.113-0.007 l-0.408-0.05c-0.022-0.003-0.043-0.006-0.064-0.01l0.181,0.213c0.044,0.051,0.082,0.107,0.113,0.167l0.158,0.298 c0.037,0.07,0.065,0.144,0.083,0.221l0.047,0.2c0.014,0.06,0.023,0.122,0.024,0.184l0.318,0.514l0.191,0.167l0.543,0.35 l0.517,0.205l0.777,0.195l2.428,0.329c0.124,0.017,0.244,0.059,0.352,0.123l0.811,0.486c0.146,0.088,0.265,0.214,0.344,0.365 l0.07,0.133l0.032,0.01l0.685,0.106l1.419-0.113c0.024-0.002,0.049-0.003,0.073-0.003c0.027,0,0.053,0.001,0.08,0.003l1.324,0.114 l0.112,0.012l0.334-1.589c0.025-0.118,0.072-0.229,0.14-0.329l0.727-1.072c0.036-0.053,0.077-0.102,0.123-0.147l0.381-0.368 c0.119-0.115,0.267-0.196,0.427-0.234l0.328-0.079c0.071-0.017,0.143-0.025,0.216-0.025c0.052,0,0.103,0.004,0.155,0.013 l0.57,0.096c0.094,0.016,0.185,0.046,0.27,0.09l0.113,0.058l0.127,0.051l0.076,0.015l0.732-0.037 c0.016-0.001,0.031-0.001,0.047-0.001c0.039,0,0.079,0.002,0.118,0.008l1.421,0.182h0.961c0.042,0,0.084,0.003,0.125,0.009 l0.471,0.064c0.058,0.008,0.115,0.021,0.171,0.04l0.307,0.104c0.044,0.015,0.086,0.033,0.128,0.054l0.021,0.011l0.492,0.008 c0.04,0.001,0.079,0.004,0.118,0.01l0.277,0.04c0.048,0.007,0.096,0.018,0.143,0.033l0.239,0.075l0.032-0.028 c0.101-0.087,0.22-0.152,0.348-0.189l0.899-0.261c0.084-0.024,0.171-0.037,0.258-0.037c0.067,0,0.135,0.007,0.201,0.022 l1.659,0.369c0.259,0.058,0.481,0.224,0.609,0.456c0.128,0.232,0.151,0.508,0.062,0.758l-0.122,0.342l-0.009,0.061l-0.001,0.144 l0.251,1.304l0.185,0.492l0.264,0.439l3.159,2.482c0.193,0.152,0.318,0.374,0.347,0.618l0.083,0.687 c0.011,0.088,0.009,0.176-0.006,0.264l-0.061,0.361l0.169,0.608l1.219,1.876l0.466,0.532c0.086,0.098,0.15,0.213,0.188,0.335 l0.149,0.061c0.361,0.147,0.592,0.504,0.576,0.894l-0.102,2.604c-0.008,0.202-0.082,0.396-0.21,0.552l-1.235,1.502l0.187,0.26 l0.17,0.198c0.03,0.035,0.058,0.073,0.083,0.112l0.285,0.455l0.064,0.081l0.106,0.084l0.352,0.165 c0.21,0.098,0.375,0.272,0.463,0.486l0.096,0.232c0.033,0.079,0.054,0.162,0.064,0.247l0.039,0.339 c0.006,0.049,0.007,0.098,0.005,0.148l-0.027,0.593l0.022,0.1l0.073,0.149c0.046,0.095,0.076,0.197,0.089,0.301l0.028,0.244 c0.02,0.173-0.009,0.348-0.083,0.505l-0.283,0.596c-0.027,0.058-0.061,0.112-0.099,0.163l-0.572,0.752l-1.369,2.197l0.876,0.394 l0.936,0.131c0.036,0.005,0.072,0.012,0.107,0.022l1.112,0.293c0.066,0.017,0.13,0.042,0.191,0.074l0.385,0.2 c0.094,0.049,0.179,0.113,0.251,0.191l0.392,0.42l0.424,0.268c0.044,0.028,0.085,0.059,0.124,0.094l0.728,0.653l0.204-0.104 l0.317-0.173c0.055-0.03,0.113-0.054,0.173-0.073l0.232-0.071c0.084-0.026,0.172-0.04,0.26-0.041l0.513-0.006l0.239-0.043 c0.037-0.007,0.074-0.011,0.112-0.013l0.31-0.018c0.018-0.001,0.035-0.002,0.053-0.002c0.156,0,0.309,0.039,0.446,0.115 l0.304,0.167c0.138,0.076,0.254,0.186,0.338,0.318c0.066-0.034,0.136-0.061,0.21-0.079l0.215-0.052 c0.072-0.017,0.145-0.026,0.219-0.026c0.055,0,0.11,0.005,0.164,0.015l0.238,0.043c0.033,0.006,0.065,0.014,0.097,0.023 l0.275,0.081l0.175,0.02l1.078-0.226l0.44-0.163c0.045-0.017,0.092-0.03,0.139-0.039l0.286-0.057 c0.029-0.006,0.059-0.01,0.089-0.013l0.352-0.036c0.031-0.003,0.062-0.005,0.094-0.005c0.043,0,0.086,0.003,0.129,0.009 l0.407,0.057c0.074,0.01,0.147,0.03,0.216,0.058l0.283,0.114c0.164,0.066,0.305,0.177,0.408,0.321l0.261,0.365 c0.057,0.081,0.102,0.17,0.131,0.264l0.159,0.514c0.013,0.041,0.023,0.083,0.029,0.125l0.174,1.064 c0.006,0.038,0.01,0.076,0.011,0.114l0.028,0.738c0.002,0.049,0,0.098-0.006,0.146l-0.15,1.247l0.003,0.019l0.022-0.031 l0.322-0.588c0.165-0.3,0.479-0.481,0.812-0.481c0.061,0,0.122,0.006,0.184,0.018l1.134,0.229c0.09,0.018,0.177,0.05,0.258,0.094 l2.483,1.349l0.678,0.121l0.498-0.082l0.568-0.335l1.122-1.021l0.481-0.59l0.375-0.561l0.45-1.187 c0.012-0.031,0.025-0.061,0.04-0.09l0.814-1.606c0.16-0.317,0.483-0.508,0.826-0.508c0.074,0,0.149,0.009,0.223,0.027l1.051,0.26 c0.297,0.074,0.539,0.289,0.646,0.576l0.083,0.223l0.236-0.236l0.173-0.234l0.064-0.162l0.036-0.23 c0.012-0.075,0.033-0.149,0.063-0.219l0.168-0.393c0.049-0.116,0.122-0.221,0.213-0.307l0.307-0.293 c0.093-0.089,0.203-0.157,0.324-0.201l0.944-0.342C314.764,254.072,314.871,254.053,314.978,254.053z").attr({id: 'nortedesantander', class: 'st4', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#EA96CE'}).data({'id': 'nortedesantander', 'region':'Norte de Santander', 'benefited-companies':'9', 'benefited-projects': '$220.000.000'});

        var quindio = rsr.path("M154.585,364.616c-0.055,0.089-0.125,0.168-0.206,0.234l-0.207,0.167 c-0.16,0.129-0.359,0.202-0.565,0.205l-1.182,0.022l-0.294,0.127c-0.116,0.05-0.241,0.076-0.367,0.076 c-0.047,0-0.094-0.004-0.141-0.011l-2.584-0.397l-1.156,1.603l0.029,0.232c0.019,0.149,0.001,0.301-0.052,0.442l-0.091,0.242 c-0.026,0.07-0.06,0.136-0.102,0.197l-0.16,0.234l-0.027,0.161c-0.005,0.031-0.012,0.062-0.02,0.092l-0.283,1.036l0.071,3.156 l0.298,0.678c0.183,0.415,0.037,0.902-0.343,1.149l-0.384,0.249l0.513,0.012c0.111,0.003,0.221,0.025,0.323,0.067l2.03,0.818 c0.221,0.089,0.4,0.26,0.498,0.478l0.965,2.136c0.107,0.238,0.11,0.509,0.006,0.748l-0.04,1.579l0.058,0.568 c0.01,0.095,0.005,0.191-0.015,0.284l-0.053,0.252c-0.012,0.057-0.029,0.113-0.052,0.167l-0.716,1.712 c-0.023,0.056-0.052,0.109-0.086,0.159l-0.563,0.838l-0.184,0.381l-0.136,0.369l-0.046,0.263l0.024,0.733 c0.002,0.05-0.001,0.101-0.007,0.151l-0.049,0.376c-0.004,0.028-0.008,0.055-0.015,0.082l-0.073,0.327 c-0.014,0.063-0.035,0.124-0.062,0.183l-0.203,0.444l-0.033,0.537l0.023,0.493l1.15,0.413c0.07,0.025,0.137,0.059,0.199,0.1 l0.796,0.527l0.144,0.059l1.871-2.14l0.699-1.15l0.308-0.667c0.028-0.06,0.062-0.116,0.101-0.169l0.866-1.149l0.251-0.682 c0.06-0.162,0.163-0.304,0.299-0.41l0.895-0.699l1.012-1.481l0.424-0.671l0.502-2.655l0.337-3.083 c0.011-0.102,0.039-0.201,0.083-0.294l1.05-2.228c0.032-0.068,0.072-0.131,0.119-0.189l1.246-1.536l0.721-2.023 c0.028-0.078,0.066-0.152,0.114-0.22l0.35-0.501c0.024-0.035,0.051-0.068,0.08-0.099l1.024-1.102 c0.071-0.076,0.154-0.14,0.247-0.189l2.035-1.072l0.118-0.139l0.168-0.274l0.214-0.936l-0.095,0.045 c-0.051,0.024-0.104,0.043-0.158,0.057l-0.378,0.1c-0.03,0.008-0.061,0.014-0.092,0.019l-0.621,0.098l-0.17,0.066l-0.205,0.123 c-0.144,0.087-0.309,0.132-0.477,0.132c-0.017,0-0.034,0-0.051-0.001l-0.323-0.018c-0.042-0.002-0.083-0.007-0.124-0.015 l-0.258-0.05c-0.137-0.026-0.267-0.083-0.379-0.167l-1.422-1.06l-1.422-0.184l-3.995,0.049c-0.004,0-0.008,0-0.011,0 c-0.066,0-0.132-0.007-0.197-0.021l-0.408-0.089c-0.094-0.021-0.185-0.056-0.269-0.104l-0.548-0.319l0.052,0.342 c0.003,0.02,0.005,0.04,0.007,0.06l0.064,0.729c0.017,0.199-0.03,0.397-0.135,0.567L154.585,364.616z").attr({id: 'quindio', class: 'st5', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#CEB3C9'}).data({'id': 'quindio', 'region':'Quindío', 'benefited-companies':'8', 'benefited-projects': '$340.000.000'});

        var meta = rsr.path("M364.735,354.593c-0.048,0.021-0.097,0.037-0.148,0.049l-0.52,0.125l-0.645,0.29l-1.164,0.701 l-2.149,1.665l-0.34,0.342c-0.14,0.14-0.321,0.232-0.517,0.262l-2.591,0.395l-13.072,5.626l-3.507,2.402 c-0.036,0.025-0.074,0.047-0.114,0.067l-1.934,0.953c-0.044,0.022-0.089,0.04-0.136,0.054l-4.094,1.265 c-0.065,0.02-0.131,0.033-0.199,0.038l-0.569,0.046c-0.025,0.002-0.05,0.003-0.075,0.003c-0.015,0-0.03,0-0.045-0.001l-0.411-0.02 l-0.147,0.024l-0.21,0.163l-3.508,3.823c-0.028,0.03-0.057,0.058-0.088,0.084l-3.481,2.91c-0.036,0.03-0.075,0.058-0.115,0.082 l-1.758,1.063c-0.072,0.044-0.15,0.077-0.232,0.1l-1.717,0.476c-0.081,0.022-0.164,0.034-0.247,0.034 c-0.09,0-0.18-0.013-0.267-0.039l-0.919-0.277c-0.182-0.055-0.343-0.164-0.461-0.314l-0.509-0.646 c-0.028-0.035-0.053-0.073-0.076-0.112l-0.261-0.455l-1.483-0.939l-0.232-0.084l-0.257,0.005l-7.122,1.544l-0.282,0.128 l-1.826,2.814c-0.126,0.195-0.322,0.335-0.547,0.393l-1.025,0.263c-0.075,0.019-0.153,0.029-0.23,0.029 c-0.042,0-0.084-0.003-0.126-0.009l-1.163-0.16c-0.149-0.021-0.292-0.077-0.414-0.165l-0.372-0.267l-1.647,0.941 c-0.07,0.04-0.145,0.071-0.223,0.091l-1.103,0.291c-0.078,0.021-0.158,0.031-0.236,0.031c-0.309,0-0.604-0.155-0.777-0.423 l-0.439-0.677l-0.071-0.081l-0.334-0.143l-0.488-0.13l-0.863,1.518c-0.097,0.17-0.245,0.306-0.424,0.386l-0.361,0.163 c-0.122,0.055-0.252,0.082-0.382,0.082c-0.188,0-0.375-0.057-0.533-0.169l-0.282-0.199c-0.034-0.024-0.067-0.051-0.098-0.08 c-0.106,0.053-0.221,0.086-0.339,0.096l-0.335,0.028c-0.026,0.002-0.052,0.003-0.078,0.003c-0.055,0-0.109-0.005-0.163-0.014 l-1.696-0.303l-0.166-0.011l-0.01,0.004l-0.488,0.476c-0.035,0.034-0.073,0.066-0.113,0.094l-0.258,0.182 c-0.113,0.08-0.243,0.133-0.38,0.156l-0.505,0.085c-0.051,0.009-0.103,0.013-0.154,0.013c-0.094,0-0.187-0.014-0.277-0.042 l-0.34-0.106c-0.061-0.019-0.121-0.045-0.177-0.076l-1.026-0.576c-0.251-0.141-0.422-0.391-0.463-0.676l-0.13-0.904l-0.03,0.008 c-0.078,0.021-0.157,0.031-0.237,0.031c-0.055,0-0.109-0.005-0.163-0.015l-0.336-0.06c-0.441-0.079-0.763-0.463-0.763-0.912v-0.291 c0-0.079,0.01-0.157,0.03-0.234l0.04-0.154l-0.083-0.115c-0.105-0.146-0.166-0.319-0.174-0.499l-0.007-0.158l-0.025-0.065 l-0.683-0.753c-0.064-0.071-0.117-0.151-0.157-0.239l-0.106-0.232l-0.258,0.019c-0.022,0.002-0.045,0.003-0.067,0.003 c-0.255,0-0.499-0.105-0.675-0.292l-4.086-4.349c-0.054-0.057-0.1-0.121-0.138-0.191l-3.039-5.572l-1.715-1.673l-1.292,9.001 l-1.518,9.919l-0.122,1.07c-0.012,0.108-0.044,0.213-0.092,0.31l-0.224,0.447c-0.086,0.173-0.225,0.314-0.395,0.404l-0.302,0.159 c-0.135,0.071-0.284,0.107-0.432,0.107c-0.126,0-0.252-0.026-0.37-0.077l-0.701-0.305c-0.055-0.024-0.108-0.053-0.157-0.087 l-1.146-0.792l-0.505-0.264c-0.062-0.032-0.12-0.072-0.173-0.117l-0.207-0.178c-0.1-0.086-0.181-0.192-0.237-0.311l-0.175-0.374 l-0.266-0.2l-0.838-0.323l-5.398-1.353l-2.445,0.256l-0.969,0.776c-0.069,0.055-0.146,0.101-0.228,0.134l-0.755,0.309 c-0.064,0.026-0.13,0.045-0.198,0.056l-0.721,0.121c-0.051,0.008-0.102,0.013-0.153,0.013c-0.059,0-0.119-0.006-0.178-0.017 l-0.636-0.124c-0.083-0.016-0.163-0.044-0.238-0.081l-0.485-0.243l-0.649-0.242c-0.05-0.018-0.097-0.041-0.143-0.068l-0.519-0.303 c-0.054-0.031-0.105-0.068-0.151-0.11l-0.393-0.352c-0.053-0.047-0.1-0.101-0.141-0.159l-0.209-0.298 c-0.092-0.132-0.148-0.285-0.163-0.445l-0.037-0.399l-0.915-2.041c-0.028-0.063-0.05-0.13-0.063-0.198l-0.255-1.279 c-0.008-0.043-0.014-0.086-0.016-0.129l-0.024-0.427l-0.074-0.167l-0.542-0.756l-0.533-0.599c-0.047-0.053-0.088-0.112-0.122-0.174 l-0.373-0.688l-0.052-0.026l-0.187-0.045l-0.514,0.025c-0.015,0.001-0.031,0.001-0.046,0.001c-0.218,0-0.43-0.077-0.598-0.219 l-0.487-0.412c-0.076-0.065-0.142-0.141-0.194-0.226l-0.118-0.195l-0.16-0.164l-0.285-0.158l-0.12-0.037l-0.089,0.025l-0.197,0.178 l-0.564,0.905l-0.265,0.541c-0.084,0.171-0.218,0.313-0.385,0.405l-1.007,0.554c-0.017,0.01-0.035,0.019-0.053,0.027l-1.047,0.491 l-0.155,0.109l-0.358,0.457l-0.143,0.235l-0.03,0.327l0.314,0.328c0.119,0.124,0.2,0.278,0.237,0.445l0.532,2.47 c0.022,0.103,0.027,0.209,0.013,0.314l-0.097,0.753l0.027,0.311l0.028,0.15l0.517,0.533c0.069,0.071,0.126,0.152,0.169,0.241 l0.354,0.732c0.055,0.114,0.086,0.239,0.091,0.366l0.025,0.625l0.062,0.409l0.429,1.456c0.082,0.277,0.03,0.576-0.141,0.809 c-0.17,0.233-0.439,0.373-0.728,0.379l-1.305,0.028c-0.007,0-0.013,0-0.02,0c-0.067,0-0.134-0.007-0.2-0.022l-0.413-0.091 l-0.63,0.002l-0.149,0.111l-0.371,0.355c-0.077,0.074-0.167,0.134-0.265,0.178l-3.098,1.371c-0.057,0.025-0.117,0.045-0.178,0.058 l-0.705,0.153l-0.625,0.335l-0.293,0.611c-0.03,0.063-0.068,0.123-0.112,0.178l-0.431,0.54c-0.126,0.158-0.301,0.271-0.498,0.32 l-0.789,0.199c-0.054,0.013-0.108,0.022-0.163,0.026l-0.562,0.038l-0.495,0.106l-0.51,0.271l-0.631,0.673 c-0.049,0.052-0.104,0.099-0.164,0.138l-1.581,1.05l-2.14,2.124c-0.174,0.173-0.409,0.269-0.653,0.269 c-0.021,0-0.042-0.001-0.062-0.002l-1.419-0.096c-0.051-0.003-0.101-0.011-0.15-0.023l-2.071-0.488l-0.148,0.102l-0.797,1.643 c-0.014,0.029-0.03,0.057-0.047,0.085l-0.598,0.963c-0.021,0.033-0.044,0.066-0.069,0.096l-1.145,1.406 c-0.023,0.028-0.047,0.054-0.072,0.079l-0.813,0.792l-0.203,0.265l-0.004,0.099l0.046,0.471c0.014,0.142-0.006,0.285-0.056,0.418 l-0.39,1.026c-0.02,0.052-0.045,0.103-0.074,0.151l-0.898,1.48c-0.023,0.038-0.048,0.074-0.076,0.108l-2.896,3.524l-0.514,1.224 c-0.034,0.08-0.078,0.155-0.133,0.222l-0.201,0.249l-0.029,0.089c-0.018,0.055-0.04,0.107-0.068,0.158l-0.203,0.373 c-0.088,0.161-0.221,0.292-0.383,0.378l-0.365,0.192c-0.133,0.07-0.281,0.106-0.431,0.106c-0.024,0-0.048-0.001-0.072-0.003 l-1.314-0.103c-0.205-0.016-0.399-0.1-0.552-0.239l-0.112-0.102l-0.97,2.361c-0.016,0.04-0.035,0.078-0.057,0.115l-1.002,1.714 c-0.017,0.029-0.036,0.058-0.056,0.085l-3.261,4.388l-0.47,1.384l-0.23,1.732l-0.165,3.764c-0.001,0.031-0.004,0.062-0.009,0.093 l-0.225,1.545c-0.007,0.046-0.017,0.092-0.031,0.137l-0.451,1.476c-0.022,0.071-0.052,0.14-0.09,0.204l-1.352,2.268 c-0.05,0.084-0.113,0.159-0.186,0.223l-0.824,0.719c-0.033,0.029-0.068,0.056-0.105,0.08l-2.111,1.368l-1.063,1.105 c-0.076,0.079-0.165,0.144-0.263,0.191l-1.266,0.614l-0.869,0.612l-0.368,0.482l-1.481,2.573l-0.993,2.827l3.623,1.168l2.085,0.283 c0.032,0.004,0.063,0.01,0.094,0.018l0.918,0.223c0.087,0.021,0.171,0.055,0.249,0.101l0.807,0.472 c0.069,0.041,0.133,0.09,0.19,0.147l0.559,0.563c0.05,0.051,0.094,0.107,0.132,0.167l0.424,0.689 c0.03,0.048,0.055,0.099,0.075,0.152l1.266,3.28l0.58,0.843l0.762,0.731l0.829,0.6c0.098,0.071,0.181,0.161,0.245,0.264l0.562,0.91 c0.089,0.144,0.137,0.309,0.138,0.479l0.014,1.637c0.001,0.079-0.009,0.157-0.028,0.233l-2.519,10.044l-0.289,2.199l-0.052,1.336 l0.168,1.456l0.368,1.124l0.633,0.991l2.72,3.043c0.026,0.029,0.049,0.059,0.071,0.09l0.702,1.015 c0.029,0.041,0.054,0.085,0.075,0.13l0.455,0.961c0.052,0.11,0.082,0.228,0.088,0.349l0.047,0.928 c0.006,0.119-0.011,0.238-0.05,0.35l-0.296,0.855c-0.032,0.093-0.079,0.18-0.138,0.258l-0.694,0.911 c-0.018,0.024-0.038,0.047-0.058,0.069l-0.978,1.054l-0.734,1.018l-0.395,1.112l-0.017,1.335l0.392,1.899l0.909,1.973l1.417,1.792 l1.598,1.104l26.864,9.481l1.134,0.134l1.612,0.027l4.294-0.336c0.024-0.002,0.048-0.003,0.072-0.003 c0.051,0,0.102,0.004,0.152,0.013l3.226,0.538l0.097-0.121l0.136-21.783l-0.101-5.811c-0.001-0.049,0.002-0.097,0.009-0.145 l0.26-1.842c0.025-0.18,0.103-0.348,0.223-0.484l0.24-0.271l0.316-0.724c0.036-0.082,0.083-0.158,0.14-0.226l0.386-0.459 l0.056-0.086l-0.052-0.156c-0.034-0.101-0.05-0.206-0.048-0.313l0.01-0.491c0.005-0.235,0.098-0.459,0.262-0.628l0.366-0.376 c0.044-0.045,0.092-0.086,0.144-0.121l0.544-0.368c0.046-0.031,0.095-0.058,0.146-0.081l0.386-0.17 c0.118-0.052,0.246-0.079,0.374-0.079c0.059,0,0.119,0.006,0.178,0.017l0.254,0.05c0.381,0.074,0.675,0.379,0.737,0.762l0.026,0.16 l1.129-0.706c0.147-0.092,0.318-0.141,0.491-0.141c0.008,0,0.015,0,0.022,0l0.285,0.007c0.28,0.007,0.542,0.14,0.713,0.363 l0.199,0.26c0.028,0.037,0.054,0.076,0.077,0.117l0.33,0.6l0.944-0.123c0.04-0.005,0.08-0.008,0.12-0.008 c0.077,0,0.153,0.009,0.228,0.028l0.24,0.061l0.134-0.679c0.077-0.391,0.395-0.688,0.79-0.739c0.04-0.005,0.08-0.008,0.119-0.008 c0.351,0,0.677,0.2,0.833,0.522l0.515,1.06c0.052,0.108,0.083,0.225,0.091,0.343c0.005,0,0.01,0,0.016,0l0.775-0.014 c0.006,0,0.011,0,0.017,0c0.167,0,0.33,0.045,0.474,0.13l0.072,0.043l0.164-0.229c0.165-0.23,0.425-0.372,0.708-0.385l0.538-0.026 c0.015-0.001,0.03-0.001,0.045-0.001c0.244,0,0.478,0.096,0.652,0.268l0.234,0.232l0.357-0.125 c0.099-0.035,0.202-0.052,0.306-0.052c0.107,0,0.213,0.018,0.315,0.055l0.899,0.325l0.534-0.117 c0.043-0.009,0.087-0.016,0.131-0.019l0.389-0.028c-0.014-0.09-0.014-0.182-0.001-0.274l0.041-0.278 c0.044-0.295,0.226-0.551,0.491-0.687l1.453-0.751c0.133-0.069,0.279-0.103,0.425-0.103c0.118,0,0.237,0.023,0.349,0.068 l0.534,0.218l0.91-0.128c0.043-0.006,0.086-0.009,0.129-0.009c0.121,0,0.241,0.024,0.354,0.07l0.275,0.113 c0.172,0.071,0.318,0.192,0.42,0.347c0.045-0.222,0.17-0.423,0.356-0.56l0.27-0.201c0.161-0.12,0.355-0.183,0.552-0.183 c0.08,0,0.161,0.01,0.24,0.032l0.353,0.095c0.14,0.038,0.27,0.108,0.378,0.205l0.054,0.048l0.301-0.282 c0.022-0.021,0.045-0.04,0.069-0.059l0.924-0.711c0.083-0.064,0.177-0.114,0.278-0.146l0.71-0.232 c0.093-0.03,0.19-0.046,0.287-0.046c0.007,0,0.014,0,0.021,0l0.424,0.01c0.204,0.005,0.401,0.077,0.56,0.204l0.025,0.02 l0.224-0.134l0.916-0.725c0.053-0.042,0.11-0.078,0.171-0.107l0.573-0.278l0.173-0.263c0.039-0.059,0.084-0.113,0.134-0.161 l0.402-0.385c0.121-0.116,0.271-0.196,0.434-0.234c-0.232-0.238-0.321-0.585-0.225-0.909l0.218-0.739 c0.071-0.241,0.238-0.443,0.461-0.56l0.54-0.281l0.109-0.231c0.014-0.031,0.03-0.06,0.048-0.089l0.375-0.614 c0.082-0.134,0.196-0.244,0.332-0.322l3.939-2.244c0.057-0.033,0.118-0.059,0.181-0.079l0.845-0.265 c0.09-0.028,0.183-0.042,0.277-0.042c0.043,0,0.085,0.003,0.128,0.009l0.509,0.071c0.26,0.036,0.492,0.181,0.639,0.398l0.357,0.527 l0.28,0.201c0.094,0.067,0.175,0.152,0.237,0.249l0.218,0.337l0.233,0.059l0.143-0.169l0.35-0.846 c0.051-0.123,0.128-0.234,0.226-0.325l0.53-0.492c0.127-0.117,0.283-0.197,0.453-0.23l1.502-0.293 c0.059-0.011,0.118-0.017,0.177-0.017c0.137,0,0.273,0.03,0.398,0.09l0.586,0.279c0.148,0.07,0.272,0.177,0.363,0.308 c0.038-0.053,0.082-0.102,0.131-0.146l0.661-0.595c0.175-0.157,0.396-0.238,0.62-0.238c0.162,0,0.325,0.043,0.472,0.129 l0.298,0.176c0.04-0.168,0.126-0.322,0.249-0.444l0.544-0.539c0.019-0.019,0.038-0.036,0.059-0.053 c-0.094-0.196-0.117-0.42-0.062-0.632l0.117-0.454c0.106-0.41,0.476-0.695,0.897-0.695c0.012,0,0.024,0,0.037,0.001l0.296,0.012 c0.126,0.005,0.25,0.036,0.363,0.09l0.305,0.146l0.246,0.058l0.425,0.035c0.076,0.006,0.15,0.021,0.221,0.046l0.709-0.571 c0.064-0.052,0.135-0.095,0.211-0.128l0.417-0.182c0.098-0.043,0.202-0.068,0.309-0.075l1.525-0.102l0.615-0.134l0.526-0.307 l1.731-1.521c0.149-0.131,0.336-0.21,0.533-0.227l0.809-0.069c0.026-0.002,0.052-0.003,0.078-0.003 c0.164,0,0.326,0.044,0.469,0.127l0.781,0.458c0.011-0.02,0.022-0.04,0.035-0.06l0.386-0.609c0.146-0.231,0.386-0.385,0.657-0.422 l0.518-0.071c0.042-0.006,0.084-0.009,0.126-0.009c0.247,0,0.486,0.099,0.661,0.278l0.141,0.144 c0.068-0.146,0.173-0.272,0.305-0.365l0.625-0.442c0.03-0.021,0.061-0.041,0.094-0.058l0.598-0.324 c0.063-0.034,0.13-0.061,0.2-0.08l0.596-0.161c0.007-0.002,0.015-0.004,0.022-0.006l0.002-0.037l-0.153-0.661 c-0.012-0.051-0.019-0.104-0.022-0.157l-0.05-0.88c-0.007-0.124,0.011-0.248,0.053-0.364l0.229-0.639 c0.08-0.223,0.242-0.407,0.454-0.514l0.532-0.269c0.081-0.041,0.169-0.07,0.258-0.086l1.704-0.298l0.902-0.283 c0.09-0.028,0.184-0.043,0.277-0.043c0.099,0,0.198,0.016,0.293,0.048l0.658,0.22c0.218,0.073,0.402,0.224,0.514,0.425l0.524,0.933 l0.357,0.272l0.805,0.215l1.669,0.141c0.192,0.016,0.375,0.092,0.522,0.217l0.044,0.037c0.026-0.002,0.053-0.003,0.08-0.003 s0.055,0.001,0.083,0.004c0.274,0.025,0.522,0.169,0.679,0.395l0.129,0.186l0.45-0.13c0.032-0.009,0.064-0.017,0.096-0.022 l0.532-0.093c0.122-0.122,0.276-0.207,0.445-0.246l0.184-0.042c0.016-0.004,0.031-0.007,0.047-0.01l0.742-0.131l3.812-0.724 l0.703-0.339l0.32-0.383c0.068-0.081,0.149-0.15,0.24-0.204l0.625-0.368c0.143-0.084,0.306-0.128,0.47-0.128 c0.042,0,0.084,0.003,0.127,0.009l0.361,0.05c0.235,0.032,0.449,0.154,0.597,0.339l-0.003-0.088 c-0.007-0.21,0.057-0.417,0.183-0.585l0.225-0.302c0.176-0.237,0.453-0.373,0.743-0.373c0.047,0,0.094,0.004,0.141,0.011 l0.369,0.057c0.191,0.029,0.369,0.118,0.507,0.253l1.533,1.5l0.104,0.031l0.038-0.019l0.233-0.279 c0.021-0.025,0.044-0.049,0.067-0.072l0.355-0.344c0.153-0.148,0.352-0.239,0.563-0.257l0.283-0.025 c0.027-0.002,0.054-0.004,0.081-0.004c0.336,0,0.648,0.183,0.812,0.481l0.154,0.28c0.088,0.16,0.126,0.343,0.111,0.525l-0.073,0.84 l0.101,0.017l1.544-0.705l0.338-0.342l0.306-0.391c0.117-0.15,0.278-0.26,0.46-0.315l0.502-0.153 c0.084-0.026,0.171-0.039,0.259-0.04l0.571-0.006l1.134-0.168c0.045-0.007,0.09-0.01,0.136-0.01c0.057,0,0.114,0.005,0.171,0.016 l0.906,0.17c0.039,0.007,0.076,0.017,0.114,0.029l0.711,0.23l0.367-0.603c0.168-0.277,0.469-0.445,0.791-0.445 c0.011,0,0.022,0,0.034,0.001l0.392,0.014c0.166,0.006,0.328,0.057,0.468,0.147l1.478,0.952l0.349,0.156l0.062-0.223 c0.036-0.129,0.1-0.249,0.187-0.351l0.279-0.327c0.177-0.208,0.435-0.326,0.705-0.326c0.029,0,0.059,0.001,0.088,0.004l0.42,0.04 c0.181,0.017,0.353,0.088,0.495,0.202l0.13,0.105l0.142-0.608c0.024-0.103,0.066-0.201,0.123-0.29l0.261-0.405 c0.171-0.265,0.464-0.425,0.779-0.425h0.46c0.236,0,0.463,0.09,0.635,0.252l0.378,0.356c0.119,0.112,0.206,0.252,0.252,0.408 l0.159,0.529l0.166,0.281l0.01,0.007l0.521,0.004c0.101,0.001,0.201,0.018,0.296,0.051l0.439,0.153 c0.049,0.017,0.097,0.039,0.143,0.064l0.373,0.206l0.07,0.003l0.24-0.08l1.441-1.075c0.161-0.12,0.355-0.184,0.554-0.184 c0.047,0,0.095,0.004,0.142,0.011l0.411,0.064c0.131,0.02,0.256,0.068,0.367,0.141l0.509,0.334c0.031,0.02,0.061,0.043,0.089,0.067 l0.239,0.202l0.176-0.192c0.179-0.195,0.428-0.3,0.683-0.3c0.104,0,0.208,0.017,0.309,0.053l0.35,0.124 c0.031,0.011,0.061,0.023,0.09,0.037l0.522,0.25l-0.001-21.714l0.149-69.295L364.735,354.593z").attr({id: 'meta', class: 'st6', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#BC9191'}).data({'id': 'meta', 'region':'Meta', 'benefited-companies':'3', 'benefited-projects': '$60.000.000'});

        var casanare = rsr.path("M307.717,292.892l-1.01-1.703c-0.051-0.086-0.088-0.18-0.109-0.278l-0.146-0.682l-0.406,0.657 l-0.838,2.706l-0.002,0.028l0.302,0.164c0.095,0.052,0.181,0.119,0.252,0.2l0.258,0.292c0.1,0.113,0.171,0.249,0.207,0.396 l0.24,0.991l0.248,0.532c0.022,0.048,0.041,0.098,0.055,0.149l0.14,0.519l0.182,0.367l1.272,1.283 c0.204,0.206,0.3,0.495,0.259,0.781l-0.125,0.888c-0.015,0.107-0.049,0.211-0.1,0.307l-0.58,1.088l-0.379,2.17 c-0.006,0.036-0.015,0.073-0.026,0.108l-1.02,3.383c-0.011,0.037-0.025,0.073-0.04,0.108l-0.162,0.364 c-0.122,0.275-0.371,0.474-0.666,0.533l-0.957,0.19l-0.509,0.202l-0.262,0.221l-0.027,0.033v0.031l3.902,2.089 c0.037,0.02,0.073,0.043,0.107,0.067l1.837,1.335c0.161,0.117,0.28,0.283,0.34,0.474l0.249,0.799l0.674,0.518 c0.074,0.057,0.139,0.125,0.193,0.202l0.985,1.402l0.968,0.819c0.207,0.175,0.327,0.431,0.328,0.702s-0.116,0.529-0.32,0.706 l-0.685,0.592c-0.083,0.072-0.178,0.128-0.28,0.166l-0.103,0.039l-0.104,0.119l-0.123,0.228l-0.119,0.682 c-0.006,0.032-0.013,0.064-0.022,0.095l-0.179,0.627c-0.008,0.027-0.017,0.054-0.027,0.08l-0.198,0.512 c-0.054,0.139-0.141,0.264-0.253,0.362l-0.465,0.408l-0.172,0.325l-0.116,0.29l-0.577,3.066c-0.039,0.205-0.145,0.391-0.303,0.528 l-0.328,0.285c-0.17,0.148-0.386,0.227-0.607,0.227c-0.073,0-0.147-0.009-0.22-0.027l-0.378-0.092 c-0.095-0.023-0.185-0.061-0.268-0.113l-0.609-0.378c-0.026-0.016-0.052-0.034-0.076-0.053l-1.008-0.775 c-0.039-0.03-0.075-0.063-0.109-0.099l-0.299-0.317c-0.057-0.06-0.105-0.127-0.144-0.2l-0.387-0.726l-0.078-0.115l-0.152,0.071 l-0.944,1.099l-5.003,5.382l-0.919,1.577c-0.008,0.014-0.016,0.027-0.025,0.041l-0.648,0.99c-0.081,0.123-0.189,0.225-0.317,0.298 l-1.831,1.042l-2.573,2.336c-0.171,0.155-0.393,0.24-0.623,0.24c-0.026,0-0.052-0.001-0.077-0.003l-0.887-0.074 c-0.261-0.022-0.501-0.153-0.659-0.362l-1.219-1.6l-0.772-0.631c-0.069-0.056-0.129-0.122-0.179-0.196l-1.052-1.545l-0.184-0.204 l-0.228-0.1l-0.614,0.493c-0.029,0.023-0.059,0.045-0.091,0.064l-0.437,0.271l-0.597,0.514l-0.689,0.753l-2.507,3.533 c-0.022,0.031-0.045,0.06-0.07,0.087l-0.1,0.11l0.124,1.207c0.027,0.268-0.063,0.535-0.248,0.73l-0.251,0.266l-0.047,0.094 l-0.105,0.297l-0.194,0.87l-0.009,0.377l0.14,0.411l0.326,0.547l1.002,0.797c0.088,0.07,0.163,0.156,0.221,0.253l0.343,0.581 c0.167,0.283,0.172,0.634,0.012,0.921l-0.651,1.171l-0.224,0.952c-0.017,0.074-0.044,0.145-0.078,0.212l-0.263,0.509 c-0.05,0.097-0.117,0.185-0.198,0.259l-0.744,0.68l-1.047,1.165c-0.18,0.2-0.432,0.307-0.689,0.307 c-0.123,0-0.247-0.025-0.365-0.075l-1.423-0.611l-0.617,2.608l-0.133,1.997c-0.006,0.091-0.025,0.18-0.058,0.266l-0.727,1.925 l-0.067,0.564l0.83,2.45c0.054,0.16,0.063,0.331,0.027,0.496l-0.139,0.634l0.225,1.03l0.14,0.262l1.999,1.951 c0.066,0.064,0.122,0.138,0.166,0.219l3.049,5.59l3.703,3.941l0.241-0.018c0.022-0.002,0.045-0.002,0.067-0.002 c0.081,0,0.161,0.011,0.24,0.032l0.238,0.064c0.133,0.036,0.257,0.101,0.362,0.19l0.199,0.17c0.213,0.182,0.332,0.45,0.324,0.729 l0.013,0.03l0.701,0.773c0.077,0.085,0.137,0.182,0.178,0.289l0.142,0.367c0.036,0.093,0.057,0.191,0.061,0.291l0.002,0.033 l0.128,0.177c0.1,0.139,0.159,0.301,0.172,0.47c0.017-0.001,0.035-0.001,0.052-0.001c0.141,0,0.281,0.032,0.408,0.095l0.34,0.167 c0.276,0.135,0.467,0.399,0.509,0.704l0.052,0.373l0.116,0.805l0.544,0.305l0.036,0.011l0.078-0.013l0.026-0.018l0.562-0.548 c0.084-0.082,0.182-0.147,0.29-0.192l0.374-0.156c0.113-0.047,0.234-0.071,0.357-0.071c0.02,0,0.04,0.001,0.06,0.002l0.434,0.028 c0.034,0.002,0.069,0.006,0.103,0.012l1.598,0.286c0.075-0.075,0.163-0.136,0.259-0.181l0.129-0.06 c0.125-0.058,0.259-0.088,0.393-0.088c0.138,0,0.276,0.031,0.404,0.093l0.322,0.156c0.028,0.014,0.056,0.029,0.083,0.046 l0.636-1.119c0.038-0.066,0.084-0.128,0.136-0.183l0.258-0.27c0.176-0.184,0.418-0.286,0.669-0.286 c0.043,0,0.086,0.003,0.129,0.009l0.506,0.071c0.037,0.005,0.074,0.013,0.11,0.022l0.677,0.181 c0.043,0.011,0.084,0.026,0.125,0.043l0.59,0.252c0.128,0.055,0.243,0.138,0.334,0.243l0.253,0.291 c0.029,0.033,0.055,0.068,0.079,0.105l0.11,0.169l0.337-0.089l2.058-1.176c0.143-0.082,0.301-0.122,0.459-0.122 c0.19,0,0.379,0.058,0.54,0.174l0.669,0.48l0.756,0.104l0.499-0.128l1.776-2.738c0.096-0.148,0.232-0.266,0.393-0.339l0.618-0.282 c0.06-0.027,0.123-0.048,0.188-0.062l7.307-1.585c0.058-0.013,0.118-0.02,0.177-0.021l0.52-0.011c0.006,0,0.013,0,0.019,0 c0.108,0,0.215,0.019,0.317,0.056l0.489,0.178c0.063,0.023,0.123,0.052,0.179,0.088l1.761,1.116 c0.127,0.081,0.233,0.191,0.308,0.322l0.341,0.595l0.286,0.363l0.383,0.115l1.336-0.37l1.589-0.96l3.379-2.825l3.519-3.836 c0.035-0.038,0.074-0.074,0.115-0.106l0.458-0.355c0.122-0.095,0.265-0.157,0.417-0.182l0.476-0.078 c0.05-0.008,0.1-0.012,0.15-0.012c0.015,0,0.03,0,0.045,0.001l0.449,0.022l0.408-0.033l3.927-1.214l1.809-0.891l3.526-2.415 c0.049-0.034,0.102-0.063,0.157-0.087l13.264-5.709c0.072-0.031,0.149-0.053,0.227-0.065l2.407-0.367l0.167-0.168 c0.028-0.028,0.058-0.054,0.089-0.078l2.238-1.735c0.029-0.022,0.058-0.043,0.089-0.061l1.258-0.758 c0.032-0.019,0.064-0.036,0.098-0.051l0.774-0.348c0.052-0.024,0.107-0.042,0.163-0.056l0.528-0.127l0.365-0.157l1.116-1.029 l0.473-0.432l0.863-1.172l3.007-7.165c0.039-0.092,0.092-0.178,0.159-0.253l0.707-0.803c0.12-0.136,0.277-0.234,0.452-0.282 l1.709-0.464l0.608-0.317l7.956-6.915c0.079-0.069,0.169-0.124,0.267-0.162l0.524-0.207l0.039-0.045l0.163-1.895 c0.004-0.049,0.012-0.097,0.024-0.144l0.208-0.835c0.044-0.176,0.139-0.336,0.272-0.459l0.756-0.694 c0.081-0.074,0.174-0.134,0.276-0.175l1.906-0.779l0.744-0.453l0.875-0.69c0.042-0.033,0.087-0.063,0.134-0.088l2.975-1.606 l2.902-2.165c0.074-0.056,0.157-0.1,0.244-0.131l0.926-0.328c0.06-0.021,0.122-0.036,0.184-0.045l0.932-0.127l2.762-1.098 c0.057-0.023,0.116-0.04,0.177-0.051l1.689-0.306c0.038-0.007,0.077-0.011,0.116-0.014l3.552-0.188l1.722-0.35l1.173-0.528 l1.433-0.885l1.338-1.043l0.94-0.992l1.459-2.241l0.223-0.579c0.045-0.117,0.113-0.223,0.2-0.312l1.846-1.899l0.697-1.189 l3.211-7.409c0.022-0.051,0.049-0.1,0.079-0.146l1.028-1.54c0.027-0.04,0.057-0.079,0.09-0.114l0.047-0.05l-0.281-0.122 c-0.133-0.058-0.251-0.146-0.343-0.258l-0.764-0.923c-0.129-0.156-0.204-0.351-0.212-0.554l-0.027-0.67l-0.033-0.107l-0.2-0.219 l-0.932-0.769l-0.757-0.426l-2.975-1.108c-0.098-0.036-0.189-0.089-0.269-0.156l-0.597-0.496c-0.109-0.091-0.196-0.205-0.254-0.334 l-0.237-0.53c-0.014-0.031-0.026-0.063-0.036-0.095l-0.141-0.439l-0.127-0.27l-0.147-0.136l-1.276-0.776 c-0.044-0.027-0.086-0.057-0.125-0.091l-0.362-0.313c-0.058-0.051-0.11-0.108-0.155-0.172l-0.474-0.682l-0.193-0.168l-1.279-0.565 l-0.526-0.115l-1.054-0.118l-1.466,0.02l-1.261,0.167c-0.039,0.005-0.079,0.008-0.118,0.008l-1.211,0.005c-0.001,0-0.002,0-0.003,0 c-0.03,0-0.06-0.001-0.09-0.004l-0.707-0.069c-0.065-0.006-0.128-0.019-0.19-0.039l-1.328-0.421l-0.733-0.062l-0.976,0.122 l-3.002,1.069l-1.867,0.898c-0.037,0.018-0.075,0.033-0.113,0.046l-0.946,0.31c-0.093,0.03-0.19,0.046-0.288,0.046 c-0.011,0-0.022,0-0.033-0.001l-1.668-0.059l-2.279,0.178l-3.485,0.596c-0.051,0.009-0.104,0.013-0.156,0.013 c-0.002,0-0.003,0-0.005,0l-2.532-0.012c-0.184-0.001-0.363-0.056-0.515-0.159l-0.164-0.111l-1.633-0.71l-0.536-0.085l-0.753,0.102 l-0.844,0.218l-1.002,0.362c-0.074,0.027-0.15,0.044-0.228,0.051l-0.488,0.046c-0.029,0.003-0.058,0.004-0.087,0.004 c-0.023,0-0.046-0.001-0.069-0.003l-4.361-0.324c-0.083-0.006-0.165-0.023-0.243-0.052l-3.204-1.147l-1.352-0.244l-2.388,0.062 c-0.008,0-0.016,0-0.024,0c-0.045,0-0.09-0.003-0.135-0.01l-1.062-0.157c-0.069-0.01-0.137-0.028-0.202-0.054l-1.36-0.531 l-1.042-0.188l-0.586,0.418c-0.158,0.113-0.346,0.173-0.538,0.173c-0.043,0-0.086-0.003-0.129-0.009l-0.633-0.089l-0.573,0.107 c-0.056,0.011-0.113,0.016-0.171,0.016c-0.053,0-0.107-0.005-0.16-0.014l-0.334-0.059l-0.194,0.049l-0.996,0.61 c-0.039,0.024-0.079,0.045-0.121,0.062l-1.66,0.706c-0.103,0.044-0.214,0.069-0.327,0.073l-1.326,0.052l-0.741,0.108l-0.603,0.209 l-0.612,0.281c-0.027,0.012-0.054,0.023-0.081,0.033l-1.781,0.621c-0.057,0.02-0.115,0.034-0.174,0.042l-1.175,0.167 c-0.043,0.006-0.087,0.009-0.131,0.009c-0.047,0-0.093-0.004-0.139-0.011l-0.892-0.136l-0.632,0.028l-1.294,0.301 c-0.069,0.016-0.139,0.024-0.21,0.024c-0.065,0-0.13-0.007-0.193-0.02l-0.668-0.143c-0.077-0.016-0.152-0.043-0.222-0.078 l-1.17-0.587l-0.181-0.058l-0.387,0.049l-0.904,0.342c-0.104,0.039-0.215,0.06-0.326,0.06l-3.357,0.007l-1.022,0.244l-4.894,1.791 c-0.076,0.028-0.155,0.045-0.235,0.053l-1.437,0.129c-0.028,0.003-0.055,0.004-0.083,0.004c-0.046,0-0.092-0.003-0.138-0.01 l-0.742-0.112l-0.77,0.004l-0.743,0.158l-2.53,1.178c-0.055,0.026-0.112,0.046-0.171,0.06l-2.289,0.558l-2.457,1.792 c-0.159,0.116-0.35,0.178-0.546,0.178c-0.005,0-0.01,0-0.015,0l-0.738-0.012c-0.055-0.001-0.109-0.007-0.163-0.017l-1.146-0.224 c-0.124-0.024-0.242-0.074-0.346-0.145l-1.395-0.957l-1.763-0.877c-0.031-0.016-0.062-0.033-0.091-0.052l-0.804-0.521 c-0.029-0.019-0.057-0.039-0.084-0.061l-0.655-0.538c-0.101-0.083-0.183-0.186-0.241-0.303l-1.041-2.092l-1.681-1.678 C307.805,293.02,307.756,292.959,307.717,292.892z").attr({id: 'casanare' ,class: 'st7', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#FF1BB3'}).data({'id': 'casanare', 'region':'Casanare', 'benefited-companies':'7', 'benefited-projects': '$180.000.000'});

        var bolivar = rsr.path("M160.135,107.141l1.47-0.816c0.141-0.078,0.296-0.116,0.449-0.116 c0.23,0,0.458,0.086,0.634,0.251c0.294,0.275,0.376,0.709,0.203,1.072l-0.15,0.316l-0.02,0.232l0.007,0.416 c0.001,0.04-0.001,0.079-0.006,0.119l-0.059,0.525c-0.006,0.054-0.017,0.108-0.033,0.161l-0.154,0.517 c-0.017,0.058-0.04,0.114-0.068,0.167l-0.143,0.272c-0.016,0.03-0.034,0.06-0.053,0.088l-0.283,0.417l-0.447,0.969 c-0.023,0.049-0.049,0.096-0.08,0.14l-0.177,0.255c-0.018,0.026-0.038,0.051-0.058,0.075l2.503-1.355 c0.139-0.075,0.29-0.112,0.441-0.112c0.243,0,0.484,0.096,0.663,0.279c0.289,0.296,0.347,0.747,0.142,1.107l-2.059,3.608 l-0.037,0.131l0.051,0.002l0.59-0.201c0.069-0.023,0.14-0.039,0.212-0.045l0.804-0.075c0.029-0.003,0.058-0.004,0.086-0.004 c0.225,0,0.443,0.082,0.613,0.232c0.192,0.169,0.305,0.41,0.313,0.666l0.047,1.555l0.064,0.38l0.334,0.765 c0.046,0.106,0.072,0.219,0.077,0.335l0.016,0.414c0.005,0.123-0.015,0.246-0.058,0.361l-0.172,0.46 c-0.031,0.084-0.075,0.163-0.129,0.235l-0.466,0.615l0.661,0.316l3.528,1.204l0.213,0.038l0.286-0.177 c0.147-0.091,0.317-0.14,0.489-0.14c0.024,0,0.049,0.001,0.073,0.003l0.968,0.077c0.47,0.037,0.837,0.422,0.852,0.893l0.023,0.715 c0.004,0.123-0.016,0.245-0.06,0.36l-0.269,0.706l-0.319,1.215l0.163,0.926c0.018,0.102,0.019,0.207,0.002,0.31l-0.118,0.722 c-0.008,0.047-0.019,0.094-0.034,0.14l-0.459,1.397l-0.164,0.718l-0.041,0.769c-0.002,0.037-0.006,0.074-0.013,0.111l-0.115,0.661 c-0.021,0.117-0.064,0.23-0.127,0.331l-0.262,0.42l-0.019,0.092l0.33,0.13l0.318-0.285l0.287-0.323 c0.089-0.1,0.199-0.18,0.322-0.234l0.593-0.259c0.117-0.051,0.243-0.077,0.37-0.077c0.031,0,0.062,0.002,0.093,0.005l0.675,0.068 c0.072,0.007,0.143,0.023,0.212,0.047l0.823,0.287c0.085,0.029,0.164,0.071,0.237,0.123l1.16,0.837l0.214,0.025l0.396-0.099 c0.074-0.018,0.149-0.028,0.225-0.028c0.029,0,0.057,0.001,0.086,0.004l0.542,0.05c0.093,0.009,0.184,0.031,0.27,0.067l0.682,0.284 c0.083,0.035,0.161,0.082,0.231,0.139l1.829,1.498c0.048,0.04,0.092,0.084,0.132,0.132l0.91,1.119l1.834,1.656l0.26,0.178 l1.077,0.031c0.07,0.002,0.139,0.012,0.207,0.03l1.361,0.355c0.262,0.068,0.48,0.247,0.599,0.49 c0.118,0.243,0.125,0.525,0.017,0.774l-0.783,1.81l0.366,0.163l0.619,0.108l0.769-0.189l0.502-0.207 c0.08-0.033,0.164-0.054,0.25-0.064l0.355-0.04c0.034-0.004,0.069-0.006,0.103-0.006c0.376,0,0.719,0.229,0.861,0.585l0.033,0.084 l0.165,0.214l0.753,0.522l0.337,0.167c0.149,0.074,0.275,0.186,0.365,0.326l0.217,0.335c0.215,0.331,0.196,0.762-0.047,1.074 l-0.187,0.239l-0.529,0.899l-0.885,1.975l0.147,0.192c0.179,0.233,0.236,0.536,0.156,0.818l-0.206,0.72l0.026,0.302l0.171,0.708 l0.573,1.234c0.028,0.061,0.05,0.126,0.065,0.192l0.436,1.991c0.013,0.058,0.02,0.117,0.021,0.176l0.012,0.529l0.084,0.449 l0.065,0.128l0.235,0.185l0.329,0.156c0.074,0.035,0.143,0.079,0.205,0.132l0.817,0.697c0.095,0.081,0.173,0.181,0.229,0.293 l0.849,1.711l0.741,1.425l1.674,1.089l1.159,0.454c0.081,0.032,0.157,0.075,0.226,0.127l4.382,3.36 c0.046,0.035,0.088,0.074,0.126,0.117l2.151,2.4c0.03,0.034,0.058,0.07,0.083,0.107l2.262,3.421l0.548,0.555 c0.056,0.057,0.104,0.12,0.144,0.19l0.27,0.471c0.08,0.139,0.122,0.295,0.123,0.455l0.002,0.362 c0.001,0.225-0.079,0.444-0.227,0.614l-0.252,0.29c-0.025,0.028-0.051,0.055-0.079,0.08l-0.225,0.203l-0.512,0.961 c-0.054,0.102-0.127,0.193-0.215,0.268l-1.01,0.864l-0.228,0.529l0.734,4.97l0.402,1.091l0.398,0.372 c0.27,0.252,0.363,0.641,0.239,0.989l-0.031,0.085l-0.011,0.791l0.123,1.206l0.394,1.527c0.011,0.043,0.019,0.087,0.024,0.131 l0.09,0.82c0.011,0.103,0.005,0.206-0.018,0.307l-0.123,0.538c-0.009,0.04-0.021,0.079-0.035,0.117l-0.653,1.756 c-0.017,0.046-0.038,0.09-0.062,0.133l-0.315,0.557c-0.165,0.292-0.474,0.47-0.806,0.47c-0.029,0-0.058-0.001-0.087-0.004 l-0.559-0.053l-0.075,0.569c-0.012,0.09-0.037,0.177-0.074,0.259l-0.485,1.078c-0.037,0.083-0.086,0.16-0.146,0.228l-0.689,0.792 c-0.05,0.058-0.108,0.109-0.171,0.153l-0.964,0.669c-0.072,0.05-0.151,0.09-0.235,0.118l-1.054,0.352 c-0.078,0.026-0.159,0.041-0.24,0.046l-1.193,0.068c-0.018,0.001-0.035,0.002-0.053,0.002c-0.027,0-0.054-0.001-0.082-0.004 l-1.35-0.119l-0.112,0.036l-0.82,0.696c-0.028,0.024-0.057,0.045-0.087,0.066l-0.404,0.268c-0.103,0.068-0.218,0.116-0.34,0.139 l-0.182,0.034c0.064,0.17,0.077,0.356,0.036,0.533l-0.078,0.341c-0.038,0.164-0.119,0.315-0.236,0.436l-0.637,0.661l-0.196,0.271 l-0.109,0.201l-0.024,0.379c-0.007,0.113-0.035,0.224-0.082,0.327l-0.029,0.063l10.193,8.333c0.087,0.071,0.16,0.157,0.216,0.254 l0.81,1.405l0.775,1.119l0.452,0.503c0.083,0.092,0.146,0.2,0.186,0.317l0.456,1.32c0.022,0.065,0.037,0.131,0.045,0.199 l0.505,4.516l0.347,1.152l0.36,0.585l0.378,0.216c0.027,0.016,0.054,0.033,0.08,0.051l0.533,0.382 c0.144,0.103,0.255,0.246,0.321,0.41l0.229,0.575c0.06,0.151,0.079,0.316,0.056,0.477l-0.119,0.815 c-0.016,0.107-0.05,0.211-0.102,0.306l-0.709,1.312c-0.047,0.088-0.108,0.167-0.181,0.235l-0.83,0.78 c-0.044,0.041-0.092,0.079-0.144,0.111l-0.964,0.601l-0.775,0.613l-0.432,0.835l-0.571,3.543l0.031,1.296l0.168,1.011l0.779,1.771 l1.428,1.777l0.728,0.67l0.445,0.12l0.476-0.085l0.788-0.685l0.461-0.545l0.711-1.837c0.022-0.057,0.05-0.112,0.083-0.164 l0.524-0.822c0.056-0.087,0.125-0.164,0.206-0.228l1.829-1.447c0.166-0.131,0.369-0.2,0.575-0.2c0.093,0,0.187,0.014,0.278,0.043 c0.293,0.092,0.521,0.323,0.609,0.617l0.774,2.576c0.043,0.143,0.051,0.295,0.022,0.442l-0.22,1.136 c-0.01,0.05-0.023,0.099-0.041,0.147l-0.279,0.75c-0.034,0.09-0.081,0.175-0.141,0.251l-0.442,0.561 c-0.018,0.023-0.037,0.045-0.057,0.066l-0.879,0.921l-0.201,0.403l-0.119,0.694l0.166,0.922c0.01,0.056,0.015,0.112,0.015,0.168 l-0.008,1.857c0,0.086-0.013,0.172-0.037,0.254l-0.41,1.413l0.034,0.888l0.275,1.28l0.748,1.75c0.016,0.038,0.03,0.078,0.041,0.118 l0.389,1.412l0.475,1.264c0.026,0.068,0.043,0.139,0.052,0.211l0.121,0.974l0.168,0.781l0.207,0.297l0.762,0.318l0.641,0.104 l1.207-0.115c0.029-0.003,0.058-0.004,0.088-0.004c0.065,0,0.13,0.007,0.194,0.021l0.373,0.082l14.146-13.466l0.227-1.585 c0.005-0.036,0.013-0.073,0.022-0.108l0.512-1.913c0.011-0.043,0.026-0.084,0.043-0.125l0.507-1.186l0.028-0.167l-0.03-0.156 l-0.324-0.482c-0.065-0.096-0.111-0.204-0.136-0.318l-0.098-0.445c-0.014-0.064-0.021-0.13-0.022-0.196l-0.006-1.804 c0-0.112,0.02-0.224,0.059-0.329l0.261-0.694c0.034-0.089,0.081-0.173,0.14-0.248l2.45-3.104l0.121-0.309 c0.086-0.22,0.253-0.398,0.466-0.499l0.229-0.109l0.048-0.151l-0.027-1.431c-0.001-0.079,0.007-0.158,0.026-0.234l0.099-0.41 c0.012-0.048,0.027-0.096,0.046-0.141l0.14-0.334l0.009-0.05l-0.056-0.122l-0.347-0.555c-0.134-0.215-0.175-0.475-0.112-0.72 l0.097-0.379c0.031-0.122,0.087-0.236,0.163-0.336l0.171-0.222l0.094-0.329l0.376-2.455l-0.05-0.845l-0.518-2.55l-0.095-0.172 l-0.325-0.305c-0.132-0.124-0.225-0.285-0.267-0.462l-0.647-2.742c-0.032-0.134-0.033-0.274-0.004-0.409l0.079-0.364l-0.712-2.314 c-0.02-0.064-0.033-0.131-0.038-0.198l-0.071-0.877c-0.004-0.047-0.004-0.094-0.001-0.141l0.064-0.878 c0.003-0.046,0.01-0.091,0.02-0.135l0.318-1.423c0.01-0.044,0.023-0.087,0.039-0.129l0.392-1.023 c-0.006-0.354,0.192-0.689,0.523-0.849l0.916-0.443c0.014-0.007,0.029-0.014,0.044-0.02l0.168-0.222l0.261-0.458 c0.047-0.082,0.106-0.157,0.175-0.221l0.423-0.392c0.098-0.091,0.215-0.16,0.343-0.201l0.256-0.083l0.1-0.105l-0.064-0.203 c-0.011-0.036-0.02-0.072-0.027-0.109l-0.123-0.664l-0.154-0.291c-0.049-0.093-0.082-0.193-0.097-0.297l-0.041-0.279 c-0.025-0.168-0.003-0.341,0.064-0.497l0.102-0.242c0.054-0.127,0.135-0.24,0.238-0.331l0.27-0.239l0.05-0.264 c0.013-0.067,0.033-0.133,0.06-0.196l0.367-0.846l0.059-0.298l0.021-1.071l-0.011-0.07c-0.028-0.174-0.006-0.353,0.063-0.515 l0.172-0.401c0.022-0.051,0.048-0.099,0.078-0.145l0.279-0.422l-0.019-0.07l-0.19-0.261c-0.069-0.094-0.119-0.2-0.148-0.313 l-0.116-0.446c-0.062-0.238-0.026-0.491,0.099-0.703l0.327-0.555l0.113-0.434l-0.317-3.003l-0.271-0.883l-0.971-1.756 c-0.045-0.082-0.078-0.17-0.097-0.262l-0.216-1.053c-0.012-0.061-0.019-0.123-0.019-0.186v-1.456l-0.072-0.242l-0.688-0.863 c-0.022-0.027-0.042-0.056-0.061-0.086l-0.314-0.501c-0.049-0.078-0.086-0.163-0.11-0.252l-0.244-0.913 c-0.019-0.071-0.03-0.145-0.031-0.219l-0.067-3.03c-0.002-0.069,0.005-0.137,0.018-0.204l0.195-0.962 c0.017-0.082,0.045-0.162,0.083-0.237l0.81-1.588l0.154-0.713l-0.145-0.941l-0.397-0.612l-1.494-1.362 c-0.044-0.04-0.084-0.084-0.119-0.132l-0.716-0.963c-0.04-0.054-0.074-0.112-0.102-0.174l-0.549-1.225 c-0.043-0.095-0.069-0.198-0.078-0.302l-0.113-1.361c-0.012-0.15,0.012-0.301,0.071-0.44l0.226-0.529l-0.284-0.125l-3.66-0.166 c-0.147-0.007-0.291-0.048-0.419-0.122l-1.463-0.839c-0.39-0.223-0.563-0.694-0.411-1.117l0.09-0.25l-0.015-0.02l-0.329-0.236 l-0.156,0.211c-0.153,0.207-0.386,0.341-0.643,0.369l-1.385,0.153c-0.034,0.004-0.068,0.006-0.102,0.006 c-0.073,0-0.147-0.009-0.218-0.026l-1.558-0.377c-0.047-0.011-0.093-0.027-0.138-0.045l-1.295-0.54 c-0.302-0.126-0.515-0.402-0.561-0.725c-0.023-0.163-0.002-0.325,0.057-0.473l-1.588-0.885c-0.111-0.062-0.208-0.146-0.285-0.246 l-0.692-0.905c-0.02-0.026-0.038-0.052-0.055-0.08l-1.061-1.734l-0.434-0.259l-1.529-0.056c-0.271-0.01-0.525-0.138-0.693-0.352 l-0.31-0.393c-0.117-0.148-0.186-0.329-0.198-0.518l-0.061-1.02l-0.087-0.118l-0.624-0.333l-0.868-0.278l-0.531-0.062l-0.206,0.07 l-0.293,0.193c-0.076,0.05-0.16,0.089-0.247,0.115l-0.413,0.122c-0.086,0.025-0.174,0.038-0.262,0.038 c-0.121,0-0.243-0.024-0.356-0.071l-0.577-0.24c-0.181-0.075-0.333-0.206-0.435-0.373l-0.254-0.416 c-0.045-0.074-0.079-0.153-0.102-0.236l-0.235-0.853l-0.895-0.087l-0.46,0.039l-0.43,0.212l-0.114,0.13l-0.159,0.273 c-0.044,0.077-0.1,0.146-0.164,0.207l-0.272,0.258c-0.145,0.137-0.33,0.224-0.528,0.247l-0.504,0.06 c-0.036,0.004-0.073,0.007-0.109,0.007c-0.109,0-0.217-0.019-0.32-0.057l-0.432-0.159c-0.098-0.036-0.189-0.088-0.269-0.155 l-0.404-0.334c-0.073-0.06-0.136-0.131-0.188-0.211l-0.295-0.455c-0.051-0.078-0.089-0.164-0.114-0.254l-0.356-1.269l-0.484-0.52 l-1.395-0.938c-0.029-0.02-0.057-0.041-0.084-0.064l-0.37-0.316c-0.045-0.038-0.086-0.081-0.123-0.127l-0.308-0.386 c-0.049-0.061-0.089-0.127-0.121-0.198l-0.209-0.465c-0.036-0.081-0.061-0.167-0.073-0.255l-0.063-0.462l-0.027-0.076l-0.079-0.07 l-0.571-0.332l-0.418,0.025c-0.019,0.001-0.037,0.002-0.056,0.002c-0.115,0-0.23-0.022-0.337-0.064l-0.269-0.105 c-0.168-0.066-0.314-0.18-0.418-0.327l-0.183-0.258c-0.054-0.076-0.095-0.159-0.124-0.247l-0.183-0.556l-0.038-0.057l-0.188-0.116 l-0.191-0.007l-0.354,0.122l-0.49,0.289c-0.147,0.087-0.31,0.129-0.47,0.129c-0.283,0-0.561-0.13-0.742-0.371l-0.878-1.174 l-0.866,0.132c-0.047,0.007-0.094,0.011-0.141,0.011c-0.449,0-0.844-0.328-0.914-0.785l-0.272-1.768 c-0.015-0.097-0.014-0.196,0.002-0.293l0.688-4.127c0.006-0.034,0.013-0.068,0.023-0.101l0.476-1.677l-0.04-0.27l-0.38-0.515 l-1.13-1.045c-0.064-0.06-0.12-0.128-0.165-0.204l-0.388-0.647c-0.062-0.103-0.103-0.216-0.121-0.334l-0.147-0.95 c-0.018-0.113-0.014-0.229,0.011-0.341l0.191-0.868c0.008-0.036,0.018-0.072,0.03-0.107l0.339-0.968l0.136-0.672l-0.116-0.311 l-1.421-1.327c-0.042-0.039-0.079-0.081-0.113-0.127l-0.418-0.566c-0.04-0.054-0.074-0.113-0.101-0.174l-0.406-0.916 c-0.029-0.066-0.051-0.135-0.064-0.205l-0.181-0.969c-0.009-0.051-0.015-0.102-0.016-0.153l-0.038-2.114 c-0.001-0.034,0.001-0.068,0.004-0.102l0.094-1.02c0.01-0.107,0.038-0.211,0.084-0.309l0.287-0.61 c0.06-0.127,0.147-0.238,0.256-0.327l0.486-0.393c0.05-0.04,0.104-0.075,0.161-0.105l1.546-0.789l0.301-0.214l0.117-0.266 l0.052-0.808l-0.195-0.078c-0.133-0.054-0.253-0.138-0.348-0.246l-0.147-0.167c-0.067-0.076-0.122-0.163-0.161-0.257l-0.548-1.313 l-0.295-0.384l-0.151-0.14l-0.077-0.053l-1.174-0.238c-0.075-0.015-0.148-0.04-0.217-0.073l-0.356-0.171 c-0.041-0.02-0.08-0.042-0.118-0.068l-0.791-0.535l-0.651-0.254c-0.122-0.048-0.233-0.121-0.325-0.215l-0.519-0.53 c-0.137-0.14-0.226-0.319-0.255-0.512l-0.195-1.307c-0.013-0.089-0.013-0.18-0.001-0.27l0.142-0.974 c0.011-0.074,0.03-0.147,0.059-0.216l0.588-1.446l0.288-1.512c0.016-0.086,0.045-0.168,0.084-0.246l0.038-0.076l-0.544-0.663 l-1.985-2.291l-1.009-0.844l-0.09-0.036l-0.667-0.161c-0.163-0.039-0.312-0.122-0.431-0.239l-1.731-1.697l-2.081,0.444 c-0.064,0.014-0.129,0.02-0.193,0.02c-0.314,0-0.611-0.16-0.783-0.432l-1.208-1.917l-0.487-0.285 c-0.217-0.127-0.373-0.337-0.432-0.581c-0.044-0.18-0.032-0.368,0.031-0.54l-0.528-0.092l-1.729-0.144 c-0.142-0.012-0.279-0.056-0.401-0.13l-0.287-0.173c-0.101-0.061-0.189-0.14-0.26-0.234l-0.183-0.241 c-0.104-0.137-0.167-0.299-0.184-0.469l-0.329-0.572c-0.049-0.085-0.084-0.178-0.104-0.274l-0.125-0.603 c-0.026-0.125-0.026-0.254,0.001-0.379l0.049-0.234c0.006-0.027,0.013-0.055,0.021-0.081l0.45-1.462l0.056-0.543 c0.024-0.234,0.136-0.45,0.313-0.604l0.435-0.379c0.052-0.046,0.11-0.085,0.171-0.118l0.241-0.129l0.032-0.711l-0.038-0.174 l-0.064-0.174l-0.045-0.078l-0.059-0.074l-0.821-0.679c-0.042-0.035-0.08-0.073-0.115-0.114l-0.264-0.311 c-0.092-0.108-0.157-0.235-0.192-0.373l-0.067-0.267c-0.015-0.061-0.025-0.123-0.027-0.186l-0.012-0.263 c-0.002-0.045-0.001-0.091,0.004-0.136l0.042-0.411c0.004-0.036,0.01-0.072,0.017-0.107l0.044-0.196 c0.005-0.022,0.011-0.044,0.017-0.066c-0.035,0.04-0.074,0.077-0.116,0.111l-0.453,0.363c-0.103,0.083-0.223,0.142-0.351,0.175 l-2.919,0.743l-0.907,0.423c-0.003,0.005-0.006,0.011-0.01,0.016l-0.29,0.484c-0.026,0.043-0.056,0.085-0.088,0.123l-0.351,0.414 c-0.024,0.028-0.049,0.054-0.075,0.079l-0.023,0.101c-0.073,0.328-0.319,0.59-0.641,0.686l-0.307,0.091 c-0.085,0.025-0.174,0.038-0.263,0.038c-0.025,0-0.05-0.001-0.075-0.003l-0.124-0.01c0.024,0.086,0.035,0.177,0.033,0.268 l-0.006,0.24c-0.006,0.243-0.106,0.474-0.281,0.643l-0.407,0.395c-0.053,0.052-0.113,0.097-0.177,0.135l-0.532,0.312 c-0.05,0.029-0.103,0.054-0.157,0.073l-0.572,0.204c-0.06,0.022-0.123,0.037-0.187,0.045l-0.283,0.038 c0.033,0.047,0.062,0.098,0.086,0.152l0.167,0.374c0.052,0.117,0.079,0.243,0.08,0.37l0.003,0.444l0.066,0.471 c0.019,0.14,0.007,0.281-0.036,0.414c0.083,0.046,0.159,0.105,0.225,0.175l0.189,0.2c0.133,0.141,0.219,0.32,0.245,0.512 l0.128,0.949c0.007,0.051,0.009,0.102,0.008,0.154l-0.037,1.164c-0.002,0.076-0.014,0.151-0.035,0.224l-0.28,0.986 c-0.059,0.206-0.187,0.385-0.363,0.507l-0.604,0.419c-0.158,0.11-0.343,0.165-0.528,0.165c-0.051,0-0.101-0.004-0.151-0.012 c0.158,0.151,0.263,0.357,0.283,0.59l0.089,1.023l0.236,1.201c0.01,0.049,0.015,0.099,0.017,0.149l0.034,1.043 c0.009,0.286-0.114,0.56-0.334,0.742l-0.528,0.438c-0.031,0.026-0.063,0.049-0.097,0.07l-1.65,1.042 c-0.087,0.055-0.183,0.095-0.283,0.119l-0.619,0.145c-0.02,0.095-0.055,0.187-0.105,0.273c-0.166,0.287-0.472,0.463-0.802,0.463 c-0.012,0-0.024,0-0.037-0.001l-0.018-0.001c0,0.07-0.008,0.14-0.025,0.209l-0.123,0.521c-0.03,0.126-0.085,0.244-0.164,0.348 l-0.203,0.267l1.393-0.927C160.092,107.166,160.113,107.153,160.135,107.141z").attr({id: 'bolivar', class: 'st8', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#822200'}).data({'id': 'bolivar', 'region':'Bolívar', 'benefited-companies':'6', 'benefited-projects': '$200.000.000'});

        var atlantico = rsr.path("M175.859,85.73l-0.208,0.295c-0.124,0.175-0.303,0.3-0.504,0.357l-0.013,0.131l0.003,0.075 l0.065,0.076l0.834,0.69c0.05,0.042,0.096,0.088,0.136,0.14l0.159,0.202c0.026,0.033,0.05,0.069,0.072,0.106l0.12,0.205 c0.028,0.048,0.052,0.099,0.071,0.151l0.113,0.311c0.014,0.038,0.025,0.077,0.034,0.117l0.078,0.353 c0.017,0.079,0.024,0.16,0.021,0.241l-0.044,0.981c-0.004,0.087-0.02,0.174-0.048,0.256l-0.105,0.31 c-0.038,0.111-0.096,0.213-0.171,0.302l-0.18,0.212c-0.075,0.088-0.166,0.162-0.268,0.217l-0.345,0.185l-0.081,0.07l-0.028,0.27 c-0.006,0.06-0.018,0.12-0.036,0.178l-0.465,1.509l-0.001,0.003l0.056,0.268l0.364,0.632c0.03,0.052,0.055,0.107,0.074,0.163 l1.45,0.121c0.028,0.002,0.055,0.006,0.083,0.011l0.783,0.137c0.035,0.006,0.07,0.014,0.105,0.025l0.58,0.173 c0.083,0.025,0.163,0.061,0.236,0.108l0.163,0.105c0.143,0.092,0.259,0.222,0.333,0.375l0.104,0.214 c0.047,0.098,0.077,0.203,0.088,0.311l0.013,0.13c0.012,0.116,0.002,0.232-0.029,0.343c0.082,0.065,0.153,0.143,0.209,0.232 l0.984,1.561l1.935-0.412c0.064-0.014,0.129-0.02,0.193-0.02c0.24,0,0.473,0.093,0.648,0.265l1.903,1.866l0.483,0.116 c0.043,0.01,0.085,0.024,0.126,0.04l0.289,0.115c0.091,0.036,0.176,0.087,0.251,0.15l1.18,0.987 c0.038,0.032,0.073,0.067,0.106,0.104l2.049,2.366l0.045,0.054l1.778-3.493c0.034-0.066,0.075-0.128,0.124-0.184l0.696-0.808 l0.445-0.659l0.208-0.794l0.24-2.08c0.012-0.105,0.042-0.208,0.089-0.303l0.828-1.683c0.069-0.141,0.174-0.262,0.303-0.352 l2.503-1.738l0.695-1.221l0.094-0.723l-0.124-2.904c-0.002-0.037-0.001-0.075,0.002-0.112l0.307-3.91l-0.033-0.81l-0.05-0.251 l-0.736-2.028c-0.026-0.072-0.043-0.146-0.051-0.222l-0.06-0.588c-0.009-0.086-0.005-0.172,0.01-0.257l0.19-1.062 c0.012-0.067,0.031-0.132,0.057-0.194l0.352-0.838l0.164-0.548l-0.088-0.429l-0.27-0.338l-0.451-0.398 c-0.059-0.052-0.11-0.111-0.154-0.175l-0.416-0.615c-0.075-0.11-0.125-0.235-0.147-0.366l-0.293-1.746l-0.255-0.461l-0.938-1.09 l-1.099-1.028l-0.587,0.492c-0.143,0.12-0.319,0.194-0.505,0.212l-1.552,0.151c-0.03,0.003-0.06,0.004-0.09,0.004 c-0.001,0-0.002,0-0.002,0l-0.46-0.001c-0.034,0.232-0.154,0.443-0.337,0.589l-1.043,0.836l-0.528,0.613 c-0.098,0.113-0.221,0.201-0.36,0.256l-0.875,0.347c-0.092,0.037-0.19,0.058-0.289,0.064l-0.673,0.038l-0.404,0.179l-0.147,0.097 l-0.036,0.077l-0.211,0.962c-0.013,0.058-0.031,0.114-0.054,0.169l-0.11,0.255l0.04,0.516c0.019,0.246-0.061,0.489-0.222,0.676 l-0.621,0.721c-0.067,0.078-0.147,0.144-0.235,0.196l-0.929,0.541c-0.077,0.045-0.16,0.079-0.247,0.1l-1.58,0.385l-2.758,1.844 c-0.054,0.036-0.111,0.066-0.171,0.09l-0.496,0.198c-0.04,0.016-0.081,0.029-0.124,0.04l-0.511,0.125 c-0.048,0.012-0.097,0.02-0.146,0.024l-0.377,0.03l-0.144,0.059l-0.095,0.117c0.002,0.011,0.004,0.023,0.006,0.034l0.169,1.136 c0.028,0.187-0.003,0.379-0.087,0.549l-0.273,0.548l0.027,0.208l0.058,0.188l0.155,0.31c0.183,0.366,0.105,0.808-0.193,1.089 L175.859,85.73z").attr({id: 'atlantico', class: 'st9', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#4D827D'}).data({'id': 'atlantico', 'region':'Atlántico', 'benefited-companies':'20', 'benefited-projects': '$660.000.000'});

        var cordoba = rsr.path("M121.706,170.61l0.747,0.753c0.096,0.097,0.169,0.213,0.215,0.342l0.33,0.929 c0.015,0.042,0.027,0.085,0.036,0.129l0.702,3.523l1.01,1.403c0.017,0.024,0.033,0.049,0.048,0.074l0.755,1.293l0.431,0.434 l2.275,0.797c0.121,0.042,0.232,0.109,0.325,0.197l0.737,0.687c0.056,0.052,0.106,0.112,0.147,0.176l0.742,1.154l0.726,1.103 c0.073,0.11,0.121,0.234,0.141,0.365l0.597,3.776c0.005,0.031,0.008,0.063,0.01,0.094l0.107,1.98 c0.002,0.043,0.002,0.085-0.002,0.128l-0.166,1.974c-0.016,0.192-0.092,0.374-0.216,0.521l-2.38,2.811l-2.123,3.031l-2.354,4.723 c-0.017,0.034-0.036,0.067-0.057,0.099l-1.362,2.051l-0.724,1.289l0.109,4.021c0.001,0.038,0,0.077-0.004,0.115l-0.12,1.237 c-0.005,0.052-0.014,0.103-0.028,0.153l-0.598,2.204c-0.024,0.088-0.061,0.172-0.109,0.249l-1.559,2.488l-1.612,5.928v4.211 l0.312,1.875l2.817,6.094c0.017,0.036,0.031,0.073,0.043,0.11l1.033,3.279l16.511,0.436l2.998,0.097l4.341,0.19l0.234-0.066 l0.047-0.03c0.005-0.049,0.013-0.097,0.025-0.144l0.192-0.74c0.028-0.109,0.076-0.212,0.142-0.304l3.218-4.526 c0.057-0.08,0.127-0.151,0.207-0.21l1.324-0.972c0.079-0.058,0.166-0.103,0.258-0.133l1.629-0.537 c0.037-0.012,0.075-0.022,0.113-0.03l2.607-0.506l1.523-0.58l0.616-0.414l0.925-1.397l0.819-3.665 c0.029-0.128,0.084-0.248,0.162-0.353l0.597-0.798c0.035-0.047,0.074-0.09,0.117-0.129l0.802-0.732 c0.041-0.038,0.086-0.072,0.134-0.102l0.938-0.585l1.333-2.936c0.048-0.105,0.115-0.201,0.198-0.281l0.783-0.761 c0.036-0.035,0.074-0.067,0.115-0.095l2.303-1.608l1.195-1.019l1.631-2.1c0.018-0.023,0.037-0.045,0.057-0.067l2.755-2.926 l0.55-0.826l0.985-1.438c0.094-0.138,0.225-0.248,0.376-0.318l0.651-0.3c0.042-0.02,0.086-0.036,0.131-0.049l1.165-0.336 c0.052-0.015,0.105-0.025,0.159-0.031l3.406-0.362c0.033-0.003,0.065-0.005,0.098-0.005c0.021,0,0.042,0.001,0.064,0.002 l1.038,0.071c0.07,0.005,0.139,0.018,0.206,0.038l0.722,0.22l0.331,0.042l0.333-0.101l0.585-0.322 c0.076-0.042,0.157-0.073,0.241-0.092l0.706-0.161c0.056-0.013,0.112-0.02,0.169-0.022l0.896-0.036 c0.012-0.001,0.025-0.001,0.037-0.001c0.016,0,0.032,0,0.049,0.001l2.027,0.107l1.086-1.439l1.14-1.859 c0.036-0.058,0.078-0.113,0.126-0.162l0.783-0.805c0.038-0.039,0.079-0.075,0.124-0.106l0.759-0.545 c0.083-0.059,0.174-0.105,0.272-0.134l0.402-0.122l0.081-0.177l0.026-0.412c0.008-0.135,0.046-0.266,0.11-0.384l0.235-0.433 c0.019-0.035,0.04-0.068,0.063-0.1l0.269-0.373c0.026-0.036,0.054-0.069,0.084-0.101l0.427-0.443 c-0.002-0.01-0.004-0.019-0.006-0.029l-0.162-0.808c-0.013-0.065-0.019-0.131-0.018-0.197l0.039-2.403l-0.124-0.358l-0.387-0.406 l-0.543-0.405c-0.031-0.023-0.06-0.048-0.088-0.074l-1.028-0.987c-0.059-0.056-0.109-0.12-0.151-0.189l-1.195-1.981l-1.563-1.193 c-0.013-0.01-0.026-0.02-0.038-0.031l-0.675-0.574l-0.261-0.013l-0.842,0.065l-2.394,0.874c-0.021,0.008-0.041,0.014-0.063,0.02 l-1.9,0.544l-4.741,2.326c-0.13,0.064-0.269,0.095-0.408,0.095c-0.247,0-0.49-0.099-0.669-0.285l-1.62-1.689l-1.366-0.915 l-1.822-0.825c-0.109-0.05-0.208-0.12-0.291-0.207l-0.464-0.49c-0.05-0.053-0.094-0.111-0.13-0.174l-0.336-0.584 c-0.026-0.045-0.048-0.092-0.066-0.141l-0.297-0.803c-0.026-0.072-0.044-0.146-0.052-0.222l-0.255-2.35 c-0.003-0.031-0.005-0.063-0.005-0.094l-0.011-1.832l-0.852-2.821c-0.017-0.057-0.029-0.116-0.035-0.176l-0.1-1.004 c-0.003-0.027-0.004-0.055-0.005-0.083l-0.007-0.685c-0.001-0.073,0.007-0.145,0.023-0.216l0.221-0.968l-0.801-2.632 c-0.034-0.113-0.047-0.231-0.037-0.348l0.151-1.774c0.012-0.145,0.059-0.285,0.135-0.408l0.287-0.463 c0.051-0.082,0.114-0.155,0.187-0.218l0.412-0.351c0.027-0.023,0.056-0.045,0.086-0.065l0.396-0.265l0.87-0.869 c0.029-0.029,0.06-0.056,0.093-0.081l0.625-0.477c0.077-0.059,0.162-0.105,0.253-0.137l0.518-0.183 c0.07-0.025,0.142-0.041,0.215-0.048l0.605-0.061l2.059-0.588l0.018-0.012l0.126-1.782c0.013-0.181,0.079-0.355,0.189-0.499 l-0.636-0.888c-0.045-0.063-0.083-0.132-0.111-0.205l-0.143-0.369c-0.095-0.246-0.081-0.521,0.039-0.756l0.076-0.149l-1.267-0.913 l-7.865-3.676c-0.156-0.073-0.289-0.188-0.384-0.333l-1.269-1.946c-0.07-0.107-0.117-0.227-0.138-0.353l-0.26-1.551l-0.235-0.128 l-0.344-0.044l-0.272,0.011c-0.013,0.001-0.025,0.001-0.038,0.001c-0.176,0-0.348-0.05-0.497-0.144l-0.181-0.115 c-0.147-0.094-0.265-0.227-0.34-0.384l-1.25-0.271c-0.191-0.041-0.364-0.142-0.494-0.288l-0.813-0.909 c-0.013-0.015-0.026-0.03-0.039-0.046l-0.535-0.683l-2.132-1.059l-1.301-0.313c-0.115-0.028-0.223-0.077-0.319-0.145l-0.27-0.192 l-1.088-0.389c-0.373-0.133-0.62-0.489-0.614-0.885l0.03-2.196l-0.114-0.032l-0.819-0.135l-0.752,0.131l-0.692,0.346l-1.352,0.93 c-0.157,0.108-0.34,0.163-0.525,0.163c-0.129,0-0.259-0.027-0.381-0.082c-0.252-0.114-0.437-0.332-0.51-0.594l-0.087,0.025 c-0.083,0.023-0.168,0.035-0.253,0.035c-0.094,0-0.187-0.014-0.278-0.043l-0.275-0.086c-0.086-0.027-0.167-0.066-0.242-0.117 l-0.364-0.247c-0.233-0.158-0.381-0.413-0.404-0.693l-0.025,0.005c-0.04,0.008-0.08,0.013-0.121,0.015l-1.487,0.085 c-0.018,0.001-0.035,0.002-0.053,0.002c-0.23,0-0.453-0.086-0.624-0.241l-0.295-0.268l-0.053-0.006l-0.084,0.875 c-0.023,0.24-0.139,0.462-0.323,0.618l-1.079,0.915c-0.042,0.035-0.086,0.067-0.133,0.094l-1.295,0.754 c-0.062,0.036-0.128,0.065-0.197,0.086l-1.471,0.446l-1.781,0.57l-0.261,0.12l-0.288,0.206l-0.317,0.34l-0.064,0.162l-0.073,0.623 l0.016,0.788c0.002,0.127-0.021,0.253-0.07,0.371l-0.201,0.488c-0.1,0.243-0.298,0.431-0.545,0.52l-0.511,0.183l-0.125,0.074 c-0.046,0.028-0.095,0.051-0.146,0.07l-1.214,0.46l-0.063,0.133l-0.512,3.705c-0.011,0.076-0.031,0.151-0.06,0.222l-0.279,0.685 c-0.031,0.077-0.073,0.15-0.124,0.216l-0.42,0.546c-0.035,0.046-0.075,0.089-0.119,0.128l-1.487,1.322l-0.736,0.872l-0.312,0.9 l0.333,1.342c0.065,0.263,0.012,0.542-0.146,0.762l-0.366,0.512c-0.058,0.081-0.129,0.152-0.209,0.211l-1.571,1.141l-0.29,0.397 l-0.204,0.389c-0.062,0.119-0.15,0.222-0.256,0.304l-0.385,0.295c-0.131,0.101-0.288,0.165-0.452,0.185l-0.656,0.08l-0.912,0.535 c-0.077,0.045-0.159,0.079-0.246,0.1l-2.149,0.533c0.011,0.057,0.016,0.115,0.016,0.174v0.288 C121.995,170.192,121.891,170.436,121.706,170.61z").attr({id: 'cordoba', class: 'st10', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#EAEAEA'}).data({'id': 'cordoba', 'region':'Córdoba', 'benefited-companies':'0', 'benefited-projects': '0'});

        var antioquia = rsr.path("M96.088,210.348l-0.198,0.225l-0.194,0.48l-0.815,4.559c-0.029,0.163-0.101,0.315-0.209,0.44 l-0.599,0.698c-0.059,0.069-0.129,0.129-0.206,0.178l-0.646,0.411l-0.805,0.862c-0.047,0.051-0.1,0.096-0.157,0.134l-1.043,0.708 c-0.155,0.105-0.336,0.16-0.52,0.16c-0.06,0-0.12-0.006-0.179-0.018l-0.119-0.024v0.343c0.04,0.055,0.073,0.115,0.1,0.177 l0.104,0.243c0.031,0.073,0.053,0.151,0.065,0.23l0.034,0.234c0.042,0.286-0.052,0.574-0.253,0.78l0.217,0.293l5.751,5.215 l4.704,3.367c0.052,0.037,0.099,0.079,0.142,0.126l4.748,5.157c0.014,0.015,0.027,0.03,0.04,0.046l3.608,4.48l0.801,0.642 l0.981,0.649l1.346,0.159c0.07,0.008,0.139,0.024,0.205,0.048l0.644,0.232c0.078,0.028,0.152,0.067,0.22,0.115l0.511,0.36 c0.025,0.017,0.048,0.036,0.071,0.055l1.996,1.722c0.054,0.047,0.102,0.099,0.144,0.157l0.611,0.842 c0.055,0.076,0.098,0.159,0.128,0.248l0.969,2.872c0.029,0.087,0.046,0.179,0.048,0.271l0.14,5.149 c0.002,0.074-0.005,0.147-0.02,0.22l-0.19,0.884c-0.008,0.039-0.019,0.076-0.032,0.114l-0.144,0.408 c-0.021,0.059-0.047,0.116-0.08,0.169l-1.53,2.545c-0.168,0.28-0.471,0.449-0.794,0.449c-0.028,0-0.055-0.001-0.083-0.004 l-1.073-0.096c-0.115-0.01-0.226-0.042-0.329-0.093l-0.58-0.288l-0.688-0.25l-3.641-0.883l-0.793-0.024l-2.829,0.228l-1.177,0.241 l-0.758,0.285l-0.296,0.174l-0.004,0.014l0.015,0.049l0.154,0.347l0.049,0.025c0.041,0.021,0.081,0.046,0.118,0.073l0.32,0.232 c0.119,0.086,0.216,0.199,0.282,0.33l0.25,0.492c0.031,0.061,0.055,0.126,0.072,0.193l0.191,0.757 c0.009,0.035,0.015,0.07,0.02,0.105l0.229,1.723c0.017,0.131,0.007,0.265-0.032,0.391l-0.207,0.682 c-0.033,0.108-0.085,0.209-0.154,0.298l-0.422,0.545c-0.033,0.043-0.071,0.083-0.111,0.12l-0.44,0.397l-0.082,0.165 c-0.098,0.197-0.263,0.352-0.465,0.438l-0.418,0.178c-0.115,0.049-0.239,0.074-0.363,0.074c-0.026,0-0.053-0.001-0.079-0.003 l-1.854-0.16l-1.199,0.717c-0.11,0.066-0.232,0.108-0.359,0.124l-0.543,0.069l-1.173,0.355l0.023,1.381l0.028,0.091l0.425,0.322 c0.147,0.112,0.258,0.265,0.317,0.44l0.148,0.435c0.072,0.212,0.065,0.443-0.021,0.65l-0.115,0.28 c0.137,0.104,0.244,0.245,0.306,0.409l0.07,0.185l0.318-0.223c0.161-0.113,0.347-0.168,0.532-0.168c0.271,0,0.538,0.118,0.72,0.343 l0.214,0.264c0.18,0.222,0.247,0.515,0.182,0.794l-0.1,0.429c-0.013,0.055-0.03,0.108-0.053,0.159l-0.073,0.166l0.796,0.083 c0.232,0.024,0.446,0.135,0.6,0.31l0.213,0.242c0.181,0.206,0.261,0.482,0.219,0.753l-0.105,0.678 c-0.066,0.427-0.419,0.752-0.85,0.782l-0.035,0.003l0.475,0.229c0.104,0.05,0.198,0.119,0.276,0.204l0.438,0.471 c0.09,0.096,0.158,0.211,0.199,0.336l0.212,0.633c0.035,0.104,0.051,0.213,0.048,0.323l-0.012,0.388l0.19,0.177 c0.067,0.062,0.124,0.134,0.17,0.213l0.229,0.394l0.073-0.022c0.089-0.027,0.18-0.04,0.27-0.04c0.277,0,0.546,0.125,0.725,0.349 l1.076,1.351c0.123,0.155,0.194,0.345,0.201,0.542l0.014,0.374c0.009,0.228-0.068,0.452-0.214,0.627l-0.223,0.268 c0.209,0.08,0.384,0.235,0.489,0.436c0.127,0.243,0.139,0.53,0.034,0.784l-0.128,0.309c-0.037,0.089-0.087,0.171-0.15,0.245 l-0.167,0.196c-0.01,0.012-0.02,0.023-0.031,0.035l0.185,0.267c0.083,0.121,0.137,0.26,0.156,0.405l0.068,0.519 c0.024,0.179-0.006,0.36-0.083,0.521c0.107,0.126,0.18,0.28,0.208,0.447c0.046,0.274-0.034,0.554-0.216,0.762l-0.261,0.299 l-0.198,0.531l-0.081,0.63l0.064,0.298l0.058,0.018l0.271,0.045c0.114,0.019,0.224,0.059,0.323,0.119l0.226,0.135 c0.23,0.137,0.389,0.367,0.436,0.631l0.169,0.938l0.005,0.013l1.144,1.245c0.047,0.051,0.088,0.108,0.123,0.168l0.474,0.832 c0.051,0.09,0.087,0.189,0.106,0.291l0.126,0.687l0.202,0.264c0.021,0.027,0.04,0.056,0.058,0.086l0.306,0.22l0.977,0.261 l0.986,0.125l3.498-0.136l1.937-0.407c0.035-0.007,0.07-0.013,0.105-0.016l2.571-0.239l2.114-0.225l1.433-0.321 c0.037-0.008,0.074-0.014,0.112-0.018l1.772-0.174c0.03-0.003,0.06-0.004,0.091-0.004c0.001,0,0.001,0,0.002,0l1.727,0.003 c0.042,0,0.084,0.003,0.126,0.009l1.588,0.221c0.147,0.02,0.287,0.076,0.408,0.162l0.866,0.613 c0.114,0.081,0.208,0.186,0.275,0.308l0.413,0.747c0.054,0.098,0.09,0.204,0.106,0.315l0.392,2.693l0.98,2.629l1.048,1.354 l0.748,0.295l1.055,0.028c0.131,0.003,0.26,0.035,0.379,0.092l1.181,0.571c0.28,0.135,0.474,0.403,0.515,0.711l0.279,2.094 c0.021,0.159,0.001,0.322-0.06,0.471l-1.227,3.023l-0.086,0.841l0.208,1.045l0.257,0.855l1.221,2.041l0.378,0.676 c0.059,0.105,0.096,0.221,0.111,0.341l0.142,1.171c0.014,0.12,0.005,0.241-0.027,0.358l-0.519,1.881l-0.038,0.383l0.278,0.522 l0.195,0.237l1.664,1.705l1.204,0.607c0.173,0.087,0.315,0.227,0.404,0.399l0.49,0.941l0.665,0.664l0.844,0.538l1.417,0.532 l1.89,0.278l0.737-0.074l2.216-0.913l2.906-2.047c0.124-0.087,0.267-0.143,0.417-0.162l0.649-0.082 c0.039-0.005,0.077-0.007,0.116-0.007c0.198,0,0.392,0.063,0.552,0.183l0.654,0.486l0.497,0.327 c0.058,0.038,0.111,0.082,0.159,0.132l0.321,0.334l0.046,0.011l0.846-0.034c0.012,0,0.025-0.001,0.037-0.001 c0.04,0,0.079,0.003,0.118,0.008l0.872,0.112l0.963-0.071c0.023-0.002,0.046-0.003,0.068-0.003c0.099,0,0.198,0.016,0.293,0.048 l0.198,0.066l0.006-0.03l0.05-0.771l-0.092-0.789l-0.696-2.445c-0.025-0.087-0.037-0.178-0.035-0.268l0.011-0.67 c0.001-0.048,0.005-0.096,0.013-0.143l0.112-0.648c-0.205-0.093-0.37-0.259-0.462-0.466l-0.256-0.576 c-0.053-0.119-0.08-0.247-0.08-0.377l0.001-1.326l-0.01-0.043c-0.063-0.277,0.004-0.567,0.182-0.788 c0.176-0.218,0.441-0.345,0.721-0.345c0.003,0,0.007,0,0.01,0l0.552,0.006c0.109,0.001,0.217,0.022,0.319,0.06l1.365,0.519 l0.498,0.074c0.176,0.026,0.341,0.103,0.475,0.22l0.506,0.445c0.148,0.13,0.25,0.304,0.293,0.495 c0.04,0.059,0.073,0.122,0.098,0.188l0.064,0.168c0.009,0.023,0.016,0.046,0.023,0.069l0.032,0.025l1.593,0.614 c0.06,0.023,0.118,0.053,0.172,0.088l0.063,0.041l0.118,0.003l0.033-0.005l1.887-1.024c0.137-0.075,0.289-0.112,0.442-0.112 c0.125,0,0.251,0.025,0.368,0.076l0.484,0.21c0.109,0.047,0.208,0.115,0.291,0.199l0.117,0.119l0.105,0.076l0.177,0.087 l0.635,0.204c0.148,0.047,0.281,0.131,0.388,0.244l0.257,0.27c0.106,0.111,0.182,0.247,0.223,0.396l0.122,0.448 c0.026,0.097,0.037,0.198,0.031,0.298l-0.053,0.883c-0.002,0.03-0.005,0.059-0.01,0.089l-0.053,0.334l0.004,0.025l0.217,0.248 l0.098,0.066l0.18,0.052c0.066,0.019,0.13,0.046,0.191,0.079l0.282,0.156c0.131,0.072,0.242,0.175,0.324,0.3l0.329,0.499 c0.043,0.066,0.078,0.137,0.104,0.212l1.084,3.189c0.014,0.041,0.025,0.082,0.033,0.124l0.1,0.524 c0.006,0.033,0.011,0.067,0.014,0.101l0.021,0.267c0.005,0.062,0.004,0.125-0.004,0.187l-0.02,0.162 c0.036-0.004,0.073-0.007,0.11-0.007c0.129,0,0.258,0.027,0.378,0.08c0.225,0.101,0.401,0.287,0.488,0.518l0.188,0.496l0.083-0.116 c0.023-0.032,0.048-0.062,0.074-0.091l0.149-0.16l0.121-0.168l0.436-0.789c0.042-0.077,0.095-0.147,0.158-0.209l0.279-0.277 c0.026-0.026,0.053-0.05,0.082-0.072l0.449-0.352c0.022-0.017,0.044-0.033,0.067-0.048l0.95-0.616 c0.033-0.021,0.067-0.041,0.103-0.058l0.643-0.309c0.024-0.011,0.048-0.022,0.073-0.031l0.421-0.16 c0.035-0.013,0.071-0.024,0.107-0.033l0.173-0.043c0.043-0.01,0.086-0.018,0.129-0.022l0.763-0.077 c0.039-0.13,0.106-0.251,0.197-0.353l1.461-1.633l0.2-0.364c-0.009-0.047-0.015-0.095-0.017-0.143l-0.057-1.321 c-0.002-0.044-0.001-0.088,0.004-0.132l0.12-1.203c0.044-0.441,0.394-0.788,0.835-0.83l1.588-0.15l0.744-0.26l0.466-0.244 l0.217-0.142l0.134-0.128l0.121-0.15l0.115-0.213c0.025-0.046,0.053-0.089,0.085-0.13l0.146-0.186l0.246-0.428 c0.119-0.207,0.314-0.361,0.543-0.428l2.926-0.855c0.028-0.008,0.056-0.015,0.084-0.02l1.693-0.327l1.061-0.194 c0.055-0.01,0.111-0.015,0.166-0.015c0.085,0,0.169,0.012,0.251,0.035l0.923,0.259c0.106,0.03,0.207,0.079,0.296,0.144l0.216,0.158 c0.067,0.049,0.127,0.106,0.178,0.171l0.091,0.114l0.372,0.348l1.761,1.159l0.075,0.035l0.82-0.244l0.329-0.624l0.189-0.858 c0.01-0.044,0.022-0.087,0.038-0.128l0.18-0.477c0.018-0.048,0.04-0.095,0.066-0.139l0.086-0.147l0.027-0.191 c0.022-0.154,0.083-0.3,0.176-0.425l0.112-0.149c0.065-0.087,0.146-0.162,0.237-0.221l0.149-0.096 c0.088-0.057,0.184-0.098,0.286-0.123l0.367-0.089c0.071-0.017,0.145-0.026,0.218-0.026c0.018,0,0.037,0.001,0.055,0.002 l0.079,0.005l0.254-0.075c0.085-0.025,0.173-0.038,0.262-0.038h0.157c0.132,0,0.263,0.028,0.383,0.083l0.164,0.075 c0.009,0.004,0.019,0.009,0.028,0.013l0.204-0.423l0.417-2.753c0.015-0.101,0.047-0.199,0.094-0.289l0.34-0.652 c0.022-0.042,0.047-0.083,0.076-0.121l0.537-0.729c0.03-0.041,0.063-0.079,0.099-0.114l0.61-0.595 c0.081-0.079,0.175-0.142,0.279-0.187l0.043-0.019l-0.486-1.338c-0.042-0.115-0.06-0.237-0.055-0.36l0.04-0.857 c0.013-0.272,0.145-0.525,0.36-0.691l0.253-0.194c0.068-0.053,0.144-0.095,0.224-0.127l0.549-0.217l-0.048-0.161 c-0.012-0.04-0.021-0.08-0.027-0.121l-0.053-0.341c-0.009-0.06-0.013-0.122-0.01-0.183l0.078-1.82l-0.053-0.474l-0.206-0.488 l-0.556-0.633c-0.044-0.05-0.082-0.104-0.114-0.162l-0.247-0.445c-0.069-0.124-0.108-0.262-0.115-0.403l-0.034-0.692 c-0.006-0.111,0.009-0.223,0.043-0.329l0.198-0.618c0.02-0.061,0.045-0.12,0.077-0.176l0.528-0.926l0.321-1.825 c0.016-0.092,0.046-0.181,0.089-0.264l0.598-1.158c0.036-0.071,0.082-0.136,0.135-0.195l0.892-0.99 c0.046-0.051,0.096-0.096,0.152-0.135l1.268-0.9l1.497-1.066l1.043-1.106l2.063-3.179c0.176-0.271,0.472-0.422,0.777-0.422 c0.129,0,0.26,0.027,0.384,0.084l0.118,0.054l0.042-0.045l0.064-0.165l-0.008-0.06l-0.139-0.231l-0.684-0.732 c-0.121-0.13-0.203-0.291-0.234-0.466l-0.112-0.614c-0.008-0.045-0.013-0.091-0.015-0.137l-0.133-4.219 c-0.002-0.073,0.004-0.146,0.019-0.217l0.074-0.358c0.013-0.062,0.032-0.122,0.057-0.18l0.535-1.234l0.057-0.298 c0.014-0.074,0.037-0.145,0.069-0.213l0.293-0.634c0.107-0.231,0.304-0.408,0.545-0.49l0.722-0.244 c0.06-0.02,0.122-0.034,0.184-0.042l1.669-0.203l1.52-0.725l8.224-6.111l0.475-0.649l1.408-2.74 c0.04-0.079,0.092-0.151,0.153-0.216l1.781-1.87l0.21-0.53c0.061-0.154,0.162-0.288,0.292-0.39l0.416-0.324 c0.051-0.039,0.105-0.074,0.163-0.102l3.658-1.785l0.859-0.654l0.38-0.798l-0.166-1.447l-0.25-0.458l-0.467-0.573 c-0.022-0.027-0.043-0.056-0.062-0.085l-0.463-0.721c-0.061-0.095-0.104-0.2-0.127-0.31l-0.198-0.947 c-0.008-0.038-0.014-0.077-0.017-0.115l-0.457-5.675l-12.874,12.255c-0.174,0.166-0.403,0.255-0.639,0.255 c-0.065,0-0.13-0.007-0.194-0.021l-0.715-0.153l-1.183,0.112c-0.029,0.003-0.058,0.004-0.088,0.004 c-0.049,0-0.099-0.004-0.148-0.012l-0.866-0.14c-0.072-0.012-0.142-0.032-0.209-0.06l-1.111-0.464 c-0.162-0.068-0.302-0.18-0.402-0.324l-0.468-0.67c-0.071-0.101-0.12-0.215-0.146-0.336l-0.216-1.003 c-0.006-0.027-0.01-0.053-0.014-0.081l-0.113-0.905l-0.451-1.2c-0.01-0.026-0.019-0.053-0.026-0.08l-0.383-1.393l-0.758-1.775 c-0.023-0.055-0.041-0.111-0.054-0.169l-0.31-1.446c-0.011-0.052-0.018-0.106-0.02-0.159l-0.042-1.118 c-0.004-0.099,0.008-0.198,0.036-0.293l0.416-1.432l0.007-1.643l-0.18-0.999c-0.019-0.106-0.02-0.214-0.001-0.321l0.17-0.99 c0.015-0.09,0.044-0.176,0.084-0.258l0.325-0.649c0.041-0.082,0.095-0.158,0.158-0.225l0.944-0.99l0.325-0.413l0.201-0.542 l0.162-0.837l-0.316-1.052l-0.637,0.504l-0.391,0.613l-0.734,1.896c-0.037,0.096-0.09,0.185-0.157,0.264l-0.608,0.718 c-0.031,0.036-0.064,0.07-0.1,0.101l-1.035,0.899c-0.127,0.11-0.281,0.184-0.446,0.213l-0.932,0.165 c-0.054,0.01-0.108,0.014-0.162,0.014c-0.081,0-0.162-0.011-0.241-0.032l-0.864-0.233c-0.144-0.039-0.276-0.112-0.386-0.213 l-0.946-0.871c-0.034-0.031-0.066-0.065-0.095-0.101l-1.548-1.926c-0.051-0.063-0.093-0.133-0.126-0.207l-0.876-1.989 c-0.031-0.071-0.053-0.145-0.066-0.221l-0.198-1.19c-0.007-0.043-0.011-0.087-0.012-0.13l-0.034-1.447 c-0.001-0.057,0.003-0.113,0.012-0.169l0.608-3.774c0.016-0.097,0.047-0.191,0.092-0.279l0.592-1.144 c0.06-0.117,0.145-0.219,0.248-0.301l0.972-0.769c0.027-0.021,0.055-0.041,0.085-0.06l0.93-0.58l0.654-0.614l0.56-1.036l0.06-0.408 l-0.037-0.092l-0.274-0.197l-0.542-0.31c-0.134-0.077-0.247-0.186-0.329-0.318l-0.548-0.889c-0.042-0.068-0.075-0.142-0.098-0.219 l-0.406-1.348c-0.016-0.054-0.027-0.108-0.034-0.164l-0.503-4.497l-0.361-1.046l-0.366-0.407c-0.026-0.029-0.05-0.06-0.072-0.092 l-0.829-1.198c-0.014-0.021-0.028-0.042-0.041-0.064l-0.745-1.291l-10.232-8.365l-0.183,0.055l-0.567,0.407l-0.654,0.672 l-1.11,1.81c-0.016,0.025-0.032,0.05-0.05,0.074l-1.41,1.868c-0.176,0.232-0.45,0.368-0.739,0.368c-0.016,0-0.032,0-0.049-0.001 l-2.476-0.13l-0.767,0.031l-0.495,0.113l-0.556,0.307c-0.057,0.031-0.117,0.057-0.179,0.075l-0.615,0.186 c-0.087,0.026-0.177,0.04-0.268,0.04c-0.039,0-0.077-0.002-0.116-0.007l-0.605-0.076c-0.052-0.007-0.104-0.018-0.154-0.033 l-0.697-0.212l-0.852-0.059l-3.245,0.345l-1.019,0.294l-0.356,0.164l-0.834,1.217l-0.587,0.881 c-0.029,0.043-0.061,0.084-0.096,0.121l-2.778,2.951l-1.663,2.14c-0.039,0.05-0.083,0.096-0.131,0.137l-1.301,1.109 c-0.023,0.019-0.046,0.037-0.07,0.054l-2.278,1.591l-0.604,0.587l-1.377,3.031c-0.075,0.166-0.198,0.306-0.353,0.403l-1.103,0.689 l-0.675,0.616l-0.426,0.568l-0.813,3.638c-0.025,0.11-0.069,0.215-0.132,0.309l-1.122,1.694c-0.067,0.102-0.154,0.189-0.256,0.257 l-0.858,0.576c-0.058,0.039-0.121,0.072-0.187,0.097l-1.697,0.646c-0.05,0.019-0.101,0.034-0.153,0.044l-2.628,0.51l-1.434,0.473 l-1.085,0.797l-3.033,4.266l-0.126,0.485l-0.019,0.346c-0.016,0.299-0.176,0.572-0.429,0.733l-0.564,0.357 c-0.076,0.048-0.158,0.085-0.245,0.109l-0.507,0.143c-0.082,0.023-0.166,0.035-0.251,0.035c-0.014,0-0.027,0-0.04-0.001 l-4.479-0.196l-2.982-0.096l-17.166-0.453c-0.395-0.01-0.74-0.27-0.859-0.647l-1.214-3.852l-2.845-6.154 c-0.035-0.075-0.059-0.155-0.073-0.237l-0.345-2.073c-0.008-0.05-0.012-0.101-0.012-0.152v-4.411c0-0.082,0.011-0.164,0.032-0.243 l1.68-6.18c0.024-0.088,0.061-0.172,0.109-0.249l1.559-2.487l0.542-1.996l0.107-1.102l-0.114-4.219 c-0.004-0.167,0.036-0.333,0.118-0.478l0.866-1.542c0.011-0.02,0.023-0.04,0.036-0.059l1.35-2.032l2.359-4.734 c0.02-0.041,0.044-0.081,0.07-0.118l2.187-3.123c0.016-0.023,0.033-0.046,0.052-0.067l2.216-2.618l0.136-1.615l-0.101-1.868 l-0.558-3.532l-0.621-0.944l-0.685-1.065l-0.511-0.476l-2.293-0.803c-0.132-0.046-0.252-0.122-0.351-0.222l-0.664-0.669 c-0.055-0.056-0.103-0.118-0.143-0.186l-0.792-1.357l-1.102-1.53c-0.077-0.108-0.131-0.23-0.157-0.36l-0.728-3.654l-0.238-0.67 l-0.704-0.71l-2.025,1.41l-1.952,1.983c-0.042,0.042-0.088,0.081-0.137,0.114l-0.62,0.425c-0.062,0.043-0.13,0.078-0.201,0.104 l-3.054,1.135c-0.022,0.276-0.168,0.53-0.398,0.689l-0.154,0.106l-0.038,0.091l-0.049,0.365l-0.01,0.446 c-0.004,0.172-0.056,0.339-0.149,0.484l-0.249,0.383c-0.083,0.128-0.197,0.234-0.331,0.308l-0.593,0.325 c-0.061,0.033-0.125,0.06-0.192,0.079l-4.448,1.267c-0.059,0.017-0.119,0.028-0.18,0.032l-0.998,0.08l-4.082,1.282l-0.397,0.667 c-0.026,0.044-0.056,0.085-0.089,0.124l-1.044,1.235l0.433,0.048c0.102,0.011,0.201,0.04,0.294,0.083l1.667,0.789 c0.043,0.021,0.085,0.044,0.125,0.071l1.433,0.975c0.057,0.039,0.11,0.084,0.157,0.135l0.914,0.983 c0.084,0.09,0.149,0.197,0.192,0.313l0.29,0.793c0.015,0.041,0.027,0.083,0.036,0.126l0.154,0.726l0.097,0.216l0.301,0.122 c0.045,0.018,0.089,0.04,0.131,0.065l0.598,0.361c0.21,0.126,0.361,0.331,0.42,0.569l0.215,0.862 c0.018,0.074,0.028,0.149,0.028,0.225l-0.004,6.361l0.224,1.335l0.553,1.433c0.021,0.055,0.037,0.112,0.048,0.17l0.177,0.987 c0.027,0.154,0.016,0.312-0.034,0.459l-0.474,1.404l0.005,0.564c0.252,0.066,0.469,0.237,0.591,0.478l0.554,1.094 c0.059,0.116,0.092,0.243,0.099,0.373l0.063,1.289c0.002,0.045,0.001,0.09-0.003,0.135l-0.277,2.841 c-0.004,0.039-0.01,0.077-0.018,0.115l-0.098,0.435c-0.036,0.159-0.113,0.305-0.224,0.425l-0.265,0.286l0.02,0.179l0.061,0.211 c0.019,0.067,0.031,0.136,0.035,0.205l0.015,0.274c0.007,0.124-0.012,0.249-0.054,0.366l-0.147,0.405 c-0.037,0.102-0.091,0.196-0.16,0.279l-0.314,0.375c-0.067,0.08-0.147,0.148-0.237,0.201l-0.476,0.283 c-0.052,0.031-0.108,0.057-0.165,0.077l-0.546,0.193c-0.048,0.017-0.098,0.03-0.149,0.039l-0.535,0.094 c-0.053,0.009-0.106,0.014-0.16,0.014c-0.008,0-0.015,0-0.023,0l-2.843-0.071c-0.087-0.002-0.173-0.017-0.256-0.043l-2.441-0.773 c-0.184-0.058-0.345-0.172-0.46-0.326l-1.217-1.617c-0.181-0.24-0.234-0.554-0.142-0.84l0.621-1.934 c-0.098-0.163-0.144-0.353-0.129-0.547l0.015-0.197c0.014-0.19,0.088-0.372,0.209-0.519l0.639-0.775 c0.156-0.189,0.381-0.309,0.625-0.333l1.064-0.103c0.001,0,0.003,0,0.004,0c0.009-0.039,0.02-0.079,0.034-0.117 c0.049-0.135,0.128-0.254,0.228-0.351v-0.278c0-0.385,0.238-0.73,0.599-0.866l0.021-0.008l-0.004-0.245 c-0.002-0.091,0.01-0.183,0.035-0.271l0.05-0.176h-0.47l-0.006,0.06c-0.044,0.42-0.367,0.757-0.784,0.82l-1.031,0.154 c-0.045,0.007-0.091,0.01-0.137,0.01c-0.172,0-0.342-0.048-0.49-0.14l-0.257-0.16l0.044,0.565c0.008,0.107-0.002,0.215-0.031,0.319 l-0.271,0.983c-0.027,0.097-0.07,0.19-0.126,0.274l-0.198,0.293l-0.096,0.629c-0.039,0.258-0.185,0.487-0.403,0.632L96.088,210.348 z").attr({id: 'antioquia', class: 'st11', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#42C642'}).data({'id': 'antioquia', 'region':'Antioquia', 'benefited-companies':'100', 'benefited-projects': '$3.160.000.000'});

        var arauca = rsr.path("M362.952,258.144l-0.046,0.03l-0.291,0.325c-0.046,0.051-0.097,0.097-0.152,0.136l-0.58,0.414 c-0.079,0.057-0.167,0.1-0.26,0.129l-0.81,0.254c-0.09,0.028-0.184,0.043-0.278,0.043c-0.085,0-0.169-0.012-0.252-0.035 l-0.446-0.126c-0.13-0.037-0.25-0.101-0.352-0.189l-0.26-0.223l-0.247-0.119l-2.028-0.05c-0.117-0.003-0.232-0.028-0.339-0.073 l-0.616-0.262c-0.202-0.086-0.367-0.241-0.466-0.437l-0.236-0.471c-0.056-0.112-0.089-0.234-0.097-0.359l-0.032-0.527l-0.014-0.077 l-0.227-0.024l-1.765,0.338c-0.057,0.011-0.116,0.017-0.174,0.017c-0.023,0-0.046-0.001-0.069-0.003l-0.76-0.057 c-0.06-0.004-0.118-0.015-0.176-0.031l-1.393-0.383l-0.497-0.048l-0.47,0.099l-1.106,0.51c-0.046,0.021-0.094,0.039-0.143,0.052 l-0.545,0.15c-0.081,0.022-0.163,0.033-0.245,0.033c-0.214,0-0.424-0.074-0.593-0.214l-0.751-0.625l-0.581-0.149l-0.227,0.06 c-0.172,0.164-0.401,0.256-0.639,0.256c-0.019,0-0.039-0.001-0.058-0.002l-0.904-0.057c-0.248-0.016-0.479-0.13-0.642-0.318 l-0.033-0.038c-0.013-0.015-0.026-0.031-0.038-0.047l-0.227,0.131c-0.057,0.033-0.118,0.06-0.181,0.08l-0.328,0.105 c-0.091,0.029-0.186,0.044-0.281,0.044c-0.037,0-0.074-0.002-0.11-0.007l-0.316-0.038c-0.151-0.018-0.295-0.073-0.42-0.16 l-0.538-0.376c-0.089-0.062-0.166-0.14-0.229-0.228l-0.168-0.239l-0.019-0.013l-1.042-0.038l0.008,0.032 c0.075,0.316-0.021,0.647-0.253,0.874c-0.175,0.172-0.409,0.265-0.649,0.265c-0.077,0-0.154-0.01-0.23-0.029l-1.154-0.296 l-0.884,0.058l-1.032,0.18c-0.048,0.008-0.097,0.013-0.146,0.014l-0.286,0.004c-0.029,0.29-0.195,0.555-0.455,0.706l-0.285,0.167 c-0.143,0.083-0.304,0.126-0.467,0.126c-0.061,0-0.123-0.006-0.184-0.018l-0.381-0.077l-0.141,0.007l-0.311,0.201l-0.4,0.339 c-0.036,0.031-0.075,0.059-0.116,0.084l-0.491,0.3c-0.101,0.062-0.213,0.104-0.33,0.123l-0.71,0.119 c-0.05,0.008-0.101,0.013-0.152,0.013c-0.026,0-0.052-0.001-0.078-0.003l-1.498-0.126c-0.045-0.004-0.09-0.011-0.134-0.021 l-2.931-0.687l-0.14,0.466c-0.017,0.056-0.039,0.11-0.066,0.161l-0.462,0.887l-1.708,4.389c-0.014,0.037-0.031,0.073-0.05,0.108 l-0.848,1.555l-0.551,1.874c-0.031,0.106-0.081,0.206-0.148,0.295l-0.865,1.152c-0.091,0.121-0.211,0.219-0.348,0.283l-0.706,0.331 l-0.138,0.357l-1.073,8.625c-0.007,0.054-0.018,0.107-0.034,0.16l-0.492,1.59c-0.02,0.066-0.048,0.13-0.083,0.19l-0.402,0.696 c-0.026,0.045-0.056,0.088-0.089,0.128l-0.556,0.67c-0.096,0.115-0.217,0.205-0.356,0.263l-0.783,0.328 c-0.089,0.037-0.183,0.06-0.279,0.068l-0.502,0.042l-0.261,0.099l-0.215,0.164l-0.336,0.461c-0.021,0.029-0.045,0.057-0.069,0.084 l-0.464,0.5c-0.048,0.052-0.103,0.099-0.162,0.139l-0.37,0.249c-0.154,0.104-0.334,0.158-0.517,0.158 c-0.056,0-0.112-0.005-0.168-0.016l-0.405-0.075c-0.152-0.028-0.294-0.094-0.414-0.191l-0.151-0.122l-0.193,0.205l-0.089,0.174 l-0.034,0.421c-0.005,0.065-0.017,0.128-0.036,0.191l-0.331,1.102c-0.048,0.16-0.138,0.304-0.262,0.417l-1.101,1.009l-1.022,1.669 l-0.098,0.349l-0.007,0.207l0.195,0.907l0.873,1.472l1.706,1.702c0.071,0.071,0.13,0.153,0.175,0.243l1.021,2.05l0.461,0.379 l0.716,0.464l1.773,0.882c0.039,0.019,0.076,0.041,0.111,0.065l1.291,0.885l0.877,0.172l0.346,0.006l2.355-1.717 c0.098-0.071,0.209-0.123,0.326-0.151l2.378-0.58l2.543-1.184c0.063-0.03,0.13-0.052,0.198-0.066l0.939-0.199 c0.062-0.013,0.125-0.02,0.188-0.02l0.937-0.005c0.002,0,0.003,0,0.005,0c0.046,0,0.092,0.003,0.138,0.01l0.703,0.106l1.205-0.108 l4.831-1.768c0.034-0.012,0.068-0.023,0.103-0.031l1.18-0.281c0.07-0.017,0.141-0.025,0.213-0.025l3.297-0.007l0.849-0.321 c0.068-0.026,0.139-0.043,0.211-0.053l0.7-0.089c0.039-0.005,0.078-0.007,0.117-0.007c0.096,0,0.191,0.015,0.283,0.044l0.445,0.143 c0.046,0.015,0.09,0.033,0.133,0.054l1.128,0.566l0.35,0.075l1.176-0.273c0.055-0.013,0.112-0.021,0.169-0.023l0.808-0.036 c0.014-0.001,0.027-0.001,0.041-0.001c0.047,0,0.093,0.004,0.139,0.011l0.847,0.129l0.951-0.135l1.654-0.576l0.612-0.281 c0.027-0.012,0.054-0.023,0.082-0.033l0.728-0.253c0.055-0.019,0.112-0.033,0.17-0.042l0.877-0.128 c0.033-0.005,0.065-0.008,0.098-0.009l1.205-0.047l1.441-0.613l1.058-0.648c0.08-0.049,0.167-0.085,0.257-0.108l0.523-0.132 c0.074-0.019,0.15-0.028,0.226-0.028c0.053,0,0.107,0.005,0.16,0.014l0.363,0.064l0.557-0.104c0.056-0.011,0.113-0.016,0.171-0.016 c0.043,0,0.086,0.003,0.129,0.009l0.417,0.059l0.603-0.431c0.158-0.113,0.347-0.173,0.538-0.173c0.055,0,0.11,0.005,0.165,0.015 l1.515,0.274c0.059,0.011,0.116,0.027,0.172,0.049l1.346,0.526l0.879,0.13l2.402-0.062c0.008,0,0.016,0,0.024,0 c0.055,0,0.11,0.005,0.164,0.015l1.521,0.274c0.05,0.009,0.1,0.022,0.148,0.039l3.158,1.13l4.157,0.309l0.293-0.028l0.932-0.337 c0.028-0.01,0.056-0.019,0.084-0.026l0.939-0.242c0.035-0.009,0.07-0.016,0.106-0.021l0.942-0.128 c0.041-0.006,0.083-0.008,0.125-0.008c0.048,0,0.097,0.004,0.145,0.011l0.787,0.125c0.077,0.012,0.153,0.034,0.225,0.066 l1.819,0.791c0.052,0.023,0.102,0.05,0.15,0.082l0.002,0.001l2.169,0.01l3.447-0.589c0.028-0.005,0.056-0.008,0.084-0.01 l2.374-0.185c0.024-0.002,0.048-0.003,0.072-0.003c0.011,0,0.022,0,0.033,0.001l1.556,0.055l0.733-0.24l1.856-0.893 c0.03-0.014,0.06-0.027,0.091-0.038l3.144-1.119c0.064-0.023,0.129-0.038,0.196-0.047l1.173-0.146 c0.038-0.005,0.076-0.007,0.114-0.007c0.026,0,0.052,0.001,0.078,0.003l0.932,0.078c0.069,0.006,0.136,0.019,0.202,0.04 l1.334,0.423l0.563,0.055l1.105-0.004l1.257-0.167c0.036-0.005,0.073-0.007,0.109-0.008l1.578-0.021c0.004,0,0.009,0,0.013,0 c0.034,0,0.069,0.002,0.103,0.006l1.16,0.13c0.032,0.004,0.064,0.009,0.096,0.016l0.664,0.146c0.06,0.013,0.119,0.032,0.175,0.057 l1.492,0.659c0.085,0.037,0.163,0.087,0.233,0.148l0.386,0.335c0.058,0.05,0.109,0.108,0.153,0.171l0.474,0.682l0.216,0.187 l1.288,0.783c0.052,0.032,0.101,0.069,0.146,0.11l0.348,0.32c0.088,0.081,0.159,0.178,0.21,0.286l0.23,0.488 c0.017,0.036,0.032,0.074,0.044,0.112l0.144,0.448l0.128,0.287l0.31,0.258l2.895,1.078c0.045,0.017,0.089,0.037,0.131,0.061 l0.892,0.502c0.048,0.027,0.093,0.058,0.135,0.093l1.045,0.863c0.034,0.028,0.065,0.058,0.095,0.09l0.383,0.42 c0.092,0.101,0.16,0.22,0.201,0.351l0.13,0.42c0.024,0.077,0.037,0.156,0.041,0.237l0.019,0.479l0.424,0.512l0.669,0.292 c0.055-0.06,0.119-0.112,0.188-0.156l1.319-0.827c0.088-0.055,0.184-0.095,0.285-0.118l1.47-0.337 c0.068-0.016,0.137-0.023,0.207-0.023c0.012,0,0.023,0,0.035,0.001l9.612,0.361l1.543-0.319l3.185-1.913l-0.842-1.067l-3.464-4.389 l-3.464-4.386l-3.464-4.39l-3.46-4.391l-3.464-4.389l-3.465-4.392l-3.464-4.393l-3.463-4.391l-0.731-0.925l-1.254-1.09 l-0.954-0.235l-1.473,0.078l-1.447,0.364l-2.465,1.391c-0.139,0.079-0.296,0.12-0.455,0.12c-0.013,0-0.026,0-0.04-0.001 l-1.436-0.062c-0.125-0.005-0.248-0.036-0.361-0.09l-4.698-2.256l-0.631-0.223c-0.11-0.039-0.211-0.098-0.299-0.174l-0.145-0.126 c-0.062-0.054-0.116-0.116-0.162-0.184l-0.107-0.161l-0.02-0.001l-0.953,0.126c-0.04,0.005-0.081,0.008-0.121,0.008 c-0.006,0-0.012,0-0.018,0l-0.487-0.009c-0.074-0.001-0.148-0.012-0.22-0.031l-0.725-0.192c-0.08-0.021-0.157-0.053-0.228-0.095 l-0.466-0.271c-0.101-0.059-0.19-0.136-0.262-0.228l-2.211-2.809l-0.208,0.037l-1.23,0.391c-0.079,0.025-0.162,0.04-0.245,0.043 l-0.748,0.029c-0.012,0-0.024,0.001-0.035,0.001c-0.069,0-0.139-0.008-0.207-0.023l-1.548-0.354 c-0.039-0.009-0.077-0.02-0.114-0.034l-0.431-0.159c-0.103-0.038-0.199-0.094-0.282-0.166l-0.554-0.476l-1.024,0.022l-2.648,0.631 c-0.048,0.011-0.097,0.019-0.146,0.023l-1.873,0.139l-1.634,0.548c-0.085,0.029-0.175,0.045-0.265,0.048l-0.629,0.02l-0.083,0.176 c-0.028,0.06-0.062,0.116-0.102,0.168l-0.489,0.64c-0.056,0.074-0.123,0.138-0.199,0.192l-1.941,1.381 c-0.066,0.047-0.137,0.085-0.212,0.113l-2.281,0.854c-0.07,0.026-0.142,0.044-0.216,0.052l-2.475,0.292 c-0.036,0.004-0.072,0.006-0.109,0.006c-0.033,0-0.067-0.002-0.1-0.005L362.952,258.144z").attr({id: 'arauca', class: 'st12', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#EAEAEA'}).data({'id': 'arauca', 'region':'Arauca', 'benefited-companies':'0', 'benefited-projects': '0'});

        var vichada = rsr.path("M436.144,300.831l-1.807,0.374c-0.062,0.013-0.125,0.019-0.188,0.019 c-0.012,0-0.023,0-0.035-0.001l-9.602-0.361l-1.198,0.275l-1.082,0.678l-0.362,0.392l-0.881,0.954l-0.941,1.41l-3.2,7.384 c-0.015,0.034-0.032,0.068-0.051,0.1l-0.782,1.334c-0.038,0.064-0.083,0.124-0.135,0.177l-1.792,1.843l-0.19,0.493 c-0.023,0.06-0.053,0.118-0.088,0.172l-1.558,2.393c-0.031,0.047-0.065,0.091-0.104,0.131l-1.045,1.104 c-0.032,0.034-0.066,0.065-0.103,0.093l-1.432,1.117c-0.027,0.021-0.054,0.04-0.083,0.058l-1.528,0.944 c-0.034,0.021-0.07,0.04-0.107,0.057l-1.323,0.595c-0.063,0.028-0.128,0.049-0.196,0.063l-1.89,0.384 c-0.045,0.009-0.09,0.015-0.135,0.017l-3.562,0.189l-1.54,0.279l-2.781,1.105c-0.07,0.028-0.143,0.047-0.217,0.057l-0.95,0.129 l-0.704,0.25l-2.844,2.122c-0.036,0.027-0.074,0.051-0.114,0.073l-2.964,1.6l-0.856,0.675c-0.029,0.023-0.06,0.045-0.092,0.064 l-0.855,0.52c-0.042,0.025-0.086,0.048-0.131,0.066l-1.82,0.744l-0.429,0.394l-0.123,0.494l-0.182,2.119 c-0.017,0.193-0.094,0.376-0.22,0.524l-0.382,0.446c-0.098,0.114-0.222,0.203-0.362,0.258l-0.59,0.233l-7.919,6.882 c-0.055,0.048-0.115,0.089-0.18,0.122l-0.794,0.414c-0.059,0.031-0.121,0.055-0.185,0.072l-1.537,0.417l-0.423,0.48l-2.991,7.127 c-0.028,0.068-0.065,0.132-0.108,0.191l-0.982,1.334c-0.036,0.049-0.076,0.094-0.121,0.134l-0.237,0.217l-0.152,70.903 l0.001,21.427c0.036-0.004,0.073-0.006,0.109-0.006c0.172,0,0.343,0.048,0.491,0.141l0.658,0.411l0.551,0.056 c0.051,0.005,0.101,0.015,0.15,0.028l0.604,0.165c0.152-0.251,0.419-0.42,0.722-0.443l0.374-0.028 c0.023-0.002,0.047-0.003,0.07-0.003c0.194,0,0.384,0.061,0.542,0.175l0.786,0.567c0.048,0.034,0.092,0.073,0.132,0.115 l0.013-0.019c0.153-0.233,0.403-0.384,0.68-0.412l0.387-0.039c0.031-0.003,0.062-0.005,0.093-0.005 c0.226,0,0.446,0.083,0.616,0.235l0.605,0.54c0.173,0.154,0.281,0.367,0.305,0.597l0.002,0.018 c0.098-0.037,0.202-0.057,0.307-0.059l0.676-0.014c0.006,0,0.013,0,0.019,0c0.182,0,0.359,0.053,0.511,0.154l0.713,0.471 c0.126,0.084,0.23,0.197,0.303,0.33l0.363,0.667l0.247-0.055l0.501-0.25l0.578-0.394c0.083-0.057,0.174-0.099,0.271-0.126 l0.505-0.142c0.082-0.023,0.166-0.034,0.25-0.034c0.053,0,0.107,0.005,0.16,0.014l0.345,0.06c0.297,0.052,0.549,0.245,0.678,0.517 l0.17,0.36l0.846-0.65l0.042-0.056l-0.088-0.257l-0.24-0.415c-0.052-0.091-0.089-0.19-0.108-0.293l-0.071-0.379 c-0.037-0.2-0.008-0.406,0.084-0.587l0.141-0.28c0.158-0.312,0.477-0.509,0.827-0.509h0.47c0.188,0,0.372,0.057,0.527,0.165 l0.451,0.312c0.073,0.051,0.138,0.111,0.194,0.18l0.602,0.747l0.016-0.018c0.176-0.195,0.426-0.305,0.687-0.305 c0.008,0,0.017,0,0.025,0l0.953,0.026c0.053,0.001,0.106,0.007,0.159,0.018l0.754,0.153c0.107,0.022,0.209,0.062,0.302,0.119 l3.694,2.278l1.004-0.807c0.066-0.053,0.138-0.096,0.215-0.129l3.747-1.606l0.923-0.535l0.274-0.321l0.063-0.327 c0.007-0.036,0.016-0.071,0.027-0.106l0.17-0.535c0.029-0.091,0.072-0.177,0.127-0.254l0.367-0.519 c0.072-0.102,0.164-0.188,0.269-0.253l2.085-1.288l0.126-0.364l-0.032-0.806l-0.168-0.734l-0.336-0.648 c-0.034-0.066-0.061-0.136-0.078-0.209l-0.107-0.443c-0.063-0.261-0.01-0.537,0.147-0.756l0.175-0.245 c0.113-0.158,0.273-0.277,0.457-0.339l0.004-0.001l-0.22-0.034c-0.033-0.005-0.065-0.012-0.098-0.02l-0.414-0.11 c-0.235-0.062-0.435-0.214-0.559-0.423l-0.162-0.273c-0.19-0.321-0.169-0.724,0.053-1.024l0.184-0.248 c0.062-0.084,0.139-0.157,0.225-0.216l0.361-0.244l0.24-0.199l0.667-1.215c0.027-0.049,0.058-0.096,0.094-0.139l0.994-1.221 c0.039-0.048,0.084-0.093,0.132-0.132l0.642-0.525c0.041-0.034,0.085-0.064,0.131-0.09l0.796-0.449l0.032-0.078 c0.055-0.133,0.141-0.252,0.249-0.346l0.209-0.181c0.169-0.146,0.384-0.226,0.606-0.226c0.017,0,0.035,0.001,0.053,0.001 l0.189,0.011c0.217,0.012,0.423,0.101,0.582,0.25l0.01,0.009c0-0.014,0.001-0.027,0.002-0.041l0.035-0.578 c0.011-0.187,0.079-0.367,0.195-0.514l0.175-0.223c0.165-0.211,0.41-0.336,0.668-0.353c-0.099-0.171-0.141-0.37-0.118-0.567 l0.095-0.841c0.026-0.232,0.138-0.445,0.315-0.597l0.345-0.298c0.017-0.014,0.034-0.028,0.051-0.041l-0.346-0.27 c-0.084-0.065-0.155-0.144-0.212-0.234l-0.383-0.604c-0.076-0.12-0.124-0.256-0.139-0.397l-0.067-0.624 c-0.029-0.271,0.062-0.541,0.25-0.738l0.588-0.617l0.214-0.351l0.179-0.479c0.038-0.102,0.094-0.197,0.165-0.28l0.033-0.817 c0.02-0.498,0.43-0.889,0.925-0.889c0.008,0,0.016,0,0.023,0l1.471,0.037l0.328-1.665c0.007-0.034,0.015-0.067,0.026-0.1 l0.091-0.287l-0.729-1.014c-0.02-0.027-0.038-0.055-0.054-0.084l-0.274-0.484c-0.144-0.255-0.16-0.563-0.041-0.83 c0.118-0.268,0.356-0.464,0.641-0.529l0.902-0.206c0.054-0.012,0.109-0.02,0.164-0.022l1.259-0.057 c0.014-0.001,0.028-0.001,0.042-0.001c0.033,0,0.066,0.002,0.099,0.005l1.123,0.121c0.143,0.015,0.281,0.064,0.402,0.142 l0.485,0.312c0.105,0.068,0.195,0.156,0.265,0.259l0.067,0.099l0.186,0.097l0.253,0.073l0.902-1.33 c0.02-0.03,0.042-0.058,0.066-0.085l0.433-0.501c0.065-0.075,0.142-0.14,0.227-0.191l0.59-0.351 c0.104-0.062,0.218-0.102,0.337-0.12l0.882-0.131c0.045-0.007,0.091-0.01,0.136-0.01c0.155,0,0.308,0.039,0.445,0.114l0.375,0.206 c0.111,0.061,0.208,0.144,0.286,0.244l0.157,0.201c0.148-0.229,0.39-0.383,0.663-0.417l0.739-0.092 c0.038-0.005,0.076-0.007,0.115-0.007c0.009,0,0.018,0,0.027,0l3.073,0.09l0.96-0.149l0.724-0.241 c0.095-0.032,0.194-0.048,0.293-0.048c0.009,0,0.018,0,0.027,0l0.74,0.021c0.188,0.005,0.37,0.068,0.522,0.18l0.956,0.702 c0.03,0.022,0.059,0.047,0.087,0.072l0.092-1.308c0.012-0.167,0.069-0.328,0.165-0.466l0.314-0.448 c0.171-0.244,0.449-0.391,0.747-0.395l0.26-0.003l0.275-0.219l0.169-1.236l-0.017-0.055l-0.187-0.209 c-0.223-0.25-0.294-0.601-0.185-0.918l0.165-0.48c0.07-0.203,0.208-0.375,0.39-0.487l0.42-0.259 c0.119-0.073,0.253-0.119,0.392-0.133l0.867-0.089c0.031-0.003,0.063-0.005,0.094-0.005c0.029,0,0.058,0.001,0.086,0.004 l0.663,0.062l0.889-0.025l0.886-0.144l1.216-0.561c0.045-0.021,0.091-0.038,0.138-0.051l0.892-0.249 c0.082-0.023,0.166-0.034,0.249-0.034c0.09,0,0.18,0.013,0.266,0.039l0.713,0.214c0.145,0.044,0.277,0.122,0.384,0.228l0.492,0.486 c0.026,0.026,0.051,0.054,0.074,0.083l0.119,0.149c0.019-0.007,0.038-0.014,0.058-0.02l0.733-0.231 c0.035-0.011,0.071-0.02,0.107-0.027l0.919-0.172l1.687-0.565c0.095-0.032,0.194-0.048,0.294-0.048 c0.019,0,0.038,0.001,0.057,0.002l0.924,0.057c0.152,0.009,0.299,0.056,0.428,0.135l0.283-0.419 c0.14-0.207,0.357-0.348,0.602-0.392l0.587-0.107c0.055-0.01,0.11-0.015,0.165-0.015c0.141,0,0.282,0.032,0.41,0.096l0.611,0.302 c0.159,0.078,0.292,0.201,0.384,0.353l0.305,0.507l0.032,0.037l0.055,0.003l0.448-0.048c0.033-0.004,0.066-0.005,0.099-0.005 c0.057,0,0.115,0.005,0.171,0.016l0.34,0.064c0.205,0.038,0.391,0.145,0.527,0.302l0.386,0.444l0.609,0.241 c0.105,0.041,0.201,0.101,0.284,0.177l0.225,0.206c0.087,0.079,0.157,0.174,0.208,0.278l0.176-0.127 c0.079-0.057,0.167-0.102,0.261-0.132l0.553-0.177c0.092-0.03,0.188-0.044,0.283-0.044c0.145,0,0.29,0.034,0.422,0.102l0.43,0.22 c0.035,0.018,0.069,0.038,0.102,0.061l0.377,0.259c0.026,0.018,0.051,0.037,0.076,0.058l0.186,0.157h0.005 c0.258,0.008,0.501,0.124,0.67,0.32c0.169,0.195,0.249,0.453,0.22,0.709l-0.091,0.808c0.03,0.038,0.057,0.077,0.081,0.119 l0.024,0.041l0.138-0.139l0.564-0.946c0.057-0.096,0.131-0.181,0.218-0.25l0.543-0.433c0.167-0.133,0.371-0.202,0.577-0.202 c0.118,0,0.237,0.023,0.35,0.069l0.466,0.19l2.368,0.331l-0.045-1.168c-0.005-0.142,0.022-0.282,0.079-0.412l0.3-0.675 c0.086-0.194,0.236-0.352,0.425-0.449l0.333-0.17c0.089-0.045,0.184-0.076,0.282-0.091l0.257-0.039 c0.046-0.007,0.093-0.011,0.139-0.011c0.077,0,0.153,0.01,0.228,0.029l0.265,0.068c0.037,0.009,0.073,0.021,0.108,0.035 l0.363,0.142c0.186,0.072,0.343,0.203,0.448,0.372l0.071,0.113c0.021,0.034,0.04,0.068,0.056,0.104l1.359-0.693 c0.054-0.028,0.111-0.05,0.17-0.067l0.505-0.142c0.082-0.023,0.167-0.034,0.25-0.034c0.187,0,0.372,0.057,0.529,0.166l0.335,0.233 l-0.023-0.101c-0.078-0.349,0.051-0.711,0.332-0.932l0.57-0.447c0.164-0.128,0.365-0.198,0.572-0.198 c0.028,0,0.056,0.001,0.085,0.004l0.465,0.043c0.039,0.004,0.078,0.01,0.116,0.018l0.835,0.185l0.168,0.014l-0.005-0.387 c-0.001-0.041,0.002-0.081,0.006-0.122l0.063-0.53c0.045-0.38,0.32-0.694,0.691-0.788l0.389-0.099 c0.017-0.004,0.034-0.008,0.051-0.011l0.695-0.136l0.801-0.707c0.171-0.151,0.39-0.232,0.613-0.232 c0.082,0,0.164,0.011,0.245,0.033l0.569,0.156c0.053,0.015,0.105,0.034,0.155,0.058l0.69,0.33l0.513,0.143l1.072-0.091l0.295-0.151 l0.336-0.361c0.048-0.052,0.103-0.098,0.161-0.138l0.433-0.291c0.153-0.103,0.333-0.157,0.516-0.157 c0.029,0,0.058,0.001,0.087,0.004l0.566,0.053c0.154,0.014,0.302,0.067,0.43,0.154l0.136,0.092l0.047-0.11 c0.031-0.073,0.072-0.142,0.121-0.205l0.577-0.739c0.047-0.06,0.1-0.113,0.16-0.16l0.717-0.56c0.102-0.08,0.22-0.137,0.346-0.169 l0.654-0.163c0.028-0.007,0.056-0.013,0.084-0.017l0.262-0.04l0.022-0.052c0.066-0.159,0.175-0.297,0.314-0.397l0.497-0.358 c0.007-0.005,0.013-0.01,0.02-0.014l-0.087-0.414c-0.044-0.207-0.015-0.422,0.081-0.611l0.29-0.571 c0.131-0.257,0.374-0.439,0.658-0.491l0.95-0.175c0.05-0.009,0.102-0.014,0.153-0.015l1.574-0.026l0.083-0.33 c0.01-0.04,0.023-0.079,0.038-0.118l0.299-0.745c0.036-0.09,0.086-0.173,0.148-0.248l0.098-0.117l-0.402-0.501 c-0.117-0.146-0.188-0.325-0.201-0.512l-0.058-0.788c-0.027-0.362,0.16-0.706,0.478-0.88l0.647-0.355 c0.137-0.075,0.29-0.114,0.445-0.114c0.013,0,0.026,0,0.039,0.001l1.002,0.042c0.035,0.002,0.07,0.005,0.105,0.011l1.981,0.312 c0.074,0.012,0.146,0.032,0.215,0.061l1.02,0.429c0.258,0.109,0.454,0.329,0.531,0.598l0.281,0.98 c0.019,0.066,0.03,0.134,0.034,0.202l0.027,0.465l0.866-0.464c0.042-0.022,0.085-0.041,0.129-0.057l1.108-0.392 c0.101-0.036,0.205-0.053,0.308-0.053c0.261,0,0.516,0.111,0.695,0.314l0.496,0.562c0.189,0.215,0.267,0.503,0.216,0.78 l0.372-0.416l0.265-0.383l0.472-1.079c0.03-0.069,0.069-0.135,0.115-0.195l0.404-0.523c0.118-0.153,0.28-0.264,0.465-0.32 l0.586-0.178c0.088-0.027,0.179-0.04,0.268-0.04c0.228,0,0.453,0.085,0.626,0.243l0.463,0.424c0.072,0.066,0.132,0.142,0.18,0.226 l0.571,1.008l0.216,0.163l0.772-1.293c0.168-0.282,0.471-0.452,0.795-0.452c0.032,0,0.064,0.002,0.096,0.005 c0.359,0.037,0.663,0.279,0.78,0.62l0.235,0.682c0.028,0.082,0.045,0.167,0.049,0.254l0.063,1.223l0.09-0.045l1.028-0.702 c0.157-0.107,0.339-0.161,0.522-0.161c0.151,0,0.303,0.037,0.441,0.112l1.633,0.885l1.455,0.587l1.281-0.052l1.538-1.098l2.1-2.975 c0.055-0.078,0.121-0.147,0.197-0.204l0.629-0.477c0.06-0.045,0.125-0.083,0.193-0.113l0.379-0.163l0.005-0.027l-0.152-0.429 l-0.364-0.377c-0.11-0.114-0.189-0.254-0.229-0.407l-0.329-1.253l-0.654-0.694l-0.813-0.666c-0.112-0.092-0.201-0.208-0.26-0.341 l-0.387-0.872c-0.034-0.077-0.058-0.159-0.07-0.243l-0.199-1.374l-0.381-1.365c-0.009-0.032-0.016-0.065-0.022-0.098l-0.25-1.518 c-0.015-0.091-0.016-0.183-0.004-0.274l0.231-1.721c0.015-0.112,0.05-0.22,0.104-0.319l0.753-1.386l0.044-0.205l-0.06-0.241 l-0.559-0.882c-0.054-0.085-0.094-0.178-0.118-0.276l-0.146-0.6c-0.031-0.128-0.035-0.26-0.011-0.39l0.069-0.367 c0.011-0.061,0.029-0.121,0.053-0.179l0.098-0.241l-0.055-0.019c-0.127-0.045-0.242-0.117-0.338-0.211l-0.186-0.182 c-0.125-0.122-0.213-0.277-0.253-0.447l-0.354-1.482l-0.168-0.31l-0.011-0.008c-0.042,0.006-0.084,0.009-0.126,0.009 c-0.188,0-0.376-0.057-0.536-0.17l-0.406-0.287c-0.033-0.024-0.065-0.05-0.095-0.078l-0.389-0.362 c-0.047-0.044-0.089-0.092-0.126-0.144l-0.307-0.434c-0.059-0.083-0.103-0.176-0.132-0.274l-0.149-0.508 c-0.035-0.12-0.046-0.246-0.031-0.37l0.076-0.636c0.022-0.184,0.099-0.357,0.22-0.498l0.264-0.304 c0.051-0.059,0.109-0.111,0.173-0.155l0.173-0.119l0.037-0.055l0.022-0.149l-0.062-1.372c-0.004-0.087,0.004-0.173,0.025-0.258 l0.271-1.132l0.139-2.462c0.003-0.052,0.01-0.104,0.022-0.155l0.229-0.997c0.023-0.1,0.062-0.195,0.116-0.282l0.431-0.693 l0.252-0.522l0.096-1.833c0.005-0.095,0.024-0.188,0.058-0.276l0.172-0.46l-0.03-0.055c-0.113-0.206-0.143-0.447-0.085-0.674 l0.068-0.268c0.015-0.06,0.036-0.117,0.063-0.173l0.063-0.131l0.005-0.177l-0.035-0.091l-0.393-0.762 c-0.027-0.052-0.049-0.107-0.065-0.163l-0.09-0.304c-0.028-0.095-0.041-0.195-0.037-0.294l0.038-1.068 c0.002-0.043,0.006-0.085,0.013-0.127l0.309-1.763c0.008-0.044,0.019-0.088,0.033-0.131l0.556-1.683l0.063-0.705l-0.078-1.979 c-0.005-0.135,0.019-0.27,0.071-0.395l0.099-0.236c0.042-0.101,0.102-0.194,0.177-0.274l0.165-0.177l0.047-0.069l-0.701-0.815 c-0.028-0.032-0.053-0.066-0.076-0.101l-0.286-0.442c-0.04-0.062-0.072-0.128-0.096-0.197l-0.16-0.459 c-0.013-0.036-0.023-0.073-0.031-0.11l-0.097-0.449c-0.008-0.037-0.014-0.075-0.017-0.113l-0.042-0.473 c-0.003-0.037-0.004-0.075-0.003-0.112l0.017-0.523c0.002-0.056,0.008-0.111,0.02-0.165l0.12-0.56 c0.01-0.046,0.023-0.091,0.04-0.135l0.389-1.024l0.05-0.209l-0.046-0.878l-0.142-0.647l-0.237-0.561l-0.388-0.694 c-0.04-0.071-0.07-0.147-0.09-0.227l-0.442-1.759c-0.035-0.138-0.037-0.282-0.007-0.42l0.415-1.929 c0.023-0.105,0.063-0.205,0.12-0.296l1.133-1.812c0.052-0.083,0.117-0.158,0.193-0.221l1.699-1.415 c0.123-0.103,0.272-0.172,0.43-0.2l0.212-0.038c0.054-0.01,0.108-0.014,0.163-0.014c0.047,0,0.093,0.004,0.14,0.011l0.214,0.033 l0.347-0.414c0.039-0.046,0.082-0.089,0.129-0.127l0.245-0.198c0.075-0.061,0.159-0.109,0.25-0.144l1.243-0.477l0.208-0.144 l0.773-0.84c0.043-0.047,0.09-0.088,0.141-0.125l0.493-0.354c0.094-0.067,0.199-0.117,0.311-0.145l0.231-0.059l0.412-1.359 c0.035-0.115,0.091-0.221,0.167-0.315l0.274-0.338c0.027-0.034,0.057-0.065,0.089-0.095l0.254-0.237l0.068-0.094l-0.457-0.447 c-0.034-0.033-0.065-0.068-0.093-0.106l-0.156-0.208c-0.103-0.138-0.166-0.302-0.182-0.474l-0.076-0.858l-0.508-2.652 c-0.011-0.057-0.016-0.115-0.017-0.173l-0.003-2.104c0-0.057,0.005-0.113,0.015-0.169l0.363-1.968 c0.011-0.061,0.028-0.12,0.051-0.177l0.732-1.82c0.023-0.058,0.052-0.113,0.086-0.165l1.092-1.656 c0.039-0.059,0.085-0.114,0.136-0.163l2.625-2.484l0.353-0.61c0.033-0.057,0.072-0.111,0.117-0.16l2.154-2.365 c0.058-0.064,0.126-0.12,0.2-0.165l0.654-0.402c0.039-0.024,0.08-0.045,0.122-0.063l1.527-0.651l0.214-0.176l0.074-0.328 l-0.081-0.786l-0.206-0.549l-0.946-0.677c-0.097-0.069-0.179-0.156-0.243-0.256l-1.685-2.649c-0.094-0.147-0.144-0.318-0.145-0.492 l-0.009-1.767c0-0.097,0.014-0.194,0.044-0.287l0.203-0.635c0.041-0.128,0.11-0.246,0.201-0.345l0.125-0.136 c-0.057-0.027-0.112-0.06-0.163-0.099l-1.27-0.96c-0.03-0.022-0.058-0.047-0.085-0.072l-1.146-1.106l-1.116-0.701l-6.953-1.624 l-3.121-0.266c-0.061-0.005-0.122-0.017-0.181-0.034l-0.664-0.194l-0.048,0.002l-0.224,0.111l-0.733,0.761 c-0.025,0.026-0.051,0.05-0.078,0.072l-0.479,0.394c-0.124,0.102-0.272,0.17-0.429,0.197l-0.51,0.089 c-0.053,0.009-0.106,0.014-0.159,0.014c-0.008,0-0.017,0-0.025,0l-0.426-0.011l-0.018,0.046l-0.072,0.386 c-0.016,0.089-0.046,0.174-0.087,0.255l-0.238,0.463c-0.045,0.088-0.104,0.168-0.174,0.237l-0.359,0.353 c-0.102,0.1-0.225,0.175-0.361,0.22l-0.434,0.142c-0.04,0.013-0.08,0.023-0.121,0.031l-0.373,0.068l-1.517,0.522 c-0.053,0.018-0.107,0.031-0.162,0.04l-1.874,0.286c-0.046,0.007-0.093,0.011-0.14,0.011c-0.03,0-0.059-0.001-0.088-0.004 l-5.715-0.548l-1.795,0.245l-5.109,1.843c-0.1,0.036-0.205,0.055-0.31,0.055l-1.687,0.007c-0.001,0-0.003,0-0.004,0 c-0.084,0-0.167-0.011-0.247-0.034l-2.926-0.811l-0.772-0.091l-0.799,0.087l-3.275,0.973c-0.07,0.021-0.142,0.033-0.215,0.037 l-2.661,0.141l-0.217,0.101l-1.102,0.969c-0.068,0.06-0.145,0.109-0.227,0.147l-0.609,0.278c-0.121,0.055-0.252,0.084-0.384,0.084 c-0.036,0-0.072-0.002-0.107-0.006l-1.097-0.128c-0.099-0.011-0.195-0.039-0.284-0.081l-1.805-0.843l-0.797-0.176l-0.976-0.105 c-0.058-0.006-0.116-0.018-0.172-0.035l-2.852-0.873l-0.81-0.133l-2.812,0.154c-0.017,0.001-0.034,0.001-0.05,0.001 c-0.062,0-0.124-0.006-0.185-0.019l-0.984-0.201c-0.042-0.009-0.084-0.02-0.125-0.035l-1.041-0.37l-0.745-0.174l-0.576,0.165 c-0.084,0.024-0.169,0.036-0.255,0.036c-0.129,0-0.258-0.027-0.377-0.08l-1.635-0.729l-0.739-0.171l-0.804,0.031l-0.561,0.25 l-1.172,1.121c-0.051,0.049-0.108,0.092-0.17,0.128l-0.888,0.524l-2.623,2.554c-0.057,0.056-0.121,0.104-0.191,0.143l-2.6,1.468 c-0.142,0.08-0.299,0.12-0.455,0.12c-0.197,0-0.392-0.063-0.556-0.186l-1.027-0.771c-0.052-0.039-0.099-0.083-0.142-0.132 l-1.835-2.104l-0.479-0.244l-0.797,0.142l-2.081,0.972c-0.044,0.021-0.09,0.038-0.137,0.051l-1.104,0.316l-4.439,2.665 C436.344,300.772,436.246,300.81,436.144,300.831z").attr({id: 'vichada' ,class: 'st13', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#EAEAEA'}).data({'id': 'vichada', 'region':'Vichada', 'benefited-companies':'0', 'benefited-projects': '0'});

        var putumayo = rsr.path("M206.895,596.647l1.091,0.861l2.722,1.636c0.047,0.028,0.09,0.06,0.131,0.096l0.542,0.472 c0.029,0.025,0.057,0.052,0.082,0.081l0.603,0.675c0.036,0.04,0.068,0.083,0.096,0.128l0.197,0.316l0.315,0.012 c0.212,0.008,0.415,0.089,0.575,0.229l0.226,0.198c0.139,0.122,0.238,0.281,0.285,0.459l21.215-6.582l-0.629-0.189 c-0.031-0.009-0.062-0.02-0.092-0.033l-2.193-0.923c-0.054-0.023-0.105-0.05-0.153-0.082l-0.991-0.658 c-0.073-0.048-0.139-0.107-0.195-0.174l-1.424-1.687l-2.302-1.75l-0.462-0.226l-0.362,0.102l-0.7,0.325 c-0.122,0.057-0.256,0.086-0.39,0.086c-0.01,0-0.021,0-0.031,0l-0.837-0.028c-0.244-0.008-0.474-0.112-0.642-0.289l-0.288-0.304 c-0.115-0.122-0.195-0.273-0.231-0.437l-0.157-0.714h-0.001l-0.183,0.028c-0.047,0.007-0.095,0.011-0.142,0.011 c-0.005,0-0.01,0-0.015,0l-0.347-0.006l-0.226,0.033l-0.204,0.111c-0.086,0.047-0.179,0.08-0.276,0.097l-0.362,0.066 c-0.055,0.01-0.111,0.015-0.166,0.015c-0.162,0-0.321-0.042-0.463-0.124L220,588.183c-0.09-0.052-0.17-0.118-0.238-0.197 l-0.342-0.396c-0.053-0.061-0.097-0.128-0.132-0.201l-0.199-0.411c-0.019-0.04-0.036-0.081-0.049-0.123l-0.435-1.366 c-0.022-0.068-0.035-0.138-0.041-0.208l-0.021-0.263l-0.024-0.095l-0.138-0.205l-0.252-0.211l-1.447-0.747l-0.551-0.117 l-1.34,0.539c-0.11,0.044-0.227,0.067-0.346,0.067c-0.005,0-0.01,0-0.015,0l-0.731-0.012c-0.294-0.005-0.568-0.148-0.738-0.387 l-0.365-0.51c-0.096-0.134-0.154-0.291-0.169-0.455l-0.059-0.648l-0.045-0.155l-0.286,0.895c-0.077,0.241-0.249,0.44-0.476,0.551 l-0.652,0.318c-0.127,0.062-0.266,0.094-0.406,0.094c-0.059,0-0.119-0.006-0.177-0.017l-0.762-0.149 c-0.119-0.023-0.232-0.07-0.333-0.136l-0.33-0.218l-0.061-0.023l-0.528,0.131c-0.035,0.009-0.07,0.015-0.105,0.02l-0.73,0.094 c-0.039,0.005-0.079,0.008-0.119,0.008c-0.042,0-0.084-0.003-0.126-0.009l-0.926-0.128c-0.053-0.007-0.105-0.019-0.156-0.036 l-0.898-0.288c-0.065-0.021-0.128-0.049-0.187-0.084l-0.642-0.378c-0.129-0.076-0.237-0.181-0.316-0.308l-0.251-0.403 c-0.044-0.071-0.079-0.148-0.103-0.229l-0.257-0.873l-0.013-0.02l-0.108-0.006l-0.269,0.016c-0.018,0.001-0.036,0.002-0.054,0.002 c-0.052,0-0.104-0.004-0.156-0.013l-0.617-0.105l-0.239,0.027c-0.035,0.004-0.07,0.006-0.105,0.006 c-0.148,0-0.294-0.035-0.426-0.104l-0.291-0.151c-0.219-0.113-0.383-0.309-0.457-0.544l-0.201-0.637 c-0.016-0.05-0.027-0.101-0.034-0.152l-0.101-0.737l-0.057-0.222l-0.461-0.848c-0.101-0.185-0.135-0.399-0.098-0.606l0.06-0.335 c0.03-0.168,0.106-0.324,0.219-0.452l0.187-0.21l0.331-0.643l-0.086-0.029c-0.074-0.025-0.144-0.06-0.21-0.103l-0.625-0.41 c-0.334-0.219-0.49-0.628-0.386-1.014l0.136-0.505c0.033-0.122,0.09-0.235,0.168-0.334l0.386-0.489l0.106-0.202l-0.2-1.325 l-0.843-1.032l-1.334-0.729l-4.994-0.959c-0.093-0.018-0.183-0.05-0.266-0.095l-2.872-1.554l-1.867-0.616 c-0.182-0.06-0.341-0.175-0.455-0.329l-0.365-0.493c-0.093-0.126-0.153-0.274-0.174-0.43l-0.194-1.469l-0.622-1.996 c-0.013-0.041-0.023-0.083-0.03-0.126l-0.107-0.656c-0.013-0.078-0.015-0.157-0.008-0.235l0.265-2.841l-0.232-0.58l-1.043-0.195 l-0.663,0.179c-0.034,0.009-0.069,0.016-0.104,0.022l-0.443,0.066c-0.045,0.007-0.091,0.01-0.137,0.01 c-0.078,0-0.156-0.01-0.232-0.03l-0.418-0.108c-0.208-0.054-0.391-0.179-0.517-0.353l-0.19-0.262 c-0.086-0.118-0.142-0.255-0.165-0.399l-0.076-0.483l-0.097-0.048l-0.073,0.001l-0.955,0.423c-0.052,0.023-0.107,0.042-0.163,0.055 l-1.544,0.363c-0.07,0.016-0.141,0.025-0.212,0.025c-0.105,0-0.21-0.018-0.31-0.053l-0.997-0.354 c-0.18-0.064-0.336-0.182-0.446-0.338l-0.699-0.987c-0.04-0.057-0.074-0.118-0.101-0.182l-0.642-1.558 c-0.028-0.068-0.048-0.139-0.059-0.211l-0.125-0.812c-0.016-0.107-0.014-0.215,0.007-0.321l0.279-1.41l-0.005-0.49l-0.199-0.462 l-0.965-1.167c-0.035-0.043-0.067-0.089-0.094-0.138l-0.406-0.724c-0.059-0.105-0.096-0.22-0.111-0.339l-0.056-0.456 c-0.008-0.068-0.009-0.137-0.003-0.205l0.068-0.686l-0.03-0.091l-0.196-0.221l-0.335-0.223l-0.963-0.422l-0.63-0.141l-2.407,0.312 c-0.039,0.005-0.079,0.008-0.119,0.008c-0.02,0-0.039-0.001-0.059-0.002l-3.892-0.248c-0.086-0.006-0.171-0.023-0.252-0.052 l-1.805-0.644c-0.138-0.049-0.262-0.131-0.363-0.237l-2.675-2.84l-1.544-0.724l-1.823-0.225l-3.038,0.236 c-0.024,0.002-0.048,0.003-0.071,0.003c-0.007,0-0.014,0-0.021,0l-0.845-0.019c-0.088-0.002-0.174-0.016-0.258-0.043l-0.793-0.25 c-0.085-0.027-0.165-0.066-0.239-0.115l-0.78-0.526l-0.7-0.342l-1.674-0.161c-0.132-0.013-0.259-0.054-0.374-0.12l-0.794-0.458 c-0.093-0.054-0.177-0.124-0.246-0.206l-2.469-2.938c-0.044-0.053-0.083-0.11-0.114-0.172l-0.55-1.067 c-0.044-0.085-0.074-0.176-0.09-0.27l-0.125-0.739c-0.01-0.058-0.014-0.117-0.013-0.175l0.011-0.474l-0.04-0.129l-0.294-0.228 l-0.438-0.105l-1.584,0.14c-0.027,0.002-0.054,0.004-0.082,0.004c-0.01,0-0.02,0-0.029,0l-0.827-0.026 c-0.109-0.003-0.216-0.026-0.317-0.067l-1.186-0.479l-0.36-0.089l-0.228,0.047l-0.144,0.14l-0.196,0.407 c-0.032,0.067-0.073,0.13-0.12,0.187l-0.38,0.46c-0.136,0.165-0.326,0.278-0.536,0.319l-0.796,0.156 c-0.059,0.011-0.118,0.017-0.178,0.017c-0.015,0-0.03,0-0.045-0.001l-1.346-0.065l-0.349,0.075l-0.527,0.248l-0.418,0.301 l-0.354,0.328c-0.037,0.034-0.077,0.065-0.118,0.093l-0.458,0.302c-0.079,0.052-0.166,0.092-0.257,0.118l-0.715,0.203 c-0.082,0.023-0.167,0.035-0.253,0.035c-0.011,0-0.021,0-0.032,0l-6.447-0.22c-0.048-0.002-0.096-0.007-0.144-0.016l-1.397-0.269 c-0.077-0.015-0.152-0.039-0.223-0.073l-1.766-0.84l-3.179-1.022c-0.088-0.028-0.171-0.07-0.247-0.123l-0.915-0.64 c-0.097-0.068-0.18-0.154-0.245-0.253l-1.102-1.69c-0.06-0.092-0.103-0.193-0.127-0.3l-0.438-1.919 c-0.018-0.081-0.026-0.164-0.022-0.247l0.176-4.015c0.003-0.071,0.014-0.141,0.033-0.209l0.23-0.821 c0.016-0.058,0.038-0.114,0.065-0.167l0.725-1.437l0.137-0.564l-0.024-0.371l-0.121-0.469l-0.464-1.046l-0.652-0.596 c-0.146-0.134-0.246-0.311-0.284-0.505l-0.063-0.323l-0.712-1.164l-0.615-0.743l-1.321-0.549c-0.051-0.021-0.1-0.047-0.147-0.077 l-0.653-0.421l-0.379-0.136l-0.109,0.028l-2.192,3.312c-0.026,0.04-0.056,0.077-0.088,0.113l-1.045,1.147 c-0.064,0.071-0.14,0.131-0.222,0.179l-1.234,0.71c-0.086,0.049-0.179,0.085-0.276,0.105l-1.228,0.253 c-0.061,0.013-0.124,0.019-0.186,0.019c-0.019,0-0.039-0.001-0.058-0.002l-3.576-0.225l-1.138,0.007l-1.127,0.967 c-0.144,0.124-0.323,0.2-0.512,0.219l-0.577,0.057l0.025,0.196c0.009,0.068,0.01,0.136,0.004,0.204l-0.047,0.507 c-0.007,0.081-0.026,0.16-0.054,0.236l-0.165,0.446c-0.054,0.144-0.142,0.273-0.258,0.375l-0.644,0.564 c-0.024,0.021-0.049,0.041-0.075,0.059l-0.48,0.34c-0.063,0.045-0.131,0.081-0.204,0.109l-3.271,1.253 c-0.021,0.008-0.042,0.015-0.063,0.021l-0.157,0.048l-0.006,0.04l-0.073,1.815l0.217,1.991l0.254,0.095 c0.095,0.035,0.183,0.086,0.262,0.15l0.768,0.625l0.446,0.152c0.099,0.034,0.192,0.084,0.274,0.149l0.192,0.151 c0.148,0.116,0.256,0.274,0.312,0.453l0.133,0.43c0.023,0.076,0.037,0.154,0.041,0.233l0.018,0.396 c0.005,0.118-0.012,0.236-0.051,0.348l-0.428,1.223c-0.01,0.029-0.022,0.058-0.035,0.086l-0.183,0.392l-2.18,4.728 c-0.013,0.028-0.027,0.055-0.042,0.081l-1.315,2.24c-0.067,0.114-0.157,0.212-0.265,0.288l-0.764,0.539l-0.766,1.003l-2.814,3.536 c-0.011,0.014-0.022,0.027-0.034,0.041l-0.349,0.391l1.154,1.146l2.034,1.68l0.724,0.461l0.662,0.273 c0.136,0.056,0.257,0.144,0.352,0.256l0.271,0.319c0.08,0.094,0.14,0.203,0.177,0.32l0.142,0.446c0.032,0.1,0.046,0.205,0.043,0.31 l-0.025,0.758c-0.004,0.115-0.029,0.228-0.074,0.334l-0.127,0.297c-0.064,0.15-0.167,0.281-0.298,0.378l-0.177,0.132l-0.002,0.041 l0.049,0.286l0.883,2.047c0.021,0.048,0.037,0.097,0.05,0.148l0.162,0.665c0.012,0.05,0.02,0.1,0.024,0.151l0.09,1.244l0.349,0.758 c0.04,0.086,0.066,0.178,0.078,0.273l0.115,0.915c0.013,0.101,0.009,0.203-0.012,0.302l-0.058,0.281 c-0.013,0.062-0.032,0.123-0.057,0.181l-0.152,0.352c-0.052,0.121-0.13,0.229-0.226,0.317c0.145,0.053,0.274,0.141,0.377,0.256 l1.582,1.788l0.987,0.333l1.683,0.03c0.045,0.001,0.09,0.005,0.135,0.012l0.569,0.094c0.052,0.009,0.104,0.022,0.154,0.039 l0.758,0.264c0.082,0.029,0.16,0.069,0.231,0.119l0.465,0.33c0.043,0.031,0.084,0.065,0.121,0.103l0.944,0.953l0.612,0.449 l0.396,0.143l0.461,0.019l3.084-0.463c0.046-0.007,0.092-0.01,0.138-0.01c0.03,0,0.06,0.001,0.09,0.004l0.576,0.056 c0.1,0.01,0.198,0.036,0.289,0.077l0.945,0.424l-0.04-0.625c-0.026-0.406,0.217-0.782,0.598-0.925l0.564-0.213 c0.105-0.04,0.216-0.06,0.327-0.06c0.082,0,0.163,0.011,0.243,0.033l1.509,0.411l2.153,0.237c0.054,0.006,0.108,0.017,0.16,0.032 l0.656,0.193c0.096,0.028,0.187,0.072,0.269,0.129l0.722,0.505c0.036,0.025,0.069,0.052,0.101,0.082l1.076,1.003l0.473,0.163 l0.292-0.037l1.037-0.534c0.099-0.051,0.207-0.084,0.318-0.097l4.309-0.498l0.129-0.086l-0.381-2.445 c-0.009-0.057-0.012-0.115-0.011-0.173l0.112-3.351l-0.019-0.245c-0.023-0.287,0.09-0.569,0.304-0.761 c0.172-0.154,0.393-0.238,0.62-0.238c0.056,0,0.113,0.005,0.17,0.016l0.319,0.059l0.812-0.051l0.354-0.069l0.123-0.045l0.976-1.165 c0.027-0.032,0.056-0.063,0.087-0.091l0.255-0.231c0.046-0.042,0.096-0.079,0.149-0.111l0.194-0.115l0.787-0.596 c0.093-0.07,0.198-0.122,0.31-0.154l0.507-0.142c0.082-0.023,0.166-0.034,0.249-0.034c0.129,0,0.258,0.027,0.377,0.08l0.455,0.203 c0.111,0.05,0.212,0.121,0.295,0.209l1.186,1.253l0.721,0.473l0.76,0.331l0.834,0.191l0.99,0.067l0.938-0.049 c0.016-0.001,0.032-0.001,0.048-0.001c0.023,0,0.046,0.001,0.068,0.003l0.51,0.038c0.106,0.008,0.211,0.034,0.308,0.077l0.382,0.17 c0.182,0.081,0.333,0.218,0.43,0.392l0.274,0.486c0.046,0.082,0.079,0.17,0.099,0.262l0.171,0.802l0.08-0.004l1.042-0.332 c0.054-0.017,0.11-0.03,0.167-0.037l1.029-0.128c0.038-0.005,0.076-0.007,0.114-0.007c0.313,0,0.608,0.159,0.779,0.426l0.439,0.684 c0.037,0.057,0.067,0.118,0.09,0.182l0.147,0.403l2.968,3.753c0.056,0.071,0.102,0.151,0.135,0.235l0.227,0.576 c0.016,0.041,0.029,0.083,0.04,0.126l0.168,0.71l0.347,0.508l0.992,0.916l2.699,1.666c0.124,0.077,0.229,0.182,0.304,0.306 l0.288,0.473l1.638,1.211l1.182,0.66l0.637,0.256l0.751,0.184l0.86,0.072l0.908-0.086l1.91-0.435 c0.031-0.007,0.063-0.013,0.094-0.016l0.86-0.104c0.037-0.004,0.074-0.007,0.111-0.007c0.098,0,0.195,0.016,0.288,0.046 l0.908,0.297c0.123,0.04,0.236,0.106,0.332,0.192l0.722,0.651c0.025,0.022,0.049,0.046,0.071,0.071l0.495,0.555l0.263,0.167 l0.705,0.233c0.12,0.04,0.231,0.104,0.326,0.188l2.086,1.861l2.501,1.537l1.002,0.349c0.085,0.029,0.164,0.071,0.237,0.123 l0.723,0.521l2.353,0.448c0.05,0.009,0.098,0.023,0.145,0.04l2.899,1.062c0.053,0.02,0.105,0.044,0.154,0.073l0.473,0.281 l0.143-0.05l0.524-0.404l0.404-0.482l0.14-0.358l0.139-0.792c0.031-0.178,0.114-0.342,0.237-0.473l0.439-0.467 c0.129-0.137,0.296-0.232,0.48-0.271l0.701-0.151c0.064-0.014,0.129-0.021,0.195-0.021c0.033,0,0.066,0.002,0.099,0.005 l0.916,0.099c0.048,0.005,0.096,0.014,0.143,0.027l2.055,0.557c0.061,0.017,0.12,0.039,0.176,0.068l0.96,0.486 c0.055,0.028,0.107,0.061,0.155,0.099l0.868,0.685c0.067,0.052,0.126,0.114,0.176,0.182l1.748,2.403l0.325,0.314l0.059,0.021 l0.654,0.016c0.082,0.002,0.164,0.015,0.243,0.039l0.426,0.127c0.107,0.032,0.207,0.083,0.295,0.15l0.286,0.217 c0.043,0.033,0.084,0.07,0.121,0.11l1.815,1.972l0.457,0.354l0.788,0.346l1.467,0.315c0.041,0.009,0.081,0.02,0.12,0.034 l0.556,0.201l0.159-0.124l1.052-1.683c0.13-0.207,0.336-0.355,0.574-0.411l0.543-0.127c0.07-0.016,0.141-0.024,0.211-0.024 c0.223,0,0.442,0.081,0.613,0.232l0.957,0.845c0.053,0.047,0.101,0.1,0.142,0.158l0.65,0.915c0.029,0.04,0.054,0.083,0.076,0.127 l1.558,3.162c0.196,0.398,0.082,0.879-0.271,1.147l-0.427,0.323l0.59,0.152l1.064,0.102c0.108,0.01,0.213,0.039,0.311,0.086 l0.287,0.137c0.1,0.048,0.19,0.113,0.267,0.192l0.139,0.144l0.256,0.191c0.03,0.022,0.059,0.047,0.086,0.072l0.232,0.222 c0.05,0.048,0.095,0.102,0.134,0.16l0.056,0.003l0.177-0.133c0.029-0.022,0.059-0.042,0.091-0.06l0.38-0.222 c0.088-0.051,0.184-0.088,0.284-0.108l0.492-0.099c0.061-0.012,0.122-0.018,0.183-0.018c0.208,0,0.412,0.07,0.578,0.202l0.438,0.35 c0.087,0.07,0.161,0.154,0.218,0.25l1.238,2.082L206.895,596.647z").attr({id: 'putumayo', class: 'st14', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#EAEAEA'}).data({'id': 'putumayo', 'region':'Putumayo', 'benefited-companies':'0', 'benefited-projects': '0'});

        var narino = rsr.path("M89.977,559.282c0.028-0.025,0.058-0.048,0.089-0.07l0.059-0.041l0.009-0.021l0.008-0.037 l-0.078-0.621l-0.36-0.781c-0.047-0.101-0.075-0.21-0.083-0.32l-0.097-1.334l-0.125-0.515l-0.895-2.075 c-0.029-0.067-0.05-0.137-0.062-0.209l-0.085-0.491c-0.011-0.064-0.015-0.13-0.013-0.195l0.019-0.469 c0.006-0.152,0.049-0.3,0.126-0.431l0.162-0.276c0.09-0.154,0.223-0.279,0.383-0.359h0.001l0.011-0.33l-0.037-0.117l-0.005-0.006 l-0.53-0.219c-0.05-0.021-0.098-0.046-0.144-0.075l-0.841-0.536c-0.032-0.02-0.063-0.043-0.092-0.067l-2.111-1.744 c-0.022-0.018-0.043-0.037-0.063-0.057l-1.807-1.796c-0.349-0.347-0.366-0.907-0.037-1.274l0.918-1.026l2.786-3.5l0.84-1.101 c0.057-0.075,0.125-0.141,0.202-0.195l0.713-0.507l1.19-2.028l2.162-4.69l0.165-0.354l0.354-1.01l-0.003-0.063l-0.309-0.105 c-0.104-0.035-0.201-0.089-0.286-0.158l-0.743-0.604c-0.023,0.002-0.045,0.003-0.068,0.003c-0.06,0-0.12-0.006-0.179-0.018 l-0.191-0.038c-0.304-0.06-0.558-0.268-0.676-0.554l-0.11-0.264c-0.034-0.081-0.056-0.167-0.065-0.254l-0.277-2.539 c-0.005-0.046-0.007-0.092-0.005-0.138l0.078-1.94c0.002-0.037,0.005-0.075,0.011-0.111l0.108-0.666 c0.057-0.349,0.307-0.635,0.646-0.738l0.678-0.205l3.131-1.199l0.346-0.245l0.431-0.378l0.041-0.111l0.026-0.284l-0.112-0.868 c-0.012-0.095-0.01-0.191,0.008-0.285l0.095-0.522c0.026-0.143,0.086-0.278,0.174-0.394l0.127-0.168 c0.163-0.215,0.412-0.348,0.682-0.364l0.159-0.01c0.019-0.001,0.037-0.002,0.056-0.002c0.273,0,0.534,0.121,0.711,0.332l0.05,0.06 l0.798-0.684l-0.063-1.212l-0.456-2.145c-0.01-0.047-0.016-0.095-0.019-0.143l-0.206-3.869c-0.004-0.083,0.002-0.167,0.02-0.248 l0.185-0.843c0.053-0.242,0.201-0.453,0.411-0.585l2.114-1.333l0.399-0.398l0.392-0.483l0.127-0.304l0.191-0.798l0.028-0.265 l-0.013-0.095l-0.085-0.154l-0.069-0.086l-0.376-0.287c-0.079-0.06-0.147-0.132-0.203-0.213l-1.348-1.969l-1.328-2.061 l-0.043-0.027l-0.07-0.026l-1.14,0.35c-0.052,0.016-0.106,0.027-0.16,0.034l-1.8,0.218l-1.279,0.353l-0.077,0.038l-0.491,0.453 l-0.268,0.287c-0.038,0.041-0.081,0.079-0.126,0.112l-0.518,0.383c-0.038,0.028-0.079,0.054-0.121,0.076l-0.342,0.179 c-0.082,0.043-0.169,0.073-0.26,0.09l-0.457,0.085c-0.056,0.01-0.113,0.016-0.17,0.016c-0.016,0-0.031,0-0.047-0.001l-0.509-0.026 c-0.073-0.004-0.146-0.016-0.217-0.037l-0.81-0.241c-0.096-0.028-0.186-0.072-0.268-0.13l-0.367-0.257 c-0.05-0.035-0.096-0.074-0.138-0.118l-0.431,0.147c-0.083,0.028-0.17,0.045-0.259,0.049l-0.621,0.027l-2.132,0.739 c-0.098,0.034-0.201,0.051-0.304,0.051c-0.076,0-0.153-0.009-0.228-0.028c-0.05-0.013-0.136-0.039-0.183-0.06l-0.482-0.212 c-0.041-0.018-0.081-0.039-0.119-0.063l-0.056-0.035l-0.093,0.034c-0.103,0.038-0.212,0.057-0.32,0.057 c-0.096,0-0.192-0.015-0.284-0.045l-2.723-0.878c-0.247-0.08-0.449-0.259-0.558-0.495c-0.108-0.236-0.112-0.507-0.012-0.746 l1.107-2.628l0.124-0.557l0.042-0.393l-0.177-0.518c-0.034-0.1-0.051-0.206-0.05-0.312l0.008-0.645 c0.001-0.079,0.012-0.157,0.033-0.232l0.113-0.415c0.007-0.027,0.016-0.053,0.025-0.079l0.663-1.78 c0.054-0.145,0.143-0.274,0.26-0.376l1.491-1.297l0.216-0.455l0.034-0.184c0.009-0.046,0.021-0.092,0.036-0.136l0.124-0.354 c0.054-0.154,0.147-0.29,0.27-0.396l0.234-0.201c0.084-0.073,0.181-0.129,0.286-0.168l0.466-0.17l0.267-0.676l-0.322-0.558 l-0.568-0.325l-0.433-0.166c-0.033-0.013-0.066-0.027-0.098-0.044l-0.651-0.34c-0.044-0.023-0.086-0.049-0.125-0.079l-2.722-2.031 c-0.037-0.027-0.071-0.057-0.103-0.09l-0.413-0.416c-0.077-0.078-0.14-0.169-0.186-0.269l-0.17-0.373 c-0.095-0.21-0.109-0.447-0.039-0.666l0.124-0.387c0.009-0.03,0.021-0.059,0.033-0.087l0.116-0.267l0.201-0.661 c0.023-0.076,0.056-0.148,0.097-0.216l0.565-0.92l0.098-0.796l-0.186-0.264l-3.797-1.763l-0.728-0.253l-0.356-0.061l-0.571-0.016 l-0.463,0.033l-0.663,0.13l-0.127,0.045l-0.078,0.041L73,477.194l-0.056,0.074c-0.109,0.145-0.259,0.255-0.43,0.316l-0.832,0.295 c-0.078,0.028-0.159,0.045-0.241,0.051l-1.198,0.09l-1.054,0.221l-0.158,0.093l-0.68,0.541c-0.066,0.053-0.14,0.096-0.218,0.129 l-1.339,0.562c-0.114,0.048-0.236,0.072-0.358,0.072c-0.017,0-0.033,0-0.049-0.001l-1.23-0.066l-1.978,0.707 c-0.088,0.032-0.181,0.05-0.275,0.053l-0.833,0.033c-0.012,0-0.024,0.001-0.037,0.001c-0.035,0-0.07-0.002-0.104-0.006 l-1.042-0.118c-0.065-0.007-0.129-0.022-0.191-0.043l-1.599-0.539l-1.369-0.323c-0.058-0.014-0.115-0.033-0.17-0.058l-1.347-0.611 c-0.104-0.047-0.199-0.114-0.279-0.195l-0.421-0.43c-0.069-0.071-0.126-0.152-0.17-0.24l-0.185-0.378 c-0.05-0.102-0.081-0.212-0.091-0.325l-0.126-1.401l-0.066-0.21l-3.216-4.634c-0.037-0.053-0.068-0.109-0.092-0.168l-0.784-1.859 c-0.027-0.064-0.047-0.13-0.059-0.198l-0.075-0.425c-0.012-0.066-0.016-0.133-0.013-0.199l0.018-0.43 c0.002-0.059,0.01-0.117,0.024-0.175l0.099-0.42c0.009-0.036,0.019-0.072,0.032-0.107l0.56-1.526l0.104-0.407l0.013-0.307 l-0.048-0.305l-0.536-1.553c-0.012-0.033-0.021-0.067-0.029-0.102l-0.235-1.058c-0.008-0.036-0.014-0.073-0.018-0.11l-0.055-0.557 l-1.126-1.129l-3.583-2.388l0.136,0.222c0.042,0.069,0.075,0.144,0.098,0.222l0.211,0.718l0.178,0.713 c0.019,0.076,0.028,0.153,0.027,0.231l-0.013,1.646c-0.001,0.107-0.02,0.213-0.058,0.314l-0.067,0.181 c-0.014,0.038-0.03,0.074-0.049,0.11l0.012,0.105c0.005,0.042,0.006,0.085,0.005,0.127l-0.009,0.344 c-0.002,0.067-0.011,0.135-0.028,0.2l-0.063,0.251c-0.079,0.313-0.315,0.563-0.623,0.659l-0.785,0.244l-0.64,0.42 c-0.126,0.083-0.271,0.134-0.421,0.148l-0.435,0.041c-0.029,0.003-0.058,0.004-0.087,0.004c-0.089,0-0.177-0.013-0.262-0.038 l-0.745-0.22c-0.051-0.015-0.102-0.035-0.15-0.059l-1.626-0.807c-0.044-0.022-0.087-0.048-0.127-0.076l-0.398-0.285 c-0.052-0.037-0.1-0.079-0.143-0.126l-0.669-0.727c-0.071-0.077-0.128-0.166-0.17-0.262l-0.354-0.825l-0.181-0.418l0.124,0.391 c0.09,0.286,0.037,0.597-0.144,0.836c-0.175,0.233-0.449,0.369-0.74,0.369c-0.008,0-0.017,0-0.025,0l-1.039-0.028 c-0.291-0.008-0.562-0.152-0.731-0.39l-0.93-1.311c-0.013-0.018-0.025-0.036-0.036-0.055l-0.718-1.184 c-0.025-0.041-0.046-0.083-0.064-0.127l-0.507-1.226l-0.143-0.357l-0.593,0.359l-0.9,0.859l-0.807,0.763 c-0.087,0.082-0.189,0.147-0.3,0.19l-0.708,0.276l-0.94,1.37c-0.018,0.026-0.037,0.051-0.057,0.074l-1.144,1.352l-1.127,1.416 c-0.178,0.224-0.446,0.349-0.724,0.349c-0.074,0-0.15-0.009-0.224-0.028l-0.156-0.039l-0.094,0.171l-0.371,2.064 c-0.007,0.038-0.016,0.075-0.027,0.111l-0.643,2.066c-0.121,0.388-0.479,0.651-0.884,0.651c-0.005,0-0.011,0-0.016,0 c-0.372-0.006-0.7-0.234-0.84-0.571l-0.528,1.053l-1.318,2.378l-0.356,1.197c-0.08,0.268-0.276,0.486-0.535,0.593l-0.81,0.334 l-0.202,0.729c-0.013,0.046-0.029,0.091-0.049,0.135l-0.564,1.246l-0.428,0.921l0.1,1.646l0.379,1.48 c0.005,0.02,0.01,0.041,0.014,0.061l0.387,2.093l0.536,1.484c0.024,0.065,0.04,0.133,0.048,0.202l0.02,0.163l0.18-0.286 c0.083-0.132,0.198-0.241,0.335-0.317l0.503-0.279c0.139-0.077,0.293-0.116,0.449-0.116c0.102,0,0.205,0.017,0.304,0.051 l0.455,0.158c0.106,0.037,0.205,0.093,0.291,0.165l0.47,0.394c0.048,0.04,0.092,0.085,0.131,0.134l0.372,0.469 c0.06,0.076,0.108,0.161,0.142,0.251l0.149,0.398c0.049,0.132,0.068,0.273,0.054,0.412l-0.052,0.545 c-0.003,0.033-0.008,0.066-0.015,0.099l-0.215,1.067l-0.055,0.639c-0.003,0.039-0.009,0.078-0.017,0.116l-0.176,0.817l0.014,0.44 h0.034l0.134-0.076l0.156-0.315c0.044-0.089,0.103-0.171,0.173-0.242l0.18-0.181c0.175-0.176,0.412-0.273,0.656-0.273 c0.049,0,0.098,0.004,0.146,0.012c0.294,0.047,0.548,0.233,0.681,0.499l0.135,0.268c0.061,0.121,0.094,0.254,0.098,0.39 l0.011,0.404c0.004,0.128-0.02,0.256-0.068,0.375l-0.123,0.301c-0.025,0.062-0.057,0.121-0.095,0.176l-0.085,0.123l-0.019,0.235 l0.248,0.521c0.096,0.201,0.116,0.43,0.057,0.644l-0.321,1.164c-0.039,0.141-0.111,0.271-0.209,0.379l-0.451,0.493l-0.112,0.463 l-0.037,0.221l0.024,0.542c0.02,0.457-0.296,0.859-0.744,0.949l-0.436,0.087c-0.06,0.012-0.121,0.018-0.181,0.018 c-0.093,0-0.186-0.014-0.276-0.042l-0.465-0.145c-0.098-0.03-0.189-0.077-0.272-0.137l-0.436-0.32 c-0.059-0.043-0.112-0.093-0.159-0.148l-0.169-0.199l-1.113-0.137c-0.029-0.004-0.058-0.009-0.086-0.015l-0.943-0.208l-1.463-0.101 c-0.052-0.004-0.104-0.012-0.154-0.024l-0.975-0.236c-0.056-0.014-0.11-0.032-0.162-0.056l-0.779-0.351l-0.75-0.163l-0.639,0.078 c-0.037,0.004-0.074,0.007-0.112,0.007c-0.049,0-0.097-0.004-0.145-0.011l-0.854-0.136l-1.746,0.391l-0.721,0.585l-0.583,0.625 l-0.92,1.053c-0.014,0.016-0.028,0.031-0.042,0.045l-1.114,1.115l-0.541,0.735l-0.682,1.322c-0.048,0.093-0.111,0.177-0.187,0.249 l-0.806,0.761c-0.116,0.109-0.257,0.187-0.412,0.225l-0.844,0.211l-0.428,0.16l-0.085,0.106l-0.058,0.196l0.143,0.238l0.522,0.557 l1.063,0.669l0.361,0.173c0.016,0.008,0.032,0.016,0.047,0.024l0.994,0.55c0.062,0.035,0.121,0.076,0.173,0.124l0.234,0.212 l0.312,0.045c0.183,0.026,0.355,0.107,0.492,0.232l0.465,0.423c0.001,0.001,0.002,0.002,0.003,0.003l0.269-0.121l0.57-0.272 c0.125-0.06,0.262-0.09,0.399-0.09c0.084,0,0.168,0.011,0.25,0.034l0.292,0.082c0.255,0.071,0.467,0.249,0.583,0.487l0.336,0.691 c0.063,0.129,0.095,0.27,0.093,0.413l-0.007,0.866c0,0.032-0.002,0.063-0.006,0.095l-0.087,0.78l0.024,0.32l0.145,0.178l0.48,0.307 c0.037,0.024,0.073,0.05,0.106,0.079l0.565,0.487c0.118,0.101,0.208,0.231,0.263,0.377l0.306,0.818 c0.08,0.212,0.076,0.437,0.005,0.636l1.61,1.104c0.089,0.061,0.166,0.137,0.229,0.224l0.885,1.234l1.25,1.008 c0.083,0.067,0.154,0.148,0.21,0.24l0.469,0.772c0.02,0.034,0.039,0.069,0.055,0.105l0.407,0.915l0.551,0.738l0.663,0.516 l0.699,0.216l0.436-0.072l0.577-0.183c0.091-0.029,0.185-0.043,0.28-0.043c0.089,0,0.178,0.013,0.264,0.039l0.428,0.128 c0.364,0.108,0.625,0.428,0.658,0.806l0.067,0.755l0.066,0.178l0.826,0.872c0.026,0.027,0.049,0.056,0.072,0.085 c0.032-0.006,0.064-0.01,0.096-0.013l0.685-0.057c0.025-0.002,0.051-0.003,0.076-0.003c0.07,0,0.139,0.008,0.207,0.023l2.53,0.581 c0.132,0.03,0.255,0.089,0.362,0.172l0.323,0.252l0.512,0.4c0.043,0.033,0.083,0.07,0.119,0.111l4.239,4.712l0.937,0.706 l0.712,0.346l2.63,0.709c0.067,0.018,0.132,0.044,0.193,0.076l0.934,0.496c0.043,0.023,0.085,0.05,0.124,0.079l5.871,4.439 l1.663,0.809l3.042,0.111c0.1,0.004,0.199,0.024,0.293,0.059l2.956,1.114l0.098,0.002l0.023-0.012 c0.133-0.07,0.281-0.106,0.43-0.106c0.04,0,0.079,0.003,0.119,0.008l0.219,0.028c0.211,0.027,0.406,0.126,0.553,0.281l0.444,0.467 c0.09,0.095,0.159,0.208,0.202,0.331l0.163,0.465c0.037,0.107,0.055,0.22,0.052,0.333l-0.011,0.406l0.014,0.075l0.116,0.099 l0.853,0.329l0.816,0.184l0.728,0.013l0.744-0.153l3.572-1.357c0.105-0.04,0.217-0.06,0.329-0.06c0.003,0,0.005,0,0.008,0 l1.128,0.009c0.205,0.002,0.403,0.071,0.564,0.198l1.364,1.072c0.201,0.158,0.327,0.391,0.35,0.645l0.276,3.047l0.739,1.093 l2.772,1.913l1.34,0.532l1.091-0.153l0.218-0.031c0.043-0.006,0.086-0.009,0.129-0.009c0.076,0,0.151,0.009,0.225,0.028 l1.885,0.472c0.323,0.081,0.578,0.329,0.667,0.65l0.616,2.213c0.017,0.063,0.028,0.127,0.032,0.192l0.287,4.706l0.389,1.443 c0.009,0.035,0.017,0.07,0.022,0.106l0.184,1.254l0.336,0.829l0.917,0.704l1.396,0.512l4.79,0.972 c0.044,0.009,0.088,0.021,0.131,0.037l0.861,0.312c0.037,0.013,0.073,0.029,0.107,0.047l0.597,0.306l0.475,0.142l0.691-0.039 l2.169-0.814c0.051-0.019,0.104-0.034,0.157-0.044l0.793-0.146c0.029-0.005,0.057-0.009,0.086-0.012l0.017-0.088 c0.039-0.199,0.142-0.38,0.293-0.514L89.977,559.282z").attr({id: 'narino', class: 'st15', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#E8853A'}).data({'id': 'narino', 'region':'nariño', 'benefited-companies':'8', 'benefited-projects': '$220.000.000'});

        var vaupes = rsr.path("M452.935,547.057l-0.369-0.759l-0.104-0.095l-0.864-0.405c-0.09-0.042-0.173-0.099-0.245-0.167 l-0.368-0.349c-0.135-0.128-0.228-0.293-0.267-0.474l-0.137-0.63c-0.061-0.278,0.01-0.569,0.192-0.788l0.331-0.399 c0.048-0.057,0.102-0.109,0.162-0.153l0.341-0.253l0.072-0.112v-0.675l-0.428-1.938c-0.022-0.098-0.027-0.198-0.017-0.298 l0.102-0.953c0.031-0.29,0.197-0.548,0.447-0.698l0.249-0.148l-0.953-0.368c-0.115-0.044-0.219-0.111-0.308-0.196l-0.735-0.706 c-0.218-0.21-0.32-0.513-0.274-0.812l0.163-1.043l-0.476-0.295c-0.195-0.121-0.339-0.31-0.402-0.531l-0.135-0.467 c-0.016-0.057-0.027-0.116-0.033-0.175l-0.039-0.443l-0.03-0.104l-0.102-0.101l-0.7-0.465c-0.079-0.053-0.15-0.117-0.21-0.192 l-0.698-0.87l-0.504-0.355l-2.102-1.081l-0.404-0.073l-0.358,0.092l-2.017,1.466c-0.159,0.116-0.35,0.177-0.544,0.177 c-0.055,0-0.11-0.005-0.166-0.015l-0.468-0.085c-0.109-0.02-0.213-0.059-0.308-0.115l-0.861-0.512 c-0.051-0.03-0.099-0.066-0.144-0.105l-0.233-0.208c-0.057-0.051-0.107-0.108-0.15-0.172l-0.093-0.137l-0.024-0.025l-0.127-0.06 l-0.165-0.021l-1.329,0.19c-0.039,0.006-0.078,0.009-0.117,0.009l-1.501,0.023c-0.005,0-0.01,0-0.015,0 c-0.037,0-0.074-0.002-0.111-0.007l-0.472-0.057c-0.066-0.008-0.131-0.023-0.193-0.045l-1.853-0.643l-0.834-0.03l-4.306,0.635 c-0.045,0.007-0.09,0.01-0.135,0.01c-0.07,0-0.14-0.008-0.209-0.024l-0.479-0.111c-0.396-0.092-0.686-0.431-0.715-0.837 l-0.032-0.456l-0.199-0.034l-0.386-0.017l-0.868,0.238l-1.783,1.154c-0.15,0.097-0.325,0.149-0.503,0.149 c-0.029,0-0.058-0.001-0.088-0.004l-1.043-0.099c-0.477-0.045-0.841-0.447-0.838-0.926l0.012-2.733l0.018-3.14l0.02-3.135 l0.015-3.138l0.019-3.139l0.017-3.14l0.017-3.137l0.017-3.138l0.02-3.049l-0.315-1.661l-0.434-0.228l-1.818-0.556l-2.076-0.151 c-0.083-0.006-0.165-0.023-0.244-0.051l-1.398-0.498c-0.039-0.014-0.078-0.031-0.115-0.05l-2.295-1.187 c-0.059-0.031-0.115-0.068-0.166-0.11l-4.858-4.037c-0.107-0.089-0.193-0.202-0.251-0.329l-0.333-0.732 c-0.069-0.152-0.096-0.319-0.077-0.484l0.085-0.774c0.009-0.086,0.031-0.17,0.064-0.25l1.928-4.707l0.445-2.14l-0.29,0.202 l-1.006,0.989c-0.033,0.032-0.068,0.062-0.105,0.089l-0.578,0.42c-0.053,0.038-0.109,0.071-0.169,0.097l-0.803,0.356 c-0.084,0.037-0.172,0.062-0.263,0.073l-2.595,0.317l-1.945,0.468l-1.56,0.542c-0.061,0.021-0.124,0.036-0.189,0.044l-0.901,0.113 c-0.038,0.005-0.077,0.007-0.115,0.007c-0.002,0-0.004,0-0.005,0l-0.633-0.004l-0.294,0.127c-0.113,0.048-0.234,0.074-0.357,0.075 l-0.704,0.007l-1.612,0.237l-0.525,0.272l-0.608,0.576c-0.029,0.028-0.06,0.053-0.093,0.077l-0.429,0.312 c-0.044,0.032-0.09,0.059-0.138,0.083l-0.591,0.288c-0.071,0.035-0.146,0.06-0.223,0.075l-1.656,0.334l-0.871,0.339 c-0.043,0.017-0.086,0.03-0.131,0.04l-2.912,0.661l-1.299,0.704c-0.087,0.047-0.182,0.08-0.279,0.098l-0.796,0.142 c-0.036,0.006-0.073,0.011-0.11,0.013l-0.703,0.04c-0.017,0.001-0.035,0.001-0.053,0.001c-0.031,0-0.062-0.002-0.093-0.005 l-0.629-0.064c-0.065-0.007-0.129-0.02-0.191-0.04l-0.526-0.17c-0.065-0.021-0.127-0.049-0.185-0.083l-0.324-0.191l-0.398-0.097 c-0.036-0.009-0.072-0.02-0.107-0.033l-0.22-0.083l-0.279,0.068c-0.071,0.017-0.144,0.026-0.218,0.026 c-0.029,0-0.057-0.001-0.086-0.004l-1.697-0.158l-4.143,0.133c-0.01,0-0.02,0-0.03,0c-0.083,0-0.167-0.011-0.247-0.034 l-0.263-0.073l-0.522,0.735c-0.031,0.044-0.065,0.084-0.103,0.122l-1.851,1.832c-0.042,0.042-0.088,0.079-0.137,0.112l-1.155,0.772 c-0.025,0.016-0.05,0.032-0.076,0.046l-1.523,0.819c-0.039,0.021-0.08,0.039-0.121,0.054l-2.282,0.833l-3.633,1.925l-2.056,1.532 l-0.75,0.792c-0.028,0.029-0.058,0.057-0.089,0.083l-0.972,0.788c-0.023,0.019-0.047,0.036-0.072,0.053l-0.792,0.524 c-0.152,0.101-0.33,0.154-0.511,0.154c-0.047,0-0.094-0.004-0.141-0.011l-0.859-0.132c-0.052-0.008-0.103-0.02-0.153-0.037 l-0.458-0.153c-0.151-0.051-0.287-0.14-0.394-0.258l-0.732-0.812l-1.347-0.483c-0.092-0.033-0.178-0.08-0.255-0.14l-0.591-0.458 l-0.14,2.752c-0.002,0.03-0.005,0.06-0.009,0.09l-0.187,1.256c-0.005,0.037-0.013,0.073-0.023,0.109l-0.279,1.01 c-0.034,0.122-0.092,0.236-0.171,0.334l-1.205,1.498l-0.276,0.558l-0.375,1.477c-0.012,0.046-0.027,0.091-0.046,0.135l-0.972,2.28 c-0.014,0.033-0.03,0.065-0.047,0.095l-0.471,0.826l-0.205,1.05c-0.005,0.027-0.012,0.055-0.02,0.082l-0.365,1.253 c-0.01,0.034-0.022,0.067-0.035,0.1l-2.101,5.004c-0.051,0.122-0.128,0.232-0.225,0.322l-0.164,0.151l-0.018,0.09l-0.027,0.338 l0.045,0.981c0.002,0.036,0.001,0.072-0.001,0.108l-0.022,0.312l0.519,0.899c0.018,0.031,0.034,0.063,0.048,0.095l0.156,0.362 l0.522,0.873c0.015,0.025,0.028,0.05,0.041,0.076l0.269,0.562l0.331,0.438c0.051,0.067,0.092,0.14,0.122,0.218l0.221,0.559 c0.074,0.187,0.085,0.393,0.031,0.587l-0.117,0.422c-0.086,0.312-0.329,0.556-0.64,0.644l-0.491,0.139 c-0.083,0.023-0.168,0.035-0.253,0.035c-0.109,0-0.218-0.019-0.321-0.058l-0.549-0.203c-0.151-0.056-0.285-0.15-0.388-0.273 l-0.196-0.233c-0.16,0.127-0.362,0.201-0.575,0.201c-0.038,0-0.077-0.002-0.116-0.007l-0.147-0.018l-0.007,0.112l0.036,0.398 c0.006,0.069,0.005,0.138-0.004,0.206l-0.06,0.451c-0.014,0.105-0.046,0.208-0.095,0.302l-0.579,1.123 c-0.019,0.036-0.04,0.072-0.063,0.105l-0.471,0.675c-0.057,0.082-0.127,0.154-0.207,0.214l-0.788,0.586l-1.983,2.077 c-0.108,0.113-0.242,0.196-0.391,0.243l-0.544,0.172c-0.09,0.029-0.185,0.043-0.279,0.043c-0.026,0-0.052-0.001-0.078-0.003 l-0.499-0.042c-0.092-0.008-0.182-0.029-0.267-0.064l-0.496-0.199l-0.435-0.062l-0.443,0.097l-0.359,0.29l-0.564,0.865 l-0.263,0.694c-0.018,0.049-0.041,0.096-0.068,0.141l-0.366,0.623c-0.036,0.061-0.079,0.118-0.128,0.169l-1.396,1.468 c-0.029,0.031-0.06,0.059-0.094,0.086l-1.357,1.082l-7.745,8.09c0.04,0.05,0.075,0.104,0.103,0.162l0.505,1.008 c0.043,0.086,0.072,0.177,0.087,0.272l0.266,1.698l0.13,0.31c0.024-0.017,0.049-0.034,0.075-0.049l0.327-0.191 c0.145-0.085,0.306-0.127,0.468-0.127c0.18,0,0.359,0.052,0.515,0.156l0.784,0.524c0.079,0.053,0.15,0.118,0.209,0.192l0.498,0.623 c0.058,0.072,0.105,0.153,0.139,0.239l0.282,0.718c0.046,0.118,0.068,0.244,0.064,0.371l-0.025,0.722 c-0.006,0.173-0.06,0.34-0.156,0.484l-0.262,0.391l-0.001,0.34l1.081,0.865l1.757,1.086c0.046,0.028,0.089,0.06,0.129,0.096 l0.984,0.875c0.215,0.191,0.329,0.471,0.308,0.758l-0.047,0.656c-0.005,0.067-0.017,0.133-0.036,0.197l-0.204,0.688l0.709-0.508 c0.159-0.114,0.348-0.173,0.539-0.173c0.069,0,0.138,0.008,0.207,0.023l0.669,0.153c0.236,0.054,0.442,0.199,0.573,0.403l0.513,0.8 c0.031,0.048,0.057,0.098,0.078,0.151l0.282,0.693l0.262,0.332l0.802,0.258c0.087,0.028,0.169,0.069,0.244,0.12l0.538,0.373 c0.113,0.078,0.207,0.181,0.276,0.3l0.893,1.555l0.375,0.413l4.406,2.09c0.039,0.018,0.076,0.04,0.112,0.063l2.041,1.344 l0.021-0.001l0.32-0.178c0.053-0.029,0.108-0.054,0.166-0.072l0.725-0.234c0.092-0.03,0.188-0.045,0.284-0.045 c0.019,0,0.039,0.001,0.058,0.002l0.452,0.028c0.082,0.005,0.162,0.021,0.239,0.047l0.714,0.242l0.168,0.025l0.332-0.046 l1.383-0.361c0.077-0.02,0.155-0.03,0.234-0.03c0.065,0,0.13,0.007,0.194,0.021l0.494,0.106c0.109,0.023,0.212,0.066,0.306,0.126 l0.97,0.622l1.47,0.507c0.127,0.044,0.243,0.114,0.339,0.207l1.392,1.336l0.949,0.911l0.492,0.25l0.592,0.195l0.582,0.081 l0.495-0.037l1.745-0.767c0.112-0.049,0.233-0.076,0.356-0.078l0.911-0.017c0.006,0,0.011,0,0.017,0 c0.294,0,0.572,0.14,0.746,0.378l0.684,0.932c0.076,0.104,0.13,0.223,0.158,0.349l0.385,1.75l0.215,0.359l0.653,0.292l0.873,0.282 c0.042,0.014,0.083,0.03,0.123,0.05l1.686,0.827l0.564,0.166l0.185-0.027l0.85-0.394c0.122-0.057,0.255-0.086,0.39-0.086 c0.006,0,0.013,0,0.019,0l0.583,0.012c0.168,0.003,0.331,0.052,0.473,0.141l0.568,0.356c0.071,0.044,0.135,0.098,0.191,0.159 l0.575,0.628c0.029,0.032,0.056,0.065,0.08,0.1l1.351,1.963c0.026,0.038,0.049,0.077,0.069,0.118l0.34,0.694 c0.025,0.051,0.046,0.105,0.061,0.16l0.201,0.725c0.019,0.069,0.03,0.14,0.033,0.211l0.031,0.788 c0.004,0.094-0.007,0.188-0.032,0.279l-0.222,0.816c-0.016,0.057-0.036,0.112-0.062,0.165l-0.151,0.307l0.001,0.008l1.579,1.97 c0.066,0.082,0.117,0.175,0.152,0.275l1.043,3.001l1.07,2.281l0.045,0.07l1.33,0.023l0.447-0.086l0.137-0.095l0.147-0.423 c0.016-0.046,0.036-0.091,0.059-0.134l0.428-0.8c0.151-0.281,0.435-0.465,0.753-0.487l0.895-0.061 c0.021-0.001,0.042-0.002,0.063-0.002c0.101,0,0.201,0.017,0.297,0.049l1.023,0.347c0.047,0.016,0.092,0.035,0.135,0.058 l0.799,0.422c0.052,0.027,0.101,0.059,0.146,0.096l1.23,0.986l0.248,0.116l0.204,0.012l0.925-0.18 c0.059-0.011,0.118-0.017,0.177-0.017c0.012,0,0.025,0,0.037,0.001l0.526,0.021c0.15,0.006,0.296,0.048,0.426,0.123l0.65,0.375 c0.1,0.057,0.188,0.133,0.26,0.223l0.749,0.934l0.235,0.095l2.081-0.158c0.023-0.002,0.047-0.003,0.07-0.003 c0.068,0,0.137,0.008,0.204,0.023l0.742,0.167c0.116,0.026,0.226,0.075,0.324,0.143l0.731,0.507 c0.06,0.042,0.115,0.091,0.164,0.145l0.699,0.786c0.033,0.038,0.064,0.078,0.091,0.12l0.565,0.892 c0.031,0.05,0.058,0.102,0.08,0.157l0.321,0.816c0.045,0.115,0.067,0.237,0.064,0.361l-0.018,0.746 c-0.001,0.036-0.004,0.072-0.009,0.108l1.086-0.047c0.013-0.001,0.027-0.001,0.04-0.001c0.066,0,0.132,0.007,0.196,0.021 l2.211,0.479l0.228-0.038l-0.077-0.809c-0.024-0.248,0.053-0.495,0.214-0.685l0.49-0.58c0.075-0.089,0.167-0.164,0.27-0.219 l0.919-0.493c0.054-0.029,0.11-0.052,0.168-0.07l0.837-0.255c0.087-0.027,0.178-0.04,0.27-0.04c0.002,0,0.003,0,0.005,0 l0.867,0.005c0.082,0,0.164,0.012,0.244,0.034l1.016,0.283c0.066,0.018,0.129,0.044,0.189,0.076l1.051,0.564 c0.211,0.113,0.37,0.304,0.444,0.532l0.169,0.524c0.092,0.286,0.04,0.599-0.14,0.839l-0.41,0.548 c-0.033,0.043-0.069,0.084-0.108,0.121l-2.798,2.622l-0.413,0.563l0.739-0.051c0.021-0.002,0.043-0.002,0.064-0.002 c0.22,0,0.434,0.079,0.603,0.223l0.721,0.618c0.143,0.123,0.245,0.286,0.293,0.469l0.198,0.758c0.023,0.087,0.033,0.178,0.03,0.268 l-0.034,0.942c-0.001,0.032-0.004,0.064-0.008,0.096l-0.238,1.683l0.005,0.671l0.111,0.566l0.461,1.394 c0.044,0.133,0.057,0.274,0.039,0.412l-0.092,0.694c-0.032,0.238-0.154,0.454-0.342,0.603l-0.576,0.458 c-0.033,0.026-0.067,0.05-0.103,0.071l-0.563,0.335l-0.078,0.096l0.236,0.956l1.242,1.304c0.04,0.042,0.077,0.088,0.108,0.137 l0.938,1.456c0.197,0.306,0.197,0.699-0.001,1.004l-1.006,1.558c-0.075,0.116-0.175,0.214-0.292,0.286l-1.258,0.774l-0.262,0.282 l-0.06,0.268l0.161,0.503l0.478,0.745l0.361,0.286l0.149-0.028l0.918-0.871c0.087-0.083,0.189-0.148,0.301-0.191l0.618-0.241 c0.11-0.043,0.224-0.063,0.336-0.063c0.34,0,0.665,0.188,0.827,0.508l0.307,0.607c0.093,0.184,0.122,0.394,0.082,0.597 l-0.125,0.637c-0.015,0.078-0.04,0.153-0.075,0.224l-0.512,1.06l-0.003,0.032l0.068,0.075l2.027,1.602l0.507,0.133l0.558-0.08 l0.396-0.251l0.112-0.227l-0.256-0.6l-1.009-0.798c-0.082-0.065-0.152-0.143-0.208-0.231l-0.654-1.031 c-0.207-0.326-0.189-0.747,0.044-1.055l1.108-1.463c0.081-0.107,0.185-0.196,0.304-0.259l0.752-0.399 c0.131-0.07,0.278-0.107,0.426-0.108l0.559-0.005c0.003,0,0.005,0,0.008,0c0.151,0,0.299,0.037,0.433,0.107l0.885,0.467 l0.072,0.029l0.045,0.012l0.243-0.143l0.315-0.406c0.062-0.079,0.136-0.148,0.22-0.204l0.456-0.302 c0.154-0.102,0.332-0.154,0.511-0.154c0.141,0,0.283,0.032,0.413,0.097l1.069,0.533l0.241-0.067l0.598-0.335 c0.032-0.018,0.066-0.034,0.1-0.048l0.7-0.288c0.104-0.043,0.215-0.066,0.327-0.069l1.035-0.028c0.008,0,0.017,0,0.025,0 c0.299,0,0.58,0.144,0.754,0.389l0.266,0.373c0.173,0.242,0.218,0.553,0.123,0.835l-0.195,0.573 c-0.022,0.064-0.051,0.126-0.086,0.184l-0.354,0.581c-0.031,0.05-0.066,0.097-0.105,0.141l-0.215,0.236 c-0.032,0.035-0.066,0.068-0.103,0.097l-0.504,0.407l-0.042,0.052l0.021,0.469c0.002,0.044,0.001,0.088-0.003,0.132l-0.028,0.29 c-0.01,0.1-0.036,0.198-0.077,0.29l-0.546,1.212l0.148,0.117l0.345,0.035l0.416-0.226l0.62-0.519 c0.037-0.031,0.077-0.059,0.118-0.084l0.717-0.43c0.14-0.084,0.299-0.129,0.462-0.132l1.112-0.016c0.005,0,0.009,0,0.014,0 c0.118,0,0.235,0.023,0.345,0.067l1.892,0.759h0.446l0.029-0.024l0.284-0.951c0.032-0.108,0.084-0.209,0.152-0.298l0.376-0.491 c0.113-0.147,0.267-0.257,0.442-0.315l0.702-0.234c0.095-0.031,0.194-0.047,0.293-0.047c0.06,0,0.121,0.006,0.181,0.018l0.69,0.137 c0.1,0.02,0.197,0.056,0.285,0.108l0.632,0.368c0.055,0.032,0.106,0.069,0.153,0.112l1.861,1.673 c0.036,0.032,0.069,0.067,0.099,0.104l0.582,0.715c0.081,0.099,0.14,0.215,0.174,0.338l0.214,0.774 c0.041,0.148,0.044,0.303,0.01,0.453l-0.183,0.8c-0.012,0.051-0.028,0.102-0.048,0.15l-0.284,0.68l-0.154,0.536l0.054,0.584 l0.134,0.335l2.092-1.209c0.141-0.082,0.301-0.124,0.463-0.124c0.039,0,0.077,0.002,0.116,0.007l0.674,0.085 c0.104,0.013,0.204,0.044,0.298,0.09l3.057,1.528l0.498,0.059c0.053,0.006,0.106,0.017,0.157,0.032l0.204,0.061 c0.038,0.011,0.074,0.025,0.11,0.041l0.462,0.206c0.116,0.052,0.221,0.127,0.307,0.221l0.284,0.309 c0.089,0.097,0.156,0.211,0.197,0.336l0.14,0.424l0.404,0.473l0.311-0.802l-0.35-0.952l-1.671-2.69 c-0.089-0.144-0.138-0.309-0.139-0.479l-0.006-0.533c-0.001-0.096,0.013-0.192,0.041-0.284l0.276-0.892l0.06-0.309l-0.219-1.577 l-0.142-0.022c-0.166-0.026-0.322-0.096-0.451-0.203l-0.279-0.231c-0.065-0.054-0.123-0.117-0.171-0.187l-0.893-1.297l-0.202-0.128 l-0.928-0.396c-0.083-0.035-0.16-0.082-0.229-0.14l-0.38-0.316c-0.099-0.083-0.181-0.185-0.238-0.302l-0.303-0.614 c-0.072-0.145-0.104-0.306-0.094-0.468l0.028-0.458c0.004-0.058,0.013-0.116,0.027-0.172l0.07-0.273l-0.017-0.182l-0.089-0.163 l-0.099-0.078l-0.252-0.129c-0.071-0.036-0.136-0.081-0.195-0.134l-0.305-0.274c-0.063-0.057-0.119-0.122-0.164-0.194l-0.413-0.651 c-0.054-0.086-0.094-0.18-0.118-0.278l-0.111-0.458c-0.026-0.106-0.032-0.215-0.02-0.323l0.1-0.873l-0.168-0.299l-1.654-1.865 c-0.066-0.074-0.12-0.159-0.159-0.251l-0.458-1.071c-0.091-0.214-0.099-0.454-0.021-0.673l0.293-0.826 c0.025-0.071,0.059-0.139,0.101-0.202l1.344-2.029l0.197-0.715l-0.034-0.153l-0.133-0.194l-0.267-0.311 c-0.046-0.054-0.086-0.113-0.119-0.176l-0.241-0.463c-0.039-0.075-0.068-0.155-0.085-0.239l-0.093-0.448 c-0.012-0.057-0.018-0.115-0.019-0.173l-0.021-1.267l-0.177-0.849l-0.297-0.742l-0.434-0.623l-0.63-0.538l-0.632-0.339 l-3.593-1.342c-0.093-0.035-0.18-0.084-0.257-0.147l-0.69-0.557c-0.036-0.029-0.07-0.061-0.102-0.096l-1.296-1.417l-0.321-0.226 l-0.977-0.456c-0.049-0.023-0.096-0.05-0.141-0.081l-0.457-0.321c-0.08-0.056-0.15-0.124-0.208-0.202l-0.343-0.458 c-0.046-0.061-0.084-0.127-0.113-0.197l-0.392-0.933l-0.133-0.194l-0.485-0.307l-1.657-0.371c-0.047-0.01-0.092-0.024-0.137-0.042 l-0.852-0.335c-0.092-0.036-0.177-0.086-0.253-0.149l-0.49-0.406c-0.068-0.057-0.128-0.123-0.177-0.196l-0.957-1.423l-2.243-2.054 c-0.026-0.024-0.05-0.049-0.074-0.076l-1.772-2.039c-0.042-0.048-0.078-0.1-0.109-0.155l-0.533-0.953 c-0.053-0.094-0.088-0.196-0.106-0.303l-0.263-1.61c-0.009-0.057-0.013-0.116-0.012-0.174l0.06-2.293l0.031-1.166l0.085-3.069 l0.123-4.338l0.137-4.973l0.132-4.974l0.123-4.339l0.085-3.068l0.033-1.166l0.085-3.175c0.01-0.362,0.23-0.686,0.563-0.828 c0.117-0.05,0.24-0.074,0.362-0.074c0.227,0,0.451,0.083,0.625,0.242l0.294,0.276l0.29-0.081l0.911-0.422 c0.114-0.053,0.238-0.082,0.364-0.085l1.038-0.028c0.008,0,0.017,0,0.025,0c0.06,0,0.12,0.006,0.179,0.017l0.913,0.18l0.648-0.109 l0.837-0.24c0.065-0.019,0.132-0.03,0.2-0.034l3.065-0.185l1.722-0.351l1.601-0.582l1.455-0.768l1.679-1.309 c0.142-0.11,0.312-0.177,0.491-0.192l0.694-0.059c0.026-0.002,0.052-0.003,0.078-0.003c0.13,0,0.26,0.028,0.379,0.081l1.197,0.537 l0.837,0.175l0.226-0.26l0.424-0.887c0.096-0.201,0.262-0.361,0.467-0.45l0.908-0.394c0.082-0.036,0.17-0.059,0.259-0.07 l0.636-0.076l1.292-0.833c0.041-0.026,0.084-0.05,0.129-0.069l0.9-0.396c0.082-0.036,0.169-0.06,0.258-0.071l1.171-0.146 c0.038-0.005,0.077-0.007,0.115-0.007c0.071,0,0.143,0.008,0.212,0.025l0.923,0.217c0.11,0.026,0.214,0.071,0.307,0.135 l0.829,0.561c0.05,0.034,0.096,0.072,0.138,0.115l2.974,3l0.428-0.197c0.045-0.021,0.092-0.038,0.14-0.051l1.007-0.278 c0.077-0.021,0.156-0.032,0.236-0.033l0.827-0.01c0.004,0,0.007,0,0.011,0c0.271,0,0.529,0.119,0.705,0.326l0.426,0.5 c0.174,0.205,0.251,0.476,0.21,0.741l-0.025,0.165l1.453,0.217l0.38-0.024l0.379-0.534c0.071-0.1,0.16-0.184,0.264-0.249 l0.354-0.222c0.142-0.089,0.306-0.138,0.473-0.141l0.478-0.009c0.006,0,0.012,0,0.018,0c0.109,0,0.218,0.019,0.321,0.057 l0.765,0.283l0.103,0.015l0.235-0.077L452.935,547.057z").attr({id: 'vaupes', class: 'st16', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#F49292'}).data({'id': 'vaupes', 'region':'Vaupés', 'benefited-companies':'1', 'benefited-projects': '$20.000.000'});

        var amazonas = rsr.path("M439.524,642.102l-0.032-1.962c-0.001-0.059,0.004-0.119,0.014-0.177l0.729-4.107l-0.1-1.626 l-1.339-1.565c-0.078-0.092-0.138-0.197-0.176-0.312l-0.135-0.408l-0.019-0.02l-0.232-0.103l-0.071-0.021l-0.578-0.069 c-0.106-0.013-0.209-0.043-0.305-0.091l-3.061-1.53l-0.208-0.026l-2.083,1.204c-0.094,0.054-0.196,0.091-0.303,0.11l-0.523,0.092 c-0.053,0.009-0.107,0.014-0.16,0.014c-0.212,0-0.419-0.073-0.586-0.209l-0.385-0.314c-0.121-0.099-0.215-0.227-0.274-0.372 l-0.34-0.845c-0.033-0.083-0.055-0.171-0.063-0.26l-0.083-0.892c-0.011-0.115,0-0.231,0.032-0.342l0.217-0.755 c0.01-0.034,0.022-0.068,0.035-0.101l0.274-0.656l0.113-0.495l-0.1-0.362l-0.414-0.509l-1.736-1.561l-0.416-0.242l-0.298-0.059 l-0.2,0.067l-0.1,0.13l-0.316,1.057c-0.053,0.176-0.156,0.332-0.297,0.449l-0.503,0.415c-0.166,0.137-0.375,0.212-0.59,0.212 h-0.958c-0.118,0-0.235-0.023-0.345-0.067l-1.885-0.757l-0.678,0.01l-0.441,0.264l-0.636,0.532 c-0.047,0.04-0.099,0.074-0.153,0.104l-0.749,0.406c-0.136,0.074-0.288,0.112-0.441,0.112c-0.031,0-0.063-0.002-0.094-0.005 l-0.898-0.092c-0.175-0.018-0.342-0.086-0.48-0.195l-0.699-0.552c-0.212-0.167-0.34-0.419-0.351-0.688l-0.026-0.628 c-0.006-0.144,0.022-0.287,0.081-0.418l0.578-1.284l0.007-0.073l-0.027-0.588c-0.004-0.093,0.006-0.186,0.029-0.275l0.068-0.262 c0.034-0.129,0.095-0.25,0.18-0.353l0.252-0.307c0.04-0.049,0.085-0.094,0.134-0.133l0.523-0.423l0.023-0.026l-0.219,0.09 l-0.647,0.362c-0.065,0.036-0.134,0.065-0.206,0.085l-0.691,0.191c-0.081,0.022-0.164,0.033-0.247,0.033 c-0.142,0-0.284-0.033-0.413-0.097l-0.867-0.432l-0.255,0.328c-0.072,0.092-0.16,0.17-0.261,0.229l-0.601,0.354 c-0.125,0.074-0.266,0.117-0.411,0.126l-0.222,0.014c-0.02,0.001-0.04,0.002-0.059,0.002c-0.025,0-0.051-0.001-0.076-0.003 l-0.2-0.016c-0.056-0.005-0.111-0.014-0.165-0.029l-0.184-0.05c-0.037-0.01-0.074-0.022-0.109-0.037l-0.168-0.069 c-0.028-0.011-0.055-0.024-0.082-0.038l-0.718-0.379l-0.099,0.001l-0.371,0.197l-0.596,0.788l0.225,0.356l1.07,0.846 c0.121,0.096,0.217,0.221,0.277,0.363l0.516,1.208c0.106,0.249,0.098,0.532-0.022,0.774l-0.417,0.842 c-0.075,0.152-0.191,0.281-0.335,0.372l-0.784,0.496c-0.11,0.07-0.234,0.116-0.364,0.134l-0.939,0.134 c-0.044,0.006-0.087,0.009-0.131,0.009c-0.079,0-0.158-0.01-0.234-0.03l-0.876-0.229c-0.124-0.032-0.24-0.09-0.34-0.169 l-2.239-1.77c-0.04-0.032-0.078-0.067-0.112-0.105l-0.393-0.434c-0.174-0.192-0.259-0.448-0.236-0.706l0.056-0.604 c0.009-0.095,0.032-0.188,0.069-0.276c-0.094,0.057-0.199,0.097-0.308,0.117l-0.833,0.156c-0.057,0.011-0.113,0.016-0.17,0.016 c-0.207,0-0.41-0.07-0.575-0.2l-0.813-0.644c-0.08-0.063-0.149-0.14-0.204-0.226l-0.626-0.977 c-0.043-0.068-0.078-0.141-0.102-0.218l-0.275-0.859c-0.05-0.157-0.058-0.325-0.021-0.486l0.171-0.758 c0.036-0.16,0.114-0.307,0.225-0.427l0.518-0.557c0.057-0.061,0.122-0.114,0.193-0.158l1.186-0.73l0.568-0.88l-0.567-0.88 l-1.352-1.418c-0.111-0.117-0.19-0.261-0.229-0.417l-0.406-1.645c-0.07-0.283-0.002-0.583,0.183-0.809l0.476-0.58 c0.068-0.083,0.151-0.154,0.243-0.209l0.649-0.386l0.234-0.186l0.015-0.112l-0.412-1.247c-0.012-0.037-0.022-0.074-0.029-0.112 l-0.139-0.708c-0.011-0.057-0.017-0.114-0.017-0.172l-0.006-0.826c0-0.046,0.003-0.091,0.009-0.136l0.241-1.703l0.027-0.757 l-0.09-0.346l-0.213-0.183l-0.28,0.019l-0.59,0.208c-0.099,0.035-0.203,0.053-0.308,0.053c-0.015,0-0.03,0-0.045-0.001 l-0.491-0.024c-0.473-0.023-0.852-0.398-0.88-0.871l-0.06-1.026c-0.013-0.215,0.05-0.428,0.178-0.602l0.958-1.307 c0.034-0.046,0.072-0.089,0.114-0.129l2.734-2.562l-0.398-0.213l-0.798-0.222l-0.603-0.003l-0.615,0.187l-0.682,0.366l-0.124,0.148 l0.078,0.818c0.02,0.206-0.03,0.413-0.141,0.587l-0.336,0.526c-0.141,0.221-0.369,0.372-0.628,0.415l-0.874,0.146 c-0.051,0.008-0.102,0.013-0.153,0.013c-0.066,0-0.132-0.007-0.196-0.021l-2.268-0.491l-1.825,0.08 c-0.014,0.001-0.027,0.001-0.041,0.001c-0.349,0-0.67-0.196-0.827-0.51l-0.205-0.408c-0.087-0.172-0.117-0.367-0.088-0.558 l0.097-0.625l0.012-0.499l-0.22-0.56l-0.478-0.754l-0.576-0.647l-0.493-0.342l-0.431-0.097l-2.159,0.164 c-0.023,0.002-0.047,0.003-0.07,0.003c-0.119,0-0.236-0.023-0.347-0.067l-0.661-0.267c-0.147-0.059-0.277-0.156-0.376-0.279 l-0.792-0.987l-0.302-0.174l-0.19-0.008l-0.933,0.182c-0.059,0.011-0.118,0.017-0.177,0.017c-0.018,0-0.035-0.001-0.053-0.002 l-0.498-0.028c-0.118-0.007-0.233-0.036-0.34-0.086l-0.51-0.239c-0.067-0.031-0.129-0.07-0.187-0.116l-1.248-1l-0.656-0.347 l-0.777-0.263l-0.199,0.014l-0.152,0.284l-0.221,0.639c-0.064,0.185-0.185,0.345-0.346,0.456l-0.545,0.38 c-0.106,0.074-0.227,0.125-0.354,0.15l-0.735,0.142c-0.058,0.011-0.116,0.017-0.175,0.017c-0.005,0-0.011,0-0.016,0l-1.627-0.028 c-0.104-0.002-0.208-0.021-0.306-0.058l-0.383-0.142c-0.188-0.07-0.348-0.198-0.457-0.367l-0.258-0.401 c-0.022-0.035-0.042-0.071-0.06-0.108l-1.117-2.381c-0.014-0.029-0.026-0.059-0.036-0.09l-1.006-2.896l-1.655-2.065 c-0.115-0.143-0.184-0.317-0.2-0.499l-0.047-0.545c-0.015-0.168,0.017-0.337,0.091-0.489l0.225-0.458l0.161-0.594l-0.021-0.539 l-0.149-0.538l-0.272-0.555l-1.276-1.854l-0.446-0.488l-0.245-0.154l-0.113-0.002l-0.778,0.361 c-0.081,0.038-0.168,0.063-0.256,0.076l-0.519,0.076c-0.044,0.006-0.089,0.01-0.133,0.01c-0.088,0-0.176-0.013-0.261-0.038 l-0.834-0.245c-0.05-0.015-0.099-0.034-0.146-0.057l-1.697-0.832l-0.858-0.277c-0.032-0.01-0.063-0.022-0.094-0.036l-0.965-0.432 c-0.173-0.078-0.319-0.207-0.416-0.37l-0.442-0.739c-0.051-0.086-0.089-0.179-0.11-0.277l-0.376-1.706l-0.285-0.388l-0.246,0.004 l-1.72,0.756c-0.096,0.042-0.198,0.068-0.303,0.076l-0.752,0.057c-0.023,0.002-0.046,0.003-0.07,0.003 c-0.043,0-0.085-0.003-0.128-0.009l-0.763-0.106c-0.055-0.008-0.109-0.02-0.162-0.038l-0.738-0.243 c-0.045-0.015-0.088-0.033-0.13-0.054l-0.677-0.344c-0.081-0.041-0.156-0.094-0.221-0.157l-0.401-0.385l-2.436,2.376 c-0.057,0.056-0.121,0.104-0.191,0.143l-2.359,1.333c-0.027,0.015-0.054,0.029-0.082,0.041l-8.35,3.678l-2.715,1.836l-1.537,1.751 l-0.464,1.779c-0.014,0.055-0.034,0.108-0.058,0.16l-0.648,1.381c-0.045,0.096-0.106,0.183-0.18,0.258l-0.96,0.97 c-0.086,0.086-0.187,0.155-0.3,0.202l-1.462,0.614c-0.057,0.024-0.116,0.042-0.177,0.054l-1.774,0.354 c-0.06,0.012-0.12,0.018-0.181,0.018c-0.003,0-0.006,0-0.01,0l-6.175-0.063l-1.191,0.12l-0.846,0.413l-1.647,1.594 c-0.059,0.057-0.124,0.105-0.195,0.145l-2.303,1.275l-0.496,0.547l-1.4,2.273c-0.016,0.026-0.033,0.05-0.051,0.074l-0.833,1.097 c-0.018,0.024-0.038,0.048-0.059,0.07l-0.935,1.008l-0.679,1.003l-0.248,1.162l-0.006,1.436l0.118,1.282 c0.007,0.077,0.004,0.155-0.008,0.232l-0.045,0.279c-0.005,0.029-0.011,0.057-0.018,0.085l-0.221,0.85 c-0.039,0.15-0.115,0.288-0.221,0.401l-0.543,0.578c-0.024,0.026-0.05,0.05-0.077,0.073l-1.167,0.989 c-0.124,0.106-0.275,0.176-0.435,0.205l-2.041,0.366c-0.054,0.01-0.109,0.015-0.163,0.015c-0.178,0-0.354-0.051-0.505-0.15 l-1.605-1.043c-0.058-0.038-0.111-0.082-0.159-0.131l-1.313-1.351l-0.931-0.54l-0.573,0.239l-1.291,1.102l-2.094,2.378l-0.547,0.92 c-0.022,0.037-0.046,0.072-0.073,0.105l-0.472,0.59c-0.152,0.19-0.374,0.313-0.616,0.341l-0.67,0.078 c-0.036,0.004-0.071,0.006-0.107,0.006c-0.133,0-0.265-0.029-0.386-0.084l-1.188-0.545c-0.039-0.018-0.077-0.039-0.114-0.062 l-1.153-0.739c-0.029-0.019-0.057-0.039-0.084-0.061l-4.693-3.812l-0.959-0.404l-0.882,0.157l-1.491,0.989 c-0.102,0.068-0.217,0.115-0.338,0.138l-3.169,0.607c-0.058,0.011-0.116,0.016-0.174,0.016c-0.182,0-0.361-0.054-0.514-0.156 l-4.613-3.078l-2.195,1.55l-0.98,1.025c-0.115,0.12-0.261,0.208-0.421,0.252l-1.059,0.295c-0.07,0.019-0.142,0.031-0.215,0.033 l-1.143,0.042l-1.471,0.32c-0.065,0.014-0.131,0.021-0.197,0.021c-0.028,0-0.056-0.001-0.084-0.004l-1.835-0.167 c-0.173-0.016-0.338-0.08-0.476-0.185l-1.772-1.345c-0.034-0.026-0.066-0.054-0.097-0.084l-1.629-1.637l-1.364-1.037l-0.32-0.102 l-0.225,0.195c-0.051,0.044-0.107,0.083-0.167,0.115l-0.8,0.432c-0.084,0.045-0.174,0.077-0.267,0.095l-1.005,0.191 c-0.057,0.011-0.115,0.016-0.173,0.016c-0.016,0-0.033,0-0.049-0.001l-2.025-0.108l-1.96,0.169 c-0.027,0.002-0.053,0.003-0.08,0.003c-0.049,0-0.099-0.004-0.147-0.012l-3.431-0.552c-0.109-0.018-0.214-0.055-0.311-0.109 l-0.582-0.331c-0.147-0.083-0.268-0.205-0.35-0.352l-0.349-0.623c-0.021-0.037-0.039-0.075-0.054-0.114l-0.441-1.123l-0.061-0.053 l-0.081-0.01l-0.389,0.059c-0.036,0.006-0.073,0.009-0.11,0.01l-0.521,0.016c-0.01,0-0.019,0-0.029,0 c-0.066,0-0.133-0.007-0.198-0.021l-0.172-0.038c-0.06-0.013-0.119-0.032-0.176-0.057l-0.171-0.076 c-0.05-0.022-0.098-0.048-0.143-0.079l-0.169-0.113c-0.051-0.034-0.098-0.073-0.141-0.117l-0.164-0.165 c-0.117-0.118-0.2-0.265-0.241-0.426l-0.082-0.323c-0.033-0.131-0.037-0.268-0.012-0.401l0.073-0.38 c-0.075-0.012-0.149-0.034-0.219-0.064l-0.261-0.113c-0.045-0.02-0.089-0.043-0.13-0.069l-1.263-0.809l-0.571-0.227l-0.259-0.003 l-1.068,0.577c-0.036,0.019-0.073,0.036-0.111,0.051l-0.626,0.238c-0.097,0.037-0.2,0.057-0.305,0.06l-0.787,0.021 c-0.008,0-0.017,0-0.025,0c-0.057,0-0.114-0.005-0.171-0.016l-3.282-0.616l-24.002,7.447l1.922,4.145 c0.1,0.216,0.113,0.461,0.037,0.686l-0.109,0.321c-0.053,0.157-0.148,0.298-0.274,0.406l-0.457,0.393l-0.024,0.044l-0.009,0.43 l0.165,0.345l1.38,1.529l0.098,0.066l0.191,0.057l0.668,0.02c0.119,0.004,0.236,0.03,0.345,0.078l0.355,0.156 c0.231,0.101,0.41,0.292,0.497,0.529s0.074,0.498-0.037,0.725l-0.157,0.322l0.363,0.374c0.078,0.08,0.14,0.174,0.185,0.276 l0.25,0.576c0.114,0.261,0.101,0.56-0.035,0.811l-0.274,0.505c-0.162,0.299-0.474,0.485-0.814,0.485h-0.316 c0.086,0.058,0.162,0.13,0.225,0.214l0.455,0.609c0.062,0.083,0.11,0.177,0.142,0.276l0.603,1.912l0.804,1.051l0.91,0.499 l2.576,0.469c0.056,0.01,0.111,0.026,0.165,0.046l2.608,0.996l0.521-0.016l0.455-0.86c0.134-0.254,0.379-0.431,0.662-0.48 c0.052-0.009,0.105-0.013,0.157-0.013c0.231,0,0.455,0.086,0.628,0.245l0.523,0.482c0.115,0.106,0.201,0.238,0.25,0.386 l1.041,3.098l0.093,0.166l0.133,0.11l0.003,0.001c0.054-0.043,0.113-0.079,0.176-0.108l0.304-0.144l0.105-0.192 c0.087-0.158,0.217-0.287,0.376-0.372l0.23-0.123c0.137-0.073,0.287-0.109,0.436-0.109c0.217,0,0.431,0.076,0.603,0.223l0.38,0.326 c0.172,0.147,0.284,0.353,0.315,0.577l0.052,0.377c0.026,0.193-0.008,0.389-0.1,0.561l-0.003,0.006l0.668-0.151 c0.067-0.015,0.135-0.023,0.203-0.023c0.107,0,0.214,0.019,0.316,0.056l0.754,0.274c0.195,0.071,0.36,0.205,0.47,0.381l0.264,0.425 c0.031,0.049,0.057,0.101,0.078,0.155l0.667,1.727l0.727,1.139l0.311,0.334l0.445,0.293l1.056,0.372l0.588,0.126l0.204,0.005 l0.337-0.19l0.609-0.96c0.109-0.171,0.27-0.302,0.46-0.372l0.688-0.255c0.106-0.039,0.215-0.058,0.322-0.058 c0.351,0,0.684,0.201,0.84,0.536l0.32,0.69l0.442,0.48l0.598,0.336l0.901,0.153c0.034,0.006,0.068,0.014,0.102,0.023l0.506,0.146 c0.106,0.031,0.205,0.08,0.294,0.145l0.736,0.544l0.915,0.265c0.229,0.066,0.423,0.218,0.543,0.424l0.236,0.406 c0.046,0.079,0.08,0.165,0.101,0.255l0.096,0.411l0.291,0.62c0.02,0.043,0.037,0.088,0.05,0.134 c0.018-0.001,0.036-0.002,0.055-0.002c0.075,0,0.151,0.009,0.224,0.028l0.171,0.043c0.279,0.07,0.51,0.265,0.625,0.529l0.144,0.331 c0.023,0.053,0.041,0.108,0.054,0.164l0.087,0.382c0.012,0.051,0.019,0.103,0.022,0.156l0.049,0.89l0.028,0.099l0.113,0.193 l0.073,0.086l0.532,0.246c0.463,0.214,0.666,0.762,0.454,1.226l-0.221,0.482c-0.033,0.073-0.076,0.142-0.128,0.204l-0.252,0.305 l1.328,0.622c0.159,0.074,0.293,0.192,0.388,0.34l0.417,0.653l0.824,0.606c0.078,0.058,0.147,0.127,0.204,0.206l0.353,0.491 c0.078,0.109,0.132,0.234,0.157,0.367l0.086,0.453c0.012,0.063,0.017,0.126,0.016,0.19l-0.008,0.424l0.051,0.478l0.464,1.844 c0.022,0.089,0.032,0.182,0.027,0.274l-0.045,0.874c-0.016,0.31-0.186,0.591-0.453,0.75l-0.896,0.53l-0.229,0.405l-0.451,1.309 l-0.072,1.281l0.591,0.731l2.816,1.725c0.173,0.106,0.306,0.266,0.38,0.455l0.066,0.17c0.014,0.037,0.026,0.075,0.036,0.113 l0.009,0.037c0.008,0,0.016,0,0.024,0c0.036,0,0.071,0.002,0.107,0.006l0.574,0.067l0.43-0.02c0.014-0.001,0.029-0.001,0.043-0.001 c0.042,0,0.084,0.003,0.126,0.009l0.552,0.076c0.132,0.018,0.259,0.065,0.372,0.136l0.571,0.364 c0.044,0.028,0.086,0.06,0.125,0.096l0.643,0.584l0.735-0.717c0.145-0.142,0.334-0.232,0.535-0.256l0.701-0.085 c0.037-0.005,0.074-0.007,0.111-0.007c0.078,0,0.156,0.01,0.232,0.03l0.796,0.206l0.064-0.418c0.07-0.452,0.458-0.785,0.915-0.785 h0.467c0.264,0,0.516,0.113,0.691,0.31l1.152,1.293l0.275,0.199l0.333,0.144c0.046,0.02,0.09,0.043,0.132,0.07l0.382,0.245 c0.117,0.075,0.215,0.175,0.288,0.293l0.309,0.5c0.123,0.199,0.166,0.438,0.12,0.667l-0.285,1.437l0.091,0.236l0.976,1.15 c0.074,0.088,0.132,0.188,0.169,0.297l0.264,0.765c0.058,0.167,0.066,0.348,0.025,0.52l-0.102,0.42 c-0.01,0.043-0.024,0.085-0.04,0.126l-0.409,1.026l-0.035,0.355l0.111,0.457l0.234,0.453l0.762,1.13 c0.043,0.063,0.077,0.131,0.103,0.203l0.309,0.855c0.012,0.033,0.022,0.066,0.03,0.1l0.237,0.994l0.261,0.701l0.457,0.427 c0.32,0.299,0.386,0.782,0.159,1.157l-1.312,2.161l-0.404,0.934c-0.053,0.122-0.131,0.23-0.229,0.319l-1.61,1.453l-0.3,0.36 l-0.032,0.066l-0.019,0.145l0.028,0.135l0.346,0.556c0.037,0.059,0.066,0.122,0.089,0.187l0.058,0.169l0.491,0.376 c0.095,0.073,0.175,0.164,0.236,0.267l0.144,0.245c0.057,0.098,0.096,0.206,0.115,0.318l0.21,1.278l0.346,0.233l1.833,0.456 c0.163,0.041,0.312,0.125,0.431,0.244l0.239,0.24l0.055-0.105l0.084-0.374c0.064-0.284,0.258-0.521,0.523-0.64 c0.121-0.055,0.251-0.082,0.38-0.082c0.154,0,0.308,0.038,0.446,0.115l3.145,1.729c0.149,0.082,0.273,0.204,0.358,0.351 l0.072,0.125l0.547,0.479c0.117,0.102,0.206,0.232,0.259,0.377l0.75,2.04l0.29,0.512l1.768-0.354l0.38-0.137l0.402-0.387 c0.095-0.091,0.208-0.161,0.333-0.205l1.251-0.444l1.081-0.541c0.13-0.065,0.272-0.098,0.415-0.098 c0.103,0,0.205,0.017,0.304,0.051l0.762,0.265c0.083,0.029,0.161,0.069,0.233,0.12l0.21,0.149c0.048-0.082,0.109-0.155,0.18-0.219 l0.371-0.331c0.065-0.058,0.139-0.107,0.218-0.145l0.564-0.269c0.128-0.061,0.264-0.09,0.398-0.09c0.295,0,0.583,0.142,0.761,0.398 l0.226,0.326c0.029,0.041,0.054,0.085,0.076,0.13l0.191,0.402c0.023,0.048,0.042,0.099,0.056,0.151l0.13,0.468 c0.012,0.042,0.02,0.085,0.026,0.128l0.017,0.128l0.067-0.062l1.128-2.337c0.028-0.058,0.062-0.113,0.102-0.165l0.571-0.737 c0.177-0.228,0.448-0.359,0.732-0.359c0.046,0,0.093,0.003,0.14,0.011l0.838,0.128c0.106,0.016,0.208,0.05,0.302,0.101l0.802,0.434 c0.05,0.027,0.097,0.059,0.141,0.094l1.939,1.568l0.628,0.2l4.612,0.726c0.172,0.027,0.332,0.102,0.463,0.216l0.408,0.354 c0.107,0.093,0.191,0.209,0.246,0.339l0.155,0.366l0.37,0.338l0.596,0.317l0.587,0.134l0.8-0.066l1.745-0.461 c0.045-0.012,0.092-0.021,0.138-0.026l0.736-0.079l-0.019-0.453c-0.013-0.295,0.116-0.578,0.346-0.762l0.236-0.189 c0.115-0.092,0.25-0.155,0.394-0.185l1.175-0.241c0.036-0.007,0.073-0.013,0.11-0.016l0.458-0.038 c0.025-0.002,0.051-0.003,0.076-0.003c0.07,0,0.14,0.008,0.208,0.024l2.703,0.624l0.192-0.06l1.841-2.112 c0.028-0.033,0.059-0.063,0.092-0.092l1.277-1.105c0.079-0.069,0.17-0.123,0.267-0.162l1.274-0.501 c0.104-0.041,0.215-0.063,0.327-0.064l1.487-0.019c0.004,0,0.008,0,0.012,0c0.043,0,0.087,0.003,0.13,0.009l2.685,0.381l0.38-0.094 l0.183-0.183l0.154-0.745c0.035-0.168,0.116-0.324,0.234-0.449l0.335-0.354c0.033-0.035,0.068-0.067,0.106-0.096l2.034-1.577 l1.529-2.338l0.194-0.414c0.142-0.303,0.437-0.506,0.771-0.53l0.228-0.016l2.461-1.557c0.036-0.023,0.073-0.043,0.111-0.06 l0.996-0.453c0.122-0.056,0.253-0.083,0.384-0.083c0.188,0,0.374,0.057,0.533,0.168l0.349,0.245 c0.258,0.181,0.406,0.482,0.393,0.797l-0.056,1.32l0.046-0.007l1.397-0.721c0.132-0.068,0.278-0.103,0.425-0.103 c0.055,0,0.109,0.005,0.164,0.015l1.078,0.193c0.11,0.02,0.216,0.059,0.312,0.117l0.899,0.538c0.031,0.019,0.062,0.039,0.09,0.062 l0.79,0.61l0.758,0.41l2.496,0.516c0.136,0.028,0.264,0.086,0.374,0.17l0.514,0.392c0.165,0.126,0.283,0.304,0.335,0.505 l0.222,0.86c0.017,0.066,0.027,0.135,0.029,0.203l0.022,0.726l0.06-0.229c0.041-0.155,0.121-0.296,0.232-0.411l0.635-0.652 c0.177-0.182,0.418-0.28,0.664-0.28c0.104,0,0.209,0.018,0.31,0.054l0.465,0.165c0.211,0.075,0.387,0.224,0.497,0.418l0.765,1.359 l1.039,1.318c0.063,0.08,0.113,0.171,0.147,0.267l0.165,0.472c0.067,0.191,0.069,0.398,0.007,0.591l-0.125,0.388 c-0.05,0.155-0.14,0.295-0.262,0.404l-0.062,0.055l0.39-0.082l3.163-1.542c0.13-0.064,0.269-0.094,0.405-0.094 c0.323,0,0.635,0.169,0.805,0.467l0.014,0.025l0.059-0.014l0.851-0.447c0.03-0.016,0.062-0.03,0.094-0.043l0.677-0.265 c0.108-0.042,0.222-0.064,0.337-0.064c0.069,0,0.138,0.008,0.206,0.023l0.498,0.113c0.125,0.029,0.243,0.083,0.346,0.159 l0.428,0.318l0.105,0.035l0.038-0.008l0.69-0.539c0.047-0.037,0.098-0.069,0.151-0.096l0.984-0.5l0.743-1.841 c0.087-0.216,0.253-0.392,0.464-0.491l1.043-0.491c0.075-0.035,0.154-0.06,0.235-0.074l1.267-0.222 c0.053-0.009,0.106-0.014,0.16-0.014c0.007,0,0.015,0,0.022,0l0.598,0.014c0.16,0.004,0.317,0.049,0.454,0.132l0.94,0.564 l-0.035-0.097c-0.026-0.073-0.043-0.148-0.051-0.225l-0.1-1.039c-0.022-0.23,0.042-0.459,0.181-0.644l0.481-0.643 c0.175-0.234,0.45-0.371,0.741-0.371c0.008,0,0.016,0,0.023,0l1.312,0.033c0.116,0.003,0.231,0.028,0.338,0.073l1.847,0.783 l0.762,0.148l0.678-0.302c0.12-0.053,0.248-0.08,0.376-0.08c0.168,0,0.335,0.046,0.482,0.135l1.386,0.845 c0.071,0.043,0.136,0.096,0.193,0.157l2.292,2.442l1.39,0.913l1.53,0.546l0.751,0.18l1.133,0.145 c0.198,0.025,0.382,0.114,0.526,0.252l0.235,0.227c0.114,0.11,0.198,0.247,0.244,0.399l0.108,0.359 c0.026,0.086,0.039,0.176,0.04,0.267l0.001,0.839l1.279,1.062c0.086,0.071,0.158,0.158,0.213,0.255l0.282,0.496 c0.059,0.105,0.098,0.22,0.113,0.339l0.06,0.463c0.005,0.04,0.008,0.08,0.008,0.121l-0.001,0.513h0.794l-0.011-0.145 c-0.008-0.104,0.002-0.208,0.029-0.308l0.114-0.425c0.06-0.224,0.203-0.418,0.399-0.542l0.798-0.505 c0.151-0.096,0.323-0.144,0.496-0.144c0.172,0,0.344,0.048,0.495,0.144l0.597,0.378c0.078,0.049,0.148,0.11,0.208,0.18l0.441,0.515 l0.399,0.2l0.613,0.079c0.052,0.007,0.103,0.018,0.152,0.033l0.864,0.264c0.048,0.015,0.095,0.033,0.14,0.056l0.801,0.397 c0.068,0.034,0.131,0.075,0.189,0.124l0.572,0.487c0.088,0.075,0.162,0.166,0.217,0.269l0.265,0.496 c0.023,0.044,0.043,0.089,0.059,0.136l0.122,0.356l0.053,0.08l0.082,0.041l0.066-0.005l0.932-0.406 c0.051-0.022,0.105-0.04,0.16-0.053l0.506-0.118c0.066-0.015,0.133-0.023,0.201-0.024l0.98-0.01c0.003,0,0.006,0,0.009,0 c0.033,0,0.066,0.002,0.098,0.005l0.97,0.104c0.17,0.018,0.332,0.083,0.467,0.187l0.576,0.444c0.283,0.218,0.415,0.58,0.34,0.93 l-0.215,0.992c-0.02,0.093-0.054,0.182-0.101,0.263l0.291-0.177c0.059-0.036,0.123-0.066,0.189-0.088l0.877-0.293 c0.095-0.032,0.195-0.048,0.293-0.048c0.141,0,0.282,0.032,0.411,0.096l1.002,0.496c0.143,0.071,0.266,0.178,0.356,0.31 l0.573,0.846c0.048,0.071,0.086,0.147,0.113,0.228l0.608,1.835l0.288,0.459l0.191,0.072l0.404-0.189 c0.044-0.021,0.09-0.038,0.138-0.051l0.777-0.222c0.084-0.024,0.169-0.036,0.254-0.036c0.205,0,0.407,0.068,0.572,0.197 l0.904,0.709c0.152,0.119,0.263,0.283,0.317,0.468l0.006,0.02l0.049-0.079c0.07-0.112,0.163-0.209,0.274-0.282l0.932-0.619 c0.155-0.103,0.334-0.155,0.512-0.155c0.182,0,0.363,0.053,0.52,0.16l0.494,0.336c0.178,0.121,0.309,0.3,0.369,0.507l0.571,1.959 l0.231,0.539l0.248,0.361l0.287,0.225l0.102,0.034c0.448,0.15,0.711,0.614,0.61,1.076c-0.023,0.105-0.072,0.243-0.129,0.334 l-1.024,1.625l-3.586,5.6l-3.582,5.591l-3.58,5.6l-3.584,5.597l-3.582,5.597l-3.582,5.602l-3.58,5.594l-3.582,5.599l-0.729,1.141 l0.503,0.055c0.115,0.013,0.227,0.047,0.33,0.101l6.195,3.254c0.033,0.017,0.064,0.036,0.095,0.057l0.349,0.24l2.171,0.539 l0.912,0.011l0.851-0.367l1.679-1.536c0.045-0.041,0.093-0.077,0.145-0.108l0.983-0.596c0.116-0.071,0.247-0.115,0.382-0.129 l1.284-0.137c0.033-0.004,0.066-0.005,0.098-0.005c0.104,0,0.207,0.018,0.306,0.052l1.757,0.615 c0.085,0.03,0.166,0.072,0.239,0.126l1.714,1.249c0.045,0.033,0.087,0.07,0.126,0.111l1.493,1.571 c0.032,0.034,0.061,0.069,0.088,0.107l1.091,1.561c0.048,0.069,0.087,0.144,0.115,0.223l0.566,1.608 c0.019,0.053,0.033,0.108,0.041,0.164l0.246,1.572l0.392,1.227l0.956,0.958l4.491,2.294c0.058,0.03,0.113,0.066,0.164,0.107 l1.37,1.117c0.043,0.035,0.082,0.073,0.118,0.115l0.926,1.079c0.023,0.027,0.044,0.055,0.064,0.084l0.798,1.178 c0.023,0.034,0.044,0.069,0.062,0.106l0.406,0.813l1.275-7.015l1.339-7.38l1.341-7.374l1.34-7.372l1.34-7.376l1.338-7.37 l1.344-7.374l1.339-7.367l1.339-7.367l1.341-7.37l1.34-7.365l1.34-7.368l1.338-7.363l1.342-7.362l1.34-7.366l1.34-7.361 l0.511-2.804c0.006-0.031,0.013-0.061,0.021-0.091l0.623-2.161l-0.013-0.791c-0.001-0.086,0.009-0.172,0.031-0.255L439.524,642.102 z").attr({id: 'amazonas', class: 'st17', parent: 'colombiamap', 'stroke-width': '0' ,'stroke-opacity': '1' ,'fill': '#EAEAEA'}).data({'id': 'amazonas', 'region':'Amazonas', 'benefited-companies':'0', 'benefited-projects': '0'});

        var guainia = rsr.path("M555.514,519.89c-0.033-0.068-0.058-0.14-0.073-0.213l-0.229-1.081 c-0.043-0.204-0.016-0.417,0.076-0.604l0.734-1.479l-0.032-0.735l-0.288-0.927l-0.382-0.721l-0.334-0.352l-0.474-0.38 c-0.038-0.03-0.074-0.064-0.107-0.1l-0.427-0.47c-0.099-0.109-0.17-0.239-0.209-0.381l-0.172-0.634 c-0.035-0.129-0.042-0.263-0.02-0.395l0.285-1.715l-0.132-0.746l-0.367-0.825l-0.942-1.554c-0.02-0.033-0.038-0.067-0.053-0.102 l-0.444-0.993c-0.029-0.064-0.05-0.131-0.063-0.199l-0.177-0.899c-0.012-0.059-0.017-0.119-0.017-0.179v-1.975l-0.108-0.823 l-3.866-10.269l-0.793-1.495c-0.038-0.072-0.066-0.148-0.085-0.227l-0.084-0.366l-0.027-0.049l-0.679-0.471 c-0.108-0.075-0.198-0.171-0.266-0.284l-0.306-0.508l-0.277-0.302c-0.029-0.032-0.056-0.066-0.081-0.102l-0.324-0.471 c-0.071-0.103-0.12-0.219-0.144-0.341l-0.115-0.572c-0.053-0.265,0.012-0.54,0.178-0.753l0.702-0.899l0.088-0.147l0.104-0.525 l-0.141-2.209l-0.112-0.284l-0.308-0.164l-0.74-0.228c-0.063-0.019-0.123-0.045-0.18-0.077l-0.691-0.387 c-0.132-0.074-0.244-0.179-0.326-0.307l-0.392-0.609c-0.034-0.053-0.062-0.109-0.085-0.168l-0.75-1.943 c-0.016-0.041-0.029-0.084-0.039-0.127l-0.305-1.335l-0.696-1.67c-0.044-0.107-0.069-0.22-0.071-0.336l-0.019-0.843 c-0.005-0.228,0.074-0.449,0.222-0.623l0.519-0.607c0.021-0.025,0.044-0.049,0.068-0.071l0.8-0.755l0.307-0.474l-0.124-0.389 l-0.195-0.314c-0.088-0.141-0.136-0.304-0.139-0.47l-0.014-0.713l-0.039-0.108l-0.132-0.128l-1.359-0.819l-1.506-0.489 c-0.07-0.023-0.137-0.054-0.2-0.093l-0.418-0.258c-0.061-0.038-0.117-0.082-0.168-0.133l-0.815-0.814l-0.313-0.224l-0.351-0.105 c-0.072-0.021-0.141-0.052-0.206-0.09l-0.401-0.236c-0.157-0.093-0.284-0.23-0.363-0.394l-0.267-0.55 c-0.018-0.036-0.033-0.073-0.045-0.111l-0.19-0.571l-0.112-0.237l-0.198-0.17l-0.924-0.5c-0.044-0.024-0.086-0.051-0.125-0.081 l-0.434-0.335c-0.086-0.066-0.159-0.147-0.217-0.238l-0.3-0.475c-0.022-0.035-0.042-0.071-0.059-0.109l-0.186-0.406l-0.071-0.089 l-0.293-0.086c-0.141-0.041-0.271-0.116-0.377-0.217l-0.187-0.177c-0.031-0.03-0.06-0.061-0.087-0.095l-0.715-0.897 c-0.051-0.064-0.094-0.135-0.126-0.211l-0.13-0.302l-0.008-0.013l-0.744-0.362c-0.051-0.025-0.099-0.054-0.144-0.087l-0.417-0.307 c-0.109-0.08-0.199-0.183-0.263-0.301l-0.189-0.345c-0.029-0.053-0.052-0.108-0.07-0.165l-0.252-0.793l-0.079-0.159l-0.405-0.362 l-0.526-0.162l-1.919-0.031c-0.203-0.003-0.399-0.073-0.558-0.199l-0.543-0.427c-0.157-0.124-0.27-0.295-0.321-0.488l-0.269-1.004 c-0.011-0.041-0.019-0.083-0.024-0.126l-0.24-1.941l-0.254-0.633l-0.522-0.829l-0.352-0.288l-0.371,0.092l-0.864,0.318 c-0.103,0.038-0.211,0.057-0.32,0.057c-0.061,0-0.123-0.006-0.184-0.018l-1.133-0.229c-0.076-0.016-0.151-0.041-0.221-0.075 l-1.883-0.914c-0.109-0.053-0.207-0.127-0.288-0.218l-0.243-0.273l-0.408,0.206c-0.106,0.054-0.222,0.086-0.34,0.096l-0.512,0.043 c-0.026,0.002-0.051,0.003-0.077,0.003c-0.015,0-0.031,0-0.046-0.001l-0.857-0.043l-0.487,0.129l-0.217,0.262l-0.322,0.562 c-0.058,0.102-0.135,0.191-0.227,0.264l-0.67,0.534c-0.167,0.133-0.372,0.202-0.577,0.202c-0.138,0-0.277-0.031-0.406-0.094 c-0.321-0.157-0.524-0.484-0.52-0.841l0.03-3.128c0.002-0.164,0.046-0.324,0.13-0.464l0.76-1.278 c0.045-0.076,0.101-0.145,0.166-0.205l1.142-1.061l1.957-1.813l1.953-1.812l1.957-1.813l1.957-1.81l1.953-1.812l1.96-1.812 l1.952-1.813l1.96-1.812l0.856-0.793c0.068-0.063,0.145-0.115,0.228-0.155l0.545-0.262c0.071-0.034,0.146-0.059,0.223-0.074 l0.935-0.184l0.271-0.094l0.35-0.266l2.656-3.321l1.042-1.69l0.146-1.272l-1.073-1.114l-1.528-0.603 c-0.066-0.026-0.128-0.059-0.186-0.099l-0.673-0.464c-0.089-0.061-0.167-0.138-0.229-0.226l-0.63-0.888 c-0.045-0.063-0.082-0.132-0.109-0.204l-3.035-7.914l-1.082-1.444l-1.292-0.606l-0.642,0.042l-0.796,0.148 c-0.056,0.01-0.113,0.016-0.17,0.016c-0.003,0-0.007,0-0.011,0l-0.835-0.009c-0.141-0.002-0.279-0.035-0.404-0.098l-0.883-0.442 c-0.115-0.058-0.217-0.139-0.299-0.238l-0.805-0.974c-0.079-0.095-0.137-0.205-0.173-0.323l-0.321-1.067 c-0.016-0.053-0.027-0.107-0.033-0.162l-0.244-2.146l-0.364-0.95l-1.79-3.111c-0.047-0.082-0.081-0.171-0.102-0.263l-0.215-0.978 c-0.011-0.05-0.018-0.102-0.021-0.153l-0.132-2.696l-0.115-0.313l-0.036,0.016l-0.425,0.322l-2.108,2.986 c-0.06,0.085-0.134,0.159-0.219,0.22l-1.89,1.349c-0.147,0.105-0.321,0.164-0.501,0.172l-1.757,0.071 c-0.012,0.001-0.025,0.001-0.037,0.001c-0.119,0-0.236-0.023-0.346-0.067l-1.689-0.681c-0.032-0.013-0.064-0.028-0.095-0.045 l-1.182-0.64l-0.614,0.419c-0.035,0.024-0.072,0.045-0.11,0.064l-0.601,0.299c-0.129,0.064-0.27,0.097-0.413,0.097 c-0.041,0-0.082-0.003-0.123-0.008l-0.53-0.071c-0.28-0.037-0.528-0.201-0.673-0.444l-0.335-0.562 c-0.047-0.079-0.082-0.163-0.103-0.251c-0.015,0.008-0.03,0.015-0.045,0.022l-0.611,0.27c-0.12,0.053-0.247,0.079-0.374,0.079 c-0.199,0-0.395-0.064-0.559-0.188l-0.882-0.668c-0.101-0.076-0.184-0.172-0.247-0.282l-0.503-0.887l-0.007,0.009l-0.463,1.057 c-0.024,0.055-0.053,0.107-0.087,0.156l-0.349,0.504c-0.022,0.031-0.046,0.061-0.071,0.09l-1.068,1.193 c-0.059,0.065-0.126,0.122-0.2,0.168l-0.586,0.365c-0.148,0.092-0.318,0.14-0.49,0.14c-0.052,0-0.104-0.004-0.156-0.013 l-0.642-0.11c-0.244-0.042-0.461-0.18-0.603-0.383l-0.272-0.39c-0.162-0.232-0.209-0.525-0.128-0.796l0.116-0.386l-1.664,0.892 c-0.139,0.075-0.289,0.11-0.437,0.11c-0.33,0-0.649-0.176-0.816-0.487l-0.367-0.681c-0.064-0.119-0.102-0.251-0.109-0.386 l-0.055-0.959l-0.13-0.455l-0.507-0.214l-1.817-0.286l-0.469-0.02l0.257,0.321c0.054,0.067,0.098,0.141,0.131,0.219l0.214,0.505 c0.135,0.319,0.08,0.686-0.141,0.953l-0.391,0.47l-0.221,0.552l-0.169,0.668c-0.052,0.208-0.175,0.391-0.348,0.518l-0.399,0.294 c-0.155,0.115-0.342,0.178-0.535,0.181l-1.88,0.031l-0.322,0.059l0.331,0.464c0.206,0.289,0.229,0.67,0.059,0.981 c-0.163,0.298-0.475,0.483-0.813,0.483c-0.015,0-0.029,0-0.044-0.001l-0.22-0.01l-0.206,0.061l-0.155,0.112l-0.108,0.262 c-0.113,0.272-0.348,0.475-0.635,0.545l-0.303,0.075c-0.027,0.007-0.054,0.012-0.081,0.016l-0.445,0.068l-0.421,0.105l-0.472,0.369 l-0.433,0.555l-0.252,0.589c-0.064,0.149-0.166,0.279-0.295,0.376l-0.299,0.225c-0.163,0.122-0.358,0.185-0.556,0.185 c-0.108,0-0.216-0.019-0.32-0.057l-0.457-0.168c-0.069-0.026-0.136-0.059-0.197-0.101l-0.3-0.202h-0.003l-0.07,0.047l-0.374,0.402 c-0.073,0.079-0.16,0.144-0.255,0.193l-0.602,0.309c-0.107,0.055-0.224,0.089-0.344,0.099l-1.42,0.12 c-0.026,0.002-0.052,0.003-0.078,0.003c-0.084,0-0.167-0.011-0.248-0.034l-0.752-0.209c-0.052-0.015-0.103-0.034-0.152-0.057 l-0.688-0.33l-0.006-0.002l-0.614,0.542c-0.123,0.109-0.273,0.183-0.435,0.215l-0.642,0.126l0.005,0.383 c0.001,0.096-0.012,0.191-0.04,0.282l-0.157,0.516c-0.084,0.276-0.291,0.497-0.561,0.598l-0.569,0.213 c-0.104,0.039-0.214,0.059-0.325,0.059c-0.026,0-0.051-0.001-0.077-0.003l-0.511-0.042c-0.042-0.004-0.083-0.01-0.124-0.019 l-0.656-0.146l0.04,0.178c0.011,0.048,0.018,0.098,0.021,0.147l0.048,0.798c0.015,0.25-0.071,0.495-0.24,0.679 c-0.168,0.185-0.404,0.294-0.654,0.302l-1.063,0.035c-0.01,0-0.021,0.001-0.031,0.001c-0.279,0-0.544-0.126-0.72-0.343 l-0.405-0.501l-1.458,0.743c-0.114,0.058-0.239,0.092-0.367,0.099l-0.629,0.037c-0.018,0.001-0.036,0.002-0.054,0.002 c-0.067,0-0.135-0.007-0.201-0.022l-0.165-0.037c-0.105-0.023-0.206-0.065-0.297-0.123l-0.234-0.149 c-0.068-0.043-0.129-0.095-0.183-0.152l0.052,1.327c0.013,0.324-0.145,0.63-0.415,0.809l-0.564,0.373 c-0.152,0.101-0.33,0.153-0.51,0.153c-0.043,0-0.085-0.003-0.128-0.009l-2.998-0.419c-0.076-0.011-0.151-0.031-0.222-0.06 l-0.065-0.026l-0.527,0.885c-0.039,0.065-0.085,0.125-0.138,0.178l-0.394,0.397c-0.106,0.107-0.236,0.186-0.379,0.231l-0.709,0.223 c-0.091,0.029-0.185,0.043-0.278,0.043c-0.177,0-0.352-0.051-0.504-0.149l-0.377-0.245c-0.124-0.08-0.227-0.189-0.301-0.318 l-0.142-0.249l-0.127-0.108c-0.235-0.2-0.355-0.503-0.32-0.809l0.061-0.543l-0.32-0.271l-0.289-0.198l-0.036-0.019l-0.048,0.015 l-0.954,0.691c-0.108,0.078-0.232,0.132-0.363,0.158l-0.358,0.071c-0.06,0.012-0.121,0.018-0.181,0.018 c-0.338,0-0.655-0.185-0.818-0.493l-0.085-0.16c-0.078-0.147-0.115-0.313-0.107-0.48l0.016-0.326l-0.512-0.202 c-0.138-0.055-0.261-0.141-0.358-0.253l-0.297-0.341l-0.306,0.033c-0.033,0.004-0.066,0.005-0.099,0.005 c-0.019,0-0.038-0.001-0.057-0.002l-0.515-0.032c-0.245-0.015-0.474-0.127-0.637-0.311l-0.342-0.387 c-0.037-0.042-0.071-0.088-0.1-0.136l-0.209-0.347l-0.007-0.003l-0.032,0.385c-0.037,0.443-0.384,0.798-0.827,0.844l-0.342,0.036 c-0.032,0.003-0.064,0.005-0.096,0.005c-0.193,0-0.382-0.06-0.54-0.174l-0.559-0.401l-0.478-0.029l-1.576,0.528 c-0.04,0.014-0.082,0.024-0.123,0.032l-0.927,0.174l-0.589,0.185l-0.312,0.175c-0.14,0.078-0.296,0.118-0.452,0.118 c-0.131,0-0.263-0.028-0.386-0.084l-0.413-0.189c-0.133-0.061-0.249-0.152-0.34-0.266l-0.337-0.425l-0.288-0.285l-0.235-0.071 l-0.562,0.157l-1.263,0.583c-0.076,0.035-0.157,0.06-0.24,0.073l-1.071,0.174c-0.04,0.007-0.081,0.01-0.122,0.012l-1.007,0.028 c-0.009,0-0.017,0-0.026,0c-0.029,0-0.057-0.001-0.086-0.004l-0.629-0.059l-0.237,0.024l0.124,0.411 c0.038,0.127,0.049,0.262,0.031,0.394l-0.247,1.803c-0.032,0.236-0.154,0.45-0.34,0.598l-0.813,0.649 c-0.161,0.129-0.36,0.2-0.566,0.202h-0.008l-0.141,2.001c-0.01,0.142-0.053,0.281-0.125,0.404l-0.258,0.44 c-0.171,0.292-0.48,0.457-0.799,0.457c-0.129,0-0.26-0.027-0.384-0.084l-0.482-0.22c-0.094-0.043-0.181-0.102-0.256-0.173 l-0.698-0.669l-0.675-0.496l-0.287-0.008l-0.642,0.214c-0.049,0.017-0.1,0.029-0.151,0.037l-1.121,0.174 c-0.047,0.007-0.094,0.011-0.142,0.011c-0.009,0-0.018,0-0.027,0l-3.087-0.09l-0.188,0.023l-0.24,0.459 c-0.026,0.049-0.056,0.096-0.091,0.14l-0.322,0.411c-0.176,0.225-0.445,0.355-0.729,0.355c-0.016,0-0.031,0-0.047-0.001 c-0.301-0.015-0.576-0.176-0.736-0.431l-0.147-0.234c-0.029-0.046-0.054-0.095-0.075-0.146l-0.084-0.207l-0.204-0.368l-0.165-0.212 l-0.36,0.053l-0.304,0.181l-0.3,0.347l-1.21,1.783c-0.174,0.256-0.462,0.406-0.766,0.406c-0.042,0-0.084-0.003-0.126-0.009 l-0.466-0.064c-0.045-0.006-0.089-0.015-0.132-0.028l-0.563-0.163c-0.059-0.017-0.117-0.04-0.171-0.069l-0.475-0.248 c-0.136-0.071-0.251-0.174-0.337-0.301l-0.092-0.135l-0.141-0.091l-0.835-0.09l-0.567,0.026l0.462,0.642 c0.171,0.237,0.219,0.542,0.131,0.82l-0.216,0.681l-0.386,1.958c-0.041,0.208-0.152,0.395-0.314,0.531l-0.491,0.411 c-0.167,0.14-0.378,0.216-0.595,0.216c-0.008,0-0.015,0-0.023,0l-0.932-0.023l-0.01,0.238c-0.009,0.215-0.092,0.421-0.236,0.582 l-0.093,0.104l-0.149,0.398c-0.021,0.055-0.046,0.108-0.077,0.158l-0.312,0.511c-0.034,0.056-0.075,0.109-0.12,0.156l-0.354,0.372 l0.174,0.275l0.483,0.376c0.066,0.052,0.125,0.112,0.176,0.18l0.406,0.55c0.054,0.073,0.097,0.154,0.127,0.239l0.138,0.388 c0.074,0.207,0.071,0.433-0.006,0.639l-0.087,0.23c-0.132,0.348-0.458,0.583-0.83,0.597l-0.2,0.008l-0.045,0.009l-0.01,0.09 l0.591,0.988c0.065,0.109,0.107,0.23,0.123,0.356l0.084,0.645c0.017,0.134,0.005,0.27-0.036,0.399l-0.177,0.558 c-0.07,0.22-0.219,0.405-0.418,0.521l-0.44,0.255c-0.144,0.083-0.304,0.125-0.464,0.125c-0.093,0-0.185-0.014-0.274-0.042 c-0.085,0.234-0.262,0.426-0.493,0.529l-0.559,0.249c-0.12,0.053-0.248,0.08-0.377,0.08c-0.09,0-0.18-0.013-0.267-0.039 l-0.439-0.132c-0.116-0.035-0.224-0.092-0.317-0.168c-0.034,0.026-0.071,0.05-0.109,0.072l-1.005,0.567l-0.507,0.415l-0.881,1.083 l-0.711,1.296c-0.019,0.034-0.039,0.066-0.062,0.097l0.199,0.067c0.103,0.035,0.199,0.088,0.284,0.156l0.414,0.333 c0.177,0.142,0.295,0.344,0.333,0.568l0.071,0.422c0.03,0.176,0.008,0.357-0.063,0.521l-0.17,0.394 c-0.085,0.197-0.236,0.358-0.427,0.456l-0.486,0.25l0.194,0.374c0.036,0.07,0.063,0.144,0.081,0.22l0.214,0.933 c0.013,0.056,0.02,0.112,0.023,0.17l0.043,1.067c0.005,0.116-0.012,0.231-0.05,0.34l-0.292,0.841 c-0.07,0.201-0.207,0.372-0.388,0.484l-2.205,1.362l-0.175,0.247l-0.11,0.345l-0.098,0.513c-0.03,0.158-0.101,0.304-0.205,0.426 l-0.536,0.629c-0.068,0.08-0.15,0.148-0.241,0.201l-1.109,0.643c-0.032,0.019-0.065,0.035-0.099,0.05l-3.682,1.578l-1.415,1.137 c-0.069,0.055-0.145,0.1-0.226,0.134l-17.601,7.281l1.846,0.602c0.048,0.016,0.094,0.035,0.139,0.058l2.198,1.138l1.025,0.279 c0.077,0.021,0.151,0.052,0.22,0.092l0.989,0.572c0.067,0.039,0.129,0.086,0.185,0.14l0.996,0.976 c0.04,0.039,0.077,0.083,0.109,0.129l2.245,3.191c0.025,0.036,0.048,0.073,0.067,0.112l1.868,3.656 c0.01,0.019,0.019,0.039,0.028,0.059l0.517,1.217l0.418,0.417l0.647,0.462l2.151,0.591l0.878,0.267l0.225,0.02 c0.113,0.01,0.223,0.041,0.325,0.09l0.435,0.213c0.132,0.064,0.246,0.159,0.334,0.276l0.377,0.503 c0.089,0.119,0.148,0.258,0.173,0.404l0.479-0.076l0.135-0.097c0.07-0.051,0.147-0.092,0.229-0.121l0.63-0.227 c0.025-0.009,0.051-0.017,0.077-0.024l0.616-0.163c0.077-0.02,0.157-0.031,0.237-0.031c0.016,0,0.032,0,0.049,0.001l0.67,0.035 c0.079,0.004,0.156,0.018,0.231,0.042l2.325,0.738l0.441,0.013c0.157,0.004,0.31,0.049,0.445,0.129l0.831,0.491 c0.002-0.012,0.004-0.025,0.007-0.037l0.058-0.279c0.062-0.301,0.27-0.552,0.554-0.669l0.309-0.127 c0.108-0.044,0.222-0.068,0.339-0.07l0.632-0.01l0.673-0.226c0.069-0.023,0.14-0.038,0.212-0.044l0.577-0.052 c0.028-0.002,0.055-0.004,0.083-0.004c0.163,0,0.324,0.043,0.467,0.126l0.312,0.182c0.06,0.035,0.115,0.076,0.166,0.123l0.17,0.159 l0.14,0.054l0.772-0.014l1.247-0.35c0.034-0.01,0.069-0.017,0.104-0.023l0.441-0.071c0.049-0.008,0.098-0.012,0.147-0.012 c0.002,0,0.004,0,0.006,0l0.006-0.011c0.129-0.242,0.358-0.415,0.626-0.472l0.533-0.113c0.063-0.013,0.128-0.02,0.192-0.02 c0.016,0,0.031,0,0.047,0.001l1.235,0.062l0.396-0.123l0.412-0.31c0.161-0.121,0.356-0.186,0.556-0.186 c0.016,0,0.031,0,0.047,0.001l0.513,0.026c0.167,0.008,0.329,0.062,0.468,0.155l0.643,0.43c0.114,0.076,0.21,0.177,0.281,0.295 l0.743,1.245l0.854,0.937c0.026,0.028,0.05,0.058,0.072,0.089l0.222,0.314c0.092,0.131,0.149,0.283,0.165,0.443l0.028,0.283 c0.013,0.135-0.003,0.271-0.048,0.398l-0.25,0.713c-0.071,0.202-0.209,0.373-0.392,0.484l-1.026,0.625l-0.255,0.32 c-0.065,0.082-0.143,0.152-0.232,0.207l-1.766,1.109l-1.024,0.861l-0.054,0.584l-0.151,1.924c-0.003,0.039-0.009,0.078-0.017,0.116 l-0.491,2.364c-0.012,0.056-0.028,0.11-0.05,0.163l-1.912,4.666l-0.043,0.392l0.14,0.307l4.617,3.837l2.15,1.112l1.221,0.435 l2.054,0.149c0.069,0.005,0.137,0.018,0.204,0.038l2.001,0.611c0.055,0.017,0.109,0.039,0.16,0.066l1.449,0.76 c0.019,0.01,0.039,0.021,0.057,0.033h0.001l1.138,0.007l0.62-0.183l1.876-0.981c0.072-0.038,0.149-0.066,0.228-0.083l0.786-0.175 c0.066-0.015,0.133-0.022,0.201-0.022c0.008,0,0.016,0,0.024,0l0.808,0.021c0.036,0.001,0.071,0.004,0.106,0.009l0.872,0.124 l1.609-0.136l2.994-1.363c0.102-0.047,0.212-0.074,0.324-0.081l1.751-0.113c0.02-0.001,0.04-0.002,0.06-0.002 c0.064,0,0.128,0.007,0.191,0.02l3.323,0.7c0.058,0.012,0.116,0.03,0.171,0.054l3.342,1.417l1.686,0.208h2.129l5.759-0.005 l8.146-0.007l9.338-0.009l9.336-0.01l8.146-0.007l5.762-0.005l2.185-0.002l1.216-0.002c-0.002-0.038-0.001-0.076,0.002-0.114 l0.017-0.22l-1.29-0.055c-0.453-0.019-0.826-0.364-0.88-0.815l-0.099-0.825c-0.008-0.067-0.009-0.135-0.002-0.202l0.058-0.585 l-0.737-0.092c-0.135-0.017-0.264-0.063-0.379-0.135l-0.3-0.189c-0.212-0.134-0.361-0.347-0.413-0.593 c-0.052-0.245-0.002-0.501,0.138-0.709l0.832-1.235l2.703-6.745c0.058-0.145,0.152-0.273,0.273-0.372l0.394-0.322 c0.166-0.136,0.374-0.209,0.586-0.209c0.041,0,0.081,0.003,0.122,0.008c0.254,0.034,0.482,0.171,0.631,0.379l0.217,0.303 c0.111,0.155,0.171,0.341,0.173,0.532l0.006,0.771l0.067,0.063l0.102,0.048l0.832,0.169c0.056,0.011,0.111,0.028,0.164,0.049 l1.05,0.426c0.102,0.042,0.197,0.101,0.278,0.176l0.687,0.631c0.076,0.07,0.14,0.152,0.189,0.243l0.45,0.836 c0.024,0.045,0.044,0.091,0.061,0.139l0.989,2.883l0.885,1.875l1.11,1.607l1.285,1.056l1.201,0.354l1.403-0.044l1.486-0.351 l1.368-0.495l1.647-0.934l1.248-1.174l5.465-7.281c0.021-0.028,0.043-0.054,0.067-0.079l3.506-3.723 c0.079-0.084,0.173-0.152,0.276-0.201l1.647-0.783l1.141-0.989c0.035-0.03,0.071-0.057,0.11-0.082l0.779-0.495 c0.115-0.073,0.245-0.12,0.38-0.137l1.444-0.184l0.135-0.066l0.659-0.691c0.061-0.064,0.131-0.119,0.207-0.163l0.429-0.248 c0.141-0.082,0.301-0.124,0.463-0.124c0.029,0,0.059,0.001,0.089,0.004l0.689,0.066c0.076,0.007,0.152,0.024,0.224,0.05 l1.959,0.703c0.032,0.011,0.063,0.024,0.093,0.039l0.729,0.355c0.091,0.044,0.174,0.103,0.246,0.174l1.149,1.136 c0.064,0.063,0.119,0.136,0.162,0.215l0.923,1.692c0.017,0.031,0.032,0.062,0.045,0.095l1.429,3.518l1.031,1.83l4.942,6.551 c0.035,0.047,0.066,0.096,0.092,0.149l1.76,3.577c0.02,0.04,0.036,0.081,0.05,0.123l1.562,4.804c0.016,0.049,0.028,0.1,0.035,0.151 l0.427,2.898c0.01,0.071,0.013,0.143,0.007,0.214l-1.117,13.075l0.156,2.193l0.168,0.507l0.198,0.031l3.78-1.048l2.958-0.824 c0.022-0.006,0.045-0.012,0.067-0.016l0.574-0.115L555.514,519.89z").attr({id: 'guainia', class: 'st18', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#EAEAEA'}).data({'id': 'guainia', 'region':'Guainía', 'benefited-companies':'0', 'benefited-projects': '0'});

        var cauca = rsr.path("M50.544,458.329c0.051,0.034,0.099,0.073,0.142,0.117l1.424,1.429 c0.151,0.151,0.245,0.35,0.266,0.563l0.082,0.83l0.211,0.952l0.546,1.58c0.018,0.051,0.031,0.104,0.039,0.158l0.075,0.477 c0.01,0.061,0.013,0.123,0.011,0.185l-0.021,0.496c-0.003,0.064-0.012,0.127-0.028,0.189l-0.139,0.546 c-0.008,0.031-0.017,0.061-0.028,0.09l-0.558,1.518l-0.066,0.28l-0.01,0.241l0.04,0.224l0.706,1.674l3.24,4.67 c0.053,0.076,0.094,0.16,0.122,0.248l0.139,0.439c0.02,0.064,0.034,0.13,0.04,0.197l0.12,1.331l0.044,0.09l0.196,0.2l1.108,0.503 l1.323,0.312c0.028,0.007,0.056,0.015,0.083,0.024l1.547,0.521l0.873,0.099l0.621-0.025l2.02-0.722 c0.1-0.036,0.206-0.054,0.312-0.054c0.017,0,0.033,0,0.05,0.001l1.204,0.064l1.025-0.43l0.63-0.501 c0.034-0.027,0.069-0.051,0.106-0.073l0.345-0.203c0.087-0.051,0.181-0.088,0.28-0.108l1.262-0.265 c0.04-0.008,0.08-0.014,0.121-0.017l1.135-0.085l0.457-0.162c0.035-0.04,0.074-0.077,0.116-0.11l0.426-0.34 c0.046-0.036,0.095-0.068,0.146-0.096l0.216-0.114c0.04-0.021,0.082-0.039,0.124-0.054l0.255-0.09 c0.042-0.015,0.085-0.027,0.129-0.035l0.785-0.153c0.037-0.007,0.074-0.012,0.112-0.015l0.565-0.04 c0.022-0.002,0.044-0.002,0.066-0.002c0.009,0,0.017,0,0.026,0l0.683,0.019c0.044,0.001,0.088,0.005,0.131,0.013L75.916,475 c0.05,0.009,0.099,0.021,0.147,0.038l0.844,0.293c0.029,0.01,0.058,0.022,0.086,0.035l4.063,1.887 c0.147,0.068,0.273,0.174,0.367,0.306l0.534,0.758c0.133,0.188,0.19,0.419,0.162,0.647l-0.166,1.351 c-0.016,0.132-0.061,0.258-0.13,0.371l-0.608,0.99l-0.182,0.599c-0.01,0.034-0.023,0.068-0.037,0.101l-0.103,0.236l0.184,0.185 l2.607,1.945l0.538,0.281l0.45,0.172c0.044,0.017,0.088,0.037,0.129,0.061l0.847,0.484c0.142,0.081,0.26,0.199,0.342,0.341 l0.671,1.162c0.141,0.245,0.163,0.541,0.06,0.803l-0.517,1.31c-0.016,0.041-0.035,0.081-0.057,0.119l-0.142,0.248 c-0.142,0.248-0.391,0.417-0.674,0.458l-0.136,0.019l-0.234,0.086l-0.002,0.006l-0.044,0.233c-0.015,0.078-0.039,0.155-0.074,0.227 l-0.35,0.739c-0.055,0.115-0.133,0.218-0.229,0.302l-1.459,1.269l-0.566,1.52l-0.071,0.261l-0.005,0.366l0.192,0.561 c0.044,0.128,0.059,0.264,0.045,0.399l-0.07,0.649c-0.004,0.034-0.009,0.069-0.017,0.102l-0.153,0.69 c-0.012,0.054-0.029,0.107-0.051,0.158l-0.747,1.774l1.457,0.47l0.109-0.04c0.086-0.032,0.175-0.05,0.266-0.056l0.161-0.009 c0.018-0.001,0.036-0.002,0.054-0.002c0.174,0,0.344,0.049,0.492,0.141l0.335,0.21l0.117,0.051l1.925-0.668 c0.085-0.029,0.173-0.046,0.263-0.05l0.624-0.027l0.608-0.207c0.096-0.033,0.197-0.05,0.299-0.05h0.281 c0.175,0,0.346,0.049,0.494,0.143l0.172,0.109c0.07,0.044,0.133,0.097,0.188,0.157l0.144,0.157l0.161,0.113l0.56,0.166l0.289,0.015 l0.212-0.04l0.156-0.082l0.392-0.29l0.234-0.25c0.015-0.016,0.031-0.032,0.048-0.048l0.613-0.567 c0.065-0.06,0.138-0.11,0.217-0.149l0.276-0.137c0.053-0.026,0.108-0.047,0.165-0.063l1.431-0.394 c0.044-0.012,0.089-0.021,0.135-0.026l1.786-0.217l1.36-0.417c0.089-0.027,0.18-0.041,0.272-0.041c0.109,0,0.218,0.019,0.322,0.058 l0.452,0.168c0.058,0.022,0.115,0.049,0.167,0.082l0.3,0.186c0.116,0.072,0.215,0.17,0.289,0.285l1.426,2.215l1.249,1.824 l0.346,0.264c0.059,0.045,0.112,0.096,0.158,0.154l0.191,0.236c0.035,0.043,0.065,0.088,0.092,0.137l0.206,0.375 c0.054,0.098,0.09,0.205,0.105,0.316l0.053,0.375c0.011,0.075,0.012,0.151,0.004,0.226l-0.046,0.439 c-0.004,0.04-0.011,0.081-0.021,0.12l-0.223,0.93c-0.012,0.048-0.027,0.096-0.046,0.142l-0.208,0.496 c-0.034,0.081-0.08,0.158-0.135,0.226l-0.506,0.623c-0.02,0.025-0.042,0.049-0.065,0.072l-0.506,0.505 c-0.049,0.048-0.102,0.091-0.16,0.128l-1.874,1.181l-0.075,0.342l0.196,3.671l0.456,2.146c0.01,0.047,0.016,0.096,0.019,0.144 l0.045,0.856l0.624-0.004c0.002,0,0.004,0,0.006,0c0.019,0,0.039,0.001,0.058,0.002l3.484,0.219l0.961-0.198l0.98-0.564l0.9-0.987 l2.351-3.552c0.127-0.193,0.322-0.331,0.546-0.387l0.73-0.184c0.074-0.019,0.15-0.028,0.226-0.028c0.106,0,0.212,0.018,0.312,0.054 l0.745,0.267c0.067,0.024,0.131,0.055,0.19,0.094l0.672,0.434l1.456,0.605c0.139,0.058,0.262,0.148,0.358,0.264l0.804,0.97 c0.028,0.034,0.054,0.07,0.077,0.107l0.833,1.362c0.057,0.094,0.098,0.197,0.119,0.305l0.037,0.187l0.57,0.521 c0.094,0.086,0.17,0.191,0.222,0.308l0.573,1.293c0.021,0.047,0.037,0.095,0.05,0.144l0.162,0.628 c0.014,0.056,0.024,0.113,0.027,0.171l0.039,0.599c0.006,0.094-0.002,0.188-0.024,0.279l-0.196,0.805 c-0.017,0.069-0.041,0.135-0.073,0.198l-0.732,1.452l-0.177,0.632l-0.166,3.783l0.373,1.636l0.914,1.401l0.654,0.457l3.105,0.998 c0.039,0.013,0.077,0.028,0.114,0.045l1.715,0.815l1.21,0.233l6.229,0.212l0.438-0.124l0.275-0.182l0.34-0.315 c0.028-0.025,0.057-0.049,0.087-0.071l0.533-0.385c0.046-0.033,0.096-0.062,0.147-0.087l0.701-0.33 c0.064-0.03,0.131-0.053,0.2-0.068l0.572-0.123c0.064-0.014,0.129-0.021,0.194-0.021c0.015,0,0.03,0,0.045,0.001l1.354,0.066 l0.361-0.071l0.098-0.118l0.219-0.454c0.004-0.009,0.009-0.018,0.013-0.027l-3.621-3.252l-0.051-0.013l-1.559,0.26 c-0.051,0.008-0.102,0.013-0.153,0.013c-0.056,0-0.113-0.005-0.168-0.015l-2.144-0.396c-0.097-0.018-0.191-0.052-0.278-0.099 l-0.789-0.434c-0.108-0.06-0.203-0.14-0.28-0.237l-0.526-0.666c-0.04-0.05-0.074-0.105-0.103-0.162l-0.526-1.06 c-0.043-0.086-0.072-0.179-0.086-0.274l-0.078-0.515c-0.011-0.072-0.013-0.146-0.007-0.219l0.523-5.988 c0.004-0.051,0.013-0.102,0.026-0.151l0.151-0.585c0.03-0.117,0.083-0.226,0.155-0.323l0.809-1.082l0.25-0.537l0.233-1.411 c0.014-0.083,0.039-0.164,0.074-0.24l1.057-2.268c0.017-0.037,0.037-0.073,0.059-0.107l2.047-3.206l0.726-1.143l-0.159-0.074 l-1.541-0.057c-0.089-0.003-0.177-0.019-0.262-0.048l-1.66-0.559c-0.077-0.026-0.15-0.062-0.217-0.107l-0.593-0.394l-1.054-0.309 l-2.244-0.669c-0.07-0.021-0.136-0.05-0.199-0.086l-1.591-0.921c-0.066-0.038-0.127-0.085-0.182-0.138l-1.225-1.192 c-0.054-0.053-0.102-0.112-0.141-0.176l-1.982-3.203l-2.253-2.926l-3.231-2.513c-0.097-0.075-0.178-0.169-0.238-0.276l-0.951-1.686 c-0.067-0.119-0.107-0.252-0.117-0.389l-0.137-1.922c-0.003-0.036-0.003-0.073-0.001-0.109l0.028-0.602 c0.006-0.12,0.035-0.238,0.085-0.347l0.371-0.798c0.05-0.108,0.12-0.205,0.207-0.286l1.042-0.975l0.005-0.017l-0.137-1.181 c-0.003-0.027-0.005-0.054-0.006-0.082l-0.057-2.104c-0.006-0.209,0.06-0.413,0.185-0.581l0.738-0.984 c0.082-0.109,0.188-0.199,0.309-0.263l0.649-0.343c0.134-0.071,0.283-0.107,0.432-0.107c0.067,0,0.135,0.007,0.202,0.022 l0.762,0.17c0.088,0.02,0.173,0.052,0.252,0.096l0.401,0.225l0.467,0.073l0.735-0.004c0.002,0,0.004,0,0.005,0 c0.056,0,0.111,0.005,0.166,0.015l0.701,0.127l0.434-0.094l0.333-0.123l-0.024-0.073c-0.018-0.053-0.031-0.107-0.038-0.162 l-0.065-0.449c-0.007-0.05-0.01-0.1-0.009-0.15l0.007-0.356c0.004-0.202,0.073-0.396,0.198-0.555l0.608-0.772 c0.089-0.114,0.204-0.205,0.335-0.266l0.255-0.119l0.454-0.851l0.625-1.66l0.138-0.441c0.028-0.09,0.07-0.176,0.124-0.253 l0.209-0.299l0.012-0.237l-1.553-3.42c-0.087-0.192-0.106-0.409-0.054-0.613l0.624-2.43c0.107-0.417,0.483-0.696,0.896-0.696 c0.067,0,0.135,0.007,0.204,0.023l1.378,0.31c0.157,0.035,0.302,0.111,0.421,0.22l0.695,0.635l2.318,1.782l0.601,0.121l0.907,0.023 l3.445-0.91l1.397-0.534l3.163-1.566l0.981-0.73l0.968-0.858l1.065-1.233c0.107-0.124,0.246-0.218,0.402-0.271l0.602-0.205 c0.098-0.033,0.199-0.05,0.299-0.05c0.188,0,0.375,0.057,0.533,0.169l1.638,1.152c0.028,0.02,0.055,0.041,0.08,0.063l1.424,1.258 l0.573,0.288l0.777-0.035l0.335-0.546c0.039-0.063,0.084-0.121,0.137-0.173l0.559-0.555c0.059-0.059,0.127-0.11,0.2-0.151 l0.319-0.179l-0.882-1.752c-0.076-0.151-0.109-0.32-0.096-0.488l0.104-1.328c0.009-0.112,0.038-0.222,0.086-0.324l0.824-1.742 l0.84-2.78l-0.408-0.7c-0.02-0.034-0.037-0.069-0.053-0.105l-0.473-1.118l-0.426-0.488l-0.647-0.464l-0.647-0.269 c-0.096-0.04-0.184-0.096-0.262-0.165l-0.591-0.529c-0.031-0.027-0.059-0.057-0.086-0.088l-1.171-1.369l-1.151-1.009l-4.806-4.191 c-0.114-0.099-0.201-0.224-0.256-0.365l-0.312-0.808c-0.043-0.111-0.064-0.229-0.062-0.348l0.044-2.861l-0.517-1.432l-0.799-0.702 c-0.058-0.051-0.109-0.108-0.152-0.172l-0.445-0.648l-0.396-0.158c-0.089-0.036-0.172-0.085-0.247-0.146l-0.875-0.723 c-0.208-0.172-0.331-0.426-0.336-0.697l-0.009-0.494c-0.001-0.04,0.001-0.079,0.005-0.118l0.059-0.539 c0.01-0.092,0.034-0.182,0.071-0.267l0.163-0.376c0.043-0.099,0.103-0.189,0.176-0.268l0.267-0.283l0.204-0.81l-0.124-0.602 c-0.023-0.114-0.025-0.231-0.005-0.345l0.163-0.937l-0.328-0.12l-2.833-0.629c-0.05-0.011-0.099-0.026-0.147-0.046l-0.7-0.284 c-0.072-0.029-0.14-0.068-0.203-0.114l-1.543-1.143l-1-0.315l-4.373-0.329c-0.039-0.003-0.078-0.008-0.116-0.016l-2.017-0.413 c-0.077-0.016-0.152-0.041-0.223-0.076l-0.814-0.4l-0.3-0.144l-0.337,0.389l0.328,0.31c0.097,0.092,0.173,0.203,0.223,0.327 l0.15,0.372c0.048,0.12,0.071,0.249,0.067,0.379l-0.057,1.614c-0.002,0.067-0.012,0.133-0.028,0.197l-0.183,0.714 c-0.02,0.079-0.051,0.155-0.091,0.226l-0.385,0.681c-0.043,0.076-0.096,0.146-0.159,0.207l-0.491,0.48 c-0.082,0.08-0.178,0.144-0.283,0.189l-0.488,0.209c-0.058,0.025-0.119,0.044-0.181,0.056l-1.05,0.213l-0.307,0.14l-0.065,0.073 l-0.376,0.855c-0.027,0.061-0.06,0.118-0.099,0.172l-0.291,0.4c-0.029,0.04-0.061,0.077-0.096,0.112l-0.71,0.707 c-0.179,0.178-0.416,0.27-0.654,0.27c-0.188,0-0.376-0.057-0.539-0.173l-0.552-0.395l-0.038,0.057 c-0.031,0.047-0.067,0.091-0.107,0.132l-0.004,0.004l-0.044,0.136c-0.045,0.139-0.123,0.265-0.226,0.368l-0.131,0.131 c-0.16,0.16-0.374,0.256-0.601,0.27l-0.241,0.014c-0.018,0.001-0.036,0.002-0.054,0.002c-0.107,0-0.214-0.019-0.315-0.055 l-0.353-0.128c-0.15-0.054-0.284-0.147-0.388-0.268l-0.281-0.328c-0.057,0.051-0.12,0.094-0.188,0.129l-0.363,0.188 c-0.132,0.068-0.278,0.103-0.425,0.103c-0.043,0-0.086-0.003-0.128-0.009l-0.608-0.085c-0.096-0.013-0.19-0.042-0.277-0.084 l-0.837-0.408c-0.074-0.036-0.142-0.081-0.204-0.135l-0.967-0.844l-2.159-1.469l-0.926,1.687c-0.036,0.065-0.079,0.126-0.129,0.18 l-0.82,0.895c-0.054,0.059-0.115,0.11-0.182,0.153l-0.336,0.216c-0.052,0.034-0.108,0.062-0.166,0.084l-0.31,0.12 c-0.023,0.009-0.046,0.017-0.07,0.024l-0.466,0.139c-0.048,0.014-0.097,0.025-0.147,0.031l-0.742,0.096 c-0.039,0.005-0.079,0.008-0.118,0.008c-0.036,0-0.072-0.002-0.108-0.006l-0.813-0.096c-0.065-0.008-0.129-0.022-0.19-0.043 l-1.325-0.451c-0.047-0.016-0.093-0.036-0.137-0.059l-2.606-1.389l-0.447-0.18c-0.119-0.048-0.227-0.12-0.317-0.212l-0.104-0.106 c-0.079-0.081-0.143-0.176-0.188-0.28l-0.017-0.038l-0.006-0.009l-0.609-0.57l-0.136-0.081l-2.059-0.64l-1.899-0.353l-0.6,0.109 l-0.752,0.265l-0.666,0.475c-0.141,0.1-0.307,0.159-0.479,0.17l-0.283,0.018c-0.019,0.001-0.039,0.002-0.058,0.002 c-0.079,0-0.158-0.01-0.234-0.03l-0.031-0.008l-0.095,0.092c-0.027,0.026-0.056,0.051-0.086,0.073l-0.13,0.098l-0.319,0.346 c-0.021,0.023-0.043,0.044-0.066,0.064l-0.458,0.408c-0.022,0.019-0.045,0.038-0.068,0.055l-0.131,0.096l-0.31,0.32 c-0.036,0.037-0.075,0.071-0.117,0.102l-0.257,0.189c-0.078,0.057-0.165,0.102-0.258,0.133l-0.483,0.16 c-0.094,0.031-0.192,0.047-0.29,0.047c-0.095,0-0.189-0.014-0.28-0.043l-0.253-0.08c-0.045,0.011-0.091,0.019-0.138,0.024 c-0.03,0.003-0.059,0.004-0.088,0.004c-0.272,0-0.532-0.12-0.709-0.33l-0.472-0.561c-0.026,0.002-0.052,0.003-0.078,0.003 c-0.206,0-0.408-0.069-0.572-0.198l-0.334-0.262c-0.151-0.119-0.262-0.281-0.316-0.466l-0.051-0.171 c-0.024-0.08-0.036-0.161-0.038-0.243l-0.271-0.125h-0.007l-0.019,0.012c-0.032,0.019-0.065,0.037-0.099,0.052l-0.283,0.128 c-0.037,0.017-0.076,0.031-0.115,0.043l-0.356,0.106c-0.049,0.015-0.099,0.025-0.15,0.032l-0.71,0.089 c-0.038,0.005-0.076,0.007-0.115,0.007c-0.155,0-0.308-0.039-0.444-0.114l-0.369-0.202c-0.141-0.077-0.26-0.19-0.344-0.326 l-0.578-0.937c-0.028-0.046-0.053-0.095-0.073-0.145l-0.133-0.337c-0.029-0.074-0.049-0.152-0.059-0.231l-0.034-0.282l-0.042-0.191 l-0.1-0.228l-0.38-0.435c-0.045-0.051-0.084-0.107-0.116-0.167l-0.531-0.976l-0.068-0.049c-0.035-0.025-0.068-0.053-0.099-0.083 l-1.442-1.387l-0.453,0.171l-0.621,0.381l-0.097,0.084c0.047,0.013,0.093,0.03,0.138,0.051l0.701,0.323 c0.178,0.082,0.325,0.218,0.421,0.388l0.263,0.468c0.203,0.361,0.141,0.814-0.152,1.107l-0.277,0.278 c-0.174,0.174-0.407,0.27-0.646,0.272c-0.007,0.04-0.017,0.08-0.029,0.119l-0.143,0.458c-0.077,0.248-0.256,0.452-0.491,0.563 c-0.124,0.058-0.259,0.088-0.393,0.088c-0.12,0-0.24-0.023-0.353-0.07l-0.432-0.178l-0.354,0.652l-0.911,1.692 c-0.055,0.103-0.129,0.194-0.218,0.269l-3.443,2.903l-0.581,0.615l-0.701,1.006c0.062-0.023,0.127-0.04,0.194-0.05 c0.045-0.007,0.089-0.01,0.134-0.01c0.326,0,0.632,0.173,0.799,0.459l0.085-0.006c0.021-0.001,0.042-0.002,0.063-0.002 c0.164,0,0.325,0.043,0.467,0.126l0.299,0.175c0.165,0.096,0.296,0.242,0.376,0.416l0.192,0.421 c0.177,0.388,0.066,0.846-0.268,1.11l-0.08,0.063c0.099,0.069,0.185,0.158,0.251,0.262l0.156,0.245 c0.082,0.129,0.131,0.276,0.142,0.429l0.037,0.504c0.007,0.101-0.002,0.203-0.027,0.301l-0.046,0.179 c-0.053,0.205-0.175,0.385-0.345,0.511l-0.143,0.106l-0.27,0.27l-0.089,0.167l-0.023,0.133c-0.03,0.172-0.107,0.33-0.221,0.458 c0.322,0.21,0.488,0.605,0.394,0.995l-0.258,1.062c-0.094,0.387-0.425,0.671-0.822,0.704c-0.026,0.002-0.052,0.003-0.078,0.003 c-0.367,0-0.703-0.218-0.85-0.56l-0.067-0.156l-0.039-0.036l-0.012-0.006l-0.089,0.103c-0.122,0.142-0.285,0.244-0.467,0.292 l-0.604,0.158c0.162,0.095,0.294,0.239,0.373,0.414l0.446,0.979c0.131,0.287,0.107,0.62-0.064,0.885 c-0.17,0.265-0.464,0.425-0.779,0.425h-0.34c-0.333,0-0.636-0.178-0.8-0.459c-0.049,0.212-0.173,0.407-0.363,0.543l-0.26,0.186 c-0.087,0.062-0.184,0.109-0.287,0.138l-0.409,0.115c-0.046,0.013-0.093,0.022-0.141,0.028l-0.175,0.021l-0.382,0.151l-0.466,0.376 c-0.067,0.054-0.14,0.098-0.219,0.132l-0.252,0.107c-0.012,0.133-0.052,0.264-0.121,0.383l-0.006,0.01 c0.152,0.1,0.272,0.244,0.344,0.416c0.094,0.226,0.094,0.478,0.004,0.701c0.419,0.096,0.719,0.47,0.719,0.903v0.344 c0,0.098-0.015,0.193-0.044,0.281l0.191,0.187c0.047,0.046,0.089,0.098,0.126,0.153l0.515,0.787 c0.022,0.034,0.042,0.069,0.06,0.106l0.279,0.58c0.058,0.12,0.089,0.251,0.091,0.384l0.015,0.807 c0.003,0.152-0.032,0.303-0.101,0.439l-0.42,0.822c-0.06,0.118-0.145,0.222-0.249,0.304l-0.801,0.636 c-0.108,0.086-0.234,0.146-0.368,0.177l-1.117,0.257c-0.046,0.011-0.092,0.018-0.138,0.021l-0.462,0.035l-1.121,0.233 c-0.062,0.013-0.125,0.019-0.188,0.019c-0.006,0-0.012,0-0.018,0l-0.58-0.011c-0.065-0.001-0.129-0.009-0.192-0.024l-0.868-0.202 l-0.485-0.053c-0.082-0.009-0.163-0.029-0.24-0.06l-0.911-0.361c-0.334-0.132-0.561-0.445-0.583-0.803l-0.052-0.833 c-0.009-0.137,0.014-0.275,0.065-0.402l0.121-0.302l-0.052-0.014c-0.209-0.055-0.392-0.181-0.518-0.357l-0.359-0.501 c-0.021-0.029-0.04-0.06-0.058-0.091l-0.399-0.723l-0.294-0.263l-0.289-0.028l-0.757,0.441l-0.557,0.359 c-0.135,0.087-0.29,0.137-0.45,0.146l-0.676,0.037L50.544,458.329z").attr({id: 'cauca', class: 'st19', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#C7B1F2'}).data({'id': 'cauca', 'region':'Cauca', 'benefited-companies':'10', 'benefited-projects': '$280.000.000'});

        var choco = rsr.path("M55.159,245.569l0.679,0.892l0.299,0.242l0.408,0.122c0.307,0.092,0.543,0.334,0.628,0.641 c0.09,0.067,0.168,0.15,0.229,0.246l0.353,0.552c0.018,0.028,0.034,0.056,0.048,0.085l0.164,0.328l0.043,0.026l0.633,0.074 c0.123,0.014,0.242,0.053,0.35,0.115l0.491,0.279c0.082,0.046,0.156,0.105,0.219,0.173l2.94,3.151 c0.068-0.016,0.139-0.024,0.211-0.024h0.312c0.344,0,0.66,0.191,0.82,0.495l1.427,2.713c0.026,0.049,0.047,0.101,0.064,0.154 l0.561,1.792c0.084,0.269,0.042,0.561-0.116,0.794l-0.544,0.808c-0.099,0.147-0.238,0.263-0.401,0.333l-0.868,0.375l-0.237,0.756 l0.059,0.821l0.096-0.032c0.095-0.031,0.193-0.047,0.29-0.047c0.181,0,0.359,0.053,0.513,0.155l0.197,0.131 c0.074,0.049,0.141,0.109,0.198,0.178l0.901,0.219c0.104,0.025,0.203,0.069,0.293,0.128l0.658,0.436 c0.049,0.033,0.095,0.07,0.137,0.111l1.304,1.28c0.036,0.036,0.07,0.074,0.1,0.115l0.909,1.246 c0.036,0.049,0.066,0.101,0.092,0.156l1.897,4.09c0.005,0.01,0.009,0.02,0.013,0.03l0.666-0.513 c0.103-0.079,0.222-0.136,0.349-0.167l1.074-0.258c0.071-0.017,0.144-0.026,0.216-0.026c0.159,0,0.317,0.041,0.457,0.121 l1.453,0.825l0.351,0.101c0.092,0.026,0.179,0.066,0.258,0.119l0.34,0.226c0.197,0.131,0.336,0.332,0.389,0.562l0.136,0.586 c0.023,0.098,0.029,0.199,0.019,0.299l-0.058,0.588c-0.004,0.044-0.012,0.087-0.022,0.129l-0.184,0.752 c0.071,0.045,0.135,0.099,0.192,0.161l0.268,0.295c0.031,0.034,0.059,0.071,0.085,0.109l0.176,0.264l0.222,0.246l1.503,1.209 c0.106,0.086,0.193,0.194,0.252,0.317l0.349,0.718c0.047,0.097,0.077,0.201,0.088,0.308l0.108,1.027 c0.01,0.094,0.005,0.188-0.013,0.28l-0.207,1.021c-0.031,0.155-0.102,0.3-0.205,0.42l-0.373,0.435l-0.011,0.609 c-0.002,0.087-0.015,0.173-0.041,0.256l-0.227,0.737c-0.021,0.07-0.051,0.136-0.088,0.199l-0.364,0.617 c0.06,0.047,0.113,0.1,0.16,0.16l0.405,0.52c0.078,0.1,0.135,0.216,0.167,0.339l0.165,0.643c0.04,0.155,0.039,0.317-0.003,0.472 l-0.19,0.703c-0.084,0.31-0.322,0.555-0.63,0.647c-0.087,0.026-0.176,0.038-0.264,0.038c-0.024,0-0.047-0.001-0.071-0.003 c0.01,0.026,0.019,0.053,0.026,0.079l0.139,0.497c0.016,0.057,0.026,0.116,0.031,0.175l0.056,0.686 c0.003,0.04,0.004,0.081,0.002,0.122l-0.041,0.809c-0.002,0.039-0.007,0.079-0.013,0.117l-0.155,0.86 c-0.01,0.055-0.025,0.109-0.044,0.161l-0.635,1.697c-0.018,0.049-0.041,0.096-0.067,0.141l-0.463,0.796 c-0.066,0.113-0.155,0.212-0.262,0.288l-0.46,0.329c-0.163,0.116-0.351,0.173-0.538,0.173c-0.276,0-0.548-0.123-0.73-0.355 l-1.032-1.319l-0.153-0.128l-0.279,1.46l-0.039,1.621l0.105,0.416l0.391,0.634l2.759,3.374c0.022,0.026,0.042,0.054,0.06,0.083 l1.171,1.807c0.038,0.058,0.069,0.12,0.092,0.185l0.056,0.152c0.031-0.003,0.063-0.005,0.095-0.005h0.34 c0.389,0,0.737,0.243,0.87,0.609l1.806,4.949c0.034,0.092,0.052,0.189,0.056,0.287l0.019,0.559c0.012,0.01,0.023,0.02,0.034,0.03 l0.16,0.149c0.06,0.056,0.112,0.12,0.155,0.19l1.864,3.018c0.024,0.039,0.045,0.08,0.063,0.122l0.691,1.614 c0.041,0.097,0.066,0.2,0.073,0.305l0.123,1.912c0.005,0.077,0,0.154-0.014,0.23l-0.099,0.526c-0.006,0.03-0.013,0.06-0.021,0.089 l-0.159,0.545c-0.012,0.04-0.026,0.079-0.043,0.116l-0.232,0.523c-0.021,0.047-0.045,0.091-0.073,0.134l-0.303,0.459 c-0.055,0.084-0.124,0.158-0.203,0.22l-0.433,0.338c-0.027,0.021-0.055,0.041-0.084,0.058l-0.529,0.326l-0.28,0.225l-0.123,0.284 c-0.028,0.065-0.063,0.126-0.105,0.183l-0.123,0.166c-0.143,0.194-0.353,0.321-0.584,0.362l-0.044,0.202 c-0.016,0.075-0.042,0.147-0.076,0.215l-0.132,0.266l-0.043,0.206c-0.01,0.047-0.023,0.094-0.041,0.139l-0.106,0.28 c-0.05,0.132-0.129,0.251-0.232,0.347l-0.292,0.274c-0.098,0.092-0.215,0.162-0.343,0.204l-1.025,0.34 c-0.095,0.031-0.193,0.047-0.291,0.047c-0.1,0-0.201-0.016-0.297-0.049l-0.756-0.256c-0.073-0.025-0.143-0.059-0.208-0.101 l-0.572-0.372l-0.465-0.137l-0.253,0.046l-0.206,0.145l-0.344,0.345c-0.036,0.036-0.074,0.068-0.115,0.098l-0.544,0.392 c-0.091,0.065-0.193,0.114-0.301,0.143l-0.444,0.119c-0.059,0.016-0.12,0.026-0.181,0.03l-0.907,0.058l-0.024,0.007l-0.307,0.402 l-1.03,2.163c0.014-0.005,0.028-0.009,0.043-0.014l0.477-0.138c0.084-0.024,0.17-0.036,0.257-0.036h0.654 c0.092,0,0.184,0.014,0.272,0.041l0.658,0.202c0.15,0.046,0.286,0.129,0.394,0.242l0.373,0.386c0.038,0.04,0.073,0.083,0.104,0.129 l0.267,0.399l0.306,0.293l0.027,0.01l0.657,0.11c0.058,0.01,0.114,0.025,0.169,0.045l0.212,0.078 c0.154,0.057,0.289,0.153,0.393,0.28l0.275,0.334c0.105,0.128,0.175,0.282,0.2,0.446l0.029,0.189 c0.016,0.105,0.015,0.212-0.005,0.316l0.259,1.11l0.037,0.084l0.235,0.15c0.254,0.163,0.413,0.439,0.426,0.74 c0.011,0.255-0.083,0.5-0.257,0.681c0.149,0.155,0.241,0.359,0.256,0.578l0.118,1.74l0.142,0.536l0.218,0.191 c0.104,0.091,0.186,0.204,0.241,0.33l0.201,0.464c0.063,0.146,0.088,0.307,0.071,0.465l-0.1,0.944l0.019,0.433l0.235,0.143 c0.397,0.241,0.554,0.738,0.368,1.163l-0.558,1.274l-0.374,1.365l-0.206,1.422l0.273,6.653l0.23,0.615 c0.029,0.077,0.047,0.158,0.055,0.24l0.538,5.827l0.165,0.781c0.089-0.028,0.182-0.042,0.274-0.042 c0.146,0,0.292,0.035,0.425,0.103c0.25,0.129,0.428,0.365,0.483,0.641l0.263,1.315l1.787,2.162c0.067,0.081,0.12,0.173,0.156,0.272 l0.535,1.465c0.104,0.284,0.062,0.601-0.111,0.849c-0.173,0.248-0.457,0.395-0.759,0.395h-0.284c-0.116,0-0.229-0.022-0.334-0.062 c0.016,0.1,0.015,0.201-0.002,0.301l-0.128,0.75c-0.013,0.078-0.037,0.154-0.069,0.226l-0.208,0.459 c-0.116,0.256-0.342,0.445-0.615,0.515c-0.074,0.019-0.149,0.028-0.224,0.029l-0.019,4.076c0,0.069-0.008,0.137-0.024,0.204 l-0.463,2.01c0.148,0.02,0.29,0.076,0.415,0.166c0.241,0.174,0.385,0.454,0.385,0.751v0.311c0,0.359-0.208,0.686-0.533,0.839 l-0.781,0.366l-0.211,0.327l-0.329,1.791c-0.011,0.058-0.027,0.114-0.048,0.169l-0.273,0.701c-0.027,0.07-0.063,0.136-0.105,0.197 l-0.941,1.338l1.341,2.242l0.364,0.451l0.294,0.045l3.798,0.046c0.352,0.004,0.671,0.208,0.824,0.525 c0.152,0.317,0.112,0.694-0.105,0.971l-0.464,0.594l0.105,0.254c0.047,0.113,0.071,0.234,0.07,0.356l-0.003,1.084l0.041,0.156 l0.132,0.188l0.237,0.255l0.062,0.039l0.024-0.021c0.048-0.042,0.1-0.078,0.155-0.109l0.239-0.135 c0.057-0.032,0.117-0.058,0.179-0.077l1.024-0.319c0.059-0.018,0.12-0.031,0.182-0.037l0.453-0.046 c0.031-0.003,0.062-0.005,0.094-0.005c0.072,0,0.144,0.008,0.214,0.025l0.432,0.103c0.125,0.03,0.242,0.085,0.344,0.162 l0.669,0.506l0.36,0.075c0.181,0.038,0.347,0.129,0.476,0.262l1.963,2.022c0.026,0.027,0.051,0.056,0.074,0.086l0.362,0.477 l0.368-0.002c0.001,0,0.003,0,0.004,0c0.044,0,0.087,0.003,0.13,0.009l0.882,0.125l0.26-0.016l0.204-0.059l0.102-0.069l0.325-0.412 c0.062-0.078,0.136-0.146,0.219-0.201l0.216-0.142c0.14-0.092,0.302-0.144,0.469-0.151l0.335-0.014c0.013,0,0.026-0.001,0.04-0.001 c0.059,0,0.118,0.006,0.175,0.017l0.48,0.093l0.321-0.028c0.027-0.002,0.053-0.003,0.08-0.003c0.143,0,0.284,0.033,0.413,0.097 l0.506,0.252c0.083,0.041,0.16,0.095,0.227,0.159l0.548,0.523c0.053,0.051,0.1,0.108,0.14,0.17l1.731,2.7l0.644,0.313l1.194-0.147 c0.038-0.005,0.076-0.007,0.113-0.007c0.092,0,0.184,0.014,0.272,0.041l0.611,0.188c0.229,0.07,0.422,0.227,0.538,0.436 l0.071,0.128c0.017,0.031,0.032,0.062,0.046,0.095l0.184,0.108l0.456,0.117c0.052,0.013,0.102,0.031,0.151,0.053l1.308,0.589 l0.491,0.034l0.211-0.065l1.361-1.32c0.025-0.025,0.052-0.048,0.08-0.069l0.723-0.556l0.632-0.613 c0.072-0.07,0.155-0.128,0.246-0.171l0.52-0.248c0.115-0.055,0.239-0.085,0.366-0.09l0.51-0.018c0.011,0,0.022-0.001,0.032-0.001 c0.082,0,0.163,0.011,0.242,0.032l2.037,0.551c0.009-0.082,0.029-0.163,0.059-0.24l0.184-0.468c0.029-0.075,0.069-0.146,0.116-0.21 l1.053-1.429c0.023-0.031,0.047-0.06,0.073-0.088l1.148-1.212c0.071-0.075,0.154-0.137,0.246-0.185l1.066-0.553 c0.056-0.029,0.114-0.052,0.174-0.069l0.879-0.249l0.943-0.911l0.025-0.056l-0.209-0.214l-1.767-0.908 c-0.258-0.133-0.439-0.378-0.489-0.664l-0.202-1.151c-0.017-0.094-0.018-0.191-0.005-0.285l0.282-2.065l-0.004-0.004l-0.28-0.196 c-0.039-0.027-0.076-0.058-0.111-0.091l-0.42-0.405c-0.033-0.032-0.063-0.065-0.091-0.101l-0.444-0.575 c-0.03-0.038-0.056-0.079-0.079-0.121l-0.788-1.442c-0.044-0.08-0.075-0.166-0.094-0.256l-0.07-0.335 c-0.039-0.188-0.019-0.384,0.058-0.56l0.064-0.145c0.147-0.337,0.481-0.555,0.848-0.555h0.163c0.074,0,0.147,0.009,0.219,0.026 l0.422,0.103l0.137-0.003l0.725-0.157l0.412-0.147c0.03-0.011,0.061-0.02,0.092-0.027l0.393-0.096l0.239-0.084l0.121-0.078 l0.375-0.32l0.486-1.668l-0.041-0.53l-0.274-0.673c-0.052-0.127-0.075-0.263-0.067-0.4l0.029-0.543 c0.004-0.068,0.015-0.136,0.034-0.202l0.666-2.36c0.018-0.062,0.042-0.123,0.072-0.18l0.384-0.728 c0.052-0.098,0.12-0.186,0.203-0.259l2.449-2.183c0.025-0.022,0.052-0.044,0.079-0.063l1.137-0.81l1.267-1.29l0.359-0.554 l-0.044-0.195l-0.203-0.343c-0.099-0.168-0.143-0.364-0.125-0.558l0.051-0.537c0.008-0.083,0.027-0.164,0.056-0.241l0.24-0.633 c0.022-0.057,0.049-0.113,0.082-0.165l0.367-0.584c0.018-0.029,0.038-0.057,0.059-0.083l0.333-0.419 c0.035-0.044,0.075-0.086,0.118-0.123l3.644-3.167l1.711-1.942l0.07-0.19l1.166-3.325c0.028-0.08,0.067-0.157,0.116-0.226 l0.413-0.587c0.022-0.031,0.046-0.061,0.072-0.09l0.719-0.792c0.057-0.063,0.123-0.118,0.196-0.163l0.395-0.246l1.02-0.998 l0.031-1.592l-0.545-0.956c-0.088-0.155-0.13-0.332-0.12-0.51l0.065-1.175l-0.364-1.391l-3.687-6.013 c-0.078-0.127-0.124-0.272-0.134-0.42l-0.137-1.983c-0.008-0.113,0.005-0.226,0.038-0.334l0.793-2.601 c0.053-0.174,0.156-0.328,0.296-0.444l0.918-0.758c0.039-0.032,0.081-0.061,0.125-0.087l2.027-1.177l0.436-2.073l0.055-1.15 c0.011-0.221,0.1-0.431,0.252-0.592l1.112-1.176l-1.178-1.207c-0.018-0.019-0.036-0.039-0.053-0.059l-0.278-0.339 c-0.039-0.047-0.073-0.098-0.101-0.152l-0.453-0.85c-0.086-0.161-0.122-0.345-0.104-0.527l0.073-0.741 c0.005-0.052,0.015-0.104,0.029-0.155l0.492-1.782l-0.098-0.809l-0.275-0.493l-1.267-2.116c-0.039-0.066-0.07-0.136-0.092-0.209 l-0.303-1.008c-0.008-0.028-0.016-0.057-0.021-0.086l-0.244-1.225c-0.018-0.091-0.022-0.183-0.013-0.275l0.113-1.111 c0.009-0.087,0.03-0.173,0.063-0.254l1.184-2.918l-0.181-1.356l-0.553-0.267l-1.02-0.027c-0.108-0.003-0.215-0.025-0.316-0.064 l-1.137-0.449c-0.155-0.061-0.291-0.163-0.393-0.295l-1.29-1.667c-0.057-0.074-0.103-0.156-0.135-0.243l-1.064-2.854 c-0.023-0.062-0.039-0.125-0.049-0.19l-0.382-2.624l-0.229-0.415l-0.509-0.361l-1.302-0.181l-1.618-0.003l-1.67,0.164l-1.429,0.32 c-0.034,0.008-0.069,0.013-0.105,0.017l-2.179,0.231l-2.531,0.235l-1.962,0.412c-0.051,0.011-0.103,0.017-0.154,0.019l-3.653,0.142 c-0.012,0.001-0.024,0.001-0.036,0.001c-0.039,0-0.078-0.002-0.116-0.007l-1.124-0.143c-0.041-0.005-0.082-0.013-0.122-0.024 l-1.201-0.32c-0.108-0.029-0.21-0.077-0.301-0.142l-0.621-0.445c-0.118-0.085-0.215-0.196-0.282-0.325l-0.041-0.078l-0.288-0.377 c-0.089-0.116-0.148-0.251-0.175-0.395l-0.138-0.751l-0.345-0.605l-1.193-1.298c-0.079-0.086-0.142-0.187-0.183-0.297l-0.099-0.26 c-0.02-0.054-0.036-0.109-0.046-0.166l-0.088-0.487c-0.009-0.003-0.018-0.005-0.027-0.008l-0.367-0.116 c-0.143-0.045-0.273-0.125-0.378-0.231l-0.317-0.32c-0.125-0.126-0.211-0.284-0.248-0.458l-0.159-0.743 c-0.022-0.103-0.026-0.208-0.013-0.312l0.115-0.893c0.009-0.07,0.026-0.14,0.051-0.206l0.213-0.57 c-0.067-0.078-0.122-0.167-0.161-0.265c-0.114-0.288-0.078-0.614,0.098-0.868l0.275-0.398l-0.216-0.312 c-0.02-0.029-0.038-0.059-0.055-0.09l-0.399-0.747c-0.145-0.271-0.146-0.596-0.002-0.868c0.035-0.067,0.078-0.128,0.127-0.183 l-0.109-0.457c-0.049-0.207-0.026-0.425,0.067-0.617l0.281-0.582c0.033-0.068,0.074-0.132,0.122-0.19l0.09-0.108l-0.373-0.468 l-0.028,0.008c-0.089,0.027-0.18,0.04-0.27,0.04c-0.237,0-0.47-0.091-0.645-0.262l-0.393-0.381 c-0.061-0.059-0.113-0.126-0.156-0.199l-0.281-0.484l-0.397-0.369c-0.195-0.182-0.303-0.439-0.295-0.706l0.02-0.642l-0.096-0.287 l-0.183-0.197l-0.077-0.037l-0.166,0.085c-0.132,0.068-0.277,0.102-0.423,0.102c-0.11,0-0.219-0.019-0.324-0.059 c-0.244-0.091-0.439-0.281-0.535-0.523l-0.23-0.574c-0.056-0.14-0.077-0.291-0.062-0.441l0.095-0.915 c0.013-0.124,0.051-0.244,0.111-0.353l0.191-0.345c-0.17-0.08-0.313-0.21-0.408-0.374l-0.301-0.519 c-0.001-0.001-0.001-0.002-0.002-0.003l-0.423-0.049c-0.139-0.016-0.272-0.063-0.39-0.138l-0.283-0.179 c-0.166-0.105-0.294-0.26-0.366-0.443l-0.132-0.335c-0.035-0.089-0.056-0.183-0.063-0.279l-0.005-0.071 c-0.016-0.001-0.031-0.001-0.047-0.003l-0.413-0.036c-0.348-0.03-0.65-0.253-0.78-0.577c-0.13-0.324-0.067-0.694,0.163-0.957 l0.561-0.639l-0.272-0.207c-0.156-0.118-0.27-0.283-0.327-0.47l-0.152-0.503c-0.025-0.082-0.038-0.167-0.04-0.253l-0.027-1.616 l-0.08-0.349c-0.106-0.463,0.156-0.931,0.606-1.084l0.681-0.231l1.358-0.412c0.05-0.015,0.101-0.026,0.152-0.032l0.428-0.054 l1.289-0.771c0.144-0.086,0.309-0.131,0.476-0.131c0.026,0,0.053,0.001,0.079,0.003l1.841,0.159 c0.049-0.089,0.113-0.169,0.188-0.237l0.508-0.46l0.268-0.346l0.099-0.327l-0.195-1.471l-0.153-0.605l-0.102-0.201l-0.082-0.06 l-0.173-0.089c-0.098-0.051-0.186-0.118-0.26-0.199l-0.156-0.171c-0.067-0.073-0.121-0.157-0.161-0.247l-0.256-0.576 c-0.014-0.033-0.027-0.066-0.038-0.1l-0.117-0.374c-0.056-0.179-0.056-0.37-0.001-0.549l0.195-0.633 c0.068-0.221,0.217-0.409,0.417-0.526l0.675-0.396c0.045-0.027,0.093-0.049,0.142-0.068l0.901-0.339 c0.046-0.017,0.092-0.031,0.14-0.04l1.304-0.267c0.037-0.008,0.074-0.013,0.112-0.016l2.937-0.237 c0.025-0.002,0.05-0.003,0.074-0.003c0.009,0,0.019,0,0.028,0l0.94,0.029c0.064,0.002,0.128,0.011,0.19,0.026l3.785,0.918 c0.033,0.008,0.066,0.018,0.098,0.03l0.785,0.285c0.033,0.012,0.065,0.026,0.096,0.041l0.471,0.234l0.322,0.029l1.183-1.968 l0.093-0.263l0.154-0.718l-0.133-4.898l-0.879-2.607l-0.465-0.641l-1.881-1.623l-0.372-0.262l-0.427-0.154l-1.459-0.173 c-0.144-0.017-0.281-0.067-0.402-0.147l-1.2-0.794c-0.024-0.016-0.046-0.032-0.068-0.05l-0.913-0.732 c-0.052-0.042-0.1-0.09-0.142-0.142l-3.652-4.535l-4.662-5.064l-4.67-3.343c-0.029-0.021-0.057-0.043-0.083-0.067l-5.858-5.312 c-0.045-0.041-0.086-0.086-0.122-0.135l-0.44-0.594c-0.024-0.033-0.046-0.067-0.066-0.102l-0.347-0.625 c-0.167-0.301-0.153-0.669,0.035-0.957l0.123-0.187c0.01-0.015,0.021-0.03,0.031-0.045c-0.015-0.066-0.023-0.135-0.023-0.204 v-1.889c0-0.277,0.124-0.54,0.338-0.716c0.167-0.137,0.375-0.211,0.588-0.211c0.06,0,0.12,0.006,0.179,0.018l0.845,0.167 l0.637-0.432l0.814-0.872c0.053-0.057,0.114-0.107,0.18-0.149l0.629-0.4l0.345-0.402l0.788-4.405 c0.011-0.063,0.029-0.124,0.053-0.184l0.289-0.716c0.039-0.097,0.095-0.187,0.164-0.266l0.384-0.435 c0.053-0.06,0.114-0.114,0.182-0.159l0.533-0.355l0.066-0.432c0.021-0.136,0.072-0.266,0.149-0.38l0.23-0.34l0.187-0.679 l-0.281-3.575l-0.209-0.734l-0.296-0.7c-0.021-0.049-0.037-0.1-0.05-0.153l-0.394-1.707l-0.759-0.01 c-0.049-0.001-0.097-0.005-0.145-0.013l-0.632-0.109c-0.15-0.026-0.291-0.088-0.41-0.181l-0.97-0.753 c-0.09-0.07-0.166-0.155-0.224-0.252l-3.653-6.034l-0.375-0.445l-0.49-0.357l-2.198-0.887c-0.062-0.025-0.121-0.056-0.175-0.094 l-2.973-2.029c-0.152-0.104-0.27-0.251-0.338-0.422l-0.386-0.969c-0.019-0.048-0.034-0.098-0.045-0.148l-0.37-1.719l-0.28-0.74 l-0.309-0.553l-0.376-0.47l-0.526-0.523c-0.051-0.051-0.096-0.107-0.134-0.168l-0.544-0.876c-0.047-0.075-0.083-0.157-0.106-0.242 l-0.096-0.349c-0.003,0.002-0.005,0.004-0.008,0.005l-0.477,0.338c-0.131,0.093-0.283,0.15-0.443,0.166l-0.683,0.069l-0.525,0.117 l-0.084,0.053c0.043,0.099,0.069,0.205,0.076,0.314l0.052,0.823c0.01,0.157-0.021,0.315-0.088,0.457l-0.55,1.153 c-0.041,0.086-0.095,0.165-0.16,0.234l-1.29,1.379l-0.346,0.37l-0.286,1.03l-0.001,0.218l0.772-0.072 c0.029-0.003,0.058-0.004,0.086-0.004c0.1,0,0.199,0.016,0.293,0.048l0.772,0.258c0.111,0.037,0.214,0.095,0.303,0.17l0.474,0.4 c0.081,0.068,0.149,0.149,0.203,0.241l0.755,1.291c0.022,0.037,0.041,0.076,0.057,0.115l0.663,1.611 c0.032,0.078,0.053,0.159,0.063,0.243l0.371,3.112l0.345,1.44l0.258,0.403l0.161,0.06l0.47,0.028 c0.107,0.006,0.212,0.031,0.31,0.073l0.585,0.25c0.157,0.067,0.292,0.176,0.391,0.315l0.34,0.478 c0.031,0.044,0.059,0.091,0.082,0.14l0.961,2.029l1.137,1.685l0.426,0.631c0.02,0.029,0.038,0.06,0.054,0.091l1.326,2.55 c0.03,0.059,0.055,0.12,0.072,0.184l0.979,3.599c0.015,0.056,0.025,0.114,0.03,0.173l0.073,0.953l0.16,0.359l0.265,0.253 l0.438,0.318c0.046,0.034,0.089,0.071,0.128,0.113l0.446,0.472c0.064,0.067,0.117,0.144,0.158,0.226l0.356,0.722 c0.199,0.402,0.08,0.889-0.281,1.155l-0.262,0.193c-0.159,0.117-0.352,0.181-0.55,0.181c-0.004,0-0.007,0-0.01,0l-1.591-0.018 l-1.221,0.256L83,215.387l-1.21,0.638l-0.747,0.75l-1.099,2.48c-0.031,0.07-0.071,0.136-0.118,0.196l-1.227,1.565l-0.016,0.059 l0.401,0.886l0.806,0.769c0.109,0.104,0.191,0.233,0.239,0.376l0.286,0.852c0.117,0.348,0.017,0.732-0.255,0.979l-1.34,1.219 c-0.041,0.037-0.086,0.071-0.133,0.101l-6.312,3.936l-2.005,2.025c-0.024,0.024-0.049,0.047-0.075,0.068l-1.144,0.926 c-0.14,0.113-0.309,0.183-0.487,0.201l-1.036,0.107c-0.032,0.003-0.064,0.005-0.095,0.005c-0.257,0-0.504-0.107-0.68-0.298 l-0.486-0.526c-0.107-0.116-0.183-0.258-0.22-0.412l-0.524-2.174l-0.255-0.449l-1.085-1.477l-0.125-0.03 c-0.153-0.037-0.295-0.112-0.411-0.219l-0.134-0.124c-0.194-0.178-0.302-0.43-0.299-0.693l0.002-0.174 c0.001-0.114,0.024-0.227,0.066-0.333l-0.029-0.033l-2.109-1.805l-0.248,0.137l-0.191,1.126l0.192,1.752l0.364,1.262l0.991,1.937 c0.047,0.092,0.079,0.192,0.093,0.295l0.137,0.988c0.02,0.145,0.006,0.292-0.042,0.43l-0.411,1.185 c-0.034,0.099-0.085,0.192-0.151,0.274l-0.679,0.852c-0.069,0.086-0.153,0.16-0.248,0.217l-0.873,0.524 c-0.102,0.061-0.214,0.102-0.332,0.121l-1.007,0.159c-0.048,0.008-0.096,0.011-0.145,0.011c-0.068,0-0.135-0.007-0.201-0.022 l-0.258-0.057l-1.337,4.304L55.159,245.569z").attr({id: 'choco', class: 'st20', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#8E48FF'}).data({'id': 'choco', 'region':'Chocó', 'benefited-companies':'4', 'benefited-projects': '$100.000.000'});

        var caqueta = rsr.path("M325.417,553.461l0.27-0.403l0.009-0.266l-0.161-0.409l-0.303-0.379 c-0.096,0.102-0.215,0.181-0.349,0.231l-0.329,0.123c-0.105,0.039-0.214,0.058-0.323,0.058c-0.195,0-0.388-0.062-0.55-0.181 l-0.729-0.538c-0.135-0.1-0.24-0.234-0.305-0.389l-0.334-0.8c-0.029-0.068-0.049-0.14-0.06-0.213l-0.261-1.665l-0.308-0.615 l-0.323-0.172l-1.759-0.215c-0.147-0.018-0.287-0.071-0.41-0.154l-0.391-0.267c-0.152-0.103-0.269-0.25-0.337-0.42l-0.177-0.441 c-0.015-0.037-0.028-0.076-0.038-0.114l-0.092-0.358l-0.075-0.127l-0.124-0.092l-1.911-0.729l-0.707-0.159l-3.001-0.212 c-0.231-0.016-0.448-0.119-0.607-0.287l-0.342-0.361c-0.07-0.073-0.127-0.158-0.169-0.25l-0.772-1.678l-0.147-0.144l-1.086-0.353 c-0.15-0.049-0.285-0.135-0.392-0.25l-0.45-0.484c-0.172-0.185-0.261-0.433-0.246-0.685l0.045-0.755 c0.004-0.06,0.013-0.12,0.028-0.179l0.192-0.737l0.012-0.142l-0.201,0.067c-0.095,0.032-0.195,0.048-0.294,0.048 c-0.128,0-0.255-0.027-0.374-0.079l-0.48-0.212c-0.16-0.071-0.297-0.186-0.395-0.331l-0.204-0.304 c-0.085-0.127-0.137-0.273-0.152-0.424l-0.125-1.266l-0.149-0.356l-0.139-0.052l-0.569-0.055c-0.153-0.015-0.3-0.067-0.427-0.153 l-0.531-0.356c-0.153-0.103-0.272-0.249-0.342-0.419l-0.244-0.599c-0.022-0.053-0.038-0.109-0.05-0.165l-0.147-0.724 c-0.008-0.041-0.014-0.083-0.017-0.125l-0.086-1.347l-0.138-0.62l-0.327-0.513l-1.913-1.776l-0.337-0.165l-1.378-0.194 c-0.049-0.007-0.097-0.018-0.145-0.032l-1.098-0.34c-0.08-0.025-0.157-0.06-0.227-0.106l-3.751-2.412 c-0.038-0.024-0.074-0.052-0.108-0.082l-1.252-1.094l-0.569-0.356l-1.14-0.448l-0.265,0.06c-0.018,0.004-0.037,0.008-0.056,0.011 l-0.386,0.063c-0.021,0.054-0.048,0.106-0.08,0.155l-0.985,1.546c-0.142,0.223-0.373,0.375-0.634,0.417 c-0.049,0.008-0.098,0.012-0.147,0.012c-0.212,0-0.42-0.073-0.586-0.209l-0.679-0.555c-0.054-0.044-0.103-0.094-0.145-0.149 l-0.541-0.696l-0.399-0.254c-0.032,0.038-0.066,0.074-0.104,0.107l-0.236,0.208c-0.101,0.089-0.22,0.155-0.349,0.193l-0.376,0.111 c-0.03,0.009-0.06,0.016-0.091,0.022l-0.27,0.051l-0.049,0.027l-0.36,0.463l-0.069,0.215l-0.144,0.734 c-0.015,0.076-0.039,0.15-0.072,0.219l-0.31,0.651l-0.032,0.215l0.147,0.729c0.015,0.076,0.021,0.153,0.017,0.23l-0.026,0.515 c-0.003,0.067-0.014,0.133-0.031,0.197l-0.168,0.616c-0.016,0.058-0.037,0.114-0.064,0.168l-0.277,0.559 c-0.078,0.158-0.2,0.291-0.352,0.382l-0.642,0.387c-0.036,0.022-0.074,0.041-0.113,0.058l-1.278,0.549l-0.556,0.498l-0.902,1.002 c-0.036,0.04-0.075,0.076-0.117,0.109l-0.886,0.695l-0.612,0.931c-0.053,0.081-0.119,0.153-0.194,0.214l-0.388,0.311 c-0.024,0.019-0.049,0.038-0.075,0.054l-0.611,0.397c-0.057,0.037-0.118,0.068-0.182,0.091l-0.686,0.255 c-0.065,0.024-0.132,0.041-0.2,0.05l-0.669,0.09c-0.035,0.005-0.07,0.007-0.106,0.008l-0.913,0.017c-0.006,0-0.011,0-0.017,0 c-0.098,0-0.196-0.016-0.289-0.046l-2.393-0.786c-0.062-0.02-0.122-0.047-0.178-0.08l-1.01-0.59 c-0.034-0.02-0.066-0.041-0.096-0.065l-0.834-0.64c-0.067-0.052-0.127-0.112-0.178-0.18l-0.496-0.663 c-0.05-0.067-0.091-0.141-0.122-0.22l-0.23-0.595l-0.175-0.304l-0.234-0.161l-1.534-0.456c-0.187-0.055-0.351-0.168-0.47-0.323 l-1.173-1.523l-4.531-4.001c-0.028-0.025-0.055-0.051-0.08-0.079l-2.325-2.62c-0.118-0.133-0.195-0.296-0.222-0.472l-0.171-1.093 c-0.007-0.042-0.01-0.083-0.011-0.125l-0.019-0.994l-0.062-0.469l-0.455-1.294l-0.384-0.591l-0.635-0.813 c-0.031-0.04-0.06-0.083-0.084-0.128l-0.652-1.202l-0.506-0.605l-2.242-1.733c-0.033-0.025-0.063-0.052-0.092-0.082l-0.74-0.748 c-0.039-0.039-0.074-0.081-0.105-0.126l-4.625-6.725c-0.083-0.12-0.136-0.259-0.155-0.404l-0.073-0.552l-0.18-0.599l-3.083-0.514 l-4.224,0.331c-0.024,0.002-0.049,0.003-0.073,0.003c-0.005,0-0.01,0-0.015,0l-1.703-0.028c-0.031-0.001-0.062-0.003-0.093-0.006 l-1.282-0.151c-0.068-0.008-0.135-0.024-0.2-0.046l-27.078-9.557c-0.077-0.027-0.151-0.065-0.218-0.112l-1.813-1.254 c-0.076-0.052-0.143-0.115-0.2-0.187l-1.572-1.988c-0.046-0.058-0.084-0.12-0.115-0.187l-0.999-2.17 c-0.029-0.064-0.051-0.131-0.066-0.2l-0.434-2.101c-0.014-0.065-0.02-0.132-0.019-0.199l0.02-1.589 c0.001-0.102,0.019-0.203,0.053-0.299l0.491-1.381c0.029-0.083,0.07-0.161,0.122-0.232l0.845-1.171 c0.022-0.031,0.046-0.06,0.072-0.088l0.986-1.062l0.577-0.758l0.189-0.545l-0.029-0.565l-0.344-0.727l-0.626-0.906l-2.731-3.055 c-0.033-0.037-0.063-0.077-0.09-0.118l-0.736-1.152c-0.042-0.066-0.075-0.136-0.1-0.21l-0.434-1.325 c-0.019-0.059-0.033-0.121-0.04-0.183l-0.186-1.62c-0.005-0.047-0.007-0.095-0.005-0.142l0.057-1.45 c0.001-0.028,0.004-0.057,0.007-0.085l0.302-2.293c0.005-0.035,0.011-0.07,0.02-0.104l2.503-9.981l-0.011-1.26l-0.329-0.533 l-0.733-0.53c-0.035-0.025-0.067-0.052-0.098-0.082l-0.877-0.841c-0.045-0.044-0.086-0.092-0.122-0.144l-0.695-1.011 c-0.041-0.06-0.075-0.124-0.101-0.191l-1.274-3.303l-0.323-0.525l-0.399-0.402l-0.586-0.343l-0.74-0.18l-2.118-0.288 c-0.054-0.007-0.108-0.019-0.16-0.036l-4.289-1.383l-0.41,0.115l-0.175,0.091l-0.598,0.56l-1.734,1.571l-1.894,2.474l-0.85,1.543 l-0.533,1.308l-0.136,0.558l0.183,0.56l0.806,0.521c0.064,0.041,0.122,0.09,0.174,0.146l1.023,1.096 c0.104,0.111,0.178,0.245,0.217,0.392l0.366,1.363c0.055,0.206,0.038,0.425-0.05,0.62l-0.352,0.782 c-0.038,0.084-0.088,0.163-0.149,0.232l-1.539,1.748c-0.039,0.045-0.083,0.085-0.13,0.122l-3.904,3.009 c-0.086,0.066-0.184,0.117-0.287,0.15l-1.516,0.477c-0.09,0.028-0.184,0.043-0.278,0.043c-0.101,0-0.202-0.017-0.299-0.05 l-0.54-0.184c-0.057-0.019-0.111-0.044-0.163-0.074l-1.188-0.683l-0.168-0.036l-0.047,0.013l-0.337,0.328l-0.539,0.839 l-1.422,5.005c-0.014,0.051-0.033,0.1-0.056,0.148l-0.655,1.363c-0.016,0.033-0.034,0.066-0.054,0.097l-0.617,0.968 c-0.029,0.045-0.061,0.087-0.097,0.126l-1.716,1.88c-0.062,0.068-0.134,0.126-0.213,0.173l-0.426,0.252l-2.062,1.465l-0.813,0.67 l-0.947,1.737l-1.457,2.395l-3.463,5.559c-0.045,0.072-0.1,0.138-0.163,0.196l-3.352,3.046l-3.014,4.406l-2.236,3.115 c-0.022,0.031-0.047,0.061-0.073,0.089l-2.968,3.203l-0.826,0.987l-0.579,1.02c-0.046,0.081-0.104,0.155-0.173,0.219l-0.667,0.623 c-0.028,0.027-0.058,0.051-0.09,0.074l-2.305,1.666l-0.767,0.763l-0.693,0.872c-0.023,0.029-0.048,0.056-0.074,0.082l-0.827,0.817 c-0.077,0.076-0.168,0.139-0.267,0.184l-0.932,0.425c-0.081,0.037-0.167,0.062-0.255,0.074l-1.177,0.165 c-0.043,0.006-0.086,0.009-0.129,0.009c-0.039,0-0.079-0.003-0.118-0.008l-1.083-0.139l-2.277-0.086 c-0.038-0.001-0.076-0.005-0.114-0.011l-2.545-0.414l-0.417,0.276l-0.698,1.099l-2.015,3.156l-0.978,2.098l-0.233,1.411 c-0.014,0.083-0.039,0.164-0.074,0.24l-0.344,0.739c-0.027,0.058-0.06,0.112-0.098,0.163l-0.757,1.013l-0.086,0.334l-0.506,5.802 l0.04,0.262l0.419,0.843l0.35,0.443l0.494,0.272l1.837,0.34l1.591-0.266c0.051-0.008,0.102-0.013,0.153-0.013 c0.077,0,0.155,0.01,0.23,0.029l0.46,0.118c0.145,0.037,0.278,0.108,0.389,0.208l4.177,3.752l0.164-0.034 c0.061-0.013,0.124-0.019,0.186-0.019c0.075,0,0.15,0.009,0.224,0.027l0.627,0.156c0.042,0.01,0.083,0.024,0.123,0.04l1.093,0.441 l0.607,0.019l1.679-0.149c0.027-0.002,0.054-0.004,0.082-0.004c0.073,0,0.145,0.009,0.216,0.025l0.779,0.187 c0.128,0.031,0.248,0.088,0.352,0.169l0.682,0.529c0.15,0.116,0.26,0.275,0.317,0.456l0.172,0.552 c0.03,0.096,0.044,0.196,0.042,0.297l-0.012,0.537l0.086,0.51l0.436,0.847l2.298,2.734l0.478,0.276l1.641,0.158 c0.11,0.011,0.218,0.041,0.318,0.09l0.909,0.444c0.039,0.019,0.076,0.04,0.111,0.064l0.722,0.487l0.539,0.17l0.667,0.015 l3.085-0.239c0.024-0.002,0.048-0.003,0.072-0.003c0.038,0,0.076,0.002,0.114,0.007l2.061,0.255 c0.097,0.012,0.191,0.039,0.28,0.081l1.837,0.861c0.106,0.05,0.201,0.119,0.281,0.204l2.644,2.807l1.473,0.526l3.673,0.234 l2.48-0.321c0.04-0.005,0.079-0.008,0.119-0.008c0.068,0,0.135,0.007,0.202,0.022l0.877,0.196c0.058,0.013,0.115,0.032,0.17,0.056 l1.12,0.491c0.049,0.022,0.097,0.048,0.142,0.078l0.503,0.335c0.066,0.044,0.127,0.097,0.18,0.157l0.401,0.453 c0.083,0.094,0.146,0.203,0.185,0.322l0.152,0.458c0.041,0.123,0.056,0.254,0.043,0.383l-0.077,0.78l0.021,0.173l0.276,0.493 l0.997,1.205c0.056,0.068,0.102,0.144,0.137,0.225l0.324,0.755c0.048,0.113,0.074,0.234,0.075,0.357l0.007,0.772 c0.001,0.063-0.005,0.126-0.018,0.188l-0.266,1.343l0.084,0.541l0.56,1.358l0.469,0.662l0.464,0.165l1.195-0.281l1.051-0.465 c0.115-0.051,0.24-0.078,0.366-0.079l0.484-0.005c0.003,0,0.006,0,0.009,0c0.142,0,0.282,0.033,0.409,0.095l0.632,0.311 c0.178,0.088,0.324,0.231,0.415,0.408l0.124,0.241c0.045,0.088,0.076,0.182,0.091,0.279l0.048,0.306l0.018-0.003l0.815-0.22 c0.079-0.021,0.16-0.032,0.241-0.032c0.057,0,0.114,0.005,0.171,0.016l1.751,0.328c0.312,0.058,0.572,0.272,0.689,0.567l0.504,1.26 c0.054,0.136,0.076,0.284,0.062,0.43l-0.274,2.945l0.078,0.475l0.626,2.01c0.016,0.05,0.027,0.102,0.034,0.154l0.173,1.311 l0.047,0.064l1.666,0.549c0.052,0.017,0.102,0.039,0.151,0.065l2.819,1.525l4.996,0.96c0.094,0.018,0.185,0.051,0.269,0.097 l1.62,0.885c0.105,0.057,0.198,0.134,0.273,0.227l1.118,1.369c0.105,0.129,0.174,0.284,0.199,0.448l0.283,1.876 c0.029,0.195-0.004,0.393-0.095,0.568l-0.287,0.547c-0.027,0.051-0.058,0.099-0.094,0.145l-0.094,0.119l0.622,0.212 c0.177,0.06,0.331,0.173,0.443,0.322l0.171,0.229c0.237,0.317,0.246,0.75,0.023,1.077l-0.21,0.307l-0.585,1.134 c-0.031,0.061-0.07,0.118-0.114,0.171l0.295,0.543c0.036,0.067,0.064,0.138,0.083,0.212l0.099,0.385 c0.009,0.034,0.016,0.069,0.021,0.105l0.098,0.713l0.008,0.025c0.035,0.002,0.069,0.006,0.103,0.012l0.643,0.11l0.218-0.013 c0.018-0.001,0.036-0.002,0.054-0.002c0.019,0,0.037,0.001,0.056,0.002l0.348,0.021c0.122,0.007,0.241,0.039,0.351,0.092 l0.392,0.191c0.148,0.072,0.274,0.183,0.365,0.32l0.23,0.347c0.051,0.077,0.091,0.162,0.117,0.251l0.26,0.886l0.064,0.103 l0.357,0.21l0.723,0.232l0.724,0.1l0.555-0.072l0.755-0.188c0.074-0.018,0.149-0.027,0.224-0.027c0.11,0,0.221,0.02,0.325,0.059 l0.428,0.161c0.065,0.024,0.127,0.056,0.186,0.095l0.265,0.175l0.277,0.054l0.018-0.009l0.317-0.994 c0.088-0.276,0.3-0.494,0.572-0.591l0.743-0.264c0.101-0.036,0.205-0.053,0.31-0.053c0.128,0,0.256,0.026,0.375,0.079l0.752,0.333 c0.25,0.111,0.439,0.327,0.515,0.59l0.195,0.673c0.016,0.057,0.027,0.114,0.033,0.173l0.038,0.413h0.031l1.429-0.575 c0.11-0.044,0.228-0.067,0.346-0.067c0.064,0,0.129,0.007,0.192,0.02l0.949,0.201c0.081,0.017,0.159,0.045,0.233,0.083l1.65,0.852 c0.061,0.031,0.118,0.069,0.17,0.113l0.43,0.361c0.066,0.055,0.124,0.12,0.172,0.192l0.301,0.446 c0.059,0.088,0.103,0.185,0.129,0.288l0.084,0.328c0.013,0.051,0.022,0.104,0.026,0.157l0.019,0.236l0.383,1.201l0.117,0.242 l0.161,0.186l0.043,0.025l0.138-0.075c0.095-0.052,0.199-0.086,0.307-0.102l0.464-0.068c0.045-0.007,0.09-0.01,0.135-0.01 c0.005,0,0.01,0,0.015,0l0.343,0.006l0.21-0.033c0.047-0.007,0.095-0.011,0.142-0.011c0.023,0,0.046,0.001,0.069,0.003l0.285,0.021 c0.117,0.009,0.232,0.04,0.337,0.091l0.416,0.203c0.155,0.075,0.285,0.192,0.377,0.337l0.197,0.312 c0.057,0.091,0.099,0.191,0.122,0.296l0.111,0.506l0.12,0.004l0.566-0.263c0.045-0.021,0.091-0.038,0.138-0.051l0.774-0.219 c0.083-0.023,0.168-0.035,0.252-0.035c0.14,0,0.28,0.032,0.408,0.095l0.861,0.422c0.054,0.026,0.105,0.058,0.153,0.094l2.455,1.867 c0.054,0.041,0.103,0.088,0.147,0.14l1.405,1.664l0.808,0.537l2.068,0.87l3.388,1.02l0.028,0.006l3.392,0.636l0.531-0.014 l0.422-0.161l1.225-0.662c0.135-0.073,0.287-0.111,0.44-0.111c0.003,0,0.007,0,0.01,0l0.671,0.007 c0.114,0.001,0.226,0.023,0.332,0.065l0.813,0.323c0.055,0.022,0.108,0.049,0.157,0.081l1.275,0.817l0.048,0.021l0.102,0.007 c0.043,0.003,0.087,0.009,0.129,0.019l0.262,0.057c0.156,0.034,0.301,0.107,0.42,0.213l0.268,0.238 c0.156,0.139,0.26,0.326,0.296,0.531l0.057,0.321c0.02,0.111,0.019,0.225-0.002,0.335l-0.084,0.44l0.21-0.007l0.459-0.07 c0.046-0.007,0.093-0.01,0.139-0.01c0.037,0,0.074,0.002,0.111,0.007l0.49,0.059c0.185,0.022,0.358,0.1,0.499,0.222l0.446,0.389 c0.112,0.098,0.199,0.221,0.253,0.359l0.501,1.274l0.192,0.343l0.212,0.12l3.153,0.507l1.911-0.165 c0.027-0.002,0.053-0.003,0.08-0.003c0.016,0,0.033,0,0.049,0.001l1.978,0.105l0.754-0.143l0.584-0.315l0.329-0.285 c0.098-0.085,0.212-0.148,0.335-0.186l0.401-0.123c0.088-0.027,0.18-0.041,0.271-0.041c0.095,0,0.19,0.015,0.281,0.044l0.777,0.248 c0.101,0.032,0.195,0.081,0.28,0.145l1.542,1.173c0.034,0.026,0.066,0.054,0.096,0.084l1.629,1.637l1.51,1.146l1.428,0.13 l1.412-0.307c0.054-0.012,0.108-0.018,0.163-0.021l1.117-0.041l0.709-0.197l0.866-0.906c0.041-0.043,0.087-0.082,0.135-0.117 l2.788-1.968c0.16-0.113,0.347-0.169,0.534-0.169c0.179,0,0.358,0.052,0.514,0.156l4.826,3.221l2.614-0.5l1.497-0.992 c0.106-0.07,0.225-0.118,0.35-0.14l1.34-0.238c0.054-0.01,0.108-0.014,0.162-0.014c0.123,0,0.245,0.024,0.36,0.073l1.333,0.562 c0.081,0.034,0.156,0.079,0.224,0.135l4.755,3.863l1.054,0.676l0.893,0.41l0.035-0.004l0.194-0.243l0.558-0.938 c0.029-0.049,0.063-0.096,0.101-0.139l2.195-2.492c0.029-0.033,0.06-0.064,0.094-0.092l1.451-1.239 c0.073-0.062,0.156-0.113,0.245-0.15l1.131-0.472c0.114-0.048,0.236-0.071,0.357-0.071c0.161,0,0.322,0.042,0.465,0.125 l1.438,0.835c0.073,0.042,0.14,0.095,0.199,0.155l1.329,1.367l1.21,0.787l1.435-0.257l0.936-0.793l0.345-0.367l0.15-0.579 l0.019-0.12l-0.111-1.21c-0.003-0.029-0.004-0.059-0.004-0.089l0.007-1.576c0-0.064,0.007-0.127,0.02-0.189l0.306-1.432 c0.025-0.117,0.072-0.227,0.139-0.326l0.82-1.211c0.026-0.039,0.056-0.076,0.088-0.111l0.952-1.026l0.778-1.025l1.422-2.307 c0.03-0.048,0.064-0.094,0.102-0.136l0.656-0.724c0.068-0.075,0.149-0.139,0.238-0.188l2.33-1.29l1.665-1.611 c0.07-0.068,0.15-0.124,0.238-0.167l1.127-0.55c0.098-0.048,0.204-0.078,0.313-0.089l1.406-0.142 c0.031-0.003,0.062-0.005,0.093-0.005c0.003,0,0.006,0,0.009,0l6.13,0.063l1.588-0.317l1.206-0.506l0.718-0.725l0.544-1.159 l0.498-1.909c0.036-0.14,0.105-0.269,0.2-0.377l1.76-2.006c0.052-0.059,0.112-0.112,0.177-0.156l2.883-1.949 c0.046-0.031,0.095-0.058,0.145-0.08l8.384-3.693l2.215-1.252l2.306-2.249l-0.554-0.532l-1.383-0.476 c-0.07-0.024-0.136-0.056-0.198-0.096l-0.922-0.591l-0.115-0.025l-1.223,0.319c-0.036,0.009-0.072,0.016-0.108,0.021l-0.518,0.071 c-0.042,0.006-0.084,0.009-0.126,0.009c-0.046,0-0.091-0.003-0.136-0.01l-0.381-0.057c-0.055-0.008-0.109-0.021-0.161-0.039 l-0.676-0.229l-0.154-0.01l-0.471,0.152l-0.426,0.237c-0.122,0.068-0.258,0.107-0.397,0.115l-0.539,0.031 c-0.018,0.001-0.035,0.002-0.053,0.002c-0.181,0-0.358-0.053-0.509-0.153l-2.243-1.477l-4.513-2.141 c-0.109-0.052-0.208-0.125-0.289-0.214l-0.565-0.623c-0.045-0.049-0.084-0.104-0.117-0.161l-0.839-1.461l-0.253-0.176l-0.94-0.302 c-0.175-0.056-0.329-0.164-0.443-0.308l-0.518-0.656c-0.054-0.068-0.098-0.144-0.131-0.224l-0.299-0.735l-0.219-0.341l-0.988,0.708 c-0.158,0.113-0.346,0.173-0.539,0.173c-0.014,0-0.028,0-0.042-0.001l-0.677-0.031c-0.355-0.016-0.67-0.234-0.81-0.561 l-0.247-0.576c-0.072-0.167-0.092-0.351-0.06-0.53l0.142-0.779c0.006-0.033,0.014-0.066,0.023-0.098l0.211-0.711l0.007-0.101 l-0.583-0.519l-1.737-1.074c-0.032-0.02-0.062-0.041-0.092-0.065l-1.475-1.18c-0.221-0.177-0.349-0.445-0.348-0.727l0.005-1.067 C325.259,553.791,325.314,553.613,325.417,553.461z").attr({id: 'caqueta', class: 'st21', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#004A47'}).data({'id': 'caqueta', 'region':'Caquetá', 'benefited-companies':'1', 'benefited-projects': '$20.000.000'});

        var valledelcauca = rsr.path("M118.859,426.396c0.031-0.056,0.068-0.108,0.109-0.156l1.015-1.171 c0.18-0.208,0.438-0.32,0.7-0.32c0.135,0,0.272,0.03,0.4,0.091l0.946,0.454l0.716,0.352l1.842,0.377l4.421,0.332 c0.071,0.005,0.141,0.019,0.209,0.04l1.25,0.394c0.098,0.031,0.19,0.078,0.273,0.139l1.574,1.165l0.519,0.211l2.818,0.626 c0.04,0.009,0.079,0.02,0.118,0.034l0.931,0.341l0.067-2.018c0.002-0.071,0.013-0.142,0.032-0.211l0.157-0.581 c0.031-0.115,0.084-0.224,0.157-0.319l0.27-0.356c0.047-0.062,0.102-0.118,0.164-0.167l-0.102-0.138 c-0.035-0.047-0.065-0.098-0.091-0.151l-0.534-1.115c-0.118-0.247-0.121-0.533-0.008-0.782l0.502-1.111l0.107-0.928l0.021-1.461 c0.001-0.089,0.015-0.178,0.042-0.263l0.287-0.918c0.01-0.032,0.022-0.063,0.035-0.094l0.454-1.043l0.154-0.648 c0.016-0.067,0.039-0.132,0.07-0.194l0.314-0.639c0.02-0.04,0.043-0.079,0.068-0.116l0.447-0.65l0.238-0.536 c0.017-0.038,0.036-0.074,0.058-0.11l0.258-0.419l0.027-0.319l-0.027-0.815c-0.002-0.052,0.001-0.104,0.008-0.155l0.343-2.542 c0.013-0.098,0.042-0.193,0.085-0.281l0.418-0.859c0.023-0.047,0.05-0.092,0.08-0.135l0.268-0.374l0.411-1.469 c0.048-0.172,0.145-0.327,0.279-0.445l0.175-0.155l0.716-0.85l0.095-0.172l0.484-1.12c0.022-0.05,0.048-0.099,0.078-0.144 l2.994-4.52l1.016-2.469c0.011-0.026,0.022-0.051,0.035-0.076l0.678-1.3c0.018-0.035,0.039-0.07,0.062-0.102l0.405-0.579 l0.557-1.657c0.026-0.079,0.063-0.154,0.11-0.223l0.361-0.536c0.066-0.099,0.151-0.183,0.25-0.25l0.527-0.356 c0.044-0.03,0.091-0.056,0.14-0.078l0.687-0.308l-0.273-0.433l-0.565-0.23c-0.057-0.023-0.111-0.052-0.163-0.086l-0.78-0.517 l-1.272-0.456c-0.126-0.045-0.241-0.117-0.336-0.211l-0.22-0.217c-0.083-0.082-0.15-0.178-0.197-0.284l-0.156-0.351 c-0.047-0.105-0.073-0.218-0.079-0.333l-0.034-0.722c-0.002-0.033-0.001-0.066,0.001-0.099l0.046-0.759 c0.007-0.114,0.035-0.225,0.082-0.329l0.235-0.513l0.043-0.192l0.034-0.26l-0.025-0.752c-0.002-0.063,0.002-0.126,0.013-0.189 l0.076-0.44c0.01-0.055,0.024-0.11,0.044-0.162l0.181-0.49c0.01-0.028,0.022-0.055,0.035-0.082l0.232-0.48 c0.019-0.039,0.041-0.077,0.065-0.113l0.549-0.817l0.647-1.547l0.005-0.025l-0.049-0.482c-0.004-0.039-0.005-0.078-0.004-0.117 l0.046-1.826c0.001-0.026,0.002-0.052,0.005-0.077l-0.665-1.471l-1.53-0.616l-0.702-0.017c-0.121-0.003-0.24-0.03-0.351-0.078 l-0.813-0.359c-0.428-0.189-0.648-0.667-0.513-1.115l0.288-0.953c0.036-0.12,0.096-0.231,0.177-0.327l0.125-0.149 c0.015-0.018,0.03-0.035,0.046-0.051l0.145-0.149c0.006-0.007,0.013-0.013,0.019-0.019l-0.062-0.142 c-0.049-0.111-0.075-0.231-0.078-0.352l-0.078-3.475c-0.002-0.089,0.009-0.179,0.033-0.265l0.306-1.12l0.052-0.315 c0.022-0.133,0.073-0.26,0.149-0.371l0.179-0.262l-0.043-0.337c-0.03-0.233,0.03-0.468,0.168-0.658l1.701-2.359 c0.176-0.244,0.456-0.384,0.751-0.384c0.047,0,0.094,0.004,0.141,0.011l2.881,0.443l0.217-0.094c0.111-0.048,0.23-0.073,0.35-0.076 l0.77-0.014l-0.011-0.123l-0.096-0.626l-2.481-0.361c-0.046-0.007-0.092-0.017-0.136-0.03l-1.679-0.51l-0.235-0.037l-0.863,0.16 c-0.056,0.01-0.113,0.015-0.168,0.015c-0.275,0-0.54-0.123-0.717-0.341c-0.214-0.262-0.268-0.62-0.141-0.933l0.17-0.42 l-0.202,0.147c-0.131,0.096-0.285,0.155-0.446,0.173l-0.425,0.046c-0.033,0.004-0.067,0.005-0.1,0.005 c-0.052,0-0.103-0.004-0.154-0.013l-0.651-0.11c-0.124-0.021-0.242-0.067-0.348-0.135l-0.49-0.316 c-0.056-0.036-0.107-0.077-0.154-0.124l-0.219-0.22c-0.109-0.109-0.188-0.243-0.232-0.39l-0.064-0.214 c-0.04-0.135-0.049-0.277-0.026-0.416l0.025-0.149c0.004-0.021,0.008-0.042,0.013-0.062l-0.233-0.465l-0.372-0.655 c-0.227-0.401-0.125-0.908,0.239-1.19l0.307-0.237l0.039-0.079l-0.837,0.021c-0.008,0-0.015,0-0.023,0 c-0.103,0-0.206-0.017-0.303-0.051l-0.454-0.157c-0.068-0.023-0.132-0.055-0.193-0.093l-0.33-0.21 c-0.128-0.081-0.234-0.193-0.309-0.324l-0.25-0.44c-0.081-0.142-0.122-0.304-0.121-0.467l0.009-0.879l-0.012-0.01l-1.307-1.114 c-0.073-0.062-0.135-0.135-0.186-0.216l-0.557-0.897c-0.026-0.042-0.049-0.087-0.068-0.133l-0.223-0.536l-0.954-1.804l-0.571,0.559 c-0.048,0.047-0.101,0.088-0.157,0.124l-0.371,0.232l-0.594,0.654l-0.306,0.435l-1.128,3.217l-0.134,0.366 c-0.04,0.108-0.099,0.207-0.174,0.293l-1.867,2.118c-0.027,0.031-0.056,0.06-0.087,0.087l-3.627,3.152l-0.248,0.312l-0.291,0.462 l-0.163,0.429l-0.011,0.114l0.124,0.21c0.049,0.083,0.085,0.173,0.106,0.268l0.162,0.717c0.055,0.243,0.009,0.498-0.126,0.707 l-0.622,0.96c-0.034,0.052-0.073,0.101-0.117,0.146l-1.39,1.415c-0.038,0.039-0.079,0.074-0.123,0.105l-1.162,0.828l-2.285,2.038 l-0.26,0.493l-0.612,2.167l-0.013,0.233l0.251,0.615c0.036,0.089,0.058,0.183,0.066,0.278l0.065,0.843 c0.009,0.111-0.003,0.223-0.034,0.33l-0.611,2.096c-0.051,0.173-0.151,0.328-0.288,0.445l-0.634,0.541 c-0.032,0.027-0.065,0.052-0.101,0.075l-0.265,0.17c-0.061,0.039-0.126,0.071-0.194,0.095l-0.385,0.135 c-0.029,0.01-0.058,0.019-0.087,0.026l-0.391,0.095l-0.423,0.151c-0.038,0.013-0.076,0.024-0.115,0.033l-0.766,0.166l0.223,0.408 l0.357,0.463l0.319,0.308l0.302,0.212c0.054,0.038,0.104,0.081,0.148,0.13l0.253,0.273c0.115,0.124,0.193,0.277,0.227,0.443 l0.079,0.387c0.021,0.102,0.024,0.207,0.01,0.311l-0.286,2.092l0.097,0.556l1.491,0.767c0.089,0.046,0.17,0.105,0.239,0.177 l0.696,0.713c0.235,0.241,0.321,0.59,0.225,0.912l-0.169,0.565c-0.011,0.038-0.025,0.076-0.042,0.113l-0.128,0.288 c-0.048,0.108-0.117,0.206-0.202,0.289l-1.239,1.197c-0.11,0.106-0.244,0.183-0.391,0.225l-1.013,0.287l-0.844,0.438l-1.001,1.057 l-0.947,1.285l-0.089,0.225l-0.015,0.205c-0.004,0.049-0.011,0.097-0.023,0.145l-0.063,0.263c-0.06,0.252-0.223,0.467-0.449,0.594 l-0.336,0.188c-0.111,0.062-0.233,0.1-0.359,0.113l-0.539,0.054c-0.031,0.003-0.062,0.005-0.093,0.005 c-0.081,0-0.163-0.011-0.242-0.032l-2.101-0.568l-0.178,0.006l-0.209,0.1l-0.561,0.545c-0.025,0.025-0.052,0.048-0.081,0.07 l-0.724,0.557l-1.482,1.437c-0.105,0.101-0.232,0.177-0.371,0.22l-0.587,0.182c-0.089,0.028-0.181,0.041-0.274,0.041 c-0.021,0-0.042-0.001-0.063-0.002l-0.83-0.057c-0.11-0.007-0.217-0.034-0.317-0.08l-1.387-0.625l-0.505-0.129 c-0.084-0.021-0.165-0.055-0.239-0.099l-0.459-0.27c-0.075-0.044-0.143-0.098-0.203-0.161l-0.159-0.168 c-0.053-0.056-0.099-0.118-0.136-0.184l-0.022-0.007l-1.269,0.157c-0.038,0.005-0.076,0.007-0.113,0.007 c-0.14,0-0.278-0.032-0.405-0.093l-1.124-0.547c-0.153-0.074-0.283-0.19-0.375-0.333l-1.811-2.826l-0.366-0.349l-0.148-0.073 l-0.19,0.016c-0.027,0.002-0.053,0.003-0.08,0.003c-0.059,0-0.118-0.006-0.175-0.017l-0.424-0.082l-0.245,0.31 c-0.059,0.075-0.129,0.14-0.208,0.193l-0.342,0.232c-0.08,0.055-0.169,0.096-0.263,0.123l-0.442,0.128 c-0.065,0.019-0.132,0.03-0.199,0.035l-0.456,0.028c-0.019,0.001-0.038,0.002-0.058,0.002c-0.044,0-0.087-0.003-0.13-0.009 l-0.909-0.129l-0.673,0.003c-0.002,0-0.003,0-0.004,0c-0.188,0-0.372-0.057-0.527-0.165l-0.191-0.132 c-0.08-0.056-0.152-0.124-0.211-0.202l-0.506-0.668l-1.726-1.777l-0.286-0.059c-0.134-0.028-0.261-0.085-0.371-0.168l-0.68-0.514 l-0.09-0.021l-0.205,0.021l-0.841,0.262l-0.071,0.04l-0.148,0.129c-0.058,0.051-0.122,0.094-0.191,0.129l-0.329,0.167 c-0.131,0.066-0.274,0.1-0.418,0.1c-0.077,0-0.155-0.01-0.231-0.029l-0.303-0.078c-0.093-0.024-0.181-0.062-0.262-0.113 l-0.44-0.277c-0.068-0.043-0.131-0.095-0.186-0.154l-0.362-0.39c-0.028-0.031-0.055-0.063-0.079-0.098l-0.264-0.376 c-0.064-0.091-0.11-0.192-0.138-0.299l-0.011-0.043c-0.023,0.069-0.054,0.136-0.092,0.199l-0.152,0.246 c-0.037,0.059-0.08,0.114-0.129,0.164l-0.221,0.224c-0.057,0.058-0.122,0.108-0.193,0.149l-0.31,0.181 c-0.058,0.034-0.12,0.062-0.185,0.082l-0.279,0.089c-0.091,0.029-0.186,0.044-0.282,0.044c-0.073,0-0.145-0.009-0.217-0.026 l-0.34-0.082c-0.108-0.026-0.209-0.071-0.301-0.133l-0.216-0.146c-0.054-0.036-0.104-0.078-0.149-0.125l-0.361-0.374l-0.109,0.017 l-1.838,1.453c-0.121,0.096-0.264,0.16-0.416,0.186l-1.079,0.187l0.002,0.431l0.164,1.281l0.28,1.059l0.094,0.161l0.487,0.617 c0.212,0.269,0.259,0.634,0.12,0.948c-0.138,0.314-0.439,0.525-0.781,0.55l-0.284,0.02l0.044,0.166l0.086,0.122l2.247,1.763 c0.077,0.06,0.142,0.131,0.195,0.209l0.103-0.195c0.038-0.072,0.086-0.139,0.141-0.199l0.317-0.341l0.254-0.863l0.118-1.061 l-0.121-0.735c-0.05-0.303,0.054-0.611,0.276-0.822c0.174-0.165,0.403-0.254,0.638-0.254c0.008,0,0.017,0,0.025,0 c0.071-0.232,0.232-0.431,0.454-0.547l0.392-0.207c0.08-0.042,0.166-0.072,0.255-0.09l0.401-0.078 c0.058-0.011,0.118-0.017,0.177-0.017c0.024,0,0.048,0.001,0.072,0.003l-0.128-0.291c-0.164-0.374-0.065-0.811,0.246-1.077 c0.172-0.147,0.387-0.222,0.602-0.222c0.173,0,0.346,0.048,0.499,0.146l0.715,0.458c0.066,0.043,0.127,0.093,0.18,0.151l0.48,0.519 l0.125,0.09l0.297-0.065c0.066-0.015,0.133-0.022,0.198-0.022c0.378,0,0.727,0.233,0.865,0.596l0.028-0.001 c0.013-0.001,0.026-0.001,0.039-0.001c0.309,0,0.598,0.154,0.77,0.412c0.18,0.269,0.206,0.612,0.069,0.905l-0.739,1.589 c-0.035,0.076-0.081,0.147-0.135,0.211l-0.627,0.734c0.115,0.035,0.223,0.092,0.317,0.17c0.215,0.176,0.339,0.439,0.339,0.716 v0.311c0,0.388-0.242,0.735-0.605,0.869l-0.656,0.242c-0.056,0.021-0.114,0.036-0.172,0.045l-2.179,0.354 c-0.05,0.008-0.1,0.012-0.149,0.012c-0.198,0-0.389-0.064-0.545-0.178l-0.076,0.393c-0.014,0.074-0.038,0.146-0.069,0.214 l-0.158,0.34l-0.067,0.197l-0.008,0.061l0.432,0.286l0.74,0.365c0.102,0.05,0.194,0.119,0.271,0.202l0.162,0.175 c0.253,0.274,0.317,0.673,0.162,1.013l-0.16,0.35c-0.022,0.049-0.049,0.095-0.079,0.139l0.393,0.203l2.822-0.478l2.001-1.145 l-0.11-1.4c-0.027-0.339,0.135-0.666,0.421-0.851c0.152-0.098,0.327-0.148,0.502-0.148c0.153,0,0.307,0.038,0.447,0.115l0.34,0.187 l0.286,0.051l1.069-0.012c0.004,0,0.007,0,0.011,0c0.265,0,0.51,0.113,0.681,0.299l1.307-0.278c0.064-0.014,0.129-0.02,0.193-0.02 c0.21,0,0.416,0.072,0.583,0.206c0.217,0.176,0.343,0.44,0.343,0.72v0.285c0,0.261-0.11,0.511-0.304,0.686l-0.547,0.496 l-0.396,0.711c-0.019,0.034-0.04,0.067-0.064,0.099l-0.561,0.76c-0.114,0.154-0.273,0.269-0.454,0.329l-1.362,0.45l0.002,0.012 l0.265,0.873c0.1,0.33,0.008,0.689-0.238,0.93l-0.669,0.656c-0.012,0.011-0.024,0.023-0.036,0.033 c0.063,0.234,0.034,0.493-0.101,0.717l-0.329,0.547c-0.013,0.022-0.027,0.043-0.042,0.063c0.12,0.078,0.221,0.184,0.294,0.308 l0.119,0.203c0.133,0.227,0.164,0.5,0.083,0.751c-0.015,0.046-0.033,0.09-0.054,0.133c0.111,0.288,0.071,0.617-0.114,0.873 l-0.234,0.324l0.139,0.045c0.34,0.109,0.587,0.404,0.635,0.757s-0.111,0.704-0.41,0.899l-0.301,0.197 c-0.086,0.056-0.181,0.098-0.28,0.123l-0.655,0.166l-0.283,0.106l-0.349,0.323c-0.068,0.062-0.144,0.115-0.227,0.155l-0.351,0.169 c-0.126,0.061-0.264,0.092-0.402,0.092c-0.081,0-0.162-0.011-0.241-0.032l-0.116-0.031l-0.09,0.279 c-0.015,0.046-0.034,0.091-0.056,0.134l-0.286,0.562c-0.032,0.063-0.071,0.122-0.116,0.176l-0.412,0.491 c0.246,0.164,0.406,0.44,0.413,0.748c0.011,0.415-0.257,0.787-0.654,0.909l-1.334,0.41c-0.083,0.025-0.17,0.039-0.257,0.041 l-0.446,0.007c-0.005,0-0.01,0-0.015,0c-0.181,0-0.354-0.053-0.502-0.148c0.072,0.152,0.102,0.324,0.083,0.496 c0.126,0.197,0.176,0.441,0.126,0.685l-0.092,0.447c0.15,0.157,0.243,0.366,0.255,0.592c0.006,0.112-0.009,0.222-0.041,0.325 c0.015,0.023,0.028,0.046,0.041,0.07l0.18,0.344c0.051,0.098,0.085,0.204,0.098,0.313l0.056,0.438 c0.045,0.356-0.119,0.706-0.422,0.899c-0.152,0.096-0.324,0.144-0.497,0.144c-0.172,0-0.345-0.048-0.496-0.144l-0.223-0.142 c-0.052-0.033-0.101-0.071-0.145-0.114l-0.288-0.277l-0.245-0.02l-0.168,0.112c-0.152,0.102-0.331,0.156-0.514,0.156 c-0.008,0-0.016,0-0.024,0l-0.252-0.006l-0.286,0.518l-0.108,0.435l0.269,0.385c0.061,0.087,0.107,0.185,0.135,0.288l0.093,0.341 c0.068,0.25,0.028,0.517-0.11,0.737l-0.134,0.212c-0.137,0.218-0.36,0.369-0.613,0.417c-0.057,0.011-0.114,0.016-0.171,0.016 c-0.118,0-0.234-0.022-0.343-0.066l0.156,0.259l1.474,1.766c0.061,0.073,0.11,0.155,0.146,0.243l0.208,0.51 c0.139,0.342,0.063,0.733-0.195,0.997c-0.178,0.182-0.418,0.279-0.663,0.279c-0.111,0-0.222-0.02-0.33-0.061l-1.133-0.432 c-0.137-0.052-0.26-0.136-0.358-0.246l-0.674-0.748c-0.05-0.056-0.093-0.117-0.128-0.183l-0.466-0.87l-0.011,0.01 c-0.037,0.033-0.076,0.063-0.117,0.09l-0.201,0.13c-0.114,0.074-0.243,0.122-0.378,0.141l-0.596,0.082l-0.705,0.181 c-0.075,0.019-0.153,0.029-0.23,0.029c-0.069,0-0.138-0.008-0.206-0.023l-0.089-0.02l-0.123,0.073l-0.38,0.387l-0.162,0.227 l-0.012,0.227l0.256,0.231l1.838,1.768l0.186,0.134c0.112,0.081,0.205,0.186,0.271,0.308l0.582,1.071l0.407,0.466 c0.062,0.071,0.113,0.152,0.151,0.239l0.194,0.443c0.024,0.056,0.043,0.114,0.056,0.173l0.071,0.324 c0.006,0.029,0.011,0.059,0.015,0.088l0.025,0.207l0.059,0.149l0.365,0.592l0.271-0.034l0.223-0.067l0.176-0.079l0.104-0.063 c0.075-0.045,0.155-0.08,0.24-0.102l0.198-0.053c0.078-0.021,0.159-0.032,0.24-0.032h0.359c0.134,0,0.266,0.029,0.388,0.085 l1.129,0.521c0.249,0.115,0.434,0.334,0.506,0.599l0.067,0.248c0.006,0.023,0.012,0.046,0.016,0.069l0.022,0.005 c0.197,0.045,0.373,0.152,0.503,0.307l0.244,0.289c0.009,0.001,0.018,0.002,0.026,0.003l0.098,0.014 c0.178,0.026,0.344,0.103,0.478,0.221l0.05-0.037l0.31-0.32c0.036-0.037,0.075-0.071,0.117-0.102l0.158-0.116l0.391-0.348 l0.345-0.375c0.038-0.042,0.08-0.08,0.126-0.114l0.153-0.115l0.313-0.301c0.119-0.114,0.266-0.195,0.426-0.233l0.282-0.067 c0.071-0.017,0.143-0.025,0.216-0.025c0.079,0,0.157,0.01,0.234,0.03l0.137,0.036l0.514-0.367c0.071-0.05,0.148-0.09,0.229-0.119 l0.945-0.333c0.046-0.016,0.094-0.029,0.143-0.038l0.84-0.153c0.055-0.01,0.11-0.015,0.166-0.015c0.057,0,0.113,0.005,0.169,0.016 l2.12,0.393c0.036,0.007,0.071,0.015,0.106,0.026l2.216,0.689c0.069,0.022,0.136,0.051,0.198,0.088l0.316,0.188 c0.057,0.034,0.111,0.074,0.16,0.12l0.748,0.699c0.044,0.041,0.083,0.086,0.118,0.134l0.118,0.163 c0.006,0.009,0.012,0.018,0.018,0.026l0.23,0.093c0.031,0.012,0.06,0.026,0.09,0.042l2.584,1.377l1.161,0.396l0.602,0.071 l0.554-0.071l0.358-0.107l0.189-0.073l0.157-0.101l0.663-0.724l1.427-2.601c0.139-0.253,0.387-0.426,0.672-0.47 c0.047-0.007,0.094-0.011,0.14-0.011c0.237,0,0.468,0.091,0.642,0.258l0.523,0.503l2.339,1.592c0.031,0.021,0.06,0.044,0.088,0.068 l0.916,0.799l0.595,0.29l0.165,0.023l0.061-0.057l0.112-0.164c0.038-0.056,0.083-0.108,0.132-0.155l0.182-0.17 c0.154-0.144,0.352-0.231,0.562-0.248l0.29-0.023c0.024-0.002,0.048-0.003,0.072-0.003c0.339,0,0.653,0.186,0.815,0.487 l0.201,0.374l0.017-0.026c0.035-0.052,0.075-0.1,0.119-0.144l0.169-0.167c0.054-0.053,0.114-0.1,0.179-0.138l0.228-0.135 c0.07-0.041,0.144-0.073,0.222-0.095l0.342-0.096c0.082-0.023,0.166-0.034,0.25-0.034c0.099,0,0.197,0.016,0.292,0.047l0.289,0.096 c0.075,0.025,0.147,0.06,0.214,0.103l0.172,0.112l0.105-0.105l0.189-0.26l0.394-0.896c0.038-0.087,0.09-0.168,0.153-0.239 l0.29-0.329c0.086-0.098,0.192-0.176,0.31-0.23l0.583-0.266c0.064-0.029,0.131-0.051,0.201-0.065l1.06-0.215l0.242-0.104 l0.273-0.267l0.259-0.459l0.128-0.498l0.046-1.318l-0.001-0.002l-0.499-0.472c-0.109-0.103-0.192-0.231-0.24-0.373l-0.139-0.408 c-0.085-0.248-0.06-0.521,0.067-0.75L118.859,426.396z").attr({id: 'valledelcauca', class: 'st22', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#BA7025'}).data({'id': 'valledelcauca', 'region':'Valle del Cauca', 'benefited-companies':'40', 'benefited-projects': '$1.340.000.000'});

        var tolima = rsr.path("M140.527,441.579l0.548-0.028c0.016-0.001,0.032-0.001,0.047-0.001 c0.049,0,0.097,0.004,0.146,0.012l0.688,0.11c0.2,0.032,0.384,0.128,0.524,0.275l0.321,0.335l0.451,0.386l0.762,0.403l3.432,1.218 l1.031,0.063l0.18-0.034l0.134-0.182l0.978-1.964c0.041-0.083,0.094-0.159,0.158-0.225l1.731-1.82 c0.026-0.027,0.053-0.052,0.082-0.076l4.394-3.626l0.642-0.758l0.277-1.275c0.037-0.172,0.122-0.329,0.246-0.454l0.916-0.929 l0.135-1.436c0.01-0.108,0.039-0.213,0.086-0.311l1.004-2.111c0.014-0.03,0.03-0.058,0.047-0.086l1.275-2.08 c0.018-0.03,0.038-0.059,0.06-0.086l1.347-1.722l0.859-1.34c0.044-0.069,0.097-0.131,0.158-0.186l0.67-0.608 c0.115-0.104,0.255-0.178,0.406-0.215l0.518-0.124c0.071-0.017,0.143-0.025,0.216-0.025c0.052,0,0.104,0.004,0.156,0.013 l0.498,0.085c0.035,0.006,0.069,0.014,0.104,0.024l0.294,0.086l0.149-0.005l0.234-0.058l0.281-0.232 c0.07-0.058,0.149-0.105,0.233-0.14l0.401-0.167c0.039-0.016,0.078-0.029,0.118-0.04l0.745-0.197l0.101-0.074l0.16-0.198 l0.298-0.45c0.052-0.079,0.116-0.149,0.19-0.209l0.268-0.216c0.079-0.064,0.169-0.115,0.265-0.15l0.256-0.093 c0.056-0.02,0.113-0.035,0.171-0.044l1.314-0.209c0.048-0.008,0.097-0.012,0.146-0.012c0.043,0,0.087,0.003,0.13,0.009l0.476,0.067 c0.108,0.015,0.212,0.049,0.308,0.101l0.456,0.245c0.033,0.018,0.065,0.038,0.096,0.059l0.87,0.613l0.584,0.333 c0.033,0.019,0.064,0.039,0.095,0.062l0.052,0.038l0.179-0.254c0.035-0.049,0.074-0.095,0.117-0.136l0.661-0.632 c0.125-0.12,0.281-0.202,0.451-0.237l0.51-0.107c0.063-0.013,0.126-0.02,0.19-0.02c0.076,0,0.152,0.009,0.227,0.028l0.394,0.099 c0.168,0.042,0.32,0.131,0.44,0.255l0.316-0.361c0.082-0.094,0.182-0.17,0.295-0.224l0.347-0.167l0.17-0.193 c0.099-0.112,0.224-0.199,0.363-0.252l0.342-0.131c0.059-0.023,0.12-0.039,0.182-0.049l0.379-0.062 c0.047-0.008,0.095-0.012,0.143-0.012l4.507-0.031c0.002,0,0.004,0,0.006,0c0.317,0,0.613,0.163,0.783,0.431 c0.171,0.27,0.19,0.61,0.051,0.898l-0.21,0.434l-0.235,0.862l-0.044,0.412c-0.008,0.075-0.025,0.149-0.051,0.22l-0.141,0.386 c-0.026,0.071-0.061,0.139-0.103,0.201l-0.266,0.393l-0.02,0.068l-0.082,0.725c-0.003,0.029-0.008,0.057-0.014,0.085l-0.118,0.567 c-0.008,0.038-0.018,0.076-0.031,0.113l-0.173,0.501l-0.034,0.153l0.026,0.023l1.818,0.448l1.97,0.177l2.206-0.428l2.184-2.201 l1.675-2.447c0.016-0.024,0.034-0.047,0.053-0.07l0.938-1.125c0.028-0.034,0.058-0.065,0.091-0.094l0.776-0.701l0.075-0.156 l-0.01-0.103l-0.175-0.443c-0.03-0.077-0.05-0.157-0.059-0.239l-0.073-0.671c-0.01-0.089-0.007-0.178,0.009-0.266l0.196-1.078 c0.017-0.093,0.048-0.183,0.092-0.267l0.274-0.519c0.055-0.103,0.128-0.196,0.217-0.272l0.419-0.358 c0.047-0.04,0.097-0.075,0.151-0.105l0.3-0.168l0.363-0.398l0.015-0.031l-0.004-0.085l-0.083-0.275 c-0.018-0.059-0.029-0.119-0.035-0.18l-0.049-0.518c-0.014-0.147,0.008-0.295,0.063-0.432l0.17-0.422 c0.021-0.052,0.046-0.102,0.076-0.149l0.283-0.448c0.046-0.073,0.103-0.14,0.168-0.198l0.228-0.202 c0.103-0.091,0.225-0.159,0.357-0.197l0.19-0.055l0.092-0.049l0.156-0.164l0.413-0.864c0.019-0.04,0.041-0.079,0.066-0.116 l0.393-0.587c0.02-0.03,0.043-0.06,0.066-0.087l0.532-0.621c0.057-0.066,0.123-0.125,0.196-0.172l1.788-1.168l2.625-2.365 l0.12-0.362l0.548-3.292c0.017-0.103,0.051-0.202,0.102-0.294l1.185-2.16l0.361-1.002l0.156-0.657l-0.013-0.222l-0.794-1.404 c-0.126-0.222-0.154-0.486-0.078-0.73l0.446-1.437l-0.19-0.458c-0.066-0.159-0.086-0.333-0.059-0.503l0.094-0.583 c0.008-0.05,0.02-0.099,0.036-0.147l0.191-0.567c0.015-0.044,0.033-0.087,0.054-0.128l0.294-0.572 c0.04-0.078,0.09-0.149,0.15-0.212l0.608-0.643c0.023-0.024,0.047-0.047,0.072-0.068l0.196-0.168l0.339-0.401l0.07-0.604 l-0.245-0.972c-0.008-0.032-0.015-0.065-0.019-0.098l-0.057-0.408l-0.215-0.484l-0.258-0.368c-0.031-0.045-0.058-0.092-0.081-0.141 l-0.926-1.993l-0.638-0.499c-0.021-0.016-0.041-0.034-0.06-0.052l-0.377-0.352l-0.16-0.156l-0.111-0.057l-0.29,0.045l-1.057,0.413 l-0.211,0.127l-0.034,0.039l-0.165,0.496c-0.023,0.07-0.055,0.137-0.094,0.199l-0.164,0.263c-0.042,0.067-0.093,0.129-0.151,0.184 l-0.169,0.159l-0.321,0.425c-0.055,0.073-0.121,0.138-0.195,0.191l-0.24,0.174c-0.073,0.053-0.152,0.095-0.237,0.124l-0.243,0.085 c-0.1,0.035-0.204,0.052-0.307,0.052c-0.169,0-0.337-0.046-0.485-0.137l-0.087-0.054l-0.29,0.05 c-0.052,0.009-0.104,0.013-0.157,0.013c-0.064,0-0.128-0.007-0.191-0.02l-0.524-0.11c-0.048-0.01-0.096-0.024-0.142-0.042 l-0.498-0.192c-0.105-0.04-0.202-0.1-0.286-0.175l-1.105-0.991l-0.273,0.087c-0.093,0.029-0.187,0.043-0.28,0.043 c-0.364,0-0.706-0.216-0.854-0.567l-0.167-0.396l-0.937-0.499c-0.13-0.069-0.239-0.167-0.322-0.284l-0.274,0.048 c-0.027,0.005-0.054,0.008-0.081,0.01l-0.941,0.08l-1.249,0.291c-0.045,0.01-0.09,0.018-0.136,0.021l-0.973,0.078 c-0.025,0.002-0.049,0.003-0.074,0.003c-0.247,0-0.485-0.099-0.66-0.276l-0.476-0.484c-0.199-0.202-0.295-0.485-0.259-0.767 l0.175-1.371c0.012-0.091,0.037-0.18,0.075-0.264l3.21-7.111l0.436-1.579l0.042-1.574l-0.564-1.808 c-0.074-0.237-0.05-0.493,0.067-0.712c0.006-0.011,0.012-0.022,0.018-0.032c-0.159-0.272-0.173-0.614-0.018-0.904l0.306-0.573 c0.031-0.058,0.068-0.113,0.11-0.163l0.509-0.601c-0.101-0.052-0.192-0.123-0.269-0.21l-0.22-0.25 c-0.109-0.124-0.183-0.274-0.215-0.436l-0.064-0.327c-0.018-0.094-0.022-0.191-0.011-0.286l0.028-0.239l-0.466-0.705 c-0.061-0.092-0.105-0.195-0.13-0.303l-0.115-0.497c-0.049-0.214-0.021-0.439,0.08-0.634l0.295-0.569 c0.076-0.146,0.189-0.27,0.329-0.358l0.507-0.32c0.067-0.042,0.139-0.076,0.215-0.1l0.496-0.156l0.086-0.045l0.05-0.131 l0.115-0.435c0.038-0.145,0.111-0.279,0.213-0.39l0.475-0.518l0.064-0.189l-0.313-1.99c-0.006-0.04-0.01-0.08-0.011-0.12 l-0.018-0.685c-0.002-0.068,0.004-0.135,0.017-0.202l0.116-0.591c0.025-0.129,0.077-0.25,0.153-0.357l0.302-0.426 c0.05-0.071,0.11-0.135,0.178-0.188c0.001-0.003,0.001-0.007,0.002-0.01l0.06-0.334c0.01-0.054,0.024-0.107,0.043-0.158l0.082-0.22 l0.005-0.157l-0.48-1.405c-0.014-0.04-0.024-0.08-0.033-0.122l-0.061-0.313c-0.063-0.323,0.05-0.655,0.296-0.872l0.282-0.249 c0.07-0.062,0.149-0.112,0.234-0.15l0.425-0.191l-0.346-0.565c-0.035-0.058-0.064-0.119-0.086-0.183l-0.177-0.516 c-0.037-0.109-0.054-0.224-0.049-0.339l0.039-0.932c0.002-0.053,0.009-0.106,0.02-0.158l0.588-2.707l-0.303-7.164l-0.026-0.087 c-0.065-0.013-0.128-0.032-0.19-0.058l-1.697-0.73l-1.427-0.404l-0.19,0.005l-0.781,0.154l-0.785,0.341 c-0.117,0.051-0.243,0.077-0.369,0.077c-0.063,0-0.126-0.006-0.189-0.019l-1.643-0.342l-0.695,0.005l-1.522,0.523 c-0.057,0.02-0.117,0.034-0.177,0.042l-0.973,0.132c-0.036,0.005-0.072,0.008-0.109,0.008l-0.461,0.008l-0.507,0.214l-0.263,0.213 c-0.061,0.049-0.127,0.091-0.199,0.123l-0.747,0.34l-0.118,0.397c-0.027,0.091-0.068,0.177-0.121,0.255l-1.882,2.783l-0.2,0.396 l-0.046,0.17c-0.016,0.057-0.037,0.113-0.063,0.166l-0.112,0.228c-0.067,0.137-0.168,0.255-0.292,0.344l-0.238,0.171 c-0.081,0.058-0.17,0.102-0.264,0.131l-0.423,0.131c-0.089,0.028-0.182,0.042-0.275,0.042c-0.067,0-0.133-0.007-0.199-0.022 l-0.662-0.146c-0.062-0.014-0.122-0.033-0.18-0.059l-0.618-0.277l-0.772,0.342l-0.28,0.305c-0.06,0.066-0.13,0.123-0.207,0.168 l-0.667,0.399c-0.056,0.034-0.116,0.061-0.178,0.082l-0.836,0.284c-0.096,0.033-0.197,0.049-0.298,0.049h-0.634 c-0.093,0-0.186-0.014-0.275-0.042l-0.364-0.113l-0.208,0.023l-0.411,0.189l-0.839,0.766l-0.902,1.043l-0.093,0.249l0.074,0.038 c0.158,0.082,0.289,0.207,0.377,0.362l0.622,1.085c0.156,0.272,0.164,0.604,0.021,0.883l-1.381,2.696l-0.127,0.51l-0.033,0.255 l0.57,1.104l0.392,0.657c0.101,0.168,0.145,0.364,0.127,0.56l-0.064,0.69c-0.009,0.098-0.034,0.195-0.073,0.285l-0.311,0.714 c-0.027,0.062-0.061,0.121-0.101,0.176l-0.799,1.095l-0.909,1.569l-0.521,3.526l0.024,0.241c0.019,0.189-0.021,0.378-0.113,0.544 l-1.172,2.099l-0.219,0.959c-0.022,0.098-0.06,0.191-0.113,0.276l-0.284,0.465c-0.025,0.041-0.054,0.081-0.085,0.117l-0.281,0.33 c-0.076,0.09-0.169,0.164-0.274,0.219l-2.054,1.082l-0.873,0.94l-0.242,0.346l-0.732,2.054c-0.035,0.099-0.087,0.191-0.153,0.273 l-1.275,1.572l-0.936,1.987l-0.324,2.965c-0.003,0.024-0.006,0.048-0.011,0.071l-0.541,2.865c-0.022,0.115-0.065,0.225-0.128,0.323 l-0.537,0.849l-1.111,1.627c-0.054,0.079-0.119,0.149-0.195,0.207l-0.801,0.626l-0.207,0.563c-0.031,0.085-0.075,0.165-0.13,0.238 l-0.889,1.178l-0.289,0.625c-0.015,0.032-0.031,0.063-0.049,0.093l-0.768,1.263c-0.028,0.045-0.059,0.088-0.094,0.128l-1.904,2.178 l0.392,0.622c0.091,0.145,0.14,0.312,0.142,0.483l0.006,0.487c0.004,0.369-0.211,0.706-0.548,0.856l-1.353,0.606l-0.312,0.21 l-0.191,0.283l-0.56,1.665c-0.028,0.084-0.068,0.163-0.119,0.236l-0.447,0.639l-0.631,1.21l-1.034,2.514 c-0.023,0.056-0.051,0.109-0.084,0.159l-2.998,4.526l-0.469,1.086c-0.012,0.027-0.025,0.054-0.039,0.08l-0.16,0.291 c-0.029,0.053-0.064,0.103-0.103,0.15l-0.819,0.972c-0.029,0.035-0.061,0.068-0.096,0.098l-0.021,0.019l-0.382,1.362 c-0.029,0.104-0.076,0.202-0.139,0.29l-0.318,0.443l-0.318,0.655l-0.313,2.317l0.027,0.792c0.001,0.037,0,0.073-0.003,0.11 l-0.051,0.592c-0.012,0.144-0.058,0.283-0.134,0.406l-0.34,0.554l-0.247,0.558c-0.023,0.052-0.051,0.102-0.083,0.149l-0.457,0.665 l-0.238,0.485l-0.15,0.627c-0.013,0.053-0.03,0.105-0.052,0.155l-0.467,1.072l-0.232,0.742l-0.019,1.374 c0,0.031-0.002,0.062-0.006,0.094l-0.13,1.118c-0.011,0.095-0.037,0.188-0.076,0.275l-0.384,0.849l0.309,0.646l0.254,0.344 c0.07,0.094,0.121,0.201,0.151,0.314l0.125,0.473c0.065,0.246,0.026,0.507-0.107,0.724l-0.182,0.294 c-0.063,0.101-0.144,0.189-0.24,0.26l-0.21,0.154l-0.08,0.105l-0.082,0.303l-0.08,2.402c-0.006,0.18-0.064,0.355-0.168,0.502 l-0.446,0.635c-0.069,0.098-0.156,0.182-0.257,0.247l-0.377,0.242l-0.077,0.444l0.131,0.638c0.028,0.137,0.025,0.278-0.009,0.413 l-0.315,1.249c-0.039,0.153-0.116,0.294-0.225,0.41l-0.321,0.34l-0.043,0.098l-0.037,0.341v0.009l0.436,0.36l0.522,0.208 c0.17,0.068,0.316,0.185,0.42,0.336l0.539,0.785l0.891,0.783c0.117,0.103,0.207,0.234,0.26,0.381l0.656,1.816 c0.038,0.105,0.057,0.217,0.055,0.329l-0.02,1.259C140.266,441.62,140.394,441.585,140.527,441.579z").attr({id: 'tolima', class: 'st23', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#DBBA82'}).data({'id': 'tolima', 'region':'Tolima', 'benefited-companies':'8', 'benefited-projects': '$200.000.000'});

        var huila = rsr.path("M115.712,485.517c-0.046,0.161-0.135,0.307-0.258,0.422l-1.098,1.027l-0.219,0.47l-0.017,0.366 l0.118,1.659l0.757,1.342l3.178,2.471c0.062,0.048,0.117,0.104,0.165,0.166l2.354,3.057c0.019,0.025,0.037,0.051,0.054,0.078 l1.947,3.147l1.06,1.033l1.396,0.808l2.136,0.637l1.185,0.348c0.089,0.026,0.174,0.066,0.252,0.117l0.609,0.405l1.417,0.478 l1.594,0.059c0.124,0.005,0.245,0.034,0.358,0.086l1.563,0.729l2.719,0.442l2.261,0.085c0.028,0.001,0.055,0.003,0.083,0.007 l1.001,0.128l0.92-0.129l0.66-0.301l0.671-0.662l0.692-0.87c0.022-0.028,0.046-0.055,0.071-0.08l0.857-0.852 c0.034-0.034,0.071-0.066,0.111-0.094l2.317-1.675l0.521-0.487l0.551-0.97c0.028-0.048,0.059-0.094,0.095-0.137l0.895-1.069 c0.01-0.012,0.02-0.024,0.031-0.035l2.945-3.178l2.19-3.051l3.064-4.478c0.041-0.059,0.088-0.114,0.141-0.162l3.337-3.033 l3.39-5.442l1.43-2.349l1.01-1.855c0.057-0.104,0.133-0.196,0.224-0.271l0.977-0.805c0.017-0.014,0.035-0.028,0.053-0.04 l2.121-1.507c0.021-0.015,0.043-0.029,0.065-0.042l0.34-0.201l1.568-1.718l0.544-0.854l0.596-1.241l1.438-5.061 c0.025-0.088,0.063-0.171,0.112-0.248l0.671-1.044c0.038-0.059,0.083-0.114,0.133-0.163l0.583-0.567 c0.112-0.108,0.249-0.187,0.398-0.229l0.494-0.137c0.081-0.022,0.164-0.034,0.247-0.034c0.065,0,0.129,0.007,0.193,0.02 l0.532,0.113c0.094,0.02,0.185,0.055,0.269,0.103l1.237,0.711l0.168,0.057l1.069-0.336l3.703-2.854l1.387-1.576l0.159-0.353 l-0.22-0.821l-0.787-0.844l-0.985-0.637c-0.178-0.115-0.311-0.288-0.377-0.49l-0.367-1.122c-0.054-0.164-0.06-0.34-0.02-0.507 l0.215-0.881c0.011-0.044,0.025-0.088,0.042-0.13l0.579-1.422c0.014-0.033,0.029-0.066,0.047-0.097l0.91-1.651 c0.022-0.04,0.048-0.079,0.076-0.116l1.987-2.596c0.034-0.045,0.072-0.086,0.114-0.124l1.785-1.617l0.678-0.636 c0.061-0.057,0.13-0.106,0.204-0.145l0.373-0.195c0.057-0.03,0.117-0.054,0.179-0.071l0.244-0.068l1.189-3.384 c0.019-0.054,0.043-0.106,0.071-0.155l1.554-2.7c0.02-0.035,0.042-0.068,0.067-0.1l0.491-0.643 c0.057-0.075,0.126-0.141,0.203-0.195l1.047-0.737c0.041-0.029,0.084-0.054,0.129-0.076l1.185-0.574l1.023-1.063 c0.049-0.051,0.104-0.096,0.164-0.135l2.145-1.39l0.663-0.579l1.219-2.045l0.398-1.301l0.208-1.429l0.165-3.758 c0.001-0.027,0.004-0.055,0.007-0.082l0.248-1.863c0.008-0.06,0.022-0.119,0.041-0.176l0.546-1.608 c0.031-0.091,0.076-0.177,0.134-0.254l3.317-4.464l0.943-1.614l0.954-2.322l0.109-0.656l-1.228-0.902 c-0.065-0.048-0.123-0.104-0.174-0.166l-0.677-0.843l-2.569,2.315c-0.035,0.032-0.073,0.061-0.113,0.087l-1.737,1.135l-0.41,0.479 l-0.325,0.485l-0.448,0.937c-0.042,0.088-0.098,0.169-0.166,0.24l-0.362,0.379c-0.069,0.072-0.149,0.133-0.238,0.18l-0.309,0.163 c-0.056,0.029-0.114,0.053-0.174,0.07l-0.066,0.019l-0.156,0.247l-0.055,0.135l0.019,0.202l0.089,0.296 c0.022,0.073,0.035,0.148,0.038,0.224l0.02,0.44c0.007,0.158-0.026,0.315-0.097,0.457l-0.181,0.362 c-0.038,0.076-0.087,0.147-0.144,0.21l-0.551,0.604c-0.067,0.074-0.146,0.136-0.233,0.185l-0.351,0.196l-0.214,0.183l-0.125,0.236 l-0.146,0.805l0.045,0.414l0.177,0.449c0.032,0.081,0.052,0.166,0.06,0.253l0.046,0.489c0.016,0.167-0.014,0.335-0.087,0.487 l-0.264,0.553c-0.052,0.109-0.125,0.207-0.215,0.288l-0.864,0.78l-0.868,1.041l-1.698,2.48c-0.032,0.046-0.067,0.09-0.107,0.129 l-2.445,2.463c-0.131,0.132-0.298,0.221-0.481,0.257l-2.615,0.507c-0.058,0.011-0.117,0.017-0.176,0.017 c-0.028,0-0.055-0.001-0.083-0.004l-2.171-0.195c-0.047-0.004-0.093-0.012-0.138-0.023l-2.101-0.517 c-0.142-0.035-0.273-0.103-0.383-0.198l-0.372-0.32c-0.106-0.091-0.189-0.205-0.245-0.333l-0.191-0.44 c-0.078-0.179-0.097-0.379-0.055-0.57l0.114-0.514c0.008-0.034,0.017-0.068,0.028-0.101l0.171-0.495l0.097-0.468l0.086-0.763 c0.006-0.054,0.017-0.107,0.032-0.159l0.084-0.284c0.027-0.092,0.068-0.178,0.122-0.257l0.283-0.418l0.063-0.173l0.04-0.373 c0.005-0.049,0.014-0.098,0.027-0.145l0.095-0.347l-3.107,0.021l-0.214,0.035l-0.041,0.016l-0.143,0.162 c-0.082,0.093-0.181,0.168-0.293,0.222l-0.346,0.166l-0.099,0.113l-0.011,0.431c-0.008,0.307-0.167,0.591-0.426,0.757 c-0.151,0.097-0.325,0.146-0.5,0.146c-0.124,0-0.248-0.025-0.366-0.075l-0.883-0.379c-0.205-0.088-0.371-0.247-0.468-0.448 l-0.358,0.342l-0.27,0.384c-0.031,0.045-0.067,0.086-0.105,0.125l-0.355,0.352c-0.045,0.044-0.094,0.084-0.146,0.118l-0.185,0.121 c-0.154,0.101-0.33,0.15-0.506,0.15c-0.195,0-0.389-0.061-0.553-0.183l-0.633-0.471l-0.574-0.327 c-0.026-0.015-0.051-0.031-0.076-0.048l-0.86-0.607l-0.262-0.14l-0.175-0.025l-1.089,0.173l-0.028,0.01l-0.037,0.03l-0.243,0.367 c-0.016,0.024-0.033,0.047-0.051,0.07l-0.263,0.326c-0.051,0.063-0.109,0.119-0.174,0.166l-0.34,0.248 c-0.093,0.068-0.198,0.118-0.309,0.148l-0.853,0.226l-0.216,0.09l-0.337,0.278c-0.107,0.088-0.232,0.151-0.366,0.184l-0.531,0.131 c-0.062,0.015-0.125,0.024-0.189,0.026l-0.394,0.014c-0.011,0-0.022,0.001-0.033,0.001c-0.088,0-0.175-0.012-0.26-0.037 l-0.387-0.113l-0.258-0.044l-0.103,0.025l-0.403,0.366l-0.816,1.273c-0.016,0.024-0.032,0.048-0.05,0.071l-1.341,1.715 l-1.222,1.993l-0.913,1.918l-0.151,1.601c-0.02,0.212-0.113,0.412-0.263,0.564l-0.959,0.972l-0.269,1.238 c-0.032,0.148-0.1,0.286-0.198,0.402l-0.845,0.997c-0.036,0.042-0.075,0.081-0.117,0.116l-4.415,3.643l-1.596,1.679l-0.952,1.912 c-0.024,0.048-0.052,0.094-0.084,0.137l-0.398,0.539c-0.138,0.188-0.343,0.316-0.571,0.36l-0.65,0.124 c-0.057,0.011-0.115,0.016-0.174,0.016c-0.019,0-0.038-0.001-0.056-0.002l-1.278-0.078c-0.086-0.005-0.172-0.023-0.253-0.052 l-3.619-1.284c-0.042-0.015-0.083-0.033-0.123-0.054l-0.913-0.482c-0.061-0.032-0.118-0.071-0.17-0.115l-0.564-0.483 c-0.023-0.02-0.046-0.041-0.067-0.063l-0.137-0.143l-0.284-0.045l-0.193,0.01l-0.514,0.348l4.56,3.976l1.203,1.054 c0.033,0.029,0.065,0.061,0.093,0.095l1.174,1.373l0.428,0.383l0.6,0.25c0.065,0.027,0.127,0.061,0.184,0.102l0.82,0.588 c0.058,0.042,0.111,0.09,0.158,0.144l0.594,0.68c0.065,0.074,0.117,0.158,0.155,0.248l0.508,1.2l0.581,0.998 c0.129,0.222,0.161,0.488,0.086,0.734l-0.977,3.231c-0.013,0.044-0.03,0.086-0.049,0.128l-0.78,1.651l-0.07,0.9l1.164,2.313 c0.223,0.443,0.058,0.982-0.375,1.224l-0.982,0.55l-0.391,0.388l-0.534,0.869c-0.161,0.262-0.441,0.426-0.747,0.44l-1.509,0.068 c-0.014,0.001-0.028,0.001-0.042,0.001c-0.144,0-0.287-0.034-0.416-0.099l-0.897-0.451c-0.071-0.036-0.137-0.081-0.197-0.133 l-1.475-1.303l-1.174-0.826l-0.895,1.037c-0.027,0.031-0.056,0.06-0.087,0.088l-1.044,0.926c-0.02,0.018-0.04,0.034-0.061,0.05 l-1.079,0.803c-0.045,0.033-0.092,0.062-0.142,0.087l-3.278,1.623c-0.026,0.013-0.053,0.025-0.08,0.035l-1.484,0.567 c-0.031,0.012-0.062,0.022-0.094,0.03l-3.621,0.957c-0.077,0.02-0.157,0.031-0.237,0.031c-0.008,0-0.016,0-0.023,0l-1.12-0.028 c-0.054-0.001-0.107-0.007-0.159-0.018l-0.891-0.179c-0.139-0.028-0.269-0.087-0.382-0.174l-2.519-1.937 c-0.021-0.016-0.041-0.033-0.06-0.05l-0.543-0.495l-0.262-0.059l-0.32,1.244l1.511,3.328c0.061,0.135,0.089,0.282,0.082,0.429 l-0.037,0.727c-0.009,0.174-0.066,0.341-0.166,0.484l-0.279,0.4l-0.103,0.329c-0.005,0.016-0.011,0.033-0.017,0.049l-0.655,1.74 c-0.014,0.038-0.031,0.074-0.05,0.11l-0.628,1.176c-0.094,0.177-0.243,0.318-0.425,0.403l-0.335,0.157l-0.275,0.35l0.038,0.267 l0.098,0.294c0.02,0.06,0.034,0.123,0.042,0.186l0.035,0.302c0.021,0.182-0.012,0.365-0.095,0.528l-0.123,0.241 c-0.069,0.135-0.17,0.252-0.295,0.339l-0.332,0.232c-0.065,0.045-0.135,0.082-0.21,0.11l-0.634,0.234 c-0.041,0.015-0.082,0.027-0.125,0.036l-0.677,0.146c-0.064,0.014-0.13,0.021-0.196,0.021c-0.055,0-0.111-0.005-0.166-0.015 l-0.798-0.145l-0.724,0.004c-0.002,0-0.004,0-0.005,0c-0.048,0-0.096-0.004-0.144-0.011l-0.706-0.111 c-0.109-0.017-0.214-0.053-0.31-0.107l-0.427-0.24l-0.297-0.066l-0.164,0.086l-0.42,0.56l0.047,1.74l0.153,1.324 c0.014,0.121,0.004,0.244-0.03,0.362L115.712,485.517z").attr({id: 'huila', class: 'st24', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#93DBD1'}).data({'id': 'huila', 'region':'Huila', 'benefited-companies':'4', 'benefited-projects': '$120.000.000'});

        var guaviare = rsr.path("M372.542,457.282l0.586-0.463c0.067-0.053,0.141-0.096,0.22-0.129l16.405-6.787l-2.568-1.583 l-0.514-0.104l-0.447-0.012l-0.231,0.255c-0.152,0.169-0.362,0.275-0.588,0.3l-0.395,0.043c-0.033,0.004-0.066,0.005-0.099,0.005 c-0.278,0-0.544-0.126-0.721-0.345l-0.018-0.022c-0.024,0.146-0.083,0.285-0.173,0.405l-0.304,0.405 c-0.05,0.067-0.11,0.127-0.176,0.178l-1.907,1.465c-0.163,0.126-0.362,0.192-0.564,0.192c-0.073,0-0.146-0.009-0.219-0.026 l-0.262-0.064c-0.334-0.081-0.596-0.341-0.68-0.675l-0.118-0.473c-0.003-0.013-0.006-0.027-0.009-0.041l-0.282,0.192 c-0.035,0.023-0.071,0.045-0.108,0.063l-0.658,0.328c-0.067,0.034-0.138,0.059-0.212,0.075l-0.742,0.165 c-0.066,0.015-0.134,0.022-0.201,0.022c-0.134,0-0.268-0.029-0.391-0.087l-0.446-0.208c-0.18-0.084-0.328-0.223-0.423-0.397 l-0.437-0.804l-0.279-0.185l-0.185,0.004l-1.012,0.491c-0.127,0.062-0.266,0.093-0.404,0.093c-0.13,0-0.259-0.027-0.38-0.082 c-0.25-0.113-0.438-0.33-0.512-0.594l-0.039-0.139c-0.174,0.158-0.397,0.24-0.622,0.24c-0.178,0-0.358-0.052-0.515-0.157 l-0.407-0.273c-0.089-0.06-0.167-0.134-0.23-0.22c-0.012,0.117-0.046,0.231-0.101,0.335l-0.205,0.391 c-0.097,0.184-0.253,0.33-0.443,0.415l-0.302,0.135c-0.121,0.054-0.249,0.08-0.377,0.08c-0.22,0-0.437-0.078-0.609-0.229 l-0.257-0.224c-0.175-0.153-0.287-0.367-0.312-0.599l-0.043-0.397c-0.011-0.101-0.005-0.203,0.017-0.302l0.078-0.349l-0.218-0.059 l-0.689-0.07c-0.141-0.014-0.277-0.061-0.397-0.136l-0.529-0.331l-0.674,0.135l-0.842,0.202c-0.071,0.017-0.143,0.025-0.215,0.025 c-0.137,0-0.274-0.031-0.4-0.091l-0.693-0.332c-0.034,0.025-0.07,0.047-0.107,0.067l-0.428,0.23 c-0.136,0.073-0.287,0.111-0.439,0.111c-0.067,0-0.134-0.007-0.2-0.022l-0.481-0.106c-0.147-0.032-0.283-0.1-0.398-0.197 l-0.427-0.361l-0.183-0.121l-1.188,0.885c-0.079,0.059-0.167,0.105-0.26,0.136l-0.542,0.181c-0.095,0.032-0.194,0.048-0.293,0.048 c-0.012,0-0.024,0-0.036-0.001l-0.458-0.018c-0.144-0.006-0.285-0.045-0.412-0.114l-0.496-0.274l-0.221-0.077l-0.652-0.006 c-0.185-0.002-0.365-0.058-0.517-0.163l-0.412-0.284c-0.111-0.076-0.203-0.176-0.272-0.291l-0.177-0.298l-0.02,0.087 c-0.022,0.092-0.057,0.181-0.105,0.262l-0.271,0.457c-0.121,0.203-0.314,0.352-0.541,0.417l-0.382,0.11 c-0.084,0.024-0.17,0.036-0.256,0.036c-0.241,0-0.477-0.095-0.653-0.27l-0.192-0.191l-0.167,0.37 c-0.125,0.276-0.377,0.474-0.675,0.529l-0.555,0.103c-0.056,0.01-0.112,0.016-0.169,0.016c-0.129,0-0.258-0.027-0.377-0.08 l-0.858-0.383c-0.043-0.019-0.085-0.042-0.124-0.067l-1.026-0.661l-0.182,0.3c-0.124,0.204-0.322,0.352-0.552,0.413l-0.583,0.156 c-0.078,0.021-0.159,0.031-0.239,0.031c-0.096,0-0.192-0.015-0.284-0.045l-0.943-0.304l-0.696-0.131l-1.043,0.154 c-0.041,0.006-0.083,0.009-0.125,0.01l-0.501,0.006l-0.095,0.029l-0.158,0.202c-0.022,0.028-0.045,0.054-0.07,0.08l-0.494,0.501 c-0.079,0.08-0.172,0.145-0.275,0.192l-1.958,0.894c-0.121,0.055-0.253,0.084-0.385,0.084c-0.052,0-0.104-0.004-0.156-0.013 l-0.96-0.164c-0.306-0.052-0.566-0.255-0.692-0.539l-0.222-0.503c-0.018-0.042-0.034-0.084-0.046-0.128l-0.276,0.137 c-0.129,0.064-0.27,0.097-0.412,0.097c-0.088,0-0.176-0.012-0.262-0.038l-0.674-0.199c-0.145-0.043-0.278-0.12-0.386-0.226 l-0.671-0.656c-0.002,0.058-0.01,0.116-0.023,0.172l-0.188,0.822c-0.031,0.134-0.091,0.26-0.176,0.367l-0.373,0.473 c-0.18,0.229-0.451,0.353-0.728,0.353c-0.14,0-0.281-0.032-0.413-0.098l-0.471-0.235c-0.24-0.12-0.416-0.338-0.483-0.598 l-0.22-0.854l-0.271,0.324c-0.085,0.101-0.19,0.183-0.308,0.24l-0.992,0.478c-0.073,0.035-0.15,0.061-0.229,0.076l-3.943,0.749 l-0.636,0.112c-0.097,0.087-0.212,0.153-0.336,0.193l-0.255,0.082c-0.04,0.013-0.081,0.023-0.122,0.03l-0.566,0.099l-0.592,0.17 c-0.083,0.024-0.17,0.036-0.256,0.036c-0.021,0-0.041-0.001-0.062-0.002l-0.565-0.038c-0.276-0.018-0.529-0.159-0.69-0.383 c-0.155-0.028-0.305-0.096-0.434-0.205l-0.303-0.257l-1.455-0.123c-0.054-0.005-0.108-0.014-0.161-0.028l-1.062-0.284 c-0.117-0.031-0.227-0.085-0.323-0.158l-0.655-0.5c-0.1-0.077-0.184-0.173-0.246-0.283l-0.442-0.788l-0.034-0.012l-0.674,0.212 c-0.039,0.012-0.078,0.022-0.118,0.029l-1.628,0.285l-0.08,0.04l-0.041,0.115l0.035,0.613l0.164,0.708 c0.019,0.083,0.027,0.168,0.023,0.252l-0.053,1.12c-0.015,0.326-0.201,0.62-0.489,0.773c-0.136,0.073-0.286,0.109-0.436,0.109 c-0.099,0-0.198-0.016-0.293-0.048l-0.301-0.037l-0.317,0.085l-0.454,0.246l-0.251,0.178l0.019,0.099 c0.011,0.056,0.016,0.113,0.016,0.17l0.001,0.95c0,0.063-0.006,0.126-0.019,0.188l-0.18,0.874 c-0.073,0.356-0.347,0.636-0.702,0.717c-0.068,0.016-0.137,0.023-0.206,0.023c-0.285,0-0.56-0.132-0.737-0.365l-0.192-0.253 c-0.057-0.075-0.102-0.158-0.134-0.246l-0.478-1.324l-0.198,0.655c-0.082,0.272-0.284,0.491-0.549,0.595 c-0.109,0.043-0.224,0.064-0.338,0.064c-0.163,0-0.325-0.043-0.469-0.127l-1.527-0.895l-0.212,0.018l-1.569,1.379 c-0.045,0.039-0.093,0.074-0.145,0.105l-0.73,0.425c-0.084,0.049-0.174,0.084-0.269,0.105l-0.825,0.18 c-0.045,0.01-0.09,0.016-0.135,0.019l-1.432,0.096l-0.155,0.068l-0.968,0.78c-0.165,0.133-0.37,0.205-0.581,0.205 c-0.003,0-0.006,0-0.009,0l-0.248-0.002c-0.039,0-0.078-0.003-0.117-0.009v0.164c0,0.506-0.406,0.918-0.911,0.926l-0.805,0.013 l-0.063,0.062l-0.093,0.601l0.001,1.232c0,0.307-0.152,0.595-0.406,0.767c-0.156,0.106-0.337,0.16-0.52,0.16 c-0.116,0-0.233-0.022-0.343-0.066l-0.503-0.201c-0.075-0.03-0.146-0.07-0.211-0.118l-0.149-0.111 c-0.122-0.091-0.217-0.209-0.28-0.34l-0.125,0.699c-0.061,0.341-0.307,0.619-0.637,0.721l-0.458,0.142 c-0.09,0.028-0.182,0.041-0.274,0.041c-0.163,0-0.326-0.043-0.469-0.128l-0.285-0.168c-0.17-0.1-0.304-0.252-0.382-0.434 l-0.149-0.347c-0.027-0.064-0.048-0.131-0.06-0.2l-0.18-0.998l-0.839,0.164l-0.188,0.174l-0.328,0.793 c-0.037,0.089-0.087,0.172-0.149,0.245l-0.611,0.72c-0.178,0.21-0.438,0.327-0.706,0.327c-0.076,0-0.152-0.009-0.228-0.028 l-1.146-0.291c-0.227-0.057-0.423-0.199-0.55-0.395l-0.32-0.495l-0.272-0.195c-0.089-0.064-0.165-0.142-0.226-0.233l-0.192-0.283 l-0.472,0.148l-3.646,2.076l-0.224,0.367l-0.22,0.469c-0.086,0.184-0.231,0.334-0.411,0.428l-0.328,0.171l0.099,0.126 c0.053,0.068,0.096,0.143,0.129,0.223l0.175,0.432c0.082,0.203,0.09,0.429,0.021,0.637l-0.132,0.402 c-0.105,0.32-0.376,0.557-0.706,0.62l-0.734,0.14l-0.128,0.123l-0.255,0.389c-0.092,0.14-0.22,0.252-0.37,0.326l-0.712,0.346 l-0.884,0.7c-0.032,0.025-0.066,0.048-0.101,0.069l-0.63,0.375c-0.144,0.086-0.308,0.131-0.474,0.131 c-0.053,0-0.106-0.005-0.159-0.014l-0.445-0.078c-0.154-0.027-0.299-0.093-0.421-0.191l-0.022-0.017l-0.375,0.122l-0.762,0.586 l-0.619,0.581c-0.102,0.095-0.223,0.166-0.356,0.208l-0.301,0.094c-0.091,0.028-0.184,0.043-0.277,0.043 c-0.161,0-0.32-0.042-0.462-0.123l-0.009-0.005l-0.202,0.373c-0.096,0.178-0.249,0.32-0.434,0.404l-0.445,0.201 c-0.101,0.046-0.21,0.073-0.321,0.08l-0.401,0.026c-0.02,0.001-0.04,0.002-0.06,0.002c-0.199,0-0.393-0.064-0.553-0.184 l-0.364-0.272c-0.173-0.129-0.295-0.314-0.347-0.524l-0.013-0.055l-0.649,0.091c-0.043,0.006-0.086,0.009-0.129,0.009 c-0.119,0-0.238-0.023-0.349-0.068l-0.37-0.151l-0.332,0.172c0.009,0.048,0.014,0.097,0.015,0.147l0.009,0.378 c0.008,0.305-0.135,0.593-0.382,0.772l-0.413,0.3c-0.14,0.101-0.305,0.162-0.477,0.174l-1.065,0.078l-0.731,0.16 c-0.066,0.014-0.132,0.022-0.199,0.022c-0.107,0-0.213-0.018-0.315-0.055l-0.706-0.255c-0.001,0.001-0.003,0.003-0.004,0.004 l-0.282,0.321c-0.116,0.132-0.266,0.228-0.434,0.278l-0.353,0.104c-0.087,0.025-0.175,0.038-0.262,0.038 c-0.297,0-0.581-0.143-0.757-0.393c-0.175,0.225-0.445,0.357-0.731,0.357c-0.034,0-0.068-0.002-0.102-0.006l-0.257-0.028 c-0.303-0.033-0.57-0.214-0.715-0.483l-0.08-0.148l-0.097,0.002l-0.079,0.077c-0.022,0.022-0.046,0.042-0.07,0.062l-0.315,0.25 c-0.165,0.132-0.369,0.201-0.576,0.201c-0.074,0-0.148-0.009-0.221-0.027l-0.211-0.052c-0.259-0.064-0.478-0.236-0.601-0.473 l-0.103-0.2c-0.05,0.008-0.101,0.013-0.152,0.013c-0.075,0-0.151-0.009-0.226-0.028l-0.328-0.083 c-0.133-0.033-0.257-0.096-0.362-0.183l-0.138-0.114l-0.037-0.009l-1.311,0.171c-0.04,0.005-0.08,0.008-0.12,0.008 c-0.267,0-0.523-0.115-0.7-0.32l-0.248-0.286c-0.043-0.049-0.08-0.103-0.112-0.16l-0.232-0.422l-0.786,0.492 c-0.068,0.043-0.142,0.076-0.219,0.1l-0.499,0.153c-0.088,0.027-0.18,0.041-0.272,0.041c-0.052,0-0.104-0.004-0.155-0.013 l-0.361-0.061c-0.206-0.035-0.394-0.138-0.533-0.294l-0.2-0.222c0.034,0.108,0.048,0.221,0.041,0.334l-0.023,0.373 c-0.01,0.161-0.062,0.318-0.15,0.453l-0.236,0.359c-0.02,0.03-0.042,0.06-0.065,0.088l-0.335,0.398l-0.32,0.734 c-0.039,0.089-0.091,0.171-0.155,0.243l-0.152,0.172l-0.211,1.494l0.1,5.76l-0.138,22.126c-0.001,0.208-0.072,0.409-0.202,0.572 l-0.334,0.419l0.228,0.758c0.014,0.047,0.025,0.096,0.031,0.145l0.053,0.405l4.452,6.474l0.639,0.646l2.273,1.756 c0.053,0.041,0.101,0.087,0.144,0.138l0.63,0.753c0.04,0.047,0.074,0.099,0.104,0.153l0.659,1.216l0.612,0.784 c0.016,0.021,0.032,0.043,0.047,0.065l0.466,0.718c0.04,0.062,0.073,0.128,0.097,0.197l0.524,1.49 c0.021,0.06,0.036,0.123,0.045,0.186l0.081,0.616c0.005,0.034,0.007,0.069,0.008,0.103l0.019,0.982l0.119,0.762l2.108,2.375 l4.556,4.022c0.044,0.039,0.085,0.082,0.121,0.129l1.044,1.356l1.387,0.413c0.093,0.028,0.182,0.07,0.262,0.125l0.527,0.364 c0.114,0.078,0.208,0.181,0.277,0.3l0.315,0.547c0.024,0.041,0.044,0.083,0.061,0.128l0.21,0.542l0.343,0.459l0.686,0.526 l0.875,0.511l2.15,0.706l0.703-0.013l0.514-0.069l0.493-0.183l0.486-0.316l0.238-0.191l0.615-0.935 c0.055-0.084,0.124-0.158,0.203-0.22l0.942-0.739l0.882-0.979c0.022-0.025,0.046-0.048,0.07-0.07l0.706-0.632 c0.075-0.067,0.16-0.121,0.253-0.161l1.36-0.584l0.356-0.215l0.117-0.236l0.118-0.432l0.015-0.298l-0.156-0.773 c-0.021-0.105-0.024-0.213-0.008-0.318l0.075-0.512c0.013-0.091,0.04-0.18,0.08-0.263l0.319-0.671l0.132-0.672 c0.007-0.035,0.016-0.069,0.026-0.103l0.135-0.423c0.033-0.104,0.084-0.201,0.151-0.287l0.579-0.746 c0.078-0.101,0.177-0.184,0.289-0.245l0.347-0.189c0.085-0.046,0.176-0.079,0.271-0.097l0.367-0.069l0.037-0.011l0.008-0.026 c0.079-0.274,0.279-0.496,0.544-0.603l0.339-0.137c0.111-0.045,0.228-0.067,0.346-0.067c0.096,0,0.192,0.015,0.285,0.045 l0.583,0.188c0.074,0.024,0.146,0.057,0.212,0.099l0.721,0.458c0.09,0.057,0.169,0.13,0.235,0.214l0.4,0.515l0.26-0.408 l0.012-0.217c0.023-0.435,0.346-0.794,0.776-0.864l1.046-0.17l0.515-0.117c0.067-0.015,0.136-0.023,0.204-0.023 c0.115,0,0.23,0.021,0.339,0.064l1.485,0.583c0.053,0.021,0.105,0.047,0.153,0.077l0.704,0.441 c0.041,0.026,0.081,0.055,0.118,0.087l1.256,1.098l3.587,2.307l0.907,0.281l1.451,0.204c0.097,0.014,0.191,0.042,0.279,0.085 l0.592,0.29c0.081,0.04,0.156,0.091,0.223,0.153l2.1,1.95c0.058,0.054,0.108,0.114,0.151,0.18l0.479,0.75 c0.058,0.091,0.1,0.192,0.123,0.297l0.189,0.85c0.01,0.047,0.017,0.094,0.02,0.142l0.087,1.355l0.117,0.578l0.105,0.257 l0.102,0.068l0.456,0.044c0.08,0.008,0.159,0.026,0.234,0.054l0.629,0.234c0.24,0.089,0.432,0.274,0.531,0.51l0.359,0.854 c0.036,0.085,0.059,0.175,0.068,0.267l0.08,0.803c0.165-0.147,0.378-0.23,0.601-0.234l0.316-0.005c0.005,0,0.01,0,0.014,0 c0.388,0,0.736,0.242,0.869,0.607l0.347,0.946c0.046,0.126,0.065,0.261,0.053,0.396l-0.057,0.684 c-0.004,0.053-0.013,0.105-0.027,0.157l-0.189,0.726l-0.016,0.269l0.016,0.018l1.063,0.346c0.136,0.044,0.259,0.119,0.361,0.219 l0.425,0.415c0.081,0.079,0.147,0.172,0.194,0.275l0.775,1.684l2.706,0.191c0.046,0.003,0.093,0.01,0.138,0.02l0.84,0.189 c0.043,0.01,0.085,0.022,0.127,0.038l2.092,0.797c0.079,0.03,0.153,0.071,0.221,0.121l0.377,0.279 c0.099,0.073,0.183,0.166,0.246,0.272l0.238,0.401c0.045,0.076,0.079,0.157,0.101,0.243l0.11,0.428l0.043,0.108l1.225,0.15 l8.258-8.626c0.029-0.03,0.059-0.058,0.091-0.083l1.355-1.081l1.279-1.344l0.272-0.463l0.271-0.715 c0.024-0.062,0.054-0.122,0.09-0.178l0.699-1.071c0.053-0.081,0.118-0.154,0.194-0.215l0.643-0.519 c0.112-0.09,0.243-0.154,0.384-0.184l0.82-0.179c0.065-0.014,0.131-0.021,0.198-0.021c0.044,0,0.087,0.003,0.131,0.009l0.711,0.101 c0.074,0.01,0.146,0.03,0.215,0.058l0.47,0.189l0.178,0.015l0.143-0.045l1.873-1.962c0.036-0.038,0.075-0.073,0.117-0.104 l0.73-0.543l0.349-0.501l0.478-0.926l0.025-0.189l-0.033-0.364c-0.004-0.046-0.005-0.092-0.002-0.138l0.03-0.498 c0.006-0.095,0.026-0.189,0.06-0.277l0.165-0.43c0.077-0.201,0.221-0.368,0.408-0.474l0.326-0.184 c0.071-0.04,0.146-0.07,0.224-0.091l0.068-0.539c0.025-0.201,0.116-0.388,0.258-0.532l0.257-0.262 c0.134-0.136,0.306-0.228,0.494-0.263l0.015-0.003l-0.026-0.06l-0.634-1.098c-0.092-0.16-0.135-0.344-0.122-0.529l0.039-0.541 l-0.045-0.985c-0.002-0.038-0.001-0.076,0.002-0.115l0.035-0.448c0.003-0.036,0.008-0.071,0.015-0.106l0.086-0.439 c0.038-0.193,0.136-0.368,0.28-0.502l0.238-0.22l2.003-4.77l0.338-1.162l0.226-1.158c0.019-0.099,0.055-0.194,0.104-0.281 l0.52-0.912l0.923-2.165l0.381-1.503c0.016-0.063,0.039-0.124,0.068-0.183l0.365-0.737c0.03-0.06,0.066-0.117,0.108-0.17 l1.148-1.428l0.213-0.772l0.172-1.156l0.192-3.791c0.021-0.42,0.322-0.772,0.733-0.859l0.726-0.153 c0.064-0.013,0.128-0.02,0.192-0.02c0.204,0,0.404,0.067,0.568,0.194l1.186,0.92l1.428,0.512c0.144,0.052,0.273,0.138,0.375,0.252 l0.725,0.804l0.152,0.051l0.427,0.066l0.456-0.302l0.89-0.722l0.763-0.806c0.037-0.039,0.076-0.074,0.119-0.106l2.177-1.622 c0.038-0.028,0.078-0.054,0.12-0.076l3.752-1.988c0.037-0.02,0.076-0.037,0.116-0.052l2.28-0.832l1.425-0.767l1.044-0.698 l1.731-1.713l0.657-0.924c0.089-0.126,0.208-0.227,0.346-0.295l0.332-0.163c0.127-0.063,0.267-0.095,0.409-0.095 c0.022,0,0.045,0.001,0.067,0.002l0.361,0.026c0.061,0.004,0.121,0.015,0.18,0.031l0.256,0.071l4.06-0.13c0.01,0,0.02,0,0.03,0 c0.029,0,0.057,0.001,0.086,0.004l1.601,0.149l0.407-0.098c0.072-0.017,0.145-0.026,0.218-0.026c0.111,0,0.222,0.02,0.327,0.06 l0.435,0.164l0.475,0.116c0.088,0.021,0.172,0.056,0.249,0.101l0.353,0.208l0.336,0.108l0.458,0.046l0.575-0.033l0.594-0.106 l1.28-0.694c0.074-0.04,0.154-0.07,0.236-0.089l2.969-0.674l0.882-0.343c0.05-0.019,0.101-0.034,0.153-0.045l1.618-0.326 l0.412-0.201l0.315-0.229l0.659-0.624c0.063-0.059,0.134-0.11,0.211-0.15l0.779-0.404c0.091-0.047,0.19-0.079,0.292-0.094 l1.829-0.269c0.042-0.006,0.084-0.009,0.126-0.01l0.581-0.006l0.301-0.129c0.116-0.05,0.24-0.075,0.366-0.075 c0.002,0,0.004,0,0.005,0l0.765,0.004l0.745-0.094l1.512-0.525c0.029-0.01,0.058-0.019,0.087-0.026l2.041-0.491 c0.034-0.008,0.069-0.015,0.104-0.019l2.511-0.307l0.587-0.261l0.443-0.322l1.013-0.995c0.037-0.036,0.077-0.07,0.12-0.099 l1.618-1.128l0.049-0.535c0.022-0.243,0.139-0.467,0.326-0.624l1.364-1.148c0.033-0.028,0.067-0.053,0.104-0.076l1.687-1.059 l0.259-0.325c0.068-0.085,0.15-0.157,0.242-0.214l0.883-0.539l0.039-0.113l-0.876-0.961c-0.042-0.046-0.079-0.096-0.111-0.149 l-0.684-1.146l-0.213-0.142l-0.239,0.179c-0.085,0.064-0.18,0.113-0.282,0.144l-0.707,0.22c-0.089,0.028-0.182,0.042-0.275,0.042 c-0.016,0-0.031,0-0.047-0.001l-1.223-0.062c-0.095,0.219-0.273,0.395-0.497,0.487l-0.275,0.113 c-0.112,0.046-0.232,0.07-0.352,0.07c-0.051,0-0.102-0.004-0.152-0.013l-0.219-0.036l-0.239,0.038l-1.31,0.368 c-0.076,0.021-0.155,0.033-0.234,0.034l-1.073,0.019c-0.005,0-0.011,0-0.017,0c-0.114,0-0.228-0.021-0.334-0.062l-0.476-0.184 c-0.11-0.043-0.211-0.106-0.298-0.187l-0.203-0.19l-0.163,0.015l-0.706,0.237c-0.09,0.03-0.185,0.047-0.281,0.048l-0.169,0.003 c-0.007,0.058-0.02,0.116-0.039,0.172l-0.139,0.425c-0.077,0.235-0.245,0.43-0.467,0.54l-0.46,0.229 c-0.13,0.065-0.271,0.097-0.413,0.097c-0.122,0-0.245-0.024-0.36-0.073l-0.616-0.26c-0.038-0.016-0.076-0.035-0.111-0.056 l-0.865-0.511l-0.332-0.01c-0.086-0.002-0.171-0.017-0.253-0.043l-2.335-0.741l-0.407-0.021l-0.437,0.115l-0.469,0.169l-0.208,0.15 c-0.118,0.085-0.254,0.141-0.397,0.164l-1.678,0.267c-0.048,0.008-0.097,0.011-0.145,0.011c-0.205,0-0.407-0.068-0.571-0.197 c-0.203-0.158-0.33-0.394-0.352-0.65l-0.056-0.654l-0.084-0.112l-0.081-0.039l-0.15-0.013c-0.064-0.006-0.127-0.018-0.188-0.037 l-0.946-0.288l-2.286-0.628c-0.105-0.029-0.204-0.076-0.293-0.14l-0.842-0.602c-0.041-0.029-0.079-0.062-0.115-0.097l-0.599-0.598 c-0.085-0.084-0.152-0.184-0.199-0.294l-0.575-1.354l-1.823-3.569l-2.159-3.068l-0.852-0.834l-0.783-0.453l-1.004-0.273 c-0.063-0.017-0.125-0.041-0.183-0.071l-2.218-1.149l-2.507-0.817c-0.135-0.044-0.259-0.119-0.361-0.219l-0.439-0.43 c-0.2-0.196-0.301-0.471-0.274-0.75l0.039-0.406C372.219,457.669,372.344,457.438,372.542,457.282z").attr({id: 'guaviare', class: 'st25', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#7D72A5'}).data({'id': 'guaviare', 'region':'Guaviare', 'benefited-companies':'1', 'benefited-projects': '$20.000.000'});

        var sucre = rsr.path("M188.288,187.374l0.633,0.032c0.203,0.01,0.398,0.088,0.553,0.219l0.896,0.762l1.683,1.285 c0.092,0.071,0.171,0.158,0.231,0.258l1.223,2.027l0.898,0.863l0.559,0.418c0.042,0.031,0.081,0.066,0.117,0.103l0.579,0.608 c0.091,0.096,0.161,0.21,0.204,0.334l0.244,0.702c0.036,0.103,0.053,0.211,0.051,0.319l-0.022,1.351l0.036-0.024l0.919-0.78 c0.093-0.079,0.2-0.138,0.315-0.176l0.466-0.15c0.092-0.03,0.188-0.045,0.284-0.045c0.027,0,0.054,0.001,0.082,0.004l1.47,0.13 l1.003-0.057l0.811-0.271l0.76-0.528l0.523-0.601l0.373-0.829l0.133-1.017c0.011-0.082,0.033-0.163,0.065-0.24l0.148-0.352 c0.115-0.274,0.355-0.475,0.645-0.542l0.17-0.039c0.069-0.016,0.139-0.024,0.209-0.024c0.112,0,0.223,0.02,0.328,0.06l0.286,0.108 l0.039,0.004l0.595-1.599l0.075-0.326l-0.065-0.598l-0.395-1.53c-0.012-0.045-0.02-0.091-0.025-0.138l-0.136-1.329 c-0.004-0.035-0.005-0.071-0.005-0.107l0.012-0.893l-0.181-0.169c-0.105-0.099-0.186-0.221-0.236-0.356l-0.511-1.387 c-0.022-0.06-0.038-0.122-0.047-0.185l-0.786-5.325c-0.025-0.17-0.002-0.343,0.065-0.501l0.417-0.968 c0.056-0.13,0.141-0.246,0.249-0.338l1.041-0.89l0.506-0.95c0.051-0.095,0.117-0.18,0.197-0.252l0.202-0.182l-0.526-0.533 c-0.042-0.043-0.08-0.09-0.113-0.14l-2.274-3.44l-2.048-2.285l-4.209-3.228l-1.125-0.441c-0.059-0.023-0.115-0.052-0.167-0.086 l-1.957-1.274c-0.134-0.087-0.243-0.207-0.317-0.349l-0.861-1.657l-0.772-1.557l-0.579-0.494l-0.313-0.148 c-0.063-0.03-0.122-0.066-0.177-0.109l-0.478-0.377c-0.106-0.083-0.192-0.189-0.253-0.308l-0.217-0.428 c-0.04-0.078-0.068-0.162-0.084-0.248l-0.123-0.653c-0.009-0.049-0.014-0.099-0.016-0.149l-0.012-0.515l-0.396-1.805l-0.568-1.225 c-0.026-0.055-0.046-0.113-0.06-0.173l-0.209-0.866c-0.011-0.046-0.019-0.092-0.023-0.139l-0.046-0.542 c-0.009-0.112,0.001-0.225,0.032-0.333l0.124-0.435l-0.156-0.204c-0.182-0.237-0.238-0.547-0.151-0.832l0.143-0.471 c0.011-0.038,0.025-0.074,0.041-0.11l0.946-2.111c0.014-0.031,0.03-0.061,0.047-0.091l0.379-0.644l-0.84-0.582 c-0.078-0.054-0.147-0.12-0.205-0.195l-0.103-0.134l-0.147,0.06c-0.043,0.018-0.086,0.032-0.131,0.043l-1.025,0.252 c-0.073,0.018-0.147,0.027-0.221,0.027c-0.053,0-0.107-0.005-0.159-0.014l-0.924-0.161c-0.075-0.013-0.148-0.036-0.218-0.067 l-0.71-0.317c-0.097-0.043-0.186-0.103-0.263-0.176l-0.312-0.298c-0.123-0.117-0.211-0.266-0.254-0.43l-0.104-0.388 c-0.054-0.202-0.038-0.416,0.045-0.607l0.536-1.24l-0.214-0.056l-1.244-0.036c-0.178-0.005-0.35-0.061-0.497-0.162l-0.536-0.367 c-0.034-0.023-0.066-0.049-0.097-0.077l-1.932-1.746c-0.035-0.032-0.068-0.066-0.098-0.103l-0.895-1.102l-1.651-1.352l-0.426-0.177 l-0.244-0.023l-0.406,0.102c-0.074,0.018-0.149,0.028-0.225,0.028c-0.035,0-0.071-0.002-0.106-0.006l-0.622-0.072 c-0.157-0.018-0.307-0.076-0.436-0.169l-1.246-0.899l-0.593-0.207l-0.325-0.033l-0.185,0.08l-0.187,0.21 c-0.023,0.026-0.048,0.051-0.074,0.075l-0.783,0.701c-0.173,0.155-0.394,0.236-0.618,0.236c-0.114,0-0.229-0.021-0.339-0.064 l-0.416-0.164l-0.401,0.382c-0.177,0.168-0.407,0.256-0.639,0.256c-0.153,0-0.307-0.038-0.448-0.116 c-0.354-0.196-0.54-0.599-0.459-0.995l0.418-2.051c0.022-0.108,0.063-0.212,0.122-0.306l0.255-0.408l0.075-0.428l0.042-0.793 c0.003-0.053,0.01-0.105,0.022-0.157l0.191-0.838c0.006-0.028,0.014-0.056,0.023-0.083l0.45-1.37l0.081-0.496l-0.171-0.971 c-0.023-0.132-0.018-0.267,0.016-0.396l0.383-1.46c0.008-0.032,0.019-0.064,0.03-0.095l0.013-0.034 c-0.135,0.073-0.286,0.11-0.438,0.11c-0.054,0-0.107-0.005-0.161-0.014l-0.632-0.111c-0.047-0.008-0.093-0.02-0.138-0.036 l-3.647-1.244c-0.034-0.012-0.068-0.025-0.101-0.041l-1.062-0.508c-0.166-0.079-0.305-0.206-0.398-0.365l-0.293-0.496 c-0.116-0.196-0.155-0.427-0.111-0.65l0.087-0.442c0.027-0.138,0.086-0.268,0.17-0.38l0.603-0.795l0.059-0.159l-0.002-0.054 l-0.31-0.71c-0.03-0.069-0.052-0.142-0.065-0.217l-0.093-0.555c-0.007-0.041-0.011-0.083-0.012-0.126l-0.017-0.563l-0.362,0.123 c-0.096,0.033-0.197,0.049-0.298,0.049c-0.01,0-0.02,0-0.031-0.001l-0.656-0.022c-0.131-0.004-0.26-0.036-0.377-0.094l-0.432-0.212 c-0.232-0.114-0.406-0.319-0.48-0.566l-0.131-0.438l-0.003,0.039c-0.004,0.05-0.011,0.099-0.023,0.148l-0.601,2.528l0.017,0.84 c0.001,0.068-0.005,0.136-0.018,0.203l-0.19,0.936c-0.007,0.034-0.016,0.067-0.026,0.1l-0.503,1.559 c-0.011,0.034-0.024,0.067-0.038,0.099l-0.553,1.217l-0.225,0.786l0.031,0.92c0.003,0.102-0.01,0.204-0.04,0.301l-0.78,2.553 l-0.435,1.271c-0.045,0.132-0.119,0.252-0.217,0.351l-0.816,0.827c0.078,0.02,0.153,0.051,0.224,0.09l0.476,0.27 c0.037,0.021,0.072,0.044,0.105,0.069l0.371,0.283l0.401-0.003c0.002,0,0.005,0,0.007,0c0.335,0,0.645,0.181,0.808,0.474 l0.441,0.788l0.202,0.178c0.035,0.031,0.068,0.064,0.098,0.1l0.567,0.673c0.066,0.078,0.118,0.166,0.155,0.261l0.495,1.275 c0.043,0.111,0.064,0.229,0.063,0.348l-0.036,2.726c-0.001,0.086-0.014,0.172-0.039,0.255l-0.886,2.939 c-0.016,0.054-0.038,0.107-0.064,0.158l-1.098,2.125c-0.053,0.103-0.125,0.195-0.212,0.271l-1.736,1.523 c-0.022,0.019-0.045,0.038-0.069,0.055l-0.638,0.461c-0.16,0.115-0.35,0.175-0.542,0.175c-0.081,0-0.163-0.011-0.243-0.033 l-0.017-0.005l-0.014,1.049l0.585,0.209c0.08,0.028,0.155,0.068,0.224,0.117l0.228,0.162l1.229,0.296 c0.068,0.016,0.133,0.04,0.196,0.071l2.413,1.199c0.123,0.061,0.232,0.15,0.317,0.258l0.645,0.824l0.593,0.662l1.409,0.306 c0.276,0.06,0.509,0.242,0.634,0.495c0.002,0,0.003,0,0.005,0.001l0.595,0.075c0.115,0.015,0.226,0.05,0.327,0.106l0.783,0.428 c0.25,0.136,0.423,0.38,0.47,0.66l0.302,1.804l1.019,1.562l7.705,3.601c0.052,0.025,0.102,0.054,0.149,0.088l1.982,1.429 c0.371,0.267,0.491,0.766,0.283,1.173l-0.232,0.453l0.716,0.999c0.029,0.041,0.056,0.085,0.078,0.13l0.138,0.281 c0.143,0.29,0.124,0.633-0.049,0.906l-0.194,0.305c-0.017,0.027-0.035,0.053-0.055,0.078l-0.136,1.937 c-0.02,0.281-0.167,0.538-0.399,0.698l-0.511,0.351c-0.083,0.057-0.174,0.1-0.27,0.127l-2.284,0.652 c-0.053,0.015-0.107,0.025-0.161,0.031l-0.577,0.058l-0.276,0.097l-0.46,0.351l-0.891,0.889c-0.043,0.043-0.089,0.081-0.14,0.115 l-0.427,0.285l-0.26,0.221l-0.094,0.152l-0.117,1.376l0.821,2.697c0.047,0.154,0.053,0.319,0.017,0.476l-0.252,1.102l0.005,0.534 l0.087,0.873l0.865,2.863c0.026,0.085,0.039,0.173,0.04,0.262l0.012,1.919l0.237,2.189l0.23,0.622l0.243,0.421l0.264,0.279 l1.727,0.781c0.047,0.021,0.091,0.046,0.134,0.074l1.513,1.014c0.055,0.037,0.107,0.08,0.153,0.128l1.221,1.273l4.207-2.064 c0.049-0.024,0.1-0.044,0.153-0.059l1.947-0.558l2.483-0.906c0.079-0.029,0.162-0.047,0.247-0.053l1.028-0.079 c0.024-0.002,0.047-0.003,0.071-0.003C188.256,187.373,188.273,187.373,188.288,187.374z").attr({id: 'sucre', class: 'st26', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#D9FF8F'}).data({'id': 'sucre', 'region':'Sucre', 'benefited-companies':'1', 'benefited-projects': '$20.000.000'});

        var caldas = rsr.path("M200.504,314.029l-0.117-0.117l-0.073,0.021c-0.085,0.025-0.173,0.038-0.262,0.038 c-0.009,0-0.017,0-0.026,0c-0.021,0.081-0.053,0.159-0.096,0.231l-0.138,0.237l-0.13,0.342l-0.201,0.914 c-0.018,0.081-0.047,0.159-0.085,0.233l-0.569,1.079c-0.116,0.22-0.316,0.385-0.555,0.456l-1.531,0.455 c-0.086,0.026-0.175,0.038-0.264,0.038c-0.135,0-0.269-0.029-0.393-0.088l-0.454-0.213c-0.04-0.019-0.079-0.04-0.116-0.065 l-1.882-1.239c-0.044-0.029-0.085-0.061-0.123-0.097l-0.479-0.448c-0.033-0.031-0.063-0.064-0.091-0.099l-0.047-0.059l-0.545-0.153 l-0.84,0.154l-1.641,0.317l-2.527,0.738l-0.093,0.162c-0.022,0.038-0.046,0.075-0.073,0.109l-0.138,0.177l-0.119,0.22 c-0.027,0.05-0.058,0.097-0.094,0.141l-0.212,0.263c-0.025,0.031-0.052,0.06-0.081,0.088l-0.238,0.228 c-0.041,0.039-0.085,0.074-0.133,0.105l-0.326,0.213c-0.025,0.017-0.051,0.032-0.078,0.046l-0.566,0.296 c-0.04,0.021-0.081,0.039-0.123,0.054l-0.914,0.32c-0.071,0.025-0.145,0.041-0.219,0.048l-0.941,0.089l-0.038,0.379l0.05,1.178 l0.024,0.113c0.013,0.063,0.02,0.127,0.02,0.192v0.192c0,0.156-0.039,0.309-0.114,0.445l-0.387,0.705 c-0.034,0.062-0.075,0.12-0.122,0.172l-1.325,1.481l-0.006,0.066c-0.02,0.239-0.132,0.46-0.313,0.618l-0.138,0.121 c-0.06,0.053-0.127,0.098-0.199,0.133l-0.251,0.124c-0.1,0.049-0.208,0.081-0.319,0.092l-1.071,0.107l-0.055,0.014l-0.332,0.126 l-0.557,0.267l-0.866,0.562l-0.374,0.293l-0.146,0.146l-0.399,0.722c-0.018,0.032-0.037,0.062-0.058,0.092l-0.186,0.26 c-0.022,0.031-0.047,0.061-0.073,0.089l-0.148,0.16l-0.106,0.148l-0.497,0.835c-0.109,0.184-0.279,0.324-0.48,0.397l-0.294,0.107 c-0.036,0.013-0.072,0.024-0.11,0.032l-0.218,0.05c-0.069,0.016-0.138,0.023-0.207,0.023c-0.378,0-0.727-0.232-0.866-0.598 l-0.368-0.972l-0.346,0.134c-0.108,0.042-0.221,0.062-0.334,0.062c-0.204,0-0.405-0.067-0.57-0.196 c-0.257-0.2-0.389-0.521-0.349-0.844l0.195-1.572l-0.01-0.122l-0.079-0.411l-1.026-3.015l-0.137-0.208l-0.212-0.062 c-0.091-0.027-0.178-0.067-0.257-0.12l-0.319-0.214c-0.067-0.045-0.128-0.099-0.181-0.159l-0.467-0.533 c-0.111-0.127-0.185-0.282-0.215-0.448l-0.077-0.432c-0.018-0.101-0.019-0.205-0.003-0.306l0.07-0.443l0.041-0.687l-0.006-0.022 l-0.421-0.135c-0.042-0.014-0.084-0.03-0.124-0.05l-0.308-0.151c-0.047-0.023-0.092-0.05-0.134-0.08l-0.233-0.167 c-0.037-0.027-0.072-0.056-0.105-0.088l-1.597,0.866c-0.093,0.05-0.194,0.085-0.298,0.101l-0.272,0.043 c-0.047,0.007-0.095,0.011-0.143,0.011c-0.007,0-0.014,0-0.021,0l-0.464-0.011c-0.172-0.004-0.34-0.056-0.484-0.15l-0.202-0.132 l-1.631-0.628c-0.085-0.033-0.165-0.078-0.237-0.134l-0.242-0.189c-0.056-0.044-0.107-0.094-0.151-0.149l-0.172-0.213 c-0.083-0.103-0.143-0.222-0.176-0.35l-0.033-0.128l-0.005-0.012l-0.055-0.078c-0.04-0.057-0.074-0.119-0.1-0.184l-0.07-0.062 l-0.327-0.049c-0.066-0.01-0.131-0.027-0.193-0.05l-0.723-0.275v0.228l0.015,0.033l0.286,0.102c0.425,0.151,0.679,0.586,0.602,1.03 l-0.232,1.342l-0.007,0.461l0.679,2.385c0.014,0.048,0.023,0.097,0.029,0.147l0.11,0.947c0.006,0.055,0.008,0.111,0.004,0.167 l-0.059,0.911c-0.002,0.038-0.007,0.075-0.014,0.112l-0.205,1.086c-0.048,0.253-0.199,0.475-0.417,0.612 c-0.149,0.094-0.32,0.142-0.493,0.142c-0.08,0-0.16-0.01-0.239-0.031l-0.679-0.181c-0.018-0.005-0.036-0.01-0.054-0.016 l-0.357-0.119l-0.872,0.064c-0.023,0.002-0.046,0.003-0.068,0.003c-0.04,0-0.079-0.003-0.119-0.008l-0.887-0.115l-0.895,0.036 c-0.012,0.001-0.025,0.001-0.037,0.001c-0.072,0-0.143-0.008-0.213-0.025l-0.436-0.103c-0.174-0.041-0.332-0.131-0.455-0.26 l-0.437-0.456l-0.432-0.284c-0.015-0.01-0.029-0.02-0.043-0.03l-0.376-0.279L152.887,324l-2.803,1.974 c-0.056,0.04-0.117,0.073-0.18,0.099l-1.855,0.764l0.047,3.525c0,0.028-0.001,0.056-0.003,0.084l-0.033,0.421l0.021,0.163 l0.155,0.121l1.244-0.141l0.196-0.041l1.706-0.773c0.12-0.055,0.251-0.083,0.382-0.083c0.002,0,0.004,0,0.006,0l0.3,0.002 l0.366-0.279c0.064-0.049,0.135-0.089,0.209-0.12l0.22-0.09c0.112-0.046,0.231-0.069,0.351-0.069c0.009,0,0.017,0,0.026,0 l0.244,0.007c0.143,0.004,0.284,0.041,0.41,0.109l0.415,0.222c0.048,0.026,0.094,0.055,0.136,0.089l0.506,0.398 c0.032,0.026,0.063,0.053,0.092,0.083l1.343,1.384c0.036,0.038,0.07,0.078,0.099,0.121l0.251,0.366 c0.111,0.162,0.168,0.355,0.162,0.552l-0.006,0.198l0.064,0.298l0.122,0.169l0.485,0.521c0.25,0.268,0.318,0.658,0.174,0.995 l-0.2,0.468c-0.024,0.055-0.052,0.108-0.086,0.157l-0.887,1.304c-0.127,0.187-0.318,0.321-0.537,0.377l-0.279,0.071l-0.749,0.293 c-0.108,0.042-0.223,0.064-0.338,0.064c-0.065,0-0.13-0.007-0.194-0.02l-1.463-0.313c-0.051-0.011-0.102-0.026-0.15-0.046 l-0.409-0.164c-0.037-0.015-0.074-0.032-0.109-0.052l-0.184-0.103c-0.07-0.039-0.134-0.087-0.191-0.142l-0.279-0.27l-0.238,0.068 c-0.084,0.024-0.17,0.036-0.256,0.036c-0.133,0-0.265-0.029-0.387-0.085l-0.658-0.303l-0.418,0.336l-0.016,0.039l0.03,0.196 l0.015,0.057l0.197,0.131c0.171,0.114,0.3,0.281,0.366,0.476l0.089,0.263c0.028,0.084,0.044,0.171,0.048,0.26l0.035,0.901 c0.002,0.057-0.001,0.115-0.009,0.172l-0.054,0.367c-0.009,0.061-0.024,0.121-0.045,0.178l-0.137,0.38 c-0.012,0.034-0.027,0.068-0.043,0.1l-0.943,1.887l-0.333,1.601c-0.062,0.299-0.267,0.548-0.549,0.666 c-0.115,0.048-0.237,0.072-0.358,0.072c-0.175,0-0.35-0.05-0.501-0.147l-0.711-0.457l-0.053-0.02l-0.555-0.029l-0.387,0.651 l-0.759,1.929l0.124,0.115c0.065,0.061,0.121,0.131,0.167,0.208l0.373,0.633c0.078,0.132,0.122,0.282,0.128,0.436l0.025,0.684 l0.033,0.23l0.045,0.161l0.238,0.548l0.356,0.506l0.951,0.741c0.119,0.093,0.214,0.213,0.276,0.351l0.009,0.02l0.421,0.178 l0.532,0.109l0.471-0.458l0.122-0.203l0.067-0.253l0.071-1.446c0.004-0.082,0.019-0.163,0.044-0.241l0.124-0.38 c0.025-0.076,0.059-0.148,0.102-0.215l1.311-2.038c0.162-0.251,0.435-0.409,0.733-0.424l0.288-0.014 c0.015-0.001,0.031-0.001,0.046-0.001c0.372,0,0.71,0.224,0.855,0.57l1.583,3.802l0.098,0.207l0.058,0.028l0.208,0.04l0.406-0.039 l0.125-0.037l0.075-0.047l0.661-0.599c0.079-0.203,0.229-0.376,0.43-0.482l0.107-0.057c0.135-0.071,0.284-0.107,0.432-0.107 c0.126,0,0.251,0.026,0.369,0.077l0.179,0.078c0.034,0.015,0.068,0.032,0.1,0.051l0.362,0.213c0.135,0.08,0.248,0.193,0.328,0.328 l0.436,0.739c0.038,0.065,0.068,0.134,0.09,0.206l0.065,0.219l0.534,0.074l0.942-0.077c0.025-0.002,0.05-0.003,0.076-0.003 c0.028,0,0.056,0.001,0.083,0.004l0.511,0.046c0.055,0.005,0.109,0.015,0.162,0.029l1.127,0.31l0.872,0.062 c0.058,0.004,0.116,0.014,0.172,0.029l0.48,0.128c0.115,0.031,0.224,0.084,0.319,0.156l0.414,0.312 c0.086,0.065,0.159,0.143,0.218,0.233l0.868,1.33l0.558,0.691l0.712,0.718l1.325,1.042c0.03,0.023,0.058,0.048,0.084,0.075 l0.292,0.294l0.415-0.717c0.016-0.028,0.034-0.055,0.053-0.082l0.767-1.052l0.211-0.484l0.022-0.241l-0.252-0.423 c-0.01-0.016-0.019-0.033-0.028-0.05l-0.716-1.387c-0.087-0.168-0.12-0.358-0.095-0.545l0.078-0.595 c0.005-0.035,0.011-0.069,0.02-0.103l0.165-0.664c0.017-0.069,0.042-0.135,0.074-0.199l1.201-2.344l-0.237-0.413l-0.56-0.29 c-0.416-0.216-0.606-0.708-0.441-1.147l0.439-1.174c0.038-0.103,0.095-0.198,0.167-0.281l1.046-1.21 c0.024-0.027,0.049-0.053,0.076-0.078l0.985-0.9c0.071-0.064,0.151-0.118,0.237-0.158l0.679-0.312 c0.09-0.042,0.187-0.068,0.286-0.079l0.55-0.061c0.034-0.004,0.068-0.006,0.101-0.006c0.093,0,0.186,0.014,0.275,0.042l0.414,0.129 h0.34l0.598-0.203l0.466-0.279l0.32-0.349c0.086-0.094,0.191-0.169,0.307-0.221l1.326-0.588c0.12-0.053,0.247-0.079,0.375-0.079 c0.129,0,0.258,0.027,0.379,0.081l0.908,0.407l0.301,0.066l0.019-0.069c0.016-0.061,0.039-0.119,0.067-0.175l0.269-0.533 c0.018-0.035,0.038-0.069,0.059-0.101l1.835-2.714l0.198-0.664c0.076-0.256,0.26-0.467,0.503-0.578l1.022-0.467l0.274-0.221 c0.067-0.054,0.142-0.099,0.222-0.133l0.793-0.335c0.109-0.046,0.227-0.071,0.346-0.073l0.586-0.01l0.829-0.112l1.578-0.543 c0.095-0.033,0.194-0.05,0.294-0.05l0.945-0.007c0.002,0,0.005,0,0.007,0c0.063,0,0.127,0.007,0.189,0.02l1.452,0.303l0.607-0.263 c0.061-0.026,0.124-0.046,0.189-0.059l0.954-0.188c0.05-0.01,0.101-0.016,0.153-0.017l0.41-0.012c0.009,0,0.018,0,0.027,0 c0.085,0,0.17,0.012,0.253,0.035l1.622,0.46c0.039,0.011,0.076,0.024,0.113,0.04l1.008,0.434c0.023-0.035,0.048-0.068,0.076-0.1 l0.205-0.235c0.066-0.075,0.144-0.139,0.23-0.19l0.151-0.088l0.552-0.523l0.16-0.742c0.019-0.09,0.052-0.176,0.097-0.256 l0.806-1.444l0.316-1.104c0.047-0.165,0.14-0.314,0.267-0.43l0.332-0.302c0.031-0.028,0.064-0.055,0.099-0.079l-0.113-0.542 c-0.04-0.192-0.018-0.392,0.063-0.571l0.139-0.307c0.073-0.16,0.188-0.294,0.33-0.388l-0.101-0.782 c-0.009-0.066-0.01-0.132-0.004-0.198l0.072-0.848c0.003-0.032,0.007-0.063,0.013-0.095c-0.064-0.054-0.12-0.117-0.167-0.188 l-0.299-0.444c-0.147-0.218-0.194-0.489-0.13-0.744l0.113-0.449c0.078-0.308,0.308-0.555,0.611-0.654l0.173-0.057 c-0.042-0.182-0.029-0.375,0.042-0.552l0.753-1.893l0.179-0.822l-0.042-0.018c-0.418-0.174-0.649-0.626-0.545-1.067l0.095-0.406 c0.023-0.096,0.061-0.188,0.112-0.273l0.26-0.424l0.169-0.367l-0.003-0.004c-0.038-0.044-0.071-0.092-0.1-0.143l-0.115-0.203 c-0.037-0.065-0.066-0.135-0.087-0.207l-0.053-0.189c-0.023-0.082-0.035-0.166-0.035-0.251v-1.218l-0.104-0.081 c-0.038,0.005-0.076,0.007-0.114,0.007c-0.212,0-0.423-0.073-0.593-0.215l-0.145-0.121 C200.543,314.067,200.523,314.049,200.504,314.029z").attr({id: 'caldas', class: 'st27', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#B2A54D'}).data({'id': 'caldas', 'region':'Caldas', 'benefited-companies':'12', 'benefited-projects': '$360.000.000'})

        var cesar = rsr.path("M242.28,201.118l0.048,0.091c0.044,0.083,0.075,0.172,0.092,0.264l0.138,0.748l0.121,0.387 c0.04,0.129,0.052,0.265,0.034,0.399l-0.043,0.322l0.252,2.19c0.002,0.016,0.003,0.032,0.004,0.048l0.031,0.486l0.28,0.755 l1.869,3.239c0.073,0.127,0.115,0.27,0.123,0.417l0.027,0.534l0.135,0.015c0.059,0.007,0.118,0.019,0.175,0.037l0.195,0.061 c0.109,0.034,0.21,0.088,0.299,0.159l0.126,0.1c0.035,0.028,0.067,0.057,0.097,0.089l0.272,0.289l0.093,0.058 c0.046,0.029,0.089,0.061,0.129,0.097l0.294,0.264c0.069,0.062,0.129,0.135,0.177,0.215l0.078,0.131l0.123,0.147 c0.073,0.088,0.13,0.189,0.166,0.297l0.267,0.79c0.031,0.091,0.047,0.185,0.049,0.281l0.014,0.845 c0.002,0.123-0.021,0.246-0.066,0.36l-0.32,0.797c-0.056,0.138-0.144,0.261-0.257,0.359l-1.281,1.098 c-0.037,0.032-0.077,0.061-0.12,0.087l-0.536,0.328l-0.13,0.102l-0.616,0.659l-0.104,0.21l-0.025,0.129l0.118,0.456 c0.008,0.03,0.014,0.06,0.019,0.09l0.071,0.457c0.005,0.029,0.008,0.059,0.009,0.088l0.025,0.432 c0.009,0.162-0.024,0.324-0.097,0.469l-0.261,0.519c-0.024,0.049-0.053,0.095-0.086,0.139l-0.033,0.044l-0.007,0.139l3.354,0.17 c0.17-0.256,0.459-0.414,0.772-0.414c0.027,0,0.054,0.001,0.081,0.004l0.203,0.018c0.037,0.003,0.073,0.009,0.109,0.016l1.71,0.357 c0.044,0.009,0.088,0.022,0.13,0.037l0.447,0.164c0.062,0.023,0.121,0.052,0.177,0.087l0.382,0.243 c0.079,0.05,0.151,0.112,0.211,0.184l0.46,0.545l0.178,0.145l0.188,0.066l0.414,0.08c0.09,0.017,0.177,0.048,0.258,0.091 l0.324,0.172c0.055,0.029,0.107,0.064,0.155,0.103l0.776,0.638l0.233,0.109l0.081,0.01l0.314-0.086l1.28-0.587l0.784-0.516 l0.555-0.543l0.425-0.561c0.03-0.039,0.062-0.076,0.098-0.11l0.422-0.404l0.304-0.589c0.024-0.047,0.052-0.092,0.084-0.134 l0.992-1.311l0.152-0.25l0.079-0.252l0.072-0.782l-0.13-1.554c-0.007-0.079-0.003-0.158,0.011-0.236l0.144-0.826 c0.011-0.063,0.029-0.125,0.053-0.185l0.215-0.537c0.061-0.154,0.163-0.288,0.294-0.389l0.361-0.279 c0.07-0.054,0.147-0.098,0.229-0.13l0.701-0.274l0.384-0.308l0.328-0.365l0.441-0.6l0.111-0.422l0.032-0.335l-0.358-0.155 c-0.157-0.068-0.291-0.178-0.389-0.318l-0.367-0.523l-1.556-0.158c-0.225-0.023-0.433-0.127-0.586-0.292l-0.585-0.632 c-0.102-0.11-0.176-0.244-0.215-0.389l-0.177-0.659c-0.024-0.09-0.035-0.184-0.031-0.277l0.042-1.059l-0.049-0.297 c-0.008-0.048-0.012-0.097-0.012-0.146v-0.133l-0.503-1.146l-0.389-0.253c-0.247-0.161-0.403-0.429-0.419-0.724l-0.206-3.626 c-0.004-0.069,0-0.138,0.011-0.207l0.166-0.987c0.01-0.057,0.025-0.114,0.045-0.168l0.345-0.931 c0.015-0.04,0.032-0.079,0.053-0.116l0.447-0.831l0.345-1.269c0.012-0.045,0.028-0.088,0.046-0.131l0.68-1.541l0.583-2.641 l-0.12-1.578l-0.247-0.161l-0.779-0.112l-0.147-0.004l0.011,0.041l0.247,0.407c0.042,0.069,0.074,0.142,0.097,0.219l0.066,0.225 c0.011,0.038,0.02,0.077,0.026,0.116l0.275,1.733c0.052,0.328-0.075,0.658-0.334,0.866l-1.259,1.014l-0.167,0.226l-0.383,0.643 c-0.065,0.109-0.152,0.204-0.255,0.278l-0.229,0.165c-0.161,0.116-0.351,0.174-0.541,0.174c-0.18,0-0.36-0.052-0.517-0.157 l-0.293-0.197c-0.072-0.048-0.137-0.106-0.192-0.173l-0.208-0.247c-0.122-0.145-0.197-0.324-0.214-0.513l-0.055-0.612l-0.348-0.224 c-0.051-0.033-0.098-0.07-0.142-0.112l-0.167-0.161l-0.139-0.079l-0.109-0.033l-0.662-0.043c-0.038-0.002-0.075-0.007-0.113-0.014 l-0.283-0.054c-0.31-0.059-0.569-0.272-0.686-0.564l-0.092-0.229c-0.067-0.166-0.084-0.348-0.05-0.523l0.064-0.326 c0.031-0.161,0.105-0.311,0.213-0.434l0.962-1.094l0.385-1.393l-0.013-0.023l-0.046-0.025c-0.182-0.1-0.325-0.259-0.406-0.45 l-0.842-1.987l-1.258-1.789c-0.046-0.065-0.083-0.136-0.11-0.21l-0.414-1.115c-0.032-0.086-0.051-0.177-0.056-0.269l-0.026-0.445 c-0.002-0.03-0.002-0.06-0.001-0.09l0.02-0.512c0.002-0.042,0.006-0.083,0.013-0.124l0.113-0.645 c0.014-0.08,0.038-0.157,0.073-0.231l0.24-0.517c0.019-0.041,0.041-0.081,0.066-0.119l0.342-0.519 c0.016-0.024,0.032-0.047,0.05-0.069l0.325-0.406c0.022-0.027,0.045-0.053,0.069-0.077l0.625-0.623 c0.027-0.027,0.056-0.053,0.087-0.076l1.625-1.259l0.274-0.294v-0.003l-0.089-0.332c-0.053-0.196-0.039-0.404,0.038-0.592 l0.139-0.338c0.045-0.11,0.112-0.211,0.195-0.296l0.274-0.279c0.05-0.051,0.106-0.096,0.166-0.134l1.064-0.673l0.446-0.43 l0.053-0.122l-0.002-0.156l-0.308-0.927c-0.006-0.019-0.012-0.038-0.017-0.057l-0.605-2.299c-0.039-0.149-0.041-0.306-0.004-0.456 l0.289-1.184l0.001-0.189l-0.186-1.81c-0.006-0.059-0.006-0.119-0.001-0.178l0.565-6.266l-0.176-1.653 c-0.02-0.191,0.019-0.384,0.114-0.552l0.894-1.589c0.096-0.171,0.245-0.307,0.423-0.389l0.405-0.184 c0.055-0.025,0.113-0.045,0.172-0.059l0.063-0.015l0.013-0.938c0.002-0.163,0.047-0.322,0.131-0.462l0.536-0.896 c0.068-0.113,0.159-0.211,0.267-0.286l1.628-1.129l0.672-0.642l0.471-0.768l1.54-3.886c0.025-0.062,0.056-0.122,0.094-0.177 l3.602-5.334l0.831-1.971c0.052-0.123,0.129-0.233,0.228-0.323l0.672-0.616c0.041-0.037,0.085-0.071,0.132-0.101l1.731-1.09 l0.571-0.607l0.387-0.688l1.128-3.067c0.023-0.063,0.053-0.124,0.09-0.18l2.481-3.869l1.376-2.829l0.271-0.901l-0.11-0.52 l-0.357-0.756c-0.026-0.055-0.046-0.112-0.061-0.172l-0.297-1.193c-0.021-0.085-0.03-0.172-0.027-0.259l0.036-0.953 c0.002-0.052,0.008-0.104,0.019-0.155l0.361-1.723l0.007-1.714c0-0.087,0.013-0.173,0.037-0.256l2.354-8.066l0.905-10.019 l-0.014-0.393l-1.538,0.66c-0.047,0.02-0.095,0.036-0.144,0.048l-0.76,0.187c-0.031,0.008-0.062,0.014-0.094,0.018l-0.827,0.115 c-0.042,0.006-0.085,0.009-0.128,0.009c-0.013,0-0.027,0-0.04-0.001l-0.833-0.036c-0.042-0.002-0.084-0.007-0.126-0.014 l-0.651-0.119c-0.074-0.013-0.146-0.036-0.214-0.067l-0.696-0.314l-0.441-0.097l-0.628,0.096l-0.678,0.291 c-0.034,0.014-0.068,0.027-0.103,0.037l-0.719,0.212c-0.086,0.025-0.174,0.038-0.263,0.038c-0.137,0-0.273-0.03-0.399-0.09 l-0.407-0.194c-0.241-0.115-0.421-0.329-0.493-0.586l-0.214-0.766l-0.225-0.482l-0.27-0.325l-0.623-0.227 c-0.233-0.085-0.422-0.26-0.525-0.486s-0.111-0.483-0.022-0.715l0.208-0.544c0.028-0.074,0.066-0.143,0.111-0.208l0.307-0.429 c0.081-0.113,0.186-0.207,0.309-0.274l0.29-0.159l0.794-1.436c0.081-0.147,0.202-0.27,0.347-0.354l0.295-0.17l0.417-1.3 c0.038-0.118,0.099-0.228,0.181-0.322l0.512-0.594l0.303-0.927c0.009-0.027,0.019-0.053,0.03-0.079l0.244-0.566 c0.025-0.058,0.056-0.114,0.093-0.165l0.16-0.227l-0.062-0.099l-1.574-1.367l-1.656-0.964l-1.257-0.332 c-0.084-0.022-0.164-0.056-0.239-0.101l-1.134-0.678l-1.214-0.371c-0.235-0.072-0.432-0.234-0.547-0.451l-0.353-0.663 c-0.093-0.174-0.127-0.374-0.099-0.569l0.072-0.491c0.008-0.054,0.02-0.107,0.038-0.159l0.164-0.492l0.013-0.31l-0.136-1.1 l-0.174-0.556l-0.364-0.523l-0.197-0.137l-0.448,0.037c-0.026,0.002-0.051,0.003-0.077,0.003c-0.056,0-0.111-0.005-0.166-0.015 l-1.57-0.287l-1.214-0.086c-0.041-0.003-0.081-0.009-0.122-0.017l-0.937-0.194l-2.8-0.107l-6.253,0.862 c-0.024,0.061-0.054,0.119-0.09,0.174l-1.114,1.688l0.403,0.025c0.051,0.003,0.103,0.011,0.153,0.022l0.786,0.184 c0.073,0.017,0.144,0.043,0.21,0.077l0.699,0.357c0.101,0.052,0.192,0.121,0.268,0.205l0.487,0.542 c0.123,0.137,0.203,0.307,0.228,0.489l0.086,0.609c0.032,0.228-0.021,0.46-0.151,0.65l-0.635,0.934 c-0.026,0.038-0.054,0.074-0.085,0.107l-0.407,0.441l-0.983,1.767l0.215,0.448c0.016,0.033,0.03,0.066,0.041,0.101l0.238,0.695 c0.018,0.051,0.031,0.104,0.039,0.158l0.268,1.717c0.008,0.054,0.012,0.11,0.011,0.165l-0.017,0.691 c-0.001,0.059-0.008,0.118-0.021,0.176l-0.091,0.416l0.301,0.176c0.068,0.04,0.131,0.088,0.187,0.144l0.374,0.372 c0.156,0.156,0.252,0.362,0.27,0.582l0.038,0.468c0.018,0.223-0.045,0.445-0.178,0.624l-0.316,0.428 c-0.094,0.127-0.218,0.227-0.361,0.293l-1.069,0.487c-0.038,0.017-0.077,0.032-0.117,0.044l-1.242,0.373l-0.003,0.007l-0.261,0.727 c-0.056,0.157-0.154,0.297-0.284,0.403l-0.363,0.299c-0.13,0.107-0.286,0.176-0.452,0.201l-0.631,0.094 c-0.043,0.006-0.086,0.01-0.13,0.01l-0.348,0.002l-0.096,0.041l-0.476,0.587c-0.091,0.112-0.207,0.201-0.339,0.261l-0.719,0.324 c-0.061,0.027-0.125,0.048-0.19,0.062l-0.425,0.089l-1.488,1.094c-0.086,0.063-0.181,0.111-0.283,0.141l-1.746,0.523 c-0.086,0.026-0.176,0.039-0.266,0.039c-0.016,0-0.032,0-0.048-0.001l-0.487-0.025c-0.079-0.004-0.156-0.018-0.232-0.042 l-0.306-0.097l-0.195-0.035l-0.214,0.004l-0.477,0.146c-0.031,0.009-0.063,0.017-0.095,0.024l-1.546,0.298l-0.383,0.164 l-0.479,0.379l-0.719,0.765l-0.292,0.62l-0.41,1.175c-0.028,0.08-0.067,0.156-0.115,0.225l-0.46,0.658 c-0.026,0.037-0.054,0.072-0.085,0.104l-1.348,1.433l-0.63,0.958c-0.029,0.045-0.063,0.087-0.099,0.126l-0.385,0.409l-0.416,0.879 c-0.026,0.056-0.058,0.109-0.095,0.158l-0.644,0.862l-0.282,1.983c-0.004,0.03-0.01,0.059-0.017,0.088l-0.355,1.464 c-0.007,0.029-0.015,0.057-0.025,0.085l-0.117,0.337l0.027,0.436l0.053,0.304l1.386,2.344l1.144,1.869l0.311,0.378l0.449,0.238 c0.027,0.014,0.052,0.029,0.078,0.046l0.663,0.438c0.031,0.02,0.06,0.043,0.088,0.066l0.783,0.665 c0.056,0.047,0.105,0.101,0.149,0.16l2.549,3.488l0.344,0.243c0.037,0.026,0.072,0.055,0.105,0.086l1.955,1.863 c0.143,0.136,0.239,0.315,0.273,0.509l0.217,1.229c0.005,0.029,0.009,0.057,0.011,0.086l0.026,0.32 c0.011,0.135-0.008,0.271-0.055,0.398l-0.139,0.374l0.985,1.78c0.028,0.05,0.05,0.102,0.068,0.156l1.481,4.442 c0.101,0.303,0.039,0.638-0.166,0.884l-0.753,0.908c-0.176,0.213-0.438,0.335-0.713,0.335c-0.008,0-0.015,0-0.023,0 c-0.284-0.007-0.549-0.144-0.718-0.371l-0.261-0.348c-0.019-0.026-0.037-0.053-0.054-0.081l-1.535,0.909 c-0.037,0.022-0.075,0.041-0.114,0.057l-0.377,0.158c-0.113,0.047-0.235,0.072-0.358,0.072c-0.002,0-0.004,0-0.007,0l-0.533-0.004 c-0.046,0-0.092-0.004-0.138-0.011l-0.249-0.039l-1.597-0.007c-0.14-0.001-0.278-0.033-0.403-0.094l-0.413-0.202 c-0.041-0.02-0.081-0.043-0.118-0.069l-0.504-0.347l-0.12-0.031l-0.653-0.038c-0.088-0.005-0.175-0.023-0.258-0.053l-0.393-0.141 l-0.288-0.054l-0.191-0.019l-0.805,0.078l-0.489,0.205l-0.61,0.379l-2.13,2.452c-0.046,0.053-0.097,0.1-0.153,0.141l-0.177,0.129 l1.293,0.75c0.065,0.038,0.125,0.083,0.18,0.136l1.853,1.793l0.83,0.445c0.068,0.037,0.132,0.082,0.189,0.134l0.806,0.74 c0.165,0.152,0.27,0.358,0.294,0.582l0.268,2.455l0.33,0.633l0.242,0.203l0.369,0.25c0.04,0.027,0.077,0.057,0.113,0.09 l0.284,0.265c0.081,0.075,0.148,0.165,0.197,0.264l0.17,0.341c0.055,0.11,0.087,0.229,0.095,0.352l0.107,1.603l0.061,0.364 c0.005,0.03,0.009,0.061,0.011,0.091l0.023,0.352c0.003,0.049,0.003,0.099-0.002,0.148l-0.021,0.224 c-0.009,0.099-0.034,0.195-0.074,0.286l-0.09,0.204c-0.044,0.101-0.106,0.193-0.183,0.272l-0.14,0.144l-0.006,0.009l0.002,0.009 l0.064,0.143l0.025,0.033l0.26,0.121l1.539,0.332l0.195-0.011l0.276-0.07c0.074-0.019,0.15-0.028,0.226-0.028 c0.025,0,0.05,0.001,0.075,0.003l0.322,0.026c0.259,0.021,0.497,0.15,0.657,0.355l0.223,0.287c0.11,0.142,0.177,0.313,0.192,0.491 l0.067,0.807l0.181,0.72l0.428,0.767l1.288,1.239c0.038,0.037,0.074,0.077,0.105,0.12l1.135,1.55 c0.222,0.302,0.239,0.709,0.044,1.029l-1.037,1.702l-0.458,1.273c-0.016,0.043-0.034,0.085-0.056,0.126l-0.412,0.765l-1.025,3.243 l0.38,0.512l1.516,1.383c0.059,0.053,0.11,0.114,0.153,0.181l0.57,0.879c0.071,0.11,0.118,0.234,0.138,0.363l0.201,1.307 c0.017,0.112,0.014,0.226-0.01,0.337l-0.216,0.998c-0.017,0.078-0.044,0.154-0.08,0.225l-0.807,1.582l-0.149,0.737l0.062,2.816 l0.179,0.671l0.212,0.339l0.767,0.962c0.074,0.093,0.13,0.2,0.164,0.314l0.162,0.544c0.025,0.086,0.038,0.174,0.038,0.264v1.497 l0.169,0.823l0.949,1.717c0.031,0.056,0.056,0.115,0.075,0.176l0.325,1.06c0.017,0.057,0.029,0.115,0.036,0.174l0.345,3.26 c0.012,0.111,0.003,0.223-0.025,0.331l-0.189,0.723c-0.022,0.083-0.055,0.163-0.098,0.236l-0.177,0.301l0.142,0.195 c0.067,0.092,0.116,0.195,0.146,0.304l0.141,0.522c0.045,0.166,0.043,0.342-0.006,0.507l-0.09,0.3 c-0.026,0.087-0.065,0.171-0.115,0.247l-0.344,0.519l-0.04,0.092c0,0.012,0,0.025,0,0.037l-0.025,1.236 c-0.001,0.054-0.007,0.109-0.018,0.162l-0.094,0.476c-0.013,0.065-0.033,0.128-0.059,0.188l-0.366,0.842l-0.074,0.391 c-0.022,0.114-0.064,0.222-0.126,0.32l-0.097,0.154c-0.047,0.074-0.104,0.142-0.169,0.2L242.28,201.118z").attr({id: 'cesar', class: 'st28', parent: 'colombiamap', 'stroke-width': '0' ,'stroke-opacity': '1' ,'fill': '#F2AB83'}).data({'id': 'cesar', 'region':'Cesar', 'benefited-companies':'3', 'benefited-projects': '$80.000.000'});

        var magdalena = rsr.path("M195.273,68.53l-0.203-0.069l1.125,1.052c0.024,0.023,0.048,0.047,0.069,0.072l1.033,1.201 c0.042,0.048,0.078,0.101,0.109,0.157l0.377,0.684c0.051,0.092,0.085,0.191,0.103,0.294l0.285,1.702l0.237,0.351l0.424,0.374 c0.04,0.036,0.078,0.075,0.111,0.117l0.459,0.576c0.091,0.114,0.154,0.248,0.183,0.391l0.18,0.875 c0.031,0.15,0.024,0.306-0.02,0.452l-0.245,0.818c-0.009,0.031-0.02,0.061-0.033,0.091l-0.329,0.787l-0.149,0.834l0.035,0.345 l0.721,1.986c0.016,0.044,0.029,0.089,0.038,0.135l0.078,0.391c0.009,0.047,0.015,0.095,0.017,0.144l0.038,0.938 c0.001,0.037,0.001,0.073-0.002,0.11l-0.307,3.909l0.125,2.927c0.002,0.053,0,0.106-0.007,0.159l-0.128,0.983 c-0.015,0.119-0.054,0.235-0.114,0.339l-0.889,1.562c-0.068,0.12-0.163,0.224-0.277,0.302l-2.479,1.721l-0.652,1.325l-0.229,1.986 c-0.005,0.043-0.013,0.086-0.024,0.128l-0.264,1.01c-0.027,0.101-0.07,0.197-0.129,0.284l-0.564,0.835 c-0.02,0.03-0.042,0.059-0.066,0.086l-0.659,0.765l-2.37,4.655l-0.253,0.497l-0.281,1.473c-0.011,0.06-0.029,0.119-0.052,0.175 l-0.58,1.427l-0.106,0.728l0.13,0.875l0.169,0.173l0.562,0.219c0.064,0.025,0.126,0.057,0.183,0.096l0.82,0.555l0.191,0.092 l1.245,0.253c0.121,0.025,0.236,0.073,0.339,0.143l0.289,0.198c0.038,0.026,0.074,0.054,0.107,0.086l0.258,0.24 c0.038,0.035,0.073,0.073,0.104,0.114l0.417,0.542c0.049,0.064,0.09,0.134,0.121,0.208l0.499,1.196l0.055,0.022 c0.061,0.025,0.12,0.056,0.175,0.093l0.32,0.217c0.165,0.112,0.289,0.273,0.354,0.461l0.147,0.423 c0.041,0.117,0.058,0.241,0.05,0.365l-0.078,1.199c-0.007,0.108-0.033,0.214-0.076,0.313l-0.286,0.649 c-0.067,0.153-0.175,0.285-0.311,0.382l-0.565,0.401c-0.037,0.026-0.075,0.049-0.115,0.07l-1.52,0.776l-0.246,0.198l-0.127,0.27 l-0.075,0.808l0.035,1.985l0.147,0.787l0.321,0.724l0.307,0.416l1.517,1.418c0.105,0.098,0.185,0.219,0.236,0.353l0.284,0.763 c0.06,0.162,0.074,0.337,0.04,0.507l-0.201,0.994c-0.008,0.042-0.02,0.083-0.034,0.123l-0.341,0.976l-0.142,0.644l0.093,0.6 l0.227,0.378l1.097,1.015c0.043,0.04,0.082,0.083,0.116,0.13l0.569,0.771c0.09,0.122,0.148,0.263,0.171,0.413l0.104,0.695 c0.02,0.13,0.011,0.263-0.025,0.39l-0.517,1.819l-0.655,3.93l0.109,0.707l0.436-0.066c0.047-0.007,0.093-0.011,0.139-0.011 c0.254,0,0.499,0.104,0.676,0.293l0.356,0.38c0.023,0.025,0.045,0.051,0.066,0.079l0.431,0.576 c0.005-0.002,0.011-0.004,0.016-0.006l0.605-0.208c0.097-0.033,0.199-0.05,0.301-0.05c0.011,0,0.022,0,0.033,0.001l0.608,0.022 c0.161,0.006,0.317,0.053,0.454,0.138l0.569,0.352c0.113,0.07,0.21,0.164,0.284,0.275l0.219,0.33 c0.046,0.07,0.083,0.145,0.109,0.224l0.125,0.38l0.208-0.012c0.018-0.001,0.037-0.002,0.056-0.002c0.092,0,0.184,0.014,0.273,0.041 l0.241,0.074c0.068,0.021,0.133,0.049,0.194,0.085l0.752,0.438c0.051,0.03,0.099,0.064,0.144,0.103l0.329,0.288 c0.12,0.105,0.211,0.239,0.263,0.389l0.139,0.395c0.021,0.059,0.036,0.121,0.044,0.183l0.057,0.423l0.106,0.236l0.18,0.225 l0.262,0.224l1.439,0.968c0.059,0.04,0.113,0.086,0.161,0.137l0.71,0.763c0.101,0.108,0.174,0.239,0.214,0.381l0.379,1.35 l0.141,0.217l0.173,0.143l0.041,0.015l0.102-0.176c0.03-0.052,0.065-0.101,0.105-0.146l0.295-0.336 c0.08-0.091,0.177-0.166,0.286-0.219l0.751-0.371c0.104-0.051,0.216-0.083,0.332-0.092l0.718-0.061 c0.026-0.002,0.052-0.003,0.078-0.003c0.03,0,0.06,0.001,0.089,0.004l1.477,0.143c0.25,0.024,0.48,0.149,0.636,0.347l0.203,0.256 c0.077,0.097,0.134,0.209,0.167,0.329l0.303,1.099l0.022,0.036l0.245-0.162c0.066-0.043,0.137-0.078,0.212-0.104l0.517-0.176 c0.096-0.033,0.197-0.049,0.298-0.049c0.036,0,0.072,0.002,0.108,0.006l0.828,0.097c0.059,0.007,0.118,0.02,0.175,0.038 l1.033,0.331c0.053,0.017,0.104,0.039,0.154,0.065l0.883,0.471c0.122,0.065,0.228,0.157,0.31,0.268l0.374,0.508 c0.106,0.144,0.168,0.315,0.179,0.494l0.05,0.837l1.213,0.044c0.155,0.006,0.307,0.05,0.44,0.13l0.834,0.497 c0.129,0.077,0.237,0.184,0.316,0.312l1.155,1.888l0.546,0.714l1.747,0.973c0.056,0.031,0.109,0.069,0.158,0.111l0.62,0.54 c0.207,0.18,0.323,0.443,0.317,0.717c0,0.006,0,0.011-0.001,0.017l0.122,0.051l1.329,0.322l0.822-0.091l0.538-0.726 c0.164-0.221,0.417-0.358,0.691-0.373c0.018-0.001,0.035-0.002,0.053-0.002c0.255,0,0.501,0.106,0.676,0.293l0.405,0.433 l0.565,0.406c0.077,0.055,0.145,0.122,0.201,0.197l0.399,0.533c0.184,0.246,0.234,0.567,0.134,0.857l0.595,0.341l3.609,0.164 c0.115,0.005,0.227,0.032,0.332,0.078l1.279,0.565c0.112,0.05,0.21,0.119,0.29,0.202l0.214-0.396l0.466-1.296 c0.021-0.059,0.048-0.115,0.08-0.168l0.763-1.253l-0.722-0.985l-1.33-1.279c-0.066-0.063-0.122-0.136-0.167-0.216l-0.554-0.994 c-0.04-0.071-0.07-0.147-0.089-0.226l-0.229-0.912c-0.012-0.049-0.021-0.099-0.025-0.149l-0.021-0.255l-0.389,0.023 c-0.018,0.001-0.036,0.002-0.054,0.002c-0.066,0-0.131-0.007-0.195-0.021l-1.764-0.38c-0.068-0.015-0.134-0.037-0.196-0.066 l-0.561-0.262c-0.136-0.064-0.255-0.159-0.346-0.279l-0.229-0.301c-0.043-0.057-0.08-0.119-0.109-0.185l-0.142-0.319 c-0.023-0.051-0.041-0.105-0.054-0.159l-0.055-0.23c-0.016-0.068-0.025-0.137-0.026-0.206l-0.002-0.223 c-0.001-0.081,0.009-0.161,0.029-0.24l0.053-0.208c0.028-0.108,0.075-0.21,0.139-0.302l0.173-0.247 c0.028-0.04,0.06-0.078,0.094-0.113l0.035-0.036l-0.013-0.189l-0.061-0.364c-0.005-0.03-0.009-0.061-0.011-0.091l-0.098-1.463 l-0.012-0.025l-0.109-0.102l-0.348-0.236c-0.026-0.018-0.051-0.036-0.075-0.057l-0.42-0.351c-0.094-0.078-0.171-0.174-0.227-0.283 l-0.496-0.952c-0.053-0.102-0.087-0.213-0.099-0.327l-0.249-2.282l-0.463-0.426l-0.841-0.451c-0.076-0.04-0.145-0.091-0.207-0.151 l-1.864-1.804l-2.423-1.405c-0.271-0.157-0.444-0.44-0.46-0.753c-0.016-0.312,0.126-0.612,0.379-0.797l1.239-0.905l2.153-2.479 c0.061-0.07,0.132-0.131,0.211-0.18l0.792-0.492c0.042-0.026,0.085-0.048,0.131-0.067l0.686-0.287 c0.086-0.036,0.176-0.059,0.268-0.068l1.035-0.101c0.03-0.003,0.06-0.004,0.09-0.004c0.031,0,0.061,0.002,0.092,0.005l0.322,0.032 c0.027,0.003,0.054,0.007,0.08,0.012l0.399,0.076c0.047,0.009,0.094,0.022,0.14,0.038l0.336,0.12l0.608,0.035 c0.059,0.003,0.117,0.012,0.175,0.027l0.367,0.093c0.106,0.027,0.207,0.073,0.297,0.135l0.584,0.402l0.16,0.079l1.455,0.006 c0.047,0,0.094,0.004,0.14,0.011l0.25,0.039l0.274,0.002l0.144-0.06l1.862-1.103c0.117-0.069,0.247-0.112,0.382-0.125l0.33-0.032 c0.03-0.003,0.06-0.004,0.09-0.004c0.099,0,0.198,0.016,0.292,0.047l-1.056-3.168l-1.15-2.078 c-0.131-0.236-0.152-0.518-0.058-0.772l0.216-0.58l-0.006-0.071l-0.157-0.887l-1.686-1.606l-0.413-0.291 c-0.082-0.058-0.154-0.129-0.214-0.21l-2.573-3.522l-0.657-0.558l-0.579-0.383l-0.574-0.304c-0.108-0.057-0.204-0.136-0.282-0.231 l-0.469-0.571c-0.027-0.033-0.052-0.068-0.074-0.105l-1.185-1.936l-1.48-2.502c-0.057-0.096-0.096-0.202-0.115-0.312l-0.091-0.521 c-0.006-0.034-0.01-0.068-0.012-0.102l-0.041-0.672c-0.008-0.122,0.009-0.244,0.049-0.36l0.163-0.47l0.334-1.378l0.309-2.173 c0.022-0.154,0.082-0.3,0.175-0.424l0.73-0.977l0.439-0.927c0.041-0.087,0.096-0.168,0.162-0.238l0.43-0.457l0.63-0.958 c0.029-0.045,0.063-0.087,0.099-0.126l1.357-1.443l0.348-0.499l0.384-1.1c0.011-0.03,0.023-0.06,0.037-0.089l0.375-0.796 c0.041-0.088,0.096-0.169,0.163-0.24l0.866-0.921c0.031-0.033,0.064-0.064,0.1-0.092l0.629-0.498 c0.064-0.051,0.135-0.093,0.211-0.125l0.589-0.252c0.061-0.026,0.124-0.045,0.189-0.058l1.596-0.307l0.555-0.169 c0.083-0.025,0.169-0.039,0.255-0.04l0.434-0.007c0.005,0,0.01,0,0.015,0c0.055,0,0.109,0.005,0.163,0.014l0.342,0.061 c0.039,0.007,0.078,0.017,0.116,0.029l0.25,0.079l0.209,0.011l1.439-0.431l1.52-1.118c0.107-0.078,0.229-0.133,0.358-0.16 l0.523-0.11l0.427-0.192l0.482-0.594c0.095-0.117,0.216-0.208,0.354-0.268l0.478-0.205c0.113-0.049,0.236-0.074,0.359-0.075 l0.47-0.003l0.288-0.043l0.183-0.51c0.011-0.031,0.024-0.061,0.038-0.091l0.178-0.368c0.098-0.203,0.266-0.363,0.474-0.45 l0.35-0.148c0.03-0.013,0.061-0.024,0.093-0.034l1.245-0.374l0.551-0.251l-0.137-0.08c-0.066-0.039-0.128-0.085-0.182-0.139 l-0.264-0.259c-0.102-0.1-0.179-0.222-0.226-0.357l-0.124-0.356c-0.056-0.161-0.067-0.335-0.03-0.502l0.14-0.642l0.012-0.52 l-0.242-1.554l-0.194-0.566l-0.399-0.831c-0.13-0.271-0.121-0.588,0.026-0.851l1.27-2.282c0.036-0.064,0.079-0.124,0.128-0.177 l0.435-0.472l0.387-0.57l-0.172-0.191l-0.445-0.227l-0.601-0.14l-0.599-0.038l-0.593,0.046c-0.024,0.002-0.047,0.003-0.071,0.003 c-0.14,0-0.279-0.032-0.406-0.094l-0.369-0.18c-0.43-0.21-0.63-0.713-0.46-1.161l0.266-0.7c0.024-0.064,0.055-0.125,0.093-0.182 l1.376-2.086l0.009-0.083l-0.946-3.268c-0.015-0.051-0.025-0.104-0.031-0.157l-0.194-1.774l-0.167-0.379l-0.512-0.822 c-0.064-0.103-0.107-0.217-0.127-0.337l-0.061-0.368c-0.013-0.076-0.016-0.154-0.009-0.231l0.039-0.463 c0.004-0.043,0.01-0.085,0.02-0.127l0.258-1.137c0.011-0.049,0.026-0.096,0.045-0.143l0.222-0.548l0.079-2.259 c0.002-0.044,0.006-0.088,0.014-0.132l0.085-0.47l-0.023-0.328l-0.121-0.624c-0.03-0.154-0.02-0.314,0.029-0.464l0.092-0.281 c0.041-0.126,0.109-0.242,0.199-0.339l0.177-0.193c0.109-0.118,0.246-0.206,0.398-0.255l0.339-0.109l0.126-0.058l0.06-0.049 l0.504-0.68c0.047-0.063,0.102-0.121,0.163-0.17l0.203-0.164c0.046-0.037,0.096-0.07,0.149-0.098l0.134-0.07l0.044-0.071 l0.756-2.38l-0.02-0.288l-0.334,0.001l-5.113,0.406c-0.024,0.002-0.049,0.003-0.073,0.003c-0.022,0-0.044-0.001-0.066-0.002 l-5.52-0.396c-0.073-0.005-0.145-0.019-0.214-0.041l-1.797-0.57c-0.066-0.021-0.13-0.049-0.189-0.084l-1.35-0.794l-1.947-0.42 c-0.051-0.011-0.101-0.026-0.15-0.046l-0.34-0.136c-0.103-0.041-0.198-0.101-0.28-0.176l-0.758-0.692l-0.628-0.454l-0.659-0.26 l-0.893-0.094l-0.062,0.012c-0.122,0.38-0.477,0.642-0.882,0.642h-0.34c-0.007,0-0.014,0-0.022,0 c-0.087,0.121-0.203,0.22-0.338,0.288l-0.444,0.222c-0.13,0.065-0.272,0.098-0.414,0.098c-0.103,0-0.207-0.017-0.306-0.052 l-0.504-0.176c-0.085-0.03-0.164-0.071-0.236-0.123c-0.082,0.024-0.169,0.037-0.259,0.037h-0.28l-0.19,0.259 c-0.175,0.239-0.453,0.378-0.746,0.378c-0.009,0-0.018,0-0.027,0c-0.016,0.012-0.033,0.024-0.049,0.035l-0.327,0.214 c-0.152,0.1-0.329,0.151-0.508,0.151c-0.071,0-0.142-0.008-0.212-0.025l-0.449-0.106l-0.06,0.004l-0.275,0.521l-0.036,0.322 c-0.018,0.161-0.078,0.314-0.174,0.444l-0.15,0.205c-0.069,0.094-0.156,0.175-0.255,0.237l-0.1,0.063l-0.119,0.132l-0.542,0.762 l-0.119,0.215c0.088,0.114,0.148,0.248,0.175,0.39l0.052,0.273c0.035,0.186,0.013,0.378-0.064,0.55l-0.1,0.225 c-0.052,0.118-0.129,0.223-0.224,0.309l-0.106,0.096l0.332,0.683c0.036,0.075,0.062,0.154,0.078,0.236l0.086,0.462 c0.019,0.1,0.02,0.203,0.006,0.304l-0.067,0.452c-0.008,0.053-0.02,0.105-0.037,0.155l-0.219,0.662l-0.004,0.163l0.059,0.136 l0.557,0.687c0.087,0.107,0.148,0.232,0.181,0.365l0.134,0.551c0.045,0.187,0.031,0.383-0.04,0.561l-0.147,0.367 c-0.025,0.063-0.057,0.124-0.096,0.18l-2.791,4.079l-0.359,0.859l-0.322,1.679c-0.018,0.094-0.051,0.185-0.096,0.269l-0.149,0.272 c-0.03,0.054-0.065,0.106-0.105,0.153l-0.596,0.707l-0.028,0.045l-0.048,0.228c-0.017,0.079-0.044,0.155-0.08,0.227l-0.408,0.803 l0.032,1.046c0.001,0.046-0.001,0.091-0.006,0.136l-0.039,0.333c-0.014,0.118-0.05,0.232-0.107,0.336l-1.268,2.322l-0.07,0.301 c-0.053,0.227-0.189,0.425-0.381,0.556L215.8,83.14l-0.81,0.789c-0.061,0.059-0.13,0.11-0.204,0.15l-0.435,0.236 c-0.078,0.042-0.162,0.073-0.249,0.092l-0.319,0.068c-0.046,0.01-0.093,0.016-0.141,0.019l-1.799,0.102 c-0.018,0.001-0.035,0.002-0.053,0.002c-0.045,0-0.091-0.003-0.135-0.01l-0.691-0.102c-0.238-0.035-0.453-0.162-0.599-0.353 l-0.415-0.541c-0.046-0.06-0.084-0.125-0.114-0.194c-0.05,0.058-0.107,0.11-0.171,0.155l-0.578,0.405 c-0.144,0.101-0.313,0.159-0.489,0.167l-0.741,0.034c-0.014,0.001-0.028,0.001-0.042,0.001c-0.131,0-0.261-0.028-0.38-0.082 l-0.697-0.314c-0.318-0.144-0.529-0.454-0.545-0.803l-0.043-0.947l-0.027,0.073c-0.094,0.256-0.297,0.457-0.554,0.55l-0.632,0.229 c-0.103,0.037-0.21,0.055-0.315,0.055c-0.266,0-0.525-0.115-0.705-0.325l-0.281-0.329c-0.119-0.139-0.194-0.311-0.215-0.493 l-0.08-0.681c-0.005-0.047-0.007-0.094-0.006-0.142l0.052-1.413c0.001-0.04,0.006-0.081,0.012-0.12l0.106-0.628 c0.006-0.034,0.013-0.067,0.023-0.1l0.269-0.942c0.012-0.044,0.028-0.086,0.047-0.128l0.355-0.783 c0.094-0.207,0.26-0.372,0.468-0.464l0.359-0.159c0.12-0.053,0.248-0.08,0.376-0.08c0.137,0,0.274,0.03,0.401,0.091l0.456,0.219 h0.878c0.113,0,0.223,0.021,0.327,0.059c0.089-0.059,0.186-0.101,0.287-0.126l-0.296-0.784c-0.072-0.192-0.079-0.402-0.019-0.598 l0.184-0.602c0.061-0.198,0.185-0.369,0.353-0.487l-0.039-0.361c-0.014-0.133,0.001-0.267,0.043-0.394l0.06-0.178l-0.08-0.01 c-0.041-0.005-0.082-0.013-0.122-0.023l-2.253-0.591c-0.022-0.006-0.043-0.012-0.064-0.019l-3.339-1.138 c-0.018-0.006-0.036-0.013-0.054-0.02l-4.435-1.829L195.273,68.53z").attr({id: 'magdalena', class: 'st29', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#A3D9EF'}).data({'id': 'magdalena', 'region':'Magdalena', 'benefited-companies':'8', 'benefited-projects': '$260.000.000'});

        var laguajira = rsr.path("M251.928,63.228c-0.023,0.073-0.055,0.143-0.096,0.208l-0.237,0.382 c-0.087,0.14-0.209,0.254-0.355,0.331l-0.277,0.146l-0.041,0.033l-0.504,0.68c-0.047,0.064-0.102,0.121-0.164,0.17l-0.242,0.195 c-0.059,0.048-0.124,0.088-0.192,0.119l-0.281,0.13c-0.018,0.008-0.037,0.016-0.056,0.024l0.046,0.238 c0.007,0.036,0.012,0.073,0.014,0.11l0.036,0.499c0.005,0.077,0.001,0.154-0.012,0.23l-0.093,0.519l-0.083,2.356 c-0.004,0.108-0.027,0.215-0.067,0.315l-0.255,0.63l-0.227,1.001l-0.024,0.283l0.012,0.072l0.449,0.721 c0.023,0.037,0.043,0.076,0.061,0.116l0.252,0.57c0.038,0.087,0.063,0.179,0.073,0.274l0.2,1.837l0.752,2.598l6.222-0.858 c0.042-0.006,0.084-0.009,0.126-0.009c0.012,0,0.024,0,0.035,0.001l2.958,0.113c0.051,0.002,0.102,0.008,0.152,0.018l0.952,0.197 l1.204,0.086c0.034,0.002,0.067,0.007,0.101,0.013l1.499,0.274l0.658-0.055c0.026-0.002,0.051-0.003,0.077-0.003 c0.188,0,0.373,0.057,0.528,0.165l0.607,0.422c0.09,0.063,0.169,0.141,0.232,0.232l0.54,0.776c0.054,0.077,0.095,0.162,0.124,0.252 l0.242,0.771c0.017,0.053,0.029,0.108,0.035,0.163l0.156,1.259c0.006,0.05,0.008,0.101,0.006,0.152L267.05,82.5 c-0.004,0.087-0.019,0.172-0.047,0.255l-0.179,0.539l-0.016,0.109l0.03,0.056l0.956,0.292c0.072,0.022,0.141,0.052,0.205,0.091 l1.118,0.669l1.252,0.331c0.08,0.021,0.158,0.053,0.23,0.095l1.839,1.071c0.05,0.029,0.098,0.063,0.141,0.101l1.743,1.514 c0.068,0.059,0.127,0.128,0.176,0.205l0.465,0.736c0.2,0.316,0.19,0.721-0.025,1.027l-0.46,0.654l-0.19,0.439l-0.348,1.063 c-0.038,0.116-0.099,0.224-0.179,0.317l-0.51,0.592l-0.468,1.461c-0.07,0.219-0.22,0.404-0.419,0.519l-0.381,0.22l-0.799,1.446 c-0.085,0.154-0.212,0.28-0.366,0.364l-0.058,0.032c0.052,0.041,0.1,0.087,0.143,0.138l0.506,0.609 c0.051,0.061,0.093,0.128,0.127,0.2l0.308,0.659c0.021,0.046,0.039,0.094,0.053,0.142l0.063,0.225l0.09-0.027l0.736-0.316 c0.072-0.031,0.148-0.053,0.225-0.065l0.916-0.14c0.047-0.007,0.094-0.011,0.141-0.011c0.067,0,0.134,0.007,0.199,0.022 l0.703,0.155c0.062,0.014,0.123,0.034,0.181,0.06l0.68,0.306l0.477,0.087l0.685,0.03l0.696-0.097l0.64-0.158l1.66-0.712 c0.06-0.026,0.122-0.045,0.186-0.058l0.548-0.108l0.241-0.655c0.031-0.084,0.074-0.163,0.127-0.234l0.71-0.95 c0.024-0.032,0.051-0.063,0.079-0.092l0.715-0.733l0.517-0.692l0.793-2.302c0.038-0.11,0.096-0.212,0.172-0.301l2.764-3.229 l1.144-1.875l2.172-6.246c0.014-0.041,0.031-0.08,0.051-0.118l1.057-2.062c0.034-0.067,0.077-0.129,0.126-0.186l1.199-1.376 c0.049-0.056,0.105-0.107,0.166-0.15l1.932-1.355l0.739-0.717l0.71-0.978l1.529-3.789c0.027-0.066,0.061-0.129,0.102-0.187 l0.37-0.525c0.023-0.033,0.049-0.065,0.076-0.095l0.822-0.89l0.218-0.31l0.056-0.197l0.035-0.781 c0.006-0.127,0.037-0.251,0.093-0.365l0.205-0.42c0.072-0.147,0.181-0.272,0.316-0.362l0.814-0.546 c0.112-0.075,0.24-0.125,0.373-0.146l0.982-0.153c0.034-0.005,0.068-0.009,0.103-0.01l1.816-0.078l2.399-0.897 c0.044-0.017,0.089-0.03,0.135-0.039l0.918-0.191c0.062-0.013,0.126-0.02,0.189-0.02c0.033,0,0.065,0.002,0.097,0.005l0.89,0.094 c0.047,0.005,0.093,0.014,0.139,0.026l1.465,0.387l0.269-0.069l0.233-0.292l1.321-2.475l1.364-2.553l1.361-2.552l1.362-2.551 l1.361-2.552l1.362-2.552l1.361-2.553l1.362-2.554l0.46-0.863c0.017-0.032,0.036-0.063,0.056-0.092l0.791-1.139 c0.066-0.095,0.148-0.176,0.244-0.241l0.892-0.6c0.086-0.058,0.182-0.101,0.283-0.128l1.18-0.308l2.676-0.699l2.675-0.701 l2.677-0.699l2.674-0.699l2.675-0.701l2.68-0.697l2.672-0.701l2.676-0.702l1.167-0.303l1.622-0.701l1.455-1.251 c0.047-0.041,0.099-0.076,0.153-0.107l0.814-0.453c0.138-0.077,0.293-0.117,0.451-0.117c0.008,0,0.017,0,0.025,0l0.77,0.021 l0.8-2.247c0.016-0.046,0.036-0.09,0.059-0.132l0.217-0.399c0.13-0.239,0.358-0.408,0.625-0.464l0.531-0.111l0.647-0.244 l0.468-0.256l0.814-0.906c0.069-0.077,0.151-0.142,0.242-0.192l3.098-1.709l1.07-0.802l0.433-0.567l0.477-0.833l0.18-0.673 l-0.168-0.525l-1.656-2.47c-0.061-0.091-0.105-0.192-0.131-0.298l-0.275-1.134l-2.7-4.628c-0.054-0.093-0.092-0.194-0.111-0.3 l-0.137-0.744l-0.097-0.178l-0.153-0.192c-0.022-0.028-0.043-0.057-0.062-0.088l-0.396-0.637l-0.688-0.511l-1.337-0.682 l-1.963-0.382c-0.048-0.009-0.096-0.023-0.142-0.04l-0.927-0.341c-0.086-0.032-0.167-0.076-0.24-0.131l-0.828-0.627L350.92,7.81 l-1.422,0.03c-0.007,0-0.013,0-0.019,0c-0.086,0-0.172-0.012-0.254-0.036l-0.593-0.169c-0.09-0.026-0.175-0.065-0.253-0.116 l-0.314-0.206c-0.051-0.034-0.099-0.072-0.143-0.116l-0.559-0.551l-1.285-0.852l-0.78-0.365l-0.728-0.145h-3.222 c-0.061,0-0.122-0.006-0.181-0.018l-0.116-0.023c0.01,0.227-0.063,0.455-0.215,0.636l-0.448,0.535 c-0.088,0.105-0.198,0.189-0.322,0.246l-0.597,0.276c-0.034,0.016-0.07,0.03-0.106,0.041l-0.543,0.174l-0.262,0.145 c0.008,0.095,0.001,0.192-0.021,0.288l-0.074,0.318c-0.019,0.082-0.049,0.161-0.09,0.235l-0.178,0.325 c-0.016,0.029-0.033,0.057-0.052,0.083l-0.119,0.171c-0.173,0.249-0.457,0.397-0.76,0.397h-0.284c-0.406,0-0.765-0.265-0.885-0.653 l-0.12-0.389l-0.064-0.053l-0.039,0.221c-0.02,0.112-0.06,0.22-0.119,0.317l-0.322,0.534c-0.065,0.108-0.151,0.201-0.252,0.274 l-0.557,0.401c-0.033,0.024-0.068,0.045-0.104,0.065l-0.842,0.451c-0.073,0.039-0.151,0.068-0.232,0.087l-0.167,0.038 c-0.041,0.009-0.082,0.016-0.123,0.019l-0.009,0.024c-0.1,0.274-0.323,0.485-0.602,0.569l-0.678,0.205 c-0.087,0.026-0.178,0.04-0.268,0.04c-0.032,0-0.064-0.002-0.096-0.005l-0.236-0.025c-0.121-0.013-0.239-0.049-0.346-0.107 l-0.332-0.181c-0.095-0.052-0.181-0.12-0.253-0.202l-0.593-0.673c-0.085-0.097-0.148-0.208-0.186-0.328 c-0.031,0.037-0.065,0.071-0.101,0.102l-1.538,1.331c0.01,0.004,0.019,0.007,0.029,0.011l0.572,0.23 c0.127,0.051,0.24,0.129,0.333,0.229l0.28,0.302c0.028,0.03,0.054,0.063,0.078,0.096l0.168,0.238l0.357,0.281 c0.387,0.305,0.467,0.86,0.183,1.262l-0.013,0.018l0.143,0.184c0.056,0.072,0.101,0.152,0.134,0.237l0.184,0.479 c0.088,0.23,0.081,0.485-0.019,0.71l-0.201,0.449c-0.13,0.292-0.402,0.496-0.718,0.54l-0.491,0.068 c-0.042,0.006-0.085,0.009-0.128,0.009c-0.036,0-0.072-0.002-0.107-0.006l-0.541-0.063l-0.303,0.016l-0.114,0.062l-0.223,0.225 l-0.168,0.291l-0.089,0.457c-0.048,0.243-0.191,0.457-0.397,0.594l-0.232,0.154c-0.039,0.026-0.08,0.049-0.123,0.069l-1.354,0.627 c-0.123,0.057-0.256,0.086-0.389,0.086s-0.265-0.028-0.388-0.085l-0.803-0.37c-0.171-0.079-0.313-0.208-0.409-0.369l-0.566-0.956 l-0.454-0.241c-0.256-0.136-0.434-0.384-0.48-0.67c-0.046-0.286,0.044-0.578,0.244-0.787L323.393,14l-0.365-0.082l-4.504,0.802 c-0.054,0.01-0.108,0.014-0.162,0.014c-0.107,0-0.214-0.019-0.316-0.055l-1.016-0.368l-0.378,0.219l0.33,0.29 c0.051,0.045,0.098,0.096,0.138,0.151l0.26,0.357c0.079,0.108,0.133,0.232,0.159,0.364l0.191,0.958 c0.008,0.038,0.013,0.077,0.016,0.116l0.187,2.627c0.003,0.046,0.003,0.091,0,0.137l-0.07,0.912 c-0.01,0.133-0.049,0.262-0.114,0.378l-0.312,0.563c-0.021,0.037-0.044,0.073-0.069,0.107l-0.921,1.226l-0.413,1.405 c-0.024,0.083-0.06,0.162-0.107,0.236l-1.574,2.475l-0.517,1.509l-0.066,0.345c-0.011,0.056-0.026,0.111-0.047,0.164l-0.19,0.486 c-0.046,0.119-0.117,0.227-0.207,0.317l-0.8,0.803l-0.536,0.688c-0.1,0.129-0.233,0.229-0.384,0.29l-2.318,0.937l-1.892,1.379 c-0.097,0.071-0.207,0.122-0.323,0.151l-1.271,0.315l-1.004,0.842c-0.04,0.034-0.084,0.064-0.129,0.091l-0.724,0.421 c-0.072,0.042-0.15,0.074-0.231,0.095l-0.849,0.222c-0.066,0.017-0.134,0.027-0.202,0.03l-2.583,0.092l-0.783,0.268l-0.894,0.627 c-0.036,0.025-0.073,0.048-0.113,0.068l-0.968,0.491c-0.131,0.067-0.275,0.1-0.419,0.1c-0.088,0-0.176-0.012-0.261-0.038 l-0.5-0.147l-1.018,0.737c-0.048,0.034-0.098,0.064-0.151,0.089l-0.712,0.332c-0.062,0.029-0.128,0.051-0.195,0.066l-2.722,0.592 l-1.527,0.529l-0.697,0.421l-7.908,6.498c-0.048,0.039-0.099,0.074-0.154,0.103l-5.405,2.868l-2.512,2.406 c-0.075,0.072-0.162,0.131-0.257,0.174l-1.403,0.639l-0.316,0.272l-0.576,0.811c-0.033,0.047-0.071,0.09-0.112,0.13l-0.399,0.385 c-0.106,0.102-0.235,0.178-0.377,0.22l-0.314,0.094l-0.416,0.855c-0.032,0.066-0.072,0.127-0.118,0.184L268.51,56.2 c-0.039,0.047-0.082,0.09-0.129,0.129l-0.232,0.19c-0.043,0.035-0.088,0.066-0.136,0.092l-1.115,0.619l-1.231,0.942l-0.214,0.29 c-0.076,0.103-0.173,0.189-0.284,0.253l-0.448,0.258c-0.099,0.057-0.207,0.095-0.32,0.112l-5.028,0.781 c-0.047,0.007-0.094,0.011-0.141,0.011l-6.445,0.007l0.023,0.339c0.008,0.116-0.006,0.233-0.041,0.344L251.928,63.228z").attr({id: 'laguajira', class: 'st30', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#004A47'}).data({'id': 'laguajira', 'region':'La Guajira', 'benefited-companies':'8', 'benefited-projects': '$220.000.000'});

        var cundinamarca = rsr.path("M272.898,364.866c-0.118,0.066-0.249,0.106-0.383,0.116l-1.885,0.145 c-0.024,0.002-0.047,0.003-0.071,0.003c-0.116,0-0.23-0.022-0.338-0.064l-1.729-0.678l-0.868-0.03 c-0.378-0.013-0.709-0.254-0.839-0.609l-0.295-0.81c-0.023-0.062-0.039-0.127-0.047-0.192l-0.123-0.906l-0.165-0.059l-0.283-0.017 l-0.275,0.011l-0.704,0.217c-0.089,0.027-0.181,0.041-0.273,0.041c-0.036,0-0.073-0.002-0.109-0.006l-0.543-0.064 c-0.211-0.025-0.407-0.121-0.555-0.274l-0.363-0.373c-0.076-0.078-0.137-0.168-0.182-0.268l-0.207-0.462l-0.712-1.262l-1.465-0.523 c-0.292-0.104-0.512-0.347-0.587-0.648l-0.075-0.298c-0.038-0.151-0.037-0.309,0.003-0.46l0.084-0.318l-0.077-0.12l-0.611-0.69 c-0.033-0.038-0.064-0.078-0.091-0.121l-0.594-0.945l-0.137-0.097l-1.068-0.33l-3.632-0.072c-0.294-0.006-0.568-0.151-0.738-0.391 l-1.006-1.422c-0.111-0.156-0.17-0.343-0.17-0.535v-0.598c0-0.15,0.037-0.298,0.106-0.431l1.287-2.448l-0.124-1.215 c-0.033-0.327,0.109-0.647,0.373-0.841l1.457-1.069l-0.528-0.968c-0.053-0.097-0.088-0.203-0.104-0.313l-0.14-0.986 c-0.02-0.138-0.008-0.279,0.035-0.413l0.13-0.405l-0.04-0.142l-1.066-1.835c-0.04-0.07-0.072-0.144-0.093-0.222l-0.337-1.238 c-0.032-0.118-0.041-0.242-0.025-0.364l0.117-0.898l-0.508-0.89l-0.126-0.157l-0.68-0.572l-1.185-0.928 c-0.116-0.091-0.208-0.207-0.27-0.341l-0.25-0.542c-0.026-0.056-0.046-0.114-0.06-0.174l-0.154-0.647 c-0.017-0.073-0.026-0.148-0.025-0.224l0.005-0.476c0.001-0.093,0.016-0.185,0.044-0.274l0.212-0.659 c0.014-0.044,0.031-0.086,0.051-0.127l0.033-0.067l-0.014-0.02c-0.096-0.136-0.153-0.294-0.166-0.459l-0.081-0.06 c-0.022-0.017-0.044-0.034-0.064-0.052l-1.903-1.698c-0.09-0.081-0.164-0.178-0.217-0.287l-0.399-0.824l-0.519-0.007 c-0.109-0.001-0.217-0.022-0.319-0.061l-0.714-0.274c-0.114-0.044-0.218-0.109-0.306-0.193l-0.674-0.64l-0.483,0.112 c-0.069,0.016-0.14,0.024-0.21,0.024c-0.14,0-0.278-0.032-0.405-0.093l-2.384-1.161c-0.319-0.155-0.521-0.478-0.521-0.833v-1.478 l-0.82,0.724l-2.243,2.321l0.004,0.453c0.001,0.107-0.017,0.213-0.052,0.313l-0.349,0.997c-0.1,0.286-0.333,0.505-0.625,0.586 l-1.069,0.299l-2.816,2.596c-0.175,0.161-0.401,0.245-0.628,0.245c-0.154,0-0.309-0.038-0.451-0.117l-1.976-1.102l-0.502-0.049 c-0.134-0.013-0.264-0.055-0.38-0.123l-0.714-0.419c-0.04-0.023-0.078-0.05-0.114-0.079l-0.492-0.398 c-0.075-0.061-0.14-0.133-0.193-0.214l-0.464-0.712c-0.09-0.139-0.142-0.298-0.149-0.463l-1.247,0.067 c-0.017,0.001-0.033,0.001-0.05,0.001c-0.102,0-0.204-0.017-0.301-0.05l-0.499-0.172c-0.043-0.015-0.085-0.033-0.125-0.053 l-0.844-0.437l-1.287-0.731l-0.745-0.026l-0.519,0.045c-0.027,0.002-0.053,0.003-0.08,0.003c-0.264,0-0.518-0.113-0.694-0.314 l-0.276-0.313c-0.111-0.126-0.186-0.28-0.217-0.446l-0.071-0.388c-0.016-0.088-0.019-0.178-0.01-0.267l0.088-0.801l0.002-0.095 l-0.212-0.57l-1.809-1.751c-0.077-0.074-0.14-0.161-0.187-0.257l-0.625-1.274c-0.042-0.086-0.071-0.178-0.085-0.273l-0.068-0.464 c-0.013-0.088-0.013-0.177-0.001-0.266l0.08-0.562c0.016-0.114,0.054-0.225,0.111-0.325l0.566-1.001 c0.027-0.048,0.059-0.094,0.095-0.137l0.297-0.356l0.038-0.161l-0.005-0.027l-0.224-0.313c-0.054-0.075-0.096-0.158-0.126-0.246 l-0.237-0.709c-0.038-0.114-0.054-0.234-0.046-0.354l0.048-0.737l-0.037-0.457l-0.021-0.105l-0.213-0.29 c-0.079-0.108-0.134-0.232-0.161-0.364l-0.089-0.438c-0.013-0.064-0.019-0.128-0.018-0.193l0.004-0.359 c-0.076-0.047-0.146-0.105-0.205-0.172l-0.15-0.167c-0.07-0.079-0.127-0.169-0.167-0.267l-0.087-0.213 c-0.01-0.025-0.02-0.051-0.028-0.077l-0.005-0.016l-0.082,0.054l-1.334,1.152c-0.035,0.031-0.073,0.058-0.113,0.083l-0.625,0.393 l-0.392,0.31c-0.092,0.073-0.197,0.128-0.31,0.161l-1.12,0.334c-0.086,0.026-0.176,0.039-0.265,0.039 c-0.063,0-0.126-0.006-0.188-0.019l-2.14-0.445c-0.025-0.005-0.05-0.011-0.074-0.019l-0.625-0.185 c-0.04-0.012-0.08-0.027-0.118-0.044l-0.568-0.256l-0.474-0.079l-0.347,0.271c-0.058,0.045-0.121,0.083-0.188,0.114l-1.067,0.484 c-0.071,0.032-0.145,0.055-0.222,0.069l-2.374,0.418l-0.07,0.032v0.804l0.137,0.068c0.423,0.21,0.62,0.706,0.457,1.149 l-0.084,0.227c-0.027,0.072-0.062,0.141-0.105,0.204l-0.139,0.202l-0.234,0.508c-0.015,0.033-0.033,0.066-0.052,0.097l-0.013,0.021 c0.035,0.048,0.065,0.1,0.09,0.154l0.256,0.556c0.084,0.183,0.106,0.388,0.064,0.584l-0.269,1.239 c-0.011,0.05-0.026,0.098-0.044,0.146l-0.421,1.059c0.116,0.077,0.214,0.179,0.286,0.3l0.189,0.318 c0.221,0.373,0.154,0.85-0.162,1.147l-0.302,0.284c-0.126,0.119-0.283,0.2-0.453,0.234c0.022,0.034,0.042,0.07,0.059,0.107 c0.112,0.237,0.118,0.511,0.016,0.753l-0.236,0.562l-0.051,0.603l0.084,0.65l0.221,0.617c0.092,0.258,0.066,0.543-0.072,0.78 c-0.124,0.212-0.326,0.365-0.561,0.428l0.074,0.355c0.048,0.228,0.007,0.466-0.113,0.666l-0.153,0.252 c-0.069,0.115-0.163,0.214-0.274,0.29l-0.275,0.187l-0.089,0.081l-0.273,0.954c-0.02,0.068-0.047,0.134-0.082,0.196l-0.79,1.416 l-0.166,0.769c-0.023,0.107-0.065,0.208-0.123,0.301l-0.149,0.235c-0.041,0.064-0.09,0.124-0.145,0.176l-0.714,0.677 c-0.027,0.026-0.056,0.05-0.086,0.072l0.262,0.866c0.022,0.074,0.035,0.151,0.039,0.229l0.313,7.4 c0.003,0.079-0.003,0.158-0.02,0.236l-0.597,2.746l-0.028,0.678l0.086,0.251l0.6,0.98c0.02,0.033,0.039,0.068,0.055,0.103 l0.134,0.298c0.155,0.344,0.086,0.748-0.176,1.021l-0.245,0.256c-0.082,0.086-0.181,0.155-0.289,0.204l-0.62,0.278l0.399,1.166 c0.036,0.105,0.053,0.216,0.049,0.328l-0.014,0.477c-0.003,0.1-0.022,0.2-0.057,0.294l-0.087,0.236l0.051,0.095 c0.129,0.242,0.144,0.528,0.042,0.781c-0.102,0.254-0.311,0.45-0.572,0.535l-0.253,0.083l-0.01,0.014l-0.058,0.296l0.014,0.523 l0.338,2.156c0.023,0.148,0.01,0.3-0.038,0.442l-0.2,0.59c-0.041,0.122-0.107,0.233-0.194,0.328l-0.452,0.493l-0.069,0.262 c-0.008,0.032-0.019,0.064-0.03,0.095l-0.194,0.506c-0.081,0.211-0.236,0.385-0.436,0.49l-0.469,0.245 c-0.048,0.025-0.098,0.046-0.15,0.062l-0.458,0.145l-0.193,0.122l-0.023,0.044l0.001,0.003l0.556,0.841 c0.086,0.129,0.137,0.278,0.15,0.433l0.013,0.149c0.009,0.103,0,0.207-0.025,0.307l-0.007,0.027 c0.002,0.001,0.004,0.002,0.006,0.003l0.28,0.124c0.233,0.103,0.413,0.298,0.498,0.538l0.121,0.341 c0.065,0.184,0.071,0.385,0.015,0.572l-0.158,0.534c-0.036,0.123-0.098,0.237-0.181,0.335l-0.602,0.711 c0.115,0.113,0.198,0.255,0.242,0.411l0.079,0.284c0.109,0.39-0.05,0.792-0.366,1.011l0.344,1.102 c0.03,0.097,0.044,0.199,0.042,0.301l-0.05,1.84c-0.002,0.075-0.013,0.149-0.033,0.221l-0.485,1.757 c-0.013,0.046-0.029,0.091-0.049,0.135l-3.182,7.05l-0.08,0.63l0.311-0.025l1.247-0.291c0.043-0.01,0.088-0.017,0.132-0.021 l0.967-0.082l1.08-0.188c0.053-0.009,0.106-0.014,0.159-0.014c0.196,0,0.388,0.062,0.548,0.179c0.203,0.149,0.337,0.374,0.37,0.624 l0.007,0.056l0.633,0.337c0.031,0.017,0.061,0.035,0.09,0.055l0.191,0.131c0.11,0.076,0.203,0.175,0.271,0.289 c0.086-0.025,0.173-0.037,0.26-0.037c0.225,0,0.446,0.082,0.618,0.237l1.372,1.23l0.269,0.104l0.279,0.059l0.303-0.052 c0.052-0.009,0.104-0.013,0.156-0.013c0.051,0,0.102,0.004,0.153,0.013l0.276,0.046c0.015,0.003,0.031,0.006,0.046,0.009 l0.179-0.237c0.031-0.042,0.066-0.08,0.104-0.116l0.139-0.131l0.042-0.068l0.189-0.57c0.039-0.118,0.102-0.227,0.185-0.321 l0.254-0.287c0.062-0.071,0.135-0.131,0.216-0.18l0.4-0.241c0.045-0.027,0.092-0.05,0.141-0.07l1.226-0.479 c0.063-0.025,0.129-0.043,0.196-0.053l0.461-0.071c0.038-0.006,0.076-0.009,0.114-0.01l0.279-0.008c0.009,0,0.018,0,0.027,0 c0.147,0,0.293,0.035,0.424,0.103l0.45,0.232c0.082,0.042,0.157,0.096,0.223,0.161l0.244,0.238l0.333,0.309l0.782,0.612 c0.115,0.09,0.207,0.206,0.269,0.339l0.985,2.12l0.262,0.375c0.034,0.049,0.063,0.1,0.087,0.154l0.305,0.685 c0.035,0.079,0.059,0.163,0.071,0.248l0.068,0.487l0.275,1.088c0.028,0.109,0.035,0.222,0.022,0.333l-0.122,1.051 c-0.021,0.181-0.095,0.352-0.213,0.491l-0.568,0.672c-0.032,0.038-0.068,0.074-0.106,0.107l-0.216,0.184l-0.483,0.512l-0.202,0.393 l-0.144,0.429l-0.04,0.248l0.218,0.525c0.083,0.2,0.093,0.423,0.029,0.63l-0.427,1.375l0.703,1.242 c0.07,0.123,0.11,0.26,0.118,0.401l0.034,0.573c0.005,0.09-0.003,0.181-0.023,0.269l-0.199,0.841 c-0.008,0.034-0.018,0.068-0.03,0.1l-0.403,1.119c-0.016,0.045-0.036,0.089-0.059,0.131l-1.144,2.085l-0.466,2.798l0.867,1.079 l2.897-4.061l1.037-1.872l1.036-2.346l0.194-0.656l0.079-0.45l-0.003-0.273l-0.017-0.156l-0.236-0.66 c-0.048-0.135-0.08-0.276-0.094-0.419l-0.067-0.672c-0.01-0.096-0.011-0.194-0.005-0.29l0.022-0.336l-0.041-0.825 c-0.012-0.241,0.025-0.482,0.11-0.708l1.291-3.453c0.056-0.149,0.131-0.289,0.224-0.417l0.223-0.308 c0.105-0.145,0.231-0.273,0.375-0.38l0.381-0.285c0.314-0.235,0.686-0.352,1.059-0.352c0.37,0,0.739,0.116,1.052,0.347l0.484,0.358 l0.101-0.351l-0.027-1.631c-0.007-0.429,0.142-0.846,0.419-1.173l0.73-0.862l0.346-0.661l0.149-0.392l0.056-0.372l0.01-0.596 c0.001-0.081,0.008-0.161,0.021-0.24l0.355-2.29c0.013-0.087,0.033-0.172,0.059-0.256l0.173-0.554 c-0.175-0.11-0.332-0.252-0.462-0.422c-0.367-0.48-0.464-1.114-0.257-1.682l1.527-4.188l0.055-1.19l-0.35-1.276l-0.042-0.025 c-0.148-0.087-0.282-0.195-0.398-0.321l-0.235-0.254c-0.095-0.102-0.177-0.215-0.245-0.336l-0.554-0.988 c-0.427-0.761-0.236-1.72,0.451-2.259l1.147-0.9c0.106-0.083,0.221-0.154,0.343-0.211l0.034-0.016 c0.004-0.044,0.009-0.088,0.017-0.132l-0.009-0.043c-0.148-0.698,0.138-1.418,0.725-1.824l0.347-0.239l0.064-0.161 c0.196-0.489,0.599-0.864,1.097-1.025l0.648-1.539c0.083-0.198,0.202-0.38,0.351-0.535l0.311-0.326 c0.106-0.111,0.225-0.207,0.355-0.287c-0.115-0.674,0.17-1.379,0.773-1.776l0.165-0.109c0.293-0.193,0.632-0.291,0.972-0.291 c0.242,0,0.485,0.05,0.713,0.15l0.228,0.1c0.032-0.002,0.065-0.003,0.098-0.003c0.087,0,0.174,0.006,0.26,0.019l0.799,0.119 c0.143,0.021,0.284,0.06,0.417,0.116l1.245,0.516c0.82,0.34,1.262,1.234,1.033,2.092l-0.242,0.907l-0.047,0.571l0.099,3.235 l0.058,0.204c0.085,0.301,0.089,0.619,0.012,0.922l-0.043,0.169c0.542,0.302,0.909,0.882,0.909,1.547 c0,0.199-0.033,0.391-0.094,0.57l-0.789,2.786c-0.137,0.483-0.472,0.885-0.923,1.107l-0.364,0.179l-1.119,1.85 c-0.024,0.04-0.05,0.079-0.077,0.117l-0.473,0.658l-0.459,0.822c-0.116,0.208-0.273,0.39-0.462,0.536l-0.521,0.404l-0.012,0.044 l0.003,0.559l0.253,0.683l0.11,0.202c0.187,0.342,0.256,0.736,0.196,1.12l-0.205,1.32c-0.038,0.241-0.125,0.472-0.256,0.678 l-1.653,2.598l-0.028,0.117l-0.006,0.159l0.38,1.103l0.822,0.962c0.052,0.061,0.1,0.126,0.143,0.193l0.513,0.799 c0.043,0.067,0.082,0.138,0.116,0.21l0.426,0.916c0.136,0.292,0.189,0.616,0.155,0.936l-0.047,0.438 c-0.03,0.275-0.124,0.54-0.275,0.773l-0.4,0.617c-0.064,0.099-0.138,0.192-0.221,0.276l-0.368,0.376 c-0.093,0.095-0.196,0.178-0.307,0.25l-0.149,0.096l-0.079,0.881c-0.014,0.153-0.048,0.304-0.1,0.449l-0.256,0.699l0.039-0.003 l1.538-1.527c0.043-0.043,0.09-0.081,0.14-0.114l1.567-1.04l0.662-0.707c0.07-0.074,0.151-0.137,0.241-0.184l0.76-0.405 c0.076-0.04,0.157-0.07,0.242-0.088l0.686-0.147c0.043-0.009,0.087-0.015,0.131-0.018l0.545-0.037l0.406-0.102l0.17-0.213 l0.378-0.789c0.085-0.178,0.224-0.324,0.398-0.417l1.007-0.539c0.076-0.041,0.157-0.07,0.24-0.089l0.74-0.161l2.864-1.268 l0.296-0.283c0.028-0.026,0.057-0.051,0.088-0.074l0.44-0.327c0.159-0.118,0.351-0.182,0.549-0.182l1.037-0.004 c0.001,0,0.002,0,0.003,0c0.067,0,0.134,0.007,0.2,0.022l0.386,0.085l-0.103-0.351c-0.012-0.041-0.021-0.082-0.027-0.124 l-0.079-0.522c-0.005-0.033-0.008-0.067-0.01-0.101l-0.019-0.483l-0.205-0.425l-0.608-0.628c-0.127-0.131-0.212-0.297-0.246-0.477 l-0.086-0.47c-0.005-0.029-0.009-0.059-0.012-0.089l-0.039-0.454c-0.006-0.066-0.004-0.132,0.004-0.197l0.089-0.694l-0.443-2.058 l-0.425-0.444c-0.186-0.194-0.278-0.459-0.253-0.726l0.089-0.96c0.013-0.14,0.057-0.275,0.13-0.395l0.282-0.465 c0.019-0.032,0.04-0.062,0.063-0.091l0.477-0.608c0.056-0.071,0.122-0.134,0.196-0.186l0.333-0.234 c0.044-0.031,0.091-0.058,0.14-0.081l1.094-0.513l0.724-0.398l0.157-0.32c0.014-0.028,0.029-0.056,0.046-0.083l0.658-1.056 c0.046-0.073,0.101-0.14,0.165-0.197l0.455-0.412c0.107-0.096,0.234-0.167,0.373-0.205l0.562-0.156 c0.081-0.023,0.165-0.034,0.249-0.034c0.092,0,0.185,0.014,0.274,0.042l0.471,0.146c0.061,0.019,0.119,0.044,0.175,0.074 l0.487,0.27c0.079,0.044,0.151,0.099,0.214,0.163l0.329,0.337c0.049,0.05,0.092,0.106,0.129,0.166l0.095,0.156l0.093,0.079 l0.281-0.014c0.015-0.001,0.031-0.001,0.046-0.001c0.072,0,0.144,0.008,0.214,0.025l0.418,0.1c0.068,0.016,0.134,0.04,0.196,0.071 l0.409,0.202c0.171,0.085,0.312,0.22,0.404,0.388l0.462,0.852l0.494,0.555c0.021,0.024,0.042,0.049,0.061,0.076l0.625,0.871 c0.036,0.051,0.068,0.105,0.093,0.162l0.183,0.408c0.046,0.103,0.073,0.214,0.079,0.327l0.029,0.532l0.222,1.113l0.935,2.085 c0.041,0.092,0.068,0.191,0.077,0.292l0.029,0.308l0.007,0.01l0.243,0.217l0.369,0.215l0.622,0.232 c0.032,0.012,0.063,0.025,0.093,0.04l0.416,0.209l0.346,0.068l0.453-0.076l0.536-0.219l1.076-0.862 c0.138-0.111,0.306-0.18,0.482-0.198l2.878-0.302c0.032-0.003,0.064-0.005,0.097-0.005c0.076,0,0.151,0.009,0.225,0.028 l5.613,1.407c0.037,0.009,0.073,0.021,0.108,0.034l1.011,0.39c0.08,0.031,0.155,0.073,0.223,0.124l0.554,0.417 c0.121,0.091,0.217,0.21,0.282,0.347l0.183,0.391l0.444,0.232c0.034,0.018,0.066,0.037,0.097,0.059l1.027,0.71l0.072-0.635 l1.521-9.945l1.113-7.752L272.898,364.866z").attr({id: 'cundinamarca', class: 'st31', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#F49292'}).data({'id': 'cundinamarca', 'region':'Cundinamarca', 'benefited-companies':'46', 'benefited-projects': '$1.260.000.000'});

        var bogota = rsr.path("M 230.209,366.493 229.566,365.966 229.473,365.631 229.531,365.301 229.7,365.051 230.129,364.724 230.243,364.28 230.125,363.866 230.016,360.312 230.085,359.483 230.368,358.424 229.123,357.908 228.324,357.79 227.902,357.814 227.286,357.542 227.12,357.651 227.237,357.854 227.281,358.017 227.267,358.516 227.142,358.808 226.89,359.158 226.3,359.456 225.989,359.782 225.102,361.887 224.977,362.121 224.255,362.317 223.993,362.973 223.207,363.516 223.282,363.866 223.27,364.029 223.232,364.212 223.311,364.259 223.475,364.219 223.674,364.209 223.78,364.327 223.796,364.524 223.594,364.89 223.33,365.142 222.183,365.678 221.036,366.578 221.592,367.566 221.826,367.82 222.073,367.965 222.352,368.2 222.602,368.635 223.099,370.446 223.018,372.187 221.398,376.628 222.308,376.55 222.484,376.842 222.471,377.606 221.971,379.207 221.618,381.497 221.605,382.21 221.503,382.884 221.249,383.553 220.763,384.481 219.907,385.492 219.938,387.389 219.388,389.295 219.211,389.658 218.945,389.773 217.875,389.461 217.411,389.223 216.527,388.569 216.146,388.854 215.924,389.162 214.632,392.615 214.678,393.541 214.65,393.978 214.717,394.65 215.023,395.505 215.072,395.952 215.079,396.477 214.954,397.189 214.699,398.051 213.585,400.573 212.461,402.604 209.314,407.014 210.58,408.167 211.835,408.265 212.183,408.082 212.377,407.726 212.454,407.485 212.748,407.12 213.29,405.831 216.136,402.366 216.993,400.953 217.366,399.973 217.316,399.461 217.336,399.027 217.738,398.502 218.56,397.701 219.653,396.358 220.224,395.439 221.087,393.659 221.745,393.209 224.103,393.764 224.89,391.611 225.014,390.237 225.197,389.851 225.501,389.577 225.925,389.304 226.293,388.928 226.693,388.312 226.74,387.873 226.314,386.957 225.801,386.158 224.761,384.94 224.165,383.207 224.189,382.545 224.325,381.969 226.138,379.119 226.344,377.799 226.171,377.484 225.766,376.388 225.76,375.268 225.921,374.691 226.205,374.26 226.98,373.66 227.488,372.75 228.02,372.01 229.306,369.883 229.581,369.631 230.237,369.309 231.05,366.435 z").attr({id: 'bogota', class: 'st32', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#E55A5A'}).data({'id': 'bogota', 'region':'Bogotá D.C', 'benefited-companies':'240', 'benefited-projects': '$7.360.000.000'});

        var providenciawhitebg = rsr.path("M80.134,57.434c0.222,0.371,0.728,0.972,1.736,1.174 c0.18,0.361,0.756,1.529,1.126,2.362c0.037,0.125,0.07,0.329,0.047,0.505c-0.312,0.549-0.741,1.689-0.173,3.224 c0.103,0.723,0.491,1.353,1.069,1.758c0.08,0.335,0.271,0.899,0.707,1.386c0.088,0.166,0.195,0.322,0.32,0.463 c0.473,0.536,1.159,0.831,1.956,0.831h0.001l0.358-0.014c0.152-0.007,0.301-0.049,0.435-0.123l0.085-0.046 c0.09-0.019,0.204-0.032,0.325-0.037l0.238-0.005c1.507-0.015,2.05-0.811,2.514-1.697c0.005-0.008,0.011-0.021,0.017-0.037 l1.059-0.489c0.017-0.008,0.044-0.023,0.072-0.039c0.073-0.026,0.258-0.082,0.559-0.112c0.148,0.016,0.344,0.029,0.568,0.029 c1.039,0,1.956-0.292,2.653-0.844c1.042-0.826,1.565-1.534,1.999-2.704l0.067-0.181c0.017-0.045,0.03-0.091,0.04-0.138 c0.51-0.196,1.171-0.546,1.791-1.167l0.979-1.07c0.032-0.016,0.082-0.037,0.154-0.061c0.443-0.026,1.152-0.115,1.838-0.402 c1.067-0.058,2.05-0.617,2.739-1.56l0.056-0.042c0.135-0.101,0.242-0.235,0.312-0.389l0.106-0.235 c0.004-0.009,0.397-0.873,1.09-2.008c0.011-0.016,0.046-0.077,0.055-0.094c0.043-0.08,1.058-1.969,1.019-4.41 c0.008-0.194,0.008-1.288-0.729-3.839l-0.093-0.32c-0.034-0.115-0.087-0.222-0.157-0.316c-0.003-0.026-0.006-0.055-0.008-0.087 c0.008-0.062,0.019-0.122,0.03-0.178l1.396-0.794c0.526-0.223,1.61-0.868,1.949-2.499c0.008-0.037,0.019-0.123,0.022-0.16 l0.229-2.158c0.006-0.062,0.007-0.123,0.001-0.185l-0.01-0.108c-0.139-1.445-1.177-2.493-2.469-2.493 c-0.472,0-0.929,0.136-1.364,0.405c-0.064-0.138-0.171-0.388-0.321-0.805c-0.018-0.73-0.327-1.409-0.866-1.918 c-0.013-0.25-0.056-0.493-0.128-0.726c0.798-0.511,1.308-1.351,1.36-2.298c0.183-1.542-0.047-2.688-0.68-3.404 c-0.412-0.466-0.978-0.743-1.493-0.77c-0.362-0.059-1.621-0.191-2.399-0.039c-0.111-0.205-0.282-0.532-0.467-0.902 c-0.145-0.897-0.593-1.672-1.236-2.146l-0.318-0.526c-0.116-0.192-0.293-0.339-0.502-0.418l-0.3-0.113 c-0.744-0.302-1.551-0.333-2.242-0.086c-0.116-0.095-0.242-0.179-0.378-0.251c0.152-0.16,0.304-0.339,0.443-0.541 c0.709-0.941,0.887-2.025,0.476-2.896c-0.376-0.803-1.148-1.297-2.041-1.351c-0.333-0.047-0.991-0.107-2.077,0.299 c-0.872-0.3-1.868-0.082-2.572,0.596c-0.722,0.105-1.34,0.478-1.739,1.035c-1.416,0.115-2.433,1.174-2.454,2.603l-0.002,0.133 c-0.001,0.086,0.009,0.173,0.03,0.257l0.029,0.12c0.007,0.031,0.013,0.086,0.014,0.135c-0.734,1.219-0.728,3.002,0.747,4.263 c0.027,0.023,0.101,0.076,0.13,0.096c0.041,0.028,0.577,0.401,1.216,0.907c0.385,0.519,1.155,1.271,2.485,1.422 c0.036,0.004,0.125,0.007,0.162,0.007l0.36,0.001c0.408,0,1.062-0.004,1.652-0.028l0.11,1.008c0,0.004,0.03,0.458-0.238,1.084 l-0.571,1.107c-0.039,0.076-0.067,0.156-0.087,0.238l-0.014,0.049c-0.272-0.014-0.591-0.05-0.87-0.116 c-0.412-0.281-1.122-0.671-2.029-0.822c-0.185-0.044-0.477-0.097-0.824-0.097c-1.169,0-2.181,0.597-2.713,1.596 c-0.016,0.01-0.034,0.022-0.056,0.034c-0.612,0.23-1.48,0.803-2.304,2.187l-0.197,0.304c-0.757,0.589-1.188,1.543-1.19,2.628 c-0.228,0.202-0.699,0.657-0.975,1.169c-0.234,0.363-0.746,1.323-0.645,2.736c-0.02,0.037-0.045,0.083-0.078,0.137 c-0.898,1.479-0.804,3.131-0.416,4.183c0.045,0.123,0.068,0.406,0.064,0.539l-0.005,0.141c-0.004,0.091,0.006,0.182,0.027,0.27 l0.027,0.11c0.001,0.007,0.135,0.711-0.186,1.505l-0.057,0.141c-0.037,0.093-0.061,0.19-0.068,0.29l-0.114,1.358 c-0.28,0.365-0.648,1.006-0.625,1.837c0.007,0.278,0.06,0.556,0.154,0.819C79.714,56.242,79.81,56.894,80.134,57.434z").attr({id: 'providenciawhitebg' ,class: 'st0', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#ffffff'}).data('id', 'providenciawhitebg');

        var sanandreswhitebg = rsr.path("M41.088,84.423c-0.042,0.104-0.165,0.359-0.494,0.74 c-0.014,0.015-0.059,0.075-0.07,0.091c-0.091,0.119-0.66,0.865-1.35,1.688c-0.584,0.574-1.82,2.003-1.659,3.683 c0.059,0.621,0.103,0.859,0.224,1.214c0.028,0.082,0.067,0.206,0.153,0.616c0.002,0.007,0.162,0.739,0.128,1.561 c-0.046,1.095,0.152,1.919,0.621,2.562l0.02,0.134c-0.007,0.63,0.19,1.75,1.418,2.85c0.226,0.202,1.44,1.21,3.317,1.21l0.034-1l0,0 l0.105,0.999c0.065,0,0.225-0.027,0.288-0.041c0.805-0.167,1.768-0.644,2.319-1.502c1.353-0.249,2.003-1.117,2.368-1.603 c0.075-0.1,0.144-0.198,0.176-0.233c0.411-0.362,1.312-1.257,1.648-2.445c0.225-0.175,0.369-0.442,0.385-0.739l0.033-0.528 c0.518-0.511,0.854-1.301,1.005-2.39c0.004-0.032,0.007-0.094,0.009-0.146c0.011-0.072,0.072-0.378,0.355-0.784 c0.553-0.792,0.939-1.256,1.04-1.375l0.072-0.082c0.048-0.054,0.089-0.113,0.124-0.175l0.055-0.099 c0.093-0.167,0.559-1.066,0.646-2.346l0.008-0.109c0.003-0.031,0.003-0.062,0.003-0.093c0.022-0.025,0.044-0.052,0.063-0.08 l0.179-0.247c0.156-0.219,0.895-1.344,0.796-2.886l0.214-0.201c0.053-0.048,0.125-0.118,0.205-0.206 c0.154-0.115,0.273-0.287,0.345-0.475c0.304-0.545,0.348-1.153,0.121-1.727l-0.012-0.028l0.064-2.805 c0.163-0.627,0.475-2,0.503-3.449c0.008-0.441,0.012-0.816,0.011-1.126c0.324-0.451,0.545-0.973,0.65-1.553 c0.17-0.088,0.368-0.186,0.558-0.27c1.139-0.506,1.765-1.275,2.028-2.495l0.669-0.682c0.599-0.568,1.185-1.742,0.607-4.109 l-0.164-4.195l0.25-0.04c0.641-0.041,1.258-0.331,1.703-0.805c0.555-0.591,0.812-1.387,0.768-2.267 c0.021-0.413-0.006-1.463-0.669-2.605c-0.036-0.332-0.085-1.381,0.227-3.987c0.005-0.038,0.007-0.135,0.007-0.173l-0.004-2.962 c0.039-0.431-0.006-0.944-0.18-1.45c0.571-0.304,0.856-0.757,0.994-1.077c0.01-0.021,0.019-0.043,0.026-0.064 c0.773-0.301,1.29-0.794,1.539-1.472c0.23-0.624,0.17-1.318-0.129-1.832c-0.091-0.195-0.229-0.422-0.438-0.642 c0.327-0.404,0.778-1.152,0.7-2.144c-0.054-0.666-0.345-1.282-0.857-1.8c0.355-0.224,1.008-0.701,1.956-1.649l0.085-0.085 c0.05-0.049,0.093-0.104,0.131-0.163c0.057-0.033,0.185-0.087,0.412-0.097c0.021-0.001,0.109-0.008,0.131-0.01 c0.009,0,1.394-0.115,2.216-0.029c0.272,0.028,0.451,0.081,0.662,0.143c0.285,0.083,0.641,0.188,1.089,0.188 c0.577,0,1.139-0.181,1.697-0.558c0.021-0.015,0.072-0.053,0.093-0.069c0.269-0.213,0.59-0.505,0.867-0.862l0.896,0.292 c0.47,0.15,0.976-0.059,1.199-0.495c0.225-0.438,0.098-0.973-0.299-1.263l-1.22-0.893c-0.165-0.598-0.561-1.096-1.074-1.369 c-0.403-0.266-0.735-0.524-0.78-0.565l-0.21-0.244c-0.128-0.148-0.296-0.255-0.483-0.309l-0.371-0.105 c-0.006-0.002-0.631-0.154-1.077-0.344l-0.024-0.01c-0.219-0.166-0.413-0.323-0.549-0.444c-0.502-0.772-1.401-1.222-2.463-1.242 c-0.586-0.034-1.295-0.148-1.747-0.271c0.041-0.11,0.068-0.209,0.085-0.29c0.257-1.203-0.442-2.227-2.089-3.05 c-0.003-0.002-0.365-0.182-0.862-0.556c-0.898-1.234-2.555-1.744-4.341-1.253l-0.221,0.061c-0.145,0.04-0.278,0.112-0.392,0.211 l-0.161,0.141c-0.044,0.036-0.314,0.252-0.595,0.382c-0.949,0.328-3.198,1.3-3.598,3.245l-0.046,0.224 c-0.004,0.02-0.008,0.039-0.01,0.059c-0.081,0.192-0.33,0.671-1.032,1.451c-0.185,0.157-0.673,0.556-1.422,1.055 c-0.512,0.255-1.621,0.898-2.267,1.959c-0.014,0.021-0.061,0.12-0.072,0.142c-0.001,0.003-0.14,0.262-0.44,0.507 c-1.024,0.503-2.132,1.699-2.043,3.577c0.002,0.042,0.016,0.133,0.025,0.188c0.013,0.085,0.065,0.458,0.061,1.025 c-0.336,0.564-0.705,1.587-0.173,2.911c-0.384,0.762-0.384,1.654-0.384,2.119c0,0.041,0.012,0.149,0.017,0.19 c0.002,0.019,0.004,0.041,0.004,0.064l-0.122,0.142c-0.657,0.768-2.913,3.411-4.598,5.468c-0.738,0.64-2.117,2.414-1.113,6.257 l0.063,0.242c0.041,0.158,0.12,0.303,0.23,0.423l0.068,0.073c-0.043,0.49,0.024,1.172,0.482,1.904 c-0.19,0.529-0.198,1.095-0.169,1.582c-0.014,0.1-0.057,0.248-0.107,0.324c-0.629,0.644-0.947,1.69-0.974,3.19 c-0.062,0.244-0.28,0.993-0.925,2.647c-0.303,0.399-0.72,1.087-0.862,1.982c-0.248,0.422-0.479,1.044-0.453,1.879 c-0.058,1.255,0.689,2.725,2.525,3.101c0.031,0.015,0.073,0.038,0.127,0.069c0.238,0.274,0.607,0.621,1.115,0.886 c-0.045,0.726,0.209,1.441,0.7,1.985c0.015,0.172,0.056,0.392,0.15,0.628c-0.176,0.556-0.219,1.164-0.243,1.713 c-0.055,1.238-0.071,1.375-0.228,2.693l-0.002,0.01c-0.27,0.744-0.683,2.33,0.085,3.692c0.002,0.021,0.004,0.049,0.004,0.086 c0,0.238,0.015,0.461,0.031,0.682c0.031,0.406,0.031,0.406-0.048,0.547C41.332,83.121,41.104,83.818,41.088,84.423z").attr({id: 'sanandreswhitebg', class: 'st0', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#ffffff'}).data('id', 'sanandreswhitebg');

        var sanandresyprovidencia = rsr.path("M108.692,40.807l-0.217,2.049c-0.186,0.9-0.838,1.056-0.838,1.056l-1.801,1.024 c-0.652,0.124-0.776,1.708-0.776,1.708c0.031,0.993,0.341,1.335,0.341,1.335c0.683,2.36,0.652,3.26,0.652,3.26 c0.031,1.987-0.776,3.477-0.776,3.477c-0.776,1.273-1.211,2.235-1.211,2.235l-0.124,0.093c-0.714,1.211-1.708,0.932-1.708,0.932 c-0.621,0.435-1.708,0.435-1.708,0.435c-0.993,0.248-1.273,0.652-1.273,0.652l-0.993,1.087c-0.683,0.683-1.49,0.807-1.49,0.807 c-0.869,0.186-0.838,1.366-0.838,1.366c-0.311,0.838-0.621,1.242-1.366,1.832c-0.745,0.59-1.925,0.373-1.925,0.373 c-1.087,0.062-1.584,0.372-1.584,0.372l-1.211,0.559c-0.559,0.248-0.776,0.9-0.776,0.9c-0.341,0.652-0.28,0.528-1.025,0.559 c-0.745,0.031-1.087,0.217-1.087,0.217c-0.652,0.031-0.59-0.466-0.59-0.466c-0.404-0.155-0.497-0.745-0.497-0.745 c0.031-0.776-0.621-1.025-0.621-1.025c-0.466-0.155-0.404-0.652-0.404-0.652c-0.59-1.273,0.031-1.925,0.031-1.925 c0.404-1.056-0.031-2.111-0.031-2.111c-0.466-1.056-1.242-2.608-1.242-2.608c-0.435-1.056-1.149-0.932-1.149-0.932 c-0.9-0.062-0.621-0.683-0.621-0.683l0.124-0.745c-0.59-0.528,0.031-1.149,0.031-1.149c0.621-0.559,0.341-1.056,0.341-1.056 l0.093-1.118c0.59-1.459,0.279-2.701,0.279-2.701s0.031-0.714-0.186-1.304c-0.217-0.59-0.279-1.583,0.248-2.453 c0.528-0.869,0.372-1.211,0.372-1.211c-0.124-1.025,0.342-1.646,0.342-1.646c0.186-0.372,0.621-0.745,0.621-0.745 c0.621-0.186,0.652-1.428,0.652-1.428c0-1.056,0.621-1.211,0.621-1.211l0.466-0.714c0.776-1.304,1.397-1.397,1.397-1.397 c0.962-0.497,1.024-0.931,1.024-0.931c0.404-0.776,1.335-0.497,1.335-0.497c0.993,0.155,1.552,0.683,1.552,0.683 c0.963,0.341,2.143,0.31,2.143,0.31c1.304-0.248,1.583-1.49,1.583-1.49l0.528-1.025c0.559-1.273,0.435-2.174,0.435-2.174 l-0.186-1.707c-0.137-0.558-0.057-0.92,0.103-1.173l-0.502-0.572c-0.44,0.578-0.967,0.612-0.967,0.612 c-0.885,0.077-2.546,0.062-2.546,0.062c-0.823-0.093-1.164-0.792-1.164-0.792c-0.838-0.683-1.583-1.195-1.583-1.195 c-0.963-0.823-0.218-1.785-0.218-1.785c0.373-0.621,0.14-1.537,0.14-1.537c0.016-1.009,1.366-0.528,1.366-0.528 c0.512,0,0.605-0.543,0.605-0.543c0-0.73,0.745-0.621,0.745-0.621c0.543,0.016,0.761-0.419,0.761-0.419 c0.435-0.59,0.9-0.093,0.9-0.093c0.73,0.031,0.931-0.124,0.931-0.124c0.823-0.357,1.288-0.248,1.288-0.248 c1.009,0.031,0.202,1.071,0.202,1.071c-0.435,0.636-1.04,0.916-1.04,0.916c-0.636,0.326-0.435,1.087-0.435,1.087 c0.388,0.45,0.295,0.497,0.295,0.497c-0.031,0.031-0.047,0.621-0.047,0.621c0.186,0.264,0.248,0.217,0.248,0.217l0.978,0.078 c0.776,0.124,0.264,1.056,0.264,1.056c-0.326,0.636-0.373,1.009-0.373,1.009c-0.027,0.076-0.06,0.135-0.09,0.202l0.596,0.68 c0.353-0.195,0.751-0.183,0.751-0.183c0.652-0.59,0.466-1.615,0.466-1.615c0.372-1.118,1.37-0.661,1.441-0.634l0.422,0.696 c0.683,0.155,0.714,1.211,0.714,1.211s0.621,1.273,0.87,1.645c0.248,0.373,1.024,1.118,1.583,0.776 c0.559-0.342,2.111-0.062,2.111-0.062c0.683-0.031,0.435,1.987,0.435,1.987c-0.031,0.869-0.931,0.993-0.931,0.993l-0.994,0.59 c-0.497,0.714,0.186,1.025,0.186,1.025c0.745,0.31,0.435,1.118,0.435,1.118c-0.155,0.9,0.435,0.776,0.435,0.776 c0.652,0.342,0.466,0.901,0.466,0.901c0.559,1.646,0.807,1.863,0.807,1.863c0.528,0.59-0.186,0.838-0.186,0.838l-0.714,0.311 c-0.714,0.807,0.497,0.528,0.497,0.528c1.025-0.373,1.615-0.341,1.615-0.341c0.776-0.093,1.056-0.683,1.056-0.683 C108.568,39.503,108.692,40.807,108.692,40.807z M61.194,43.569c1.459,0.124,0.869-0.497,0.869-0.497s-0.9-0.435,0.559-0.652 c1.459-0.217,1.024-0.714,1.024-0.714c-0.186-0.528-1.428-0.466-1.428-0.466c-1.087-0.093-1.18-0.714-1.521-0.559 c-0.342,0.155-0.652-0.062-0.652-0.062c-0.342-0.714-0.621-0.776-0.621-0.776c-1.18-0.776-0.714-1.77-0.714-1.77 c0.248-1.242,1.273,0.217,1.273,0.217c1.149,0.435,0.497,0.838,0.497,0.838c0.528,1.304,1.273,1.352,1.273,1.352 s0.714,0.078,0.993-0.636c0,0-0.062-0.559,0.621-0.838c0,0,0.869-0.838-0.155-1.552l-0.869-0.466c0,0-1.087-0.87,0.124-1.708 c0,0,0.342-0.031,1.211-0.683c0,0,0.559-0.28,1.708-1.428c0,0,0.528-0.869,1.956-0.931c0,0,1.428-0.155,2.639-0.031 c1.211,0.124,1.428,0.575,2.096,0.124c0,0,1.258-0.993,0.559-1.32c0,0-0.978-0.637-1.257-0.978c0,0-0.776-0.186-1.397-0.45 c-0.621-0.264,0.031,0.093,0.031,0.093s-1.025-0.714-1.444-1.18c0,0-0.093-0.435-0.916-0.45c0,0-2.22-0.124-3.136-0.73 c0,0-1.04-1.273-1.016-1.283c0,0-0.435-0.807,0.311-0.838c0.745-0.031-0.031-0.621-0.714-0.963c0,0-0.652-0.31-1.49-0.993 c0,0-0.497-1.18-2.297-0.683c0,0-0.497,0.435-1.211,0.745c0,0-2.111,0.714-2.329,1.77c0,0,0.062,0.9-1.646,2.763 c0,0-0.652,0.59-1.832,1.366c0,0-1.087,0.497-1.521,1.211c0,0-0.342,0.776-1.242,1.397c0,0-1.117,0.373-1.055,1.677 c0,0,0.155,0.838,0.062,2.111c0,0-0.745,0.497-0.217,1.583c0,0,0.279,0.372-0.031,1.366c0,0-0.28,0.062-0.28,1.273 c0,0,0.186,1.366-0.559,1.739c0,0-2.804,3.268-4.729,5.628c0,0-1.491,0.869-0.59,4.316c0,0,0.373,0.404,0.497,1.149 c0,0-0.372,0.59,0.497,1.397c0,0,0.497,0.249,0,1.118c0,0-0.341-0.155-0.248,1.055c0,0,0,0.994-0.652,1.708 c0,0-0.435,0.31-0.435,2.018c0,0-0.062,0.652-1.18,3.477c0,0-0.714,0.714-0.652,1.708c0,0-0.466,0.279-0.403,1.149 c0,0-0.124,0.931,0.931,1.118c0,0,0.311,0,1.087,0.528c0,0,0.404,0.683,1.211,0.776c0,0,0.667-0.07,0.846,0.396 c0.179,0.466,1.7,0.14,1.7,0.14s0.031,0.357-1.428,0.636c0,0-0.466-0.101-0.567,0.435c0,0-0.148,0.567,0.458,0.854 c0,0,0.69,0.178,0.365,0.675c0,0-0.388,0.295,0.093,0.543c0,0,0.404,0.341-0.031,0.885c0,0-0.233,0.062-0.295,1.459 c-0.062,1.397-0.085,1.537-0.272,3.105c0,0-0.621,1.444-0.14,2.204c0,0,0.272,0.323,0.272,1.083c0,0.761,0.224,1.323-0.272,2.208 c-0.497,0.885-0.419,1.226-0.419,1.226s0.031,0.745-0.963,1.894c0,0-0.668,0.885-1.491,1.863c0,0-1.226,1.149-1.133,2.127 c0.093,0.978,0.093,0.404,0.342,1.599c0,0,0.217,0.947,0.171,2.065c-0.046,1.118,0.233,1.351,0.512,1.568l0.14,0.962 c0,0-0.155,0.636,0.745,1.444c0,0,0.792,0.714,2.003,0.699c0,0,0.9-0.186,1.118-0.776c0,0,0.124-0.606,1.102-0.714 c0.978-0.109,1.118-0.8,1.708-1.374c0,0,1.009-0.87,1.102-1.661c0.093-0.792,0.31-0.854,0.31-0.854s0.047-0.916,0.497-1.071 c0,0,0.357-0.125,0.513-1.242c0,0,0-0.838,0.714-1.863c0.714-1.024,1.18-1.552,1.18-1.552s0.341-0.621,0.404-1.521 c0,0-0.186-1.242,0.621-1.552c0,0,0.559-0.776,0.404-1.801c0,0,0-1.18,0.683-1.615c0.683-0.435,0.186,0.031,0.186,0.031 l0.093-4.067c0,0,0.465-1.584,0.497-3.198c0.031-1.614-0.015-1.863-0.015-1.863s0.637-0.373,0.73-1.273s0.528-1.013,0.528-1.013 s0.605-0.342,1.164-0.59c0.559-0.248,0.761-0.512,0.885-1.087c0,0-0.077-0.652,0.528-0.993l0.714-0.714c0,0,0.512-0.45,0-2.375 l-0.186-4.75c0,0-0.543-0.621,0.016-1.04c0,0,0.17-0.357,1.086-0.574l0.978-0.155c0,0,0.73,0.077,0.652-1.133 c0,0,0.093-0.792-0.481-1.677c0,0-0.512-0.373,0.046-5.03v-3.105c0,0,0.124-1.01-0.714-1.351l-0.776,0.093 c0,0-0.963-0.093-0.683-0.776c0,0-0.155-0.776,0.993-1.056C60.045,43.507,61.194,43.569,61.194,43.569z").attr({id: 'sanandresyprovidencia', class: 'st33', parent: 'colombiamap', 'stroke-width': '0', 'stroke-opacity': '1', 'fill': '#C6C4FF'}).data({'id': 'sanandresyprovidencia', 'region':'San Andrés y Providencia', 'benefited-companies':'2', 'benefited-projects': '$60.000.000'});

        colombiamap.attr({'id': 'colombia-map','name': 'colombiamap'});

        colombiamap.push( santander , risaralda , boyaca , nortedesantander , quindio , meta , casanare , bolivar , atlantico , cordoba , antioquia , arauca , vichada , putumayo , narino , vaupes , amazonas , guainia , cauca , choco , caqueta , valledelcauca , tolima , huila , guaviare , sucre , caldas , cesar , magdalena , laguajira , cundinamarca , bogota , sanandresyprovidencia );

        // animate and style
        var markup = _.template(document.getElementById('department-map-tpl').innerHTML);

        for (var i = 0; i < colombiamap.length; i++) {
            // if (colombiamap[i].data('id') == 'cundinamarca') {
            //     colombiamap[i].node.setAttribute('fill', 'red');
            // }

            if(colombiamap[i].data('id') == 'bogota') {
                var data = {
                    region: colombiamap[i].data('region'),
                    benefitedProjects: colombiamap[i].data('benefited-projects'),
                    benefitedCompanies: colombiamap[i].data('benefited-companies')
                };
                document.getElementById('map-content-box').innerHTML = markup(data);
            }

            colombiamap[i].mouseover(function(e){
                var data = {
                    region: this.data('region'),
                    benefitedCompanies: this.data('benefited-companies'),
                    benefitedProjects: this.data('benefited-projects')
                };

                this.node.style.opacity = 0.7;
                document.getElementById('map-content-box').innerHTML = markup(data);
            });

            colombiamap[i].mouseout(function(e){
                this.node.style.opacity = 1;
            });
        }

    }
})(jQuery, this, this.document);

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
* Class ProjectCreateView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.ProjectCreateView = Backbone.View.extend({
		el: '#content-modal-create-entity',
		templateFormCompany: _.template( ($('#form-create-company-tpl').html() || '') ),
		templateFormEntrepreneurship: _.template( ($('#form-create-entrepreneurship-tpl').html() || '') ),
		templateFormGroup: _.template( ($('#form-create-group-tpl').html() || '') ),
        templateIdentifications: _.template( ($('#identification-type-tpl').html() || '') ),
		events: {
			'change #codigo_clase_empre_insti': 'onChangeClass',
			'submit #form-create-entity': 'onStore',
            'change #codigo_tipo_identificacion': 'onChangeTypeID'
		},
        parameters: {
            'redirect': null
        },

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalCreate');

            if(opts !== undefined && opts.template) {
                this.template = opts.template;
            }

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

			//Init Attributes
			this.$modalLogin = $('#modal-login');
			this.$formCreate = this.$('#form-create-entity');
			this.$modalCreateProject = $('#modal-base-create-entity');

			this.configAlert = {
				'wrapper': this.$formCreate,
				'closeTime': 8000,
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

			//Events Listener
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

			// link to create entity
			$('.create-entity').off();
			$('.create-entity').on('click', this.openModalCreate);
		},

		/*
		* Render View Element
		*/
		render: function(){

            if(typeof this.template === 'function') {
                this.$el.html( this.template({}) );

                //Init Attributes
                this.$formCreate = this.$('#form-create-entity');
            }

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
				this.$formCreate.foundation('abide');
			}

			// reload plugins
			if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();

			if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
				window.initComponent.configInputMask();

			if( typeof window.initComponent.datepickerTrigger == 'function' && _.has($.fn, 'datetimepicker') )
				window.initComponent.datepickerTrigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* Event for create project
		*/
		onStore: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson( e.target );
			this.model.resetAttrs({silent:true});

			this.model.save( data, {patch: true, wait:true} );
			// this.$formCreate.find(':submit').addClass('disabled');
		},

		onChangeClass: function (e) {
			e.preventDefault();
			var _this = this;
			var projectEmpty = new app.ProjectModel();

			this.validateClass($(e.currentTarget).val(), function (respState, respAlert, resp) {

				window.Misc.removeSpinner({
					'wrap': _this.$('#class-complementary-container'),
					'direct': true
				});

				if( respState ){
					switch( parseInt(resp.codigo_clase_emprendimiento) ) {
						case window._tp.getClassEntrepreneurship['company']:
								_this.$('#class-complementary-container').html( _this.templateFormCompany(projectEmpty.toJSON()) );
                                if( !_.isUndefined(_this.model.get('codigo_tipo_identificacion')) && !_.isNull(_this.model.get('codigo_tipo_identificacion')) && _this.model.get('codigo_tipo_identificacion') != 0 ){
                                    _this.validateInputIdentity( _this.model.get('codigo_tipo_identificacion') );
                                }else{
                                    _this.validateInputIdentity();
                                }
							break;
						case window._tp.getClassEntrepreneurship['entrepreneurship']:
								_this.$('#class-complementary-container').html( _this.templateFormEntrepreneurship(projectEmpty.toJSON()) );
							break;
						case window._tp.getClassEntrepreneurship['group']:
								_this.$('#class-complementary-container').html( _this.templateFormGroup(projectEmpty.toJSON()) );
							break;

						default:
							_this.$('#class-complementary-container').html('');
							$('#form-purchase-payment').find(':submit').removeClass('disabled');
						break;
					}

					_this.ready();
				}
			});
		},

		/**
		* validate classInstitution of the team entity
		* @param String classInstitution
		* @return Array | [Boolean, Object]
		*/
		validateClass: function (classEntity, callback) {

			var _this = this,
				respReturn = true,
				configAlert = this.configAlert;
			window.Misc.setSpinner( _this.$('#class-complementary-container') );

			$.get( window.Misc.urlFull(Route.route('proyecto.categoriaclase.show', {categoriaclase: classEntity})), function (resp) {

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
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (model, xhr, opts) {

			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {
			// response success or error
			var type = resp.success ? 'success' : 'alert',
				text = resp.success ?
					(resp.message !== undefined ? resp.message : 'El proyecto se creo.')
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

			//complete proccess
			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false,
				'callback': (function (conf, re, _this, $formReset) {
					return function () {
						$formReset.find(':submit').removeClass('disabled');

						if( re.success !== undefined ){
							if( re.success ){
								$formReset[0].reset();
								$formReset.find('.chosen-select')
										  .trigger("chosen:updated");
								if( $formReset.data('type') == 'program'){
									// Trigger saved event
									$formReset.trigger('saved', _this.model);
								}else{
                                    // Redirect
                                    if( !_.isUndefined(_this.parameters.redirect) && !_.isNull(_this.parameters.redirect) ) {
                                        window.location = _this.parameters.redirect;
                                    }else{
                                        window.location = window.Misc.urlFull( Route.route('proyecto.proyecto.tab', {proyecto: _this.model.get('url_nickname'), tab: 'basico'}) );
                                    }
                                }

							}else{
								window.Misc.showAlertBox( conf );
							}
						}
					};
				})(this.configAlert, resp, this, this.$formCreate)
			});
		},

		/**
		* on open modal create
		*/
		openModalCreate: function (e) {
			//e.preventDefault();

			if( window.Misc.checkSession(false) ) {
				this.$modalCreateProject.foundation('reveal', 'open');

			}else{
				this.$modalLogin.foundation('reveal','open');
			}
		},

        /**
        * Change type ID
        */
        onChangeTypeID: function (e) {
           // e.preventDefault();
            var typeIdentity = $(e.currentTarget).val();
            this.validateInputIdentity( typeIdentity );
        },

        validateInputIdentity: function (data) {
            var attributes = this.model.toJSON(),
                classInput = '',
                limit = '';

            if( data == window._tp.getTypeID['cc'] || data == window._tp.getTypeID['nit'] || data == window._tp.getTypeID['ti'] ){
                attributes.classInput = 'indetification-mask';
                if( data == window._tp.getTypeID['nit'] ){
                    attributes.limit = '9';
                }else{
                    attributes.limit = '10';
                }
            }

            this.$('#identification-type').html( this.templateIdentifications( attributes ) );
            this.ready();
        }
	});

})(jQuery, this, this.document);

/**
* Class AppRouter  of Backbone Router
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.LandingRouter = new( Backbone.Router.extend({
		routes : {
			'': 'index'
		},

		/**
		* Constructor Method
		*/
		initialize : function ( opts ){
			// Initialize landing resources
		},

		/**
		* Start Backbone history
		*/
		start: function () {
			var config = { pushState: true, hashChange: false };

			if( document.domain.search(/(192.168.1.17|localhost)/gi) != '-1' )
				config.root = '/plataforma/public/';

			Backbone.history.start( config );
		},

		// Routes on Landing
		// --------------------
		/**
		* get landing institution
		*/
		index : function(institution) {
			// this.navigate(window.location.pathname.substring(1), {trigger: true, replace: true});
		}
	}) );

})(jQuery, this, this.document);

/**
* Init Class
*/

/*global*/
var app = app || {};

(function ($, window, document, undefined) {

    var InitComponent = function(){
        var csrf = window.Misc.getCsrf();

        //Init Attributes
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    InitComponent.prototype = {

        /**
        * Constructor or Initialize Method
        */
        initialize: function () {
            // fix error about getAttribute method for comment object dom
            Object.getPrototypeOf(document.createComment('')).getAttribute = function() {}

            //Initialize
            this.initLanding();
            this.initConfigForm();
            this.initAnchor();
            this.configEllipsis();
            this.configSlick();
            this.initModalForm();
            this.autoOpenModal();
            this.configScrollbar();
            this.configSticky();
            this.initModalVideo();
            this.initTabs();
            // this.validateFormForEdit();
            this.chosenTrigger();
            this.select2Trigger();
            // this.initVideoPlayer();
            this.startParallaxScroll();
            this.initCollapsible();
            // override Materialize forms default validation
            window.validate_field = function () {};
        },

        /**
        * Init Landing Backbone Application
        */
        initLanding: function () {
            window.app.LandingRouter.start();
        },

        /**
        *  Init interactive anchor
        */
        initAnchor: function () {
            var config = {
                'anchor-topage' : {
                    'parentDelegate': 'body',//'#wrapper-land',
                    'anchorLink': '.anchor-topage',
                    'duration': 1000,
                    'gutter': -84
                },

                'anchor-tosection' : {
                    'parentDelegate': '.anchors-sub-nav',
                    'anchorLink': '.anchor-tosection',
                    'activation': true,
                    'duration': 1000,
                    'gutter': 0
                }
            };

            for (var selector in config)
                window.Misc.anchorJumpTo( config[selector] );
        },

        /**
        * Trigger Ellipsis plugin config
        */
        configEllipsis: function () {
            var config = {
                '.ellipsis': {}
            };

            for (var selector in config){
                 $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('dotdotdot') == undefined ){
                        $el.dotdotdot(config[selector]);
                    }else {
                        $el.trigger("update.dot");
                    }
                });
            }
        },

        /**
        * Trigger Slick plugin config
        */
        configSlick: function () {
            var _this = this,
                config = {
                '.slick-autoslide': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    infinite: true,
                    speed: 12000,
                    cssEase: 'linear',
                    arrows: false,
                    pauseOnHover: true,
                    responsive: [
                        {
                            breakpoint: 1441,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                speed: 10000
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                speed: 8000
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-autoslide-md': {
                    dots: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '15px',
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-news': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-news-coomeva': {
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-programs': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-events': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-carousel-pair': {
                    dots: false,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-feature-projects': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 2,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 1,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false,
                                slidesToShow: 1,
                                dots: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-feature-projects-compensar': {
                    dots: false,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 2,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 1,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false,
                                slidesToShow: 1,
                                dots: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-tips': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 2,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 1,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false,
                                slidesToShow: 1,
                                dots: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-content': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs'
                },

                '.slick-tabs': {
                    dots: false,
                    slidesToShow: 7,
                    slidesToScroll: 1,
                    centerMode: true,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 6,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '20px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.innpulsa-requirements-slick-tabs': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 5,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px',
                                centerMode: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px',
                                centerMode: true,
                                arrows: true
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '80px',
                                centerMode: true,
                                arrows: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.innpulsa-about-slick-tabs': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 4,
                                centerPadding: '20px',
                                centerMode: false,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '40px',
                                centerMode: false,
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '80px',
                                centerMode: true,
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.innpulsa-slick-stats': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    pauseOnHover: false,
                    centerMode: true,
                    infinite: true,
                    speed: 2000,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                },

                '.slick-slider-innpulsa-team': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-content-five-activearrow': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs-five-activearrow'
                },

                '.slick-tabs-five-activearrow': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content-five-activearrow',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4
                                // centerMode: true,
                                // infinite: true,
                                // centerPadding: '35px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '20px'
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.slick-slider-banner': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-coomeva': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-text-btn': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },
                '.slick-programs': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-events': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-carousel-pair': {
                    dots: false,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-content': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs'
                },

                '.slick-tabs': {
                    dots: false,
                    slidesToShow: 7,
                    slidesToScroll: 1,
                    centerMode: true,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 6,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '20px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.slick-content-five-activearrow': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs-five-activearrow'
                },

                '.slick-tabs-five-activearrow': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content-five-activearrow',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4
                                // centerMode: true,
                                // infinite: true,
                                // centerPadding: '35px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '20px'
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.slick-slider-banner': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-coomeva': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-text-btn': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,

                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },
                '.slick-slider-copo': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade:true,
                    arrows: false,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //     breakpoint: 1440,
                        //     settings: {
                        //         slidesToShow: 4
                        //     }
                        // },
                        // {
                        //     breakpoint: 1200,
                        //     settings: {
                        //         slidesToShow: 3
                        //     }
                        // },
                        // {
                        //     breakpoint: 980,
                        //     settings: {
                        //         slidesToShow: 2,
                        //         centerPadding: '0px'
                        //     }
                        // },
                        // {
                        //     breakpoint: 640,
                        //     settings: {
                        //         slidesToShow: 1,
                        //         centerPadding: '0px',
                        //         arrows: false
                        //     }
                        // }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-carousel-content-testimonial-copo': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: true,
                    speed: 200,
                    asNavFor: '.slick-carousel-testimonial-copo'
                },

                '.slick-carousel-testimonial-copo': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 500,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0',
                    adaptiveHeight: true,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-carousel-content-testimonial-copo',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                               arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                               slidesToShow: 1,
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                               slidesToShow: 1,
                            }
                        },
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-copo-emprendimiento-news': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>'
                    // responsive: [
                    //     {
                    //         breakpoint: 640,
                    //         settings: {
                    //             arrows: false
                    //         }
                    //     },
                    //     {
                    //         breakpoint: 480,
                    //         settings: {
                    //             arrows: false
                    //         }
                    //     }
                    // ]
                },

                '.slick-copo-emprendimiento-partners': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    centerMode: false,
                    infinite: true,
                    speed: 300,
                    cssEase: 'ease',
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    pauseOnHover: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                               slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                               slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                               slidesToShow: 4
                            }
                        }
                    ]
                },
                    '.slick-slider-bolivar': {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        adaptiveHeight: true,
                        autoplay: true,
                        autoplaySpeed: 3500,
                        arrows: false,
                        // pauseOnDotsHover: true
                    },
                    '.slick-slider-bolivar2': {
                        dots: false,
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 4500,
                        responsive: [
                             {
                               breakpoint: 980,
                                settings: {
                                   slidesToShow: 1,
                                    slidesToScroll: 1,
                                   dots:false
                                }

                             },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    dots:false
                                }
                            }
                            // You can unslick at a given breakpoint now by adding:
                            // settings: "unslick"
                            // instead of a settings object
                        ]
                        // pauseOnDotsHover: true
                    },


                '.slick-slider-terpel': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 14000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade:true,
                    arrows: true,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //     breakpoint: 1440,
                        //     settings: {
                        //         slidesToShow: 4
                        //     }
                        // },
                        // {
                        //     breakpoint: 1200,
                        //     settings: {
                        //         slidesToShow: 3
                        //     }
                        // },
                        // {
                        //     breakpoint: 980,
                        //     settings: {
                        //         slidesToShow: 2,
                        //         centerPadding: '0px'
                        //     }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-slider-images-dinamiza': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2500,
                    pauseOnHover: false,
                    centerMode: false,
                    infinite: true,
                    speed: 2500,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade: true,
                    arrows: false,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-slider-default': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    pauseOnHover: false,
                    centerMode: false,
                    infinite: true,
                    speed: 1000,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade:true,
                    arrows: false,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //     breakpoint: 1440,
                        //     settings: {
                        //         slidesToShow: 4
                        //     }
                        // },
                        // {
                        //     breakpoint: 1200,
                        //     settings: {
                        //         slidesToShow: 3
                        //     }
                        // },
                        // {
                        //     breakpoint: 980,
                        //     settings: {
                        //         slidesToShow: 2,
                        //         centerPadding: '0px'
                        //     }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-testimonial-dinamiza': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    centerMode: false,
                    infinite: true,
                    speed: 500,
                    pauseOnHover:false,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                arrows: false,
                                dots: false
                            }
                        }
                    ]
                },

                '.slick-convocatorias-dinamiza': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-events-dinamiza': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-stats-dinamiza': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    pauseOnHover: false,
                    centerMode: true,
                    infinite: true,
                    speed: 2000,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                },

                '.slick-dinamiza-partners': {
                    dots: false,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 0,
                    pauseOnHover: true,
                    centerMode: true,
                    infinite: true,
                    speed: 2000,
                    cssEase: 'linear',
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object

                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 4,
                            }
                        }
                    ]
                },

                '.slick-slider-testimonial': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false,
                                adaptiveHeight: true
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                adaptiveHeight: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-carousel-team': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },
                '.slick-slider-cenisoft-events': {
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: false,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }

                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                    '.slick-slider-mentorias': {
                        vertical: true,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        responsive: [
                            {
                                breakpoint: 980,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }

                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                            // You can unslick at a given breakpoint now by adding:
                            // settings: "unslick"
                            // instead of a settings object
                        ]
                        // pauseOnDotsHover: true
                    },
                    '.slick-slider-cenisoft-news': {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        adaptiveHeight: true,
                        autoplay: false
                        // pauseOnDotsHover: true
                    }

            };

            for (var selector in config) {
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( !$el.hasClass('slick-initialized') ){
                        $el.slick(config[selector]);
                        $el.on('setPosition', function(event, slick) {

                            // trigger ellipsis
                            _this.configEllipsis();
                        });

                        // assign events to tabs
                        if( $el.data('tab') !== undefined ) {

                            $el.on('.focus.fndtn.tab click.fndtn.tab', '.tab-title > a', function (event) {
                                var settingsTab = Foundation.libs.tab.S(this).closest('[data-tab]').data('tab-init');

                                if (!settingsTab.is_hover || Modernizr.touch) {
                                    event.preventDefault();
                                    event.stopPropagation();

                                    $(document).foundation('tab', 'toggle_active_tab', Foundation.libs.tab.S(this).parent());
                                }
                            });

                            $el.on('mouseenter.fndtn.tab', '.tab-title > a', function (event) {
                                var settingsTab = Foundation.libs.tab.S(this).closest('[data-tab]').data('tab-init');

                                if (settingsTab.is_hover) $(document).foundation('tab', 'toggle_active_tab', Foundation.libs.tab.S(this).parent());
                            });

                            $el.on('afterChange', function (slick, currentSlide) {
                                var $currentTab = currentSlide.$slides.eq(currentSlide.currentSlide);

                                $(document).foundation('tab', 'toggle_active_tab', $currentTab);
                            });
                        }
                    }
                });
            }
        },

        /**
        *  auto open modal
        */
        autoOpenModal: function () {
            $('.modal-land[data-openauto]').each(function(index, el) {
                var $el = $(el);
                $el.foundation('reveal','open');
            });
        },

        /**
        * Init Scrollbar plugin
        */
        configScrollbar: function () {
            var config = {
                '.scroll-general-h': {
                    suppressScrollY: true,
                    minScrollbarLength: 25
                },
                '.scroll-general-v': {
                    suppressScrollX: true,
                    minScrollbarLength: 25
                },
                '.scroll-chosen': {
                    suppressScrollX: false,
                    minScrollbarLength: 25
                },
                '.scroll-aside': {
                    suppressScrollX: false
                },
                '.scroll-user-likes': {
                    suppressScrollX: true
                }
            }
            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( !$el.hasClass('ps-container') )
                        $el.perfectScrollbar( config[selector] );
                });
            }
        },

        /**
        * Init sticky plugin
        */
        configSticky: function () {
            var config = {
                '.sticky-top-menu': {
                    wrapperClassName: 'sticky-wrapper-topmenu',
                    getWidthFrom: $('#header-land'),
                    topSpacing: 0
                },
                '.sticky-sub-nav': {
                    wrapperClassName: 'sticky-wrapper-subnav',
                    getWidthFrom: $('#destapafuturo-navmenu'),
                    responsiveWidth: true,
                    topSpacing: 0
                },
                '.sticky-sub-nav-reb': {
                    wrapperClassName: 'sticky-wrapper-subnav',
                    getWidthFrom: $('#reb-navmenu'),
                    responsiveWidth: true,
                    topSpacing: 0
                }
            }

            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el),
                        defaults = {},
                        settings = {};

                    // set limit scroll
                    if( $el.is('[data-limitscroll]') ){
                        defaults['bottomSpacing'] = $el.data('limitscroll');
                    }

                    // defaults parent
                    if( !config[selector]['getWidthFrom'] || config[selector]['getWidthFrom'].length <= 0 ){
                        defaults['getWidthFrom'] = $el.parent();
                    }

                    settings = $.extend({}, config[selector], defaults);

                    if( !$el.parent().hasClass('is-sticky') ){
                        $el.sticky( settings );

                        // handler events
                        if(selector == '.sticky-top-menu') {
                            $( window ).scroll(function() {
                                if( $el.offset().top > 100 ) {
                                    $el.addClass('sticky-menu-limit');
                                }else {
                                    $el.removeClass('sticky-menu-limit');
                                }
                            });
                        }

                        if( $el.hasClass('sticky-sub-nav') ) {
                            $el.off('sticky-start');
                            $el.off('sticky-end');
                            $el.on('sticky-start', function() {
                                $el.find('.opts-action-subnav').removeClass('hidedark');
                            });
                            $el.on('sticky-end', function() {
                                $el.find('.opts-action-subnav').addClass('hidedark');
                            });
                        }
                    }
                });
            }
        },

        /**
        * init event handlers for modal video
        */
        initModalVideo: function () {
            var _this = this;

            $(document).on('opened.fndtn.reveal', '[data-reveal]#modal-video-landing', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                _this.initVideoPlayer();

                if( $modal.hasClass('full') ){
                    $('body').css('overflow', 'hidden');
                }
            });

            $(document).on('close.fndtn.reveal', '[data-reveal]#modal-video-landing', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);

                _this.playerVideoLand.pause();
                _this.playerVideoLand.remove();

                $('body').css('overflow', 'auto');
            });
        },

        /**
        * init tab config
        */
        initTabs: function () {

            $('[data-tab].tabs-route, [data-tab].tabs-progress-bar').off('toggled');
            $('[data-tab].tabs-route').on('toggled', function(event, tab) {
                var $elTab = $(event.currentTarget),
                    $linkActive = $elTab.find('dd.active a, .tab-title.active a'),
                    refTab = $linkActive.attr('aria-controls');

                var settings = $elTab.data(Foundation.libs.tab.attr_name(true) + '-init') || {};

                // if it's url to go there
                if( settings.is_hover && Modernizr.touch && window.Misc.isUrl($linkActive.attr('href')) ) {

                    window.Misc.redirect($linkActive.attr('href'));

                    if( refTab != '' ) {
                        $('#'+refTab).addClass('active')
                                     .siblings('.content').removeClass('active');
                    }

                }else if( window.Misc.isUrl($linkActive.attr('href')) && $elTab.hasClass('tabs-redirect') ) {
                    window.Misc.redirect($linkActive.attr('href'));

                }else {
                    if( refTab != '' ) {
                        $('#'+refTab).addClass('active')
                                     .siblings('.content').removeClass('active');
                    }
                }

            });

            // event close tabs
            $(document).on('click', '.tabs-content .content > .close', function (event) {
                event.preventDefault();

                var idContent = $(event.currentTarget).parents('.content')
                                                        .removeClass('active').attr('id');

                $('[aria-controls="'+ idContent +'"]').attr('aria-selected', false)
                                                         .parent().removeClass('active');
            });

            // event progress bar completed
            $('[data-tab].tabs-progress-bar').on('toggled', function (event, tab) {

                var $elTab = $(event.currentTarget),
                    $tabChildren = $elTab.find('dd, .tab-title'),
                    $barProgress = $elTab.find('.bar__fill');

                var percentageBar =  ($tabChildren.index($tabChildren.filter('.active'))) / ($tabChildren.length - 1) * 100;
                $barProgress.css({'width': percentageBar + '%' });
            });

            window.setTimeout(function () {
                $('[data-tab].tabs-progress-bar').trigger('toggled');
            }, 1500);

            // init materialize tabs
            // $('ul.tabs-sub-nav').tabs();
        },

        /**
        * init video player
        */
        initVideoPlayer: function () {

            this.playerVideoLand = new MediaElementPlayer('#player-video-landing', {
                pluginPath: window.Misc.urlFull('js/vendor/'),
                plugins: ['flash','silverlight','youtube','vimeo'],
                enablePluginDebug: true,
                alwaysShowControls: true,
                videoVolume: 'horizontal',
                features: ['playpause','volume','current','duration','progress','fullscreen'],
                success: function (media, element) {
                    media.play();
                }
            });
        },

        /*
        * initialize form validate
        */
        initConfigForm: function () {

            // Show maxLength
            $('[data-maxlen]').each(function(index, el) {
                var $el = $(el),
                    textFld = $el.val(),
                    maxLength = parseInt( $el.data('maxlen') ),
                    typeLength = $el.data('abide-validator'),
                    hasLength = 0,
                    textLen = '',
                    $elCounter = $el.next('span.count-field-char').length ? $el.next('span.count-field-char') : $('<span>').addClass('count-field-char');

                switch(typeLength){
                    case 'maxLength':
                        hasLength = textFld.length;
                        textLen = ' Caracteres';
                    break;

                    case 'maxWords':
                        hasLength = textFld.length ? window.Misc.trim(textFld.replace(/\s{2,}|\t/g,' ')).split(' ').length : 0;
                        textLen = ' Palabras';
                    break;

                    default:
                        hasLength = textFld.length; textLen = ' Caracteres';
                    break;
                }

                $elCounter.text( (maxLength-hasLength) + textLen );
                $elCounter.insertAfter($el);
            });

            // Render Materialize field form
            Materialize.updateTextFields();
            $('select').material_select();
            $('input[data-abide-validator*=maxLength], textarea[data-abide-validator*=maxLength], input[length], textarea[length]').characterCounter();

            // reload plugins
            $('select').trigger('change.select2');

            $(document).off('focus blur', '.tagsinput input');
            $(document).on('focus', '.tagsinput input', function (e) {

                var $inputEl = $(e.target);

                $inputEl.parents('.tagsinput').addClass('is-focused').prev('input').triggerHandler('focus');
            });
            $(document).on('blur', '.tagsinput input', function (e) {

                var $inputEl = $(e.target);

                $inputEl.parents('.tagsinput').removeClass('is-focused');
            });
        },

        /**
        * to validate forms with Editor
        */
        validateFormForEdit: function () {

            var _this = this;

            Foundation.libs.abide['init'] = function (scope, method, options) {
                this.bindings(method, options);

                // delegate custome events
                _this.validateFormEvents(scope);
            };

            // overwrite validate method for abide foundation library
            Foundation.libs.abide['validate'] = function (els, e, is_ajax) {
                var validations = this.parse_patterns(els),
                    validation_count = validations.length,
                    form = this.S(els[0]).closest('form'),
                    submit_event = /submit/.test(e.type),
                    elsAdd = [].concat(els);

                // add additional index for each validation
                for (var i = 0; i < elsAdd.length; i++) {
                    var validators = [];

                    if( elsAdd[i].getAttribute(this.add_namespace('data-abide-validator')) ) {
                        validators = elsAdd[i].getAttribute(this.add_namespace('data-abide-validator')).split(' ');
                    }

                    for (var iv = 1; iv < validators.length; iv++) {
                        elsAdd.splice(i+iv, 0, elsAdd[i]);
                        i = i+iv;
                    }
                };

                // Has to count up to make sure the focus gets applied to the top error
                for (var i = 0; i < validation_count; i++) {
                    if (!validations[i] && (submit_event || is_ajax)) {
                        if (this.settings.focus_on_invalid) {
                            elsAdd[i].focus();
                        }
                        form.trigger('invalid.fndtn.abide');
                        this.S(elsAdd[i]).closest('form').attr(this.invalid_attr, '');
                        return false;
                    }
                }

                if (submit_event || is_ajax) {
                    form.trigger('valid.fndtn.abide');
                }

                form.removeAttr(this.invalid_attr);

                if (is_ajax) {
                    return false;
                }

                return true;
            };

            Foundation.libs.abide['reflow'] = function(scope, options) {
                (({}).toString.call(scope).slice(8, -1) === 'HTMLFormElement') || (scope = '[' + this.attr_name() + ']');

                var self = this,
                form = self.S(scope).attr('novalidate', 'novalidate');
                self.S(form).each(function (idx, el) {
                    // self.events(el);
                    // delegate customize events
                    _this.validateFormEvents(el);
                });
            };
        },

        /**
        * validate fields
        * @param $invalid_fields collection or element
        */
        validateFields: function ($invalid_fields) {

            $invalid_fields = $($invalid_fields);

            if( !$invalid_fields || !$invalid_fields.length ){
                return;
            }

            var _return = true;

            $invalid_fields.each(function(index, el) {

                var $fieldValid = $(el);
                var invalidClass = typeof $fieldValid.attr('data-invalid') !== 'undefined' ? true : false;
                $fieldValid.parents('.textarea-post').toggleClass('error', invalidClass);

                if( !$fieldValid.is(':checkbox,:radio') ) {
                    $fieldValid.toggleClass('valid', !invalidClass);
                    $fieldValid.toggleClass('invalid', invalidClass);
                }

                invalidClass || (_return = invalidClass);
            });

            return _return;
        },
        validateFieldOne: function(form, originalSelf, e) {

            var _this = this,
                settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

            // clearTimeout(Foundation.libs.abide.timer);
            setTimeout(function () {
                Foundation.libs.abide.validate([originalSelf], e);
                // customize validation
                _this.validateFields(originalSelf);
            }.bind(originalSelf), settings.timeout);
        },

        /**
        * validate form events
        */
        validateFormEvents: function (formScope) {
            (({}).toString.call(formScope).slice(8, -1) === 'HTMLFormElement') || (formScope = 'form[data-abide]');

            var _this = this;

            // customize validations
            $(formScope)
            .off('submit.fndtn.abide')
            .on('submit.fndtn.abide', function(e) {

                var is_ajax = /ajax/i.test( Foundation.libs.abide.S(e.target).attr(Foundation.libs.abide.attr_name()) );
                return Foundation.libs.abide.validate( Foundation.libs.abide.S(e.target).find('input, textarea, select').not("[data-abide-ignore]").get(), e, is_ajax );
            });

            $(formScope).off('validate.fndtn.abide', 'form[data-abide]');
            $(formScope).on('validate.fndtn.abide', 'form[data-abide]', function (e) {

                var settings = $(this).data(Foundation.libs.abide.attr_name(true) + '-init') || {};
                var $invalid_fields = $(this).find('[data-invalid]:not([type="submit"]), .invalid:not([type="submit"])');

                // validate fields
                _this.validateFields($invalid_fields);

                // focus and scroll to fields that they are invalid
                if(e.type == 'invalid' && settings.focus_on_invalid) _this.invalidFocusField(this);
            })
            .off('blur.fndtn.abide change.fndtn.abide', 'input:not([data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])')
            .on('blur.fndtn.abide change.fndtn.abide', 'input:not([data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])', function (e) {

                // overwrite foundation validation
                var form = Foundation.libs.abide.S($(e.target).closest('form[data-abide]')[0]).attr('novalidate', 'novalidate'),
                    settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

                var id = this.getAttribute('id'),
                    eqTo = form.find('[data-equalto="'+ id +'"]');

                // old settings fallback
                // will be deprecated with F6 release
                if (settings.validate_on_blur && settings.validate_on_blur === true) {
                  _this.validateFieldOne(form, this, e);
                }
                // checks if there is an equalTo equivalent related by id
                if(typeof eqTo.get(0) !== "undefined" && eqTo.val().length){
                  _this.validateFieldOne(form, eqTo.get(0), e);
                }
                // new settings combining validate options into one setting
                if (settings.validate_on === 'change') {
                  _this.validateFieldOne(form, this, e);
                }
            })
            .off('keydown.fndtn.abide', 'input:not(:radio,:checkbox,[data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])')
            .on('keydown.fndtn.abide', 'input:not(:radio,:checkbox,[data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])', function (e) {

                // overwrite foundation validation
                var form = Foundation.libs.abide.S($(e.target).closest('form[data-abide]')[0]).attr('novalidate', 'novalidate'),
                    settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

                var id = this.getAttribute('id'),
                    eqTo = form.find('[data-equalto="'+ id +'"]');
                // old settings fallback
                // will be deprecated with F6 release
                if (settings.live_validate && settings.live_validate === true && e.which != 9) {
                  _this.validateFieldOne(form, this, e);
                }
                // checks if there is an equalTo equivalent related by id
                if(typeof eqTo.get(0) !== "undefined" && eqTo.val().length){
                  _this.validateFieldOne(form, eqTo.get(0), e);
                }
                // new settings combining validate options into one setting
                if (settings.validate_on === 'tab' && e.which === 9) {
                  _this.validateFieldOne(form, this, e);
                }
                else if (settings.validate_on === 'change') {
                  _this.validateFieldOne(form, this, e);
                }
            });
        },

        /**
        * focus scroll in invalid inputs
        * @parem Element formInvalid
        */
        invalidFocusField: function (formInvalid) {
            var $target = $(formInvalid).find(':input[data-invalid]:eq(0)').parent();

            var $parentScroll = $target.parents().filter(function () {
                    return ( _.contains(['fixed','relative'], $(this).css('position')) && _.contains(['auto','scroll'], $(this).css('overflow')) ) || $(this).is('body');
                }).eq(0);

            if( $parentScroll.is('body') ) {

                $parentScroll.animate({
                    scrollTop: ( $target.offset().top - 85 ) + 'px'
                }, {
                    duration: 1000,
                    easing: 'swing',
                    complete: null
                });

            }else {
                $parentScroll.animate({
                    scrollTop: '+=' + ( $target.offset().top - 85 ) + 'px'
                }, {
                    duration: 1000,
                    easing: 'swing',
                    complete: null
                });
            }
        },

        /**
        * Init settings forms modal
        */
        initModalForm: function  () {
            $(document).on('open.fndtn.reveal', '[data-reveal].reveal-modal-form', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                $modal.foundation('reveal', {bg_class:'reveal-modal-bgform', bg:$('.reveal-modal-bgform')});

                if( $modal.hasClass('full') ){
                    $('body').css('overflow', 'hidden');
                }
            });

            $(document).on('closed.fndtn.reveal', '[data-reveal].reveal-modal-form', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                $('.reveal-modal-bgform').css('display', 'none');
                $modal.foundation('reveal', {bg_class:'reveal-modal-bg', bg:$('.reveal-modal-bg')});

                if( $modal.hasClass('full') ){
                    $('body').css('overflow', 'auto');
                }
            });
        },

        /**
        * Trigger chosen plugin config
        */
        chosenTrigger: function () {
            var _this = this,
                config = {
                    'select.chosen-select': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' '},
                    'select.chosen-select-nosearch': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' ', disable_search: true},
                    'select.chosen-select-deselect': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' ', allow_single_deselect: true},
                    'select.chosen-select-deselect-nosearch': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' ', allow_single_deselect: true, disable_search: true},
                    'select.chosen-select-no-single': {disable_search_threshold:10},
                    'select.chosen-select-multiple': {
                        max_selected_options: 6,
                        display_selected_options: false,
                        no_results_text:'¡No se encontrarón resultados! de:'
                    }
                };

            // chosen events listener
            $(document).off('chosen:ready', 'select[data-chosenopts]', this.getItemsChosen);
            $(document).on('chosen:ready', 'select[data-chosenopts]', this.getItemsChosen);
            $(document).on('chosen:ready', 'select[class*=chosen-select]', function (event, params) {
                var chosen = params.chosen,
                    $chosenResults = chosen.search_results;

                $chosenResults.addClass('scroll-chosen');
                _this.configScrollbar();
            });

            // Instance selects to chosen plugin
            for (var selector in config) {

                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('chosen') == undefined ){
                        $el.chosen(config[selector]);
                    }
                });
            }

        },

        /**
        * init select2 plugin
        */
        select2Trigger: function () {
            var _this = this,
                config = {
                  '.choice-select' : {language:"es", placeholder:'Seleccione una opción'},
                  '.choice-select-deselect'  : {language:"es", placeholder:'Seleccione una opción', allowClear: true},
                  '.choice-select-no-single' : {},
                  '.choice-select-multiple': {},
                  '.choice-select-autocomplete': {
                    language: "es",
                    placeholder:'Seleccione una opción',
                    ajax: {
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        escapeMarkup: function (markup) { return markup; },
                        cache: true,
                        minimumInputLength: 1
                    }
                  }
                };

            // Instance selects to choice plugin
            for (var selector in config){

                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('select2') == undefined ){
                        $el.select2(config[selector]);
                    }
                });
            }
        },

        /**
        * Parallax scrolling
        */
        startParallaxScroll: function () {

            $(window).stellar({
                horizontalScrolling: false,
                responsive: true
            });
        },

        /**
        * Collapsible
        *
        */
        initCollapsible: function () {
            $('.collapsible').collapsible();
        }
    };

    InitComponent.prototype.validateFormForEdit.call(new InitComponent);
    //Init Foundation Plugins
    //-----------------------
    $(document).foundation({
        abide: {
            timeout: 100,
            error_labels: false,
            patterns: {
                'max_char_textarea': /[^\s](.[\n\r]*?){10,}/,
                'min_char_textarea': /[^\s](.[\n\r]*?){10,}/,
                'alpha_numeric_esp': /^[\s\wá-źÁ-Ź]+$/,
                'alpha_dash': /^[a-zA-Z_-]+$/,
                'alpha_num_dash': /^[a-zA-Z0-9_-]+$/,
                'greater_than_zero': /^[1-9]\d*(\.?\d+)?$/,
                'number_positive': /^[0-9]\d*(\.?\d+)?$/,
                'full_year': /[1-9][0-9]{3}/,
                'url_simple': /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+(\/(.)*)?(\?(.)*)?/i,
                'nickname': /^[a-zA-Z0-9\._-]{0,15}$/,
                'singleText': /[^\s](.|[\n\r])*/i,
                'longText': /[^\s](.[\n\r]*?)*/i,
                'number_format': /^[-+]?\d+((([,.]{1})\d{3})(\3\d{3})*)*([.,]{1}\d+)?$/
            },
            validators: {
                maxLength: function(el, required, parent) {
                    // validate required and patterns again
                    var el_patterns = this.pattern(el),
                        value = el.value.trim(),
                        valid_length = (required) ? (el.value.length > 0) : true,
                        el_validation = true;
                    el_validation = (el_patterns[1].test(value) && valid_length ||
                                        !required && el.value.length < 1 || $(el).attr('disabled')) ? true : false;

                    var $el = $(el),
                        textFld = $el.val(),
                        maxLength = parseInt( $el.data('maxlen') ) || parseInt( $el.attr('length') ),
                        $counter = $el.next('span.count-field-char').length ? $el.next('span.count-field-char') : $('<span>').addClass('count-field-char');

                    if( $el.data('maxlen') != undefined ) {
                        $counter.text( maxLength-textFld.length +' Caracteres' );
                        $counter.insertAfter($el);
                    }

                    return  textFld.length > maxLength || !el_validation ? false : true;
                },
                maxWords: function  (el, required, parent) {
                    // validate required and patterns again
                    var el_patterns = this.pattern(el),
                        value = el.value.trim(),
                        valid_length = (required) ? (el.value.length > 0) : true,
                        el_validation = true;
                    el_validation = (el_patterns[1].test(value) && valid_length ||
                                        !required && el.value.length < 1 || $(el).attr('disabled')) ? true : false;

                    var $el = $(el),
                        textFld = $el.val(),
                        maxLength = parseInt( $el.data('maxlen') ),
                        hasLength = 0,
                        $counter = $el.next('span.count-field-char').length ? $el.next('span.count-field-char') : $('<span>').addClass('count-field-char');

                    hasLength = textFld.length ? window.Misc.trim(textFld.replace(/\s{2,}|\t/g,' ')).split(' ').length : 0;
                    $counter.text( (maxLength-hasLength) +' Palabras' );
                    $counter.insertAfter($el);

                    return  hasLength > maxLength || !el_validation ? false : true;
                },
                onChecked: function(el, required, parent) {
                    var $el = $(el);
                    var checked = 0;

                    if ( $el.is( ":checkbox" ) ) {

                        $( 'input[type="checkbox"][data-relchecks="'+ $el.data('relchecks') +'"]:checked' ).each(function(index, el) {
                            checked++;
                        });

                        // validate associated checks
                        if( checked ){
                            $( 'input[type="checkbox"][data-relchecks="'+ $el.data('relchecks') +'"]' ).parent().removeClass('error');
                        }else {
                            $( 'input[type="checkbox"][data-relchecks="'+ $el.data('relchecks') +'"]' ).parent().addClass('error');
                        }
                    }

                    return checked;
                },
                oneDataMinimun: function (el, required, parent) {
                    var $el = $(el),
                        quantity = 0;

                    $( 'input[data-reldata="'+ $el.data('reldata') +'"]' ).each(function(index, el) {

                        if( $(el).val().length && $(el).data('invalid') == undefined )
                            quantity++;
                    });

                    // validate associated checks
                    if( quantity ){
                        $( 'input[data-reldata="'+ $el.data('reldata') +'"]' ).parent().removeClass('error');
                    }else {
                        $( 'input[data-reldata="'+ $el.data('reldata') +'"]' ).parent().addClass('error');
                    }

                    return quantity;
                },
                requiredOf: function(el, required, parent) {
                    var $el = $(el);

                    var from  = $('#'+ $el.data('requiredof')), //document.getElementById( el.getAttribute(this.add_namespace('data-requiredof')) ).value,
                        to    = $el,
                        valid = from.length ? (from.val().length || from.is(':checked') ? !!(to.val().length || to.is(':checked')) : true) : true;

                    return valid;
                }
            }
        },
        accordion: {
            multi_expand: false,
            toggleable: true
        },
        dropdown: {
            opened: function() {
                // Reposition dropdown using jquery.ui position
                var $dropdown = $(this),
                    targetEl = Foundation.libs.dropdown.S(this).data('target');

                var reloadPositions = function ($dropdown, targetEl) {
                    var offsetTop = $dropdown.offset().top,
                        offsetLeft = $dropdown.offset().left;

                    // redefine dropdown arrow
                    if( !$dropdown.hasClass('drop-right') && !$dropdown.hasClass('drop-left') ){

                        // change arrow direction
                        if( Math.round(offsetTop) < Math.round($(targetEl).offset().top) ) {
                            $dropdown.removeClass('drop-left drop-right drop-bottom')
                                     .addClass('drop-top');
                        }else {
                            $dropdown.removeClass('drop-left drop-right drop-top')
                                     .addClass('drop-bottom');
                        }
                    }else {
                        // change arrow direction
                        if( Math.round(offsetLeft) < Math.round($(targetEl).offset().left) ) {
                            $dropdown.removeClass('drop-top drop-right drop-bottom')
                                     .addClass('drop-left');
                        }else {
                            $dropdown.removeClass('drop-left drop-right drop-top')
                                     .addClass('drop-right');
                        }
                    }

                    // invert arrow
                    if( Math.round(offsetLeft) < Math.round($(targetEl).offset().left) ) {
                        $dropdown.addClass('arrow-inverted-left');
                    }else {
                        $dropdown.removeClass('arrow-inverted-left');
                    }
                    if( Math.round(offsetTop) < Math.round($(targetEl).offset().top) ) {
                        $dropdown.addClass('arrow-inverted-top');
                    }else {
                        $dropdown.removeClass('arrow-inverted-top');
                    }

                    // calculate pos at target
                    var gutterTop = $dropdown.hasClass('drop-top') ? parseFloat($dropdown.css('margin-top')) - $dropdown.outerHeight() : parseFloat($dropdown.css('margin-top')),
                        gutterLeft = $dropdown.hasClass('drop-left') ? parseFloat($dropdown.css('margin-left')) - $dropdown.outerWidth() : parseFloat($dropdown.css('margin-left')),
                        posAtHorizontal = $dropdown.hasClass('drop-right') ? 'right' : 'left',
                        posAtVertical = $dropdown.hasClass('drop-bottom') ? 'bottom' : 'top';

                    // set position of the dropdown
                    $dropdown.position({
                        of: targetEl || $dropdown.offsetParent(),
                        my: 'left+'+ gutterLeft +' top+'+ gutterTop,
                        at: posAtHorizontal +' '+ posAtVertical,
                        collision: 'flip'
                    });

                    if( typeof callback == 'function' )
                        callback.call(null, $dropdown, targetEl);
                }

                // redefine dropdown position
                var cloop = 1;
                do {
                    reloadPositions( $dropdown, targetEl );

                }while( ++cloop <= 2 )

                // // redefine dropdown position
                // reloadPositions( $dropdown, targetEl, reloadPositions );
            },
            closed: function  () {
                var $dropdown = $(this);

                $dropdown.css('top', '0px');
            }
        },

        "magellan-expedition": {
            destination_threshold: 0,
            throttle_delay: 0
        }
    });

    //Init App Components
    //-----------------------
    $(function() {
        window.initComponent = new InitComponent();
        window.initComponent.initialize();
    });

})(jQuery, this, this.document);

/**
* Animation for application elements
* @author TuPoryecto
* @frontend Desarrollador: @krobing
* @link tuproyecto.com
*/

(function ($, window, document, undefined) {

	var InitAnimated = function () {
		//
	};

	InitAnimated.prototype = {

		defaults: {

		},

		/**
		* Constructor or Initialize Method
		*/
		initialize: function (opts) {

			// Extends default config
			this.settings = $.extend({}, this.defaults, opts);

			// Initialize Methods
			this.slidingMenuSide();
			// this.dropdownsMotion();
			this.configOffCanvas();
			this.focusTo();
			this.toggleMainMenu();
			this.slidingDropdown();
			this.toggleSignUp();
            this.preloadTolink();
		},

		/**
		* slide of side menu
		*/
		slidingMenuSide: function () {

			$(document).on('click', '.hide-fx-left-btn, .hide-fx-right-btn', function (event) {
				event.preventDefault();

				var $btnShow = $(event.currentTarget),
					$colLeft = $('.fx-main-content .fx-col-left'),
					$colRight = $('.fx-main-content .fx-col-right');

				if( $btnShow.hasClass('hide-fx-left-btn') ){

					if( $colLeft.hasClass('is-hide') ){
						$colLeft.css({
							'margin-left': '0px'
						}).removeClass('is-hide');

						$('.hide-fx-left-btn').removeClass('on');

					}else {
						$colLeft.css({
							'margin-left': function (dim) {
								return '-'+ ( $(this).outerWidth(true) + 5 ) +'px';
							}
						}).addClass('is-hide');

						$('.hide-fx-left-btn').addClass('on');
					}

					$('.is-sticky > [class*="sticky-"]').sticky('update');
					// $('.is-sticky > [class*="sticky-"]').each(function(index, el) {
					//     $(el).sticky('update');
					// });

				}else if( $btnShow.hasClass('hide-fx-right-btn')){

					if( $colRight.hasClass('is-hide') ){
						$colRight.css({
							'margin-right': '0px'
						}).removeClass('is-hide');

						$('.hide-fx-right-btn').removeClass('on');

					}else {
						$colRight.css({
							'margin-right': function (dim) {
								return '-'+ ( $(this).outerWidth(true) + 5 ) +'px';
							}
						}).addClass('is-hide');

						$('.hide-fx-right-btn').addClass('on');
					}

					$('.is-sticky > [class*="sticky-"]').sticky('update');
				}
			});
		},

		/**
		* sliding aside dropdown
		*/
		slidingDropdown: function () {

			var _this = this;

			// handler with click event
			$(document).on('click', '.toggle-slide-drop', function(event) {
				event.preventDefault();

				// if browser window is least 1024px
				if( $(window).width() <= 1024 ) {

					if(!$('.content-filters-sidemenu').hasClass('dd')){

						$('.content-filters-sidemenu').removeClass('dropdown-transition-md').addClass('dd');
						$(event.currentTarget).removeClass('on');

					}else{
						$('.content-filters-sidemenu').removeClass('dd').addClass('dropdown-transition-md');
						$(event.currentTarget).addClass('on');
					}
				}
			});

			// handler with resize window event
			this.breakpointsDropdown();
			$(window).on('resize load', function (event) {
				_this.breakpointsDropdown();
			});
		},

		/**
		* breakpoints dropdown
		*/
		breakpointsDropdown: function () {
			// if browser window is least 1024px
			if( $(window).width() <= 1024 ) {

				$('.content-filters-sidemenu').removeClass('dropdown-transition-md').addClass('dd');
				$('.toggle-slide-drop').removeClass('on');

			}else {
				$('.content-filters-sidemenu').addClass('dropdown-transition-md').removeClass('dd');
				// $('.toggle-slide-drop').addClass('on');
			}
		},

		/**
		*
		*/
		dropdownsMotion: function () {
			$(document).on('click.fndtn.dropdown', '.btn-plus-create', function (event) {
				event.preventDefault();
				event.stopPropagation();

				var $linkDrop = $(event.currentTarget);

				if( $linkDrop.data('dropdown') ){
					var $dropdown = $( '#'+ $linkDrop.data('dropdown') );
					$dropdown.foundation('dropdown', 'toggle', $linkDrop);
				}
			});
		},
		/**
		* configuring show and hide of offCanvas menu
		*/
		configOffCanvas: function  () {
		    $('#boton-buttom-menu').click(function(){
		        $('.bottom-off-canvas-menu').addClass('show-top-off-canvas');
            });
			$(document).on('open.fndtn.offcanvas', '[data-offcanvas]', '[data-pepe]', function (event) {
				var $btnToggle = $('.left-off-canvas-toggle.md-animated-icon.md-hamburger__icon');
				if( $(event.target).data('offcanvas') !== undefined ){
					$('.left-off-canvas-menu').addClass('show-right-off-canvas');
					$btnToggle.addClass('active');
					$btnToggle.removeClass('no-active');
                    document.body.style.overflow = 'hidden';
				}
			});
			$(document).on('close.fndtn.offcanvas', '[data-offcanvas]', function (event) {
				var $btnToggle = $('.left-off-canvas-toggle.md-animated-icon.md-hamburger__icon');
				$('.left-off-canvas-menu').removeClass('show-right-off-canvas');
				$('.bottom-off-canvas-menu').removeClass('show-top-off-canvas');
				$btnToggle.removeClass('active');
				$btnToggle.addClass('no-active');
                document.body.style.overflow = 'auto';
			});
		},
		/**
		* focus to
		*/
		focusTo: function () {
			$(document).on('click', '[data-focuses]', function (event) {
				event.preventDefault();

				var $el = $(this);

				if( $el.data('focuses') ) {
					$('#'+$el.data('focuses')).focus();
				}
			})
		},

		/**
		* toggle main menu
		*/
		toggleMainMenu: function () {
			$(document).off('click', '.md-hamburger-close__icon');
			$(document).on('click', '.md-hamburger-close__icon', function (event) {
				event.preventDefault();

				var $toggleMenu = $(this),
					$topMenuOpts = $('#topmenu-main-options'),
					isActive = $toggleMenu.hasClass('active');

				$toggleMenu.toggleClass('active', !isActive);
				$toggleMenu.toggleClass('no-active', isActive);

				if( $toggleMenu.hasClass('main-menu-toggle') ) {
					$topMenuOpts.toggleClass('show-topmenu-options', !isActive);
					$('body').css('overflow', isActive ? 'auto' : 'hidden');
				}
			});
		},

		/**
		*
		*/
		toggleSignUp: function () {

			$(document).on('click', '.show-strip-signup', function (event) {
				event.preventDefault();

				$('.strip-sign-up-mobile').slideToggle('fast');
			});
		},

        /**
         * when the link was clicked in the main menu options, start preload
         */
        preloadTolink: function () {
            $(document).on('click', '.load-when-linking', function (event) {
                $('body').removeClass('loaded');
            });
        }
	};

	/**
	* Expose the class either via AMD, CommonJS or the global object
	*/
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return InitAnimated;
        });
    }
    else if (typeof module === 'object' && module.exports) {
        module.exports = InitAnimated;
    }
    else {
    	//Initialize animated components
		//------------------------------
		$(function() {
	    	window.initAnimated = new InitAnimated();
			window.initAnimated.initialize();
		});
    }

})(
	(this && this.jQuery) || require('jquery'),
	this || global,
	(this && this.document) || global.document
);

//# sourceMappingURL=landing.min.js.map
