//page before change event
$(document).on('pagebeforechange', function (e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
			re = /^#accountInquiry/;

        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#accountInquiry";

                e.preventDefault();

                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#accountInquiry").on('pagebeforeshow', function () {
    var profile = cache.getProfile();

    if (profile != null && profile.id.length > 0) {
        //reset page number
        accountInquiry.pageNumber = 1;
        $(".hl-account-inquiry-title-container, #accountMoreContainer").hide();

        //clear
        $("#accountInquiryList").empty();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountInquiry").on('pageshow', function () {
    //initialiaze
    accountInquiry.init();
});

//page init event
$('#accountInquiry').on('pageinit', function (event) {
    $("#searchAccountList").change(function (event, ui) {
        //reset page number
        accountInquiry.pageNumber = 1;
        $(".hl-account-inquiry-title-container, #accountMoreContainer").hide();

        //clear
        $("#accountInquiryList").empty();

        accountInquiry.search(false);
    });

    $("#accountMoreLink").off("click").click(function () {
        //increase page number
        accountInquiry.pageNumber++;
        accountInquiry.search(false);
    });
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "accountInquiry") {
        //reset page number
        accountInquiry.pageNumber = 1;

        accountInquiry.search(true);
    }
});

var accountInquiry = {
    pageNumber: 1,

    //init
    init: function () {
        //clear
        $("#accountInquiryList").empty();
        accountInquiry.render();
    },

    //render
    render: function () {
        var data = cache.getProfile(),
            accountId = "",
            searchAccountList = $("#searchAccountList");

        if (data != null) {
            if (searchAccountList.html().length > 0) {
                accountInquiry.search(false);
            }
            else {
                var a = [],
                    accountLabel = "";

                $.each(data.a, function () {
                    accountLabel = utils.getAccountLabel(this.id);
                    if (accountLabel == null || accountLabel == '') {
                        return;
                    }
                    //set account id
                    if (accountId.length == 0) {
                        accountId = this.id;
                    }

                    a.push('<option value="');
                    a.push(this.id);
                    a.push('">');
                    a.push(accountLabel);
                    a.push('</option>');
                });

                searchAccountList.empty().html(a.join(""));

                //reset dropdown
                searchAccountList[0].selectedIndex = 0;
                searchAccountList.selectmenu("refresh", true);

                if (accountId.toString().length > 0) {
                    accountInquiry.search(false);
                }
            }
        }
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

        var item = {};
        item.id = $("#searchAccountList").val();
        item.pageNumber = accountInquiry.pageNumber;
        item.pageSize = setting.search.pageSize;

        server.getAccountActivity(item, function (data) {
            if (data != null) {
                var s = [];
                if (data.r.length > 0) {
                    $.each(data.r, function (index) {
                        
                        s.push('<li><div class="hl-account-inquiry"><div class="hl-account-inquiry-date">');
                        s.push(this.create_time);
                        s.push('</div><div class="hl-account-inquiry-txn ');
                        
                        if (this.amount >= 0) {
                            s.push('hl-account-inquiry-txn-in');
                        }
                        else {
                            s.push('hl-account-inquiry-txn-out');
                        }

                        s.push('">');
                        s.push(utils.digits(this.amount, 2));
                        s.push('</div><div class="hl-account-inquiry-bal">');
                        s.push(utils.digits(this.balance, 2));
                        s.push('</div><div class="hl-account-inquiry-type">');
                        s.push(this.type);
                        s.push('</div></div></li>');
                    });
                }
                else {
                    s.push('<li>');
                    s.push(label.noRecord);
                    s.push('</div></li>');
                }

                if (showProgress) {
                    $("#accountInquiryList").html(s.join("")).listview('refresh');
                }
                else {
                    $("#accountInquiryList").append(s.join("")).listview('refresh');
                }

                //show title
                $(".hl-account-inquiry-title-container").show();

                //show or hide more button
                if (data.r.length > 0 && data.c >accountInquiry.pageNumber) {
                    $("#accountMoreContainer").show();
                }
                else {
                    $("#accountMoreContainer").hide();
                }

                if (showProgress) {
                    $(".dn-progress").hide();
                    $(".dn-refresh").show();
                }
                else {
                    //hide load
                    $.mobile.loading('hide');
                }
            }
        });
    }
}