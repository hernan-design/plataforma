/**
* Class ProjectAttachmentList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProjectAttachmentList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('adjunto.usuario.index') );
        },
        model: app.AttachmentModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
