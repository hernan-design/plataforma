/**
* Class PurchaseModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.VoucherModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.voucher.index') );
        },
        idAttribute: 'codigo_voucher',
        defaults: {
        	'codigo_institucion' : '',
            'codigo_usuario' : '',
            'codigo_estado': '',
            'descripcion_voucher' : '',
        	'valor_voucher' : '',
            'saldo_voucher': '',
            'fecha_voucher': '',
            'codigo_encuesta': '',
            'url_encuesta': ''

        }
    });

})(this, this.document);
