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
					$newContent = $('<div/>').html(data);
					$('#modals').append($newContent);
					var $modal = $newContent.find('form.modal');
					$modal.modal()
					  .on('submit', e.data, e.data.modalsubmit)
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
						e.data.options.closure(data);
						e.data.modalclose(e);
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
			closure : function(data, closer) {
				$("#modals .modal-body").html(data);
			//	$("#modals .modal-footer [type=submit]").remove();
			}
	}

	$.fn.formModal.Constructor = FormModal

}(window.jQuery);
