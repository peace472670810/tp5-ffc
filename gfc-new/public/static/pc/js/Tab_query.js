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