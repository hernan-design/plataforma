/**
* Class MentoringQuestionItemGridView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionItemGridView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentoring-question-list-tpl').html() || '') ),
        events: {
            'click .tp_link-title': 'onValidateTitle',
            'click #opt-close-mentoring-question': 'onCloseMentoringQuestion'
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        },

        onCloseMentoringQuestion: function (e) {
            e.preventDefault();

                var data = {};
                data['codigo_estado'] = window._tp.getState['closed'];
                _this = this;
                this.model.save(data, {patch: true, wait: true,
                    success: function (model, resp) {
                        // response success or error
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
                    }
                });

        },

        onValidateTitle: function (e) {
            e.preventDefault();

            if(this.model.get('codigo_estado') == window._tp.getState['pending']){
                var conf = {
                    text: 'La solicitud de asesoría no se ha aprobado.',
                    type: 'alert'
                };
                confAlert = $.extend({}, this.configAlert, conf);
                window.Misc.showAlertBox( confAlert );
            }else if(this.model.get('codigo_estado') == window._tp.getState['closed']){
                var conf = {
                    text: 'El proceso de asesoría se encuentra cerrado.',
                    type: 'alert'
                };
                confAlert = $.extend({}, this.configAlert, conf);
                window.Misc.showAlertBox( confAlert );
            }else{
                app.AppRouter.navigate( Route.route('mentoria.preguntas.show', {'preguntas': this.model.get('url_asesoria') }), {trigger: true} );
            }
        }

    });

})(jQuery, this, this.document);
