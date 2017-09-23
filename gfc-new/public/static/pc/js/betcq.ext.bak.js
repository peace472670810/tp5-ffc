$(function () {
    (function (openedIssues, lottery_id, lottery_type) {
//开奖奖期
        openedIssues.render = function (v) {
            var str = '';
            var showCode = v.code;
            if (lottery_type == 1 || lottery_type == 4) {
                showCode = showCode.charAt(0) + ' ' + showCode.charAt(2) + ' ' + showCode.charAt(4) + ' ' + showCode.charAt(6) + ' ' + showCode.charAt(8);
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + showCode + '</span><span class="old_kj_left_box_list_s3">' + v.prop.hszt + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.daxiao + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.danshuang + "</span></li>";
            } else if (lottery_type == 2) {
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + v.code + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="old_kj_left_box_list_s3">' + v.prop.daxiao + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.danshuang + "&nbsp;&nbsp;&nbsp;&nbsp;</span></li>";
            }
            else if (lottery_type == 6) {
                showCode = showCode.charAt(0) + ' ' + showCode.charAt(2) + ' ' + showCode.charAt(4);
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + showCode + '</span><span class="old_kj_left_box_list_s3">' + v.prop.qshz + '&nbsp;&nbsp;&nbsp;&nbsp;' + v.prop.leixing + "</span></li>";
            }
            else if (lottery_type == 7) {
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + v.code + '</span><span class="old_kj_left_box_list_s3">' + v.prop.pkzt + "</span></li>";
            }
            else if (lottery_type == 8) {
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + v.code + "</span></li>";
            }
            else if (lottery_type == 9) {
                showCode = showCode.charAt(0) + ' ' + showCode.charAt(1) + ' ' + showCode.charAt(2) + ' ' + showCode.charAt(3) + ' ' + showCode.charAt(4) + ' ' + showCode.charAt(5) + ' ' + showCode.charAt(6);
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + showCode + '</span><span class="old_kj_left_box_list_s3"></span></li>';
            }
            else if (lottery_type == 10) {
                str = '<li class="old_kj_left_box_list_li2"><span class="old_kj_left_box_list_s1">' + v.issue + '</span><span class="old_kj_left_box_list_s2">' + showCode + '</span><span class="old_kj_left_box_list_s3"></span></li>';
            }
            return str;
        };

            openedIssues.updateLast = function () {
            var v = openedIssues[0];
            $("#todayIssuesBody").prepend(openedIssues.render(v));
        };
        //中奖排行榜
        $("#prizeRankBtn").click(
            function () {
                $("#todayIssuesHead").hide();
                $("#todayIssuesBody").hide();
                $("#prizeScrollContent").show();
                $.post("?c=api&a=play" + urlSession(), {
                        op: "getPrizeRank",
                        lotteryId: lottery_id
                    },
                    function (response) {
                        if (response.errno == 0) {
                            if (response.data.length == 0) {
                                $('<div class="todayNoBet">暂时没有记录！</div>').appendTo("#prizeScrollContent");
                            } else {
                                $("#prizeScrollContent").empty();
                                $.each(response.data,
                                    function (k, v) {
                                        //$('<ul><li>' + v.issue + '  <span>' + v.nick_name + "</span> 喜中 <em>" + number_format(v.total_prize, 2) + "</em>元</li></ul>").appendTo($("#prizeScrollContent"));
                                        $('<ul><li><span><i class="ranknum">' + (k + 1) + '</i>' + v.nick_name + '</span> </li><li> <em>' + number_format(v.total_prize, 2) + "</em>元</li></ul>").appendTo($("#prizeScrollContent"));
                                    });
                                $("#prizeScrollContent").html($("#prizeScrollContent").html());
                            }
                        } else {
                            layer.alert("没有中奖数据！", 1);
                        }
                    },
                    "json");
            }
        );
        //今日开奖

        function todayDraw() {
            $("#todayIssuesHead").empty().show();
            $("#todayIssuesBody").empty().show();
            $("#prizeScrollContent").hide();
            if (lottery_type == 4) {
                $("#todayDrawBtn").text('最新开奖');
            }
            if (lottery_type == 1 || lottery_type == 4) {
                $("#todayIssuesHead").html('<p class="old_kj_left_box_title_p1">期号</p><p class="old_kj_left_box_title_p2">开奖</p><p class="old_kj_left_box_title_p3"><span class="old_kj_left_box_title_p3_s1">三星</span><span class="old_kj_left_box_title_p3_s2">形态&nbsp;&nbsp;大小比&nbsp;&nbsp;单双比</span></p>');
            } else if (lottery_type == 2) {
                $("#todayIssuesHead").html('<p class="old_kj_left_box_title_p1">期号</p><p class="old_kj_left_box_title_p2">开奖</p><p class="old_kj_left_box_title_p3"><span class="old_kj_left_box_title_p3_s1">大小比</span><span class="old_kj_left_box_title_p3_s2">&nbsp;&nbsp;单双比</span></p>');
            }

            else if (lottery_type == 6) {
                $("#todayIssuesHead").html('<p class="old_kj_left_box_title_p1">期号</p><p class="old_kj_left_box_title_p2">开奖</p><p class="old_kj_left_box_title_p3"><span class="old_kj_left_box_title_p3_s1">和值</span><span class="old_kj_left_box_title_p3_s2">&nbsp;&nbsp;类型</span></p>');
            }
            else if (lottery_type == 7) {
                $("#todayIssuesHead").html('<p class="old_kj_left_box_title_p1">期号</p><p class="old_kj_left_box_title_p2">开奖</p><p class="old_kj_left_box_title_p3"><span class="old_kj_left_box_title_p3_s1">形态</span></p>');
            }
            else if (lottery_type == 8 || lottery_type == 9 || lottery_type == 10) {
                $("#todayIssuesHead").html('<p class="old_kj_left_box_title_p1">期号</p><p class="old_kj_left_box_title_p2">开奖</p><p class="old_kj_left_box_title_p3"><span class="old_kj_left_box_title_p3_s1">形态</span></p>');
            }
            else {
                throw 'unknown lt type';
            }

            $("#todayIssuesBody").empty();
            $.each(openedIssues,
                function (k, v) {
                    $("#todayIssuesBody").append(openedIssues.render(v));
                });
        }

        todayDraw();
        //今日投注
        $("#todayBuyBtn").click(
            function () {
                $("#todayIssuesHead").empty().show();
                $("#todayIssuesBody").empty().show();
                $("#prizeScrollContent").hide();
                $.post("?c=api&a=play" + urlSession(), {
                        op: "getCurContextIssues",
                        lotteryId: lottery_id
                    },
                    function (response) {
                        if (response.errno == 0) {
                            $.each(response.issueInfos,
                                function (k, v) {
                                    $('<li name="' + v.issue + '" class="todayRecentIssues"' + (k == 2 ? " style='width:80px;'" : "") + '>' + v.issue.substr(v.issue.length - 3) + (k == 2 ? "(当前期)" : "") + "</li>").click(function () {
                                        $(this).addClass("yellow").siblings().removeClass("yellow");
                                        $.post(BuyRecordsUrl, {
                                                lotteryId: lottery_id,
                                                issue: $(this).attr("name")
                                            },
                                            function (response) {
                                                if (response.errno == 0) {
                                                    $("#todayIssuesBody").empty();
                                                    $('<ul><li class="C1">玩法类型</li><li class="C2">投注内容</li><li class="C3">倍数</li><li class="C4">金额</li><li class="C5">状态</li></ul>').appendTo("#todayIssuesBody");
                                                    if (response.prj.length == 0) {
                                                        $('<div class="todayNoBet">暂时没有记录！</div>').appendTo("#todayIssuesBody");
                                                    } else {
                                                        $.each(response.prj,
                                                            function (k, v) {
                                                                $('<ul><li class="C1"><a target="_blank" href="/?c=api&a=packageDetail&wrap_id=' + v.wrapId + urlSession() + '">' + v.methodName + '</a></li><li class="C2">' + v.code + '</li><li class="C3">' + v.multiple + '</li><li class="C4">' + v.amount + '</li><li class="C5">' + v.prizeStatus + "</li></ul>").click(function () {
                                                                }).appendTo("#todayIssuesBody");
                                                            });
                                                    }
                                                } else {

                                                    layer.alert("获取投注数据失败!");
                                                }
                                            },
                                            "json");
                                    }).appendTo("#todayIssuesHead");
                                });
                            $("#todayIssuesHead li:eq(2)").click();
                        } else {
                            layer.alert("获取最近几期数据失败!");
                        }
                    },
                    "json");
            }
        );
        //备注tips
        $(".ShowTips").mouseover(function () {
            layer.tips('从万位、千位、百位、十位、个位分别选择每位的1个或多个号码投注。', this, {
                guide: 1,
                style: ['background-color:#333; color:#fff', '#333'],
                maxWidth: 250,
                time: 90,
                closeBtn: [0, false]
            });
            //新增鼠标移除消失效果
            $(".ShowTips").mouseout(function () {
                $(".xubox_layer").hide();
            });
        });
        //投注清空tips
        $('.del').on('mouseover', function () {
            layer.tips('清空投注项', this, {
                guide: 1,
                time: 1,
                style: ['background-color:#333; color:#fff', '#333'],
                maxWidth: 200
            });
        });
//投注项-追号界面
        $(".ShowbeitouToolsBox").click(function () {
            var i = parent.$.layer({
                type: 1,
                title: '追号',
                offset: ['50px', ''],
                //border: [0],
                area: ['700px', 'auto'],
                page: {html: $('.AddNumberPop').html()}

            });
        });
//游戏大厅弹出层

        $(".newgame_lob").mouseover(function (e) {
            e.stopPropagation();
            $(".GamePopLayer").removeClass("hide");
        });
        $(".CloseLayer").click(function () {
            $(".GamePopLayer").addClass("hide");
        });
        $(document).mouseover(function () {
            if (!$(".GamePopLayer").hasClass("hide")) {
                $(".GamePopLayer").addClass("hide");
            }
        });
        $(".GamePopLayer").mouseover(function (e) {
            e.stopPropagation(); //阻止事件向上冒泡  
        });
        //公告
        $.getJSON(notice_url , function (data) {
            if (data.errno == 0) {
                $("#notice2").append(data.hot);
                //滚动
                var str = $(".ShowNewsMore").html();
                if(!(typeof (str) == "undefined")){
                    if(str.length >50){
                        $("#notice2").Scroll({line: 1, speed: 500, timer: 2000});
                    }
                }
                $("#layer_containerMore").append(data.all);
                function showNotice(notice_id) {
                    var i = $.layer({
                        type: 2,
                        title: '最新公告',
                        offset: ['100px', ''],
                        //border: [0],
                        area: ['900px', '500px'],
                        iframe: {
                            src: noticeUrl ,
                            scrolling: 'auto'
                        }

                    });
                }
                //最新公告弹出层
                $(".ShowNewsMore").click(function () {
                    var notice_id = $(this).attr('notice_id');
                    showNotice(notice_id);
                });
            }


        });
        // $('#gamerule').click(function () {
        //     var i = $.layer({
        //         type: 2,
        //         title: '游戏规则',
        //         offset: ['50px', ''],
        //         //border: [0],
        //         area: ['850px', '500px'],
        //         iframe: {
        //             src: '/?c=api&a=prizeDetail' + urlSession(),
        //             scrolling: 'auto'
        //         }
        //
        //     });
        // });
        $('#prizerule').click(function () {
            var i = $.layer({
                type: 2,
                title: '奖金计算说明',
                offset: ['50px', ''],
                //border: [0],
                area: ['850px', '500px'],
                iframe: {
                    src: prizeDetailUrl + '?lottery_id='+lottery_id ,
                    scrolling: 'auto'
                }

            });
        });
        //左边菜单
        $('#leftBar a').click(function () {
            var ops = $(this).attr('name').split('_');
            window.location.href = "index.php?c=" + ops[0] + "&a=" + ops[1] + "&_=" + Math.random() + urlSession();
        });
        //投注记录
        $('.kj_right_btn_myFa').click(function () {
            $(this).addClass('kj_right_btn_myFa_select');
            $('.kj_right_btn_myZh').removeClass('kj_right_btn_myZh_select');
            $("#mybetList").show();
            $("#myTraceList").hide();
            $.post(BuyRecordsUrl, {
                    lotteryId: lottery_id
                },
                function (response) {
                    if (response.errno == 0) {
                        if (response.prj.length == 0) {
                            $("#mybetListContent").html('暂时没有记录！');
                        } else {
                            $("#mybetListContent").empty();
                            $.each(response.prj,
                                function (k, v) {
                                    $("#mybetListContent").append('<li class="old_kj_left_box_list_li2"><a href="' +v.detailUrl + '" target="_blank"><span class="old_kj_right_box_list_s1">' + v.issue + '</span><span class="old_kj_right_box_list_s2">￥' + v.amount + '</span><span class="old_kj_right_box_list_s3">' + v.prizeStatus + '</span></a></li>');
                                });
                        }
                    }
                    else {
                        $("#mybetListContent").html(response.errstr);
                    }
                },
                "json");
        });
        $('.kj_right_btn_myZh').click(function () {
            $(this).addClass('kj_right_btn_myZh_select');
            $('.kj_right_btn_myFa').removeClass('kj_right_btn_myFa_select');
            $("#myTraceList").show();
            $("#mybetList").hide();
            $.post(traceRecordsUrl, {
                    lotteryId: lottery_id
                },
                function (response) {
                    if (response.errno == 0) {
                        if (response.prj.length == 0) {
                            $("#myTraceListContent").empty();
                            $("#myTraceListContent").append('<li class="old_kj_left_box_list_li2" ><a href="javascript:;" onclick="moreTraceRecord()" ><span class="old_kj_right_box_list_s1"></span><span class="old_kj_right_box_list_s2 kg_trace_record_btn1" id="kg_trace_record_btn1" >更多追号记录</span><span class="old_kj_right_box_list_s3"></span></a></li>');
                        } else {
                            $("#myTraceListContent").empty();
                            $.each(response.prj,
                                function (k, v) {
                                    $("#myTraceListContent").append('<li class="old_kj_left_box_list_li2"><a href="'+v.detailUrl + '" target="_blank"><span class="old_kj_right_box_list_s1">' + v.start_issue + '</span><span class="old_kj_right_box_list_s2">￥' + v.total_amount + '</span><span class="old_kj_right_box_list_s3">' + v.states + '</span></a></li>');
                                });
                            $("#myTraceListContent").append('<li class="old_kj_left_box_list_li2" ><a href="javascript:;" onclick="moreTraceRecord()" ><span class="old_kj_right_box_list_s1"></span><span class="old_kj_right_box_list_s2 kg_trace_record_btn1" id="kg_trace_record_btn1" >更多追号记录</span><span class="old_kj_right_box_list_s3"></span></a></li>');
                        }
                    }
                    else {
                        $("#myTraceListContent").html(response.errstr);
                    }
                },
                "json");
        });


        $('.kj_right_btn_myFa').click();


        //实时推荐
//        function gamePromo() {
//            $.post("?c=api&a=play" + urlSession(), {
//                op: "instancePromos",
//                lotteryId: lottery_id
//            },
//            function (response) {
//                if (response) {
//                    $("#gamePromoContainer").html(response);
//                    $("#gamePromoContainer").Scroll({line: 1, speed: 500, timer: 2000});
//                }
//            },
//                    "html");
//        }
//        gamePromo();
//        setInterval(gamePromo, 10000);


    })(openedIssues, lottery_id, lottery_type)
});