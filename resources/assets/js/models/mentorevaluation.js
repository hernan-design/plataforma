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
