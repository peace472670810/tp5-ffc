//page before change event
$(document).on('pagebeforechange', function (e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
			re = /^#accountSummary/;

        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();

            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#accountSummary";
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#accountSummary").on('pagebeforeshow', function () {
    var profile = cache.getProfile();

    if (profile != null && profile.id.length > 0) {
        //clear
        $("#accountList").empty();
        $(".hl-account-summary-container").hide();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountSummary").on('pageshow', function () {
    //initialiaze
    accountSummary.init();
});

//page init event
$('#accountSummary').on('pageinit', function (event) {
 
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "accountSummary") {
        accountSummary.search(true);
    }
});

var accountSummary = {
    //init
    init: function () {
        //clear content
        $("#accountList").empty();
        accountSummary.search(false);
    },

    //search
    search: function(showProgress){
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }

        var profile = cache.getProfile();

        server.getAccount(profile, function (data) {
            if (data != null) {
                //render
                accountSummary.render(data);
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
        var a = [],
            s = [],
            accountLabel = "";

        //list
        s.push('<option value="">&nbsp;</option>');

        if (data.length > 0) {
            $.each(data, function (index) {
                accountLabel = utils.getAccountLabel(this.id);
                a.push('<li><div class="hl-account-type">');
                a.push(accountLabel);
                a.push('</div><div class="hl-account-bal" id="acct_' + this.aId + '">');
                a.push(utils.cny(this.val, 2));
                a.push('</div></li>');

                s.push('<option value="');
                s.push(this.aId);
                s.push('">');
                s.push(accountLabel);
                s.push('</option>');
            });
        }
        else {
            a.push('<li>');
            a.push(label.noRecord);
            a.push('</li>');
        }

        $("#accountList").empty().html(a.join("")).listview('refresh');
        $(".hl-account-summary-container").show();
        
    }

 
}