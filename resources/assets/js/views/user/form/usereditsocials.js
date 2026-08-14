/**
* Class UserEditSocials extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditSocials = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        id: 'container-form-socials',
        template: _.template( ($('#edit-user-socials-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-user-socials': 'onEditForm'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            var _this = this;
            // Init Attributes

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        }
    });

})(jQuery, this, this.document);