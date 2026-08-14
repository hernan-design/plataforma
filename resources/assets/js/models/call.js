/**
* Class CallModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CallModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('convocatoria.index') );
        },
        idAttribute: 'codigo_convocatoria',
        defaults: {
            'url_convocatoria': '',
            'nombre_convocatoria' : '',
            'imagen_convocatoria' : '',
            'banner_convocatoria' : '',
            'contador_inscritos' : 0,
            'descripcion_convocatoria' : '',
            'resumen_convocatoria' : '',
            'tipo_convocatoria': '',
            'url_externa_convocatoria': '',
            'terminos_convocatoria' : '',
            'politicas_convocatoria' : '',
            'contenido_aceptacion_terminos' : '',
            'codigo_orientacion_convocatoria': 0,
            'fecha_cierre_registro': '',
            'fecha_cierre_convocatoria': '',
            'fases' : [],
            'documentos' : [],
            'categorias' : [],
            'etapas': [],
            'registered': false,
            'registered_entity': false,
            'opened': false,
            'codigo_estado': 0,
            'contador_like': 0,
            'srcparams': '',
            'userentitys': [],
            'type_user': 0,
            'url_encuesta': '',
            'url_organizador': '',
            'nombre_organizador' : '',
            'imagen_organizador' : '',
            'mensaje_tiempo_restante':'',
            'texto_alerta_convocaotoria':'',
            'permanente_convocatoria':false
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        }
    });

})(this, this.document);
