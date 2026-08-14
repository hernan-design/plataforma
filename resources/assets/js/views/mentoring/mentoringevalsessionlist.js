/**
* Class MentoringEvalSessionListView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringEvalSessionListView = Backbone.View.extend({

        el: '#container-session-items-mentoring',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            /* if was passed mentoring code */
            if( !_.isUndefined(this.attributes.mentoring) && !_.isNull(this.attributes.mentoring) )
                 this.confCollection.data.codigo_mentoria = this.attributes.mentoring;

            // // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );

            this.collection.fetch( this.confCollection );
        },

        /*
        * Render View Element
        */
        render: function(){
        },

        /**
        * Render view items by model
        * @param Object mentoringItemModel Model instance
        */
        addOne: function (mentoringItemModel) {
            var view = new app.MentoringEvalSessionItemView( { model: mentoringItemModel } );
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a task of mentoring
        * @param form element
        */
        storeOne: function (form) {
            var data = window.Misc.formToJson( form );
            this.collection.create( data );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server    
        */
        responseServer: function ( collection, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        }
   });

})(jQuery, this, this.document);
