/**
* Class UserProductItemView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserProductItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#user-product-item-list-tpl').html() || '') ),
        events: {
        },
        dataFilter: {},

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes
            this.favoriteModel = new app.FavoriteModel();

            // Events Listener
            this.listenTo( this.model, "change", this.render ); 
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // instance favorite
            this.favoriteView = new app.FavoriteView({
                el: this.$('.post-favorite-icon.TPfavoritelink'),
                model: this.favoriteModel,
                parameters: {
                    codFavorite: this.model.get('codigo_favorito'),
                    favoriteState: this.model.get('favorito_auth'),
                    srcparams: this.model.get('srcparams')
                }
            });
            
            return this;
        }
    });

})(jQuery, this, this.document);
