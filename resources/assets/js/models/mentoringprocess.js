/**
* Class MentoringItemModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringProcess = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.mentores.procesos.index') );
        },
        idAttribute: 'codigo_usuario',
        defaults: {
            //
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
            if( ! attrs.nombre_item_general_mentoria.length ){
                err.message = "No hay items.";
                return err;
            }
        }
    });

})(this, this.document);
