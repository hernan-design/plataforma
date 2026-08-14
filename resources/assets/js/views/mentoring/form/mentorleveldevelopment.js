/**
* Class MentorEditLevelDevelopment extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorEditLevelDevelopment = Backbone.View.extend({

        tagName: 'div',
        id: 'container-form-level-development',
        className: 'edit-form',
        template: _.template( ($('#edit-mentor-level-development-form-tpl').html() || '') ),  
        events: {
            'submit #form-edit-mentor-level-development': 'onEditForm',
            'change .etapa_proyecto':'onChangeField'
        },
        parameters: {
            'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            this.parameters['changedLevelAttributes'] = false;
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

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            data['changed_level_attributes'] = this.parameters.changedLevelAttributes || false;   
            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el ); 
        },
        
        /**
        * change  fields
        */
       onChangeField: function(e) {
            e.preventDefault();        
            var attributes = this.model.toJSON();
            if( e.target.type === 'checkbox' ){
                this.parameters['changedLevelAttributes'] = true;
                }

            return;
        },
        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            }); 

            if( this.parameters['dropdown'] !== false )           
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }

    });

})(jQuery, this, this.document);