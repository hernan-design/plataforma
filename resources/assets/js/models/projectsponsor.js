/**
* Class ProjectSponsorModel of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.ProjectSponsorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('proyecto.patrocinador.index') );
        },
        idAttribute: 'codigo_patrocinador',
        defaults: {
            'codigo_entidad': 0,
            'nombre_patrocinador': '',
            'imagen_patrocinador': '',
            'url_patrocinador': '',
            'owner': false     
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
