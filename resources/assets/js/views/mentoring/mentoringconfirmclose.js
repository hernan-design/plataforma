/**
* Class MentoringConfirmCloseView extend of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringConfirmCloseView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#mentoring-confirm-close-tpl').html() || '') ),
        events: {
            'click .confirm-action': 'onConfirm'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // 
        },

        /*
        * Render View Element
        */
        render: function() {
        	var attributes = {};
            this.$el.find('.content-modal').html( this.template(attributes) );

            return this;
        },


        /**
        * Event Close Confirm
        */
        onConfirm: function (e) {
            e.preventDefault();

            this.$el.foundation('reveal', 'close');
            this.model.closeMentoring();
        }
   });

})(jQuery, this, this.document);
