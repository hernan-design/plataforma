/**
* Class UserRegistrationItemView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserRegistrationItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#registration-user-course-tpl').html() || '') ),
        events: {
           // 
        },

        /**
        * Constructor Method
        */ 
        initialize : function(){

            //Init Attributes
            this.$wrapperPosts = $('#side-course-students');

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };
            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {;

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )

            return this;
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
