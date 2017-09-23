<?php

/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/23
 * Time: 15:33
 */
namespace app\Service\lottery\model;
class lottery
{
    public $lotteryTypes = array(
        '2' => '重庆时时彩',
        '8' => '新疆时时彩',
        '14' => '天津时时彩',
        '30' => '湖北快三',
        '9' => '江苏快三',
        '24' => '广东11选5',
        '26' => '山东11选5',
        '27' => '江西11选5',
        '28' => '福彩3D',
        '29' => '排列三/五',
        '6' => 'PK10'
    );
    /**
     * @var array
     */
    public $lottery_list = array(
        2 =>
            array(
                'lid' => '2',
                'name' => 'CQSSC',
                'cname' => '重庆时时彩',
                'lottery_type' => '1',
                'property_id' => '1',
                'description' => '时时彩',
                'codesum' => '5',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '00:05:00',
                                'end_time' => '01:55:00',
                                'cycle' => '300',
                                'end_sale' => '60',
                                'drop_time' => '60',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                        1 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '02:00:00',
                                'first_end_time' => '10:00:00',
                                'end_time' => '22:00:00',
                                'cycle' => '600',
                                'end_sale' => '60',
                                'drop_time' => '60',
                                'code_time' => '0',
                                'frag_sort' => '1',
                            ),
                        2 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '22:00:00',
                                'first_end_time' => '22:05:00',
                                'end_time' => '00:00:00',
                                'cycle' => '300',
                                'end_sale' => '60',
                                'drop_time' => '60',
                                'code_time' => '0',
                                'frag_sort' => '2',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|1,1,0',
                'issue_weeks' => '',
                'zx_max_comb' => '1000',
                'total_profit' => '0.150',
                'min_profit' => '0.000',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.12',
                                'gap' => '0.005',
                            ),
                        1 =>
                            array(
                                'from' => '0.12',
                                'to' => '0.128',
                                'gap' => '0.001',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '65',
                'status' => '8',
                'sort' => '2',
                'update_time' => '2017-03-08 03:10:50',
            ),
        6 =>
            array(
                'lid' => '6',
                'name' => 'PK10',
                'cname' => 'PK拾',
                'codesum' => '10',
                'lottery_type' => '8',
                'property_id' => '1',
                'description' => 'http://www.bwlc.gov.cn/help/pk10.jsp',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '09:07:00',
                                'end_time' => '23:57:00',
                                'cycle' => '300',
                                'end_sale' => '30',
                                'drop_time' => '30',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => '[n6]|1,1,1',
                'issue_weeks' => '',
                'zx_max_comb' => '1000',
                'total_profit' => '0.150',
                'min_profit' => '0.022',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.12',
                                'gap' => '0.005',
                            ),
                        1 =>
                            array(
                                'from' => '0.12',
                                'to' => '0.128',
                                'gap' => '0.001',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '10',
                'catch_interval' => '30',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-30 11:17:08',
            ),
        24 =>
            array(
                'lid' => '24',
                'name' => 'GD115',
                'cname' => '广东11选5',
                'codesum' => '5',
                'lottery_type' => '2',
                'property_id' => '2',
                'description' => '首期09:10开奖，最后一期23:00开奖，每10分钟一期，全天84期',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '09:10:00',
                                'end_time' => '23:00:00',
                                'cycle' => '600',
                                'end_sale' => '90',
                                'drop_time' => '90',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|0,0,0',
                'issue_weeks' => '',
                'zx_max_comb' => '990',
                'total_profit' => '0.150',
                'min_profit' => '0.050',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.10',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '45',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-08 03:11:51',
            ),
        8 =>
            array(
                'lid' => '8',
                'name' => 'XJSSC',
                'cname' => '新疆时时彩',
                'codesum' => '5',
                'lottery_type' => '1',
                'property_id' => '1',
                'description' => '10:00~02:00，10分钟一期，每天96期',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '02:10:00',
                                'first_end_time' => '10:10:00',
                                'end_time' => '02:00:00',
                                'cycle' => '600',
                                'end_sale' => '300',
                                'drop_time' => '300',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n2]|0,0,0',
                'issue_weeks' => '',
                'zx_max_comb' => '1000',
                'total_profit' => '0.150',
                'min_profit' => '0.022',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.12',
                                'gap' => '0.005',
                            ),
                        1 =>
                            array(
                                'from' => '0.12',
                                'to' => '0.128',
                                'gap' => '0.001',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '65',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-08 03:11:13',
            ),
        26 =>
            array(
                'lid' => '26',
                'name' => 'SD11Y',
                'cname' => '山东11选5',
                'codesum' => '5',
                'lottery_type' => '2',
                'property_id' => '2',
                'description' => '十一选五',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '08:35:00',
                                'end_time' => '22:55:00',
                                'cycle' => '600',
                                'end_sale' => '130',
                                'drop_time' => '130',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|0,0,0',
                'issue_weeks' => '',
                'zx_max_comb' => '990',
                'total_profit' => '0.150',
                'min_profit' => '0.050',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.10',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '78',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-04-06 13:54:23',
            ),
        28 =>
            array(
                'lid' => '28',
                'name' => 'FC3D',
                'cname' => '福彩3D',
                'codesum' => '3',
                'lottery_type' => '4',
                'property_id' => '2',
                'description' => '一天开一期,20:30官方截止，我们可在20:20分截止。',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '21:10:00',
                                'end_time' => '21:10:00',
                                'cycle' => '36000',
                                'end_sale' => '600',
                                'drop_time' => '600',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => '[n7]|1,1,1',
                'issue_weeks' => '',
                'zx_max_comb' => '1000',
                'total_profit' => '0.150',
                'min_profit' => '0.050',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.1',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '60',
                'catch_retry' => '10',
                'catch_interval' => '115',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-08 03:12:08',
            ),
        14 =>
            array(
                'lid' => '14',
                'name' => 'TJSSC',
                'cname' => '天津时时彩',
                'codesum' => '5',
                'lottery_type' => '1',
                'property_id' => '1',
                'description' => '首期09:09开奖，最后一期22:58开奖，10分钟一期，每天84期，不定时会提前一分钟08分的时候开，因此应统一按08分开奖。',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '09:08:00',
                                'end_time' => '22:58:00',
                                'cycle' => '600',
                                'end_sale' => '90',
                                'drop_time' => '90',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|0,0,0',
                'issue_weeks' => '',
                'zx_max_comb' => '1000',
                'total_profit' => '0.150',
                'min_profit' => '0.022',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.12',
                                'gap' => '0.005',
                            ),
                        1 =>
                            array(
                                'from' => '0.12',
                                'to' => '0.128',
                                'gap' => '0.001',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '65',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-08 03:12:00',
            ),
        27 =>
            array(
                'lid' => '27',
                'name' => 'JX115',
                'cname' => '江西11选5',
                'codesum' => '5',
                'lottery_type' => '2',
                'property_id' => '2',
                'description' => '首期09:10开奖，最后一期23:00开奖，每10分钟一期，全天84期，开奖准时。',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '09:10:00',
                                'end_time' => '23:00:00',
                                'cycle' => '600',
                                'end_sale' => '110',
                                'drop_time' => '110',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|0,0,0',
                'issue_weeks' => '',
                'zx_max_comb' => '990',
                'total_profit' => '0.150',
                'min_profit' => '0.050',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.10',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '45',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-05-15 18:44:07',
            ),
        9 =>
            array(
                'lid' => '9',
                'name' => 'JSKS',
                'cname' => '江苏快三',
                'codesum' => '3',
                'lottery_type' => '6',
                'property_id' => '3',
                'description' => '江苏快3 销售时间：每天 8：40--10：00 每10分钟一期 每天82期',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '08:40:00',
                                'end_time' => '22:10:00',
                                'cycle' => '600',
                                'end_sale' => '180',
                                'drop_time' => '60',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|1,1,0',
                'issue_weeks' => '',
                'zx_max_comb' => '216',
                'total_profit' => '0.300',
                'min_profit' => '0.150',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.12',
                                'gap' => '0.01',
                            ),
                        1 =>
                            array(
                                'from' => '0.12',
                                'to' => '0.15',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '-200',
                'catch_retry' => '5',
                'catch_interval' => '30',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-04-06 19:13:41',
            ),
        29 =>
            array(
                'lid' => '29',
                'name' => 'P3P5',
                'cname' => '排列三/五',
                'codesum' => '5',
                'lottery_type' => '1',
                'property_id' => '2',
                'description' => '一天开一期,20:30官方截止，我们可在20:20分截止。',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '20:10:00',
                                'end_time' => '20:30:00',
                                'cycle' => '36000',
                                'end_sale' => '600',
                                'drop_time' => '600',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => '[n7]|1,1,1',
                'issue_weeks' => '',
                'zx_max_comb' => '1000',
                'total_profit' => '0.150',
                'min_profit' => '0.050',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.1',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '60',
                'catch_retry' => '10',
                'catch_interval' => '115',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-08 03:12:13',
            ),
        30 =>
            array(
                'lid' => '30',
                'name' => 'HBKS',
                'cname' => '湖北快3',
                'codesum' => '3',
                'lottery_type' => '6',
                'property_id' => '3',
                'description' => '销售：9:00～22:00（78期）10分钟开奖　返奖59%',
                'settings' =>
                    array(
                        0 =>
                            array(
                                'is_use' => '1',
                                'start_time' => '00:00:00',
                                'first_end_time' => '09:10:00',
                                'end_time' => '22:00:00',
                                'cycle' => '600',
                                'end_sale' => '210',
                                'drop_time' => '210',
                                'code_time' => '0',
                                'frag_sort' => '0',
                            ),
                    ),
                'issue_rule' => 'Ymd-[n3]|1,1,0',
                'issue_weeks' => '',
                'zx_max_comb' => '216',
                'total_profit' => '0.300',
                'min_profit' => '0.150',
                'min_rebate_gaps' =>
                    array(
                        0 =>
                            array(
                                'from' => '0',
                                'to' => '0.12',
                                'gap' => '0.01',
                            ),
                        1 =>
                            array(
                                'from' => '0.12',
                                'to' => '0.15',
                                'gap' => '0.005',
                            ),
                    ),
                'yearly_start_closed' => '2017-01-27',
                'yearly_end_closed' => '2017-02-02',
                'catch_delay' => '0',
                'catch_retry' => '5',
                'catch_interval' => '30',
                'status' => '8',
                'sort' => '100',
                'update_time' => '2017-03-08 03:12:34',
            ),
    );

    /**
     * 初始化
     * lottery constructor.
     * @param int $lottery_id
     */
    public function __construct()
    {

    }

    /**
     * 获取彩种详情
     * @param int $lottery_id
     * @return mixed
     */
    public function getItem($lid = 1)
    {
        $list = $this->lottery_list;
        if (empty($list[$lid])) {
            return [];
        }
        return $list[$lid];
    }

    /**
     * 获取彩种列表
     * @param array $data
     * @return array
     */
    public function getLotreryList($data = [])
    {
        $list = $this->lottery_list;
        foreach ($list as $k => $v) {
            $list[$k]['lottery_type'] = $this->lotteryTypes[$v['lid']];
        }
        return $list;
    }

    /**
     * 获取彩种列表
     * @param array $data
     * @return array
     */
    public function getLotList($data = [])
    {
        $list = $this->lottery_list;
        return $list;
    }

    /**
     * 后台获取彩种列表
     * @param array $data
     * @return array
     */
    public function getlottery()
    {
        $list = $this->lotteryTypes;
        return $list;
    }


}