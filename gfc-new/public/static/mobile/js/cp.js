//page show event
$("#cp").on('pageshow', function () {
    //initialiaze
    cp.init();
});

//refresh event
$(document).on('refresh', function (event, data) {
    if (data == "cp") {
        cp.updateDrawNumber(true);
    }
});

var cp = {
    //init
    init: function () {
        //reset user game related cache
        cache.resetGame();

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
                    cp.render(data);
                }
            });
        }
        else {
            cp.render(data);
        }
    },

    //render
    render: function (data) {
        var games = data.games,
            g = [],
            gameLabel = "";

        if (games.length > 0) {
            $.each(games, function (index) {
                gameLabel = utils.getGameLabel(this.id);
                g.push('<li><a href="#orderSelect?g=');
                g.push(this.id);
                g.push('" id="game');
                g.push(this.id);
                g.push('" title="');
                g.push(gameLabel);
                g.push('"><img src="css/images/thumb-');
                g.push(this.id);
                g.push('.png" class="hl-thumbnail" /><h3>');
                g.push(gameLabel);
                g.push('</h3><p>&nbsp;</p></a></li>');
            });
        }
        else {
            g.push('<li>');
            g.push(label.noRecord);
            g.push('</li>');
        }

        $("#gameList").html(g.join("")).listview('refresh', true);

        //update draw number
        cp.updateDrawNumber(false);
    },

    //update draw number
    updateDrawNumber: function (showProgress) {
        return ;//目前先不实现
        var data = cache.getData();

        if (data != null) {
            if (showProgress) {
                $(".dn-refresh").hide();
                $(".dn-progress").show();
            }

            var games = [];
            $.each(data.games, function () {
                games.push(this.id);
            });

            server.getDrawNumber(games, function (data) {
                if (data != null) {
                    //update draw number
                    $.each(data, function () {
                        $("#game" + this.id + " > p").text(label.drawNumber.replace("{0}", this.val));
                    });
                }

                if (showProgress) {
                    $(".dn-progress").hide();
                    $(".dn-refresh").show();
                }
            });
        } else {
            //avoid infinite loop by only re-init when show progress is true
            if (showProgress) {
                cp.init();
            }
        }
    }
}