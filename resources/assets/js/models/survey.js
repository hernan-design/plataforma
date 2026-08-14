/**
* Class SurveyModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SurveyModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('encuesta.index') );
        },
        idAttribute: 'codigo_encuesta',
        defaults: {
            'url_encuesta': '',
            'nombre_encuesta': '',
            'fecha_encuesta': '',
            'reference_encuesta': '',
            'redirect_to': '',
            'preguntas': [],
            'agrupaciones': [],
            'label_finalizar': '',
            'color_fondo_encuesta': '',
            'color_encuesta': '',
            'imagen_encuesta': '',
            'codigo_usuario': 0,
            'cancelar_encuesta': false,
            'preguardado_encuesta': false,
            'nickname_usuario': '',
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
            // var err = new Error();
            // err.message = "Complete los campos obligatorios";

            // if( !attrs.nombre_encuesta.length || attrs.reference_encuesta < 1 ){
            //     return err;
            // }
        },

        /**
        * JSON object to String
        */
        toStrJSON: function () {
            return JSON.stringify( this );
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
