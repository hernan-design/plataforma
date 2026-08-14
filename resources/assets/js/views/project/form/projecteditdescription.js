/**
* Class ProjectEditDescription extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProjectEditDescription = Backbone.View.extend({

		tagName: 'div',
		className: 'edit-form',
		template: _.template( ($('#edit-project-description-form-tpl').html() || '') ),
		events: {
			'submit #form-edit-project-description': 'onEditForm',
			'keydown .edit-field-text': 'revertOnEscape'
			// 'blur .edit-field-text': 'onEditForm'
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			// Init Attributes

			// Events Listener
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
		},

		/*
		* Render View Element
		*/
		render: function() {
			var attributes = this.model.toJSON();

			this.$el.html( this.template(attributes) );

			// Initialize references
			this.$editFieldTxt = this.$('.edit-field-text');
			this.$formEdit = this.$('#form-edit-project-description');

			return this;
		},

		/**
		* update user fields
		*/
		onEditForm: function (e) {

			e.preventDefault();

			// if it is not editing
			if( !this.$el.parents('.editable-item').hasClass('editing') ){
				return;
			}

			var data = window.Misc.formToJson( this.$formEdit );
			// if the value was not modified
			if( window.Misc.trim(data['descripcion_entidad']) == window.Misc.trim(this.model.get('descripcion_entidad')) ){
				this.close();
				this.$editFieldTxt.blur();

				return;
			}

			this.model.save(data, {patch:true, wait:true});
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {
			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			if( resp.success !== undefined ) {
				if ( resp.success ) {
					this.close();
				}
			}
		},

		/**
		* on escape key event
		*/
		revertOnEscape: function  (e) {

			if( e.which === 27 ){
				this.close();
				this.$editFieldTxt.blur();
			}
		},

		/**
		* close field editing
		*/
		close: function () {
			this.$el.parents('.editable-item').removeClass('editing');
		}
	});

})(jQuery, this, this.document);
