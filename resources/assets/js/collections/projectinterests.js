/**
* Class ProjectInterestsList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectInterestsList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('proyecto.intereses.index') );
        },
        model: app.ProjectInterestModel,
        
        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
