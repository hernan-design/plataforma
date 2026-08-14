/**
* Class EditGroup extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditGroup = Backbone.View.extend({

        el: '#group-content',
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
                'name-project': {'nameView': 'projectEditName', 'nameClassView': 'ProjectEditName', 'renderTo': '#drop-edit-form'},
                'location-project': {'nameView': 'projectEditLocation', 'nameClassView': 'ProjectEditLocation', 'renderTo': '#drop-edit-form'},
                'tags': {'nameView': 'projectEditTag', 'nameClassView': 'ProjectEditTag', 'renderTo': '#group-tag-container .field-editing'},
                'video-group': {'nameView': 'projectEditVideo', 'nameClassView': 'ProjectEditVideo', 'renderTo': '#drop-edit-form'},
                'socials': {'nameView': 'projectEditSocials', 'nameClassView': 'ProjectEditSocials', 'renderTo': '#drop-edit-form'},
                'description': {'nameView': 'projectEditDescription', 'nameClassView': 'ProjectEditDescription', 'renderTo': '#group-description-container .field-editing'},
                'interests': {'nameView': 'projectEditInterests', 'nameClassView': 'ProjectEditInterests', 'renderTo': false},
                'members': {'nameView': 'projectEditMembers', 'nameClassView': 'ProjectEditMembers', 'renderTo': false},
                'sponsors': {'nameView': 'projectEditSponsors', 'nameClassView': 'ProjectEditSponsors', 'renderTo': false},
                'summary': {'nameView': 'projectEditSummary', 'nameClassView': 'ProjectEditSummary', 'renderTo': '#group-summary-container .field-editing'}
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
            this.swicthEditForm('interests');
            this.swicthEditForm('sponsors');
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

                'tags' : function() {
                    _this.renderViewToEdit('tags');
                },

                'video-group' : function() {

                    _this.renderViewToEdit('video-group', {
                        parameters: {
                            'dropdown': _this.editForms['video-group'].renderTo
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
                },

                'summary' : function() {
                    _this.renderViewToEdit('summary');
                },
                
                'interests': function () {
                    var params = {
                        el: '#group-interests-container',
                        collection: _this.parameters['interests'],
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
                        if( typeof this[this.editForms[nameForm].nameView].renderTagsPost == 'function' )
                        	this[this.editForms[nameForm].nameView].renderTagsPost();
                        if( typeof this[this.editForms[nameForm].nameView].renderImportTags == 'function' )
                        	this[this.editForms[nameForm].nameView].renderImportTags();
                    }else {
                        this[this.editForms[nameForm].nameView].render();
                    }

                    // trigger fuctions plugin
                    if( _.has($.fn, 'foundation') ) {
                        this[this.editForms[nameForm].nameView].$el.foundation('abide');
                    }

                    if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') ) {
                        window.initComponent.chosenTrigger();
                    }

                    if( typeof window.initComponent.chosenTrigger == 'function' ) {
                        window.initComponent.initConfigForm();
                    }
                }
            }
        }
    });

})(jQuery, this, this.document);