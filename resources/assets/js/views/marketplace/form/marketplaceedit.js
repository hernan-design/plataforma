/**
* Class MarketplaceEdit extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MarketplaceEdit = Backbone.View.extend({

        el: '#marketplace-content',
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
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.editForms = {
                'infobasic': {'nameView': 'marketPlaceEditBasic', 'nameClassView': 'MarketPlaceEditBasic', 'renderTo': '#drop-edit-form'},
                'summary': {'nameView': 'marketPlaceEditSummary', 'nameClassView': 'MarketPlaceEditSummary', 'renderTo': '#product-summary-container .field-editing'},
                'infolocation': {'nameView': 'marketPlaceEditLocation', 'nameClassView': 'MarketPlaceEditLocation', 'renderTo': '#drop-edit-form-alt'},
                'infoclassification': {'nameView': 'marketPlaceEditClassification', 'nameClassView': 'MarketPlaceEditClassification', 'renderTo': '#drop-edit-form'},
                'infodescription': {'nameView': 'marketPlaceEditDescription', 'nameClassView': 'MarketPlaceEditDescription', 'renderTo': '#product-infodescription-container .field-editing'}
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

        },

        /*
        * Render View Element
        */
        render: function() {

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
            //
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
                'summary' : function() {
                    _this.renderViewToEdit('summary');
                },
                infolocation: function () {
                	_this.renderViewToEdit('infolocation');
                },
                'infoclassification' : function() {
                    _this.renderViewToEdit('infoclassification', {
                        parameters: {
                            'dropdown': _this.editForms['infoclassification'].renderTo
                        }
                    });
                },
                'infodescription' : function() {
                    _this.renderViewToEdit('infodescription', {
                        parameters: {
                            'dropdown': _this.editForms['infodescription'].renderTo
                        }
                    });

                    // React component simple-editor
                    ReactDOM.render(React.createElement(SimpleEditor, {
                       content: _this.model,
                       formCreate: nameForm,
                       value: _this.model.get('descripcion_producto'),
                       name: "descripcion_producto",
                       options: {
                           placeholder: 'Ingresa una descripción',
                           toolbar: [
                               ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                               ['para', ['ul', 'ol', 'paragraph', 'height']],
                               ['insert', ['link']]
                           ]
                       }
                    }, null), document.getElementById('form-product-editor'));
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
                        // this[this.editForms[nameForm].nameView].$el.foundation('abide');
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

                    // reload plugins
                    if( typeof window.initComponent.initConfigForm == 'function' ) {
                        window.initComponent.initConfigForm();
                    }
                }
            }
        }
    });

})(jQuery, this, this.document);
