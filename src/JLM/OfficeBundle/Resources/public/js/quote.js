/**
 * Quote plugin
 */

!function($){

  "use strict"; // jshint ;_;
  
  /* QUOTE PUBLIC CLASS DEFINITION
   * ================================= */

   var Quote = function (element, options) {
     this.$element = $(element)
     this.options = $.extend({}, $.fn.quote.defaults, options)
     this.listen()
   }
  
   Quote.prototype = {
	  constructor: Quote
	  
	  , listen : function() {
		  $("#quote_vat").on('change', $.proxy(this.vatchange,this));
		  
		  $('#quote_followerCp').autocomplete({
				source:['Yohann Martinez','Emmanuel Bernaszuk','Jean-Louis Martinez','Nadine Martinez','Aurélie Costalat']
			});
		  
		  
		  $("#quote_doorCp").attr('data-source',this.options.autoSource)
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
				    $("#quote_door").val(ui.item.door);
				    $("#quote_doorCp").val(ui.item.label);
				    $("#quote_vat").val(number_format(ui.item.vat*100,1,',',' ')).change();
				    $("#quote_trustee").val(ui.item.trustee);
				    $("#quote_trusteeName").val(ui.item.trusteeName);
				    $("#quote_trusteeAddress").val(ui.item.trusteeAddress);
				    $("#quote_contact").val('');
					$("#quote_contactCp").val('');
			        return false;
			    }
		  });
		  
		  $("#quote_trusteeName").attr('data-source',this.options.autoSource)
		  			.autocomplete({
				source: function(request,response){
					request.repository = 'JLMModelBundle:Trustee';
					return $.post(
							this.element.attr('data-source'),
							request,
							function( data ) { response( data ); },
							'json'
					);
				}
				, select: function (event, ui) {
				  $("#quote_trustee").val(ui.item.trustee);
				  $("#quote_trusteeName").val(ui.item.label);
				  $("#quote_trusteeAddress").val(ui.item.trusteeAddress);
				  return false;
				}
			});
		  
		  $("#quote_contactCp").attr('data-source',this.options.autoSource)
					          .autocomplete({
					source: function(request,response){
						request.term = $('#quote_door').val();
						request.repository = 'JLMModelBundle:SiteContact';
						return $.post(
								this.element.attr('data-source'),
								request,
								function( data ) { response( data ); },
								'json'
						);
					}
					, select: function (event, ui) {
					  $("#quote_contact").val(ui.item.id);
					  $("#quote_contactCp").val(ui.item.name);
					  return false;
					}
				});
	  }
   	 , vatchange : function(e) {
   		e.stopPropagation()
		e.preventDefault()
		var v = parseFloat($("#quote_vat").val().replace(',','.'));
   		$("#quote_vat").val(number_format(v,1,',',' '));	
   	 }
   }

  
  /* QUOTE PLUGIN DEFINITION
   * =========================== */

  $.fn.quote = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('quote')
        , options = typeof option == 'object' && option
      if (!data) $this.data('quote', (data = new Quote(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.quote.defaults = {
	 autoSource:'',
  }

  $.fn.quote.Constructor = Quote

}(window.jQuery);

/**
 * Quote variant plugin
 */

!function($){

  "use strict"; // jshint ;_;
  
  /* QUOTE VARIANT PUBLIC CLASS DEFINITION
   * ================================= */

   var QuoteVariant = function (element, options) {
     this.$element = $(element)
     this.options = $.extend({}, $.fn.quote.defaults, options)
     this.listen()
   }
  
   QuoteVariant.prototype = {
	  constructor: QuoteVariant
	  
	  , listen : function() {
		    $(".col-coding").hide();
		    $(".tab-quote").click(function(){
		    	if (!$(".tab-quote").hasClass('active'))
		    	{
		    		$(".tab-quote").addClass('active');
		    		$(".col-quote").show();
		    		$(".tab-coding").removeClass('active');
		    		$(".col-coding").hide();
		    	}
		    	return false;
		    });
		    
		    $(".tab-coding").click(function(){
		    	if (!$(".tab-coding").hasClass('active'))
		    	{
		    		$(".tab-quote").removeClass('active');
		    		$(".col-quote").hide();
		    		$(".tab-coding").addClass('active');
		    		$(".col-coding").show();
		    	}
		    	return false;
		    });
		    
		  	$("#quote_variant_paymentRules").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:PaymentModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			$("#quote_variant_deliveryRules").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:DelayModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			
			$("#quote_variant_intro").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:IntroModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			
			this.$element.find("#quote_variant_lines > tr").on('change',$.proxy(this.total,this)).quoteline({
				autoSource:this.options.autoSource,
			}); 
			$("#quote_variant_discount").on('change',$.proxy(this.total,this));
			$(".newline").on('click',$.proxy(this.newline,this));
			$("#quote_variant_lines > tr").change();
			$("#quote_variant_lines").sortable({
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
			var lineList = $("#quote_variant_lines");
			var newWidget = lineList.attr('data-prototype');
			newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
			lineList.append(newWidget);
			$("#quote_variant_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).quoteline({
				autoSource:this.options.autoSource
			});
			// Valeurs par défaut
			$("#quote_variant_lines_" + this.options.lineCount + "_position").val(this.options.lineCount);
			$("#quote_variant_lines_" + this.options.lineCount + "_description").hide();
			$("#quote_variant_lines_" + this.options.lineCount + "_showDescription").val(0);
			$("#quote_variant_lines_" + this.options.lineCount + "_quantity").val(1);
			$("#quote_variant_lines_" + this.options.lineCount + "_puchasePrice").val(0);
			$("#quote_variant_lines_" + this.options.lineCount + "_discountSupplier").val(0);
			$("#quote_variant_lines_" + this.options.lineCount + "_expenseRatio").val(10);
			$("#quote_variant_lines_" + this.options.lineCount + "_shipping").val('0,00');
			$("#quote_variant_lines_" + this.options.lineCount + "_discount").val(0);
			$("#quote_variant_lines_" + this.options.lineCount + "_vat").val($("#quote_vat").val());
			$("#quote_variant_lines_" + this.options.lineCount + "_coef").val('40,00').change();
			if (!$(".tab-coding").hasClass('active'))
	    	{
	    		$(".col-quote").show();
	    		$(".col-coding").hide();
	    	}
			else
			{
		    	$(".col-quote").hide();
		    	$(".col-coding").show();
			}
			this.options.lineCount++;
			return this;
		}
   	 , total : function(e) {
   		 e.stopPropagation()
		 e.preventDefault()
		 var tht = 0;
   		 var tva = 0;
   		 var tpc = 0;
		 $.each($("#quote_variant_lines > tr"),function(){
			 var thtline = parseFloat($("#" + this.id + "_total").html().replace(',','.').replace(' ',''));
			 var tvaline = parseFloat($("#" + this.id + "_vat").val().replace(',','.').replace(' ',''))/100;
			 var qtyline = parseFloat($("#" + this.id + "_quantity").val().replace(',','.').replace(' ',''));
			 var pcline = parseFloat($("#" + this.id + "_purchasePrice").val().replace(',','.').replace(' ',''));
			 var dsline = parseFloat($("#" + this.id + "_discountSupplier").val().replace(',','.').replace(' ',''))/100;
			 var erline = parseFloat($("#" + this.id + "_expenseRatio").val().replace(',','.').replace(' ',''))/100;
			 var shline = parseFloat($("#" + this.id + "_shipping").val().replace(',','.').replace(' ',''));
			 tpc += (pcline*(1-dsline)*(1+erline)+shline)*qtyline;
			 tht += thtline;
			 tva += (thtline * tvaline);
		 });
		 var dis = parseFloat($("#quote_variant_discount").val().replace(',','.').replace(' ',''))/100;
		 $("#quote_variant_total_htbd").html(number_format(tht,2,',',' '));
		 $("#quote_variant_total_discount").html(number_format(tht*dis,2,',',' '));	
		 $("#quote_variant_total_purchase").html(number_format(tpc,2,',',' '));
		 	
		 tht -= tht*dis;
		 tva -= tva*dis;
		 $("#quote_variant_total_margin").html(number_format(tht-tpc,2,',',' '));
		 $("#quote_variant_total_ht").html(number_format(tht,2,',',' '));
		 $("#quote_variant_total_tva").html(number_format(tva,2,',',' '));
		 $("#quote_variant_total_ttc").html(number_format(tht+tva,2,',',' '));
		 return this;
   	   
   		
   	 }
   }

  
  /* QUOTE VARIANT PLUGIN DEFINITION
   * =========================== */

  $.fn.quotevariant = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('quotevariant')
        , options = typeof option == 'object' && option
      if (!data) $this.data('quotevariant', (data = new QuoteVariant(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.quote.defaults = {
	 autoSource:'', 
	 lineCount:0,
  }

  $.fn.quote.Constructor = QuoteVariant

}(window.jQuery);


/*************************************************************************
 * QuoteLine plugin
 */

!function($){

	  "use strict"; // jshint ;_;
	  
	  /* QUOTELINE PUBLIC CLASS DEFINITION
	   * ================================= */

	   var QuoteLine = function (element, options) {
	     this.$element = $(element)
	     this.options = $.extend({}, $.fn.quoteline.defaults, options)
	     this.listen()
	   }
	  
	   QuoteLine.prototype = {
		  constructor: QuoteLine
		  
		  , listen : function() {
			  var line = "#" + this.$element.attr('id');
			  this.$element.find(".remove-line").on('click',$.proxy(this.remove,this));
			  this.$element.find(".show-description").on('click',$.proxy(this.toggleDesc,this));
			  this.showDesc();
			  
			  $(line + "_quantity, "
			  + line + "_unitPrice, "
			  + line + "_discount").on('change',$.proxy(this.totalQuote,this));
			  
			  $(line + "_purchasePrice, "
			  + line + "_discountSupplier, "
			  + line + "_expenseRatio, "
			  + line + "_shipping, "
			  + line + "_coef").on('change',$.proxy(this.totalCoding,this));
			  
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
						    $(id + 'product').val(ui.item.id);
						  	$(id + 'reference').val(ui.item.reference);
						  	$(id + 'designation').val(ui.item.designation);
						  	$(id + 'description').val(ui.item.description);
						  	$(id + 'purchasePrice').val(ui.item.purchase);
						  	$(id + 'discountSupplier').val(ui.item.discountSupplier);
						  	$(id + 'expenseRatio').val(ui.item.expenseRatio);
						  	
						  	$(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
						  	$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? $("#quote_vatTransmitter").val() : $("#quote_vat").val());
						  	$(id + 'shipping').val(ui.item.shipping).change();
						  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
						
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
					    $(id + 'product').val(ui.item.id);
					  	$(id + 'reference').val(ui.item.reference);
					  	$(id + 'designation').val(ui.item.designation);
					  	$(id + 'description').val(ui.item.description);
					  	$(id + 'purchasePrice').val(ui.item.purchase);
					  	$(id + 'discountSupplier').val(ui.item.discountSupplier);
					  	$(id + 'expenseRatio').val(ui.item.expenseRatio);
					  	
					  	$(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
					  	$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? $("#quote_vatTransmitter").val() : $("#quote_vat").val());
					  	$(id + 'shipping').val(ui.item.shipping).change();
					  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
				      return false;
				  }
				});
			  $(line + "_quantity").change();

		  
		  }
	   
	   	  , totalQuote : function(e) {
		   		e.stopPropagation()
		        e.preventDefault()
	   		  	var line = "#" + this.$element.attr('id');
		   		var qty = parseInt($(line + "_quantity").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var pp = parseFloat($(line + "_purchasePrice").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var ds = parseFloat($(line + "_discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var er = parseFloat($(line + "_expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var sh = parseFloat($(line + "_shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var up = parseFloat($(line + "_unitPrice").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var dc = parseInt($(line + "_discount").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var totalunit = up*(1-dc);
		   		var total = qty*totalunit;
		   		var coef = ((totalunit-sh)/(pp*(1-ds)*(1+er)))-1;
		   		$(line + "_quantity").val(number_format(qty,0,',',' '));
			  	$(line + '_coef').val(number_format(coef*100,2,',',' '));
		   		$(line + "_unitPrice").val(number_format(up,2,',',' '));
		   		$(line + "_discount").val(number_format(dc*100,0,',',' '));
		   		$(line + "_total").html(number_format(total,2,',',' '));
		   		$(line).change();
		   		return this;
	   	  }
	   	  , totalCoding : function(e) {
	   		e.stopPropagation()
	        e.preventDefault()
	        var line = "#" + this.$element.attr('id');
	   		var qty = parseInt($(line + "_quantity").val().replace(',','.').replace(/[\s]{1,}/g,""));
	   		var pp = parseFloat($(line + "_purchasePrice").val().replace(',','.').replace(/[\s]{1,}/g,""));
	   		var ds = parseFloat($(line + "_discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
	   		var er = parseFloat($(line + "_expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
	   		var sh = parseFloat($(line + "_shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
	   		var coef = parseFloat($(line + "_coef").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
	   		var dc = parseInt($(line + "_discount").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
	   		var up = (pp*(1-ds)*(1+er))*(1+coef)+sh;
	   		var total = qty*(up*((100-dc)/100));
	   		$(line + '_purchasePrice').val(number_format(pp,2,',',' '));
		  	$(line + '_discountSupplier').val(number_format(ds*100,0,',',' '));
		  	$(line + '_expenseRatio').val(number_format(er*100,0,',',' '));
		  	$(line + '_shipping').val(number_format(sh,2,',',' '));
		  	$(line + '_coef').val(number_format(coef*100,2,',',' '));
	   		$(line + "_unitPrice").val(number_format(up,2,',',' '));
	   		$(line + "_total").html(number_format(total,2,',',' '));
	   		$(line).change();
	   		return this;
	   	  }
	   	  ,showDesc : function() {
	   		var input = $("#" + this.$element.attr('id') + "_showDescription");
	   		var state = input.val() == '1';
	   		this.$element.find(".show-description > i")
		       .toggleClass("icon-minus-sign",state)
		       .toggleClass("icon-plus-sign",!state);
	   			input.next().toggle(state);	
	   	  }
	   	  , toggleDesc : function(e) {
	   		    e.stopPropagation()
	            e.preventDefault()
	   		  	var input = $("#" + this.$element.attr('id') + "_showDescription")
	   		  	var v = input.val();
	   		    input.val(v == '1' ? '' : '1');
	   		    this.showDesc();
	   		    return false
	   	  }
	   	  
	   	  , remove : function(e) {
		   		e.stopPropagation()
		        e.preventDefault()
		   		this.$element.fadeOut(500,function(){
		   			$("#" + $(this).attr('id') + "_purchasePrice").val(0);
		   			$("#" + $(this).attr('id') + "_shippingPrice").val(0);
		   			$("#" + $(this).attr('id') + "_unitPrice").val(0).change();
		   			$(this).remove();
		   		});
				return this;
	   	  }
	   }

	  
	  /* QUOTELINE PLUGIN DEFINITION
	   * =========================== */

	  $.fn.quoteline = function (option) {
	    return this.each(function () {
	      var $this = $(this)
	        , data = $this.data('quoteline')
	        , options = typeof option == 'object' && option
	      if (!data) $this.data('quoteline', (data = new QuoteLine(this, options)))
	      if (typeof option == 'string') data[option]()
	    })
	  }

	  $.fn.quoteline.defaults = {
			 autoSource:'',
			 line:0,
	  }

	  $.fn.quoteline.Constructor = QuoteLine

	}(window.jQuery);
	