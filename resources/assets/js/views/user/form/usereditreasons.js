/**
* Class UserEditReasons extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditReasons = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-user-reasons-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-user-reasons': 'onEditForm'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // Init Attributes
            this.$fieldEditing = this.$('.field-editing');
            this.$wrapperData = this.$('.list-reasons-profile');

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
            this.$formEdit = this.$('#form-edit-user-reasons');

            return this;
        },

        /**
        * update user fields
        */
        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( this.$formEdit );

            if( _.isUndefined(this.collection.findWhere( {'codigo_razon_registro': parseInt(data['codigo_razon_registro']) } )) ){

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
        addOne: function (reasonModel) {
            var view = new app.UserReasonItemView( {model: reasonModel} );
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
