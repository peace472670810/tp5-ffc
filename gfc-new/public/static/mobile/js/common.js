var KEY_UP = 38;
var KEY_DOWN = 40;
var KEY_ENTER = 13;
var KEY_A = 65;
var KEY_Z = 90;
var KEY_0 = 48;
var KEY_9 = 57;
var KEY_NUMPAD_0 = 96;
var KEY_NUMPAD_9 = 105;
var timeout = 3000;
var lastBalance;
var amsrefreshTimer;
var loginCount = 0;
var retryCount = 3;
var isReceived = false;
var sslTimer;
var LOGOUT = 2244;
//服务端传来这个代码表示需要重新登陆﻿
var label = {
    //common
    period: "期",
    noRecord: "暂时没有记录!",
    invalidUser: "请先登录",
    noResult: "(无)",
    yntrue: "是",
    ynfalse: "否",
    noOrder: '请先正确选择号码后再投注！',
    invalidCno: '请先正确选择追号后再投注！',
    invalidMultiplier: '请先正确选择倍数后再投注！',
    drawDisable: '您好，本期已销售截止，进入开奖倒计时',
    drawDisable1:"本期等待开奖中",
    //cp
    drawNumber: "第 {0} 期",
    drawVoid: "本期空开",
    //game
    gameSSCFFC: "DS分分彩",
    gameCQSSC: "重庆时时彩",
    gameJXSSC: "江西时时彩",
    gameHLJSSC: "黑龙江时时彩",
    gameXJSSC: "新疆时时彩",
    gameTJSSC: "天津时时彩",
    gameCQ115: "重庆11选5",
    gameSD11Y: "山东11选5",
    gameGD115: "广东11选5",
    gameJX115: "江西11选5",
    gameHEL11X5: "Hi彩11选5",
    gameFC3D: '福彩3D',
    gameP3P5: '排列三/五',
    gameJSKS: '江苏快三',
    gameHBKS: '湖北快三',
    gamePK10: 'PK拾',
    //member
    account: "我的账户",
    transfer: "转账",
    deposit: "充值",
    withdraw: "我要提现",
    inquiry: "交易记录",
    deposits: '我要充值',
    alipayDeposit: '支付宝转帐',
    alipayMessage: '<font color="green">提示信息</font>:<br/><font color="red">支付宝小额转帐(1000元以下)，无需填单，自动上分。 </font>  <br/> <font color="red"> 汇款时必须填写附言，因不填、错填附言导致上分失败由客户承担全部责任。 </font> <br/><font color="red">请在30分钟内完成汇款操作，若超时不予处理。 </font> ',
    icbcDeposit: '工行转帐',
    icbcMessage: '<font color="green">提示信息</font>:<br/><font color="red">仅限工行网银转帐，汇款后无需填单，全自动快速上分，强烈推荐！</font>  <br/> <font color="red"> 汇款时必须填写附言，因不填、错填附言导致上分失败由客户承担全部责任。 </font> <br/><font color="red">请在30分钟内完成汇款操作，若超时不予处理。 </font> ',
    tenpayDeposit: '财付通转帐',
    tenpayMessage: '<font color="green">提示信息</font>:<br/><font color="red">财付通小额转帐(1000元以下)，无需填单，自动上分。</font>  <br/> <font color="red"> 汇款时必须填写附言，因不填、错填附言导致上分失败由客户承担全部责任。 </font> <br/><font color="red">请在30分钟内完成汇款操作，若超时不予处理。 </font> ',
    yeepaycardDeposit: '易宝充值卡充值',
    yeepaycardMessage: '<font color="green">提示信息</font>:<br/><font color="red">易宝充值卡充值(1000元以下)，无需填单，自动上分。</font>  <br/> <font color="red"> 汇款时必须填写附言，因不填、错填附言导致上分失败由客户承担全部责任。 </font> <br/><font color="red">请在30分钟内完成汇款操作，若超时不予处理。 </font> ',
    //status
    statusA: "未开奬",
    statusW: "已中奖",
    statusS: "未中奖",
    statusC: "个人撤单",
    statusM: "出号撤单",
    statusX: "追中撤单",
    statusO: "空开撤单",
    statusY: "无效订单",
    statusZ: "无效订单",
    //mode
    mode: "当前模式",
    //bet unit
    unit1: "2元",
    unit2: "2角",
    unit3: "2分",
    unit4: "1元",
    //action
    total: "共",
    bet: "注",
    symbol: "￥",
    unit: "元",
    maxReached: "当前玩法每行最多选择号码不能多于{0}个号码,正确选择号码！",
    inCompleteGame: '请先正确选择号码后再投注！',
    inCorrect:'请按规则正确选择号码！',
    sameAccount: "同一账户不能互转，请重新选择账户",
    confirmOrders: '总投注金额为￥<span class="hl-popup-message-bold">{0}</span>, 请确认。',
    orderSuccess: '订单成功，注单数 <span class="hl-popup-message-bold">{0}</span>.<br/> 总投注金额 ￥<span class="hl-popup-message-bold">{1}</span>。',
    withdrawSuccess: '撤单成功',
    transferSuccess: '转账成功',
    withdrawMessage: '<font color="red">提示信息</font>: 提款下限：<font color="red"><b>{0}</b></font> 元/次,提款上限：<font color="green"><b>{1}</b></font> 元/次。',
    withdrawCashSuccess: '提现成功',
    /*
     inCompleteGame: '当前玩法每行最少选择号码不能少于{0}个号码,正确选择号码！',
     inCompleteGame2: '请先正确选择号码后再投注！',    
     error1: '该彩票不销售，详情请联系客服，订单不成功。',
     error2: '该彩票玩法不销售，详情请联系客服 ，订单不成功。',
     error3: '该期彩票不销售，详情请联系客服，订单不成功。',
     error4: '该期彩票还未到销售时间，订单不成功。',
     error5: '追号期数超过最大允许期数，订单不成功。',
     error6: '您所追的期号中，至少一期还未到销售时间，订单不成功。',
     error7: '该期彩票已经截止销售，订单不成功。',
     error8: '超过本期投注上限，订单不成功。',
     error9: '账户余额不足，请先充值再投注。',
     confirmAccount: '彩票账户余额不足，要从主账户支付吗？',
     orderSuccess: '订单成功，游戏编号为 {0}, 总投注金额 ￥{1}。',
     orderFail: '投注失败',
     
     group_1: '豹子',
     group_2: '组三',
     group_3: '组六',
     
     bs_1: '大',
     bs_2: '小',
     oe_3: '单',
     oe_4: '双',
     */
    account1: '主帐户',
    account2: '怡乐殿',
    account3: '体育博彩',
    account4: '彩票',
    accountActivity1: '体育博彩',
    acctDisplayError: '账户信息无法读取。请联系客服。',
    accountM_CA: '主帐户',
    accountP_Agile: '怡乐殿',
    accountP_SB188: '体育博彩',
    accountP_SSC: '彩票',
    acctTransError: '转账时出错。请联系客服。',
    acctInqError: '账户查询出错。请联系客服。',
    acctWithdrawError: '提现出错。请检查您的资金密码是否正确。',
    accountActivityMEM_TRADE_PAY: '投注扣款',
    accountActivityMEM_PROM_COST: '活动赠送',
    accountActivityMEM_MAN_DED: '人工扣减',
    accountActivityAGT_BONUS_PAYOUT: '占成收入',
    accountActivityAGT_GRP_REBATE: '代理返点',
    accountActivityMEM_TRADE_CANCEL: '撤单返款',
    accountActivityAGT_COMM: '代理占成',
    accountActivityAGT_BONUS: '占成累计',
    accountActivityMEM_TRADE_RECEIVE: '派奖所得',
    accountActivityMEM_TROP: '游戏转出',
    accountActivityMEM_TRIP: '游戏转入',
    accountActivityMEM_TROC: '现金转出',
    accountActivityMEM_TRIC: '现金转入',
    accountActivityMEM_O_FR: '冻结转出',
    accountActivityMEM_I_FR: '转入冻结',
    accountActivityMEM_MAN_ADD: '人工添加',
    accountActivityMEM_WDOC: '现金提现',
    accountActivityMEM_REBATE: '会员返点',
    accountActivityMEM_WB_CHARGE: '提现费用',
    accountActivityMEM_DB_CHARGE: '充值费用',
    accountActivityMEM_ADJ_COMP: '理赔收入',
    accountActivityMEM_ADJ_REB: '红利赠送',
    accountActivityMEM_ADJ_DEP: '存款赠送',
    accountActivityMEM_ADJ_DED: '人工扣除',
    accountActivityMEM_ADJ_COM: '代理佣金',
    accountActivityMEM_ADJ_WL: '派奖收入',
    accountActivityFBA_IR: '银行利息',
    accountActivityFBA_BC: '银行手续费',
    accountActivityFBA_OB: '冻结余额',
    accountActivityFBA_AF: '账户冻结',
    accountActivityFBA_IRR: '利息返还',
    accountActivityFBA_BCR: '手续费返还',
    accountActivityFBA_AFR: '冻帐返还',
    accountActivityFBA_OBR: '冻结返还',
    accountActivityTRX_CDT: '账户充值',
    accountActivityTRX_DBT: '账户提现',
    accountActivityTRX_DBT_FAIL: '提现失败',
    accountActivityTRX_TRIN: '转入资金',
    accountActivityTRX_TROU: '转出资金',
    accountActivityTRX_CDT_CST: '存款费用',
    accountActivityTRX_CDT_RBT: '存款返还',
    accountActivityTRX_UNC_CDT: '未取存款',
    accountActivityTRX_DBT_BC: '提现手续费',
    accountActivityTRX_NET_FLT: '未知类型',
    accountActivityTRX_TR_BC: '转手续费',
    accountActivityTRX_CDT_RVS: '存款冻结',
    accountActivityBUY: '投注扣款',
    accountActivityREBATE: '会员返点',
    accountActivityPRIZE: '派奖所得',
    accountActivityREVERSE_REBATE: '奖金退回',
    accountActivityREVERSE_PRIZE: '返点退回',
    accountActivityREFUND_MANUAL_CANCEL: '撤单退款',
    accountActivityREFUND_VOID_CANCEL: '空开退款',
    accountActivityREFUND_CNO_WIN_CANCEL: '追中撤单',
    accountActivityREFUND_CNO_OUT_CANCEL: '出号撤单',
    accountActivityTRANS_IN: '资金转入',
    accountActivityTRANS_OUT: '资金转出'

};

label.errorMsg = {
    "-2": "输入的参数不完整，请重试。",
    "-5": "请先登录",
    "-10": "输入的参数不完整，请重试。",
    "-11": "输入的参数不正确，请重试。",
    "-20": "状态异常",
    "-30": "找不到相关数据",
    "-40": "户头余额不足",
    "-50": "此游戏暂时不接受投注。若有疑问，请联系客服。",
    "-59": "此彩种暂时不接受投注。若有疑问，请联系客服。",
    "-60": "该期已经停止销售。请重新投注正确的期号。",
    "-70": "投注内容过长。请重新投注。",
    "-101": "输入的参数不正确，请重试。",
    "-1000401": "不能提现：每日提现次数或金额已达到上限，请明天再试",
    "-1000402": "不能提现：提现金额不能为0！",
    "-10004020": "不能提现：您的主账户余额为零，请您把资金由游戏场馆子账户转回主账户后重新尝试提款。",
    "-10004021": "不能提现：您所输入的提款金额大于您的主账户金额，请您把资金由游戏场馆子账户转回主账户后重新尝试提款。",
    "-10004022": "不能提现：提现金额已超过限额。",
    "-1000403": "不能提现：没有绑定银行卡，请绑定至少一张银行卡后再试",
    "-1000404": "请输入正确的提现金额，提现金额不可超过可提现金额",
    "-1000405": "请选择银行卡",
    "-1000408": "不能提现：提现金额低于允许最小值",
    "-1000409": "不能提现：提现金额高于 单次提现 允许最大值",
    "-2000001": "提现密码验证出错"
};


String.prototype.startWith = function (str) {
    return (this.match("^" + str) == str)
}
String.prototype.trim = function () {
    return (this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, ""))
}
String.prototype.endWith = function (str) {
    return (this.match(str + "$") == str)
}

Date.prototype.parseUTCDateToLocalDate = function (date) {
    if (!(date instanceof Date)) {
        date = new Date(date);
    }
    return new Date(date.getTime() - (getTimeZoneOffset() * 60 * 1000));
}
Date.prototype.getTimeZoneOffset = function () {
    if (global.timeZoneOffset) {
        return global.timeZone;
    }
    return ((new Date).getTimezoneOffset());
}
Date.prototype.gettimeZone = function () {
    if (global && global.timeZone) {
        return global.timeZone;
    }
    return ((new Date).gettimeZone());
}
Date.prototype.getLocalDateTime = function (serverDate) {
    if (!(serverDate instanceof Date)) {
        serverDate = new serverDate(serverDate);
    }
    return new Date(serverDate.getTime() - ((gettimeZone() - 4) * 60 * 60 * 1000));
}
Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
        "S": this.getMilliseconds() //millisecond
    }
    if (/(y+)/.test(format))
        format = format.replace(RegExp.$1,
                (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1,
                    RegExp.$1.length == 1 ? o[k] :
                    ("00" + o[k]).substr(("" + o[k]).length));
    return format;
};
Date.prototype.toDateString = function () {
    return this.format("yyyy/MM/dd");
}
Date.prototype.toDateTimeString = function () {
    return this.format("yyyy/MM/dd hh:mm:ss")
}
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
//纯对象的属性个数
function propLen(obj) {
    var count = 0;
    for (var i in obj) {
        count++;
    }
    return count;
}
function isEmpty(obj)
{
    if ((typeof obj == 'undefined') || !obj || obj == '0') {
        return true;
    }

    if ((typeof obj == 'boolean') || (typeof obj == 'number')) {
        return false;
    }

    for (var i in obj)
    {
        return false;
    }

    return true;
}
;

//设置cookie，expire为多少秒后到期
function setCookie(name, value, expire) {
    var exp = new Date();
    exp.setTime(exp.getTime() + expire * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}
//获取cookie
function getCookie(name) {
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null)
        return unescape(arr[2]);
    return null;
}
//删除cookie
function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    if (cval != null)
        document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}

//格式化服务器时间
function getTS(dateStr) {
    return Math.floor(new Date(dateStr.replace(/[\-\u4e00-\u9fa5]/g, "/")).getTime() / 1000);
}

function showTime() {
    var d = new Date();
    var str = d.getFullYear() + '-' + padLeft(d.getMonth() + 1) + '-' + padLeft(d.getDate().toString()) + ' ' + padLeft(d.getHours().toString()) + ':' + padLeft(d.getMinutes().toString()) + ':' + padLeft(d.getSeconds().toString());
    document.getElementById("nowTime").innerHTML = str; //ff不支持innerText
}

String.prototype.trim = function ()
{
    return this.replace(/(^\s*)|(\s*$)/g, '');
}

function rtrim(str, charlist) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Erkekjetter
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   input by: rem
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: rtrim('    Kevin van Zonneveld    ');
    // *     returns 1: '    Kevin van Zonneveld'
    charlist = !charlist ? ' \\s\u00A0' : (charlist + '').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\\$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return (str + '').replace(re, '');
}

function checkAll(obj)
{
    $(":checkbox[id!='" + obj + "']").attr("checked", $("#" + obj).attr("checked"));
}

function isEmail(str) {
    var re = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;

    return re.test(str);
}

function getXY(wnd) {
    var scrollX = 0, scrollY = 0, width = 0, height = 0, contentWidth = 0, contentHeight = 0;
    if (typeof (wnd) == 'undefined') {
        wnd = window.self;
    }
    if (typeof (wnd.pageXOffset) == 'number') {
        scrollX = wnd.pageXOffset;
        scrollY = wnd.pageYOffset;
    }
    else if (wnd.document.body && (wnd.document.body.scrollLeft || wnd.document.body.scrollTop)) {
        scrollX = wnd.document.body.scrollLeft;
        scrollY = wnd.document.body.scrollTop;
    }
    else if (wnd.document.documentElement && (wnd.document.documentElement.scrollLeft || wnd.document.documentElement.scrollTop)) {
        scrollX = wnd.document.documentElement.scrollLeft;
        scrollY = wnd.document.documentElement.scrollTop;
    }
    if (typeof (wnd.innerWidth) == 'number') {
        width = wnd.innerWidth;
        height = wnd.innerHeight;
    }
    else if (wnd.document.documentElement && (wnd.document.documentElement.clientWidth || wnd.document.documentElement.clientHeight)) {
        width = wnd.document.documentElement.clientWidth;
        height = wnd.document.documentElement.clientHeight;
    }
    else if (wnd.document.body && (wnd.document.body.clientWidth || wnd.document.body.clientHeight)) {
        width = wnd.document.body.clientWidth;
        height = wnd.document.body.clientHeight;
    }
    if (wnd.document.documentElement && (wnd.document.documentElement.scrollHeight || wnd.document.documentElement.offsetHeight)) {
        if (wnd.document.documentElement.scrollHeight > wnd.document.documentElement.offsetHeight) {
            contentWidth = wnd.document.documentElement.scrollWidth;
            contentHeight = wnd.document.documentElement.scrollHeight;
        }
        else {
            contentWidth = wnd.document.documentElement.offsetWidth;
            contentHeight = wnd.document.documentElement.offsetHeight;
        }
    }
    else if (wnd.document.body && (wnd.document.body.scrollHeight || wnd.document.body.offsetHeight)) {
        if (wnd.document.body.scrollHeight > wnd.document.body.offsetHeight) {
            contentWidth = wnd.document.body.scrollWidth;
            contentHeight = wnd.document.body.scrollHeight;
        }
        else {
            contentWidth = wnd.document.body.offsetWidth;
            contentHeight = wnd.document.body.offsetHeight;
        }
    }
    else {
        contentWidth = width;
        contentHeight = height;
    }
    if (height > contentHeight)
        height = contentHeight;
    if (width > contentWidth)
        width = contentWidth;
    var rect = new Object();
    rect.scrollX = scrollX;
    rect.scrollY = scrollY;
    rect.width = width;
    rect.height = height;
    rect.contentWidth = contentWidth;
    rect.contentHeight = contentHeight;

    return rect;
}

function array_unique(inputArr) {
    // http://kevin.vanzonneveld.net
    // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
    // +      input by: duncan
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Nate
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Michael Grier
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // %          note 1: The second argument, sort_flags is not implemented;
    // %          note 1: also should be sorted (asort?) first according to docs
    // *     example 1: array_unique(['Kevin','Kevin','van','Zonneveld','Kevin']);
    // *     returns 1: {0: 'Kevin', 2: 'van', 3: 'Zonneveld'}
    // *     example 2: array_unique({'a': 'green', 0: 'red', 'b': 'green', 1: 'blue', 2: 'red'});
    // *     returns 2: {a: 'green', 0: 'red', 1: 'blue'}
    var key = '',
            tmp_arr2 = {}, val = '', tmp_arr3 = [];

    var __array_search = function (needle, haystack) {
        var fkey = '';
        for (fkey in haystack) {
            if (haystack.hasOwnProperty(fkey)) {
                if ((haystack[fkey] + '') === (needle + '')) {
                    return fkey;
                }
            }
        }
        return false;
    };

    for (key in inputArr) {
        if (inputArr.hasOwnProperty(key)) {
            val = inputArr[key];
            if (false === __array_search(val, tmp_arr2)) {
                tmp_arr2[key] = val;
                tmp_arr3.push(val);
            }
        }
    }
    //return tmp_arr2;  //返回对象
    return tmp_arr3;  //返回数组
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // http://kevin.vanzonneveld.net
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +   improved by: davook
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Jay Klehr
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +      input by: Amirouche
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    // *    example 13: number_format('1 000,50', 2, '.', ' ');
    // *    returns 13: '100 050.00'
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? '' : thousands_sep, //我的改动：默认为空而不是逗号
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function round(value, precision, mode) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +    revised by: Onno Marsman
    // +      input by: Greenseed
    // +    revised by: T.Wild
    // +      input by: meo
    // +      input by: William
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Josep Sanz (http://www.ws3.es/)
    // +    revised by: Rafał Kukawski (http://blog.kukawski.pl/)
    // %        note 1: Great work. Ideas for improvement:
    // %        note 1:  - code more compliant with developer guidelines
    // %        note 1:  - for implementing PHP constant arguments look at
    // %        note 1:  the pathinfo() function, it offers the greatest
    // %        note 1:  flexibility & compatibility possible
    // *     example 1: round(1241757, -3);
    // *     returns 1: 1242000
    // *     example 2: round(3.6);
    // *     returns 2: 4
    // *     example 3: round(2.835, 2);
    // *     returns 3: 2.84
    // *     example 4: round(1.1749999999999, 2);
    // *     returns 4: 1.17
    // *     example 5: round(58551.799999999996, 2);
    // *     returns 5: 58551.8
    var m, f, isHalf, sgn; // helper variables
    precision |= 0; // making sure precision is integer
    m = Math.pow(10, precision);
    value *= m;
    sgn = (value > 0) | -(value < 0); // sign of the number
    isHalf = value % 1 === 0.5 * sgn;
    f = Math.floor(value);

    if (isHalf) {
        switch (mode) {
            case 'PHP_ROUND_HALF_DOWN':
                value = f + (sgn < 0); // rounds .5 toward zero
                break;
            case 'PHP_ROUND_HALF_EVEN':
                value = f + (f % 2 * sgn); // rouds .5 towards the next even integer
                break;
            case 'PHP_ROUND_HALF_ODD':
                value = f + !(f % 2); // rounds .5 towards the next odd integer
                break;
            default:
                value = f + (sgn > 0); // rounds .5 away from zero
        }
    }

    return (isHalf ? value : Math.round(value)) / m;
}

function str_repeat(input, multiplier) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Ian Carter (http://euona.com/)
    // *     example 1: str_repeat('-=', 10);
    // *     returns 1: '-=-=-=-=-=-=-=-=-=-='

    var y = '';
    while (true) {
        if (multiplier & 1) {
            y += input;
        }
        multiplier >>= 1;
        if (multiplier) {
            input += input;
        }
        else {
            break;
        }
    }

    return y;
}

function is_numeric(mixed_var) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: David
    // +   improved by: taith
    // +   bugfixed by: Tim de Koning
    // +   bugfixed by: WebDevHobo (http://webdevhobo.blogspot.com/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: is_numeric(186.31);
    // *     returns 1: true
    // *     example 2: is_numeric('Kevin van Zonneveld');
    // *     returns 2: false
    // *     example 3: is_numeric('+186.31e2');
    // *     returns 3: true
    // *     example 4: is_numeric('');
    // *     returns 4: false
    // *     example 4: is_numeric([]);
    // *     returns 4: false
    return (typeof (mixed_var) === 'number' || typeof (mixed_var) === 'string') && mixed_var !== '' && !isNaN(mixed_var);
}

function getUrlParam(name, url) {
    if (!url)
        url = window.location.hash;
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = url.substr(url.indexOf('?') + 1).match(reg);
    if (r != null) {

        return unescape(r[2]);
    }
    return null;
}

var common = {
    ajax: function (url, param, callback, errorCb, container) {
        $.ajax({
            url: url,
            type: 'POST',
            data: param,
            dataType: "text",
            success: function (resultStr, textStatus, jqXHR) {
                if (resultStr == '') {
                    // Do nothing for empty result string
                    callback(null);
                    return;
                }
                //resultStr = common.repairFaultyJson(resultStr);
                var result;
                try {
                    result = JSON.parse(resultStr);
                } catch (E) {
                    // Do nothing for invalid result string
                    alert(E.message);
                    callback(null);
                    return;
                }
                callback(result);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                callback(null);
                alert('Server error (' + textStatus + '): ' + errorThrown);
            }
        });
    }

};


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
        var countnum=0;
        switch (orderSelect.gameSubOption.name) {
            //pk10玩法
            case 'PKQ6LX':  //猜前六
            case 'PKQ7LX':  //猜前七
            case 'PKQ8LX':  //猜前八
                for (i in CombinList) {
                    countnum += CombinList[i].length;
                    if (countnum > 50) {
                        alert("所选号码不能超过50个!");
                        orderSelect.renderNumber($("#gameOptionList").val());
                        return 0;
                    }
                }
                break;
            case 'PKQ9LX':  //猜前九
            case 'PKQ10LX':  //猜前十
                for (i in CombinList) {
                    countnum += CombinList[i].length;
                    if (countnum > 30) {
                        alert("所选号码不能超过30个!");
                        orderSelect.renderNumber($("#gameOptionList").val());
                        return 0;
                    }
                }
                break;
        }
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
                                    alert("最大注数不能超过1万注!");
                                    orderSelect.renderNumber($("#gameOptionList").val());
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
    factorial: function (n) {
        if (n == 1) {
            return 1
        } else {
            return n * helper.factorial(n - 1)
        }
    },
    expandLotto: function ($nums) {
        var result = [];
        var tempVars = [];
        var oneAreaIsEmpty = 0;
        $.each($nums,
                function (k, v) {
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
                function (k, v) {
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
    getGameLabel: function (id) {
        return window["label"]["game" + id];
    },
    //get game by id
    getGameById: function (id) {
        var result = null;
        var data = cache.getData();

        $.each(data.games, function () {
            if (this.id == id) {
                result = this;

                return false;
            }
        });

        return result;
    },
    //get game configs by id
    getGameConfigsById: function (id) {
        var data = cache.getData();
        var index = -1;
        $.each(data.games, function (i) {
            if (this.id == id) {
                index = i;
            }
        });
        //获取彩种的所有配置信息
        if (index != -1 && !data.games[index].gc) {
            $.mobile.loading('hide');
            $.mobile.loading('show');
            server.getGameConfig(id,
                    function (rGc) {
                        $.mobile.loading('hide');
                        if (rGc)
                            data.games[index].gc = rGc;
                    });
        }
        return data.games[index];
    },
    //get game option
    getGameOptionLabel: function (id) {

        return window["label"]["opt" + id];
    },
    //get game sub option
    getGameSubOptionLabel: function (id) {

        return window["label"]["subOpt" + id];
    },
    //get game sub option summary 
    getGameSubOptionSummaryLabel: function (id) {

        return window["label"]["subOptSummary" + id];
    },
    //get game sub option configuration
    getGameSubOptionConfig: function (id) {
        var result = null;
        var data = cache.getData();
        $.each(data.gameSubOption, function () {
            if (this.id == id) {
                result = this;

                return false;
            }
        });

        return result;
    },
    //get game status
    getGameStatus: function (type) {

        return window["label"]["status" + type];
    },
    //get payout group by id
    getPayoutGroup: function (id) {
        var result = null;
        var data = cache.getData();
        $.each(data.groups, function () {
            if (this.id == id) {
                result = this;

                return false;
            }
        });

        return result;
    },
    //get unit - 元角分
    getUnit: function (u) {
        return window["label"]["unit" + u];
    },
    //get yes no
    getYesNo: function (b) {
        return window["label"]["yn" + b];
    },
    //calculate order summary
    orderSummary: function (numbers, payout, rebate, unit, gameCode) {
        if (unit == 4) {
            unit = 1;
        }
        else if (unit == 2) {
            unit = 0.02;
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
    getAccountLabel: function (id) {
        return window["label"]["account" + id];
    },
    //get account activity type
    getAccountActivityType: function (id) {
        return window["label"]["accountActivity" + id];
    },
    //convert unit
    convertToBaseUnit: function (type, value) {
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
    convertToUnit: function (type, value) {
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
    alert: function (input, container, callback) {
        if(container.is(":visible")){
            $(".hl-system-confirm", container).popup("close");
            var popLayer = document.getElementById('popLayer');
            var selectLayer = document.getElementById('selectLayer');
            $(".hl-system-popup-text", container).html(input);
            $(".hl-system-popup", container).popup("open", {history: false});
            //var perstyle='';perstyle=$(".ui-popup-active").attr("style");
            //var temptop=perstyle.match(/top[\W\w]+?px;/);
            //perstyle=perstyle.replace(temptop,"top:25%;position:fixed;");
            $(".ui-popup-active").attr("style","top:50%;left:50%;position:fixed;width:280px;height:170px;margin-left:-140px;margin-top:-85px;");
            popLayer.style.display = "block";
            selectLayer.style.display = "block";
        }

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

    },
    //prompt
    prompt: function (input, container, callback) {
        $(".hl-system-confirm", container).popup("close");
        $(".hl-system-popup-text", container).html(input);
        $(".hl-system-popup", container).popup("open");

        $(".popup-close", container).off("click").click(function () {
            $(".hl-system-popup", container).popup("close");

            setTimeout(function () {
                if (callback != null) {
                    callback();
                }
            }, 500);
        });
    },
    //confirm
    confirm: function (input, container, confirmCallback, cancelCallback) {
        $(".hl-system-confirm-text", container).html(input);
        $(".hl-system-confirm", container).popup("open");
        //var perstyle='';perstyle=$("#placeOrderPopup-popup").attr("style");
        //var temptop=perstyle.match(/top[\W\w]+?px;/);
        //perstyle=perstyle.replace(temptop,"top:25%;position:fixed;");
        $("#placeOrderPopup-popup").attr("style","top:50%;left:50%;position:fixed;width:280px;height:170px;margin-left:-140px;margin-top:-85px;");



        $(".popup-cancel", container).off("click").click(function () {
            $(".hl-system-confirm", container).popup("close");

            setTimeout(function () {
                if (cancelCallback != null) {
                    cancelCallback();
                }
            }, 500);
        });

        $(".popup-confirm", container).off("click").click(function () {
            $(".hl-system-confirm", container).popup("close");

            setTimeout(function () {
                if (confirmCallback != null) {
                    confirmCallback();
                }
            }, 500);
        });
    },
    //parse float
    parseFloat: function (input) {
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

    digits: function (n, p) {
        var t = $.type(n);

        if (($.type(n) != 'number' && $.type(n) != 'string') || n == null || n === 'null') {
            return '';
        }

        return n.toString().toFixed(
                $.type(p) == 'number' ? p : 2
                ).addCommas();
    },
    cny: function (n, p) {
        var t = utils.digits(n, p);
        return t != '' ? label.symbol + t : t;
    },
    hideLoading: function () {
        $.mobile.loading('hide');
    },
    //number only
    isNumberOnly: function (keyCode) {
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
    isValidBetNumber: function (keyCode) {
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
    isNavigationKey: function (keyCode) {
        var result = false;

        // allow: backspace, tab, left arrow, right arrow, delete, space, +, . and ,             
        if (keyCode == 8 ||
                keyCode == 37 ||
                keyCode == 39) {
            result = true;
        }

        return result;
    },
 
    isLegalCode:  function (codes,method) {

        //这一段加上否则直选和值类玩法不选号也能添加
        if (allHasValue(codes)['charsNum'] == 0) {
            return {
                singleNum: 0,
                isDup: 0
            };
        }
        var singleNum = 0, isDup = 0, parts;
        switch (method.name) {
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
                var length = propLen(method.field_def);
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
                throw "unfinished method " + method.name;
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
    Array.prototype.indexOf = function (obj) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == obj) {

                return i;
            }
        }

        return -1;
    }
}

//format number
Number.prototype.toFixed = function (precision) {

    return this.toString().toFixed(precision);
};

//format number
String.prototype.toFixed = function (precision) {
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
String.prototype.addCommas = function () {
    x = this.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;
};


var utils2 = {
    calculateNoRepeatLots: function (rows) {
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
    sumArrLength: function (rows) {
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
    combination: function (n, k) {
        if (k > n) {

            return 0;
        }
        if (k < 0) {

            return 0;
        }

        return this.factorial(n) / (this.factorial(k) * this.factorial(n - k));
    },
    factorial: function (n) {
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
    findCombinations: function (array2d) {
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
    _findCombinations: function (arr, index, cur) {
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
    findRepeat: function (arr) {
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

utils.serializeOrders = function (orders) {
    var map = {};
    for (var i = 0; i < orders.length; i++) {
        var gameCode = orders[i].code;
        if (gameCode.length == 1) {
            gameCode = '0' + gameCode;
        }
        if (typeof map[gameCode] !== 'string') {
            map[gameCode] = '';
        }
        if (map[gameCode].length > 0) {
            map[gameCode] += ','
        }
        map[gameCode] += orders[i].detail;
    }
    var result = [];
    for (var gameCode in map) {
        result.push(gameCode + map[gameCode]);
    }
    return result.join('.') + '.';
};

utils.errorMsg = function (code, container) {
    utils.hideLoading();
    utils.alert(label.errorMsg[code], container);
};

utils.errorMsg2 = function (msg, container) {
    utils.hideLoading();
    utils.alert(msg, container);
};