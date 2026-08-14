/**
* Class UserInstitutionModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserInstitutionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuarioinstitucion.index') );
        },
        idAttribute: 'codigo_usuario_institucion',
        defaults: {
            'codigo_usuario': 0,
            'codigo_institucion': 0
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
