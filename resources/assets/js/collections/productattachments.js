/**
* Class AttachmentList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AttachmentList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('adjunto.producto.index') );
        },
        model: app.AttachmentModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
