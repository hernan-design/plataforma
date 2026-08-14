/**
* Class MentoringTaskList extend of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTagsList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tags.index') );
        },
        model: app.MentoringTagsModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
