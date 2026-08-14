/**
* Class CourseThemeAttachedModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseThemeAttachedModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.tema.adjunto.index') );
        },
        idAttribute: 'url_adjunto',
        defaults: {
            'direccion_adjunto': '',
            'nombre_adjunto': '',
            'codigo_tipo_adjunto': 0,
            'state_review': false,
            'srcparams': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        },

        /**
        * change state of review attached
        */
        changeStateReview: function () {

            this.save({
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'srcparams': this.get('srcparams')
            }, {patch: true});
        }
    });

})(this, this.document);
