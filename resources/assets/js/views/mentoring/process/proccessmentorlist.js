/**
* Class ProccessMentorList extends of Backbone View
* @author TuProyecto || Desarrollador : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProccessMentorList = Backbone.View.extend({
        el: '#mentoring_init',
        template: _.template( ($('#mentoring-process').html() || '') ),
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
        	// _.extend( this.parameters, opts.parameters );

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

            var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

        	// Init Attributes

            // this.listenTo( this.collection, 'reset', this.onReset );
            // this.listenTo( this.collection, 'request', this.loadSpinner );
            // this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
           this.$el.html(this.template());
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

        ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();
		},

        onReset: function(collection) {
            var attributes = collection.toJSON();

            if (attributes[0].nombre_usuario) {
                this.$el.html(this.template());
            } else {
                console.log('No eres un mentor');
            }
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
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },
   });

})(jQuery, this, this.document);
