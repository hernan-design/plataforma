/**
* Class ProjectEditNumeroWhatsapp extends of Backbone View
* @author TuProyecto || Desarrollador : @ayrielnoriega
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectEditNumeroWhatsapp = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-project-numerowhatsapp-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-project-numerowhatsapp': 'onEditForm',
            'blur .edit-field-text': 'onEditForm',
            'keydown .edit-field-text': 'revertOnEscape'
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
            this.$formEdit = this.$('#form-edit-project-numerowhatsapp');

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
            if( window.Misc.trim(data['numero_whatsapp']) == window.Misc.trim(this.model.get('numero_whatsapp')) ){
                this.close();
                this.$editFieldTxt.blur();

                return;
            }

            if (this.validateNumeroWhatsapp(data)) {
                if (data.numero_whatsapp == '') {
                    data.numero_whatsapp = null;
                }
                this.model.save(data, {patch:true, wait:true});
                $( "#errorNumWS" ).css( "display", "none" );
            } else {
                $( "#errorNumWS" ).css( "display", "block" );

            }
        },

        /**
         * valida url ingresada
         */
         validateNumeroWhatsapp: function (data) {
            if (data.numero_whatsapp != "") {
                if (data.numero_whatsapp.toString().length == 10 && !isNaN(data.numero_whatsapp)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
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
            this.$editFieldTxt.val( this.model.get('numero_whatsapp') );
            this.$editFieldTxt.trigger('autoresize');
        }
    });

})(jQuery, this, this.document);
