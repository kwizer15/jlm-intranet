/**
 * Intervention plugin
 */

!function($){

  "use strict"; // jshint ;_;
  
  /* INTERVENTION PUBLIC CLASS DEFINITION
   * ================================= */

   var Intervention = function (element, options) {
     this.$element = $(element)
     this.options = $.extend({}, $.fn.intervention.defaults, options)
     this.listen()
   }
  
   Intervention.prototype = {
	  constructor: Intervention
	  
	  , listen : function() {
//		  var id = "#" + $("#jlm_dailybundle_fixingtype," +
//					"#jlm_dailybundle_fixingedittype," +
//					"#jlm_dailybundle_worktype," +
//				  	"#jlm_dailybundle_workedittype").attr('id') + "_";
		  var id = "#" + this.$element.attr('id') + "_";
		  console.log(id);
		  $(id + "contactName").attr('data-source',this.options.autoSource)
					          .autocomplete({
					source: function(request,response){
						
						request.term = $(id + 'door').val();
						request.repository = 'JLMModelBundle:SiteContact';
						return $.post(
								this.element.attr('data-source'),
								request,
								function( data ) { response( data ); },
								'json'
						);
					}
					, select: function (event, ui) {
						console.log('3' + id);
					  $(id + "contactName").val(ui.item.name);
					  $(id + "contactPhones").val(ui.item.phones);
					  $(id + "contactEmail").val(ui.item.email);
					  return false;
					}
				});
		  $(id + "place").attr('data-source',this.options.autoSource)
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
				$(id + "door").val(ui.item.door);
				$(id + "place").val(ui.item.doorCp);
				return false;
			}
			});
	  }
   }

  
  /* INTERVENTION PLUGIN DEFINITION
   * =========================== */

  $.fn.intervention = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('intervention')
        , options = typeof option == 'object' && option
      if (!data) $this.data('intervention', (data = new Intervention(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.intervention.defaults = {
	 autoSource:'',
  }

  $.fn.intervention.Constructor = Intervention

}(window.jQuery);