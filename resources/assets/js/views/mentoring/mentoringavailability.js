/**
* Class MentoringAvailabilityView extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringAvailabilityView = Backbone.View.extend({

        el: '#mentoring-availability',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onEventClick', 'onEventSelect');
            //Init Attributes
            this.eventMentoring = new app.EventModel();
            this.scheduleMentoring = new app.ConfirmScheduleMentoringView({ model:this.eventMentoring });
            this.eventCalendarModel = new app.EventModel();
            this.createEventView = new app.UserCreateEventView({ model:this.eventCalendarModel });

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            this.$type = 'encrypt';

            // Events Listener
            this.listenTo( this.scheduleMentoring, 'schedule', this.setConfirmSchedule );
            this.listenTo( this.createEventView, 'addevent', this.createEvent );
            this.listenTo( this.createEventView, 'editevent', this.editEvent );
            this.listenTo( this.createEventView, 'removeevent', this.removeEvent );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this;

            //Initialize Reference to elements
            this.$calendarAvailability = this.$('#calendar-availability');

            return this;
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
            // set calendar
            this.setCalendar();
        },

        /**
        * set calendar for user
        */
        setCalendar: function () {
            var _this = this;

            this.$calendarAvailability.fullCalendar({
                header: {
                  left: 'prevYear, prev,next, nextYear today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                lang: 'es',
                defaultDate: moment(),
                defaultView: 'month',
                selectable: true,
                editable: true,
                dragOpacity: .75,
                weekNumbers: false,
                aspectRatio: 650/300,
                eventSources: [
                    {
                        url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                        type: 'GET',
                        data: {
                            'type': 'schedule'
                        },
                        error: function (jqXHR, status, error) {
                            console.log('error::', status, error);
                        },
                        success: this.successRequetsEvents,
                        editable: false
                    }
                ],
                select: this.onEventSelect,
                eventClick: this.onEventClick
            });

            if( this.$calendarAvailability.data('fullCalendar') !== undefined )
                this.$calendarAvailability.fullCalendar('render');
        },

        /**
        * response of events
        * @param Object resp
        */
        successRequetsEvents: function () {
            // body...
        },

        /**
        * handler zone selected on calendar
        */
        onEventSelect: function  ( start, end, jsEvent, view ) {
            // console.log( 'event select:', start, end, jsEvent, view );
            var calendar = this.$calendarAvailability.fullCalendar('getCalendar'),
                attrsEvent = {
                    start: calendar.moment(start).format('YYYY-MM-DD HH:mm'),
                    end: calendar.moment(end).format('YYYY-MM-DD HH:mm')
                };

            this.renderEventEdit(attrsEvent);
        },

        /**
        * handler event click on calendar
        * @param Object calEvent
        * @param Object jsEvent
        * @param Object view
        */
        onEventClick: function  (calEvent, jsEvent, view) {
            var calendar = this.$calendarAvailability.fullCalendar('getCalendar'),
                attrsSchedule = {
                    start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
                    end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
                    stateEvent: _.find(calEvent.className, function (eventClasses) {
                        return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed';
                    })
                };

            if( calEvent.className.indexOf('available') !== -1 && calEvent.className.indexOf('disabled') === -1 ){
                _.extend(attrsSchedule, {
                    start: calendar.moment( calEvent.start ).format('YYYY-MM-DD HH:mm'),
                    end: calendar.moment( calEvent.end ).format('YYYY-MM-DD HH:mm')
                });
                this.renderEventEdit(attrsSchedule, calEvent);
                
            }else if( calEvent.className.indexOf('disabled') === -1 ){
                this.renderEventShedule(attrsSchedule, calEvent);
            }
        },

        renderEventEdit: function (attrsEvent, calEvent) {

            attrsEvent || (attrsEvent = {});
            calEvent || (calEvent = {});

            this.createEventView.attrsEvent = attrsEvent;
            this.createEventView.calEvent = calEvent;
            this.eventCalendarModel.resetAttrs({silent:true});

            if( !_.isEmpty(calEvent) && calEvent.codigo_evento ){
                this.eventCalendarModel.set('codigo_evento', calEvent.codigo_evento);
                this.eventCalendarModel.fetch({data: {type:this.$type , processData: true}});
            }else{
                this.createEventView.render();
            }

            this.createEventView.$el.dialog('open');
        },

        renderEventShedule: function (attrsSchedule, calEvent) {

            this.scheduleMentoring.attrsSchedule = attrsSchedule;
            this.scheduleMentoring.calEvent = calEvent;
            this.eventMentoring.resetAttrs({silent:true});
            this.eventMentoring.set('codigo_evento', calEvent.codigo_evento);
            this.eventMentoring.fetch({data: {type:this.$type , processData: true}});

            this.scheduleMentoring.$el.dialog('open');
        },

        /**
        * listen when adviser schedule was confirmed
        */
        setConfirmSchedule: function () {
            this.$calendarAvailability.fullCalendar('removeEvents');
            this.$calendarAvailability.fullCalendar('refetchEvents');
        },

        /**
        * create event on calendar
        */
        createEvent: function (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarAvailability.fullCalendar('renderEvent', calEvent, true);
        },

        /**
        * edit event on calendar
        */
        editEvent: function  (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarAvailability.fullCalendar('updateEvent', calEvent);
        },

        /**
        * remove event on calendar
        */
        removeEvent: function (idEvent) {
            this.$calendarAvailability.fullCalendar('removeEvents', idEvent);
        }
    });

})(jQuery, this, this.document);
