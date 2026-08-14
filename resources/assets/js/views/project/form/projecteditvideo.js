/**
* Class ProjectEditVideo extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectEditVideo = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        id: 'container-form-videodata',
        template: _.template( ($('#edit-project-video-form-tpl').html() || '') ),
        events: {
            'submit #form-video-project': 'onEditForm',
            'keyup #video-project-txt': 'onPreviewVideo',
            'change #video-project-txt': 'onPreviewVideo'
        },
        parameters: {
            'dropdown': false,
            'canSave': true
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Init Attributes
            this.$editVideoPreview = $('.preview-video-project');
            this.$inputVideoProject = $('.input-video-project');

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            // Initialize reference to elements
            this.$videoPreview = this.$('#video-project-preview');

            return this;
        },

        onEditForm: function (e) {

            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            // Check out whether we can save the video right now
            if( this.parameters.canSave ) {
            	this.model.save(data, {patch:true, wait:true});

            }else {

            	if( this.$editVideoPreview != undefined && this.$editVideoPreview.length ){
            		if( window.Misc.isUrl(data['video_entidad']) ) {
            			this.$editVideoPreview.attr('src', window.Misc.convertVideoEmbed(data['video_entidad'],'embed') );
            		}
            	}

            	if( this.$inputVideoProject != undefined && this.$inputVideoProject.length ) {
            		this.$inputVideoProject.val( data['video_entidad'] );
            	}

            	if( this.parameters['dropdown'] !== false )
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });

            if( this.parameters['dropdown'] !== false )
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        },

        /**
        * Event preview video
        */
        onPreviewVideo: function (e) {

            var $fldVideo = $(e.target),
                urlVideo = $fldVideo.val();

            if( window.Misc.isUrl(urlVideo) ){

                urlVideo = window.Misc.convertVideoEmbed(urlVideo, 'embed');
                if( urlVideo ){
                    this.$videoPreview.attr('src', urlVideo);
                }
            }
        }
    });

})(jQuery, this, this.document);
