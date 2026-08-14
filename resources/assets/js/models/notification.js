/**
* Class NotificationModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina & @krobing
* @link http://TuProyecto.com
*/

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

	window.app.NotificationModel = Backbone.Model.extend({

		urlRoot: function () {
		    return window.Misc.urlFull( Route.route('notificaciones.index') );
		},
		idAttribute: '_id',
		defaults: {
		    'title': '',
		    'content': '',
		    'image': '',
		    'created': ''
		},

		/**
		* Constructor Method
		* @param Object attrs, model attributes
		* @param Object opts, model Options
		*/
		initialize: function(attrs, opts){
		    //
		},

		/**
		* validate attributes model in the change
		* @param Object. modified attributes model
		*/
		validate: function (attrs) {

		}
	});

	return window.app.NotificationModel;
}));
