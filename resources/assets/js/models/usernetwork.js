/**
* Class UserNetworkModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserNetworkModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.redusuario.index') );
        },
        idAttribute: 'seg_codigo_usuario',
        defaults: {
            'state_friendship': '',
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'profesion_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'rol_usuario_institucion': '',
            'owner': false
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        }
    });

})(this, this.document);
