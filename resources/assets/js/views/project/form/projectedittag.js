/**
* Class ProjectEditTag extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectEditTag = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-project-tags-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-project-tags': 'onEditForm',
            'blur .edit-field-text': 'onEditForm',
            'keydown .edit-field-text': 'revertOnEscape'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // Init Attributes

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            // Initialize references
            this.$tags_usuario = this.$('#tags_usuario');
            this.$editFieldTxt = this.$('.edit-field-text');
            this.$formEdit = this.$('#form-edit-project-tags');

            return this;
        },

        /**
        * update user fields
        */
        onEditForm: function (e) {
            e.preventDefault();

            var _this = this;

            // if it is not editing
            if( !this.$el.parents('.editable-item').hasClass('editing') ){
                return;
            }

            var data = window.Misc.formToJson( this.$formEdit );
            data.update_tags = 'true';

            // if the value was not modified
            if( window.Misc.trim(data['tags_usuario']) == window.Misc.trim(this.model.get('tags')) ){
                this.close();
                this.$editFieldTxt.blur();

                return;
            }

            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of server
        */
        responseServer: function ( target, resp, opts ) {

            if( resp.success !== undefined ) {
                if ( resp.success ) {
                    this.close();
                }
            }
        },

        /**
        *
        */
        revertOnEscape: function  (e) {

            this.close();
            this.$editFieldTxt.blur();
        },

        /**
        *
        */
        close: function () {

            this.$el.parents('.editable-item').removeClass('editing');
            this.$editFieldTxt.val( this.model.get('tags') );
        },

        /**
        * Init Tags Input
        */
        renderTagsPost: function () {

            this.$tags_usuario.tagsInput({
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
        },

        /**
        * Init ImportTags Input
        */
        renderImportTags: function () {
            this.$tags_usuario.importTags(this.model.get('tags'));
        }
    });

})(jQuery, this, this.document);
