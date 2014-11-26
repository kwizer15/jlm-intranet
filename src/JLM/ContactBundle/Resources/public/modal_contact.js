/**
 * ModalForm plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* FormModal PUBLIC CLASS DEFINITION
	 * ================================= */

	var FormModal = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.formModal.defaults, options)
		this.listen()
	}

	FormModal.prototype = {
			constructor: FormModal

			, listen: function() {
				this.$element.on('click', this, this.load);
				
			}
				
			, load: function(e) {
				e.preventDefault();
				$.get(e.data.options.urlModal, function(data) {
					$('#modals').html(data);
					var $modal = $('#modals form');
					$modal.modal()
					  .on('submit', $modal, e.data.modalsubmit)
					  .on('hidden', e.data.modalclose)
					  .modal('show')
				}, 'html');

				return false;
			}
			
			, modalclose: function(e) {
				e.preventDefault();
				$(this).modal('hide').parent().empty();
			}

			, modalsubmit: function(e) {
				e.preventDefault();
				$.ajax({
					url: $(this).attr('action'),
					type: $(this).attr('method'),
					dataType: 'html',
					data: $(this).serialize(),
					success: function(data) {
						var $m = e.data.find(".modal-body");
						$m.html(data);
					}
				});
				
				return false;
			}
	}


	/* FormModal PLUGIN DEFINITION
	 * =========================== */

	$.fn.formModal = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('formModal')
			, options = typeof option == 'object' && option
			if (!data) $this.data('formModal', (data = new FormModal(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.formModal.defaults = {
			urlModal : '',
			jsLoader : function() {}
	}

	$.fn.formModal.Constructor = FormModal

}(window.jQuery);
