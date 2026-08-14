/**
* Class AdviceModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AdviceModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.preguntas.index') );
        },
        idAttribute: 'codigo_asesoria',
        defaults: {
            'url_asesoria': '',
            'titulo_asesoria': '',
            'descripcion_asesoria': '',
            'propuesta_asesoria': '',
            'codigo_tipo_asesoria': null,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'fecha_asesoria': '',
            'hora_asesoria': '',
            'tags': [],
            'nombre_tipo_asesoria': '',
            'contador_comentario': 0,
            'contador_like': 0,
            'is_open': true,
            'owner': false,
            'srcparams': '',
            'codigo_usuario': 0,
            'url_profile': '',
            'isMentor' : null
        },

        /**
        * Constructor Method
        * @param Object attrs, model Attributes
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
        },

        /**
        * change state mentoring
        */
        closeMentoring: function () {
            this.save({
                'codigo_asesoria': this.get('codigo_asesoria'),
                'close': true,
                '_token': $('meta[name="csrf-token"]').attr('content'),
            }, {patch: true, wait: true});
        }
    });

})(this, this.document);
