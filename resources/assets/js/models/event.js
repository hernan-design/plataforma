/**
* Class EventModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EventModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('calendario.evento.index') );
        },
        idAttribute: 'codigo_evento',
        defaults: {
            'nombre_evento': '',
            'descripcion_evento': '',
            'fecha_label_evento': '',
            'fecha_evento': '',
            'fecha_fin_evento': '',
            'hora_inicio_evento': '',
            'hora_fin_evento': '',
            'lugar_evento': '',
            'descripcion_mentoria': '',
            'objetivos_mentoria': [],
            'codigo_tipo_evento': 0,
            'codigo_calendario': 0,
            'codigo_ciudad': 0,
            'estado_evento': 0,
            'url_evento': '',
            'url_mentoria': '',
            'url_evento_organizador': '',
            'nombre_ciudad': '',
            'organizadores': [],
            'owner': false,
            'register': false,
            'categorias' : [],
            'etapas': [],
            'register': false,
            'view':false,
            'nombre_organizador_principal': '',
            'nombre_emprendimiento': '',
            'nombre_usuario_emprendimiento': '',
            'apellido_usuario_emprendimiento': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        	//
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
