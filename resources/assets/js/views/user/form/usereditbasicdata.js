/**
* Class UserEditBasicData extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditBasicData = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        id: 'container-form-basicdata',
        template: _.template( ($('#edit-user-basic-data-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-user-basic-data': 'onEditForm'
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

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            if(!_.isEmpty(data.year) && !_.isEmpty(data.month) && !_.isEmpty(data.day)){
                data.fecha_nacimiento_usuario = [data.year, data.month, data.day].join('-');
            }

            if (this.validateUrl(data)) {
                $( "#errorUrl" ).css( "display", "none" );
                this.model.save(data, {patch:true, wait:true});
            } else {
                $( "#errorUrl" ).css( "display", "block" );
            }


        },

        validateUrl: function (data) {
            if (data.pagina_web_usuario != "") {
                var pattern = /^(http|https)\:\/\/[a-z0-9\.-]+\.[a-z]{2,4}/gi;
 
                if (data.pagina_web_usuario.match(pattern) != null) {
                    return true;
                } else {
                    return false;
                }
            }
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
