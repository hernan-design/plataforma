/**
* Class ProjectEditSponsors extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProjectEditSponsors = Backbone.View.extend({

		tagName: 'div',
		className: 'edit-form',
		template: _.template( ($('#edit-project-sponsor-form-tpl').html() || '') ),
		events: {
			'submit #form-edit-project-sponsors': 'onEditForm'
		},
		parameters: {
			codigo_entidad: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

			// Init Attributes
			this.$fieldEditing = this.$('.field-editing');
			this.$wrapperData = this.$('.list-sponsor-project');

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );

		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();

			this.$fieldEditing.html( this.template(attributes) );

			// Initialize references
			this.$formEdit = this.$('#form-edit-project-sponsors');

			return this;
		},

		/**
		* update project fields
		*/
		onEditForm: function (e) {
			e.preventDefault();
			var data = window.Misc.formToJson( this.$formEdit );
			data.codigo_entidad = this.parameters['codigo_entidad'];

			if( _.isUndefined(this.collection.findWhere( {'codigo_patrocinador': parseInt(data['codigo_patrocinador']) } )) ){

				this.collection.create(data, {patch:true, wait:true});
				this.$formEdit.find(':submit').addClass('disabled');

				return;
			}

			this.clearForm( this.$formEdit );
		},

		/**
		* Render view theme by model
		* @param Object sponsor Model instance
		*/
		addOne: function (sponsorModel) {

			var view = new app.ProjectSponsorItemView( {
				model: sponsorModel,
				parameters: { codigo_entidad: this.parameters['codigo_entidad'] }
			} );
			this.$wrapperData.append( view.render().el );
		},

		/**
		* Render all view theme of the collection
		*/
		addAll: function () {

			this.$wrapperData.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {

			if( target instanceof Backbone.Collection )
				window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});

			if( this.$formEdit ){
				this.$formEdit.find(':submit').removeClass('disabled');

				this.clearForm( this.$formEdit );
			}
		},

		/**
		* clean form
		* @param Object | jQuery $formReset
		*/
		clearForm: function ($formReset) {

			$formReset[0].reset();
			$formReset.find('[class*=chosen-select]')
					  .trigger("chosen:updated");
		}
	});

})(jQuery, this, this.document);
