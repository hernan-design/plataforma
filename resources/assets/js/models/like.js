/**
* Class LikeModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.LikeModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('like.index') );
        },
        idAttribute: 'codigo_like',
        defaults: {
            'codigo_usuario': 0,
            'srcparams': '',
            'fecha_like': '',
            'hora_like': '',
            'codigo_estado': 0,
            'value_txt': '',
            'auth_like': false,
            'nickname_usuario': '',
            'nombre_usuario': '',
            'imagen_usuario': '',
            'url_profile': '',
            'contador_like': 0
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //Init attributes
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            // console.log( attrs );
        }

    });

})(this, this.document);
