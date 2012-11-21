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
		    .on('change',$.proxy(this.total,this));
		  $(line + "purchase").change();
			
	  }
   	 
   	 , total : function(e) {
   		 e.stopPropagation()
		 e.preventDefault()
		 var line = "#product_";
		   		var p = parseFloat($(line + "purchase").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var d = parseInt($(line + "discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var e = parseInt($(line + "expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var s = parseFloat($(line + "shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var m = parseInt($(line + "margin").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var total = (p*((100-d)/100)*((100+e)/100))*((100+m)/100)+s;
		   		$(line + "purchase").val(number_format(p,2,',',' '));
		   		$(line + "discountSupplier").val(number_format(d,0,',',' '));
		   		$(line + "expenseRatio").val(number_format(e,0,',',' '));
		   		$(line + "shipping").val(number_format(s,2,',',' '));
		   		$(line + "margin").val(number_format(m,0,',',' '));
		   		$(line + "unitPrice").html(number_format(total,2,',',' '));
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
