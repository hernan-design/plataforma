/**
* Class ConfirmRemoveProcessMentoringView extends of Backbone View
* @author TuProyecto || Desarrollador : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ConfirmRemoveProcessMentoringView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#mentoring-confirm-remove-tpl').html() || '') ),
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
        	_.extend( this.parameters, opts.parameters );
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
        * Mentoring Close Confirm
        */
        onConfirm: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            this.$el.foundation('reveal', 'close');
            this.model.destroy({
            	processData: true,
            	wait: true,
            	data: {
            		'_token':$('meta[name="csrf-token"]').attr('content')
            	}
           	});
               //ocultando sesion cancelada manualmente
               var idn = this.model.toJSON()
               var idn = "#" + idn.id_mentoria
               $( idn ).parent().hide( "slow" );
               //
        }
   });

})(jQuery, this, this.document);
