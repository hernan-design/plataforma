/**
* Class OfferModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

	app.OfferModel = Backbone.Model.extend({

		urlRoot: function () {
			return window.Misc.urlFull( Route.route('marketplace.compras.offer.index') );
		},
		idAttribute: 'codigo_compra',
		defaults: {
			'valor_total_compra': 0,
			'unidades': 0
		}
	});

})(this, this.document);
