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
