utils.serializeOrders = function (orders) {
    var map = {};
    for (var i = 0; i < orders.length; i++) {
        var gameCode = orders[i].code;
        if (gameCode.length == 1) {
            gameCode = '0' + gameCode;
        }
        if (typeof map[gameCode] !== 'string') {
            map[gameCode] = '';
        }
        if (map[gameCode].length > 0) {
            map[gameCode] += ','
        }
        map[gameCode] += orders[i].detail;
    }
    var result = [];
    for (var gameCode in map) {
        result.push(gameCode + map[gameCode]);
    }
    return result.join('.') + '.';
};

utils.errorMsg = function(code, container) {	
    utils.hideLoading();            
    utils.alert(label.errorMsg[code], container);    
};

utils.errorMsg2 = function(msg, container) {	
    utils.hideLoading();            
    utils.alert(msg, container);    
};