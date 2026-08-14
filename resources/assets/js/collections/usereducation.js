/**
* Class UserEducationList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserEducationList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.educaciones.index') );
        },
        model: app.UserEducationModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
