/**
* Class UserWallCommentView of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserWallCommentView = Backbone.View.extend({

        tagName: 'article',
        className: 'user-comment',
        template: _.template( ($('#comment-post-tpl').html() || '') ),
        events: {
            'click .comment-icons-list .show-user-likes': 'onShowUserLikes'
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.likeList = new window.app.LikeList();
            this.$modalBase = $('#modal-base-material');
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
            this.$el.html( this.template(attributes) );

            //Initialize Reference to elements
            this.$likeLink = this.$('.TPlikelink');
            this.$countLikes = this.$('.data-count-likes');
            
            //to render like link for post
            this.likeLinkView = new window.app.LikeView({
                el: this.$likeLink,
                collection: this.likeList,
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });
            this.likeLinkView.$countLikes = this.$countLikes;

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
        responseServer: function (model, resp, opts) {

            var $formComment = this.$el.parents('.post-comments-box').find('.form-comment-post');
            
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
                            $formReset.find('.chosen-select')
                                      .trigger("chosen:updated");
                        }
                    }
                })(this.configAlert, resp, $formComment)
            });
        },

        /**
        * show user likes
        */
        onShowUserLikes: function (e) {
            e.preventDefault();

            // to render view user likes
            this.viewUserLikes = new window.app.UserLikesListView({
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });
            this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
            this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

            this.$modalBase.foundation('reveal','open');
        }
    });

})(jQuery, this, this.document);
