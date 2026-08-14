/**
* Class MentoringCalendar extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {
    
    app.MentoringCalendar = Backbone.View.extend({
        el: '#modal-schedule-mentoring',
        templateCalendar: _.template( ($('#calendar-mentoring-tpl').html() || '') ),
        events: {
            'change #chosen-advisers': 'onChangeAdvisers'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'scheduleMentoring', 'onEventClick');
            // Init Attributes
            this.eventMentoring = new app.EventModel();
            this.scheduleAdviser = new app.ScheduleAdviserView({
                model:this.eventMentoring
            });

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            }); 

            // Events Listener
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
            this.listenTo( this.scheduleAdviser, 'schedule', this.setScheduleAdviser );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = {};
            attributes.codigo_proyecto = this.codigo_proyecto;

           this.$el.find('#mentor-calendar-wrap').append (this.templateCalendar(attributes) );
            this.$el.foundation('reveal', 'open');

            //Initialize Reference to elements
            this.$calendarMentoring = this.$('#calendar-mentoring');
           // this.$selectAdvisers = this.$('select#chosen-advisers');

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

            var _this = this;

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            if( typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            $(document).on('opened.fndtn.reveal', this.$el, this.scheduleMentoring );

            // set calendar
            this.setCalendar();
        },

        setCalendar: function () {
            var _this = this;

            this.$calendarMentoring.fullCalendar({
                header: {
                  left: 'prevYear, prev,next, nextYear today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                lang: 'es',
                defaultDate: moment(),
                defaultView: 'month',
                selectable: false,
                editable: true,
                dragOpacity: .75,
                weekNumbers: false,
                aspectRatio: 650/300,
                eventClick: this.onEventClick
            });
        },

        /**
        *
        */
        onEventClick: function  (calEvent, jsEvent, view) {
            // console.log('click to event:', calEvent, jsEvent, view);
            var calendar = this.$calendarMentoring.fullCalendar('getCalendar'),
                attrsSchedule = {
                    title: calEvent.title,
                    start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
                    end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
                    stateEvent: _.find(calEvent.className, function (eventClasses) {
                        return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed';
                    })
                };

            if( calEvent.codigo_evento !== undefined && calEvent.className.indexOf('disabled') === -1 ){
                var type = 'encrypt';
                this.scheduleAdviser.attrsSchedule = attrsSchedule;
                this.scheduleAdviser.calEvent = calEvent;
                this.eventMentoring.resetAttrs({silent:true});
                this.eventMentoring.set('codigo_evento', calEvent.codigo_evento );
                this.eventMentoring.fetch({data: {type:type , processData: true}});
                
                this.scheduleAdviser.$el.dialog('open');
            }
        },

        /**
        * render calendar schedule mentoring
        */
        scheduleMentoring: function  () {
            // render calendar
            if( this.$calendarMentoring.data('fullCalendar') !== undefined ){
                this.$calendarMentoring.fullCalendar('render');
            }
        },

        /**
        * fetch advisers events calendar
        */
        onChangeAdvisers: function (e) {
            var _this = this,
                $elAdvisers = $(e.target),
                codigo_asesor = $elAdvisers.find('option:selected').val();

            if( this.$calendarMentoring.data('fullCalendar') !== undefined ){

                this.$calendarMentoring.fullCalendar('removeEventSource', {url:window.Misc.urlFull( Route.route('calendario.evento.index') )});
                this.$calendarMentoring.fullCalendar( 'addEventSource', {
                    url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                    type: 'GET',
                    data: {
                        'type': 'schedule',
                        'event': 'mentoring',
                        'codigo_usuario': codigo_asesor 
                    },
                    error: function (jqXHR, status, error) {
                        console.log('error::', status, error);
                    },
                    success: this.successRequesEvents,
                    editable: false
                });
            }
        },

        /**
        * response of events
        * @param Object resp
        */
        successRequetsEvents: function (resp) {
            // console.log(resp);
        },

        /**
        * listen when adviser was scheduled
        */
        setScheduleAdviser: function () {
            this.$calendarMentoring.fullCalendar('removeEvents');
            this.$calendarMentoring.fullCalendar('refetchEvents');
        }
    });

})(jQuery, this, this.document );