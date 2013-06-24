/**
 * AskQuote plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* QUOTE PUBLIC CLASS DEFINITION
	 * ================================= */

	var AskQuote = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.askquote.defaults, options)
		this.listen()
	}

	AskQuote.prototype = {
			constructor: AskQuote

			, listen : function() {
				var src = this.options.autoSourceDoor;
					$("#askquote_site").on("autocompletechange", function(event,ui) {
						console.log(ui.item);
						$.post( src, { id_site : ui.item.id }, function(data){
							$("#askquote_door").empty();
							$("#askquote_door").append('<option value=""></option>');
							$.each(data, function(key,val) {
								$("#askquote_door").append('<option value="' + val.id + '">' + val.string + '</option>');
							})
					},'json')
				})
			}
	}


	/* QUOTE PLUGIN DEFINITION
	 * =========================== */

	$.fn.askquote = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('askquote')
			, options = typeof option == 'object' && option
			if (!data) $this.data('askquote', (data = new AskQuote(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.askquote.defaults = {
			autoSource:'',
			autoSourceDoor:'',
	}

	$.fn.askquote.Constructor = AskQuote

}(window.jQuery);
