/**
* Class ItemEvaluationModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemEvaluationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('evaluacion.index') );
        },
        idAttribute: 'codigo_grupo_item_eval',
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
        }
    });

})(this, this.document);
