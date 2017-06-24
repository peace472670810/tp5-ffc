//mobile init event
$(document).on("mobileinit", function () {
    app.login(data);
    $.mobile.defaultPageTransition = "none";
    $.mobile.page.prototype.options.domCache = true;
    $.mobile.buttonMarkup.hoverDelay = 10;
});


