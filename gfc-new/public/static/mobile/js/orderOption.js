//page before change event
        $(document).on("pagebeforechange", function(e, data) {
    //use cache if available, otherwise read from url
    if (cache.getGame() == null) {
        if (typeof data.toPage === "string") {
            var u = $.mobile.path.parseUrl(data.toPage),
                    re = /^#orderSelect/;
            if (u.hash.search(re) !== -1) {
                //further check for query string
                if (u.hash.indexOf("?g=") != -1) {
                    cache.setGame(u.hash.replace(/.*g=/, ""));
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
$("#orderSelect").on('pagebeforeshow', function() {
    //clear
    $("#numberList").empty();
    $("#orderCountdown").text("--:--:--");

    //reset cache
    orderSelect.resetDraw();
});

//page show event
$("#orderSelect").on('pageshow', function(e, data) {
    //initialiaze    
    orderSelect.init();
});

//page hide event
$("#orderSelect").on('pagehide', function(e, data) {
    //reset number
    orderSelect.resetNumber();
    orderSelect.resetCountdown();
});

//page init event
$('#orderSelect').on('pageinit', function(event) {
    $("#gameOptionList").change(function(event, ui) {
        orderSelect.renderNumber($(this).val());
    });

    $("#orderAuto").unbind("vclick").bind('vclick', function(e) {
        orderSelect.randomNumber();
    });

    $("#orderClear").unbind("vclick").bind('vclick', function(e) {
        orderSelect.resetNumber();
    });

    $("#orderSelect").unbind("click").bind('click', function(e) {
        orderSelect.confirmOrder();
    });
});

var orderSelect = {
    gameSubOption: null,
    number: {},
    gameType: null,
    //init
    init: function() {
        orderSelect.render();
        //start countdown
        orderConfirm.resetCountdown();
        orderSelect.setCountdown();
    },
    //render
    render: function() {
        var gameId = cache.getGame();
        if (gameId) {
            //header
            $("#orderTitle").text(utils.getGameLabel(gameId));
            //options
            var o = [], game = utils.getGameConfigsById(gameId);
            if (game != null) {
                var gameConfig = game.gc,
                        configIndex = 0,
                        count = 0,
                        id = "",
                        optionLabel = "",
                        subOptionLabel = "";
                //set game type
                orderSelect.gameType = game.lottery_id;
                orderSelect.lotteryType = game.lotteryType;
                $.each(gameConfig.methods, function() {
                    optionLabel = this.mg_name;
                    //main options
                    o.push('<optgroup label="');
                    o.push(optionLabel);
                    o.push('">');
                    //sub options
                    $.each(this.childs, function() {
                        //不能输入的 不支持～～
                        if (!this.field_def || this.field_def.length == 0) {
                            return;
                        }
                        subOptionLabel = this.cname;
                        o.push('<option value="');
                        o.push(this.method_id);
                        o.push('">');
                        o.push(subOptionLabel);
                        o.push('</option>');
                        // 默认方法
                        if (gameConfig.lotteryType == 1) {
                            if (subOptionLabel == '后三直选' || subOptionLabel == 'P3直选')
                                configIndex = count;
                        } else if (gameConfig.lotteryType == 2) {
                            if (subOptionLabel == '任选' || subOptionLabel == '任选五中五')
                                configIndex = count;
                        } else if (gameConfig.lotteryType == 4) {
                            if (subOptionLabel == '直选')
                                configIndex = count;
                        }
                        count++;
                    });
                    o.push('</optgroup>');
                });
                $("#gameOptionList").empty().html(o.join(""));
            }
            $("#gameOptionList")[0].selectedIndex = configIndex;
            $("#gameOptionList").selectmenu("refresh", true);
            //render default numbers
            orderSelect.renderNumber($("#gameOptionList").val());
            //render history
            $('#orderHistory').attr('href', '/?c=game&a=chart&lottery_id=' + orderSelect.gameType);
        }
    },
    //render numbers
    renderNumber: function(code) {
        var gameId = cache.getGame();
        var game = utils.getGameConfigsById(gameId);
        var gameConfig = game.gc;
        var subOption = {};
        $.each(gameConfig.methods, function() {
            $.each(this.childs, function() {
                if (this.method_id == code) {
                    subOption = this;
                }
            });
        });
        var className = 'hl-order-tab';
        // 特殊彩种
        //var  className = "hl-order-tab-hel";
        if (subOption) {
            //cache subOption
            orderSelect.gameSubOption = subOption;
            var n = [];
            for (var rowno in subOption.field_def) {
                n.push('<li data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal"><legend class="hl-order-game-legend">');
                if (subOption.field_def[rowno].prompt) {
                    n.push(subOption.field_def[rowno].prompt);
                }
                else {
                    n.push("");
                }
                n.push('</legend><div class="hl-order-game-buttons ');
                n.push('">');
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
            $('#numberList').empty().html(n.join("")).listview('refresh');
            //bind events
            $('.hl-order-game-tab > span').bind('vclick', function(e) {
                e.preventDefault();
                var tab = $(this).parent();
                var id = tab.attr('row');
                if (tab.hasClass(className + "-selected")) {
                    tab.removeClass(className + "-selected");
                    //update number
                    orderSelect.updateNumber(id, $(this).text(), false)
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
                            alert("当前最多只能选择" + orderSelect.gameSubOption.field_def[id].max_selected + "个号码");
                        }
                    } else {
                        tab.addClass(className + "-selected");
                        orderSelect.updateNumber(id, $(this).text(), true);
                        orderSelect.updateOrder();
                    }

                }

            });
        }

        //reset 
        orderSelect.resetNumber();
    },
    //reset number
    resetNumber: function() {
        $(".hl-order-game-tab").removeClass("hl-order-tab-selected");
        $(".hl-order-game-tab").removeClass("hl-order-tab-hel-selected");
        $(".hl-order-footer-text").text("");

        orderSelect.number = {};
    },
    //get number
    getNumber: function(id) {
        return orderSelect.number[id];
    },
    //update number
    updateNumber: function(id, number, add) {
        var numbers = orderSelect.getNumber(id);

        //create new number placeholder
        if (numbers == null || number == undefined) {
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
    isLegalCode: function() {
        var result = true;
        for (var rowno in orderSelect.gameSubOption.field_def) {
            if (!orderSelect.number[rowno]) {
                result = false;
            }
        }
        return result;

    },
    //update order
    updateOrder: function() {
        var isLegalCode = orderSelect.isLegalCode();
        if (orderSelect.number && isLegalCode) {
            var codes = new Array();
            var bets = '';
            var arrindex = 0;
            for (var rowno in orderSelect.number) {
                if (bets != '') {
                    bets += ',';
                }
                if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10) {
                    bets += (orderSelect.number[rowno]).join('_');
                }
                else {
                    bets += (orderSelect.number[rowno]).join('');
                }

                codes[arrindex] = orderSelect.number[rowno];
                arrindex++;
            }
            //只有一组的情况下格式不同
            if (arrindex == 1) {
                codes[0] = codes[0].join('_');
            }

            var betResult = utils.isLegalCode(codes, orderSelect.gameSubOption.name);
            var bets_total = betResult.singleNum;
            var totalOrder = [];
            totalOrder.push('号码: ');
            totalOrder.push('<span id="orderBet" class="hl-order-summary">');
            totalOrder.push(bets);
            totalOrder.push('</span>');
            totalOrder.push("，");
            totalOrder.push('<span id="orderTotal" class="hl-order-summary">');
            totalOrder.push(bets_total);
            totalOrder.push('</span> ');
            totalOrder.push('注');
            $(".hl-order-footer-text").html(totalOrder.join("")).show();
        }
        else {
            $(".hl-order-footer-text").html("").show();
        }
    },
    //confirm order
    confirmOrder: function() {
        //validation
        var isLegalCode = orderSelect.isLegalCode();

        if (isLegalCode) {
            //add number to bet collection

            var codes = '';
            for (var rowno in orderSelect.number) {
                if (codes != '') {
                    codes += ',';
                }
                if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10) {
                    codes += (orderSelect.number[rowno]).join('_');
                }
                else {
                    codes += (orderSelect.number[rowno]).join('');
                }
            }
            var orderDetail = {
                subOption: orderSelect.gameSubOption.method_id,
                type: orderSelect.gameSubOption.cname,
                name: orderSelect.gameSubOption.name,
                number: orderSelect.number,
                codes: codes,
                bet: $("#orderBet").text(),
                total: $("#orderTotal").text(),
                unit: cache.getUnit(),
            };
            cache.addBet(orderDetail);
            //direct to order confirmation page
            $.mobile.changePage($("#orderConfirm"), {
                changeHash: true
            });
        }
        else {
            utils.alert(label.inCompleteGame, $("#orderSelect"));
        }
    },
    //set order number
    setOrderNumber: function(data) {

    },
    //random number
    randomNumber: function() {
        var max = $('#numberList span').length;
        $('#numberList span').each(function() {
            var random = Math.floor(Math.random() * max + 1);
            if (random > (max * 0.618))
                $(this).click();

        });

    },
    //set countdown
    setCountdown: function() {
        var gameId = cache.getGame();
        if (gameId) {
            server.getDraw(gameId, function(data) {
                if (data != null) {
                    //cache data
                    cache.setDraw(data);
                    //update title
                    $("#orderTitle").html(utils.getGameLabel(gameId) + '<span class="hl-order-period">' + data.curIssueInfo.issue + label.period + '</span>');
                    orderSelect.countDownTimer($("#orderCountdown"), data.curRemainTime);
                }
            });
        }
    },
    //reset countdown
    resetCountdown: function() {
        $("#orderCountdown").countdown('destroy');
    },
    //count down timer
    countDownTimer: function(gameTime, timestamp) {
        //timestamp = 999999;
        gameTime.countdown('destroy');
        gameTime.countdown({
            until: timestamp,
            format: "dHMS",
            compact: true,
            onExpiry: function() {
                alert(label.drawDisable);
                //refresh countdown
                orderSelect.setCountdown();
            }
        });
    },
    //reset draw
    resetDraw: function() {
        cache.resetDraw();
    }
}