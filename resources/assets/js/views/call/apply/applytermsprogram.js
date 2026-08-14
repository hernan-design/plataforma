/**
* Class ApplyTermsProgramView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ApplyTermsProgramView = Backbone.View.extend({
		el: '#apply-terms-program',
		template: _.template( ($('#terms-apply-program-tpl').html() || '') ),
		events: {
			'submit #form-terms-apply-program': 'onTermAgree'
		},
		parameters: {
			url_convocatoria: '',
			step: ''
		},

		/**
		* Constructor Method
		*/
		initialize: function (opts) {

			// extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            //Init Attributes

            // Events Listener
			this.listenTo( this.model, 'change', this.render );
		},

		/*
		* Render View Element
		*/
		render: function () {

			var attributes = this.model.toJSON();
			attributes['url_convocatoria'] = this.parameters.url_convocatoria;
			attributes['step'] = this.parameters.step;

			// Initialize attributes

			this.$el.html( this.template(attributes) );

			return this;
		},

		/**
		* on agree terms
        */
        onTermAgree: function (e) {
        	e.preventDefault();

        	// go to next step (basic data)
        	if( this.parameters.applyProgramView instanceof Backbone.View ) {
        		this.parameters.applyProgramView.getEntity(false);
        	}
        }
	});

})(jQuery, this, this.document);
