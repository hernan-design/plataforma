/**
* Class RequestMentoringView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RequestMentoringView = Backbone.View.extend({
        el: '#mentoring-create',
        template: _.template( ($('#request-mentoring-tpl').html() || '') ),
        events: {
            'submit #form-request-mentoring': 'onStore'
        },
        parameters: {
            //
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
            this.$modalBase = $('#modal-base-tp');

            this.configAlert = {
                'wrapper': '#modal-base-tp',
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

            this.adviceModel = new app.AdviceModel();

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, "request", this.loadSpinner );
            this.listenTo( this.model, "sync", this.responseServer );
            this.listenTo( this.adviceModel, "request", this.loadSpinner );
            this.listenTo( this.adviceModel, "sync", this.responseServer );

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
            this.$tags_asesoria = this.$('#tags_asesoria');

            //Init Attributes
            this.$formCreate = this.$('#form-request-mentoring');

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

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
            this.renderTagsPost();
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
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' ){
                window.initComponent.chosenTrigger();
            }

            if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') ){
                window.initComponent.select2Trigger();
            }

            if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') ){
                window.initComponent.chosenTrigger();
            }

            if( typeof window.initComponent.initConfigForm == 'function' ){
                window.initComponent.initConfigForm();
            }

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' ){
                window.initComponent.select2Trigger();
            }

        },

        /**
        * Event for create request mentory
        */
        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            this.adviceModel.save( data, {patch: true} );

            this.$formCreate.find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
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
                this.$modalBase.foundation('reveal', 'close');

                window.Misc.showAlertBox( {
                    'type': 'info',
                    'text': resp.message,
                    'closeTime': 7000
                });

                // Redirect to Content Questions Mentoring
                url = Route.route('mentoria.preguntas.index') ;
                Backbone.history.navigate(url, { trigger:true });
            }
        },

        /**
        * Init Tags Input
        */
        renderTagsPost: function () {

            this.$tags_asesoria.tagsInput({
                'autocomplete_url': document.url + Route.route('tag.index'),
                'autocomplete': { selectFirst:true, width:'300px', autoFill:true },
                'height': 'auto',
                'width': '100%',
                'interactive': true,
                'defaultText': 'Agrega una etiqueta',
                'removeWithBackspace' : true,
                'minChars' : 1,
                'placeholderColor' : '#666666'
            });
        }
    });

})(jQuery, this, this.document);
