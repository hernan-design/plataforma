/**
* Class MentoringTaskList extend of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTaskList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tarea.index') );
        },
        model: app.MentoringTaskModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
