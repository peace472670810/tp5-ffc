$(function(){
	var xOffset = -20; // x distance from mouse
    var yOffset = 20; // y distance from mouse  
	
	
	//input action
	$("[reg],[url]:not([reg]),[tip]").hover(
		function(e) {
			if($(this).attr('tip') != undefined){
				var top = (e.pageY + yOffset);
				var left = (e.pageX + xOffset);
				$('body').append( '<p id="vtip"><span id="vtipArrow"></span>' + $(this).attr('tip') + '</p>' );
				$('p#vtip').css("top", top+"px").css("left", left+"px");
				$('p#vtip').bgiframe();
			}
		},
		function() {
			if($(this).attr('tip') != undefined){
				$("p#vtip").remove();
			}
		}
	).mousemove(
		function(e) {
			if($(this).attr('tip') != undefined){
				var top = (e.pageY + yOffset);
				var left = (e.pageX + xOffset);
				$("p#vtip").css("top", top+"px").css("left", left+"px");
			}
		}
	).blur(function(){
		if($(this).attr("url") != undefined){
			ajax_validate($(this));
		}else if($(this).attr("reg") != undefined){
			validate($(this));
		}
	});
	
	$("form").submit(function(){
		var isSubmit = true;
		$(this).find("[reg],[url]:not([reg])").each(function(){
			if($(this).attr("reg") == undefined){
				if(!ajax_validate($(this))){
					isSubmit = false;
				}
			}else{
				if(!validate($(this))){
					isSubmit = false;
				}
			}
		});
		if(typeof(isExtendsValidate) != "undefined"){
   			if(isSubmit && isExtendsValidate){
				return extendsValidate();
			}
   		}
		return isSubmit;
	});
	
});

function validate(obj){
	var reg = new RegExp(obj.attr("reg"));
	var objValue = obj.attr("value");
	
	if(!reg.test(objValue)){
		change_error_style(obj,"add");
		change_tip(obj,null,"remove");
		return false;
	}else{
		if(obj.attr("url") == undefined){
			change_error_style(obj,"remove");
			change_tip(obj,null,"remove");
			return true;
		}else{
			return ajax_validate(obj);
		}
	}
}

function ajax_validate(obj){
	
	var url_str = obj.attr("url");
	if(url_str.indexOf("?") != -1){
		url_str = url_str+"&"+obj.attr("name")+"="+obj.attr("value");
	}else{
		url_str = url_str+"?"+obj.attr("name")+"="+obj.attr("value");
	}
	var feed_back = $.ajax({url: url_str,cache: false,async: false}).responseText;
	feed_back = feed_back.replace(/(^\s*)|(\s*$)/g, "");
	if(feed_back == 'success'){
		change_error_style(obj,"remove");
		change_tip(obj,null,"remove");
		return true;
	}else{
		change_error_style(obj,"add");
		change_tip(obj,feed_back,"add");
		return false;
	}
}

function change_tip(obj,msg,action_type){
	
	if(obj.attr("tip") == undefined){//初始化判断TIP是否为空
		obj.attr("is_tip_null","yes");
	}
	if(action_type == "add"){
		if(obj.attr("is_tip_null") == "yes"){
			obj.attr("tip",msg);
		}else{
			if(msg != null){
				if(obj.attr("tip_bak") == undefined){
					obj.attr("tip_bak",obj.attr("tip"));
				}
				obj.attr("tip",msg);
			}
		}
	}else{
		if(obj.attr("is_tip_null") == "yes"){
			obj.removeAttr("tip");
			obj.removeAttr("tip_bak");
		}else{
			obj.attr("tip",obj.attr("tip_bak"));
			obj.removeAttr("tip_bak");
		}
	}
}

function change_error_style(obj,action_type){
	if(action_type == "add"){
		obj.addClass("input_validation-failed");
	}else{
		obj.removeClass("input_validation-failed");
	}
}

$.fn.validate_callback = function(msg,action_type,options){
	this.each(function(){
		if(action_type == "failed"){
			change_error_style($(this),"add");
			change_tip($(this),msg,"add");
		}else{
			change_error_style($(this),"remove");
			change_tip($(this),null,"remove");
		}
	});
};
/********************表单验证  jquery.bgiframe.min.js************************/
(function(a){a.fn.bgiframe=(a.browser.msie&&/msie 6\.0/i.test(navigator.userAgent)?function(d){d=a.extend({top:"auto",left:"auto",width:"auto",height:"auto",opacity:true,src:"javascript:false;"},d);var c='<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+d.src+'"style="display:block;position:absolute;z-index:-1;'+(d.opacity!==false?"filter:Alpha(Opacity='0');":"")+"top:"+(d.top=="auto"?"expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+'px')":b(d.top))+";left:"+(d.left=="auto"?"expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+'px')":b(d.left))+";width:"+(d.width=="auto"?"expression(this.parentNode.offsetWidth+'px')":b(d.width))+";height:"+(d.height=="auto"?"expression(this.parentNode.offsetHeight+'px')":b(d.height))+';"/>';return this.each(function(){if(a(this).children("iframe.bgiframe").length===0){this.insertBefore(document.createElement(c),this.firstChild)}})}:function(){return this});a.fn.bgIframe=a.fn.bgiframe;function b(c){return c&&c.constructor===Number?c+"px":c}})(jQuery);



/********************首页图片轮番 jquery.jslides.js************************/

$(function(){
	var numpic = $('#slides li').size()-1;
	var nownow = 0;
	var inout = 0;
	var TT = 0;
	var SPEED = 5000;


	$('#slides li').eq(0).siblings('li').css({'display':'none'});


	var ulstart = '<ul id="pagination">',
		ulcontent = '',
		ulend = '</ul>';
	ADDLI();
	var pagination = $('#pagination li');
	var paginationwidth = $('#pagination').width();
	$('#pagination').css('margin-left',(200-paginationwidth))
	
	pagination.eq(0).addClass('current')
		
	function ADDLI(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic; i++){
			ulcontent += '<li>' + '<a href="javascript:void(0);">' + (i+1) + '</a>' + '</li>';
		}
		
		$('#slides').after(ulstart + ulcontent + ulend);	
	}

	pagination.on('click',DOTCHANGE)
	
	function DOTCHANGE(){
		
		var changenow = $(this).index();
		
		$('#slides li').eq(nownow).css('z-index','900');
		$('#slides li').eq(changenow).css({'z-index':'800'}).show();
		pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
		$('#slides li').eq(nownow).fadeOut(400,function(){$('#slides li').eq(changenow).fadeIn(500);});
		nownow = changenow;
	}
	
	pagination.mouseenter(function(){
		inout = 1;
	})
	
	pagination.mouseleave(function(){
		inout = 0;
	})
	
	function GOGO(){
		
		var NN = nownow+1;
		
		if( inout == 1 ){
			} else {
			if(nownow < numpic){
			$('#slides li').eq(nownow).css('z-index','900');
			$('#slides li').eq(NN).css({'z-index':'800'}).show();
			pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
			$('#slides li').eq(nownow).fadeOut(400,function(){$('#slides li').eq(NN).fadeIn(500);});
			nownow += 1;

		}else{
			NN = 0;
			$('#slides li').eq(nownow).css('z-index','900');
			$('#slides li').eq(NN).stop(true,true).css({'z-index':'800'}).show();
			$('#slides li').eq(nownow).fadeOut(400,function(){$('#slides li').eq(0).fadeIn(500);});
			pagination.eq(NN).addClass('current').siblings('li').removeClass('current');

			nownow=0;

			}
		}
		TT = setTimeout(GOGO, SPEED);
	}
	
	TT = setTimeout(GOGO, SPEED); 

})
/********************table隔行换色 jquery-Tabletr_change.js************************/
$(document).ready(function(){
$(".tab01 tr:odd").addClass("intro1");
$(".tab01 tr").mouseover(function(){
	$(this).addClass("change");
	})
$(".tab01 tr").mouseout(function(){
	$(this).removeClass("change");
	})
$(".tab01 tr:even").addClass("intro2")
});


/********************首页二级菜单下拉 menu.js************************/

$(function () {
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_1 = $menu.find('li.li_1'), $li_1_content = $li_1.find('.li_1_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_2 = $menu.find('li.li_2'), $li_2_content = $li_2.find('.li_2_content');
    var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_3 = $menu.find('li.li_3'), $li_3_content = $li_3.find('.li_3_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_4 = $menu.find('li.li_4'), $li_4_content = $li_4.find('.li_4_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_5 = $menu.find('li.li_5'), $li_5_content = $li_5.find('.li_5_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_6 = $menu.find('li.li_6'), $li_6_content = $li_6.find('.li_6_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_7 = $menu.find('li.li_7'), $li_7_content = $li_7.find('.li_7_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_8 = $menu.find('li.li_8'), $li_8_content = $li_8.find('.li_8_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_9 = $menu.find('li.li_9'), $li_9_content = $li_9.find('.li_9_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_10 = $menu.find('li.li_10'), $li_10_content = $li_10.find('.li_10_content');
    $menuLi.hover(function () {
        var $this = $(this), num = $menuLi.index($this), current = $menuLi.index($(".first")), len = current - num;
        $menu.css("background-position", (101 * current) + "px" + " bottom");
        $current.removeClass("lihover");
        $menuLi.removeClass("first");
        $this.addClass("first");
        if (len <= 0) { len = -len; };
        if (num != 10) {
            $menu.stop().animate({ backgroundPosition: (98 * num) + "px" + " bottom" }, 100 * len);
        }
        else {
            $menu.stop().animate({ backgroundPosition: (98 * num) + "px" + " bottom" }, 100 * len);
        }
    });
    $li_1.hover(function () {
        $li_1_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_1_content.fadeOut(10, function () {
            $li_1_content.css("display", "none");
        });
    });
    $li_2.hover(function () {
        $li_2_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_2_content.fadeOut(10, function () {
            $li_2_content.css("display", "none");
        });
    });
    $li_3.hover(function () {
        $li_3_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_3_content.fadeOut(10, function () {
            $li_3_content.css("display", "none");
        });
    });
	$li_4.hover(function () {
        $li_4_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_4_content.fadeOut(10, function () {
            $li_4_content.css("display", "none");
        });
    });
	$li_5.hover(function () {
        $li_5_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_5_content.fadeOut(10, function () {
            $li_5_content.css("display", "none");
        });
    });
	$li_6.hover(function () {
        $li_6_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_6_content.fadeOut(10, function () {
            $li_6_content.css("display", "none");
        });
    });
    $li_7.hover(function () {
        $li_7_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_7_content.fadeOut(10, function () {
            $li_7_content.css("display", "none");
        });
    });
    $li_8.hover(function () {
        $li_8_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_8_content.fadeOut(10, function () {
            $li_8_content.css("display", "none");
        });
    });
    $li_9.hover(function () {
        $li_9_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_9_content.fadeOut(10, function () {
            $li_9_content.css("display", "none");
        });
    });
    $li_10.hover(function () {
        $li_10_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_10_content.fadeOut(10, function () {
            $li_10_content.css("display", "none");
        });
    });
    $menu.mouseleave(function () {
        var $this = $(this), num = $menuLi.index($this), current = $menuLi.index($current), len = current - num;
        $menuLi.removeClass("first");
        $current.addClass("first");
        if (len <= 0) { len = -len; };
        $menu.stop().animate({ backgroundPosition: (98 * current + 1) + "px" + " bottom" }, 100 * len);
    });
    $("a.noclick").click(function (event) {
        event.preventDefault();
    });
});

/********************首页文字向上滚动Scrollup.js************************/

//滚动插件
	(function($){
		$.fn.extend({
			Scroll:function(opt,callback){
					//参数初始化
					if(!opt) var opt={};
					var _this=this.eq(0).find("ul:first");
					var lineH=_this.find("li:first").height(), //获取行高
						line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), //每次滚动的行数，默认为一屏，即父容器高度
						speed=opt.speed?parseInt(opt.speed,10):500, //卷动速度，数值越大，速度越慢（毫秒）
						timer=opt.timer?parseInt(opt.timer,10):3000; //滚动的时间间隔（毫秒）
					if(line==0) line=1;
					var upHeight=0-line*lineH;
					//滚动函数
					scrollUp=function(){
							_this.animate({
									marginTop:upHeight
							},speed,function(){
									for(i=1;i<=line;i++){
											_this.find("li:first").appendTo(_this);
									}
									_this.css({marginTop:0});
							});
					}
					//鼠标事件绑定
					_this.hover(function(){
							clearInterval(timerID);
					},function(){
							timerID=setInterval("scrollUp()",timer);
					}).mouseout();
			}       
		});
	})(jQuery);
	
/*************************************Tab切换 Tab_jquery.js************************************************/
//tab切换条
$(document).ready(function(){ 
var intervalID; 
var curLi; 

$(".nav li a").click(function(){ 
curLi=$(this); 
intervalID=setInterval(onMouseOver,250);//鼠标移入的时候有一定的延时才会切换到所在项，防止用户不经意的操作 
}); 

function onMouseOver(){ 
$(".cur-sub-con").removeClass("cur-sub-con"); 
$(".sub-con").eq($(".nav li a").index(curLi)).addClass("cur-sub-con"); 
$(".cur").removeClass("cur"); 
curLi.addClass("cur"); 
} 
$(".nav li a").click(function(){ 
clearInterval(intervalID); 
}); 

$(".nav li a").click(function(){//鼠标点击也可以切换 
clearInterval(intervalID); 
$(".cur-sub-con").removeClass("cur-sub-con"); 
$(".sub-con").eq($(".nav li a").index(curLi)).addClass("cur-sub-con"); 
$(".cur").removeClass("cur"); 
curLi.addClass("cur"); 
}); 
$(".nav li a").first().click(); 
//$("table").resizableColumns({});

$(".nav2 li a").click(function(){ 
curLi=$(this); 
intervalID=setInterval(onMouseOver,250);//鼠标移入的时候有一定的延时才会切换到所在项，防止用户不经意的操作 
}); 

function onMouseOver(){ 
$(".cur-sub-con2").removeClass("cur-sub-con2"); 
$(".sub-con2").eq($(".nav2 li a").index(curLi)).addClass("cur-sub-con2"); 
$(".cur2").removeClass("cur2"); 
curLi.addClass("cur2"); 
} 
$(".nav2 li a").click(function(){ 
clearInterval(intervalID); 
}); 

$(".nav2 li a").click(function(){//鼠标点击也可以切换 
clearInterval(intervalID); 
$(".cur-sub-con2").removeClass("cur-sub-con2"); 
$(".sub-con2").eq($(".nav2 li a").index(curLi)).addClass("cur-sub-con2"); 
$(".cur2").removeClass("cur2"); 
curLi.addClass("cur2"); 
}); 
	
}); 

/**********end***********/
//去掉引导
$(document).ready(function(){ 
 if(parent&&parent.$('#mainFrame').length>0){
     var url=parent.$('#mainFrame').contents().get(0).location.href;
     if(url.indexOf('a=welcome')==-1){
         parent.$('#new_guide').hide();
     }
     else{
         parent.$('#new_guide').show();
     }
 }
}); 