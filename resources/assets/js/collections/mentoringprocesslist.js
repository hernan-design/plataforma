/**
* Class MentoringItemList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentorignProcessList = Backbone.Collection.extend({

        url: function() {

            return window.Misc.urlFull( Route.route('mentoria.mentores.procesos.index') );
        },
        model: app.MentoringProcess,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
