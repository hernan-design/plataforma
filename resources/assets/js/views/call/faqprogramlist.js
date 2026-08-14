/**
* Class FaqProgramListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.FaqProgramListView = Backbone.View.extend({

        el: '#faq-programs',
        templateBtnMore: _.template( ($('#btn-view-more-tpl').html() || '') ),
        events: {
            // 
        },
        parameters: {
            program: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            _.bindAll(this, 'showMore');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.$wrapViewMore = $( this.templateBtnMore() );
            this.$postsWrap = this.$('#program-faq-wrap');
            this.$noResults = this.$('.no-results-filter');
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');
            this.pageOld = this.collection.state.currentPage;

            this.dataFilter = {'program': this.parameters['program']};

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.listenTo( this.collection, 'all', this.render);

            this.$wrapViewMore.on( 'click', '.btn-view-more', this.showMore);
            this.on('getdata', this.getFirstData);

            $( window ).on("scroll", this.onLoadMore);

            this.trigger('getdata');
        },

        /*
        * Render View Element
        */
        render: function(){

            if( this.collection.length )
                this.$noResults.css('display', 'none');            

            this.$el.append( this.$wrapViewMore );
        },

        /**
        * Render view faq by model
        * @param Object faqModel Model instance
        */
        addOne: function (faqModel) {

            var view = new app.FaqProgramItemView({
                model: faqModel,  
                parameters: {
                    // 
                }
            });
            this.$postsWrap.append( view.render().el ); 
        },

        /**
        * Render all view Faq of the collection
        */
        addAll: function () {
            
            this.$postsWrap.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            this.$noResults.css('display', 'none');

            this.$elmSpinner = this.$wrapViewMore;

            if( target instanceof Backbone.Collection ){
           
                this.$spinnerPosts.appendTo( this.$elmSpinner );
            }else{

                this.$spinnerPosts.prependTo( this.$elmSpinner );
            }

            window.Misc.setSpinner( this.$elmSpinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length )
                this.$noResults.fadeIn('fast');

            // complete process
            window.Misc.removeSpinner({
                'wrap': this.$elmSpinner,
                'direct': false,
                'callback': (function ($elSpinner) {
                    return function () {
                        $elSpinner.remove();
                    };
                })(this.$spinnerPosts)
            });

            if( this.collection.state.currentPage >= this.collection.state.lastPage){
                this.$wrapViewMore.hide();
            }else{
                this.$wrapViewMore.show();
            } 
        },

        /**
        * get reset data
        *
        */
        getFirstData: function  () {

            this.$wrapViewMore.hide();
            this.collection.getFirstPage( {reset:true, data: this.dataFilter} );
        }, 

        /**
        * Show more discussion program
        */
        showMore: function (e) {
            e.preventDefault();

            if( this.collection.hasNextPage() ){
                this.collection.getNextPage( {wait:true, data: this.dataFilter} );   
            }
        }
   });

})(jQuery, this, this.document);

