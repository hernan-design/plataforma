/**
* Class UserNoteListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserNoteListView = Backbone.View.extend({

        el: '#side-course-notes',
        events: {
            'submit #form-note-course': 'onStore',
            'keypress #texto_nota_usuario': 'onStore'
            // 'click .load-posts': 'onLoadMore'
        },
        parameters: {
            course: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'onLoadMore');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.$postsWrap = this.$('#notes-posts-wrap');
            this.$formCreate = this.$('#form-note-course');
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');
            this.pageOld = this.collection.state.currentPage;

            this.dataFilter = {'course': this.parameters['course']};

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.listenTo( this.collection, 'all', this.render);
            this.on('getdata', this.getFirstData);

            $( window ).on("scroll", this.onLoadMore);

            this.trigger('getdata');
        },

        /*
        * Render View Element
        */
        render: function(){
            return this;
        },

        /**
        * Render view comment by model
        * @param Object usernoteModel Model instance
        */
        addOne: function (usernoteModel) {

            var view = new app.UserNoteItemView({
                model: usernoteModel
            });
            this.$postsWrap.prepend( view.render().el );
        },

        /**
        * Render all view comment of the collection
        */
        addAll: function () {

            this.$postsWrap.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a forum comment
        * @param form element
        */
        storeOne: function ( data ) {

            this.collection.create( data, {patch:true, wait:true} );
            window.Misc.setSpinner( this.$formCreate );
        },

        /**
        * Store posts
        */
        onStore: function (e) {
            if( e.type == 'submit' ) e.preventDefault();

            if( e.type == 'keypress' && e.which != 13 ){
                return;

            }else if( e.type == 'keypress' && e.which == 13 ) {
                this.$formCreate.submit();
                return;
            }

            var data = window.Misc.formToJson( this.$formCreate  );

            data.texto_nota_usuario = window.Misc.stripTags( data.texto_nota_usuario );
            data.texto_nota_usuario = data.texto_nota_usuario.replace(/(\&nbsp;|<[a-z\?\!\/]([a-z0-9\_\:\.])*(\s[^>]*)?(>|$))/gi, ' $&');
            data.texto_nota_usuario = window.Misc.urlWrapLink( data.texto_nota_usuario );

            this.collection.trigger('store', data);
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            if( ! target instanceof Backbone.Model ){
                if( target instanceof Backbone.Collection ){
                    this.$spinnerPosts.appendTo( this.$postsWrap );
                }else{
                    this.$spinnerPosts.prependTo( this.$postsWrap );
                }

                window.Misc.setSpinner( this.$spinnerPosts );
            }
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function ($elSpinner, $formReset) {
                    return function () {
                        $formReset.find('[name="texto_nota_usuario"]' ).val('')
                            .end().find( '.wysiwyg-editor' ).html('');
                        $elSpinner.remove();
                    };
                })(this.$spinnerPosts, this.$formCreate)
            });

            window.Misc.removeSpinner({'wrap': this.$formCreate})
        },

        /**
        * get reset data
        *
        */
        getFirstData: function  () {
            this.collection.getFirstPage( {reset:true, data: this.dataFilter} );
        },

        /**
        * load more posts
        */
        onLoadMore: function (e) {

            e.preventDefault();
            var _this = this;

            var scrollHeight = $(document).height();
            var scrollPosition = $(window).height() + $(window).scrollTop();

            if ((scrollHeight - scrollPosition) / scrollHeight <= 0.001) {

                // when scroll to bottom of the page
                if( this.collection.state.currentPage < this.collection.state.lastPage && this.pageOld == this.collection.state.currentPage ){

                    this.collection.getNextPage({
                        data: this.dataFilter,
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
