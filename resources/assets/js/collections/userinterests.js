/**
* Class UserInterestsList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserInterestsList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.intereses.index') );
        },
        model: app.UserInterestModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
