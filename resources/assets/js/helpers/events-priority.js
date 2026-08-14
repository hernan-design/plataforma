/**
* @author TuProyecto | Desarrollador: @krobing
* Events ordering by Priority
*/
(function($, window, undefined){


	$.fn.bindNth = function (eTypes, selector, data, fn, index) {
		// Bind event normally.
		this.on(eTypes, selector, data, fn);
		// Move to nth position.
		this.changeEventOrder(eTypes, selector, index);

		return this;
	};

	$.fn.bindFirst = function (eTypes, selector, data, fn) {
		this.bindNth(eTypes, selector, data, fn, 0);

		return this;
	};

	$.fn.changeEventOrder = function (eTypes, selector, newIndex) {
		var that = this;
		// Allow for multiple events.
		$.each(eTypes.split(' '), function (idx, eType) {

			that.each(function () {

				var handlers = $._data(this, 'events')[eType.split('.')[0]];
				// Validate requested position.
				if( handlers ){
					newIndex = Math.min(newIndex, handlers.length - 1);
					handlers.splice(newIndex, 0, handlers.pop());
				}
			});
		});
	};

})(jQuery, this);
