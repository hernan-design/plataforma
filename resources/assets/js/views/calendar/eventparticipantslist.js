/**
* Class UsersEventListView extend of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UsersEventListView = Backbone.View.extend({
        templateBtnMore: _.template( ($('#btn-view-more-tpl').html() || '') ),
        events: {
            //
        },
        parameters: {
            data: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            _.bindAll(this, 'showMore');

            // extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
                this.parameters = $.extend({},this.parameters, opts.parameters);
            }

            //Init Attributes
            this.$elmSpinner = this.$el;
            this.$modalBase = $('#modal-base-material');
            this.$wrapViewMore = $( this.templateBtnMore() );
            this.$noResults = $('#event-participants-wrap > .no-results-filter');

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'remove', this.removeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.$wrapViewMore.on( 'click', '.btn-view-more', this.showMore);
        },

        /*
        * Render View Element
        */
        render: function () {

            this.collection.getFirstPage({data: {codigo_evento: this.model.get('codigo_evento')}, reset: true});

            this.$modalBase.find('.content-modal').addClass('scroll-user-likes');

            if( typeof window.initComponent.configScrollbar == 'function' ){
                window.initComponent.configScrollbar();
            }

            // hide no results message
            if( this.collection.length ){
                this.$noResults.css('display', 'none');
            }

            return this;
        },

        /**
        * Render view theme by model
        * @param Object themeModel Model instance
        */
        addOne: function (userEventModel) {
            var view = new app.UsersEventItemView( {
                model: userEventModel,
                id: 'user-event-'+userEventModel.get('codigo_usuario_evento'),
            });
            this.$el.append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {

            this.$el.html('');
            this.collection.forEach( this.addOne, this );
        },

        // Remove element
        removeOne: function (userEventModel) {
            this.$('#user-event-'+userEventModel.get('codigo_usuario_evento')).remove();
            if(!this.collection.length) {
                if(!_.isUndefined(this.parameters.data['btnViewParts'])){
                    this.$noResults.show();
                    this.parameters.data['btnViewParts'].css('display', 'none');
                }
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {

            this.$noResults.css('display', 'none');

            if( this.collection.state.currentPage >= this.collection.state.lastPage ){
                this.$elmSpinner = this.$el;
            }else{
                this.$elmSpinner = this.$wrapViewMore;
            }

            window.Misc.setSpinner( this.$elmSpinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if(this.collection.length) {
                if(!_.isUndefined(this.parameters.data['btnViewParts'])){
                    this.$noResults.css('display', 'none');
                    this.parameters.data['btnViewParts'].css('display', 'block');
                }
            }else{
                this.$noResults.fadeIn('fast');
            }

            window.Misc.removeSpinner({
                'wrap': this.$elmSpinner,
                'direct': false
            });

            if( this.collection.state.currentPage >= this.collection.state.lastPage ){
                this.$wrapViewMore.hide();
            }else{
                this.$wrapViewMore.show();
            }
        },

        /**
        * Show more users that likesd it
        */
        showMore: function (e) {
            e.preventDefault();

            if( this.collection.hasNextPage() ){
                this.collection.getNextPage( {wait:true, data: {codigo_evento: this.model.get('codigo_evento')}} );
            }
        }
    });

})(jQuery, this, this.document);
