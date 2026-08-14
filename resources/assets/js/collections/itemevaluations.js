//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemEvaluationList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('evaluacion.index') );
        },
        model: app.ItemEvaluationModel,

        /**
        * Constructor Method
        */
        initialize : function(){
          //
        }
   });

})(this, this.document);


