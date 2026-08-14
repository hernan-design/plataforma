/**
* Class surveyQuestionsList extends of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.surveyQuestionsList = Backbone.PageableCollection.extend({

        modelId: function(attrs) {
            return attrs.codigo_pregunta_encuesta;
        },
        model: function (attrs, options) {
            var newModel = Backbone.Model.extend( {idAttribute : 'codigo_pregunta_encuesta'} );

            return new newModel(attrs, options);
        },
        mode: 'client',
        url: function () {
            return window.Misc.urlFull( Route.route('encuesta.index') );
        },

        state: {
            firstPage: 1,
            pageSize: 5 //number of records to show by page
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
           Makes a Backbone.Collection that contains all the pages || override.

           @private
           @param {Array.<Object|Backbone.Model>} models
           @param {Object} options Options for Backbone.Collection constructor.
           @return {Backbone.Collection}
        */
        _makeFullCollection: function (models, options) {

          var properties = ["url", "model", "sync", "comparator", "modelId"];
          var thisProto = this.constructor.prototype;
          var i, length, prop;

          var proto = {};
          for (i = 0, length = properties.length; i < length; i++) {
            prop = properties[i];
            if (!_.isUndefined(thisProto[prop])) {
              proto[prop] = thisProto[prop];
            }
          }

          var fullCollection = new (Backbone.Collection.extend(proto))(models, options);

          for (i = 0, length = properties.length; i < length; i++) {
            prop = properties[i];
            if (this[prop] !== thisProto[prop]) {
              fullCollection[prop] = this[prop];
            }
          }

          return fullCollection;
        }

        /**
        * order by
        */
        // comparator: function(question){

        //     // ordenamos por el atributo position
        //     if( question.get('posicion') )
        //         return question.get('posicion');
        // }
   });

})(this, this.document);
