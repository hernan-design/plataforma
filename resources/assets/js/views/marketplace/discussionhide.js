/**
* Class DiscussionHideView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DiscussionHideView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#discussion-confirm-hide-tpl').html() || '') ),
        parameters: {
            'titleConfirm': 'Eliminar Entrada'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {   
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
            this.model.destroy({
                processData: true,
                wait: true,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content') 
                }
            });
        }
   });

})(jQuery, this, this.document);