<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/30
 * Time: 20:00
 */

namespace app\Service\lottery\model;

use think\Model;

class Method_groups extends Model
{


    public $method_groups = array(
        1 =>
            array(
                'mg_id' => '1',
                'mg_lid' => '2',
                'mg_name' => '三星',
                'mg_description' => '百位，十位与个位数字',
                'mg_sort' => '3',
                'mg_update_time' => '2015-08-26 21:17:42',
            ),
        2 =>
            array(
                'mg_id' => '2',
                'mg_lid' => '2',
                'mg_name' => '二星',
                'mg_description' => '十位与和个位数字',
                'mg_sort' => '4',
                'mg_update_time' => '2015-08-26 21:17:51',
            ),
        3 =>
            array(
                'mg_id' => '3',
                'mg_lid' => '2',
                'mg_name' => '三星不定位',
                'mg_description' => '对应数字相同，与位置无关',
                'mg_sort' => '10',
                'mg_update_time' => '2015-08-26 22:48:02',
            ),
        4 =>
            array(
                'mg_id' => '4',
                'mg_lid' => '2',
                'mg_name' => '大小单双',
                'mg_description' => '十位、个位的大小单双属性',
                'mg_sort' => '11',
                'mg_update_time' => '2015-08-26 21:18:17',
            ),
        5 =>
            array(
                'mg_id' => '5',
                'mg_lid' => '26',
                'mg_name' => '前三',
                'mg_description' => '前面三个数游戏',
                'mg_sort' => '7',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        6 =>
            array(
                'mg_id' => '6',
                'mg_lid' => '26',
                'mg_name' => '任选',
                'mg_description' => '在01-11数字中任意选择一个或多个数',
                'mg_sort' => '9',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        7 =>
            array(
                'mg_id' => '7',
                'mg_lid' => '26',
                'mg_name' => '三星不定位',
                'mg_description' => '选择任意数字进行投注',
                'mg_sort' => '10',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        8 =>
            array(
                'mg_id' => '8',
                'mg_lid' => '26',
                'mg_name' => '定位胆',
                'mg_description' => '选择数字必须与开数字位置一致，数字相同',
                'mg_sort' => '100',
                'mg_update_time' => '2013-04-26 12:21:53',
            ),
        9 =>
            array(
                'mg_id' => '9',
                'mg_lid' => '26',
                'mg_name' => '定单双',
                'mg_description' => '选择开奖数字的单双',
                'mg_sort' => '100',
                'mg_update_time' => '2013-04-26 12:22:34',
            ),
        10 =>
            array(
                'mg_id' => '10',
                'mg_lid' => '26',
                'mg_name' => '猜中位',
                'mg_description' => '由大到小重新排列后的中间数字',
                'mg_sort' => '100',
                'mg_update_time' => '2013-04-26 12:23:30',
            ),
        12 =>
            array(
                'mg_id' => '12',
                'mg_lid' => '26',
                'mg_name' => '前二',
                'mg_description' => '前面二个数字游戏',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        13 =>
            array(
                'mg_id' => '13',
                'mg_lid' => '2',
                'mg_name' => '一星',
                'mg_description' => '个位数字',
                'mg_sort' => '5',
                'mg_update_time' => '2015-08-26 21:18:01',
            ),
        14 =>
            array(
                'mg_id' => '14',
                'mg_lid' => '2',
                'mg_name' => '前三',
                'mg_description' => '万位，千位和百位数字',
                'mg_sort' => '7',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        15 =>
            array(
                'mg_id' => '15',
                'mg_lid' => '2',
                'mg_name' => '前二',
                'mg_description' => '万位与千位数字',
                'mg_sort' => '8',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        16 =>
            array(
                'mg_id' => '16',
                'mg_lid' => '2',
                'mg_name' => '五星',
                'mg_description' => '万位，千位，百位，十位和个位数字',
                'mg_sort' => '1',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        26 =>
            array(
                'mg_id' => '26',
                'mg_lid' => '2',
                'mg_name' => '四星',
                'mg_description' => '四星',
                'mg_sort' => '2',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        27 =>
            array(
                'mg_id' => '27',
                'mg_lid' => '2',
                'mg_name' => '中三',
                'mg_description' => '千位，百位，十位 三个数',
                'mg_sort' => '6',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        29 =>
            array(
                'mg_id' => '29',
                'mg_lid' => '8',
                'mg_name' => '一星',
                'mg_description' => '个位数字',
                'mg_sort' => '5',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        30 =>
            array(
                'mg_id' => '30',
                'mg_lid' => '8',
                'mg_name' => '二星',
                'mg_description' => '十位与和个位数字',
                'mg_sort' => '4',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        31 =>
            array(
                'mg_id' => '31',
                'mg_lid' => '8',
                'mg_name' => '三星',
                'mg_description' => '百位，十位与个位数字',
                'mg_sort' => '3',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        33 =>
            array(
                'mg_id' => '33',
                'mg_lid' => '8',
                'mg_name' => '前二',
                'mg_description' => '万位与千位数字',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        34 =>
            array(
                'mg_id' => '34',
                'mg_lid' => '8',
                'mg_name' => '前三',
                'mg_description' => '万位，千位和百位数字',
                'mg_sort' => '7',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        35 =>
            array(
                'mg_id' => '35',
                'mg_lid' => '8',
                'mg_name' => '中三',
                'mg_description' => '千位，百位，十位 三个数',
                'mg_sort' => '6',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        36 =>
            array(
                'mg_id' => '36',
                'mg_lid' => '8',
                'mg_name' => '四星',
                'mg_description' => '四星',
                'mg_sort' => '2',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        38 =>
            array(
                'mg_id' => '38',
                'mg_lid' => '8',
                'mg_name' => '三星不定位',
                'mg_description' => '对应数字相同，与位置无关',
                'mg_sort' => '10',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        39 =>
            array(
                'mg_id' => '39',
                'mg_lid' => '8',
                'mg_name' => '大小单双',
                'mg_description' => '大小单双',
                'mg_sort' => '11',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        40 =>
            array(
                'mg_id' => '40',
                'mg_lid' => '8',
                'mg_name' => '五星',
                'mg_description' => '万位，千位，百位，十位和个位数字',
                'mg_sort' => '1',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        48 =>
            array(
                'mg_id' => '48',
                'mg_lid' => '27',
                'mg_name' => '前三',
                'mg_description' => '前面三个数游戏',
                'mg_sort' => '7',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        49 =>
            array(
                'mg_id' => '49',
                'mg_lid' => '27',
                'mg_name' => '前二',
                'mg_description' => '前面二个数字游戏',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        50 =>
            array(
                'mg_id' => '50',
                'mg_lid' => '27',
                'mg_name' => '任选',
                'mg_description' => '在01-11数字中任意选择一个或多个数',
                'mg_sort' => '9',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        51 =>
            array(
                'mg_id' => '51',
                'mg_lid' => '27',
                'mg_name' => '三星不定位',
                'mg_description' => '选择任意数字进行投注',
                'mg_sort' => '10',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        52 =>
            array(
                'mg_id' => '52',
                'mg_lid' => '27',
                'mg_name' => '定位胆',
                'mg_description' => '选择数字必须与开数字位置一致，数字相同',
                'mg_sort' => '100',
                'mg_update_time' => '2013-12-16 12:13:51',
            ),
        53 =>
            array(
                'mg_id' => '53',
                'mg_lid' => '27',
                'mg_name' => '定单双',
                'mg_description' => '选择开奖数字的单双',
                'mg_sort' => '100',
                'mg_update_time' => '2013-12-16 12:13:51',
            ),
        54 =>
            array(
                'mg_id' => '54',
                'mg_lid' => '27',
                'mg_name' => '猜中位',
                'mg_description' => '由大到小重新排列后的中间数字',
                'mg_sort' => '100',
                'mg_update_time' => '2013-12-16 12:13:51',
            ),
        55 =>
            array(
                'mg_id' => '55',
                'mg_lid' => '24',
                'mg_name' => '前三',
                'mg_description' => '前面三个数游戏',
                'mg_sort' => '7',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        56 =>
            array(
                'mg_id' => '56',
                'mg_lid' => '24',
                'mg_name' => '前二',
                'mg_description' => '前面二个数字游戏',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        57 =>
            array(
                'mg_id' => '57',
                'mg_lid' => '24',
                'mg_name' => '任选',
                'mg_description' => '在01-11数字中任意选择一个或多个数',
                'mg_sort' => '9',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        58 =>
            array(
                'mg_id' => '58',
                'mg_lid' => '24',
                'mg_name' => '三星不定位',
                'mg_description' => '选择任意数字进行投注',
                'mg_sort' => '10',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        59 =>
            array(
                'mg_id' => '59',
                'mg_lid' => '24',
                'mg_name' => '定位胆',
                'mg_description' => '选择数字必须与开数字位置一致，数字相同',
                'mg_sort' => '100',
                'mg_update_time' => '2013-12-17 11:24:11',
            ),
        60 =>
            array(
                'mg_id' => '60',
                'mg_lid' => '24',
                'mg_name' => '定单双',
                'mg_description' => '选择开奖数字的单双',
                'mg_sort' => '100',
                'mg_update_time' => '2013-12-17 11:24:11',
            ),
        61 =>
            array(
                'mg_id' => '61',
                'mg_lid' => '24',
                'mg_name' => '猜中位',
                'mg_description' => '由大到小重新排列后的中间数字',
                'mg_sort' => '100',
                'mg_update_time' => '2013-12-17 11:24:11',
            ),
        62 =>
            array(
                'mg_id' => '62',
                'mg_lid' => '14',
                'mg_name' => '三星',
                'mg_description' => '百位，十位与个位数字',
                'mg_sort' => '3',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        63 =>
            array(
                'mg_id' => '63',
                'mg_lid' => '14',
                'mg_name' => '二星',
                'mg_description' => '十位与和个位数字',
                'mg_sort' => '4',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        64 =>
            array(
                'mg_id' => '64',
                'mg_lid' => '14',
                'mg_name' => '三星不定位',
                'mg_description' => '对应数字相同，与位置无关',
                'mg_sort' => '10',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        65 =>
            array(
                'mg_id' => '65',
                'mg_lid' => '14',
                'mg_name' => '大小单双',
                'mg_description' => '',
                'mg_sort' => '11',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        67 =>
            array(
                'mg_id' => '67',
                'mg_lid' => '14',
                'mg_name' => '一星',
                'mg_description' => '个位数字',
                'mg_sort' => '5',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        68 =>
            array(
                'mg_id' => '68',
                'mg_lid' => '14',
                'mg_name' => '前三',
                'mg_description' => '万位，千位和百位数字',
                'mg_sort' => '7',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        69 =>
            array(
                'mg_id' => '69',
                'mg_lid' => '14',
                'mg_name' => '前二',
                'mg_description' => '万位与千位数字',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        70 =>
            array(
                'mg_id' => '70',
                'mg_lid' => '14',
                'mg_name' => '五星',
                'mg_description' => '万位，千位，百位，十位和个位数字',
                'mg_sort' => '1',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        71 =>
            array(
                'mg_id' => '71',
                'mg_lid' => '14',
                'mg_name' => '四星',
                'mg_description' => '四星',
                'mg_sort' => '2',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        72 =>
            array(
                'mg_id' => '72',
                'mg_lid' => '14',
                'mg_name' => '中三',
                'mg_description' => '千位，百位，十位 三个数',
                'mg_sort' => '6',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        73 =>
            array(
                'mg_id' => '73',
                'mg_lid' => '28',
                'mg_name' => '直选',
                'mg_description' => '直选',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-26 17:37:38',
            ),
        74 =>
            array(
                'mg_id' => '74',
                'mg_lid' => '28',
                'mg_name' => '组选',
                'mg_description' => '组选',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-26 17:38:50',
            ),
        75 =>
            array(
                'mg_id' => '75',
                'mg_lid' => '28',
                'mg_name' => '不定位',
                'mg_description' => '不定位',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-26 17:39:30',
            ),
        76 =>
            array(
                'mg_id' => '76',
                'mg_lid' => '28',
                'mg_name' => '前二',
                'mg_description' => '前二',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        77 =>
            array(
                'mg_id' => '77',
                'mg_lid' => '28',
                'mg_name' => '二星',
                'mg_description' => '后二',
                'mg_sort' => '4',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        78 =>
            array(
                'mg_id' => '78',
                'mg_lid' => '28',
                'mg_name' => '大小单双',
                'mg_description' => '大小单双',
                'mg_sort' => '11',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        79 =>
            array(
                'mg_id' => '79',
                'mg_lid' => '28',
                'mg_name' => '定位胆',
                'mg_description' => '定位胆',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-26 17:40:26',
            ),
        80 =>
            array(
                'mg_id' => '80',
                'mg_lid' => '29',
                'mg_name' => 'P3直选',
                'mg_description' => '万千百三位',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-27 18:11:14',
            ),
        81 =>
            array(
                'mg_id' => '81',
                'mg_lid' => '29',
                'mg_name' => 'P3组选',
                'mg_description' => '万千百三位',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-27 18:11:39',
            ),
        82 =>
            array(
                'mg_id' => '82',
                'mg_lid' => '29',
                'mg_name' => 'P3不定位',
                'mg_description' => 'P3不定位',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-27 18:12:10',
            ),
        83 =>
            array(
                'mg_id' => '83',
                'mg_lid' => '29',
                'mg_name' => '前二',
                'mg_description' => '前二',
                'mg_sort' => '8',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        84 =>
            array(
                'mg_id' => '84',
                'mg_lid' => '29',
                'mg_name' => '二星',
                'mg_description' => '后二',
                'mg_sort' => '4',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        85 =>
            array(
                'mg_id' => '85',
                'mg_lid' => '29',
                'mg_name' => '大小单双',
                'mg_description' => '大小单双',
                'mg_sort' => '11',
                'mg_update_time' => '2015-09-04 14:06:26',
            ),
        86 =>
            array(
                'mg_id' => '86',
                'mg_lid' => '29',
                'mg_name' => '定位胆',
                'mg_description' => '定位胆',
                'mg_sort' => '100',
                'mg_update_time' => '2014-03-27 18:14:12',
            ),
        118 =>
            array(
                'mg_id' => '118',
                'mg_lid' => '9',
                'mg_name' => '和值',
                'mg_description' => '和值',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:30:19',
            ),
        119 =>
            array(
                'mg_id' => '119',
                'mg_lid' => '9',
                'mg_name' => '二同号单选',
                'mg_description' => '二同号单选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:30:27',
            ),
        120 =>
            array(
                'mg_id' => '120',
                'mg_lid' => '9',
                'mg_name' => '二同号复选',
                'mg_description' => '二同号复选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:30:35',
            ),
        121 =>
            array(
                'mg_id' => '121',
                'mg_lid' => '9',
                'mg_name' => '二不同号',
                'mg_description' => '二不同号',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:30:46',
            ),
        122 =>
            array(
                'mg_id' => '122',
                'mg_lid' => '9',
                'mg_name' => '三同号单选',
                'mg_description' => '三同号单选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:30:54',
            ),
        123 =>
            array(
                'mg_id' => '123',
                'mg_lid' => '9',
                'mg_name' => '三同号通选',
                'mg_description' => '三同号通选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:31:03',
            ),
        124 =>
            array(
                'mg_id' => '124',
                'mg_lid' => '9',
                'mg_name' => '三不同号',
                'mg_description' => '三不同号',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:31:11',
            ),
        125 =>
            array(
                'mg_id' => '125',
                'mg_lid' => '9',
                'mg_name' => '三连号通选',
                'mg_description' => '三连号通选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 17:31:17',
            ),
        134 =>
            array(
                'mg_id' => '134',
                'mg_lid' => '2',
                'mg_name' => '任选',
                'mg_description' => '任选',
                'mg_sort' => '9',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        146 =>
            array(
                'mg_id' => '146',
                'mg_lid' => '6',
                'mg_name' => '猜冠军',
                'mg_description' => '猜冠军',
                'mg_sort' => '1',
                'mg_update_time' => '2015-08-31 09:22:41',
            ),
        147 =>
            array(
                'mg_id' => '147',
                'mg_lid' => '6',
                'mg_name' => '猜冠亚军',
                'mg_description' => '猜冠亚军',
                'mg_sort' => '2',
                'mg_update_time' => '2015-08-31 09:22:55',
            ),
        148 =>
            array(
                'mg_id' => '148',
                'mg_lid' => '6',
                'mg_name' => '猜前三名',
                'mg_description' => '猜前三名',
                'mg_sort' => '3',
                'mg_update_time' => '2015-08-31 09:23:11',
            ),
        149 =>
            array(
                'mg_id' => '149',
                'mg_lid' => '6',
                'mg_name' => '猜前四名',
                'mg_description' => '猜前四名',
                'mg_sort' => '4',
                'mg_update_time' => '2015-08-31 09:23:23',
            ),
        150 =>
            array(
                'mg_id' => '150',
                'mg_lid' => '6',
                'mg_name' => '猜前五名',
                'mg_description' => '猜前五名',
                'mg_sort' => '5',
                'mg_update_time' => '2015-08-31 09:24:17',
            ),
        151 =>
            array(
                'mg_id' => '151',
                'mg_lid' => '6',
                'mg_name' => '猜前六名',
                'mg_description' => '猜前六名',
                'mg_sort' => '6',
                'mg_update_time' => '2015-08-31 09:24:01',
            ),
        152 =>
            array(
                'mg_id' => '152',
                'mg_lid' => '6',
                'mg_name' => '猜前七名',
                'mg_description' => '猜前七名',
                'mg_sort' => '7',
                'mg_update_time' => '2015-08-31 09:24:27',
            ),
        153 =>
            array(
                'mg_id' => '153',
                'mg_lid' => '6',
                'mg_name' => '猜前八名',
                'mg_description' => '猜前八名',
                'mg_sort' => '8',
                'mg_update_time' => '2015-08-31 09:25:14',
            ),
        154 =>
            array(
                'mg_id' => '154',
                'mg_lid' => '6',
                'mg_name' => '猜前九名',
                'mg_description' => '猜前九名',
                'mg_sort' => '9',
                'mg_update_time' => '2015-08-31 09:25:14',
            ),
        155 =>
            array(
                'mg_id' => '155',
                'mg_lid' => '6',
                'mg_name' => '猜前十名',
                'mg_description' => '猜前十名',
                'mg_sort' => '10',
                'mg_update_time' => '2015-08-31 09:25:06',
            ),
        157 =>
            array(
                'mg_id' => '157',
                'mg_lid' => '14',
                'mg_name' => '任选',
                'mg_description' => '任选',
                'mg_sort' => '9',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        158 =>
            array(
                'mg_id' => '158',
                'mg_lid' => '8',
                'mg_name' => '任选',
                'mg_description' => '任选',
                'mg_sort' => '9',
                'mg_update_time' => '2015-08-26 21:17:32',
            ),
        160 =>
            array(
                'mg_id' => '160',
                'mg_lid' => '30',
                'mg_name' => '和值',
                'mg_description' => '和值',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:30:19',
            ),
        161 =>
            array(
                'mg_id' => '161',
                'mg_lid' => '30',
                'mg_name' => '二同号单选',
                'mg_description' => '二同号单选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:30:27',
            ),
        162 =>
            array(
                'mg_id' => '162',
                'mg_lid' => '30',
                'mg_name' => '二同号复选',
                'mg_description' => '二同号复选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:30:35',
            ),
        163 =>
            array(
                'mg_id' => '163',
                'mg_lid' => '30',
                'mg_name' => '二不同号',
                'mg_description' => '二不同号',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:30:46',
            ),
        164 =>
            array(
                'mg_id' => '164',
                'mg_lid' => '30',
                'mg_name' => '三同号单选',
                'mg_description' => '三同号单选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:30:54',
            ),
        165 =>
            array(
                'mg_id' => '165',
                'mg_lid' => '30',
                'mg_name' => '三同号通选',
                'mg_description' => '三同号通选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:31:03',
            ),
        166 =>
            array(
                'mg_id' => '166',
                'mg_lid' => '30',
                'mg_name' => '三不同号',
                'mg_description' => '三不同号',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:31:11',
            ),
        167 =>
            array(
                'mg_id' => '167',
                'mg_lid' => '30',
                'mg_name' => '三连号通选',
                'mg_description' => '三连号通选',
                'mg_sort' => '100',
                'mg_update_time' => '2015-03-26 09:31:17',
            ),
    );

    /**
     * 根据彩种获取玩法组
     */
    public function getMethodGroups($mg_lid = 1)
    {
        $arr = [];
        foreach ($this->method_groups as $v){
            if($v['mg_lid'] == $mg_lid){
                $arr[] = $v;
            }
        }
        return  $arr;
    }

    /**
     * 玩法详情
     */
    public function getMethodGroupsDetail($mg_id)
    {
        $list = $this->method_groups;
        if(empty($list[$mg_id])){
            return [];
        }
        return $list[$mg_id];
    }

}