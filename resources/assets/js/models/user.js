/**
* Class UserModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            'id': 0,
            'codigo_persona': 0,
            'nickname_usuario': '',
            'tipo_identificacion_usuario': '',
            'identificacion_usuario': '',
            'nombre_usuario': '',
            'primer_apellido_persona': '',
            'segundo_apellido_persona': '',
            'fecha_nacimiento_usuario': '',
            'codigo_ciudad': 0,
            'codigo_usuario_institucion': 0,
            'codigo_nivel_educacion': '',
            'codigo_especialidad': 0,
            'codigo_especialidad_destacada': 0,
            'rol_usuario_institucion': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'biografia_usuario': '',
            'experiencia_usuario': '',
            'direccion_usuario': '',
            'barrio_usuario': '',
            'telefono_usuario': '',
            'movil_usuario': '',
            'imagen_usuario': '',
            'correo_electronico': '',
            'profesion_usuario': '',
            'pagina_web_usuario': '',
            'estado_civil_persona': 0,
            'nombre_estado_civil': '',
            'genero_persona': 0,
            'nombre_genero': '',
            'contador_gamification': '',
            'posicion_gamification': '',
            'facebook_usuario': '',
            'twitter_usuario': '',
            'linkedin_usuario': '',
            'tiktok_usuario': '',
            'mentor': false,
            'owner': false,
            'state_friendship': '',
            'srcparams': '',
            'codigo_concepto_institucion': 0,
            'tipo_usuario': 0,
            'forma_ayuda_mentoria': '',
            'descripcion_adicional_usuario': '',
            'stage_mentoring': 0,
            'aceptacion_terminos':false
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
