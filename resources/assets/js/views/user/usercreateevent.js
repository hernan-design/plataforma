/**
* Class UserCreateEventView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserCreateEventView = Backbone.View.extend({
        el: '#modal-create-calendar-event',
        template: _.template( ($('#create-calendar-event-tpl').html() || '') ),
        templateTitleDescription: _.template( ($('#title-description-event-tpl').html() || '') ),
        events: {
            'submit #form-create-calendar-event': 'onCreate',
            'click .on-remove-event': 'onRemove',
            'change #start-event': 'onDate'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'setRequest');

            //Init Attributes
            this.$modalConfirm = $('#modal-base-confirm-tp');

            // Init Attributes
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 10000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.setRequest );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'destroy', this.removeEvent );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            _.extend( attributes, this.attrsEvent );
                
            this.$el.find('.content-modal').html( this.template(attributes) );

            //Initialize Reference to elements
            this.$formSchedule = this.$('#form-create-calendar-event');

            //initialize form settings for schedule advisor
            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( typeof window.initComponent.datepickerTrigger == 'function' )
                window.initComponent.datepickerTrigger();

            if( typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /**
        * send new event
        */
        onCreate: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            // data.codigo_calendario = 3;

            this.model.save(data);
        },

        /**
        * listens when it send request to the server
        */
        setRequest: function (target, xhr, opts) {

            this.$formSchedule.find(':submit').addClass('disabled');
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {

            this.$formSchedule.find(':submit').removeClass('disabled');
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ?
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
            var confAlert = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, confAlert );

            if( resp.success !== undefined ){
                if( resp.success ){
                    // window.Misc.showAlertBox( this.configAlert );
                    this.$el.dialog('close');

                    // new event or update event
                    if( _.isEmpty(this.calEvent) ){
                        this.trigger('addevent', this.buildEvent());
                    }else{
                        this.trigger('editevent', this.buildEvent());
                    }

                }else {
                    window.Misc.showAlertBox( this.configAlert );
                }
            }
        },

        /**
        * build calendar event
        */
        buildEvent: function () {

            var newEvent = {
                'id': this.model.get('id'),
                'codigo_evento': this.model.get('codigo_evento'),
                'title': this.model.get('nombre_evento'),
                'start': this.model.get('start'),
                'end': this.model.get('end'),
                'className': this.model.get('className'),//'available'
                'editable': false
            };
            _.extend(this.calEvent, newEvent);

            return this.calEvent;
        },

        /**
        * destroy event
        */
        onRemove: function (e) {
            e.preventDefault();

            var confirmRemove = new app.ConfirmWindow({
                model: this.model,
                parameters: {
                    template: _.template( ($('#event-confirm-remove-tpl').html() || '') ),
                    titleConfirm: '¿Estás seguro que quieres eliminar este evento?'
                }
            });
            confirmRemove.render();
        },

        removeEvent: function (model, opts) {

            this.trigger('removeevent', this.calEvent.id );
            this.$('.on-remove-event').removeClass('disabled');
        },

        onDate: function (e) {
            e.preventDefault();

            var initDate = $(e.target).val();

            $('#end-event').datetimepicker({
                startDate: initDate,
                minDate: initDate,
                singleDatePicker: true
            });
        }
    });

})(jQuery, this, this.document);
