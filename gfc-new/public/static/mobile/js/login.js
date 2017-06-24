//page before show event
$("#login").on('pagebeforeshow', function () {
    //reset form
    $(".hl-login > input").val("");
});

//page show event
$("#login").on('pageshow', function () {
    //initialiaze
    login.init();
});

var login = {
    nextPage: "",
    //init
    init: function () {
        $("#loginConfirm").off("click").click(function () {
            login.login();
        });
        $("#loginCancel").off("click").click(function () {
            //move to welcome page
            $.mobile.changePage($("#cp"), {
                changeHash: true
            });
        });
    },
    //login
    login: function () {
        //show load
        $.mobile.loading('show');
        server.login({ id: $("#txtLogin").val(), password: $("#txtPassword").val() }, function (data) {
            //hide load
            $.mobile.loading('hide');
            app.login(data);
        });
    }
}