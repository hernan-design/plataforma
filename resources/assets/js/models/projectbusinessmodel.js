/**
* Class ProjectBusinessModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.ProjectBusinessModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.modelodenegocio.index') );
        },
        idAttribute: 'codigo_respuesta_modelo_negocio',
        defaults: {
            'codigo_proyecto': 0,
            'codigo_modelo_negocio': 0,
            'items': [],
            'updated_at': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            //
        }
    });

})(this, this.document);
