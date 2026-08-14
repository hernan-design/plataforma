/**
* Class LikeView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.LikeView = Backbone.View.extend({

        tagName: 'a',
        className: 'TPlikelink inst-color-invert',
        attributes: {
            'href': '#',
            'data-srcparams': {}
        },
        events: {
            'click': 'onILike'
        },

        /**
        * Constructor Method
        */
        initialize: function() {

            //Init Attributes
            this.model = new window.app.LikeModel();
            this.$countLikes || (this.$countLikes = null);
            this.$modalLogin = $('#modal-login');
            this.$modalBase = $('#modal-base-tp');
            this.counterLikes = 0;

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'destroy', this.unLike );
            this.listenTo( this.model, 'request', this.requestLike );
            this.listenTo( this.model, 'sync', this.responseLike );

            if( window.Misc.checkSession(false) ) {
                // fetch one like
                this.fetchOneLike();
            }
        },


        /*
        * Render View Element
        */
        render: function () {

            var attributes = this.model.toJSON();
         
            // overwrite id attribute of model
            if( this.model.changed.success !== undefined ) {
                this.model.idAttribute = 'codigo_like';
                this.model.set( {codigo_like: this.model.get('codigo_like')}, {'silent':true} );
            }

            if( !this.$el.hasClass('no-text-like') ) {
                this.$el.html( attributes.value_txt );
            }else{
                this.$el.toggleClass('ilike', !!attributes.auth_like);
            }

            this.$el.attr('title', attributes.value_txt);

            if( this.model.id !== undefined ){
                this.$el.data('srcparams', attributes.srcparams);
            }else{
                this.$el.data('srcparams', this.attributes['data-srcparams']);
            }

            return this;
        },

        /**
        * remove like of the collection
        * @param Object model
        * @param Object collection
        * @param Object opts
        */
        removeOne: function (model, collection, opts) {

            this.model.destroy( {wait:true} );
        },

        /**
        * refresh count likes
        */
        refreshCountLikes: function () {

            if(typeof this.$countLikes !== 'undefined' && this.$countLikes.length) {
                this.$countLikes.html( this.counterLikes || 0 );
            }
        },

        /**
        * I Like or Unlike event
        */
        onILike: function (e) {
            e.preventDefault();
            // check out if there is session to like that
            if( window.Misc.checkSession(false) ) {
                var data = {},
                    _this = this;

                data.srcparams = this.$el.data('srcparams');
                data._token = this.$el.data('csrf-token');
                data.auth_like = !this.model.get('auth_like');

                if( !this.$el.hasClass('disabled') ) {
                    if( this.model.changed.codigo_like !== undefined && this.model.get('auth_like') === true ) {
                            this.model.destroy({
                                processData: true,
                                data: data,
                                success: function (model, resp) {
                                    if(resp.success !== undefined) {
                                        if(resp.success) {
                                            _this.counterLikes = resp.contador_like;
                                            _this.refreshCountLikes();

                                            _this.model.clear({silent:true});
                                            _this.model.set( 'value_txt', resp.value_txt );

                                        }else {
                                            ++_this.counterLikes;
                                            _this.refreshCountLikes();

                                            _this.model.set( 'auth_like', true );
                                        }
                                    }

                                    _this.$el.removeClass('disabled');
                                },
                                error: function (model, resp) {
                                    ++_this.counterLikes;
                                    _this.refreshCountLikes();
                                    _this.model.set( 'auth_like', true );

                                    _this.$el.removeClass('disabled');

                                }
                            });

                    }else {

                        // increment likes counter
                        ++this.counterLikes;
                        this.refreshCountLikes();

                        this.model.save(data, { error: function (model, resp) {
                            --_this.counterLikes;
                            _this.refreshCountLikes();
                            _this.model.set( 'auth_like', false );

                            _this.$el.removeClass('disabled');
                        }});
                    }
                }

            }else{
                this.$modalLogin.foundation('reveal','open');
            }
        },

        /**
        * Unlike
        */
        unLike: function (model, collection, opts) {
            // console.log('Unlike::', model, collection, opts);

            // decrement likes counter
            --this.counterLikes;
            this.refreshCountLikes();
            this.model.set( 'auth_like', false );
        },

        /**
        * fetch one like
        */
        fetchOneLike: function () {

            this.model.idAttribute = 'srcparams';
            this.model.set( {srcparams: this.attributes['data-srcparams']}, {'silent':true} );

            this.model.fetch();
        },

        /**
        * request one like to server
        */
        requestLike: function (target, xhr, opts) {
            this.$el.addClass('disabled');
        },

        /**
        * response one like from server
        */
        responseLike: function (target, resp, opts) {

            if(resp.success) {
                this.counterLikes = parseInt(this.model.get('contador_like'));
                this.refreshCountLikes();
            }

            this.$el.removeClass('disabled');
        }
    });

})(jQuery, this, this.document);
