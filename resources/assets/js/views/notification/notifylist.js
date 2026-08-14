/**
* Class NotifyList extends of Backbone View
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

	window.app.NotifyViewList = Backbone.View.extend({
		el: '.container-notifications',
		events: {
			'opened.fndtn.dropdown': 'onOpened'
		},
		parameters: {
			'NotifyView': window.app.GeneralNotifyView,
			'renderTemplate': 'template'
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// Extend parameters options
			if(opts != undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			this.$noResults = this.$('.no-results-filter');
			this.$wrapperData = this.$('.notifications-list');

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo(this.collection, 'add', this.addOne);
			this.listenTo(this.collection, 'reset', this.addAll);

			this.on('beforeRender', this.beforeRender);
			this.on('afterRender', this.afterRender);

			this.collection.fullCollection = null;
			this.collection.switchMode('client', {fetch:false, resetState:true, models: this.collection.models} );

			this.collection.getFirstPage();

			// hide no results message
            if( this.collection.length ){
                this.$noResults.css('display', 'none');
                this.$noResults.toggleClass('hidesoft', !(!!this.collection.length));
            }
		},

		/*
		* Render View Element
		*/
		render: function(){
			//
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			// code goes here
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {
			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {

            // refresh plugins
            if(window.initComponent && typeof window.initComponent.configEllipsis === 'function' && _.has($.fn, 'dotdotdot')) {
                window.initComponent.configEllipsis();
            }
		},

		/**
		* Render view notification by model
		* @param Object question Model instance
		*/
		addOne: function (notificationModel) {
			var renderTemplate = this.parameters.renderTemplate;

			switch( notificationModel.get('type') ) {
				case window._tp.typeNotify['like']: renderTemplate = 'templateLike'; break;
				case window._tp.typeNotify['favorite']: renderTemplate = 'templateFavorite'; break;
			}

			var view = new this.parameters.NotifyView({
				model: notificationModel,
				parameters: {
					renderTemplate: renderTemplate
				}
			});
			this.$wrapperData.append( view.render().el );

            if(this.collection.indexOf(notificationModel) >= (this.collection.length-1) ) {
                this.ready();
            }
		},

		/**
		* Render all view question of the collection
		*/
		addAll: function () {

			if( !this.collection.length ){
                this.$noResults.fadeIn('fast');
                this.$noResults.toggleClass('hidesoft', !(!!this.collection.length));
            }

			var hasMore = this.collection['fullCollection'].length >= this.collection.state.pageSize;

			// this.$('.settings-bottom-notificication').toggleClass( 'hidesoft', !hasMore );
			// this.$el.toggleClass('hidesoft', !(!!this.collection.length) );

			$(window).scrollTop(0);
			this.$wrapperData.html('');

			this.collection.forEach( this.addOne, this );
		},

		/**
		*
		*/
		onOpened: function (e) {

			// console.log( 'onOpened::', e );

			this.$el.siblings('.notification-notify')
					.find('.quantity-value')
					.fadeOut('fast');
		}
	});

	return window.app.NotifyViewList;
}));
