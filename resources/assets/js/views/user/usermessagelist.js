/**
* Class UserMessageListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserMessageListView = Backbone.View.extend({

        className: 'comments-discussion-list',
        events: {
        },
        parameters: {
           'codigo_discucion': '',
           dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            _.bindAll(this, 'onLoadMore');

            // Extend options parameters
            if( opts !== undefined && _.isObject(opts.parameters) ){
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

            var _this = this;

            //Init Attributes
            this.$spinnerComments = $('<div>').attr('id','spinner-load-comments');
            this.pageOld = this.collection.state.currentPage;

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.listenTo( this.collection, 'all', this.render);
            this.on('store', this.storeOne);
            this.on('getdata', this.getFirstData);

            // listening scrolltop event
            this.$el.off('ps-y-reach-start');
            this.$el.on('ps-y-reach-start', this.onLoadMore);

            // sorting collection
            this.collection.state.pageSize = 15;
            this.collection.setSorting('id_comentario', '1');
        },

        /*
        * Render View Element
        */
        render: function(){
            //
        },

        /**
        * get firsts data
        * @param Object dataFilter
        */
        getFirstData: function (dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
        },

        /**
        * Render view comment by model
        * @param Object commentDiscussionModel Model instance
        */
        addOne: function (commentDiscussionModel) {

            var view = new app.UserMessageItemView( {model: commentDiscussionModel} );

            if( commentDiscussionModel.isNew() ){
                this.$el.append( view.render().el );
            }else{
                this.$el.prepend( view.render().el );
            }

            // reload plugins
            if( _.has($.fn, 'foundation') ){
                $(document).foundation('dropdown', 'reflow');
            }

            // if already finish to the end
            if( this.collection.length == (this.collection.indexOf(commentDiscussionModel)+1) && this.collection.state.firstPage == this.collection.state.currentPage ) {
                this.trigger('readyContent', this.el);
            }
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

            this.collection.create( data, {patch:true, wait:false} );
            $(form).find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            if( target instanceof Backbone.Collection ){
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
        },

        /**
        * load more posts
        */
        onLoadMore: function () {
            var _this = this;

            if ( this.$el.scrollTop() <= 0 ) {

                // when scroll to bottom of the page
                if( this.collection.state.currentPage < this.collection.state.lastPage && this.pageOld == this.collection.state.currentPage ){

                    this.collection.getNextPage({
                        data: this.parameters.dataFilter,
                        wait: true,
                        success: function (collection) {
                            _this.pageOld = collection.state.currentPage;
                        }
                    });
                }
            }
        }
   });

})(jQuery, this, this.document);
