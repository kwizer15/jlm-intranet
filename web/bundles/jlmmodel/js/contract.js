/**
 * Contract plugin
 */

!function($){

  "use strict"; // jshint ;_;
  
  /* CONTRACT PUBLIC CLASS DEFINITION
   * ================================= */

   var Contract = function (element, options) {
     this.$element = $(element)
     this.options = $.extend({}, $.fn.contract.defaults, options)
     this.listen()
   }
  
   Contract.prototype = {
	  constructor: Contract
	  
	  , listen : function() {
		  var line = "#jlm_modelbundle_contracttype_";
		  $(line + "fee").on('change',$.proxy(this.dot,this));
			
	  }
   	 
   	 , dot : function(e) {
   		 e.stopPropagation()
		 e.preventDefault()
		 var line = "#jlm_modelbundle_contracttype_";
		 var p = parseFloat($(line + "fee").val().replace(',','.').replace(/[\s]{1,}/g,""));
		 $(line + "fee").val(number_format(p,2,',',' '));
		 return this;
   	 }
   }

  
  /* CONTRACT PLUGIN DEFINITION
   * =========================== */

  $.fn.contract = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('contract')
        , options = typeof option == 'object' && option
      if (!data) $this.data('contract', (data = new Contract(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.contract.defaults = {
	
  }

  $.fn.contract.Constructor = Contract

}(window.jQuery);