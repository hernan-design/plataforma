/**
* Class MarketPlaceModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MarketPlaceModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.index') );
        },
        idAttribute: 'codigo_producto',
        defaults: {
            'url_producto': '',
            'id_producto': 0,
            'codigo_clase_producto': 0,
            'nombre_producto': '',
            'descripcion_producto': '',
            'purchase':'',
            'precio_producto': 0,
            'codigo_iva_producto': 0,
            'imagen_producto': '',
            'privacidad_producto': '',
            'nombre_privacidad_producto': '',
            'nombre_categoria_producto': '',
            'codigo_categoria_prod_insti': 0,
            'valor_iva_producto': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_ciudad': '',
            'rol_usuario_institucion': 0,
            'profesion_usuario': '',
            'state_product': 0,
            'resumen_producto': '',
            'nombre_clase_producto': '',
            'puntos_producto': 0,
            'cantidad_producto': 0,
            'codigo_clase_producto': 0,
            'manejo_unidades': false,
            'owner': false,
            'producto_sin_precio':false,
            'averagepurchase': [],
            'srcparams': '',
            'contador_like': 0,
            'nombre_pais': '',
            'url_profile': '',
            'seg_codigo_usuario': 0,
            'nombre_entidad': '',
            'nickname_entidad': '',
            'avg_purchase_user': 0,
            'message_categorias_marketplace': false,
			'modalidad_prestacion_servicio': '',
            'modalidad_texto': '',
            'descuento': 0,
            'porcentaje_descuento': ''
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

        }
    });

})(this, this.document);
