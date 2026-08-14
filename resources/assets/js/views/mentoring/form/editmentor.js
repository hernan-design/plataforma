/**
* Class EditMentor extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditMentor = Backbone.View.extend({

        el: '#mentoring-content',
        templateMentorTerms: _.template( ($('#edit-mentor-terms-form-tpl').html() || '') ),
        events: {
            'click .edit-field': 'onOpenEditForm',
            'change #aceptacion_terminos': 'onAcceptMentorTerms'
        },
        parameters: {
            'viewProfile': null
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.editForms = {
                'assistance': {'nameView': 'mentorEditAssistance', 'nameClassView': 'MentorEditAssistance', 'renderTo': '#mentor-asisstance-container .field-editing'},
                'experience': {'nameView': 'mentorEditExperience', 'nameClassView': 'MentorEditExperience', 'renderTo': '#mentor-experience-container .field-editing'},
                'expertise': {'nameView': 'mentorEditExpertise', 'nameClassView': 'MentorEditExpertise', 'renderTo': '#drop-edit-form-alt'},
                'specialities': {'nameView': 'mentorEditSpecialities', 'nameClassView': 'MentorEditSpecialities', 'renderTo': false},
                'economics': {'nameView': 'editPersonEconomicSectorList', 'nameClassView': 'EditPersonEconomicSectorList', 'renderTo': false},
                'level-development': {'nameView': 'mentorEditLevelDevelopment', 'nameClassView': 'MentorEditLevelDevelopment', 'renderTo': '#drop-edit-form-alt'},
                'socials': {'nameView': 'mentorEditSocials', 'nameClassView': 'MentorEditSocials', 'renderTo': '#drop-edit-form-alt'}
            };

            var _this = this;

            this.$('#mentor-terms-container').html( this.templateMentorTerms( this.model.toJSON()) );

            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

        },

        /*
        * Render View Element
        */
        render: function() {

            $(this.el).off('click', '.edit-field');
            $(this.el).off('change', '#aceptacion_terminos');

            this.delegateEvents({
                'click .edit-field': 'onOpenEditForm',
                'change #aceptacion_terminos': 'onAcceptMentorTerms'
            });



            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {

        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
        	if( _.has($.fn, 'foundation') ){
                $(document).foundation('tab', 'reflow');
                $(document).foundation('dropdown', 'reflow');
            }

            this.swicthEditForm('specialities');
            this.swicthEditForm('economics');
        },

        /**
        * open edit form
        */
        onOpenEditForm: function (e) {
            e.preventDefault();

            var nameFormTmpl = '',
                $editField = $(e.currentTarget);

            if( $editField.data('edit-template') ) {
                nameFormTmpl = $editField.data('edit-template');
            }

            this.swicthEditForm(nameFormTmpl);
        },

        /**
         * accept mentor terms
         */
        onAcceptMentorTerms: function (e) {
            e.preventDefault();
            e.stopPropagation();
            checked = e.target.checked;
            data = this.model.toJSON();
         
            if(checked)
            {      
                data['aceptacion_terminos'] = true;
                _this = this;
                this.model.save(data,
                    {
                        patch:true,
                        wait:true,
                        success: function(model, response){
                            if(response.success){
                                _this.$('#mentor-terms-container').html('');
                            }else{
                                console.log('error en aceptacion de terminos');
                                _this.$('#aceptacion_terminos').prop('checked', false);
                                checked = false;
                            }
                        },
                        error: function(){
                            console.log('error en aceptacion de terminos');
                            _this.$('#aceptacion_terminos').prop('checked', false);
                            checked = false;
                        }});
            }

        },


        /**
        * switch for edit forms
        * @param String nameForm
        */
        swicthEditForm: function (nameForm) {

            nameForm || (nameForm = '');

            var _this = this;

            var toRenderView = {

                'assistance' : function() {
                    _this.renderViewToEdit('assistance');

                    // React component simple-editor
                    ReactDOM.render(React.createElement(SimpleEditor, {
                        content: _this.model,
                        formCreate: nameForm,
                        value: _this.model.get('forma_ayuda_mentoria'),
                        name: "forma_ayuda_mentoria",
                        options: {
                            placeholder: 'En qué puedo ayudar',
                            toolbar: [
                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph', 'height']],
                                ['insert', ['link']]
                            ]
                        }
                    }, null), document.getElementById('form-mentor-help-editor'));
                },

                'experience' : function() {
                    _this.renderViewToEdit('experience');

                    // React component simple-editor
                    ReactDOM.render(React.createElement(SimpleEditor, {
                        content: _this.model,
                        formCreate: nameForm,
                        value: _this.model.get('experiencia_usuario'),
                        name: "experiencia_usuario",
                        options: {
                            placeholder: 'Ingresa tu experiencia',
                            toolbar: [
                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph', 'height']],
                                ['insert', ['link']]
                            ]
                        }
                    }, null), document.getElementById('form-project-editor'));
                },

                'expertise' : function() {
                    _this.renderViewToEdit('expertise', {
                        parameters: {
                            'dropdown': _this.editForms['expertise'].renderTo
                        }
                    });
                },

                'level-development' : function() {
                    _this.renderViewToEdit('level-development', {
                        parameters: {
                            'dropdown': _this.editForms['level-development'].renderTo
                        }
                    });
                },

                'specialities': function () {
                    var params = {
                        el: '#mentor-specialities-container',
                        collection: _this.parameters['specialities'],
                        parameters: {
                            'codigo_usuario': _this.parameters['user'],
                            'owner':  _this.parameters['owner']
                        }
                    };

                    _this.renderViewToEdit('specialities', params);
                },

                'economics': function () {
                    var params = {
                        el: '#mentor-economic-sector-container',
                        collection: _this.parameters['economics'],
                        parameters: {
                            'codigo_persona': _this.parameters['person'],
                            'owner':  _this.parameters['owner']
                        }
                    };

                    _this.renderViewToEdit('economics', params);
                },

                'socials' : function() {

                    _this.renderViewToEdit('socials', {
                        parameters: {
                            'dropdown': _this.editForms['socials'].renderTo
                        }
                    });
                },

                'default' : function() {
                    //
                }
            };

            if (toRenderView[nameForm]) {
                toRenderView[nameForm]();
            } else {
                toRenderView['default']();
            }
        },
       
        /**
        * to render edit view
        * @param String nameForm
        * @param Object params
        */
        renderViewToEdit: function (nameForm, params) {

            params || (params = {});

            var config = {
                model: this.model
            };
            _.extend( config, params );

            // if it exists form template
            if( this.editForms[nameForm] ) {

                if( this[this.editForms[nameForm].nameView] instanceof Backbone.View ){
                    this[this.editForms[nameForm].nameView].stopListening();
                    this[this.editForms[nameForm].nameView].undelegateEvents();
                    // this[this.editForms[nameForm].nameView].remove();
                }

                if( window.app[this.editForms[nameForm].nameClassView] !== undefined ) {

                    this[this.editForms[nameForm].nameView] = new window.app[this.editForms[nameForm].nameClassView]( config );
                    // set view inside container
                    if( this.editForms[nameForm].renderTo ){
                        this.$(this.editForms[nameForm].renderTo).html( this[this.editForms[nameForm].nameView].render().el );

                        // if( typeof this[this.editForms[nameForm].nameView].renderTagsPost == 'function' )
                        // 	this[this.editForms[nameForm].nameView].renderTagsPost();

                        // if( typeof this[this.editForms[nameForm].nameView].renderImportTags == 'function' )
                        // 	this[this.editForms[nameForm].nameView].renderImportTags();
                    }else {
                        this[this.editForms[nameForm].nameView].render();
                    }

                    // trigger fuctions plugin
                    if( _.has($.fn, 'foundation') ) {
                        this[this.editForms[nameForm].nameView].$el.foundation('abide');
                    }

                    // fire plugins
                    if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') ) {
                        window.initComponent.chosenTrigger();
                    }

                    if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') ) {
                        window.initComponent.select2Trigger();
                    }

                    if( typeof window.initComponent.initConfigForm == 'function' ) {
                        window.initComponent.initConfigForm();
                    }
                }
            }
        }
    });

})(jQuery, this, this.document);
