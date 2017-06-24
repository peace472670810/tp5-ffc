<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 11:11
 */

namespace app\Service\lottery\business;

use app\Service\lottery\model\Issues as issues_model;

class issues
{
    /**
     * 错误码
     * @var array
     */
    public static $error_code = [
        '80000000' => '彩种id参数有误！',
        '80000003' => '玩法组id参数有误！',
        '80000002' => '参数有误！',
        '80000001' => '不存在该玩法组！',
    ];
    public $model = null;

    public function __construct()
    {
        $this->model = new issues_model();
    }

    /**
     * 奖期列表
     */
    public function getIssueList($data = [])
    {
        $arr = [];
        $arr['lid'] = $data['lid'];
        if (empty($arr['lid'])) {
            return put_encode(false, '80000000', self::$error_code['80000000']);
        }
        $arr['before_date'] = empty($data['before_date'])?'':$data['before_date'];
        $arr['belong_date'] = empty($data['belong_date'])?'':$data['belong_date'];
        $arr['start_sale_time1'] =  empty($data['start_sale_time1'])?'':$data['start_sale_time1'];
        $arr['start_sale_time2'] =  empty($data['start_sale_time2'])?'':$data['start_sale_time2'];
        $arr['end_sale_time1'] =  empty($data['end_sale_time1'])?'':$data['end_sale_time1'];
        $arr['end_sale_time2'] =  empty($data['end_sale_time2'])?'':$data['end_sale_time2'];
        $arr['status_code'] =  empty($data['status_code'])?'':$data['status_code'];
        $arr['order_by'] =  empty($data['order_by'])?'':$data['order_by'];
        $arr['start'] =  empty($data['start'])?0:$data['start'];
        $arr['amount'] = ($data['amount']<=0)?DEFAULT_PER_PAGE:$data['amount'];
        $list = $this->model->getIssueList($arr);
        return put_encode($list,'','');
    }

    /**
     * 获取当前奖期
     */
    public function getCurrentIssue($data = []){
        $time = time();
        $belongDate = date('Y-m-d', $time);
        //新疆时时彩 00-02时间跨天的期号是属于前一天的。
        if ($data['lid'] == 8) {
            $hour = date('H', $time);
            if ($hour == '00' || $hour == '01') {
                $belongDate = date('Y-m-d', $time - 60 * 60 * 24);
            }
        }
    }
    /**
     * 根据彩种生成奖期
     */
    public function addIssue($data = [])
    {

    }

    /**
     * 录入奖期号
     */
    public function addCode()
    {

    }

    /**
     * 改变奖期状态
     */
    public function editIssueStatus()
    {

    }

}