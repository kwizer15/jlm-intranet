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
		  $('#quote_followerCp').typeahead.attr('autocomplete','off').typeahead({
				source:['Yohann Martinez','Emmanuel Bernaszuk','Jean-Louis Martinez','Nadine Martinez','Aurélie Costalat']
			
		  });
		  $("#quote_doorCp").attr('autocomplete','off').typeahead({
				  source: function(query,process){return $.post(this.doorsSource,{'query':query},function (data) { return process(data.options);},'json');}
		  		, select: function() {
		  			var val = this.$menu.find('.active').attr('data-value').split('|'):
		  			$("#quote_door").val(val[0]).change();
		  			this.$element.val(val[1]).change();
				    $("#quote_trustee").val(val[2]).change();
				    $("#quote_trusteeName").val(val[3]).change();
				    $("#quote_trusteeAddress").val(val[4]).change();
		  	      return this.hide()
		  		}
			    , matcher: function (item) {
			    	var m = item.split('|');
			    	item = m[1];
			        return ~item.toLowerCase().indexOf(this.query.toLowerCase())
			      }

			    , highlighter: function (item) {
			        var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
			        var m = item.split('|');
				      item = m[1];
			        return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
			          return '<strong>' + match + '</strong>'
			        })
			      },
			    items:12,});
		  	$("#quote_paymentRules").attr('autocomplete','off').typeahead({
				source:['à réception de la facture', '30% à la commande, le solde fin de travaux']
			});
			$("#quote_deliveryRules").attr('autocomplete','off').typeahead({
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
	 doorsSource:'',
	 trusteesSource:'',
	 paymentSource:'',
	 delaySource:'',
  }

  $.fn.quote.Constructor = Quote

}(window.jQuery);


$(this.element + " .showDescription").click(this.toggleDescription)
		$(this.element + " .remove-line").click(this.remove);
		$(this.element + "_quantity").change(this.update);
		$(this.element + "_unitPrice").change(this.update);
		$(this.element + "_discount").change(this.update);
		$(this.element + "_vat").change(this.update);
		$(this.element + "_reference").attr('autocomplete','off').typeahead({
			source: function(query,process){
				return $.post(
					'{{ path('quote_auto_product_reference') }}',
					{'query':query}, 
					function (data) { return process(data.options);},
					'json'
				);
		    }
		    , updater: function (item) {
			    var m = item.split('|');
			    var line = "#" + this.$element.parent().parent().parent().attr("id");
			    $(line + "_designation").val(m[2]);
			    $(line + "_description").val(m[3]);
			    $(line + "_unitPrice").val(m[4]);
			    $(line + "_vat").val(m[5]);
			    this.update();
			    return m[2];
		      }
		    , matcher: function (item) {
		    	var m = item.split('|');
		    	item = m[1];
		        return ~item.toLowerCase().indexOf(this.query.toLowerCase())
		      }

		    , highlighter: function (item) {
		        var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
		        var m = item.split('|');
			      item = m[2];
		        return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
		          return '<strong>' + match + '</strong>'
		        })
		      },
		    items:12,});
		$(this.element + "_designation").attr('autocomplete','off').typeahead({
			source: function(query,process){
				return $.post(
					'{{ path('quote_auto_product_designation') }}',
					{'query':query}, 
					function (data) { return process(data.options);},
					'json'
				);
		    }
		    , updater: function (item) {
			    var m = item.split('|');
			    var line = "#" + this.$element.parent().parent().parent().attr("id");
			    $(line + "_reference").val(m[1]);
			    $(line + "_description").val(m[3]);
			    $(line + "_unitPrice").val(m[4]);
			    $(line + "_vat").val(m[5]);
			    $(line + "_unitPrice").change();
			    return m[2];
		      }
		    , matcher: function (item) {
		    	var m = item.split('|');
		    	item = m[2];
		        return ~item.toLowerCase().indexOf(this.query.toLowerCase())
		      }

		    , highlighter: function (item) {
		        var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
		        var m = item.split('|');
			      item = m[2];
		        return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
		          return '<strong>' + match + '</strong>'
		        })
		      },
		    items:12,});