/**
* Class UserWallCommentListView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserWallCommentListView = Backbone.View.extend({

        className: 'comments-post-list',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.$spinnerComments = $('<div>').attr('id','spinner-load-comments');

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            // this.listenTo( this.collection, 'update', this.render);
        },

        /*
        * Render View Element
        */
        render: function(){

            this.$el.slideToggle('normal');
        },

        /**
        * Render view comment by model
        * @param Object categoryModel Model instance
        */
        addOne: function (commentPostModel) {

            var view = new app.UserWallCommentView( {model:commentPostModel} );
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view comment of the collection
        */
        addAll: function () {
            this.$el.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a forum comment
        * @param form element
        */
        storeOne: function ( data, form ) {

            this.collection.create( data, {patch:true, wait:true} );
            $(form).find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            if( Backbone.Collection.prototype.isPrototypeOf(target) ){
                window.Misc.setSpinner( this.$el );
            }else{
                this.$spinnerComments.prependTo( this.$el );
                window.Misc.setSpinner( this.$spinnerComments );
            }
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            //complete process
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function ($spinner) {
                    return function () {
                        $spinner.remove();
                    };
                })(this.$spinnerComments)
            });
        }
   });

})(jQuery, this, this.document);
