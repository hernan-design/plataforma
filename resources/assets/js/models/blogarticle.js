/**
* Class BlogArticleModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.BlogArticleModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('blog.index') );
        },
        idAttribute: 'codigo_contenido',
        defaults: {
            'url_contenido': '',
            'nombre_contenido': '',
            'resumen_contenido': '',
            'texto_contenido': '',
            'imagen_contenido': '',
            'fecha_contenido': '',
            'codigo_contenido': null,
            'codigo_tipo_contenido': 0,
            'contador_comentario': 0,
            'contador_like': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'time_ago': null,
            'srcparams': '',
            'url_profile': '',
            'owner': false,
            'url_tipo_contenido': '',
            'state_product': 0,
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
        },

        /**
        * return to url initial
        */
        returnToUrlRoot: function () {
            // redefine the URI
            this.url = function () {
                var base =
                    _.result(this, 'urlRoot') ||
                    _.result(this.collection, 'url') ||
                    urlError();

                if (this.isNew()) return base;
                var id = this.get(this.idAttribute);
                return base.replace(/[^\/]$/, '$&/') + encodeURIComponent(id);
            };
        }
    });

})(this, this.document);
