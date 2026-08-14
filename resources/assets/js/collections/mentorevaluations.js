/**
* Class MentorEvaluationList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentorEvaluationList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.preguntas.evaluacion.mentor.index') );
        },
        model: app.MentorEvaluationModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
