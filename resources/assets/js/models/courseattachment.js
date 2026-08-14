/**
* Class CourseAttachmentModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CourseAttachmentModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.adjunto.index') );
        },
        idAttribute: 'url_adjunto',
        defaults: {
        	'codigo_adjunto': '',
        	'codigo_curso': '',
            'codigo_estado': 0,
            'direccion_adjunto': '',
            'nombre_adjunto': '',
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
