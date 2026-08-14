/**
* Class FavoriteView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.FavoriteView = Backbone.View.extend({

		tagName: 'a',
		className: 'TPfavoritelink',
		parameters: {
			'codFavorite': null,
			'favoriteState': false,
			'srcparams': null
		},
		events: {
			'click': 'onChangeState'
		},

		/**
		* Constructor method
		*/
		initialize: function (opts) {
			// Extend parameters custome
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			// Initialize attributes
			this.$modalLogin = $('#modal-login');

			// Events Listener
			this.listenTo( this.model, 'change:favorito_auth', this.render );
			this.listenTo( this.model, 'request', this.requestFavorite );
            this.listenTo( this.model, 'sync', this.responseFavorite );

            this.render();
		},

		/**
		* Render view element
		*/
		render: function () {

			// overwrite id attribute of model
           	if( _.isUndefined(this.model.id) && this.parameters.codFavorite) {

        		this.model.set( {codigo_favorito:this.parameters.codFavorite, favorito_auth:this.parameters.favoriteState} );
           	}

           	if( this.model.get('favorito_auth') ) {
           		this.$el.attr('title', 'Quitar de favoritos');
           	}else {
           		this.$el.attr('title', 'Añadir a favoritos');
           	}

           	// switch favorite state
           	this.$el.toggleClass('on-favorite', this.model.get('favorito_auth') );
		},

		/**
		* on change favorite state
		*/
		onChangeState: function (e) {

			e.preventDefault();

			if( window.Misc.checkSession(false) ) {

				if( !this.$el.hasClass('disabled') ) {
					this.model.save({
		                '_token': $('meta[name="csrf-token"]').attr('content'),
		                'srcparams': this.parameters['srcparams'],
		                'favorito_auth': !this.model.get('favorito_auth')
		            }, {patch: true});
				}

			} else {
				this.$modalLogin.foundation('reveal','open');
			}
		},

		/**
		* request favorite of server
		*/
		requestFavorite: function (target, xhr, opts) {

			this.$el.addClass('disabled');
		},

		/**
        * response favorite of server
        */
		responseFavorite: function (target, resp, opts) {

			this.$el.removeClass('disabled');
		}
	});

})(jQuery, this, this.document);
