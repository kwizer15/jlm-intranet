/**
 * Coding plugin
 */

!function ($) {

    "use strict"; // jshint ;_;
  
  /* CODING PUBLIC CLASS DEFINITION
   * ================================= */

    var Coding = function (element, options) {
        this.$element = $(element)
        this.options = $.extend({}, $.fn.coding.defaults, options)
        this.listen()
    }
  
    Coding.prototype = {
        constructor: Coding
      
        , listen : function () {
            $("#coding_vat").on('change', $.proxy(this.vatchange,this));
          
            $('#coding_followerCp').autocomplete({
                source:['Yohann Martinez','Emmanuel Bernaszuk','Jean-Louis Martinez','Nadine Martinez','Aurélie Costalat']
              });
          
          
            $("#coding_doorCp").attr('data-source',this.options.autoSource)
                            .autocomplete({
                                source: function (request,response) {
                                    request.repository = 'JLMModelBundle:Door';
                                    return $.post(
                                        this.element.attr('data-source'),
                                        request,
                                        function ( data ) {
                                                response(data); },
                                        'json'
                                    );
                                }
                , select: function (event, ui) {
                    $("#coding_door").val(ui.item.door);
                    $("#coding_doorCp").val(ui.item.label);
                    $("#coding_vat").val(number_format(ui.item.vat*100,1,',',' ')).change();
                    $("#coding_trustee").val(ui.item.trustee);
                    $("#coding_trusteeName").val(ui.item.trusteeName);
                    $("#coding_trusteeAddress").val(ui.item.trusteeAddress);
                    $("#coding_contact").val('');
                    $("#coding_contactCp").val('');
                    return false;
                }
                            });
          
            $("#coding_trusteeName").attr('data-source',this.options.autoSource)
                    .autocomplete({
                        source: function (request,response) {
                            request.repository = 'JLMModelBundle:Trustee';
                            return $.post(
                                this.element.attr('data-source'),
                                request,
                                function ( data ) {
                                    response(data); },
                                'json'
                            );
                        }
                , select: function (event, ui) {
                    $("#coding_trustee").val(ui.item.trustee);
                    $("#coding_trusteeName").val(ui.item.label);
                    $("#coding_trusteeAddress").val(ui.item.trusteeAddress);
                    return false;
                }
                    });
          
            $("#coding_contactCp").attr('data-source',this.options.autoSource)
                              .autocomplete({
                                    source: function (request,response) {
                                        request.term = $('#coding_door').val();
                                        request.repository = 'JLMModelBundle:SiteContact';
                                        return $.post(
                                            this.element.attr('data-source'),
                                            request,
                                            function ( data ) {
                                                    response(data); },
                                            'json'
                                        );
                                    }
                    , select: function (event, ui) {
                        $("#coding_contact").val(ui.item.id);
                        $("#coding_contactCp").val(ui.item.name);
                        return false;
                    }
                                });
          
            
            this.$element.find("#coding_lines > tr").on('change',$.proxy(this.total,this)).codingline({
                autoSource:this.options.autoSource,
              });
            $("#coding_discount").on('change',$.proxy(this.total,this));
            $(".newline").on('click',$.proxy(this.newline,this));
            $("#coding_lines > tr").change();
            $("#coding_lines").sortable({
                update: function (e,ui) {
                    $.each($(this).children(),function (key,value) {
                        var posid = "#" + $(value).attr('id') + "_position";
                        $(posid).val(key);
                    })
                }
              });
        
            
        }
        , newline : function (e) {
            e.stopPropagation()
            e.preventDefault()
            var lineList = $("#coding_lines");
            var newWidget = lineList.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g,this.options.lineCount);
            lineList.append(newWidget);
            $("#coding_lines_" + this.options.lineCount).on('change',$.proxy(this.total,this)).codingline({
                autoSource:this.options.autoSource
                });
            // Valeurs par défaut (voir ici)
            $("#coding_lines_" + this.options.lineCount + "_position").val(this.options.lineCount);
            $("#coding_lines_" + this.options.lineCount + "_quantity").val(1);
            $("#coding_lines_" + this.options.lineCount + "_purchase").val(0);
            $("#coding_lines_" + this.options.lineCount + "_discountSupplier").val(0);
            $("#coding_lines_" + this.options.lineCount + "_expenseRatio").val(10);
            $("#coding_lines_" + this.options.lineCount + "_shipping").val(0);
            $("#coding_lines_" + this.options.lineCount + "_vat").val($("#coding_vat").val());
            this.options.lineCount++;
            return this;
        }
        , total : function (e) {
            e.stopPropagation()
            e.preventDefault()
            var tht = 0;
            var tva = 0;
            $.each($("#coding_lines > tr"),function () {
                var thtline = parseFloat($("#" + this.id + "_total").html().replace(',','.').replace(' ',''));
                var tvaline = parseFloat($("#" + this.id + "_vat").val().replace(',','.').replace(' ',''))/100;
                tht += thtline;
                tva += (thtline * tvaline);
            });
            var dis = parseFloat($("#coding_discount").val().replace(',','.').replace(' ',''))/100;
            $("#coding_total_htbd").html(number_format(tht,2,',',' '));
            $("#coding_total_discount").html(number_format(tht*dis,2,',',' '));
            tht -= tht*dis;
            tva -= tva*dis;
            $("#coding_total_ht").html(number_format(tht,2,',',' '));
            $("#coding_total_tva").html(number_format(tva,2,',',' '));
            $("#coding_total_ttc").html(number_format(tht+tva,2,',',' '));
            return this;
        }
        , vatchange : function (e) {
            e.stopPropagation()
            e.preventDefault()
            var v = parseFloat($("#coding_vat").val().replace(',','.'));
            $("#coding_vat").val(number_format(v,1,',',' '));
            $.each($("#coding_lines > tr"),function (key,value) {
                        var vatid = "#" + $(value).attr('id') + "_vat";
                        var transmitter = "#" + $(value).attr('id') + "_isTransmitter";
                        $(vatid).val($(transmitter).val() == '1' ? number_format($("#coding_vatTransmitter").val()*100,1,',',' ') : $("#coding_vat").val());
            })
        }
    }

  
  /* CODING PLUGIN DEFINITION
   * =========================== */

    $.fn.coding = function (option) {
        return this.each(function () {
            var $this = $(this)
            , data = $this.data('quote')
            , options = typeof option == 'object' && option
            if (!data) {
                $this.data('quote', (data = new Coding(this, options)))
                if (typeof option == 'string') {
                    data[option]()
                }
            }
        })
    }

    $.fn.coding.defaults = {
        autoSource:'',
     
        lineCount:0,
        lineReferenceSource:'',
        lineDesignationSource:'',
    }

    $.fn.coding.Constructor = Coding

}(window.jQuery);


/*************************************************************************
 * CodingLine plugin
 */

!function ($) {

      "use strict"; // jshint ;_;
      
      /* QUOTELINE PUBLIC CLASS DEFINITION
       * ================================= */

       var CodingLine = function (element, options) {
         this.$element = $(element)
         this.options = $.extend({}, $.fn.codingline.defaults, options)
         this.listen()
       }
      
       CodingLine.prototype = {
            constructor: CodingLine
          
            , listen : function () {
                var line = "#" + this.$element.attr('id');
                this.$element.find(".remove-line").on('click',$.proxy(this.remove,this));
                $(line + "_quantity, " + line + "_purchase, " + line + "_discountSupplier, " + line + "_expenseRatio, " + line + "_shipping").on('change',$.proxy(this.total,this));
              
                $(line + "_reference").attr('data-source',this.options.autoSource)
                                  .autocomplete({
                                        source: function (request,response) {
                                            request.repository = 'JLMProductBundle:Product';
                                            request.action = 'Reference';
                                            return $.post(
                                                this.element.attr('data-source'),
                                                request,
                                                function ( data ) {
                                                    response(data); },
                                                'json'
                                            );
                                        }
                      , select: function (event, ui) {
                          var id = "#" + this.id.replace("reference","");
                            $(id + 'product').val(ui.item.id);
                            $(id + 'reference').val(ui.item.reference);
                            $(id + 'designation').val(ui.item.designation);
                            $(id + 'purchase').val(ui.item.purchase);
                            $(id + 'discoutSupplier').val(ui.item.discoutSupplier);
                            $(id + 'expenseRatio').val(ui.item.expenseRatio);
                            
                            $(id + 'shipping').val(ui.item.shipping).change();
                            $(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
                            $(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? number_format($("#quote_vatTransmitter").val()*100,1,',',' ') : $("#quote_vat").val())
                        
                          return false;
                      }
                                    });
                $(line + "_designation").attr('data-source',this.options.autoSource)
                              .autocomplete({
                                    source: function (request,response) {
                                        request.repository = 'JLMProductBundle:Product';
                                        request.action = 'Designation';
                                        return $.post(
                                            this.element.attr('data-source'),
                                            request,
                                            function ( data ) {
                                                response(data); },
                                            'json'
                                        );
                                    }
                    , select: function (event, ui) {
                        var id = "#" + this.id.replace("designation","");
                        $(id + 'product').val(ui.item.id);
                        $(id + 'reference').val(ui.item.reference);
                        $(id + 'designation').val(ui.item.designation);
                        $(id + 'purchase').val(ui.item.purchase).change();
                        $(id + 'discoutSupplier').val(ui.item.discoutSupplier).change();
                        $(id + 'expenseRatio').val(ui.item.expenseRatio).change();
                        $(id + 'shipping').val(ui.item.shipping).change();
                        $(id + 'isTransmitter').val(ui.item.transmitter ? '1' : '');
                        $(id + 'vat').val(($(id + 'isTransmitter').val() == '1') ? number_format($("#coding_vatTransmitter").val()*100,1,',',' ') : $("#coding_vat").val())
                        return false;
                    }
                                });
                $(line + "_quantity").change();
          
            }
       
            , total : function (e) {
                e.stopPropagation()
                e.preventDefault()
                
                var line = "#" + this.$element.attr('id');
                var qty = parseInt($(line + "_quantity").val().replace(',','.').replace(/[\s]{1,}/g,""));
                var pu = parseFloat($(line + "_purchase").val().replace(',','.').replace(/[\s]{1,}/g,""));
                var dc = parseInt($(line + "_discountSupplier").val().replace(',','.').replace(/[\s]{1,}/g,""));
                var er = parseInt($(line + "_expenseRatio").val().replace(',','.').replace(/[\s]{1,}/g,""));
                var sh = parseFloat($(line + "_shipping").val().replace(',','.').replace(/[\s]{1,}/g,""));
                
                var total = qty*(pu*((100-dc)/100)*((100+er)/100))+sh;
                $(line + "_quantity").val(number_format(qty,0,',',' '));
                $(line + "_purchase").val(number_format(pu,2,',',' '));
                $(line + "_discountSupplier").val(number_format(dc,0,',',' '));
                $(line + "_expenseRatio").val(number_format(er,0,',',' '));
                $(line + "_shipping").val(number_format(sh,2,',',' '));
                $(line + "_total").html(number_format(total,2,',',' '));
                $(line).change();
                return this;
            }
          
            , remove : function (e) {
                e.stopPropagation()
                e.preventDefault()
                this.$element.fadeOut(500,function () {
                    $("#" + $(this).attr('id') + "_purchase").val(0);
                    $("#" + $(this).attr('id') + "_shipping").val(0).change();
                    $(this).remove();
                });
                return this;
            }
    }

      
      /* QUOTELINE PLUGIN DEFINITION
       * =========================== */

      $.fn.codingline = function (option) {
        return this.each(function () {
            var $this = $(this)
            , data = $this.data('codingline')
            , options = typeof option == 'object' && option
            if (!data) {
                $this.data('codingline', (data = new CodingLine(this, options)))
                if (typeof option == 'string') {
                    data[option]()
                }
            }
        })
      }

      $.fn.codingline.defaults = {
            autoSource:'',
            line:0,
    }

      $.fn.codingline.Constructor = CodingLine

}(window.jQuery);
