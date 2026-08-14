/**
* Class MentoringTaskConfirmRemoveView extends of Backbone View
* @author TuProyecto || Desarrolladora : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringTaskConfirmRemoveView = Backbone.View.extend({

        el: '#modal-base-confirm-tp',
        template: _.template( ($('#task-mentoring-confirm-remove-tpl').html() || '') ),
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
        * Event Close Confirm
        */
        onConfirm: function (e) {
            e.preventDefault();
            this.$el.foundation('reveal', 'close');
            this.model.destroy({
            	processData: true,
            	wait: true,
            	data: { 
            		'codigo_tarea_mentoria': this.model.get('codigo_tarea_mentoria'), 
            		'_token': $('meta[name="csrf-token"]').attr('content') 
            	}
           	});
        }
   });

})(jQuery, this, this.document);
