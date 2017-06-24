var server = {
    //get configuration
    getConfig: function(callback) {
        var result = {
            groups: [
                {id: "1", pp: 1700, pr: 500, p: 2000, r: 1.04, s: 1, u: 1},
                {id: "2", pp: 1700, pr: 400, p: 1740, r: 1.6, s: 2, u: 2}
            ],
            games: [
                {
                    id: "HELSSC",
                    grp: 1,
                    u: "1",
                    dg: "3M",
                    t: "SSC",
                    gc: [
                        {c: "1", s: [{id: "1", cd: "1S"}]},
                        {c: "2", s: [{id: "2", cd: "2S"}, {id: "3", cd: "2C"}, {id: "4", cd: "2P"}, {id: "5", cd: "22"}, {id: "6", cd: "2A"}]},
                        {c: "3", s: [{id: "7", cd: "3S"}, {id: "8", cd: "3M"}, {id: "9", cd: "33"}, {id: "10", cd: "36"}, {id: "11", cd: "3A"} /*, { id: "12", cd: "3C"}*/]},
                        {c: "4", s: [{id: "13", cd: "BS"}, {id: "14", cd: "BC"}, {id: "15", cd: "BP"}, {id: "16", cd: "B2"}, {id: "17", cd: "BA"}]},
                        {c: "5", s: [{id: "18", cd: "CS"}, {id: "19", cd: "CM"}, {id: "20", cd: "C3"}, {id: "21", cd: "C6"}, {id: "22", cd: "CA"} /*, { id: "23", cd: "CC"}*/]},
                        {c: "6", s: [{id: "24", cd: "4S"}, {id: "25", cd: "DS"}]},
                        {c: "7", s: [{id: "26", cd: "5S"}, {id: "27", cd: "5C"}, {id: "28", cd: "5A"}]},
                        {c: "8", s: [{id: "29", cd: "2U"}, {id: "30", cd: "3U"}, {id: "31", cd: "BU"}, {id: "32", cd: "CU"}]},
                        {c: "9", s: [{id: "33", cd: "BB"}, {id: "34", cd: "2B"}]},
                        {c: "10", s: [{id: "35", cd: "BF"}, {id: "36", cd: "BG"}, {id: "37", cd: "CH"}, {id: "38", cd: "CI"}, {id: "39", cd: "CJ"}, {id: "40", cd: "CK"}, {id: "41", cd: "2F"}, {id: "42", cd: "2G"}, {id: "43", cd: "3H"}, {id: "44", cd: "3I"}, {id: "45", cd: "3J"}, {id: "46", cd: "3K"}]},
                        {c: "11", s: [{id: "47", cd: "5F"}]}
                    ]
                },
                {
                    id: "CQSSC",
                    grp: 1,
                    u: "1",
                    dg: "3M",
                    t: "SSC",
                    gc: [
                        {c: "1", s: [{id: "1", cd: "1S"}]},
                        {c: "2", s: [{id: "2", cd: "2S"}, {id: "3", cd: "2C"}, {id: "4", cd: "2P"}, {id: "5", cd: "22"}, {id: "6", cd: "2A"}]},
                        {c: "3", s: [{id: "7", cd: "3S"}, {id: "8", cd: "3M"}, {id: "9", cd: "33"}, {id: "10", cd: "36"}, {id: "11", cd: "3A"} /*, { id: "12", cd: "3C"}*/]},
                        {c: "4", s: [{id: "13", cd: "BS"}, {id: "14", cd: "BC"}, {id: "15", cd: "BP"}, {id: "16", cd: "B2"}, {id: "17", cd: "BA"}]},
                        {c: "5", s: [{id: "18", cd: "CS"}, {id: "19", cd: "CM"}, {id: "20", cd: "C3"}, {id: "21", cd: "C6"}, {id: "22", cd: "CA"} /*, { id: "23", cd: "CC"}*/]},
                        {c: "6", s: [{id: "24", cd: "4S"}, {id: "25", cd: "DS"}]},
                        {c: "7", s: [{id: "26", cd: "5S"}, {id: "27", cd: "5C"}, {id: "28", cd: "5A"}]},
                        {c: "8", s: [{id: "29", cd: "2U"}, {id: "30", cd: "3U"}, {id: "31", cd: "BU"}, {id: "32", cd: "CU"}]},
                        {c: "9", s: [{id: "33", cd: "BB"}, {id: "34", cd: "2B"}]},
                        {c: "10", s: [{id: "35", cd: "BF"}, {id: "36", cd: "BG"}, {id: "37", cd: "CH"}, {id: "38", cd: "CI"}, {id: "39", cd: "CJ"}, {id: "40", cd: "CK"}, {id: "41", cd: "2F"}, {id: "42", cd: "2G"}, {id: "43", cd: "3H"}, {id: "44", cd: "3I"}, {id: "45", cd: "3J"}, {id: "46", cd: "3K"}]},
                        {c: "11", s: [{id: "47", cd: "5F"}]}
                    ]
                },
                {
                    id: "JXSSC",
                    grp: 1,
                    u: "2",
                    dg: "3S",
                    t: "SSC",
                    gc: [
                        {c: "1", s: [{id: "1", cd: "1S"}]},
                        {c: "2", s: [{id: "2", cd: "2S"}, {id: "3", cd: "2C"}, {id: "4", cd: "2P"}, {id: "5", cd: "22"}, {id: "6", cd: "2A"}]},
                        {c: "3", s: [{id: "7", cd: "3S"}, {id: "8", cd: "3M"}, {id: "9", cd: "33"}, {id: "10", cd: "36"}, {id: "11", cd: "3A"} /*, { id: "12", cd: "3C" }*/]},
                        {c: "4", s: [{id: "13", cd: "BS"}, {id: "14", cd: "BC"}, {id: "15", cd: "BP"}, {id: "16", cd: "B2"}, {id: "17", cd: "BA"}]},
                        {c: "5", s: [{id: "18", cd: "CS"}, {id: "19", cd: "CM"}, {id: "20", cd: "C3"}, {id: "21", cd: "C6"}, {id: "22", cd: "CA"} /*, { id: "23", cd: "CC" }*/]},
                        {c: "6", s: [{id: "24", cd: "4S"}, {id: "25", cd: "DS"}]},
                        {c: "7", s: [{id: "26", cd: "5S"}, {id: "27", cd: "5C"}, {id: "28", cd: "5A"}]},
                        {c: "8", s: [{id: "29", cd: "2U"}, {id: "30", cd: "3U"}, {id: "31", cd: "BU"}, {id: "32", cd: "CU"}]},
                        {c: "9", s: [{id: "33", cd: "BB"}, {id: "34", cd: "2B"}]},
                        {c: "10", s: [{id: "35", cd: "BF"}, {id: "36", cd: "BG"}, {id: "37", cd: "CH"}, {id: "38", cd: "CI"}, {id: "39", cd: "CJ"}, {id: "40", cd: "CK"}, {id: "41", cd: "2F"}, {id: "42", cd: "2G"}, {id: "43", cd: "3H"}, {id: "44", cd: "3I"}, {id: "45", cd: "3J"}, {id: "46", cd: "3K"}]},
                        {c: "11", s: [{id: "47", cd: "5F"}]}
                    ]
                },
                {
                    id: "HLJSSC",
                    grp: 2,
                    u: "3",
                    dg: "3S",
                    t: "SSC",
                    gc: [
                        {c: "1", s: [{id: "1", cd: "1S"}]},
                        {c: "2", s: [{id: "2", cd: "2S"}, {id: "3", cd: "2C"}, {id: "4", cd: "2P"}, {id: "5", cd: "22"}, {id: "6", cd: "2A"}]},
                        {c: "3", s: [{id: "7", cd: "3S"}, {id: "8", cd: "3M"}, {id: "9", cd: "33"}, {id: "10", cd: "36"}, {id: "11", cd: "3A"} /*, { id: "12", cd: "3C" }*/]},
                        {c: "4", s: [{id: "13", cd: "BS"}, {id: "14", cd: "BC"}, {id: "15", cd: "BP"}, {id: "16", cd: "B2"}, {id: "17", cd: "BA"}]},
                        {c: "5", s: [{id: "18", cd: "CS"}, {id: "19", cd: "CM"}, {id: "20", cd: "C3"}, {id: "21", cd: "C6"}, {id: "22", cd: "CA"} /*, { id: "23", cd: "CC" }*/]},
                        {c: "6", s: [{id: "24", cd: "4S"}, {id: "25", cd: "DS"}]},
                        {c: "7", s: [{id: "26", cd: "5S"}, {id: "27", cd: "5C"}, {id: "28", cd: "5A"}]},
                        {c: "8", s: [{id: "29", cd: "2U"}, {id: "30", cd: "3U"}, {id: "31", cd: "BU"}, {id: "32", cd: "CU"}]},
                        {c: "9", s: [{id: "33", cd: "BB"}, {id: "34", cd: "2B"}]},
                        {c: "10", s: [{id: "35", cd: "BF"}, {id: "36", cd: "BG"}, {id: "37", cd: "CH"}, {id: "38", cd: "CI"}, {id: "39", cd: "CJ"}, {id: "40", cd: "CK"}, {id: "41", cd: "2F"}, {id: "42", cd: "2G"}, {id: "43", cd: "3H"}, {id: "44", cd: "3I"}, {id: "45", cd: "3J"}, {id: "46", cd: "3K"}]},
                        {c: "11", s: [{id: "47", cd: "5F"}]}
                    ]
                },
                {
                    id: "HEL11X5",
                    grp: 1,
                    u: "4",
                    dg: "F2",
                    t: "11X5",
                    gc: [
                        {c: "101", s: [{id: "152", cd: "Fa"}, {id: "153", cd: "Fb"}, {id: "154", cd: "Fc"}, {id: "155", cd: "Fd"}, {id: "156", cd: "Fe"}, {id: "157", cd: "Ff"}, {id: "158", cd: "Fg"}, {id: "159", cd: "Fh"}]},
                        {c: "102", s: [{id: "160", cd: "FO"}]},
                        {c: "103", s: [{id: "161", cd: "FM"}]},
                        {c: "104", s: [{id: "162", cd: "F3"}, {id: "163", cd: "FC"}]},
                        {c: "105", s: [{id: "164", cd: "F2"}, {id: "165", cd: "FB"}]},
                        {c: "106", s: [{id: "166", cd: "FG"}]},
                        {c: "107", s: [{id: "167", cd: "FF"}]}
                    ]
                },
                {
                    id: "SD11X5",
                    grp: 1,
                    u: "4",
                    dg: "F3",
                    t: "11X5",
                    gc: [
                        {c: "101", s: [{id: "152", cd: "Fa"}, {id: "153", cd: "Fb"}, {id: "154", cd: "Fc"}, {id: "155", cd: "Fd"}, {id: "156", cd: "Fe"}, {id: "157", cd: "Ff"}, {id: "158", cd: "Fg"}, {id: "159", cd: "Fh"}]},
                        {c: "102", s: [{id: "160", cd: "FO"}]},
                        {c: "103", s: [{id: "161", cd: "FM"}]},
                        {c: "104", s: [{id: "162", cd: "F3"}, {id: "163", cd: "FC"}]},
                        {c: "105", s: [{id: "164", cd: "F2"}, {id: "165", cd: "FB"}]},
                        {c: "106", s: [{id: "166", cd: "FG"}]},
                        {c: "107", s: [{id: "167", cd: "FF"}]}
                    ]
                },
                {
                    id: "GD11X5",
                    grp: 1,
                    u: "5",
                    dg: "F3",
                    t: "11X5",
                    gc: [
                        {c: "101", s: [{id: "152", cd: "Fa"}, {id: "153", cd: "Fb"}, {id: "154", cd: "Fc"}, {id: "155", cd: "Fd"}, {id: "156", cd: "Fe"}, {id: "157", cd: "Ff"}, {id: "158", cd: "Fg"}, {id: "159", cd: "Fh"}]},
                        {c: "102", s: [{id: "160", cd: "FO"}]},
                        {c: "103", s: [{id: "161", cd: "FM"}]},
                        {c: "104", s: [{id: "162", cd: "F3"}, {id: "163", cd: "FC"}]},
                        {c: "105", s: [{id: "164", cd: "F2"}, {id: "165", cd: "FB"}]},
                        {c: "106", s: [{id: "166", cd: "FG"}]},
                        {c: "107", s: [{id: "167", cd: "FF"}]}
                    ]
                },
                {
                    id: "JX11X5",
                    grp: 1,
                    u: "4",
                    dg: "F2",
                    t: "11X5",
                    gc: [
                        {c: "101", s: [{id: "152", cd: "Fa"}, {id: "153", cd: "Fb"}, {id: "154", cd: "Fc"}, {id: "155", cd: "Fd"}, {id: "156", cd: "Fe"}, {id: "157", cd: "Ff"}, {id: "158", cd: "Fg"}, {id: "159", cd: "Fh"}]},
                        {c: "102", s: [{id: "160", cd: "FO"}]},
                        {c: "103", s: [{id: "161", cd: "FM"}]},
                        {c: "104", s: [{id: "162", cd: "F3"}, {id: "163", cd: "FC"}]},
                        {c: "105", s: [{id: "164", cd: "F2"}, {id: "165", cd: "FB"}]},
                        {c: "106", s: [{id: "166", cd: "FG"}]},
                        {c: "107", s: [{id: "167", cd: "FF"}]}
                    ]
                }
            ],
            gameSubOption: [
                //一星直选
                {
                    id: "1S", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //二星直选
                {
                    id: "2S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
                    r: [
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //二星组选
                {
                    id: "2C", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 6, t: 6, mn: 0, mx: 9}
                    ],
                    mna: 2, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //二星分位
                {
                    id: "2P", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //二星包点
                {
                    id: "22", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 7, t: 7, mn: 0, mx: 18}
                    ],
                    mna: 1, mxa: 20, as: 1, lg: 1, lgl: 3
                },
                //二星连选
                {
                    id: "2A", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
                    r: [
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //三星直选
                {
                    id: "3S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
                    r: [
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //三星包点
                {
                    id: "3M", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 8, t: 8, mn: 0, mx: 27}
                    ],
                    mna: 1, mxa: 30, as: 1, lg: 1, lgl: 3
                },
                //三星组三
                {
                    id: "33", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 4, ss: 0,
                    r: [
                        {lb: 9, t: 9, mn: 0, mx: 9}
                    ],
                    mna: 2, mxa: 10, as: 1, lg: 0, lgl: 1
                },
                //三星组六
                {
                    id: "36", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 2, ss: 0,
                    r: [
                        {lb: 17, t: 17, mn: 0, mx: 9}
                    ],
                    mna: 3, mxa: 10, as: 1, lg: 0, lgl: 1
                },
                //三星连选
                {
                    id: "3A", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
                    r: [
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //三星直选组合
                {
                    id: "3C", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 10, t: 10, mn: 0, mx: 9}
                    ],
                    mna: 3, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //前二直选
                {
                    id: "BS", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //前二组选
                {
                    id: "BC", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 6, t: 6, mn: 0, mx: 9}
                    ],
                    mna: 2, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //前二分位
                {
                    id: "BP", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //前二包点
                {
                    id: "B2", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 20, t: 20, mn: 0, mx: 18}
                    ],
                    mna: 1, mxa: 20, as: 1, lg: 1, lgl: 3
                },
                //前二连选
                {
                    id: "BA", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //前三直选
                {
                    id: "CS", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //前三包点
                {
                    id: "CM", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 21, t: 21, mn: 0, mx: 27}
                    ],
                    mna: 1, mxa: 30, as: 1, lg: 1, lgl: 3
                },
                //前三组三
                {
                    id: "C3", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 4, ss: 0,
                    r: [
                        {lb: 9, t: 9, mn: 0, mx: 9}
                    ],
                    mna: 2, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //前三组六
                {
                    id: "C6", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 2, ss: 0,
                    r: [
                        {lb: 17, t: 17, mn: 0, mx: 9}
                    ],
                    mna: 3, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //前三连选
                {
                    id: "CA", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //前三直选组合
                {
                    id: "CC", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 10, t: 10, mn: 0, mx: 9}
                    ],
                    mna: 3, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //五星直选 
                {
                    id: "5S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 3, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //五星通选
                {
                    id: "5C", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 3, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //五星连选        
                {
                    id: "5A", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 3, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //二星和值
                {
                    id: "2U", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 11, t: 11, mn: 0, mx: 18}
                    ],
                    mna: 1, mxa: 20, as: 0, lg: 1, lgl: 3
                },
                //三星和值
                {
                    id: "3U", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 18, t: 18, mn: 0, mx: 27}
                    ],
                    mna: 1, mxa: 30, as: 0, lg: 1, lgl: 3
                },
                //前二和值
                {
                    id: "BU", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 19, t: 19, mn: 0, mx: 18}
                    ],
                    mna: 1, mxa: 20, as: 0, lg: 1, lgl: 3
                },
                //前三和值
                {
                    id: "CU", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 12, t: 12, mn: 0, mx: 27}
                    ],
                    mna: 1, mxa: 30, as: 0, lg: 1, lgl: 3
                },
                //前二大小单双
                {
                    id: "BB", om: 1, ht: 1, msg: 1, t: 3, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 5, t: 5, mn: 1, mx: 4},
                        {lb: 4, t: 4, mn: 1, mx: 4}
                    ],
                    mna: 1, mxa: 5, as: 0, lg: 1, lgl: 1
                },
                //后二大小单双
                {
                    id: "2B", om: 1, ht: 1, msg: 1, t: 3, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 2, t: 2, mn: 1, mx: 4},
                        {lb: 1, t: 1, mn: 1, mx: 4}
                    ],
                    mna: 1, mxa: 5, as: 0, lg: 1, lgl: 1
                },
                //前二组选
                {
                    id: "BF", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 13, t: 13, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //前二直选
                {
                    id: "BG", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 14, t: 14, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //前三组选 (包一胆)
                {
                    id: "CH", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 13, t: 15, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //前三组选 (包二胆)
                {
                    id: "CI", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 15, t: 15, mn: 0, mx: 9},
                        {lb: 16, t: 16, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //前三直选 (包一胆)
                {
                    id: "CJ", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 13, t: 15, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //前三直选 (包二胆)
                {
                    id: "CK", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 15, t: 15, mn: 0, mx: 9},
                        {lb: 16, t: 16, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //后二组选
                {
                    id: "2F", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 14, t: 13, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //后二直选
                {
                    id: "2G", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 14, t: 14, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
                },
                //后三组选 (包一胆)
                {
                    id: "3H", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 13, t: 15, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //后三组选 (包二胆)
                {
                    id: "3I", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 15, t: 15, mn: 0, mx: 9},
                        {lb: 16, t: 16, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //后三直选 (包一胆)
                {
                    id: "3J", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 13, t: 15, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //后三直选 (包二胆)
                {
                    id: "3K", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
                    r: [
                        {lb: 15, t: 15, mn: 0, mx: 9},
                        {lb: 16, t: 16, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
                },
                //定位胆
                {
                    id: "5F", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 0, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //四星
                {
                    id: "DS", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 0, mx: 9},
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //四星
                {
                    id: "4S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
                    r: [
                        {lb: 4, t: 4, mn: 0, mx: 9},
                        {lb: 3, t: 3, mn: 0, mx: 9},
                        {lb: 2, t: 2, mn: 0, mx: 9},
                        {lb: 1, t: 1, mn: 0, mx: 9}
                    ],
                    mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
                },
                //任选一
                {
                    id: "Fa", om: 1, ht: 1, msg: 1, t: 5, me: 0, mec: 0, met: 0, ss: 0,
                    r: [
                        {lb: 6, t: 6, mn: 1, mx: 11}
                    ],
                    mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选二
                {
                    id: "Fb", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 7, t: 7, mn: 1, mx: 11}
                    ],
                    mna: 2, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选三
                {
                    id: "Fc", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 8, t: 8, mn: 1, mx: 11}
                    ],
                    mna: 3, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选四
                {
                    id: "Fd", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 9, t: 9, mn: 1, mx: 11}
                    ],
                    mna: 4, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选五
                {
                    id: "Fe", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 10, t: 10, mn: 1, mx: 11}
                    ],
                    mna: 5, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选六
                {
                    id: "Ff", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 11, t: 11, mn: 1, mx: 11}
                    ],
                    mna: 6, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选七
                {
                    id: "Fg", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 12, t: 12, mn: 1, mx: 11}
                    ],
                    mna: 7, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //任选八
                {
                    id: "Fh", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
                    r: [
                        {lb: 13, t: 13, mn: 1, mx: 11}
                    ],
                    mna: 8, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //定单双
                {
                    id: "FO", om: 1, ht: 1, msg: 1, t: 3, me: 0, mec: 0, met: 0, ss: 0,
                    r: [
                        {lb: "", t: 16, mn: 0, mx: 1},
                        {lb: "", t: 16, mn: 2, mx: 3},
                        {lb: "", t: 16, mn: 4, mx: 5}
                    ],
                    mna: 0, mxa: 6, as: 0, lg: 0, lgl: 0, rm: 2
                },
                //猜中位
                {
                    id: "FM", om: 1, ht: 1, msg: 1, t: 6, me: 0, mec: 0, met: 0, ss: 0,
                    r: [
                        {lb: 14, t: 14, mn: 3, mx: 9}
                    ],
                    mna: 1, mxa: 11, as: 1, lg: 0, lgl: 1, rm: 1
                },
                //前三直选
                {
                    id: "F3", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 2, met: 1, ss: 0,
                    r: [
                        {lb: 3, t: 3, mn: 1, mx: 11},
                        {lb: 2, t: 2, mn: 1, mx: 11},
                        {lb: 1, t: 1, mn: 1, mx: 11}
                    ],
                    mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //前三组选
                {
                    id: "FC", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 2, met: 1, ss: 0,
                    r: [
                        {lb: 4, t: 4, mn: 1, mx: 11}
                    ],
                    mna: 3, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //前二直选
                {
                    id: "F2", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 1, ss: 0,
                    r: [
                        {lb: 2, t: 2, mn: 1, mx: 11},
                        {lb: 1, t: 1, mn: 1, mx: 11}
                    ],
                    mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //前二组选
                {
                    id: "FB", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 1, ss: 0,
                    r: [
                        {lb: 5, t: 5, mn: 1, mx: 11}
                    ],
                    mna: 2, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //不定位胆
                {
                    id: "FG", om: 1, ht: 1, msg: 1, t: 5, me: 0, mec: 0, met: 0, ss: 0,
                    r: [
                        {lb: 15, t: 15, mn: 1, mx: 11}
                    ],
                    mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
                },
                //定位胆
                {
                    id: "FF", om: 1, ht: 1, msg: 1, t: 5, me: 0, mec: 0, met: 0, ss: 0,
                    r: [
                        {lb: 3, t: 3, mn: 0, mx: 11},
                        {lb: 2, t: 2, mn: 0, mx: 11},
                        {lb: 1, t: 1, mn: 0, mx: 11}
                    ],
                    mna: 0, mxa: 11, as: 1, lg: 0, lgl: 1, rm: 1
                }
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get draw number
    getDrawNumber: function(data, callback) {
        /*
         id - 彩总
         val - 期号
         */
        var result = [
                    {'id': 'CQSSC', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'SD11Y', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'HLJSSC', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'XJSSC', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'CQ115', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'JX115', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'GD115', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'TJSSC', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': '3D', 'val': Math.floor(Math.random() * 99999999999)},
                    {'id': 'P3P5', 'val': Math.floor(Math.random() * 99999999999)}
        ];

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get draw
    getDraw: function(gameId, callback) {
        /*
         currently use only cdTs (current draw time stamp)
         */
        var result = {
            cdId: Math.floor(Math.random() * 99999) + 'cid-' + Math.floor(Math.random() * 999),
            cd: Math.floor(Math.random() * 99999) + 'c-' + Math.floor(Math.random() * 999),
            cdTs: Math.floor(Math.random() * 60),
            ndId: Math.floor(Math.random() * 99999) + 'ndid-' + Math.floor(Math.random() * 999),
            nd: Math.floor(Math.random() * 99999) + 'nd-' + Math.floor(Math.random() * 999),
            ndTs: Math.floor(Math.random() * 60)
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get draw result
    getDrawResult: function(data, callback) {
        /*
         id - 期号
         date - 开彩日期
         val - 开彩号
         */
        var result = [
            {id: Math.floor(Math.random() * 999999999999), date: "2012-08-12 13:00:05", val: Math.floor(Math.random() * 99999)},
            {id: Math.floor(Math.random() * 999999999999), date: "2012-08-12 13:00:05", val: Math.floor(Math.random() * 99999)},
            {id: Math.floor(Math.random() * 999999999999), date: "2012-08-12 13:00:05", val: Math.floor(Math.random() * 99999)},
            {id: Math.floor(Math.random() * 999999999999), date: "2012-08-12 13:00:05", val: Math.floor(Math.random() * 99999)},
            {id: Math.floor(Math.random() * 999999999999), date: "2012-08-12 13:00:05", val: Math.floor(Math.random() * 99999)}
        ];

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get orders
    getOrders: function(data, callback) {
        /*
         c - count
         r - rows
         cdId - order code
         s - 状态
         val - 奖金
         */
        var result = {
            c: 123,
            r: [
                {id: Math.floor(Math.random() * 999999999999), no: Math.floor(Math.random() * 999999999999), s: "O", val: Math.floor(Math.random() * 9999999999999), ti: "99-99 99:99", at: Math.floor(Math.random() * 999999999999)},
                {id: Math.floor(Math.random() * 999999999999), no: Math.floor(Math.random() * 999999999999), s: "Y", val: Math.floor(Math.random() * 99999), ti: "99-99 99:99", at: Math.floor(Math.random() * 999999999999)},
                {id: Math.floor(Math.random() * 999999999999), no: Math.floor(Math.random() * 999999999999), s: "Z", val: Math.floor(Math.random() * 99999), ti: "99-99 99:99", at: Math.floor(Math.random() * 999999999999)},
                {id: Math.floor(Math.random() * 999999999999), no: Math.floor(Math.random() * 999999999999), s: "Z", val: Math.floor(Math.random() * 99999), ti: "99-99 99:99", at: Math.floor(Math.random() * 999999999999)},
                {id: Math.floor(Math.random() * 999999999999), no: Math.floor(Math.random() * 999999999999), s: "A", val: Math.floor(Math.random() * 99999), ti: "99-99 99:99", at: Math.floor(Math.random() * 999999999999)}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get bet detail
    getDetail: function(id, callback) {
        var result = {
            orderNo: Math.floor(Math.random() * 999999999999),
            d: [
                /*
                 n - 玩法名称
                 b - 投注内容
                 a - 投注注数
                 */
                {n: "3M", b: "0123456789_0123456789_0123456789_0123456789_0123456789", a: "10"},
                {n: "CI", b: "0123456789", a: "10"},
                {n: "BB", b: "2_3", a: "10"},
                {n: "FO", b: "01234", a: "10"}
            ],
            t: "2", //type
            ac: "1", //allow cancel

            //share details
            g: "CQSSC", //彩种类别
            po: Math.floor(Math.random() * 9999), //系列模式
            bty: "2", //投注模式
            bp: "20120412-100", //投注期号
            sm: "10", //单倍注数

            //normal game details
            bm: "1", //投注倍数
            st: "O", //订单状态
            br: "", //开奖号码
            wp: "0.0000", //中奖金额
            bt: "2012-04-12 22:16:02", //投注时间
            ps: "1800", //奖金系列

            //cno details
            pb: "0.40", //计划投注金额
            ab: "0.00", //实际投注金额
            gm: "2", //总倍数
            cnom: "2", //追号期数
            sww: "true", //中奖即停止
            swo: "false", //出号即停止
            tm: "true", //是否结束
            //cno
            cno: [
                {id: "1", p: "20120412-099", n: "12345678", s: "未开奖", a: "1", b: "0.20", w: "0.000"},
                {id: "2", p: "20120412-099", n: "12345678", s: "未开奖", a: "1", b: "0.20", w: "0.000"},
                {id: "3", p: "20120412-099", n: "12345678", s: "未开奖", a: "1", b: "0.20", w: "0.000"},
                {id: "4", p: "20120412-099", n: "12345678", s: "未开奖", a: "1", b: "0.20", w: "0.000"},
                {id: "5", p: "20120412-099", n: "12345678", s: "未开奖", a: "1", b: "0.20", w: "0.000"}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //withdraw
    withdraw: function(id, callback) {
        var result = true;

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //save settings
    saveSettings: function(game, value, type, callback) {
        var result = true;

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //save order
    saveOrder: function(detail, callback) {
        var result = {
            no: Math.floor(Math.random() * 999999999999),
            total: Math.floor(Math.random() * 9999)
        };

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //login
    login: function(data, callback) {
        var result = {
            /*
             id - member id
             a - accounts
             */

            id: "999",
            a: [
                {id: '1'},
                {id: '2'},
                {id: '3'},
                {id: '4'}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //logout
    logout: function(callback) {
        var result = true;

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get draw result
    getAccount: function(data, callback) {
        /*
         id - 帐户
         val - 存额
         */
        var result = [
            {id: 1, aId: "1", val: Math.floor(Math.random() * 99999999)},
            {id: 2, aId: "2", val: Math.floor(Math.random() * 99999999)},
            {id: 3, aId: "3", val: Math.floor(Math.random() * 99999999)},
            {id: 4, aId: "4", val: Math.floor(Math.random() * 99999999)}
        ];

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //transfer
    transfer: function(data, callback) {
        var result = true;

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get account withdraw
    getAccountWithdraw: function(data, callback) {
        /*
         id - 帐户
         val - 存额
         */
        var result = {
            mw: Math.floor(Math.random() * 99),
            cw: Math.floor(Math.random() * 99),
            b: Math.floor(Math.random() * 99999999),
            a: [
                {id: 1, val: Math.floor(Math.random() * 99999999)},
                {id: 2, val: Math.floor(Math.random() * 99999999)},
                {id: 3, val: Math.floor(Math.random() * 99999999)},
                {id: 4, val: Math.floor(Math.random() * 99999999)}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //account withdraw
    accountWithdraw: function(data, callback) {
        var result = true;

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    //get account activity
    getAccountActivity: function(data, callback) {
        /*
         c - count
         r - rows
         date - 账变时间
         txn - 收支
         val - 余额
         t - 类型
         */
        var result = {
            c: 123,
            r: [
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 9999999999), txnType: "0", val: Math.floor(Math.random() * 9999999999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "1", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "1", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "0", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "0", val: Math.floor(Math.random() * 99999), t: '1'}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    getAccountBal: function(aId, callback) {
        var result = {
            c: 123,
            r: [
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 9999999999), txnType: "0", val: Math.floor(Math.random() * 9999999999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "1", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "1", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "0", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "0", val: Math.floor(Math.random() * 99999), t: '1'}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    updateBalance: function(callback) {
        var result = {
            c: 123,
            r: [
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 9999999999), txnType: "0", val: Math.floor(Math.random() * 9999999999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "1", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "1", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "0", val: Math.floor(Math.random() * 99999), t: '1'},
                {date: "2012-08-12 13:00:05", txn: Math.floor(Math.random() * 99999), txnType: "0", val: Math.floor(Math.random() * 99999), t: '1'}
            ]
        }

        setTimeout(function() {
            callback(result);
        }, 1000);
    },
    
    defaultGameSubOpt : function() {
    return [
        //一星直选
        {
            id: "1S", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //二星直选
        {
            id: "2S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
            r: [
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //二星组选
        {
            id: "2C", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 6, t: 6, mn: 0, mx: 9 }
            ],
            mna: 2, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //二星分位
        {
            id: "2P", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //二星包点
        {
            id: "22", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 7, t: 7, mn: 0, mx: 18 }
            ],
            mna: 1, mxa: 20, as: 1, lg: 1, lgl: 3
        },
        //二星连选
        {
            id: "2A", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
            r: [
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //三星直选
        {
            id: "3S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
            r: [
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //三星包点
        {
            id: "3M", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 8, t: 8, mn: 0, mx: 27 }
            ],
            mna: 1, mxa: 30, as: 1, lg: 1, lgl: 3
        },
        //三星组三
        {
            id: "33", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 4, ss: 0,
            r: [
                { lb: 9, t: 9, mn: 0, mx: 9 }
            ],
            mna: 2, mxa: 10, as: 1, lg: 0, lgl: 1
        },
        //三星组六
        {
            id: "36", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 2, ss: 0,
            r: [
                { lb: 17, t: 17, mn: 0, mx: 9 }
            ],
            mna: 3, mxa: 10, as: 1, lg: 0, lgl: 1
        },
        //三星连选
        {
            id: "3A", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
            r: [
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //三星直选组合
        {
            id: "3C", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                 { lb: 10, t: 10, mn: 0, mx: 9 }
            ],
            mna: 3, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //前二直选
        {
            id: "BS", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //前二组选
        {
            id: "BC", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 6, t: 6, mn: 0, mx: 9 }
            ],
            mna: 2, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //前二分位
        {
            id: "BP", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //前二包点
        {
            id: "B2", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 20, t: 20, mn: 0, mx: 18 }
            ],
            mna: 1, mxa: 20, as: 1, lg: 1, lgl: 3
        },
        //前二连选
        {
            id: "BA", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 1, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //前三直选
        {
            id: "CS", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //前三包点
        {
            id: "CM", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 21, t: 21, mn: 0, mx: 27 }
            ],
            mna: 1, mxa: 30, as: 1, lg: 1, lgl: 3
        },
        //前三组三
        {
            id: "C3", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 4, ss: 0,
            r: [
                { lb: 9, t: 9, mn: 0, mx: 9 }
            ],
            mna: 2, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //前三组六
        {
            id: "C6", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 2, ss: 0,
            r: [
                { lb: 17, t: 17, mn: 0, mx: 9 }
            ],
            mna: 3, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //前三连选
        {
            id: "CA", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //前三直选组合
        {
            id: "CC", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                 { lb: 10, t: 10, mn: 0, mx: 9 }
            ],
            mna: 3, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //五星直选 
        {
            id: "5S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 3, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //五星通选
        {
            id: "5C", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 3, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //五星连选        
        {
            id: "5A", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 3, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //二星和值
        {
            id: "2U", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 11, t: 11, mn: 0, mx: 18 }
            ],
            mna: 1, mxa: 20, as: 0, lg: 1, lgl: 3
        },
        //三星和值
        {
            id: "3U", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 18, t: 18, mn: 0, mx: 27 }
            ],
            mna: 1, mxa: 30, as: 0, lg: 1, lgl: 3
        },
        //前二和值
        {
            id: "BU", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 19, t: 19, mn: 0, mx: 18 }
            ],
            mna: 1, mxa: 20, as: 0, lg: 1, lgl: 3
        },
        //前三和值
        {
            id: "CU", om: 1, ht: 1, msg: 1, t: 2, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 12, t: 12, mn: 0, mx: 27 }
            ],
            mna: 1, mxa: 30, as: 0, lg: 1, lgl: 3
        },
        //前二大小单双
        {
            id: "BB", om: 1, ht: 1, msg: 1, t: 3, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 5, t: 5, mn: 1, mx: 4 },
                { lb: 4, t: 4, mn: 1, mx: 4 }
            ],
            mna: 1, mxa: 5, as: 0, lg: 1, lgl: 1
        },
        //后二大小单双
        {
            id: "2B", om: 1, ht: 1, msg: 1, t: 3, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 2, t: 2, mn: 1, mx: 4 },
                { lb: 1, t: 1, mn: 1, mx: 4 }
            ],
            mna: 1, mxa: 5, as: 0, lg: 1, lgl: 1
        },
        //前二组选
        {
            id: "BF", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 13, t: 13, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //前二直选
        {
            id: "BG", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                 { lb: 14, t: 14, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //前三组选 (包一胆)
        {
            id: "CH", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 13, t: 15, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //前三组选 (包二胆)
        {
            id: "CI", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 15, t: 15, mn: 0, mx: 9 },
                { lb: 16, t: 16, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //前三直选 (包一胆)
        {
            id: "CJ", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 13, t: 15, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //前三直选 (包二胆)
        {
            id: "CK", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 15, t: 15, mn: 0, mx: 9 },
                { lb: 16, t: 16, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //后二组选
        {
            id: "2F", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 14, t: 13, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //后二直选
        {
            id: "2G", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                 { lb: 14, t: 14, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 0, lgl: 0
        },
        //后三组选 (包一胆)
        {
            id: "3H", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 13, t: 15, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //后三组选 (包二胆)
        {
            id: "3I", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 15, t: 15, mn: 0, mx: 9 },
                { lb: 16, t: 16, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //后三直选 (包一胆)
        {
            id: "3J", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 13, t: 15, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //后三直选 (包二胆)
        {
            id: "3K", om: 1, ht: 1, msg: 1, t: 4, me: 0, mec: 0, ss: 1,
            r: [
                { lb: 15, t: 15, mn: 0, mx: 9 },
                { lb: 16, t: 16, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 0, lg: 0, lgl: 0
        },
        //定位胆
        {
            id: "5F", om: 1, ht: 1, msg: 1, t: 1, me: 0, mec: 0, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 0, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //四星
        {
            id: "DS", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 0, mx: 9 },
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //四星
        {
            id: "4S", om: 1, ht: 1, msg: 1, t: 1, me: 1, mec: 2, ss: 0,
            r: [
                { lb: 4, t: 4, mn: 0, mx: 9 },
                { lb: 3, t: 3, mn: 0, mx: 9 },
                { lb: 2, t: 2, mn: 0, mx: 9 },
                { lb: 1, t: 1, mn: 0, mx: 9 }
            ],
            mna: 1, mxa: 10, as: 1, lg: 1, lgl: 1
        },
        //任选一
        {
            id: "Fa", om: 1, ht: 1, msg: 1, t: 5, me: 0, mec: 0, met: 0, ss: 0,
            r: [
                { lb: 6, t: 6, mn: 1, mx: 11 }
            ],
            mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选二
        {
            id: "Fb", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                 { lb: 7, t: 7, mn: 1, mx: 11 }
            ],
            mna: 2, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选三
        {
            id: "Fc", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                { lb: 8, t: 8, mn: 1, mx: 11 }
            ],
            mna: 3, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选四
        {
            id: "Fd", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                { lb: 9, t: 9, mn: 1, mx: 11 }
            ],
            mna: 4, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选五
        {
            id: "Fe", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                { lb: 10, t: 10, mn: 1, mx: 11 }
            ],
            mna: 5, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选六
        {
            id: "Ff", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                 { lb: 11, t: 11, mn: 1, mx: 11 }
            ],
            mna: 6, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选七
        {
            id: "Fg", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                 { lb: 12, t: 12, mn: 1, mx: 11 }
            ],
            mna: 7, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //任选八
        {
            id: "Fh", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 2, ss: 0,
            r: [
                 { lb: 13, t: 13, mn: 1, mx: 11 }
            ],
            mna: 8, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //定单双
        {
            id: "FO", om: 1, ht: 1, msg: 1, t: 3, me: 0, mec: 0, met: 0, ss: 0,
            r: [
                  { lb: "", t: 16, mn: 0, mx: 1 },
                  { lb: "", t: 16, mn: 2, mx: 3 },
                  { lb: "", t: 16, mn: 4, mx: 5 }
            ],
            mna: 0, mxa: 6, as: 0, lg: 0, lgl: 0, rm: 2
        },
        //猜中位
        {
            id: "FM", om: 1, ht: 1, msg: 1, t: 6, me: 0, mec: 0, met: 0, ss: 0,
            r: [
                 { lb: 14, t: 14, mn: 3, mx: 9 }
            ],
            mna: 1, mxa: 11, as: 1, lg: 0, lgl: 1, rm: 1
        },
        //前三直选
        {
            id: "F3", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 2, met: 1, ss: 0,
            r: [
                { lb: 3, t: 3, mn: 1, mx: 11 },
                { lb: 2, t: 2, mn: 1, mx: 11 },
                { lb: 1, t: 1, mn: 1, mx: 11 }
            ],
            mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //前三组选
        {
            id: "FC", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 2, met: 1, ss: 0,
            r: [
                { lb: 4, t: 4, mn: 1, mx: 11 }
            ],
            mna: 3, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
         //前二直选
        {
            id: "F2", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 1, ss: 0,
            r: [
                { lb: 3, t: 2, mn: 1, mx: 11 },
                { lb: 2, t: 1, mn: 1, mx: 11 }
            ],
            mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //前二组选
        {
            id: "FB", om: 1, ht: 1, msg: 1, t: 5, me: 1, mec: 1, met: 1, ss: 0,
            r: [
                { lb: 5, t: 5, mn: 1, mx: 11 }
            ],
            mna: 2, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //不定位胆
        {
            id: "FG", om: 1, ht: 1, msg: 1, t: 5, me: 0, mec: 0, met: 0, ss: 0,
            r: [
                 { lb: 15, t: 15, mn: 1, mx: 11 }
            ],
            mna: 1, mxa: 11, as: 1, lg: 1, lgl: 1, rm: 1
        },
        //定位胆
		{
			id: "FF", om: 1, ht: 1, msg: 1, t: 5, me: 0, mec: 0, met: 0, ss: 0,
			r: [
				{ lb: 3, t: 3, mn: 0, mx: 11 },
				{ lb: 2, t: 2, mn: 0, mx: 11 },
				{ lb: 1, t: 1, mn: 0, mx: 11 }
			],
			mna: 0, mxa: 11, as: 1, lg: 0, lgl: 1, rm: 1
		}
    ];
}



}