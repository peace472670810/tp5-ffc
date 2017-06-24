      var helper = {
            SXBD: {
                0: 1,
                1: 1,
                2: 2,
                3: 3,
                4: 4,
                5: 5,
                6: 7,
                7: 8,
                8: 10,
                9: 12,
                10: 13,
                11: 14,
                12: 15,
                13: 15,
                14: 15,
                15: 15,
                16: 14,
                17: 13,
                18: 12,
                19: 10,
                20: 8,
                21: 7,
                22: 5,
                23: 4,
                24: 3,
                25: 2,
                26: 1,
                27: 1
            },
            EXBD: {
                0: 1,
                1: 1,
                2: 2,
                3: 2,
                4: 3,
                5: 3,
                6: 4,
                7: 4,
                8: 5,
                9: 5,
                10: 5,
                11: 4,
                12: 4,
                13: 3,
                14: 3,
                15: 2,
                16: 2,
                17: 1,
                18: 1
            },
            SXHZ: {
                0: 1,
                1: 3,
                2: 6,
                3: 10,
                4: 15,
                5: 21,
                6: 28,
                7: 36,
                8: 45,
                9: 55,
                10: 63,
                11: 69,
                12: 73,
                13: 75,
                14: 75,
                15: 73,
                16: 69,
                17: 63,
                18: 55,
                19: 45,
                20: 36,
                21: 28,
                22: 21,
                23: 15,
                24: 10,
                25: 6,
                26: 3,
                27: 1
            },
            EXHZ: {
                0: 1,
                1: 2,
                2: 3,
                3: 4,
                4: 5,
                5: 6,
                6: 7,
                7: 8,
                8: 9,
                9: 10,
                10: 9,
                11: 8,
                12: 7,
                13: 6,
                14: 5,
                15: 4,
                16: 3,
                17: 2,
                18: 1
            },
            SXZXHZ: {
                1: 1,
                2: 2, 
                3: 2, 
                4: 4, 
                5: 5,
                6: 6, 
                7: 8, 
                8: 10, 
                9: 11, 
                10: 13, 
                11: 14, 
                12: 14, 
                13: 15,
                14: 15, 
                15: 14, 
                16: 14, 
                17: 13, 
                18: 11, 
                19: 10, 
                20: 8, 
                21: 6, 
                22: 5,
                23: 4, 
                24: 2, 
                25: 2, 
                26: 1
            },
            factorial: function(n) {
                if (n == 1) {
                    return 1
                } else {
                    return n * helper.factorial(n - 1)
                }
            },
            expandLotto: function($nums) {
                var result = [];
                var tempVars = [];
                var oneAreaIsEmpty = 0;
                $.each($nums,
                        function(k, v) {
                            if ($.trim(v) == "") {
                                oneAreaIsEmpty = 1;
                                return
                            }
                            var tmp = v.split("_");
                            tmp.sort();
                            tempVars.push(tmp);
                        });
                if (oneAreaIsEmpty) {
                    return [];
                }
                var i, j, k, L, m;
                switch ($nums.length) {
                    case 2:
                        for (i = 0; i < tempVars[0].length; i++) {
                            for (j = 0; j < tempVars[1].length; j++) {
                                result.push(tempVars[0][i] + " " + tempVars[1][j])
                            }
                        }
                        break;
                    case 3:
                        for (i = 0; i < tempVars[0].length; i++) {
                            for (j = 0; j < tempVars[1].length; j++) {
                                for (k = 0; k < tempVars[2].length; k++) {
                                    result.push(tempVars[0][i] + " " + tempVars[1][j] + " " + tempVars[2][k])
                                }
                            }
                        }
                        break;
                    case 5:
                        for (i = 0; i < tempVars[0].length; i++) {
                            for (j = 0; j < tempVars[1].length; j++) {
                                for (k = 0; k < tempVars[2].length; k++) {
                                    for (L = 0; L < tempVars[3].length; L++) {
                                        for (m = 0; m < tempVars[4].length; m++) {
                                            result.push(tempVars[0][i] + " " + tempVars[1][j] + " " + tempVars[2][k] + " " + tempVars[2][L] + " " + tempVars[2][m])
                                        }
                                    }
                                }
                            }
                        }
                        break;
                    default:
                        throw "unkown expand";
                        break;
                }
                var $finalResult = [];
                $.each(result,
                        function(k, v) {
                            var $parts = v.split(" ");
                            var tmp = array_unique($parts);
                            if (tmp.length == $parts.length) {
                                $finalResult.push(v)
                            }
                        });
                return $finalResult;
            }
        }
   

﻿var utils = {
    //get game label
    getGameLabel: function(id) {
        return window["label"]["game" + id];
    },
    //get game by id
    getGameById: function(id) {
        var result = null;
        var data = cache.getData();

        $.each(data.games, function() {
            if (this.id == id) {
                result = this;
                return false;
            }
        });

        return result;
    },
    //get game configs by id
    getGameConfigsById: function(id) {
        var data = cache.getData();
        var index = -1;
        $.each(data.games, function(i) {
            if (this.id == id) {
                index = i;
            }
        });
        //获取彩种的所有配置信息
        if (index != -1 && !data.games[index].gc) {
            $.mobile.loading('show');
            server.getGameConfig(id,
                    function(rGc) {
                        $.mobile.loading('hide');
                        data.games[index].gc = rGc;
                    });
        }
        return data.games[index];
    },
    //get game option
    getGameOptionLabel: function(id) {
        return window["label"]["opt" + id];
    },
    //get game sub option
    getGameSubOptionLabel: function(id) {
        return window["label"]["subOpt" + id];
    },
    //get game sub option summary 
    getGameSubOptionSummaryLabel: function(id) {
        return window["label"]["subOptSummary" + id];
    },
    //get game sub option configuration
    getGameSubOptionConfig: function(id) {
        var result = null;
        var data = cache.getData();

        $.each(data.gameSubOption, function() {
            if (this.id == id) {
                result = this;
                return false;
            }
        });

        return result;
    },
    //get game status
    getGameStatus: function(type) {
        return window["label"]["status" + type];
    },
    //get payout group by id
    getPayoutGroup: function(id) {
        var result = null;
        var data = cache.getData();

        $.each(data.groups, function() {
            if (this.id == id) {
                result = this;
                return false;
            }
        });

        return result;
    },
    //get unit - 元角分
    getUnit: function(u) {
        return window["label"]["unit" + u];
    },
    //get yes no
    getYesNo: function(b) {
        return window["label"]["yn" + b];
    },
    //calculate order summary
    orderSummary: function(numbers, payout, rebate, unit, gameCode) {
        if (unit == 4) {
            unit = 1;
        }
        else if (unit == 2) {
            unit = 0.2;
        }
        else if (unit == 3) {
            unit = 0.02;
        }
        else {
            unit = 2;
        }

        var bet = 0;

        try {
            if (gameCode == '1S') {
                bet = numbers["1"].length;
            }
            else if (gameCode == '2S') {
                bet = numbers["1"].length * numbers["2"].length;
            }
            else if (gameCode == 'BS') {
                bet = numbers["5"].length * numbers["4"].length;
            }
            else if (gameCode == '2S') {
                bet = numbers["1"].length * numbers["2"].length;
            }
            else if (gameCode == 'BS') {
                bet = numbers["5"].length * numbers["4"].length;
            }
            else if (gameCode == '2P') {
                bet = numbers["1"].length * numbers["2"].length;
            }
            else if (gameCode == 'BP') {
                bet = numbers["5"].length * numbers["4"].length;
            }
            else if (gameCode == '2C' || gameCode == 'BC') {
                bet = (numbers["6"].length * (numbers["6"].length - 1)) / 2;
            }
            else if (gameCode == '2A') {
                bet += numbers["1"].length;
                bet += numbers["2"].length * numbers["1"].length;
            }
            else if (gameCode == 'BA') {
                bet += numbers["4"].length;
                bet += numbers["5"].length * numbers["4"].length;
            }
            else if (gameCode == '2B') {
                if (numbers["2"].length == 1 && numbers["1"].length == 1) {
                    bet = 1;
                }
            }
            else if (gameCode == 'BB') {
                if (numbers["5"].length == 1 && numbers["4"].length == 1) {
                    bet = 1;
                }
            }
            else if (gameCode == '2F' || gameCode == 'BF') {
                bet += numbers["13"].length * 10;
            }
            else if (gameCode == '2G' || gameCode == 'BG') {
                bet += numbers["14"].length;
            }
            else if (gameCode == '33' || gameCode == 'C3') {
                bet = (numbers["9"].length * (numbers["9"].length - 1))
            }
            else if (gameCode == '36' || gameCode == 'C6') {
                if (numbers["17"].length >= 3) {
                    bet = (numbers["17"].length * (numbers["17"].length - 1) * (numbers["17"].length - 2)) / 6;
                }
            }
            else if (gameCode == '3A') {
                bet += numbers["1"].length
                bet += +numbers["2"].length * numbers["1"].length;
                bet += numbers["3"].length * numbers["2"].length * numbers["1"].length
            }
            else if (gameCode == 'CA') {
                bet += numbers["3"].length;
                bet += numbers["4"].length * numbers["3"].length;
                bet += numbers["5"].length * numbers["4"].length * numbers["3"].length;
            }
            else if (gameCode == 'CC' || gameCode == '3C') {
                if (numbers["10"].length >= 3) {
                    bet = (numbers["10"].length * (numbers["10"].length - 1) * (numbers["10"].length - 2));
                }
            }
            else if (gameCode == 'CS') {
                bet = numbers["5"].length * numbers["4"].length * numbers["3"].length;
            }
            else if (gameCode == '3S') {
                bet = numbers["1"].length * numbers["2"].length * numbers["3"].length;
            }
            else if (gameCode == 'CH' || gameCode == 'CI' || gameCode == '3H' || gameCode == '3I') {
                ////前三组选 (包二胆), 前三组选 (包一胆), 后三组选 (包一胆), 后三组选 (包二胆)
                if (numbers["15"] != null && numbers["16"] != null) {
                    bet = 10;
                }
                else if (numbers["15"] != null) {
                    bet = 55;
                }
            }
            else if (gameCode == 'CJ' || gameCode == 'CK' || gameCode == '3J' || gameCode == '3K') {
                //前三直选 (包一胆), 前三直选 (包二胆), 后三直选 (包一胆), 后三直选 (包二胆)
                if (numbers["15"] != null && numbers["16"] != null) {
                    bet = 1;
                }
                else if (numbers["15"] != null) {
                    bet = 1;
                }
            }
            else if (gameCode == '4S') {
                bet = numbers["1"].length * numbers["2"].length * numbers["3"].length * numbers["4"].length;
            }
            else if (gameCode == 'DS') {
                bet = numbers["5"].length * numbers["2"].length * numbers["3"].length * numbers["4"].length;
            }
            else if (gameCode == '5S' || gameCode == '5C') {
                bet = numbers["1"].length * numbers["2"].length * numbers["3"].length * numbers["4"].length * numbers["5"].length;
            }
            else if (gameCode == '5A') {
                bet += numbers["1"].length;
                bet += numbers["1"].length * numbers["2"].length;
                bet += numbers["1"].length * numbers["2"].length * numbers["3"].length;
                bet += numbers["1"].length * numbers["2"].length * numbers["3"].length * numbers["4"].length * numbers["5"].length;
            }
            else if (gameCode == '5F') {
                if (numbers["1"] != null) {
                    bet += numbers["1"].length;
                }

                if (numbers["2"] != null) {
                    bet += numbers["2"].length;
                }

                if (numbers["3"] != null) {
                    bet += numbers["3"].length;
                }

                if (numbers["4"] != null) {
                    bet += numbers["4"].length;
                }

                if (numbers["5"] != null) {
                    bet += numbers["5"].length;
                }
            }
            else if (gameCode == '2U') {
                for (var i = 0; i < numbers["11"].length; i++) {
                    bet += ref_data.sum2[numbers["11"][i]];
                }
            }
            else if (gameCode == 'BU') {
                for (var i = 0; i < numbers["19"].length; i++) {
                    bet += ref_data.sum2[numbers["19"][i]];
                }
            }
            else if (gameCode == '22') {
                for (var i = 0; i < numbers["7"].length; i++) {
                    bet += ref_data.sum22[numbers["7"][i]];
                }
            }
            else if (gameCode == 'B2') {
                for (var i = 0; i < numbers["20"].length; i++) {
                    bet += ref_data.sum22[numbers["20"][i]];
                }
            }
            else if (gameCode == '3U') {
                for (var i = 0; i < numbers["18"].length; i++) {
                    bet += ref_data.sum3[numbers["18"][i]];
                }
            }
            else if (gameCode == 'CU') {
                for (var i = 0; i < numbers["12"].length; i++) {
                    bet += ref_data.sum3[numbers["12"][i]];
                }
            }
            else if (gameCode == '3M') {
                for (var i = 0; i < numbers["8"].length; i++) {
                    bet += ref_data.sum33[numbers["8"][i]];
                }
            }
            else if (gameCode == 'CM') {
                for (var i = 0; i < numbers["21"].length; i++) {
                    bet += ref_data.sum33[numbers["21"][i]];
                }
            }
            else {
                // 11X5
                switch (gameCode) {
                    case "Fa":
                        bet = numbers["6"].length;
                        break;
                    case "Fb":
                        bet = mathUtil.combination(numbers["7"].length, 2);
                        break;
                    case "Fc":
                        bet = mathUtil.combination(numbers["8"].length, 3);
                        break;
                    case "Fd":
                        bet = mathUtil.combination(numbers["9"].length, 4);
                        break;
                    case "Fe":
                        bet = mathUtil.combination(numbers["10"].length, 5);
                        break;
                    case "Ff":
                        bet = mathUtil.combination(numbers["11"].length, 6);
                        break;
                    case "Fg":
                        bet = mathUtil.combination(numbers["12"].length, 7);
                        break;
                    case "Fh":
                        bet = mathUtil.combination(numbers["13"].length, 8);
                        break;
                    case "FO":
                        bet = numbers["16"].length;
                        break;
                    case "FM":
                        bet = numbers["14"].length;
                        break;
                    case "F3":
                        if (numbers["3"] && numbers["2"] && numbers["1"]) {
                            bet = utils2.calculateNoRepeatLots([numbers["3"], numbers["2"], numbers["1"]]);
                        }
                        break;
                    case "FC":
                        bet = mathUtil.combination(numbers["4"].length, 3);
                        break;
                    case "F2":
                        if (numbers["2"] && numbers["1"]) {
                            bet = utils2.calculateNoRepeatLots([numbers["2"], numbers["1"]]);
                        }
                        break;
                    case "FB":
                        bet = mathUtil.combination(numbers["5"].length, 2);
                        break;
                    case "FG":
                        bet = numbers["15"].length;
                        break;
                    case "FF":
                        if (numbers["3"] && numbers["2"] && numbers["1"]) {
                            bet = utils2.sumArrLength([numbers["3"], numbers["2"], numbers["1"]]);
                        }
                        break;
                    default:
                        break;
                }
            }
        } catch (e) {

        }

        var total = bet * unit;

        return {
            bet: bet,
            total: total.toFixed(2)
        }
    },
    //get account name
    getAccountLabel: function(id) {
        return window["label"]["account" + id];
    },
    //get account activity type
    getAccountActivityType: function(id) {
        return window["label"]["accountActivity" + id];
    },
    //convert unit
    convertToBaseUnit: function(type, value) {
        value = utils.parseFloat(value);
        var result = value;

        /*
         1 - 元
         2 - 角
         3 - 分 
         */

        //convert to 元
        switch (type) {
            case "2":
                result = value * 10;
                break;

            case "3":
                result = value * 100;
                break;
        }

        return result;
    },
    //convert to given unit
    convertToUnit: function(type, value) {
        value = utils.parseFloat(value);
        var result = value;

        //convert to 元
        switch (type) {
            case "2":
                result = value * 0.1;
                break;

            case "3":
                result = value * 0.01;
                break;
        }

        return result;
    },
    //alert
    alert: function(input, container,callback) {
        var popLayer = document.getElementById('popLayer');
        var selectLayer = document.getElementById('selectLayer');
        $(".hl-system-popup-text", container).html(input);
        popLayer.style.display = "block";
        selectLayer.style.display = "block";
        $(".hl-system-popup", container).popup("open", {history: false});


        $(".popup-close", container).off("click").click(function () {
            $(".hl-system-popup", container).popup("close");
            popLayer.style.display = "none";
            selectLayer.style.display = "none";
            setTimeout(function () {
                if (callback != null) {
                    callback();
                }
            }, 500);

        });
        /*var popLayer = document.getElementById('popLayer');
        $(".hl-system-popup-text", container).html(input);
        popLayer.style.display = "block";
        $(".hl-system-popup", container).popup("open", {history: false});

        $(".popup-close", container).off("click").click(function() {
            $(".hl-system-popup", container).popup("close");
            popLayer.style.display = "none";
        });*/
    },
    //prompt
    prompt: function(input, container, callback) {
        $(".hl-system-popup-text", container).html(input);
        $(".hl-system-popup", container).popup("open");

        $(".popup-close", container).off("click").click(function() {
            $(".hl-system-popup", container).popup("close");

            setTimeout(function() {
                if (callback != null) {
                    callback();
                }
            }, 500);
        });
    },
    //confirm
    confirm: function(input, container, confirmCallback, cancelCallback) {
        $(".hl-system-confirm-text", container).html(input);
        $(".hl-system-confirm", container).popup("open");

        $(".popup-cancel", container).off("click").click(function() {
            $(".hl-system-confirm", container).popup("close");

            setTimeout(function() {
                if (cancelCallback != null) {
                    cancelCallback();
                }
            }, 500);
        });

        $(".popup-confirm", container).off("click").click(function() {
        $(".hl-system-confirm", container).popup("close");

            setTimeout(function() {
                if (confirmCallback != null) {
                    confirmCallback();
                }
            }, 500);
        });
    },
    //parse float
    parseFloat: function(input) {
        var result = 0;

        if (input.length > 0) {
            result = parseFloat(input);

            if (result == NaN) {
                result = 0;
            }
        }

        return result;
    },
    /*
     bigSmallOddEven: function (bs, oe) {
     if ($.type(bs) != 'array' || $.type(oe) != 'array') {
     return '';
     }
     return label['bs_' + bs[0]] + label['bs_' + bs[1]]
     + ', ' + label['bs_' + bs[0]] + label['oe_' + oe[1]]
     + ', ' + label['oe_' + oe[0]] + label['bs_' + bs[1]]
     + ', ' + label['oe_' + oe[0]] + label['oe_' + oe[1]];
     },
     
     convertLastDrawSummary: function (siteInfo) {
     if ($.type(siteInfo.ls) != 'array' || siteInfo.ls.length == 0) {
     siteInfo.ls = [{ v: '-' }, { v: '-' }, { v: '-' }, { v: '-'}];
     return;
     }
     siteInfo.ls[0].v = label['group_' + siteInfo.ls[0].v];
     siteInfo.ls[3].v = utils.bigSmallOddEven(siteInfo.ls[3].bs, siteInfo.ls[3].oe);
     },
     */

    digits: function(n, p) {
        var t = $.type(n);

        if (($.type(n) != 'number' && $.type(n) != 'string') || n == null || n === 'null') {
            return '';
        }

        return n.toString().toFixed(
                $.type(p) == 'number' ? p : 2
                ).addCommas();
    },
    cny: function(n, p) {
        var t = utils.digits(n, p);
        return t != '' ? label.symbol + t : t;
    },
    hideLoading: function() {
        $.mobile.loading('hide');
    },
    //number only
    isNumberOnly: function(keyCode) {
        var result = false;

        // allow: keyboard 0-9, numpad 0-9, backspace, tab, left arrow, right arrow, delete
        if ((keyCode >= 48 && keyCode <= 57) ||
                (keyCode >= 96 && keyCode <= 105) ||
                keyCode == 8 ||
                keyCode == 9 ||
                keyCode == 37 ||
                keyCode == 39 ||
                keyCode == 46) {
            result = true;
        }

        return result;
    },
    //bet number
    isValidBetNumber: function(keyCode) {
        var result = false;

        // allow: keyboard 0-9, numpad 0-9, backspace, tab, left arrow, right arrow, delete, space, +, . and ,             
        if ((keyCode >= 48 && keyCode <= 57) ||
                (keyCode >= 96 && keyCode <= 105) ||
                keyCode == 8 ||
                keyCode == 9 ||
                keyCode == 37 ||
                keyCode == 39 ||
                keyCode == 46 ||
                keyCode == 32 ||
                keyCode == 190 ||
                keyCode == 107 ||
                keyCode == 188 ||
                keyCode == 17 ||
                keyCode == 86) {
            result = true;
        }

        return result;
    },
    //navigation key
    isNavigationKey: function(keyCode) {
        var result = false;

        // allow: backspace, tab, left arrow, right arrow, delete, space, +, . and ,             
        if (keyCode == 8 ||
                keyCode == 37 ||
                keyCode == 39) {
            result = true;
        }

        return result;
    }, 
    isLegalCode : function(codes,MethodName) {
            var singleNum = 0, isDup = 0, parts=[];
            switch (MethodName) {
                case 'SXZX':    //三星直选 12,34,567
                case "ZSZX":
                case 'QSZX':    //前三直选
                    singleNum = codes[0].length * codes[1].length * codes[2].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXZS':    //三星组三
                case "ZSZS":
                case 'QSZS':
                    singleNum = codes[0].length * (codes[0].length - 1);
                    isDup = singleNum > 2 ? 1 : 0;
                    break;
                case 'SXZL':    //三星组六  1234
                case "ZSZL":
                case 'QSZL':
                    singleNum = codes[0].length * (codes[0].length - 1) * (codes[0].length - 2) / helper.factorial(3);
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXLX':    //三星连选 12345,123,58
                case "ZSLX":
                case 'QSLX':
 

                    var $betNums3 = 0, $betNums2 = 0, $betNums1 = 0;
                    //算注数 后三注数+后二注数+后一注数
                    $betNums3 = codes[0].length * codes[1].length * codes[2].length;
                    $betNums2 = codes[1].length * codes[2].length;
                    $betNums1 = codes[2].length;
                    singleNum = $betNums3 + $betNums2 + $betNums1;
                    isDup = singleNum > 3 ? 1 : 0;
                    break;
                case 'SXBD':    //三星包点 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
                case "ZSBD":
                case 'QSBD':
                    parts = codes[0].split('_');
                    $.each(parts, function(k, v) {
                        singleNum += helper.SXBD[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'SXHHZX':    //三星混合组选 仅支持单式手工录入 12,34,567
                case "ZSHHZX":
                case 'QSHHZX':    //前三混合组选 仅支持单式手工录入 12,34,567
                    singleNum = codes[0].length * codes[1].length * codes[2].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'EXZX':    //二星直选 0123456789,0123456789
                case 'QEZX':
                    singleNum = codes[0].length * codes[1].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'EXZUX':    //二星组选 0123456789
                case 'QEZUX':
                    singleNum = codes[0].length * (codes[0].length - 1) / 2;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'EXLX':    //二星连选 0123456789,0123456789
                case 'QELX':
 

                    //算注数 后二注数+后一注数
                    var $betNums2 = 0, $betNums1 = 0;
                    $betNums2 = codes[0].length * codes[1].length;
                    $betNums1 = codes[1].length;
                    singleNum = $betNums2 + $betNums1;
                    isDup = singleNum > 2 ? 1 : 0;
                    break;
                case 'EXBD':    //二星包点 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
                case 'QEBD':
                    parts = codes[0].split('_');
                    $.each(parts, function(k, v) {
                        singleNum += helper.EXBD[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'YXZX':    //一星直选
                    singleNum = codes[0].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXDW':    //五星定位
                    singleNum = codes[0].length + codes[1].length + codes[2].length + codes[3].length + codes[4].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXDW':    //低频特有 三星定位
                    singleNum = codes[0].length + codes[1].length + codes[2].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'EMBDW':   //三星二码不定位 一注仅限一组号码，如1,2，因为奖金本来就低，也为了判断方便
                case 'QSEMBDW': //低频P3P5特有 前三两码不定位
                case 'EXDXDS':    //二星大小单双 一注仅限一个号码 因为奖金本来就低
                case 'QEDXDS':  //低频3D特有 前二大小单双 一注仅限一个号码 因为奖金本来就低
                    singleNum = codes[0].length * codes[1].length == 1 ? 1 : 0;
                    isDup = 0;
                    break;
                case 'SXDXDS':    //三星大小单双 一注仅限一个号码 因为奖金本来就低
                    singleNum = codes[0].length * codes[1].length * codes[2].length == 1 ? 1 : 0;
                    isDup = 0;
                    break;
                case 'YMBDW':   //三星一码不定位 一注仅限一个号码，如1，因为奖金本来就低，也为了判断方便
                case 'QSYMBDW': //低频P3P5特有 前三一码不定位
                    singleNum = 1;
                    isDup = 0;
                    break;
                case 'SXHZ':    //三星和值 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
                case "ZSHZ":
                case 'QSHZ':
                    parts = codes[0].split('_');
                    $.each(parts, function(k, v) {
                        singleNum += helper.SXHZ[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'EXHZ':    //二星和值 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
                case 'QEHZ':
                    parts = codes[0].split('_');
                    $.each(parts, function(k, v) {
                        singleNum += helper.EXHZ[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'SXZXHZ':  //低频3D特有 组选和值
                case 'QSZXHZ':  //低频P3P5特有 组选和值
                    parts = codes[0].split('_');
                    $.each(parts, function(k, v) {
                        singleNum += helper.SXZXHZ[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'SIXZX':    //四星直选 12,34,567
                case 'QSIZX':    //前四直选
                    singleNum = codes[0].length * codes[1].length * codes[2].length * codes[3].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZX':    //五星直选
                    //算注数 相乘即可
                    singleNum = codes[0].length * codes[1].length * codes[2].length * codes[3].length * codes[4].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXLX':    //五星连选
 

                    var $betNums5 = 0, $betNums3 = 0, $betNums2 = 0, $betNums1 = 0;
                    //算注数 后三注数+后二注数+后一注数
                    $betNums5 = codes[0].length * codes[1].length * codes[2].length * codes[3].length * codes[4].length;
                    $betNums3 = codes[2].length * codes[3].length * codes[4].length;
                    $betNums2 = codes[3].length * codes[4].length;
                    $betNums1 = codes[4].length;
                    singleNum = $betNums5 + $betNums3 + $betNums2 + $betNums1;
                    isDup = singleNum > 4 ? 1 : 0;
                    break;

                    //========== sd11y ===========//
                case 'SDQSZX':  //前三直选 01_02_03_04,02_03,01_05
                    if (codes.length != 3) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var result = helper.expandLotto(codes);
                    singleNum = result.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDQEZX':     //前二直选 二段 01_02_03_04,02_03
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var result = helper.expandLotto(codes);

                    singleNum = result.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDQSZUX':     //前三组选 一段 01_02_03_04
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) / helper.factorial(3);
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDQEZUX':     //前二组选 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) / 2;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX1':     //任选1 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX2':     //任选2 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) / 2;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX3':     //任选3 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) / 6;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX4':     //任选4 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) * (parts.length - 3) / 24;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX5':     //任选5 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) * (parts.length - 3) * (parts.length - 4) / 120;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX6':     //任选6 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) * (parts.length - 3) * (parts.length - 4) * (parts.length - 5) / 720;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX7':     //任选7 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) * (parts.length - 3) * (parts.length - 4) * (parts.length - 5) * (parts.length - 6) / 5040;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDRX8':     //任选8 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length * (parts.length - 1) * (parts.length - 2) * (parts.length - 3) * (parts.length - 4) * (parts.length - 5) * (parts.length - 6) * (parts.length - 7) / 40320;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDQSBDW':     //前3不定位胆 一段 01_02_03_04_05_06_07_08_09_10_11
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SDQSDWD':     //前3定位胆 01_02_03,04_05,06_07为一单 也可以只买一位，如'01_02_03,,'表示只买个位胆，没买的位留空
                    $.each(codes, function(k, v) {
                        if (v != '') {
                            //号码不得重复
                            parts = v.split('_');
                            singleNum += parts.length;  //注意是数组长度，所以前面必须判断v != ''
                        }
                    });
                    isDup = singleNum > 3 ? 1 : 0;
                    break;
                case 'SDDDS':     //0单5双:750.0000元 (1注) 5单0双:125.0000元 (6注)1单4双:25.0000元 (30注)4单1双:10.0000元 (75注)2单3双:5.0000元 (150注)3单2双:3.7000元 (200注)
                case 'SDCZW':     // 一次只能选一注
                    singleNum = 1;
                    isDup = 1;
                    break;
                default:
                    throw "unknown method2";
                    break;
            }

            return {
                singleNum: singleNum,
                isDup: isDup
            };
        }
    
};

/* required for IE6 */
if (!Array.indexOf) {
    Array.prototype.indexOf = function(obj) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == obj) {
                return i;
            }
        }
        return -1;
    }
}

//format number
Number.prototype.toFixed = function(precision) {
    return this.toString().toFixed(precision);
};

//format number
String.prototype.toFixed = function(precision) {
    var numbers = this.split(".");

    if (numbers.length == 1) {
        numbers.push("");
    }

    if (numbers[1].length > precision) {
        numbers[1] = numbers[1].substring(0, precision);
    } else {
        for (; numbers[1].length < precision; ) {
            numbers[1] += "0";
        }
    }

    return numbers[0] + "." + numbers[1];
};

//format number
String.prototype.addCommas = function() {
    x = this.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';

    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;
};

//reference data - use for calculating order summary
var ref_data = {
    sum2: [
        1, // 0 
        2, // 1
        3, // 2
        4, // 3
        5, // 4
        6, // 5
        7, // 6
        8, // 7
        9, // 8
        10, // 9
        9, // 10
        8, // 11
        7, // 12
        6, // 13
        5, // 14
        4, // 15
        3, // 16
        2, // 17
        1	// 18
    ],
    sum22: [
        1, // 0 
        1, // 1
        2, // 2
        2, // 3
        3, // 4
        3, // 5
        4, // 6
        4, // 7
        5, // 8
        5, // 9
        5, // 10
        4, // 11
        4, // 12
        3, // 13
        3, // 14
        2, // 15
        2, // 16
        1, // 17
        1	// 18
    ],
    sum3: [
        1, // 0 
        3, // 1
        6, // 2
        10, // 3
        15, // 4
        21, // 5
        28, // 6
        36, // 7
        45, // 8
        55, // 9
        63, // 10
        69, // 11
        73, // 12
        75, // 13
        75, // 14
        73, // 15
        69, // 16
        63, // 17
        55, // 18
        45, // 19
        36, // 20
        28, // 21
        21, // 22
        15, // 23
        10, // 24
        6, // 25
        3, // 26
        1	// 27
    ],
    sum33: [
        1, // 0 
        1, // 1
        2, // 2
        3, // 3
        4, // 4
        5, // 5
        7, // 6
        8, // 7
        10, // 8
        12, // 9
        13, // 10
        14, // 11
        15, // 12
        15, // 13
        15, // 14
        15, // 15
        14, // 16
        13, // 17
        12, // 18
        10, // 19
        8, // 20
        7, // 21
        5, // 22
        4, // 23
        3, // 24
        2, // 25
        1, // 26
        1	// 27
    ]
};

var utils2 = {
    calculateNoRepeatLots: function(rows) {
        var c = mathUtil.findCombinations(rows);
        if (c.length == 0) {
            return 0;
        }
        var lots = c.length;
        for (var i = 0; i < c.length; i++) {
            if (mathUtil.findRepeat(c[i])) {
                lots--;
            }
        }
        return lots;
    },
    sumArrLength: function(rows) {
        var retval = 0;
        for (var i = 0; i < rows.length; i++) {
            if (rows[i] && rows[i].length && rows[i].length > 0 && rows[i] != "") {
                retval += rows[i].length;
            }
        }
        return retval;
    }
};

var mathUtil = {
    combination: function(n, k) {
        if (k > n) {
            return 0;
        }

        if (k < 0) {
            return 0;
        }

        return this.factorial(n) / (this.factorial(k) * this.factorial(n - k));
    },
    factorial: function(n) {
        if (n < 0) {
            return 1;
        }

        if (n == 0) {
            return 1;
        }

        var result = 1;

        for (var ptr = n; ptr >= 2; ptr--) {
            result *= ptr;
        }

        return result;
    },
    findCombinations: function(array2d) {
        if (array2d.length == 0) {
            return [];
        }

        for (var i = 0; i < array2d.length; i++) {
            if (!(array2d[i] && array2d[i].length && array2d[i].length > 0)) {
                return [];
            }
        }

        return this._findCombinations(array2d, 0, []);
    },
    _findCombinations: function(arr, index, cur) {
        var a = [];

        for (var i = 0; i < arr[index].length; i++) {
            var x = cur.slice(0); // clone this array (w/o changing it)
            x.push(arr[index][i]);

            if (index == arr.length - 1) {
                a.push(x);
            }
            else {
                a = a.concat(this._findCombinations(arr, index + 1, x));
            }
        }

        return a;
    },
    findRepeat: function(arr) {
        for (var i = 0; i < arr.length; i++) {
            for (var j = i + 1; j < arr.length; j++) {
                if (arr[i] == arr[j]) {
                    return true;
                }
            }
        }

        return false;
    }
};