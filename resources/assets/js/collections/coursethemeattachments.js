/**
* Class CourseThemeAttachedList of Backbone Collection
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeAttachedList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('aprende.curso.tema.adjunto.index') );
        },
        model: app.CourseThemeAttachedModel,
        /**
        * Constructor Method
        */
        initialize : function(){
            //
        }
   });

})(this, this.document);
