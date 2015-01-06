/**
 * Bill plugin
 */

!function($){

	"use strict"; // jshint ;_;

	/* BILL PUBLIC CLASS DEFINITION
	 * ================================= */

	var Bill = function (element, options) {
		this.$element = $(element)
		this.options = $.extend({}, $.fn.bill.defaults, options)
		this.listen()
	}

	Bill.prototype = {
			constructor: Bill

			, listen : function() {
				$("#jlm_commerce_bill_vat").on('change', $.proxy(this.vatchange,this)).change();

				$("#jlm_commerce_bill_site").attr('data-source',this.options.autoSource)
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
					$("#jlm_commerce_bill_siteObject").val(ui.item.id);
					$("#jlm_commerce_bill_site").val(ui.item.siteCp);
					$("#jlm_commerce_bill_vat").val(number_format(ui.item.vat*100,1,',',' ')).change();
					$("#jlm_commerce_bill_trustee").val(ui.item.trustee);
					$("#jlm_commerce_bill_prelabel").val(ui.item.prelabel);
					$("#jlm_commerce_bill_trusteeName").val(ui.item.trusteeBillingLabel);
					$("#jlm_commerce_bill_trusteeAddress").val(ui.item.trusteeBillingAddress);
					$("#jlm_commerce_bill_accountNumber").val(ui.item.accountNumber);
					$("#jlm_commerce_bill_reference").val(ui.item.reference);
					$("#jlm_commerce_bill_details").val(ui.item.doorDetails);
					return false;
				}
				});

				$("#jlm_commerce_bill_details").attr('data-source',this.options.autoSource)
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
					$("#jlm_commerce_bill_siteObject").val(ui.item.id);
					$("#jlm_commerce_bill_site").val(ui.item.siteCp);
					$("#jlm_commerce_bill_details").val(ui.item.doorDetails)
					$("#jlm_commerce_bill_vat").val(number_format(ui.item.vat*100,1,',',' ')).change();
					$("#jlm_commerce_bill_trustee").val(ui.item.trustee);
					$("#jlm_commerce_bill_prelabel").val(ui.item.prelabel);
					$("#jlm_commerce_bill_trusteeName").val(ui.item.trusteeBillingLabel);
					$("#jlm_commerce_bill_trusteeAddress").val(ui.item.trusteeBillingAddress);
					$("#jlm_commerce_bill_accountNumber").val(ui.item.accountNumber);
					$("#jlm_commerce_bill_reference").val(ui.item.reference);
					$("#jlm_commerce_bill_details").val(ui.item.doorDetails);
					$("#jlm_commerce_bill_reference").val(ui.item.reference);
					return false;
				}
				});

				$("#jlm_commerce_bill_trusteeName").attr('data-source',this.options.autoSource)
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
					$("#jlm_commerce_bill_trustee").val(ui.item.trustee);
					$("#jlm_commerce_bill_trusteeName").val(ui.item.trusteeBillingLabel);
					$("#jlm_commerce_bill_trusteeAddress").val(ui.item.trusteeBillingAddress);
					$("#jlm_commerce_bill_accountNumber").val(ui.item.accountNumber);
					return false;
				}
				});
				$("#jlm_commerce_bill_property").attr('data-source',this.options.autoSource).autocomplete({
					source: function(request,response){
						request.repository = 'JLMCommerceBundle:PropertyModel';
						return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
					}});
				$("#jlm_commerce_bill_earlyPayment").attr('data-source',this.options.autoSource).autocomplete({
					source: function(request,response){
						request.repository = 'JLMCommerceBundle:EarlyPaymentModel';
						return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
					}});
				$("#jlm_commerce_bill_penalty").attr('data-source',this.options.autoSource).autocomplete({
					source: function(request,response){
						request.repository = 'JLMCommerceBundle:PenaltyModel';
						return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
					}});

				$("#jlm_commerce_bill_intro").attr('data-source',this.options.autoSource).autocomplete({
					source: function(request,response){
						request.repository = 'JLMCommerceBundle:IntroBillModel';
						return $.post(this.element.attr('data-source'),request,function( data ) { response( data ); },'json');
					}});
				this.$element.find("#jlm_commerce_bill_lines > tr").on('change',$.proxy(this.total,this)).billline({
					autoSource:this.options.autoSource,
				});
				$("#jlm_commerce_bill_discount").on('change',$.proxy(this.total,this));
				$(".newline").on('click',$.proxy(this.newline,this));
				$("#jlm_commerce_bill_lines > tr").change();
				$("#jlm_commerce_bill_lines").sortable({
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
		var v = parseFloat($("#jlm_commerce_bill_vat").val().replace(',','.'));
		$("#jlm_commerce_bill_vat").val(number_format(v,1,',',' '));	
		// boucle pour changer la tva sur toute les lignes (sauf emetteurs)
		$("#jlm_commerce_bill_lines tr").each(function() {
			if ($('#' + $(this).attr('id') + '_isTransmitter').val() == 0)
				$('#' + $(this).attr('id') + '_vat').val($("#jlm_commerce_bill_vat").val());
			else
				$('#' + $(this).attr('id') + '_vat').val(number_format($("#jlm_commerce_bill_vatTransmitter").val() * 100,',',' '));
			$('#' + $(this).attr('id')).change();
		});
	}
	, newline : function(e){
		e.stopPropagation()
		e.preventDefault()
		var lineList = $("#jlm_commerce_bill_lines");
		var newWidget = lineList.attr('data-prototype');
		newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
		lineList.append(newWidget);
		$("#jlm_commerce_bill_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).billline({
			autoSource:this.options.autoSource
		});
		// Valeurs par défaut
		$("#jlm_commerce_bill_lines_" + this.options.lineCount + "_position").val(this.options.lineCount);
		$("#jlm_commerce_bill_lines_" + this.options.lineCount + "_description").hide();
		$("#jlm_commerce_bill_lines_" + this.options.lineCount + "_showDescription").val(0);
		$("#jlm_commerce_bill_lines_" + this.options.lineCount + "_quantity").val(1);
		$("#jlm_commerce_bill_lines_" + this.options.lineCount + "_discount").val(0);
		$("#jlm_commerce_bill_lines_" + this.options.lineCount + "_vat").val($("#jlm_commerce_bill_vat").val());
		this.options.lineCount++;
		return this;
	}
	, total : function(e) {
		e.stopPropagation()
		e.preventDefault()

		var tht = 0;
		var tva = 0;
		$.each($("#jlm_commerce_bill_lines > tr"),function(){
			var thtline = parseFloat($("#" + this.id + "_total").html().replace(',','.').replace(' ',''));
			var tvaline = parseFloat($("#" + this.id + "_vat").val().replace(',','.').replace(' ',''))/100;
			var qtyline = parseFloat($("#" + this.id + "_quantity").val().replace(',','.').replace(' ',''));
			tht += thtline;
			tva += (thtline * tvaline);
		});
		var dis = parseFloat($("#jlm_commerce_bill_discount").val().replace(',','.').replace(' ',''))/100;
		$("#jlm_commerce_bill_total_htbd").html(number_format(tht,2,',',' '));
		$("#jlm_commerce_bill_total_discount").html(number_format(tht*dis,2,',',' '));	
		tht -= tht*dis;
		tva -= tva*dis;
		$("#jlm_commerce_bill_total_ht").html(number_format(tht,2,',',' '));
		$("#jlm_commerce_bill_total_tva").html(number_format(tva,2,',',' '));
		$("#jlm_commerce_bill_total_ttc").html(number_format(tht+tva,2,',',' '));
		return this;
	}
	}

	/* BILL PLUGIN DEFINITION
	 * =========================== */

	$.fn.bill = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('jlm_commerce_bill')
			, options = typeof option == 'object' && option
			if (!data) $this.data('jlm_commerce_bill', (data = new Bill(this, options)))
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
				$(line + "_vat").on('change', $.proxy(this.vatchange,this));
				
				$(line + "_reference").attr('data-source',this.options.autoSource)
				.autocomplete({
					source: function(request,response){
						request.repository = 'JLMProductBundle:Product';
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
					$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? number_format($("#jlm_commerce_bill_vatTransmitter").val() * 100,',',' ') : $("#jlm_commerce_bill_vat").val());
					$(id + 'unitPrice').val(ui.item.unitPrice).change();

					return false;
				}
				});
				$(line + "_designation").attr('data-source',this.options.autoSource)
				.autocomplete({
					source: function(request,response){
						request.repository = 'JLMProductBundle:Product';
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
					$(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? number_format($("#jlm_commerce_bill_vatTransmitter").val() * 100,',',' ') : $("#jlm_commerce_bill_vat").val());
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
	, vatchange : function(e) {
		e.stopPropagation()
		e.preventDefault()
		var line = "#" + this.$element.attr('id');
		var v = parseFloat($(line + "_vat").val().replace(',','.'));
		$(line + "_vat").val(number_format(v,1,',',' '));
		$(line).change();

	}
}


	/* BILLLINE PLUGIN DEFINITION
	 * =========================== */

	$.fn.billline = function (option) {
		return this.each(function () {
			var $this = $(this)
			, data = $this.data('jlm_commerce_bill_line')
			, options = typeof option == 'object' && option
			if (!data) $this.data('jlm_commerce_bill_line', (data = new BillLine(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.billline.defaults = {
			autoSource:'',
			line:0,
	}

	$.fn.billline.Constructor = BillLine

}(window.jQuery);
