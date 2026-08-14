/**
* Class UserEditProfile extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditProfile = Backbone.View.extend({

        el: '#user-content',
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
                'name': {'nameView': 'userEditName', 'nameClassView': 'UserEditName', 'renderTo': '#drop-edit-form'},
                'location': {'nameView': 'userEditLocation', 'nameClassView': 'UserEditLocation', 'renderTo': '#drop-edit-form'},
                'biography': {'nameView': 'userEditBiography', 'nameClassView': 'UserEditBiography', 'renderTo': '#user-biography-container .field-editing'},
                'socials': {'nameView': 'userEditSocials', 'nameClassView': 'UserEditSocials', 'renderTo': '#drop-edit-form'},
                'basic': {'nameView': 'userEditBasicData', 'nameClassView': 'UserEditBasicData', 'renderTo': '#drop-edit-form-alt'},
                'experience': {'nameView': 'userEditExperience', 'nameClassView': 'UserEditExperience', 'renderTo': '#user-experience-container .field-editing'},
                'reasons': {'nameView': 'userEditReasons', 'nameClassView': 'UserEditReasons', 'renderTo': false},
                'education': {'nameView': 'userEditEducation', 'nameClassView': 'UserEditEducation', 'renderTo': false},
                'specialities': {'nameView': 'userEditSpecialities', 'nameClassView': 'UserEditSpecialities', 'renderTo': false},
                'interests': {'nameView': 'userEditInterests', 'nameClassView': 'UserEditInterests', 'renderTo': false}
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

            // delegate events of programs
            // if( $(this.el).attr('id') != 'user-content' ){
            //     $(this.el).off();
            //     this.delegateEvents({
            //         'click .edit-field': 'onOpenEditForm'
            //     });
            // }

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

            this.swicthEditForm('reasons');
            this.swicthEditForm('education');
            this.swicthEditForm('specialities');
            this.swicthEditForm('interests');
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
                'name' : function() {
                    _this.renderViewToEdit('name', {
                        parameters: {
                            'dropdown': _this.editForms['name'].renderTo
                        }
                    });
                },

                'location' : function() {
                    _this.renderViewToEdit('location', {
                        parameters: {
                            'dropdown': _this.editForms['location'].renderTo
                        }
                    });
                },

                'biography' : function() {
                    _this.renderViewToEdit('biography');
                },

                'socials' : function() {
                    var socialModel = _this.parameters.socialModel;
                    _this.renderViewToEdit('socials', {
                        model: socialModel instanceof Backbone.Model ? socialModel : _this.model
                    });
                },

                'basic' : function() {
                    _this.renderViewToEdit('basic', {
                        parameters: {
                            'dropdown': _this.editForms['basic'].renderTo
                        }
                    });
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

                'reasons' : function () {
                    var params = {
                        el: '#user-reasons-container',
                        collection: _this.parameters['reasonsList']
                    };

                    _this.renderViewToEdit('reasons', params);
                },

                'education' : function () {
                    var params = {
                        el: '#user-education-container',
                        collection: _this.parameters['educationList']
                    };

                    _this.renderViewToEdit('education', params);
                },

                'specialities': function () {
                    var params = {
                        el: '#user-specialities-container',
                        collection: _this.parameters['specialitiesList']
                    };

                    _this.renderViewToEdit('specialities', params);
                },

                'interests': function () {
                    var params = {
                        el: '#user-interests-container',
                        collection: _this.parameters['interestsList'],
                        parameters: {
                            'codigo_usuario': _this.parameters['user']
                        }
                    };

                    _this.renderViewToEdit('interests', params);
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
                    }else {
                        this[this.editForms[nameForm].nameView].render();
                    }

                    // trigger fuctions plugin
                    if( _.has($.fn, 'foundation') ) {
                        this[this.editForms[nameForm].nameView].$el.foundation('abide');
                    }

                    // fire functions
                    if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') ) {
                        window.initComponent.chosenTrigger();
                    }

                    if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') ) {
                        window.initComponent.select2Trigger();
                    }

                    if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') ) {
                         window.initComponent.configInputMask();
                    }

                    if( typeof window.initComponent.initConfigForm == 'function' ) {
                        window.initComponent.initConfigForm();
                    }
                }
            }
        }
    });

})(jQuery, this, this.document);
