/**
* Class AttachmentModel extends of Backbone Model
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	app.AttachmentModel = Backbone.Model.extend({

		// urlRoot: function () {
		//     return window.Misc.urlFull( Route.route('adjunto.index') );
		// },
		idAttribute: 'codigo_adjunto',
		defaults: {
			'codigo_adjunto': null,
			'direccion_adjunto': '',
			'owner': false
		},

		/**
		* Constructor Method
		* @param Object attrs, model attributes
		* @param Object opts, model Options
		*/
		initialize: function(attrs, opts){
			//Init attributes
		},

		/**
		* validate attributes model in the change
		* @param Object. modified attributes model
		*/
		validate: function (attrs) {
			var err = new Error();

			// if( ! attrs.direccion_adjunto.length ){
			//     err.message = "No hay items.";
			//     return err;
			// }
		},

		/**
		* JSON object to String
		*/
		toStrJSON: function () {
			return JSON.stringify( this );
		},

		/**
		* reset attributes in default
		*/
		resetAttrs: function (opts) {
			opts || (opts = {});

			var setAttrs = {};
			setAttrs[this.idAttribute] = null;

			this.clear({silent:true});
			_.extend(setAttrs, this.defaults);
			this.set( setAttrs, opts );
		}
	});

})(this, this.document);
