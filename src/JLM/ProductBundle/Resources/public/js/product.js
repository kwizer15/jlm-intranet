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
				this.$supplierPurchasePrice.children().supplierpurchaseprice({sellPriceElement: this.$unitPrice});
				this.lastLineNumber = this.$supplierPurchasePrice.children().size();		  
				this.$btnAddSPP.on('click', $.proxy(this.addSupplierLine,this));
			}

	, addSupplierLine : function(e) {
		e.stopPropagation()
		e.preventDefault()
		$line = $(this.$supplierPurchasePrice.attr('data-prototype').replace(/__name__/g, this.lastLineNumber));
		$line.supplierpurchaseprice({'sellPriceElement':this.$unitPrice,'priority':this.lastLineNumber});
		this.$supplierPurchasePrice.append($line);
		

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
				var stdInput = function(context, name, calculMe, listen) {
					return {
						context: context,
						updated: false,
						$element: (typeof name == "string") ? context.$element.find("#" + context.$element.attr('id') + "_" + name) : name,
						value: function() { return parseFloat(this.$element.val().replace(',','.').replace(/[\s]{1,}/g,"")) },
						valueUpdated: function() { if (!this.updated) { this.ud()}; return this.value(); },
						onType: function() {
							this.updated = true;
							$ctrlgrp = this.$element.parent().parent();
							$ctrlgrp.toggleClass('error', this.value() < 0);
							//console.log('Change ' + this.$element.attr('id'))
							this.$element.trigger({
								type: "update"
							});
							//this.$element.change();
							
						},
						init: function() { this.$element.val(number_format(this.value(),2,',',' ')); },
						ud: function() {
							if (!this.updated) {
								this.updated = true;
								var calc = calculMe();
								calc = (calc === undefined) ? this.value() : calc;
								this.$element.val(number_format(calc,2,',',' '));
								
							}
						},
						update: function(e) { 
							e.stopPropagation()
							e.preventDefault()
							//console.log('Call ' + this.$element.attr('id'))
							if (!this.updated) {
								this.ud();
								this.onType();
							}
							return this;
						},
						reset: function() { this.updated = false },
						listen: listen
					}
				};
				/* @todo Améliorer avec des evenements sur chaques case
				 * Exemple :
				 * unitPrice : change si keyup sur publicPrice ou discount
				 * discount : publicPrice ou unitPrice
				 * expense : unitPrice ou expenseRatio
				 * expenseRatio : expense
				 * delivery : jamais
				 * totalPrice : unitPrice, expense ou delivery
				 * coef : margin ou sellPrice
				 * margin : coef ou sellPrice
				 * sellPrice : coef, margin, totalPrice ou globalPrice(priority=0)
				 * globalPrice : sellPrice(priority=0)
				 * + drapeau sur chaque case pour la signaler à jour (anti-récursivité)
				 */
				context = this;
				this.datas = {
						priority: stdInput(context, "priority", function() {}, function() {}),
						publicPrice: stdInput(context, "publicPrice", function() {}, function() {}),
						unitPrice: stdInput(context, "unitPrice", function() {
							var publicPrice = context.datas.publicPrice.valueUpdated(),
							discount = context.datas.discount.valueUpdated();
							return publicPrice * (1 - discount / 100);
						}, function() {
							context.datas.discount.$element.on('update', $.proxy(this.update, this))
						}),
						
						discount: stdInput(context, "discount", function() {
							var unitPrice = context.datas.unitPrice.valueUpdated(),
							publicPrice = context.datas.publicPrice.valueUpdated();
							if (publicPrice == 0) {
								return 0;
							}
							return (1 - (unitPrice / publicPrice)) * 100;
						}, function() {
							context.datas.unitPrice.$element.on('update', $.proxy(this.update, this))
						}), 
						
						expense: stdInput(context, "expense", function() {
							var unitPrice = context.datas.unitPrice.valueUpdated(),
							expenseRatio = context.datas.expenseRatio.valueUpdated();
							return unitPrice * (expenseRatio / 100 );
						}, function() {
							context.datas.expenseRatio.$element.on('update', $.proxy(this.update, this))
							//context.datas.unitPrice.$element.on('update', $.proxy(this.update, this))
						}),
						
						expenseRatio: stdInput(context, "expenseRatio", function() {}, function() {
							context.datas.unitPrice.$element.on('update', $.proxy(this.update, this))
						}),
						delivery: stdInput(context, "delivery", function() {}, function() {}),
						totalPrice: stdInput(context, "totalPrice", function() {
							var unitPrice = context.datas.unitPrice.valueUpdated(),
							expense = context.datas.expense.valueUpdated(),
							delivery = context.datas.delivery.valueUpdated();
							return unitPrice + expense + delivery;
						}, function() {
							context.datas.expense.$element.on('update', $.proxy(this.update, this))
							context.datas.delivery.$element.on('update', $.proxy(this.update, this))
						}),
						coef: stdInput(context, "coeficient", function() {
							console.log('COEF : ' + context.datas.coef.$element.attr('id'))
							var totalPrice = context.datas.totalPrice.valueUpdated(),
							margin = context.datas.margin.valueUpdated()
							return (totalPrice == 0) ? 0 : (margin / totalPrice) * 100;
						}, function() {
							context.datas.margin.$element.on('update', $.proxy(this.update, this))
						}),
						margin: stdInput(context, "margin", function() {
							console.log('MARGIN : ' + context.datas.margin.$element.attr('id'))
							var totalPrice = context.datas.totalPrice.valueUpdated()
							if (parseInt(context.datas.priority.value()) != 0 || context.datas.globalSellPrice.updated) {
								var sellPrice = context.datas.globalSellPrice.valueUpdated()
								return sellPrice - totalPrice;
							}
							if (context.datas.coef.updated) {
								var coef = context.datas.coef.valueUpdated()
								return (coef / 100) * totalPrice;
							}
							
						}, function() {
							context.datas.totalPrice.$element.on('update', $.proxy(this.update, this))
							context.datas.sellPrice.$element.on('update', $.proxy(this.update, this))
							context.datas.coef.$element.on('update', $.proxy(this.update, this))
						}),
						sellPrice: stdInput(context, "sellPrice", function() {
							console.log('SELL : ' + context.datas.sellPrice.$element.attr('id'))
							if (context.datas.priority.value() != 0 || context.datas.globalSellPrice.updated) {
								return context.datas.globalSellPrice.valueUpdated();
							}
							var totalPrice = context.datas.totalPrice.valueUpdated(),
							margin = context.datas.margin.valueUpdated();
							return totalPrice + margin;									
						}, function() {
							context.datas.globalSellPrice.$element.on('update', $.proxy(this.update, this))
							if (parseInt(context.datas.priority.value()) == 0) {
								console.log('UPDATE GLOBAL PRICE')
								context.datas.coef.$element.on('update', $.proxy(this.update, this))
								context.datas.margin.$element.on('update', $.proxy(this.update, this))
							}
						}),
													
						globalSellPrice: stdInput(context, context.options.sellPriceElement, function() {
							if (parseInt(context.datas.priority.value()) == 0 && context.datas.sellPrice.updated) {
								return context.datas.sellPrice.valueUpdated();
							}
							
						}, function() {
							if (parseInt(context.datas.priority.value()) == 0) {
								context.datas.sellPrice.$element.on('update', $.proxy(this.update, this))
							}
						})
						
				};

				this.$btnRemove    = this.$element.find("#" + this.$element.attr('id') + "_" + "remove");
				this.$btnRemove.on('click', $.proxy(this.remove,this));
				this.datas.priority.$element.val(this.options.priority);
				if (this.datas.priority.value() != 0) {
					this.datas.coef.$element.attr('disabled','disabled');
				}
				that = this;
				$.each(this.datas, function(index, data) {
					data.init();
					data.listen();
					data.$element.on('keyup', $.proxy(that.calcul, that))
					data.$element.on('change', $.proxy(data.init, data))
					data.$element.trigger({type:'update'})
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
		elem = undefined;
		that = this;
		$.each(that.datas, function(index, data) {
			data.reset();
			elem = ($(e.target).attr('id') == data.$element.attr('id')) ? data : elem;
		});
		if (elem != undefined) {
			elem.onType();
		}
		
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
				}
			},
			sellPriceElement: $('div'),
			priority: 0
	}

	$.fn.supplierpurchaseprice.Constructor = SupplierPurchasePrice

}(window.jQuery);

