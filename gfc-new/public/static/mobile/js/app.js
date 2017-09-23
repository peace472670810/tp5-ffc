//page change event
$(document).on('pagechange', function() {
    //initialiaze
    app.init();
});

//page init event
$(document).on('pageinit', function() {
    //wire up event for common buttons
    $(".dn-refresh").off("click").click(function() {
        //trigger reload event
        var type = $(this).attr("val");
        $(document).trigger("refresh", type);
    });
    $(".logout").off("click").click(function() {
        app.logout();
    });
});

var app = {
    //init
    init: function() {
        //authentication verification
        var profile = cache.getProfile();
        if (!profile) {
            $(".logout").hide();
            //use manual set instead of show as there are issue with .show setting the display to inline instead of block
            $(".login").css('display', 'block');
        }
        else {
            $(".login").hide();
            //use manual set instead of show as there are issue with .show setting the display to inline instead of block
            $(".logout").css('display', 'block');
        }
        $("#news").vTicker({speed: 500, pause: 3E3, animation: "fade", mousePause: true, showItems: 1});
    },
    login: function(data) {
        if (!isEmpty(data)) {
            cache.setProfile(data);
            server.getConfig(function(data) {
                if (data != null) {
                    //cache config
                    cache.setData(data);
                }
            });
            $.mobile.changePage($("#cp"), {
                changeHash: true
            });
        }
        else {
            //login.refreshCaptcha();
        }
    },
    logout: function() {
        $.mobile.loading('hide');
        $.mobile.loading('show');
        server.logout(function(data) {
            //hide load
            $.mobile.loading('hide');
            cache.setProfile(null);
            //move to welcome page
            $.mobile.changePage($("#login"), {
                changeHash: true
            });
        });

    }
    ,
    checkLoginOrUrl: function(code) {
        if (LOGOUT == code) {
            app.logout();
            return true;
        }
        
        return false;
        
    }
}
