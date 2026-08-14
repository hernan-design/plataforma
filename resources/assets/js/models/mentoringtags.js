/**
* Class MentoringTaskModel extend of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringTagsModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.tags.index') );
        },
        idAttribute: 'codigo_tag_sesion_mentoria',
        defaults: {
            'codigo_mentoria': 0,
            'nombre_tag_sesion_mentoria': '',
            'valor_tag_sesion_mentoria': '',
            'mentor': false,
            'item': 0
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
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
            var err = new Error();
            if( ! attrs.nombre_tag_sesion_mentoria.length && attrs.valor_tag_sesion_mentoria.length){
                err.message = "No existen tags.";
                return err;
            }
        }
    });

})(this, this.document);
