/**
* Class ProjectEditInterests extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectEditInterests = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-project-interests-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-project-interests': 'onEditForm'
        },
        parameters: {
            codigo_usuario: '',
			creator: false
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
            this.$noResults = this.$('.no-results-filter');
            this.$fieldEditing = this.$('.field-editing');
            this.$wrapperData = this.$('.list-interests-project');

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

            if( this.collection.length )
                this.$noResults.css('display', 'none');

            var attributes = this.model.toJSON();
            this.$fieldEditing.html( this.template(attributes) );

            // Initialize references
            this.$formEdit = this.$('#form-edit-project-interests');

            // if the collection is empty initially
            if( !this.collection.length && !this.parameters.creator ) {
				this.$el.css('display', 'none');
			}

			// show message no result if the collection is empty
			if( !this.collection.length && this.parameters.creator ) {
				this.$noResults.fadeIn('fast');
			}

            return this;
        },

        /**
        * update project fields
        */
        onEditForm: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( this.$formEdit );
            data.codigo_usuario = this.parameters['codigo_usuario'];

            if( _.isUndefined(this.collection.findWhere( {'codigo_sector_interes': parseInt(data['codigo_sector_interes']) } )) ){

                this.collection.create(data, {patch:true, wait:true});
                this.$formEdit.find(':submit').addClass('disabled');

                return;
            }

            this.clearForm( this.$formEdit );
        },

        /**
        * Render view theme by model
        * @param Object themeModel Model instance
        */
        addOne: function (interestModel) {

            var view = new app.ProjectInterestItemView( {
                model: interestModel,
                parameters: { codigo_usuario: this.parameters['codigo_usuario'] }
            } );
            this.$wrapperData.append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {

			if( !this.collection.length && !this.parameters.creator ) {
				this.$el.remove();
				return;
			}else {
                this.$el.css('display', 'block');
            }

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

            if( !this.collection.length && this.parameters.creator ) {
				this.$noResults.fadeIn('fast');
			}else {
				this.$noResults.css('display', 'none');
			}

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
