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
