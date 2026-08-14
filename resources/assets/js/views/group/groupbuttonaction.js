/**
* Class GroupButtonActionsView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GroupButtonActionsView = Backbone.View.extend({
        className: 'icons-connect',
        template: _.template( ($('#buttons-group-tpl').html() || '') ),
        events: {
            'click #link-join-group': 'onToJoin',
            'click .cancel-request-group': 'onToCancel'
        },
        parameters: {
            'owner': '',
            'statejoin': '',
            'url_nickname': '',
            'codigo_usuario': '',
            'wrapperTeamGroup': '',
            'collectiongroup': ''
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

            this.$modalBase = $('#modal-base-tp');

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            this.render();
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            attributes.url_nickname = this.parameters['url_nickname'];
            attributes.nombre_categoria_clase_espacio = this.parameters['nombre_categoria_clase_espacio'];
            attributes.owner = this.parameters['owner'];

            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') ) {
                $(document).foundation('dropdown', 'reflow');
            }

            this.$modalBase.find('.inner-title-modal').html( this.$('#link-join-call').attr('area-title') );

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
                'direct': true,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(!_.isUndefined(re.success)) {
                            if( !re.success ){
                                window.Misc.showAlertBox( conf );
                            }
                        }
                        if(re.success){
                            if( _this.parameters['collectiongroup'] instanceof Backbone.Collection )
                                _this.parameters['collectiongroup'].trigger('getdata');
                        }
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * Event join to group
        */
        onToJoin: function (e) {

            e.preventDefault();
            switch(this.parameters['orientacion_clase_espacio']) {
                case window._tp.getOrientationSpace['user']:
                   var data = {
                        'codigo_usuario': this.parameters['codigo_usuario'],
                        'statejoin': this.model.get('statejoin'),
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    };
                    this.model.save( data, {patch: true, wait:true} );

                    break;
                case window._tp.getOrientationSpace['project']:
                    var data = {
                        'codigo_proyecto': this.parameters['codigo_proyecto'],
                        'statejoin': this.model.get('statejoin'),
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    };
                    this.model.save( data, {patch: true, wait:true} );
                    break;
                default:
                    // default 
            }
        },

        /**
        * Cancel group project
        */
        onToCancel: function (e) {

            e.preventDefault();

            var data = {
                'codigo_usuario': this.parameters['codigo_usuario'],
                'statejoin': this.model.get('statejoin'),
                'cancel_request': true,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
        }

    });

})(jQuery, this, this.document);
