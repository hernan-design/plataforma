/**
* Class ProjectInterestItemView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectInterestItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#interest-item-project-tpl').html() || '') ),
        events: {
            'click .remove-interest': 'onRemove'
        },
        parameters: {
            codigo_usuario: ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Remove element
        */
        onRemove: function (e) {
            e.preventDefault();

            this.model.destroy({
                'processData': true,
                wait: true,
                data: { '_token': $('meta[name="csrf-token"]').attr('content'), codigo_usuario: this.parameters['codigo_usuario'] }
            });
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

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);