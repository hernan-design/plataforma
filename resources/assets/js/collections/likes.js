/**
* Class LikeList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.LikeList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('like.index') );
        },
        model: app.LikeModel,
        
        /**
        * Constructor Method
        */
        initialize : function(){
        },
        
        /**
        * get like model by authenticated user
        */
        getModelLikeAuth: function () {
            
            return this.find(function (model) {
                return model.get('auth_like') === true;
            });
        }
   });

})(this, this.document);
