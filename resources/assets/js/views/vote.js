/**
* Class VoteView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VoteView = Backbone.View.extend({
    
        template: _.template( ($('#vote-form-tpl').html() || '') ),
        events: {
            'submit #form-vote-user': 'onStoreVote',
            'blur #email': 'onValidateEmail'
        },
        parameters: {
            'data-srcparams': 'data-srcparams'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onSuccessVote');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 15000,
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

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this,
                attributes = {};

            this.$el.html( this.template(attributes) );
            this.$formEdit = this.$('#form-vote-user');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {

            var _this = this; 

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                _this.$el.foundation('abide');
            }
        },

        /**
        * event vote user
        */
        onStoreVote: function (e) {

            e.preventDefault();
            data = window.Misc.formToJson(event.target);
            data.srcparams = this.parameters['data-srcparams'];

            this.$formEdit.find(':submit').addClass('disabled');

            $.post(document.url + Route.route('voto.voto.store'), data, this.onSuccessVote);

        },

        /**
        * success event for vote User
        * @param Object res
        */
        onSuccessVote: function (resp) {
            var _this = this;
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });

            if(resp.requestPost) {
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
                _.extend( _this.configAlert, config );
                //complete proccess
                if( resp.success !== undefined ){
                    if( resp.success ){
                        _this.$el.foundation('reveal','close');
                        window.Misc.showAlertBox( _this.configAlert );
                    }else{
                        window.Misc.showAlertBox( _this.configAlert );
                    }
                    _this.clearForm( _this.$formEdit );
                    _this.$formEdit.find(':submit').removeClass('disabled');
                }
            } 
        },

        /**
        * validate email
        */
        onValidateEmail: function (e) {

            var _this = this,
                email = (e !== undefined && e.type != 'opened' && $(e.currentTarget).length) ? 
                            $(e.currentTarget).val() : 
                                (!this.$fldEmail.length && e !== undefined ) ? 
                                        this.$('#email').val() : this.$fldEmail.val(),
                sendData = {
                    'email': email
                };

            this.validateEmail(sendData, function (respState, respAlert, resp) {

                window.Misc.removeSpinner({ 
                    'wrap': _this.$formEdit,
                    'direct': true
                });
                
                if( respState ){
                    _this.$formEdit.find('#nombre_usuario').val(resp.labelname);
                    _this.$formEdit.find('#primer_apellido_persona').val(resp.labellastname);

                }else{

                    _this.$formEdit.find('.view-input').val('');
                }

            });
        },

        /**
        * validate E-mail of the team project
        * @param String email
        * @return Array | [Boolean, Object]
        */
        validateEmail: function (sendData, callback) {

            var _this = this,
                respReturn = true,
                configAlert = this.configAlert,
                _data = {
                    'email': ''
                };

            if( _.isObject(sendData) )
                _.extend(_data, sendData);


            if( window.Misc.isEmail(_data['email']) ) {

                window.Misc.setSpinner( _this.$formEdit);
                $.get(document.url + Route.route('usuario.valid.email'), _data, function (resp) {

                    if( resp.success !== undefined ){

                        var type = resp.success ? 'success' : 'alert',
                            text = resp.success ? 
                                   (resp.message !== undefined ? resp.message : '')
                                   : resp.errors;

                        if( _.isObject(resp.errors) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                 listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }
                        
                        var conf = {
                            'text': text,
                            'type': type
                        };

                        _.extend(configAlert, conf);

                        if (!resp.success) {

                            respReturn = false;

                        }
                    }

                    if( typeof callback == 'function' ){
                        callback.call(null, respReturn, configAlert, resp);
                    }
                });
            }
        },

        /**
        * clean form
        * @param Object | jQuery $formReset
        */
        clearForm: function ($formReset) {
            $formReset[0].reset();
        }
    });

})(jQuery, this, this.document);
