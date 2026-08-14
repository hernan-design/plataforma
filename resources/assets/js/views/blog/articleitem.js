/**
* Class ArticleItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ArticleItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#article-item-list-tpl').html() || '') ),
        events: {
            'click .show-user-likes': 'onShowUserLikes'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes
            this.$modalBase = $('#modal-base-material');

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Trigger plugins function
            if( typeof window.initComponent.configEllipsis == 'function' && _.has($.fn, 'dotdotdot') )
                window.initComponent.configEllipsis();

            return this;
        },

        /**
        * show user likes
        */
        onShowUserLikes: function (e) {

            e.preventDefault();

            // to render view user likes
            this.viewUserLikes = new window.app.UserLikesListView({
                parameters: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });
            this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
            this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

            this.$modalBase.foundation('reveal','open');
        }
    });

})(jQuery, this, this.document);
