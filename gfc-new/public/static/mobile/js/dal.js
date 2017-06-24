var server = {};
window.alert = function(str)
{
    var alertFram = document.createElement("DIV");
    alertFram.setAttribute('class','alertFram');
    //alertFram.class="alertFram";
    alertFram.style.position = "fixed";
    alertFram.style.left = "50%";
    alertFram.style.top = "50%";
    alertFram.style.marginLeft = "-125px";
    alertFram.style.marginTop = "-75px";
    alertFram.style.width = "250px";
    alertFram.style.height = "150px";
    alertFram.style.textAlign = "center";
    alertFram.style.lineHeight = "150px";
    alertFram.style.zIndex = "300";
    strHtml = "<ul style=\"list-style:none;margin:0px;padding:0px;width:100%;border:1px solid #cd1b02;border-radius:5px;background:#f6f6f3;\">\n";
    strHtml += " <li style=\"background:#cd1b02;color:#fff;text-align:center;padding-left:20px;font-size:18px;font-weight:bold;height:41px;line-height:41px;border-bottom:1px solid #cd1b02;\">友情提示</li>\n";
    strHtml += " <li style=\"background:#f6f6f3;text-align:center;font-size:14px;height:100px;line-height:100px;\">"+str+"</li>\n";
    strHtml += " <li style=\"text-align:center;font-weight:bold;height:46px;line-height:25px;\"><input type=\"button\" value=\"确 定\" onclick=\"doOk()\" style=\"width: 90%;height: 35px;color: #fff;border: 1px solid #cd1b02;font-size: 16px;border-radius: 5px;background-image: -webkit-gradient(linear, 0 0, 0 70%, from(#cd1b02), to(#cd1b02));background-image: -moz-linear-gradient(#cd1b02, #cd1b02);background-image:-ms-linear-gradient(#cd1b02, #cd1b02);\" /></li>\n";
    strHtml += "</ul>\n";
    alertFram.innerHTML = strHtml;
    //function doOk(){
    //    console.log('11132ds');
    //    document.getElementById('alertFram').style.display='none';
    //}
    document.body.appendChild(alertFram);
    //var ad = setInterval("doOk()",5000);
    alertFram.focus();
    document.body.onselectstart = function(){return false;};
};
function doOk(){
    $(".alertFram").hide();
}
server.getConfig = function(callback) {
    var config = {
        'games':
                [
                    /*{'id': 'SSCFFC', 'lottery_id': 11, 'req': 'sscffc', 'desc': '一分钟一期', 'gc': null},*/
                    {'id': 'CQSSC', 'lottery_id': 1, 'req': 'cqssc', 'desc': '最多人玩', 'gc': null},
                    /*{'id': 'HLJSSC', 'lottery_id': 3, 'req': 'hljssc', 'desc': '十分钟一期', 'gc': null},*/
                    {'id': 'XJSSC', 'lottery_id': 4, 'req': 'xjssc', 'desc': '十分钟一期', 'gc': null},
                    {'id': 'TJSSC', 'lottery_id': 8, 'req': 'tjssc', 'desc': '十分钟一期', 'gc': null},
                    /*{'id': 'CQ115', 'lottery_id': 5, 'req': 'cq115', 'desc': '返奖率高', 'gc': null},*/
                    {'id': 'SD11Y', 'lottery_id': 2, 'req': 'sd11y', 'desc': '返奖率高', 'gc': null},
                    {'id': 'JX115', 'lottery_id': 6, 'req': 'jx115', 'desc': '返奖率高', 'gc': null},
                    {'id': 'GD115', 'lottery_id': 7, 'req': 'gd115', 'desc': '返奖率高', 'gc': null},
                    {'id': 'JSKS', 'lottery_id': 12, 'req': 'jsks', 'desc': '三个号码一注', 'gc': null},
                    {'id': 'HBKS', 'lottery_id': 17, 'req': 'hbks', 'desc': '三个号码一注', 'gc': null},
                    {'id': 'FC3D', 'lottery_id': 9, 'req': 'low3D', 'desc': '最容易中奖', 'gc': null},
                    {'id': 'P3P5', 'lottery_id': 10, 'req': 'P3P5', 'desc': '易玩多中', 'gc': null},
                    {'id': 'PK10', 'lottery_id': 16, 'req': 'pk10', 'desc': '', 'gc': null}
                ]
    }
    callback(config);
};
server.getGameConfig = function(gameId, callback) {
    var game = utils.getGameById(gameId);
    //使用同步ajaxa 设置 sync: false,
    $.ajax({type: 'POST',
        beforeSend: function() {
        },
        async: false,
        url: RP_DATA + '?c=game&a=' + game.req,
        data: {},
        dataType: 'json',
        error: function() {
            alert("网络异常，请刷新页面");
            callback(null);
        },
        success: function(result) {
            if (result.errno) {
                alert(result.errstr);
                callback(null);
            } else {
                callback(result);
            }
        }
    });
};
server.getDraw = function(gameId, callback) {
    var game = utils.getGameById(gameId);
    $.ajax({
        url: RP_DATA + "?c=game&a=play",
        type: "POST",
        data: {
            op: "getCurIssue",
            lotteryId: game.lottery_id
        },
        cache: false,
        dataType: "json",
        timeout: 30000,
        success: function(response) {
            if (response.errno == 0) {
                var result = {};
                result.curIssueInfo = response.issueInfo;
                result.curServerTime = response.serverTime;
                result.curRemainTime = getTS(result.curIssueInfo.end_time) - getTS(result.curServerTime);
                result.curWaitOpenTime = 30;
                result.lastIssueInfo = response.lastIssueInfo;
                callback(result);
            }
            else if (response.errno == LOGOUT) {
                callback(LOGOUT);
            }
            else {

                alert(response.errstr);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (errorThrown.indexOf("a=logout") != -1) {
                alert("您已经退出，请重新登录");
            } else {
                alert("网络异常，请刷新页面");
            }
        }
    });
};
//
server.getDrawResult = function(gameId, callback) {
    var game = utils.getGameById(gameId);
    common.ajax(OPENISSUE_URL,
            {'lotteryName': game.req},
    function(result) {
        var s = result;
        var list = [];
        for (var i = 0; i < s.length; i++) {
            list.push({
                'ssue_id': s[i].ssue_id,
                'id': s[i].issue,
                'val': s[i].code
            });
        }
        callback(list);
    });
};
server.login = function(loginData, callback) {
    jQuery.ajax({
        url: RP_DATA + '?a=login',
        type: "POST",
        data: {
            'username': loginData.id,
            'encpassword': $.md5(loginData.password),
            'verify': 'login'
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            if (data.errno == 0) {
                callback({'isLogin': true, 'id': loginData.id,
                    a: [
                        {id: '1'}
                    ]});
            } else {
                alert(data.errstr);
                callback(null);
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
};
server.logout = function(callback) {
    jQuery.ajax({
        url: RP_DATA + '?a=logout',
        complete: function(jqXHR, textStatus) {
            callback(true);
        }
    });
};
server.getAccount = function(data, callback) {
    common.ajax( BALANCE_URL, {},
            function(result) {
                var s = [];
                s.push({
                    id: 1,
                    aId: 1,
                    val: result.balance
                });
                callback(s);
            },
            function(result) {
                utils.errorMsg(label.acctDisplayError, $("#accountSummary"));
            },
            $("#accountSummary")
            );
};
server.getAccountActivity = function(data, callback) {
    common.ajax(RP_DATA + '?startDate=1970-01-01&orderType=0&c=fin&a=orderList&curPage=' + data.pageNumber,
            {},
            function(result) {
                var r = {};
                if (result) {
                    r.c = data.pageNumber + 1;
                    r.r = result;
                }
                else
                {
                    r.r = [];
                    r.c = 0;
                }
                callback(r);
            },
            function(result) {
                utils.errorMsg(label.acctInqError, $("#accountInquiry"));
            },
            $("#accountInquiry")
            );
}

server.saveOrder = function(orderDetail, callback) {
    var orderInfo = {};
    var codes = '';
    var tmpMethod = '';
    var mid = '';
    var code = '';
    var listFirst = '';
    var mids = '';
    for (var number in orderDetail.data) {
        mid = orderDetail.data[number].subOption;
        if (mids) {
            mids += ',';
        }
        mids += mid;
        code = orderDetail.data[number].codes;
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
    }
//追号
    if ((0 + orderDetail.cno) > 1) {
        orderInfo = {
            'op': 'buy',
            'modes': orderDetail.modes,
            'curRebate': orderDetail.curRebate,
            'issue': orderDetail.issue,
            'lotteryId': orderDetail.lotteryId,
            'multiple': orderDetail.multiplier,
            'codes': codes,
            'stopOnWin': orderDetail.stopOnWin,
            'traceCount': orderDetail.cno,
            'mids': mids
        };
        if (orderDetail.traceData) {
            $.each(orderDetail.traceData, function(i) {
                orderInfo['traceData[' + i + '][issue]'] = this.issue;
                orderInfo['traceData[' + i + '][multiple]'] = this.multiple;
            });
        }

    }
    else {
        orderInfo = {
            'op': 'buy',
            'modes': orderDetail.modes,
            'curRebate': orderDetail.curRebate,
            'issue': orderDetail.issue,
            'lotteryId': orderDetail.lotteryId,
            'multiple': orderDetail.multiplier,
            'codes': codes,
            'traceCount': 0,
            'mids': mids
        };
    }
    common.ajax(RP_DATA + '?c=game&a=play', orderInfo,
            function(result) {
                if (result.errno == 0) {
                    var r = {
                        no: result.pkgnum
                    };
                    callback(r);
                } else {
                    utils.alert(result.errstr, $("#orderConfirm"));
                    callback(null);
                }
            },
            function(result) {
                utils.alert(result.errstr, $("#orderConfirm"));
                callback(null);
            },
            $("#orderConfirm")
            );
};
server.getOrders = function(data, callback) {
    var game = utils.getGameById(data.gameId);
    var timeNow = new Date();
    var start_time = new Date();
    var end_time = new Date();
    end_time.setTime(timeNow.getTime() + 24 * 60 * 60 * 1000);
    end_time = end_time.format("yyyy-MM-dd");
    start_time.setTime(timeNow.getTime() - (data.day - 1) * 24 * 60 * 60 * 1000);
    start_time = start_time.format("yyyy-MM-dd");
    common.ajax(RP_DATA + '?submit=%E6%9F%A5%E8%AF%A2&c=game&a=packageList&wrap_id=&end_time=' + end_time + '&start_time=' + start_time + '&curPage=' + data.pageNumber + '&lottery_id=' + game.lottery_id
            , {},
            function(result) {
                var r = {};
                if (result) {
                    r.c = data.pageNumber + 1;
                    r.r = result;
                }
                else
                {
                    r.r = [];
                    r.c = 0;
                }
                callback(r);
            },
            function(result) {
                utils.errorMsg(result.code, $("#search"));
            },
            $("#search")
            );
};
server.getDetail = function(data, callback) {
    //var url_a=data.trace_id>0?'traceDetail':'packageDetail' ;
    var url_a = 'packageDetail';
    var url = RP_DATA + '?c=game&a=' + url_a + '&wrap_id=' + data.id;
    common.ajax(url, {},
            function(result) {
                callback(result);
            },
            function(result) {
                utils.errorMsg(result.code, $("#detail"));
            },
            $("#detail")
            );
};
server.withdraw = function(data, callback) {
    var url_a = data.trace_id > 0 ? 'cancelTrace' : 'cacelPackage';
    var url = RP_DATA + '?c=game&a=' + url_a;
    var params = {'wrap_id': data.wrap_id};
    if (data.trace_id > 0 && data.pkids) {
        params['pkids[]'] = data.pkids;
    }
    common.ajax(url, params,
            function(result) {
                callback(result);
            },
            function(result) {
                utils.errorMsg(result.code, $("#detail"));
            },
            $("#detail")
            );
};
//get account withdraw
server.getAccountWithdraw = function(data, callback) {
    var url = RP_DATA + '?c=fin&a=withdraw';
    common.ajax(url, {},
            function(result) {
                callback(result);
            },
            function(result) {
                utils.errorMsg(result.errstr, $("#accountWithdraw"));
            },
            $("#accountWithdraw")
            );
};
//submit account withdraw
server.accountWithdraw = function(data, callback) {
    var postData = {op: 'doWithdraw'};
    postData.bind_card_id = data.bind_card_id;
    postData.secpassword = data.secpassword;
    postData.withdraw_bank_id = data.withdraw_bank_id;
    postData.withdraw_amount = data.withdraw_amount;
    var url = RP_DATA + '?c=fin&a=withdraw';
    common.ajax(url, postData,
            function(result) {
                callback(result);
            },
            function(result) {
                utils.errorMsg(result.errstr, $("#accountWithdraw"));
            },
            $("#accountWithdraw")
            );
};
//get account withdraw
server.getPay = function(data, callback) {
    var bankId = '';
    switch (data.bank)
    {
        case 'icbc':
            bankId = '1';
            break;
        case 'alipay':
            bankId = '101';
            break;
        case 'tenpay':
            bankId = '102';
            break;
        case 'icbc':
            bankId = '1';
            break;
        case 'yeepaycard':
            callback({'types': [{'name': '神州行', 'code': 'SZX-NET'}, {'name': '联通卡', 'code': 'UNICOM-NET'}, {'name': '电信卡', 'code': 'TELECOM-NET'}]
                , 'amounts': [{'name': '10元', 'amount': '10'}, {'name': '50元', 'amount': '50'}, {'name': '100元', 'amount': '100'}, {'name': '200元', 'amount': '200'}, {'name': '500元', 'amount': '500'}
                    , {'name': '1000元', 'amount': '1000'}]});
            return;
            break;
        default:
            return;
    }

    var url = RP_DATA + '?c=fin&a=showAccount&bankId=' + bankId;
    common.ajax(url, {},
            function(result) {
                callback(result);
            },
            function(result) {
                utils.errorMsg(result.errstr, $("#" + data.bank));
            },
            $("#" + data.bank)
            );
};

//get account withdraw
server.getTracePage = function(data, callback) {
    var url = RP_DATA + '?c=game&a=play';
    common.ajax(url, {op: 'getTracePage', lotteryId: data.lotteryId, mids: data.mids},
    function(result) {
        callback(result);
    },
            function(result) {
                utils.errorMsg(result.errstr, $("#orderConfirm"));
            },
            $("#orderConfirm")
            );
};


 