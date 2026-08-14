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
            'certificado_curso': false,
            'log_curso': false,
            'log_biofacial': false
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
