/**
* Class UserEditEducation extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditEducation = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-user-education-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-user-education': 'onEditForm'
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Init Attributes
            this.$fieldEditing = this.$('.field-editing');
            this.$wrapperData = this.$('.list-education-profile');

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
            this.$formEdit = this.$('#form-edit-user-education');

            return this;
        },

        /**
        * update user fields
        */
        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( this.$formEdit );
        
            this.collection.create(data, {patch:true, wait:true});
            this.$formEdit.find(':submit').addClass('disabled');

            return;
        },

        /**
        * Render view theme by model
        * @param Object themeModel Model instance
        */
        addOne: function (reasonModel) {
            var view = new app.UserEducationItemView({
                    model: reasonModel
                });
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
