/**
 * Fee plugin
 */

!function($){

  "use strict"; // jshint ;_;
  
  /* FEE PUBLIC CLASS DEFINITION
   * ================================= */

   var Fee = function (element, options) {
     this.$element = $(element)
     this.options = $.extend({}, $.fn.fee.defaults, options)
     this.listen()
   }
  
   Fee.prototype = {
	  constructor: Fee
	  
	  , listen : function() {
		  $("#fee_address").attr('data-source',this.options.autoSource)
		                    .autocomplete({
				source: function(request,response){
					request.repository = 'JLMModelBundle:Site';
					return $.post(
							this.element.attr('data-source'),
							request,
							function( data ) { response( data ); },
							'json'
					);
			    }
			    , select: function (event, ui) {
				    $("#fee_address").val(ui.item.siteCp);
				    $("#fee_vat").val(ui.item.vatid);
				    $("#fee_trustee").val(ui.item.trusteeName);
				    $("#fee_prelabel").val(ui.item.prelabel);
			        return false;
			    }
		  });

			$("#fee_contracts > tr").feecontract({
				autoSource:this.options.autoSource,
			});
			$(".newcontract").on('click',$.proxy(this.newcontract,this));
	  }
   	, newcontract : function(e){
		 	e.stopPropagation()
		 	e.preventDefault()
		var lineList = $("#fee_contracts");
		var newWidget = lineList.attr('data-prototype');
		newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
		lineList.append(newWidget);
		$("#fee_contracts_" + this.options.lineCount).feecontract({
			autoSource:this.options.autoSource
		});
		// Valeurs par défaut
		$("#fee_contracts_" + this.options.lineCount).val('');
		this.options.lineCount++;
		return this;
	}
}

  
  /* FEE PLUGIN DEFINITION
   * =========================== */

  $.fn.fee = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('fee')
        , options = typeof option == 'object' && option
      if (!data) $this.data('fee', (data = new Fee(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.fee.defaults = {
	 autoSource:'',
	 lineCount:0,
  }

  $.fn.fee.Constructor = Fee

}(window.jQuery);

/*************************************************************************
 * FeeContract plugin
 */

!function($){

	  "use strict"; // jshint ;_;
	  
	  /* FEECONTRACT PUBLIC CLASS DEFINITION
	   * ================================= */

	   var FeeContract = function (element, options) {
	     this.$element = $(element)
	     this.options = $.extend({}, $.fn.feecontract.defaults, options)
	     this.listen()
	   }
	  
	   FeeContract.prototype = {
		  constructor: FeeContract
		  
		  , listen : function() {
			  var line = "#" + this.$element.attr('id');
			  
			  this.$element.find(".remove-line").on('click',$.proxy(this.remove,this));
			  
			  $("input"+line).attr('data-source',this.options.autoSource)
					 .autocomplete({
						source: function(request,response){
							request.repository = 'JLMContractBundle:Contract';
							return $.post(
								this.element.attr('data-source'),
								request,
								function( data ) { response( data ); },
								'json'
							);
					  }
					  , select: function (event, ui) {
						  $("input#"+this.id).val(ui.item.label);
					      return false;
					  }
				});
		  }
	   	  , remove : function(e) {
		   		e.stopPropagation()
		        e.preventDefault()
		   		this.$element.fadeOut(500,function(){
		   			$("#" + $(this).attr('id')).val('');
		   			$(this).remove();
		   		});
				return this;
	   	  }
	   }

	  
	  /* BILLLINE PLUGIN DEFINITION
	   * =========================== */

	  $.fn.feecontract = function (option) {
	    return this.each(function () {
	      var $this = $(this)
	        , data = $this.data('feecontract')
	        , options = typeof option == 'object' && option
	      if (!data) $this.data('feecontract', (data = new FeeContract(this, options)))
	      if (typeof option == 'string') data[option]()
	    })
	  }

	  $.fn.feecontract.defaults = {
			 autoSource:'',
			 line:0,
	  }

	  $.fn.feecontract.Constructor = FeeContract

}(window.jQuery);
