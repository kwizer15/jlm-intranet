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
				var stdInput = function(context, name, calcul) {
					return {
						$element: context.$element.find("#" + context.$element.attr('id') + "_" + name),
						value: function() { return parseFloat(this.$element.val().replace(',','.').replace(/[\s]{1,}/g,"")); },
						context: context,
						calcul: calcul
					}
				};
				context = this;
				this.datas = {
						publicPrice: stdInput(context, "publicPrice", function() {
								return this.value()
							}),
						discount: stdInput(context, "discount", function() {
							var unitPrice = context.datas.unitPrice.value(),
							publicPrice = context.datas.publicPrice.value();
							if (publicPrice == 0) {
								return 0;
							}
							return (1 - (unitPrice / publicPrice)) * 100;
						}), 
						unitPrice: stdInput(context, "unitPrice", function() {
							var publicPrice = context.datas.publicPrice.value(),
							discount = context.datas.discount.value();
							return publicPrice * (1 - discount / 100);
						}),
						expenseRatio: stdInput(context, "expenseRatio", function() {
							return this.value();
						}),
						expense: stdInput(context, "expense", function() {
							var unitPrice = context.datas.unitPrice.value(),
							expenseRatio = context.datas.expenseRatio.value();
							return unitPrice * (expenseRatio / 100 );
						}),
						
						delivery: stdInput(context, "delivery", function() {
							return this.value();
						}),
						totalPrice: stdInput(context, "totalPrice", function() {
							var unitPrice = context.datas.unitPrice.value(),
							expense = context.datas.expense.value(),
							delivery = context.datas.delivery.value();
							return unitPrice + expense + delivery;
						}),
						coef: stdInput(context, "coeficient", function() {
							var sellPrice = context.datas.sellPrice.value(),
							totalPrice = context.datas.totalPrice.value();
							if (totalPrice == 0) {
								return 0;
							}
							return ((sellPrice / totalPrice) - 1) * 100;
						}),
						margin: stdInput(context, "margin", function() {
							var coef = context.datas.coef.value(),
							totalPrice = context.datas.totalPrice.value();
							return totalPrice * (coef / 100);
						}),
						sellPrice: stdInput(context, "sellPrice", function() {
							var totalPrice = context.datas.totalPrice.value(),
							margin = context.datas.margin.value();
							return totalPrice + margin;
						}),
						priority: stdInput(context, "priority", function() {
							return this.value();
						}),							
						globalSellPrice: {
							$element: this.options.sellPriceElement,
							value: function() { return parseFloat(this.$element.val().replace(',','.').replace(/[\s]{1,}/g,"")); },
							that: this,
							calcul: function() {
								if (this.that.datas.priority.value() == 1) {
									return this.that.datas.sellPrice.value();									
								}
								
								return this.value();
							}
						}
				};

				this.$btnRemove    = this.$element.find("#" + this.$element.attr('id') + "_" + "remove");
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
		$.each(this.datas, function(index, data) {
			if ($(e.target).attr('id') != data.$element.attr('id')) {
				data.$element.val(number_format(data.calcul(),2,',',' '));
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

