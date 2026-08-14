/**
* Class Paginator extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.Paginator = Backbone.View.extend({

		tagName: 'ul' ,
		className: 'pagination',
		template: _.template( ($('#pagination-tpl').html() || '') ),
		maxLen: 8,
		events: {
			'click .arrow.start-page a': 'onStartPage',
			'click .arrow.end-page a': 'onEndPage',
			'click .arrow.prev-page a': 'onPrevPage',
			'click .arrow.next-page a': 'onNextPage',
			'click li:not(.arrow) a': 'onGetPage'
		},
		parameters: {
			nameForm: '',
			data: {},
            queryParams:{}
		},

		/**
		* Constructor Method
		*/
		initialize: function(opts){
			_.bindAll(this, 'onReasignLen');

			// extend view parameters
            if( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

			if( ! this.collection instanceof Backbone.PageableCollection ) {
                return;
            }

			//Init Attributes
			this.$formFilter = this.parameters['nameForm'];

			// Events Listener
			this.listenTo( this.collection, 'reset', this.render );
            this.listenTo( this.collection, 'change', this.updatedState );

			// handler with resize window event
			this.onReasignLen();
			$(window).off('resize load', this.onReasignLen);
			$(window).on('resize load', this.onReasignLen);
		},


		/*
		* Render View Element
		*/
		render: function () {

			var items = this.buildItems();
			var attributes = { items: items };
			this.$el.html( this.template(attributes) );

			this.$el.find('li.arrow').removeClass('unavailable')
									 .addClass('waves-effect')
									 .find('a').removeClass('disabled');

			if( this.collection.state.firstPage == this.collection.state.currentPage ){
				this.$el.find('li.arrow.prev-page, li.arrow.start-page').addClass('unavailable disabled')
														.removeClass('waves-effect')
													.find('a').addClass('disabled');
			}
			if( this.collection.state.lastPage == this.collection.state.currentPage ){
				this.$el.find('li.arrow.next-page, li.arrow.end-page').addClass('unavailable disabled')
														.removeClass('waves-effect')
												   .find('a').addClass('disabled');
			}

			return this;
		},

		/**
		* to calculate split on pagination
		*/
		calSplit: function (start) {

			var splitAt = [],
				len = this.collection.state.totalPages,
				maxLen1_2 = Math.floor(this.maxLen/2),
				startPag = 0;
				maxLen1_2End = len - maxLen1_2;

			splitAt[0] = maxLen1_2;
			startPag = this.collection.state.currentPage - maxLen1_2 > 0 ? this.collection.state.currentPage - maxLen1_2 : this.collection.state.firstPage;

			if( this.collection.state.currentPage >= maxLen1_2 ){
				splitAt[0] = this.collection.state.currentPage + 1;
			}
			splitAt[1] = maxLen1_2End;

			return {
				'startPag': startPag,
				'splitAt': splitAt
			};
		},

		/**
		* build pagination items object
		*/
		buildItems: function () {
			var items = new Array(),
				startPag = 0,
				splitAt = [0,0],
				flagHellip = true;

			confPagination = this.calSplit();
			startPag = confPagination.startPag;
			splitAt = confPagination.splitAt;

			for (var i=startPag, len=this.collection.state.lastPage; i <= len; i++) {

				if( i > splitAt[0] && i <= splitAt[1] ){

					if( flagHellip ){
						items.push({
							indx: '',
							title: '...',
							classes: 'unavailable'
						});
						flagHellip = false;
					}
					continue;
				}

				items.push({
					indx: i,
					title: this.collection.state.firstPage > 0 ? i : i+1,
					classes: this.collection.state.currentPage == i ? 'current active' : ''
				});
			}

			return items;
		},

		/**
		* re asign length for mobile resolution
		*/
		onReasignLen: function (e) {

			// if browser window is least 1024px
			if( $(window).width() <= 480 ) {
				this.maxLen = 4;
			}else if( $(window).width() <= 640 ) {
				this.maxLen = 6;
			} else {
				this.maxLen = 8;
			}

			// reload pagination
			this.render();
		},

		/**
		* event to fetch start page
		*/
		onStartPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

            var parametersDataFilter = this.filterData();

			this.collection.getFirstPage({reset:true, data: _.omit(parametersDataFilter, function(value, key, object) {
                return _.isEmpty(value);
            })});
            this.updatedState();
		},

		/**
		* event to fetch end page
		*/
		onEndPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

            var parametersDataFilter = this.filterData();

			this.collection.getLastPage({reset:true, data: _.omit(parametersDataFilter, function(value, key, object) {
                return _.isEmpty(value);
            })});
            this.updatedState();
		},

		/**
		* event to fetch the previous page
		*/
		onPrevPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

			var _this = this,
                parametersDataFilter = this.filterData();

			if(this.collection.state.currentPage > this.collection.state.firstPage){
				this.collection.getPreviousPage({reset:true, data:  _.omit(parametersDataFilter, function(value, key, object) {
                    return _.isEmpty(value);
                })});
                this.updatedState();
			}
		},

		/**
		* event to fetch the next page
		*/
		onNextPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

			var _this = this,
                parametersDataFilter = this.filterData();

			if(this.collection.state.currentPage < this.collection.state.lastPage){
				this.collection.getNextPage({reset:true, data: _.omit(parametersDataFilter, function(value, key, object) {
                    return _.isEmpty(value);
                })});
                this.updatedState();
			}
		},

		/**
		* event to fecth a page
		*/
		onGetPage: function (e) {
			e.preventDefault();
			e.stopPropagation();

			var indx = $(e.currentTarget).attr('href').replace(/^#/, ''),
                parametersDataFilter = this.filterData();

			this.collection.getPage(parseInt(indx), {reset: true, data:  _.omit(parametersDataFilter, function(value, key, object) {
                return _.isEmpty(value);
            })});
            this.updatedState();
		},

        /**
        * State change event
        */
        updatedState: function (newStates) {

            var currentPage = this.collection.state.currentPage,
                firstPage = this.collection.state.firstPage,
				params = $.param(_.extend(
				    this.parameters.queryParams,
				    currentPage > firstPage ? {page: (firstPage && currentPage) || currentPage + 1} : delete this.parameters.data.page
				));

           if (Backbone.history.fragment.split('?')[0] == "marketplace/ventas/promocion") {
                app.AppRouter.navigate(
                    params == '' ? Backbone.history.fragment.split('?')[0] : Backbone.history.fragment.split('?')[0] + '?' + 'type=owner'
                    , { replace: true }
                )
           } else {
                app.AppRouter.navigate(
                    params == '' ? Backbone.history.fragment.split('?')[0] : Backbone.history.fragment.split('?')[0] + '?' + params
                    , { replace: true }
                )
           }
        },

        /**
        * Filter data
        */
        filterData: function ( ) {
            this.dataFilter = window.Misc.formToJson( this.$formFilter );

            if( this.dataFilter !== undefined ) {
				this.parameters.dataFilter = _.extend({}, this.parameters.data, this.dataFilter);
			}else{
				this.parameters.dataFilter = this.parameters.data;
			}

            return this.parameters.dataFilter;
        }
	});

})(jQuery, this, this.document);
