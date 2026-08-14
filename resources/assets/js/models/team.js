/**
* Class TeamModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TeamModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.grupos') );
        },
        idAttribute: 'codigo_grupo',
        defaults: {
            'nombre_grupo': '',
            'imagen_grupo': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model options
        */
        initialize: function(attrs, opts){
            //Init attributes

            //Events Listener
        },

        /**
        * validate attributes model in the change
        * @param Object attrs. modified attributes model
        */
        validate: function (attrs) {
        }

    });

})(this, this.document);
