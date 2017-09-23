<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 11:11
 */

namespace app\Service\lottery\business;

use app\Service\lottery\model\Issues as issues_model;
use think\Log;
use app\Service\lottery\business\config as config_model;
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
        '80000004' => '没有可以追的奖期！',
        '80000005' => '彩种id 有误！',
        '80000006' => '没有当前奖期,暂未开盘！',
    ];
    public   $lottery_name = [
        '2' => '重庆时时彩',
        '26'=>'山东11选5',
        '8' => '新疆时时彩',
        '27'=>' 江西11选5',
        '24'=> '广东11选5',
        '14'=> '天津时时彩',
        '28'=> '福彩3D',
        '29'=> '排列三/五',
        '9' => '江苏快三',
        '30'=> '湖北快3',
        '6' => ' 北京赛车'
    ];
    public $model = null;
    public  $conf_mode = null;
    public function __construct()
    {
        $this->model = new issues_model();
        $this->conf_mode = new config_model();
    }

    /**
     * 生成前端展示号码格式
     * 11选5 ，10，5，6，4 变成 05 10 05 06 04
     */
    protected function changeCode($lid,$code = ''){
        $str = '';
        switch ($lid){
            case 26:
            case 27:
            case 24:
                $arr = explode(',',$code);
                foreach ($arr as $v){
                    if($v<10){
                        $str .= " 0".$v;
                    }else{
                        $str .= " 10";
                    }
                }
            break;
            default:
                $str = $code;
        }
        return trim($str);
    }
    /**
     * 前台获取奖期列表
     */
    public function getIssueList($data = [])
    {
        $arr = [];
        $arr['lid'] = $data['lid'];
        if (empty($arr['lid'])) {
            return put_encode(false, '80000000', self::$error_code['80000000']);
        }
        $arr['status_code'] = empty($data['status_code']) ? '' : $data['status_code'];
        $arr['is_mobile'] = empty($data['is_mobile'])?0:1;
        $list = $this->model->getIssueList($arr);
        $issues = [];
        foreach ($list as $v){
            $issues[] = array(
                'issue_id' => $v['ds_qishu'],
                'issue' => $v['ds_qishu'],
                'code' => $v['ds_balls'],
            );
        }
        return put_encode($issues, '', '');
    }
    /**
     * 获取当前奖期
     */
    public function getCurrentIssue($data = [])
    {
        $arr['lid'] = empty($data['lid']) ? 2 : $data['lid'];
//        $stop_time = $this->conf_mode->getLotterytConf($arr);
//        $arr['ds_val'] = $stop_time;
        $issueInfo = $this->model->getCurIssue($arr);
        if (empty($issueInfo)) {
            $cur['issueInfo'] = [
                'issue_id' => '',
                'issue' => '',
                'end_time' => '',
                'input_time' => '',
                'state' => '',
                'waite_time' => 0,
            ];
        } else{
            $cur['issueInfo'] = [
                'issue_id' => $issueInfo['ds_qishu'],
                'issue' => $issueInfo['ds_qishu'],
                'end_time' => $issueInfo['ds_time_stop'],
                'input_time' => $issueInfo['ds_time_open'],
                'state' =>  $issueInfo['ds_state'],
                'waite_time' => strtotime($issueInfo['ds_time_draw']) - time(),
            ];
        }
        $lastIssueInfo =$this->model->getLastOpenIssue($arr);
        if (!empty($lastIssueInfo)) {
            $cur['lastIssueInfo'] = [
                'issue_id' => $lastIssueInfo['ds_qishu'],
                'issue' => $lastIssueInfo['ds_qishu'],
                'code' => $lastIssueInfo['ds_balls'],
            ];
        }else{
            $cur['lastIssueInfo'] = [
                'issue_id' => '',
                'issue' => '',
                'code' => '',
            ];
        }
        return put_encode($cur, '', '');
    }

    /**
     * 获取指定彩种所有的当前奖期
     */
    public function getAllCurrentIssue($data = []){
        $arr['lids'] = $data['lids'];
        if(empty($arr)){
            return put_encode(false,'80000005',self::$error_code['80000005']);
        }
        $arr = explode(',',$arr['lids']);
//        $lid_conf = $this->conf_mode->getConfByLots($arr);
        $list = $this->model->allCurrentIssue($arr);
        return  put_encode($list,'','');
    }
    /**
     * 得到上一期的开奖结果
     * @param array $data
     */
    public function lastIssueInfo($data = [])
    {
       $arr['lid'] = empty($data['lid']) ? 2 : $data['lid'];
       $last = $this->model->getLastOpenIssue($arr);
       if(empty($last)){
           $lastIssueInfo = array(
               'issue_id' => '',
               'issue' => '',
               'code' => '',
           );
       }else{
           $lastIssueInfo = array(
               'issue_id' => $last['ds_qishu'],
               'issue' => $last['ds_qishu'],
               'code' => $last['ds_balls'],
           );
       }
        return put_encode($lastIssueInfo, '', '');
    }

    /**
     * 点击追号
     * 获取当前彩种可追的期数
     */
    public function  getTraceIssue($data = []){
        $arr['lid'] = $data['lid'];
        $tracelist['tracelist'] = $this->model->traceIusse($arr);
        foreach ($tracelist['tracelist'] as $v){
            $tracelist['issuelist'][] = $v['ds_qishu'];
        }
        return  put_encode($tracelist,'','');
    }

    /**
     *根据期数及彩种奖期
     */
    public function getIusse($data = []){
        $arr['lid'] = $data['lid'];
        $arr['issue'] = $data['issue'];
        $arr['time'] = $data['time'];
        return  put_encode($this->model->getIusse($arr),'','');
    }
    public function getHadOpenIusse($data = []){
        $arr['lid'] = $data['lid'];
        $arr['issue'] = $data['issue'];
        return  put_encode($this->model->HadOpenIusse($arr),'','');
    }
    /**
     * 获取追号期数列表
     */
    public function getTraceIusse($data = []){
        $arr['status'] = empty($data['status']) ? 0:1;
        $arr['lid']= $data['lid'];
        $arr['issue'] = $data['issue'];
        $res = $this->model->TraceIssue($arr);
        $list = [];
        foreach ($res as $k=>$v){
            $list[$v['ds_qishu']] = $v;
        }
        return put_encode($list,'','');
    }


    /**
     * 获取昨天以前的追号期数列表
     */
    public function getHadTraceIusse($data = []){
        $arr['lid']= $data['lid'];
        $arr['issue'] = $data['issue'];
        $res = $this->model->hadTraceIssue($arr);
        $list = [];
        foreach ($res as $k=>$v){
            $list[$v['ds_qishu']] = $v;
        }
        return put_encode($list,'','');
    }
    /**
     * 追号撤单 获取期数列表
     */
    public function getTraceIusseByIssues($data = []){
        $arr['status'] = empty($data['status']) ? 0:1;
        $arr['lid']= $data['lid'];
        $arr['issue'] = $data['issue'];
        $res = $this->model->TraceIusseByIssues($arr);
        return put_encode($res,'','');
    }
    /**
     * 获取手机端可追追号
     */
    public function getMobileTraceIssue($data = []){
        $arr = [];
        $arr['lid'] = $data['lid'];
        $list = $this->model->MobileTraceIssue($arr);
        if(empty($list)){
            return put_encode(false,'80000004',self::$error_code['80000004']);
        }else{
            $issueList = [];
           foreach ($list as $v){
               $issueList[] = $v['ds_qishu'];
           }
            return put_encode($issueList,'','');
        }
    }
    /**
     * 根据奖期获取奖期信息
     * @param array $data
     */
    public function getIusseByIssue($data = []){
        $arr['lid']= $data['lid'];
        $arr['issue'] = $data['issue'];
        $res = $this->model->getIusseByIssue($arr);
        if(empty($res)){
            return put_encode(false,'','');
        }
        return put_encode($res,'','');
    }

    /**
     * 手机端普通追号
     */
    public  function getMobileTraceIsssue($data = []){
        $arr['lid']= $data['lid'];
        $arr['traceCount'] = $data['traceCount'];
        $res = $this->model->MobileTraceIsssue($arr);
        if(empty($res)){
            return put_encode(false,'','');
        }
        return put_encode($res,'','');
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
     /**
     * 走势图得到最近有开奖的奖期默认50期数
     */
    public function getChart($data=[]){
         if(!is_numeric($data['lid'])){
             return put_encode(false, '80000000', self::$error_code['80000000']);
         }
         if(!is_numeric($data['issueNum'])){
            return put_encode(false, '81000001', self::$error_code['81000001']);
         }
         if(!is_numeric($data['issueNum'])){
            return put_encode(false, '81000001', self::$error_code['81000001']);
         }
          $issues= $this->model->getChart($data);
           asort($issues);

        $codes = array();
        foreach ($issues as $k => $v) {
            $codes[$v['ds_qishu']]['issue'] = $v['ds_qishu'];
            $codes[$v['ds_qishu']]['ds_qishu'] = $v['ds_qishu'];
            $codes[$v['ds_qishu']]['openNumber']=explode(",", $v['ds_balls']);         
            if($data['lottery_type']=='6'){
                $text=json_decode($v['ds_miss'],true);      
                $codes[$v['ds_qishu']]['miss_info']=$text['ball'];
                $codes[$v['ds_qishu']]['sum']=$text['sum'];
                $codes[$v['ds_qishu']]['sum'] = array_sum($codes[$v['ds_qishu']]['openNumber']);
                    $oddnum = $evennum = $bignum = $smallnum = 0;
                    for ($i = 0, $len = count($codes[$v['ds_qishu']]['openNumber']); $i < $len; $i++) {
                        if ( $codes[$v['ds_qishu']]['openNumber'][$i] % 2 == 0) {
                            $evennum++;
                        } else {
                            $oddnum++;
                        }
                        if ( $codes[$v['ds_qishu']]['openNumber'][$i] <= 3) {
                            $smallnum++;
                        } else {
                            $bignum++;
                        }
                    }
                    $codes[$v['ds_qishu']]['oddnum'] = $oddnum;
                    $codes[$v['ds_qishu']]['evennum'] = $evennum;
                    $codes[$v['ds_qishu']]['bignum'] = $bignum;
                    $codes[$v['ds_qishu']]['smallnum'] = $smallnum;
                    $codes[$v['ds_qishu']]['miss_k3'] = isset($text) ? $text : array();
            }elseif($data['lottery_type']=='2'){
                 $arra=array('01','02','03','04','05','06','07','08','09','10','11');
                 $text=json_decode($v['ds_miss'],true);
                 foreach ($text as $key => $value) {
                    foreach ($value as $ko => $vo){
                       $arr[$key][$arra[$ko]]=$vo;
                    }                   
                 }
                  
                 $codes[$v['ds_qishu']]['miss_info']=$arr;
            }elseif($data['lottery_type']=='8'){
                 $arra=array('01','02','03','04','05','06','07','08','09','10');
                 $text=json_decode($v['ds_miss'],true);
                 foreach ($text as $key => $value) {
                    foreach ($value as $ko => $vo){
                       $arr[$key][$arra[$ko]]=$vo;
                    }                   
                 }
                  
                 $codes[$v['ds_qishu']]['miss_info']=$arr;
            }else{
                 $codes[$v['ds_qishu']]['miss_info']=json_decode($v['ds_miss'],true);
            }
          
        }
          return put_encode($codes,'','');
    }

}