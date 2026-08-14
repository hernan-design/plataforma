/**
* Class SaleAgreementActivityView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.SaleAgreementCarView = Backbone.View.extend({

		tagName: 'tr',
		templateActivity: _.template( ($('#item-agreement-sale-activity-tpl').html() || '') ),
		templateAdviser: _.template( ($('#item-agreement-sale-adviser-tpl').html() || '') ),
		templateDeliverable: _.template( ($('#item-agreement-sale-deliverable-tpl').html() || '') ),
		templateWorkteam: _.template( ($('#item-agreement-sale-workteam-tpl').html() || '') ),
		events: {
			'click .remove-item-agreement': 'onRemove'
		},
		parameters: {
		   tab: '',
		   template: 'templateActivity',
           codigo_usuario_entidad: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			// extend parameters
			if(!_.isUndefined(opts) && _.isObject(opts.parameters))
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			// Events Listener
			this.listenTo( this.model, 'change', this.render );
		},

		// view render
		render : function () {
			var attributes = this.model.toJSON();
			attributes['tab'] = this.parameters.tab;

            if(this.parameters.codigo_usuario_entidad){
                attributes['codigo_usuario_entidad'] = this.parameters.codigo_usuario_entidad;
            }

			this.$el.html( this[this.parameters.template](attributes) );

			return this;
		},

		onRemove: function (e) {
			e.preventDefault();

			!({}).hasOwnProperty.call(this.model, 'collection') || this.model.collection.remove(this.model);

			this.$el.fadeOut('fast', function() {
			   this.remove();
			}.bind(this));
		}
	});

})(jQuery, this, this.document);
