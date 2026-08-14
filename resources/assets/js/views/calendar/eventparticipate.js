/**
* Class UserEventView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEventView = Backbone.View.extend({

        template: _.template( ($('#participate-event-tpl').html() || '') ),
        templateRemove: _.template( ($('#registered-event-tpl').html() || '') ),
        events: {
            'click #button-participate-event': 'onRegisterToEvent',
            'click #button-stop-participating-event': 'onStopParticipatingToEvent'
        },
        parameters: {
            data: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts) {

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Init attributes
            this.$wrapEventUserList = this.$('#event-participants-list');

            // Events Listener
            this.listenTo( this.model, 'change:register', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();

            if(this.parameters.data['view']){
                if(attributes.register){
                    this.$el.html( this.templateRemove() );
                }else {
                    this.$el.html( this.template() );
                }
            }

            return this;
        },

        // Resiter to event
        onRegisterToEvent: function (e) {
            e.preventDefault();

            var _this = this,
                data = {
                    codigo_evento: this.parameters.data['codigo_evento']
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#modal-participate-event-tpl").html() || ""),
                    titleConfirm: "¡Confirma tu interés en el evento!",
                    onConfirm: function () {

                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {

                                /*Valida (resp.check) que cumpla con los criterios enviados desde el controlador UsuarioEventoController
                                en el método participateEvent*/

                                if (resp.check) {

                                    // Response recibe success o error.
                                    var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                    if( _.isObject(resp.errors) ){

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
                                    _.extend( _this.configAlert, config );

                                    if( resp.success ){
                                        window.Misc.showAlertBox( _this.configAlert );
                                        _this.$el.html( _this.templateRemove() );
                                        _this.onInstanceViewParticipants(model);
                                    }
                                } else {

                                    //Envía alert en caso de que no cumpla con la validación.
                                    var text = resp.message,
                                    type = 'alert';

                                    var config = {
                                        'text': text,
                                        'type': type
                                    };

                                    _.extend( _this.configAlert, config );

                                    window.Misc.showAlertBox( _this.configAlert );
                                }
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        // Instance view participants
        onInstanceViewParticipants: function (model) {
            if ( this.UsersEventListView instanceof Backbone.View ){
                this.UsersEventListView.stopListening();
                this.UsersEventListView.undelegateEvents();
            }

            this.collection.add(model);

            this.UsersEventListView = new app.UsersEventListView({
                el: this.parameters.data['wrapper'],
                model: this.model,
                collection: this.collection,

            });
        },

        /**
        * Remove element
        */
        onStopParticipatingToEvent: function (e) {
            e.preventDefault();

            var _this = this;

            this.collection.remove(this.model, {reset: true, wait: true});

            this.model.destroy({wait: true,
                success: function (model, resp){
                    //complete proccess
                    if( resp.success !== undefined ){
                        if( resp.success ){
                            _this.$el.html( _this.template() );
                            _this.model = new app.UserEventModel();
                        }
                    }
                }
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);
