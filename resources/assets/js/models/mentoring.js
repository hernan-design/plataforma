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
