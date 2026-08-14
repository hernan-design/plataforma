/**
* Class EventEdit extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventEdit = Backbone.View.extend({

        el: '#calendar-content',
        events: {
            'click .edit-field': 'onOpenEditForm'
        },

        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.editForms = {
                'infobasic': {'nameView': 'eventEditBasic', 'nameClassView': 'EventEditBasic', 'renderTo': '#drop-edit-form'},
                'infocity': {'nameView': 'eventEditCity', 'nameClassView': 'EventEditCity', 'renderTo': '#event-city-container'},
                'infodescription': {'nameView': 'eventEditDescription', 'nameClassView': 'EventEditDescription', 'renderTo': '#event-infodescription-container .field-editing'}
            };
        },

        /*
        * Render View Element
        */
        render: function() {

            return this;
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
                'infobasic' : function() {
                    _this.renderViewToEdit('infobasic', {
                        parameters: {
                            'dropdown': _this.editForms['infobasic'].renderTo
                        }
                    });
                },
                'infocity' : function() {
                    _this.renderViewToEdit('infocity', {
                        parameters: {
                            'dropdown': _this.editForms['infocity'].renderTo
                        }
                    });
                },
                'infodescription' : function() {
                    _this.renderViewToEdit('infodescription', {
                        parameters: {
                            'dropdown': _this.editForms['infodescription'].renderTo
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
                    	$(document).foundation('abide', 'reflow');
                    }

                    if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') ) {
                        window.initComponent.select2Trigger();
                    }

                    if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'sspinner') ){
                        window.initComponent.spinnerTrigger();
                    }

                    if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') ) {
						window.initComponent.configInputMask();
					}

        			if( typeof(window.initComponent.datepickerTrigger) == 'function' ) {
        				window.initComponent.datepickerTrigger();
                    }

                    // reload plugins
                    if( typeof window.initComponent.initConfigForm == 'function' ) {
                        window.initComponent.initConfigForm();
                    }

                    if(nameForm == 'infodescription'){
                        this.wysiwygTrigger();
                    }
                }
            }
        },

        /**
        * Trigger wysiwyg
        */
        wysiwygTrigger:  function () {
            ReactDOM.render(React.createElement(ContentEditor, {
                formCreate: 'form-edit-description-event',
                name: 'descripcion_evento',
                value: this.model.get('descripcion_evento'),
                options: {height: 'auto'}
            }, null), document.getElementById('edit-description-event'));
        }
    });

})(jQuery, this, this.document);
