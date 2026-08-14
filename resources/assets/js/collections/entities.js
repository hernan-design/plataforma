/**
* Class EntitiesList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EntitiesList = Backbone.Collection.extend({

        mode: 'server',
        url: function () {
            return window.Misc.urlFull( Route.route('entidad.index') );
        },
        model: app.EntityModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        	//
        }
   });

})(this, this.document);
