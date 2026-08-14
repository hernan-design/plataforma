/**
* Class EventModal extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventModalView = Backbone.View.extend({

        className: 'reveal-modal-main xtiny clearfix',
        attributes: {
            'data-reveal': ''
            // 'data-openauto': ''
        },
        template: _.template( ($('#event-modal-tpl').html() || '') ),
        events: {
            // 'click .open-event-info': 'onOpenEvent'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            //Initialize Attributes
            _.bindAll(this, 'onOpenEvent');

            //Events Listener
            // this.listenTo( this.model, 'change:codigo_evento', this.render );
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            $(document).on('click', '.open-event-info', this.onOpenEvent);
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON(),
                _this = this;
            this.$el.html( this.template(attributes) );

            return this;
        },

        /**
        * show modal
        */
        showModal: function () {
            this.$el.foundation('reveal','open');
        },

        /**
        * Event fecth modal data event
        */
        onOpenEvent: function (e) {

            var type = 'encrypt';
            e.preventDefault();
            e.stopPropagation();

            this.$el.foundation('reveal','close');
            var indEvent = $(e.target).data('event');

            if( indEvent !== undefined && indEvent !== '' ) {
                this.model.set({codigo_evento: indEvent}, {silent: true});
                this.showModal();
                this.model.fetch({data: {type:type , processData: true}});
            }
        }
    });
})(jQuery, this, this.document);
