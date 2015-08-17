/**
 * Product plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* PRODUCT PUBLIC CLASS DEFINITION
	 * ================================= */

	var Product = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.product.defaults, options)
		this.listen()
	}

	Product.prototype = {
			constructor: Product

			, listen : function() {
				var prefix = "#" + this.$element.attr('id') + "_";
				this.$unitPrice = this.$element.find(prefix + "unitPrice");
				this.$btnAddSPP = this.$element.find(prefix + "addSupplierPurchasePrice");
				this.$supplierPurchasePrice = this.$element.find(prefix + "supplierPurchasePrices");
				this.$supplierPurchasePrice.children().supplierpurchaseprice({'sellPriceElement':this.$unitPrice});
				this.lastLineNumber = this.$supplierPurchasePrice.children().size();		  
				this.$btnAddSPP.on('click', $.proxy(this.addSupplierLine,this));
			}

	, addSupplierLine : function(e) {
		e.stopPropagation()
		e.preventDefault()
		$line = $(this.$supplierPurchasePrice.attr('data-prototype').replace(/__name__/g, this.lastLineNumber));
		this.$supplierPurchasePrice.append($line);
		$line.supplierpurchaseprice({'sellPriceElement':this.$unitPrice});

		this.lastLineNumber++;
		return this;
	}
	}


	/* PRODUCT PLUGIN DEFINITION
	 * =========================== */

	$.fn.product = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('product')
			, options = typeof option == 'object' && option
			if (!data) $this.data('product', (data = new Product(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.product.defaults = {

	}

	$.fn.product.Constructor = Product

}(window.jQuery);



/**
 * SupplierPurchasePrice plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* SupplierPurchasePrice PUBLIC CLASS DEFINITION
	 * ================================= */

	var SupplierPurchasePrice = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.supplierpurchaseprice.defaults, options)
		this.listen()
	}

	SupplierPurchasePrice.prototype = {
			constructor: SupplierPurchasePrice

			, listen : function() {
				var convert = function($price) { return $price.val().replace(',','.').replace(/[\s]{1,}/g,""); }
				var inputToFloat = function() { return parseFloat(convert(this.$element)); }
				var inputToInt = function() { return parseInt(convert(this.$element)); }
				var prefix = "#" + this.$element.attr('id') + "_";
				this.datas = {
						publicPrice: {
							$element: this.$element.find(prefix + "publicPrice"),
							value: inputToFloat,
							calcul: function() { return this.value() },
							dec: 2
						},   
						discount: {
							$element: this.$element.find(prefix + "discount"),
							value: inputToInt,
							that: this,
							calcul: function() {
								var unitPrice = this.that.datas.unitPrice.value(),
								publicPrice = this.that.datas.publicPrice.value();
								return (1 - (unitPrice / publicPrice)) * 100;
							},
							dec: 0
						},
						unitPrice: {
							$element: this.$element.find(prefix + "unitPrice"),
							value: inputToFloat,
							that: this,
							calcul: function() {
								var publicPrice = this.that.datas.publicPrice.value(),
								discount = this.that.datas.discount.value();
								return publicPrice * (1 - discount / 100);
							},
							dec: 2
						},
						expenseRatio: {
							$element: this.$element.find(prefix + "expenseRatio"),
							value: inputToInt,
							calcul: function() { return this.value() },
							dec: 0
						},
						delivery: {
							$element: this.$element.find(prefix + "delivery"),
							value: inputToFloat,
							calcul: function() { return this.value() },
							dec: 2
						},
						sellPrice: {
							$element: this.options.sellPriceElement,
							value: inputToFloat,
							that: this,
							calcul: function() {
								var unitPrice = this.that.datas.unitPrice.value(),
								expenseRatio = this.that.datas.expenseRatio.value(),
								delivery = this.that.datas.delivery.value(),
								margin = this.that.datas.margin.value();
								return (unitPrice * (1 + expenseRatio / 100) + delivery) * (1 + margin / 100);
							},
							dec: 2
						},
						margin: {
							$element: this.$element.find(prefix + "margin"),
							value: inputToInt,
							that : this,
							calcul: function() {
								var sellPrice = this.that.datas.sellPrice.value(),
								unitPrice = this.that.datas.unitPrice.value(),
								expenseRatio = this.that.datas.expenseRatio.value(),
								delivery = this.that.datas.delivery.value();
								return ((sellPrice / (unitPrice * (1 + expenseRatio / 100) + delivery)) - 1) * 100;
							},
							dec: 0
						}
				};

				this.$btnRemove    = this.$element.find(prefix + "remove");
				this.$btnRemove.on('click', $.proxy(this.remove,this));
				that = this;
				$.each(this.datas, function(index, data) {
					data.$element.on('keyup', $.proxy(that.calcul, that))
				})		
			}

	, remove : function(e) {
		e.stopPropagation()
		e.preventDefault()
		this.options.remove.animation(this.$element, function(){
			$(this).remove();
		});
		return this;
	}

	, calcul : function(e) {
		e.stopPropagation()
		e.preventDefault()
		var toInput = function($element, price, dec) { $element.val(number_format(price,dec,',',' ')); }
		$.each(this.datas, function(index, data) {
			if ($(e.target).attr('id') != data.$element.attr('id')) {
				toInput(data.$element, data.calcul(), data.dec);
			}
		});

		return this;
	}
	}


	/* SupplierPurchasePrice PLUGIN DEFINITION
	 * =========================== */

	$.fn.supplierpurchaseprice = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('supplierpurchaseprice')
			, options = typeof option == 'object' && option
			if (!data) $this.data('supplierpurchaseprice', (data = new SupplierPurchasePrice(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.supplierpurchaseprice.defaults = {
			remove: {
				animation: function($line, action) {
					$line.fadeOut(500, action);
				},
				sellPriceElement: $('div')
			}
	}

	$.fn.supplierpurchaseprice.Constructor = SupplierPurchasePrice

}(window.jQuery);

