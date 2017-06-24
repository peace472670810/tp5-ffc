var KEY_UP = 38, KEY_DOWN = 40, KEY_ENTER = 13;
var KEY_A = 65, KEY_Z = 90, KEY_0 = 48, KEY_9 = 57;
var KEY_NUMPAD_0 = 96, KEY_NUMPAD_9 = 105;
var timeout = 3000;
var lastBalance;
var amsrefreshTimer;
var loginCount = 0;
var retryCount = 3;
var isReceived = false;
var sslTimer;

String.prototype.startWith = function(str) {
    return (this.match("^" + str) == str)
}
String.prototype.trim = function() {
    return (this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, ""))
}
String.prototype.endWith = function(str) {
    return (this.match(str + "$") == str)
}

Date.prototype.parseUTCDateToLocalDate = function(date) {
    if (!(date instanceof Date)) {
        date = new Date(date);
    }
    return new Date(date.getTime() - (getTimeZoneOffset() * 60 * 1000));
}
Date.prototype.getTimeZoneOffset = function() {
    if (global.timeZoneOffset) {
        return global.timeZone;
    }
    return ((new Date).getTimezoneOffset());
}
Date.prototype.gettimeZone = function() {
    if (global && global.timeZone) {
        return global.timeZone;
    }
    return ((new Date).gettimeZone());
}
Date.prototype.getLocalDateTime = function(serverDate) {
    if (!(serverDate instanceof Date)) {
        serverDate = new serverDate(serverDate);
    }
    return new Date(serverDate.getTime() - ((gettimeZone() - 4) * 60 * 60 * 1000));
}
Date.prototype.format = function(format) {
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
Date.prototype.toDateString = function() {
    return this.format("yyyy/MM/dd");
}
Date.prototype.toDateTimeString = function() {
    return this.format("yyyy/MM/dd hh:mm:ss")
}
/*
 extend jQuery.cookie
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
//jquery - jsonp
(function(e, b) {
    function d() {
    }
    function t(C) {
        c = [C]
    }
    function m(C) {
        f.insertBefore(C, f.firstChild)
    }
    function l(E, C, D) {
        return E && E.apply(C.context || C, D)
    }
    function k(C) {
        return /\?/.test(C) ? "&" : "?"
    }
    var n = "async", s = "charset", q = "", A = "error", r = "_jqjsp", w = "on", o = w + "click", p = w + A, a = w + "load", i = w + "readystatechange", z = "removeChild", g = "<script/>", v = "success", y = "timeout", x = e.browser, f = e("head")[0] || document.documentElement, u = {}, j = 0, c, h = {callback: r, url: location.href};
    function B(C) {
        C = e.extend({}, h, C);
        var Q = C.complete, E = C.dataFilter, M = C.callbackParameter, R = C.callback, G = C.cache, J = C.pageCache, I = C.charset, D = C.url, L = C.data, P = C.timeout, O, K = 0, H = d;
        C.abort = function() {
            !K++ && H()
        };
        if (l(C.beforeSend, C, [C]) === false || K) {
            return C
        }
        D = D || q;
        L = L ? ((typeof L) == "string" ? L : e.param(L, C.traditional)) : q;
        D += L ? (k(D) + L) : q;
        M && (D += k(D) + encodeURIComponent(M) + "=?");
        !G && !J && (D += k(D) + "_" + (new Date()).getTime() + "=");
        D = D.replace(/=\?(&|$)/, "=" + R + "$1");
        function N(S) {
            !K++ && b(function() {
                H();
                J && (u[D] = {s: [S]});
                E && (S = E.apply(C, [S]));
                l(C.success, C, [S, v]);
                l(Q, C, [C, v])
            }, 0)
        }
        function F(S) {
            !K++ && b(function() {
                H();
                J && S != y && (u[D] = S);
                l(C.error, C, [C, S]);
                l(Q, C, [C, S])
            }, 0)
        }
        J && (O = u[D]) ? (O.s ? N(O.s[0]) : F(O)) : b(function(T, S, U) {
            if (!K) {
                U = P > 0 && b(function() {
                    F(y)
                }, P);
                H = function() {
                    U && clearTimeout(U);
                    T[i] = T[o] = T[a] = T[p] = null;
                    f[z](T);
                    S && f[z](S)
                };
                window[R] = t;
                T = e(g)[0];
                T.id = r + j++;
                if (I) {
                    T[s] = I
                }
                function V(W) {
                    (T[o] || d)();
                    W = c;
                    c = undefined;
                    W ? N(W[0]) : F(A)
                }
                if (x.msie) {
                    T.event = o;
                    T.htmlFor = T.id;
                    T[i] = function() {
                        /loaded|complete/.test(T.readyState) && V()
                    }
                } else {
                    T[p] = T[a] = V;
                    x.opera ? ((S = e(g)[0]).text = "jQuery('#" + T.id + "')[0]." + p + "()") : T[n] = n
                }
                T.src = D;
                m(T);
                S && m(S)
            }
        }, 0);
        return C
    }
    B.setup = function(C) {
        e.extend(h, C)
    };
    e.jsonp = B
})(jQuery, setTimeout);
/*
 Utilities
 */
var utility = {
    securetimeout: 10000,
    templateCache: new Object()
    , stopRequest: false
    , $error: null
    , $lostConn: null
    , showError: function(message) {
        // utility.stopRequest = true;
        if (utility.$error == null) {
            utility.$error = $("<a href='javascript:void(0)' id='errMsg'>" + (new Date()) + ":Error Occur:Please refresh page</a>").click(function() {
                window.location.href = window.location.href;
            });
            window.status = new Date();
            //            $('body').append(utility.$error);
        }
        //        utility.$error.attr("title", message);
        //        alert(message);
    }
    , showLoading: function(show) {
        if (show) {
            $("#loading").remove();
            $('<div id="loading" class="loading maskwrapper" />').appendTo($('body'));
        } else {
            $("#loading").remove();
        }
    }
    , showLostConn: function(url) {
        // GAS-635: fixed 'idle' issues
        // this method will be no longer used
        utility.stopRequest = true;
        if (utility.$lostConn == null) {
            utility.$lostConn = $("<a href='javascript:void(0)' id='errLostConnMsg'>" + (new Date()) + ":Lost connection,Please refresh page</a>").click(function() {
                window.location.href = window.location.href;
            });
            window.status = new Date();
            //            $('body').append(utility.$lostConn);
        }
        //        utility.$lostConn.attr("title", url);
        //        alert(message);
        //        if ($('body').hasClass("login")) {
        //            window.location.href = window.location.href;
        //        }
    }
    , template: function(templateUrl, callBack, key) {
        var templateObj;
        if (key) {
            templateObj = this.templateCache[key];
            if (templateObj) {
                callBack(templateObj);
                return;
            }
        }
        var fileUrl = global.root + "../Public/Templates/" + templateUrl + "?v=" + global.rv;
        if (utility.stopRequest) {
            return;
        }
        $.ajax({
            url: fileUrl
            , cache: true
            , type: "GET"
            , success: function(response) {
                templateObj = TrimPath.parseTemplate(response);
                response = null;
                utility.templateCache[key] = templateObj;
                callBack(templateObj);
            }
            , error: function(response) {
                // GAS-635: template no need to handle everything.
                //                if (response.statusText) {
                //                    utility.showError("Server Error\r\n  URL:  " + fileUrl + "\r\n  " + response.statusText);
                //                }
                //                else {
                //                    if (($.browser.mozilla || $.browser.safari || navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
                //                        && response.status == 0 && response.responseText == "") {
                //                        // Request Aborted - Chrome & Firefox - Safari - Do nothing
                //                    } else {
                //                        utility.showError("Server Error\r\n  URL:  " + fileUrl + "\r\n  Detail:  " + response);
                //                    }
                //                }
                //                response = null;
            }
        });
    }
    , getValueFromUrl: function(name) {
        if (window.location.search) {
            var querys = [];
            var nameLowerCase = name.toLowerCase();
            $.each(window.location.search.substring(1).split('&'), function() {
                $.each(this.split('='), function() {
                    querys.push(this);
                })
            });
            for (var i = 0; i < querys.length; i += 2) {
                if (querys[i].toLowerCase() == nameLowerCase) {
                    return querys[i + 1];
                }
            }
        }
        return null;
    }, getQueryFromUrl: function(url, exclusion) {
        var querys = [];
        if (url === undefined)
            url = window.location.search;
        var urlTokens = url.split("?");
        if (urlTokens.length >= 2) {
            var queryTokens = urlTokens[1].split("&");
            for (var i = 0; i < queryTokens.length; i++) {
                var pair = queryTokens[i].split("=");
                if (pair[0].toLowerCase() !== exclusion.toLowerCase()) {
                    querys.push(queryTokens[i]);
                }
            }
            return querys.join("&");
        }
    },
    service: function(serviceName, methodName, parameter, httpMethod, callBack, errorCallback, excludeLanguage) {
        if (utility.stopRequest) {
            return;
        }
        var postData = this.objToPostString(parameter);
        var serviceUrl = global.root + "Service/" + serviceName + "?" + methodName;
        if (httpMethod.toUpperCase() == "POST") {
            serviceUrl += "&_ts=" + new Date().getTime();
        }
        //if ($.mobile) $.mobile.loading('show');
        //utility.showLoading(true);
        $.ajax({url: serviceUrl, cache: false, data: postData, type: httpMethod,
            success: function(response) {
                utility.succeededAction(response, callBack, excludeLanguage);
                //if ($.mobile) $.mobile.loading('hide');
                //utility.showLoading(false);
            },
            error: function(request) {
                utility.failedAction(request, errorCallback);
                if ($.mobile)
                    $.mobile.loading('hide');
                //utility.showLoading(false);
            }
        });
    },
    secureservice: function(serviceName, methodName, parameter, httpMethod, callBack, errorCallback, excludeLanguage) {
        if (utility.stopRequest) {
            return;
        }
        var postData = this.objToPostString(parameter);
        var serviceUrl = uv.sec + "Service/" + serviceName + "?" + methodName + "G";

        isReceived = false;
        utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: methodName, Message: "sent request to SSL server. "}, "POST");
        sslTimer = new Date().getTime();
        $.jsonp({
            url: serviceUrl,
            data: postData,
            callback: callBack,
            timeout: utility.securetimeout,
            success: function(json) {
                utility.succeededAction(response, callBack, excludeLanguage);
            },
            error: function(d, msg) {
                if (!isReceived) {
                    isReceived = true;
                    utility.service(serviceName, methodName, parameter, httpMethod, callBack, errorCallback, excludeLanguage);
                    sslTimer = new Date().getTime() - sslTimer;
                    utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: ("SSLTimeOut_" + methodName + "(cost " + sslTimer + "ms)")}, "POST");
                }
            }
        });
    },
    succeededJsonp: function(data) {
        try {
            if (isReceived) {
                utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: "Login", Message: "Received Data Info after Timeout!", ServerCode: data.srvc}, "POST");
                isReceived = false;
                return;
            }
            isReceived = true;
            if (data != "") {
                if (data.lostConn) {
                    utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: "Login", Message: "lostConnect", ServerCode: data.srvc}, "POST");
                    window.location.href = window.location.href;
                }
                else if (data.isAuth == false) {
                    var $parent = window.parent ? window.parent : window.opener;
                    if ($parent && $parent != window)
                        $parent.location.reload();
                    if (data.u && data.u != '')
                        document.location.href = data.u;
                    else
                        document.location.reload();
                }
                else {
                    if (data.u) {
                        loginCount = 0;
                        if (data.DCheck && data.DCheck == true) {
                            Control.Dialog.showMessage(l.header_Help, data.dMsg, function() {
                                window.location.href = data.u;
                            });
                            setTimeout(function() {
                                window.location.href = data.u;
                            }, 10000);
                        }
                        else
                            window.location.href = data.u;
                        return;
                    }
                    if (data.suc) {
                        loginCount = 0;
                        //Should reload when loggin successfully.
                        //To Reload Oddpage with user OddType and TimeZone
                        document.location.reload();
                    }
                    else {
                        utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: "Login", Message: (data.m ? data.m : data.error), ServerCode: data.srvc}, "POST");
                        if ($("#txtName").val() == "") {
                            $("#txtNameMask").focus();
                        }
                        $("#txtPass").val("");
                        $("#txtPassMask").focus();
                        HomeJS.ajaxLoading(false);
                        if (data.sc || loginCount > retryCount) {
                            utility.popupUrl("/" + global.lan + "/user/fail-login", "cpt-login", 500, 164);
                        }
                        else if (data.scp) {
                            utility.popupUrl("/" + global.lan + "/user/change-password?ud=" + $.trim(Base64.encode($("#txtName").val())), "changePassword", 395, 190);
                        }
                        else {
                            HomeJS.ajaxLoading(false);
                            Control.Dialog.showAlert(l.Dlg_Login, data.m ? data.m : data.error, function() {
                                if ($("#txtName").val() == "")
                                    $("#txtNameMask").focus();
                                else
                                    $("#txtPassMask").focus();
                            });
                        }
                    }
                }
            }
        }
        catch (e) {
            utility.showError("parse error: " + response);
        }
    },
    succeededCP: function(data) {
        try {
            if (isReceived) {
                utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: "changePassword", Message: "Received Data Info after Timeout!", ServerCode: data.srvc}, "POST");
                //                isReceived = false;
                //                return;
            }
            isReceived = true;
            if (data != "") {
                $(".r-window").loadingMask("hide");
                if (data.m == "true") {
                    utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: "changePassword", Message: "success", ServerCode: data.srvc}, "POST");
                    hideMsg();
                    var isForce = window.location.search.indexOf("logout=false") < 0
                    var strMsg = chpSuccess;
                    if (isForce)
                        strMsg = spanSuccessful;

                    Control.Dialog.showMessage(changePasswordtxt, strMsg, function() {
                        if (isForce)
                            Logout();
                        else
                            $("#btnClose").trigger("click");
                    });

                    if (isForce) {
                        setTimeout("Logout()", 5000);
                    }
                }
                else {
                    //Control.Dialog.showMessage(changePasswordtxt, data.m, function() {  });
                    utility.service("UserService", "SetSecureLog", {MemberCode: $("#txtName").val(), MethodName: "changePassword", Message: (data.m ? data.m : data.error), ServerCode: data.srvc}, "POST");
                    if (data.m) {
                        showMsg(data.m);
                    }
                    else if (data.error) {
                        showMsg(data.error);
                    }
                }
                ;
            }
        }
        catch (e) {
            utility.showError("parse error: " + response);
        }
    },
    succeededAction: function(response, callBack, excludeLanguage) {
        var data, parsed = false;
        try {
            if (response != "") {
                eval("data =" + response);
                if (!excludeLanguage && window.l) {
                    data.$l = window.l;
                }
                parsed = true;
            }
            else {
                parsed = false;
            }
        }
        catch (e) {
            utility.showError("parse error: " + response);
        }
        if (parsed && data) {
            if (data.syserror) {
                //only 'DEBUG' mode will have this message
                //utility.showError(data.syserror);
            }
            else if (data.lostConn) {
                //utility.showLostConn(serviceUrl);
                window.location.href = window.location.href;
            }
            else if (data.isAuth == false) {
                var $parent = window.parent ? window.parent : window.opener;
                if ($parent && $parent != window)
                    $parent.location.reload();
                if (data.u && data.u != '')
                    document.location.href = '/';
                else
                    document.location.reload();
            }
            else {
                if (callBack)
                    callBack(data);
            }
        }
        data = null;
        response = null;
    },
    failedAction: function(request, errorCallback) {
        //404 stop, other error do nothing
        if (request.status == 404) {
            utility.stopRequest = true;
            window.status = new Date();
        }
        //          if (response.statusText) {
        //              utility.showError("Server Error 3\r\n  URL:  " + serviceUrl + "\r\n  Par:  " + postData + "\r\n  Detail:  " + response.statusText);
        //          }
        //          else {
        //              if (($.browser.mozilla || $.browser.safari || navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
        //                  && response.status == 0 && response.responseText == "") {
        //                  // Request Aborted - Chrome & Firefox - Safari - Do nothing
        //              }
        //              else {
        //                  utility.showError("Server Error 2\r\n  URL:  " + serviceUrl + "\r\n  Par:  " + postData + "\r\n  Detail:  " + response);
        //              }
        //          }
        if (errorCallback)
            errorCallback();
        request = null;
    },
    objToPostString: function(obj, preFix) {
        if (!preFix) {
            preFix = "";
        }
        var builder = [];
        for (var name in obj) {
            if (obj[name] == undefined || obj[name] == null) {
            }
            else if (obj[name] instanceof Array) {
                var arr = obj[name];
                for (var i = 0; i < arr.length; i++) {
                    builder.push(preFix + name + "=" + arr[i]);
                }
            }
            else if (typeof (obj[name]) == "object") {
                builder.push(this.objToPostString(obj[name], name + "."));
            }
            else {
                builder.push(preFix + name + "=" + encodeURIComponent(obj[name]));
            }
        }
        return builder.join("&");
    },
    isCookieEnabled: function() {
        var cookieEnabled = ((navigator.cookieEnabled) ? true : false);
        return cookieEnabled;
    },
    cookie: {
        write: function(c_name, value, expiredays) {
            if (!expiredays) {
                expiredays = 7;
            }
            $.cookie(c_name, value, {expires: expiredays, path: '/'});
        },
        read: function(c_name) {
            return $.cookie(c_name);
        },
        erase: function(c_name) {
            $.cookie(c_name, null);
        }
    }
    , dialogIndex: 0
    , popupUrl: function(url, id, w, h, scrolling, closeOnEsc, onClosed) {
        if (!url || url.indexOf('javascript:void') >= 0) {
            return false;
        }
        if (!w || w == -1) {
            w = 800;
        }
        if (!h || h == -1) {
            h = 550;
        }
        if (!scrolling) {
            scrolling = "no";
        }
        if (id) {
            var iframe = $("#" + id);
            if (iframe.length > 0) {
                // this dialog already existed
                var dlg = iframe.parent().dialog('destroy');
                dlg.remove();
            }
        } else {
            id = "dialog" + (utility.dialogIndex++);
        }

        $("<div/>").dialog({autoOpen: false, modal: true, height: h, width: w, closeOnEscape: (closeOnEsc == null ? true : closeOnEsc), resizable: false,
            close: function(event, ui) {
                if (onClosed && $.isFunction(onClosed))
                    onClosed(event, ui);
            }
        }
        ).html('<iframe id="' + id + '" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="' + scrolling + '" />').dialog("open");
        $("#" + id).attr("src", url);
    }
    , haveClass: function(array, className) {
        for (var i = 0; i < array.length; i++) {
            if (!$(array[i]).hasClass(className)) {
                return false;
            }
        }
        return true;
    }
    , remove: function(array, removeObj) {
        var arr = [];
        while (true) {
            var value = array.pop()
            if (value == null) {
                return arr;
            }
            else if (removeObj != value) {
                arr.push(value);
            }
        }
    }
    , parseToSizeInfo: function(css) {
        var classvalues = css.split(' ');
        var id, w = -1, h = -1, s;
        for (var i = 0; i < classvalues.length; i++) {
            switch (String(classvalues[i]).toLowerCase().charAt(0)) {
                case "w":
                    w = parseInt(String(classvalues[i]).substr(1));
                    break;
                case "h":
                    h = parseInt(String(classvalues[i]).substr(1));
                    break;
                case "i":
                    id = String(classvalues[i]).substr(1);
                    break;
                case "s":
                    s = String(classvalues[i]).substr(1);
                    break;
                case "r":
                    r = String(classvalues[i]).substr(1);
                    break; // values in "yes" or "no"
            }
        }
        if (typeof (s) == 'undefined' || s.toLowerCase() != "no")
            s = 'yes';
        if (typeof (r) == 'undefined' || r.toLowerCase() != "yes")
            r = 'no';
        if (isNaN(w) || isNaN(h)) {
            Control.Dialog.showAlert(global.tLogin, "Error:" + css, function() {
            });
        }
        return {'id': id, 'width': w, 'height': h, 'scroll': s, resizable: r};
    }
    , disableLinks: function(selector) {
        $(selector).fadeTo(2000, .3).addClass("disabled_link").removeAttr("href").unbind("click");
    },
    popupUrlWin: function(url, info, name) {
        var x = 0, y = 0, w = 800, h = 600; // default value: width=800, height=600
        if (info.width != -1)
            w = info.width;
        if (info.height != -1)
            h = info.height;
        x = (screen.width - w) / 2;
        y = (screen.height - h) / 2;
        var features = "resizable=" + info.resizable + ", scrollbars=" + info.scroll + ", left=" + x + ", top=" + y + ", width=" + w + ", height=" + h;

        var win = window.open(url, name, features);
        win.focus();

    }, popupNewWin: function(event, obj, name) {
        var info = utility.parseToSizeInfo(obj.className);

        // just give examples: Main -> popup profile -> if the user click on What's this.. should popup
        // what if popup the same windows ? Hence, if (!name) { name = "188BET"; }
        if (name == "_blank") {
            name = "188BET";
        }

        // to prevent multiple same popup window. only 1 popup window is allowed
        if (!name) {
            name = "188BET";
        }

        if (info && info.id) {
            name = info.id;
        }

        utility.popupUrlWin(obj.href, info, name);

        event.stopPropagation();
        event.preventDefault();
    }
    , ttip: function(name) {
        $(name).tt({showEvent: 'mouseover',
            hideEvent: 'mouseout',
            vAlign: "above",
            align: "flushLeft",
            ttClass: 'tooltip',
            distanceX: 0,
            distanceY: 0,
            visibleOnScroll: true
        });
    }
    //to disable the auto hide in statement pages
    , ttip_st: function(name) {
        $(name).tt({showEvent: 'mouseover',
            hideEvent: 'mouseout',
            vAlign: "above",
            align: "flushLeft",
            ttClass: 'tooltip',
            distanceX: 0,
            distanceY: 0,
            visibleOnScroll: true,
            autoHide: false
        });
    }
    , checkRefresh: function() {
        if (uv && uv.login) {
            utility.service("HomePageService", "NeedRefresh", {}, "GET",
                    function(data) {
                        if (data && data.ref) {
                            HomeJS.logout_ACM();
                            if (data.u && data.u != "" && HomeJS) {
                                document.location.href = data.u;
                            }
                            else {
                                document.location.reload();
                            }
                        }
                    }
            );
        }
    },
    cancelEvent: function(e) {
        e = e ? e : window.event;
        if (e.stopPropagation)
            e.stopPropagation();
        if (e.preventDefault)
            e.preventDefault();
        e.cancelBubble = true;
        e.cancel = true;
        e.returnValue = false;
        return false;
    }
};
 

