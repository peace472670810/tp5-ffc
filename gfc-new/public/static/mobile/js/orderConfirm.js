//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#orderConfirm/;
        if (u.hash.search(re) !== -1) {
            var game = cache.getGame();

            if (game == null) {
                e.preventDefault();

                $.mobile.changePage($("#cp"), {
                    changeHash: true
                });
            }
        }
    }
});

//page before show event
$("#orderConfirm").on('pagebeforeshow', function() {
    //clear
    $("#orderList").empty();

    //reset draw
    $(".hl-order-confirm-bet-no").text("-");
});

//page show event
$("#orderConfirm").on('pageshow', function(e, data) {
    //initialiaze    
    orderConfirm.init();
});

//page hide event
$("#orderConfirm").on('pagehide', function(e, data) {
    orderConfirm.resetCountdown();
});



//page init event
$('#orderConfirm').on('pageinit', function(event) {
    $("input[name=unit]:radio").unbind("change").change(function() {
        //update summary
        orderConfirm.updateSummary();
    });

    $("#txtCno").unbind("keydown").keydown(function(event) {
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
    }).unbind("change").change(function() {
        try {
            var m = parseInt($("#txtCno").val());

            if (m <= 0) {
                $("#txtCno").val("1");
            }
        } catch (E) {
            $("#txtCno").val("1");
        }

        cache.setBetSettingsCno(this.value);

        //update summary
        orderConfirm.updateSummary();
    });

    $("#txtMultiplier").unbind("keydown").keydown(function(event) {
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
    }).unbind("change").change(function() {
        try {
            var m = parseInt($("#txtMultiplier").val());

            if (m <= 0) {
                $("#txtMultiplier").val("1");
            }
        } catch (E) {
            $("#txtMultiplier").val("1");
        }

        orderConfirm.updateSummary();
    });

    $("#orderConfirmOrder").unbind("click").click(function() {
        orderConfirm.placeOrder();
    });
});

var orderConfirm = {
    payoutStack: [],
    //init
    init: function() {
        var data = cache.getData();

        if (data == null) {
            server.getConfig(function(data) {
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
    //render
    render: function() {
        var data = cache.getBet(),
                multiplier = 0,
                total = 0,
                o = [],
                amount = 0;

        if (data.length > 0) {
            $.each(data, function(i) {
                o.push('<li><div class="hl-order-confirm-label">');
                o.push(this.type);
                o.push('</div><div class="hl-order-confirm-number">');
                o.push(orderConfirm.getNumberDisplay(this.type, this.number));
                o.push('  (共' + this.total + '注)');
                o.push('</div><div class="hl-order-confirm-data" number="');
                o.push(orderConfirm.getNumberDisplay(this.type, this.number));
                o.push('" code="');
                o.push(this.subOption);
                o.push('" style="display:none"></div><div class="hl-order-confirm-delete">');
                o.push('<a href="#" data-role="button" data-mini="true" data-theme="d" i="');
                o.push(i.toString());
                o.push('">删除</a></div></li>');

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
        $('.hl-order-confirm-delete > a').button().click(function() {
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
        var defaultGapPos = 50;
        var defaultGap = orderConfirm.getMode(defaultGapPos);
        //当前模式
        $(".hl-order-mode").text(defaultGap.prize + '/' + (defaultGap.rebate * 100));
        $("#slider")
                .off("slidestop")
                .off("change")
                .attr("min", 1)
                .attr("max", 100)
                .val(defaultGapPos)
                .slider('refresh');

        //slider event
        $("#slider").change(function() {
            var gap = orderConfirm.getMode(this.value);
            $(".hl-order-mode").text(gap.prize + '/' + (gap.rebate * 100));
        }).on("slidestop", function() {
            var gap = orderConfirm.getMode(this.value);
            $(".hl-order-mode").text(gap.prize + '/' + (gap.rebate * 100));
        });

        //元角分模式
        //$(".hl-order-confirm-unit").attr("checked", false).checkboxradio("refresh");
        //$("#unit" + memberSettings.u).attr("checked", true).checkboxradio("refresh");

        //单倍注数
        $("#lblMultiplier").text(multiplier);

        //合计
        $("#lblTotal").attr("val", total);
        orderConfirm.updateSummary();
        $("#txtMultiplier").blur();
    },
    //get number display
    getNumberDisplay: function(type, number) {
        var bets = '';
        for (var rowno in number) {
            if (bets != '') {
                bets += ',';
            }
            bets += (number[rowno]).join('_');

        }
        return bets;
    },
    //update summary
    updateSummary: function() {
        var total = $("#lblTotal").attr("val"),
                multiplier = utils.parseFloat($("#txtMultiplier").val()),
                cno = utils.parseFloat($("#txtCno").val());
        total = $("input[name=unit]:checked").val() * total * (multiplier * cno);
        $("#lblTotal").text(label.symbol + total.toFixed(2));
    },
    //place order
    placeOrder: function() {
        var data = cache.getBet();

        //make sure there are order
        if (data.length > 0) {
            //verify cno and multiplier
            if ($("#txtCno").val().length > 0) {
                if ($("#txtMultiplier").val().length > 0) {

                    $("#orderConfirmSummary").text(label.confirmOrders);
                    var message = label.confirmOrders.replace("{0}", $("#lblTotal").text().replace("￥", ""));
                    utils.confirm(message, $("#orderConfirm"),
                            function() {
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
                                    $.mobile.loading('show');
                                    orderDetail = {};
                                    orderDetail.data = data;
                                    orderDetail.cno = $("#txtCno").val();
                                    orderDetail.multiplier = $("#txtMultiplier").val();
                                    var gap = orderConfirm.getMode($("#slider").val());
                                    orderDetail.curRebate = gap.rebate;
                                    orderDetail.modes = $("input[name=unit]:checked").val();
                                    orderDetail.lotteryId = orderSelect.gameType;
                                    orderDetail.issue = cache.getDraw().curIssueInfo.issue;
                                    orderDetail.stopOnWin = $('#withdrawlWin').attr("checked") ? '1' : '0';

                                    server.saveOrder(orderDetail, function(data) {
                                        //hide load
                                        $.mobile.loading('hide');
                                        if (data) {
                                            orderConfirm.resetBet();

                                            utils.prompt(label.orderSuccess.replace("{0}", data.no).replace("{1}", $("#lblTotal").text().replace("￥", "")),
                                                    $("#orderConfirm"),
                                                    function() {
                                                        $.mobile.changePage($("#orderSelect"), {
                                                            changeHash: true
                                                        });
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
    setCountdown: function() {
        var gameId = cache.getGame();
        if (gameId) {
            server.getDraw(gameId, function(data) {
                if (data != null) {
                    //cache data
                    cache.setDraw(data);
                    $(".hl-order-confirm-bet-no").text(cache.getDraw().curIssueInfo.issue);
                    orderConfirm.countDownTimer($("#orderConfirmCountdown"), data.curRemainTime);
                }
            });
        }
    },
    //reset countdown
    resetCountdown: function() {
        $("#orderConfirmCountdown").countdown('destroy');
    },
    //count down timer
    countDownTimer: function(gameTime, timestamp) {
        //set display
        gameTime.countdown('destroy');
        gameTime.countdown({
            until: timestamp,
            format: "dHMS",
            compact: true,
            onExpiry: function() {
                alert(label.drawDisable);
                //refresh countdown
                orderConfirm.setCountdown();
            }
        });
    },
    //reset bet
    resetBet: function() {
        cache.clearBet();
    },
    getMode: function(pos) {
        if (!pos) {
            pos = 50;
        }
        var gapList = orderConfirm.generateGapList();
        var gap = gapList[parseInt(gapList.length * (pos / 100))];

        return gap;
    },
    generateGapList: function() {
        var gameId = cache.getGame();
        var game = utils.getGameConfigsById(gameId);
        var gameConfig = game.gc;
        var result = [];
        $.each(gameConfig.minRebateGaps,
                function(k, v) {
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
                function(k, v) {
                    var prize = round(gameConfig.maxCombPrize * ((gameConfig.lotteryType == 1 ? 0.9 : 0.9) + v), 0);
                    result2.push({
                        rebate: round(gameConfig.rebate - v, 3),
                        prize: prize
                    })
                });

        return result2;
    }
}
