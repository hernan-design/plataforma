  /**
* Class MentoringSessionListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionListView = Backbone.View.extend({

        el: '#mentoring-process-main',
        template: _.template( ($('#mentoring-sessions-process-list-tpl').html() || '') ),
        events: {
            'click #button-confirm-sesion': 'onConfirmSesion',
            'click #button-cancel-sesion': 'onCancelSesion'
        },
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

            this.collection.fetch({reset:true});

        },

        /*
        * Render View Element
        */
        render: function () {
            attributes = this.collection.toJSON();
            var _this = this;

            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapperBodySesion = this.$('.body-session-content');
            this.$el.html( this.template(attributes));
           // this.$wrapperData = this.$('#browse-list-mentoring-sessions');


            return this;
        },


        /**
        * Render view article by model
        * @param Object MentoringEvaluationModel Model instance
        */
        addOne: function (mentoringModel) {
            var view = new app.MentoringSessionListItemView({
                model: mentoringModel,
                parameters: {
                    //rol: this.parameters['rol']
                }
            });
            this.$('.body-session-content').append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {
            this.$('.body-session-content').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner( this.$el );
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
