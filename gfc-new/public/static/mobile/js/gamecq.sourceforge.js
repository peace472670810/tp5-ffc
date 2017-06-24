/**
 * 游戏界面JS v1.3
 * jQuery 1.4.1 or above
 * Copyright (c) 2013 william(william990804#gmail.com)
 * Dual licensed under the MIT and GPL licenses.
 *
 * 调试好的文件，在http://tool.chinaz.com/Tools/JsFormat.aspx 有压缩工具进行加密压缩，替换gamecq.js
 *
 * 玩法基本属性：
 几个号段组成最少投注，最少多少注;
 时时调用methods::isLegalCode()检查是否合法投注，且返回注数
 根据不同玩法展示投注界面：
 几个选区
 array(
 array(
 'nums'  => '0 1 2 3 4 5 6 7 8 9',   //号码列表
 'multi' => 1,   //是否可多选
 'prompt'    => '百位',    //前导提示符
 'has_filter_btn' => 1,  //是否显示筛选按钮
 ),
 )

 号码表示方法：号区之间用,分隔，同区内号码之间一般不用分隔符，若可能有2位表示的，用_分隔（如和值玩法或sd11y）
 注单表示方法（改进版）：String codes = "46:1,2,3,4,5|6,7,8,9,0|1,2,3,4,5#43:1,2,3|6,7,0";

 修改历史：
 3000注5星直选 网络传输量451k
 3000注5星直选 网络传输量75k 解码后39k	格式46:1,2,3,4,5|46:6,7,8,9,0|46:1,2,3,4,5
 3000注5星直选 网络传输量60k 解码后30k	格式46:1,2,3,4,5|6,7,8,9,0|1,2,3,4,5#43:1,2,3|6,7,0

 jq Tip:
 1.find()是在孩子结点中条件查找，filter是用于在一个集合中进行筛选，不处理子结点。不能用于同级别元素的条件筛选，要么先parent()再find()，要么用filter()
 如查找具有某一属性的结点：filter('[mode='+ps.curMode+']')
 var ob = $('<div><span>aa</span><span>bb</span><input value="123"/></div> <div class="me"><span>cc</span><span>dd</span><input value="456"/></div></div>');
 console.info(ob.children().length); //返回6 children()返回所有子结点
 console.info(ob.filter('input').val()); //返回undefined 当前集合只有2个div
 console.info(ob.filter('.me').html()); //返回<span>cc</span><span>dd</span><input value="456"> 从当前集合查找有me类的div元素集合
 console.info(ob.children().filter('input').val()); //123 找到2个结点，val()输出第一个结点的值
 console.info(ob.children().filter('input:eq(1)').val()); //456 输出第2个input的值
 console.info(ob.find('input').val()); //123 成功找到input结点，val()输出第一个结点的值
 console.info(ob.find('input:eq(0)').val()); //123
 console.info(ob.find('input:eq(1)').val()); //undefined 奇怪的问题，为何返回undefined
 console.info(ob.find('input:first').val()); //123
 console.info(ob.find('input:last').val());  //456
 console.info(ob.find('input').eq(1).val()); //456
 $.each(ob.find('input'), function(k,v){
 console.info(k);
 });

 2.empty()和remove()的区别在于前者是移除所有子节点，后者是移除包括自身
 3.ie6下iframe中操作父框架不支持appendTo()，也不支持$('#id').append(jQuery对象)，仅支持$('#id').append('html')
 */

if (typeof(console) != "object") {
    var console = {
        info: function(a) {
            window.status = a;
        }
    }
}
var runTime = {
    remainTimer: 0,
    waitOpenTimer: 0,
    getLastOpenTimer: 0,
    scollTopIntervalTimer: 0,
    clearAll: function() {
        clearInterval(runTime.remainTimer);
        clearInterval(runTime.waitOpenTimer);
        clearInterval(runTime.getLastOpenTimer);
        clearInterval(runTime.scollTopIntervalTimer);
    }
};
(function($) {
    $.init = function(settings) {
        //检查传过来的参数的正确性
        var verifyParams = function() {
            var flag = 0;
            if (settings.lotteryId == undefined || !is_numeric(settings.lotteryId) || settings.lotteryId <= 0) {
                flag = -1;
            }
            else if (settings.lotteryName == undefined || settings.lotteryName == '') {
                flag = -2;
            }
            else if (settings.lotteryType == undefined || !is_numeric(settings.lotteryType) || $.inArray(settings.lotteryType, [1,2,4,5]) == -1) {
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
                //console.info('参数错误：flag='+flag);
            }
            return flag == 0;
        };

        var ps = $.extend({
            //应传过来的设置
            lotteryId: 1,
            lotteryName: 'CQSSC',
            lotteryType: 1, //采种类型
            //startIssueInfo: {issue_id: '11444', issue:'20130131-080', 'end_time': '2013/01/31 19:14:10', 'input_time': '2013/01/31 19:14:20'},
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
            halt: function(msg) {    //致命错误处理
                alert(msg + '!');
                throw msg;
            },
            //运行时变量
            curIssueInfo: {}, //当前奖期{ issue_id="15712", issue="20130201-070", end_time="2013-02-01 17:48:30", input_time=2013-02-01 17:50:30"}
            lastIssueInfo: {}, //上一期{ issue_id="15712", issue="20130201-070", code="96983"}
            curMode: 0, //当前选择的元角分模式
            //curRebate: 0,       //当前选择的返点值=ps.rebateGapList[ps.curPrizeIndex].rebate，这里不再需要
            curMethod: {}, //当前选择的玩法
            curProjects: [], //当前投注栏内容
            nextProjectCounter: 0, //投注栏计数器
            curPrizeIndex: -1, //当前选择的返点在rebateGapList数组的下标
            rebateGapList: [], //计算出来的滑动奖金列表
            todayDrawList: [], //今天已开奖奖期
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


        //判断是否每区都有值
        function allHasValue(cds) {
            var flag = 1, charsNum = 0;
            $.each(cds, function(k, v) {
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
        
        var isLegalCode = function(codes) {

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
        };

        var initModesBar = function() {
            var tmpMode = 1;
            var mod = parseFloat(getCookie("mod_" + ps.lotteryId));
            $.each([1, 0.1, 0.01],
                    function(k, v) {
                        if (v == mod) {
                            tmpMode = v;
                        }
                    });
            ps.curMode = tmpMode;
            $('<div><span mode="1">元</span><span mode="0.1">角</span><span mode="0.01">分</span></div>').prependTo("#modesDIV");
            $("#modesDIV div").click(modesBar.modesBtn_Click).find("[mode=" + tmpMode + "]").show().siblings().hide();
        };

        var modesBar = {
            //点击模式按钮事件
            modesBtn_Click: function() {
                var curModeSpan = $(this).find(':visible');
                if ($('#projectList').children('li').length > 0) {
                    $.confirm('切换元角分模式将影响您现有投注项，是否继续？', function() {
                        //更新当前选择的模式
                        if (curModeSpan.attr('mode') == 1) {
                            ps.curMode = 0.1;
                            curModeSpan.parent().children().hide();
                            curModeSpan.siblings('[mode=' + ps.curMode + ']').show();
                        }
                        else if (curModeSpan.attr('mode') == 0.1) {
                            ps.curMode = 0.01;
                            curModeSpan.parent().children().hide();
                            curModeSpan.siblings('[mode=' + ps.curMode + ']').show();
                        }
                        else if (curModeSpan.attr('mode') == 0.01) {
                            ps.curMode = 1;
                            curModeSpan.parent().children().hide();
                            curModeSpan.siblings('[mode=' + ps.curMode + ']').show();
                        }
                        //console.info("您选择了" + curModeSpan.text() + "模式");
                        //加上选择样式
                        curModeSpan.parent().children().removeClass('colorRed').filter('[mode=' + ps.curMode + ']').addClass('colorRed');
                        //重新计算投注区金额
                        buyBar.updateTotalSingle();
                        //重置所有小球为未选择的状态
                        ballBar.reset();
                        //保存所选模式
                        modesBar.saveLastModes();
                        prizeBar.showPirze();   //每点一下应更新对应的玩法
                    });
                }
                else {
                    //更新当前选择的模式
                    if (curModeSpan.attr('mode') == 1) {
                        ps.curMode = 0.1;
                        curModeSpan.parent().children().hide();
                        curModeSpan.siblings('[mode=' + ps.curMode + ']').show();
                    }
                    else if (curModeSpan.attr('mode') == 0.1) {
                        ps.curMode = 0.01;
                        curModeSpan.parent().children().hide();
                        curModeSpan.siblings('[mode=' + ps.curMode + ']').show();
                    }
                    else if (curModeSpan.attr('mode') == 0.01) {
                        ps.curMode = 1;
                        curModeSpan.parent().children().hide();
                        curModeSpan.siblings('[mode=' + ps.curMode + ']').show();
                    }
                    //console.info("您选择了 " + $(this).find(':visible').text() + "模式,ps.curMode="+ps.curMode);
                    //加上选择样式
                    //curModeSpan.parent().children().removeClass('colorRed').filter('[mode=' + ps.curMode + ']').addClass('colorRed');
                    //重置所有小球为未选择的状态
                    ballBar.reset();
                }
                //保存所选模式
                modesBar.saveLastModes();
                prizeBar.showPirze();   //每点一下应更新对应的玩法
            },
            saveLastModes: function() {  //目前是保存到cookie里面
                setCookie('mod_' + ps.lotteryId, ps.curMode, 30 * 86400);
            }
        };

        //1.2 滑动奖金栏
        var initPrizeBar = function() {
            ps.rebateGapList = prizeBar.generateGapList();
            ps.curPrizeIndex = 0;
            var reb = getCookie("reb_" + ps.lotteryId);
            $.each(ps.rebateGapList,
                    function(k, v) {
                        if (reb == v.rebate) {
                            ps.curPrizeIndex = k
                        }
                    });
            if (ps.curPrizeIndex == undefined) {
                ps.halt("initPrizeBar failed")
            }
            $("#addPrizeBtn").bind("click", prizeBar.plusPrize);
            $("#subPrizeBtn").bind("click", prizeBar.minusPrize);
        };

        //奖金滑动事件处理
        var prizeBar = {
            plusPrize: function() {
                if (ps.curMethod.name == 'YMBDW' || ps.curMethod.name == 'QSYMBDW') {
                    $.alert('温馨提示：一码不定位最大奖金固定是￥6.6，不能调节！');
                    return;
                }
                if (++ps.curPrizeIndex > ps.rebateGapList.length - 1) {
                    ps.curPrizeIndex = ps.rebateGapList.length - 1;
                }
                prizeBar.saveLastPrize();
                prizeBar.showPirze();
            },
            minusPrize: function() {
                if (--ps.curPrizeIndex < 0) {
                    ps.curPrizeIndex = 0;
                }
                prizeBar.saveLastPrize();
                prizeBar.showPirze();
            },
            generateGapList: function() {
                var result = [];
                $.each(ps.minRebateGaps,
                        function(k, v) {
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
                        function(k, v) {
                            var prize = round(ps.maxCombPrize * ((ps.lotteryType == 1 ? 0.9 : 0.9) + v), 0);
                            result2.push({
                                rebate: round(ps.rebate - v, 3),
                                prize: prize
                            })
                        });

                return result2;
            },
            //显示当前奖金
            showPirze: function() {
                var realPrize = round(ps.curMode * ps.curMethod.prize * (0.9 + ps.rebate - ps.rebateGapList[ps.curPrizeIndex].rebate) / 0.9, 2);
                $("#curPrizeSpan").text(realPrize + "/" + number_format(parseFloat(ps.rebateGapList[ps.curPrizeIndex].rebate) * 100, 1));
            },
            //保存当前奖金设置
            saveLastPrize: function() {
                setCookie("reb_" + ps.lotteryId, ps.rebateGapList[ps.curPrizeIndex].rebate, 30 * 86400);
            }
        };

        //3.玩法相关
        var initMethodBar = function() {
            /*
             * <li id="methodGroup_0">后一
                    <ul id="method_0" class="methodPopStyle" style="display: none;">
                        <li id="method_0_1">后一直选</li>
                        <li id="method_0_2">五星选</li>
                    </ul>
                </li>
             */
            $.each(ps.methods,
                function(i, n) {
                    $('<li class="methodGroupLI" id="methodGroup_' + i + '"><label>' + n.mg_name + "</label></li>").click(methodBar.methodGroup_Click).hover(methodBar.methodGroup_hoverOver,methodBar.methodGroup_hoverOut).appendTo("#methodGroupContainer");
                    var ul = $('<ul id="method_' + i + '"></ul>').addClass('methodPopStyle').hide();
                    $.each(n.childs,
                            function(ii, nn) {
                                $('<li class="method" name="' + nn.name + '" id="method_' + i + "_" + ii + '">' + nn.cname + "</li>").bind("click", nn, methodBar.method_Click).hover(methodBar.method_hoverOver,methodBar.method_hoverOut).appendTo(ul);
                            });
                    $("#methodGroup_" + i).append(ul);
                });
            methodBar.selectDefault();
        };

        //玩法组及玩法菜单事件处理
        var methodBar = {
            methodGroup_Click: function(e) {
                $(this).addClass("methodGroup_selected").siblings().removeClass("methodGroup_selected");
                //必须这样做
                if($(e.target).is('label')){
                    $(this).find('li:first').click();
                }
            },
            methodGroup_hoverOver: function() {
                $(this).addClass("methodGroup_hover");
                /\w+_(\d+)/.test($(this).attr("id"));
                var index = RegExp.$1;
                //$("#method_" + index).show().siblings().hide();
                //$("#method_" + index).children(":first").click();
                $(this).find('ul').show();
            },
            methodGroup_hoverOut: function() {
                $(this).removeClass("methodGroup_hover");
                /\w+_(\d+)/.test($(this).attr("id"));
                var index = RegExp.$1;
                $(this).find('ul').hide();
            },
            method_hoverOver: function() {
                $(this).addClass("method_hover");
                /\w+_(\d+)/.test($(this).attr("id"));
                var index = RegExp.$1;
                //$("#method_" + index).show().siblings().hide();
                //$("#method_" + index).children(":first").click();
                $(this).find('ul').show();
            },
            method_hoverOut: function() {
                $(this).removeClass("method_hover");
                /\w+_(\d+)/.test($(this).attr("id"));
                var index = RegExp.$1;
                $(this).find('ul').hide();
            },
            method_Click: function(e) {
                ps.curMethod = e.data;
                //设置当前玩法前景色以示区别
                $('#methodGroupContainer').find('.method').removeClass("method_selected");
                $(this).addClass("method_selected");
                $('#curMethod').text(ps.curMethod.cname);
                //玩法提示文字
                $("#methodDesc").text(ps.curMethod.description).hide();
                $('#methodTipInfo').hover(function(){$("#methodDesc").show();}, function(){$("#methodDesc").hide();});
                if (ps.curMethod.can_input == 1) {
                    $("#inputBtn").show();
                } else {
                    $("#inputBtn").hide();
                }
                
                ballBar.generateBall();
                //$("input[name=missHotBtn]:checked").click();
                $("#inputBtn").text("手工录入");
                $("#singleInfo div").show();
                buyBar.updateSingle(0);
                prizeBar.showPirze();
                if (propLen(ps.curMethod.field_def) == 0) {
                    ballBar.showInput();
                    $("#singleInfo div").hide();
//                    $("#delTA").click(function() {
//                        $("#inputTA").val("");
//                    });
                    $("#selectArea").removeClass("N-selected");
                }
            },
            selectDefault: function() {
                if (ps.lotteryType == 1) {
                    $("#methodGroupContainer").find("label:contains('后三')").click();
                    $("#methodGroupContainer").find("label:contains('P3直选')").click();
                } else if (ps.lotteryType == 2) {
                    var ob = $("#methodGroupContainer").find("label:contains('任选')");
                    ob.click();
                    // $("#methodGroupContainer").find(".tabGray").attr("id");
                    // \w+_(\d+)/.test($("#methodGroupContainer").find(".tabGray").attr("id"));
                    // $("#method_" + RegExp.$1).children(":contains('任选五中五')").click();
                    ob.siblings('ul').children(":contains('任选五中五')").click();
                } else if (ps.lotteryType == 4) {
                    $("#methodGroupContainer").find("label:contains('直选')").click();
                }
            }
        };

        //3.1投注球事件处理 ball_Selected为选中后的样式
        var ballBar = {
            reset: function() {
                if ($.isEmptyObject(ps.curMethod.field_def)) {
                    return;
                }
                $.each(ps.curMethod.field_def, function(i, prop) {
                    $('#field_' + i).children().removeClass('ball_Selected');
                });
                buyBar.updateSingle(0);
            },
            showInput: function() {
                $("#selectArea").children().remove();
                if (ps.lotteryType == 1) {
                    var str = '<div class="manualInput"><div class="manualInputTop"><li id="delTA" class="delTA">清空</li><li><textarea cols="" rows="" class="inputTA" id="inputTA"></textarea></li></div><div class="manualInputBottom"><li class="inputTip1"><p>提示：</p><p>请把您已有的大底号码复制或者输入到下边文本框中。</p><p>每注号码之间用 空格 或者换行符 隔开,</p><p>每注号码每位之间不使用任何分隔符。</p><p>仅支持单式。 </p></li><li class="inputTip2"><p>例如：</p><p id="inputExample">';
                    var tmp = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
                    if (ps.curMethod.name == "SXHHZX" || ps.curMethod.name == "ZSHHZX" || ps.curMethod.name == "QSHHZX") {
                        str += "123 112<br></p></li></div></div>";
                    } else {
                        str += tmp.slice(0, propLen(ps.curMethod.field_def)).join("") + " " + tmp.slice(propLen(ps.curMethod.field_def), propLen(ps.curMethod.field_def) + propLen(ps.curMethod.field_def)).join("") + "<br></p></li></div></div>";
                    }
                } else if (ps.lotteryType == 2) {
                    var str = '<div class="manualInput"><div class="manualInputTop"><li id="delTA" class="delTA">清空</li><li><textarea cols="" rows="" class="inputTA" id="inputTA"></textarea></li></div><div class="manualInputBottom"><li class="inputTip1"><p>提示：</p><p>请把您已有的大底号码复制或者输入到下边文本框中。</p><p>每注号码之间必须用 换行  隔开,</p><p>每注号码每位之间必须使用 空格 作为分隔。</p><p>仅支持单式。 </p></li><li class="inputTip2"><p>例如：</p><p id="inputExample">';
                    var tmp = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"];
                    var num;
                    if (/SDRX(\d+)/.test(ps.curMethod.name)) {
                        num = parseInt(RegExp.$1);
                    } else if (ps.curMethod.name == 'SDQSZUX') {
                        num = 3;
                    } else if (ps.curMethod.name == 'SDQEZUX') {
                        num = 2;
                    } else {
                        num = propLen(ps.curMethod.field_def);
                    }
                    str += tmp.slice(0, num).join(" ") + "<br/>" + tmp.slice(1, 1 + num).join(" ") + "<br></p></li></div></div>";
                } else if (ps.lotteryType == 4) {
                    var str = '<div class="manualInput"><div class="manualInputTop"><li id="delTA" class="delTA">清空</li><li><textarea cols="" rows="" class="inputTA" id="inputTA"></textarea></li></div><div class="manualInputBottom"><li class="inputTip1"><p>提示：</p><p>请把您已有的大底号码复制或者输入到下边文本框中。</p><p>每注号码之间用 空格 或者换行符 隔开,</p><p>每注号码每位之间不使用任何分隔符。</p><p>仅支持单式。 </p></li><li class="inputTip2"><p>例如：</p><p id="inputExample">';
                    var tmp = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
                    if (ps.curMethod.name == "SXHHZX") {
                        str += "123 112<br></p></li></div></div>";
                    } else {
                        str += tmp.slice(0, propLen(ps.curMethod.field_def)).join("") + " " + tmp.slice(propLen(ps.curMethod.field_def), propLen(ps.curMethod.field_def) + propLen(ps.curMethod.field_def)).join("") + "<br></p></li></div></div>";
                    }
                }
                $(str).appendTo("#selectArea");
            },
            //显示投注球
            generateBall: function() {
                $("#selectArea").children().remove();
                var filterBtn = '<dl class="navSub" style="display:none;"><dd>全</dd><dd>奇</dd><dd>偶</dd> <dd>大</dd><dd>小</dd><dd>清</dd><dd>质</dd><dd>合</dd><dd>反</dd></dl>';
                $.each(ps.curMethod.field_def, function(i, prop) {  //注：i从1开始
                    var numList = prop.nums.split(" ");
                    var ballStr = '', hzbdStr = "";
                    $.each(numList, function(ii, nn) {
                        switch (ps.curMethod.name) {
                            case "SXBD":
                            case "ZSBD":
                            case "QSBD":
                                ballStr += '<li>' + nn + '</li>';    //<span class="HZBD">' + helper.SXBD[ii] + "</span>"
                                hzbdStr += '<li>' + helper.SXBD[ii] + '</li>';
                                break;
                            case "SXHZ":
                            case "ZSHZ":
                            case "QSHZ":
                                ballStr += '<li>' + nn + '</li>';
                                hzbdStr += '<li>' + helper.SXHZ[ii] + '</li>';
                                break;
                            case "EXBD":
                            case "QEBD":
                                ballStr += '<li>' + nn + '</li>';
                                hzbdStr += '<li>' + helper.EXBD[ii] + '</li>';
                                break;
                            case "EXHZ":
                            case "QEHZ":
                                ballStr += '<li>' + nn + '</li>';
                                hzbdStr += '<li>' + helper.EXHZ[ii] + '</li>';
                                break;
                            case 'SXZXHZ':
                            case 'QSZXHZ':
                                ballStr += '<li>' + nn + '</li>';
                                hzbdStr += '<li>' + helper.SXZXHZ[ii+1] + '</li>';
                                break;
                            default:
                                ballStr += '<li>' + nn + "</li>";
                                break;
                        }
                    });
                    ballStr = '<li><ul class="ballList' + (/(BD|HZ)$/.test(ps.curMethod.name) ? " w400" : "") + '" id=field_' + i + ">" + ballStr + "</ul></li>";
                    hzbdStr = '<li><ul class="BDHZinfo">' + hzbdStr + "</ul></li>";
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
                    //$('<div class="locate" id="locate_' + i + '"><ul class="lotteryNumber' + specialClass + '"><li class="areaPrefix">' + (prop.prompt ? prop.prompt + ":" : "") + "</li>" + "</ul></div>").appendTo("#selectArea");
                    $('<div class="locate" id="locate_' + i + '"><ul class="lotteryNumber' + specialClass + '"><li class="areaPrefix">' + (prop.prompt ? prop.prompt + ":" : "") + "</li>" + ballStr + "</ul></div>").appendTo("#selectArea");
                    //特殊处理和值包点
                    if (/(BD|HZ)$/.test(ps.curMethod.name)) {
                        $('#locate_' + i + ' .lotteryNumber').append('<li class="BDHZprompt">包含注数:</li>' + hzbdStr);
                    }
                    //处理是否有筛选功能
                    if (prop.has_filter_btn) {
                        $("#locate_" + i).find(".areaPrefix").append(filterBtn);
                        //$('.areaPrefix').addClass('shaixuan');
                        if (ps.curMethod.name == "EXZUX" || ps.curMethod.name == "QEZUX") {
                            $("#locate_" + i).find(".navSub :first").text(" ");
                            $("#locate_" + i).find(".navSub :last").text(" ");
                        }
                        $("#locate_" + i).find(".areaPrefix").hover(function() {
                                $("#locate_" + i).find(".navSub").show();
                            },
                            function() {
                                $("#locate_" + i).find(".navSub").hide();
                            }
                        );
                        $("#locate_" + i).find("dd").click(function() {
                            switch ($(this).text()) {
                                case '全':
                                    $('#field_' + i).children().addClass('ball_Selected');
                                    break;
                                case '奇':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i).children().removeClass('ball_Selected').parent().find(":odd").addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2) {
                                        $('#field_' + i).children().removeClass('ball_Selected').parent().find(":even").addClass('ball_Selected');
                                    }
                                    break;
                                case '偶':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i).children().removeClass('ball_Selected').parent().find(":even").addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2) {
                                        $('#field_' + i).children().removeClass('ball_Selected').parent().find(":odd").addClass('ball_Selected');
                                    }
                                    break;
                                case '大':
                                    $('#field_' + i).children().removeClass('ball_Selected').filter(function(idx) {
                                        return idx >= 5;
                                    }).addClass('ball_Selected');
                                    break;
                                case '小':
                                    $('#field_' + i).children().removeClass('ball_Selected').filter(function(idx) {
                                        return idx < 5;
                                    }).addClass('ball_Selected');
                                    break;
                                case '清':
                                    $('#field_' + i).children().removeClass('ball_Selected');
                                    break;
                                case '质':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function(idx) {
                                            return $.inArray(idx, [2, 3, 5, 7]) != -1;
                                        }).addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function(idx) {
                                            return $.inArray(idx, [1, 2, 4, 6, 10]) != -1;
                                        }).addClass('ball_Selected');
                                    }
                                    break;
                                case '合':
                                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function(idx) {
                                            return $.inArray(idx, [4, 6, 8, 9]) != -1;
                                        }).addClass('ball_Selected');
                                    } else if (ps.lotteryType == 2) {
                                        $('#field_' + i).children().removeClass('ball_Selected').filter(function(idx) {
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
                        $.each(result, function(i, n) {
                            $(n).appendTo('#selectArea');
                        });
                    }
                });
                //绑定球点击事件
                $(".ballList li").bind("click", ballBar.ball_Click);
            },
            //是否显示遗漏冷热
            getAssisInfo: function(field_def_idx) {
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
                            function(i, n) {
                                str += '<li class="yiLouNum">' + n + "</li>"
                            });
                    str = '<div class="missDIV" id="missHot_' + field_def_idx + '"><ul class="missHotNumber"><li class="missHotUnit">遗漏:</li><li><ul class="yiLouList" id=yiLouList_' + field_def_idx + ">" + str + "</ul></li></ul></div>";
                    result.push(str);
                    str = "";
                    $.each(ps.missHot.hot[idx],
                            function(i, n) {
                                str += '<li class="yiLouNum">' + n + "</li>"
                            });
                    str = '<div class="hotDIV" id="missHot_' + field_def_idx + '"><ul class="missHotNumber"><li class="missHotUnit">冷热:</li><li><ul class="yiLouList" id=yiLouList_' + field_def_idx + ">" + str + "</ul></li></ul></div>";
                    result.push(str);
                }
                return result;
            },
            ball_Click: function(e) {
                $(this).toggleClass("ball_Selected");
                /\w+_(\d+)/.test($(this).parent().attr("id"));
                var index = RegExp.$1;
                if ($(this).parent().find(".ball_Selected").length > ps.curMethod.field_def[index].max_selected) {
                    if (ps.curMethod.field_def[index].max_selected == 1) {
                        $(this).siblings(".ball_Selected").removeClass("ball_Selected");
                    } else {
                        $(this).removeClass("ball_Selected");
                        $.alert("当前最多只能选择" + ps.curMethod.field_def[index].max_selected + "个号码");
                    }
                } else {
                    ballBar.computeSingle();
                }
            },
            //计算注数
            computeSingle: function() {
                var codes = [];
                $.each(ps.curMethod.field_def,
                        function(i, n) {
                            var tmp = "";
                            $("#field_" + i + " li").each(function(ii) {
                                if ($(this).hasClass("ball_Selected")) {
                                    if (ps.lotteryType == 2 || ps.curMethod.field_def[i].max_selected > 10) {
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
                return {
                    singleNum: ob.singleNum,
                    isDup: ob.isDup,
                    code: codes.join(",")
                }
            }
        };

        //4.遗漏
        var initMissHotBar = function() {
            $("input[name=missHotBtn]").click(missHotBar.missHotBtn_Click);
            $("input[name=missHotBtn][value=1]").click()
        };
        var missHotBar = {
            missHotBtn_Click: function() {
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
        var initBuyBar = function() {
            ps.nextProjectCounter = 0;
            buyBar.removeAll();
            //$("#totalSingleInfo").prepend('总计[<span>0</span>]注 倍数<input name="multiple" id="multiple" value="1"/>');
            $("#multiple").click(function() {
                this.focus();
                this.select();
            }).keyup(buyBar.checkMultiple).keyup(buyBar.updateTotalSingle);
            $(".xDel").live("click",
                    function() {
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
            inputBtn_Click: function() {
                if ($(this).text() == "手工录入") {
                    $(this).text("常规录入");
                    ballBar.showInput();
                    $("#singleInfo div").hide();
                    $("#delTA").click(function() {
                        $("#inputTA").val("");
                        //$("#selectCodeBtn").removeClass("selectCodeBtn_selected");
                    });
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
                    $(this).text("手工录入");
                    $("#singleInfo div").show();
                    ballBar.generateBall();
                    $("input[name=missHotBtn]:checked").click();
                    $("#selectArea").addClass("N-selected");
                    $("#selectCodeBtn").removeClass("selectCodeBtn_selected");
                }
            },
            selectCodeBtn_Click: function() {
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
                        if (ps.curMethod.name == "SXHHZX" || ps.curMethod.name == "ZSHHZX" || ps.curMethod.name == "QSHHZX") {
                            var re = eval("/^\\d{3}$/")
                        } else {
                            var re = eval("/^\\d{" + propLen(ps.curMethod.field_def) + "}$/")
                        }
                        for (var i in arr) {
//                            if (!re.test(arr[i])) {
//                                $.alert("您输入的号码有误，请重新检查输入");
//                                return false
//                            }
                            allCodes.push(arr[i].split(""))
                        }
                    } else {
                        if (ps.lotteryType == 2) {
                            var arr = str.split(/\n/);
                            var re = /^[01]\d$/;
                            for (var i in arr) {
                                arr[i] = $.trim(rtrim($.trim(arr[i]), ","));
                                var tmp = arr[i].split(" ");
//                                for (var i2 in tmp) {
//                                    if (!re.test(tmp[i2])) {
//                                        $.alert("您输入的号码有误，请重新检查输入");
//                                        return false
//                                    }
//                                }
                                if (tmp.length != array_unique(tmp).length) {
                                    $.alert("您输入的号码有重复，请重新检查输入");
                                    return false
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
                    var strPart1 = '<li><span class="width80px" mid="' + ps.curMethod.method_id + '">';
                    var strPart2 = "." + ps.curMethod.cname + '</span><span class="width60px">';
                        + ps.nextProjectCounter + "." + ps.curMethod.cname + '</span><span class="width60px">';
                    for (var i in allCodes) {
                        var ob = isLegalCode(allCodes[i]);
                        //对于三星连选，选一注的singleNum是3注，所以这个得动态算
                        var singleAmount = number_format(ob.singleNum * 2 * ps.curMode, 2);
                        var strPart3 = '</span><span class="width100px">' + ob.singleNum + '注</span><span class="width100px">￥' + singleAmount + '</span><span class="xDel">X</span></li>';
                        
                        if (ob.isDup) { //对于三星连选，选1注相当于3注，所以不能加ob.singleNum != 1条件
                            $.alert("您输入的号码有误，请重新检查输入!");
                            return false;
                        }
                        ps.nextProjectCounter++;
                        //var singleAmount = number_format(ob.singleNum * 2 * ps.curMode, 2);
                        
                        //140329 加入排除重复号码功能 相同号码将无法加上 为效率起见100以下方案才判断
                        var isDuplicate = false;
                        if (allCodes.length < 100) {
                            $("#projectList").children("li").each(function(ii) {
                                if (ps.curMethod.method_id == $(this).children().eq(0).attr("mid") && allCodes[i].join(",") == $(this).children().eq(1).text()) {
                                    isDuplicate = true;
                                }
                            });
                            if (isDuplicate) {
                                //$.alert('"' + allCodes[i].join(",") + '" 已添加至投注项，请勿重复添加！');
                                continue;
                            }
                        }
                        
                        //$('<li><span class="width80px" mid="' + ps.curMethod.method_id + '">' + ps.nextProjectCounter + "." + ps.curMethod.cname + '</span><span class="width60px">' + allCodes[i].join(",") + '</span><span class="width100px">' + ob.singleNum + '注</span><span class="width100px">￥' + singleAmount + '</span><span class="xDel">X</span></li>').appendTo("#projectList")
                        $(strPart1 + ps.nextProjectCounter + strPart2 + allCodes[i].join(",") + strPart3).appendTo("#projectList");
                    }
                    buyBar.updateTotalSingle();
                    //$("#confirmBtn").removeClass('CantapCodeBtn');
                    $("#delTA").click()
                } else {
                    var ob = ballBar.computeSingle();
                    if (ob.singleNum == 0) {
                        return false;
                    }
                    ps.nextProjectCounter++;
                    var singleAmount = number_format(ob.singleNum * 2 * ps.curMode, 2);
                    
                    //140329 加入排除重复号码功能 相同号码将无法加上 为效率起见100以下方案才判断
                    var isDuplicate = false;
                    if ($("#projectList").children("li").length < 100) {
                        $("#projectList").children("li").each(function(i) {
                            if (ps.curMethod.method_id == $(this).children().eq(0).attr("mid") && ob.code == $(this).children().eq(1).text()) {
                                isDuplicate = true;
                            }
                        });
                        if (isDuplicate) {
                            //$.alert('"' + ob.code + '" 已添加至投注项，请勿重复添加！');
                            return false;
                        }
                    }
                    
                    $('<li><span class="width80px" mid="' + ps.curMethod.method_id + '">' + ps.nextProjectCounter + "." + ps.curMethod.cname + '</span><span class="width60px">' + ob.code + '</span><span class="width100px">' + ob.singleNum + '注</span><span class="width100px">￥' + singleAmount + '</span><span class="xDel">X</span></li>').appendTo("#projectList");
                    buyBar.updateTotalSingle();
                    ballBar.reset();
                    //$("#confirmBtn").removeClass('CantapCodeBtn');
                }
                //var d = new Date();var t1 = d.getTime();
                //alert("66 t0=" + t0 + "\nt1=" + t1 + "\nt1-t0=" + (t1-t0));
            },
            removeAll: function() {
                $("#projectList").empty();
                ps.nextProjectCounter = 0;
                $("#totalSingleInfo input").val("1");
                buyBar.updateTotalSingle()
            },
            updateSingle: function(singleNum) {
                var singleAmount = number_format(singleNum * 2 * ps.curMode, 2);
                $("#betCount").text(singleNum);
                $("#betAmount").text(singleAmount);
                if (singleNum > 0) {
                    $("#selectCodeBtn").addClass('selectCodeBtn_selected');
                } else {
                    $("#selectCodeBtn").removeClass('selectCodeBtn_selected');
                }
            },
            updateTotalSingle: function() {
                var totalSingleNum = 0;
                $("#projectList").children("li").each(function(i) {
                    spans = $(this).children();
                    totalSingleNum += parseInt(spans.eq(2).text());
                    spans.eq(3).text("￥" + number_format(parseInt(spans.eq(2).text()) * 2 * ps.curMode, 2))
                });
                if (totalSingleNum > 0) {
                    $("#confirmBtn").addClass('CantapCodeBtn_selected');
                } else {
                    $("#confirmBtn").removeClass('CantapCodeBtn_selected');
                }
                $("#totalBetCount").text(totalSingleNum);
                $("#totalBetAmount").text(number_format(totalSingleNum * 2 * $("#multiple").val() * ps.curMode, 2))
            },
            checkMultiple: function() {
                //if (!/^[1-9]\d{0,2}$/.test($(this).val())) {
                if ($(this).val() > 500) {
                    $.alert("请输入正确的倍数，最大为500倍");
                    $(this).val(500);
                    return true;
                }
                return true;
            },
            //确认按钮
            confirmBtn_Click: function() {
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
                $("#projectList").children("li").each(function(i) {
                    if (!methodCodes[$(this).children().eq(0).attr("mid")]) {
                        methodCodes[$(this).children().eq(0).attr("mid")] = {};
                    };
                    methodCodes[$(this).children().eq(0).attr("mid")][$(this).children().eq(1).text()] = $(this).children().eq(1).text();
                });
                //2.拼出codes格式  46:1,2,3,4,5|6,7,8,9,0|1,2,3,4,5#43:1,2,3|6,7,0
                $.each(methodCodes, function(mid, v) {
                    codes += mid + ':';
                    $.each(v, function(code, vv) {
                        codes += code + '|';
                    });
                    codes = rtrim(codes, '|');
                    codes += '#';
                });
                codes = rtrim(codes, '#');
                
                if (!ps.canBuy) {
                    $.alert("该期已截止购买");
                    return false;
                }
                if (codes.length == 0) {
                    $.alert("请先选择号码再投注");
                    return false;
                }
                var confirmInfo = '<div id="buy_message">请确认以下投注内容：<br>************************<br>单倍注数：' + $("#totalBetCount").text() + "注<br>总 金 额：￥" + $("#totalBetAmount").text() + "<br>所选奖金：" + ps.rebateGapList[ps.curPrizeIndex].prize + "<br>模&nbsp;&nbsp;式：" + (ps.curMode == 1 ? "元" : (ps.curMode == 0.1 ? "角" : "分")) + "模式<br>倍&nbsp;&nbsp;数：" + $("#totalSingleInfo input").val() + "倍<br>************************<br></div>";
                $.confirm(confirmInfo,
                        function() {
                            $.post("?c=game&a=play", {
                                op: "buy",
                                lotteryId: ps.lotteryId,
                                issue: ps.curIssueInfo.issue,
                                curRebate: ps.rebateGapList[ps.curPrizeIndex].rebate,
                                modes: ps.curMode,
                                codes: codes,
                                multiple: $("#totalSingleInfo input").val()
                            },
                            function(response) {
                                if (response.errno == 0) {
                                    var msg = '<div id="buy_success_message">购买成功!<br>************************<br>订单编号：' + response.pkgnum + "<br>投注期号：" + ps.curIssueInfo.issue + "<br>投注总额：￥" + $("#totalBetAmount").text() + "<br>所选奖金：" + ps.rebateGapList[ps.curPrizeIndex].prize + "<br>模&nbsp;&nbsp;式：" + (ps.curMode == 1 ? "元" : (ps.curMode == 0.1 ? "角" : "分")) + "模式<br>倍&nbsp;&nbsp;数：" + $("#multiple").val() + "倍<br>************************<br></div>";
                                    $.alert(msg,
                                            function() {
                                                buyBar.removeAll()
                                            })
                                } else {
                                    $.alert("购买失败:" + response.errstr + "(errno=" + response.errno + ")",
                                            function() {
                                                buyBar.removeAll()
                                            })
                                }
                                showBalance()
                            },
                                    "json")
                        })
            },
            //追号按钮
            traceBtn_Click: function() {
                if ($("#projectList li").length == 0) {
                    $.alert("请先选择投注号码");
                    return false
                }
                $("#traceBtn").attr('disabled',"true");
                var mids = [];
                $("#projectList li").each(function(i) {
                    if ($.inArray($(this).find("span:first").attr("mid"), mids) == -1) {
                        mids.push($(this).find("span:first").attr("mid"))
                    }
                });
                $.ajax({
                    url: "?c=game&a=play",
                    type: "POST",
                    data: {
                        op: "getTracePage",
                        lotteryId: ps.lotteryId,
                        mids: mids.join(",")
                    },
                    cache: false,
                    dataType: "json",
                    timeout: 30000,
                    success: function(response) {
                        $("#traceBtn").removeAttr("disabled");
                        if (response.errno == 0) {
                            ps.canTraceIssues = response.issues;
                            ps.traceMethodPrize = response.prize;
                            ps.tracePrizeLimit = response.prizeLimit;
                            traceFunc.showTracePage(response.content);
                            if (response.prize == 0 || mids.length != 1) {
                                $("#multipleStyle2", parent.document).attr("disabled", true)
                            }
                            $("input[name=multipleStyle]", parent.document).click(traceFunc.multipleStyle_Click);
                            $("#confirmTraceBtn", parent.document).click(traceFunc.confirmTraceBtn_Click);
                            $("#cancelTraceBtn", parent.document).click(traceFunc.cancelTraceBtn_Click);
                            $("#startIssue", parent.document).change(traceFunc.startIssue_Change);
                            $("#traceNum", parent.document).click(function() {
                                this.focus();
                                this.select()
                            }).keyup(buyBar.checkMultiple).keyup(traceFunc.traceNum_Keyup);
                            $("#ui-dialog2", parent.document).keyup(function(e) {
                                var key = e.keyCode ? e.keyCode : e.which;
                                if (key == 27) {
                                    $("#cancelTraceBtn", parent.document).click()
                                }
                            });
                            $("#singleNum", parent.document).text($("#totalBetCount").text());
                            $("#issuesNum2", parent.document).text("1");
                            $("#multipleStyle1", parent.document).click();
                            traceFunc.updateTotalMoney()
                        } else {
                            alert("系统繁忙，请稍候再试(01)")
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#traceBtn").removeAttr("disabled");
                        if (errorThrown.indexOf("a=logout") != -1) {
                            alert("您已经退出，请重新登录");
                            window.location.href = "?a=logout"
                        } else {
                            alert("调用数据失败，请刷新页面1")
                        }
                    }
                })
            }
        };

        //5.1定义追号几个按钮事件 放在buyBar前面
        var traceFunc = {
            multipleStyle_Click: function() {
                $("#startIssue", parent.document).get(0).selectedIndex = 0;
                $("#traceNum", parent.document).val(1);
                if ($(this).val() == 1) {
                    $(".style1BodyMultiple", parent.document).live("click",
                            function() {
                                this.focus();
                                this.select()
                            }).live("keyup", buyBar.checkMultiple).live("keyup", traceFunc.style1BodyMultiple_Keyup);
                    traceFunc.updateStyle1();
                    $("#multipleStyle1DIV", parent.document).show();
                    $("#multipleStyle2DIV", parent.document).hide()
                } else {
                    $("#startMultiple", parent.document).click(function() {
                        this.focus();
                        this.select()
                    });
                    $("#beitouToolSmainbtzk input", parent.document).click(function() {
                        $(this).parent().click()
                    }).focus(function() {
                        this.select()
                    });
                    $("#beitouToolSmainbtzk li", parent.document).click(function() {
                        $(this).addClass("checked").siblings().removeClass("checked");
                        $(this).find("input[name=profitStyle]").attr("checked", true)
                    });
                    $("#generalPlanBtn", parent.document).click(traceFunc.generalPlanBtn_Click);
                    $("#issuesNum2", parent.document).text("1");
                    $("#style2Body", parent.document).empty();
                    $("#startMultiple", parent.document).val("1");
                    $("input[name=totalProfitRate]", parent.document).val("10");
                    $("input[name=first5Rate]", parent.document).val("5");
                    $("input[name=first5RateValue]", parent.document).val("10");
                    $("input[name=laterRateValue]", parent.document).val("5");
                    $("input[name=totalProfit]", parent.document).val("100");
                    $("input[name=first5Profit]", parent.document).val("5");
                    $("input[name=first5ProfitValue]", parent.document).val("100");
                    $("input[name=laterProfitValue]", parent.document).val("50");
                    $("#beitouToolSmainbtzk li:first", parent.document).click();
                    $("#multipleStyle1DIV", parent.document).hide();
                    $("#multipleStyle2DIV", parent.document).show()
                }
            },
            startIssue_Change: function() {
                if ($("input[name=multipleStyle]:checked", parent.document).val() == "1") {
                    traceFunc.updateStyle1()
                }
            },
            traceNum_Keyup: function() {
                if ($("input[name=multipleStyle]:checked", parent.document).val() == "1") {
                    traceFunc.updateStyle1()
                }
            },
            style1BodyMultiple_Keyup: function() {
                var multiple = parseInt($(this).val());
                if (isNaN(multiple) || multiple < 1 || multiple > 99999) {
                    multiple = 1
                }
                /\w+_(\d+)/.test($(this).attr("id"));
                var idx = RegExp.$1;
                if (idx == 0) {
                    var prevTotalMoney = 0
                } else {
                    var prevTotalMoney = parseFloat($("#totalMoney_" + (idx - 1), parent.document).text())
                }
                while (idx <= $("#style1Body li", parent.document).length) {
                    $("#style1BodyMultiple_" + idx, parent.document).val(multiple);
                    var curMoney = parseInt($("#singleNum", parent.document).text()) * multiple * 2 * ps.curMode;
                    prevTotalMoney += curMoney;
                    $("#curMoney_" + idx, parent.document).text(number_format(curMoney, 2));
                    $("#totalMoney_" + idx, parent.document).text(number_format(prevTotalMoney, 2));
                    idx++
                }
                traceFunc.updateTotalMoney()
            },
            updateStyle1: function() {
                var idx = -1;
                $.each(ps.canTraceIssues,
                        function(k, v) {
                            if (v == $("#startIssue", parent.document).val()) {
                                idx = k
                            }
                        });
                if (idx == -1) {
                    alert("数据出错");
                    throw "数据出错"
                }
                if (isNaN(parseInt($("#traceNum", parent.document).val()))) {
                    $("#traceNum", parent.document).val("1")
                }
                var willTraceIssues = ps.canTraceIssues.slice(idx, idx + parseInt($("#traceNum", parent.document).val()));
                if (willTraceIssues.length < $("#traceNum", parent.document).val()) {
                    $.alert("最多只能追" + willTraceIssues.length + "期");
                    $("#traceNum", parent.document).val(willTraceIssues.length);
                }
                $("#style1Body", parent.document).empty();
                var str = "",
                        curMoney, totalMoney = 0;
                $.each(willTraceIssues,
                        function(k, v) {
                            curMoney = parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode;
                            totalMoney += curMoney;
                            var str = '<li id="traceIssueLI_' + k + '"><span id="traceIssue_' + k + '">' + v + '</span><span><input type="text" value="1" id="style1BodyMultiple_' + k + '" class="beitouToolsinput style1BodyMultiple" maxlength="5" /></span><span id=curMoney_' + k + ">" + number_format(curMoney, 2) + "</span><span id=totalMoney_" + k + ">" + number_format(totalMoney, 2) + "</span></li>";
                            $("#style1Body", parent.document).append(str);
                            $(".style1BodyMultiple", parent.document).bind("click",
                                    function() {
                                        this.focus();
                                        this.select()
                                    }).bind("keyup", buyBar.checkMultiple).bind("keyup", traceFunc.style1BodyMultiple_Keyup)
                        });
                traceFunc.updateTotalMoney()
            },
            confirmTraceBtn_Click: function() {
                var spans, codes, tmpMethod, mid, code, listFirst;
                $("#projectList").children("li").each(function(i) {
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
                    $.alert("该期已截止购买");
                    return false
                }
                if (codes.length == 0) {
                    $.alert("请先选择号码再投注");
                    return false
                }
                
                var traceData = [];
                if ($("input[name=multipleStyle]:checked", parent.document).val() == "1") {
                    $("#style1Body li", parent.document).each(function(i) {
                        var issue = $(this).find("span:eq(0)").text();
                        var multiple = $(this).find("input").val();
                        traceData.push({
                            issue: issue,
                            multiple: multiple
                        })
                    })
                } else {
                    $("#style2Body li", parent.document).each(function(i) {
                        var issue = $(this).find("span:eq(0)").text();
                        var multiple = $(this).find("span:eq(1)").text();
                        traceData.push({
                            issue: issue,
                            multiple: multiple
                        })
                    })
                }
                var traceTotalAmount = $("#traceTotalAmount", parent.document).text();
                var stopOnWin = $("input[name=stopOnWin]", parent.document).attr("checked") ? 1 : 0;
                var confirmInfo = '<div id="buy_message">请确认以下投注内容：<br>************************<br>是否追号：是<br>单倍注数：' + $("#totalBetCount").text() + "注<br>总 金 额：￥" + traceTotalAmount + "<br>超始期号：" + traceData[0].issue + "<br>追号期数：" + traceData.length + "<br>所选奖金：" + ps.rebateGapList[ps.curPrizeIndex].prize + "<br>模&nbsp;&nbsp;式：" + (ps.curMode == 1 ? "元" : (ps.curMode == 0.1 ? "角" : "分")) + "模式<br>************************<br></div>";
                traceFunc.destroyTracePage();
                $.confirm(confirmInfo,
                        function() {
                            $.post("?c=game&a=play", {
                                op: "buy",
                                lotteryId: ps.lotteryId,
                                issue: ps.curIssueInfo.issue,
                                curRebate: ps.rebateGapList[ps.curPrizeIndex].rebate,
                                modes: ps.curMode,
                                codes: codes,
                                traceData: traceData,
                                stopOnWin: stopOnWin
                            },
                            function(response) {
                                if (response.errno == 0) {
                                    var msg = '<div id="buy_success_message">追号订单成功!<br>************************<br>订单编号：' + response.pkgnum + "<br>起始期号：" + traceData[0].issue + "<br>追号期数：" + traceData.length + "<br>追号总额：￥" + traceTotalAmount + "<br>所选奖金：" + ps.rebateGapList[ps.curPrizeIndex].prize + "<br>模&nbsp;&nbsp;式：" + (ps.curMode == 1 ? "元" : (ps.curMode == 0.1 ? "角" : "分")) + "模式<br>************************<br></div>";
                                    $.alert(msg,
                                            function() {
                                                buyBar.removeAll()
                                            })
                                } else {
                                    $.alert("追号失败:" + response.errstr + "(errno=" + response.errno + ")",
                                            function() {
                                                buyBar.removeAll()
                                            })
                                }
                                //showBalance()
                            },
                                    "json")
                        })
            },
            cancelTraceBtn_Click: function() {
                traceFunc.destroyTracePage()
            },
            showTracePage: function(content) {
                var wnd = window.parent;
                $("body", wnd.document).append('<div id="ui-dialog2" style="outline: 0px none; z-index: 1002;" class="ui-dialog" tabindex="-1"></div>');
                var uiDialog2 = $("#ui-dialog2", wnd.document).append(content).css("width", 530).hide();
                $("body", wnd.document).append('<div id="ui-widget-overlay2" class="ui-widget-overlay2" style="z-index: 1001;"></div>');
                var dialogOverlay2 = $("#ui-widget-overlay2", wnd.document).css("width", $(wnd.document).width()).css("height", $(wnd.document).height());
                var rect = getXY(wnd);
                uiDialog2.css("left", rect.scrollX + (rect.width - uiDialog2.width()) / 2);
                uiDialog2.css("top", rect.scrollY + (rect.height - uiDialog2.height()) / 2);
                uiDialog2.show();
                dialogOverlay2.show();
                $("#startIssue", wnd.document).children(":first").text($("#startIssue", wnd.document).children(":first").text() + "(当前期)")
            },
            destroyTracePage: function() {
                $("#ui-dialog2", parent.document).remove();
                $("#ui-widget-overlay2", parent.document).remove()
            },
            updateTotalMoney: function() {
                var totalMultiple = 0;
                if ($("input[name=multipleStyle]:checked", parent.document).val() == "1") {
                    $("#style1Body li", parent.document).each(function(i) {
                        totalMultiple += parseInt($(this).find("input").val())
                    });
                    $("#issuesNum2", parent.document).text($("#style1Body li", parent.document).length)
                } else {
                    $("#style2Body li", parent.document).each(function(i) {
                        totalMultiple += parseInt($(this).find("span:eq(1)").text())
                    });
                    $("#issuesNum2", parent.document).text($("#style2Body li", parent.document).length)
                }
                $("#traceTotalAmount", parent.document).text(number_format(parseInt($("#singleNum", parent.document).text()) * totalMultiple * 2 * ps.curMode, 2))
            },
            generalPlanBtn_Click: function() {
                var computeMultiple = function(startMultiple, profitRate, singleAmount, totalMoney, prize) {
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
                        function(k, v) {
                            if (v == $("#startIssue", parent.document).val()) {
                                idx = k
                            }
                        });
                if (idx == -1) {
                    alert("数据出错");
                    throw "数据出错"
                }
                if (isNaN(parseInt($("#traceNum", parent.document).val()))) {
                    $("#traceNum", parent.document).val("1")
                }
                var willTraceIssues = ps.canTraceIssues.slice(idx, idx + parseInt($("#traceNum", parent.document).val()));
                if (willTraceIssues.length < $("#traceNum", parent.document).val()) {
                    $.alert("最多只能追" + willTraceIssues.length + "期");
                    $("#traceNum", parent.document).val(willTraceIssues.length);
                }
                $("#style2Body", parent.document).empty();
                var traces = [],
                        str = "",
                        curMultiple,
                        curMoney,
                        totalMoney = 0;
                var singleMoney = parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode;
                var prize = ps.traceMethodPrize * (ps.rebateGapList[ps.curPrizeIndex].prize / (ps.maxCombPrize * (ps.lotteryType == 1 ? 0.9 : 0.9))) * ps.curMode;
                $.each(willTraceIssues,
                        function(k, v) {
                            if ($("input[name=profitStyle]:checked", parent.document).val() == 1) {
                                if (k == 0) {
                                    curMultiple = parseInt($("#startMultiple", parent.document).val());
                                    curMoney = curMultiple * parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode;
                                    if ((curMultiple * prize - curMoney) / curMoney * 100 < $("input[name=totalProfitRate]", parent.document).val()) {
                                        $.alert("该计划无法实现，请调整目标");
                                        return false
                                    }
                                } else {
                                    curMultiple = computeMultiple($("#startMultiple", parent.document).val(), $("input[name=totalProfitRate]", parent.document).val(), singleMoney, totalMoney, prize)
                                }
                            } else {
                                if ($("input[name=profitStyle]:checked", parent.document).val() == 2) {
                                    if (k == 0) {
                                        curMultiple = parseInt($("#startMultiple", parent.document).val());
                                        curMoney = curMultiple * parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode;
                                        if ((curMultiple * prize - curMoney) / curMoney * 100 < $("input[name=first5RateValue]", parent.document).val()) {
                                            $.alert("该计划无法实现，请调整目标");
                                            return false
                                        }
                                    } else {
                                        if (k < $("input[name=first5Rate]", parent.document).val()) {
                                            curMultiple = computeMultiple($("#startMultiple", parent.document).val(), $("input[name=first5RateValue]", parent.document).val(), singleMoney, totalMoney, prize)
                                        } else {
                                            curMultiple = computeMultiple($("#startMultiple", parent.document).val(), $("input[name=laterRateValue]", parent.document).val(), singleMoney, totalMoney, prize)
                                        }
                                    }
                                } else {
                                    if ($("input[name=profitStyle]:checked", parent.document).val() == 3) {
                                        curMultiple = Math.ceil(round((parseInt($("input[name=totalProfit]", parent.document).val()) + totalMoney) / (prize - parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode), 3));
                                        if (curMultiple < $("#startMultiple", parent.document).val()) {
                                            curMultiple = $("#startMultiple", parent.document).val()
                                        }
                                    } else {
                                        if ($("input[name=profitStyle]:checked", parent.document).val() == 4) {
                                            if (k < $("input[name=first5Profit]", parent.document).val()) {
                                                curMultiple = Math.ceil(round((parseInt($("input[name=first5ProfitValue]", parent.document).val()) + totalMoney) / (prize - parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode), 3))
                                            } else {
                                                curMultiple = Math.ceil(round((parseInt($("input[name=laterProfitValue]", parent.document).val()) + totalMoney) / (prize - parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode), 3))
                                            }
                                        }
                                    }
                                }
                            }
                            if (curMultiple == 0) {
                                $.alert("您输入的参数有误，必须为正整数");
                                return false
                            } else {
                                if (curMultiple < 0) {
                                    $.alert("该计划不可能实现，请调整目标");
                                    return false
                                } else {
                                    if (curMultiple * prize > ps.tracePrizeLimit) {
                                        $.alert("该计划超出无法实现，请调整目标");
                                        return false
                                    }
                                }
                            }
                            curMoney = curMultiple * parseInt($("#singleNum", parent.document).text()) * 2 * ps.curMode;
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
            _showPlan: function(traces) {
                $.each(traces,
                        function(k, v) {
                            var str = '<li><span class="spanWidth90px">' + v.issue + '</span><span class="spanWidth50px">' + v.multiple + '</span><span class="spanWidth70px">' + v.curMoney + '</span><span class="spanWidth70px">' + v.totalMoney + '</span><span class="spanWidth70px">' + v.curPrize + '</span><span class="spanWidth70px">' + v.totalProfit + '</span><span class="spanWidth70px">' + Math.round(v.totalProfitRate * 100) + "%</span></li>";
                            $("#style2Body", parent.document).append(str)
                        });
                traceFunc.updateTotalMoney()
            }
        };

        //6.开奖区
        var initDrawBar = function() {
            $("#curLotteryName").text(ps.lotteryName);
            $("#curLotteryName2").text(ps.lotteryName);
            if (ps.lotteryType == 1) {
                $("#todayIssuesHead").html('<li class="width80px">期号</li><li class="width60px">开奖号</li><li class="width55px">前三组态</li><li class="width55px">后三组态</li>')
            } else if (ps.lotteryType == 2) {
                $("#todayIssuesHead").html('<li class="width247px">期号</li><li class="width247px">开奖号</li>')
            } else if (ps.lotteryType == 4) {
                $("#todayIssuesHead").html('<li class="width80px">期号</li><li class="width60px">开奖号</li><li class="width55px">三星组态</li><li class="width55px">三星和值</li>')
            }
            $("#todayDrawBtn").click(drawBar.todayDrawBtn_Click);
            $("#prizeRankBtn").click(drawBar.prizeRankBtn_Click);
            $("#todayBuyBtn").click(drawBar.todayBuyBtn_Click);
            $.each(ps.openedIssues,
                    function(k, v) {
                        var ob = drawBar.getMoreInfo(v.code);
                        v.prop = ob;
                        ps.todayDrawList.push(v)
                    });
            $("#todayDrawBtn").click();
            drawBar.getCurIssue(drawBar.init);
        };

        var drawBar = {
            init: function() {
                runTime.remainTimer = window.setInterval(drawBar.showCurIssue_Timer, 1000);
                if (ps.lastIssueInfo.code == "") {
                    ps.getLastOpenTime = 0;
                    clearInterval(runTime.getLastOpenTimer);
                    runTime.getLastOpenTimer = window.setInterval(drawBar.getLastOpen_Timer, 1000);
                    $("#thisIssueInfo").addClass("thisIssueInfo_lock");
                    ps.canBuy = false;
                    $("#thisIssueSpan").text(ps.lastIssueInfo.issue);
                }
                //初始化开奖球数目
                if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                    var nums = ps.todayDrawList[0].code.split("");
                } else if (ps.lotteryType == 2) {
                    var nums = ps.todayDrawList[0].code.split(" ");
                }
                $('#thisIssueNumUL').empty();
                $.each(nums, function(i, n) {
                    if (ps.lotteryType == 1 || ps.lotteryType == 4) {
                        $('#thisIssueNumUL').append('<span class="pendingBall"></span>');
                    } else if (ps.lotteryType == 2) {
                        $('#thisIssueNumUL').append('<span class="sd115_Ball"></span>');
                    }
                });
                drawBar.showLastDraw();
                ps.canBuy = true;
            },
            getCurIssue: function(callback) {
                $.ajax({
                    url: "?c=game&a=play",
                    type: "POST",
                    data: {
                        op: "getCurIssue",
                        lotteryId: ps.lotteryId
                    },
                    cache: false,
                    dataType: "json",
                    timeout: 30000,
                    success: function(response) {
                        if (response.errno == 0) {
                            ps.curIssueInfo = response.issueInfo;
                            ps.curServerTime = response.serverTime;
                            ps.curRemainTime = getTS(ps.curIssueInfo.end_time) - getTS(ps.curServerTime);
                            ps.curWaitOpenTime = 30;
                            ps.lastIssueInfo = response.lastIssueInfo;
                            if (typeof(callback) == "function") {
                                callback()
                            }
                        } else {
                            alert("系统繁忙，请稍候再试(02)")
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        if (errorThrown.indexOf("a=logout") != -1) {
                            alert("您已经退出，请重新登录");
                            window.location.href = "?a=logout"
                        } else {
                            alert("调用数据失败，请刷新页面2")
                        }
                    }
                })
            },
            showCurIssue_Timer: function() {
                $("#thisIssueSpan").text(ps.curIssueInfo.issue);
                $("#thisIssueSpan2").text(ps.curIssueInfo.issue);
                var d = subTime(--ps.curRemainTime);
                if (ps.curRemainTime > 0) {
                    $("#thisIssueRemainTime").text(d.hour + ":" + d.minute + ":" + d.second);
                    $("#thisIssueInfo").removeClass("thisIssueInfo_lock").addClass('Remaining_time');
                } else {
                    clearInterval(runTime.remainTimer);
                    
                    $('#thisIssueInfo').removeClass('Remaining_time').addClass('thisIssueInfo_lock');
                    var d2 = subTime(--ps.curWaitOpenTime);
                    $('#thisIssueRemainTime').text(d2.hour + ":" + d2.minute + ":" + d2.second);
                    
                    //$("#thisIssueRemainTime").addClass("lotteryTime-lock");
                    //$("#thisIssueMoreInfo").html('<div class="remainOpenDIV">第 ' + ps.curIssueInfo.issue + ' 期开奖倒计时：<span class="lotteryTime2">' + ps.curWaitOpenTime + "</span></div>");
                    ps.canBuy = false;
                    runTime.waitOpenTimer = window.setInterval(drawBar.waitOpen_Timer, 1000);
                }
            },
            //显示锁倒计时
            waitOpen_Timer: function() {
                var d = subTime(--ps.curWaitOpenTime);
                if (ps.curWaitOpenTime > 0) {
                    $("#thisIssueRemainTime").text(d.hour + ":" + d.minute + ":" + d.second);
                } else {
                    clearInterval(runTime.waitOpenTimer);
                    drawBar.getCurIssue(drawBar.init);
                }
            },
            getLastOpen_Timer: function() {
                ps.getLastOpenTime++;
                //每10秒请求一次
                if (ps.getLastOpenTime >= 10 && ps.getLastOpenTime % 10 == 0) {
                    $.ajax({
                        url: "?c=game&a=play",
                        type: "POST",
                        data: {
                            op: "getLastIssueCode",
                            lotteryId: ps.lotteryId,
                            issue: ps.lastIssueInfo.issue
                        },
                        cache: false,
                        dataType: "json",
                        timeout: 30000,
                        success: function(response) {
                            if (response.errno == 0) {
                                if (typeof(response.issueInfo.code) != "undefined") {
                                    clearInterval(runTime.getLastOpenTimer);
                                    ps.getLastOpenTime = 0;
                                    //更新最近一期数据，否则导致draw.init()中重复调用
                                    ps.lastIssueInfo = response.issueInfo;
                                    var ob = drawBar.getMoreInfo(response.issueInfo.code);
                                    response.issueInfo.prop = ob;
                                    ps.todayDrawList.unshift(response.issueInfo);
                                    if ($("#todayDrawBtn").hasClass("menuYellow")) {
                                        var v = ps.todayDrawList[0];
                                        if (ps.lotteryType == 1) {
                                            var str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code +  '</li><li class="width53px">' + v.prop.qszt + '</li><li class="width53px">' + v.prop.hszt + "</li></ul>"
                                        } else if (ps.lotteryType == 2) {
                                            var str = '<ul><li class="width247px">' + v.issue + '</li><li class="width247px">' + v.code + "</li>"
                                        } else if (ps.lotteryType == 4) {
                                            var str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width53px">' + v.prop.qshz + "</li></ul>"
                                        }
                                        
                                        $("#todayIssuesBody").prepend(str)
                                    }
                                    drawBar.showLastDraw()
                                } else {
                                }
                            } else {
                                alert("系统繁忙，请稍候再试(03)")
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            if (errorThrown.indexOf("a=logout") != -1) {
                                alert("您已经退出，请重新登录");
                                window.location.href = "?a=logout"
                            } else {
                                alert("调用数据失败，请刷新页面3")
                            }
                        }
                    })
                }
            },
            //显示上一期开奖结果
            showLastDraw: function() {
                var latest = ps.todayDrawList[0];
                $("#lastIssueSpan").text(ps.lastIssueInfo.issue);
                var str;
                if (ps.lastIssueInfo.issue == latest.issue) {
                    if (ps.lotteryType == 1) {
                        var nums = latest.code.split("");
                        str = "<ul><li>三星形态:[<span>" + latest.prop.hszt + "</span>]</li><li>三星和值:[<span>" + latest.prop.hshz + "</span>]</li><li>二星和值:[<span>" + latest.prop.hehz + "</span>]</li><li>大小单双:[<span>" + latest.prop.dxds + "</span>]</li></ul>"
                    } else if (ps.lotteryType == 2) {
                        var nums = latest.code.split(" ");
                        str = "<ul><li>第一位：<span>" + nums[0] + "</span></li><li>第二位：<span>" + nums[0] + "," + nums[1] + "</span></li></ul><ul><li>第三位：<span>" + nums[0] + "," + nums[1] + "," + nums[2] + "</span></li></ul>"
                    } else if (ps.lotteryType == 4) {
                        var nums = latest.code.split("");
                        str = "<ul><li>三星形态:[<span>" + latest.prop.qszt + "</span>]</li><li>三星和值:[<span>" + latest.prop.qshz + "</span>]</li></ul>";
                    } else {
                        throw new exception('无效的数据引用1');
                    }
                    $("#thisIssueNumUL").children().removeClass("pendingBall");
                    $("#thisIssueNumUL").children().each(function(i) {
                        $(this).text(nums[i]);
                    })
                } else {
                    $("#thisIssueNumUL").children().addClass("pendingBall");
                    if (ps.lotteryType == 1) {
                        str = "<ul><li>三星形态:[<span></span>]</li><li>二星和值:[<span></span>]</li><li>三星和值:[<span></span>]</li><li>大小单双:[<span></span>]</li></ul>"
                    } else if (ps.lotteryType == 2) {
                        str = "<ul><li>第一位：<span></span></li><li>第二位：<span></span></li><li>第三位：<span></span></li></ul>"
                    } else if (ps.lotteryType == 4) {
                        str = "<ul><li>三星形态:[<span></span>]</li><li>三星和值:[<span></span>]</li></ul>";
                    } else {
                        throw new exception('无效的数据引用2');
                    }
                }
                $("#thisIssueMoreInfo").html(str);
            },
            //今日开奖
            todayDrawBtn_Click: function() {
                $(this).addClass("menuYellow").siblings().removeClass("menuYellow");
                $("#todayIssuesHead").empty().show();
                $("#todayIssuesBody").empty().show();
                $("#prizeScrollContent").hide();
                if (ps.lotteryType == 1) {
                    $("#todayIssuesHead").html('<li class="width80px">期号</li><li class="width60px">开奖号</li><li class="width55px">前3组态</li><li class="width55px">后3组态</li>')
                } else if (ps.lotteryType == 2) {
                    $("#todayIssuesHead").html('<li class="width247px">期号</li><li class="width247px">开奖号</li>')
                }
                else if (ps.lotteryType == 4) {
                    $("#todayIssuesHead").html('<li class="width80px">期号</li><li class="width60px">开奖号</li><li class="width55px">后3组态</li>')
                }
                $("#todayIssuesBody").empty();
                $.each(ps.todayDrawList,
                        function(k, v) {
                            if (ps.lotteryType == 1) {
                                var str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width53px">' + v.prop.qszt + '</li><li class="width53px">' + v.prop.hszt + "</li></ul>"
                            } else if (ps.lotteryType == 2) {
                                var str = '<ul><li class="width247px">' + v.issue + '</li><li class="width247px">' + v.code + "</li>"
                            }
                            else if (ps.lotteryType == 4) {
                                var str = '<ul><li class="width80px">' + v.issue + '</li><li class="width60px">' + v.code + '</li><li class="width53px">' + v.prop.qszt + "</li></ul>";
                            }
                            $("#todayIssuesBody").append(str)
                        })
            },
            //中奖排行榜
            prizeRankBtn_Click: function() {
                if ($(this).hasClass("menuYellow")) {
                    return true;
                }
                $(this).addClass("menuYellow").siblings().removeClass("menuYellow");
                $("#todayIssuesHead").empty().hide();
                $("#todayIssuesBody").empty().hide();
                $.post("?c=game&a=play", {
                    op: "getPrizeRank",
                    lotteryId: ps.lotteryId
                },
                function(response) {
                    if (response.errno == 0) {
                        if (response.data.length == 0) {
                            $('<div class="todayNoBet">暂时没有记录！</div>').appendTo("#prizeScrollContent")
                        } else {
                            $("#prizeScrollContent").empty();
                            $.each(response.data,
                                    function(k, v) {
                                        $('<ul><li style="width:500px"><span class="Color_blue">' + v.nick_name + "</span> 喜中 " + number_format(v.total_prize, 2) + "元</li></ul>").appendTo($("#prizeScrollContent"))
                                    });
                            $("#prizeScrollContent").html($("#prizeScrollContent").html() + $("#prizeScrollContent").html()).show();
                            if (runTime.scollTopIntervalTimer == 0) {
                                runTime.scollTopIntervalTimer = window.setInterval(drawBar.scrollPrizeRank, 100);
                                $("#prizeScrollContent").mouseover(function() {
                                    clearInterval(runTime.scollTopIntervalTimer);
                                }).mouseout(function() {
                                    runTime.scollTopIntervalTimer = window.setInterval(drawBar.scrollPrizeRank, 100)
                                })
                            }
                        }
                    } else {
                        alert("暂时没有数据！")
                    }
                },
                        "json")
            },
            //今日投注
            todayBuyBtn_Click: function() {
                $(this).addClass("menuYellow").siblings().removeClass("menuYellow");
                $("#todayIssuesHead").empty().show();
                $("#todayIssuesBody").empty().show();
                $("#prizeScrollContent").hide();
                $.post("?c=game&a=play", {
                    op: "getCurContextIssues",
                    lotteryId: ps.lotteryId
                },
                function(response) {
                    if (response.errno == 0) {
                        $.each(response.issueInfos,
                                function(k, v) {
                                    $('<li name="' + v.issue + '" class="todayRecentIssues"'+ (k == 2 ? " style='width:80px;'" : "") + '>' + v.issue.substr(v.issue.length - 3) + (k == 2 ? "(当前期)" : "") + "</li>").click(function() {
                                        $(this).addClass("Yellow").siblings().removeClass("Yellow");
                                        $.post("?c=game&a=play", {
                                            op: "getBuyRecords",
                                            lotteryId: ps.lotteryId,
                                            issue: $(this).attr("name")
                                        },
                                        function(response) {
                                            if (response.errno == 0) {
                                                $("#todayIssuesBody").empty();
                                                $('<ul><li class="C1">玩法类型</li><li class="C2">投注内容</li><li class="C3">倍数</li><li class="C4">金额</li><li class="C5">状态</li></ul>').appendTo("#todayIssuesBody");
                                                if (response.prj.length == 0) {
                                                    $('<div class="todayNoBet">暂时没有记录！</div>').appendTo("#todayIssuesBody");
                                                } else {
                                                    $.each(response.prj,
                                                            function(k, v) {
                                                                // 宽度有限 奖金一栏不要了'</li><li style="width:80px">' + v.prize
                                                                $('<ul><li class="C1"><a href="javascript:showPackageDetail(\'' + v.wrapId + '\');">' + v.methodName + '</a></li><li class="C2">' + v.code + '</li><li class="C3">' + v.multiple + '</li><li class="C4">' + v.amount + '</li><li class="C5">' + v.prizeStatus  + "</li></ul>").click(function() {
                                                                    //为适应客户端statusText，这里不再用jq定义
                                                                    //window.open("?c=game&a=packageDetail&wrap_id=" + v.wrapId, "_blank")
                                                                }).appendTo("#todayIssuesBody");
                                                            })
                                                }
                                            } else {
                                                alert("系统繁忙，请稍候再试(04)");
                                            }
                                        },
                                                "json")
                                    }).appendTo("#todayIssuesHead");
                                });
                        $("#todayIssuesHead li:eq(2)").click();
                    } else {
                        alert("系统繁忙，请稍候再试(05)");
                    }
                },
                        "json")
            },
            scrollPrizeRank: function() {
                var obj = $("#prizeScrollContent")[0];
                obj.scrollTop += 1;
                if (obj.scrollTop >= $("#prizeScrollContent")[0].scrollHeight / 2) {
                    obj.scrollTop = 0
                }
            },
            getMoreInfo: function(code) {
                var nums = code.split("");
                var ob = {};
                ob.qshz = parseInt(nums[0]) + parseInt(nums[1]) + parseInt(nums[2]);
                ob.qszt = drawBar.zutai(nums[0], nums[1], nums[2]);
                ob.hshz = parseInt(nums[2]) + parseInt(nums[3]) + parseInt(nums[4]);
                ob.hszt = drawBar.zutai(nums[2], nums[3], nums[4]);
                ob.hehz = parseInt(nums[3]) + parseInt(nums[4]);
                ob.dxds = drawBar.dxds(nums[3], nums[4]);
                return ob
            },
            zutai: function(a, b, c) {
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
            dxds: function(n1, n2) {
                var a = [],
                        b = [];
                a.push(n1 >= 5 ? "大" : "小");
                a.push(n1 % 2 == 1 ? "单" : "双");
                b.push(n2 >= 5 ? "大" : "小");
                b.push(n2 % 2 == 1 ? "单" : "双");
                return [a[0] + b[0], a[0] + b[1], a[1] + b[0], a[1] + b[1]].join(",")
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
            $.alert("数据初始化失败");
            return false
        }
        initPrizeBar();
        initModesBar();
        initMethodBar();
        initMissHotBar();
        initBuyBar();
        initDrawBar();
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
        };
    }
})(jQuery);