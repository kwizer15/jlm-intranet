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
//		  var line = "#" + this.$element.attr('id') + "_";
//		  $(line + "purchase, " +
//		    line + "discountSupplier, " + 
//		    line + "expenseRatio, " + 
//		    line + "shipping, " + 
//		    line + "margin")
//		    .on('change',$.proxy(this.totalCoef,this));
		  this.$unitPrice.on('change',$.proxy(this.total,this));
		  this.$unitPrice.change();
			
	  }
   	 
     , addSupplierLine : function(e) {
    	 e.stopPropagation()
		 e.preventDefault()
		 $line = $(this.$supplierPurchasePrice.attr('data-prototype').replace(/__name__/g, this.lastLineNumber))
		 	.supplierpurchaseprice({'sellPriceElement':this.$unitPrice});
		 this.$supplierPurchasePrice.append($line);   	 
    	 
    	 this.lastLineNumber++;
    	 return this;
     }
   
   	 , total : function(e) {
   		 e.stopPropagation()
		 e.preventDefault()
//		 var line = "#jlm_product_product_";
//		   		var p = parseFloat($(line + "purchase").val().replace(',','.').replace(/[\s]{1,}/g,""));
//		   		var d = parseFloat($(line + "discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
//		   		var e = parseFloat($(line + "expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
//		   		var s = parseFloat($(line + "shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
//		   		var u = parseFloat($(line + "unitPrice").val().replace(',','.').replace(/[\s]{1,}/g,""));
//		   		var m = ((u-s)/(p*(1-d)*(1+e)))-1;
//		   		$(line + "purchase").val(number_format(p,2,',',' '));
//		   		$(line + "discountSupplier").val(number_format(d*100,0,',',' '));
//		   		$(line + "expenseRatio").val(number_format(e*100,0,',',' '));
//		   		$(line + "shipping").val(number_format(s,2,',',' '));
//		   		$(line + "margin").val(number_format(m*100,2,',',' '));
//		   		$(line + "unitPrice").val(number_format(u,2,',',' '));
		 return this;
   	 }
   	, totalCoef : function(e) {
  		 e.stopPropagation()
		 e.preventDefault()
//		 var line = "#jlm_product_product_";
//		   		var p = parseFloat($(line + "purchase").val().replace(',','.').replace(/[\s]{1,}/g,""));
//		   		var d = parseFloat($(line + "discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
//		   		var e = parseFloat($(line + "expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
//		   		var s = parseFloat($(line + "shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
//		   		var m = parseFloat($(line + "margin").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
//		   		var u = p*(1-d)*(1+e)*(1+m)+s;
//		   		$(line + "purchase").val(number_format(p,2,',',' '));
//		   		$(line + "discountSupplier").val(number_format(d*100,0,',',' '));
//		   		$(line + "expenseRatio").val(number_format(e*100,0,',',' '));
//		   		$(line + "shipping").val(number_format(s,2,',',' '));
//		   		$(line + "margin").val(number_format(m*100,2,',',' '));
//		   		$(line + "unitPrice").val(number_format(u,2,',',' '));
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
		  var prefix = "#" + this.$element.attr('id') + "_";
		  this.$sellPrice = this.options.sellPriceElement;
		  this.$unitPrice = this.$element.find(prefix + "unitPrice");
		  this.$publicPrice = this.$element.find(prefix + "publicPrice");
		  this.$discount     = this.$element.find(prefix + "discount");
		  this.$expenseRatio = this.$element.find(prefix + "expenseRatio");
		  this.$delivery     = this.$element.find(prefix + "delivery");
		  this.$margin       = this.$element.find(prefix + "margin");
		  this.$btnRemove    = this.$element.find(prefix + "remove");
		  this.$btnRemove.on('click', $.proxy(this.remove,this));
		  
		  this.$unitPrice.on('keyup', $.proxy(this.calcul,this))
		  this.$publicPrice.on('keyup', $.proxy(this.calcul,this))
		  this.$discount.on('keyup', $.proxy(this.calcul,this))
		  this.$expenseRatio.on('keyup', $.proxy(this.calcul,this))
		  this.$delivery.on('keyup', $.proxy(this.calcul,this))
		  this.$margin.on('keyup', $.proxy(this.calcul,this))
		  this.$sellPrice.on('keyup', $.proxy(this.calcul,this))
		  
//		  var line = "#" + this.$element.attr('id') + "_";
//		  $(line + "purchase, " +
//		    line + "discountSupplier, " + 
//		    line + "expenseRatio, " + 
//		    line + "shipping, " + 
//		    line + "margin")
//		    .on('change',$.proxy(this.totalCoef,this));
//		  this.$unitPrice.on('change',$.proxy(this.total,this));
//		  this.$unitPrice.change();
			
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
			
		   var publicPrice = parseFloat(this.$publicPrice.val().replace(',','.').replace(/[\s]{1,}/g,"")); console.log(publicPrice);
		   var discount = parseInt(this.$discount.val().replace(',','.').replace(/[\s]{1,}/g,"")); console.log(discount);
		   var unitPrice = parseFloat(this.$unitPrice.val().replace(',','.').replace(/[\s]{1,}/g,"")); console.log(unitPrice);
		   var expenseRatio = parseInt(this.$expenseRatio.val().replace(',','.').replace(/[\s]{1,}/g,""));
		   var delivery = parseFloat(this.$delivery.val().replace(',','.').replace(/[\s]{1,}/g,""));
		   var margin = parseInt(this.$margin.val().replace(',','.').replace(/[\s]{1,}/g,""));
		   var sellPrice = parseFloat(this.$sellPrice.val().replace(',','.').replace(/[\s]{1,}/g,""));
   
		   if ($(e.target).attr('id') != this.$unitPrice.attr('id')) {
			   unitPrice = publicPrice * (1 - discount / 100);			   
			   this.$unitPrice.val(number_format(unitPrice,2,',',' '));
		   }
		   if ($(e.target).attr('id') != this.$discount.attr('id')) {
			   discount = (1 - (unitPrice / publicPrice)) * 100;			   
			   this.$discount.val(number_format(discount,0,',',' '));
		   }
		   if ($(e.target).attr('id') != this.$publicPrice.attr('id')) {
			   publicPrice = unitPrice / (1-discount/100);
			   this.$publicPrice.val(number_format(publicPrice,2,',',' '));
		   }
		   if ($(e.target).attr('id') != this.$expenseRatio.attr('id')) {
			   this.$expenseRatio.val(number_format(expenseRatio,0,',',' '));
		   }
		   if ($(e.target).attr('id') != this.$delivery.attr('id')) {
			   this.$delivery.val(number_format(delivery,2,',',' '));
		   }
		   
		   if ($(e.target).attr('id') != this.$sellPrice.attr('id')) {
			   sellPrice = (unitPrice * (1 + expenseRatio / 100) + delivery) * (1 + margin / 100);
			   this.$sellPrice.val(number_format(sellPrice,2,',',' '));
		   }
		   if ($(e.target).attr('id') != this.$margin.attr('id')) {
			   totalPrice = unitPrice * (1 + expenseRatio / 100) + delivery;
			   margin = ((sellPrice / totalPrice) - 1) * 100;
			   this.$margin.val(number_format(margin,0,',',' '));
		   }
		   // Verifier et revoir l'ordre
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

