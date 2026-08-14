/**
* @author TuProyecto | Desarrollador: @dropecamargo
* Events mediaElementPlayer woopra analytics
*/
(function($, window, document, undefined) {

	$.extend(MediaElementPlayer.prototype, {
		buildwoopraanalytics: function(player, controls, layers, media) {
			var timeInterval = 30,
				counter, time, currentInterval, lastInterval = 0;

            _.extend(media, Backbone.Events);

			media.addEventListener('timeupdate', function(e) {
				if (typeof woopra != 'undefined') {
					time = parseInt(player.getCurrentTime());
					counter = Math.ceil(time / timeInterval);
	                currentInterval = timeInterval * counter;

	                if ( (time === currentInterval) && (lastInterval != currentInterval) ) {
						lastInterval = time;
						// Call trigger trackViewed
                        media.trigger('trackViewed', timeInterval,
                        	window.Misc.formatTime(currentInterval - timeInterval) + " - " + window.Misc.formatTime(currentInterval)
                       	);
	                }
	           	}
			}, false);
		}
	});

})(jQuery, this, this.document);
