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
		  
		  	$("#quote_paymentRules").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:PaymentModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			$("#quote_deliveryRules").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:DelayModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			
			$("#quote_intro").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:IntroModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			
			this.$element.find("#quote_lines > tr").on('change',$.proxy(this.total,this)).quoteline({
				autoSource:this.options.autoSource,
			}); 
			$("#quote_discount").on('change',$.proxy(this.total,this));
			$(".newline").on('click',$.proxy(this.newline,this));
			$("#quote_lines > tr").change();
			$("#quote_lines").sortable({
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
			var lineList = $("#quote_lines");
			var newWidget = lineList.attr('data-prototype');
			newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
			lineList.append(newWidget);
			$("#quote_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).quoteline({
				autoSource:this.options.autoSource
			});
			// Valeurs par défaut
			$("#quote_lines_" + this.options.lineCount + "_position").val(this.options.lineCount);
			$("#quote_lines_" + this.options.lineCount + "_description").hide();
			$("#quote_lines_" + this.options.lineCount + "_showDescription").val(0);
			$("#quote_lines_" + this.options.lineCount + "_quantity").val(1);
			$("#quote_lines_" + this.options.lineCount + "_discount").val(0);
			$("#quote_lines_" + this.options.lineCount + "_vat").val($("#quote_vat").val());
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
   	 , vatchange : function(e) {
   		e.stopPropagation()
		e.preventDefault()
		var v = parseFloat($("#quote_vat").val().replace(',','.'));
   		$("#quote_vat").val(number_format(v,1,',',' '));
		$.each($("#quote_lines > tr"),function(key,value) {
						var vatid = "#" + $(value).attr('id') + "_vat";
						var transmitter = "#" + $(value).attr('id') + "_isTransmitter";
						$(vatid).val($(transmitter).val() == '1' ? number_format($("#quote_vatTransmitter").val()*100,1,',',' ') : $("#quote_vat").val());
					})
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
			  this.showDesc();
			  $(line + "_quantity, " + line + "_unitPrice, " + line + "_discount").on('change',$.proxy(this.total,this));
			
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
						  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
						  	$(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
						  	$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? number_format($("#quote_vatTransmitter").val()*100,1,',',' ') : $("#quote_vat").val())
						
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
					  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
					  	$(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
					  	$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? number_format($("#quote_vatTransmitter").val()*100,1,',',' ') : $("#quote_vat").val())
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
	