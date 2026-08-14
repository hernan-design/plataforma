/**
* Class MentorEditAssistance extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MentorEditAssistance = Backbone.View.extend({

		tagName: 'div',
		className: 'edit-form',
		template: _.template( ($('#edit-mentor-assistance-form-tpl').html() || '') ),
		events: {
			'submit #form-edit-mentor-assistance': 'onEditForm',
			'keydown .edit-field-text': 'revertOnEscape',
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
			this.$formEdit = this.$('#form-edit-mentor-assistance');
			this.$wysiwygDescription = this.$('.wysiwyg-single-without-link');

			// Fire wysiwyg
			this.wysiwygTrigger();

			// reload plugins
			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();

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
			if( window.Misc.trim(data['forma_ayuda_mentoria']) == window.Misc.trim(this.model.get('forma_ayuda_mentoria')) ){
				this.close();
				this.$editFieldTxt.blur();

				return;
			}

			// this.close(); // call before, because in the server response already the element doesn't exist
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

			if( resp.success ) {
				this.close();
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
			this.$editFieldTxt.val( this.model.get('forma_ayuda_mentoria') );

			// if the edit field is wysiwyg
			if( this.$editFieldTxt.data('wysiwyg') ) {
				this.$editFieldTxt.data('wysiwyg').wysiwygeditor.setHTML( this.model.get('forma_ayuda_mentoria') );
			}
		},

		/**
		* Trigger wysiwyg
		*/
		wysiwygTrigger:  function () {

			window.wysiwygConfig.initialize('.wysiwyg-single-without-link', this.$wysiwygDescription);
		}
	});

})(jQuery, this, this.document);
