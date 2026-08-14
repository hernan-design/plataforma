/**
* Class CourseThemeModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeModel = Backbone.Model.extend({

        urlRoot: function () {
           return window.Misc.urlFull( Route.route('aprende.curso.tema.index') );
        },
        idAttribute: 'codigo_tema_curso',
        defaults: {
            'nombre_tema_curso': '',
            'url_tema_curso': '',
            'url_adjunto': '',
            'codigo_curso': 0,
            'objetivo_tema_curso': '',
            'adjuntos': [],
            'codigo_estado': '',
            'log_curso': false,
            'log_biofacial': false
        },
        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        }
    });

})(this, this.document);
