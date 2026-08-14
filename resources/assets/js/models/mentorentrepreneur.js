/**
* Class MentorEntrepreneurModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.MentorEntrepreneurModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.mentoremprendimiento.index') );
        },
        defaults: {
            'codigo_proyecto': 0,
            'codigo_usuario': 0
            
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
