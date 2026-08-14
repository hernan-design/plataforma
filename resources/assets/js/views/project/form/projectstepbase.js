/**
* Class StepFormBaseView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.StepFormBaseView = Backbone.View.extend({

        className: 'step-item',
        formCreate: '',
        events: {
        },
        parameters: {
            'modal-form': null,
            'carousel-form':null,
        },
        /**
        * Constructor Method
        */
        initialize: function (opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            this.events[ 'submit '+ this.formCreate ] = 'onStore';
            _.extend(this.parameters, opts.parameters);

            //Initialize Attributes
            this.$carouselForm = this.parameters['carousel-form'];
            this.configAlert = {
                'wrapper': this.parameters['modal-form'],
                'closeTime': 8000,
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
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$formCreate = this.$( this.formCreate );

            return this.el;
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
            this.ready();
        },

        /**
        * Event for create project
        */
        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            this.model.set( data, {silent:true} );

            this.model.save( this.model.toJSON(), {patch: true, wait:true} );
            this.$formCreate.find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            
            // window.Misc.setSpinner( this.$formCreate );
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {

            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ? 
                    (resp.message !== undefined ? resp.message : 'El proyecto se creo.')
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

                            // $formReset[0].reset();
                            // $formReset.find('[class*=chosen-select]')
                            //           .trigger("chosen:updated");
                        }else if( !re.success && re.success !== undefined ){

                            window.Misc.showAlertBox( conf );
                        }
                    };
                })(this.configAlert, resp, this.$formCreate)
            });
        },

        /**
        * fires libraries js and functions
        */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$formCreate.foundation('abide');
                $(document).foundation('tab', 'reflow');
                $(document).foundation('equalizer', 'reflow');
            }

            // trigger functions
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();
        },

        /**
        * event updated at
        * @param String updated
        */
        updatedAt: function (updated) {

            if( this.$('.text-updated-at').length ){
                this.$('.text-updated-at').text(updated);
            }

            this.model.set( {'updated_at':updated}, {silent:true} );
        }
    });
    
})(jQuery, this, this.document);