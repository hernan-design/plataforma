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
