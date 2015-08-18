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
						expenseRatio: {
							$element: this.$element.find(prefix + "expenseRatio"),
							value: inputToInt,
							that: this,
							calcul: function() {
								return this.value();
								var unitPrice = this.that.datas.unitPrice.value(),
								expense = this.that.datas.expense.value();
								if (unitPrice == 0) {
									return 0;
								}
								return (expense * 100) / unitPrice;
							},
							dec: 0
						},
						expense: {
							$element: this.$element.find(prefix + "expense"),
							value: inputToFloat,
							that: this,
							calcul: function() {
								var unitPrice = this.that.datas.unitPrice.value(),
								expenseRatio = this.that.datas.expenseRatio.value();
								return unitPrice * (expenseRatio / 100 );
							},
							dec: 2
						},
						delivery: {
							$element: this.$element.find(prefix + "delivery"),
							value: inputToFloat,
							calcul: function() { return this.value() },
							dec: 2
						},
						totalPrice: {
							$element: this.$element.find(prefix + "totalPrice"),
							value: inputToFloat,
							that: this,
							calcul: function() {
								var unitPrice = this.that.datas.unitPrice.value(),
								expense = this.that.datas.expense.value(),
								delivery = this.that.datas.delivery.value();
								return unitPrice + expense + delivery;
							},
							dec: 2
						},
						sellPrice: {
							$element: this.options.sellPriceElement,
							value: inputToFloat,
							that: this,
							calcul: function() {
								var totalPrice = this.that.datas.totalPrice.value(),
								margin = this.that.datas.margin.value();
								return totalPrice + margin;
							},
							dec: 2
						},
						coef: {
							$element: this.$element.find(prefix + "coef"),
							value: inputToInt,
							that : this,
							calcul: function() {
								var sellPrice = this.that.datas.sellPrice.value(),
								totalPrice = this.that.datas.totalPrice.value();
								return ((sellPrice / totalPrice) - 1) * 100;
							},
							dec: 0
						},
						margin: {
							$element: this.$element.find(prefix + "margin"),
							value: inputToFloat,
							that : this,
							calcul: function() {
								var coef = this.that.datas.coef.value(),
								totalPrice = this.that.datas.totalPrice.value();
								return totalPrice * (coef / 100);
							},
							dec: 2
						}
				};

				this.$btnRemove    = this.$element.find(prefix + "remove");
				this.$btnRemove.on('click', $.proxy(this.remove,this));
				that = this;
				$.each(this.datas, function(index, data) {
					data.$element.on('keyup', $.proxy(that.calcul, that))
					data.$element.keyup();
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
		$ctrlgrp = data.$element.parent().parent();
		$ctrlgrp.toggleClass('warning', (index == 'coef' || index == 'expenseRatio') && data.value() < 10 && data.value() >= 0);
		$ctrlgrp.toggleClass('error', data.value() < 0);

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

