/**
 * TransmitterSeries plugin
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

	var TransmitterSeries = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.transmitterSeries.defaults, options)
		this.listen()
	}

	TransmitterSeries.prototype = {
			constructor: TransmitterSeries

			, listen : function() {
				var id = "#" + this.$element.attr("id") + "_";
				var form = $("#" + this.$element.attr("id")).parent().parent();
				$(id + "quantity," + id + "first").on("change", function(event,ui) {
					if ($(id + "quantity").val() != '' && $(id + "first").val() != '')
					{
						$(id + "last").val(parseInt($(id + "first").val()) + parseInt($(id + "quantity").val()) - 1);
						formatTransmitterNumber($(id + "last"));
					}
					if ($(id + "first").val() != '')
						formatTransmitterNumber($(id + "first"));
				});
				$(id + "last").on("change", function(event,ui) {
					if ($(id + "last").val() != '' && $(id + "first").val() != '')
					{
						$(id + "quantity").val(parseInt($(id + "last").val()) - parseInt($(id + "first").val()) + 1);
						formatTransmitterNumber($(id + "first"));
						formatTransmitterNumber($(id + "last"));
					}
				});
				form.submit(function(){
					$.ajax({
						url: $(this).attr('action'), 
						type: $(this).attr('method'), 
						data: $(this).serialize(),
						success: function(html) {
							if (html == 'reload')
							{
								form.find(".modal-body").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%"></div></div>');
								form.find(".modal-footer").html('');
								location.reload();
							}
							else
							{
								form.find(".modal-body").html(html);
							}
						}
					});
					return false;
				});
			}
		}


	/* TransmitterSeries PLUGIN DEFINITION
	 * =========================== */

	$.fn.transmitterSeries = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('transmitterSeries')
			, options = typeof option == 'object' && option
			if (!data) $this.data('transmitterSeries', (data = new TransmitterSeries(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.transmitterSeries.defaults = {}

	$.fn.transmitterSeries.Constructor = TransmitterSeries

}(window.jQuery);
