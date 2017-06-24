﻿//page before change event
$(document).on('pagebeforechange', function (e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
			re = /^#search/;

        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#search";

                e.preventDefault();

                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

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
    search.init();
});

//page init event
$('#search').on('pageinit', function (event) {
    $("#searchGameList").change(function (event, ui) {
        //reset page number
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();

        //clear
        $("#searchList").empty();

        search.search(false);
    });

    $("#searchRangeList").change(function (event, ui) {
        //reset page number
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();

        //clear
        $("#searchList").empty();

        search.search(false);
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

    //init
    init: function () {
        //clear
        $("#searchList").empty();

        var data = cache.getData();

        if (data == null) {
            //show load
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
            if (searchGameList.html().length > 0) {
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

                //reset dropdown
                searchGameList[0].selectedIndex = 0;
                searchGameList.selectmenu("refresh", true);
                
                for (var i = 1; i < 8; i++) {
                    d.push('<option value="');
                    d.push(i.toString());
                    d.push('">');
                    d.push(i.toString());
                    d.push("天</option>");
                }                    

                searchRangeList.empty().html(d.join(""));

                //reset dropdown
                searchRangeList[0].selectedIndex = 0;
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
            $.mobile.loading('show');
        }

        var item = {};
        item.gameId = $("#searchGameList").val();
        item.day = $("#searchRangeList").val();
        item.pageNumber = search.pageNumber;
        item.pageSize = setting.search.pageSize;

        server.getOrders(item, function (data) {
            if (data != null) {
                var s = [];
//amount: "2.00"
//cancel_admin_id: "0"
//cancel_status: "0"
//cancel_time: "0000-00-00 00:00:00"
//check_prize_status: "0"
//create_time: "2014-06-04 19:08:43"
//cur_rebate: "0.000"
//issue: "20140604-111"
//lottery_id: "1"
//modes: "1"
//multiple: "1"
//package_id: "239"
//prize: "0.0000"
//prize_mode: 1950
//proxy_ip: "127.0.0.1"
//send_prize_status: "0"
//send_prize_time: "0000-00-00 00:00:00"
//server_ip: ""
//single_num: "1"
//status: "未开奖"
//top_id: "10100"
//trace_id: "11"
//ts: "2014-06-04 19:08:43"
//user_id: "10100"
//user_ip: "127.0.0.1"
//username: "zdjerry"
//wrap_id: "CQ4060411100000239P"
                if (data.r.length > 0) {
                    $.each(data.r, function (index) {
                        s.push('<li><a href="#detail?id='+this.wrap_id+'&trace_id='+this.trace_id);
                        s.push('"><div class="hl-search-search"><div class="hl-search-bet">');
                        s.push(this.create_time);
                        s.push('</div><div class="hl-search-order">');
                        s.push((this.prize_mode));
                        s.push('</div><div class="hl-search-amount">');
                        s.push(utils.digits(this.amount, 2));
                        s.push('</div><div class="hl-search-status">');
                        s.push((this.status));
                        s.push('</div></div></a></li>');
                    });
                }
                else {
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