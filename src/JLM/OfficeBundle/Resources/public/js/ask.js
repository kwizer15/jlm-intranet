/**
 * AskQuote plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* QUOTE PUBLIC CLASS DEFINITION
	 * ================================= */

	var Ask = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.ask.defaults, options)
		this.listen()
	}

	Ask.prototype = {
			constructor: Ask

			, listen : function() {
				var src = this.options.autoSourceDoor;
				var id = "#" + this.$element.attr("id") + "_";
				$(id + "site").on("autocompleteselect", function(event,ui) {
					console.log(ui.item);
					console.log('ok');
					$.getJSON('/app_dev.php/model/trustee/trustee.json',{'id':ui.item.trustee},
						function(data) {
						console.log(id);
						  $(id + "trustee").select2("data",{id: data.id, text: data.contact.name});
						}
					);
				})
			}
	}


	/* QUOTE PLUGIN DEFINITION
	 * =========================== */

	$.fn.ask = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('ask')
			, options = typeof option == 'object' && option
			if (!data) $this.data('ask', (data = new Ask(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.ask.defaults = {
			autoSource:'',
	}

	$.fn.ask.Constructor = Ask

}(window.jQuery);
