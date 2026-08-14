/**
* Class MentoringSessionPageListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionPageListView = Backbone.View.extend({

        el: '#mentoring-process-main',
        template: _.template( ($('#mentoring-sessions-list-tpl').html() || '') ),
        parameters: {
            rol: '',
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            // Initialize attributes

            // Events Listener
            // this.listenTo( this.collection, 'change', this.render );
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.listenTo( this.collection, 'remove', this.responseItemDelete );
            this.on('getData', this.getFirstData);
        },

        /*
        * Render View Element
        */
        render: function () {
          
            var _this = this,
                attributes = {};

            attributes.rol = this.parameters['rol'];
            attributes.dataFilter = this.parameters['dataFilter'] || null;
            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapPagination = this.$('.wrap-pagination');
            this.$wrapperData = this.$('#browse-list-mentoring-sessions');
            this.$blockFilters = this.$('.block-filters-choice');

            this.$wrapPagination.each(function(index, el) {

                var pagination = new app.Paginator({
                    className: 'right pagination inner-title-section',
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-filter-questions',
                        'data':  attributes.dataFilter
                    }
                });

                $(el).html( pagination.render().el );
            });

            // set block filter
            this.$blockFilters.each(function(index, el) {

                var blockFilter = new app.FilterData({
                    el: el,
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-filter-questions',
                        'dataFilter': _.extend({
                            'rol':_this.parameters.rol
                        }, _this.parameters.dataFilter)
                    }
                });
            });

            // trigger functions
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            return this;
        },

        getFirstData: function (dataFilter) {
            dataFilter || (dataFilter = {});

            _.extend( this.parameters.dataFilter, dataFilter );

            //Fetch data
            this.collection.getFirstPage( {reset:true, data: this.parameters.dataFilter} );
        },

        /**
        * Render view article by model
        * @param Object MentoringEvaluationModel Model instance
        */
        addOne: function (mentoringModel) {

            var view = new app.MentoringSessionItemView({
                model: mentoringModel,
                parameters: {
                    rol: this.parameters['rol']
                }
            });
            this.$wrapperData.find('tbody').append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {
            this.$wrapperData.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner( this.$wrapperData );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length && target instanceof Backbone.Collection )
                this.$noResults.fadeIn('fast');

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        },

        /**
        * response of the server item delete
        */
        responseItemDelete: function (model, resp, opts) {
            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);
