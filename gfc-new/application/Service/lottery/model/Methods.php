<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/30
 * Time: 19:20  使用程序里面写好的方法详情
 */

namespace app\Service\lottery\model;

use think\image\Exception;
use think\Model;

class Methods extends Model
{
    /**
     * 玩法列表
     * @var array
     */
    public $method_list =
        array (
            1 =>
                array (
                    'm_id' => '1',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXZX',
                    'm_cname' => '三星直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择后三个数，开奖号码后三码相同且顺序一致即为中奖。投注三码(例：03、06、08)，开奖号码**368，与开奖号码后三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '10',
                    'm_flock' => '5000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            2 =>
                array (
                    'm_id' => '2',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXZS',
                    'm_cname' => '三星组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中有对子并且对应的三位号码有任意两位，即为中奖。投注两码(例：03、06)，开奖号码**336、**633、**663、**366等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '20',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            3 =>
                array (
                    'm_id' => '3',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXZL',
                    'm_cname' => '三星组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中对应的三位号码各不相同，即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**863、**836，与开奖号码后三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            4 =>
                array (
                    'm_id' => '4',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXLX',
                    'm_cname' => '三星连选',
                    'm_team' => '直选',
                    'm_description' => '对百位，十位，个位选择投注后，有个位，十位个位，百位十位个位，三种组合（类似后一直选+后二直选+后三直选）。开奖之后，投注号码与开奖号码相同且顺序一致则为中奖。投注三码(例：04、06、07)， 开奖号码**467，与开奖号码相同且顺序需一致，即中1等奖。开奖号码***67，与开奖号码相同且顺序需一致，即中2等奖。开奖号码****7，与开奖号码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            5 =>
                array (
                    'm_id' => '5',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXBD',
                    'm_cname' => '三星包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。豹子按直选派奖，组三态按组三派奖，组六态按组六派奖。投注一码(例：03)，开奖111按直选派奖，003,300,030按组三派奖，012,102,201按组六派奖。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '三星包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            6 =>
                array (
                    'm_id' => '6',
                    'm_lid' => '2',
                    'm_mg_id' => '3',
                    'm_name' => 'YMBDW',
                    'm_cname' => '三星一码不定位',
                    'm_team' => '',
                    'm_description' => '投注1个号码,在百位，十位和个位的位置上3个开奖号码包含所选号码，不限位置,即为中奖。投注一码(例：06)，开奖号码**6**、***6*、****6，与开奖号码后三码中任一码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '271',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆码',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            7 =>
                array (
                    'm_id' => '7',
                    'm_lid' => '2',
                    'm_mg_id' => '3',
                    'm_name' => 'EMBDW',
                    'm_cname' => '三星二码不定位',
                    'm_team' => '',
                    'm_description' => '投注2个号码,在百位，十位和个位的位置上3个开奖号码包含2个所选号码，不限位置,即为中奖。投注两码(例：04、07)，开奖号码***47、**47*、**4*7、**7*4、**74*、***74，与开奖号码后三码中任两码相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '54',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆一',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆二',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            8 =>
                array (
                    'm_id' => '8',
                    'm_lid' => '2',
                    'm_mg_id' => '4',
                    'm_name' => 'EXDXDS',
                    'm_cname' => '二星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜十位和个位的大、小、单、双。01234为小，56789为大。如：投注双大，开奖号码为21385,十位为双，个位为大，即为中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            9 =>
                array (
                    'm_id' => '9',
                    'm_lid' => '2',
                    'm_mg_id' => '4',
                    'm_name' => 'SXDXDS',
                    'm_cname' => '三星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜百位、十位和个位的大、小、单、双。0-4为小，5-9为大。如：投注小、双、大，开奖号码为21385,百位小,十位双，个位大，即为中奖。小(0-4)、单(奇数)、双(偶数)',
                    'm_max_comb' => '64',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '125',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '百位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            3 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            10 =>
                array (
                    'm_id' => '10',
                    'm_lid' => '26',
                    'm_mg_id' => '5',
                    'm_name' => 'SDQSZX',
                    'm_cname' => '前三直选',
                    'm_team' => '',
                    'm_description' => '选3个号码与开奖的前3个号码相同且顺序一致，即中奖。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '990',
                    'm_max_money' => '1980',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            11 =>
                array (
                    'm_id' => '11',
                    'm_lid' => '26',
                    'm_mg_id' => '5',
                    'm_name' => 'SDQSZUX',
                    'm_cname' => '前三组选',
                    'm_team' => '',
                    'm_description' => '选3个号码与开奖的前3个号码相同，即中奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中奖。',
                    'm_max_comb' => '990',
                    'm_max_money' => '1980',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前三组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            12 =>
                array (
                    'm_id' => '12',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX1',
                    'm_cname' => '任选一中一',
                    'm_team' => '',
                    'm_description' => '投注的1个号码与当期开奖的5个号码中的任1号码相同，即中奖。如投注01，开奖号码包含01，与开奖号码任一码相同，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '5',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选一',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            13 =>
                array (
                    'm_id' => '13',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX2',
                    'm_cname' => '任选二中二',
                    'm_team' => '',
                    'm_description' => '投注的2个号码与当期开奖的5个号码中的任2个号码相同，即中奖。如投注01、02，开奖号码包含01,02，与开奖号码任两码相同，顺序不限，即中奖。',
                    'm_max_comb' => '55',
                    'm_max_money' => '110',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选二',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            14 =>
                array (
                    'm_id' => '14',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX3',
                    'm_cname' => '任选三中三',
                    'm_team' => '',
                    'm_description' => '投注的3个号码与当期开奖的5个号码中的任3个号码相同，即中奖。如投注01、02、03，开奖号码包含01,02,03，与开奖号码任三码相同，顺序不限,即中奖。',
                    'm_max_comb' => '165',
                    'm_max_money' => '330',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            15 =>
                array (
                    'm_id' => '15',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX4',
                    'm_cname' => '任选四中四',
                    'm_team' => '',
                    'm_description' => '投注的4个号码与当期开奖的5个号码中的任4个号码相同，即中奖。如投注01、02、03、04，开奖号码包含01,02,03,04，与开奖号码任四码相同，顺序不限,即中奖。',
                    'm_max_comb' => '330',
                    'm_max_money' => '660',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '5',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选四',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            16 =>
                array (
                    'm_id' => '16',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX5',
                    'm_cname' => '任选五中五',
                    'm_team' => '',
                    'm_description' => '投注的5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选五',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            17 =>
                array (
                    'm_id' => '17',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX6',
                    'm_cname' => '任选六中五',
                    'm_team' => '',
                    'm_description' => '投注的6个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            18 =>
                array (
                    'm_id' => '18',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX7',
                    'm_cname' => '任选七中五',
                    'm_team' => '',
                    'm_description' => '投注的7个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '21',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选七',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            19 =>
                array (
                    'm_id' => '19',
                    'm_lid' => '26',
                    'm_mg_id' => '6',
                    'm_name' => 'SDRX8',
                    'm_cname' => '任选八中五',
                    'm_team' => '',
                    'm_description' => '投注的8个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*、*、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '56',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选八',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            20 =>
                array (
                    'm_id' => '20',
                    'm_lid' => '26',
                    'm_mg_id' => '7',
                    'm_name' => 'SDQSBDW',
                    'm_cname' => '前三不定位胆',
                    'm_team' => '',
                    'm_description' => '投注的号码包含在开奖号码的第一，二，三位内，即中奖，奖金是定位胆的1/3。投注一码(例：01)，开奖号码前三码任一码为01，即中奖。投注两码(例：01、02)，开奖号码12***、*12**、1*2**、21***、*21**、2*1**，与开奖号码前三码任两码相同，即中奖。投注三码(例：03、01、02)，开奖号码123**、132**、231**、213**、312**、321**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            21 =>
                array (
                    'm_id' => '21',
                    'm_lid' => '26',
                    'm_mg_id' => '8',
                    'm_name' => 'SDQSDWD',
                    'm_cname' => '前三定位胆',
                    'm_team' => '',
                    'm_description' => '从第一，二，三位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致即中奖。投注一码(例：万位01)，开奖号码1****，与开奖号码前三码任一码相同且位置一致，即中奖。投注两码(例：万位01、千位02)，开奖号码12***，与开奖号码前三码中任两码相同且位置一致，即中奖。投注三码(例：万位01、千位02、百位03)，开奖号码123**，与开奖号码前三码相同且位置一致，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第一位',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第二位',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第三位',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            24 =>
                array (
                    'm_id' => '24',
                    'm_lid' => '26',
                    'm_mg_id' => '9',
                    'm_name' => 'SDDDS',
                    'm_cname' => '定单双',
                    'm_team' => '',
                    'm_description' => '投注组合与开奖的单双个数一致，即为中奖，从1等奖到6等奖分别是：0单5双,5单0双,1单4双,4单1双,2单3双,3单2双。投注两单三双，开奖号码86345，与开奖号码单双数量相同，即中奖。奖金分为：0单5双(奖金873.18)，5单0双(奖金145.53)，1单4双(奖金29.11)，4单1双(奖金11.64)，2单3双(奖金5.82)，3单2双(奖金4.37)。',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '6',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0单5双 1单4双 2单3双 3单2双 4单1双 5单0双',
                                    'max_selected' => '1',
                                    'prompt' => '定单双',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            25 =>
                array (
                    'm_id' => '25',
                    'm_lid' => '26',
                    'm_mg_id' => '10',
                    'm_name' => 'SDCZW',
                    'm_cname' => '猜中位',
                    'm_team' => '',
                    'm_description' => '开奖号码按照大小顺序排列后第三个号码包含在所投注的号码中，即为中奖。投注一码（例：05)，开奖号码86345，依开奖号码小到大排序第三码相同，即中奖。若投注03，为不中奖.开奖03,09时为一等奖,04,08时为二等奖,05,07时为三等奖,开奖06为四等奖。',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '03 04 05 06 07 08 09',
                                    'max_selected' => '1',
                                    'prompt' => '猜中位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            26 =>
                array (
                    'm_id' => '26',
                    'm_lid' => '2',
                    'm_mg_id' => '2',
                    'm_name' => 'EXZX',
                    'm_cname' => '二星直选',
                    'm_team' => '直选',
                    'm_description' => '投注号码与当期中奖号码的后两位号码相同并顺序一致，即中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '1000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            27 =>
                array (
                    'm_id' => '27',
                    'm_lid' => '2',
                    'm_mg_id' => '2',
                    'm_name' => 'EXZUX',
                    'm_cname' => '二星组选',
                    'm_team' => '组选',
                    'm_description' => '对十位和个位进行投注，所选号码与开奖号码后两位一致，顺序不限，即为中奖投注两码(例：06、08)，开奖号码***68、***86，与开奖号码后两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '3000000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            28 =>
                array (
                    'm_id' => '28',
                    'm_lid' => '2',
                    'm_mg_id' => '2',
                    'm_name' => 'EXLX',
                    'm_cname' => '二星连选',
                    'm_team' => '直选',
                    'm_description' => '对十位，个位选择投注，有十位个位、个位两种组合。开奖后，投注号码与开奖号码相同且顺序一致则为中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且位置一致，即中1等奖。开奖号码****8，与开奖号码后一码相同，即中2等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            29 =>
                array (
                    'm_id' => '29',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXHZ',
                    'm_cname' => '三星和值',
                    'm_team' => '和值',
                    'm_description' => '后三位之和与所投号码相同即中奖。投注一码(例：2)，开奖号码**002、**020、**200、**110、**101、**011，与开奖号码后三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '三星和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            30 =>
                array (
                    'm_id' => '30',
                    'm_lid' => '2',
                    'm_mg_id' => '2',
                    'm_name' => 'EXHZ',
                    'm_cname' => '二星和值',
                    'm_team' => '和值',
                    'm_description' => '后两位之和 与所投号码相同即中奖。投注一码(例：14)，开奖号码***68，与开奖号码后两码和值相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '二星和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            31 =>
                array (
                    'm_id' => '31',
                    'm_lid' => '26',
                    'm_mg_id' => '12',
                    'm_name' => 'SDQEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '',
                    'm_description' => '选2个号码与开奖的前2个号码相同且顺序一致，即中奖。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '110',
                    'm_max_money' => '220',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            32 =>
                array (
                    'm_id' => '32',
                    'm_lid' => '26',
                    'm_mg_id' => '12',
                    'm_name' => 'SDQEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '',
                    'm_description' => '选2个号码与开奖的前2个号码相同，即中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '110',
                    'm_max_money' => '220',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            33 =>
                array (
                    'm_id' => '33',
                    'm_lid' => '2',
                    'm_mg_id' => '13',
                    'm_name' => 'YXZX',
                    'm_cname' => '一星直选',
                    'm_team' => '直选',
                    'm_description' => '从个位选择一个或多个数字进行投注，与开奖号码一致即为中奖。投注一码(例：08)，开奖号码****8，与开奖号码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            34 =>
                array (
                    'm_id' => '34',
                    'm_lid' => '2',
                    'm_mg_id' => '2',
                    'm_name' => 'EXBD',
                    'm_cname' => '二星包点',
                    'm_team' => '和值',
                    'm_description' => '选择1个或多个和值点投注，中奖号码为对子为一等奖，非对子为二等奖。投注一码(例：14)，开奖号码***68，与开奖号码后两码和值相等，即中奖。中奖号码为对子为一等奖（奖金195.00），非对子为二等奖（奖金97.50）。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '对子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '非对子',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '二星包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            35 =>
                array (
                    'm_id' => '35',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSZX',
                    'm_cname' => '前三直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，且顺序对应一致。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序需一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            36 =>
                array (
                    'm_id' => '36',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSZS',
                    'm_cname' => '前三组三',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码有两位相同。投注两码(例：03、06)，开奖号码336**、363**、366**、633**、663**、636**等，与开奖号码前三码中任两码相同，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            37 =>
                array (
                    'm_id' => '37',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSZL',
                    'm_cname' => '前三组六',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码各不相同。如：投注三码(例：03、06、08)，开奖号码368**、386**、836**、863**、638**、683**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            38 =>
                array (
                    'm_id' => '38',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSLX',
                    'm_cname' => '前三连选',
                    'm_team' => '直选',
                    'm_description' => '对万位，千位，百位选择投注后，则有万位千位百位，千位百位，百位三个中奖机会。投注三码(例：00、03、04)，开奖号码034**，与开奖号码前三码相同且顺序需一致，即中1等奖。开奖号码*34**，与开奖号码前三码相同且顺序需一致，即中2等奖。开奖号码**4**，与开奖号码前三码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            39 =>
                array (
                    'm_id' => '39',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSBD',
                    'm_cname' => '前三包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。豹子按直选派奖(1等奖)，组三态按组三派奖(2等奖)，组六态按组六派奖(3等奖)。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '前三包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            40 =>
                array (
                    'm_id' => '40',
                    'm_lid' => '2',
                    'm_mg_id' => '15',
                    'm_name' => 'QEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前两码，即万位和千位，且顺序一致。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            41 =>
                array (
                    'm_id' => '41',
                    'm_lid' => '2',
                    'm_mg_id' => '15',
                    'm_name' => 'QEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '组选',
                    'm_description' => '竞猜前两码，即万位和千位，顺序不限。开对子不中奖。如：投注前二组选12,开奖号码为21385,前二号码为21,有12，即为中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            42 =>
                array (
                    'm_id' => '42',
                    'm_lid' => '2',
                    'm_mg_id' => '15',
                    'm_name' => 'QELX',
                    'm_cname' => '前二连选',
                    'm_team' => '直选',
                    'm_description' => '从万位和千位选择1个或多个号码，2个号码均正确为一等奖，仅千位正确为二等奖。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中1等奖。开奖号码*3***，与开奖号码前两码相同且顺序一致，即中2等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            43 =>
                array (
                    'm_id' => '43',
                    'm_lid' => '2',
                    'm_mg_id' => '15',
                    'm_name' => 'QEBD',
                    'm_cname' => '前二包点',
                    'm_team' => '和值',
                    'm_description' => '选择1个或多个和值点投注，中奖号码为对子为一等奖，非对子为二等奖。投注一码(例：2)，开奖号码11***、02***、20***，与开奖号码前两码总和值相同，即中奖。中奖号码为对子为一等奖，非对子为二等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '对子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '非对子',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '18',
                                    'prompt' => '前二包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            44 =>
                array (
                    'm_id' => '44',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSHZ',
                    'm_cname' => '前三和值',
                    'm_team' => '和值',
                    'm_description' => '竞猜前三码和值，即万千百位和。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '前三和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            45 =>
                array (
                    'm_id' => '45',
                    'm_lid' => '2',
                    'm_mg_id' => '15',
                    'm_name' => 'QEHZ',
                    'm_cname' => '前二和值',
                    'm_team' => '和值',
                    'm_description' => '万位千位之和，按排列全展开，和直选奖金相同。投注一码(例：03)，开奖号码03***、30***、12***、21***，与开奖号码前两码总和值相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '前二和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            46 =>
                array (
                    'm_id' => '46',
                    'm_lid' => '2',
                    'm_mg_id' => '16',
                    'm_name' => 'WXZX',
                    'm_cname' => '五星直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜全部5位号码，即万位、千位、百位、十位和个位，且顺序一致。如选号12345,开奖12345,全部相同对应且顺序一致,即中奖。',
                    'm_max_comb' => '100000',
                    'm_max_money' => '200000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '500000.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            47 =>
                array (
                    'm_id' => '47',
                    'm_lid' => '2',
                    'm_mg_id' => '16',
                    'm_name' => 'WXLX',
                    'm_cname' => '五星连选',
                    'm_team' => '直选',
                    'm_description' => '万千百十个位分别选择每位的1个或多个号码投注，有4次中奖机会（五星+后三+后二+后一）。投注五码(例：00、03、04、06、07)，开奖号码03467，与开奖号码相同且顺序需一致，即中1等奖。 开奖号码**467，与开奖号码后三位相同且顺序需一致，即中2等奖。开奖号码***67，与开奖号码后两位相同且顺序需一致，即中3等奖。开奖号码****7，与开奖号码个位相同且顺序需一致，即中4等奖。',
                    'm_max_comb' => '100000',
                    'm_max_money' => '200000',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            48 =>
                array (
                    'm_id' => '48',
                    'm_lid' => '2',
                    'm_mg_id' => '134',
                    'm_name' => 'WXDW',
                    'm_cname' => '任选一',
                    'm_team' => '任一',
                    'm_description' => '从万、千、百、十、个位任意一位中选1个或多个号码，号码与当期中奖号码的位置与号码相符，即中奖。投注一码(例：百位04)，开奖号码**4**，与开奖号码相同且位置一致，即中奖。万、千、百、十、个位中奖分别为1~5等奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '5',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            79 =>
                array (
                    'm_id' => '79',
                    'm_lid' => '2',
                    'm_mg_id' => '26',
                    'm_name' => 'SIXZX',
                    'm_cname' => '后四直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜开奖号码后面四位,即千位、百位、十位和个位,且顺序一致。如投注号为后四直选 2345 开奖为 12345 ,后面四位2345相对应,即为中奖。',
                    'm_max_comb' => '10000',
                    'm_max_money' => '20000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            80 =>
                array (
                    'm_id' => '80',
                    'm_lid' => '2',
                    'm_mg_id' => '26',
                    'm_name' => 'QSIZX',
                    'm_cname' => '前四直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜开奖号码前四位,即万位、千位、百位、十位,且顺序一致。如投注号为前四直选 1234 开奖为 12345 ,前面四位1234相对应,即为中奖。',
                    'm_max_comb' => '10000',
                    'm_max_money' => '20000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            81 =>
                array (
                    'm_id' => '81',
                    'm_lid' => '2',
                    'm_mg_id' => '1',
                    'm_name' => 'SXHHZX',
                    'm_cname' => '三星混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入，组三号码按组三派奖，组六号码按组六派奖。投注112，开奖号码**112， **121， **211，即中一等奖。投注123,若开奖号码**123， **132，**213，**231，**312，**321，即中二等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            82 =>
                array (
                    'm_id' => '82',
                    'm_lid' => '2',
                    'm_mg_id' => '14',
                    'm_name' => 'QSHHZX',
                    'm_cname' => '前三混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码112**，121**，211**，即中1等奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            83 =>
                array (
                    'm_id' => '83',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSZX',
                    'm_cname' => '中三直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择中间三个数，位置和数字正确即为中奖。投注三码(例：03、06、08)，开奖号码*368*，与开奖号码中间三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            84 =>
                array (
                    'm_id' => '84',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSZS',
                    'm_cname' => '中三组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，即千位、百位，十位 顺序不限，且开奖号码中有对子，且对应的三位号码与投注号码相同，即为中奖。投注两码(例：03、06)，开奖号码*336*、*363*、*633*、*663*、*636*、*366*…等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            85 =>
                array (
                    'm_id' => '85',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSZL',
                    'm_cname' => '中三组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，即千位、百位，十位 顺序不限，且开奖号码中对应的三位号码各不相同。即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**836、**863，与开奖号码中间三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            86 =>
                array (
                    'm_id' => '86',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSLX',
                    'm_cname' => '中三连选',
                    'm_team' => '直选',
                    'm_description' => '对千位，百位，十位选择投注后，则有十位，百位十位，千位百位十位三个中奖机会。投注三码(例：00、04、03)，开奖号码*043*，与开奖号码中间三码相同且顺序需一致，即中1等奖。开奖号码**43*，与开奖号码中间三码相同且顺序需一致，即中2等奖。开奖号码***3*，与开奖号码中间三码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            87 =>
                array (
                    'm_id' => '87',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSBD',
                    'm_cname' => '中三包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。豹子按直选派奖，组三态按组三派奖，组六态按组六派奖。投注一码(例：2)，开奖号码*110*、*101*、*011*、*002*、*020*、*200*，与开奖号码中间三码总和值相同，即中奖。豹子按直选派奖(1等奖)，组三态按组三派奖(2等奖)，组六态按组六派奖(3等奖)。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '中三包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            88 =>
                array (
                    'm_id' => '88',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSHHZX',
                    'm_cname' => '中三混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码*112*，*121*，*211*，即中1等奖。投注123,若开奖号码*123*， *132*，*213*，*231*，*312*，*321*，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            89 =>
                array (
                    'm_id' => '89',
                    'm_lid' => '2',
                    'm_mg_id' => '27',
                    'm_name' => 'ZSHZ',
                    'm_cname' => '中三和值',
                    'm_team' => '和值',
                    'm_description' => '中三位之和，按排列全展开，和直选奖金相同。投注一码(例：2)，开奖号码*110*、*101*、*011*、*002*、*020*、*200*，与开奖号码中间三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '中三和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            97 =>
                array (
                    'm_id' => '97',
                    'm_lid' => '8',
                    'm_mg_id' => '29',
                    'm_name' => 'YXZX',
                    'm_cname' => '一星直选',
                    'm_team' => '直选',
                    'm_description' => '从个位选择一个或多个数字进行投注，与开奖号码一致即为中奖。投注一码(例：08)，开奖号码****8，与开奖号码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            98 =>
                array (
                    'm_id' => '98',
                    'm_lid' => '8',
                    'm_mg_id' => '158',
                    'm_name' => 'WXDW',
                    'm_cname' => '任选一',
                    'm_team' => '任一',
                    'm_description' => '从万、千、百、十、个位任意一位中选1个或多个号码，号码与当期中奖号码的位置与号码相符，即中奖。投注一码(例：百位04)，开奖号码**4**，与开奖号码相同且位置一致，即中奖。万、千、百、十、个位中奖分别为1~5等奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '5',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            99 =>
                array (
                    'm_id' => '99',
                    'm_lid' => '8',
                    'm_mg_id' => '30',
                    'm_name' => 'EXZX',
                    'm_cname' => '二星直选',
                    'm_team' => '直选',
                    'm_description' => '投注号码与当期中奖号码的后两位号码相同并顺序一致，即中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            100 =>
                array (
                    'm_id' => '100',
                    'm_lid' => '8',
                    'm_mg_id' => '30',
                    'm_name' => 'EXZUX',
                    'm_cname' => '二星组选',
                    'm_team' => '组选',
                    'm_description' => '对十位和个位进行投注，所选号码与开奖号码后两位一致，顺序不限，即为中奖投注两码(例：06、08)，开奖号码***68、***86，与开奖号码后两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '100',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            101 =>
                array (
                    'm_id' => '101',
                    'm_lid' => '8',
                    'm_mg_id' => '30',
                    'm_name' => 'EXLX',
                    'm_cname' => '二星连选',
                    'm_team' => '直选',
                    'm_description' => '对十位，个位选择投注，有十位个位、个位两种组合。开奖后，投注号码与开奖号码相同且顺序一致则为中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且位置一致，即中1等奖。开奖号码****8，与开奖号码后一码相同，即中2等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            102 =>
                array (
                    'm_id' => '102',
                    'm_lid' => '8',
                    'm_mg_id' => '30',
                    'm_name' => 'EXBD',
                    'm_cname' => '二星包点',
                    'm_team' => '和值',
                    'm_description' => '选择1个或多个和值点投注，中奖号码为对子为一等奖，非对子为二等奖。投注一码(例：14)，开奖号码***68，与开奖号码后两码和值相等，即中奖。中奖号码为对子为一等奖（奖金195.00），非对子为二等奖（奖金97.50）。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '对子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '非对子',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '二星包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            103 =>
                array (
                    'm_id' => '103',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXZX',
                    'm_cname' => '三星直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择后三个数，开奖号码后三码相同且顺序一致即为中奖。投注三码(例：03、06、08)，开奖号码**368，与开奖号码后三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '10',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            104 =>
                array (
                    'm_id' => '104',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXZS',
                    'm_cname' => '三星组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中有对子并且对应的三位号码有任意两位，即为中奖。投注两码(例：03、06)，开奖号码**336、**633、**663、**366等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '20',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            105 =>
                array (
                    'm_id' => '105',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXZL',
                    'm_cname' => '三星组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中对应的三位号码各不相同，即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**863、**836，与开奖号码后三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            106 =>
                array (
                    'm_id' => '106',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXLX',
                    'm_cname' => '三星连选',
                    'm_team' => '直选',
                    'm_description' => '对百位，十位，个位选择投注后，有个位，十位个位，百位十位个位，三种组合（类似后一直选+后二直选+后三直选）。开奖之后，投注号码与开奖号码相同且顺序一致则为中奖。投注三码(例：04、06、07)， 开奖号码**467，与开奖号码相同且顺序需一致，即中1等奖。开奖号码***67，与开奖号码相同且顺序需一致，即中2等奖。开奖号码****7，与开奖号码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            107 =>
                array (
                    'm_id' => '107',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXBD',
                    'm_cname' => '三星包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。豹子按直选派奖，组三态按组三派奖，组六态按组六派奖。投注一码(例：03)，开奖111按直选派奖，003,300,030按组三派奖，012,102,201等组六态按组六派奖。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '三星包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            108 =>
                array (
                    'm_id' => '108',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXHHZX',
                    'm_cname' => '三星混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入，组三号码按组三派奖，组六号码按组六派奖。投注112，开奖号码**112， **121， **211，即中一等奖。投注123,若开奖号码**123， **132，**213，**231，**312，**321，即中二等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            113 =>
                array (
                    'm_id' => '113',
                    'm_lid' => '8',
                    'm_mg_id' => '33',
                    'm_name' => 'QEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前两码，即万位和千位，且顺序一致。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            114 =>
                array (
                    'm_id' => '114',
                    'm_lid' => '8',
                    'm_mg_id' => '33',
                    'm_name' => 'QEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '组选',
                    'm_description' => '竞猜前两码，即万位和千位，顺序不限。开对子不中奖。如：投注前二组选12,开奖号码为21385,前二号码为21,有12，即为中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            115 =>
                array (
                    'm_id' => '115',
                    'm_lid' => '8',
                    'm_mg_id' => '33',
                    'm_name' => 'QELX',
                    'm_cname' => '前二连选',
                    'm_team' => '直选',
                    'm_description' => '从万位和千位选择1个或多个号码，2个号码均正确为一等奖，仅千位正确为二等奖。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中1等奖。开奖号码*3***，与开奖号码前两码相同且顺序一致，即中2等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            116 =>
                array (
                    'm_id' => '116',
                    'm_lid' => '8',
                    'm_mg_id' => '33',
                    'm_name' => 'QEBD',
                    'm_cname' => '前二包点',
                    'm_team' => '和值',
                    'm_description' => '选择1个或多个和值点投注，中奖号码为对子为一等奖，非对子为二等奖。投注一码(例：2)，开奖号码11***、02***、20***，与开奖号码前两码总和值相同，即中奖。中奖号码为对子为一等奖，非对子为二等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '对子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '非对子',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '18',
                                    'prompt' => '前二包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            117 =>
                array (
                    'm_id' => '117',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSZX',
                    'm_cname' => '前三直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，且顺序对应一致。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序需一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            118 =>
                array (
                    'm_id' => '118',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSZS',
                    'm_cname' => '前三组三',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码有两位相同。投注两码(例：03、06)，开奖号码336**、363**、366**、633**、663**、636**等，与开奖号码前三码中任两码相同，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            119 =>
                array (
                    'm_id' => '119',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSZL',
                    'm_cname' => '前三组六',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码各不相同。如：投注三码(例：03、06、08)，开奖号码368**、386**、836**、863**、638**、683**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            120 =>
                array (
                    'm_id' => '120',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSLX',
                    'm_cname' => '前三连选',
                    'm_team' => '直选',
                    'm_description' => '对万位，千位，百位选择投注后，则有万位千位百位，千位百位，百位三个中奖机会。投注三码(例：00、03、04)，开奖号码034**，与开奖号码前三码相同且顺序需一致，即中1等奖。开奖号码*34**，与开奖号码前三码相同且顺序需一致，即中2等奖。开奖号码**4**，与开奖号码前三码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            121 =>
                array (
                    'm_id' => '121',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSBD',
                    'm_cname' => '前三包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。豹子按直选派奖(1等奖)，组三态按组三派奖(2等奖)，组六态按组六派奖(3等奖)。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '前三包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            122 =>
                array (
                    'm_id' => '122',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSHHZX',
                    'm_cname' => '前三混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码112**，121**，211**，即中1等奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            123 =>
                array (
                    'm_id' => '123',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSZX',
                    'm_cname' => '中三直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择中间三个数，位置和数字正确即为中奖。投注三码(例：03、06、08)，开奖号码*368*，与开奖号码中间三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            124 =>
                array (
                    'm_id' => '124',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSZS',
                    'm_cname' => '中三组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，即千位、百位，十位 顺序不限，且开奖号码中有对子，且对应的三位号码与投注号码相同，即为中奖。投注两码(例：03、06)，开奖号码*336*、*363*、*633*、*663*、*636*、*366*…等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            125 =>
                array (
                    'm_id' => '125',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSZL',
                    'm_cname' => '中三组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，即千位、百位，十位 顺序不限，且开奖号码中对应的三位号码各不相同。即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**836、**863，与开奖号码中间三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            126 =>
                array (
                    'm_id' => '126',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSLX',
                    'm_cname' => '中三连选',
                    'm_team' => '直选',
                    'm_description' => '对千位，百位，十位选择投注后，则有十位，百位十位，千位百位十位三个中奖机会。投注三码(例：00、04、03)，开奖号码*043*，与开奖号码中间三码相同且顺序需一致，即中1等奖。开奖号码**43*，与开奖号码中间三码相同且顺序需一致，即中2等奖。开奖号码***3*，与开奖号码中间三码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            127 =>
                array (
                    'm_id' => '127',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSBD',
                    'm_cname' => '中三包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。豹子按直选派奖，组三态按组三派奖，组六态按组六派奖。投注一码(例：2)，开奖号码*110*、*101*、*011*、*002*、*020*、*200*，与开奖号码中间三码总和值相同，即中奖。豹子按直选派奖(1等奖)，组三态按组三派奖(2等奖)，组六态按组六派奖(3等奖)。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '中三包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            128 =>
                array (
                    'm_id' => '128',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSHHZX',
                    'm_cname' => '中三混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码*112*，*121*，*211*，即中1等奖。投注123,若开奖号码*123*， *132*，*213*，*231*，*312*，*321*，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            129 =>
                array (
                    'm_id' => '129',
                    'm_lid' => '8',
                    'm_mg_id' => '36',
                    'm_name' => 'SIXZX',
                    'm_cname' => '后四直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜开奖号码后面四位,即千位、百位、十位和个位,且顺序一致。如投注号为后四直选 2345 开奖为 12345 ,后面四位2345相对应,即为中奖。',
                    'm_max_comb' => '10000',
                    'm_max_money' => '20000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            130 =>
                array (
                    'm_id' => '130',
                    'm_lid' => '8',
                    'm_mg_id' => '36',
                    'm_name' => 'QSIZX',
                    'm_cname' => '前四直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜开奖号码前四位,即万位、千位、百位、十位,且顺序一致。如投注号为前四直选 1234 开奖为 12345 ,前面四位1234相对应,即为中奖。',
                    'm_max_comb' => '10000',
                    'm_max_money' => '20000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            131 =>
                array (
                    'm_id' => '131',
                    'm_lid' => '8',
                    'm_mg_id' => '31',
                    'm_name' => 'SXHZ',
                    'm_cname' => '三星和值',
                    'm_team' => '和值',
                    'm_description' => '后三位之和与所投号码相同即中奖。投注一码(例：2)，开奖号码**002、**020、**200、**110、**101、**011，与开奖号码后三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '三星和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            132 =>
                array (
                    'm_id' => '132',
                    'm_lid' => '8',
                    'm_mg_id' => '30',
                    'm_name' => 'EXHZ',
                    'm_cname' => '二星和值',
                    'm_team' => '和值',
                    'm_description' => '后两位之和 与所投号码相同即中奖。投注一码(例：14)，开奖号码***68，与开奖号码后两码和值相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '二星和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            133 =>
                array (
                    'm_id' => '133',
                    'm_lid' => '8',
                    'm_mg_id' => '34',
                    'm_name' => 'QSHZ',
                    'm_cname' => '前三和值',
                    'm_team' => '和值',
                    'm_description' => '竞猜前三码和值，即万千百位和。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '前三和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            134 =>
                array (
                    'm_id' => '134',
                    'm_lid' => '8',
                    'm_mg_id' => '33',
                    'm_name' => 'QEHZ',
                    'm_cname' => '前二和值',
                    'm_team' => '和值',
                    'm_description' => '万位千位之和，按排列全展开，和直选奖金相同。投注一码(例：03)，开奖号码03***、30***、12***、21***，与开奖号码前两码总和值相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '前二和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            135 =>
                array (
                    'm_id' => '135',
                    'm_lid' => '8',
                    'm_mg_id' => '35',
                    'm_name' => 'ZSHZ',
                    'm_cname' => '中三和值',
                    'm_team' => '和值',
                    'm_description' => '中三位之和，按排列全展开，和直选奖金相同。投注一码(例：2)，开奖号码*110*、*101*、*011*、*002*、*020*、*200*，与开奖号码中间三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '中三和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            136 =>
                array (
                    'm_id' => '136',
                    'm_lid' => '8',
                    'm_mg_id' => '38',
                    'm_name' => 'YMBDW',
                    'm_cname' => '三星一码不定位',
                    'm_team' => '',
                    'm_description' => '投注1个号码,在百位，十位和个位的位置上3个开奖号码包含所选号码，不限位置,即为中奖。投注一码(例：06)，开奖号码**6**、***6*、****6，与开奖号码后三码中任一码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '271',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆码',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            137 =>
                array (
                    'm_id' => '137',
                    'm_lid' => '8',
                    'm_mg_id' => '38',
                    'm_name' => 'EMBDW',
                    'm_cname' => '三星二码不定位',
                    'm_team' => '',
                    'm_description' => '投注2个号码,在百位，十位和个位的位置上3个开奖号码包含2个所选号码，不限位置,即为中奖。投注两码(例：04、07)，开奖号码***47、**47*、**4*7、**7*4、**74*、***74，与开奖号码后三码中任两码相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '54',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆一',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆二',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            138 =>
                array (
                    'm_id' => '138',
                    'm_lid' => '8',
                    'm_mg_id' => '39',
                    'm_name' => 'EXDXDS',
                    'm_cname' => '二星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜十位和个位的大、小、单、双。01234为小，56789为大。如：投注双大，开奖号码为21385,十位为双，个位为大，即为中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            139 =>
                array (
                    'm_id' => '139',
                    'm_lid' => '8',
                    'm_mg_id' => '39',
                    'm_name' => 'SXDXDS',
                    'm_cname' => '三星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜百位、十位和个位的大、小、单、双。0-4为小，5-9为大。如：投注小、双、大，开奖号码为21385,百位小,十位双，个位大，即为中奖。小(0-4)、单(奇数)、双(偶数)',
                    'm_max_comb' => '64',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '125',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '百位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            3 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            140 =>
                array (
                    'm_id' => '140',
                    'm_lid' => '8',
                    'm_mg_id' => '40',
                    'm_name' => 'WXZX',
                    'm_cname' => '五星直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜全部5位号码，即万位、千位、百位、十位和个位，且顺序一致。如选号12345,开奖12345,全部相同对应且顺序一致,即中奖。',
                    'm_max_comb' => '100000',
                    'm_max_money' => '200000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            141 =>
                array (
                    'm_id' => '141',
                    'm_lid' => '8',
                    'm_mg_id' => '40',
                    'm_name' => 'WXLX',
                    'm_cname' => '五星连选',
                    'm_team' => '直选',
                    'm_description' => '万千百十个位分别选择每位的1个或多个号码投注，有4次中奖机会（五星+后三+后二+后一）。投注五码(例：00、03、04、06、07)，开奖号码03467，与开奖号码相同且顺序需一致，即中1等奖。 开奖号码**467，与开奖号码相同且顺序需一致，即中2等奖。开奖号码***67，与开奖号码相同且顺序需一致，即中3等奖。开奖号码****7，与开奖号码相同且顺序需一致，即中4等奖。',
                    'm_max_comb' => '100000',
                    'm_max_money' => '200000',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            158 =>
                array (
                    'm_id' => '158',
                    'm_lid' => '27',
                    'm_mg_id' => '48',
                    'm_name' => 'SDQSZX',
                    'm_cname' => '前三直选',
                    'm_team' => '',
                    'm_description' => '选3个号码与开奖的前3个号码相同且顺序一致，即中奖。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '990',
                    'm_max_money' => '1980',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            159 =>
                array (
                    'm_id' => '159',
                    'm_lid' => '27',
                    'm_mg_id' => '48',
                    'm_name' => 'SDQSZUX',
                    'm_cname' => '前三组选',
                    'm_team' => '',
                    'm_description' => '选3个号码与开奖的前3个号码相同，即中奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中奖。',
                    'm_max_comb' => '990',
                    'm_max_money' => '1980',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前三组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            160 =>
                array (
                    'm_id' => '160',
                    'm_lid' => '27',
                    'm_mg_id' => '49',
                    'm_name' => 'SDQEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '',
                    'm_description' => '选2个号码与开奖的前2个号码相同且顺序一致，即中奖。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '110',
                    'm_max_money' => '220',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            161 =>
                array (
                    'm_id' => '161',
                    'm_lid' => '27',
                    'm_mg_id' => '49',
                    'm_name' => 'SDQEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '',
                    'm_description' => '选2个号码与开奖的前2个号码相同，即中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '110',
                    'm_max_money' => '220',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            162 =>
                array (
                    'm_id' => '162',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX1',
                    'm_cname' => '任选一中一',
                    'm_team' => '',
                    'm_description' => '投注的1个号码与当期开奖的5个号码中的任1号码相同，即中奖。如投注01，开奖号码包含01，与开奖号码任一码相同，即中奖',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '5',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选一',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            163 =>
                array (
                    'm_id' => '163',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX2',
                    'm_cname' => '任选二中二',
                    'm_team' => '',
                    'm_description' => '投注的2个号码与当期开奖的5个号码中的任2个号码相同，即中奖。如投注01、02，开奖号码包含01,02，与开奖号码任两码相同，顺序不限，即中奖',
                    'm_max_comb' => '55',
                    'm_max_money' => '110',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选二',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            164 =>
                array (
                    'm_id' => '164',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX3',
                    'm_cname' => '任选三中三',
                    'm_team' => '',
                    'm_description' => '投注的3个号码与当期开奖的5个号码中的任3个号码相同，即中奖。如投注01、02、03，开奖号码包含01,02,03，与开奖号码任三码相同，顺序不限,即中奖',
                    'm_max_comb' => '165',
                    'm_max_money' => '330',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            165 =>
                array (
                    'm_id' => '165',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX4',
                    'm_cname' => '任选四中四',
                    'm_team' => '',
                    'm_description' => '投注的4个号码与当期开奖的5个号码中的任4个号码相同，即中奖。如投注01、02、03、04，开奖号码包含01,02,03,04，与开奖号码任四码相同，顺序不限,即中奖',
                    'm_max_comb' => '330',
                    'm_max_money' => '660',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '5',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选四',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            166 =>
                array (
                    'm_id' => '166',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX5',
                    'm_cname' => '任选五中五',
                    'm_team' => '',
                    'm_description' => '投注的5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选五',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            167 =>
                array (
                    'm_id' => '167',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX6',
                    'm_cname' => '任选六中五',
                    'm_team' => '',
                    'm_description' => '投注的6个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            168 =>
                array (
                    'm_id' => '168',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX7',
                    'm_cname' => '任选七中五',
                    'm_team' => '',
                    'm_description' => '投注的7个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '21',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选七',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            169 =>
                array (
                    'm_id' => '169',
                    'm_lid' => '27',
                    'm_mg_id' => '50',
                    'm_name' => 'SDRX8',
                    'm_cname' => '任选八中五',
                    'm_team' => '',
                    'm_description' => '投注的8个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*、*、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '56',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选八',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            170 =>
                array (
                    'm_id' => '170',
                    'm_lid' => '27',
                    'm_mg_id' => '51',
                    'm_name' => 'SDQSBDW',
                    'm_cname' => '前三不定位胆',
                    'm_team' => '',
                    'm_description' => '投注的号码包含在开奖号码的第一，二，三位内，即中奖，奖金是定位胆的1/3。投注一码(例：01)，开奖号码前三码任一码为01，即中奖。投注两码(例：01、02)，开奖号码12***、*12**、1*2**、21***、*21**、2*1**，与开奖号码前三码任两码相同，即中奖。投注三码(例：03、01、02)，开奖号码123**、132**、231**、213**、312**、321**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            171 =>
                array (
                    'm_id' => '171',
                    'm_lid' => '27',
                    'm_mg_id' => '52',
                    'm_name' => 'SDQSDWD',
                    'm_cname' => '前三定位胆',
                    'm_team' => '',
                    'm_description' => '从第一，二，三位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致即中奖。投注一码(例：万位01)，开奖号码1****，与开奖号码前三码任一码相同且位置一致，即中奖。投注两码(例：万位01、千位02)，开奖号码12***，与开奖号码前三码中任两码相同且位置一致，即中奖。投注三码(例：万位01、千位02、百位03)，开奖号码123**，与开奖号码前三码相同且位置一致，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第一位',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第二位',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第三位',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            172 =>
                array (
                    'm_id' => '172',
                    'm_lid' => '27',
                    'm_mg_id' => '53',
                    'm_name' => 'SDDDS',
                    'm_cname' => '定单双',
                    'm_team' => '',
                    'm_description' => '投注组合与开奖的单双个数一致，即为中奖，从1等奖到6等奖分别是：0单5双,5单0双,1单4双,4单1双,2单3双,3单2双。投注两单三双，开奖号码86345，与开奖号码单双数量相同，即中奖。奖金分为：0单5双(奖金873.18)，5单0双(奖金145.53)，1单4双(奖金29.11)，4单1双(奖金11.64)，2单3双(奖金5.82)，3单2双(奖金4.37)。',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '6',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0单5双 1单4双 2单3双 3单2双 4单1双 5单0双',
                                    'max_selected' => '1',
                                    'prompt' => '定单双',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            173 =>
                array (
                    'm_id' => '173',
                    'm_lid' => '27',
                    'm_mg_id' => '54',
                    'm_name' => 'SDCZW',
                    'm_cname' => '猜中位',
                    'm_team' => '',
                    'm_description' => '开奖号码按照大小顺序排列后第三个号码包含在所投注的号码中，即为中奖。投注一码（例：05)，开奖号码86345，依开奖号码小到大排序第三码相同，即中奖。若投注03，为不中奖.开奖03,09时为一等奖,04,08时为二等奖,05,07时为三等奖,开奖06为四等奖。',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '03 04 05 06 07 08 09',
                                    'max_selected' => '1',
                                    'prompt' => '猜中位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            174 =>
                array (
                    'm_id' => '174',
                    'm_lid' => '24',
                    'm_mg_id' => '55',
                    'm_name' => 'SDQSZX',
                    'm_cname' => '前三直选',
                    'm_team' => '',
                    'm_description' => '选3个号码与开奖的前3个号码相同且顺序一致，即中奖。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '990',
                    'm_max_money' => '1980',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            175 =>
                array (
                    'm_id' => '175',
                    'm_lid' => '24',
                    'm_mg_id' => '55',
                    'm_name' => 'SDQSZUX',
                    'm_cname' => '前三组选',
                    'm_team' => '',
                    'm_description' => '选3个号码与开奖的前3个号码相同，即中奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中奖。',
                    'm_max_comb' => '990',
                    'm_max_money' => '1980',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前三组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            176 =>
                array (
                    'm_id' => '176',
                    'm_lid' => '24',
                    'm_mg_id' => '56',
                    'm_name' => 'SDQEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '',
                    'm_description' => '选2个号码与开奖的前2个号码相同且顺序一致，即中奖。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '110',
                    'm_max_money' => '220',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            177 =>
                array (
                    'm_id' => '177',
                    'm_lid' => '24',
                    'm_mg_id' => '56',
                    'm_name' => 'SDQEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '',
                    'm_description' => '选2个号码与开奖的前2个号码相同，即中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '110',
                    'm_max_money' => '220',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            178 =>
                array (
                    'm_id' => '178',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX1',
                    'm_cname' => '任选一中一',
                    'm_team' => '',
                    'm_description' => '投注的1个号码与当期开奖的5个号码中的任1号码相同，即中奖。如投注01，开奖号码包含01，与开奖号码任一码相同，即中奖',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '5',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选一',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            179 =>
                array (
                    'm_id' => '179',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX2',
                    'm_cname' => '任选二中二',
                    'm_team' => '',
                    'm_description' => '投注的2个号码与当期开奖的5个号码中的任2个号码相同，即中奖。如投注01、02，开奖号码包含01,02，与开奖号码任两码相同，顺序不限，即中奖',
                    'm_max_comb' => '55',
                    'm_max_money' => '110',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选二',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            180 =>
                array (
                    'm_id' => '180',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX3',
                    'm_cname' => '任选三中三',
                    'm_team' => '',
                    'm_description' => '投注的3个号码与当期开奖的5个号码中的任3个号码相同，即中奖。如投注01、02、03，开奖号码包含01,02,03，与开奖号码任三码相同，顺序不限,即中奖',
                    'm_max_comb' => '165',
                    'm_max_money' => '330',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            181 =>
                array (
                    'm_id' => '181',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX4',
                    'm_cname' => '任选四中四',
                    'm_team' => '',
                    'm_description' => '投注的4个号码与当期开奖的5个号码中的任4个号码相同，即中奖。如投注01、02、03、04，开奖号码包含01,02,03,04，与开奖号码任四码相同，顺序不限,即中奖',
                    'm_max_comb' => '330',
                    'm_max_money' => '660',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '5',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选四',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            182 =>
                array (
                    'm_id' => '182',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX5',
                    'm_cname' => '任选五中五',
                    'm_team' => '',
                    'm_description' => '投注的5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选五',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            183 =>
                array (
                    'm_id' => '183',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX6',
                    'm_cname' => '任选六中五',
                    'm_team' => '',
                    'm_description' => '投注的6个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            184 =>
                array (
                    'm_id' => '184',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX7',
                    'm_cname' => '任选七中五',
                    'm_team' => '',
                    'm_description' => '投注的7个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '21',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选七',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            185 =>
                array (
                    'm_id' => '185',
                    'm_lid' => '24',
                    'm_mg_id' => '57',
                    'm_name' => 'SDRX8',
                    'm_cname' => '任选八中五',
                    'm_team' => '',
                    'm_description' => '投注的8个号码中任5个号码与当期开奖的5个号码相同，即中奖。如投注01、02、03、04、05、*、*、*，开奖号码包含01,02,03,04,05，与开奖号码五码相同，顺序不限,即中奖',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '56',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '任选八',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            186 =>
                array (
                    'm_id' => '186',
                    'm_lid' => '24',
                    'm_mg_id' => '58',
                    'm_name' => 'SDQSBDW',
                    'm_cname' => '前三不定位胆',
                    'm_team' => '',
                    'm_description' => '投注的号码包含在开奖号码的第一，二，三位内，即中奖，奖金是定位胆的1/3。投注一码(例：01)，开奖号码前三码任一码为01，即中奖。投注两码(例：01、02)，开奖号码12***、*12**、1*2**、21***、*21**、2*1**，与开奖号码前三码任两码相同，即中奖。投注三码(例：03、01、02)，开奖号码123**、132**、231**、213**、312**、321**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '前三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            187 =>
                array (
                    'm_id' => '187',
                    'm_lid' => '24',
                    'm_mg_id' => '59',
                    'm_name' => 'SDQSDWD',
                    'm_cname' => '前三定位胆',
                    'm_team' => '',
                    'm_description' => '从第一，二，三位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致即中奖。投注一码(例：万位01)，开奖号码1****，与开奖号码前三码任一码相同且位置一致，即中奖。投注两码(例：万位01、千位02)，开奖号码12***，与开奖号码前三码中任两码相同且位置一致，即中奖。投注三码(例：万位01、千位02、百位03)，开奖号码123**，与开奖号码前三码相同且位置一致，即中奖。',
                    'm_max_comb' => '11',
                    'm_max_money' => '22',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第一位',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第二位',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '第三位',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第一位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第二位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10 11',
                                    'max_selected' => '11',
                                    'prompt' => '第三位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            188 =>
                array (
                    'm_id' => '188',
                    'm_lid' => '24',
                    'm_mg_id' => '60',
                    'm_name' => 'SDDDS',
                    'm_cname' => '定单双',
                    'm_team' => '',
                    'm_description' => '投注组合与开奖的单双个数一致，即为中奖，从1等奖到6等奖分别是：0单5双,5单0双,1单4双,4单1双,2单3双,3单2双。投注两单三双，开奖号码86345，与开奖号码单双数量相同，即中奖。奖金分为：0单5双(奖金873.18)，5单0双(奖金145.53)，1单4双(奖金29.11)，4单1双(奖金11.64)，2单3双(奖金5.82)，3单2双(奖金4.37)。',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '6',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0单5双 1单4双 2单3双 3单2双 4单1双 5单0双',
                                    'max_selected' => '1',
                                    'prompt' => '定单双',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            189 =>
                array (
                    'm_id' => '189',
                    'm_lid' => '24',
                    'm_mg_id' => '61',
                    'm_name' => 'SDCZW',
                    'm_cname' => '猜中位',
                    'm_team' => '',
                    'm_description' => '开奖号码按照大小顺序排列后第三个号码包含在所投注的号码中，即为中奖。投注一码（例：05)，开奖号码86345，依开奖号码小到大排序第三码相同，即中奖。若投注03，为不中奖.开奖03,09时为一等奖,04,08时为二等奖,05,07时为三等奖,开奖06为四等奖。',
                    'm_max_comb' => '462',
                    'm_max_money' => '924',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '03 04 05 06 07 08 09',
                                    'max_selected' => '1',
                                    'prompt' => '猜中位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            190 =>
                array (
                    'm_id' => '190',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXZX',
                    'm_cname' => '三星直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择后三个数，开奖号码后三码相同且顺序一致即为中奖。投注三码(例：03、06、08)，开奖号码**368，与开奖号码后三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '10',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            191 =>
                array (
                    'm_id' => '191',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXZS',
                    'm_cname' => '三星组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中有对子并且对应的三位号码有任意两位，即为中奖。投注两码(例：03、06)，开奖号码**336、**633、**663、**366等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '20',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            192 =>
                array (
                    'm_id' => '192',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXZL',
                    'm_cname' => '三星组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中对应的三位号码各不相同，即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**863、**836，与开奖号码后三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            193 =>
                array (
                    'm_id' => '193',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXLX',
                    'm_cname' => '三星连选',
                    'm_team' => '直选',
                    'm_description' => '对百位，十位，个位选择投注后，有个位，十位个位，百位十位个位，三种组合（类似后一直选+后二直选+后三直选）。开奖之后，投注号码与开奖号码相同且顺序一致则为中奖。投注三码(例：04、06、07)， 开奖号码**467，与开奖号码相同且顺序需一致，即中1等奖。开奖号码***67，与开奖号码相同且顺序需一致，即中2等奖。开奖号码****7，与开奖号码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            194 =>
                array (
                    'm_id' => '194',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXBD',
                    'm_cname' => '三星包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。豹子按直选派奖，组三态按组三派奖，组六态按组六派奖。投注一码(例：03)，开奖111按直选派奖，003,300,030按组三派奖，012,102,201按组六派奖。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '三星包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            195 =>
                array (
                    'm_id' => '195',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXHHZX',
                    'm_cname' => '三星混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入，组三号码按组三派奖，组六号码按组六派奖。投注112，开奖号码**112， **121， **211，即中一等奖。投注123,若开奖号码**123， **132，**213，**231，**312，**321，即中二等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            196 =>
                array (
                    'm_id' => '196',
                    'm_lid' => '14',
                    'm_mg_id' => '64',
                    'm_name' => 'YMBDW',
                    'm_cname' => '三星一码不定位',
                    'm_team' => '',
                    'm_description' => '投注1个号码,在百位，十位和个位的位置上3个开奖号码包含所选号码，不限位置,即为中奖。投注一码(例：06)，开奖号码**6**、***6*、****6，与开奖号码后三码中任一码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '271',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆码',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            197 =>
                array (
                    'm_id' => '197',
                    'm_lid' => '14',
                    'm_mg_id' => '64',
                    'm_name' => 'EMBDW',
                    'm_cname' => '三星二码不定位',
                    'm_team' => '',
                    'm_description' => '投注2个号码,在百位，十位和个位的位置上3个开奖号码包含2个所选号码，不限位置,即为中奖。投注两码(例：04、07)，开奖号码***47、**47*、**4*7、**7*4、**74*、***74，与开奖号码后三码中任两码相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '54',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆一',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆二',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            198 =>
                array (
                    'm_id' => '198',
                    'm_lid' => '14',
                    'm_mg_id' => '65',
                    'm_name' => 'EXDXDS',
                    'm_cname' => '二星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜十位和个位的大、小、单、双。01234为小，56789为大。如：投注双大，开奖号码为21385,十位为双，个位为大，即为中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            199 =>
                array (
                    'm_id' => '199',
                    'm_lid' => '14',
                    'm_mg_id' => '65',
                    'm_name' => 'SXDXDS',
                    'm_cname' => '三星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜百位、十位和个位的大、小、单、双。0-4为小，5-9为大。如：投注小、双、大，开奖号码为21385,百位小,十位双，个位大，即为中奖。小(0-4)、单(奇数)、双(偶数)',
                    'm_max_comb' => '64',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '125',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '百位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            3 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            200 =>
                array (
                    'm_id' => '200',
                    'm_lid' => '14',
                    'm_mg_id' => '63',
                    'm_name' => 'EXZX',
                    'm_cname' => '二星直选',
                    'm_team' => '直选',
                    'm_description' => '投注号码与当期中奖号码的后两位号码相同并顺序一致，即中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            201 =>
                array (
                    'm_id' => '201',
                    'm_lid' => '14',
                    'm_mg_id' => '63',
                    'm_name' => 'EXZUX',
                    'm_cname' => '二星组选',
                    'm_team' => '组选',
                    'm_description' => '对十位和个位进行投注，所选号码与开奖号码后两位一致，顺序不限，即为中奖投注两码(例：06、08)，开奖号码***68、***86，与开奖号码后两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '100',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            202 =>
                array (
                    'm_id' => '202',
                    'm_lid' => '14',
                    'm_mg_id' => '63',
                    'm_name' => 'EXLX',
                    'm_cname' => '二星连选',
                    'm_team' => '直选',
                    'm_description' => '对十位，个位选择投注，有十位个位、个位两种组合。开奖后，投注号码与开奖号码相同且顺序一致则为中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且位置一致，即中1等奖。开奖号码****8，与开奖号码后一码相同，即中2等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            203 =>
                array (
                    'm_id' => '203',
                    'm_lid' => '14',
                    'm_mg_id' => '63',
                    'm_name' => 'EXBD',
                    'm_cname' => '二星包点',
                    'm_team' => '和值',
                    'm_description' => '选择1个或多个和值点投注，中奖号码为对子为一等奖，非对子为二等奖。投注一码(例：14)，开奖号码***68，与开奖号码后两码和值相等，即中奖。中奖号码为对子为一等奖（奖金195.00），非对子为二等奖（奖金97.50）。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '对子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '非对子',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '二星包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            204 =>
                array (
                    'm_id' => '204',
                    'm_lid' => '14',
                    'm_mg_id' => '62',
                    'm_name' => 'SXHZ',
                    'm_cname' => '三星和值',
                    'm_team' => '和值',
                    'm_description' => '后三位之和与所投号码相同即中奖。投注一码(例：2)，开奖号码**002、**020、**200、**110、**101、**011，与开奖号码后三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '三星和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            205 =>
                array (
                    'm_id' => '205',
                    'm_lid' => '14',
                    'm_mg_id' => '63',
                    'm_name' => 'EXHZ',
                    'm_cname' => '二星和值',
                    'm_team' => '和值',
                    'm_description' => '后两位之和 与所投号码相同即中奖。投注一码(例：14)，开奖号码***68，与开奖号码后两码和值相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '二星和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            206 =>
                array (
                    'm_id' => '206',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSHZ',
                    'm_cname' => '前三和值',
                    'm_team' => '和值',
                    'm_description' => '竞猜前三码和值，即万千百位和。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '前三和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            207 =>
                array (
                    'm_id' => '207',
                    'm_lid' => '14',
                    'm_mg_id' => '69',
                    'm_name' => 'QEHZ',
                    'm_cname' => '前二和值',
                    'm_team' => '和值',
                    'm_description' => '万位千位之和，按排列全展开，和直选奖金相同。投注一码(例：03)，开奖号码03***、30***、12***、21***，与开奖号码前两码总和值相同，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '19',
                                    'prompt' => '前二和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            208 =>
                array (
                    'm_id' => '208',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSHZ',
                    'm_cname' => '中三和值',
                    'm_team' => '和值',
                    'm_description' => '中三位之和，按排列全展开，和直选奖金相同。投注一码(例：2)，开奖号码*110*、*101*、*011*、*002*、*020*、*200*，与开奖号码中间三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '中三和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '150',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            209 =>
                array (
                    'm_id' => '209',
                    'm_lid' => '14',
                    'm_mg_id' => '67',
                    'm_name' => 'YXZX',
                    'm_cname' => '一星直选',
                    'm_team' => '直选',
                    'm_description' => '从个位选择一个或多个数字进行投注，与开奖号码一致即为中奖。投注一码(例：08)，开奖号码****8，与开奖号码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            210 =>
                array (
                    'm_id' => '210',
                    'm_lid' => '14',
                    'm_mg_id' => '157',
                    'm_name' => 'WXDW',
                    'm_cname' => '任选一',
                    'm_team' => '任一',
                    'm_description' => '从万、千、百、十、个位任意一位中选1个或多个号码，号码与当期中奖号码的位置与号码相符，即中奖。投注一码(例：百位04)，开奖号码**4**，与开奖号码相同且位置一致，即中奖。万、千、百、十、个位中奖分别为1~5等奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '5',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            211 =>
                array (
                    'm_id' => '211',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSZX',
                    'm_cname' => '前三直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，且顺序对应一致。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序需一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            212 =>
                array (
                    'm_id' => '212',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSZS',
                    'm_cname' => '前三组三',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码有两位相同。投注两码(例：03、06)，开奖号码336**、363**、366**、633**、663**、636**等，与开奖号码前三码中任两码相同，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            213 =>
                array (
                    'm_id' => '213',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSZL',
                    'm_cname' => '前三组六',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码各不相同。如：投注三码(例：03、06、08)，开奖号码368**、386**、836**、863**、638**、683**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            214 =>
                array (
                    'm_id' => '214',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSLX',
                    'm_cname' => '前三连选',
                    'm_team' => '直选',
                    'm_description' => '对万位，千位，百位选择投注后，则有万位千位百位，千位百位，百位三个中奖机会。投注三码(例：00、03、04)，开奖号码034**，与开奖号码前三码相同且顺序需一致，即中1等奖。开奖号码*34**，与开奖号码前三码相同且顺序需一致，即中2等奖。开奖号码**4**，与开奖号码前三码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            215 =>
                array (
                    'm_id' => '215',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSBD',
                    'm_cname' => '前三包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。豹子按直选派奖(1等奖)，组三态按组三派奖(2等奖)，组六态按组六派奖(3等奖)。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '前三包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            216 =>
                array (
                    'm_id' => '216',
                    'm_lid' => '14',
                    'm_mg_id' => '68',
                    'm_name' => 'QSHHZX',
                    'm_cname' => '前三混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码112**，121**，211**，即中1等奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            217 =>
                array (
                    'm_id' => '217',
                    'm_lid' => '14',
                    'm_mg_id' => '69',
                    'm_name' => 'QEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前两码，即万位和千位，且顺序一致。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            218 =>
                array (
                    'm_id' => '218',
                    'm_lid' => '14',
                    'm_mg_id' => '69',
                    'm_name' => 'QEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '组选',
                    'm_description' => '竞猜前两码，即万位和千位，顺序不限。开对子不中奖。如：投注前二组选12,开奖号码为21385,前二号码为21,有12，即为中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '二组',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            219 =>
                array (
                    'm_id' => '219',
                    'm_lid' => '14',
                    'm_mg_id' => '69',
                    'm_name' => 'QELX',
                    'm_cname' => '前二连选',
                    'm_team' => '直选',
                    'm_description' => '从万位和千位选择1个或多个号码，2个号码均正确为一等奖，仅千位正确为二等奖。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中1等奖。开奖号码*3***，与开奖号码前两码相同且顺序一致，即中2等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            220 =>
                array (
                    'm_id' => '220',
                    'm_lid' => '14',
                    'm_mg_id' => '69',
                    'm_name' => 'QEBD',
                    'm_cname' => '前二包点',
                    'm_team' => '和值',
                    'm_description' => '选择1个或多个和值点投注，中奖号码为对子为一等奖，非对子为二等奖。投注一码(例：2)，开奖号码11***、02***、20***，与开奖号码前两码总和值相同，即中奖。中奖号码为对子为一等奖，非对子为二等奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '对子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '非对子',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '18',
                                    'prompt' => '前二包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            221 =>
                array (
                    'm_id' => '221',
                    'm_lid' => '14',
                    'm_mg_id' => '70',
                    'm_name' => 'WXZX',
                    'm_cname' => '五星直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜全部5位号码，即万位、千位、百位、十位和个位，且顺序一致。如选号12345,开奖12345,全部相同对应且顺序一致,即中奖。',
                    'm_max_comb' => '100000',
                    'm_max_money' => '200000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            222 =>
                array (
                    'm_id' => '222',
                    'm_lid' => '14',
                    'm_mg_id' => '70',
                    'm_name' => 'WXLX',
                    'm_cname' => '五星连选',
                    'm_team' => '直选',
                    'm_description' => '万千百十个位分别选择每位的1个或多个号码投注，有4次中奖机会（五星+后三+后二+后一）。投注五码(例：00、03、04、06、07)，开奖号码03467，与开奖号码相同且顺序需一致，即中1等奖。 开奖号码**467，与开奖号码相同且顺序需一致，即中2等奖。开奖号码***67，与开奖号码相同且顺序需一致，即中3等奖。开奖号码****7，与开奖号码相同且顺序需一致，即中4等奖。',
                    'm_max_comb' => '100000',
                    'm_max_money' => '200000',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            223 =>
                array (
                    'm_id' => '223',
                    'm_lid' => '14',
                    'm_mg_id' => '71',
                    'm_name' => 'SIXZX',
                    'm_cname' => '后四直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜开奖号码后面四位,即千位、百位、十位和个位,且顺序一致。如投注号为后四直选 2345 开奖为 12345 ,后面四位2345相对应,即为中奖。',
                    'm_max_comb' => '10000',
                    'm_max_money' => '20000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            224 =>
                array (
                    'm_id' => '224',
                    'm_lid' => '14',
                    'm_mg_id' => '71',
                    'm_name' => 'QSIZX',
                    'm_cname' => '前四直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜开奖号码前四位,即万位、千位、百位、十位,且顺序一致。如投注号为前四直选 1234 开奖为 12345 ,前面四位1234相对应,即为中奖。',
                    'm_max_comb' => '10000',
                    'm_max_money' => '20000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            225 =>
                array (
                    'm_id' => '225',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSZX',
                    'm_cname' => '中三直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择中间三个数，位置和数字正确即为中奖。投注三码(例：03、06、08)，开奖号码*368*，与开奖号码中间三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            226 =>
                array (
                    'm_id' => '226',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSZS',
                    'm_cname' => '中三组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，即千位、百位，十位 顺序不限，且开奖号码中有对子，且对应的三位号码与投注号码相同，即为中奖。投注两码(例：03、06)，开奖号码*336*、*363*、*633*、*663*、*636*、*366*…等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            227 =>
                array (
                    'm_id' => '227',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSZL',
                    'm_cname' => '中三组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，即千位、百位，十位 顺序不限，且开奖号码中对应的三位号码各不相同。即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**836、**863，与开奖号码中间三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            228 =>
                array (
                    'm_id' => '228',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSLX',
                    'm_cname' => '中三连选',
                    'm_team' => '直选',
                    'm_description' => '对千位，百位，十位选择投注后，则有十位，百位十位，千位百位十位三个中奖机会。投注三码(例：00、04、03)，开奖号码*043*，与开奖号码中间三码相同且顺序需一致，即中1等奖。开奖号码**43*，与开奖号码中间三码相同且顺序需一致，即中2等奖。开奖号码***3*，与开奖号码中间三码相同且顺序需一致，即中3等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '10',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '100',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            229 =>
                array (
                    'm_id' => '229',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSBD',
                    'm_cname' => '中三包点',
                    'm_team' => '和值',
                    'm_description' => '三个数加起来和值相同即为中奖。豹子按直选派奖，组三态按组三派奖，组六态按组六派奖。投注一码(例：2)，开奖号码*110*、*101*、*011*、*002*、*020*、*200*，与开奖号码中间三码总和值相同，即中奖。豹子按直选派奖(1等奖)，组三态按组三派奖(2等奖)，组六态按组六派奖(3等奖)。 ',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '豹子',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '中三包点',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            230 =>
                array (
                    'm_id' => '230',
                    'm_lid' => '14',
                    'm_mg_id' => '72',
                    'm_name' => 'ZSHHZX',
                    'm_cname' => '中三混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码*112*，*121*，*211*，即中1等奖。投注123,若开奖号码*123*， *132*，*213*，*231*，*312*，*321*，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            231 =>
                array (
                    'm_id' => '231',
                    'm_lid' => '28',
                    'm_mg_id' => '73',
                    'm_name' => 'SXZX',
                    'm_cname' => '直选',
                    'm_team' => '直选',
                    'm_description' => '任意选择后三个数，开奖号码后三码相同且顺序一致即为中奖。投注三码(例：03、06、08)，开奖号码**368，与开奖号码后三码相同且顺序一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            232 =>
                array (
                    'm_id' => '232',
                    'm_lid' => '28',
                    'm_mg_id' => '73',
                    'm_name' => 'SXHZ',
                    'm_cname' => '直选和值',
                    'm_team' => '和值',
                    'm_description' => '后三位之和与所投号码相同即中奖。投注一码(例：2)，开奖号码**002、**020、**200、**110、**101、**011，与开奖号码后三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            233 =>
                array (
                    'm_id' => '233',
                    'm_lid' => '28',
                    'm_mg_id' => '74',
                    'm_name' => 'SXZS',
                    'm_cname' => '组三',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中有对子并且对应的三位号码有任意两位，即为中奖。投注两码(例：03、06)，开奖号码**336、**633、**663、**366等，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            234 =>
                array (
                    'm_id' => '234',
                    'm_lid' => '28',
                    'm_mg_id' => '74',
                    'm_name' => 'SXZL',
                    'm_cname' => '组六',
                    'm_team' => '组选',
                    'm_description' => '所选号码，百位、十位和个位，顺序不限，且开奖号码中对应的三位号码各不相同，即为中奖。投注三码(例：03、06、08)，开奖号码**368、**386、**683、**638、**863、**836，与开奖号码后三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            235 =>
                array (
                    'm_id' => '235',
                    'm_lid' => '28',
                    'm_mg_id' => '74',
                    'm_name' => 'SXHHZX',
                    'm_cname' => '混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入，组三号码按组三派奖，组六号码按组六派奖。投注112，开奖号码**112， **121， **211，即中一等奖。投注123,若开奖号码**123， **132，**213，**231，**312，**321，即中二等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            236 =>
                array (
                    'm_id' => '236',
                    'm_lid' => '28',
                    'm_mg_id' => '74',
                    'm_name' => 'SXZXHZ',
                    'm_cname' => '组选和值',
                    'm_team' => '',
                    'm_description' => '所选数值等于后三位之和，豹子号除外，组三态按组三派奖，组六态按组六派奖。如投注7,开奖号码为**223,**115等,即中1等奖。开奖号码为**124,**016等,即中2等奖',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26',
                                    'max_selected' => '26',
                                    'prompt' => '和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            237 =>
                array (
                    'm_id' => '237',
                    'm_lid' => '28',
                    'm_mg_id' => '75',
                    'm_name' => 'YMBDW',
                    'm_cname' => '一码不定位',
                    'm_team' => '',
                    'm_description' => '投注1个号码,在百位，十位和个位的位置上3个开奖号码包含所选号码，不限位置,即为中奖。投注一码(例：06)，开奖号码**6**、***6*、****6，与开奖号码后三码中任一码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '271',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆码',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            238 =>
                array (
                    'm_id' => '238',
                    'm_lid' => '28',
                    'm_mg_id' => '75',
                    'm_name' => 'EMBDW',
                    'm_cname' => '二码不定位',
                    'm_team' => '',
                    'm_description' => '在百位，十位和个位的位置上任意投注3个号码，包含2个所选号码，即为中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '54',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆一',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆二',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            239 =>
                array (
                    'm_id' => '239',
                    'm_lid' => '28',
                    'm_mg_id' => '76',
                    'm_name' => 'QEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前两码，即万位和千位，且顺序一致。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            240 =>
                array (
                    'm_id' => '240',
                    'm_lid' => '28',
                    'm_mg_id' => '76',
                    'm_name' => 'QEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '组选',
                    'm_description' => '竞猜前两码，即万位和千位，顺序不限。开对子不中奖。如：投注前二组选12,开奖号码为21385,前二号码为21,有12，即为中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            241 =>
                array (
                    'm_id' => '241',
                    'm_lid' => '28',
                    'm_mg_id' => '77',
                    'm_name' => 'EXZX',
                    'm_cname' => '二星直选',
                    'm_team' => '直选',
                    'm_description' => '投注号码与当期中奖号码的后两位号码相同并顺序一致，即中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            242 =>
                array (
                    'm_id' => '242',
                    'm_lid' => '28',
                    'm_mg_id' => '77',
                    'm_name' => 'EXZUX',
                    'm_cname' => '二星组选',
                    'm_team' => '组选',
                    'm_description' => '对十位和个位进行投注，所选号码与开奖号码后两位一致，顺序不限，即为中奖投注两码(例：06、08)，开奖号码***68、***86，与开奖号码后两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            243 =>
                array (
                    'm_id' => '243',
                    'm_lid' => '28',
                    'm_mg_id' => '78',
                    'm_name' => 'QEDXDS',
                    'm_cname' => '前二大小单双',
                    'm_team' => '',
                    'm_description' => '仅限在百位和十位进行投注。大：5-9小：0-4单：1,3,5,7,9双：0,2,4,6,8投注两码(例：大&双、双&双、大&大、双&大)，开奖号码68***，与开奖号前两码属性相同且顺序一致，即中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '百位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            244 =>
                array (
                    'm_id' => '244',
                    'm_lid' => '28',
                    'm_mg_id' => '78',
                    'm_name' => 'EXDXDS',
                    'm_cname' => '二星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜十位和个位的大、小、单、双。01234为小，56789为大。如：投注双大，开奖号码为21385,十位为双，个位为大，即为中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            245 =>
                array (
                    'm_id' => '245',
                    'm_lid' => '28',
                    'm_mg_id' => '79',
                    'm_name' => 'SXDW',
                    'm_cname' => '定位胆',
                    'm_team' => '',
                    'm_description' => '从百位、十位、个位分别选择任意的1个或多个号码投注。投注一码(例：个位03)，开奖号码**3，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '百位',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '十位',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '个位',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            246 =>
                array (
                    'm_id' => '246',
                    'm_lid' => '29',
                    'm_mg_id' => '80',
                    'm_name' => 'QSZX',
                    'm_cname' => '直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，且顺序对应一致。投注三码(例：00、03、05)，开奖号码035**，与开奖号码前三码相同且顺序需一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            247 =>
                array (
                    'm_id' => '247',
                    'm_lid' => '29',
                    'm_mg_id' => '80',
                    'm_name' => 'QSHZ',
                    'm_cname' => '直选和值',
                    'm_team' => '和值',
                    'm_description' => '竞猜前三码和值，即万千百位和。投注一码(例：2)，开奖号码110**、101**、011**、002**、020**、200**，与开奖号码前三码总和值相同，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27',
                                    'max_selected' => '28',
                                    'prompt' => '和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            248 =>
                array (
                    'm_id' => '248',
                    'm_lid' => '29',
                    'm_mg_id' => '81',
                    'm_name' => 'QSZS',
                    'm_cname' => '组三',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码有两位相同。投注两码(例：03、06)，开奖号码336**、363**、366**、633**、663**、636**等，与开奖号码前三码中任两码相同，即中奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组三',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            249 =>
                array (
                    'm_id' => '249',
                    'm_lid' => '29',
                    'm_mg_id' => '81',
                    'm_name' => 'QSZL',
                    'm_cname' => '组六',
                    'm_team' => '组选',
                    'm_description' => '竞猜前三码，即万位、千位和百位，顺序不限，且投注时三位号码各不相同。如：投注三码(例：03、06、08)，开奖号码368**、386**、836**、863**、638**、683**，与开奖号码前三码相同，即中奖。',
                    'm_max_comb' => '720',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '组六',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            250 =>
                array (
                    'm_id' => '250',
                    'm_lid' => '29',
                    'm_mg_id' => '81',
                    'm_name' => 'QSHHZX',
                    'm_cname' => '混合组选',
                    'm_team' => '组选',
                    'm_description' => '组三组六态号码混合录入。投注112，开奖号码112**，121**，211**，即中1等奖。投注123，若开奖号码123**， 132**，213**，231**，312**，321**，即中2等奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '1',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            251 =>
                array (
                    'm_id' => '251',
                    'm_lid' => '29',
                    'm_mg_id' => '81',
                    'm_name' => 'QSZXHZ',
                    'm_cname' => '组选和值',
                    'm_team' => '',
                    'm_description' => '所选数值等于前三位之和，投注一码(例：2)，开奖号码002**、020**、200**、110**、101**、011**，与开奖号码前三码总和值相同，即中奖。豹子号除外，组三态按组三派奖(1等奖)，组六态按组六派奖(2等奖) 。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '组三',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '组六',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26',
                                    'max_selected' => '26',
                                    'prompt' => '和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            252 =>
                array (
                    'm_id' => '252',
                    'm_lid' => '29',
                    'm_mg_id' => '82',
                    'm_name' => 'QSYMBDW',
                    'm_cname' => '一码不定位',
                    'm_team' => '',
                    'm_description' => '在万千百位的位置上任意投注，只要出现即为中奖。投注一码(例：06)，开奖号码**6**、***6*、****6，与开奖号码前三码中任一码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '271',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆码',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            253 =>
                array (
                    'm_id' => '253',
                    'm_lid' => '29',
                    'm_mg_id' => '82',
                    'm_name' => 'QSEMBDW',
                    'm_cname' => '二码不定位',
                    'm_team' => '',
                    'm_description' => '在万千百位的位置上任意投注2个号码，开奖号码包含2个所选号码即为中奖。投注两码(例：04、07)，开奖号码***47、**47*、**4*7、**7*4、**74*、***74，与开奖号码后三码中任两码相同，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '54',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆一',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '1',
                                    'prompt' => '胆二',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            254 =>
                array (
                    'm_id' => '254',
                    'm_lid' => '29',
                    'm_mg_id' => '83',
                    'm_name' => 'QEZX',
                    'm_cname' => '前二直选',
                    'm_team' => '直选',
                    'm_description' => '竞猜前两码，即万位和千位，且顺序一致。投注两码(例：00、03)，开奖号码03***，与开奖号码前两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            255 =>
                array (
                    'm_id' => '255',
                    'm_lid' => '29',
                    'm_mg_id' => '83',
                    'm_name' => 'QEZUX',
                    'm_cname' => '前二组选',
                    'm_team' => '组选',
                    'm_description' => '竞猜前两码，即万位和千位，顺序不限。开对子不中奖。如：投注前二组选12,开奖号码为21385,前二号码为21,有12，即为中奖。投注两码(例：00、03)，开奖号码03***、30***，与开奖号码前两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            256 =>
                array (
                    'm_id' => '256',
                    'm_lid' => '29',
                    'm_mg_id' => '84',
                    'm_name' => 'EXZX',
                    'm_cname' => '二星直选',
                    'm_team' => '直选',
                    'm_description' => '投注号码与当期中奖号码的后两位号码相同并顺序一致，即中奖。投注两码(例：06、08)，开奖号码***68，与开奖号码后两码相同且顺序一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            257 =>
                array (
                    'm_id' => '257',
                    'm_lid' => '29',
                    'm_mg_id' => '84',
                    'm_name' => 'EXZUX',
                    'm_cname' => '二星组选',
                    'm_team' => '组选',
                    'm_description' => '对十位和个位进行投注，所选号码与开奖号码后两位一致，顺序不限，即为中奖投注两码(例：06、08)，开奖号码***68、***86，与开奖号码后两码相同，即中奖。',
                    'm_max_comb' => '50',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '2',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '7',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            258 =>
                array (
                    'm_id' => '258',
                    'm_lid' => '29',
                    'm_mg_id' => '85',
                    'm_name' => 'QEDXDS',
                    'm_cname' => '前二大小单双',
                    'm_team' => '',
                    'm_description' => '仅限在万位和千位进行投注。大：5-9小：0-4单：1,3,5,7,9双：0,2,4,6,8投注两码(例：大&双、双&双、大&大、双&大)，开奖号码68***，与开奖号前两码属性相同且顺序一致，即中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '万位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '千位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            259 =>
                array (
                    'm_id' => '259',
                    'm_lid' => '29',
                    'm_mg_id' => '85',
                    'm_name' => 'EXDXDS',
                    'm_cname' => '二星大小单双',
                    'm_team' => '',
                    'm_description' => '竞猜十位和个位的大、小、单、双。01234为小，56789为大。如：投注双大，开奖号码为21385,十位为双，个位为大，即为中奖。',
                    'm_max_comb' => '16',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '250',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '十位',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '大 小 单 双',
                                    'max_selected' => '1',
                                    'prompt' => '个位',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            260 =>
                array (
                    'm_id' => '260',
                    'm_lid' => '29',
                    'm_mg_id' => '86',
                    'm_name' => 'WXDW',
                    'm_cname' => '定位胆',
                    'm_team' => '任一',
                    'm_description' => '从个、十、百、千、万位任意一位中选1个或多个号码，号码与当期中奖号码的位置与号码相符，即中奖。投注一码(例：个位03)，开奖号码**3，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '5',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            360 =>
                array (
                    'm_id' => '360',
                    'm_lid' => '9',
                    'm_mg_id' => '118',
                    'm_name' => 'JSHZ',
                    'm_cname' => '和值',
                    'm_team' => '',
                    'm_description' => '至少选择1个号码投注，与开奖号码3个数字相加的点数一致即中奖。1等奖(3,18)、2等奖(4,17)、3等奖(5,16)、4等奖(6,15)、5等奖(7,14)、6等奖(8,13)、7等奖(9，12)、8等奖(10，11)投注一码(例：10)，开奖号码01、06、03，与开奖号码三码加总值相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '8',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '16',
                                    'prompt' => '和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            361 =>
                array (
                    'm_id' => '361',
                    'm_lid' => '9',
                    'm_mg_id' => '119',
                    'm_name' => 'JSETDX',
                    'm_cname' => '二同号单选',
                    'm_team' => '',
                    'm_description' => '选择1对相同号码和1个不同号码投注,所选择的同号与不同号不能为同一个数。开出所选择之号码即中奖。投注11,2（必须有两码号码相同），开奖号码112,121,211,即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '11 22 33 44 55 66',
                                    'max_selected' => '6',
                                    'prompt' => '同号',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '1 2 3 4 5 6',
                                    'max_selected' => '10',
                                    'prompt' => '不同号',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            362 =>
                array (
                    'm_id' => '362',
                    'm_lid' => '9',
                    'm_mg_id' => '120',
                    'm_name' => 'JSETFX',
                    'm_cname' => '二同号复选',
                    'm_team' => '',
                    'm_description' => '二同号即：11x，22x，33x，44x，55x，66x开出所选之同号即中奖。投注两码（例：11），开奖号码11*、*11,1*1，需与开奖号码两码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '15',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '11 22 33 44 55 66',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            363 =>
                array (
                    'm_id' => '363',
                    'm_lid' => '9',
                    'm_mg_id' => '121',
                    'm_name' => 'JSEBT',
                    'm_cname' => '二不同号',
                    'm_team' => '',
                    'm_description' => '至少选择两个号码，开出选择之号码即中奖。投注两码（例：2、1），开奖号码12*、1*2、*12、21*、2*1、*21，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '30',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '1 2 3 4 5 6',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            364 =>
                array (
                    'm_id' => '364',
                    'm_lid' => '9',
                    'm_mg_id' => '122',
                    'm_name' => 'JSSTDX',
                    'm_cname' => '三同号单选',
                    'm_team' => '',
                    'm_description' => '选择一注以上三同号，即：111，222，333，444，555，666。开出所选之指定三同号即中奖。投注三码（例：111），开奖号码111，与中奖号码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '111 222 333 444 555 666',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            365 =>
                array (
                    'm_id' => '365',
                    'm_lid' => '9',
                    'm_mg_id' => '123',
                    'm_name' => 'JSSTTX',
                    'm_cname' => '三同号通选',
                    'm_team' => '',
                    'm_description' => '三同号通选包含（111,222,333,444,555,666），开出任意三同号皆中奖。投注全部三码皆同号（例：111～666，共六种），开奖号码111、222、333、444、555、666，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '三同号通选',
                                    'max_selected' => '1',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            366 =>
                array (
                    'm_id' => '366',
                    'm_lid' => '9',
                    'm_mg_id' => '124',
                    'm_name' => 'JSSBT',
                    'm_cname' => '三不同号',
                    'm_team' => '',
                    'm_description' => '至少选择三个号,所选择的号码包含开出的号码即中奖。投注三码（例：136），开奖号码136、163、361、316、613、631，皆与中奖号码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '1 2 3 4 5 6',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            367 =>
                array (
                    'm_id' => '367',
                    'm_lid' => '9',
                    'm_mg_id' => '125',
                    'm_name' => 'JSSLTX',
                    'm_cname' => '三连号通选',
                    'm_team' => '',
                    'm_description' => '开出任意连号（123,234,345,456）即中奖。投注全部三连号（例：123、234、345、456，共四种），开奖号码123、234、345、456，与中奖号码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '24',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '三连号通选',
                                    'max_selected' => '1',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            376 =>
                array (
                    'm_id' => '376',
                    'm_lid' => '2',
                    'm_mg_id' => '134',
                    'm_name' => 'REZX',
                    'm_cname' => '任选二',
                    'm_team' => '任二',
                    'm_description' => '单注对任意两个位数投注，号码与当期中奖号码的位置与号码相符，即中奖。投注两码(例：千位04、十位01)，开奖号码*4*1*，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            377 =>
                array (
                    'm_id' => '377',
                    'm_lid' => '2',
                    'm_mg_id' => '134',
                    'm_name' => 'RSZX',
                    'm_cname' => '任选三',
                    'm_team' => '任三',
                    'm_description' => '单注对任意三个位数投注，号码与当期中奖号码的位置与号码相符，即中奖。投注三码(例：万位07、百位04、十位01)，开奖号码7*41*，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            421 =>
                array (
                    'm_id' => '421',
                    'm_lid' => '6',
                    'm_mg_id' => '146',
                    'm_name' => 'PKQYZX',
                    'm_cname' => '猜冠军',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码中第一位一致即中奖。投注一码（例：冠军10）,开奖号码冠军10，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '10',
                    'm_max_money' => '20',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            425 =>
                array (
                    'm_id' => '425',
                    'm_lid' => '8',
                    'm_mg_id' => '158',
                    'm_name' => 'REZX',
                    'm_cname' => '任选二',
                    'm_team' => '任二',
                    'm_description' => '单注对任意两个位数投注，号码与当期中奖号码的位置与号码相符，即中奖。投注两码(例：千位04、十位01)，开奖号码*4*1*，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            426 =>
                array (
                    'm_id' => '426',
                    'm_lid' => '8',
                    'm_mg_id' => '158',
                    'm_name' => 'RSZX',
                    'm_cname' => '任选三',
                    'm_team' => '任三',
                    'm_description' => '单注对任意三个位数投注，号码与当期中奖号码的位置与号码相符，即中奖。投注三码(例：万位07、百位04、十位01)，开奖号码7*41*，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            428 =>
                array (
                    'm_id' => '428',
                    'm_lid' => '14',
                    'm_mg_id' => '157',
                    'm_name' => 'REZX',
                    'm_cname' => '任选二',
                    'm_team' => '任二',
                    'm_description' => '单注对任意两个位数投注，号码与当期中奖号码的位置与号码相符，即中奖。投注两码(例：千位04、十位01)，开奖号码*4*1*，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '100',
                    'm_max_money' => '200',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            429 =>
                array (
                    'm_id' => '429',
                    'm_lid' => '14',
                    'm_mg_id' => '157',
                    'm_name' => 'RSZX',
                    'm_cname' => '任选三',
                    'm_team' => '任三',
                    'm_description' => '单注对任意三个位数投注，号码与当期中奖号码的位置与号码相符，即中奖。投注三码(例：万位07、百位04、十位01)，开奖号码7*41*，与开奖号码相同且位置一致，即中奖。',
                    'm_max_comb' => '1000',
                    'm_max_money' => '2000',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '万位',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '千位',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '百位',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '十位',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '0 1 2 3 4 5 6 7 8 9',
                                    'max_selected' => '10',
                                    'prompt' => '个位',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            433 =>
                array (
                    'm_id' => '433',
                    'm_lid' => '30',
                    'm_mg_id' => '160',
                    'm_name' => 'JSHZ',
                    'm_cname' => '和值',
                    'm_team' => '',
                    'm_description' => '至少选择1个号码投注，与开奖号码3个数字相加的点数一致即中奖。1等奖(3,18)、2等奖(4,17)、3等奖(5,16)、4等奖(6,15)、5等奖(7,14)、6等奖(8,13)、7等奖(9，12)、8等奖(10，11)投注一码(例：10)，开奖号码01、06、03，与开奖号码三码加总值相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '8',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18',
                                    'max_selected' => '16',
                                    'prompt' => '和值',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            434 =>
                array (
                    'm_id' => '434',
                    'm_lid' => '30',
                    'm_mg_id' => '161',
                    'm_name' => 'JSETDX',
                    'm_cname' => '二同号单选',
                    'm_team' => '',
                    'm_description' => '选择1对相同号码和1个不同号码投注,所选择的同号与不同号不能为同一个数。开出所选择之号码即中奖。投注11,2（必须有两码号码相同），开奖号码112,121,211,即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '3',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '11 22 33 44 55 66',
                                    'max_selected' => '6',
                                    'prompt' => '同号',
                                    'has_filter_btn' => 0,
                                ),
                            2 =>
                                array (
                                    'nums' => '1 2 3 4 5 6',
                                    'max_selected' => '10',
                                    'prompt' => '不同号',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            435 =>
                array (
                    'm_id' => '435',
                    'm_lid' => '30',
                    'm_mg_id' => '162',
                    'm_name' => 'JSETFX',
                    'm_cname' => '二同号复选',
                    'm_team' => '',
                    'm_description' => '二同号即：11x，22x，33x，44x，55x，66x开出所选之同号即中奖。投注两码（例：11），开奖号码11*、*11,1*1，需与开奖号码两码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '15',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '11 22 33 44 55 66',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            436 =>
                array (
                    'm_id' => '436',
                    'm_lid' => '30',
                    'm_mg_id' => '163',
                    'm_name' => 'JSEBT',
                    'm_cname' => '二不同号',
                    'm_team' => '',
                    'm_description' => '至少选择两个号码，开出选择之号码即中奖。投注两码（例：2、1），开奖号码12*、1*2、*12、21*、2*1、*21，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '30',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '1 2 3 4 5 6',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            437 =>
                array (
                    'm_id' => '437',
                    'm_lid' => '30',
                    'm_mg_id' => '164',
                    'm_name' => 'JSSTDX',
                    'm_cname' => '三同号单选',
                    'm_team' => '',
                    'm_description' => '选择一注以上三同号，即：111，222，333，444，555，666。开出所选之指定三同号即中奖。投注三码（例：111），开奖号码111，与中奖号码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '111 222 333 444 555 666',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            438 =>
                array (
                    'm_id' => '438',
                    'm_lid' => '30',
                    'm_mg_id' => '165',
                    'm_name' => 'JSSTTX',
                    'm_cname' => '三同号通选',
                    'm_team' => '',
                    'm_description' => '三同号通选包含（111,222,333,444,555,666），开出任意三同号皆中奖。投注全部三码皆同号（例：111～666，共六种），开奖号码111、222、333、444、555、666，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '三同号通选',
                                    'max_selected' => '1',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            439 =>
                array (
                    'm_id' => '439',
                    'm_lid' => '30',
                    'm_mg_id' => '166',
                    'm_name' => 'JSSBT',
                    'm_cname' => '三不同号',
                    'm_team' => '',
                    'm_description' => '至少选择三个号,所选择的号码包含开出的号码即中奖。投注三码（例：136），开奖号码136、163、361、316、613、631，皆与中奖号码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '6',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '1 2 3 4 5 6',
                                    'max_selected' => '6',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            440 =>
                array (
                    'm_id' => '440',
                    'm_lid' => '30',
                    'm_mg_id' => '167',
                    'm_name' => 'JSSLTX',
                    'm_cname' => '三连号通选',
                    'm_team' => '',
                    'm_description' => '开出任意连号（123,234,345,456）即中奖。投注全部三连号（例：123、234、345、456，共四种），开奖号码123、234、345、456，与中奖号码相同，即中奖。',
                    'm_max_comb' => '216',
                    'm_max_money' => '432',
                    'm_levels' => '1',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '24',
                                    'name' => '一等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '三连号通选',
                                    'max_selected' => '1',
                                    'prompt' => '',
                                    'has_filter_btn' => 0,
                                ),
                        ),
                    'm_can_input' => '0',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            441 =>
                array (
                    'm_id' => '441',
                    'm_lid' => '6',
                    'm_mg_id' => '147',
                    'm_name' => 'PKQELX',
                    'm_cname' => '猜冠亚军',
                    'm_team' => '',
                    'm_description' => '玩法提示：选号与开奖号码按位猜对1-2位即中奖投注两码（例：冠军10、亚军09）,开奖号码冠亚依序为10、09。若两码与开奖号码相同且位置一致，即中奖1等奖 。若任一码与开奖号码相同且位置一致，即中奖2等奖。',
                    'm_max_comb' => '90',
                    'm_max_money' => '180',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1.6',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '45',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            442 =>
                array (
                    'm_id' => '442',
                    'm_lid' => '6',
                    'm_mg_id' => '148',
                    'm_name' => 'PKQSLX',
                    'm_cname' => '猜前三名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对1-3位即中奖投注三码（例：冠军10、亚军09、季军08）,开奖号码冠亚依序为10、09，08若三~一码与开奖号码相同且位置一致，即中奖1~3等奖.',
                    'm_max_comb' => '720',
                    'm_max_money' => '1440',
                    'm_levels' => '3',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '4.5',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '72',
                                    'name' => '二等奖',
                                ),
                            3 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '360',
                                    'name' => '三等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            443 =>
                array (
                    'm_id' => '443',
                    'm_lid' => '6',
                    'm_mg_id' => '149',
                    'm_name' => 'PKQ4LX',
                    'm_cname' => '猜前四名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对1-4位即中奖投注四码（例：10、09、08、07）,开奖号码依序为10、09，08、07若四~一码与开奖号码相同且位置一致，即中奖1~4等奖.',
                    'm_max_comb' => '5040',
                    'm_max_money' => '10080',
                    'm_levels' => '4',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            444 =>
                array (
                    'm_id' => '444',
                    'm_lid' => '6',
                    'm_mg_id' => '150',
                    'm_name' => 'PKQ5LX',
                    'm_cname' => '猜前五名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对1-5位即中奖投注五码（例：10、09、08、07、06）,开奖号码依序为10、09，08、07、06若五~一码与开奖号码相同且位置一致，即中奖1~5等奖.',
                    'm_max_comb' => '30240',
                    'm_max_money' => '60480',
                    'm_levels' => '5',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第五名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            445 =>
                array (
                    'm_id' => '445',
                    'm_lid' => '6',
                    'm_mg_id' => '155',
                    'm_name' => 'PKQ10LX',
                    'm_cname' => '猜前十名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对10位或一位没中即中奖投注十码（例：10、09、08、07、06、05、04、03、02、01）,开奖号码依序为10、09，08、07、06、05、04、03、02、01若十码与开奖号码相同且位置一致，即中奖1等奖。若没有一码位与开奖号码相同且位置一致，即中奖2等奖。',
                    'm_max_comb' => '3628800',
                    'm_max_money' => '7257600',
                    'm_levels' => '2',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' =>
                        array (
                            1 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '4',
                                    'name' => '一等奖',
                                ),
                            2 =>
                                array (
                                    'is_use' => '1',
                                    'expand_num' => '1814400',
                                    'name' => '二等奖',
                                ),
                        ),
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第五名',
                                    'has_filter_btn' => '1',
                                ),
                            6 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第六名',
                                    'has_filter_btn' => '1',
                                ),
                            7 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第七名',
                                    'has_filter_btn' => '1',
                                ),
                            8 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第八名',
                                    'has_filter_btn' => '1',
                                ),
                            9 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第九名',
                                    'has_filter_btn' => '1',
                                ),
                            10 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第十名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            446 =>
                array (
                    'm_id' => '446',
                    'm_lid' => '6',
                    'm_mg_id' => '154',
                    'm_name' => 'PKQ9LX',
                    'm_cname' => '猜前九名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对2-9位即中奖投注九码（例：10、09、08、07、06、05、04、03、02）,开奖号码依序为10、09，08、07、06、05、04、03、02若九~二码与开奖号码相同且位置一致，即中奖1~8等奖.',
                    'm_max_comb' => '3628800',
                    'm_max_money' => '7257600',
                    'm_levels' => '8',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第五名',
                                    'has_filter_btn' => '1',
                                ),
                            6 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第六名',
                                    'has_filter_btn' => '1',
                                ),
                            7 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第七名',
                                    'has_filter_btn' => '1',
                                ),
                            8 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第八名',
                                    'has_filter_btn' => '1',
                                ),
                            9 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第九名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            447 =>
                array (
                    'm_id' => '447',
                    'm_lid' => '6',
                    'm_mg_id' => '151',
                    'm_name' => 'PKQ6LX',
                    'm_cname' => '猜前六名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对2-6位即中奖投注六码（例：10、09、08、07、06、05）,开奖号码依序为10、09，08、07、06、05若六~二码与开奖号码相同且位置一致，即中奖1~5等奖.',
                    'm_max_comb' => '151200',
                    'm_max_money' => '302400',
                    'm_levels' => '5',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第五名',
                                    'has_filter_btn' => '1',
                                ),
                            6 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第六名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            448 =>
                array (
                    'm_id' => '448',
                    'm_lid' => '6',
                    'm_mg_id' => '152',
                    'm_name' => 'PKQ7LX',
                    'm_cname' => '猜前七名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对2-7位即中奖投注七码（例：10、09、08、07、06、05、04）,开奖号码依序为10、09，08、07、06、05、04若七~二码与开奖号码相同且位置一致，即中奖1~6等奖.',
                    'm_max_comb' => '604800',
                    'm_max_money' => '1209600',
                    'm_levels' => '6',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第五名',
                                    'has_filter_btn' => '1',
                                ),
                            6 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第六名',
                                    'has_filter_btn' => '1',
                                ),
                            7 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第七名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
            449 =>
                array (
                    'm_id' => '449',
                    'm_lid' => '6',
                    'm_mg_id' => '153',
                    'm_name' => 'PKQ8LX',
                    'm_cname' => '猜前八名',
                    'm_team' => '',
                    'm_description' => '选号与开奖号码按位猜对2-8位即中奖投注八码（例：10、09、08、07、06、05、04、03）,开奖号码依序为10、09，08、07、06、05、04、03若八~二码与开奖号码相同且位置一致，即中奖1~7等奖.',
                    'm_max_comb' => '1814400',
                    'm_max_money' => '3628800',
                    'm_levels' => '7',
                    'm_is_lock' => '0',
                    'm_is_odds' => '0',
                    'm_expands' => false,
                    'm_field_def' =>
                        array (
                            1 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '冠军',
                                    'has_filter_btn' => '1',
                                ),
                            2 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '亚军',
                                    'has_filter_btn' => '1',
                                ),
                            3 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第三名',
                                    'has_filter_btn' => '1',
                                ),
                            4 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第四名',
                                    'has_filter_btn' => '1',
                                ),
                            5 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第五名',
                                    'has_filter_btn' => '1',
                                ),
                            6 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第六名',
                                    'has_filter_btn' => '1',
                                ),
                            7 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第七名',
                                    'has_filter_btn' => '1',
                                ),
                            8 =>
                                array (
                                    'nums' => '01 02 03 04 05 06 07 08 09 10',
                                    'max_selected' => '10',
                                    'prompt' => '第八名',
                                    'has_filter_btn' => '1',
                                ),
                        ),
                    'm_can_input' => '1',
                    'm_status' => '8',
                    'm_sort' => '100',
                    'm_flock' => '0.0000',
                    'm_update_time' => '0000-00-00 00:00:00',
                ),
        );

    /**
     * 数据库获取玩法列表
     * @param array $data
     */
    public function getLockmethodsList($lid ){
        $list = $this->query("select * from ffc_methods where m_lid={$lid} ");
        if(empty($list)){
            return [];
        }
        return $list;
    }

    /**
     * 修改封锁值
     * @param array $data
     */
    public function editLocks($data = []){

    }
    /**
     * 根据玩法组获取玩法列表
     */
    public function getMothodList($mg_id = 1)
    {
        $arr = [];
        foreach ($this->method_list as $v){
            if($v['m_mg_id'] == $mg_id){
                $arr[] = $v;
            }
        }
        return  $arr;
    }
    /**
     * 根据玩法组获取玩法列表
     */
    public function getMethodBylid($lid = 1,$byId=false)
    {
        $arr = [];
        foreach ($this->method_list  as $k=>$v){
            if($byId){
                if($v['m_lid'] == $lid){
                    $arr[$k] = $v;
                }
            }else{
                if($v['m_lid'] == $lid){
                    $arr[] = $v;
                }
            }

        }
        return  $arr;
    }

    /**
     * 获取玩法详情
     * @param $m_id
     */
    public function getMothodDetail($m_id)
    {
        $list = $this->method_list;
        if(empty($list[$m_id])){
            return [];
        }
        return $list[$m_id];
    }


}