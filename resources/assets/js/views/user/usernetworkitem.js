/**
* Class UserNetworkItemView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserNetworkItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#user-network-item-tpl').html() || '') ),
        events: {
           'click .contacts-user-hide': 'onHide'
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
            this.$wrapperPosts = $('#contacts-users-friendship');
            this.confirmHide = new app.UserContactConfirmHideView({ model:this.model });
            this.$modalBase = $('#modal-base-tp');

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };
            // Events Listener
            this.listenTo( this.model, 'destroy', this.remove );
        },

        /*
        * Render View Element
        */
        render: function () {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )

            this.$containerMore = this.$('.container-more');
            this.$buttonsConnect = this.$('#buttons-contact-friendship');

            this.buttonsFriendly = new app.UserButtonsFriendlyView({
                el: this.$buttonsConnect,
                model: this.model,
                parameters: {
                    'type_action': 'arrow',
                    'userprofile': this.model.get('seg_codigo_usuario')
                }
            });

            // link show more
            window.Misc.showMore({'container': this.$containerMore, 'maxlen': 300});

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
        },

        /**
        * hides contacts user
        */
        onHide: function (e) {
            e.preventDefault();
            this.confirmHide.render();
        }
    });

})(jQuery, this, this.document);
