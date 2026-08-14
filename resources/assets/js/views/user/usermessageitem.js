/**
* Class UserMessageItemView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserMessageItemView = Backbone.View.extend({

        tagName: 'article',
        className: 'message-discussion',
        template: _.template( ($('#comment-discussion-tpl').html() || '') ),
        events: {
            'click .on-remove-comment': 'onHide'
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            //Init Attributes
            this.$modalBase = $('#modal-base-tp');

            // Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();

            // assign attribute to the element
            this.$el.attr('data-owner', this.model.get('owner'));

            this.$el.html( this.template(attributes) );

            //Initialize Reference to elements

            return this;
        },

        /**
        * hides contacts user
        */
        onHide: function (e) {
            e.preventDefault();

            this.confirmHide = new app.ConfirmWindow({
                model: this.model,
                parameters: {
                    titleConfirm: 'Eliminar mensaje',
                    template: _.template( ($('#confirm-remove-discussion-tpl').html() || '') ),
                    dataFilter: {
                        'codigo_discucion': this.model.get('codigo_discucion'),
                        'codigo_comentario': this.model.get('codigo_comentario')
                    }
                }
            });
            this.confirmHide.render();
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

            var $formComment = this.$el.parents('#user-discussion-message-wrap').find('#form-comment-discussion');

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
                'wrap': this.$el,
                'direct': true,
                'callback': (function (conf, re, $formReset) {
                    return function () {

                        if( !re.success )
                            window.Misc.showAlertBox( conf );

                        if( re.success ){
                            $formReset[0].reset();
                            $formReset.find(':submit').removeClass('disabled');
                        }
                    }
                })(this.configAlert, resp, $formComment)
            });
        }
    });

})(jQuery, this, this.document);
