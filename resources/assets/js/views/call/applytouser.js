/**
* Class ApplyToUserView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ApplyToUserView = Backbone.View.extend({

        className: '',
        template: _.template( ($('#call-apply-user-tpl').html() || '') ),
        events: {
            'submit #form-call-apply-user': 'onStore',
            'click .create-form': 'onShowForm'
        },
        parameters: {
            'orientacion': '',
            'codigo_convocatoria': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

             // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attributes
            this.configAlert = {
                'wrapper': '#modal-base-tp',
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            this.$modalCreateEntity = $('#modal-base-create-entity');
            this.$modalBase = $('#modal-base-tp');

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, "request", this.loadSpinner );
            this.listenTo( this.model, "sync", this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = {};
            _.extend(attributes, {'codigo_convocatoria': this.parameters['codigo_convocatoria'],  'codigo_orientacion_convocatoria': this.parameters['orientacion'], 'userentitys': this.parameters['userentitys'] })
            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$formCreate = this.$('#form-call-apply-user');

            return this;
        },

        /**
        * Show form for create project or company
        */

        onShowForm: function (e){

            e.preventDefault();
            this.$modalBase.foundation('reveal', 'close');

            var type = e.currentTarget.id;

            var _this = this,
                typeApply = e.currentTarget.id,
                stuffToDo = {
                    'project' : function() {

                        _this.$modalCreateEntity.find('#form-create-entity').attr( {
                            'data-type': "call",
                            'data-call': _this.codigo_convocatoria
                        });
                        _this.$modalCreateEntity.foundation('reveal', 'open');
                    },

                    'default' : function() {
                    }
                };

            if (stuffToDo[typeApply]) {
                stuffToDo[typeApply]();
            } else {
                stuffToDo['default']();
            }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function() {
        },

        /**
        * Fires after of run render function
        */
        afterRender: function() {
            // this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }
            if( _.has($.fn, 'chosen') ){
                window.initComponent.chosenTrigger();
            }
        },

        /**
        * Event for create project
        */
        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            _.extend(data, { 'codigo_convocatoria': this.codigo_convocatoria })

            this.model.save( data, {patch: true, wait:true} );
            this.$formCreate.find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            // window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {

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

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re, $formReset) {
                    return function () {
                        $formReset.find(':submit').removeClass('disabled');

                        if( re.success && re.success !== undefined ){

                            $formReset[0].reset();
                            $formReset.find('.chosen-select')
                                      .trigger("chosen:updated");

                        }else if( !re.success && re.success !== undefined ){

                            window.Misc.showAlertBox( conf );
                        }
                    };
                })(this.configAlert, resp, this.$formCreate)
            });

            if( resp.success ){
                window.location.reload();
            }
        }
    });

})(jQuery, this, this.document);
