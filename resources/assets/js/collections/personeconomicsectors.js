/**
* Class PersonEconomicSectorList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykata
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PersonEconomicSectorList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('usuario.economicos.index') );
        },
        model: app.PersonEconomicSectorModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
