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
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["GET","HEAD"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/email","name":"password.request","action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":"password.email","action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"password.reset","action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}","name":"auth.provider","action":"App\Http\Controllers\Auth\LoginController@redirectToProvider"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}\/callback","name":"auth.provider.callback","action":"App\Http\Controllers\Auth\LoginController@handleProviderCallback"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home","action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"chat","name":"chat.index","action":"App\Http\Controllers\Chat\ChatController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.index","action":"App\Http\Controllers\CanalUsuarioController@index"},{"host":null,"methods":["POST"],"uri":"comunidad\/canalusuario","name":"comunidad.canalusuario.store","action":"App\Http\Controllers\CanalUsuarioController@store"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/canalusuario\/{canalusuario}","name":"comunidad.canalusuario.update","action":"App\Http\Controllers\CanalUsuarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{canal}\/create","name":"comunidad.create","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad","name":"comunidad.index","action":"App\Http\Controllers\MuroController@index"},{"host":null,"methods":["POST"],"uri":"comunidad","name":"comunidad.store","action":"App\Http\Controllers\MuroController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"comunidad\/{comunidad}","name":"comunidad.show","action":"App\Http\Controllers\MuroController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"comunidad\/{comunidad}","name":"comunidad.update","action":"App\Http\Controllers\MuroController@update"},{"host":null,"methods":["DELETE"],"uri":"comunidad\/{comunidad}","name":"comunidad.destroy","action":"App\Http\Controllers\MuroController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/rechazar\/{asesoria}","name":"mentoria.preguntas.rechazar","action":"App\Http\Controllers\AsesoriaController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/aceptar\/{asesoria}","name":"mentoria.preguntas.aceptar","action":"App\Http\Controllers\AsesoriaController@aceptar"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor\/create\/{user}","name":"mentoria.preguntas.evaluacion.mentor.create","action":"App\Http\Controllers\EvaluacionAsesoriaController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.index","action":"App\Http\Controllers\EvaluacionAsesoriaController@index"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas\/evaluacion\/mentor","name":"mentoria.preguntas.evaluacion.mentor.store","action":"App\Http\Controllers\EvaluacionAsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.index","action":"App\Http\Controllers\AsesoriaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/create","name":"mentoria.preguntas.create","action":"App\Http\Controllers\AsesoriaController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/preguntas","name":"mentoria.preguntas.store","action":"App\Http\Controllers\AsesoriaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.show","action":"App\Http\Controllers\AsesoriaController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/preguntas\/{preguntas}","name":"mentoria.preguntas.update","action":"App\Http\Controllers\AsesoriaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores","name":"mentoria.mentores.index","action":"App\Http\Controllers\MentorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/create","name":"mentoria.mentores.create","action":"App\Http\Controllers\MentorController@create"},{"host":null,"methods":["POST"],"uri":"mentoria\/mentores","name":"mentoria.mentores.store","action":"App\Http\Controllers\MentorController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.show","action":"App\Http\Controllers\MentorController@show"},{"host":null,"methods":["PUT","PATCH"],"uri":"mentoria\/mentores\/{mentores}","name":"mentoria.mentores.update","action":"App\Http\Controllers\MentorController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"mentoria","name":"mentoria.index","action":"App\Http\Controllers\MentoriaController@index"},{"host":null,"methods":["POST"],"uri":"file\/temp","name":"file.temp","action":"App\Http\Controllers\FileController@temp"},{"host":null,"methods":["POST"],"uri":"file\/crop","name":"file.crop","action":"App\Http\Controllers\FileController@crop"},{"host":null,"methods":["POST"],"uri":"file\/upload","name":"file.upload","action":"App\Http\Controllers\FileController@upload"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/identificacion","name":"usuario.identificacion.index","action":"App\Http\Controllers\TipoIdentificacionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/economicos","name":"usuario.economicos.index","action":"App\Http\Controllers\SectorEconomicoPersonaController@index"},{"host":null,"methods":["PUT","PATCH"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.update","action":"App\Http\Controllers\SectorEconomicoPersonaController@update"},{"host":null,"methods":["DELETE"],"uri":"usuario\/economicos\/{economicos}","name":"usuario.economicos.destroy","action":"App\Http\Controllers\Se