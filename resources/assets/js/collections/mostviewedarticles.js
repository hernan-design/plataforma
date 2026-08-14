/**
* Class MostViewedArticlesList extends of Backbone Collection
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MostViewedArticlesList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('blog.index') );
        },
        model: app.BlogArticleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);


