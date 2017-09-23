<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/7/4
 * Time: 10:35
 */

namespace app\Service\lottery\business;
use app\Service\lottery\model\Config as ds_conf;
use Nocache\mcache;
use think\Db;
use think\image\Exception;
use think\Log;
use app\Service\DS\business\issue as DS;
class config
{
    public static $error_code = [
        '9000000000' => '彩种参数错误!',
        '9000000001' => '传入配置参数错误!',
        '9000000002' => '更新失败！',
        '9000000003' => '系统配置参数错误！',
        '9999999999'=>'接口调用失败！！！',
        '9999999910'=>'该彩种已暂时停止运营！'
    ];
    public $lotteryConf = [
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
    public $conf_model = null;
    public $memcache = null;
    public function __construct()
    {
        $this->conf_model = new ds_conf();
        $this->memcache = new mcache();
    }
    /**
     *获取彩种配置信息
     */
    public function getLotterytConf($data = []){
        $value = 'G_PROCESS_STOP_ORDER_'.$data['lid'];
        $ds_cache = $this->memcache->get('ds_lottery',$value);
        if(empty($ds_cache)){
            $ds_cache = $this->conf_model->getLotConf($value);
            $this->memcache->set('ds_lottery',$value,$ds_cache,60);
        }
        return $ds_cache;
    }
    /**
     * 根据彩种列表获取彩种配置
     */
    public function getConfByLots($arr = []){
        $sql = '';
        foreach ($arr as $k=>$v){
            $value = 'G_PROCESS_STOP_ORDER_'.$v;
            $sql .="select ds_key as lid,ds_val as value from ds_config where ds_key='{$value}'   UNION ALL ";
        }
        $sql = substr($sql,0,strlen($sql)-11);
        $lotconfs = $this->conf_model->query($sql);
        return $lotconfs;
    }
    /**
     *  系统初始值设定
     */
    public function getSystemConf(){
        $list = $this->conf_model->query("select * from ds_config where ds_key like 'SYSTEM_%'");
        $arr = [];
        foreach ($list as $k=>$v){
            if($v['ds_key'] == 'SYSTEM_WEB_STATUS'){
                $arr['status']['web_status'] = $v['ds_val'];
                $arr['status']['name'] = 'SYSTEM_WEB_STATUS';
            }
            if($v['ds_key'] == 'SYSTEM_XIAOXI_START'){
                $arr['start']['start_time'] = $v['ds_val'];
                $arr['start']['name'] = 'SYSTEM_XIAOXI_START';
            }
            if($v['ds_key'] == 'SYSTEM_XIAOXI_STOP'){
                $arr['end']['end_time'] = $v['ds_val'];
                $arr['end']['name'] = 'SYSTEM_XIAOXI_STOP';
            }
        }
        return  put_encode($arr,'','');
    }

    /**
     * 系统初始值修改
     */
    public function editSystemConf($data = []){
        if(!isset($data['SYSTEM_WEB_STATUS'])){
            return  put_encode(false,'9000000003',self::$error_code['9000000003']);
        }
        if(!isset($data['SYSTEM_XIAOXI_START'])){
            return  put_encode(false,'9000000003',self::$error_code['9000000003']);
        }
        if(!isset($data['SYSTEM_XIAOXI_STOP'])){
            return  put_encode(false,'9000000003',self::$error_code['9000000003']);
        }
       try{
        $this->conf_model->startTrans();
        $this->conf_model->query("update ds_config set ds_val='{$data['SYSTEM_WEB_STATUS']}' where ds_key='SYSTEM_WEB_STATUS' ");
        $this->conf_model->query("update ds_config set ds_val='{$data['SYSTEM_XIAOXI_START']}' where ds_key='SYSTEM_XIAOXI_START' ");
        $this->conf_model->query("update ds_config set ds_val='{$data['SYSTEM_XIAOXI_STOP']}' where ds_key='SYSTEM_XIAOXI_STOP' ");
        $this->conf_model->commit();
        return put_encode(true,'','修改成功！');
       }catch (Exception $e){
           $this->conf_model->rollback();
           Log::record($e->getMessage(),'error');
           return put_encode(false,'','修改失败！');
       }
    }
    /**
     * 获取彩种配置信息
     */
    public function getLidListConf(){
        $lidlist = $this->conf_model->getLotConfList();
        $lotteryConf = $this->lotteryConf;
        $arr = [];
        foreach ($lotteryConf as $k=>$v){
            foreach ($lidlist as $key=>$val){
                preg_match("/^G_PROCESS_STOP_ORDER_(\d+)/",$val['ds_key'],$match1);//提前封盘时间
                if(!empty($match1)){
                    if($k == $match1[1] ){
                        $arr[$k]['lid'] = $k;
                        $arr[$k]['name'] = $v;
                        $arr[$k]['G_PROCESS_STOP_ORDER'] = $val['ds_val'];
                    }
                }
            }
            foreach ($lidlist as $key=>$val){
                preg_match("/^G_ON_OFF_(\d+)/",$val['ds_key'],$match2);//运营状态
                if(!empty($match2)){
                    if($k == $match2[1] ){
                        $arr[$k]['G_ON_OFF'] = $val['ds_val'];
                    }
                }
            }
            foreach ($lidlist as $key=>$val){
                preg_match("/^G_OPEN_(\d+)/",$val['ds_key'],$match3);//自动开盘
                if(!empty($match3)){
                    if($k == $match3[1] ){
                        $arr[$k]['G_OPEN'] = $val['ds_val'];
                    }
                }
            }
            foreach ($lidlist as $key=>$val){
                preg_match("/^G_TASK_(\d+)/",$val['ds_key'],$match4);//自动任务
                if(!empty($match4)){
                    if($k == $match4[1] ){
                        $arr[$k]['G_TASK'] = $val['ds_val'];
                    }
                }
            }
        }
        $data['list'] = $lotteryConf;
        $data['conf'] = $arr;
        return  put_encode($data,'','');
    }
    /**
     * 手机端获取某个彩种运营状态 下注的时候也采用
     */
    public function getLidStatus($data = []){
        $on_off = 'G_ON_OFF_'.$data['lid'];
        $res =$this->conf_model->query("select * from  ds_config  where ds_key='{$on_off}' ");
        if(empty($res)){
            return put_encode(false,'9999999910',self::$error_code['9999999910']);
        }else{
            if($res[0]['ds_val']){
                return put_encode(true,'','');
            }else{
                return put_encode(false,'9999999910',self::$error_code['9999999910']);
            }
        }
    }
    /**
     * pc 端获取彩种运营状态
     */
    public function getLidStatusList($data = []){
        $lids = $data['lids'];
        $sql = "select * from ds_config where ds_key in( ";
        foreach ($lids as $v){
            $sql .="  'G_ON_OFF_{$v}',";
        }
        $sql = rtrim($sql,',');
        $sql .= ")";
        $res =$this->conf_model->query($sql);
        $stopIds = [];
        foreach ($res as $v){
            if($v['ds_val'] == 0){
                preg_match('/^G_ON_OFF_(\d+)/',$v['ds_key'],$martch);
                $stopIds[] = $martch[1];
            }
        }
        return put_encode($stopIds,'','');
    }
    /**
     * 修改彩种配置信息
     */
    public function editLidConf($data = []){
        $on_off = 'G_ON_OFF_'.$data['lid'];
        $open = 'G_OPEN_'.$data['lid'];
        $task = 'G_TASK_'.$data['lid'];
        $stop_time = 'G_PROCESS_STOP_ORDER_'.$data['lid'];
        if(empty($data['lid'])){
            return  put_encode(false,'9000000000',self::$error_code['9000000000']);
        }
        if(!isset($data[$on_off])){
            return  put_encode(false,'9000000001',self::$error_code['9000000001']);
        }
        if(!isset($data[$open])){
            return  put_encode(false,'9000000001',self::$error_code['9000000001']);
        }
        if(!isset($data[$task])){
            return  put_encode(false,'9000000001',self::$error_code['9000000001']);
        }
        if(!isset($data[$stop_time])){
            return  put_encode(false,'9000000001',self::$error_code['9000000001']);
        }
        $sql="select ds_val from ds_config where ds_key='$stop_time'";
        $time= $this->conf_model->query($sql);
        if($time['0']['ds_val'] !== $data[$stop_time]){
            $text['Lid']=$data['lid'];
            $text['StopTime']=$data[$stop_time];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('u_name');
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('pankou_url'));
            $datas=json_decode($datas,true);
            if(!$datas['Result']){
                 Log::record(self::$error_code['9999999999'].$datas['Message'],'error');
                 return put_encode(false,'9999999999',self::$error_code['9999999999'].$datas['Message']);
            }
        }
        try{
            $this->conf_model->startTrans();
            $sql1 = "update ds_config set ds_val='{$data[$on_off]}' where ds_key='{$on_off}'";
            $this->conf_model->query($sql1);
            $sql2 = "update ds_config set ds_val='{$data[$open]}' where ds_key='{$open}'";
            $this->conf_model->query($sql2);
            $sql3 = "update ds_config set ds_val='{$data[$task]}' where ds_key='{$task}'";
            $this->conf_model->query($sql3);
            $sql4 = "update ds_config set ds_val='{$data[$stop_time]}' where ds_key='{$stop_time}'";
            $this->conf_model->query($sql4);
            $this->conf_model->commit();
            return put_encode(true,'','修改成功！');
        }catch (Exception $e){
            $this->conf_model->rollback();
            Log::record($e->getMessage(),'error');
            return  put_encode(false,'9000000002',self::$error_code['9000000002']);
        }
    }
}