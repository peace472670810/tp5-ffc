//page before show event
$("#draw").on('pagebeforeshow', function () {
    //clear
    $("#drawList").empty();
});

//page show event
$("#draw").on('pageshow', function () {
    //initialiaze
    draw.init();
});

//page init event
$('#draw').on('pageinit', function (event) {
    $("#drawGameList").change(function (event, ui) {
        draw.search(false);
    });
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "draw") {
        draw.search(true);
    }
});

var draw = {
    //init
    init: function () {
        //clear content
        $("#drawList").empty();

        var data = cache.getData();

        if (data == null) {
            //show load
            $.mobile.loading('show');

            server.getConfig(function (data) {
                //hide load
                $.mobile.loading('hide');

                if (data != null) {
                    //cache config
                    cache.setData(data);

                    //render
                    draw.render();
                }
            });
        }
        else {
            draw.render();
        }
    },

    //render
    render: function () {
        var data = cache.getData(),
            gameId = "",
            drawGameList = $("#drawGameList");

        if (data != null) {
            if (drawGameList.html().length > 0) {
                draw.search(false);
            }
            else {
                var g = [],
                    gameLabel = "";

                $.each(data.games, function () {
                    gameLabel = utils.getGameLabel(this.id);

                    //set game code
                    if (gameId.length == 0) {
                        gameId = this.id;
                    }

                    g.push('<option value="');
                    g.push(this.id);
                    g.push('">');
                    g.push(gameLabel);
                    g.push('</option>');
                });

                drawGameList.empty().html(g.join(""));

                //reset dropdown
                drawGameList[0].selectedIndex = 0;
                drawGameList.selectmenu("refresh", true);

                if (gameId.length > 0) {
                    draw.search(false);
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

        var gameId = $("#drawGameList").val();
        
        server.getDrawResult(gameId, function (data) {
            if (data != null) {
                var r = [] ;
                 gameLabel = "";
                if (data.length > 0) {
                    $.each(data, function (index) {
                        r.push('<li>');
                        r.push(label.drawNumber.replace("{0}", this.id));
//                        r.push('<span class="hl-spacer"></span>');
//                        r.push(this.date);
                        r.push('<br/><span class="hl-draw">');
                        r.push(this.val);
                        r.push('</span></li>');
                    });
                }
                else {
                    r.push('<li>');
                    r.push(label.noRecord);
                    r.push('</li>');
                }

                $("#drawList").html(r.join("")).listview('refresh');
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
    }
}