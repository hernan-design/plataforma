/**
* Class CourseThemeList of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('aprende.curso.tema.index') );
        },
        model: app.CourseThemeModel,
        /**
        * Constructor Method
        */
        initialize : function(){
            // 
        },

        getLecture : function (course, theme, lecture) {
            
            var lectureModel = this.find(function (model) {
                return model.get('url_tema_curso') == theme;
            });

            return _.findWhere(lectureModel.get('adjuntos'), {url_adjunto: lecture});
        }
   });

})(this, this.document);
