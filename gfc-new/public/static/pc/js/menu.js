$(function () {
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_2 = $menu.find('li.li_2'), $li_2_content = $li_2.find('.li_2_content');
    var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_3 = $menu.find('li.li_3'), $li_3_content = $li_3.find('.li_3_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_4 = $menu.find('li.li_4'), $li_4_content = $li_4.find('.li_4_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_5 = $menu.find('li.li_5'), $li_5_content = $li_5.find('.li_5_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_6 = $menu.find('li.li_6'), $li_6_content = $li_6.find('.li_6_content');
	var $menu = $(".MenuBox"), $menuLi = $menu.find("li"), $current = $menu.find('.current'), $li_7 = $menu.find('li.li_7'), $li_7_content = $li_7.find('.li_7_content');
    $menuLi.hover(function () {
        var $this = $(this), num = $menuLi.index($this), current = $menuLi.index($(".first")), len = current - num;
        $menu.css("background-position", (101 * current) + "px" + " bottom");
        $current.removeClass("lihover");
        $menuLi.removeClass("first");
        $this.addClass("first");
        if (len <= 0) { len = -len; };
        if (num != 6) {
            $menu.stop().animate({ backgroundPosition: (98 * num) + "px" + " bottom" }, 100 * len);
        }
        else {
            $menu.stop().animate({ backgroundPosition: (98 * num) + "px" + " bottom" }, 100 * len);
        }
    });
    $li_2.hover(function () {
        $li_2_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_2_content.fadeOut(500, function () {
            $li_2_content.css("display", "none");
        });
    });
    $li_3.hover(function () {
        $li_3_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_3_content.fadeOut(500, function () {
            $li_3_content.css("display", "none");
        });
    });
	$li_4.hover(function () {
        $li_4_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_4_content.fadeOut(500, function () {
            $li_4_content.css("display", "none");
        });
    });
	$li_5.hover(function () {
        $li_5_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_5_content.fadeOut(500, function () {
            $li_5_content.css("display", "none");
        });
    });
	$li_6.hover(function () {
        $li_6_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_6_content.fadeOut(500, function () {
            $li_6_content.css("display", "none");
        });
    });
    $li_7.hover(function () {
        $li_7_content.stop(true, true).fadeIn(0);
    }, function () {
        $li_7_content.fadeOut(500, function () {
            $li_7_content.css("display", "none");
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