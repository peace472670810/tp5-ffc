var cache = {
    data: null, //configuration data
    profile: null, //user profile
    game: null, //game
    bet: [], //selected numbers
    draw: null, //draw
    betSettings: { cno: 1, multiplier: 1 }, //bet settings
    unit: "1",
    sportBookUrl: "",

    //get data
    getData: function () {
        return cache.data;
    },

    //set data
    setData: function (data) {
        cache.data = data;
    },

    //get profile
    getProfile: function () {
        return cache.profile;
    },

    //set profile
    setProfile: function (data) {
        cache.profile = data;
    },

    //get game
    getGame: function () {
        return cache.game;
    },

    //set game
    setGame: function (data) {
        cache.game = data;

        //set unit
        $(cache.data, function () {
            if (this.id == data) {
                cache.setUnit(this.u);
                return false;
            }
        });
    },

    //get bet
    getBet: function () {
        return cache.bet;
    },

    //add bet
    addBet: function (data) {
        cache.bet.push(data);
    },

    //remove bet
    removeBet: function (index){
        //remove bet base on index
        cache.bet.splice(index, 1);
    },

    //clear bet
    clearBet: function (){
        cache.bet = [];
    },

    //get draw
    getDraw: function (){
        return cache.draw;
    },

    //set draw
    setDraw: function(data){
        cache.draw = data;
    },

    //reset draw
    resetDraw: function(){
        cache.setDraw(null);
    },

    //get bet settings
    getBetSettings: function(){
        return cache.betSettings;
    },

    //set bet settings cno
    setBetSettingsCno: function(data){
        cache.betSettings.cno = data;
    },

    //set bet settings multiplier
    setBetSettingsMultiplier: function (data) {
        cache.betSettings.multiplier = data;
    },

    //reset both game and bet cache
    resetGame: function () {
        cache.setGame(null);
        cache.clearBet();
    },

    //get unit
    getUnit: function () {
        return cache.unit;
    },

    //set unit
    setUnit: function (data) {
        cache.unit = data;
    }
};

var setting = {
    /* use by detail.js */
    detail: {
        typeNormal: "1",
        typeCno: "2"
    },

    /* use by order.js */
    order: {
        typeNumberGroup: 1,
        typeNumber: 2,
        typeText: 3,
        typeOther: 4,
        type11x5: 5,
        typeGuess: 6,
        flagN: "N",
        flagW: "W",
        flagG: "G"
    },

    /* use by search.js */
    search: {
        pageSize: 25
    }
}