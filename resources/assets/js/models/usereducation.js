/**
* Class UserEducationModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserEducationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('usuario.educaciones.index') );
        },
        idAttribute: 'codigo_nivel_educacion_usuario',
        defaults: {
            'codigo_nivel_educacion': 0,
            'codigo_usuario': 0,
            'codigo_estado': 0,
            'nombre_nivel_educacion': '',
            'disciplina': ''

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
