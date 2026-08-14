/**
* Class ProjectTeamModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.ProjectTeamModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.equipo.index') );
        },
        idAttribute: 'seg_codigo_usuario',
        defaults: {
            'codigo_usuario': 0,
            'codigo_rol_usuario_grupo_insti': 0,
            'administracion_grupo_usuario': false,
            'fecha_hora_grupo_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'nombre_rol_usuario_grupo': '',
            'nombre_ciudad': '',
            'nombre_pais': '',
            'owner': false,
            'ownerlist':false,
            'nickname_usuario': '',
            'statejoin': ''  
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
            
        }
    });

})(this, this.document);
