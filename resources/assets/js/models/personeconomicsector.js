/**
* Class PersonEconomicSectorModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PersonEconomicSectorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.economicos.index') );
        },
        idAttribute: 'codigo_sector_economico',
        defaults: {
            'codigo_persona': 0,
            'codigo_estado': 0,
            'nombre_sector_economico': ''
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
