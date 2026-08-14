/**
* Class UserCalendarView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserCalendarView = Backbone.View.extend({

        el: '#user-calendar',
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onEventSelect', 'onEventClick');
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
            this.$calendarUser = this.$('#calendar-user');

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

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            if( typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            // set calendar
            this.setCalendar();
        },

        /**
        * set calendar for user
        */
        setCalendar: function () {
            var _this = this;

            this.$calendarUser.fullCalendar({
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
                contentHeight: 'auto',
                eventSources: [
                    {
                        url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                        type: 'GET',
                        data: {
                            'type': 'schedule',
                            'codigo_usuario': this.codigo_usuario
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

            if( this.$calendarUser.data('fullCalendar') !== undefined )
                this.$calendarUser.fullCalendar('render');
        },

        /**
        * handler zone selected on calendar
        */
        onEventSelect: function  ( start, end, jsEvent, view ) {
            var calendar = this.$calendarUser.fullCalendar('getCalendar'),
                attrsEvent = {
                    start: calendar.moment(start).format('YYYY-MM-DD HH:mm'),
                    end: calendar.moment(end).format('YYYY-MM-DD HH:mm'),
                    now: calendar.moment().format('YYYY-MM-DD HH:mm')
                };

           if( attrsEvent['now'] < attrsEvent['end'])
           {
            this.renderEventEdit(attrsEvent);
           }

        },

        /**
        * handler event click on calendar
        * @param Object calEvent
        * @param Object jsEvent
        * @param Object view
        */
        onEventClick: function  (calEvent, jsEvent, view) {
            var calendar = this.$calendarUser.fullCalendar('getCalendar'),
                attrsSchedule = {
                    start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
                    end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
                    stateEvent: _.find(calEvent.className, function (eventClasses) {
                        return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed' || eventClasses == 'unregistered';
                    })
                };

            if( calEvent.className.indexOf('available') !== -1 && calEvent.className.indexOf('disabled') === -1 && typeof(calEvent.owner) !== 'undefined' && calEvent.owner && calEvent.clase_tipo_evento == window._tp.getClassTypeEvent['user']){
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
            attrsSchedule || (attrsSchedule = {});
            calEvent || (calEvent = {});
               //console.log('attrsSchedule',attrsSchedule);
               //console.log('calEvent',calEvent);
            this.scheduleMentoring.attrsSchedule = attrsSchedule;
            this.scheduleMentoring.calEvent = calEvent;
            this.eventMentoring.resetAttrs({silent:true});
            this.eventMentoring.set('codigo_evento', calEvent.codigo_evento);
            this.eventMentoring.fetch({data: {type:this.$type , processData: true}});
            //console.log('eventMentoring',  this.eventMentoring);
            this.scheduleMentoring.$el.dialog('open');
        },

        /**
        * response of events
        * @param Object resp
        */
        successRequetsEvents: function () {
            // body...
        },

        /**
        * listen when adviser schedule was confirmed
        */
        setConfirmSchedule: function () {
            this.$calendarUser.fullCalendar('removeEvents');
            this.$calendarUser.fullCalendar('refetchEvents');
        },

        /**
        * create event on calendar
        */
        createEvent: function (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarUser.fullCalendar('renderEvent', calEvent, true);
        },

        /**
        * edit event on calendar
        */
        editEvent: function  (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarUser.fullCalendar('updateEvent', calEvent);
        },

        /**
        * remove event on calendar
        */
        removeEvent: function (idEvent) {
            this.$calendarUser.fullCalendar('removeEvents', idEvent);
        }
    });

})(jQuery, this, this.document);
