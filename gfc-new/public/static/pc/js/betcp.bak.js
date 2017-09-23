//only for test
if (typeof (console) != "object" && window.status) {
    var console = {
        info: function (a) {
            window.status = a;
        }
    }
}
$.fn.animateBG = function (x, y, speed) {
    var pos = this.css('background-position').split(' ');
//    this.x = pos[0] || 0,
//    this.y = pos[1] || 0;
    this.x = pos[0].split('px')[0] || 0;
    this.y = pos[1].split('px')[0] || 0;
    $.Animation(this, {
        x: x,
        y: y
    }, {
        duration: speed
    }).progress(function (e) {
        this.css('background-position', e.tweens[0].now + 'px ' + e.tweens[1].qenow + 'px');
    });
    return this;
};
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (elt /*, from*/) {
        var len = this.length >>> 0;

        var from = Number(arguments[1]) || 0;
        from = (from < 0)
            ? Math.ceil(from)
            : Math.floor(from);
        if (from < 0)
            from += len;

        for (; from < len; from++) {
            if (from in this &&
                this[from] === elt)
                return from;
        }
        return -1;
    };
}
var runTime = {
    remainTimer: 0,
    waitOpenTimer: 0,
    showCurIssueTimer:0,
    drawIssueTimer:0,
    getLastOpenTimer: 0,
    traceRemainTimer: 0,
    traceWaitOpenTimer: 0,
    clearAll: function () {
        clearInterval(runTime.remainTimer);
        clearInterval(runTime.waitOpenTimer);
        clearInterval(runTime.showCurIssueTimer);
        clearInterval(runTime.drawIssueTimer);
        clearInterval(runTime.getLastOpenTimer);
        // clearInterval(runTime.traceRemainTimer);
        // clearInterval(runTime.traceWaitOpenTimer);
    }
};
(function ($) {
    //$.fx.interval = 100;
    $.bet = function (settings) {
        //检查传过来的参数的正确性
        var verifyParams = function () {
            var flag = 0;

            if (settings.lotteryId == undefined || !is_numeric(settings.lotteryId) || settings.lotteryId <= 0) {
                flag = -1;
            }
            else if (settings.lotteryName == undefined || settings.lotteryName == '') {
                flag = -2;
            }
            else if (settings.lotteryType == undefined || !is_numeric(settings.lotteryType)) {
                flag = -3;
            }
            else if (settings.methods == undefined || !$.isArray(settings.methods) || settings.methods.length == 0) {
                flag = -4;
            }
            else if (settings.openedIssues == undefined || !$.isArray(settings.openedIssues) || settings.openedIssues.length == 0) {
                flag = -5;
            }
            else if (settings.minRebateGaps == undefined || !$.isArray(settings.minRebateGaps) || settings.minRebateGaps.length == 0) {
                flag = -6;
            }
            else if (settings.rebate == undefined || !is_numeric(settings.rebate) || settings.rebate < 0 || settings.rebate > 0.15) {
                flag = -7;
            }
            else if (settings.defaultMode == undefined || !is_numeric(settings.defaultMode) || !$.inArray(settings.defaultMode, [1, 0.1, 0.01]) == -1) {
                flag = -8;
            }
            else if (settings.defaultRebate == undefined || !is_numeric(settings.defaultRebate) || settings.defaultRebate < 0 || settings.defaultRebate > settings.rebate) {
                flag = -9;
            }
            else if (settings.maxCombPrize == undefined || !is_numeric(settings.maxCombPrize) || settings.maxCombPrize <= 0) {
                flag = -10;
            }

            if (flag < 0) {
                console.info('参数错误：flag=' + flag);
            }

            return flag == 0;
        };

        var ps = $.extend({
            //应传过来的设置
            lotteryId: 2,
            lotteryName: 'CQSSC',
            lotteryType: 1, //采种类型
            //startIssueInfo: {issue_id$.extendopenedIssues: '11444', issue:'20130131-080', 'end_time': '2013/01/31 19:14:10', 'input_time': '2013/01/31 19:14:20'},
            methods: [],
            maxCombPrize: 0, //全包奖金
            maxBetTime: 1000, //全包奖金
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
            canTraceIssues: [], //可追号的期号列表
            modeName: {
                '1': '2元',
                '0.1': '2角',
                '0.01': '2分',
                '0.001': '2厘',
                '0.5': '1元',
                '0.05': '1角',
                '0.005': '1分',
                '0.0005': '1厘'
            } //模式名字
        }, settings);

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
            EXZUHZ: {
                1: 1,
                2: 1,
                3: 2,
                4: 2,
                5: 3,
                6: 3,
                7: 4,
                8: 4,
                9: 5,
                10: 4,
                11: 4,
                12: 3,
                13: 3,
                14: 2,
                15: 2,
                16: 1,
                17: 1
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
            pokerNumMaps: {
                A: 1,
                2: 2,
                3: 3,
                4: 4,
                5: 5,
                6: 6,
                7: 7,
                8: 8,
                9: 9,
                T: 10,
                J: 11,
                Q: 12,
                K: 13
            },
            SXZXKD: {
                0: 10,
                1: 54,
                2: 96,
                3: 126,
                4: 144,
                5: 150,
                6: 144,
                7: 126,
                8: 96,
                9: 54
            },
            EXZXKD: {
                0: 10,
                1: 18,
                2: 16,
                3: 14,
                4: 12,
                5: 10,
                6: 8,
                7: 6,
                8: 4,
                9: 2
            },
            factorial: function (n) {
                if (n == 1) {
                    return 1
                } else {
                    return n * helper.factorial(n - 1)
                }
            },
            /**
             * pk10
             * @param {type} $nums
             * @returns {Number}
             */
            countNums: function ($nums, returnType, spliter) {
                if (!spliter) {
                    spliter = '_';
                }
                if (!returnType) {
                    returnType = 1;
                }
                var CombinList = [];
                var oneAreaIsEmpty = 0;
                $.each($nums,
                    function (k, v) {
                        if ($.trim(v) == "") {
                            oneAreaIsEmpty = 1;
                            return false;
                        }
                        if (spliter == 'self') {
                            var tmp = v.split("");
                        }
                        else {
                            var tmp = v.split(spliter);
                        }

                        tmp.sort();
                        CombinList.push(tmp);
                    });


                if (oneAreaIsEmpty) {
                    return 0;
                }
                var $finalResult = 0;
                var Result = new Array();
                var CombineCount = 1;
                for (i in CombinList) {
                    CombineCount *= CombinList[i].length;
                }
                var RepeatTime = CombineCount;
                var lengthNums = CombinList.length;
                for (i in CombinList) {
                    var ClassNo = i;
                    var StudentList = CombinList[i];
                    RepeatTime = RepeatTime / StudentList.length;
                 if(RepeatTime>100000){
                     layer.alert("最大注数不能超过10万注!");
                     $('.ball_Selected').removeClass('ball_Selected');
                     return 0;
                 }
                    var StartPosition = 1;
                    for (j in StudentList) {
                        var TempStartPosition = StartPosition;
                        var SpaceCount = CombineCount / StudentList.length / RepeatTime;
                        for (var J = 1; J <= SpaceCount; J++) {
                            for (var I = 0; I < RepeatTime; I++) {
                                if (typeof (Result[TempStartPosition + I]) == 'undefined') {
                                    Result[TempStartPosition + I] = '';
                                }

                                if (Result[TempStartPosition + I] == -1) {//have one
                                    continue;
                                }
                                else if (Result[TempStartPosition + I].indexOf(StudentList[j]) != -1) {//have one
                                    Result[TempStartPosition + I] = -1;
                                    continue;
                                }
                                else {
                                    Result[TempStartPosition + I] += '_' + StudentList[j];

                                    if (parseInt(ClassNo) + 1 == lengthNums) {
                                        $finalResult++;
                                        if ($finalResult > 10000) {
                                            layer.alert("最大注数不能超过10万注!");
                                            $('.ball_Selected').removeClass('ball_Selected');
                                            return 0;
                                        }
                                    }
                                }
                            }
                            TempStartPosition += RepeatTime * StudentList.length;
                        }
                        StartPosition += RepeatTime;
                    }
                }
                if (returnType == 1) {
                    Result = null;
                    return $finalResult;
                }
                else {
                    var resultArr = [];
                    for (var i = 0; i < Result.length; i++) {
                        if (Result[i] && Result[i] != -1) {
                            var tmp = Result[i].substr(1).split('_');
                            tmp.sort();
                            tmp = tmp.join('_')
                            if (resultArr.indexOf(tmp) == -1) {
                                resultArr.push(tmp);
                            }

                        }
                    }
                    return resultArr;
                }
            },
            combin: function ($nums) {
                var CombinList = [];
                var oneAreaIsEmpty = 0;
                $.each($nums,
                    function (k, v) {
                        if ($.trim(v) == "") {
                            oneAreaIsEmpty = 1;
                            return;
                        }
                        var tmp = v.split("_");
                        tmp.sort();
                        CombinList.push(tmp);
                    });
                if (oneAreaIsEmpty) {
                    return [];
                }


                var Result = new Array();
                var CombineCount = 1;
                for (i in CombinList) {
                    CombineCount *= CombinList[i].length;
                }
                var RepeatTime = CombineCount;
                for (i in CombinList) {
                    var ClassNo = i;
                    var StudentList = CombinList[i];
                    RepeatTime = RepeatTime / StudentList.length;
                    var StartPosition = 1;
                    for (j in StudentList) {
                        var TempStartPosition = StartPosition;
                        var SpaceCount = CombineCount / StudentList.length / RepeatTime;
                        for (var J = 1; J <= SpaceCount; J++) {
                            for (var I = 0; I < RepeatTime; I++) {
                                if (typeof (Result[TempStartPosition + I]) == 'undefined') {
                                    Result[TempStartPosition + I] = new Array();
                                }
                                Result[TempStartPosition + I][ClassNo] = StudentList[j];
                            }
                            TempStartPosition += RepeatTime * StudentList.length;
                        }
                        StartPosition += RepeatTime;
                    }
                }

                var $finalResult = [];
                $.each(Result,
                    function (k, v) {
                        if (typeof (v) != 'undefined') {
                            var tmp = array_unique(v);
                            if (tmp.length == v.length) {
                                $finalResult.push(v)
                            }
                        }


                    });
                return $finalResult;
            },
            expandLotto: function ($nums) {
                var result = [];
                var tempVars = [];
                var oneAreaIsEmpty = 0;
                $.each($nums,
                    function (k, v) {
                        if ($.trim(v) == "") {
                            oneAreaIsEmpty = 1;
                            return;
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
                    function (k, v) {
                        var $parts = v.split(" ");
                        var tmp = array_unique($parts);
                        if (tmp.length == $parts.length) {
                            $finalResult.push(v)
                        }
                    });
                return $finalResult;
            }
        };

        var initModesBar = function () {
            var tmpMode = 1;
            var mod = parseFloat(getCookie("mod_" + ps.lotteryId));
            $.each([1, 0.5, 0.1, 0.01],
                function (k, v) {
                    if (v == mod) {
                        tmpMode = v;
                    }
                });
            ps.curMode = tmpMode;
            //$('<option value="1">元</option><option value="0.1">角</option><option value="0.01">分</option>').prependTo("#modesDIV");
            $("#modesDIV").change(modesBar.modesBtn_Click);
            $("#modesDIV").val(ps.curMode);
            $(".modesDIV").click(modesBar.modes_Click);
            $('.modesDIV[val="' + ps.curMode + '"]').click();

        };
        var modesBar = {
            modes_Click: function () {
                $(".modesDIV").removeClass('modesDIVselect');
                $(this).addClass('modesDIVselect');
                $("#modesDIV").val($(this).attr('val'));
                $("#modesDIV").change();
            },
            //点击模式按钮事件
            modesBtn_Click: function () {
                var curModeSpan = $("#modesDIV").val();
                //更新当前选择的模式
                ps.curMode = curModeSpan;
                //console.info("您选择了 " + $(this).find(':visible').text() + "模式,ps.curMode="+ps.curMode);
                //加上选择样式
                //curModeSpan.parent().children().removeClass('colorRed').filter('[mode=' + ps.curMode + ']').addClass('colorRed');
                //重置所有小球为未选择的状态
                //ballBar.reset();
                //保存所选模式
                modesBar.saveLastModes();
                prizeBar.showPirze();   //每点一下应更新对应的玩法
                if ($('#projectList').children('li').length > 0) {
                    //重新计算投注区金额
                    buyBar.updateTotalSingle();
                    layer.msg('您现有投注金额已经更新!', 1, 9);
                }

            },
            saveLastModes: function () {  //目前是保存到cookie里面
                setCookie('mod_' + ps.lotteryId, ps.curMode, 30 * 86400);
            }
        };

        //1.2 滑动奖金栏
        var initPrizeBar = function () {
            ps.rebateGapList = prizeBar.generateGapList();
            ps.curPrizeIndex = ps.rebateGapList.length - 1;
//            var reb = getCookie("reb_" + ps.lotteryId);
//            $.each(ps.rebateGapList,
//                    function (k, v) {
//                        if (reb == v.rebate) {
//                            ps.curPrizeIndex = k
//                        }
//                    });
//            if (ps.curPrizeIndex == undefined) {
//                ps.halt("initPrizeBar failed")
//            }
// $("#addPrizeBtn").bind("click", prizeBar.plusPrize);
// $("#subPrizeBtn").bind("click", prizeBar.minusPrize);
            prizeBar.showPirze();
            $('#curPrizeSpan').change(prizeBar.changePrize);
        };


        var RxPos = {
            rsMethods: ['REZXHZ', 'REZUX', 'REZUXHZ', 'RSZU6', 'RSZXHZ', 'RSZU3', 'RSZUXHZ', 'RSHHZX', 'R4ZUX24', 'R4ZUX12', 'R4ZUX6', 'R4ZUX4', 'R4ZX'],
            changeRxPos: function () {
                ballBar.computeSingle();
                RxPos.saveLastRxPos();
            },
            //保存当前奖金设置
            saveLastRxPos: function () {
                // setCookie("RxPos_" + ps.lotteryId, , 30 * 86400);
            },
            getNumRxPos: function (needed) {

                var posCheckedLen = $('.posChoose:checked').size();
                if (posCheckedLen < needed) {
                    return 0;
                }
                var zsNum = 1;
                for (var i = posCheckedLen; i > (posCheckedLen - needed); i--) {
                    zsNum = zsNum * i;
                }
                var zsNum = zsNum / helper.factorial(needed);
                zsNum = zsNum > 0 ? zsNum : 0;
                return zsNum;
            }


        };

        //1.2 滑动奖金栏
        var initRxPos = function () {

            if (RxPos.rsMethods.indexOf(ps.curMethod.name) != -1) {

                var htmlstr = '<div id="poschoose"><span class="methodgroupname">选择位置:</span><label><input type="checkbox"  class="posChoose" value="万">万位</label><label><input type="checkbox"  class="posChoose" value="千">千位</label><label><input type="checkbox"  class="posChoose" value="百">百位</label><label><input type="checkbox"  class="posChoose" value="十">十位</label><label><input type="checkbox"  class="posChoose" value="个">个位</label></div>';
                $('#rxpos').empty().show().append(htmlstr);
                $('.posChoose').change(RxPos.changeRxPos);

                if (ps.curMethod.cname.indexOf('任二') == 0) {

                    $('.posChoose').get(3).checked = true;
                    $('.posChoose').get(4).checked = true;
                }
                else if (ps.curMethod.cname.indexOf('任三') == 0) {

                    $('.posChoose').get(2).checked = true;
                    $('.posChoose').get(3).checked = true;
                    $('.posChoose').get(4).checked = true;
                }
                else if (ps.curMethod.cname.indexOf('任四') == 0) {
                    if (ps.curMethod.name == 'R4ZX') {
                        $('#rxpos').hide();
                    }
                    $('.posChoose').get(1).checked = true;
                    $('.posChoose').get(2).checked = true;
                    $('.posChoose').get(3).checked = true;
                    $('.posChoose').get(4).checked = true;
                }

            }
            else {
                $('#rxpos').hide();

            }


        };


        //奖金滑动事件处理
        var prizeBar = {
            changePrize: function () {
                if (!$("#curPrizeSpan").val()) {
                    return;
                }
                ps.curPrizeIndex = $("#curPrizeSpan").val();
                //显示当前的最高 奖金
                // console.log(ps.rebateGapList);
                // console.log(ps.curPrizeIndex);
                var selectPrize = prizeBar.computeFinalPrizePrize(ps.curMethod.prizes, ps.rebateGapList[ps.curPrizeIndex].rebate);
                $("#curPrizeSpanShower").text(selectPrize);
                prizeBar.saveLastPrize();
            },
            generateGapList: function () {
                var result = [];
                $.each(ps.minRebateGaps,
                    function (k, v) {
                        v.from = parseFloat(v.from);
                        v.to = parseFloat(v.to);
                        v.gap = parseFloat(v.gap);
                        if (ps.rebate > v.to) {
                            for (var i = v.from; i <= v.to; i += v.gap) {
                                result.push(parseFloat(number_format(i, 3)));
                            }
                        } else {
                            for (i = v.from; i < v.to && i < ps.rebate; i += v.gap) {
                                result.push(parseFloat(number_format(i, 3)))
                            }
                            result.push(parseFloat(number_format(ps.rebate, 3)));
                        }
                    });
                result = array_unique(result);
                var result2 = [];
                $.each(result,
                    function (k, v) {
                        var prize = round(ps.maxCombPrize * (ps.prizeRate + v), 0);
                        result2.push({
                            rebate: round(ps.rebate - v, 3),
                            prize: prize
                        });
                    });
                return result2;
            },
            computeFinalPrizePrize: function (prize, rebate) {
                var selectPrize = round(prize, 2);
                if (ps.curMethod.name == 'YMBDW' && selectPrize > 6.61) {
                    selectPrize = 6.61;
                }
                selectPrize = round(ps.curMode * selectPrize, 2);

                return selectPrize;
            },
            //显示当前奖金
            showPirze: function () {
                $('#curPrizeSpan').empty();
                $.each(ps.rebateGapList,
                    function (k, v) {
                        var selectPrize = prizeBar.computeFinalPrizePrize(ps.curMethod.prize, ps.rebateGapList[k].rebate);
                                             // if (ps.curMethod.prizes) {
                        //     if (propLen(ps.curMethod.prizes) > 1) {
                        //         var priceNum = 1;
                        //         var prizeDesc = '';
                        //         for (var i in ps.curMethod.prizes) {
                        //             if (prizeDesc != '') {
                        //                 prizeDesc += ',';
                        //             }
                        //             console.log(ps.curMethod.prizes);
                        //             prizeDesc += priceNum + '等奖<em>' + prizeBar.computeFinalPrizePrize(ps.curMethod.prizes, ps.rebateGapList[k].rebate) + '</em>元 ';
                        //             priceNum++;
                        //         }
                        //         $("#prizeDesc").html(prizeDesc + '。');
                        //     }
                        //     else {
                        //         var prizeDesc = '奖金<em>' + selectPrize + '</em>元';
                        //         $("#prizeDesc").html(prizeDesc + '。');
                        //     }
                        // }
                        var selectRebate = number_format(parseFloat(ps.rebateGapList[k].rebate) * 100, 1);
                        //显示当前的最高 奖金
                        if (ps.curPrizeIndex == k) {
                            $("#curPrizeSpanShower").text(selectPrize);
                        }
                        //$('#curPrizeSpan').append('<option value="' + k + '">' + selectPrize + '/' + selectRebate + '</option>');
                    });
                $("#curPrizeSpan").val(ps.curPrizeIndex);
                prizeBar.changePrize();

                //var realPrize = round(ps.curMode * ps.curMethod.prize * (ps.prizeRate + ps.rebate - ps.rebateGapList[ps.curPrizeIndex].rebate) / ps.prizeRate, 2);
                //$("#curPrizeSpan").text(realPrize + "/" + number_format(parseFloat(ps.rebateGapList[ps.curPrizeIndex].rebate) * 100, 1));
            },
            //保存当前奖金设置
            saveLastPrize: function () {
                setCookie("reb_" + ps.lotteryId, ps.rebateGapList[ps.curPrizeIndex].rebate, 30 * 86400);
            }
        };

        //3.玩法相关
        var initMethodBar = function () {
            var classpos = 1;
            $.each(ps.methods,
                function (i, n) {
                    classpos = i + 1;
                    var li = $('<li class="methodGroupLI even_xz_nav_li' + classpos + '" id="methodGroup_' + i + '"><a href="javascript:;" class="nav_btn' + classpos + ' nav_sp">' + n.mg_name + "</a></li>");
                    var ul = $('<ul id="method_' + i + '"></ul>').addClass('even_xz_nav_menu_box' + classpos).addClass('even_xz_nav_menu_box_div_btn').hide();

                    if (classpos >= 6) {
                        $('<li class="meun_jt' + classpos + '"></li>').appendTo(ul);
                    }
                    else {
                        $('<li class="meun_jt"></li>').appendTo(ul);
                    }
                    $.each(n.childs,
                        function (ii, nn) {
                            $('<li class="method" name="' + nn.name + '" id="method_' + i + "_" + ii + '"><a href="javascript:;">' + nn.cname + "</a></li>").appendTo(ul);
                        });

                    $('#evenXzNav').append(li);
                    $("#methodGroup_" + i).click(methodBar.methodGroup_Click);
                    $("#methodGroup_" + i).append(ul);
                    $("#methodGroup_" + i).lazyhover(methodBar.methodGroup_hoverOver, methodBar.methodGroup_hoverOut, 100, 200);
                });
            $('#evenXzNav .method').click(methodBar.method_Click);

            for (var i = (classpos + 1); i < 12; i++) {
                $('<li class="methodGroupLI even_xz_nav_li' + i + '" ><a href="javascript:;" class="nav_btn' + i + ' nav_sp"></a></li>').appendTo("#evenXzNav");
            }

            methodBar.selectDefault();
            function machineRun(maxNum) {
                if (ps.curMethod.field_def) {
                    var max_selecteds = [];
                    var max_selected_all = 1;
                    var isMutilCode = false;
                    var fieldNum = 0;
                    for (var i in ps.curMethod.field_def) {
                        fieldNum++;
                        var tmp2 = ps.curMethod.field_def[i].nums.split(" ");
                        for (var j in tmp2) {
                            if (tmp2[j].length > 1) {
                                isMutilCode = true;
                            }
                        }
                        if (ps.curMethod.field_def[i].max_selected) {
                            max_selecteds.push(parseInt(ps.curMethod.field_def[i].max_selected));
                            if (parseInt(ps.curMethod.field_def[i].max_selected) > max_selected_all) {
                                max_selected_all = parseInt(ps.curMethod.field_def[i].max_selected);
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
                            for (var i in ps.curMethod.field_def) {

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
                                var tmp2 = ps.curMethod.field_def[i].nums.split(" ");
                                var arrIndex = Math.floor(Math.random() * tmp2.length);

                                var _maxTryRandom = 20;
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

                                var ob = isLegalCode(codes);

                                if (ob.singleNum >= 1) {
                                    isBreak = true;
                                    break;
                                }
                            }
                            if (isBreak) {
                                break;
                            }
                        }
                        var ob = isLegalCode(codes);
                        if (ob.singleNum >= 1) {
                            var resultCode = ballBar.getBetCode(codes);
                            ob.code = resultCode;
                            ps.nextProjectCounter++;
                            var singleAmount = number_format(ob.singleNum * 2 * ps.curMode, 2);
                            $('<li><span class="num_try_text_list_s1"  mid="' + ps.curMethod.method_id + '">' + ps.nextProjectCounter + "." + ps.curMethod.cname + '</span><span class="num_try_text_list_s2">' + ob.code + '</span><span class="num_try_text_list_s3">' + ob.singleNum + '注</span><span class="num_try_text_list_s4">￥' + singleAmount + '</span><a href="javascript:;" class="btn_delete">删除</a></li>').appendTo("#projectList");
                            buyBar.updateTotalSingle();
                            break;
                        }
                        trytimes++;
                    }
                }
                maxNum--;
                if (maxNum > 0) {
                    machineRun(maxNum);
                }
            }

            $("#machineChoice1").click(function () {
                machineRun(1);
            });

            $("#machineChoice5").click(function () {
                machineRun(5);
            });
        };

        //玩法组及玩法菜单事件处理
        var methodBar = {
            methodGroup_Click: function (e) {
                $('.nav_btn_selected').removeClass("nav_btn_selected");
                $('a', this).first().addClass("nav_btn_selected");
                if ($(this).text().indexOf('外围玩法') != -1) {
                    setCookie("default_method_" + ps.lotteryId, $(this).attr('id'), 30 * 86400);
                    //官方玩法 非官方玩法切换
                    $('.official_game:visible').hide();
                    $('.non_official_game:hidden').show();
                    while (true) {
                        if (typeof $.bet.initWaiWei != 'undefined' && $.bet.initWaiWei) {
                            $.bet.initWaiWei(ps);
                            break;
                        }
                    }
                }
                else {
                    //官方玩法 非官方玩法切换
                    $('.non_official_game:visible').hide();
                    $('.official_game:hidden').show();
                    //保证子元素不再 激发这个事件
                    if ($(e.target).is('li') || $(e.target).hasClass('nav_btn_selected')) {
                        methodBar.methodClickHandle($('.method', this).first());
                    }
                }
            },
            methodGroup_hoverOver: function () {
                $(this).addClass("methodGroup_hover");
                if ($(this).text().indexOf('外围玩法') != -1) {

                }
                else {
                    $(this).find('ul').show();
                }


            },
            methodGroup_hoverOut: function () {

                $(this).removeClass("methodGroup_hover");
                $(this).find('ul').hide();
            },
            method_hoverOver: function () {

            },
            method_hoverOut: function () {
                $(this).removeClass("method_hover");
                /\w+_(\d+)/.test($(this).attr("id"));
                var index = RegExp.$1;
                $(this).find('ul').hide();
            },
            method_Click: function () {
                methodBar.methodClickHandle(this);
            },
            methodClickHandle: function (_this) {
                var id = $(_this).attr('id');
                id = id.toString().split('_');
                ps.curMethod = ps.methods[id[1]].childs[id[2]];
                //设置当前玩法前景色以示区别
                $('#evenXzNav').find('.method').removeClass("method_selected");
                $(_this).addClass("method_selected");
                setCookie("default_method_" + ps.lotteryId, $(_this).attr('name'), 30 * 86400);

                $('#curMethod').text(ps.curMethod.cname);
                //玩法提示文字
                var desc = ps.curMethod.description;
                if (desc.length > 100) {
                    desc = desc.substring(0, 100) + '...';
                }
                $("#methodDesc").text(desc).show();
                //详细介绍玩法

                //备注tips
                $("#methodTipInfo").hover(function () {
                    var t = layer.tips(ps.curMethod.description, $("#methodTipInfo"), {
                        tips: 3,
                        guide: 1,
                        style: ['background-color:#F26C4F; color:#fff', '#F26C4F'],
                        maxWidth: 250,
                        time: 90,
                        closeBtn: [0, false]
                    });
                }, function () {
                    $(".xubox_layer").hide();
                });
//                $('#methodTipInfo').hover(function() {
//                    $("#methodDesc").show();
//                }, function() {
//                    $("#methodDesc").hide();
//                });

                //显示手工输入
                $('#delTA').hide();
                $('#manTip').hide();
                if (ps.curMethod.can_input == 1) {
                    $("#inputBtn").show();
                } else {
                    $("#inputBtn").hide();
                }
                ballBar.generateBall();
                //$("input[name=missHotBtn]:checked").click();
                $("#inputBtn").addClass('btn_zthm');

                $("#singleInfo").show();
                buyBar.updateSingle(0);
                prizeBar.showPirze();
                if (propLen(ps.curMethod.field_def) == 0) {
                    ballBar.showInput();
                    $("#singleInfo").hide();
//                    $(".machineChoice").hide();
                    $(".machineChoice").attr('disabled', 'disabled');
                    $(".machineChoice").removeClass("CantapCodeBtn_selected");
//                    $("#delTA").click(function() {
//                        $("#inputTA").val("");
//                    });
                    $("#selectArea").removeClass("N-selected");
                }
                else {

                }
            },
            selectDefault: function () {
                var medthod = getCookie("default_method_" + ps.lotteryId);
                if (!medthod) {
                    $($("#evenXzNav li a").get(0)).click();
                }
                else {
                    if ($('#' + medthod).length > 0) {
                        $('#' + medthod).click();
                    }
                    else {
                        $('.nav_btn_selected').removeClass("nav_btn_selected");
                        $('a', $('#evenXzNav').find('.method[name="' + medthod + '"]').parent().parent()).first().addClass("nav_btn_selected");
                        methodBar.methodClickHandle($('#evenXzNav').find('.method[name="' + medthod + '"]'));
                    }
                }

            }
        };
        //3.1投注球事件处理 ball_Selected为选中后的样式
        var ballBar = {
            reset: function () {
                if ($.isEmptyObject(ps.curMethod.field_def)) {
                    return;
                }
                $.each(ps.curMethod.field_def, function (i, prop) {
                    $('#field_' + i).children().removeClass('ball_Selected');
                });
                buyBar.updateSingle(0);
            },
            showInput: function () {
                $("#selectArea").children().remove();
                $("#delTA").show();
                $("#manTip").show();
                var str = '<div class="zeng_zthm" id="zthmBox"><p class="zeng_zthm_p1">选号须知：</p><ul class="zeng_zthm_ul"><li>1. 仅支持单式，多注号码粘贴格式示例：以组三为例122 233 344分别是三注号码。</li><li>2. 每注号码之间用空格或者换行符（11选5）隔开。</li><li>3. 中英文、符号等非法字符，系统将自动滤除。</li></ul><textarea cols="" rows="" class="zthm_text" id="inputTA"></textarea><a href="javascript:void(0)"  id="delTA" class="zthm_qk btn_sp" title="清空输入框"></a></div>';
                $(str).appendTo("#selectArea");
                $("#delTA").click(function () {
                    $("#inputTA").val("");
                    //$("#selectCodeBtn").removeClass("selectCodeBtn_selected");
                });
                $("#inputTA").keyup(function () {
                    if ($("#inputTA").val() != '') {
                        $("#selectCodeBtn").addClass('selectCodeBtn_selected');
                    }
                });
            },
            //显示投注球
            generateBall: function () {
                initRxPos();//显示投注位置
                $("#selectArea").children().remove();
//                          <div class="xz_list1">
//                            <div class="xz_list1_left">
//                                <p class="xz_list1_ww btn_sp">万&nbsp;位</p>
//                                <p class="xz_list1_yl">当前遗漏</p>
//                            </div>
//                            <ul class="xz_list1_right">
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num_h btn_sp">0</a>
//                                    <span class="xz_list1_right_s1">35</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">1</a>
//                                    <span class="xz_list1_right_s2">05</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">2</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">3</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">4</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">5</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">6</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">7</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">8</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                                <li>
//                                    <a href="javascript:;" class="xz_list1_right_num btn_sp">9</a>
//                                    <span class="xz_list1_right_s2">45</span>
//                                </li>
//                            </ul>
//                            <div class="bigSmall btn_sp">
//                                <a href="javascript:;" class="bigSmall_btn_h btn_sp">全</a>
//                                <a href="javascript:;" class="bigSmall_btn btn_sp">大</a>
//                                <a href="javascript:;" class="bigSmall_btn btn_sp">小</a>
//                                <a href="javascript:;" class="bigSmall_btn btn_sp">奇</a>
//                                <a href="javascript:;" class="bigSmall_btn btn_sp">偶</a>
//                                <a href="javascript:;" class="bigSmall_btn btn_sp">清</a>
//                            </div>
//                        </div>
//


                var filterBtn = '<div class="bigSmall btn_sp QuickChoose"><a href="javascript:;" class="bigSmall_btn btn_sp">全</a><a href="javascript:;" class="bigSmall_btn btn_sp">大</a><a href="javascript:;" class="bigSmall_btn btn_sp">小</a><a href="javascript:;" class="bigSmall_btn btn_sp">单</a><a href="javascript:;" class="bigSmall_btn btn_sp">双</a><a href="javascript:;" class="bigSmall_btn btn_sp">清</a></div>';
                $.each(ps.curMethod.field_def, function (i, prop) {  //注：i从1开始
                    var numList = prop.nums.split(" ");
                    var ballStr = '', hzbdStr = "";
                    $.each(numList, function (ii, nn) {
                        switch (ps.curMethod.name) {
                            case "SXBD":
                            case "ZSBD":
                            case "QSBD":
                                ballStr += '<li><a href="javascript:;" class="xz_list1_right_num btn_sp">' + nn + '</a></li>';    //<span class="HZBD">' + helper.SXBD[ii] + "</span>"
                                hzbdStr += '<span class="xz_list1_right_s2">' + helper.SXBD[ii] + '</span>';
                                break;
                            case "SXHZ":
                            case "ZSHZ":
                            case "QSHZ":
                                ballStr += '<li><a href="javascript:;" class="xz_list1_right_num btn_sp">' + nn + '</a></li>';
                                hzbdStr += '<span class="xz_list1_right_s2">' + helper.SXHZ[ii] + '</span>';
                                break;
                            case "EXBD":
                            case "QEBD":
                                ballStr += '<li><a href="javascript:;" class="xz_list1_right_num btn_sp">' + nn + '</a></li>';
                                hzbdStr += '<span class="xz_list1_right_s2">' + helper.EXBD[ii] + '</span>';
                                break;
                            case "EXHZ":
                            case "QEHZ":
                                ballStr += '<li><a href="javascript:;" class="xz_list1_right_num btn_sp">' + nn + '</a></li>';
                                hzbdStr += '<span class="xz_list1_right_s2">' + helper.EXHZ[ii] + '</span>';
                                break;
                            case 'SXZXHZ':
                            case 'QSZXHZ':
                                ballStr += '<li><a href="javascript:;" class="xz_list1_right_num btn_sp">' + nn + '</a></li>';
                                hzbdStr += '<span class="xz_list1_right_s2">' + helper.SXZXHZ[ii + 1] + '</span>';
                                break;
                            case 'PKSZ':    //扑克.顺子
                            case 'PKBZ':    //扑克.豹子
                                var tmp = nn.split("");
                                ballStr += '<li><div><span><i>' + tmp[0] + '</i></span><span class="p2"><i>' + tmp[1] + '</i></span><span class="cover"><i>' + tmp[2] + '</i><em></em></span><i class="gou"></i></div></li>';
                                break;
                            default:
                                ballStr += '<li><a href="javascript:;" class="xz_list1_right_num btn_sp">' + nn + "</a></li>";
                                break;
                        }
                    });

                    var ballListName = 'ballList';
                    if (ps.lotteryType == 6) {
                        ballListName = 'ballList_k3no_square';
                        if (ps.curMethod.name == 'JSSTTX' || ps.curMethod.name == 'JSSLTX') {
                            ballListName = 'ballList_k3no_sttx';
                        }
                        else if ((ps.curMethod.name == 'JSHZ')) {
                            ballListName = 'ballList_square';

                        }
                    }
                    else if (ps.lotteryType == 7) {
                        ballListName = 'poker3';
                    }
                    else if (ps.curMethod.name == 'SDDDS') {
                        ballListName = 'ballList_k3no_square';
                    }

                    ballStr = '<ul class="xz_list1_right ' + ballListName + (/(BD|HZ)$/.test(ps.curMethod.name) ? " w400" : "") + '" id=field_' + i + ">" + ballStr + "</ul>";


                    var specialClass = "";
                    if (/(DXDS)$/.test(ps.curMethod.name)) {
                        specialClass = ' DXDS-margin-left';
                    }
                    else if (/(SDDDS)$/.test(ps.curMethod.name)) {
                        specialClass = ' SDDDS-margin-left';
                    }
                    else if (/(SDCZW)$/.test(ps.curMethod.name)) {
                        specialClass = ' SDCZW-margin-left';
                    }
                    if (ps.lotteryType == 6 && (ps.curMethod.name == 'JSSTTX' || ps.curMethod.name == 'JSSLTX')) {
                        $('<div class="locate xz_list1" id="locate_' + i + '">' + ballStr + "</div>").appendTo("#selectArea");
                    }
                    else {

                        $('<div class="locate xz_list1" id="locate_' + i + '"><div class=" xz_list1_left lotteryNumber' + specialClass + '">' + (prop.prompt ? '<p class="xz_list1_ww btn_sp areaPrefix">' + prop.prompt + ":" + "</p>" : "") + '</div>' + ballStr + "</div>").appendTo("#selectArea");
                    }

                    //特殊处理和值包点
                    if (/(BD|HZ)$/.test(ps.curMethod.name) && ps.curMethod.name != 'JSHZ') {
                        $('#locate_' + i + ' .xz_list1_left').append('<p class="xz_list1_yl">包含注数</p>');
                        var hzbdStr = '';
                        $.each(numList, function (ii, nn) {
                            switch (ps.curMethod.name) {
                                case "SXBD":
                                case "ZSBD":
                                case "QSBD":
                                    hzbdStr = '<span class="xz_list1_right_s2">' + helper.SXBD[ii] + '</span>';
                                    break;
                                case "SXHZ":
                                case "ZSHZ":
                                case "QSHZ":
                                    hzbdStr = '<span class="xz_list1_right_s2">' + helper.SXHZ[ii] + '</span>';
                                    break;
                                case "EXBD":
                                case "QEBD":
                                    hzbdStr = '<span class="xz_list1_right_s2">' + helper.EXBD[ii] + '</span>';
                                    break;
                                case "EXHZ":
                                case "QEHZ":
                                    hzbdStr = '<span class="xz_list1_right_s2">' + helper.EXHZ[ii] + '</span>';
                                    break;
                                case 'SXZXHZ':
                                case 'QSZXHZ':
                                    hzbdStr = '<span class="xz_list1_right_s2">' + helper.SXZXHZ[ii + 1] + '</span>';
                                    break;
                                default:

                                    break;
                            }
                            $($('#locate_' + i + ' li').get(ii)).append(hzbdStr);

                        });
                    }


                    //处理是否有筛选功能
                    if (prop.has_filter_btn) {
                        $("#locate_" + i).append(filterBtn);
                        if (ps.curMethod.name == "EXZUX" || ps.curMethod.name == "QEZUX") {
//                            $("#locate_" + i).find(".navSub :first").text(" ");
//                            $("#locate_" + i).find(".navSub :last").text(" ");
                            $("#locate_" + i).find(".QuickChoose").hide();
                        }
                        $("#locate_" + i).find(".QuickChoose a").click(function () {
                            switch ($(this).text()) {
                                case '全':
                                    $('#field_' + i + ' li a').removeClass('ball_Selected').addClass('ball_Selected');
                                    break;
                                case '单':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i + ' li a').removeClass('ball_Selected');
                                        $('#field_' + i + ' li a:odd').addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2 || ps.lotteryType == 8) {

                                        $('#field_' + i + ' li a').removeClass('ball_Selected');
                                        $('#field_' + i + ' li a:even').addClass('ball_Selected');
                                    }
                                    break;
                                case '双':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i + ' li a').removeClass('ball_Selected');
                                        $('#field_' + i + ' li a:even').addClass('ball_Selected');

                                    } else if (ps.lotteryType == 2 || ps.lotteryType == 8) {
                                        $('#field_' + i + ' li a').removeClass('ball_Selected');
                                        $('#field_' + i + ' li a:odd').addClass('ball_Selected');
                                    }
                                    break;
                                case '大':
                                    $('#field_' + i + ' li a').removeClass('ball_Selected').filter(function (idx) {
                                        return idx >= 5;
                                    }).addClass('ball_Selected');
                                    break;
                                case '小':
                                    $('#field_' + i + ' li a').removeClass('ball_Selected').filter(function (idx) {
                                        return idx < 5;
                                    }).addClass('ball_Selected');
                                    break;
                                case '清':
                                    $('#field_' + i + ' li a').removeClass('ball_Selected');
                                    break;
                                case '质':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function (idx) {
                                            return $.inArray(idx, [2, 3, 5, 7]) != -1;
                                        }).addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function (idx) {
                                            return $.inArray(idx, [1, 2, 4, 6, 10]) != -1;
                                        }).addClass('ball_Selected');
                                    }
                                    break;
                                case '合':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function (idx) {
                                            return $.inArray(idx, [4, 6, 8, 9]) != -1;
                                        }).addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function (idx) {
                                            return $.inArray(idx, [3, 5, 7, 8, 9]) != -1;
                                        }).addClass('ball_Selected');
                                    }
                                    break;
                                case '反':
                                    $('#field_' + i).children().toggleClass('ball_Selected');
                                    break;
                            }
                            ballBar.computeSingle();
                        });
                    }


                    //暂不显示遗漏冷热
                    //var result = ballBar.getAssisInfo(i);
                    var result = [];
                    if (result.length > 0) {
                        $.each(result, function (i, n) {
                            $(n).appendTo('#selectArea');
                        });
                    }
                });

                $('.locate ul li a').off('click').bind("click", ballBar.ball_Click);


            },
            //是否显示遗漏冷热
            getAssisInfo: function (field_def_idx) {
                var str = "", result = [];
                if (!$.isArray(ps.missHot.miss) || !$.isArray(ps.missHot.hot)) {
                    return [];
                }
                var idx = -1;
                switch (ps.curMethod.name) {
                    case "QSZX":
                    case "QSLX":
                    case "QEZX":
                    case "QELX":
                    case "QSIZX":
                    case "WXZX":
                    case "WXLX":
                    case "WXDW":
                    case 'SXDW':
                    case "SDQSZX":
                    case "SDQEZX":
                        idx = field_def_idx - 1 + 0;
                        break;
                    case "SIXZX":
                    case "ZSZX":
                    case "ZSLX":
                        idx = field_def_idx - 1 + 1;
                        break;
                    case "SXZX":
                    case "SXLX":
                        idx = field_def_idx - 1 + 2;
                        break;
                    case "EXZX":
                    case "EXLX":
                        idx = field_def_idx - 1 + 3;
                        break;
                    case "YXZX":
                        idx = field_def_idx - 1 + 4;
                        break;
                }
                if (idx > -1) {
                    $.each(ps.missHot.miss[idx],
                        function (i, n) {
                            str += '<li class="yiLouNum">' + n + "</li>"
                        });
                    str = '<div class="missDIV" id="missHot_' + field_def_idx + '"><ul class="missHotNumber"><li class="missHotUnit">遗漏:</li><li><ul class="yiLouList" id=yiLouList_' + field_def_idx + ">" + str + "</ul></li></ul></div>";
                    result.push(str);
                    str = "";
                    $.each(ps.missHot.hot[idx],
                        function (i, n) {
                            str += '<li class="yiLouNum">' + n + "</li>"
                        });
                    str = '<div class="hotDIV" id="missHot_' + field_def_idx + '"><ul class="missHotNumber"><li class="missHotUnit">冷热:</li><li><ul class="yiLouList" id=yiLouList_' + field_def_idx + ">" + str + "</ul></li></ul></div>";
                    result.push(str);
                }
                return result;
            },
            ball_Click: function (e) {
                $(this).toggleClass("ball_Selected");
                var isSelected = $(this).hasClass("ball_Selected");
                var regIndex = /\w+_(\d+)/;
                var indexArr = regIndex.exec($(this).parent().parent().attr("id"));
                var index = indexArr[1];
                if ($('#locate_' + index).find(".ball_Selected").length > ps.curMethod.field_def[index].max_selected) {
                    if (ps.curMethod.field_def[index].max_selected == 1) {
                        $('#locate_' + index + " .ball_Selected").removeClass("ball_Selected");
                        if (isSelected) {
                            $(this).addClass("ball_Selected");
                        }
                    } else {
                        $(this).removeClass("ball_Selected");
                        layer.alert("最多只能选择" + ps.curMethod.field_def[index].max_selected + "个号码");
                    }
                } else {
                    //JSETDX 江苏快三 二同号单选 特殊处理
                    if (ps.curMethod.name == 'JSETDX') {
                        var tmpi = $('#locate_' + index + ' a').index($(this));
                        $('#locate_' + (index == 1 ? 2 : 1) + ' a').eq(tmpi).removeClass("ball_Selected");
                    }
                    ballBar.computeSingle();
                }
            },
            getBetCode: function (codes) {
                if (ps.curMethod.name == 'REZX' || ps.curMethod.name == 'RSZX' || ps.curMethod.name == 'R4ZX') {//如果是REZX || RSZX
                    $.each(codes, function (k, v) {
                        if (v == '') {
                            codes[k] = '-';
                        }
                    });
                }

                var resultCode = codes.join(",");
                if (ps.curMethod.name == 'JSSTTX') {
                    resultCode = '111_222_333_444_555_666';
                }
                else if (ps.curMethod.name == 'JSSLTX') {//如果是三连号通选(nyjah)
                    resultCode = '123_234_345_456';
                }

                if (RxPos.rsMethods.indexOf(ps.curMethod.name) != -1) {
                    if (!(ps.curMethod.name == 'R4ZX' && codes.length == 5)) {
                        var posChecked = $('.posChoose:checked');
                        var pos = '';
                        $.each(posChecked, function (k, v) {
                            pos += $(v).val();
                        });
                        pos += '_';
                        resultCode = pos + resultCode;
                    }
                }
                return resultCode;
            },
            //计算注数
            computeSingle: function () {
                var codes = [];
                $.each(ps.curMethod.field_def,
                    function (i, n) {
                        var tmp = "";
                        var tmp2 = ps.curMethod.field_def[i].nums.split(" ");
                        $("#field_" + i + " li a").each(function (ii) {
                            if ($(this).hasClass("ball_Selected")) {
                                if (ps.lotteryType == 2 || ps.curMethod.field_def[i].max_selected > 10 || tmp2[tmp2.length - 1].length > 1) {
                                    tmp += $(this).text() + "_"
                                } else {
                                    tmp += $(this).text()
                                }
                            }
                        });
                        if (tmp.indexOf("_") == -1) {
                            codes.push(tmp)
                        } else {
                            codes.push(tmp.substr(0, tmp.length - 1))
                        }
                    });
                var ob = isLegalCode(codes);

                buyBar.updateSingle(ob.singleNum);

                var resultCode = ballBar.getBetCode(codes);

                return {
                    singleNum: ob.singleNum,
                    isDup: ob.isDup,
                    code: resultCode
                }
            }
        };

        //4.遗漏
        var initMissHotBar = function () {
            $("input[name=missHotBtn]").click(missHotBar.missHotBtn_Click);
            $("input[name=missHotBtn][value=1]").click()
        };
        var missHotBar = {
            missHotBtn_Click: function () {
                if ($(this).val() == "1") {
                    $("#selectArea .missDIV").removeClass("hidden");
                    $("#selectArea .hotDIV").addClass("hidden")
                }
                else {
                    $("#selectArea .missDIV").addClass("hidden");
                    $("#selectArea .hotDIV").removeClass("hidden")
                }
            }
        };

        //5.投注区相关
        var initBuyBar = function () {
            ps.nextProjectCounter = 0;
            buyBar.removeAll();
            //$("#totalSingleInfo").prepend('总计[<span>0</span>]注 倍数<input name="multiple" id="multiple" value="1"/>');
            $("#multiple").click(function () {
                this.focus();
                this.select();
            }).keyup(buyBar.checkMultiple).keyup(buyBar.updateTotalSingle);
            $(".btn_delete").live("click",
                function () {
                    $(this).parent().remove();
                    buyBar.updateTotalSingle()
                });

            $("#clearProjectBtn").click(buyBar.removeAll);
            $("#inputBtn").click(buyBar.inputBtn_Click);
            $("#selectCodeBtn").click(buyBar.selectCodeBtn_Click);
            $("#confirmBtn").click(buyBar.confirmBtn_Click);
            $("#traceBtn").click(buyBar.traceBtn_Click)
        };
        var buyBar = {
            inputBtn_Click: function () {
                if ($(this).hasClass('btn_zthm')) {

                    if (ps.curMethod.name == 'R4ZX') {
                        $('#rxpos').show();
                    }

                    $(this).addClass("btn_pttz");
                    $(this).removeClass("btn_zthm");


                    ballBar.showInput();
                    $("#singleInfo").hide();
//                    $(".machineChoice").hide();
                    $("#selectCodeBtn").addClass("selectCodeBtn_selected");
                    /*
                     $("#inputTA").mouseout(function() {
                     if ($("#inputTA").val() !== "") {
                     $("#selectCodeBtn").addClass("selectCodeBtn_selected");
                     } else {
                     $("#selectCodeBtn").removeClass("selectCodeBtn_selected");
                     }
                     });
                     */
                    $("#selectArea").removeClass("N-selected");
                } else {
                    $(this).addClass("btn_zthm");
                    $(this).removeClass("btn_pttz");


                    if (ps.curMethod.name == 'R4ZX') {
                        $('#rxpos').hide();
                    }
                    $("#delTA").hide();
                    $("#manTip").hide();
                    $(".machineChoice").show();
                    $("#singleInfo").show();
                    ballBar.generateBall();
                    $("input[name=missHotBtn]:checked").click();
                    $("#selectArea").addClass("N-selected");
                    $("#selectCodeBtn").removeClass("selectCodeBtn_selected");
                }
            },
            selectCodeBtn_Click: function () {
                //var d = new Date();var t0 = d.getTime();
                if ($("#inputTA").length > 0) {
                    var allCodes = [];
                    var str = $.trim($("#inputTA").val());
                    if (str.length == 0) {
                        return false
                    }
                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                        var arr = str.split(/\s+/);
                        //because HHZX have no field_def
                        if (ps.curMethod.name == "SXHHZX" || ps.curMethod.name == "ZSHHZX" || ps.curMethod.name == "QSHHZX" || ps.curMethod.name == "RSHHZX") {
                            var re = eval("/^\\d{3}$/")
                        } else {
                            var re = eval("/^\\d{" + propLen(ps.curMethod.field_def) + "}$/")
                        }
                        for (var i in arr) {
                            allCodes.push(arr[i].split(""))
                        }
                    } else {
                        if (ps.lotteryType == 2 || ps.lotteryType == 8) {
                            var arr = str.split(/\n/);
                            var re = /^[01]\d$/;
                            var ischeck = 0;
                            for (var i in arr) {
                                arr[i] = $.trim(rtrim($.trim(arr[i]), ","));
                                var tmp = arr[i].split(" ");
                                if (tmp.length != array_unique(tmp).length) {
                                    layer.alert("您输入的号码有重复，请重新检查输入");
                                    return false
                                }
                                if (ps.lotteryType == 8) {
                                    $.each(tmp, function (k) {
                                        if (tmp[k] > 10 || tmp[k] < 1 || !re.test(tmp[k])) {
                                            layer.alert("您输入的号码有误，请重新检查输入");
                                            ischeck = 1;
                                            return false;
                                        }
                                    });
                                }
                                if (ischeck == 1) {
                                    return false;
                                }
                                if (ps.curMethod.name == 'SDQSZUX' || ps.curMethod.name == 'SDQEZUX' || /SDRX(\d+)/.test(ps.curMethod.name)) {
                                    allCodes.push([arr[i].split(" ").join("_")]);
                                } else {
                                    allCodes.push(arr[i].split(" "));
                                }
                            }
                        }
                    }
                    //节省字符串连接时间
                    var ob = {
                        singleNum: 1,
                        isDup: 0
                    };

                    var strPart1 = '<li><span class="num_try_text_list_s1"  mid="' + ps.curMethod.method_id + '">';
                    var strPart2 = "." + ps.curMethod.cname + '</span><span class="num_try_text_list_s2">';

                    var unLegalCode = '';
                    if (allCodes.length <= 500) {
                        for (var i in allCodes) {
                            var ob = isLegalCode(allCodes[i]);
                            if (ob.singleNum < 1) {
                                unLegalCode += allCodes[i];
                                continue;
                            }
                            //对于三星连选，选一注的singleNum是3注，所以这个得动态算
                            var singleAmount = number_format(ob.singleNum * 2 * ps.curMode, 2);
                            var strPart3 = '</span><span class="num_try_text_list_s3">' + ob.singleNum + '注</span><span class="num_try_text_list_s4">￥' + singleAmount + '</span><a href="javascript:;" class="btn_delete">删除</a></li>';
                            ps.nextProjectCounter++;

                            var resultCode = ballBar.getBetCode(allCodes[i]);

                            $(strPart1 + ps.nextProjectCounter + strPart2 + resultCode + strPart3).appendTo("#projectList");
                        }
                        if (unLegalCode !== '') {
                            layer.alert('以下号码不符合规范:' + unLegalCode);
                            return false
                        }
                    }
                    else {
                        var allCodesStr = '';
                        var allProjectsStr = '';
                        var allCodesLength = 0;
                        for (var i in allCodes) {
                            var ob = isLegalCode(allCodes[i]);
                            if (ob.singleNum < 1) {
                                continue;
                            }
                            allCodesLength += ob.singleNum;
                            var resultCode = ballBar.getBetCode(allCodes[i]);

                            if (allCodesStr) {
                                allCodesStr += '|';
                            }
                            allCodesStr += resultCode;

                        }
                        var singleAmount = number_format(allCodesLength * 2 * ps.curMode, 2);
                        var strPart3 = '</span><span class="num_try_text_list_s3">' + allCodesLength + '注</span><span class="num_try_text_list_s4">￥' + singleAmount + '</span><a href="javascript:;" class="btn_delete">删除</a></li>';
                        ps.nextProjectCounter = allCodesLength;
                        allProjectsStr += strPart1 + ps.nextProjectCounter + strPart2 + allCodesStr + strPart3;
                        $(allProjectsStr).appendTo("#projectList");
                    }
                    buyBar.updateTotalSingle();
                    //$("#confirmBtn").removeClass('CantapCodeBtn');
                    $("#delTA").click();
                } else {
                    var ob = ballBar.computeSingle();
                    if (ob.singleNum == 0) {
                        return false;
                    }
                    ps.nextProjectCounter++;
                    var singleAmount = number_format(ob.singleNum * 2 * ps.curMode, 2);
                    //140329 加入排除重复号码功能 相同号码将无法加上 为效率起见100以下方案才判断
//                    var isDuplicate = false;
//                    if ($("#projectList").children("li").length < 100) {
//                        $("#projectList").children("li").each(function(i) {
//                            if (ps.curMethod.method_id == $(this).children().eq(0).attr("mid") && ob.code == $(this).children().eq(1).text()) {
//                                isDuplicate = true;
//                            }
//                        });
//                        if (isDuplicate) {
//                            //layer.alert('"' + ob.code + '" 已添加至投注项，请勿重复添加！');
//                            return false;
//                        }
//                    }

                    $('<li><span class="num_try_text_list_s1" mid="' + ps.curMethod.method_id + '">' + ps.nextProjectCounter + "." + ps.curMethod.cname + '</span><span class="num_try_text_list_s2">' + ob.code + '</span><span class="num_try_text_list_s3">' + ob.singleNum + '注</span><span class="num_try_text_list_s4">￥' + singleAmount + '</span><a href="javascript:;" class="btn_delete">删除</a></li>').appendTo("#projectList");
                    buyBar.updateTotalSingle();
                    ballBar.reset();
                    //$("#confirmBtn").removeClass('CantapCodeBtn');
                }
                //var d = new Date();var t1 = d.getTime();
                //alert("66 t0=" + t0 + "\nt1=" + t1 + "\nt1-t0=" + (t1-t0));
            },
            removeAll: function () {
                $("#projectList").empty();
                ps.nextProjectCounter = 0;
                $("#multiple").val("1");
                buyBar.updateTotalSingle()
            },
            updateSingle: function (singleNum) {
                var singleAmount = number_format(singleNum * 2 * ps.curMode, 2);
                $("#betCount").text(singleNum);
                $("#betAmount").text(singleAmount);
                if (singleNum > 0) {
                    $("#selectCodeBtn").addClass('selectCodeBtn_selected');
                    $('#prizeAmount').text($('#curPrizeSpanShower').text());
                    $('#winAmount').text(number_format($('#curPrizeSpanShower').text() - singleAmount, 2));
                    if ($("#prizeDesc").length > 0) {
                        $("#prizeAmountDetail").attr('title', $("#prizeDesc").text());
                    }

                    $('#showWinTip').show();

                } else {
                    $('#showWinTip').hide();
                    $("#selectCodeBtn").removeClass('selectCodeBtn_selected');
                }
            },
            updateTotalSingle: function () {
                var totalSingleNum = 0;
                $("#projectList").children("li").each(function (i) {
                    spans = $(this).children();
                    totalSingleNum += parseInt(spans.eq(2).text());
                    spans.eq(3).text("￥" + number_format(parseInt(spans.eq(2).text()) * 2 * ps.curMode, 2))
                });
                if (totalSingleNum > 0) {
                    $("#confirmBtn").addClass('confirmBtn_selected');
                    $("#traceBtn").addClass('traceBtn_selected');
                } else {
                    $("#confirmBtn").removeClass('confirmBtn_selected');
                    $("#traceBtn").removeClass('traceBtn_selected');
                }
                $("#totalBetCount").text(totalSingleNum);
                $("#totalBetAmount").text(number_format(totalSingleNum * 2 * $("#multiple").val() * ps.curMode, 2))
            },
            checkMultiple: function () {
                //if (!/^[1-9]\d{0,2}$/.test($(this).val())) {
                this.value = this.value.replace(/^0|[^\d]/g, '');
                if ($(this).val() > 5000) {
                    layer.alert("请输入正确的倍数，最大为5000倍");
                    $(this).val(5000);
                    return true;
                }
                return true;
            },
            //确认按钮
            confirmBtn_Click: function () {
                /*
                 var spans, codes, tmpMethod, mid, code, listFirst;
                 $("#projectList").children("li").each(function(i) {
                 spans = $(this).children();
                 // 46:1,2,3,4,5|6,7,8,9,0|1,2,3,4,5#43:1,2,3|6,7,0
                 mid = spans.eq(0).attr("mid");
                 code = spans.eq(1).text();
                 listFirst = false;
                 if (!tmpMethod) {
                 tmpMethod = mid;
                 codes = mid + ":";
                 listFirst = true;
                 }
                 if (tmpMethod != mid) {
                 codes += "#" + mid + ":";
                 tmpMethod = mid;
                 codes += code;
                 } else {
                 if (listFirst == true) {
                 codes += code;
                 } else {
                 codes += "|" + code;
                 }
                 }
                 });
                 */
                //140329 按要求去掉重复选号
                //1.先按玩法归类到一个对象
                var methodCodes = {}, codes = '';
                var projects = 0;
                $("#projectList").children("li").each(function (i) {
                    projects++;
                    if (!methodCodes[$(this).children().eq(0).attr("mid")]) {
                        methodCodes[$(this).children().eq(0).attr("mid")] = {};
                    }
                    ;
                    methodCodes[$(this).children().eq(0).attr("mid")][i] = $(this).children().eq(1).text();
                    //methodCodes[$(this).children().eq(0).attr("mid")][$(this).children().eq(1).text()] = $(this).children().eq(1).text();
                });
                if(projects>50){
                    alert("提交下注一次最多只能下50注哦!");
                    return false;
                }
                //2.拼出codes格式  46:1,2,3,4,5|6,7,8,9,0|1,2,3,4,5#43:1,2,3|6,7,0
                $.each(methodCodes, function (mid, v) {
                    codes += mid + ':';
                    $.each(v, function (code, vv) {
                        codes += vv + '|';
                    });
                    codes = rtrim(codes, '|');
                    codes += '#';
                });
                codes = rtrim(codes, '#');
                if (!ps.canBuy) {
                    layer.alert("投注已暂停");
                    return false;
                }
                if (codes.length == 0) {
                    layer.alert("请先 添加号码 再投注");
                    return false;
                }
                var betTotalAmount = $("#totalBetAmount").text();
                var betTotalBetCount = $("#totalBetCount").text();
                var totalSingleInfo = $("#multiple").val();
                var confirmInfo = '<div id="buy_message">投注内容(确认投注按空格键)：<br>注数：' + betTotalBetCount + "<br>金额：" + betTotalAmount + "元<br>币值：" + ps.modeName[ps.curMode] + "模式<br>倍数：" + totalSingleInfo + "倍</div>";
                var confirmLayer = layer.confirm(confirmInfo,
                    function (i) {
                        //使用进度条代替按钮
                        $('.xubox_botton').empty();
                        $('.xubox_botton').html('<p class="">提交中</p>');
                        $.post(ps.getbuyUrl, {
                                op: "buy",
                                lotteryId: ps.lotteryId,
                                issue: ps.curIssueInfo.issue,
                                curRebate: ps.rebateGapList[ps.curPrizeIndex].rebate,
                                modes: ps.curMode,
                                codes: codes,
                                multiple: $("#multiple").val(),
                                odd:ps.odds
                            },
                            function (response) {
                                if (response.errno == 0) {
                                    $(".kj_right_btn_myFa").click();
                                    buyBar.removeAll();
                                    var msg = '<div id="buy_success_message">投注成功!<br>投注注单数：' + response.ordersums + "<br>投注期号：" + ps.curIssueInfo.issue + "<br>投注金额：￥" + betTotalAmount + "<br>币值模式：" + ps.modeName[ps.curMode] + "模式<br>投注倍数：" + totalSingleInfo + "倍<br></div>";
                                    layer.close(i);
                                    layer.alert(msg, 1);
                                    $('.xubox_yes').focus();
                                    $('.xubox_yes').one('keyup', function (e) {
                                        var key = e.keyCode ? e.keyCode : e.which;
                                        if (key == 32) {
                                            $('.xubox_yes').trigger("click");
                                        }
                                        if (key == 27) {
                                            $('.xubox_no').trigger("click");
                                        }
                                    });
                                } else {
                                    layer.close(i);
                                    layer.alert("投注失败:" + response.errstr);
                                }
                                showBalance();
                            },
                            "json").fail(function () {
                            layer.close(i);
                            layer.alert("投注失败:服务器无法处理请求！");
                        });
                    });
                $('.xubox_yes').focus();
                $('.xubox_yes').one('keyup', function (e) {
                    var key = e.keyCode ? e.keyCode : e.which;
                    if (key == 32) {
                        $('.xubox_yes').trigger("click");
                    }
                    if (key == 27) {
                        $('.xubox_no').trigger("click");
                    }
                });

            },
            //追号按钮
            traceBtn_Click: function () {
                if ($("#projectList li").length == 0) {
                    layer.alert("请先 添加号码 ");
                    return false
                }

                if ($("#user_is_test").val() == 2) {
                    layer.alert("只有正式会员才能追号！试玩用户不能追号 ");
                    return false
                }
                $("#traceBtn").attr('disabled', "true");
                var mids = [];
                $("#projectList li").each(function (i) {
                    if ($.inArray($(this).find("span:first").attr("mid"), mids) == -1) {
                        mids.push($(this).find("span:first").attr("mid"))
                    }
                });

                $.ajax({
                    url: traceUrl,
                    type: "POST",
                    data: {
                        op: "getTracePage",
                        lotteryId: ps.lotteryId,
                        mids: mids.join(",")
                    },
                    cache: false,
                    dataType: "json",
                    timeout: 30000,
                    success: function (response) {
                        $("#traceBtn").removeAttr("disabled");
                        if (response.errno == 0) {
                            ps.canTraceIssues = response.issues;
                            ps.traceMethodPrize = response.prize;
                            ps.tracePrizeLimit = response.prizeLimit;
                            var i = traceFunc.showTracePage(response.content);
                            if (response.prize == 0 || mids.length != 1) {
                                $("#multipleStyle2").attr("disabled", true);
                            }
                            $("input[name=multipleStyle]").click(traceFunc.multipleStyle_Click);
                            $("#confirmTraceBtn").click(
                                function () {
                                    if (traceFunc.confirmTraceBtn_Click()) {
                                        layer.close(i);
                                    }
                                });
                            $("#cancelTraceBtn").click(
                                function () {
                                    traceFunc.cancelTraceBtn_Click();
                                    layer.close(i);
                                });
                            $("#startIssue").change(traceFunc.startIssue_Change);
                            $("#traceNum").click(function () {
                                this.focus();
                                this.select()
                            }).keyup(buyBar.checkMultiple).keyup(traceFunc.traceNum_Keyup);
                            $("#singleNum").text($("#totalBetCount").text());
                            $("#issuesNum2").text("1");
                            $("#multipleStyle1").click();
                            traceFunc.updateTotalMoney();
                            runTime.traceRemainTimer = window.setInterval(traceFunc.traceRemain_Timer_Handle, 1000);
                        } else {
                            layer.alert("不能获取该奖期的可追号信息");
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#traceBtn").removeAttr("disabled");
                        var message = errorThrown.toString();
                        if (errorThrown.message) {
                            message = errorThrown.message;
                        }
                        if (message.indexOf("a=logout") != -1 || message.indexOf("a=login") != -1) {
                            layer.alert("你与服务器之间的认证失败");
                        } else {
                            layer.alert("服务器无法响应");
                        }
                    }
                })
            }
        };

        //5.1定义追号几个按钮事件 放在buyBar前面
        var traceFunc = {
            multipleStyle_Click: function () {
                $("#startIssue").get(0).selectedIndex = 0;
                $("#traceNum").val(1);
                if ($(this).val() == 1) {
                    $(".style1BodyMultiple").live("click",
                        function () {
                            this.focus();
                            this.select()
                        }).live("keyup", buyBar.checkMultiple).live("keyup", traceFunc.style1BodyMultiple_Keyup);
                    traceFunc.updateStyle1();
                    $("#multipleStyle1DIV").show();
                    $("#multipleStyle2DIV").hide();
                } else {
                    $("#startMultiple").click(function () {
                        this.focus();
                        this.select()
                    });
                    $("#beitouToolSmainbtzk input").click(function () {
                        $(this).parent().click()
                    }).focus(function () {
                        this.select()
                    });
                    $("#beitouToolSmainbtzk li").click(function () {
                        $(this).addClass("checked").siblings().removeClass("checked");
                        $(this).find("input[name=profitStyle]").attr("checked", true)
                    });
                    $("#generalPlanBtn").click(traceFunc.generalPlanBtn_Click);
                    $("#issuesNum2").text("1");
                    $("#style2Body").empty();
                    $("#startMultiple").val("1");
                    $("input[name=totalProfitRate]").val("10");
                    $("input[name=first5Rate]").val("5");
                    $("input[name=first5RateValue]").val("10");
                    $("input[name=laterRateValue]").val("5");
                    $("input[name=totalProfit]").val("100");
                    $("input[name=first5Profit]").val("5");
                    $("input[name=first5ProfitValue]").val("100");
                    $("input[name=laterProfitValue]").val("50");
                    $("#beitouToolSmainbtzk li:first").click();
                    $("#multipleStyle1DIV").hide();
                    $("#multipleStyle2DIV").show()
                }
            },
            startIssue_Change: function () {
                if ($("input[name=multipleStyle]:checked").val() == "1") {
                    traceFunc.updateStyle1();
                }
            },
            traceNum_Keyup: function () {
                if ($("input[name=multipleStyle]:checked").val() == "1") {
                    traceFunc.updateStyle1();
                }
            },
            //追号界面也加一个倒计时
            traceRemain_Timer_Handle: function () {
                var d = subTime(ps.curRemainTime);
                console.log(ps.curRemainTime);
                if (ps.curRemainTime>0) {
                    if(ps.curIssueInfo.state == 1){
                        $("#curIssueText").html("投注还剩：");
                        $("#remainTimerLabel").text(d.hour + ":" + d.minute + ":" + d.second);
                    }else{
                        $("#curIssueText").html("等待开奖中！");
                        $("#remainTimerLabel").text(' ');
                    }
                } else{
                    $("#curIssueText").html("开奖倒计时：");
                    clearInterval(runTime.traceRemainTimer);
                    var d2 = subTime(ps.curWaitOpenTime);
                    $("#remainTimerLabel").text(d2.hour + ":" + d2.minute + ":" + d2.second);
                    $("#remainTimerLabel").text('');
                    runTime.traceWaitOpenTimer = window.setInterval(traceFunc.traceWaitOpen_Timer_Handle, 1000);
                    //去掉过期的一期
                    layer.alert("起始期" + ps.curIssueInfo.issue + "的投注时间已结束，自动设置下一期为起始期！");
                    $("#startIssue").children(":first").remove();
                    $("#startIssue").children(":first").text($("#startIssue").children(":first").text() + "(当前期)");
                    var tmpArr = [];
                    $(".style1BodyMultiple").each(function () {
                        tmpArr.push(this.value);
                    });
                    traceFunc.updateStyle1();
                    $(".style1BodyMultiple").each(function () {
                        this.value = tmpArr.pop();
                    });
                }
            },
            //显示锁倒计时
            traceWaitOpen_Timer_Handle: function () {
                var d = subTime(ps.curWaitOpenTime);
                $("#remainTimerLabel").text(d.hour + ":" + d.minute + ":" + d.second);
                if (ps.curWaitOpenTime <= 0) {
                    clearInterval(runTime.traceWaitOpenTimer);
                    runTime.traceRemainTimer = window.setInterval(traceFunc.traceRemain_Timer_Handle, 1000);
                }
            },
            style1BodyMultiple_Keyup: function () {
                var multiple = parseInt($(this).val());
                if (isNaN(multiple) || multiple < 1 || multiple > 99999) {
                    multiple = 1
                }
                test($(this).attr("id"));
                var idx = RegExp.$1;
                if (idx == 0) {
                    var prevTotalMoney = 0
                } else {
                    var prevTotalMoney = parseFloat($("#totalMoney_" + (idx - 1)).text())
                }
                while (idx <= $("#style1Body li").length) {
                    $("#style1BodyMultiple_" + idx).val(multiple);
                    var curMoney = parseInt($("#singleNum").text()) * multiple * 2 * ps.curMode;
                    prevTotalMoney += curMoney;
                    $("#curMoney_" + idx).text(number_format(curMoney, 2));
                    $("#totalMoney_" + idx).text(number_format(prevTotalMoney, 2));
                    idx++
                }
                traceFunc.updateTotalMoney();
            },
            updateStyle1: function () {
                var idx = -1;
                $.each(ps.canTraceIssues,
                    function (k, v) {
                        if (v == $("#startIssue").val()) {
                            idx = k;
                        }
                    });
                if (idx == -1) {
                    alert("追号数据出错");
                    console.log("数据出错");
                }
                if (isNaN(parseInt($("#traceNum").val()))) {
                    $("#traceNum").val("1")
                }
                var willTraceIssues = ps.canTraceIssues.slice(idx, idx + parseInt($("#traceNum").val()));
                if (willTraceIssues.length < $("#traceNum").val()) {
                    layer.alert("当前时间只能追" + willTraceIssues.length + "期");
                    $("#traceNum").val(willTraceIssues.length);
                }
                $("#style1Body").empty();
                var str = "",
                    curMoney, totalMoney = 0;
                $.each(willTraceIssues,
                    function (k, v) {
                        curMoney = parseInt($("#singleNum").text()) * 2 * ps.curMode;
                        totalMoney += curMoney;
                        var str = '<li id="traceIssueLI_' + k + '"><span id="traceIssue_' + k + '">' + v + '</span><span><input type="text" value="1" id="style1BodyMultiple_' + k + '" class="beitouToolsinput style1BodyMultiple" maxlength="5" /></span><span id=curMoney_' + k + ">" + number_format(curMoney, 2) + "</span><span id=totalMoney_" + k + ">" + number_format(totalMoney, 2) + "</span></li>";
                        $("#style1Body").append(str);
                        $(".style1BodyMultiple").bind("click",
                            function () {
                                this.focus();
                                this.select()
                            }).bind("keyup", buyBar.checkMultiple).bind("keyup", traceFunc.style1BodyMultiple_Keyup)
                    });
                traceFunc.updateTotalMoney()
            },
            confirmTraceBtn_Click: function () {
                var spans, codes, tmpMethod, mid, code, listFirst;
                $("#projectList").children("li").each(function (i) {
                    spans = $(this).children();
                    mid = spans.eq(0).attr("mid");
                    code = spans.eq(1).text();
                    listFirst = false;
                    if (!tmpMethod) {
                        tmpMethod = mid;
                        codes = mid + ":";
                        listFirst = true;
                    }

                    if (tmpMethod != mid) {
                        codes += "#" + mid + ":";
                        tmpMethod = mid;
                        codes += code;
                    } else {
                        if (listFirst == true) {
                            codes += code;
                        } else {
                            codes += "|" + code;
                        }

                    }
                });
                if (!ps.canBuy) {
                    layer.alert("该期已暂停购买");
                    return false
                }
                if (codes.length == 0) {
                    layer.alert("请先 添加号码");
                    return false
                }

                var traceData = [];
                if ($("input[name=multipleStyle]:checked").val() == "1") {
                    $("#style1Body li").each(function (i) {
                        var issue = $(this).find("span:eq(0)").text();
                        var multiple = $(this).find("input").val();
                        traceData.push({
                            issue: issue,
                            multiple: multiple
                        })
                    })
                } else {
                    $("#style2Body li").each(function (i) {
                        var issue = $(this).find("span:eq(0)").text();
                        var multiple = $(this).find("span:eq(1)").text();
                        traceData.push({
                            issue: issue,
                            multiple: multiple
                        })
                    })
                }
                var traceTotalAmount = $("#traceTotalAmount").text();
                var stopOnWin = $("input[name=stopOnWin]").attr("checked") ? 1 : 0;
                var confirmInfo = '<div id="buy_message">投注内容(确认投注按空格键)：<br>投注注数：' + $("#totalBetCount").text() + "注<br>投注金额：￥" + traceTotalAmount + "<br>超始期号：" + traceData[0].issue + "<br>追号期数：" + traceData.length + "<br>币值模式：" + ps.modeName[ps.curMode] + "模式<br></div>";
                traceFunc.destroyTracePage();
                layer.confirm(confirmInfo,
                    function (i) {
                        $.post(traceUrlBuy, {
                                lotteryId: ps.lotteryId,
                                issue: ps.curIssueInfo.issue,
                                odd: ps.odds,
                                modes: ps.curMode,
                                codes: codes,
                                traceData: traceData,
                                stopOnWin: stopOnWin
                            },
                            function (response) {
                                if (response.errno == 0) {
                                    $(".kj_right_btn_myZh").click();
                                    buyBar.removeAll();
                                    var msg = '<div id="buy_success_message">追号成功!<br>注单数：' + 1 + "<br>起始期号：" + traceData[0].issue + "<br>追号期数：" + traceData.length + "<br>投注金额：￥" +traceTotalAmount + "<br>币值模式：" + ps.modeName[ps.curMode] + "模式</div>";
                                    layer.close(i);
                                    layer.alert(msg, 1);
                                    $('.xubox_yes').focus();
                                    $('.xubox_yes').one('keyup', function (e) {
                                        var key = e.keyCode ? e.keyCode : e.which;
                                        if (key == 32) {
                                            $('.xubox_yes').trigger("click");
                                        }
                                        if (key == 27) {
                                            $('.xubox_no').trigger("click");
                                        }
                                    });
                                } else {
                                    layer.close(i);
                                    layer.alert("追号失败:" + response.errstr);
                                }
                                showBalance();
                            },
                            "json").fail(function () {
                            layer.close(i);
                            layer.alert("追号失败:服务器无法处理请求！");
                        });
                        //使用进度条代替按钮
                        $('.xubox_botton').empty();
                        $('.xubox_botton').html('<div class="LoadingShow"><span class="Loading_icon"></span><span class="Loading_Font">投注中...</span></div>');
                    });


                $('.xubox_yes').focus();
                $('.xubox_yes').one('keyup', function (e) {
                    var key = e.keyCode ? e.keyCode : e.which;
                    if (key == 32) {
                        $('.xubox_yes').trigger("click");
                    }
                    if (key == 27) {
                        $('.xubox_no').trigger("click");
                    }
                });


                return true;
            },
            cancelTraceBtn_Click: function () {
                traceFunc.destroyTracePage();
            },
            showTracePage: function (content) {
//                var wnd = window.parent;
//                $("body", wnd.document).append('<div id="ui-dialog2" style="outline: 0px none; z-index: 1002;" class="ui-dialog" tabindex="-1"></div>');
//                var uiDialog2 = $("#ui-dialog2", wnd.document).append(content).css("width", 530).hide();
//                $("body", wnd.document).append('<div id="ui-widget-overlay2" class="ui-widget-overlay2" style="z-index: 1001;"></div>');
//                var dialogOverlay2 = $("#ui-widget-overlay2", wnd.document).css("width", $(wnd.document).width()).css("height", $(wnd.document).height());
//                var rect = getXY(wnd);
//                uiDialog2.css("left", rect.scrollX + (rect.width - uiDialog2.width()) / 2);
//                uiDialog2.css("top", rect.scrollY + (rect.height - uiDialog2.height()) / 2);
//                uiDialog2.show();
//                dialogOverlay2.show();
                var i = $.layer({
                    type: 1,
                    title: '追号管理',
                    offset: ['240px', ''],
                    //border: [0],
                    area: ['700px', 'auto'],
                    page: {html: content},
                    success: function (l) {
                        $("#startIssue").children(":first").text($("#startIssue").children(":first").text() + "(当前期)");
                    },
                    close: traceFunc.cancelTraceBtn_Click
                });
                $(document).one('keyup', function (e) {
                    var key = e.keyCode ? e.keyCode : e.which;
                    if (key == 27) {
                        traceFunc.cancelTraceBtn_Click();
                        layer.close(i);
                    }
                });
                return i;
            },
            destroyTracePage: function () {
//                $("#ui-dialog2").remove();
//                $("#ui-widget-overlay2").remove();
                clearInterval(runTime.traceRemainTimer);
                clearInterval(runTime.traceWaitOpenTimer);
            },
            updateTotalMoney: function () {
                var totalMultiple = 0;
                if ($("input[name=multipleStyle]:checked").val() == "1") {
                    $("#style1Body li").each(function (i) {
                        totalMultiple += parseInt($(this).find("input").val())
                    });
                    $("#issuesNum2").text($("#style1Body li").length)
                } else {
                    $("#style2Body li").each(function (i) {
                        totalMultiple += parseInt($(this).find("span:eq(1)").text())
                    });
                    $("#issuesNum2").text($("#style2Body li").length)
                }
                $("#traceTotalAmount").text(number_format(parseInt($("#singleNum").text()) * totalMultiple * 2 * ps.curMode, 2))
            },
            generalPlanBtn_Click: function () {
                var computeMultiple = function (startMultiple, profitRate, singleAmount, totalMoney, prize) {
                    startMultiple = isNaN(parseInt(startMultiple)) ? -1 : parseInt(startMultiple);
                    profitRate = isNaN(parseInt(profitRate)) ? -1 : parseInt(profitRate);
                    singleAmount = isNaN(parseFloat(singleAmount)) ? -1 : parseFloat(singleAmount);
                    totalMoney = isNaN(parseFloat(totalMoney)) ? -1 : parseFloat(totalMoney);
                    prize = parseFloat(prize);
                    if (startMultiple < 0 || profitRate < 0 || singleAmount < 0 || totalMoney < 0 || prize <= 0) {
                        return 0
                    }
                    var result = 0;
                    if (singleAmount > 0) {
                        if (profitRate > 0) {
                            result = ((profitRate / 100 + 1) * totalMoney) / (prize - (singleAmount * (profitRate / 100 + 1)));
                            result = Math.ceil(round(result, 3))
                        } else {
                            result = 1
                        }
                        if (result > 0 && result < startMultiple) {
                            result = startMultiple
                        }
                    }
                    return result
                };
                var idx = -1;
                $.each(ps.canTraceIssues,
                    function (k, v) {
                        if (v == $("#startIssue").val()) {
                            idx = k
                        }
                    });
                if (idx == -1) {
                    alert("数据出错");
                    throw "数据出错"
                }
                if (isNaN(parseInt($("#traceNum").val()))) {
                    $("#traceNum").val("1")
                }
                var willTraceIssues = ps.canTraceIssues.slice(idx, idx + parseInt($("#traceNum").val()));
                if (willTraceIssues.length < $("#traceNum").val()) {
                    layer.alert("当前时间只能追" + willTraceIssues.length + "期");
                    $("#traceNum").val(willTraceIssues.length);
                }
                $("#style2Body").empty();
                var traces = [],
                    str = "",
                    curMultiple,
                    curMoney,
                    totalMoney = 0;
                var singleMoney = parseInt($("#singleNum").text()) * 2 * ps.curMode;
                var prize = ps.traceMethodPrize * (ps.rebateGapList[ps.curPrizeIndex].prize / (ps.maxCombPrize * ps.prizeRate)) * ps.curMode;
                $.each(willTraceIssues,
                    function (k, v) {
                        if ($("input[name=profitStyle]:checked").val() == 1) {
                            if (k == 0) {
                                curMultiple = parseInt($("#startMultiple").val());
                                curMoney = curMultiple * parseInt($("#singleNum").text()) * 2 * ps.curMode;
                                if ((curMultiple * prize - curMoney) / curMoney * 100 < $("input[name=totalProfitRate]").val()) {
                                    layer.alert("该计划无法实现，请调整目标");
                                    return false;
                                }
                            } else {
                                curMultiple = computeMultiple($("#startMultiple").val(), $("input[name=totalProfitRate]").val(), singleMoney, totalMoney, prize)
                            }
                        } else {
                            if ($("input[name=profitStyle]:checked").val() == 2) {
                                if (k == 0) {
                                    curMultiple = parseInt($("#startMultiple").val());
                                    curMoney = curMultiple * parseInt($("#singleNum").text()) * 2 * ps.curMode;
                                    if ((curMultiple * prize - curMoney) / curMoney * 100 < $("input[name=first5RateValue]").val()) {
                                        layer.alert("该计划无法实现，请调整目标");
                                        return false;
                                    }
                                } else {
                                    if (k < $("input[name=first5Rate]").val()) {
                                        curMultiple = computeMultiple($("#startMultiple").val(), $("input[name=first5RateValue]").val(), singleMoney, totalMoney, prize)
                                    } else {
                                        curMultiple = computeMultiple($("#startMultiple").val(), $("input[name=laterRateValue]").val(), singleMoney, totalMoney, prize)
                                    }
                                }
                            } else {
                                if ($("input[name=profitStyle]:checked").val() == 3) {
                                    curMultiple = Math.ceil(round((parseInt($("input[name=totalProfit]").val()) + totalMoney) / (prize - parseInt($("#singleNum").text()) * 2 * ps.curMode), 3));
                                    if (curMultiple < $("#startMultiple").val()) {
                                        curMultiple = $("#startMultiple").val()
                                    }
                                } else {
                                    if ($("input[name=profitStyle]:checked").val() == 4) {
                                        if (k < $("input[name=first5Profit]").val()) {
                                            curMultiple = Math.ceil(round((parseInt($("input[name=first5ProfitValue]").val()) + totalMoney) / (prize - parseInt($("#singleNum").text()) * 2 * ps.curMode), 3))
                                        } else {
                                            curMultiple = Math.ceil(round((parseInt($("input[name=laterProfitValue]").val()) + totalMoney) / (prize - parseInt($("#singleNum").text()) * 2 * ps.curMode), 3))
                                        }
                                    }
                                }
                            }
                        }
                        if (curMultiple == 0) {
                            layer.alert("您输入的参数有误，必须为正整数");
                            return false
                        } else {
                            if (curMultiple < 0) {
                                layer.alert("该计划不可能实现，请调整目标");
                                return false
                            } else {
                                if (curMultiple * prize > ps.tracePrizeLimit) {
                                    layer.alert("该计划超出无法实现，请调整目标");
                                    return false
                                }
                            }
                        }
                        curMoney = curMultiple * parseInt($("#singleNum").text()) * 2 * ps.curMode;
                        totalMoney += curMoney;
                        traces.push({
                            issue: v,
                            multiple: curMultiple,
                            curMoney: number_format(curMoney, 2),
                            totalMoney: number_format(totalMoney, 2),
                            curPrize: number_format(curMultiple * prize, 2),
                            totalProfit: number_format(curMultiple * prize - totalMoney, 2),
                            totalProfitRate: round((curMultiple * prize - totalMoney) / totalMoney, 2)
                        })
                    });
                traceFunc._showPlan(traces)
            },
            _showPlan: function (traces) {
                $.each(traces,
                    function (k, v) {
                        var str = '<li><span class="spanWidth90px">' + v.issue + '</span><span class="spanWidth50px">' + v.multiple + '</span><span class="spanWidth70px">' + v.curMoney + '</span><span class="spanWidth70px">' + v.totalMoney + '</span><span class="spanWidth70px">' + v.curPrize + '</span><span class="spanWidth70px">' + v.totalProfit + '</span><span class="spanWidth70px">' + Math.round(v.totalProfitRate * 100) + "%</span></li>";
                        $("#style2Body").append(str)
                    });
                traceFunc.updateTotalMoney()
            }
        };

        //6.开奖区
        var initDrawBar = function () {
            $("#curLotteryName").text(ps.lotteryName);
            $("#curLotteryName2").text(ps.lotteryName);

            $.each(ps.openedIssues,
                function (k, v) {
                    v.prop = drawBar.getMoreInfo(v.code);
                });
            //初始化开奖球数目
            if (ps.lotteryType == 1 || ps.lotteryType == 4 || ps.lotteryType == 6 || ps.lotteryType == 9) {
                var nums = ps.openedIssues[0].code.split("");
            } else if (ps.lotteryType == 2 || ps.lotteryType == 7 || ps.lotteryType == 8 || ps.lotteryType == 10) {
                var nums = ps.openedIssues[0].code.split(" ");
            }
            else {
                throw '无效的彩种开奖区无法初始化';
            }
            $('#thisIssueNumUL').empty();
            $.each(nums, function (i, n) {
                if (ps.lotteryType == 1 || ps.lotteryType == 4 || ps.lotteryType == 8 || ps.lotteryType == 9 || ps.lotteryType == 10) {
                    $('#thisIssueNumUL').append('<span class="pendingBall"></span>');
                } else if (ps.lotteryType == 2) {
                    $('#thisIssueNumUL').append('<span class="pendingBall"></span>');
//                        //$('#thisIssueNumUL').append('<span class="sd115_Ball"></span>');
                } else if (ps.lotteryType == 6) {	//快三
                    $('#thisIssueNumUL').append('<span class="pendingNum_k3' + (i + 1) + ' k3"></span>');
                } else if (ps.lotteryType == 7) {	//扑克
                    $('#thisIssueNumUL').append('<div class="pendingNum_poker poker"><span class="poker_kj_num poker_kj_wait' + (i + 1) + ' poker_kj_wait"><i></i><em></em></span></div>');
                }
            });
            drawBar.showLastDraw();
            drawBar.getCurIssue(drawBar.init);
        };

        var drawBar = {
            isOpen:true,
            lock_alert_time:3,
            init: function () {
                runTime.remainTimer = window.setInterval(drawBar.showCurIssue_Timer, 1000);
                ps.getLastOpenTime = 0;
                clearInterval(runTime.getLastOpenTimer);
                runTime.getLastOpenTimer = window.setInterval(drawBar.getLastOpen_Timer, 1000);
                if (ps.lastIssueInfo.code == "") {
                    $("#thisIssueInfo").addClass("lock");
                    ps.canBuy = false;
                    $("#thisIssueSpan").text(ps.lastIssueInfo.issue);
                } else {  //友好界面 1秒等待后显示
                    //更新最近一期数据，否则导致draw.init()中重复调用
                    var latest = ps.openedIssues[0];
                    if (ps.lastIssueInfo.length > 0 && ps.lastIssueInfo.issue != latest.issue) {
                        var tmp = ps.lastIssueInfo;
                        var ob = drawBar.getMoreInfo(tmp.code);
                        tmp.prop = ob;
                        ps.openedIssues.unshift(tmp);
                        ps.openedIssues.updateLast();
                    }
                }
                ps.canBuy = true;
            },
            getCurIssue: function (callback) {
                var lids = '';
                $('.lottery_timer').each(function (){
                    var lottery_issue = $(this);
                    var lotteryId = lottery_issue.attr('lottery');
                    if(ps.lotteryId != lotteryId){
                        lids +=lotteryId+',';//去掉显示当前页显示的彩种
                    }
                });
                $.ajax({
                    url:allCurIssueURL,
                    type:'POST',
                    data:{
                        lids:lids,
                        curentLid:ps.lotteryId,//当前彩种
                    },
                    async:true,
                    cache:false,
                    dataType:'json',
                    timeout:30000,
                    success:function(response){
                        if(response.errno == 0){
                            //切换到当前页面的彩种 当前期和下一期
                            ps.curIssueInfo = response.curIssue.issueInfo;
                            ps.curServerTime = response.serverTime;
                            ps.curRemainTime = getTS(ps.curIssueInfo.end_time) - getTS(ps.curServerTime);
                            ps.curWaitOpenTime = ps.curIssueInfo.waite_time;    //显示锁形的时间，可酌情减少，不构成风险
                            ps.lastIssueInfo = response.curIssue.lastIssueInfo;
                            //当前期上一次开奖号码
                            lastIssueInfo = ps.lastIssueInfo ;
                            //其他彩种
                            $('.lottery_timer').each(function (){
                                var lottery_issue = $(this);
                                var lotteryId = lottery_issue.attr('lottery');
                                var issueInfo = response.issueInfo;
                                $.each(issueInfo,function(i,val){
                                    if(i == lotteryId){
                                        if(val.state != ''&& val.state <=1){
                                            lottery_issue.attr('title', val.issue);
                                            var d = val.end_time.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/gi);
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
                                                var curTime = $(this).html();
                                                if(curTime == '0:00:00'){
                                                    $(this).html("等待开奖");
                                                }
                                            });
                                        }else if(val.state != ''&&val.state >1){
                                            lottery_issue.text('等待开奖');
                                        }else{
                                            lottery_issue.text('等待开盘');
                                        }
                                    }
                                });
                            });
                            //更新上方倒计时 延迟1s 与下方匹配上
                            if(response.curIssue.issueInfo.state >0){
                                var lottery_issue =  $("#lotterycurrent"+ps.lotteryId);
                                lottery_issue.attr('title', response.curIssue.issueInfo.issue);
                                var d = response.curIssue.issueInfo.end_time.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/gi);
                                d = new Date(RegExp.$1, RegExp.$2, RegExp.$3, RegExp.$4, RegExp.$5, RegExp.$6);
                                serverTime = response.serverTime.match(/(\d{4})\/(\d{2})\/(\d{2}) (\d{2}):(\d{2}):(\d{2})/gi);
                                var serverTime = new Date(RegExp.$1, RegExp.$2, RegExp.$3, RegExp.$4, RegExp.$5, RegExp.$6);
                                var now = new Date();
                                var offset = d.getTimezoneOffset() / 60 + 8;
                                var nowDate = new Date(serverTime.getTime()-(3600000 * offset));
                                var nd = new Date(now.getTime() - nowDate.getTime() + d.getTime() - (3600000 * offset));
                                lottery_issue.countdown(nd.getTime(), function (event) {
                                    var tmpTitle = $(this).attr('title').toString();
                                    tmpTitle = tmpTitle.substr(tmpTitle.length - 4).replace('-', '');
                                    var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                                    $(this).html(event.strftime(totalHours + ':%M:%S'));
                                    var curTime = $(this).html();
                                    if(curTime == '0:00:00'){
                                        $("#lotterycurrent"+ps.lotteryId).html("等待开奖");
                                    }
                                });
                                if(response.curIssue.issueInfo.state > 1){
                                    $("#lotterycurrent"+ps.lotteryId).html("等待开奖");
                                }
                            }else{
                                $("#lotterycurrent"+ps.lotteryId).html("等待开盘");
                            }
                        }else{
                            $('.lottery_timer').each(function (){
                                var lottery_issue = $(this);
                                lottery_issue.text('等待开奖');
                            });
                        }
                        //执行下方倒计时
                        $("#thisIssueSpan").text(ps.curIssueInfo.issue);
                        $("#thisIssueSpan2").text(ps.curIssueInfo.issue);
                        var d = subTime(ps.curRemainTime);
                        if(ps.curRemainTime>=0 && response.curIssue.issueInfo.state == 1){//必须为1 和还剩时间才允许显示
                            drawBar.showIssueRemainTime(d);
                        }
                        runTime.showCurIssueTimer = window.setInterval(function () {
                            if(ps.curRemainTime>=0){//还没封盘
                                if(response.curIssue.issueInfo.state == 1){
                                    ps.canBuy = true;
                                    window.clearInterval(window.runTime.lock_alert_timer);
                                    $("#thisIssueTimerIcon").removeClass("lock").addClass('clock');
                                    $('#thisIssueTimerIcon').text('投注还剩');
                                    var d = subTime(--ps.curRemainTime);
                                }else{
                                    --ps.curRemainTime;
                                    ps.canBuy = false;
                                    drawBar.isOpen = true;//开启下一盘开启弹窗友好提示
                                    $('#thisIssueTimerIcon').text('等待开盘');
                                    $('#lastIssueSpan').html(parseInt(response.curIssue.lastIssueInfo.issue)+1);
                                    $("#nextTimeOpen").text('开奖中');
                                    var d = subTime(0);
                                    var codes = ps.lastIssueInfo.code.split(",");
                                    if(codes.length == 3){
                                        $(".donghua1").hide();
                                        $(".donghua2").hide();
                                        $(".donghua3").show();
                                        $(".ball5").hide();
                                        $(".ball10").hide();
                                    }
                                    if(codes.length == 5){
                                        $(".donghua3").hide();
                                        $(".donghua2").hide();
                                        $(".donghua1").show();
                                        $(".ball5").hide();
                                        $(".ball10").hide();
                                    }
                                    if(codes.length == 10){
                                        $(".donghua1").hide();
                                        $(".donghua3").hide();
                                        $(".donghua2").show();
                                        $(".ball5").hide();
                                        $(".ball10").hide();
                                    }
                                }
                                drawBar.showIssueRemainTime(d);
                                if(ps.curRemainTime %5 == 0){
                                    runTime.clearAll();
                                    drawBar.getCurIssue();
                                }
                            }else{
                                ps.canBuy = false;
                                $('#thisIssueTimerIcon').removeClass('clock').addClass('lock');
                                $('#thisIssueTimerIcon').text('开奖倒计时');
                                clearInterval(runTime.showCurIssueTimer);
                                if(drawBar.isOpen){
                                    // window.clearInterval(window.runTime.lock_alert_timer);
                                    // var lock_alert_time = ps.curWaitOpenTime;//友好提示
                                    var lock_alert_time = 3;//友好提示
                                    if(ps.curIssueInfo.issue.state == ''){
                                        $.layer({
                                            'title': '封盘提示', 'time': lock_alert_time,
                                            'dialog': {
                                                type: 7,
                                                msg: '暂无当前期，封盘中'
                                            }
                                            , 'btns': 1
                                            , btn: ['确定']
                                        });
                                    }else {
                                        $.layer({
                                            'title': '开奖倒计时提示', 'time': lock_alert_time,
                                            'dialog': {
                                                type: 7,
                                                msg: '第' + ps.curIssueInfo.issue + '期已经截止<br/>投注时请注意期号<br/><span id="lock_alert_timer">' + lock_alert_time + '</span>秒后自动关闭窗口'
                                            }
                                            , 'btns': 1
                                            , btn: ['确定']
                                        });
                                    }
                                    $(".xubox_botton1").click(function () {
                                        drawBar.isOpen = false;
                                        window.clearInterval(window.runTime.lock_alert_timer);
                                    });
                                }
                                // window.runTime.lock_alert_timer = window.setInterval(function () {
                                //     $("#lock_alert_timer").text(parseInt($("#lock_alert_timer").text()) - 1);
                                // }, 1000);
                                window.setTimeout(function () {
                                    drawBar.isOpen = false;
                                    window.clearInterval(window.runTime.lock_alert_timer);
                                }, 3);
                                //开始开奖倒计时
                                var d2 = subTime(ps.curWaitOpenTime);
                                drawBar.showIssueRemainTime(d2);
                                runTime.drawIssueTimer = window.setInterval(function (res){
                                    if(ps.curWaitOpenTime >=0){
                                        if(ps.curWaitOpenTime %5 == 0){
                                            runTime.clearAll();
                                            drawBar.getCurIssue();
                                        }
                                        var d2 = subTime(--ps.curWaitOpenTime);
                                        drawBar.showIssueRemainTime(d2);
                                        // console.log('开奖倒计时');
                                    }else{
                                        runTime.clearAll();
                                        console.log('开奖倒计时结束');
                                        drawBar.getCurIssue();
                                    }
                                },1000);
                            }
                        },1000);
                        ps.getLastOpenTime = 0;
                        clearInterval(runTime.getLastOpenTimer);
                        runTime.getLastOpenTimer = window.setInterval(drawBar.getLastOpen_Timer, 1000);
                        if (ps.lastIssueInfo.code == "") {
                            $("#thisIssueInfo").addClass("lock");
                            ps.canBuy = false;
                            $("#thisIssueSpan").text(ps.lastIssueInfo.issue);
                        } else {  //友好界面 1秒等待后显示
                            //更新最近一期数据，否则导致draw.init()中重复调用
                            var latest = ps.openedIssues[0];
                            if (ps.lastIssueInfo.length > 0 && ps.lastIssueInfo.issue != latest.issue) {
                                var tmp = ps.lastIssueInfo;
                                var ob = drawBar.getMoreInfo(tmp.code);
                                tmp.prop = ob;
                                ps.openedIssues.unshift(tmp);
                                ps.openedIssues.updateLast();
                            }
                        }
                      if(response.curIssue.issueInfo.state == 1){
                          ps.canBuy = true;
                      }else{
                          ps.canBuy = false;
                      }
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        $('.lottery_timer').each(function (){
                            var lottery_issue = $(this);
                            lottery_issue.text('封盘中');
                        });
                    }
                });
            },
            showIssueRemainTime: function (d) {
                //$("#thisIssueRemainTime").text(d.hour + ":" + d.minute + ":" + d.second);
                if (parseInt(d.day) >= 1) {
                    d.hour = parseInt(d.hour) + (parseInt(d.day) * 24);
                }
                var time_h = $("#thisIssueRemainTime .time_h");
                time_h.empty();
                time_h.html('<span class="time_' + d.hour.toString().charAt(0) + ' time_sp"></span><span class="time_' + d.hour.toString().charAt(1) + ' time_sp"></span>');
                var time_m = $("#thisIssueRemainTime .time_m");
                time_m.empty();
                time_m.html('<span class="time_' + d.minute.toString().charAt(0) + ' time_sp"></span><span class="time_' + d.minute.toString().charAt(1) + ' time_sp"></span>');
                var time_s = $("#thisIssueRemainTime .time_s");
                time_s.empty();
                time_s.html('<span class="time_' + d.second.toString().charAt(0) + ' time_sp"></span><span class="time_' + d.second.toString().charAt(1) + ' time_sp"></span>');
            },
            showCurIssue_Timer: function () {
                $("#thisIssueSpan").text(ps.curIssueInfo.issue);
                $("#thisIssueSpan2").text(ps.curIssueInfo.issue);
                var d2 = subTime(ps.curRemainTime);
                drawBar.showIssueRemainTime(d2);
                runTime.showCurIssueTimer =  window.setInterval(function(){
                    if (ps.curIssueInfo.state == 1) {
                        var d = subTime(--ps.curRemainTime);
                        var curRemainTime = ps.curRemainTime;
                        if(curRemainTime%5 == 0){
                            runTime.clearAll();
                            drawBar.getCurIssue();
                        }
                        $("#thisIssueTimerIcon").removeClass("lock").addClass('clock');
                        $('#thisIssueTimerIcon').text('投注还剩');
                        drawBar.showIssueRemainTime(d);
                    } else {
                        // clearInterval(runTime.remainTimer);
                        $('#thisIssueTimerIcon').removeClass('clock').addClass('lock');
                        $('#thisIssueTimerIcon').text('开奖倒计时');
                        // var lock_alert_time = ps.curWaitOpenTime;
                        var lock_alert_time = 8;//友好提示 10s
                        window.runTime.lock_alert_timer = window.setInterval(function () {
                            $("#lock_alert_timer").text(parseInt($("#lock_alert_timer").text()) - 1);
                        }, 1000);
                        window.setTimeout(function () {
                            window.clearInterval(window.runTime.lock_alert_timer);
                        }, lock_alert_time * 1000);
                        var d2 = subTime(ps.curWaitOpenTime);
                        drawBar.showIssueRemainTime(d2);
                        console.log(ps.curWaitOpenTime);
                        if(ps.curWaitOpenTime%5 == 0){
                            runTime.clearAll();
                            drawBar.getCurIssue();
                        }

                    }
                },1000);
            },
            //显示锁倒计时
            waitOpen_Timer: function () {
                --ps.curWaitOpenTime;
                var d = subTime(ps.curWaitOpenTime);
                drawBar.showIssueRemainTime(d);
                if (ps.curWaitOpenTime < 0) {
                    clearInterval(runTime.showCurIssueTimer);
                    clearInterval(runTime.waitOpenTimer);
                    drawBar.getCurIssue(drawBar.init);
                }
            },
            getLastOpen_Timer: function () {
                ps.getLastOpenTime++;
                //console.info("ps.getLastOpenTime计时器=" + ps.getLastOpenTime);
                //每10秒更新一次
                if (ps.getLastOpenTime % 5 == 0) {
                    if (lastIssueInfo != -1) {
                        if (typeof (lastIssueInfo.code) != "undefined" && lastIssueInfo.issue != ps.openedIssues[0].issue) {
                            //clearInterval(runTime.getLastOpenTimer);
                            ps.getLastOpenTime = 0;
                            //更新最近一期数据，否则导致draw.init()中重复调用
                            ps.lastIssueInfo = lastIssueInfo.issue_id;
                            var ob = drawBar.getMoreInfo(lastIssueInfo.code);
                            lastIssueInfo.prop = ob;
                            ps.openedIssues.unshift(lastIssueInfo);
                            ps.openedIssues.updateLast();
                            drawBar.showLastDraw();
                        } else {
                            // layer.alert("开号数据不存在1");
                        }
                    } else {
                        layer.alert("开号数据不存在");
                    }
                }
            },
            //显示上一期开奖结果
            showLastDraw: function () {
                var latest = ps.openedIssues[0];
                $("#lastIssueSpan").text(latest.issue);
                $("#nextTimeOpen").text('开奖结果');
                if(donghua){
                    $(".donghua3").hide();
                    $(".donghua2").hide();
                    $(".donghua1").hide();
                    var nums = [];
                    if (ps.lotteryType == 1 || ps.lotteryType == 4 || ps.lotteryType == 6 || ps.lotteryType == 9) {
                        nums = latest.code.split("");
                    } else if (ps.lotteryType == 2 || ps.lotteryType == 7 || ps.lotteryType == 8 || ps.lotteryType == 10) {
                        nums = latest.code.split(",");
                    }
                    else {
                        throw '无效的数据引用';
                    }
                    if (ps.lotteryType == 8 || ps.lotteryType == 9) {
                        $(".ball5").hide();
                        $(".ball10").empty().show();
                        for (var i in nums) {
                            $(".ball10").append('<span class="kj_small_ball' + parseInt(nums[i], 10) + ' kj_ball_sp"></span>');
                        }
                    }
                    else if (ps.lotteryType == 10) {
                        $(".ball5").hide();
                        $(".ball10").empty().show();
                        for (var i in nums) {
                            if (i == 6) {
                                $(".ball10").append('<span class="kj_lhc_ball_pos">+</span>');
                            }
                            $(".ball10").append('<span class="kj_lhc_ball' + parseInt(nums[i], 10) + ' kj_lhc_ball_pos' + i + ' kj_ball_sp">' + nums[i] + '</span>');
                        }
                    }
                    else {
                        $(".ball5").empty().show();
                        $(".ball10").hide();
                        for (var i in nums) {
                            $(".ball5").append('<span class="kj_ball' + parseInt(nums[i], 10) + ' kj_ball_sp"></span>');
                        }
                    }
                    donghua = 0;
                }else{
                    var codes = latest.code.split(",");
                    if(codes.length == 3){
                        $(".donghua1").hide();
                        $(".donghua2").hide();
                        $(".donghua3").show();
                        $(".ball5").hide();
                        $(".ball10").hide();
                    }
                    if(codes.length == 5){
                        $(".donghua3").hide();
                        $(".donghua2").hide();
                        $(".donghua1").show();
                        $(".ball5").hide();
                        $(".ball10").hide();
                    }
                    if(codes.length == 10){
                        $(".donghua1").hide();
                        $(".donghua3").hide();
                        $(".donghua2").show();
                        $(".ball5").hide();
                        $(".ball10").hide();
                    }
                    setTimeout(function (res) {
                        //用户余额
                        showBalance();
                        $(".donghua1").hide();
                        $(".donghua2").hide();
                        $(".donghua3").hide();
                        var nums = [];
                        if (ps.lotteryType == 1 || ps.lotteryType == 4 || ps.lotteryType == 6 || ps.lotteryType == 9) {
                            nums = latest.code.split("");
                        } else if (ps.lotteryType == 2 || ps.lotteryType == 7 || ps.lotteryType == 8 || ps.lotteryType == 10) {
                            nums = latest.code.split(",");
                        }
                        else {
                            throw '无效的数据引用';
                        }
                        if (ps.lotteryType == 8 || ps.lotteryType == 9) {
                            $(".ball5").hide();
                            $(".ball10").empty().show();
                            for (var i in nums) {
                                $(".ball10").append('<span class="kj_small_ball' + parseInt(nums[i], 10) + ' kj_ball_sp"></span>');
                            }
                        }
                        else if (ps.lotteryType == 10) {
                            $(".ball5").hide();
                            $(".ball10").empty().show();
                            for (var i in nums) {
                                if (i == 6) {
                                    $(".ball10").append('<span class="kj_lhc_ball_pos">+</span>');
                                }
                                $(".ball10").append('<span class="kj_lhc_ball' + parseInt(nums[i], 10) + ' kj_lhc_ball_pos' + i + ' kj_ball_sp">' + nums[i] + '</span>');
                            }
                        }
                        else {
                            $(".ball5").empty().show();
                            $(".ball10").hide();
                            for (var i in nums) {
                                $(".ball5").append('<span class="kj_ball' + parseInt(nums[i], 10) + ' kj_ball_sp"></span>');
                            }
                        }
                    },1000);
                    $('.kj_right_btn_myFa').click();
                    $('.kj_right_btn_myZh').click();
                }
                // $(".donghua1").hide();
                // $(".donghua2").hide();
                // $(".donghua3").show();
                // $(".ball5").hide();
                // $(".ball10").hide();
            },
            getMoreInfo: function (code) {   //得到扩展信息
                var $result = {};
                if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                    var nums = code.split("");
                    $result.qshz = parseInt(nums[0]) + parseInt(nums[1]) + parseInt(nums[2]);
                    $result.qszt = drawBar.zutai(nums[0], nums[1], nums[2]);
                    $result.hshz = parseInt(nums[2]) + parseInt(nums[3]) + parseInt(nums[4]);
                    $result.hszt = drawBar.zutai(nums[2], nums[3], nums[4]);
                    $result.hehz = parseInt(nums[3]) + parseInt(nums[4]);
                    $result.dxds = drawBar.dxds(nums[3], nums[4]);
                    $result.daxiao = drawBar.daxiao(new Array(nums[2], nums[3], nums[4]));
                    $result.danshuang = drawBar.danshuang(new Array(nums[2], nums[3], nums[4]));
                }
                else if (ps.lotteryType == 2) {
                    var nums = code.split("");
                    $result.daxiao = drawBar.daxiao(nums);
                    $result.danshuang = drawBar.danshuang(nums);
                }
                else if (ps.lotteryType == 6) {
                    var nums = code.split(",");
                    $result.leixing = drawBar.leixing(nums);
                    $result.qshz = parseInt(nums[0]) + parseInt(nums[1]) + parseInt(nums[2]);
                }
                else if (ps.lotteryType == 7) {
                    var nums = code.split(" ");
                    $result.pkzt = drawBar.pokerZutai(nums[0], nums[1], nums[2]);
                }
                else if (ps.lotteryType == 8) {
                    // var nums = code.split(" ");
                    // $result.xt = drawBar.pk10xt(nums[0], nums[1], nums[2], nums[3], nums[4], nums[5], nums[6], nums[7], nums[8], nums[9]);
                }

                return $result;
            },
            translateCards: function ($nums) {
                var $result = [], $tmp;
                for (var i = 0; i < $nums.length; i++) {
                    $tmp = {num: "", className: ""};
                    switch ($nums[i].charAt(0)) {
                        case 'T':
                            $tmp.num = '10';
                            break;
                        default :
                            $tmp.num = $nums[i].charAt(0);
                            break;
                    }

                    switch ($nums[i].charAt(1)) {
                        case 's':
                            $tmp.className = 'poker_heit';
                            break;
                        case 'h':
                            $tmp.className = 'poker_hongt';
                            break;
                        case 'c':
                            $tmp.className = 'poker_meih';
                            break;
                        case 'd':
                            $tmp.className = 'poker_fangk';
                            break;
                        default :
                            throw 'unknown color';
                            break;
                    }
                    $result.push($tmp);
                }

                return $result;
            },
            zutai: function (a, b, c) {
                if (a == b && a == c && b == c) {
                    return "豹子"
                } else {
                    if (a == b || a == c || b == c) {
                        return "组三"
                    } else {
                        return "组六"
                    }
                }
            },
            dxds: function (n1, n2) {
                var a = [], b = [];
                a.push(n1 >= 5 ? "大" : "小");
                a.push(n1 % 2 == 1 ? "单" : "双");
                b.push(n2 >= 5 ? "大" : "小");
                b.push(n2 % 2 == 1 ? "单" : "双");
                return [a[0] + b[0], a[0] + b[1], a[1] + b[0], a[1] + b[1]].join(",")
            },
            daxiao: function (nums) {
                var da = 0, xiao = 0;

                for (var n in nums) {

                    if (parseInt(nums[n]) >= 5) {
                        da += 1;
                    }
                    else {
                        xiao += 1;
                    }
                }


                return da + ":" + xiao;
            },
            danshuang: function (nums) {
                var dan = 0, shuang = 0;
                for (var n in nums) {
                    if (parseInt(nums[n]) % 2 != 0) {
                        dan += 1;
                    }
                    else {
                        shuang += 1;
                    }
                }

                return dan + ":" + shuang;
            },
            leixing: function (nums) {
                if (nums[0] + 1 == nums[1] && nums[1] + 1 == nums[2]) {
                    return '三连号';
                }
                if (nums[0] == nums[1] && nums[1] == nums[2]) {
                    return '三同号';
                }
                if (nums[0] == nums[1] || nums[0] == nums[2] || nums[1] == nums[2]) {
                    return '二同号';
                }
                return '三不同号';


//二同号：7次二不同号：18次
//三同号：0次三不同号：11次
//三连号：5次

            },
            //扑克组态
            pokerZutai: function (a, b, c) {
                if (a.charAt(0) == b.charAt(0) && a.charAt(0) == c.charAt(0) && b.charAt(0) == c.charAt(0)) {
                    return "豹子";
                } else if (a.charAt(1) == b.charAt(1) && a.charAt(1) == c.charAt(1) && b.charAt(1) == c.charAt(1) && helper.pokerNumMaps[a] + 1 == helper.pokerNumMaps[b] && helper.pokerNumMaps[b] + 1 == helper.pokerNumMaps[c]) {
                    return "同花顺";
                } else if (a.charAt(1) == b.charAt(1) && a.charAt(1) == c.charAt(1) && b.charAt(1) == c.charAt(1)) {
                    return "同花";
                } else if (helper.pokerNumMaps[a] + 1 == helper.pokerNumMaps[b] && helper.pokerNumMaps[b] + 1 == helper.pokerNumMaps[c]) {
                    return "顺子";
                } else if (a.charAt(0) == b.charAt(0) || b.charAt(0) == c.charAt(0)) {
                    return "对子";
                }
                else {
                    return "散牌";
                }
            },
            pk10xt: function (a, b, c) {
                if (a.charAt(0) == b.charAt(0) && a.charAt(0) == c.charAt(0) && b.charAt(0) == c.charAt(0)) {
                    return "豹子";
                } else if (a.charAt(1) == b.charAt(1) && a.charAt(1) == c.charAt(1) && b.charAt(1) == c.charAt(1) && helper.pokerNumMaps[a] + 1 == helper.pokerNumMaps[b] && helper.pokerNumMaps[b] + 1 == helper.pokerNumMaps[c]) {
                    return "同花顺";
                } else if (a.charAt(1) == b.charAt(1) && a.charAt(1) == c.charAt(1) && b.charAt(1) == c.charAt(1)) {
                    return "同花";
                } else if (helper.pokerNumMaps[a] + 1 == helper.pokerNumMaps[b] && helper.pokerNumMaps[b] + 1 == helper.pokerNumMaps[c]) {
                    return "顺子";
                } else if (a.charAt(0) == b.charAt(0) || b.charAt(0) == c.charAt(0)) {
                    return "对子";
                }
                else {
                    return "散牌";
                }
                return '龙';
            }
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

        if (!verifyParams()) {
            layer.alert("彩种或者玩法的参数错误");
            return false
        }
        initPrizeBar();
        initModesBar();
        initMethodBar();
        initMissHotBar();
        initBuyBar();
        initDrawBar();

        //判断是否每区都有值
        function allHasValue(cds) {
            var flag = 1, charsNum = 0;
            $.each(cds, function (k, v) {
                charsNum += v.length;
                if (v.length == 0) {
                    flag = 0;
                }
            });
            return {
                flag: flag,
                charsNum: charsNum
            };
        }

        var isLegalCode = function (codes) {
            //低版本IE没有console,为安全的使用console用前需判断
            //if(window.console && console.log){
            //    console.log(codes);
            //}
            //这一段加上否则直选和值类玩法不选号也能添加
            if (allHasValue(codes)['charsNum'] == 0) {
                return {
                    singleNum: 0,
                    isDup: 0
                };
            }

            var singleNum = 0, isDup = 0, parts;
            switch (ps.curMethod.name) {
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
                    //每区都必须有数字
                    if (allHasValue(codes)['flag'] == 0) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
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
                    $.each(parts, function (k, v) {
                        singleNum += helper.SXBD[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'SXHHZX':    //三星混合组选 仅支持单式粘贴号码 12,34,567
                case "ZSHHZX":
                case 'QSHHZX':    //前三混合组选 仅支持单式粘贴号码 12,34,567
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
                    //每区都必须有数字
                    if (allHasValue(codes)['flag'] == 0) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }

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
                    $.each(parts, function (k, v) {
                        singleNum += helper.EXBD[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'YXZX':    //一星直选
                case 'WXYFFS':    //一星直选
                case 'WXHSCS':    //一星直选
                case 'WXSXBX':    //一星直选
                case 'WXSJFC':    //一星直选
                case 'SXHZWS':    //3星尾数
                case 'QSHZWS':    //前3尾数
                case 'ZSHZWS':    //前3尾数
                case 'ZSYMBDW':    //一定位
                case 'SSCQSYMBDW':    //一定位
                case 'SXYMBDW':    //一定位
                    singleNum = codes[0].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXDW':    //五星定位
                    singleNum = codes[0].length + codes[1].length + codes[2].length + codes[3].length + codes[4].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXEMBDW':    //五星2定位
                case 'ZSEMBDW':    //2定位
                case 'SSCQSEMBDW':    //2定位
                case 'SXEMBDW':    //2定位
                    if (codes[0].length < 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) / 2;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;

                case 'WXSMBDW':    //五星3定位

                    if (codes[0].length < 3) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) * (codes[0].length - 2) / 6;
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
                    $.each(parts, function (k, v) {
                        singleNum += helper.SXHZ[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;

                case 'SXTSH'://三星特殊号
                case 'ZSTSH'://中三特殊号
                case 'QSTSH'://前三特殊号
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    break;
                case 'WXLHH'://
                case 'WXHZDXDS'://
                    singleNum = codes[0].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXZXKD'://3星跨度
                case 'QSZXKD'://前3跨度
                case 'ZSZXKD'://中三跨度
                    parts = codes[0].toString().split("");

                    $.each(parts, function (k, v) {
                        singleNum += helper.SXZXKD[v];
                    });

                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'EXZXKD'://2星跨度
                case 'QEZXKD'://前2跨度
                    parts = codes[0].toString().split("");
                    $.each(parts, function (k, v) {
                        singleNum += helper.EXZXKD[v];
                    });

                    isDup = parts.length > 1 ? 1 : 0;
                    break;


                case 'EXHZ':    //二星和值 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
                case 'QEHZ':
                    parts = codes[0].split('_');
                    $.each(parts, function (k, v) {
                        singleNum += helper.EXHZ[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'SXZXHZ':  //低频3D特有 组选和值
                case 'QSZXHZ':  //低频P3P5特有 组选和值
                    parts = codes[0].split('_');
                    $.each(parts, function (k, v) {
                        singleNum += helper.SXZXHZ[v];
                    });
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'SIXZX':    //四星直选 12,34,567
                case 'QSIZX':    //前四直选
                    if (isNaN(codes[0]) || isNaN(codes[1]) || isNaN(codes[2]) || isNaN(codes[3])) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * codes[1].length * codes[2].length * codes[3].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZX':    //五星直选
                    if (isNaN(codes[0]) || isNaN(codes[1]) || isNaN(codes[2]) || isNaN(codes[3]) || isNaN(codes[4])) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    //算注数 相乘即可
                    singleNum = codes[0].length * codes[1].length * codes[2].length * codes[3].length * codes[4].length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZUX120':    //组选120
                    if (codes[0].length < 5) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) * (codes[0].length - 2) * (codes[0].length - 3) * (codes[0].length - 4) / helper.factorial(5);
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZUX60':    //组选60
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 3) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length * (codes[1].length - 1) * (codes[1].length - 2) / helper.factorial(3);
                    if (sameNum > 0) {
                        singleNum -= sameNum * (codes[1].length - 1) * (codes[1].length - 2) / helper.factorial(2);
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZUX30':    //组选30
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[1].length * codes[0].length * (codes[0].length - 1) / helper.factorial(2);
                    if (sameNum > 0) {
                        singleNum -= sameNum * (codes[0].length - 1);
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZUX20':    //组选30
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length * (codes[1].length - 1) / helper.factorial(2);
                    if (sameNum > 0) {
                        singleNum -= sameNum * (codes[1].length - 1);
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZUX10':    //组选10
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length;
                    if (sameNum > 0) {
                        singleNum -= sameNum;
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXZUX5':    //组选5
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length;
                    if (sameNum > 0) {
                        singleNum -= sameNum;
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXZUX24':    //组选24
                    if (codes.length != 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 4) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) * (codes[0].length - 2) * (codes[0].length - 3) / helper.factorial(4);
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXZUX12':    //组选12
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length * (codes[1].length - 1) / helper.factorial(2);
                    if (sameNum > 0) {
                        singleNum -= sameNum * (codes[1].length - 1);
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXZUX6':    //组选6
                    if (codes.length != 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) / helper.factorial(2);
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'SXZUX4':    //组选6
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }

                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length;
                    if (sameNum > 0) {
                        singleNum -= sameNum;
                    }
                    break;
                case 'RSZU6':    //任选三组六
                    var zsNum = RxPos.getNumRxPos(3);
                    singleNum = codes[0].length * (codes[0].length - 1) * (codes[0].length - 2) / helper.factorial(3);
                    singleNum = singleNum > 0 ? singleNum : 0;
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'REZXHZ':    //任二直选和值
                    var zsNum = RxPos.getNumRxPos(2);
                    parts = codes[0].split('_');
                    $.each(parts, function (k, v) {
                        singleNum += helper.EXHZ[v];
                    });
                    singleNum = zsNum * singleNum;
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'REZUX':    //任二组选
                    var zsNum = RxPos.getNumRxPos(2);
                    singleNum = codes[0].length * (codes[0].length - 1) / helper.factorial(2);
                    singleNum = singleNum > 0 ? singleNum : 0;
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'REZUXHZ':
                    var zsNum = RxPos.getNumRxPos(2);
                    parts = codes[0].split('_');
                    $.each(parts, function (k, v) {
                        singleNum += helper.EXZUHZ[v];
                    });
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'RSZXHZ':
                    var zsNum = RxPos.getNumRxPos(3);
                    parts = codes[0].split('_');
                    $.each(parts, function (k, v) {
                        singleNum += helper.SXHZ[v];
                    });
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'RSZU3':
                    var zsNum = RxPos.getNumRxPos(3);
                    singleNum = codes[0].length * (codes[0].length - 1);
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 2 ? 1 : 0;
                    break;
                case 'RSZUXHZ':
                    var zsNum = RxPos.getNumRxPos(3);
                    parts = codes[0].split('_');
                    $.each(parts, function (k, v) {
                        singleNum += helper.SXZXHZ[v];
                    });
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'RSHHZX':
                    if (codes[0] == codes[1] && codes[0] == codes[2]) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var zsNum = RxPos.getNumRxPos(3);
                    singleNum = codes[0].length * codes[1].length * codes[2].length;
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'R4ZX':
                    var zsNum = 1;
                    if (codes.length == 4) {
                        if (isNaN(codes[0]) || isNaN(codes[1]) || isNaN(codes[2]) || isNaN(codes[3])) {
                            return {
                                singleNum: 0,
                                isDup: 0
                            };
                        }

                        zsNum = RxPos.getNumRxPos(4);
                        singleNum = codes[0].length * codes[1].length * codes[2].length * codes[3].length;
                        singleNum = zsNum * singleNum;
                    }
                    else {
                        var rightPos = [];
                        for (var i = 0; i < 5; i++) {
                            if (codes[i] != '') {
                                rightPos.push(i);
                            }
                        }
                        if (rightPos.length < 4) {
                            return {
                                singleNum: 0,
                                isDup: 0
                            };
                        }
                        singleNum = 0;
                        var tmp = [rightPos.join('_'), rightPos.join('_'), rightPos.join('_'), rightPos.join('_')];
                        var zuhe = helper.countNums(tmp, 2);
                        if (zuhe) {
                            for (var i = 0; i < zuhe.length; i++) {
                                var pos = zuhe[i].split('_');
                                if (pos.length != 4) {
                                    return {
                                        singleNum: 0,
                                        isDup: 0
                                    };
                                }
                                singleNum += codes[pos[0]].length * codes[pos[1]].length * codes[pos[2]].length * codes[pos[3]].length;
                            }
                        }
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'R4ZUX24':
                    zsNum = RxPos.getNumRxPos(4);
                    if (codes.length != 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 4) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) * (codes[0].length - 2) * (codes[0].length - 3) / helper.factorial(4);
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'R4ZUX12':
                    zsNum = RxPos.getNumRxPos(4);
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length * (codes[1].length - 1) / helper.factorial(2);
                    if (sameNum > 0) {
                        singleNum -= sameNum * (codes[1].length - 1);
                    }


                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'R4ZUX6':
                    zsNum = RxPos.getNumRxPos(4);
                    if (codes.length != 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = codes[0].length * (codes[0].length - 1) / helper.factorial(2);
                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'R4ZUX4':
                    zsNum = RxPos.getNumRxPos(4);
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[0].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    if (codes[1].length < 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var sameNum = 0;
                    for (var i = 0; i < codes[0].length; i++) {
                        if (codes[1].indexOf(codes[0].charAt(i)) != -1) {
                            sameNum++;
                        }
                    }
                    singleNum = codes[0].length * codes[1].length;
                    if (sameNum > 0) {
                        singleNum -= sameNum;
                    }

                    singleNum = zsNum * singleNum;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'WXLX':    //五星连选
                    //每区都必须有数字
                    if (allHasValue(codes)['flag'] == 0) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }

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
                case 'REZX':    //任二直选
                    var n = 4; //5!
                    for (var i = 0; i < 4; i++) {
                        //如果注码不写'-'的话可以省略两个if判断,效率差不多
                        if (codes[i] != '-') {
                            for (var j = (i + 1); j < 5; j++) {
                                if (codes[j] != '-') {
                                    singleNum += codes[i].length * codes[j].length;
                                }
                            }
                        }
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'RSZX':    //任三直选		xxxxxx
                    for (var i = 0; i < 3; i++) {
                        if (codes[i] != '-') {
                            for (var j = (i + 1); j < 4; j++) {
                                if (codes[j] != '-') {
                                    for (var k = (j + 1); k < 5; k++) {
                                        if (codes[k] != '-') {
                                            singleNum += codes[i].length * codes[j].length * codes[k].length;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
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
                    $.each(codes, function (k, v) {
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
                //江苏快三
                case 'JSETDX':  //二同单选 2个号区 11_22,34
                    if (codes.length != 2) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    var parts0 = codes[0].length ? codes[0].split('_') : [];
                    var parts1 = codes[1].length ? codes[1].split('') : [];
                    singleNum = parts0.length * parts1.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'JSETFX':  //二同复选 1个号区 11_22_33
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'JSHZ':    //快三和值
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'JSSTTX':    //快三   江苏三同号通选
                    //parts = codes[0].split('_');	//111_222_333_444_555_666
                    singleNum = 1;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'JSSLTX'://快三三连号通选
                    singleNum = 1;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                case 'JSEBT':   //二不同号
                    var codesLen = codes[0].length;
                    singleNum = (codesLen - 1) * codesLen / 2;
                    isDup = codesLen > 2 ? 1 : 0;
                    break;
                case 'JSSTDX':   //三同号单选
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = parts.length > 1 ? 1 : 0;
                    break;
                case 'JSSBT':   //三不同号
                    var codesLen = codes[0].length;
                    singleNum = (codesLen - 1) * (codesLen - 2) * codesLen / 6;
                    isDup = codesLen > 3 ? 1 : 0;
                    break;
                //快乐扑克
                case 'PKSZ'://顺子
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                //pk10
                case 'PKQYZX':  //前一直选 01_02_03_04,02_03,01_05
                    if (codes.length != 1) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    parts = codes[0].split('_');
                    singleNum = parts.length;
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                //pk10
                case 'PKQELX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQSLX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ4LX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ5LX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ6LX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ7LX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ8LX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ9LX':  //猜冠亚 01_02_03_04,02_03,01_05
                case 'PKQ10LX':  //猜冠亚 01_02_03_04,02_03,01_05
                    var length = propLen(ps.curMethod.field_def);
                    if (codes.length != length) {
                        return {
                            singleNum: 0,
                            isDup: 0
                        };
                    }
                    singleNum = helper.countNums(codes);
                    isDup = singleNum > 1 ? 1 : 0;
                    break;
                default:
                    throw "unfinished method " + ps.curMethod.name;
                    break;
            }

            return {
                singleNum: singleNum,
                isDup: isDup
            };
        };
    }
})(jQuery);