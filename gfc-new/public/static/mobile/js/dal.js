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
    strHtml += " <li class='checkLogin' style=\"text-align:center;font-weight:bold;height:46px;line-height:25px;\"><input type=\"button\" value=\"确 定\" onclick=\"doOk()\" style=\"width: 90%;height: 35px;color: #fff;border: 1px solid #cd1b02;font-size: 16px;border-radius: 5px;background-image: -webkit-gradient(linear, 0 0, 0 70%, from(#cd1b02), to(#cd1b02));background-image: -moz-linear-gradient(#cd1b02, #cd1b02);background-image:-ms-linear-gradient(#cd1b02, #cd1b02);\" /></li>\n";
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
var into={};
server.setInter = function(data,nowTime){ 
   if(data.state != 1 && data.state != 0 ){
      var   str = "<span style='color:#ef0808;font-size:65%;'>等待开奖</span>";
      if(data.lid == 2){
            $("#gameCQSSC").find("p").find("i").removeClass();
            $("#gameCQSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameCQSSC").find("p").find("span").html(str);
        }else if(data.lid == 8){
             $("#gameXJSSC").find("p").find("i").removeClass();
            $("#gameXJSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameXJSSC").find("p").find("span").html(str);
        }else if(data.lid == 14){
             $("#gameTJSSC").find("p").find("i").removeClass();
            $("#gameTJSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameTJSSC").find("p").find("span").html(str);
        }else if(data.lid == 26){
             $("#gameSD11Y").find("p").find("i").removeClass();
            $("#gameSD11Y").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameSD11Y").find("p").find("span").html(str);
        }else if(data.lid == 27){
             $("#gameJX115").find("p").find("i").removeClass();
            $("#gameJX115").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameJX115").find("p").find("span").html(str);
        }else if(data.lid == 24){
             $("#gameGD115").find("p").find("i").removeClass();
            $("#gameGD115").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameGD115").find("p").find("span").html(str);
        }else if(data.lid == 9){
             $("#gameJSKS").find("p").find("i").removeClass();
            $("#gameJSKS").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameJSKS").find("p").find("span").html(str);
        }else if(data.lid == 30){
             $("#gameHBKS").find("p").find("i").removeClass();
            $("#gameHBKS").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameHBKS").find("p").find("span").html(str);
        }else if(data.lid == 28){
             $("#gameFC3D").find("p").find("i").removeClass();
            $("#gameFC3D").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameFC3D").find("p").find("span").html(str);
        }else if(data.lid == 29){
             $("#gameP3P5").find("p").find("i").removeClass();
            $("#gameP3P5").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gameP3P5").find("p").find("span").html(str);
        }else if(data.lid == 6){
            $("#gamePK10").find("p").find("i").removeClass();
            $("#gamePK10").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            $("#gamePK10").find("p").find("span").html(str);
        }
        return;
   }
    var serverTime = nowTime * 1000;
    var dateTime = new Date().getTime();
    var difference =  dateTime - serverTime;
    clearInterval(into[data.lid]);
    into[data.lid]=setInterval(function(){ 
        var endTime =new Date(data.end_time).getTime();
        var nowTimess = new Date().getTime();
        var nMS=endTime - nowTimess + difference;
        var myD=Math.floor(nMS/(1000 * 60 * 60 * 24));
        var myH=Math.floor(nMS/(1000*60*60)) % 24;
        var myM=Math.floor(nMS/(1000*60)) % 60;
        var myS=Math.floor(nMS/1000) % 60;
        var myMS=Math.floor(nMS/100) % 10;
        if(myD>= 0){
           if(data.lid == 2){
                $("#gameCQSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 8){
                $("#gameXJSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 14){
                $("#gameTJSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 26){
                $("#gameSD11Y").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 27){
                $("#gameJX115").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 24){
                $("#gameGD115").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 9){
                $("#gameJSKS").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 30){
                $("#gameHBKS").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 28){
                $("#gameFC3D").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 29){
                $("#gameP3P5").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }else if(data.lid == 6){
                $("#gamePK10").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs am-icon-spin text-kaijiangzhong");
            }      
          var  str ="<span style='font-size:75%' >"+myH+":"+myM+":"+myS+"</span>";
        }else{
                if(data.lid == 2){
                $("#gameCQSSC").find("p").find("i").removeClass();
                $("#gameCQSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 8){
                $("#gameXJSSC").find("p").find("i").removeClass();
                $("#gameXJSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 14){
                $("#gameTJSSC").find("p").find("i").removeClass();
                $("#gameTJSSC").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 26){
                $("#gameSD11Y").find("p").find("i").removeClass();
                $("#gameSD11Y").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 27){
                $("#gameJX115").find("p").find("i").removeClass();
                $("#gameJX115").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 24){
                $("#gameGD115").find("p").find("i").removeClass();
                $("#gameGD115").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 9){
                $("#gameJSKS").find("p").find("i").removeClass();
                $("#gameJSKS").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 30){
                $("#gameHBKS").find("p").find("i").removeClass();
                $("#gameHBKS").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 28){
                $("#gameFC3D").find("p").find("i").removeClass();
                $("#gameFC3D").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 29){
                $("#gameP3P5").find("p").find("i").removeClass();
                $("#gameP3P5").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }else if(data.lid == 6){
                $("#gamePK10").find("p").find("i").removeClass();
                $("#gamePK10").find("p").find("i").addClass("am-icon-hourglass am-margin-right-xs  text-kaijiangzhong");
            }
          var   str = "<span style='color:#ef0808;font-size:65%;'>等待开奖</span>";
                clearInterval(data.lid);
        }
        if(data.lid == 2){
            $("#gameCQSSC").find("p").find("span").html(str);
        }else if(data.lid == 8){
            $("#gameXJSSC").find("p").find("span").html(str)
        }else if(data.lid == 14){
            $("#gameTJSSC").find("p").find("span").html(str)
        }else if(data.lid == 26){
            $("#gameSD11Y").find("p").find("span").html(str)
        }else if(data.lid == 27){
            $("#gameJX115").find("p").find("span").html(str)
        }else if(data.lid == 24){
            $("#gameGD115").find("p").find("span").html(str)
        }else if(data.lid == 9){
            $("#gameJSKS").find("p").find("span").html(str)
        }else if(data.lid == 30){
            $("#gameHBKS").find("p").find("span").html(str)
        }else if(data.lid == 28){
            $("#gameFC3D").find("p").find("span").html(str)
        }else if(data.lid == 29){
            $("#gameP3P5").find("p").find("span").html(str)
        }else if(data.lid == 6){
            $("#gamePK10").find("p").find("span").html(str)
        }
    }, 100);
}
server.getDjs=function(){
    $.ajax({
                  url: ISSUE_URL,
                  cache: false,
                  success: function(data){
                   
                    server.setInter(data.issueInfo[2],data.serverTime); 
                   
                    server.setInter(data.issueInfo[8],data.serverTime);
                   
                    server.setInter(data.issueInfo[14],data.serverTime);
                   
                    server.setInter(data.issueInfo[26],data.serverTime);
                   
                    server.setInter(data.issueInfo[27],data.serverTime);
                   
                    server.setInter(data.issueInfo[24],data.serverTime);
                   
                    server.setInter(data.issueInfo[9],data.serverTime);
                   
                    server.setInter(data.issueInfo[30],data.serverTime);
                   
                     server.setInter(data.issueInfo[28],data.serverTime);
                   
                    server.setInter(data.issueInfo[29],data.serverTime);
                   
                    server.setInter(data.issueInfo[6],data.serverTime);
                  
                    //console.log(into);
                  }
        });
    
}
var dsq=null;
server.setDjs=function(){
    
    dsq = setInterval(function(){     
        $.ajax({
                  url: ISSUE_URL,
                  cache: false,
                  success: function(data){
  
                    var times=data.serverTime+1;
                    
                    server.setInter(data.issueInfo[2],times); 
                   
                    server.setInter(data.issueInfo[8],times);
        
                    server.setInter(data.issueInfo[14],times);
        
                    server.setInter(data.issueInfo[26],times);
        
                    server.setInter(data.issueInfo[27],times);
        
                    server.setInter(data.issueInfo[24],times);
                   
                    server.setInter(data.issueInfo[9],times);
        
                    server.setInter(data.issueInfo[30],times);
        
                     server.setInter(data.issueInfo[28],times);
        
                    server.setInter(data.issueInfo[29],times);
                   
                    server.setInter(data.issueInfo[6],times);
        
                    //console.log(into);
                  }
              });
     },5000);
   
}
server.getConfig = function(callback) {
          var config = {
          'games':
            [
                /*{'id': 'SSCFFC', 'lottery_id': 11, 'req': 'sscffc', 'desc': '一分钟一期', 'gc': null},*/
                {'id': 'CQSSC', 'lottery_id': 2, 'req': 'cqssc', 'desc':'' , 'gc': null},
                /*{'id': 'HLJSSC', 'lottery_id': 3, 'req': 'hljssc', 'desc': '十分钟一期', 'gc': null},*/
                {'id': 'XJSSC', 'lottery_id': 8, 'req': 'xjssc', 'desc':'' , 'gc': null},
                {'id': 'TJSSC', 'lottery_id': 14, 'req': 'tjssc', 'desc':'', 'gc': null},
                /*{'id': 'CQ115', 'lottery_id': 5, 'req': 'cq115', 'desc': '返奖率高', 'gc': null},*/
                {'id': 'SD11Y', 'lottery_id': 26, 'req': 'sd11y', 'desc': '', 'gc': null},
                {'id': 'JX115', 'lottery_id': 27, 'req': 'jx115', 'desc': '', 'gc': null},
                {'id': 'GD115', 'lottery_id': 24, 'req': 'gd115', 'desc': '', 'gc': null},
                {'id': 'JSKS', 'lottery_id': 9, 'req': 'jsks', 'desc': '', 'gc': null},
                {'id': 'HBKS', 'lottery_id': 30, 'req': 'hbks', 'desc': '', 'gc': null},
                {'id': 'FC3D', 'lottery_id': 28, 'req': 'low3D', 'desc':'', 'gc': null},
                {'id': 'P3P5', 'lottery_id': 29, 'req': 'P3P5', 'desc': '', 'gc': null},
                {'id': 'PK10', 'lottery_id': 6, 'req': 'pk10', 'desc':'', 'gc': null}
            ]
         }
       callback(config);    
}; server.getDjs();
server.getGameConfig = function(gameId, callback) {
    var game = utils.getGameById(gameId);
    //使用同步ajaxa 设置 sync: false,
    $.ajax({type: 'POST',
        beforeSend: function() {
        },
        async: false,
        url: getLotteryInfoUrl + '?lid=' + game.lottery_id,
        data: {},
        dataType: 'json',
        error: function() {
            alert("网络异常，请刷新页面");
            callback(null);
        },
        success: function(result) {
            if (result.errno) {
                alert(result.message);
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
        url: getCurIssueUrl,
        type: "POST",
        data: {
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
                result.waite_time = response.issueInfo.waite_time;
                result.state = response.issueInfo.state;
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
            {'lid': game.lottery_id},
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
            if(result == -1){
               var  primaryKey = localStorage.getItem('primaryKey');
               $.ajax({
                   type:"post",
                   url:reLoginUrl,
                   data:{primaryKey:primaryKey},
                   dataType:"json",
                   success:function (data) {
                        if(!data){
                            alert('登陆时间已经超时！');
                            delCookie();
                            $(".checkLogin").click(function (res) {
                                location.href = loginOutUrl;
                            });
                        }else{
                            console.log('登陆时间已经超时,现在已经重新连接登录！');
                        }
                   },
                   error:function (data) {
                       alert('登陆时间已经超时！');
                       delCookie();
                       $(".checkLogin").click(function (res) {
                           location.href = loginOutUrl;
                       });
                   }
               });
            }else if(result == -2){
                delCookie();
                alert('您已经在另一地方登录，已经被挤下线!');
                $(".checkLogin").click(function (res) {
                    location.href = loginResetUrl;
                });
            }
                var s = [];
                s.push({
                    id: 1,
                    aId: 1,
                    val: result.balance
                });
                localStorage.setItem('primaryKey',getCookie('primaryKey'));
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
    common.ajax(buyUrl, orderInfo,
            function(result) {
                if (result.errno == 0) {
                    var r = {
                        no: result.ordersums
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
    common.ajax(buyRecordUrl + '?day=' + data.day + '&curPage=' + data.pageNumber + '&lottery_id=' + game.lottery_id,
        {}, function(result) {
                var r = {};
                if (result) {
                    r.c = data.pageNumber + 1;
                    r.r = result;
                } else {
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
//注单详情
server.getDetail = function(data, callback) {
    var url = OrderDetailUrl+ '?wrap_id=' + data.id+'&lid='+data.lid+'&mg_id='+data.mg_id+'&trace_id='+data.trace_id+'&issue='+data.issue;
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
//追号注单详情
server.getTraceDetail = function(data,callback){
    var url = OrderTraceDetail+'?trace_id='+data.trace_id;
    common.ajax(url,{},function (result) {
        callback(result);
    },function (result) {
        utils.errorMsg(result.code, $("#traceDetail"));
    }, $("#traceDetail"));
}
server.withdraw = function(data, callback) {
    var url = cancelTraceUrl;
    common.ajax(url, data,
            function(result) {
                callback(result);
            },
            function(result) {
                utils.errorMsg(result.code, $("#traceDetail"));
            },
            $("#traceDetail")
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
    common.ajax(getTracePageUrl, {op: 'getTracePage', lid: data.lotteryId, mids: data.mids},
    function(result) {
        callback(result);
    },
    function(result) {
        utils.errorMsg(result.errstr, $("#orderConfirm"));
    },
    $("#orderConfirm")
    );
};


 