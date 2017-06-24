//page before change event
$(document).on('pagebeforechange', function (e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),re = /^#accountWithdraw/;
        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#accountWithdraw";
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#accountWithdraw").on('pagebeforeshow', function () {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#accountWithdrawMessage, #accountWithdrawBalance").text("");
        $("#txtWithdrawAmount, #txtAccountPassword").val("");
        $("#accountWithdrawFrom").empty();
        $(".hl-account-withdraw-container").hide();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountWithdraw").on('pageshow', function () {
    //initialiaze
    accountWithdraw.init();
});

//page init event
$('#accountWithdraw').on('pageinit', function (event) {
    $("#accountWithdrawLink").off("click").click(function () {
        accountWithdraw.withdraw();
    });
});

//page show event
$("#accountWithdraw").on('pageshow', function () {
    //initialiaze
    accountWithdraw.init();
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "accountWithdraw") {
        accountWithdraw.search(true);
    }
});

var accountWithdraw = {
    //init
    init: function () {
        //clear content
        $("#accountWithdrawMessage, #accountWithdrawBalance").text("");
        $("#txtWithdrawAmount, #txtAccountPassword").val("");
        $("#accountWithdrawFrom").empty();
        accountWithdraw.search(false);
    },

    //search
    search: function (showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }
        var profile = cache.getProfile();
        server.getAccountWithdraw(profile, function (data) {
            //hide load
            $.mobile.loading('hide');
            if (data != null) {
                //render
                accountWithdraw.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },

    //render
    render: function (data) {
        var s = [];
        s.push('<option value="">&nbsp;</option>');
        if (data.a.length > 0) {
            $.each(data.a, function (index) {
                s.push('<option value="');
                s.push(this.id);
                s.push('">');
                s.push(this.val);
                s.push('</option>');
            });
        }
        $("#accountWithdrawMessage").html(label.withdrawMessage.replace("{0}", data.mw).replace("{1}", data.cw));
        $("#accountWithdrawBalance").text(utils.cny(data.b, 2));
        //dropdown
        $("#accountWithdrawFrom").empty().html(s.join(""));
        $("#accountWithdrawFrom").selectmenu("refresh", true);
        $("#txtWithdrawAmount").val("");
        $("#txtAccountPassword").val("");
        $(".hl-account-withdraw-container").show();
    },
    //withdraw
    withdraw: function () {
        var detail = {};
        detail.amount = $("#txtWithdrawAmount").val();
        detail.account = $("#accountWithdrawFrom").val();
        detail.password = $("#txtAccountPassword").val();
        //show load
        $.mobile.loading('show');
        server.accountWithdraw(detail, function (data) {
            //hide load
            $.mobile.loading('hide');
            utils.prompt(label.withdrawCashSuccess, $("#accountWithdraw"),
                function () {
                    accountWithdraw.search(false);
                });
        });
    }
}