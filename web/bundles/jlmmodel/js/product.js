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
		  var line = "#product_";
		  $(line + "purchase, " +
		    line + "discountSupplier, " + 
		    line + "expenseRatio, " + 
		    line + "shipping, " + 
		    line + "margin")
		    .on('change',$.proxy(this.totalCoef,this));
		  $(line + "unitPrice").on('change',$.proxy(this.total,this));
		  $(line + "unitPrice").change();
			
	  }
   	 
   	 , total : function(e) {
   		 e.stopPropagation()
		 e.preventDefault()
		 var line = "#product_";
		   		var p = parseFloat($(line + "purchase").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var d = parseFloat($(line + "discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var e = parseFloat($(line + "expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var s = parseFloat($(line + "shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var u = parseFloat($(line + "unitPrice").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var m = ((u-s)/(p*(1-d)*(1+e)))-1;
		   		$(line + "purchase").val(number_format(p,2,',',' '));
		   		$(line + "discountSupplier").val(number_format(d*100,0,',',' '));
		   		$(line + "expenseRatio").val(number_format(e*100,0,',',' '));
		   		$(line + "shipping").val(number_format(s,2,',',' '));
		   		$(line + "margin").val(number_format(m*100,2,',',' '));
		   		$(line + "unitPrice").val(number_format(u,2,',',' '));
		 return this;
   	 }
   	, totalCoef : function(e) {
  		 e.stopPropagation()
		 e.preventDefault()
		 var line = "#product_";
		   		var p = parseFloat($(line + "purchase").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var d = parseFloat($(line + "discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var e = parseFloat($(line + "expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var s = parseFloat($(line + "shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var m = parseFloat($(line + "margin").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var u = p*(1-d)*(1+e)*(1+m)+s;
		   		$(line + "purchase").val(number_format(p,2,',',' '));
		   		$(line + "discountSupplier").val(number_format(d*100,0,',',' '));
		   		$(line + "expenseRatio").val(number_format(e*100,0,',',' '));
		   		$(line + "shipping").val(number_format(s,2,',',' '));
		   		$(line + "margin").val(number_format(m*100,2,',',' '));
		   		$(line + "unitPrice").val(number_format(u,2,',',' '));
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
