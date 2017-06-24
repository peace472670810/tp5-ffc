/*
* Name:xuForm0.1
* Author xuwei
* Email xuwei0930@gmail.com
* Date: 2012-12-13
* 简单的表单美化插件
*API==================
wid    //自定义  自适应（100%）
*/

(function($){
    $.fn.xuForm = function(options){
        var defaults = {
            wid       :"default"    //default auto
        };
        var options = $.extend(defaults, options);
		this.each(function(){
			currt=$(this);
			
			//input===========================================================================
			currt.find('input[type="text"],input[type="password"]').addClass("xuInput")
			.focus(function(){$(this).addClass("xuInputHover")})
			.blur(function(){$(this).removeClass("xuInputHover")});
			if(options.wid=="default"){
			}else if(options.wid=="auto"){
				currt.find('input[type="text"],input[type="password"]').addClass("xuAuto");
			}
			;
			
			//select===========================================================================
			currt.find("select").each(function(index,element){
				sel=$(element);
				$(element).attr("id","xuSelect"+index).hide();//隐藏select
				var selNum=$(element).find("option");
				if(options.wid=="default"){
					$sel=$("<div>").addClass("xuSelect").css({"width":sel.width()+"px"}).attr("ins",index).insertAfter(sel);
					selTxt='<span class="xuSelect-fa"><span class="xuSelect-currt">'+sel.find("option:selected").text()+'</span><i></i></span><ul class="xuSelect-son" style="width:175px;">';
				}else if(options.wid=="auto"){
					$sel=$("<div>").addClass("xuSelect").css({"width":"100%"}).attr("ins",index).insertAfter(sel);
					selTxt='<span class="xuSelect-fa"><span class="xuSelect-currt">'+sel.find("option:selected").text()+'</span><i></i></span><ul class="xuSelect-son" style="width:175px;">';
				}
				selNum.each(function(index1,element1){
					selTxt+='<li order="'+index1+'" value="'+$(element1).val()+'">'+$(element1).text()+'</li>';
				})
				selTxt+='</ul>';
				$sel.append(selTxt);
			})
				//点击弹出option
			$('.xuSelect-fa').click(function(){
				var fa=$(this);
				var son=$(this).next(".xuSelect-son");
				if($(this).next(".xuSelect-son").css('display')=='none'){$(".xuSelect-son").hide();} 
				if(currt.attr('disabled')){return false;}
				son.toggle().find("li.checked").removeClass("checked")
				son.find("li:odd").addClass("odd");
				if(!fa.find(".xuSelect-currt").attr("order")){
					son.find("li[order=0]").addClass("checked");
				}else{
					son.find("li[order="+fa.find(".xuSelect-currt").attr("order")+"]").addClass("checked");
				}
				bodyClick(fa);
				return false;
			})
	
	
				//弹出option之后点击事件
			var bodyClick =function(obj){
				var ins=obj.parent(".xuSelect").attr("ins");
				$('body').click(function(e){
					var e=e?e:window.event;
					var tar = e.srcElement||e.target;
					if($(tar).is(".xuSelect-son>li")){
						obj.find(".xuSelect-currt").html($(tar).text());
						obj.find(".xuSelect-currt").attr("order",$(tar).attr("order"));
						$("#xuSelect"+ins).find("option").eq($(tar).attr("order")).attr("selected", true);
						obj.next(".xuSelect-son").hide();
						$('body').unbind("click");
					}else if($(tar).is(".xuSelect-son")){
						return false;
					}else{
						obj.next(".xuSelect-son").hide();
						$('body').unbind("click");
					}	
				})
			}
		//textarea===========================================================================
		currt.find("textarea").addClass("xuTextarea")
		.focus(function(){$(this).addClass("xuTextareaHover")})
		.blur(function(){$(this).removeClass("xuTextareaHover")});
		if(options.wid=="default"){
			
		}else if(options.wid=="auto"){
			currt.find("textarea").addClass("xuAuto");
		}
		//checkbox===========================================================================
		currt.find("input[type='checkbox']").each(function(index,element){
			$(element).hide();
			$checkbox=$('<span>').addClass("xuCheckBox").insertAfter(element);
			if($(element).attr("checked")){
				$checkbox.attr("checked","checked");
				$checkbox.attr("checked","checked").html("<i class='xuichecked'></i>");
			}
			$checkbox.bind("click",function(){
				if(!$(this).attr("checked")){//没选中
					$(this).attr("checked","checked").html("<i class='xuichecked'></i>");
					$(element).attr("checked",true);
				}else{
					$(this).removeAttr("checked").html("");	
					$(element).removeAttr("checked");
				}
			});
		})
		//radio=============================================================================
		currt.find("input[type='radio']").each(function(index,element){
			$(element).hide();
			$radio=$('<span>').addClass("xuRadio").attr("name",$(element).attr("name")).insertAfter(element);
			if($(element).attr("checked")){
				$radio.attr("checked","checked");
				$radio.attr("checked","checked").html("<i class='xuiRadio'></i>");
			}
			$radio.bind("click",function(){
				if(!$(this).attr("checked")){//没选中
					currt.find("input[type='radio'][name="+$(this).attr("name")+"]").removeAttr("checked");
					currt.find(".xuRadio[name="+$(this).attr("name")+"]").html("").removeAttr("checked");
					$(this).attr("checked","checked").html("<i class='xuiRadio'></i>");
					$(element).attr("checked",true);
				}
			})
		})
		//submit========================================================================
		currt.find("input[type='submit']").addClass("xuSubmit")
		//button========================================================================
		currt.find("input[type='button'],input[type='reset']").addClass("xuButton")
			
			
		})

    };
})(jQuery);