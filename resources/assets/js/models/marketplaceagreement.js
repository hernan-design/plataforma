/**
* Class MarketPlaceAgreementModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MarketPlaceAgreementModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.ventas.acuerdo.index') );
        },
        idAttribute: 'codigo_acuerdo_compra',
        defaults: {
            'alcance_acuerdo_compra': '',
            'resultados_acuerdo_compra': '',
            'actividad_acuerdo': [],
            'asesor_acuerdo': [],
            'entregable_acuerdo': [],
            'codigo_compra': null,
            'comprador': false,
            'codigo_estado': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
           //
        }
    });

})(this, this.document);
