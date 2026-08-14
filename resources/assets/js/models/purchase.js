/**
* Class PurchaseModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PurchaseModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.compras.index') );
        },
        idAttribute: 'codigo_compra',
        defaults: {
        	'valor_total_compra' : 0,
            'valor_total_iva' : 0,
            'valor_total_puntos': 0,
            'fecha_compra' : '',
        	'hora_compra' : '',
            'nickname_usuario': '',
            'nombre_usuario': '',
            'imagen_usuario': '',
            'telefono_usuario': 0,
            'movil_usuario': 0,
            'correo_electronico': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'id': 0,
            'state_purchase': '',
            'nombre_tipo_pago': '',
            'nombre_tipo_envio': '',
            'unidad_producto': 0,
            'imagen_producto': '',
            'url_producto': 0,
            'nombre_producto': '',
            'resumen_producto': '',
            'evaluation_purchase': false,
            'url_profile': '',
            'nombre_entidad': '',
            'imagen_entidad': '',
            'codigo_usuario_entidad': '',
            'codigo_adjunto': '',
            'codigo_adjunto_informe_final': '',
            'nombre_adjunto_informe_final': '',
            'direccion_adjunto_informe_final': '',
            'codigo_adjunto_certificate': '',
            'nombre_adjunto_certificate': '',
            'direccion_adjunto_certificate': '',
            'codigo_acuerdo_compra_decrypt': '',
        }
    });

})(this, this.document);
