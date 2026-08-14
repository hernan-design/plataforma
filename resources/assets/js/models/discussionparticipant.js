/**
* Class DiscussionParticipantModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionParticipantModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('discusion.participantes.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            'nombre_usuario': '',
            'imagen_usuario': '',
            'nickname_usuario': '',
            'profesion_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'contador_inscritos': 0,
            'srcparams': '',
            'state_friendship': '',
            'url_profile': '',
            'codigo_convocatoria': 0,
            'codigo_orientacion_convocatoria': 0        
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
            
        }
    });

})(this, this.document);
