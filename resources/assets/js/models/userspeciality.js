/**
* Class UserSpecialityModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserSpecialityModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.especialidades.index') );
        },
        idAttribute: 'codigo_especialidad',
        defaults: {
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_especialidad': '',
            'descripcion_especialidad': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {

        }
    });

})(this, this.document);
