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
		  
		  
		  $("#quote_doorCp").attr('data-source',this.options.doorsSource).autocomplete({
				source: function(request,response){
					return $.post(
							$("#quote_doorCp").attr('data-source'),
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
			$(".add-line").click(function(){
				var lineList = $(this).parent().parent().parent().next();
				lineList.addClass('test');
				var newWidget = lineList.attr('data-prototype');
				newWidget = newWidget.replace(/__name__/g,lineCount);
				
				$(lineList).append(newWidget);
				var line = "#quote_lines_" + lineCount;
				QuoteLine(lineCount);
				lineCount++;
				return false;
			});
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
	 doorsSource:'bb',
	 trusteesSource:'',
	 paymentSource:'',
	 delaySource:'',
  }

  $.fn.quote.Constructor = Quote

}(window.jQuery);

//
//$(this.element + " .showDescription").click(this.toggleDescription)
//		$(this.element + " .remove-line").click(this.remove);
//		$(this.element + "_quantity").change(this.update);
//		$(this.element + "_unitPrice").change(this.update);
//		$(this.element + "_discount").change(this.update);
//		$(this.element + "_vat").change(this.update);
//		$(this.element + "_reference").attr('autocomplete','off').typeahead({
//			source: function(query,process){
//				return $.post(
//					'{{ path('quote_auto_product_reference') }}',
//					{'query':query}, 
//					function (data) { return process(data.options);},
//					'json'
//				);
//		    }
//		    , updater: function (item) {
//			    var m = item.split('|');
//			    var line = "#" + this.$element.parent().parent().parent().attr("id");
//			    $(line + "_designation").val(m[2]);
//			    $(line + "_description").val(m[3]);
//			    $(line + "_unitPrice").val(m[4]);
//			    $(line + "_vat").val(m[5]);
//			    this.update();
//			    return m[2];
//		      }
//		    , matcher: function (item) {
//		    	var m = item.split('|');
//		    	item = m[1];
//		        return ~item.toLowerCase().indexOf(this.query.toLowerCase())
//		      }
//
//		    , highlighter: function (item) {
//		        var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
//		        var m = item.split('|');
//			      item = m[2];
//		        return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
//		          return '<strong>' + match + '</strong>'
//		        })
//		      },
//		    items:12,});
//		$(this.element + "_designation").attr('autocomplete','off').typeahead({
//			source: function(query,process){
//				return $.post(
//					'{{ path('quote_auto_product_designation') }}',
//					{'query':query}, 
//					function (data) { return process(data.options);},
//					'json'
//				);
//		    }
//		    , updater: function (item) {
//			    var m = item.split('|');
//			    var line = "#" + this.$element.parent().parent().parent().attr("id");
//			    $(line + "_reference").val(m[1]);
//			    $(line + "_description").val(m[3]);
//			    $(line + "_unitPrice").val(m[4]);
//			    $(line + "_vat").val(m[5]);
//			    $(line + "_unitPrice").change();
//			    return m[2];
//		      }
//		    , matcher: function (item) {
//		    	var m = item.split('|');
//		    	item = m[2];
//		        return ~item.toLowerCase().indexOf(this.query.toLowerCase())
//		      }
//
//		    , highlighter: function (item) {
//		        var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
//		        var m = item.split('|');
//			      item = m[2];
//		        return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
//		          return '<strong>' + match + '</strong>'
//		        })
//		      },
//		    items:12,});