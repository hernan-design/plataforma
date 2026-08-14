/**
* Class UserEditExperience extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditExperience = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-user-experience-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-user-experience': 'onEditForm',
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
            this.$formEdit = this.$('#form-edit-user-experience');
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
            if( window.Misc.trim(data['experiencia_usuario']) == window.Misc.trim(this.model.get('experiencia_usuario')) ){
                this.close();

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
        *
        */
        revertOnEscape: function  (e) {

            if( e.which === 27 ){
                this.close();
                this.$editFieldTxt.blur();
            }
        },

        /**
        *
        */
        close: function () {

            this.$el.parents('.editable-item').removeClass('editing');
            this.$editFieldTxt.val( this.model.get('experiencia_usuario') );
        }
    });

})(jQuery, this, this.document);
