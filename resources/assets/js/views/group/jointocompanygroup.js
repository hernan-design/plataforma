/**
* Class JoinToCompanyGroupView extend of Backbone View
* @author TuProyecto || Desarrollador : @xidnykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.JoinToCompanyGroupView = Backbone.View.extend({

        template: _.template( ($('#group-join-company-tpl').html() || '') ),
        events: {
            'submit #form-group-join-company': 'onStore',
            'click .create-form': 'onShowForm'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes

            this.$modalCreateCompany = $('#modal-create-company');
            this.$modalBase = $('#modal-base-tp');
             this.$modalBase.addClass('not-fixed')
                           .find('.content-modal')
                                .addClass('reset-content');
            
            this.configAlert = {
                'wrapper': '#modal-base-tp',
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "request", this.loadSpinner );
            this.listenTo( this.model, "sync", this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = {};
            attributes.codigo_proyecto = this.codigo_proyecto;

            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$formCreate = this.$('#form-group-join-company');

            if( _.has($.fn, 'foundation') )
                this.$el.foundation('abide');

            return this;
        },

        /**
        * Show form for create company
        */

        onShowForm: function (e){

            e.preventDefault();
            this.$modalBase.foundation('reveal', 'close');

            var type = e.currentTarget.id;

            var _this = this,
                typeApply = e.currentTarget.id,
                stuffToDo = {
                    'company' : function() {

                        _this.$modalCreateCompany.find('#form-create-company').attr( {
                            'data-type': "call", 
                            'data-call': _this.codigo_convocatoria
                        });
                        _this.$modalCreateCompany.foundation('reveal', 'open');
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
        * fires libraries js
        */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();
        },

        /**
        * Event for create project
        */
        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            _.extend(data, { 'codigo_convocatoria': this.codigo_convocatoria })

            // overwrite model value id attribute and save
            this.model.set({'codigo_proyecto': data.codigo_proyecto},{'silent':true});
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
                    (resp.message !== undefined ? resp.message : '')
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