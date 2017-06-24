(function ($) {
    $.fn.extend({
        Scroll: function (opt, callback) {
            var _this = this.find("ul:first");
            _this.css({'width': '2000px'});//必须这样让li可以足够空间
            var lineW = 0;
            var _li = this.find("li");
            _li.each(function () {
                $(this).css({'float': 'left'});
                var newW = $(this).width() + 30;
                lineW += newW;
                $(this).css({'width': newW + 'px'});
            });
            _this.css({'width': lineW + 'px'});
            var speed = lineW * 15;

            _this.attr('lineW', lineW);
            _this.attr('speed', speed);


            scrollUp = function (a) {
                if (a.find('li').length < 1) {
                    return;
                }
 

                a.animate({
                    'margin-left': -parseFloat(a.attr('lineW')) + 'px'
                }, parseFloat(a.attr('speed')), 'swing', function () {
                    a.css({'margin-left': 0});
                    a.stop();
                    scrollUp(a);
                });
            };
            _this.hover(function () {
                $(this).stop();
            }, function () {
                $(this).stop();
                scrollUp($(this));
            });
            scrollUp(_this);


        }
    });
})(jQuery);
//tab切换条
$(document).ready(function () {
    $(".nav li a").click(function () {//鼠标点击也可以切换 
        $(".sub-con").removeClass("cur-sub-con");
        $(".sub-con").eq($(".nav li a").index($(this))).addClass("cur-sub-con");
        $(".nav li a").removeClass("cur");
        $(this).addClass("cur");
    });
    $(".nav li a").first().click();
//$("table").resizableColumns({});

    $(".nav2 li a").click(function () {
        curLi = $(this);
        intervalID = setInterval(onMouseOver, 250); //鼠标移入的时候有一定的延时才会切换到所在项，防止用户不经意的操作 
    });
    function onMouseOver() {
        $(".cur-sub-con2").removeClass("cur-sub-con2");
        $(".sub-con2").eq($(".nav2 li a").index(curLi)).addClass("cur-sub-con2");
        $(".cur2").removeClass("cur2");
        curLi.addClass("cur2");
    }
    $(".nav2 li a").click(function () {
        clearInterval(intervalID);
    });
    $(".nav2 li a").click(function () {//鼠标点击也可以切换 
        clearInterval(intervalID);
        $(".cur-sub-con2").removeClass("cur-sub-con2");
        $(".sub-con2").eq($(".nav2 li a").index(curLi)).addClass("cur-sub-con2");
        $(".cur2").removeClass("cur2");
        curLi.addClass("cur2");
    });
}); 