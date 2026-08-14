/**
* Class AppRouter  of Backbone Router
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.LandingRouter = new( Backbone.Router.extend({
		routes : {
			'': 'index'
		},

		/**
		* Constructor Method
		*/
		initialize : function ( opts ){
			// Initialize landing resources
		},

		/**
		* Start Backbone history
		*/
		start: function () {
			var config = { pushState: true, hashChange: false };

			if( document.domain.search(/(192.168.1.17|localhost)/gi) != '-1' )
				config.root = '/plataforma/public/';

			Backbone.history.start( config );
		},

		// Routes on Landing
		// --------------------
		/**
		* get landing institution
		*/
		index : function(institution) {
			// this.navigate(window.location.pathname.substring(1), {trigger: true, replace: true});
		}
	}) );

})(jQuery, this, this.document);
