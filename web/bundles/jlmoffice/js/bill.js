/**
 * Bill plugin
 */

!function($){

  "use strict"; // jshint ;_;
  
  /* QUOTE PUBLIC CLASS DEFINITION
   * ================================= */

   var Bill = function (element, options) {
     this.$element = $(element)
     this.options = $.extend({}, $.fn.bill.defaults, options)
     this.listen()
   }
  
   Bill.prototype = {
	  constructor: Bill
	  
	  , listen : function() {
		  $("#bill_vat").on('change', $.proxy(this.vatchange,this)).change();
		  
		  $("#bill_site").attr('data-source',this.options.autoSource)
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
				    $("#bill_site").val(ui.item.siteCp);
				    $("#bill_vat").val(number_format(ui.item.vat*100,1,',',' ')).change();
				    $("#bill_trustee").val(ui.item.trustee);
				    $("#bill_prelabel").val(ui.item.prelabel);
				    $("#bill_trusteeName").val(ui.item.trusteeName);
				    $("#bill_trusteeAddress").val(ui.item.trusteeBillingAddress);
				    $("#bill_accountNumber").val(ui.item.accountNumber);
				    $("#bill_reference").val(ui.item.reference);
				    $("#bill_details").val(ui.item.doorDetails);
				    $("#bill_reference").val(ui.item.reference);
			        return false;
			    }
		  });
		  
		  $("#bill_details").attr('data-source',this.options.autoSource)
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
  $("#bill_site").val(ui.item.siteCp);
  $("#bill_details").val(ui.item.doorDetails)
  $("#bill_vat").val(number_format(ui.item.vat*100,1,',',' ')).change();
  $("#bill_trustee").val(ui.item.trustee);
  $("#bill_prelabel").val(ui.item.prelabel);
  $("#bill_trusteeName").val(ui.item.trusteeName);
  $("#bill_trusteeAddress").val(ui.item.trusteeBillingAddress);
  $("#bill_accountNumber").val(ui.item.accountNumber);
  $("#bill_reference").val(ui.item.reference);
  $("#bill_details").val(ui.item.doorDetails);
  $("#bill_reference").val(ui.item.reference);
  return false;
}
});
		  
		  $("#bill_trusteeName").attr('data-source',this.options.autoSource)
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
				  $("#bill_trustee").val(ui.item.trustee);
				  $("#bill_trusteeName").val(ui.item.label);
				  $("#bill_trusteeAddress").val(ui.item.trusteeBillingAddress);
				  $("#bill_accountNumber").val(ui.item.accountNumber);
				  return false;
				}
			});
		  $("#bill_property").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:PropertyModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			$("#bill_earlyPayment").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:EarlyPaymentModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			$("#bill_penalty").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:PenaltyModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			
			$("#bill_intro").attr('data-source',this.options.autoSource).autocomplete({
				source: function(request,response){
					request.repository = 'JLMOfficeBundle:IntroBillModel';
					return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
			}});
			this.$element.find("#bill_lines > tr").on('change',$.proxy(this.total,this)).billline({
				autoSource:this.options.autoSource,
			});
			$("#bill_discount").on('change',$.proxy(this.total,this));
			$(".newline").on('click',$.proxy(this.newline,this));
			$("#bill_lines > tr").change();
			$("#bill_lines").sortable({
				update: function(e,ui) {
					$.each($(this).children(),function(key,value) {
						var posid = "#" + $(value).attr('id') + "_position";
						$(posid).val(key);
					})
				}
			});
	  }
   	 , vatchange : function(e) {
   		e.stopPropagation()
		e.preventDefault()
		var v = parseFloat($("#bill_vat").val().replace(',','.'));
   		$("#bill_vat").val(number_format(v,1,',',' '));	
   		// boucle pour changer la tva sur toute les lignes (sauf emetteurs)
   	 }
   	, newline : function(e){
		 	e.stopPropagation()
		 	e.preventDefault()
		var lineList = $("#bill_lines");
		var newWidget = lineList.attr('data-prototype');
		newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
		lineList.append(newWidget);
		$("#bill_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).billline({
			autoSource:this.options.autoSource
		});
		// Valeurs par défaut
		$("#bill_lines_" + this.options.lineCount + "_position").val(this.options.lineCount);
		$("#bill_lines_" + this.options.lineCount + "_description").hide();
		$("#bill_lines_" + this.options.lineCount + "_showDescription").val(0);
		$("#bill_lines_" + this.options.lineCount + "_quantity").val(1);
		$("#bill_lines_" + this.options.lineCount + "_discount").val(0);
		$("#bill_lines_" + this.options.lineCount + "_vat").val($("#bill_vat").val());
		this.options.lineCount++;
		return this;
	}
	 , total : function(e) {
		 e.stopPropagation()
	 e.preventDefault()
	
	 var tht = 0;
		 var tva = 0;
	 $.each($("#bill_lines > tr"),function(){
		 var thtline = parseFloat($("#" + this.id + "_total").html().replace(',','.').replace(' ',''));
		 var tvaline = parseFloat($("#" + this.id + "_vat").val().replace(',','.').replace(' ',''))/100;
		 var qtyline = parseFloat($("#" + this.id + "_quantity").val().replace(',','.').replace(' ',''));
		 tht += thtline;
		 tva += (thtline * tvaline);
	 });
	 var dis = parseFloat($("#bill_discount").val().replace(',','.').replace(' ',''))/100;
	 $("#bill_total_htbd").html(number_format(tht,2,',',' '));
	 $("#bill_total_discount").html(number_format(tht*dis,2,',',' '));	
	 tht -= tht*dis;
	 tva -= tva*dis;
	 $("#bill_total_ht").html(number_format(tht,2,',',' '));
	 $("#bill_total_tva").html(number_format(tva,2,',',' '));
	 $("#bill_total_ttc").html(number_format(tht+tva,2,',',' '));
	 return this;
	   
		
	 }
   }

  
  /* BILL PLUGIN DEFINITION
   * =========================== */

  $.fn.bill = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('bill')
        , options = typeof option == 'object' && option
      if (!data) $this.data('bill', (data = new Bill(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.bill.defaults = {
	 autoSource:'',
  }

  $.fn.bill.Constructor = Bill

}(window.jQuery);

/*************************************************************************
 * BillLine plugin
 */

!function($){

	  "use strict"; // jshint ;_;
	  
	  /* BILLLINE PUBLIC CLASS DEFINITION
	   * ================================= */

	   var BillLine = function (element, options) {
	     this.$element = $(element)
	     this.options = $.extend({}, $.fn.billline.defaults, options)
	     this.listen()
	   }
	  
	   BillLine.prototype = {
		  constructor: BillLine
		  
		  , listen : function() {
			  var line = "#" + this.$element.attr('id');
			  this.$element.find(".remove-line").on('click',$.proxy(this.remove,this));
			  this.$element.find(".show-description").on('click',$.proxy(this.toggleDesc,this));
			  this.showDesc();
			  
			  $(line + "_quantity, "
			  + line + "_unitPrice, "
			  + line + "_discount").on('change',$.proxy(this.totalBill,this));
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
						  	$(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
						  	$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? $("#bill_vatTransmitter").val() : $("#bill_vat").val());
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
					  	
					  	
					  	$(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
					  	$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? $("#bill_vatTransmitter").val() : $("#bill_vat").val());
					  	$(id + 'unitPrice').val(ui.item.unitPrice).change();
				      return false;
				  }
				});
			  $(line + "_quantity").change();

		  
		  }
	   
	   	  , totalBill : function(e) {
		   		e.stopPropagation()
		        e.preventDefault()
	   		  	var line = "#" + this.$element.attr('id');
		   		var qty = parseInt($(line + "_quantity").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var up = parseFloat($(line + "_unitPrice").val().replace(',','.').replace(/[\s]{1,}/g,""));
		   		var dc = parseInt($(line + "_discount").val().replace(',','.').replace(/[\s]{1,}/g,""))/100;
		   		var totalunit = up*(1-dc);
		   		var total = qty*totalunit;
		   		$(line + "_quantity").val(number_format(qty,0,',',' '));
		   		$(line + "_unitPrice").val(number_format(up,2,',',' '));
		   		$(line + "_discount").val(number_format(dc*100,0,',',' '));
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

	  
	  /* BILLLINE PLUGIN DEFINITION
	   * =========================== */

	  $.fn.billline = function (option) {
	    return this.each(function () {
	      var $this = $(this)
	        , data = $this.data('billline')
	        , options = typeof option == 'object' && option
	      if (!data) $this.data('billline', (data = new BillLine(this, options)))
	      if (typeof option == 'string') data[option]()
	    })
	  }

	  $.fn.billline.defaults = {
			 autoSource:'',
			 line:0,
	  }

	  $.fn.billline.Constructor = BillLine

	}(window.jQuery);
	