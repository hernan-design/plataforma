/**
* Class SalesListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.SalesListView = Backbone.View.extend({

        el: '#marketplace-content',
        template: _.template( ($('#marketplace-list-tpl').html() || '') ),
		templateResultCount: _.template( ($('#browse-result-count-tpl').html() || '') ),
        events: {
            //
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = {},
                _this = this;

            // initialize reference
            this.$wrapPagination = this.$('.wrap-pagination');
            this.$postsWrap = this.$('#my-sales-list');
            this.$noResults = this.$('.no-results-filter');

            this.$wrapPagination.each(function(index, el) {

                var pagination = new app.Paginator({
                    className: 'right pagination inner-title-section',
                    collection: _this.collection,
                    attributes: {
                        data: _this.parameters.dataFilter
                    }
                });
                $(el).html( pagination.render().el );
            });


            if( this.collection.length )
                this.$noResults.css('display', 'none');

            return this;
        },

        /**
        * Render view purchase by model
        * @param Object purchaseModel Model instance
        */
        addOne: function (purchaseModel) {

            var view = new app.SalesItemView({
                model: purchaseModel
            });

            this.$postsWrap.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {

            this.$postsWrap.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            if( target instanceof Backbone.Collection ){
                window.Misc.setSpinner( this.$postsWrap );
            }
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( target instanceof Backbone.Collection && !target.length )
                this.$noResults.fadeIn('fast');

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });

			// set result count
			this.resultCount(this.collection.state);
		},

		/**
		* set result count
		* @param Object states
		*/
		resultCount: function (states) {

			if( !(this.collection instanceof Backbone.PageableCollection) )
				return;

			var fromResult = this.collection.state.currentPage <= this.collection.state.firstPage ? 1 : (this.collection.state.currentPage * this.collection.state.pageSize) + 1,
				toResult = (this.collection.state.firstPage ? this.collection.state.currentPage : this.collection.state.currentPage + 1) * this.collection.state.pageSize;

			this.$('.wrap-result-count').html(this.templateResultCount({
				'from': fromResult,
				'to': toResult > this.collection.state.totalRecords ? this.collection.state.totalRecords : toResult,
				'totalRecords': this.collection.state.totalRecords
			}));
		},
   });

})(jQuery, this, this.document);
