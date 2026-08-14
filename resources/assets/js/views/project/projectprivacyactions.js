/**
* Class ProjectPrivacyActionsView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectPrivacyActionsView = Backbone.View.extend({
        className: 'icons-connect',
        template: _.template( ($('#buttons-privacy-project-tpl').html() || '') ),
        events: {
            'click .edit-privacy': 'onEditPrivacy'
        },
        parameters: {
            'type_action': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

            // Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            // this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            this.render();
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            attributes.type_action = this.parameters['type_action'];

            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') ) {
                $(document).foundation('dropdown', 'reflow');
            }

            return this;
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('normal', function (){
                _this.$el.remove();
            });
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
            // response success or error
            var text = resp.success ? '' : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){
                var listError = '<ul>';
                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';
                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re) {
                    return function () {
                        if(!_.isUndefined(re.success)) {
                            if( !re.success ){
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp)
            });
        },

        /**
        * Event for edit privacy project
        */
        onEditPrivacy: function (e) {

            e.preventDefault();

            var state = e.currentTarget.id;

            var data = {
                'codigo_entidad': this.model.get('codigo_entidad'),
                'codigo_privacidad_contenido': state,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
        }
    });

})(jQuery, this, this.document);
