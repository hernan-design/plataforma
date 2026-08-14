/**
* Class UserReasonList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserReasonList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.razones.index') );
        },
        model: app.UserReasonModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
