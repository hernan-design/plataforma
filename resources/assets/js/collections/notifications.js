/**
* Class NotificationList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
window.app || (window.app = {});

//Global App Backbone
window.app || (window.app = {});

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery', 'underscore', 'backbone'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		exports = module.exports = factory(require('jquery'), require('underscore'), require('backbone'));
	} else {
		// Browser globals
		factory(jQuery, window._, window.Backbone);
	}
}(function ($, _, Backbone) {

    window.app.NotificationList = Backbone.PageableCollection.extend({

        mode: 'server',
        modelId: function(attrs) {
            return attrs._id;
        },
        url: function (){
           return window.Misc.urlFull( Route.route('notificaciones.index') );
        },
        model: app.NotificationModel,

        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },

        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
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
        },

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        * order by
        */
        // comparator: function(){
        // },

        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });

	return window.app.NotificationList;
}));
