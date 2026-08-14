/**
* Class MentoringItemList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringItemList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.item.index') );
        },
        model: app.MentoringItemModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
