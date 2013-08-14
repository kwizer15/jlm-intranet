/**
 * Transmitter plugin
 */

function formatTransmitterNumber(object) {
	var number = 0;
	number = object.val() + '';
	for (var i = number.length; i < 6; i++) {
		number = '0' + number;
	}
	object.val(number);
}

!function($){

	"use strict"; // jshint ;_;

	/* QUOTE PUBLIC CLASS DEFINITION
	 * ================================= */

	var Transmitter = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.transmitter.defaults, options)
		this.listen()
	}

	Transmitter.prototype = {
			constructor: Transmitter

			, listen : function() {
				var id = "#" + this.$element.attr("id") + "_";
				var form = this.$element.parent().parent();
				$(id + "number").on("change", function(event,ui) {
					formatTransmitterNumber($(id + "number"));	
				});
				form.on('submit', function(){
					
					$.ajax({
						url: form.attr('action'), 
						type: form.attr('method'), 
						data: form.serialize(),
						success: function(html) {
							if (html == 'reload')
							{
								form.find(".modal-body").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%"></div></div>');
								form.find(".modal-footer").html('');
								location.reload();
							}
							else
								form.find(".modal-body").html(html);
						}
					});
					return false;
				});
			}
		}


	/* Transmitter PLUGIN DEFINITION
	 * =========================== */

	$.fn.transmitter = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('transmitter')
			, options = typeof option == 'object' && option
			if (!data) $this.data('transmitter', (data = new Transmitter(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.transmitter.defaults = {}

	$.fn.transmitter.Constructor = Transmitter

}(window.jQuery);
