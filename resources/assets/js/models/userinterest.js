/**
* Class UserInterestModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserInterestModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.intereses.index') );
        },
        idAttribute: 'codigo_sector_interes',
        defaults: {
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_sector_interes': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {

        }
    });

})(this, this.document);
