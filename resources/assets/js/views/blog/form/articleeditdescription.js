/**
* Class ArticleEditDescription extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ArticleEditDescription = Backbone.View.extend({
        tagName: 'div',
        id: 'container-form-infobasic',
        className: 'edit-form',
        template: _.template( ($('#edit-article-description-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-description-article': 'onEditForm',
            'keydown .edit-field-text': 'revertOnEscape'
        },
        parameters: {
        	'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

        	if( opts !== undefined && _.isObject(opts.parameters) )
        		this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Init Attributes
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner);
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
			this.$formEdit = this.$('#form-edit-description-article');
			this.$wysiwygDescription = this.$('.wysiwyg-single');

            this.wysiwygTrigger();

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();

            // if it is not editing
			if( !this.$el.parents('.editable-item').hasClass('editing') ){
				return;
			}

            var data = window.Misc.formToJson( e.target );

            // if the value was not modified
			if( window.Misc.trim(data['texto_contenido']) == window.Misc.trim(this.model.get('texto_contenido')) ){
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
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function ($elSpinner, res, _this) {
                    return function () {
                        $( '#form-edit-description-article [name="texto_contenido"]' ).val('')
                            .end().find( '.wysiwyg-editor' ).html('');
                        $elSpinner.remove();

                        if( res.success !== undefined ) {
							if ( res.success ) {
								_this.close();
							}
						}
                    };
                })(this.$spinnerPosts, resp, this)
            });
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

			this.$editFieldTxt.val( this.model.get('texto_contenido') );

			// if the edit field is wysiwyg
			if( this.$editFieldTxt.data('wysiwyg') ) {
				this.$editFieldTxt.data('wysiwyg').wysiwygeditor.setHTML( this.model.get('texto_contenido') );
			}
		},

        /**
        * Trigger wysiwyg
        */
        wysiwygTrigger:  function () {
        	window.wysiwygConfig.initialize('.wysiwyg-single', this.$wysiwygDescription);
        }
    });

})(jQuery, this, this.document);
