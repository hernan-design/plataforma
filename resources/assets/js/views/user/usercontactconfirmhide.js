/**
* Class UserContactConfirmHideView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserContactConfirmHideView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#user-confirm-contact-tpl').html() || '') ),
        parameters: {
            'titleConfirm': 'Eliminar Contacto',
            'srcparams-user': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) { 

        if ( opts !== undefined && _.isObject(opts.parameters) ) {
            _.extend(this.parameters, opts.parameters);
        };
            // Init Attributes
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = {};
            this.$el.find('.content-modal').html( this.template(attributes) );
            // Change modal title
            this.$el.find('.inner-title-modal').html( this.parameters['titleConfirm'] );
            this.$el.foundation('reveal', 'open');

            // delegate events
            $(this.el).off();
            this.delegateEvents({
                'click .confirm-action': 'onConfirm'
            });

            return this;
        },

        /**
        * Discussion confirm hide
        */
        onConfirm: function (e) {
            
            e.preventDefault();
            this.$el.foundation('reveal', 'close');
            var data = { 
                'srcparams-user': this.parameters['srcparams-user'],
                'state_friendship': this.model.get('state_friendship'), 
                'cancel_friendship': true, 
                '_token': $('meta[name="csrf-token"]').attr('content') 
            };

            this.model.save( data, {patch: true, wait:true} );
        }
   });

})(jQuery, this, this.document);