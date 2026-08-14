/**
* Class ScheduleAdviserView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ScheduleAdviserView = Backbone.View.extend({
        el: '#modal-schedule-adviser',
        template: _.template( ($('#schedule-adviser-tpl').html() || '') ),
        templateItemTarget: _.template( '<li><span><%- target_mentoring %></span><a href="#" class="remove-target right">&times;</a><input type="hidden" name="objetivos_mentoria" value="<%- target_mentoring %>"></li>' ),
        events: {
            'click .add-target-schedule': 'onAddTarget',
            'keypress #target_mentoring': 'onAddTarget',
            'click .remove-target': 'onRemoveTarget',
            'submit #form-schedule-adviser': 'onRequestSchedule'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Init Attributes

            _.bindAll(this, 'render', 'setRequest', 'onAddTarget', 'onRemoveTarget',
            'onRequestSchedule','responseServer');

            this.configAlert = {
                'wrapper': $('#modal-schedule-adviser'),
                'closeTime': 10000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.setRequest );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            _.extend( attributes, this.attrsSchedule );
            //console.log("ScheduleAdviserModel", attributes );
            this.$el.find('.content-modal').html( this.template(attributes) );

            //Initialize Reference to elements
            this.$formSchedule = this.$('#form-schedule-adviser');
            this.$targetsWrapper = this.$('.targets-schedule-mentoring');
            this.$fieldTargetMentoring = this.$('#target_mentoring');

            //initialize form settings for schedule advisor
            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }
        },

        /**
        * add a new target to the adviser schedule
        */
        onAddTarget: function (e) {
            var codeKey = e.keyCode || e.which;

            if( e.type == 'keypress' ){
                if( codeKey !== 13 )
                    return;
            }else{
                e.preventDefault();
                e.stopImmediatePropagation();
            }

            var targetMentoring = ''

            if(typeof this.$fieldTargetMentoring != 'undefined')
                targetMentoring = this.$fieldTargetMentoring.val().trim();

            if( targetMentoring.length ){
                this.$targetsWrapper.append( this.templateItemTarget({'target_mentoring': targetMentoring}) );

                this.$fieldTargetMentoring.val('');
            }

            if( codeKey === 13 ) return false;
        },

        /**
        * add a new target to the adviser schedule
        */
        onRemoveTarget: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $(e.target).parents('li').remove();
        },

        /**
        *
        */
        onRequestSchedule: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var owner =  this.model.get('owner');

            var data = window.Misc.formToJson( e.target );
            if(typeof data.objetivos_mentoria === 'string'){
                data.objetivos_mentoria = [ data.objetivos_mentoria ];
            }
            data.action = owner ? 'confirm-mentoring' : 'schedule-mentoring';

            if(owner || (typeof data.objetivos_mentoria !== 'undefined' && data.objetivos_mentoria.length && data.codigo_asesoria !== "0") ){
                this.model.save(data, {patch:true});
            } else if (data.codigo_asesoria === "0") {
                var config = {
                    'text': 'Debes seleccionar el Emprendimiento',
                    'type': 'alert'
                };

                _.extend( this.configAlert, config );

                window.Misc.showAlertBox( this.configAlert );

                this.render();
            } else {
                var config = {
                'text': 'Debe agregar al menos un objetivo',
                'type': 'alert'
                };

                _.extend( this.configAlert, config );

                window.Misc.showAlertBox( this.configAlert );

                this.render();
            }
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
            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            if( resp.success !== undefined ){
                if( resp.success ){
                    window.Misc.showAlertBox( this.configAlert );
                    this.$el.dialog('close');
                    this.trigger('schedule');
                }else{
                    window.Misc.showAlertBox( this.configAlert );
                }
            }
        }
    });

})(jQuery, this, this.document);
