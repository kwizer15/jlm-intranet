/**
 * ModalForm plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* MODALFORM PUBLIC CLASS DEFINITION
	 * ================================= */

	var ModalForm = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.modalForm.defaults, options)
		this.listen()
	}

	ModalForm.prototype = {
			constructor: ModalForm

			, listen : function() {
				var id = "#" + this.$element.attr("id") + "_";
				var form = this.$element.parent().parent();
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


	/* ModalForm PLUGIN DEFINITION
	 * =========================== */

	$.fn.modalForm = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('modalForm')
			, options = typeof option == 'object' && option
			if (!data) $this.data('modalForm', (data = new ModalForm(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.modalForm.defaults = {}

	$.fn.modalForm.Constructor = ModalForm

}(window.jQuery);
