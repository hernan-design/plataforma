/**
* Class UserNoteItemView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserNoteItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#note-post-tpl').html() || '') ),
        events: {
            'click .note-post-hide': 'onHide'
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            //Init Attributes
            this.$wrapperPosts = $('#side-course-notes');
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
        render: function () {;

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) )

            this.$containerMore = this.$('.container-more');
            
            // link show more
            window.Misc.showMore({'container': this.$containerMore, 'maxlen': 120});

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
        },

        /**
        * hides notes post
        */
        onHide: function (e) {
            e.preventDefault();

            this.model.destroy({
                processData: true,
                wait: true,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content') 
                }
            });
        }
    });

})(jQuery, this, this.document);
