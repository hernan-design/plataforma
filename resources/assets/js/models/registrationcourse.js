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
