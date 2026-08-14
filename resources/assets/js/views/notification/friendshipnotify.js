/**
* Class FriendshipNotifyView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
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

	window.app.FriendshipNotifyView = Backbone.View.extend({
		tagName: 'li',
		className: 'without-read',
		template: _.template( ($('#friendship-notification-tpl').html() || '') ),
		events: {
			'click .toNotifyLink': 'onToLink',
			'click .remove-notify': 'onHide'
		},
		parameters: {

		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){

			// Extend parameters options
			if(opts != undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			// Events Listener
			this.listenTo( this.model, "change", this.render );
			this.listenTo( this.model, 'destroy', this.remove );
			this.listenTo( this.model, 'request', this.loadSpinner);
			// this.listenTo( this.model, 'sync', this.responseServer);
		},

		/**
		* Render View Element
		*/
		render: function () {
			var attributes = this.model.toJSON();

			this.$el.html( this.template(attributes) ).fadeIn('fast');

			if( this.model.attributes.readBy ) this.$el.toggleClass('without-read', !(!!this.model.get('readBy').length) );
			if( this.model.attributes.read ) this.$el.toggleClass('without-read', !this.model.get('read') );


			// Initialize renference to elements

			// overwrite model id attribute
			// if( this.model.attributes.codigo_pregunta_encuesta ) {

			//     this.model.idAttribute = 'codigo_pregunta_encuesta';
			//     this.model.set( {'codigo_pregunta_encuesta': this.model.get('codigo_pregunta_encuesta')}, {'silent':false} );
			// }

			return this;
		},

		/*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('normal', function (){
                _this.$el.remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {

            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        },

		/**
		* go to notification link
		*/
		onToLink: function (e) {
			// e.preventDefault();

			var $toLink = $( e.currentTarget );

			if( (this.model.attributes.readBy && !this.model.get('readBy').length) || !this.model.get('read') ){
				this.model.save({}, {patch:true, wait:true, success: function (model, resp, opts) {

					// window.Misc.redirect( $toLink.attr('href') );
				}});
			}
		},

		/**
		* remove notification
		*/
		onHide: function (e) {
			e.preventDefault();

			var _this = this;

			this.model.destroy( {wait:true} );
		}
	});

	return window.app.FriendshipNotifyView;
}));
