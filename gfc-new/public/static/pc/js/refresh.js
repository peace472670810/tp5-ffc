function initSortLotterys() {
    $('#topNavMenu').empty();
    $('.pg_top_nav_sp').empty();
    if (!sortLotterys) {
        return;
    }
    var sortIns = 0;
    for (var i in sortLotterys) {
        if (sortLotterys[i]['isopened'] == 1) {
            if (sortIns < 8) {
                var sortli = $('.pg_top_nav' + (sortIns + 1).toString());
                sortli.attr('title', sortLotterys[i]['cname']);
                sortli.attr('href', sortLotterys[i]['alink'] + '?lid=' + sortLotterys[i]['lotteryId'] + urlSession());
                var tmphtml = '<span class="pg_top_nav_ul_s1">' + sortLotterys[i]['cname'] + '</span><span class="pg_top_nav_ul_s2 lottery_timer" lottery="' + sortLotterys[i]['lotteryId'] + '">载入中</span>';
                sortli.html(tmphtml);
            }
            else {
                var tmphtml = '<a href=" ' + sortLotterys[i]['alink'] + '?lid=' + sortLotterys[i]['lotteryId'] + '">' + sortLotterys[i]['cname'] + '</a>';
                $('#topNavMenu').append(tmphtml);
            }
            sortIns++;
        }
    }

}
//彩种列表
initSortLotterys();
function refreshLottery() {
    $('.lottery_timer').each(function () {
        var lottery_issue = $(this);
        var lotteryId = lottery_issue.attr('lottery');
        if (lotteryId) {
            $.ajax({
                url: getCurIssueUrl + urlSession(),
                type: "POST",
                data: {
                    lotteryId: lotteryId
                },
                cache: false,
                dataType: "json",
                timeout: 30000,
                success: function (response) {
                    if (response.errno == 0) {
                        lottery_issue.attr('title', response.issueInfo.issue);
                        var d = response.issueInfo.end_time.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/gi);
                        d = new Date(RegExp.$1, RegExp.$2, RegExp.$3, RegExp.$4, RegExp.$5, RegExp.$6);
                        serverTime = response.serverTime.match(/(\d{4})\/(\d{2})\/(\d{2}) (\d{2}):(\d{2}):(\d{2})/gi);
                        var serverTime = new Date(RegExp.$1, RegExp.$2, RegExp.$3, RegExp.$4, RegExp.$5, RegExp.$6);
                        var now = new Date();
                        var offset = d.getTimezoneOffset() / 60 + 8;
                        var nowDate = new Date(serverTime.getTime() - (3600000 * offset));
                        var nd = new Date(now.getTime() - nowDate.getTime() + d.getTime() - (3600000 * offset));
                        lottery_issue.countdown(nd.getTime(), function (event) {
                            var tmpTitle = $(this).attr('title').toString();
                            tmpTitle = tmpTitle.substr(tmpTitle.length - 4).replace('-', '');
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            $(this).html(event.strftime(totalHours + ':%M:%S'));
                        });
                    } else {
                        lottery_issue.text('封盘');
                        //alert("获取当前期数据失败");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    lottery_issue.text('载入中');
                    //alert("调用当前期数据失败，请再次尝试");
                }
            });
        }
    });
}
setInterval('refreshLottery()', 30000);
//刷新彩种列表倒计时
refreshLottery();
var btnAddNum = document.getElementById("btnAddNum");
var btnSubNum = document.getElementById("btnSubNum");
var inpNumber = document.getElementById("multiple");
btnAddNum.onclick = function () {
    var num = inpNumber.value;
    if (num >= 5000) {
        num = 5000;
    } else {
        num++;
    }
    inpNumber.value = num;
    $('#multiple').keyup();
}
btnSubNum.onclick = function () {
    var num = inpNumber.value;
    if (num <= 1) {
        num = 1;
    } else {
        num--;
    }
    inpNumber.value = num;
    $('#multiple').keyup();
}
// 导航菜单
var evenXzNav = document.getElementById("evenXzNav");
var evenXzNavLi = evenXzNav.getElementsByTagName("li");
var evenXzNavMenu = document.getElementById("evenXzNavMenu");
// 浮层
function show(showbBtn, showBox) {
    var showbBtn = document.getElementById(showbBtn);
    var showBox = document.getElementById(showBox);
    showbBtn.onmousemove = function () {
        showBox.style.display = "block";
    }
}
;
//皮肤
show("hdSkinBox", "skinList");
//设置
function initSetLotterys() {
    $('#caiKndXz').empty();
    if (!sortLotterys) {
        return;
    }
    for (var i in sortLotterys) {
        var checked = '';

        if (sortLotterys[i]['isopened'] == 1) {
            checked = ' checked="checked" ';
        }
        var tmphtml = '<li><input ' + checked + ' name="' + sortLotterys[i]['name'] + '" type="checkbox" id="' + sortLotterys[i]['name'] + '"  value="' + sortLotterys[i]['name'] + '" /><lable onclick="$(\'#' + sortLotterys[i]['name'] + '\').click();' + '">' + sortLotterys[i]['cname'] + '</lable></li>';
        $('#caiKndXz').append(tmphtml);
    }
    $('#caiKndXz li').css('cursor', 'move');
    $('#caiKndXz').sortable();
}
initSetLotterys();
var shezhi = document.getElementById("shezhi");
var caiKind = document.getElementById("caiKind");
shezhi.onclick = function () {
    caiKind.style.display = "block";
    initSetLotterys();
}
//更多游戏
var moreGame = document.getElementById("moreGame");
var topNavMenu = document.getElementById("topNavMenu");
moreGame.onmouseover = function () {
    topNavMenu.style.display = "block";
}
moreGame.onmouseout = function () {
    topNavMenu.style.display = "none";
}
topNavMenu.onmouseover = function () {
    topNavMenu.style.display = "block";
}
topNavMenu.onmouseout = function () {
    topNavMenu.style.display = "none";
}
function hide(hidebBtn, hideBox) {
    var hidebBtn = document.getElementById(hidebBtn);
    var hideBox = document.getElementById(hideBox);
    hidebBtn.onmouseout = function () {
        hideBox.style.display = "none";
    }
};
hide("hdSkinBox", "skinList");
//全选-反选
var quanXuan = document.getElementById("quanXuan");
var fanXuan = document.getElementById("fanXuan");
var caiKndXz = document.getElementById("caiKndXz");
var caiKndXzLab = caiKndXz.getElementsByTagName("input")
quanXuan.onclick = function () {
    for (var i = 0; i < caiKndXzLab.length; i++) {
        if (caiKndXzLab[i].checked !== true) {
            caiKndXzLab[i].checked = "checked";
        }
    }
}

fanXuan.onclick = function () {
    for (var i = 0; i < caiKndXzLab.length; i++) {
        if (caiKndXzLab[i].checked == true) {
            caiKndXzLab[i].checked = false;
        } else {
            caiKndXzLab[i].checked = true;
        }
    }
}
//关闭设置弹窗
var btnClose = document.getElementById("btnClose");
var caiKind = document.getElementById("caiKind");

function closeKind() {
    var caiKind = document.getElementById("caiKind");
    caiKind.style.display = "none";
}
$('#btnClose').click(function () {
    var caiKind = document.getElementById("caiKind");
    caiKind.style.display = "none";
});
$('#caiKindQx').click(function () {
    var caiKind = document.getElementById("caiKind");
    caiKind.style.display = "none";
});
$('#caiKindTrue').click(function () {
    if (sortLotterys) {
        var newSortLotterys = [];

        $sortlis = $('#caiKndXz li input');
        $sortlis.each(function (i, v) {
            var item = {};
            for (var j in sortLotterys) {
                if (sortLotterys[j]['name'] == $(v).val()) {
                    item['lotteryId'] = sortLotterys[j]['lotteryId'];
                    item['name'] = sortLotterys[j]['name'];
                    item['cname'] = sortLotterys[j]['cname'];
                    item['alink'] = sortLotterys[j]['alink'];
                    item['isopened'] = $(v).attr('checked') ? 1 : 0;
                }
            }
            if (item != {}) {
                newSortLotterys.push(item);
            }
        });
        if (newSortLotterys != []) {
            sortLotterys = newSortLotterys;
            $.ajax({
                url: window.location.href + urlSession(),
                type: "POST",
                data: {
                    op: "sortLotterysSave",
                    sortLotterys: sortLotterys
                },
                cache: false,
                dataType: "json",
                timeout: 30000,
                success: function (response) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    //alert("调用当前期数据失败，请再次尝试");
                }
            });
            initSortLotterys();
            refreshLottery()
        }
    }
    var caiKind = document.getElementById("caiKind");
    caiKind.style.display = "none";
});
function skinSave(skin) {
    $.ajax({
        url: skin_url,
        type: "POST",
        data: {
            skin: skin
        },
        cache: false,
        dataType: "json",
        timeout: 1000,
        success: function (response) {
            if (response) {
                window.location.reload();
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            //alert("调用当前期数据失败，请再次尝试");
        }
    });
}
$('.btn_skin_blue').click(function () {
    skinSave('blue');
});
$('.btn_skin_black').click(function () {
    skinSave('black');
});
$('.btn_skin_red').click(function () {
    skinSave('red');
});
$('.btn_skin_green').click(function () {
    skinSave('green');
});