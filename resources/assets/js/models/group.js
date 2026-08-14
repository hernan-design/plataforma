/**
* Class GroupModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.GroupModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('grupo.index') );
        },
        idAttribute: 'codigo_entidad',
        defaults: {
            'id_entidad': 0,
            'nombre_usuario': '',
            'biografia_usuario': '',
            'descripcion_entidad': null,
            'codigo_etapa_proyecto': 0,
            'codigo_categoria_proyecto': 0,
            'codigo_clase_emprendimiento': 0,
            'codigo_ciudad': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'codigo_privacidad_contenido': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_institucion': '',
            'slug_institucion': '',
            'background_body': null,
            'tags': null,
            'video_entidad': null,
            'facebook_usuario': null,
            'twitter_usuario': null,
            'linkedin_usuario': null,
            'tiktok_usuario': null,
            'pagina_web_usuario': null,
            'contador_comentario': 0,
            'contador_like': 0,
            'srcparams': '',
            'updated_at': '',
            'nombre_clase_emprendimiento': '',
            'identificacion_usuario': '',
            'codigo_categoria_clase_espacio': 0,
            'owner': false,
            'codigo_usuario': 0,
            'nombre_privacidad_contenido': '',
            'icono_privacidad_contenido':'',
            'nombre_categoria_proyecto': '',
            'orientacion_clase_espacio':0,
            'statejoin': '',
            'nombre_categoria_clase_espacio': ''

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
            // var err = new Error();
            // err.message = "Complete los campos obligatorios";

            // if( !attrs.resumen_proyecto.length || attrs.codigo_categoria_proyecto < 1 ){
            //     return err;
            // }
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
