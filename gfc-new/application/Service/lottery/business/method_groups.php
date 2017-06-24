<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/30
 * Time: 19:53
 */

namespace app\Service\lottery\business;

use app\Service\lottery\model\Method_groups as mg_model;
use app\Service\lottery\business\methods as method_model;
use app\Service\lottery\business\prizes as prize_model;
class method_groups
{
    public  $model = null;
    public static  $error_code = [
        '70000000' => '彩种id参数有误！',
        '70000003' => '玩法组id参数有误！',
        '70000002' => '参数有误！',
        '70000001' => '不存在该玩法组！',
    ];

    public function __construct()
    {
        $this->model = new mg_model();
    }

    /**
     * 根据彩种获取玩法组列表
     * @param $lid
     * @return string
     */
    public  function getMethodGroupList($data){

        if(!is_numeric($data['lid'])){
            return   put_encode(false,'70000000',self::$error_code['70000000']);
        }
        $list =  $this->model->getMethodGroups($data['lid']);
        if($list){
            return  put_encode($list,'','');
        }
        return   put_encode(false,'70000001',self::$error_code['70000001']);
    }

    /**
     * 获取玩法组详情
     * @param $mg_id
     */
    public function getMethodGroupDetail($data){
        if(!is_numeric($data['mg_id'])){
            return   put_encode(false,'70000003',self::$error_code['70000003']);
        }
        if(!is_numeric($data['mg_id'])){
            return  put_encode(false,'70000002',self::$error_code['70000002']);
        }
        $detail = $this->model->getMethodGroupsDetail($data['mg_id']);
        if($detail){
            return  put_encode($detail,'','');
        }
        return  put_encode(false,'70000001',self::$error_code['70000001']);
    }
    /**
     * 获取玩法组 玩法及对应奖金组
     * mg_id
     * mg_name
     * childs 玩法 + 对应奖金组
     */
    public function getMethodGroupsByLid($data = []){
        if(!is_numeric($data['lid'])){
            return   put_encode(false,'70000000',self::$error_code['70000000']);
        }
        $method_model = new method_model();
        $prize_model = new prize_model();
        $mglist = $this->model->getMethodGroups($data['lid']);
        $mlist =  $method_model->getMethodBylid(['lid'=>$data['lid']]);
        $plist = json_decode($prize_model->getPrizeByLid(['lid'=>$data['lid']]),true);
        $plist = $plist['data'];
        $arr = [];
        $prizes  = [];
        $prize = 0;
        $childs = [];
        //玩法组下面的所有玩法及奖金组
        foreach ($mglist as $k1 => $v1){
            $arr[$k1]['mg_id'] = $v1['mg_id'];
            $arr[$k1]['mg_name'] = $v1['mg_name'];
            foreach ($mlist as $k2 => $v2){
                if($v2['m_mg_id'] == $v1['mg_id']){
                    $childs['can_input'] = $v2['m_can_input'];
                    $childs['cname'] = $v2['m_cname'];
                    $childs['description'] = $v2['m_description'];
                    $childs['field_def'] = $v2['m_field_def'];
                    $childs['lottery_id'] = $v2['m_lid'];
                    $childs['method_id'] = $v2['m_id'];
                    $childs['mg_name'] = $v1['mg_name'];
                    $childs['name'] = $v2['m_name'];
                    foreach ($plist as $k3 => $v3){
                        if($v3['p_m_id'] == $v2['m_id']){
                            $prizes[$v3['p_level']] = $v3['p_prize'];
                            if($v3['p_level'] == 1){
                                $prize = $v3['p_prize'];
                            }
                        }
                    }
                    //选出最大的
                    $childs['prize'] = $prizes;
                    $childs['prizes'] = $prize;
                    $childs['sample'] = '';
                    $childs['team'] = $v2['m_team'];
                    $arr[$k1]['childs'][] =  $childs;
                }
            }
        }
        return  json_encode($arr);
    }
}