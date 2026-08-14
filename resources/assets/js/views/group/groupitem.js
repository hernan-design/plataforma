/**
* Class GroupItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GroupItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#group-item-list-tpl').html() || '') ),
        events: {
            'click .show-user-likes': 'onShowUserLikes',
            'click .link-edit-project': 'onShowEditProject',
            'click .on-remove-project': 'onRemove'
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

             _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            this.likeList = new app.LikeList();

            this.$modalConfirm = $('#modal-base-confirm-tp');
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            //Init Attributes
            this.$modalBase = $('#modal-base-material');

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();

            attributes.dataFilter = this.parameters['dataFilter'];

            this.$el.html( this.template(attributes) );

            // reference to elements
            this.$countLikes = this.$('.data-count-likes');
            this.$likeLink = this.$('.data-post-share.TPlikelink');

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

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

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
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
        },

        /**
        * show form edit project
        */
        onShowEditProject: function (e) {
            e.preventDefault();

            var clase = this.model.get('codigo_clase_emprendimiento');

             switch (clase) {
                case window._tp.getClassEntrepreneurship['idea']:
                    //Init Attributes Idea

                break;
                case window._tp.getClassEntrepreneurship['entrepreneurship']:
                     //Init Attributes Entrepreneurship
                break;
                case window._tp.getClassEntrepreneurship['group']:
                     //Init Attributes Group;

                break;
                case window._tp.getClassEntrepreneurship['company']:
                     //Init Attributes Company
                break;
            }
        },

        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * destroy project
        */
        onRemove: function (e) {

            e.preventDefault();

            this.confirmRemove = new app.ConfirmWindow({
                model:this.model,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres eliminarlo?'
                }
            });
            this.confirmRemove.render();
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {

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
                'wrap': '#user-content, #project-content',
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if( re.success ){
                            // this.$el.dialog('close');
                            return;
                        }
                        _this.remove();
                        window.Misc.showAlertBox( conf );
                    }
                })(this.configAlert, resp, this)
            });
        }
    });

})(jQuery, this, this.document);
