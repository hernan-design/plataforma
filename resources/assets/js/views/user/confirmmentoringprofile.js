/**
* Class ConfirmMentoringProfileView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ConfirmMentoringProfileView = Backbone.View.extend({
        el: '#modal-confirm-schedule',
        template: _.template( ($('#confirm-mentoring-profile-tpl').html() || '') ),
        events: {
            'submit #form-confirm-mentoring': 'onConfirmSchedule',
            'click #cancel-mentoring': 'onRemove'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Init Attributes
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 10000,
                'speedOpen': 500,
                'speedClose': 500
            };

            this.mentoringModel = new app.MentoringModel();

            this.$modalConfirm = $('#modal-base-confirm-tp');

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.setRequest );
            // this.listenTo( this.model, 'sync', this.responseServer );

            this.listenTo( this.mentoringModel, 'change', this.render );
            this.listenTo( this.mentoringModel, 'request', this.setRequest );
            this.listenTo( this.mentoringModel, 'sync', this.responseServer );
            this.listenTo( this.mentoringModel, 'destroy', this.removeMentoring );

        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            _.extend( attributes, this.attrsSchedule );
            this.confirmRemove = new app.ConfirmRemoveMentoringView({
                model:this.mentoringModel,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres cancelar esta mentoría?'
                }
            });

            this.mentoringModel.set('url_mentoria', this.model.get('url_mentoria'), {silent:true});
        
            this.$el.find('.content-modal').html( this.template(attributes) );

            //Initialize Reference to elements
            this.$formSchedule = this.$('#form-confirm-mentoring');

            //initialize form settings for schedule advisor
            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }
        },

        /**
        *
        */
        onConfirmSchedule: function (e) {

            e.preventDefault();
            console.log("onConfirmSchedule");

            var attributes = this.model.toJSON();

            var data = {'url_mentoria' : attributes.url_mentoria, '_token': $('meta[name="csrf-token"]').attr('content')};
            data.action = 'confirm-mentoring';

            this.mentoringModel.save(data, {patch:true});
        },

        /**
        * destroy Mentoring
        */
        onRemove: function (e) {
            e.preventDefault();
            this.confirmRemove.render();
        },

        removeMentoring: function (model, opts) {

            this.trigger('schedule');
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

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });

            if( resp.success !== undefined ){
                if( resp.success ){
                    window.Misc.showAlertBox( this.configAlert );
                    this.$el.dialog('close');
                    this.trigger('schedule');
                }else {
                    window.Misc.showAlertBox( this.configAlert );
                }
            }
         }
    });

})(jQuery, this, this.document);