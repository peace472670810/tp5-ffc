//page before change event
$(document).on('pagebeforechange', function (e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
			re = /^#member/;

        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();

            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#member";

                e.preventDefault();

                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#member").on('pagebeforeshow', function () {
    var profile = cache.getProfile();

    if (profile != null && profile.id.length > 0) {
        //clear
        $("#memberList").empty();
    }
    else {        
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#member").on('pageshow', function () {
    //initialiaze
    member.init();
});

var member = {
    //init
    init: function () {
        member.render();
    },

    //render
    render: function () {
        var m = [];

        m.push('<li><a href="#accountSummary"><img src="css/images/ico-gold.png" /><h3>');
        m.push(label.account);
        //m.push('</h3><p>&nbsp;</p></a></li><li><a href="#accountWithdraw"><img src="css/images/ico-gold.png" /><h3>');
        //m.push(label.withdraw);
        m.push('</h3><p>&nbsp;</p></a></li><li><a href="#accountInquiry"><img src="css/images/ico-gold.png" /><h3>');
        m.push(label.inquiry);
        m.push('</h3><p>&nbsp;</p></a></li>');

        $("#memberList").html(m.join("")).listview('refresh', true);
    }
}