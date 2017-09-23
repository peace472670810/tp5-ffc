<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 11:16
 */

namespace app\Service\lottery\model;
use think\Model;
use think\Log;

class Issues extends  Model
{
    protected  $connection = [
    // 数据库类型
            'type'        => 'mysql',
            // 数据库连接DSN配置
            'dsn'         => '',
            // 服务器地址
            'hostname'    => '10.10.197.2',
            // 数据库名
            'database'    => 'ds_ffc_periods',
            // 数据库用户名
            'username'    => 'ffc_new',
            // 数据库密码
            'password'    => 'qweqweqwe123',
            // 数据库连接端口
            'hostport'    => '3306',
            // 数据库连接参数
            'params'      => [],
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => 'ds_',
    ];
    /**
     * 获取奖期列表
     */
    public function getIssueList($data = []){
        $i_lid = $data['lid'];
        $time = date('Y-m-d');
        if($data['is_mobile']){
            $table = 'ds_pankou_'.$i_lid;
            $sql = "SELECT * FROM $table WHERE 1 AND ds_state={$data['status_code']} AND ds_time_open>$time ORDER BY ds_qishu DESC limit 120";
            $data = $this->query($sql);
            if(count($data)<100){
                $table = 'ds_kaijiang_'.$i_lid;
                $sql = " select * from $table  ORDER BY ds_qishu DESC  LIMIT 120";
                $data = $this->query($sql);
            }
        }else{
            $table = 'ds_pankou_'.$i_lid;
            $sql = "SELECT * FROM $table WHERE 1 AND ds_state={$data['status_code']} ORDER BY ds_qishu DESC   LIMIT 10";
            $data = $this->query($sql);
            if(count($data)<10){
                $table = 'ds_kaijiang_'.$i_lid;
                $sql = " select * from $table  ORDER BY ds_qishu DESC  LIMIT 10";
                $data = $this->query($sql);
            }
        }

        return $data;
    }
    /**
     * 生成奖期
     */
    public function addIussus($data = []){

    }
    /**
     *  获取当前彩种可追号的期数
     */
    public  function traceIusse($data = []){
        $ds_lid = $data['lid'];
        $table =  'ds_pankou_'.$ds_lid;
        $time = date("Y-m-d H:i:s",time());
        $sql = "select  ds_qishu,ds_lid,ds_time_open,ds_time_stop,ds_time_draw from $table where ds_state<3 and ds_time_draw>'{$time}' order by ds_qishu ASC ";
        $tracelist = $this->query($sql);
        return $tracelist;
    }

    /**
     * 根据彩种id及期数获取奖期详情
     */
    public function getIusse($data = []){
        $time = $data['time']; 
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $qishu = $data['issue'];
        $sql = "select ds_qishu,ds_lid,ds_time_open,ds_time_stop,ds_time_draw from  $table  where ds_qishu=$qishu and ds_state=1 and ds_time_open <= '{$time}' and ds_time_stop >'{$time}' ";
        $list =$this->query($sql);
        return empty($list)?[]:$list[0];
    }
    public function HadOpenIusse($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_kaijiang_'.$ds_lid;
        $qishu = $data['issue'];
        $sql = "select ds_qishu,ds_balls from  $table  where ds_qishu=$qishu limit 1 ";
        $list =$this->query($sql);
        return empty($list)?[]:$list[0];
    }
    /**
     * 根据期数字符串获取期数列表
     * 0 还未开奖的期数
     * 1全部
     */
    public function TraceIssue($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $qishu = $data['issue'];
        if(empty($data['status'])){
            $sql = "select * from $table  where ds_qishu in($qishu) and ds_state<=1 order by  ds_qishu ASC ";
            $list =$this->query($sql);
        }else{
            $sql = "select * from $table  where ds_qishu in($qishu)  order by  ds_qishu ASC ";
            $list =$this->query($sql);
            if (empty($list)){
                $table = 'ds_kaijiang_'.$ds_lid;
                $sql = "select * from $table  where ds_qishu in($qishu)  order by  ds_qishu ASC ";
            }
            $list =$this->query($sql);
        }
        return $list;
    }

    /**
     * 获取已过的追号期数列表
     */
    public function hadTraceIssue($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_kaijiang_'.$ds_lid;
        $qishu = $data['issue'];
        $sql = "select * from $table  where ds_qishu in($qishu)  order by  ds_qishu ASC ";
        $list =$this->query($sql);
        return $list;
    }
    /**
     * 追号撤单 获取期数列表
     * @param array $data
     * @return mixed
     */
    public function TraceIusseByIssues($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $qishu = $data['issue'];
        $sql = "select * from $table  where ds_qishu in($qishu) and ds_state<1 order by  ds_qishu ASC ";
        $list =$this->query($sql);
        return $list;
    }
    /**
     * 手机端可以追号期数
     */
    public function MobileTraceIssue($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $time = date("Y-m-d H:i:s");
        $sql = "select ds_qishu  from $table  where ds_state<=1  and  ds_time_stop>'{$time}' order by  ds_qishu ASC ";
        $list =$this->query($sql);
        return $list;
    }
    /**
     *获取当前奖期
     */
    public function getCurIssue($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $time = date('Y-m-d H:i:s');
        $sql = " select ds_qishu,ds_time_open,ds_time_stop,ds_time_draw,ds_state from $table where ds_time_draw>='{$time}' and ds_time_open<='{$time}'   limit 1  ";
        $curlist = $this->query($sql);
        if(empty($curlist)){
            return  [];
        }
        return  $curlist[0];
    }
    /**
     * 得到当前彩种列表所有的当前奖期
     * //        $curlist = [];
    //        foreach ($data as $k=>$v){
    //            $table = 'ds_pankou_'.$v;
    //            $time =date("Y-m-d H:i:s");
    //            $sql = " select ds_qishu,ds_time_open,ds_time_stop,ds_time_draw,ds_state from $table where ds_time_draw>='{$time}' and ds_time_open<='{$time}'  limit 1 ";//由于表结构因数只能一个一个去查
    //            $cur = $this->query($sql);
    //            if(empty($cur)){
    //                $curlist[$v] = [
    //                    'state' => '',
    //                    'issue' => '',
    //                    'end_time' => '',
    //                    'input_time' => '',
    //                    'lid' => $v,
    //                ];
    //            }else{
    //                $curlist[$v] =[
    //                    'state' => $cur[0]['ds_state'],
    //                    'issue' => $cur[0]['ds_qishu'],
    //                    'end_time' => $cur[0]['ds_time_stop'],
    //                    'input_time' =>  $cur[0]['ds_time_open'],
    //                    'lid' => $v,
    //                ];
    //            }
    //        }
     */
    public  function allCurrentIssue($data = []){
        $curlist = [];
        $sql = '';
        foreach ($data as $k=>$v){
            $table = 'ds_pankou_'.$v;
            $time =date("Y-m-d H:i:s");
            $sql .= " select ds_lid,ds_qishu,ds_time_open,ds_time_stop,ds_time_draw,ds_state from $table where ds_time_draw>='{$time}' and ds_time_open<='{$time}' UNION  ALL ";//由于表结构因数只能一个一个去查
        }
        $sql = substr($sql,0,strlen($sql)-12);
        $cur = $this->query($sql);
        foreach ($cur as $k=>$v){
            if(empty($v)){
                $curlist[$v['ds_lid']] = [
                    'state' => '',
                    'issue' => '',
                    'end_time' => '',
                    'input_time' => '',
                    'lid' => $v['ds_lid'],
                ];
            }else{
                $curlist[$v['ds_lid']] =[
                    'state' => $v['ds_state'],
                    'issue' => $v['ds_qishu'],
                    'end_time' => $v['ds_time_stop'],
                    'input_time' =>  $v['ds_time_open'],
                    'lid' => $v['ds_lid'],
                ];
            }
        }
        return $curlist;
    }

    /**
     * 得到最近有开奖的奖期
     */
    public function getLastOpenIssue($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $sql = "select  ds_qishu,ds_time_open,ds_time_stop,ds_time_draw,ds_state,ds_balls from $table where ds_state=3 order by ds_qishu desc  limit 1 ";
        $last = $this->query($sql);
        if(empty($last)){
            $table = 'ds_kaijiang_'.$ds_lid;
            $sql = "select * from $table  order by ds_qishu desc  limit 1 ";
            $last = $this->query($sql);
            return  $last[0];
        }
        return $last[0];
    }


    /**
     * 是手机端普通追号获取奖期
     * 获取当前奖期及最近要追的期数
     */
    public function MobileTraceIsssue($data = []){
        $ds_lid = $data['lid'];
        $table = 'ds_pankou_'.$ds_lid;
        $count = $data['traceCount'];
        $time = date('Y-m-d H:i:s');
        $sql = "select * from $table where ds_state<2 and ds_time_stop>'{$time}' order by ds_qishu ASC limit $count ";
        $curlist = $this->query($sql);
        return  $curlist;
    }
    /**
     * 根据奖期获取期数详情
     */
    public  function getIusseByIssue($data = []){
        $ds_lid = $data['lid'];
        $issue = $data['issue'];
        $table = 'ds_pankou_'.$ds_lid;
        $sql = "select * from $table where ds_qishu=$issue  limit 1 ";
        $list = $this->query($sql);
        if(empty($list)){
            $table = 'ds_kaijiang_'.$ds_lid;
            $sql = "select * from $table where ds_qishu=$issue  limit 1 ";
            $list = $this->query($sql);
            if(empty($list)){
                return  [];
            }
            return  $list[0];
        }
        return $list[0];
    }
    /**
     *修改期数状态
     */
    public function editStatus($data = []){
    }
    /**
     * 走势图得到最近有开奖的奖期默认50期数
     */
    public function getChart($data=[]){
        $ds_lid = $data['lid'];
        $issueNum=$data['issueNum'];
        $table = 'ds_kaijiang_'.$ds_lid;
        $sql = "select * from $table where ds_is_pay='1' and ds_is_cancel='0' order by ds_qishu desc  limit $issueNum ";
        return $this->query($sql);
    }
    
}

