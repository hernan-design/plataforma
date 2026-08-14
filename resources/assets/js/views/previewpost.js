/**
* Class PreviewPostView of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PreviewPostView = Backbone.View.extend({

        id: 'preview-post-view',
        className: 'row collapse wall-post-preview',
        template: _.template( ($('#preview-post').html() || '') ),
        events: {
            'click .close': 'onClear'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes
            this.$wrapperPostsWall = $('#wrapper-preview-post');//$( '#wrapper-posts-wall' );
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy invalid', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'preview', this.fetchDataUrl );
            this.on( 'reassign', this.reassign );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
                    .fadeIn('normal');

            return this;
        },

        /*
        * Remove View Element
        */
        remove: function(model){
            var _this = this;

            // if( _.isObject(model) ) 
            this.model.resetAttrs( {silent: true} );

            this.$el.slideUp('normal', function (){
                _this.$el.empty();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
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
        },

        /**
        * fetch data of url
        */
        fetchDataUrl: function (parseUrl) {

            if( this.model.previous('url') == parseUrl )
                return;

            // var previewPost = window.app.AppRouter.previewPost;
            this.$wrapperPostsWall.prepend( this.render().el );

            this.model.fetch( {data: {'url': parseUrl }, validate: true } );
        },

        /**
        * remove the item, destroy the model
        */
        onClear: function (e) {
            e.preventDefault();

            // this.model.set({success: null}, {silent: true});
            this.remove();
        },

        /**
        * Reassign elements
        */
        reassign: function () {
            this.$wrapperPostsWall = $('#wrapper-preview-post');
        }
   });

})(jQuery, this, this.document);
