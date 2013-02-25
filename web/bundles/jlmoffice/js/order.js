/**
 * Order plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* ORDER PUBLIC CLASS DEFINITION
	 * ================================= */

	var Order = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.order.defaults, options)
		this.listen()
	}

	Order.prototype = {
			constructor: Order
			, listen : function() {
				$("#order_place").attr('data-source',this.options.autoSource)
				.autocomplete({
					source: function(request,response){
						request.repository = 'JLMModelBundle:Door';
						return $.post(
								this.element.attr('data-source'),
								request,
								function( data ) { response( data ); },
								'json'
						);
					}
				, select: function (event, ui) {
					$("#order_place").val(ui.item.doorCp);
					return false;
				}
				});
				this.$element.find("#order_lines > tr").on('change',$.proxy(this.total,this)).orderline({
					autoSource:this.options.autoSource,
				});
				$(".newline").on('click',$.proxy(this.newline,this));

				$("#order_lines").sortable({
					update: function(e,ui) {
						$.each($(this).children(),function(key,value) {
							var posid = "#" + $(value).attr('id') + "_position";
							$(posid).val(key);
						})
					}
				});
			}
	, newline : function(e){
		e.stopPropagation()
		e.preventDefault()
		var lineList = $("#order_lines");
		var newWidget = lineList.attr('data-prototype');
		newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
		lineList.append(newWidget);
		$("#order_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).orderline({
			autoSource:this.options.autoSource
		});
		// Valeurs par défaut
		$("#order_lines_" + this.options.lineCount + "_position").val(this.options.lineCount);
		$("#order_lines_" + this.options.lineCount + "_quantity").val(1);
		this.options.lineCount++;
		return this;
	}
	}

	/* ORDER PLUGIN DEFINITION
	 * =========================== */

	$.fn.order = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('order')
			, options = typeof option == 'object' && option
			if (!data) $this.data('order', (data = new Order(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.order.defaults = {
			autoSource:'',
	}

	$.fn.order.Constructor = Order

}(window.jQuery);

/*************************************************************************
 * OrderLine plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* ORDERLINE PUBLIC CLASS DEFINITION
	 * ================================= */

	var OrderLine = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.orderline.defaults, options)
		this.listen()
	}

	OrderLine.prototype = {
			constructor: OrderLine

			, listen : function() {
				var line = "#" + this.$element.attr('id');
				this.$element.find(".remove-line").on('click',$.proxy(this.remove,this));

				$(line + "_reference").attr('data-source',this.options.autoSource)
				.autocomplete({
					source: function(request,response){
						request.repository = 'JLMModelBundle:Product';
						request.action = 'Reference';
						return $.post(
								this.element.attr('data-source'),
								request,
								function( data ) { response( data ); },
								'json'
						);
					}
				, select: function (event, ui) {
					var id = "#" + this.id.replace("reference","");
					$(id + 'reference').val(ui.item.reference);
					$(id + 'designation').val(ui.item.designation);
					return false;
				}
				});
				$(line + "_designation").attr('data-source',this.options.autoSource)
				.autocomplete({
					source: function(request,response){
						request.repository = 'JLMModelBundle:Product';
						request.action = 'Designation';
						return $.post(
								this.element.attr('data-source'),
								request,
								function( data ) { response( data ); },
								'json'
						);
					}
				, select: function (event, ui) {
					var id = "#" + this.id.replace("designation","");
					$(id + 'reference').val(ui.item.reference);
					$(id + 'designation').val(ui.item.designation);
					return false;
				}
				});
			}
	, remove : function(e) {
		e.stopPropagation()
		e.preventDefault()
		this.$element.fadeOut(500,function(){
			$(this).remove();
		});
		return this;
	}
	}
	/* ORDERLINE PLUGIN DEFINITION
	 * =========================== */

	$.fn.orderline = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('orderline')
			, options = typeof option == 'object' && option
			if (!data) $this.data('orderline', (data = new OrderLine(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.orderline.defaults = {
			autoSource:'',
			line:0,
	}

	$.fn.orderline.Constructor = OrderLine

}(window.jQuery);
