var runTime = {
    remainTimer: 0,
    waitOpenTimer: 0,
    getLastOpenTimer: 0,
    traceRemainTimer: 0,
    traceWaitOpenTimer: 0,
    clearAll: function () {
        clearInterval(runTime.remainTimer);
        clearInterval(runTime.waitOpenTimer);
        clearInterval(runTime.getLastOpenTimer);
        clearInterval(runTime.traceRemainTimer);
        clearInterval(runTime.traceWaitOpenTimer);
    }
};
(function ($) {
    $.bet = function (settings) {
        var ps = $.extend({
            //应传过来的设置
            lotteryId: 1,
            lotteryName: 'CQSSC',
            lotteryType: 1, //采种类型
            //startIssueInfo: {issue_id$.extendopenedIssues: '11444', issue:'20130131-080', 'end_time': '2013/01/31 19:14:10', 'input_time': '2013/01/31 19:14:20'},
            methods: [],
            maxCombPrize: 0, //全包奖金
            openedIssues: [], //已开奖奖期
            minRebateGaps: [{
                    from: 0,
                    to: 0.12,
                    gap: 0.005
                }, {
                    from: 0.12,
                    to: 0.125,
                    gap: 0.001
                }],
            rebate: 0.123, //用户的返点
            defaultMode: 1, //1,0.1,0.01
            defaultRebate: 0.123, //默认选中的返点
            missHot: {
                miss: [],
                hot: []
            }, //上期开奖冷热数据
            halt: function (msg) {    //致命错误处理
                alert(msg + '!');
                throw msg;
            },
            //运行时变量
            prizeRate: 0, //返奖率
            curIssueInfo: {}, //当前奖期{ issue_id="15712", issue="20130201-070", end_time="2013-02-01 17:48:30", input_time=2013-02-01 17:50:30"}
            lastIssueInfo: {}, //上一期{ issue_id="15712", issue="20130201-070", code="96983"}
            curMode: 0, //当前选择的元角分模式
            //curRebate: 0,       //当前选择的返点值=ps.rebateGapList[ps.curPrizeIndex].rebate，这里不再需要
            curMethod: {}, //当前选择的玩法
            curProjects: [], //当前投注栏内容
            nextProjectCounter: 0, //投注栏计数器
            curPrizeIndex: -1, //当前选择的返点在rebateGapList数组的下标
            rebateGapList: [], //计算出来的滑动奖金列表
            curServerTime: '', //当前服务器时间
            curRemainTime: 0, //当前期剩余秒数
            remainTimer: {}, //倒数计时器
            curWaitOpenTime: 0, //当前等待开奖秒数
            waitOpenTimer: {}, //等待开奖计时器
            getLastOpenTime: 0, //等待开奖的循环时间计时
            getLastOpenTimer: {}, //得到上一期开奖结果计时器
            canBuy: false, //当前状态是否允许游戏
            traceMethodPrize: 0, //可利润率追号时，传回该玩法奖金
            tracePrizeLimit: 0, //购买奖金限额
            canTraceIssues: []   //可追号的期号列表
        }, settings);
        //6.开奖区
        var initDrawBar = function () {
            $("#curLotteryName").text(ps.lotteryName);
            $("#curLotteryName2").text(ps.lotteryName);
            drawBar.getCurIssue(drawBar.init);
        };

        var drawBar = {
            init: function () {
                runTime.remainTimer = window.setInterval(drawBar.showCurIssue_Timer, 1000);
                if (ps.lastIssueInfo.code == "") {
                    ps.getLastOpenTime = 0;
                    clearInterval(runTime.getLastOpenTimer);
                    runTime.getLastOpenTimer = window.setInterval(drawBar.getLastOpen_Timer, 1000);
                    $("#thisIssueInfo").addClass("lock");
                    ps.canBuy = false;
                    $("#thisIssueSpan").text(ps.lastIssueInfo.issue);
                }
                else {  //友好界面 1秒等待后显示
                    //更新最近一期数据，否则导致draw.init()中重复调用
                    var latest = ps.openedIssues[0];
                    //tconsole.info("latest.issue=" + latest.issue);
                    if (ps.lastIssueInfo.issue != latest.issue) {
                        var tmp = ps.lastIssueInfo;
                        ps.openedIssues.unshift(tmp);
                        ps.openedIssues.updateLast();
                    }
                }

                //初始化开奖球数目
                if (ps.lotteryType == 1 || ps.lotteryType == 4 || ps.lotteryType == 6) {
                    var nums = ps.openedIssues[0].code.split("");
                } else if (ps.lotteryType == 2 || ps.lotteryType == 7 || ps.lotteryType == 8) {
                    var nums = ps.openedIssues[0].code.split(" ");
                }
                $('#thisIssueNumUL').empty();

                drawBar.showLastDraw();
                ps.canBuy = true;
            },
            getCurIssue: function (callback) {
                $.ajax({
                    url: "?c=api&a=play",
                    type: "POST",
                    data: {
                        op: "getCurIssue",
                        lotteryId: ps.lotteryId
                    },
                    cache: false,
                    dataType: "json",
                    timeout: 30000,
                    success: function (response) {
                        if (response.errno == 0) {
                            ps.curIssueInfo = response.issueInfo;
                            ps.curServerTime = response.serverTime;
                            ps.curRemainTime = getTS(ps.curIssueInfo.end_time) - getTS(ps.curServerTime);
                            ps.curWaitOpenTime = 8;    //显示锁形的时间，可酌情减少，不构成风险
                            ps.lastIssueInfo = response.lastIssueInfo;
                            if (typeof (callback) == "function") {
                                callback();
                            }
                        } else {
                            layer.alert("当前期不存在");
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        var message = errorThrown.toString();
                        if (errorThrown.message) {
                            message = errorThrown.message;
                        }

                        if (message.indexOf("a=logout") != -1 || message.indexOf("a=login") != -1) {
                            layer.alert("你与服务器的认证失败");
                            //window.location.href = "?a=logout";
                        } else {
                            layer.alert("服务器无法处理获取当前期数的请求");
                        }
                    }
                })
            },
            showCurIssue_Timer: function () {
                $("#thisIssueSpan").text(ps.curIssueInfo.issue);
                $("#thisIssueSpan2").text(ps.curIssueInfo.issue);
                var d = subTime(--ps.curRemainTime);
                if (ps.curRemainTime >= 0) {
                    $("#thisIssueRemainTime").text(d.hour + ":" + d.minute + ":" + d.second);
                    $("#thisIssueTimerIcon").removeClass("lock").addClass('clock');
                    $('#thisIssueTimerIcon').text('开盘中');
                } else {
                    clearInterval(runTime.remainTimer);
                    $('#thisIssueTimerIcon').removeClass('clock').addClass('lock');
                    $('#thisIssueTimerIcon').text('封盘中');

                    if ($('#autoDownload').attr('checked')) {
                        download('/?c=api&a=downloadBackup&lotteryId=' + ps.lotteryId);
                    }

                    var lock_alert_time = ps.curWaitOpenTime;


                    window.runTime.lock_alert_timer = window.setInterval(function () {
                        $("#lock_alert_timer").text(parseInt($("#lock_alert_timer").text()) - 1);
                    }, 1000);
                    window.setTimeout(function (){
                        window.clearInterval(window.runTime.lock_alert_timer);
                    }, lock_alert_time * 1000);
                    //layer.alert('第'+ps.curIssueInfo.issue+'期已经截止<br/>投注时请注意期号<br/><span id="lock_alert_timer">'+lock_alert_time+'</span>秒后自动关闭窗口', 7, '封盘提示');


                    $.layer({'title': '封盘提示', 'time': lock_alert_time
                        , 'dialog': {
                            type: 7,
                            msg: '第' + ps.curIssueInfo.issue + '期已经截止<br/><b>如需备份当前期，请选中 "封盘后自动下载excel备份"。</b><br/><span id="lock_alert_timer">' + lock_alert_time + '</span>秒后自动关闭窗口'
                        }
                        , 'btns': 1
                        , btn: ['关闭']
                    });

                    var d2 = subTime(ps.curWaitOpenTime);
                    $('#thisIssueRemainTime').text(d2.hour + ":" + d2.minute + ":" + d2.second);
                    //$("#thisIssueRemainTime").addClass("lotteryTime-lock");
                    //$("#thisIssueMoreInfo").html('<div class="remainOpenDIV">第 ' + ps.curIssueInfo.issue + ' 期开奖倒计时：<span class="lotteryTime2">' + ps.curWaitOpenTime + "</span></div>");
                    ps.canBuy = false;
                    runTime.waitOpenTimer = window.setInterval(drawBar.waitOpen_Timer, 1000);
                }
            },
            //显示锁倒计时
            waitOpen_Timer: function () {
                --ps.curWaitOpenTime;
                var d = subTime(ps.curWaitOpenTime);
                $("#thisIssueRemainTime").text(d.hour + ":" + d.minute + ":" + d.second);
                if (ps.curWaitOpenTime < 0) {
                    clearInterval(runTime.waitOpenTimer);
                    drawBar.getCurIssue(drawBar.init);
                }
            },
            getLastOpen_Timer: function () {
                ps.getLastOpenTime++;
                //console.info("ps.getLastOpenTime计时器=" + ps.getLastOpenTime);
                //每10秒请求一次
                if (ps.getLastOpenTime % 10 == 0) {
                    $.ajax({
                        url: "?c=api&a=play",
                        type: "POST",
                        data: {
                            op: "getLastIssueCode",
                            lotteryId: ps.lotteryId,
                            issue: ps.lastIssueInfo.issue
                        },
                        cache: false,
                        dataType: "json",
                        timeout: 30000,
                        success: function (response) {
                            if (response.errno == 0) {
                                if (typeof (response.issueInfo.code) != "undefined") {
                                    clearInterval(runTime.getLastOpenTimer);
                                    ps.getLastOpenTime = 0;
                                    //更新最近一期数据，否则导致draw.init()中重复调用
                                    ps.lastIssueInfo = response.issueInfo;

                                    ps.openedIssues.unshift(response.issueInfo);

                                    ps.openedIssues.updateLast();

                                    drawBar.showLastDraw();
                                } else {
                                }
                            } else {
                                layer.alert("开号数据不存在");
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            var message = errorThrown.toString();
                            if (errorThrown.message) {
                                message = errorThrown.message;
                            }
                            if (message.indexOf("a=logout") != -1 || message.indexOf("a=login") != -1) {
                                alert("你与服务器的认证失败");
                                //window.location.href = "?a=logout";
                            } else {
                                layer.alert("服务器无法处理获取开号的请求");
                            }
                        }
                    })
                }
            },
            //显示上一期开奖结果
            showLastDraw: function () {
                var latest = ps.openedIssues[0];
                $("#lastIssueSpan").text(ps.lastIssueInfo.issue);
                if (ps.lotteryType == 2) {
                    var numPosY = [-30, 80, 10, 1];
                }
                else if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                    var numPosY = [-25, 80, 9, 0];
                }
                var str;
                if (ps.lastIssueInfo.issue == latest.issue) {
                    if (ps.lotteryType == 1) {
                        var nums = latest.code.split("");
                    } else if (ps.lotteryType == 2) {
                        var nums = latest.code.split(" ");
                    } else if (ps.lotteryType == 4) {
                        var nums = latest.code.split("");
                    } else if (ps.lotteryType == 6) {
                        var nums = latest.code.split("");
                    } else if (ps.lotteryType == 7) {
                        var nums = latest.code.split(" ");
                    }
                    else if (ps.lotteryType == 8) {
                        var nums = latest.code.split(" ");
                    } else {
                        throw new exception('无效的数据引用');
                    }

                    /**
                     * 动画第二版
                     */
                    var index = index2 = 0;
                    if (ps.lotteryType == 7) {
                        var nums = drawBar.translateCards(nums);
                    }

                    $("#thisIssueNumUL").text(nums.join(' , '));

                } else {
                    $("#thisIssueNumUL").text('正在获取...');


                }

            },
        };
        function subTime(t) {
            var ob = t > 0 ? {
                day: Math.floor(t / 86400),
                hour: Math.floor(t % 86400 / 3600),
                minute: Math.floor(t % 3600 / 60),
                second: Math.floor(t % 60)
            } : {
                day: 0,
                hour: 0,
                minute: 0,
                second: 0
            };
            if ((ob.hour + "").length == 1) {
                ob.hour = "0" + ob.hour;
            }
            if ((ob.minute + "").length == 1) {
                ob.minute = "0" + ob.minute;
            }
            if ((ob.second + "").length == 1) {
                ob.second = "0" + ob.second;
            }
            return ob;
        }

        initDrawBar();

    }
})(jQuery);


if (typeof (openedIssues) != "undefined") {
    (function (openedIssues, lottery_id, lottery_type) {
        //开奖奖期
        openedIssues.render = function (v) {
            var str = '';
            if (lottery_type == 1 || lottery_type == 4) {
                str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width150px">' + v.prop.qszt + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.daxiao + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.danshuang + "</li></ul>";
            } else if (lottery_type == 2) {
                str = '<ul><li class="width80px">' + v.issue + '</li><li class="width80px">' + v.code + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li><li class="width60px">' + v.prop.daxiao + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.danshuang + "&nbsp;&nbsp;&nbsp;&nbsp;</li></ul>";
            }

            else if (lottery_type == 6) {
                str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width53px">' + v.prop.qshz + '</li><li class="width53px">' + v.prop.leixing + "</li></ul>";
            }
            else if (lottery_type == 7) {
                str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width60px">' + v.prop.pkzt + "</li></ul>";
            }
            else if (lottery_type == 8) {
                str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width60px">' + v.prop.xt + "</li></ul>";
            }

            return str;
        };
        openedIssues.updateLast = function () {
        };

        $('#refresh').click(function () {
            refresh();
        });



    })(openedIssues, lottery_id, lottery_type);

}
function refresh(type, callback) {
    $.post('', {'ajax': 1}, function (data, textStatus, jqXHR) {
        if (data) {
            if (callback) {
                callback(data);
            }
            else if (type == 'html') {
                $('#projects').html(data);
                setupBlocks();
            }

        }
    }, type);

}
function refreshAuto(type, callback) {
    if (!type) {
        type = 'html';
    }
    refresh(type, callback);
    setTimeout(function () {
        refreshAuto(type, callback);
    }, parseInt($('#selectTime').val()));
}

//把列表安排到位
var colCount = 0;
var colWidth = 0;
var margin = 0;
var windowWidth = 0;
var blocks = [];

$(function () {
    $(window).resize(setupBlocks);
});

function setupBlocks() {
    windowWidth = $(window).width();
    colWidth = $('.block').outerWidth();
    blocks = [];
    console.log(blocks);
    colCount = 2;
    for (var i = 0; i < colCount; i++) {
        blocks.push(margin);
    }
    positionBlocks();
}

function positionBlocks() {
    $('.block').each(function () {
        var min = Array.min(blocks);
        var index = $.inArray(min, blocks);
        var leftPos = margin + (index * (colWidth + margin));
        $(this).css({
            'left': leftPos + 'px',
            'top': (min + 32) + 'px'
        });
        blocks[index] = min + $(this).outerHeight() + margin;
    });
}

// Function to get the Min value in Array
Array.min = function (array) {
    return Math.min.apply(Math, array);
};

//excel表格导出
$('.excel').click(function () {
    var table = $($(this).attr('table')).tableToJSON(); // Convert the table into a javascript object
    if ($('#excelIframe').length == 0) {
        $("body").append(' <iframe id="excelIframe" name="excelIframe" scrolling="no" frameborder="0" width="0" height="0"></iframe>');
        $("body").append(' <form name="excelForm" id="excelForm" action="/?c=default&a=excel" method="post" target="excelIframe"></form>');
        $('#excelForm').append('<input type="hidden" id="excelData" name="excelData"  value=""/>');
        $('#excelForm').append('<input type="hidden" id="excelFile" name="excelFile"  value=""/>');
    }
    $('#excelData').val(JSON.stringify(table));
    $('#excelFile').val($(this).attr('excelFile'));
    $('#excelForm').submit();
});

function download(action) {
    var excelIframe = 'excelIframe' + Math.floor(Math.random() * 100000);
    var excelForm = 'excelForm' + Math.floor(Math.random() * 100000);
    $("body").append(' <iframe id="' + excelIframe + '" name="' + excelIframe + '" scrolling="no" frameborder="0" width="0" height="0"></iframe>');
    $("body").append(' <form name="' + excelForm + '" id="' + excelForm + '" action="' + action + '" method="post" target="' + excelIframe + '"></form>');

    $('#' + excelForm).append('<input type="hidden" id="fileType" name="fileType"  value="excel"/>');
    $('#' + excelForm).submit();

}

