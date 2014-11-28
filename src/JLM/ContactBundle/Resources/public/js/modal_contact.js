/**
 * ModalForm plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* FormModal PUBLIC CLASS DEFINITION
	 * ================================= */

	var FormModal = function (element, options) {
		this.$element = $(element)
		this.$modal = undefined
		this.options = $.extend({}, $.fn.formModal.defaults, options)
		this.listen()
	}

	FormModal.prototype = {
			constructor: FormModal

			, listen: function() {
				this.options.urlModal = this.$element.attr('href');
				this.$element.on('click', this, this.load);
			}
				
			, load: function(e) {
				e.preventDefault();
				console.log(e.data.options.urlModal);
				$.get(e.data.options.urlModal, function(data) {
					$newContent = $('<div/>').html(data);
					$('#modals').append($newContent);
					e.data.$modal = $newContent.find('form.modal');
					e.data.$modal.modal()
					  .on('submit', e.data, e.data.modalsubmit)
					  .on('hidden', e.data, e.data.modalclose)
					  .modal('show')
				}, 'html');

				return false;
			}
			
			, modalclose: function(e) {
				e.preventDefault();
				e.data.$modal.modal('hide').parent().remove();
			}

			, modalsubmit: function(e) {
				e.preventDefault();
				console.log('submit');
				$.ajax({
					url: $(this).attr('action'),
					type: $(this).attr('method'),
					dataType: 'json',
					data: $(this).serialize(),
					success: function(data) {
						e.data.options.closure(data);
						e.data.$modal.modal('hide').parent().remove();
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
			closure : function(data) {}
	}

	$.fn.formModal.Constructor = FormModal

}(window.jQuery);
