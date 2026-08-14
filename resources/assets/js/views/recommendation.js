/**
* Class RecommendationMentorView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RecommendationMentorView = Backbone.View.extend({
        
        template: _.template( ($('#recommendation-mentor-tpl').html() || '') ),
        events: {
            'submit #form-recommendation-mentor': 'onStore'
        },
        parameters: {
            type: '',
            institucion: ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

             // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.configAlert = {
                'wrapper': '#modal-base-material',
                'closeTime': 7000,
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
            this.listenTo( this.model, "request", this.loadSpinner );
            this.listenTo( this.model, "sync", this.responseServer );

            // Events Listener custome
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
            this.$formCreate = this.$('#form-recommendation-mentor');
        
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
                this.$el.foundation('abide');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();

            if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
                window.initComponent.chosenTrigger();
        },

        /**
        * Event for create request mentory
        */
        onStore: function (e) {

            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            data.type = this.parameters['type'];
            data.institucion = this.parameters['institucion'];

            this.model.save( data, {patch: true} );

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

            this.$el.foundation('reveal', 'close');
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
                            
                        }else{
                            window.Misc.showAlertBox( conf );
                        }
                    };
                })(this.configAlert, resp, this.$formCreate)
            });
        }
    });

})(jQuery, this, this.document);