/**
* Class ParticipantsProgramUserItemView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ParticipantsProgramUserItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#participant-program-item-tpl').html() || '') ),
        events: {
           //
        },
        parameters: {
            'orientacion': ''
        },

        /**
        * Constructor Method
        */ 
        initialize : function(opts){

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.userNetworkModel = new app.UserNetworkModel();
           
            this.$wrapperPosts = $('#friends-wrap');
            this.$modalBase = $('#modal-base-tp');

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };
            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
            
            if( window.Misc.checkSession(false)) {    
                if(!this.model.get('owner') && this.parameters['orientacion'] == window._tp.orientationProgram.user){
                    this.buttonsConnect = this.$('#buttons-connect-friendship');
                    this.userNetworkModel.set({'seg_codigo_usuario': this.model.get('srcparams'), 'nickname_usuario': this.model.get('nickname_usuario'), 'state_friendship' : this.model.get('state_friendship'), 'owner': true });
                    this.buttonsFriendly = new app.UserButtonsFriendlyView({
                        el: this.buttonsConnect,
                        model: this.userNetworkModel,
                        parameters: {
                            'type_action': ''
                        }
                    });
                }    
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
        loadSpinner: function () {

            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            // response success or error
            var text = !resp.success ? resp.errors: '',
                type = resp.success ? 'success' : 'alert';


            if( _.isObject(resp.errors) ){

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
                'wrap': this.$wrapperPosts,
                'direct': false,
                'callback': (function (conf, re, $wrap) {
                    return function () {
                        $wrap.find('#spinner-load-posts').remove();
                        
                        if( !re.success )
                            window.Misc.showAlertBox( conf );

                        if( re.success ){
                        $wrap.find('#spinner-load-posts').remove();
                        }
                    }
                })(this.configAlert, resp, this.$wrapperPosts) 
            });
        }
    });

})(jQuery, this, this.document);

