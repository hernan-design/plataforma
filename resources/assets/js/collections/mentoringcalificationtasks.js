/**
* Class MentoringCalificationTaskList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringCalificationTaskList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.calificacion.tarea.index') );
        },
        model: app.MentoringCalificationTaskModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
