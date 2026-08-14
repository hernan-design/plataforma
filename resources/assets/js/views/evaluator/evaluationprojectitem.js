/**
* Class EvaluationProjectItemView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.EvaluationProjectItemView = Backbone.View.extend({

		tagName: 'li',
		template: _.template( ($('#evaluation-item-project-tpl').html() || '') ),
		events: {

		},
		parameters: {
			//
		},

		/**
		* Constructor Method
		*/
		initialize: function(opts){

			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			//Init Attributes

			// Events Listener
			this.listenTo( this.model, "change", this.render );
		},

		/*
		* Render View Element
		*/
		render: function(){

			var attributes = this.model.toJSON();

			this.$el.html( this.template(attributes) );

			return this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
			    this.$el.foundation('abide');
			}

			// reload plugins
            if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'spinner') )
                window.initComponent.spinnerTrigger();

            // reload plugins
            if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm(); 

		}

	});

})(jQuery, this, this.document);
