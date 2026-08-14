/**
* Class UrlMetaDataModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UrlMetaDataModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('muro.metadata') );
        },
        defaults: {
            'url': '',
            'status': 0,
            'success': false,
            'image': '',
            'description': '',
            'title': '',
            'author': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model options
        */
        initialize: function(attrs, opts){
            //Init attributes
        },

         /**
        * validate attributes model in the change
        * @param Object attrs. modified attributes model
        */
        validate: function (attrs) {
            
            var error = new Error();

            if( ! attrs.success ){
                error.message = "No se logro el previsualizado.";
                return error;
            }
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

            this.set( this.defaults, opts );
        }

    });

})(this, this.document);