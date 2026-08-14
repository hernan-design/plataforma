/**
* Class MentoringItemSessionList extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringItemSessionList = Backbone.View.extend({
        template: _.template( ($('#session-mentorig-tpl').html() || '') ),
        events: {
            //
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();

            console.log('Session Attributes', attributes);
         
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') ){
                $(document).foundation('dropdown', 'reflow');
            }

            return this;
        }
    });

})(jQuery, this, this.document);
