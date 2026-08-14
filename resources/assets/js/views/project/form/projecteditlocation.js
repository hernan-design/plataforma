/**
* Class ProjectEditLocation extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectEditLocation = Backbone.View.extend({

        tagName: 'div',
        id: 'container-form-location',
        className: 'edit-form',
        template: _.template( ($('#edit-project-location-form-tpl').html() || '') ),  
        events: {
            'submit #form-edit-project-location': 'onEditForm'
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

            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
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

            if( this.parameters['dropdown'] !== false )           
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }

    });

})(jQuery, this, this.document);