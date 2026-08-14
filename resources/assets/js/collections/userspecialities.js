/**
* Class UserSpecialitiesList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserSpecialitiesList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.especialidades.index') );
        },
        model: app.UserSpecialityModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
