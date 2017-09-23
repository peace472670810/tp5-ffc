/*---------------------------------------------------------------------------base--------------------------------------------------------------------------------------------------------*/
$(document).on('pagebeforechange', function (e, data) {
    lastBackTime = 0;
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage), re = /^\#login/;
        if (u.hash.search(re) == -1) {
            var profile = cache.getProfile();
            if (!profile) {
                //store next page url
                login.nextPage = u.hash;
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

/*---------------------------------------------------------------------------login--------------------------------------------------------------------------------------------------------*/
//page before show event
/*$("#login").on('pagebeforeshow', function() {
 //reset form
 $(".hl-login > input").val("");
 });

 //page show event
 $("#login").on('pageshow', function() {
 //initialiaze
 login.init();
 });

 var login = {
 nextPage: "",
 //init
 init: function() {
 $("#loginConfirm").off("click").click(function() {
 login.login();
 });
 $("#loginCancel").off("click").click(function() {
 //move to welcome page
 $.mobile.changePage($("#cp"), {
 changeHash: true
 });
 });
 },
 //login
 login: function() {
 //show load
 $.mobile.loading('show');
 server.login({id: $("#txtLogin").val(), password: $("#txtPassword").val()}, function(data) {
 //hide load
 $.mobile.loading('hide');
 app.login(data);
 });
 }
 }*/

/*---------------------------------------------------------------------------cp--------------------------------------------------------------------------------------------------------*/
//page show event
$("#cp").on('pageshow', function () {
   
    $("#detail").hide();
    $("#traceDetail").hide();
    //initialiaze
    cp.init();
});

//refresh event
$(document).on('refresh', function (event, data) {

    if (data == "cp") {

        cp.updateDrawNumber(true);
    }
});

var cp = {
    //init
   //alert(123);
    init: function () {
        clearInterval(dsq);
        //reset user game related cache
        
        cache.resetGame(); 
        var data = cache.getData(); 
        server.getDjs();
        server.setDjs();
        if (data == null) {
            
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
            server.getConfig(function (data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    cp.render(data);
                }
            });
        }
        else { 
          //  alert('qweqweqweq');
            cp.render(data);
        }
    },
    //render
    render: function (data) {
        var games = data.games, g = [], gameLabel = "";
        if (games.length > 0) {
            var i = 1;
            $.each(games, function (index) {
                gameLabel = utils.getGameLabel(this.id);
                switch (i) {
                    case 3:
                    case 6:
                        g.push('<li style="width: 100%;float: left;display: block;border-bottom: 1px solid #d4d7d7;"><a href="#orderSelect?lottery=');
                        break;
                    case 7:
                    case 8:
                        g.push('<li style="width: 50%;float: left;display: block;border-bottom: 1px solid #d4d7d7;"><a href="#orderSelect?lottery=');
                        break;
                    default:
                        g.push('<li style="width: 50%;float: left;display: block;"><a href="#orderSelect?lottery=');
                        break;
                }
                g.push(this.id);
                g.push('" id="game');
                g.push(this.id);
                g.push('" title="');
                g.push(gameLabel);
                g.push('"><img src="' + RP_STATIC + 'css/images/thumb-');
                g.push(this.id);
                g.push('.png" class="hl-thumbnail" /><h3>');
                g.push(gameLabel);
                g.push("</h3><p>&nbsp;<i class='am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong' ></i>&nbsp;<span><span></p></a></li>");
                i++;
            });
        }
        else {
            g.push('<li>');
            g.push(label.noRecord);
            g.push('</li>');
        }

        $("#gameList").html(g.join("")).listview('refresh', true);
        var m = [];
        m.push('<div style="display: block;margin-left: 5%;width: 36%;overflow: hidden;text-overflow:ellipsis;float:left;white-space: nowrap;">账户：<label id="memberAccountId">&nbsp;  </label></div>');
        m.push('<div style="display: block;margin-right: 3%;width: 34%;overflow: hidden;text-overflow:ellipsis;float:right;white-space: nowrap;text-align: right">余额：<label id="memberAccountSummaryDesc">&nbsp;  </label>&nbsp;</div>');
        $("#memberAccount").html(m.join(""));
        //$('#refreshMemberAccountSummaryDesc').button();
        $('#memberAccountSummaryDesc').html('&nbsp;...');
        var profile = cache.getProfile();
        var accountId = 0;
        server.getAccount(profile, function (data) {
            if (data != null) {
                if (data.length > 0) {
                    $.each(data, function (index) {
                        $('#memberAccountId').html(cache.profile.id);
                        accountId = this.id;
                        if (this.val == '--') {
                            $('#memberAccountSummaryDesc').html('--');
                        } else {
                            $('#memberAccountSummaryDesc').html(utils.cny(this.val, 2));
                        }
                        //$('#memberAccountSummaryDesc').html(utils.cny(this.val, 2));

                    });
                }
            }

        });
        //server.getDetail({'id': accountId, 'trace_id': 1}, function(data) {
        //    console.log(data);
        //});
        //console.log(cache);
        //update draw number
        cp.updateDrawNumber(false);
    },
    //update draw number
    updateDrawNumber: function (showProgress) {
        var data = cache.getData();
        if (data != null) {
            if (showProgress) {
                $(".dn-refresh").hide();
                $(".dn-progress").show();
            }
            var games = data.games;
            $.each(games, function () {
                if (!isEmpty(this.desc)) {
                    $("#game" + this.id + " > p").text(this.desc);
                }
            });
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
        } else {
            //avoid infinite loop by only re-init when show progress is true
            if (showProgress) {
                cp.init();
            }
        }
    }
}

﻿/*---------------------------------------------------------------------------draw--------------------------------------------------------------------------------------------------------*/
//page before show event
$("#draw").on('pagebeforeshow', function () {
    //clear
    $("#drawList").empty();
});

//page show event
$("#draw").on('pageshow', function () {
    //initialiaze
    draw.init();
});

//page init event
$('#draw').on('pageinit', function (event) {
    $("#drawGameList").change(function (event, ui) {
        draw.search(false);
    });
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "draw") {
        draw.search(true);
    }
});

var draw = {
    //init
    init: function () {
        clearInterval(dsq);
        //clear content
        $("#drawList").empty();
        var data = cache.getData();
        if (data == null) {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
            server.getConfig(function (data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    draw.render();
                }
            });
        }
        else {
            draw.render();
        }
    },
    //render
    render: function () {
        var data = cache.getData(), gameId = "", drawGameList = $("#drawGameList");
        if (data != null) {
            if (drawGameList.html().length < 0) {
                draw.search(false);
            }
            else {
                var g = [],
                    gameLabel = "";
                $.each(data.games, function () {
                    gameLabel = utils.getGameLabel(this.id);
                    //set game code
                    if (gameId.length == 0) {
                        gameId = this.id;
                    }
                    g.push('<option value="');
                    g.push(this.id);
                    g.push('">');
                    g.push(gameLabel);
                    g.push('</option>');
                });
                // 默认方法
                drawGameList.empty().html(g.join(""));
                var m = [];
                m.push('<div style="display: block;margin-left: 5%;width: 36%;overflow: hidden;text-overflow:ellipsis;float:left;white-space: nowrap;">账户：<label id="drawmemberAccountId">&nbsp;  </label></div>');
                m.push('<div style="display: block;margin-right: 3%;width: 34%;overflow: hidden;text-overflow:ellipsis;float:right;white-space: nowrap;text-align: right">余额：<label id="drawmemberAccountSummaryDesc">&nbsp;  </label>&nbsp;</div>');
                $("#drawmemberAccount").html(m.join(""));
                //$('#refreshMemberAccountSummaryDesc').button();
                $('#drawmemberAccountSummaryDesc').html('&nbsp;...');
                var profile = cache.getProfile();
                var accountId = 0;
                server.getAccount(profile, function (data) {
                    if (data != null) {
                        if (data.length > 0) {
                            $.each(data, function (index) {
                                $('#drawmemberAccountId').html(cache.profile.id);
                                accountId = this.id;
                                if (this.val == '--') {
                                    $('#drawmemberAccountSummaryDesc').html('--');
                                } else {
                                    $('#drawmemberAccountSummaryDesc').html(utils.cny(this.val, 2));
                                }
                                //$('#drawmemberAccountSummaryDesc').html(utils.cny(this.val, 2));

                            });
                        }
                    }

                });
                //reset dropdown
                if (orderSelect.gameSubOption) {
                    var game_order = 0;
                    for (var i in cache.getData().games) {
                        if (cache.getData().games[i].lottery_id == orderSelect.gameSubOption.lottery_id) {
                            game_order = i;
                        }
                    }
                    drawGameList[0].selectedIndex = game_order;
                } else {
                    drawGameList[0].selectedIndex = 0;
                }
                drawGameList.selectmenu("refresh", true);
                if (gameId.length > 0) {
                    draw.search(false);
                }
            }
        }
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var gameId = $("#drawGameList").val();
        server.getDrawResult(gameId, function (data) {
            if (data != null) {
                var r = [], arrt = [];
                gameLabel = "";
                if (data.length > 0) {
                    $.each(data, function (index) {
                        if (this.val.indexOf(" ") == -1) {
                            arrt = this.val.split(",");
                        } else {
                            arrt = this.val.split(" ");
                        }
                        r.push('<li>');
                        r.push(label.drawNumber.replace("{0}", this.id));
//                        r.push('<span class="hl-spacer"></span>');
//                        r.push(this.date);
                        r.push('<br/>');
                        $.each(arrt, function (k, v) {
                            r.push('<span class="hl-draw">');
                            if (v.length == 1) {
                                r.push('&nbsp;' + v);
                            } else {
                                r.push(v);
                            }
                            r.push('</span>');
                        });
                        r.push('</li>');

                    });
                }
                else {
                    r.push('<li>');
                    r.push(label.noRecord);
                    r.push('</li>');
                }
                $("#drawList").html(r.join("")).listview('refresh');
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    }
}

﻿/*---------------------------------------------------------------------------search--------------------------------------------------------------------------------------------------------*/


//page before show event
$("#search").on('pagebeforeshow', function () {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //reset page number
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();
        //clear
        $("#searchList").empty();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#search").on('pageshow', function () {
    //initialiaze
    $("#traceDetail").hide();
    search.init();
});

//page init event
$('#search').on('pageinit', function (event) {
    $("#searchGameList").change(function (event, ui) {
        //reset page number
        for (var i in cache.getData().games) {
            if (cache.getData().games[i].id == this.value) {
                search.readyus = cache.getData().games[i].lottery_id;
            }
        }
        search.cqd = 1;
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();
        //clear
        $("#searchList").empty();
        search.search(false);
    });

    $("#searchRangeList").change(function (event, ui) {
        //reset page number
        search.selectday = this.value;
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();
        //clear
        $("#searchList").empty();
        search.search(true);
    });

    $("#searchMoreLink").unbind("click").click(function () {
        //increase page number
        search.pageNumber++;
        search.search(false);
    });
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "search") {
        //reset page number
        search.pageNumber = 1;
        search.search(true);
    }
});

var search = {
    pageNumber: 1,
    readyus: 1,
    selectday: 1,
    cqd: 0,
    //init
    init: function () {
        clearInterval(dsq);
        //clear
        $("#searchList").empty();
        var data = cache.getData();
        if (data == null) {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
            server.getConfig(function (data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    search.render();
                }
            });
        }
        else {
            $.mobile.loading('hide');
            search.render();
        }
    },
    //render
    render: function () {
        var data = cache.getData(),
            gameId = "",
            searchGameList = $("#searchGameList"),
            searchRangeList = $("#searchRangeList");
        if (data != null) {
            if (searchGameList.html().length < 0) {
                search.search(false);
            }
            else {
                var g = [],
                    d = [],
                    gameLabel = "";
                $.each(data.games, function () {
                    gameLabel = utils.getGameLabel(this.id);
                    //set game code
                    if (gameId.length == 0) {
                        gameId = this.id;
                    }
                    g.push('<option value="');
                    g.push(this.id);
                    g.push('">');
                    g.push(gameLabel);
                    g.push('</option>');
                });
                searchGameList.empty().html(g.join(""));
                var m = [];
                m.push('<div style="display: block;margin-left: 5%;width: 36%;overflow: hidden;text-overflow:ellipsis;float:left;white-space: nowrap;">账户：<label id="searchmemberAccountId">&nbsp;  </label></div>');
                m.push('<div style="display: block;margin-right: 3%;width: 34%;overflow: hidden;text-overflow:ellipsis;float:right;white-space: nowrap;text-align: right;">余额：<label id="searchmemberAccountSummaryDesc">&nbsp;  </label>&nbsp;</div>');
                $("#searchmemberAccount").html(m.join(""));
                //$('#refreshMemberAccountSummaryDesc').button();
                $('#searchmemberAccountSummaryDesc').html('&nbsp;...');
                var profile = cache.getProfile();
                var accountId = 0;
                server.getAccount(profile, function (data) {
                    if (data != null) {
                        if (data.length > 0) {
                            $.each(data, function (index) {
                                $('#searchmemberAccountId').html(cache.profile.id);
                                accountId = this.id;
                                if (this.val == '--') {
                                    $('#searchmemberAccountSummaryDesc').html('--');
                                } else {
                                    $('#searchmemberAccountSummaryDesc').html(utils.cny(this.val, 2));
                                }
                                //$('#searchmemberAccountSummaryDesc').html(utils.cny(this.val, 2));

                            });
                        }
                    }

                });
                //reset dropdown
                if (search.readyus != 1 || search.cqd == 1) {
                    // 默认方法
                    var game_order = 0;
                    for (var i in cache.getData().games) {
                        if (cache.getData().games[i].lottery_id == search.readyus) {
                            game_order = i;
                        }
                    }
                    searchGameList[0].selectedIndex = game_order;
                } else if (orderSelect.gameSubOption) {
                    var game_order = 0;
                    for (var i in cache.getData().games) {
                        if (cache.getData().games[i].lottery_id == orderSelect.gameSubOption.lottery_id) {
                            game_order = i;
                        }
                    }
                    searchGameList[0].selectedIndex = game_order;
                } else {
                    searchGameList[0].selectedIndex = 0;
                }
                searchGameList.selectmenu("refresh", true);
                for (var i = 1; i < 8; i++) {
                    d.push('<option value="');
                    d.push(i.toString());
                    d.push('">');
                    d.push(i.toString());
                    d.push("天</option>");
                }
                d.push('<option value="-1">未结算</option>');
                searchRangeList.empty().html(d.join(""));
                //reset dropdown
                searchRangeList[0].selectedIndex = search.selectday - 1;
                searchRangeList.selectmenu("refresh", true);
                if (gameId.length > 0) {
                    search.search(false);
                }
            }
        }
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var item = {};
        item.gameId = $("#searchGameList").val();
        if (search.selectday != 1) {
            item.day = search.selectday;
        } else {
            item.day = $("#searchRangeList").val();
        }
        item.pageNumber = search.pageNumber;
        item.pageSize = setting.search.pageSize;
        server.getOrders(item, function (data) {
            if (data != null) {
                var modestr = [];
                var s = [];
                modestr['1'] = ['2元'];
                modestr['0.5'] = ['1元'];
                modestr['0.1'] = ['2角'];
                modestr['0.01'] = ['2分'];
                if (data.r.length > 0) {
                    $.each(data.r, function (index) {
                        s.push('<li><a href="#detail?id=' + this.wrapId +'&lid='+this.lottery_id+ '&trace_id=' + this.traceId+'&mg_id='+this.mg_id+'&issue='+this.issue);
                        s.push('"><div class="hl-search-search"><div class="hl-search-bet">');
                        s.push(this.create_time);
                        s.push('</div><div class="hl-search-order">');
                        s.push((modestr[this.modes]));
                        s.push('</div><div class="hl-search-amount">');
                        s.push(utils.digits(this.amount, 2));
                        s.push('</div><div class="hl-search-status">');
                        s.push((this.prizeStatus));
                        s.push('</div></div></a></li>');
                    });
                } else {
                    s.push('<li>');
                    s.push(label.noRecord);
                    s.push('</div></li>');
                }
                if (showProgress) {
                    $("#searchList").html(s.join("")).listview('refresh');
                }
                else {
                    $("#searchList").append(s.join("")).listview('refresh');
                }
                //show title
                $(".hl-search-title-container").show();
                //show or hide more button
                if (data.r.length > 0 && data.c > search.pageNumber) {
                    $("#searchMoreContainer").show();
                }
                else {
                    $("#searchMoreContainer").hide();
                }
                if (showProgress) {
                    $(".dn-progress").hide();
                    $(".dn-refresh").show();
                }
                else {
                    //hide load
                    $.mobile.loading('hide');
                }
            }
        });
    }
}

﻿/*---------------------------------------------------------------------------detail--------------------------------------------------------------------------------------------------------*/
//page before change event
$(document).on("pagebeforechange", function (e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
            re = /^#detail/;
        if (u.hash.search(re) !== -1) {
            detail.id = getUrlParam('id', u.hash);
            detail.trace_id = getUrlParam('trace_id', u.hash);
            traceDetail.trace_id = getUrlParam('trace_id',u.hash);
            detail.lid = getUrlParam('lid',u.hash);
            detail.mg_id = getUrlParam('mg_id',u.hash);
            detail.issue = getUrlParam('issue',u.hash);
        }
    }
});
//追号详情
$("#traceDetail").on('pagebeforeshow', function () {
    //hide content
    $("#detailNumber").text("");
    $(".hl-detail-main, #cancelpackage").hide();
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#detailList").empty();
    }
    else {
        $.mobile.changePage($("#search"), {
            changeHash: false
        });
    }
});
$("#traceDetail").on('pageshow',function () {
    $("#traceDetail").show();
    traceDetail.init();
});
var traceDetail = {
    trace_id:"",
    init:function () {
        clearInterval(dsq);
        if(traceDetail.trace_id.length>0){
            server.getTraceDetail({trace_id:traceDetail.trace_id},function (data) {
                $.mobile.loading('hide');
                if (data != null) {
                    //render
                    traceDetail.render(data);
                }else{
                    $("#detailNumber1").text(label.noRecord);
                }
            });
        }else{
            $("#detailNumber1").text(label.noRecord);
        }
    },
    render:function(data){
        $.mobile.loading('hide');
        var o = [];
        if(data != null){
            $.each(data.detail, function () {
                o.push('<li>');
                o.push('<span class="hl-detail-game">');
                o.push(this.m_name);
                o.push('</span><span class="hl-detail-number">号码：');
                o.push(this.number);
                o.push('</span><span class="hl-detail-bet">');
                o.push(this.nums);
                o.push('注</span></li>');
            });
            $("#detailList1").html(o.join("")).listview('refresh');
            $(".hl-detail-normal").hide();
            $(".hl-detail-cno").show();
            $("#detailNumber1").text(data.wrap_id);
            $("#detail2_lottery").text(data.lidName);
            $("#detail2_issue").text(data.t_start_issue);
            $("#detail2_modes").text(data.t_modes);
            $("#detail2_single_num").text(data.t_single_num);
            $("#detail2_total_multiple").text(data.t_total_multiple);
            $("#detail2_trace_times").text(data.t_trace_times);
            $("#detail2_total_amount").text(data.t_total_amount);
            $("#detail2_stop_on_win").text(data.t_stop);
            $("#detail2_status").text(data.status);
            $("#detail2_create_time").text(data.t_add_time);
            var oPackages = [];
                $.each(data.order, function (aii) {
                    oPackages.push('<li>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">追号期号:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.ds_qishu + '</label></div>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">开奖号码:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.ds_balls + '</label></div>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">当期倍数:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.multiple + '</label></div>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">投注金额:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.total_amount + '</label></div>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">中奖金额:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.total_prize + '</label></div>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">订单状态:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.status + '</label>');
                    oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label1">当期状态:</label>');
                    oPackages.push('<label class="hl-detail-display-label2">' + this.issue_status + '</label>');
                    var cancel_status = false;
                    if(this.cancel_status == 1){
                        cancel_status = true;
                        oPackages.push('<input type="checkbox" id="canceltrace' + aii + '" checked="checked" style="position: absolute" name="arrTrace" value=' + aii + ' />');
                    }
                    if(cancel_status){
                        $("#cancelpackage").off("click").click(function () {
                            $("#withdrawPopup").popup("open");
                            //programmatically bind click event
                            $("#confirmWithdraw").off("click").click(function () {
                                var cancelIssues = '';
                                $("input[name='arrTrace']:checked").each(function(i){
                                    cancelIssues += this.value+',';
                                });
                                traceDetail.withdraw({'issues': cancelIssues, 'trace_id': traceDetail.trace_id});
                                $("#cancelpackage").hide();
                            });
                        }).show();
                        $("#cancelpackage").show();
                    }
                    oPackages.push('</div></li>');
                });
                $("#zhuihaoList1").html(oPackages.join("")).listview('refresh');
            $(".hl-detail-main").show();
        }else{
            $("#detailNumber1").text(label.noRecord);
        }
    },
    withdraw:function(sdata){
        //show load
        $.mobile.loading('hide');
        $.mobile.loading('show');
        server.withdraw(sdata, function (data) {
            //hide load
            $.mobile.loading('hide');
            $(".hl-detail-main, #cancelpackage").hide();
            if (data.errno == '0') {
                utils.alert(label.withdrawSuccess, $("#traceDetail"));
            }
            else {
                utils.alert(data.errstr, $("#traceDetail"));
            }
            $("#traceDetail").show();
            traceDetail.init();
        });
    }
};
$("#back_search1").click(function () {
    $("#traceDetail").hide();
    window.history.go(-1);
});
//page before show event  注单详情
$("#detail").on('pagebeforeshow', function () {
    //hide content
    $("#detailNumber").text("");
    $(".hl-detail-main, #cancelpackage").hide();
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#detailList").empty();
    }
    else {
        $.mobile.changePage($("#search"), {
            changeHash: false
        });
    }
});
$("#back_search").click(function () {
    window.history.go(-1);
});

//page show event
$("#detail").on('pageshow', function () {
    //initialiaze
    $("#detail").show();
    detail.init();
});

var detail = {
    id: "",
    lid:"",
    mg_id:"",
    issue:"",
    //init
    init: function () {
        clearInterval(dsq);
        if (detail.id.length > 0) {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
            server.getDetail({'id': detail.id, 'trace_id': detail.trace_id,'mg_id':detail.mg_id,'lid':detail.lid,issue:detail.issue}, function (data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //render
                    detail.render(data);
                } else {
                    $("#detailNumber").text(label.noRecord);
                }
            });
        } else {
            $("#detailNumber").text(label.noRecord);
        }
    },
    //render
    render: function (data) {
        var o = [];
        //number list
        $.each(data.code_detail, function () {
            o.push('<li>');
            o.push('<span class="hl-detail-game">');
            o.push(this.name);
            o.push('</span><span class="hl-detail-number">');
            o.push(this.number);
            o.push('</span><span class="hl-detail-bet">');
            o.push(this.nums);
            o.push('注</span></li>');
        });
        $("#detailList").html(o.join("")).listview('refresh');
            $(".hl-detail-normal").show();
            $(".hl-detail-cno").hide();
            $("#detailNumber").text(data.o_sn);
            $("#detail_username").text(data.o_username);
            $("#detail_create_time").text(data.o_add_time);
            $("#detail_lottery").text(data.lidName);
            $("#detail_issue").text(data.o_issue);
            $("#detail_single_num").text(data.o_single_num);
            $("#detail_multiple").text(data.o_multiple);
            $("#detail_modes").text(data.modeName);
            if(data.o_trace_id){
                var create_trace_a = document.createElement("a");
                var create_node = document.createTextNode("是【查看追号详情】");
                create_trace_a.appendChild(create_node);
                create_trace_a.setAttribute('href','#traceDetail?trace_id='+data.o_trace_id);
                create_trace_a.setAttribute('class','create_trace_a');
                $("#detail_is_trace").html(create_trace_a);
            }else{
                $("#detail_is_trace").text(data.trace_status);
            }
            $("#detail_amount").text(data.o_amount);
            $("#detail_prizeMode").text(data.odd_detail);
            $("#detail_openCodes").text(data.draw_code);
            $("#detail_status").text(data.prize_status);
            $("#detail_prize").text(data.o_wins);
            //withdraw button 撤单
            detail.wrap_id = data.o_sn;
        $(".hl-detail-main").show();
    },
    //withdraw
    withdraw: function (id) {
        //show load
        $.mobile.loading('hide');
        $.mobile.loading('show');
        server.withdraw(id, function (data) {
            //hide load
            $.mobile.loading('hide');
            $(".hl-detail-main, #cancelpackage").hide();
            if (data.errno == '0') {
                utils.alert(label.withdrawSuccess, $("#detail"));
            }
            else {
                utils.alert(data.errstr, $("#detail"));
            }
            detail.init();
        });
    }
}

﻿/*---------------------------------------------------------------------------member--------------------------------------------------------------------------------------------------------*/

//page show event
$("#member").on('pageshow', function () {
    //initialiaze
    member.init();
});

var member = {
    //init
    init: function () {
        clearInterval(dsq);
        member.render();
    },
    //render
    render: function () {
        $("#memberList").empty();
        var m = [];
        m.push('<li><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.account);
        m.push('</h3><div><label id="memberAccountSummaryDesc">&nbsp;  </label>&nbsp;  <a href="javascript:void(0);"><img id="refreshMemberAccountSummaryDesc" height="10px" src="' + RP_STATIC + 'images/ico-refresh10.png" /></a></div> </li><li><a href="#deposits"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.deposits);
        m.push('</h3><p>&nbsp;</p></a></li><li><a href="#accountWithdraw"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.withdraw);
        m.push('</h3><p>&nbsp;</p></a></li><li><a href="#accountInquiry"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.inquiry);
        m.push('</h3><p>&nbsp;</p></a></li>');
        $("#memberList").html(m.join("")).listview('refresh', true);
        //$('#refreshMemberAccountSummaryDesc').button();
        member.memberAccountSummaryDesc();

        $('#refreshMemberAccountSummaryDesc').off('click').click(function () {
            member.memberAccountSummaryDesc();
        });
        //<button data-role="button" id="refreshMemberAccountSummaryDesc" data-icon="refresh"   data-inline="true"/>

    },
    memberAccountSummaryDesc: function () {
        $('#memberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...');
        var profile = cache.getProfile();
        server.getAccount(profile, function (data) {
            if (data != null) {
                if (data.length > 0) {
                    $.each(data, function (index) {
                        if (this.val == '--') {
                            $('#memberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + '--');
                        } else {
                            $('#memberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + utils.cny(this.val, 2));
                        }


                    });
                }
            }

        });

    }

}

﻿/*---------------------------------------------------------------------------deposits--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#deposits").on('pagebeforeshow', function () {
    $("#depositsList").empty();
});

//page show event
$("#deposits").on('pageshow', function () {
    //initialiaze
    deposits.init();
});

var deposits = {
    //init
    init: function () {
        clearInterval(dsq);
        deposits.render();
    },
    //render
    render: function () {
        var m = [];
        m.push('<li><a href="#alipay"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.alipayDeposit);
        m.push('</h3><p>&nbsp;</p></a></li>');

        m.push('<li><a href="#tenpay"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.tenpayDeposit);
        m.push('</h3><p>&nbsp;</p></a></li>');

        m.push('<li><a href="#icbc"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.icbcDeposit);
        m.push('</h3><p>&nbsp;</p></a></li>');

        m.push('<li><a href="#yeepaycard"><img src="' + RP_STATIC + 'css/images/ico-gold.png" /><h3>');
        m.push(label.yeepaycardDeposit);
        m.push('</h3><p>&nbsp;</p></a></li>');


        $("#depositsList").html(m.join("")).listview('refresh', true);
    }
}

﻿/*---------------------------------------------------------------------------accountSummary--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#accountSummary").on('pagebeforeshow', function () {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#accountList").empty();
        $(".hl-account-summary-container").hide();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountSummary").on('pageshow', function () {
    //initialiaze
    accountSummary.init();
});

//page init event
$('#accountSummary').on('pageinit', function (event) {

});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "accountSummary") {
        accountSummary.search(true);
    }
});

var accountSummary = {
    //init
    init: function () {
        clearInterval(dsq);
        //clear content
        $("#accountList").empty();
        accountSummary.search(false);
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }

        var profile = cache.getProfile();

        server.getAccount(profile, function (data) {
            if (data != null) {
                //render
                accountSummary.render(data);
            }

            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function (data) {
        var a = [],
            s = [],
            accountLabel = "";

        //list
        s.push('<option value="">&nbsp;</option>');

        if (data.length > 0) {
            $.each(data, function (index) {
                accountLabel = utils.getAccountLabel(this.id);
                a.push('<li><div class="hl-account-type">');
                a.push(accountLabel);
                a.push('</div><div class="hl-account-bal" id="acct_' + this.aId + '">');
                a.push(utils.cny(this.val, 2));
                a.push('</div></li>');

                s.push('<option value="');
                s.push(this.aId);
                s.push('">');
                s.push(accountLabel);
                s.push('</option>');
            });
        }
        else {
            a.push('<li>');
            a.push(label.noRecord);
            a.push('</li>');
        }
        $("#accountList").empty().html(a.join("")).listview('refresh');
        $(".hl-account-summary-container").show();

    }


}

﻿/*---------------------------------------------------------------------------accountInquiry--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#accountInquiry").on('pagebeforeshow', function () {
    var profile = cache.getProfile();

    if (profile != null && profile.id.length > 0) {
        //reset page number
        accountInquiry.pageNumber = 1;
        $(".hl-account-inquiry-title-container, #accountMoreContainer").hide();

        //clear
        $("#accountInquiryList").empty();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountInquiry").on('pageshow', function () {
    //initialiaze
    accountInquiry.init();
});

//page init event
$('#accountInquiry').on('pageinit', function (event) {
    $("#searchAccountList").change(function (event, ui) {
        //reset page number
        accountInquiry.pageNumber = 1;
        $(".hl-account-inquiry-title-container, #accountMoreContainer").hide();

        //clear
        $("#accountInquiryList").empty();

        accountInquiry.search(false);
    });

    $("#accountMoreLink").off("click").click(function () {
        //increase page number
        accountInquiry.pageNumber++;
        accountInquiry.search(false);
    });
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "accountInquiry") {
        //reset page number
        accountInquiry.pageNumber = 1;

        accountInquiry.search(true);
    }
});

var accountInquiry = {
    pageNumber: 1,
    //init
    init: function () {
        clearInterval(dsq);
        //clear
        $("#accountInquiryList").empty();
        accountInquiry.render();
    },
    //render
    render: function () {
        var data = cache.getProfile(),
            accountId = "",
            searchAccountList = $("#searchAccountList");

        if (data != null) {
            if (searchAccountList.html().length > 0) {
                accountInquiry.search(false);
            }
            else {
                var a = [],
                    accountLabel = "";

                $.each(data.a, function () {
                    accountLabel = utils.getAccountLabel(this.id);
                    if (accountLabel == null || accountLabel == '') {
                        return;
                    }
                    //set account id
                    if (accountId.length == 0) {
                        accountId = this.id;
                    }
                    a.push('<option value="');
                    a.push(this.id);
                    a.push('">');
                    a.push(accountLabel);
                    a.push('</option>');
                });

                searchAccountList.empty().html(a.join(""));
                //reset dropdown
                searchAccountList[0].selectedIndex = 0;
                searchAccountList.selectmenu("refresh", true);
                if (accountId.toString().length > 0) {
                    accountInquiry.search(false);
                }
            }
        }
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var item = {};
        item.id = $("#searchAccountList").val();
        item.pageNumber = accountInquiry.pageNumber;
        item.pageSize = setting.search.pageSize;
        server.getAccountActivity(item, function (data) {
            if (data != null) {
                var s = [];
                if (data.r.length > 0) {
                    $.each(data.r, function (index) {
                        s.push('<li><div class="hl-account-inquiry"><div class="hl-account-inquiry-date">');
                        s.push(this.create_time);
                        s.push('</div><div class="hl-account-inquiry-txn ');
                        if (this.amount >= 0) {
                            s.push('hl-account-inquiry-txn-in');
                        }
                        else {
                            s.push('hl-account-inquiry-txn-out');
                        }
                        s.push('">');
                        s.push(utils.digits(this.amount, 2));
                        s.push('</div><div class="hl-account-inquiry-bal">');
                        s.push(utils.digits(this.balance, 2));
                        s.push('</div><div class="hl-account-inquiry-type">');
                        s.push(this.type);
                        s.push('</div></div></li>');
                    });
                }
                else {
                    s.push('<li>');
                    s.push(label.noRecord);
                    s.push('</div></li>');
                }

                if (showProgress) {
                    $("#accountInquiryList").html(s.join("")).listview('refresh');
                }
                else {
                    $("#accountInquiryList").append(s.join("")).listview('refresh');
                }

                //show title
                $(".hl-account-inquiry-title-container").show();

                //show or hide more button
                if (data.r.length > 0 && data.c > accountInquiry.pageNumber) {
                    $("#accountMoreContainer").show();
                }
                else {
                    $("#accountMoreContainer").hide();
                }

                if (showProgress) {
                    $(".dn-progress").hide();
                    $(".dn-refresh").show();
                }
                else {
                    //hide load
                    $.mobile.loading('hide');
                }
            }
        });
    }
}

﻿/*---------------------------------------------------------------------------accountWithdraw--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#accountWithdraw").on('pagebeforeshow', function () {
    //clear
    $("#accountWithdrawMessage, #accountWithdrawBalance").text("");
    $("#txtWithdrawAmount, #txtAccountPassword").val("");
    $("#accountWithdrawFrom").empty();
    $(".hl-account-withdraw-container").hide();
});

//page show event
$("#accountWithdraw").on('pageshow', function () {
    //initialiaze
    accountWithdraw.init();
});

//page init event
$('#accountWithdraw').on('pageinit', function (event) {
    $("#accountWithdrawLink").off("click").click(function () {
        accountWithdraw.withdraw();
    });
});


//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "accountWithdraw") {
        accountWithdraw.search(true);
    }
});

var accountWithdraw = {
    //init
    init: function () {
        clearInterval(dsq);
        //clear content
        $("#accountWithdrawMessage, #accountWithdrawBalance").text("");
        $("#txtWithdrawAmount, #txtAccountPassword").val("");
        $("#accountWithdrawFrom").empty();
        accountWithdraw.search(false);
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var profile = cache.getProfile();
        server.getAccountWithdraw(profile, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data != null) {
                //render
                accountWithdraw.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function (data) {
        if (data) {
            if (isEmpty(data.errno)) {
                var s = [];
                if (data.bindCards && data.withdrawBankList) {
                    $.each(data.bindCards, function (index) {
                        s.push('<option value="');
                        s.push(this.bank_id + '_' + this.bind_card_id);
                        s.push('">');
                        s.push(data.withdrawBankList[this.bank_id]);
                        s.push('</option>');
                    });
                }
                $("#accountWithdrawMessage").html(label.withdrawMessage.replace("{0}", data.min_withdraw_limit).replace("{1}", data.max_withdraw_limit));
                $("#accountWithdrawBalance").text(utils.cny(data.balance, 2));
                //dropdown
                $("#accountWithdrawFrom").empty().html(s.join(""));
                $("#accountWithdrawFrom").selectmenu("refresh", true);
                $("#txtWithdrawAmount").val("");
                $("#txtAccountPassword").val("");
                $(".hl-account-withdraw-container").show();

            }
            else {

                utils.prompt(data.errstr, $("#accountWithdraw"),
                    function () {
                        $(".hl-account-withdraw-container").hide();
                        $("#accountWithdrawLink").hide();
                    });

            }
        }
    },
    //withdraw
    withdraw: function () {
        var detail = {};
        detail.withdraw_amount = $("#txtWithdrawAmount").val();
        var bank = $("#accountWithdrawFrom").val().split('_');
        detail.withdraw_bank_id = bank[0];
        detail.bind_card_id = bank[1];
        detail.secpassword = $("#txtAccountPassword").val();
        //show load
        $.mobile.loading('hide');
        $.mobile.loading('show');
        server.accountWithdraw(detail, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data) {
                if (data.errno == 0) {
                    utils.prompt(label.withdrawCashSuccess, $("#accountWithdraw"),
                        function () {
                            accountWithdraw.search(false);
                        });
                }
                else {
                    utils.prompt(data.errstr, $("#accountWithdraw"),
                        function () {
                            accountWithdraw.search(false);
                        });

                }
            }

        });
    }
}


﻿/*---------------------------------------------------------------------------alipay--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#alipay").on('pagebeforeshow', function () {
    $(".hl-alipay-container").hide();
});

//page show event
$("#alipay").on('pageshow', function () {
    //initialiaze
    alipay.init();
});

//page init event
$('#alipay').on('pageinit', function (event) {

});


//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "alipay") {
        alipay.search(true);
    }
});

var alipay = {
    //init
    init: function () {
        clearInterval(dsq);
        alipay.search(false);
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var pay = {'bank': 'alipay'};
        server.getPay(pay, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data != null) {
                //render
                alipay.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function (data) {
        if (data) {
            if (isEmpty(data.errno)) {
                $("#alipayMessage").html(label.alipayMessage);
                $("#alipayAccount").val(data.card_num);
                $("#alipayTag").val(data.postscript);
                $("#alipayTag").off("click").click(function () {
                    $(this).select();
                });
                $("#alipayAccount").off("click").click(function () {
                    $(this).select();
                });

                $(".hl-alipay-container").show();
            }
            else {

                utils.prompt(data.errstr, $("#alipay"),
                    function () {
                        $(".hl-alipay-container").hide();
                    });

            }
        }
    },
}

﻿/*---------------------------------------------------------------------------yeepaycard--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#yeepaycard").on('pagebeforeshow', function () {
    $(".hl-yeepaycard-container").hide();
});

//page show event
$("#yeepaycard").on('pageshow', function () {
    //initialiaze
    yeepaycard.init();
});

//page init event
$('#yeepaycard').on('pageinit', function (event) {

});


//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "yeepaycard") {
        yeepaycard.search(true);
    }
});

var yeepaycard = {
    //init
    init: function () {
        clearInterval(dsq);
        yeepaycard.search(false);
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var pay = {'bank': 'yeepaycard'};
        server.getPay(pay, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data) {
                //render
                yeepaycard.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function (data) {
        if (data) {
            if (isEmpty(data.errno)) {
                $("#yeepaycardMessage").html(label.yeepaycardMessage);
                var typeList = '';
                var amountList = '';
                $.each(data.types, function (index) {
                    typeList += '<option value="' + this.code + '">' + this.name + '</option>';
                });
                $.each(data.amounts, function (index) {
                    amountList += '<option value="' + this.amount + '">' + this.name + '</option>';
                });
                $("#yeepaycardTypeList").html(typeList).selectmenu("refresh", true);
                $("#yeepaycardAmountList").html(amountList).selectmenu("refresh", true);
                $(".hl-yeepaycard-container").show();

                $('#yeepaycardSubmit').off('click').click(function () {
                    $('#iframepage_iframe').attr('src', RP_DATA + '?c=fin&a=deposit&autoSubmit=yeepaycard&code=' + $("#yeepaycardTypeList").val()
                        + '&amount=' + $("#yeepaycardAmountList").val());
                    $('#iframepage_iframe').attr('height', '800px');
                    $('#iframepage_title').html($("#yeepaycardTypeList option:selected").text() + ' 易宝充值');
                    $('#iframepage_header').off('click').click(function () {
                        $.mobile.changePage($("#yeepaycard"), {
                            transition: 'pop',
                            reverse: true,
                            changeHash: true
                        });
                        return false;

                    });
                    return true;
                });

            }
            else {

                utils.prompt(data.errstr, $("#yeepaycard"),
                    function () {
                        $(".hl-yeepaycard-container").hide();
                    });

            }
        }
    },
}

/*---------------------------------------------------------------------------tenpay--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#tenpay").on('pagebeforeshow', function () {
    $(".hl-tenpay-container").hide();
});

//page show event
$("#tenpay").on('pageshow', function () {
    //initialiaze
    tenpay.init();
});

//page init event
$('#tenpay').on('pageinit', function (event) {

});


//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "tenpay") {
        tenpay.search(true);
    }
});

var tenpay = {
    //init
    init: function () {
        clearInterval(dsq);
        tenpay.search(false);
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var pay = {'bank': 'tenpay'};
        server.getPay(pay, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data != null) {
                //render
                tenpay.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function (data) {
        if (data) {
            if (isEmpty(data.errno)) {
                $("#tenpayMessage").html(label.tenpayMessage);
                $("#tenpayAccount").val(data.card_num);
                $("#tenpayTag").val(data.postscript);
                $("#tenpayTag").off("click").click(function () {
                    $(this).select();
                });
                $("#tenpayAccount").off("click").click(function () {
                    $(this).select();
                });

                $(".hl-tenpay-container").show();
            }
            else {

                utils.prompt(data.errstr, $("#tenpay"),
                    function () {
                        $(".hl-tenpay-container").hide();
                    });

            }
        }
    },
}

﻿/*---------------------------------------------------------------------------icbc--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#icbc").on('pagebeforeshow', function () {
    $(".hl-icbc-container").hide();
});

//page show event
$("#icbc").on('pageshow', function () {
    //initialiaze
    icbc.init();
});

//page init event
$('#icbc').on('pageinit', function (event) {

});


//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "icbc") {
        icbc.search(true);
    }
});

var icbc = {
    //init
    init: function () {
        clearInterval(dsq);
        icbc.search(false);
    },
    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('hide');
            $.mobile.loading('show');
        }
        var pay = {'bank': 'icbc'};
        server.getPay(pay, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data != null) {
                //render
                icbc.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function (data) {
        if (data) {
            if (isEmpty(data.errno)) {
                $("#icbcMessage").html(label.icbcMessage);

                $("#icbcName").val(data.card_name);
                $("#icbcAccount").val(data.card_num);
                $("#icbcTag").val(data.postscript);

                $("#icbcAccount").off("click").click(function () {
                    $(this).select();
                });
                $("#icbcTag").off("click").click(function () {
                    $(this).select();
                });
                $("#icbcName").off("click").click(function () {
                    $(this).select();
                });

                $(".hl-icbc-container").show();
            }
            else {

                utils.prompt(data.errstr, $("#icbc"),
                    function () {
                        $(".hl-icbc-container").hide();
                    });

            }
        }
    },
}

﻿/*---------------------------------------------------------------------------orderSelect--------------------------------------------------------------------------------------------------------*/
//page before change event
$(document).on("pagebeforechange", function (e, data) {
    //use cache if available, otherwise read from url
    if (cache.getGame() == null) {
        if (typeof data.toPage === "string") {
            var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#orderSelect/;
            if (u.hash.search(re) !== -1) {
                //further check for query string
                if (u.hash.indexOf("?lottery=") != -1) {
                    cache.setGame(u.hash.replace(/.*lottery=/, ""));
                }
                else {
                    e.preventDefault();
                    $.mobile.changePage($("#cp"), {
                        changeHash: true
                    });
                }
            }
        }
    }
});

//page before show event
$("#orderSelect").on('pagebeforeshow', function () {
    //clear
    $("#numberList").empty();
    $("#orderCountdown").text("--:--:--");
    $('.pop-box3').hide();
    var num = cache.getBet().length;

    document.getElementById('group').innerHTML = num;
    //reset cache
    orderSelect.resetDraw();
});

//page show event
$("#orderSelect").on('pageshow', function (e, data) {
    //initialiaze
    orderSelect.init();

});

//page hide event
$("#orderSelect").on('pagehide', function (e, data) {
    //reset number
    orderSelect.resetNumber();
    orderSelect.resetCountdown();
});

//page init event
$('#orderSelect').on('pageinit', function (event) {
    $("#gameOptionList").change(function (event, ui) {
        orderSelect.renderNumber($(this).val());
    });

    /*$("#orderAuto").unbind("vclick").bind('vclick', function(e) {
     orderSelect.randomNumber();
     });*/

    /*$("#orderClear").unbind("vclick").bind('vclick', function(e) {
     orderSelect.resetNumber();
     });*/
    $("#addNumbox").unbind("vclick").bind('vclick', function (e) {
        //utils.isLegalCode(codes, orderSelect.gameSubOption.name);
        var isLegalCode = orderSelect.isLegalCode();

        if (isLegalCode) {
            //add number to bet collection
            var codes = '';
            var total = 0;
            var bet = '';
            if (orderSelect.inputType == 1) {
                total = $("#orderTotal").text();
                //bet=$("#orderBet").text();
                for (var rowno in orderSelect.number) {
                    switch (orderSelect.gameSubOption.name) {
                        case 'WXDW':
                            if (orderSelect.number[rowno] == '' && rowno != 5) {
                                codes += ',';
                            }
                            break;
                        case 'REZX':
                        case 'RSZX':
                            if (orderSelect.number[rowno] == '' && rowno != 5) {
                                codes += '-,';
                            }
                            if (orderSelect.number[rowno] == '' && rowno == 5) {
                                codes += '-';
                            }
                            break;
                        case 'SDQSDWD':
                        case 'SXDW':
                            if (orderSelect.number[rowno] == '' && rowno != 3) {
                                codes += ',';
                            }
                            break;
                        default:
                            if (codes != '') {
                                codes += ',';
                            }
                            break;
                    }
                    //if (codes != '') {
                    //    codes += ',';
                    //}
                    var tmp2 = orderSelect.gameSubOption.field_def[rowno].nums.split(" ");
                    if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10 || tmp2[tmp2.length - 1].length > 1) {
                        codes += (orderSelect.number[rowno]).join('_');
                    }
                    else {
                        codes += (orderSelect.number[rowno]).join('');
                    }
                    switch (orderSelect.gameSubOption.name) {
                        case 'WXDW':
                        case 'REZX':
                        case 'RSZX':
                            if (orderSelect.number[rowno] != '' && rowno != 5) {
                                codes += ',';
                            }
                            break;
                        case 'SDQSDWD':
                        case 'SXDW':
                            if (orderSelect.number[rowno] != '' && rowno != 3) {
                                codes += ',';
                            }
                            break;
                    }
                }
            }
            else if (orderSelect.inputType == 2) {
                var numbers = orderSelect.getNumber(0);
                total = numbers.length;
                for (var rowno in numbers) {
                    if (codes != '') {
                        codes += '|';
                    }
                    if ($.isArray(numbers[rowno])) {
                        codes += (numbers[rowno]).join(',');
                    }
                    else {
                        codes += numbers[rowno];
                    }

                }
                //bet=codes;

            }
            switch (orderSelect.gameSubOption.name) {
                case 'JSSTTX':
                    codes = '111_222_333_444_555_666';
                    break;
                case 'JSSLTX':
                    codes = '123_234_345_456';
                    break;
                case 'JSETDX':
                    var part0 = orderSelect.number['1'];
                    var part1 = orderSelect.number['2'];
                    for (var i = 0; i < part0.length; i++) {
                        var codesword0 = part0.join(''), codesword1 = part1.join('');
                        if (codesword1.indexOf(codesword0.charAt(2 * i)) != -1) {
                            total = 0;
                            orderSelect.renderNumber($("#gameOptionList").val());
                        }
                    }
                    break;
            }
            if (total == 0) {
                utils.alert("您输入的号码有误，请重新检查输入", $("#orderSelect"));
                return false;
            }
            //if (orderSelect.gameSubOption.name == 'JSSTTX') {
            //    codes = '111_222_333_444_555_666';
            //}
            //else if (orderSelect.gameSubOption.name == 'JSSLTX') {//如果是三连号通选(nyjah)
            //    codes = '123_234_345_456';
            //}
            var orderDetail = {
                subOption: orderSelect.gameSubOption.method_id,
                type: orderSelect.gameSubOption.cname,
                name: orderSelect.gameSubOption.name,
                number: orderSelect.number,
                codes: codes,
                //  bet: bet,
                total: total,
                unit: cache.getUnit(),
            };
            //alert(orderDetail.subOption);
            //alert(orderDetail.type);
            //alert(orderDetail.name);
            //alert(orderDetail.number);
            //alert(orderDetail.codes);
            //alert(orderDetail.total);
            //alert(orderDetail.unit);
            //var description = "";
            //for(var i in orderSelect.number){
            //    var property=orderSelect.number[i];
            //    description+=i+" = "+property+"\n";
            //}
            //alert(description);
            cache.addBet(orderDetail);
            orderSelect.resetNumber();
        }
        else {
            setTimeout(function () {
                utils.alert('请正确选择号码后添加到号码篮！', $("#orderSelect"));
            }, 100);
        }
        var num = cache.getBet().length;
        document.getElementById('group').innerHTML = num;
    });

    $("#orderCheck").unbind("click").bind('click', function (e) {
        var checkTextinput = function () {
            var allCodes = [];
            var str = $.trim($("#textHandInput").val());
            if (str.length == 0) {
                return false;
            }
            if (orderSelect.lotteryType == 1 || orderSelect.lotteryType == 4) {
                var arr = str.split(/\s+/);
                //because HHZX have no field_def
                if (orderSelect.gameSubOption.name == "SXHHZX" || orderSelect.gameSubOption.name == "ZSHHZX" || orderSelect.gameSubOption.name == "QSHHZX") {
                    var re = eval("/^\\d{3}$/")
                } else {
                    var re = eval("/^\\d{" + propLen(orderSelect.gameSubOption.field_def) + "}$/")
                }
                for (var i in arr) {
                    if (!re.test(arr[i])) {
                        utils.alert("您输入的号码有误，请重新检查输入", $("#orderSelect"));
                        return false
                    }
                    allCodes.push(arr[i].split(""))
                }
            } else {
                if (orderSelect.lotteryType == 2 || orderSelect.lotteryType == 8) {
                    var arr = str.split(/\n/);
                    var re = /^[01]\d$/;
                    var ischeck = 0;
                    for (var i in arr) {
                        arr[i] = $.trim(rtrim($.trim(arr[i]), ","));
                        var tmp = arr[i].split(" ");
                        if (orderSelect.lotteryType == 8 && tmp.length != propLen(orderSelect.gameSubOption.field_def)) {
                            return false;
                        }
                        for (var i2 in tmp) {
                            if (!re.test(tmp[i2])) {
                                utils.alert("您输入的号码有误，请重新检查输入", $("#orderSelect"));
                                return false
                            }
                        }
                        if (orderSelect.lotteryType == 8) {
                            $.each(tmp, function (k) {
                                if (tmp[k] > 10 || tmp[k] < 1) {
                                    utils.alert("您输入的号码有误，请重新检查输入", $("#orderSelect"));
                                    ischeck = 1;
                                    return false;
                                }
                            });
                        }
                        if (ischeck == 1) {
                            return false;
                        }
                        if (tmp.length != array_unique(tmp).length) {
                            utils.alert("您输入的号码有重复，请重新检查输入", $("#orderSelect"));
                            return false
                        }
                        if (orderSelect.gameSubOption.name == 'SDQSZUX' || orderSelect.gameSubOption.name == 'SDQEZUX' || /SDRX(\d+)/.test(orderSelect.gameSubOption.name)) {
                            allCodes.push([arr[i].split(" ").join("_")]);
                        } else {
                            allCodes.push(arr[i].split(" "));
                        }
                    }
                }
            }
            orderSelect.number[0] = allCodes;

            return true;


        };
        if (orderSelect.inputType == 2) {
            var isInputOk = checkTextinput();
            if (!isInputOk) {
                utils.alert("请输入正确的号码", $("#orderSelect"));
                return;
            }
        }
        if ($("#orderTotal").text() == 0 && isEmptyObject(orderSelect.number) == 0 && orderSelect.inputType == 1) {
            utils.alert("您输入的号码有误，请重新检查输入", $("#orderSelect"));
            return false;
        }
        function isEmptyObject(obj) {
            var iscorrect = 1;
            $.each(obj, function (k, v) {
                if (v.length != 0) {
                    iscorrect = 0;
                    return false;
                }
            });
            return iscorrect;
        }

        orderSelect.confirmOrder();
    });
});
var orderSelect = {
    gameSubOption: null,
    number: {},
    gameType: null,
    runtime: 0,
    newopen: 0,
    //init
    init: function () {
        clearInterval(dsq);
        //$.mobile.loading('hide');
        //$.mobile.loading('show');
        //$(".scrollWrapper").css('display','none');
        orderSelect.newopen = 0;
        orderSelect.render();
        //start countdown
        orderConfirm.resetCountdown();
        orderSelect.setCountdown();
        clearInterval(orderSelect.runtime);
        orderSelect.runtime = setInterval(orderSelect.setCountdown, 10000);
        orderSelect.getAccount();
        //$(function() {
        //   $("#chartlist").attr("src","?c=game&a=chart&lottery_id=" + orderSelect.gameType);
        //});
        //setTimeout(function(){$.mobile.loading('hide');},500);
        search.readyus = 1;
        search.pageNumber = 1;
        search.selectday = 1;
        search.cqd = 0;
    },
    //render
    render: function () {
        var gameId = cache.getGame();
        if (gameId) {
            //header
            $("#orderTitle").text(utils.getGameLabel(gameId));
            //options
            var o = [], game = utils.getGameConfigsById(gameId);
            if (!isEmpty(game.gc)) {
                var gameConfig = game.gc,
                    configIndex = 0,
                    method_order = 0,
                    count = 0,
                    id = "",
                    optionLabel = "",
                    subOptionLabel = "";
                //set game type
                orderSelect.gameType = game.lottery_id;
                orderSelect.lotteryType = game.gc.lotteryType;
                $.each(gameConfig.methods, function () {
                    optionLabel = this.mg_name;
                    //main options
                    o.push('<optgroup label="');
                    o.push(optionLabel);
                    o.push('">');
                    //sub options
                    $.each(this.childs, function () {
//                        //不能输入的 不支持～～
//                        if (!this.field_def || this.field_def.length == 0) {
//                            return;
//                        }
                        subOptionLabel = this.cname;
                        o.push('<option value="');
                        o.push(this.method_id);
                        o.push('">');
                        o.push(subOptionLabel);
                        o.push('</option>');
                        // 默认方法
                        if (orderSelect.gameSubOption) {
                            if (this.method_id == orderSelect.gameSubOption.method_id) {
                                method_order = count;
                            }
                        }
                        /*if (gameConfig.lotteryType == 1) {
                         if (subOptionLabel == '后三直选' || subOptionLabel == 'P3直选')
                         configIndex = count;
                         } else if (gameConfig.lotteryType == 2) {
                         if (subOptionLabel == '任选' || subOptionLabel == '任选五中五')
                         configIndex = count;
                         } else if (gameConfig.lotteryType == 4) {
                         if (subOptionLabel == '直选')
                         configIndex = count;
                         }*/
                        count++;
                    });
                    o.push('</optgroup>');
                });
                $("#gameOptionList").empty().html(o.join(""));
                $("#gameOptionList")[0].selectedIndex = method_order;
                $("#gameOptionList").selectmenu("refresh", true);
                //render default numbers
                orderSelect.renderNumber($("#gameOptionList").val());
            }

            //render history
            //$('#orderHistory').attr('href', '/?c=game&a=chart&lottery_id=' + orderSelect.gameType);
        }
    },
    //render numbers
    renderNumber: function (code) {
        var gameId = cache.getGame();
        var game = utils.getGameConfigsById(gameId);
        var gameConfig = game.gc;
        var subOption = {};
        $.each(gameConfig.methods, function () {
            $.each(this.childs, function () {
                if (this.method_id == code) {
                    subOption = this;
                }
            });
        });
        var showBall = function () {
            var className = 'hl-order-tab';
            // 特殊彩种
            //var  className = "hl-order-tab-hel";
            var n = [];
            for (var rowno in subOption.field_def) {
                n.push('<li data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal"><legend class="hl-order-game-legend">');
                if (subOption.field_def[rowno].prompt) {
                    n.push(subOption.field_def[rowno].prompt);
                } else {
                    n.push('选择');
                }
                //else {
                //    n.push("");
                //}
                n.push('</legend><div class="hl-order-game-buttons" >');
                var nums = subOption.field_def[rowno].nums.split(" ");
                for (var i = 0; i < nums.length; i++) {
                    n.push('<div id="gameButton');
                    n.push(i);
                    n.push('" row="' + rowno);
                    n.push('" class="' + className + ' hl-order-game-tab');
                    n.push('"><span class="hl-order-game-tab-button');
                    n.push('">');
                    n.push(nums[i]);
                    n.push('</span></div>');
                }
                n.push('</div></fieldset></li>');
            }
            n.push('<li data-role="fieldcontain" style="border: 0;"><fieldset data-role="controlgroup" data-type="horizontal"><legend class="hl-order-game-legend" style="top:10%;">');
            n.push('玩法');
            n.push('</legend><div class="hl-order-game-buttons" style="margin-left: 16px;width: 67%;">');
            n.push(subOption.description);
            n.push('</div></fieldset></li>');
            $('#numberList').empty().html(n.join("")).listview('refresh');
            //bind events
            $('.hl-order-game-tab > span').bind('vclick', function (e) {
                e.preventDefault();
                var tab = $(this).parent();
                var id = tab.attr('row');
                if (tab.hasClass(className + "-selected")) {
                    tab.removeClass(className + "-selected");
                    //update number
                    orderSelect.updateNumber(id, $(this).text(), false);
                    orderSelect.updateOrder();
                }
                else {
                    if (tab.parent().find('.' + className + "-selected").length >= orderSelect.gameSubOption.field_def[id].max_selected) {
                        if (orderSelect.gameSubOption.field_def[id].max_selected == 1) {
                            orderSelect.updateNumber(id, tab.parent().find('.' + className + "-selected").text(), false);
                            tab.parent().find('.' + className + "-selected").removeClass(className + "-selected");
                            tab.addClass(className + "-selected");
                            orderSelect.updateNumber(id, $(this).text(), true);
                            orderSelect.updateOrder();
                        } else {
                            utils.alert("最多只能选择" + orderSelect.gameSubOption.field_def[id].max_selected + "个号码", $("#orderSelect"));
                        }
                    } else {
                        tab.addClass(className + "-selected");
                        orderSelect.updateNumber(id, $(this).text(), true);
                        orderSelect.updateOrder();
                    }

                }

            });


        }

        var showSample = function () {
            var str = '';
            if (orderSelect.lotteryType == 1) {
                var tmp = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
                if (subOption.name == "SXHHZX" || subOption.name == "ZSHHZX" || subOption.name == "QSHHZX") {
                    str += "123 112";
                } else {
                    str += tmp.slice(0, propLen(subOption.field_def)).join("") + " " + tmp.slice(propLen(subOption.field_def), propLen(subOption.field_def) + propLen(subOption.field_def)).join("");
                }
            } else if (orderSelect.lotteryType == 2) {
                var tmp = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"];
                var num;
                if (/SDRX(\d+)/.test(subOption.name)) {
                    num = parseInt(RegExp.$1);
                } else if (subOption.name == 'SDQSZUX') {
                    num = 3;
                } else if (subOption.name == 'SDQEZUX') {
                    num = 2;
                } else {
                    num = propLen(subOption.field_def);
                }
                str += tmp.slice(0, num).join(" ") + "<br/>" + tmp.slice(1, 1 + num).join(" ");
            } else if (orderSelect.lotteryType == 4) {
                var tmp = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
                if (subOption.name == "SXHHZX") {
                    str += "123 112";
                } else {
                    str += tmp.slice(0, propLen(subOption.field_def)).join("") + " " + tmp.slice(propLen(subOption.field_def), propLen(subOption.field_def) + propLen(subOption.field_def)).join("");
                }
            }

            $('#inputSample').html(str);
        }
        if (subOption) {
            //cache subOption
            orderSelect.gameSubOption = subOption;
            if (!isEmpty(subOption.field_def) && subOption.can_input != '0') {
                //需要显示输入方式选择
                $('#enterNum').show();
                $('#inputHand').unbind('click').click(function () {
                    //需要显示手工输入
                    $('#textinput').show();
                    //$('#cather').css('width','50%');
                    //$('#orderCheck').css({"width":"100%"});
                    $('.hl-order-footer-left').css('display', 'none');
                    //不显示输入球球
                    $('#numberList').hide();
                    orderSelect.inputType = 2;
                    $(this).hide();
                    //$('#orderAuto').hide();
                    $('#addNumbox').hide();
                    $('#inputBall').show();
                    showSample();
                    orderSelect.resetNumber();

                });

                $('#inputBall').unbind('click').click(function () {
                    //不显示手工输入
                    $('#textinput').hide();
                    $('#cather').css('width', '27%');
                    $('#orderCheck').css({"width": "100%", "padding": "0"});
                    $('.hl-order-footer-left').css('display', 'block');
                    //显示输入球球
                    $('#numberList').show();
                    orderSelect.inputType = 1;
                    $(this).hide();
                    $('#addNumbox').show();
                    $('#inputHand').show();
                    //$('#orderAuto').show();
                    showBall();
                    orderSelect.resetNumber();

                });


            }
            else {
                //不需要显示输入方式选择
                $('#enterNum').hide();
            }

            if (isEmpty(subOption.field_def)) {
                //不需要显示输入球球
                $('#numberList').hide();
                //显示手工输入
                $('#textinput').show();
                //$('#cather').css('width','50%');
                //$('#orderCheck').css({"width":"100%"});
                $('.hl-order-footer-left').css('display', 'none');
                orderSelect.inputType = 2;
                $('#addNumbox').hide();
                $('#inputBall').show();
                $('#inputHand').hide();
                //$('#orderAuto').hide();
                showSample();
            }
            else {
                //需要显示输入球球
                $('#numberList').show();
                //不显示手工输入
                $('#textinput').hide();
                $('#cather').css('width', '27%');
                $('#orderCheck').css({"width": "100%", "padding": "0"});
                $('.hl-order-footer-left').css('display', 'block');
                orderSelect.inputType = 1;
                $('#addNumbox').show();
                $('#inputBall').hide();
                $('#inputHand').show();
                showBall();
                //$('#orderAuto').show();
            }


        }
        //reset
        orderSelect.resetNumber();
    },
    //reset number
    resetNumber: function () {
        $(".hl-order-game-tab").removeClass("hl-order-tab-selected");
        $(".hl-order-game-tab").removeClass("hl-order-tab-hel-selected");
        $("#textHandInput").val('');
        $(".hl-order-footer-text").text("下注: 0 注，0 元，奖金0 元");
        orderSelect.number = {};
    },
    //get number
    getNumber: function (id) {
        return orderSelect.number[id];
    },
    //update number
    updateNumber: function (id, number, add) {
        var numbers = orderSelect.getNumber(id);
        //create new number placeholder
        if (!numbers || number == undefined) {
            orderSelect.number[id] = [];
            numbers = orderSelect.number[id];
        }
        //add or remove number
        if (add) {
            if (numbers.indexOf(number) == -1) {
                //only add when number does not exsit
                numbers.push(number);
            }
        }
        else {
            var index = -1;
            for (var i = 0; i < numbers.length; i++) {
                if (numbers[i] == number) {
                    index = i;
                    break;
                }
            }

            if (index > -1) {
                //remove
                numbers.splice(index, 1);
            }
        }
    },
    isLegalCode: function () {
        var result = true;
        if (orderSelect.inputType == 1) {
            for (var rowno in orderSelect.gameSubOption.field_def) {
                if (!orderSelect.number[rowno]) {
                    result = false;
                }
            }
        }
        return result;

    },
    //update order
    updateOrder: function () {
        switch (orderSelect.gameSubOption.name) {
            case 'WXDW':
            case 'REZX':
            case 'RSZX':
            case 'SDQSDWD':
            case 'SXDW':
                for (var i in orderSelect.gameSubOption.field_def) {
                    if (!orderSelect.number[i]) {
                        orderSelect.number[i] = [];
                    }
                }
                break;
        }
        var isLegalCode = orderSelect.isLegalCode();
        if (orderSelect.number && isLegalCode) {
            var codes = new Array();
            var bets = '';
            var arrindex = 0;
            for (var rowno in orderSelect.number) {
                if (bets != '') {
                    bets += ',';
                }
                var tmp2 = orderSelect.gameSubOption.field_def[rowno].nums.split(" ");
                if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10 || tmp2[tmp2.length - 1].length > 1) {
                    bets += (orderSelect.number[rowno]).join('_');
                    codes[arrindex] = (orderSelect.number[rowno]).join('_');
                }
                else {
                    bets += (orderSelect.number[rowno]).join('');
                    codes[arrindex] = (orderSelect.number[rowno]).join('');
                }
                arrindex++;
            }
            //只有一组的情况下格式不同
            //if (arrindex == 1) {
            //    codes[0] = codes[0].join('_');
            //}
            var game = utils.getGameConfigsById(cache.getGame()).gc;
            var betResult = utils.isLegalCode(codes, orderSelect.gameSubOption);
            var bets_total = betResult.singleNum;
            if (orderSelect.gameSubOption.name == 'JSETDX') {
                var part0 = orderSelect.number['1'];
                var part1 = orderSelect.number['2'];
                for (var i = 0; i < part0.length; i++) {
                    var codesword0 = part0.join(''), codesword1 = part1.join('');
                    if (codesword1.indexOf(codesword0.charAt(2 * i)) != -1) {
                        bets_total = 0;
                        orderSelect.renderNumber($("#gameOptionList").val());
                    }
                }
            }
            if (bets_total >= 1) {
                var bets_prize = computeFinalPrizePrize(orderSelect.gameSubOption.prize);
            } else {
                var bets_prize = 0;
                bets_total = 0;
            }
            function computeFinalPrizePrize(prize) {
                // var selectPrize = round(parseFloat(game.defaultMode) * parseFloat(prize) * (parseFloat(game.prizeRate) + parseFloat(game.rebate)) / parseFloat(game.prizeRate), 2);
                var selectPrize= round(parseFloat(game.defaultMode) * parseFloat(prize[1]),2);
                if (orderSelect.gameSubOption.name == 'YMBDW' && selectPrize > 6.61) {
                    selectPrize = 6.61;
                }
                return selectPrize;
            }

            var totalOrder = [];
            totalOrder.push('下注： ');
            //totalOrder.push('<span id="orderBet" class="hl-order-summary">');
            //totalOrder.push(bets);
            //totalOrder.push('</span>');
            //totalOrder.push("，");
            totalOrder.push('<span id="orderTotal" class="hl-order-summary">');
            totalOrder.push(bets_total);
            totalOrder.push('</span> ');
            totalOrder.push('注');
            totalOrder.push("，");
            totalOrder.push('<span id="orderCost" class="hl-order-summary">');
            totalOrder.push(bets_total * 2);
            totalOrder.push('</span> ');
            totalOrder.push('元');
            totalOrder.push("，最高奖金");
            totalOrder.push('<span id="orderPrize" class="hl-order-summary">');
            totalOrder.push(bets_prize);
            totalOrder.push('</span> ');
            totalOrder.push('元');
            $(".hl-order-footer-text").html(totalOrder.join("")).show();
        }
        else {
            $(".hl-order-footer-text").html("").show();
        }
    },
    //confirm order
    confirmOrder: function () {
        //validation
        var isLegalCode = orderSelect.isLegalCode();
        var t = 0;
        var u = 0;
        for (var rowno in orderSelect.gameSubOption.field_def) {
            if (!orderSelect.number[rowno] || orderSelect.number[rowno].length == 0) {
                t++;
            }
            u++;
        }
        if (t == u && orderSelect.inputType != 2) {
            $.mobile.changePage($("#orderConfirm"), {
                changeHash: true
            });
        } else if (isLegalCode) {
            //add number to bet collection
            var codes = '';
            var total = 0;
            var bet = '';
            if (orderSelect.inputType == 1) {
                total = $("#orderTotal").text();
                //bet=$("#orderBet").text();
                for (var rowno in orderSelect.number) {
                    switch (orderSelect.gameSubOption.name) {
                        case 'WXDW':
                            if (orderSelect.number[rowno] == '' && rowno != 5) {
                                codes += ',';
                            }
                            break;
                        case 'REZX':
                        case 'RSZX':
                            if (orderSelect.number[rowno] == '' && rowno != 5) {
                                codes += '-,';
                            }
                            if (orderSelect.number[rowno] == '' && rowno == 5) {
                                codes += '-';
                            }
                            break;
                        case 'SDQSDWD':
                        case 'SXDW':
                            if (orderSelect.number[rowno] == '' && rowno != 3) {
                                codes += ',';
                            }
                            break;
                        default:
                            if (codes != '') {
                                codes += ',';
                            }
                            break;
                    }
                    var tmp2 = orderSelect.gameSubOption.field_def[rowno].nums.split(" ");
                    if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10 || tmp2[tmp2.length - 1].length > 1) {
                        codes += (orderSelect.number[rowno]).join('_');
                    }
                    else {
                        codes += (orderSelect.number[rowno]).join('');
                    }
                    switch (orderSelect.gameSubOption.name) {
                        case 'WXDW':
                        case 'REZX':
                        case 'RSZX':
                            if (orderSelect.number[rowno] != '' && rowno != 5) {
                                codes += ',';
                            }
                            break;
                        case 'SDQSDWD':
                        case 'SXDW':
                            if (orderSelect.number[rowno] != '' && rowno != 3) {
                                codes += ',';
                            }
                            break;
                    }
                }
            }
            else if (orderSelect.inputType == 2) {
                var numbers = orderSelect.getNumber(0);
                total = numbers.length;
                if (total == 0) {
                    return false;
                }
                for (var rowno in numbers) {
                    if (codes != '') {
                        codes += '|';
                    }
                    if ($.isArray(numbers[rowno])) {
                        codes += (numbers[rowno]).join(',');
                    }
                    else {
                        codes += numbers[rowno];
                    }
                }
                //bet=codes;

            }
            switch (orderSelect.gameSubOption.name) {
                case 'JSSTTX':
                    codes = '111_222_333_444_555_666';
                    break;
                case 'JSSLTX':
                    codes = '123_234_345_456';
                    break;
            }
            //if (orderSelect.gameSubOption.name == 'JSSTTX') {
            //    codes = '111_222_333_444_555_666';
            //}
            //else if (orderSelect.gameSubOption.name == 'JSSLTX') {//如果是三连号通选(nyjah)
            //    codes = '123_234_345_456';
            //}

            var orderDetail = {
                subOption: orderSelect.gameSubOption.method_id,
                type: orderSelect.gameSubOption.cname,
                name: orderSelect.gameSubOption.name,
                number: orderSelect.number,
                codes: codes,
                //  bet: bet,
                total: total,
                unit: cache.getUnit(),
            };
            cache.addBet(orderDetail);
            //direct to order confirmation page
            $.mobile.changePage($("#orderConfirm"), {
                changeHash: true
            });
        } else {
            utils.alert(label.inCompleteGame, $("#orderSelect"));
        }
    },
    //set order number
    setOrderNumber: function (data) {

    },
    //random number
    /*randomNumber: function() {
     var numberList = $('#numberList span');
     $.each(numberList, function() {
     if (Math.random() > 0.618)
     $(this).click();
     });

     },*/
    //set countdown
    setCountdown: function () {
        var gameId = cache.getGame();
        if (gameId) {
            server.getDraw(gameId, function (data) {
                if (data != null) {
                    if (app.checkLoginOrUrl(data)) {
                        return;
                    }
                    //cache data
                    cache.setDraw(data);
                    //update title
                    $("#orderTitle").html(utils.getGameLabel(gameId));
                    orderSelect.countDownTimer($("#orderCountdown"), data.curRemainTime,data.waite_time,data.state);
                    var q = [], arrt = [], reinfo = null, perinfo = null;
                    // reinfo = data.lastIssueInfo.issue.split("-");
                    // perinfo = data.curIssueInfo.issue.split("-");
                    reinfo = data.lastIssueInfo.issue;
                    perinfo = data.curIssueInfo.issue;
                    $("#orderPeriod").html('距<span class="hl-order-period">' + perinfo + label.period + '</span>:');
                    $("#orderLastkj").html(reinfo + label.period + "开奖结果");
                    q.push('<li>');
                    if (data.lastIssueInfo.code.indexOf(" ") == -1) {
                        arrt = data.lastIssueInfo.code.split(",");
                    } else {
                        arrt = data.lastIssueInfo.code.split(" ");
                    }
                    if (data.lastIssueInfo.code == '') {
                        q.push('正在开奖中...');
                    } else {
                        $.each(arrt, function (k, v) {
                            q.push('<span class="hl-draw">');
                            if (v.length == 1) {
                                q.push('&nbsp;' + v);
                            } else {
                                q.push(v);
                            }
                            q.push('</span>');
                        });
                    }
                    q.push('</li>');
                    $("#historyNum").html(q.join(""));
                }
            });
        }
    },
    //reset countdown
    resetCountdown: function () {
        $("#orderCountdown").countdown('destroy');
    },
    //count down timer
    countDownTimer: function (gameTime, timestamp,waite_time,state) {
        //timestamp = 999999;
        gameTime.countdown('destroy');
        gameTime.countdown({
            until: timestamp,
            format: "dHMS",
            compact: true,
            onExpiry: function () {
                utils.alert(label.drawDisable, $("#orderSelect"), orderSelect.setCountdown);
                //refresh countdown
            }
        });

        if (timestamp < 1 ) {
            gameTime.countdown('destroy');
            if($("#orderCountdown").html() == '00:00:00'){
                // utils.alert(label.drawDisable1, $("#orderSelect"), orderSelect.setCountdown);
                alert(label.drawDisable1);
            }
            orderConfirm.countDownTimer($("#orderConfirmCountdown"),timestamp,waite_time,state);
            $("#orderCountdown").hide();
            $("#orderPeriod").hide();
            $("#orderCountdown1").show();
            $("#orderPeriod1").show();
            $("#orderCountdown1").countdown({
                until: waite_time,
                format: "dHMS",
                compact: true,
                onExpiry: function () {
                    // utils.alert('封盘结束！', $("#orderSelect"), orderSelect.setCountdown);
                    alert('该期截止！');
                    //refresh countdown
                    $("#orderCountdown1").hide();
                    $("#orderPeriod1").hide();
                    $("#orderCountdown").show();
                    $("#orderPeriod").show();
                }
            });
        }else{
            $("#orderCountdown1").hide();
            $("#orderPeriod1").hide();
            $("#orderCountdown").show();
            $("#orderPeriod").show();
        }
        if(isNaN(timestamp)){
            $("#orderCountdown").hide();
            $("#orderPeriod").hide();
            $("#orderPeriod1").text('等待开奖');
            $("#orderCountdown1").show();
            $("#orderPeriod1").show();
        }
    },
    //reset draw
    resetDraw: function () {
        cache.resetDraw();
    },
    getAccount: function () {
        var profile = cache.getProfile();
        server.getAccount(profile, function (data) {
            if (data != null) {
                if (data.length > 0) {
                    $.each(data, function (index) {
                        if (this.val == '--') {
                            $('#memberAccountfact').html('--');
                        } else {
                            $('#memberAccountfact').html(utils.cny(this.val, 2));
                        }
                    });
                }
            }

        });
    }
}

﻿/*---------------------------------------------------------------------------orderConfirm--------------------------------------------------------------------------------------------------------*/

//page before show event
$("#orderConfirm").on('pagebeforeshow', function () {
    //clear
    $("#orderList").empty();

    //reset draw
    $(".hl-order-confirm-bet-no").text("-");
});
$("#orderClear").unbind("vclick").bind('vclick', function () {
    var data = cache.getBet(), s = data.length;
    for (var j = 0; j < s; j++) {
        var index = $("#orderList").attr("i");
        //remove from cache
        cache.removeBet(index);
    }
    //refresh
    orderConfirm.render();
});
$("#orderRnd1").unbind("vclick").bind('vclick', function () {
    orderConfirm.machineRun(1);
});
$("#orderRnd5").unbind("vclick").bind('vclick', function () {
    orderConfirm.machineRun(5);
});

//page show event
$("#orderConfirm").on('pageshow', function (e, data) {
    //initialiaze
    orderConfirm.init();
});

//page hide event
$("#orderConfirm").on('pagehide', function (e, data) {
    orderConfirm.resetCountdown();
});
//page init event
$('#orderConfirm').on('pageinit', function (event) {
    $("input[name=unit]:radio").unbind("change").change(function () {
        //update summary
        orderConfirm.updateSummary();
    });

    $("#txtCno").unbind("keydown").keydown(function (event) {
        // prevent shift key since its not needed
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ($(this).val().length >= 2 && !utils.isNavigationKey(event.keyCode)) {
            //$(this).val($(this).val().substr(0, 2));
            event.preventDefault();
        }
        else if (!utils.isValidBetNumber(event.keyCode)) {
            // prevent the rest
            event.preventDefault();
        }
    }).unbind("change").change(function () {
        try {
            var m = parseInt($("#txtCno").val());

            if (m <= 0) {
                $("#txtCno").val("1");
            }
        } catch (E) {
            $("#txtCno").val("1");
        }
//        cache.setBetSettingsCno(this.value);
        //update summary
        orderConfirm.displayTraceData();
        orderConfirm.updateSummary();
    });

    $("#txtMultiplier").unbind("keydown").keydown(function (event) {
        // prevent shift key since its not needed
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ($(this).val().length >= 4 && !utils.isNavigationKey(event.keyCode)) {
            //$(this).val($(this).val().substr(0, 4));
            event.preventDefault();
        }
        else if (!utils.isValidBetNumber(event.keyCode)) {
            // prevent the rest
            event.preventDefault();
        }
    }).unbind("change").change(function () {
        try {
            var m = parseInt($("#txtMultiplier").val());
            if (m > 5000) {
                m = 500;
                $("#txtMultiplier").val('5000');
            }
            if (m <= 0) {
                $("#txtMultiplier").val("1");
            }
        } catch (E) {
            $("#txtMultiplier").val("1");
        }
        orderConfirm.displayTraceData();
        orderConfirm.updateSummary();
    });
    $("#txtMultiplierPlus").unbind("click").click(function (event) {
        try {
            var m = parseInt($("#txtMultiplier").val());
            $("#txtMultiplier").val((m + 1));
        } catch (E) {

        }
        $("#txtMultiplier").change();

    });

    $("#txtMultiplierMinus").unbind("click").click(function (event) {
        try {
            var m = parseInt($("#txtMultiplier").val());
            $("#txtMultiplier").val((m - 1));
        } catch (E) {

        }
        $("#txtMultiplier").change();
    });

    $("#orderConfirmOrder").unbind("click").click(function () {
        orderConfirm.placeOrder();
    });
});

var orderConfirm = {
    payoutStack: [],
    //init
    init: function () {
        clearInterval(dsq);
        var data = cache.getData();
        $('.hl-order-footer-left').css('display', 'block');
        var game = utils.getGameConfigsById(cache.getGame()).gc;
        switch (game.lotteryName) {
            case '福彩3D':  //福彩3D
            case '排列三/五':  //排列三/五
                $('.multipleDiv').css('display', 'none');
                break;
            default:
                $('.multipleDiv').css('display', 'inline-block');
                break;
        }
        if (data == null) {
            server.getConfig(function (data) {
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    orderConfirm.render();
                    //start countdown
                    orderConfirm.resetCountdown();
                    orderConfirm.setCountdown();
                }
            });
        }
        else {
            orderConfirm.render();
            //start countdown
            orderConfirm.resetCountdown();
            orderConfirm.setCountdown();
        }
    },
    //machineRun
    machineRun: function (maxNum) {
        switch (orderSelect.gameSubOption.name) {
            //pk10玩法
            case 'PKQYZX':  //猜冠军
            case 'PKQELX':  //猜冠亚
            case 'PKQSLX':  //猜前三
            case 'PKQ4LX':  //猜前四
            case 'PKQ5LX':  //猜前五
            case 'PKQ6LX':  //猜前六
            case 'PKQ7LX':  //猜前七
            case 'PKQ8LX':  //猜前八
            case 'PKQ9LX':  //猜前九
            case 'PKQ10LX':  //猜前十
                var totalNum = 0;
                for (var i in orderSelect.gameSubOption.field_def) {
                    totalNum++;
                }
                var codes = [];
                var count = totalNum;
                var original = new Array();//原始数组
//给原始数组original赋值
                for (var i = 0; i < 10; i++) {
                    original[i] = i + 1;
                }
                original.sort(function () {
                    return Math.random() > 0.5 ? -1 : 1;
                });
                if (Math.random() > 0.5) {
                    original.reverse();
                }
                for (var i = 0; i < count; i++) {
                    codes[i] = "0" + original[i];
                    if (original[i] == 10) {
                        codes[i] = 10;
                    }
                }
                var obnum = 1;
                break;
            case 'SDQSZX':  //前三直选 01_02_03_04,02_03,01_05
            case 'SDQEZX'://前二直选 二段 01_02_03_04,02_03
                var totalNum = 0;
                for (var i in orderSelect.gameSubOption.field_def) {
                    totalNum++;
                }
                var codes = [];
                var count = totalNum;
                var original = new Array();//原始数组
//给原始数组original赋值
                for (var i = 0; i < 11; i++) {
                    original[i] = i + 1;
                }
                original.sort(function () {
                    return Math.random() > 0.5 ? -1 : 1;
                });
                if (Math.random() > 0.5) {
                    original.reverse();
                }
                for (var i = 0; i < count; i++) {
                    codes[i] = "0" + original[i];
                    if (original[i] == 10 || original[i] == 11) {
                        codes[i] = original[i];
                    }
                }
                var obnum = 1;
                break;
            case 'JSETDX'://前二直选 二段 01_02_03_04,02_03
                var codes = [], temp1 = ['11', '22', '33', '44', '55', '66'], temp2 = ['1', '2', '3', '4', '5', '6', '1', '2', '3', '4', '5'];
                var kii = parseInt(Math.random() * 6, 10);
                var kjj = parseInt(Math.random() * 4 + 1, 10);
                codes[0] = temp1[kii];
                codes[1] = temp2[kii + kjj];
                var obnum = 1;
                break;
            case 'SXHHZX'://混合组选
            case 'ZSHHZX':
            case 'QSHHZX':
                var totalNum = 3;
                var codes = [];
                var count = totalNum;
                var original = new Array();//原始数组
//给原始数组original赋值
                for (var i = 0; i < 10; i++) {
                    original[i] = i;
                }
                original.sort(function () {
                    return Math.random() > 0.5 ? -1 : 1;
                });
                if (Math.random() > 0.5) {
                    original.reverse();
                }
                for (var i = 0; i < count; i++) {
                    codes[i] = original[i];
                }
                var obnum = 1;
                break;
            //default
            default:
                if (orderSelect.gameSubOption.field_def) {
                    var max_selecteds = [];
                    var max_selected_all = 1;
                    var isMutilCode = false;
                    var fieldNum = 0;

                    for (var i in orderSelect.gameSubOption.field_def) {
                        fieldNum++;
                        var tmp2 = orderSelect.gameSubOption.field_def[i].nums.split(" ");
                        for (var j in tmp2) {
                            if (tmp2[j].length > 1) {
                                isMutilCode = true;
                            }
                        }
                        if (orderSelect.gameSubOption.field_def[i].max_selected) {
                            max_selecteds.push(parseInt(orderSelect.gameSubOption.field_def[i].max_selected));
                            if (parseInt(orderSelect.gameSubOption.field_def[i].max_selected) > max_selected_all) {
                                max_selected_all = parseInt(orderSelect.gameSubOption.field_def[i].max_selected);
                            }
                        }
                        else {
                            max_selecteds.push(1);
                        }
                    }
                    var trytimes = 0;

                    while (trytimes <= 5) {
                        var codes = [];                                                //插入空值
                        while (codes.length < fieldNum) {
                            codes.push('');
                        }
                        for (var j = 0; j < max_selected_all; j++) {
                            var isBreak = false;
                            for (var i in orderSelect.gameSubOption.field_def) {
                                var lenNow = 0;
                                if (codes[parseInt(i) - 1] != '') {
                                    if (isMutilCode) {
                                        var codesNow = codes[parseInt(i) - 1].split('_');
                                        lenNow = codesNow.length;
                                    }
                                    else {
                                        lenNow = codes[parseInt(i) - 1].length;
                                    }
                                }
                                if (max_selecteds[parseInt(i) - 1] <= lenNow) {
                                    continue;
                                }
                                var tmp2 = orderSelect.gameSubOption.field_def[i].nums.split(" ");
                                var arrIndex = Math.floor(Math.random() * tmp2.length);
                                var _maxTryRandom = 20;
                                //var tmp2str=tmp2[arrIndex].toString();
                                //alert(tmp2[arrIndex]);
                                while (_maxTryRandom > 0 && (codes[parseInt(i) - 1].toString().indexOf(tmp2[arrIndex]) != -1)) {
                                    arrIndex = Math.floor(Math.random() * tmp2.length);
                                    _maxTryRandom--;
                                }

                                if (codes[parseInt(i) - 1].toString().indexOf(tmp2[arrIndex]) != -1) {

                                    isBreak = true;
                                    break;
                                }

                                if (isMutilCode) {
                                    if (codes[parseInt(i) - 1]) {
                                        codes[parseInt(i) - 1] += '_';
                                    }
                                    codes[parseInt(i) - 1] += tmp2[arrIndex];
                                }
                                else {
                                    codes[parseInt(i) - 1] += tmp2[arrIndex];
                                }
                                var obcode = utils.isLegalCode(codes, orderSelect.gameSubOption);
                                //var acodes=[];
                                //acodes[0]=codes[0].split('_');
                                //switch (orderSelect.gameSubOption.name){
                                //    case 'SDQSZUX':
                                //    case 'SDQEZUX':
                                //    case 'SDRX1':
                                //    case 'SDRX2':
                                //    case 'SDRX3':
                                //    case 'SDRX4':
                                //    case 'SDRX5':
                                //    case 'SDRX6':
                                //    case 'SDRX7':
                                //    case 'SDRX8':
                                //    case 'SDQSBDW':
                                //    case 'SDQSDWD':
                                //        var obcode = utils.isLegalCode(codes, orderSelect.gameSubOption.name);
                                //        break;
                                //    default:
                                //        var obcode = utils.isLegalCode(codes, orderSelect.gameSubOption.name);
                                //        break;
                                //
                                //}
                                var obnum = obcode.singleNum;

                                if (obnum >= 1) {
                                    isBreak = true;
                                    break;
                                }
                            }
                            if (isBreak) {
                                break;
                            }
                        }
                        trytimes++;
                    }
                }
                break;
        }
        if (orderSelect.gameSubOption.name == 'JSSTTX') {
            codes = '111_222_333_444_555_666';
        }
        else if (orderSelect.gameSubOption.name == 'JSSLTX') {//如果是三连号通选(nyjah)
            codes = '123_234_345_456';
        }
        switch (orderSelect.gameSubOption.name) {
            case 'SDQSZX':
            case 'SDQSZX':
                obnum = 1;
                break;
        }
        //混合组选机选判断
        if (!obnum) {
            return false;
        }
        //任选二
        switch (orderSelect.gameSubOption.name) {
            case 'REZX':
                codes[2] = '-';
                codes[3] = '-';
                codes[4] = '-';
                break;
            case 'RSZX':
                codes[3] = '-';
                codes[4] = '-';
                break;
        }
        //任选三
        //if(orderSelect.gameSubOption.method_id==432){
        //    codes[3]='-';
        //    codes[4]='-';
        //}
        var total = $("#orderTotal").text() + obnum;
        //alert(das);
        var orderDetail = {
            subOption: orderSelect.gameSubOption.method_id,
            type: orderSelect.gameSubOption.cname,
            name: orderSelect.gameSubOption.name,
            number: orderSelect.number,
            codes: codes,
            //  bet: bet,
            total: total,
            unit: cache.getUnit(),
        };
        //var description = "";
        //var arr=cache.getBet().bet;
        //for(var i in arr){
        //    var property=arr[i];
        //    description+=i+" = "+property+"\n";
        //}
        //alert(description);
        cache.addBet(orderDetail);
        //refresh
        orderConfirm.render();
        maxNum--;
        if (maxNum > 0) {
            orderConfirm.machineRun(maxNum);
        }
    },
    //render
    render: function () {
        var data = cache.getBet(),
            multiplier = 0,
            total = 0,
            o = [],
            amount = 0;
        if (data.length > 0) {
            $.each(data, function (i) {
                o.push('<li><div class="hl-order-confirm-label">');
                o.push(this.type);
                o.push('</div><div class="hl-order-confirm-number">');
                o.push(this.codes);
                o.push('  (共' + this.total + '注)');
                o.push('</div><div class="hl-order-confirm-data" number="');
                o.push(this.codes);
                o.push('" code="');
                o.push(this.subOption);
                o.push('" style="display:none"></div><div class="hl-order-confirm-delete">');
                o.push('<a href="#" data-role="button" data-mini="true" data-theme="d" i="');
                o.push(i.toString());
                o.push('"><b style="font-size: 15px;">X</b></a></div></li>');
                multiplier = multiplier + parseInt(this.total);
                //convert to 元
                amount = this.total * 2;
                total = total + amount;

            });
        }
        else {
            o.push('<li><span class="hl-order-confirm-no-record">');
            o.push(label.noRecord);
            o.push('<span></li>');
        }
        $('#orderList').empty().html(o.join("")).listview('refresh');
        $('.hl-order-confirm-delete > a').button().click(function () {
            var index = $(this).attr("i");
            //remove from cache
            cache.removeBet(index);
            //refresh
            orderConfirm.render();
        });
        //settings
        var betSettings = cache.getBetSettings();
        //彩种
        $(".hl-order-confirm-game").text(utils.getGameLabel(cache.getGame()));
        //倍数
        $("#txtMultiplier").val(betSettings.multiplier);
        //追号
        $("#txtCno").val(betSettings.cno);
        var gapList = orderConfirm.generateGapList();
        var defaultGapPos = 50;
        var defaultGap = orderConfirm.getMode(defaultGapPos);
        var sliderHtml = '';
        var tmpSelectThis = 0;
        $.each(gapList, function (i) {

            if (defaultGap.rebate == this.rebate) {
                tmpSelectThis = i;
            }
            sliderHtml += '<option value="' + this.rebate + '" ' + tmpSelectThis + '>' + this.prize + '/' + number_format(this.rebate * 100, 2) + '</option>';
        })
        $("#slider").empty().html(sliderHtml);
        $("#slider")[0].selectedIndex = tmpSelectThis;
        $("#slider").selectmenu("refresh", true);


        //当前模式
        //   $(".hl-order-mode").text(defaultGap.prize + '/' + number_format(defaultGap.rebate * 100, 2));
//        $("#slider").off("slidestop").off("change").attr("min", 1).attr("max", 100).val(defaultGapPos).slider('refresh');
//        //slider event
//        $("#slider").change(function() {
//            var gap = orderConfirm.getMode(this.value);
//            $(".hl-order-mode").text(gap.prize + '/' + number_format(gap.rebate * 100, 2));
//        }).on("slidestop", function() {
//            var gap = orderConfirm.getMode(this.value);
//            $(".hl-order-mode").text(gap.prize + '/' + number_format(gap.rebate * 100, 2));
//        });
        //元角分模式
        //$(".hl-order-confirm-unit").attr("checked", false).checkboxradio("refresh");
        //$("#unit" + memberSettings.u).attr("checked", true).checkboxradio("refresh");

        //单倍注数
        $("#lblMultiplier").text(multiplier);
        //合计
        $("#lblTotal").attr("val", total);
        orderConfirm.updateSummary();
        $("#txtMultiplier").blur();


        //高级追号
        $('#advCnoList').hide();
        $("#advCno").unbind("click").click(function () {

            var advCnoEnable = $("#advCno").attr('enable');
            if (advCnoEnable == '1') {
                $('#advCnoList').hide();
                $("#advCno").attr('enable', '0');
                orderConfirm.updateSummary();
            }
            else {
                orderConfirm.refreshTraceData();
            }


        });
        var m = [];
        m.push('账户：<label id="confirmmemberAccountId">&nbsp;  </label>');
        m.push('<div>余额：<label id="confirmmemberAccountSummaryDesc" style="color: #ba2020;">&nbsp;  </label>&nbsp;  <a href="javascript:void(0);"><img id="confirmrefreshMemberAccountSummaryDesc" height="10px" src="' + RP_STATIC + 'images/ico-refresh10.png" /></a></div>');
        $("#confirmmemberAccount").html(m.join(""));
        //$('#refreshMemberAccountSummaryDesc').button();
        $('#confirmmemberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;...');
        var profile = cache.getProfile();
        var accountId = 0;
        server.getAccount(profile, function (data) {
            if (data != null) {
                if (data.length > 0) {
                    $.each(data, function (index) {
                        $('#confirmmemberAccountId').html(cache.profile.id);
                        accountId = this.id;
                        if (this.val == '--') {
                            $('#confirmmemberAccountSummaryDesc').html('--');
                        } else {
                            $('#confirmmemberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;' + utils.cny(this.val, 2));
                        }
                    });
                }
            }

        });
        //server.getDetail({'id': accountId, 'trace_id': 1}, function(data) {
        //    console.log(data);
        //});
        //console.log(cache);
        $('#confirmrefreshMemberAccountSummaryDesc').off('click').click(function () {
            $('#confirmmemberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;...');
            var profile = cache.getProfile();
            server.getAccount(profile, function (data) {
                if (data != null) {
                    if (data.length > 0) {
                        $.each(data, function (index) {
                            if (this.val == '--') {
                                $('#confirmmemberAccountSummaryDesc').html('--');
                            } else {
                                $('#confirmmemberAccountSummaryDesc').html('&nbsp;&nbsp;&nbsp;' + utils.cny(this.val, 2));
                            }

                        });
                    }
                }

            });
        });
    },
    //get number display
    getNumberDisplay: function (type, number) {
        var bets = '';
        for (var rowno in number) {
            if (bets != '') {
                bets += ',';
            }
            bets += (number[rowno]).join('_');
        }
        return bets;
    },
    refreshTraceData: function () {
        var traceData = {};
        traceData.lotteryId = orderSelect.gameType;
        traceData.mids = '';
        var data = cache.getBet();
        if (data.length > 0) {
            $.each(data, function (i) {
                if (traceData.mids == '') {
                    traceData.mids += ',';
                }
                traceData.mids += this.subOption;
            });
            //$.mobile.loading('hide');
            //$.mobile.loading('show');
            //console.log('111sdddd');
            server.getTracePage(traceData, function (data) {
                //$.mobile.loading('hide');
                if (data) {
                    if (data.errno == 0) {
                        $('#advCnoList').show();
                        $("#advCno").attr('enable', '1');
                        orderConfirm.traceData = data;
                        orderConfirm.displayTraceData();
                    }
                    else {
                        alert(data.errstr);
                    }
                }
            });
        }
    }
    ,
    //get number display
    displayTraceData: function () {
        if (orderConfirm.traceData && $("#advCno").attr('enable') == '1') {
            var data = orderConfirm.traceData;
            $("#advCno").attr('max', data.issues.length);
            $("#txtCno").attr('max', data.issues.length);
            $("#maxIssueCount").html(data.issues.length);
            var tables = '<table width="95%">';
            var cno = parseInt($('#txtCno').val());
            if (cno > data.issues.length) {
                $('#txtCno').val(data.issues.length);
                cno = data.issues.length;

            }
            var multiplierDefault = $("#txtMultiplier").val();
            $.each(data.issues, function (i) {
                if (i < cno) {
                    tables += '<tr ><td>' + this + '</td>';
                    tables += '<td style="text-align: right;">' + '<input type="number" issue="' + this + '" name="multiplier' + i + '" id="multiplier' + i + '" value="' + multiplierDefault + '" class="hl-order-confirm-input" maxlength="3" min="1" max="5000" data-mini="true" data-inline="true">' + '</td></tr>';
                }
            });
            tables += '</table>';
            $('#advCnoListTable').html(tables);
            for (var i = 0; i < data.issues.length; i++) {
                $('#multiplier' + i).textinput();
                $('#multiplier' + i).unbind("change").change(function () {
                    try {
                        var m = parseInt($(this).val());
                        if (m > 5000) {
                            m = 5000;
                            $(this).val('5000');
                        }
                        if (m <= 0) {
                            $(this).val('1');
                        }
                    } catch (E) {
                        $(this).val('1');
                    }

                    var next = $(this).parent().parent().next();
                    if (next && next.length > 0) {
                        var nextinput = $('input', next);
                        if (nextinput && nextinput.length > 0) {
                            nextinput.val($(this).val());
                            nextinput.change();
                        }
                    }
                    else {
                        orderConfirm.updateSummary();
                    }

                });
            }
        }

    },
    //update summary
    updateSummary: function () {
        //有高级追号的情况
        if ($("#advCno").attr('enable') == '1') {
            var issues = $('#advCnoListTable input');
            var total = $("#lblTotal").attr("val");
            var unit = $("input[name=unit]:checked").val();
            var totalIssue = 0;
            $.each(issues, function () {
                totalIssue += total * unit * $(this).val();
            });
            totalIssue += 0.00001;
            $("#lblTotal").text(label.symbol + totalIssue.toFixed(2));

        }
        else {
            var total = $("#lblTotal").attr("val"), multiplier = utils.parseFloat($("#txtMultiplier").val()), cno = utils.parseFloat($("#txtCno").val());
            total = $("input[name=unit]:checked").val() * total * (multiplier * cno);
            total += 0.00001;
            $("#lblTotal").text(label.symbol + total.toFixed(2));
        }

    },
    //place order
    placeOrder: function () {
        var data = cache.getBet();
        //make sure there are order
        if (data.length > 0) {
            //verify cno and multiplier
            if ($("#txtCno").val().length > 0) {
                if ($("#txtMultiplier").val().length > 0) {

                    $("#orderConfirmSummary").text(label.confirmOrders);
                    var message = label.confirmOrders.replace("{0}", $("#lblTotal").text().replace("￥", ""));
                    utils.confirm(message, $("#orderConfirm"),
                        function () {
                            var profile = cache.getProfile();
                            if (profile == null || profile.id.length == 0) {
                                //store next page url
                                login.nextPage = "#orderConfirm";

                                $.mobile.changePage($("#login"), {
                                    changeHash: false
                                });
                            }
                            else {
                                //show load
                                $.mobile.loading('hide');
                                $.mobile.loading('show');
                                orderDetail = {};
                                orderDetail.data = data;
                                orderDetail.cno = $("#txtCno").val();
                                var multiple = $("#multiplier0").val();
                                if (multiple === undefined) {
                                    multiple = $("#txtMultiplier").val();
                                }
                                orderDetail.multiplier = multiple;
                                orderDetail.curRebate = $("#slider").val();
                                orderDetail.modes = $("input[name=unit]:checked").val();
                                orderDetail.lotteryId = orderSelect.gameType;
                                orderDetail.issue = cache.getDraw().curIssueInfo.issue;
                                orderDetail.stopOnWin = $('#withdrawlWin').attr("checked") ? '1' : '0';
                                orderDetail.traceData = null;
                                if ($("#advCno").attr('enable') == '1') {
                                    orderDetail.traceData = [];
                                    var issues = $('#advCnoListTable input');
                                    $.each(issues, function () {
                                        orderDetail.traceData.push({
                                            issue: $(this).attr('issue'),
                                            multiple: $(this).val()
                                        });
                                    });
                                }

                                server.saveOrder(orderDetail, function (data) {
                                    //hide load
                                    $.mobile.loading('hide');
                                    if (data) {
                                        orderConfirm.resetBet();
                                        utils.prompt(label.orderSuccess.replace("{0}", data.no).replace("{1}", $("#lblTotal").text().replace("￥", "")),
                                            $("#orderConfirm"),
                                            function () {
                                                $.mobile.changePage($("#orderSelect"), {
                                                    changeHash: true
                                                });
                                                var num = cache.getBet().length;
                                                document.getElementById('group').innerHTML = num;
                                            });
                                    }
                                });

                            }
                        }, null);
                }
                else {
                    utils.alert(label.invalidMultiplier, $("#orderConfirm"));
                }
            }
            else {
                utils.alert(label.invalidCno, $("#orderConfirm"));
            }
        }
        else {
            utils.alert(label.noOrder, $("#orderConfirm"));
        }
    },
    //set countdown
    setCountdown: function () {
        var gameId = cache.getGame();
        if (gameId) {
            server.getDraw(gameId, function (data) {
                if (data != null) {
                    //cache data
                    cache.setDraw(data);
                    $(".hl-order-confirm-bet-no").text(cache.getDraw().curIssueInfo.issue);
                    orderConfirm.countDownTimer($("#orderConfirmCountdown"), data.curRemainTime,data.curIssueInfo.waite_time,data.curIssueInfo.state);
                    //追号也要刷新
                    if ($("#advCno").attr('enable') == '1') {
                        orderConfirm.refreshTraceData();
                    }
                }
            });
        }
    },
    //reset countdown
    resetCountdown: function () {
        $("#orderConfirmCountdown").countdown('destroy');
    },
    //count down timer
    countDownTimer: function (gameTime, timestamp,waite_time,state) {
        //set display
        gameTime.countdown('destroy');
        if (timestamp > 0) {
            $("#orderStop").html("<span>截止：</span>");
            // utils.alert(label.drawDisable, $("#orderConfirm"), orderConfirm.setCountdown());
            gameTime.countdown({
                until: timestamp,
                format: "dHMS",
                compact: true,
                onExpiry: function () {
                    utils.alert(label.drawDisable, $("#orderConfirm"), orderConfirm.setCountdown);
                }
            });
        } else {
            $("#orderStop").html("<span>开奖倒计时：</span>");
            gameTime.countdown({
                until: waite_time,
                format: "dHMS",
                compact: true,
                onExpiry: function () {
                    // utils.alert(label.drawDisable1, $("#orderConfirm"), orderConfirm.setCountdown);
                    orderConfirm.setCountdown();
                }
            });
        }
        if(isNaN(timestamp)){
            gameTime.countdown('destroy');
            $("#orderStop").empty();
            gameTime.text('等待开奖');
        }
    },
    //reset bet
    resetBet: function () {
        cache.clearBet();
    },
    getMode: function (pos) {
        if (!pos) {
            pos = 50;
        }
        var gapList = orderConfirm.generateGapList();
        var gap = gapList[parseInt(gapList.length * (pos / 100))];

        return gap;
    },
    generateGapList: function () {
        var gameId = cache.getGame();
        var game = utils.getGameConfigsById(gameId);
        var gameConfig = game.gc;
        var result = [];
        $.each(gameConfig.minRebateGaps,
            function (k, v) {
                v.from = parseFloat(v.from);
                v.to = parseFloat(v.to);
                v.gap = parseFloat(v.gap);
                if (gameConfig.rebate > v.to) {
                    for (var i = v.from; i <= v.to; i += v.gap) {
                        result.push(parseFloat(number_format(i, 3)));
                    }
                } else {
                    for (i = v.from; i < v.to && i < gameConfig.rebate; i += v.gap) {
                        result.push(parseFloat(number_format(i, 3)))
                    }
                    result.push(parseFloat(number_format(gameConfig.rebate, 3)));
                }
            });
        result = array_unique(result);
        var result2 = [];
        $.each(result,
            function (k, v) {
                var prize = round(gameConfig.maxCombPrize * ((gameConfig.lotteryType == 1 ? 0.85 : 0.85) + v), 0);
                result2.push({
                    rebate: round(gameConfig.rebate - v, 3),
                    prize: prize
                })
            });
        return result2;
    }
}

﻿/*---------------------------------------------------------------------------test--------------------------------------------------------------------------------------------------------*/
