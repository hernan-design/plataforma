/**
* Class ProjectProductModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectProductModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('marketplace.index') );
        },
        idAttribute: 'codigo_producto',
        defaults: {
            'url_producto': '',
            'codigo_clase_producto': 0,
            'nombre_producto': '',
            'descripcion_producto': '',
            'precio_producto': '',
            'iva_producto': 0,
            'imagen_producto': '',
            'url_categoria_producto': '',
            'nombre_categoria_producto': '',
            'codigo_categoria_producto': 0,
            'privacidad_producto': 0,
            'nombre_privacidad_producto': '',
            'cantidad_producto': 0,
            'manejo_unidades': false,
            'producto_sin_precio': false
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

        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({silent:true});
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        }
    });

})(this, this.document);
