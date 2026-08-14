/**
* Class EditProject extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditProject = Backbone.View.extend({

        el: '#project-content',
        events: {
            'click .edit-field': 'onOpenEditForm'
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
                'name-project': {'nameView': 'projectEditName', 'nameClassView': 'ProjectEditName', 'renderTo': '#drop-edit-form-alt'},
                'location-project': {'nameView': 'projectEditLocation', 'nameClassView': 'ProjectEditLocation', 'renderTo': '#drop-edit-form-alt'},
                'industry-project': {'nameView': 'projectEditIndustry', 'nameClassView': 'ProjectEditIndustry', 'renderTo': '#drop-edit-form-alt'},
                'tags': {'nameView': 'projectEditTag', 'nameClassView': 'ProjectEditTag', 'renderTo': '#project-tag-container .field-editing'},
                'video-project': {'nameView': 'projectEditVideo', 'nameClassView': 'ProjectEditVideo', 'renderTo': '#drop-edit-form-lg'},
                'socials': {'nameView': 'projectEditSocials', 'nameClassView': 'ProjectEditSocials', 'renderTo': '#drop-edit-form'},
                'description': {'nameView': 'projectEditDescription', 'nameClassView': 'ProjectEditDescription', 'renderTo': '#project-description-container .field-editing'},
                'interests': {'nameView': 'projectEditInterests', 'nameClassView': 'ProjectEditInterests', 'renderTo': false},
                'members': {'nameView': 'projectEditMembers', 'nameClassView': 'ProjectEditMembers', 'renderTo': false},
                'sponsors': {'nameView': 'projectEditSponsors', 'nameClassView': 'ProjectEditSponsors', 'renderTo': false},
                'summary': {'nameView': 'projectEditSummary', 'nameClassView': 'ProjectEditSummary', 'renderTo': '#project-summary-container .field-editing'},
                'mail-contact': {'nameView': 'ProjectEditMailContact', 'nameClassView': 'ProjectEditMailContact', 'renderTo': '#project-mail-contact .field-editing'},
                'pageweb': {'nameView': 'projectEditPageWeb', 'nameClassView': 'ProjectEditPageWeb', 'renderTo': '#project-pageweb-container .field-editing'},
                'numerowhatsapp': {'nameView': 'projectEditNumeroWhatsapp','nameClassView': 'ProjectEditNumeroWhatsapp', 'renderTo': '#project-numerowhatsapp-container .field-editing'
                }
            };

            var _this = this;

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
            this.delegateEvents({
                'click .edit-field': 'onOpenEditForm'
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

            if( $(this.el).attr('id') == 'project-detail' ){
                this.swicthEditForm('interests');
                this.swicthEditForm('members');
                this.swicthEditForm('sponsors');
            }
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
        * switch for edit forms
        * @param String nameForm
        */
        swicthEditForm: function (nameForm) {

            nameForm || (nameForm = '');

            var _this = this;

            var toRenderView = {
                'name-project' : function() {

                    _this.renderViewToEdit('name-project', {
                        parameters: {
                            'dropdown': _this.editForms['name-project'].renderTo
                        }
                    });
                },

                'location-project' : function() {

                    _this.renderViewToEdit('location-project', {
                        parameters: {
                            'dropdown': _this.editForms['location-project'].renderTo
                        }
                    });
                },

                'industry-project' : function() {

                    _this.renderViewToEdit('industry-project', {
                        parameters: {
                            'dropdown': _this.editForms['industry-project'].renderTo
                        }
                    });
                },

                'tags' : function() {
                    _this.renderViewToEdit('tags');
                },

                'video-project' : function() {

                    _this.renderViewToEdit('video-project', {
                        parameters: {
                            'dropdown': _this.editForms['video-project'].renderTo
                        }
                    });
                },

                'socials' : function() {

                    _this.renderViewToEdit('socials', {
                        parameters: {
                            'dropdown': _this.editForms['socials'].renderTo
                        }
                    });
                },

                'description' : function() {
                    _this.renderViewToEdit('description');

                    // React component simple-editor
                    ReactDOM.render(React.createElement(SimpleEditor, {
                        content: _this.model,
                        formCreate: nameForm,
                        value: _this.model.get('descripcion_entidad'),
                        name: "descripcion_entidad",
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

                'summary' : function() {
                    _this.renderViewToEdit('summary');
                },
                'pageweb' : function() {
                    _this.renderViewToEdit('pageweb');
                },
                'numerowhatsapp' : function() {
                    _this.renderViewToEdit('numerowhatsapp');
                },

                'mailContact' : function() {
                    _this.renderViewToEdit('mail-contact');
                },

                'interests': function () {
                    var params = {
                        el: '#project-interests-container',
                        collection: _this.parameters['interests'],
                        parameters: {
                            'codigo_usuario': _this.model.get('codigo_usuario'),
							'creator': _this.model.get('creator')
                        }
                    };

                    _this.renderViewToEdit('interests', params);
                },

                'members': function () {
                    var params = {
                        el: '#project-members-container',
                        collection: _this.parameters['members'],
                        parameters: {
                            'codigo_usuario': _this.parameters['user']
                        }
                    };

                    _this.renderViewToEdit('members', params);
                },

                'sponsors': function () {
                    var params = {
                        el: '#project-sponsor-container',
                        collection: _this.parameters['sponsors'],
                        parameters: {
                            'codigo_entidad': _this.parameters['entity']
                        }
                    };

                    _this.renderViewToEdit('sponsors', params);
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

                        if( typeof this[this.editForms[nameForm].nameView].renderTagsPost == 'function' )
                        	this[this.editForms[nameForm].nameView].renderTagsPost();

                        if( typeof this[this.editForms[nameForm].nameView].renderImportTags == 'function' )
                        	this[this.editForms[nameForm].nameView].renderImportTags();
                    }else {
                        this[this.editForms[nameForm].nameView].render();
                    }

                    // trigger fuctions plugin
                    if( _.has($.fn, 'foundation') ) {
                    	$(document).foundation('abide', 'reflow');
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
