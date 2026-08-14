/**
* Class ConfirmRemoveMentoringView extends of Backbone View
* @author TuProyecto || Desarrolladora : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ConfirmRemoveMentoringView = Backbone.View.extend({

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
        * Mentoring Cancel Confirm
        */
        onConfirm: function (e) {
            console.log('onConfirmDelete', this.model.toJSON());
            attributes = this.model.toJSON();
            attributes.action = 'remove';
            e.preventDefault();
            this.$el.foundation('reveal', 'close');

            //var item = new app.MentoringSessionModel();
            //item.idAtrribute = 'codigo_mentoria';
            //item.set({'codigo_mentoria': attributes['codigo_mentoria'] }, {'silent':true});

            this.model.save(attributes, { wait: true, success: function(model, resp) {
               console.log('Refuse success');
            } });

            // item.destroy({
            // 	processData: true,
            // 	wait: true,
            //     data: { '_token': $('meta[name="csrf-token"]').attr('content')}
           	// });
        }
   });

})(jQuery, this, this.document);
