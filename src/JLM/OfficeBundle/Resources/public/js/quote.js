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
		  $('#quote_followerCp').autocomplete({
				source:['Yohann Martinez','Emmanuel Bernaszuk','Jean-Louis Martinez','Nadine Martinez','Aurélie Costalat']
			});
		  
		  
		  $("#quote_doorCp").attr('data-source',this.options.doorsSource)
		                    .autocomplete({
				source: function(request,response){
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
				    $("#quote_trustee").val(ui.item.trustee);
				    $("#quote_trusteeName").val(ui.item.trusteeName);
				    $("#quote_trusteeAddress").val(ui.item.trusteeAddress);
			        return false;
			    }
		  });
		  
		  	$("#quote_paymentRules").autocomplete({
				source:['à réception de la facture', '30% à la commande, le solde fin de travaux']
			});
			$("#quote_deliveryRules").autocomplete({
				source:['10 à 15 jours après accord','3 à 5 semaines après accord']
			});
			
			$("#quote_intro").attr('data-source',this.options.introSource).autocomplete({
				source: function(request,response){
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			
			this.$element.find("#quote_lines > tr").on('change',$.proxy(this.total,this)).quoteline({
				referenceSource:this.options.lineReferenceSource,
				designationSource:this.options.lineDesignationSource,
			});
			$("#quote_discount").on('change',$.proxy(this.total,this));
			$(".add-line").on('click',$.proxy(this.newline,this));
			$("#quote_lines > tr").change();
	  }
   
   	 , newline : function(e){
   		 	e.stopPropagation()
   		 	e.preventDefault()
			var lineList = this.$element.find("tbody");
			var newWidget = lineList.attr('data-prototype');
			newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
			lineList.append(newWidget);
			$("#quote_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).quoteline({
				referenceSource:this.options.lineReferenceSource,
				designationSource:this.options.lineDesignationSource
			});
			this.options.lineCount++;
			return this;
		}
   	 , total : function(e) {
   		 e.stopPropagation()
		 e.preventDefault()
		 var tht = 0;
   		 var tva = 0;
		 $.each($("#quote_lines > tr"),function(){
			 var thtline = parseFloat($("#" + this.id + "_total").html().replace(',','.').replace(' ',''));
			 var tvaline = parseFloat($("#" + this.id + "_vat").val().replace(',','.').replace(' ',''))/100;
			 tht += thtline;
			 tva += (thtline * tvaline);
		 });
		 var dis = parseFloat($("#quote_discount").val().replace(',','.').replace(' ',''))/100;
		 $("#quote_total_htbd").html(number_format(tht,2,',',' '));
		 $("#quote_total_discount").html(number_format(tht*dis,2,',',' '));	
		 tht -= tht*dis;
		 tva -= tva*dis;
		 $("#quote_total_ht").html(number_format(tht,2,',',' '));
		 $("#quote_total_tva").html(number_format(tva,2,',',' '));
		 $("#quote_total_ttc").html(number_format(tht+tva,2,',',' '));
		 return this;
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
	 followersSource:'',
	 doorsSource:'',
	 trusteesSource:'',
	 paymentSource:'',
	 delaySource:'',
	 introSource:'',
	 
	 lineCount:0,
	 lineReferenceSource:'',
	 lineDesignationSource:'',
  }

  $.fn.quote.Constructor = Quote

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
			  $(line + "_quantity, " + line + "_unitPrice, " + line + "_discount").on('change',$.proxy(this.total,this));
			
			  $(line + "_reference").attr('data-source',this.options.referenceSource)
					              .autocomplete({
						source: function(request,response){
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
						  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
					      return false;
					  }
				});
			  $(line + "_designation").attr('data-source',this.options.designationSource)
				              .autocomplete({
					source: function(request,response){
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
					  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
				      return false;
				  }
				});
			  $(line + "_quantity").change();
		  
		  }
	   
	   	  , total : function(e) {
		   		e.stopPropagation()
		        e.preventDefault()
	   		  	var line = "#" + this.$element.attr('id');
		   		var qty = parseInt($(line + "_quantity").val().replace(',','.').replace(' ',''));
		   		var up = parseFloat($(line + "_unitPrice").val().replace(',','.').replace(' ',''));
		   		var dc = parseInt($(line + "_discount").val().replace(',','.').replace(' ',''));
		   		var total = qty*(up*((100-dc)/100));
		   		$(line + "_quantity").val(number_format(qty,0,',',' '));
		   		$(line + "_unitPrice").val(number_format(up,2,',',' '));
		   		$(line + "_discount").val(number_format(dc,0,',',' '));
		   		$(line + "_total").html(number_format(total,2,',',' '));
		   		$(line).change();
		   		return this;
	   	  }
	   	  
	   	  , toggleDesc : function() {
	   		  	var input = $("#" + this.$element.attr('id') + "_showDescription");
	   		  	input.attr('test','test');
		   		var plus = (input.attr('value') != 1);
		   		this.$element.find(".show-description > i")
				       .toggleClass("icon-minus-sign",plus)
				       .toggleClass("icon-plus-sign",!plus);
				input.attr('value',plus?'1':'0')
				       .next().slideToggle();
			    return false;
	   	  }
	   	  
	   	  , remove : function(e) {
		   		e.stopPropagation()
		        e.preventDefault()
		   		this.$element.fadeOut(500,function(){
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
			 referenceSource:'',
			 designationSource:'',
			 line:0,
	  }

	  $.fn.quoteline.Constructor = QuoteLine

	}(window.jQuery);
	