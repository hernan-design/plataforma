
/**
 * Class CourseBrowseListView of Backbone View
 * @author TuProyecto || Desarrollador : @xindykatalina
 * @link http://TuProyecto.com
 */

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseNotedListView = Backbone.View.extend({
        el: '#section-course-list',
        events: {
            'click .course-certificate-total' : 'onCertificateTotal',
        },
        parameters: {
            dataFilter: {},
            'ul-view': '',
            type: ''
        },

        /**
         * Constructor Method
         */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            //Init Attributes
            this.pageOld = this.collection.state.currentPage;
            this.$spinnerProduct = $('<div>').attr('id','spinner-load-posts');

            var _this = this;

            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.on('getdata', this.getFirstData);

            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            $( window ).off("scroll");

            if( this.parameters.dataFilter.limit ) {
                this.collection.state = this.collection._checkState(_.extend({}, this.collection.state, {
                    pageSize: this.parameters.dataFilter.limit
                }));
            }else {
                $( window ).on("scroll", this.onLoadMore);
                this.collection.state = this.collection._checkState(_.extend({}, this.collection.state, {
                    pageSize: 4
                }));
            }
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = {},
                _this = this;

            attributes.type = this.parameters['type'];
            attributes.dataFilter = this.parameters['dataFilter'];

            // Initialize reference
            this.$wrapperData = this.parameters['ul-view'];
            this.$noResults = this.$('.no-results-filter');
        },

        /**
         * Fires before of run render function
         */
        beforeRender: function() {
        },

        /**
         * Fires after of run render function
         */
        afterRender: function() {
            this.ready();
        },

        /**
         * get reset data
         * @param dataFilter Object
         * @param replace Boolean
         */
        getFirstData: function  (dataFilter, replace) {
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
         * fires libraries js and functions
         */
        ready: function () {

            // trigger functions
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();
        },

        /**
         * Render view comment by model
         * @param Object courseModel Model instance
         */
        addOne: function (courseModel) {
                var view = new app.CourseBrowseItemNoted({
                    model: courseModel,
                    parameters: {
                        dataFilter: this.parameters.dataFilter,
                        type: this.parameters['type']
                    }
                });

            this.$wrapperData.append( view.render().el );
        },

        /**
         * Render all view Marketplace of the collection
         */
        addAll: function () {
            this.$wrapperData.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
         * Load spinner on the request
         */
        loadSpinner: function ( target, xhr, opts ) {

            this.$noResults.css('display', 'none');

            this.$elmSpinner = this.$spinnerProduct;

            if( target instanceof Backbone.Collection ){
                this.$spinnerProduct.appendTo( this.$wrapperData.parent() );

                if( !target.length ) {
                    this.$elmSpinner = this.$wrapperData.parent();
                }
            }else{
                this.$spinnerProduct.prependTo( this.$wrapperData.parent() );
            }
            window.Misc.setSpinner( this.$elmSpinner );
        },

        /**
         * response of the server
         */
        responseServer: function ( target, resp, opts ) {

            if( target instanceof Backbone.Collection && !target.length ){
                this.$noResults.fadeIn('fast');
            }else {
                this.$noResults.css('display', 'none');
            }

            window.Misc.removeSpinner({
                'wrap': this.$elmSpinner,
                'direct': false,
                'callback': (function ($elSpinner) {
                    return function () {
                        $elSpinner.remove();
                    };
                })(this.$spinnerProduct)
            });
        },

        /**
         * load more
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
                        data: _.clone(this.parameters.dataFilter),
                        wait: true,
                        success: function (collection) {
                            _this.pageOld = collection.state.currentPage;
                        }
                    });
                }
            }
        },

        onCertificateTotal: function(e) {
            e.preventDefault();

			var _this = this;

			window.Misc.setSpinner( this.$el );

			$.post( window.Misc.urlFull( Route.route('aprende.curso.certificadoTotal') ), {
                '_token': $('meta[name=csrf-token]').attr('content'),
            }).success( function (resp){
				if (resp.success) {
					window.Misc.removeSpinner({
						'wrap': _this.$el,
						'direct': true
					});

					window.Misc.redirect(resp.url)
				} else {
					var config = {
						'text': resp.error,
						'type': 'alert'
					};
					_.extend( _this.configAlert, config );

					window.Misc.showAlertBox( conf );
				}
			});
        }
    });

})(jQuery, this, this.document);
