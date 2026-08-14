/**
* Class MentoringQuestionView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringQuestionView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#mentoring-feedback-tpl').html() || '') ),
        events: {
            'click #opt-close-mentoring-question': 'onCloseMentoringQuestion'
        },
        parameters: {
            rol: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters)
            }

            this.configAlert = {
                'wrapper': '#mentoring-wrapper',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attribute
            this.discussionList = new app.DiscussionList();

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
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
            attributes.rol = this.parameters.rol;

            this.$el.html( this.template(attributes) );

            this.$wrapperDocuments = this.$('#wrap-documents');
            // redefine id attribute model
            if( this.model.changed.codigo_asesoria !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_asesoria';
                this.model.set({'codigo_asesoria': this.model.get('codigo_asesoria')},{'silent':true});

                this.referenceViews();
            }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {

            // Instance of Documents of Advice
            this.mentoringQuestionDocuments = new app.MentoringQuestionDocuments({
                el: this.$wrapperDocuments,
                model: this.model,
                parameters: {
                    //
                }
            });

            this.mentoringQuestionDocuments.render();

            this.discussionListView = new app.DiscussionListView({
                collection: this.discussionList,
                    parameters: {
                        'formDiscussion': '#form-discussion-advice',
                        dataFilter: {
                            'codigo_recurso_modulo': this.model.get('codigo_asesoria'),
                            'codigo_modulo': window._tp.getModule('mentoring')
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
                'direct': true
            });
        },

        /**
         * 
         */
        onCloseMentoringQuestion: function (e) {
            e.preventDefault();
                var data = {};
                data['codigo_estado'] = window._tp.getState['closed'];
                _this = this;

                this.acceptSendConfirm = new app.ConfirmWindow({
                    model: _this.model,
                    parameters: {
                        template: _.template($("#mentoring-end-confirm-tpl").html() || ""),
                        titleConfirm: "¿ Está seguro de finalizar la asesoría/mentoría ?",
                        onConfirm: function () {
                            _this.model.save(data, {patch: true, wait: true,
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

                                    Backbone.history.navigate(Route.route('mentoria.preguntas.evaluacion.mentor.create', {
                                        user: _this.model.get('codigo_asesoria') } ), { trigger:true });
                                }
                            });
                        }
                    }
                });

                this.acceptSendConfirm.render();
        }
   });

})(jQuery, this, this.document);
