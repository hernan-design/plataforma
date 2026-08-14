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
