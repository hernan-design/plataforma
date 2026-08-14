/**
* Class MentoringQuestionListView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionListView = Backbone.View.extend({

        el: '#mentoring-questions',
        template: _.template( ($('#mentoring-viewquestions-tpl').html() || '') ),
        templateNotResultMentoring: _.template( ($('#not-result-mentoring-tpl').html() || '') ),
        templateNotResultSessions: _.template( ($('#not-result-sessions-tpl').html() || '') ),
        templateContenDataMentoring: '.content-data-mentoring',
        events: {
            'click .redirect___Mentoring': 'onRedirectMentoring',
			'keyup #number_document': 'onFilterActiveMentoring',
			'keyup #name_entrepreneurship': 'onFilterActiveMentoring'
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function( opts ){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');

            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend( this.parameters, opts.parameters );
            }

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Initialize
            this.mentoringSessionList = new app.MentoringSessionList();

            // Events Listener
            this.listenTo( this.collection, 'change', this.render );
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );

            this.on('getData', this.getFirstData);
            this.on('getDataSessions', this.getFirstDataSessions);
            this.on('getDataMentoringActive', this.getFirstDataMentoringActive)

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            $( window ).off("scroll");

            if(this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid'){
                $( window ).on("scroll", this.onLoadMore);
            }

            this.$count = 0;
            this.$contentFilter = '#form-filters-mentoring';

        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this,
                attributes = {};

            attributes.dataFilter = this.parameters['dataFilter'];

            this.$el.html( this.template(attributes) );
            this.$wrapActiveMentoring = this.$('#container-active-mentoring');
            this.$wrapSessionMentoring = this.$('#container-session-mentoring');
            this.$wrapMentoringPending = this.$('#container-mentoring-pending');
            this.$wrapMentoringAll = this.$('#container-mentoring-all-proccess');
            this.$wrapPaginationActive = this.$('.wrap-pagination');

            this.$wrapperData = (this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid') ?
                                this.$('#list-mentoring-questions') :
                                this.$('#mentoring-questions-data > tbody');

            /* Old pagination */

            //Init Attributes
            // this.$wrapPagination = this.$('.wrap-pagination');
            // this.$blockFilters = this.$('.block-filters-choice');


            // this.$spinnerEvents = (this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid') ?
            //                     $('<div>').attr('id','spinner-load-questions') :
            //                     this.$wrapperData;

            // if(this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'list') {
            //     // set paginations
            //     this.$wrapPagination.each(function(index, el) {

            //         var pagination = new app.Paginator({
            //             className: 'right pagination inner-title-section',
            //             collection: _this.collection,
            //             parameters: {
            //                 'nameForm': '#form-filter-questions',
            //                 data: _this.parameters.dataFilter
            //             }
            //         });

            //         $(el).html( pagination.render().el );
            //     });
            // }

            // set block filter
            //this.$blockFilters.each(function(index, el) {
            //    var blockFilter = new app.FilterData({
            //        el: el,
            //        collection: _this.collection,
            //        parameters: {
            //            'nameForm': '#form-filters-mentoring',
            //            'callBackFilter': function (newDataFilter) {
            //                app.AppRouter.navigate( Route.route('mentoria.preguntas.index', newDataFilter), {trigger: false, replace: true} );
            //                _this.trigger('getData', newDataFilter, true);
            //            },
            //            'dataFilter': _.extend({
            //            }, _this.parameters.dataFilter)
            //        }
            //    });
            //});

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            var _this = this;

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('tooltip', 'reflow');
                $(document).foundation('dropdown', 'reflow');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

        },

        /**
        * get firsts data
        * @param Object dataFilter
        */
        getFirstData: function (dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            this.parameters.dataFilter.state = window._tp.getState['pending'];
            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }
            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
            //this.parameters.fetching = 'mentoring_pending';
        },

        getFirstDataSessions: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.mentoringSessionList.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.mentoringSessionList.state.currentPage;
        },

        getFirstDataMentoringActive: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);
            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }
            this.parameters.dataFilter.state = window._tp.getState['active'];
            this.parameters.dataFilter.per_page = 20;
            this.parameters.dataFilter.page = 1; // Always start from page 1 when fetching active mentoring

            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
            this.parameters.fetching = 'mentoring_active';
        },

        /**
        * Render view theme by model
        * @param Object themeModel Model instance
        */
        addOne: function (questionModel) {

            var attributes = questionModel.toJSON();

            if (attributes.codigo_estado === window._tp.getState['pending']) {
                var view = new app.MentoringQuestionItemView({
                    model: questionModel,
                    parameters: {
                      template: 'templateMentoringPending'
                    }
                });

                this.$wrapMentoringPending.append( view.render().el );
            }

            if (attributes.codigo_estado === window._tp.getState['active']) {
                var view = new app.MentoringQuestionItemView({
                    model: questionModel,
                    parameters: {
                        template: ''
                    }
                });

                this.$wrapActiveMentoring.append( view.render().el );
            }


            // refresh plugins
            this.ready();
        },

        /**
         * Render all view theme of the collection
         */
        addAll: function () {
            this.$wrapperData.html('');
            if (this.collection.length > 0) {
                this.$wrapActiveMentoring.html('');
                this.collection.forEach( this.addOne, this );
                if (this.parameters.fetching == 'mentoring_active' && this.collection.state.lastPage > 1) {
                    this.renderPagination();
                }
            } else {
                this.$wrapActiveMentoring.html('');
                this.notResultMentoring();
            }
        },

        notResultMentoring: function() {
                if (this.parameters.fetching == "mentoring_active") {
                    this.$wrapActiveMentoring.html( this.templateNotResultMentoring() );
                } else if (this.parameters.fetching == "mentoring_pending"){
                    this.$wrapMentoringPending.html( this.templateNotResultMentoring() );
                }
        },

        addOneSession: function (mentoringModel) {

            var view = new app.MentoringItemSessionList({
                model: mentoringModel,
                parameters: {
                    //
                }
            });

            this.$wrapSessionMentoring.append( view.render().el );

            // refresh plugins
            this.ready();
        },

        /**
         * Render all view of Sessions
         */

        addAllSession: function() {

            this.$wrapperData.html('');

            if (this.mentoringSessionList.length > 0) {
                this.mentoringSessionList.forEach( this.addOneSession, this );
            } else {
                this.notResultSessions();
            }

        },

        notResultSessions: function() {
            this.$wrapSessionMentoring.html(this.templateNotResultSessions());
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            // if(this.parameters.dataFilter.v && this.parameters.dataFilter.v == 'grid'){
            //     if( target instanceof Backbone.Collection ) {
            //         this.$spinnerEvents.appendTo( this.$('.content-data-list') );
            //     }else{
            //         this.$spinnerEvents.prependTo( this.$('.content-data-list') );
            //     }
            // }

            window.Misc.setSpinner( this.templateContenDataMentoring );
        },

        /**
         * response of the server
         */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.templateContenDataMentoring,
                'direct': false
            });

            // Clear pagination when not fetching active mentoring
            if (this.parameters.fetching != 'mentoring_active') {
                this.$wrapPaginationActive.html('');
            }
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

        onRedirectMentoring: function(e) {
            e.preventDefault();

            var mentoring = $(e.currentTarget).data('mentoring');

            // Redirect to Mentoring Content
            url = Route.route('mentoria.mentores.procesos.show', { procesos: mentoring }) ;
            Backbone.history.navigate(url, { trigger:true });
        },

        onFilterActiveMentoring: function (e) {
   e.preventDefault();

            var currentTarget = e.currentTarget;
   var dataFilter = window.Misc.formToJson(this.$('#form-filters-mentoring'));
            this.$count++;

            this.countCharacters(currentTarget, dataFilter);
            if (this.standby(currentTarget.id, this.$count)) {
                if (this.onValidateDataInput(dataFilter, currentTarget.id)) {
                    dataFilter.state = window._tp.getState['active'];
                    this.getFirstDataMentoringActive(dataFilter);
                }
            }
  },

        onValidateDataInput: function (dataFilter, target) {
            if (target == 'number_document') {
                if (dataFilter.number_document.length >= 15 || dataFilter.number_document.length < 1) {
                    return false;
                }
            }
            if (target == 'name_entrepreneurship') {
                if (dataFilter.name_entrepreneurship.length >= 30 || dataFilter.name_entrepreneurship.length < 1) {
                    return false;
                }
            }

            return true;
        },

        standby: function (currentTarget, count) {
            if (count > 100) {
                $( "#"+currentTarget ).prop( "disabled", true );
                //window.Misc.setSpinner( this.$contentFilter );

                setTimeout(function() {
                //    window.Misc.removeSpinner({
                //        'wrap': this.$contentFilter,
                //        'direct': false
                //    });

                    $( "#"+currentTarget ).prop( "disabled", false );

                }, 15000);
                this.$count = 0;
            } else {
                return true;
            }
        },

        countCharacters: function (currentTarget, dataFilter) {
            //dataFilter.number_document.length

            if (currentTarget.id == 'number_document') {
                $('.count_number_document').html((currentTarget.maxLength - dataFilter.number_document.length) + ' ' + 'Caracteres');
            }
            if (currentTarget.id == 'name_entrepreneurship') {
                $('.count_name_entrepreneurship').html((currentTarget.maxLength - dataFilter.name_entrepreneurship.length ) + ' ' + 'Caracteres');
            }
        },

        renderPagination: function() {
            var _this = this;
            var pagination = new app.Paginator({
                className: 'right pagination inner-title-section',
                collection: this.collection,
                parameters: {
                    'nameForm': '#form-filters-mentoring',
                    data: _.extend({}, this.parameters.dataFilter, { state: window._tp.getState['active'] })
                }
            });

            this.$wrapPaginationActive.html( pagination.render().el );
        }
    });

})(jQuery, this, this.document);
