function number_format(f,c,h,e){f=(f+"").replace(",","").replace(" ","");var b=!isFinite(+f)?0:+f,a=!isFinite(+c)?0:Math.abs(c),j=(typeof e==="undefined")?",":e,d=(typeof h==="undefined")?".":h,i="",g=function(o,m){var l=Math.pow(10,m);return""+Math.round(o*l)/l};i=(a?g(b,a):""+Math.round(b)).split(".");if(i[0].length>3){i[0]=i[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,j)}if((i[1]||"").length<a){i[1]=i[1]||"";i[1]+=new Array(a-i[1].length+1).join("0")}return i.join(d)}$(".input-money").on("change",function(){$(this).val(number_format(parseFloat($(this).val().replace(",",".").replace(/[\s]{1,}/g,"")),2,","," "));return this});