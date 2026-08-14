/**
* Class UserWallPostView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserWallPostView = Backbone.View.extend({

        tagName: 'article',
        className: 'wall-post-box',
        template: _.template( ($('#wall-post-tpl').html() || '') ),
        events: {
            'submit .form-comment-post': 'onStoreComment',
            'click .show-comments-post': 'onShowComments',
            'click .show-comment-field': 'onShowField',
            'click .wall-post-hide': 'onHide',
            'click .post-footer-box .show-user-likes': 'onShowUserLikes'
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            //Init Attributes
            this.$wrapperPosts = $('#wall-posts-wrap');
            this.collectionComments = new window.app.WallCommentsList();
            this.confirmHide = new app.WallPostConfirmHideView({ model:this.model });

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
            this.listenTo( this.model, "change:contador_comentario", this.incrementComments );
            this.listenTo( this.model, 'destroy', this.remove );
            // this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collectionComments, 'add', this.countNewComment );
        },

        /*
        * Render View Element
        */
        render: function () {

            if( this.model.id === undefined || this.model.changed.contador_comentario !== undefined )
                return this;

            var attributes = this.model.toJSON();
            attributes.metadatos_muro = JSON.parse( attributes.metadatos_muro );
            this.$el.html( this.template(attributes) )
                    .fadeIn('slow');

            //Initialize Reference to elements
            this.$commentField = this.$( '.comment-post-field' );
            this.$formComment = this.$('.form-comment-post');
            this.$dataCountComments = this.$('.data-count-comments');
            this.$commentsList = this.$('.comments-post-list');
            this.$containerMore = this.$('.container-more');
            this.$likeLink = this.$('.post-footer-box .data-post-share.TPlikelink');
            this.$countLikes = this.$('.post-footer-box .data-count-likes');
            if( _.has($.fn, 'foundation') )
                this.$el.foundation('abide');

            // link show more
            window.Misc.showMore({'container': this.$containerMore, 'maxlen': 300});

            //to render view of the comment list
            this.viewComments = new window.app.UserWallCommentListView({
                el: this.$commentsList,
                collection: this.collectionComments,
                attributes: {
                    'codigo_muro': this.model.id
                }
            });
            
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
                'callback': (function (conf, re, $wrap, wallPostCreate) {
                    return function () {
                        $wrap.find('#spinner-load-posts').remove();
                        
                        if( !re.success )
                            window.Misc.showAlertBox( conf );

                        if( re.success ){
                            // console.log( wallPostCreate );

                            if( wallPostCreate ){
                                var $formReset = wallPostCreate.$formPostWall;
                                var $fieldeditor = wallPostCreate.$wysiwyg;
                                var editor = $fieldeditor.data('wysiwyg').wysiwygeditor.getElement();

                                editor.innerHTML = '';

                                $formReset[0].reset();
                                $formReset.find('.chosen-select')
                                          .trigger("chosen:updated");
                            }

                            window.app.AppRouter.urlMetaDataModel.destroy();
                        }
                    }
                })(this.configAlert, resp, this.$wrapperPosts, this.wallPostCreate)
            });
        },

        /**
        * Show comments
        */
        showField: function () {

            // this.$commentField.slideToggle(100);
            this.$el.find('.post-comments-box').slideToggle(100);

            if( !this.collectionComments.length ){

                this.viewComments.render();

                this.collectionComments.fetch({
                    reset: true,
                    data:{'codigo_muro': this.viewComments.attributes.codigo_muro }
                });

                return;
            }

            this.viewComments.render();
        },

        /**
        * Count the new commnet
        */
        countNewComment: function () {
            var count = parseInt( this.model.get('contador_comentario') );
            count++;

            this.model.set( {'contador_comentario': count} );
        },

        /**
        *  increment comments value
        */
        incrementComments: function (model, value) {
            this.$dataCountComments.html( value );
        },

        /**
        * Event for store a comment
        */
        onStoreComment: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            data.texto_comentario = window.Misc.stripTags(data.texto_comentario, 'a');
            data.texto_comentario = data.texto_comentario.replace(/(\&nbsp;|<[a-z\?\!\/]([a-z0-9\_\:\.])*(\s[^>]*)?(>|$))/gi, ' $&');
            data.texto_comentario = window.Misc.urlWrapLink(data.texto_comentario);
            this.collectionComments.trigger('store', data, e.target);
        },

        /**
        * Show comments post
        */
        onShowComments: function (e) {
            e.preventDefault();

            this.showField();
        },

        /**
        * Show comment field
        */
        onShowField: function (e) {
            e.preventDefault();

            this.showField();
            this.$formComment.find('.wysiwyg-commentpost').focus();
        },

        /**
        * hides wall post
        */
        onHide: function (e) {
            e.preventDefault();
            this.confirmHide.render();        
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
