/**
* Class MentorEvaluationView extends of Backbone View
* @author TuProyecto || Desarrollador: @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEvaluationView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#evaluation-mentor-tpl').html() || '') ),
        events: {
        	'submit #form-mentor-evaluation': 'onStore'
        },
        parameters: {
           //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');


            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);

            //Init Attribute
            this.mentorEvaluationModel = new app.MentorEvaluationModel();
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 6000,
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
            this.listenTo( this.model, 'change:codigo_asesoria' , this.render );

            // this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentorEvaluationModel, 'sync', this.responseServerRegistration );


            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );
            // Initialize attributes

            // overwrite model id attribute
            if( this.model.changed.codigo_asesoria !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_asesoria';
                this.model.set({'codigo_asesoria': this.model.get('codigo_asesoria')},{'silent':true});

                // reference to views
                this.referenceViews();
            }

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
                $(document).foundation('dropdown', 'reflow');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

        },

        /**
        * reference to views
        */
        referenceViews: function () {

            this.ready();

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

            // response success or error
            var text = resp.success ? '' : resp.errors,
                type = resp.success ? 'success' : 'alert';

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
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(re.success != undefined) {
                            if( re.success ){
                                // window.Misc.redirect(re.redirect);
                            }else{
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * response of the server model calificationTask
        */
        responseServerRegistration: function ( model, resp, opts ) {
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

            if( resp.success ){
                // Redirect to Content Questions Mentoring
                url = Route.route('mentoria.preguntas.index') ;
                Backbone.history.navigate(url, { trigger:true })
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        },

        /**
        * Event Evaluation Items Mentor
        */
        onStore: function (e) {

            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            data.codigo_asesoria = this.model.get('codigo_asesoria');
            data.referee = this.model.get('emprendedor') ? window._tp.typeItemMentoring['entrepreneurship'] : window._tp.typeItemMentoring['mentor'];
            this.mentorEvaluationModel.save( data, {patch: true, wait:true} );
        }

   });

})(jQuery, this, this.document);
