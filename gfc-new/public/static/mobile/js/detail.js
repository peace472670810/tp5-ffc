//page before change event
        $(document).on("pagebeforechange", function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#detail/;

        if (u.hash.search(re) !== -1) {

            detail.id = getUrlParam('id', u.hash);
            detail.trace_id = getUrlParam('trace_id', u.hash);
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
$("#detail").on('pagebeforeshow', function() {
    //hide content
    $("#detailNumber").text("");
    $(".hl-detail-main, #withdraw").hide();

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

//page show event
$("#detail").on('pageshow', function() {
    //initialiaze
    detail.init();
});

var detail = {
    id: "",
    //init
    init: function() {
        if (detail.id.length > 0) {
            //show load
            $.mobile.loading('show');
            server.getDetail({'id': detail.id, 'trace_id': detail.trace_id}, function(data) {
                //hide load
                $.mobile.loading('hide');

                if (data != null) {
                    //render
                    detail.render(data);
                }
                else {
                    $("#detailNumber").text(label.noRecord);
                }
            });
        }
        else {
            $("#detailNumber").text(label.noRecord);
        }
    },
    //render
    render: function(data) {

        var o = [];
        //number list
        $.each(data.projects, function() {
            o.push('<li>');
            o.push('<span class="hl-detail-game">');
            o.push(this.cname);
            o.push('</span><span class="hl-detail-number">');
            o.push(this.code);
            o.push('</span><span class="hl-detail-bet">');
            o.push(this.single_num);
            o.push('注</span></li>');

        });
        $("#detailList").html(o.join("")).listview('refresh');
        //detail

        if (data.trace) {
            $(".hl-detail-normal").hide();
            $(".hl-detail-cno").show();
            $("#detailNumber").text(data.trace.wrap_id);
            $("#detail2_lottery").text(data.lottery.cname);
            $("#detail2_modes").text(data.modes);
            $("#detail2_single_num").text(data.trace.single_num);
            $("#detail2_total_multiple").text(data.trace.total_multiple);
            $("#detail2_trace_times").text(data.trace.trace_times);
            $("#detail2_total_amount").text(data.trace.total_amount);
            $("#detail2_prizeMode").text(data.prizeMode);
            $("#detail2_stop_on_win").text(data.trace.stop_on_win);
            $("#detail2_status").text(data.trace.status);
            $("#detail2_create_time").text(data.trace.create_time);

            var pkids = [];
            var oPackages = [];
            var cancel_status = false ;
            $.each(data.packages, function() {
                if(this.cancel_status=='0') cancel_status=true;
                pkids.push(this.package_id);
                oPackages.push('<li>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">追号期号:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.issue + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">开奖号码:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.openCodes + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">当期倍数:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.multiple + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">投注金额:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.amount + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">中奖金额:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.prize + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">订单状态:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.status + '</label></div>');
                oPackages.push('</li>');
            });
            $("#zhuihaoList").html(oPackages.join("")).listview('refresh');

            //withdraw button 撤单
            detail.wrap_id = data.trace.wrap_id;
            detail.pkids = pkids;
            if (cancel_status) {
                $("#withdraw").off("click").click(function() {
                    $("#withdrawPopup").popup("open");
                    //programmatically bind click event
                    $("#confirmWithdraw").off("click").click(function() {
                        detail.withdraw({'id': detail.id, 'trace_id': detail.trace_id, 'wrap_id': detail.wrap_id,
                            'pkids': detail.pkids});
                    });
                }).show();
            }

        }
        else if (data.package)
        {
            $(".hl-detail-normal").show();
            $(".hl-detail-cno").hide();
            $("#detailNumber").text(data.package.wrap_id);
            $("#detail_username").text(data.user.username);
            $("#detail_create_time").text(data.package.create_time);
            $("#detail_lottery").text(data.lottery.cname);
            $("#detail_issue").text(data.package.issue);
            $("#detail_single_num").text(data.package.single_num);
            $("#detail_multiple").text(data.package.multiple);
            $("#detail_modes").text(data.modes);
            $("#detail_is_trace").text(data.package.is_trace);
            $("#detail_amount").text(data.package.amount);
            $("#detail_prizeMode").text(data.prizeMode);
            $("#detail_openCodes").text(data.package.openCodes);
            $("#detail_status").text(data.package.status);
            $("#detail_prize").text(data.package.prize);
            //withdraw button 撤单
            detail.wrap_id = data.package.wrap_id;
            if (data.package.cancel_status == '0') {
                $("#withdraw").off("click").click(function() {
                    $("#withdrawPopup").popup("open");
                    //programmatically bind click event
                    $("#confirmWithdraw").off("click").click(function() {
                        detail.withdraw({'id': detail.id, 'trace_id': detail.trace_id, 'wrap_id': detail.wrap_id});
                    });
                }).show();
            }

        }
        $(".hl-detail-main").show();
    },
    //withdraw
    withdraw: function(id) {
        //show load
        $.mobile.loading('show');

        server.withdraw(id, function(data) {
            //hide load
            $.mobile.loading('hide');
            $(".hl-detail-main, #withdraw").hide();
            if (data.errno == '0') {
                alert(label.withdrawSuccess);
            }
            else {
                alert(data.errstr);
            }
            detail.init();
        });
    }
}