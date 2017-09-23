<?php 
namespace app\Service\drawhistory\business;
use app\Service\lottery\business\config;
use think\Exception;
use app\Service\DS\business\issue as DS;
use app\Service\drawhistory\model\drawhistory as drawhistory_model;
class drawhistory{

	   public   $model = null;
    //地址转放到配置文件里面去了
     //开奖接口
//     static $KAIJIANG_URL='http://10.10.2.6:5001/KaiJiang/SetKaiJiang';
     //手动结算
//     static $JIESUAN_URL='http://10.10.2.6:5001/KaiJiang/SetPanKouFinish';
     //手动派奖
//     static $PAIJIANG_URL='http://10.10.2.6:5001/KaiJiang/SetPanKouPay';
     //撤销接口
//     static $CHEXIAO_URL='http://10.10.2.6:5001/KaiJiang/SetPanKouCancel';
     //回滚接口
//     static $HUIHUN_URL='http://10.10.2.6:5001/KaiJiang/SetPanKouRollback';
//     static $KAIFEN_URL='http://10.10.2.6:5001/PanKou/SetPanKouStateBySingle';
     //盘口生成调用非种子
//     static $PANKOU_URL='http://10.10.2.6:5001/Other/BuildPanKouListByDate';
     //盘口生成调用带种子
//     static $PKZZ_URL='http://10.10.2.6:5001/Other/BuildPanKouListByFirstQiShu';
     //盘口插入期数
//     static $ADDJQ_URL='http://10.10.2.6:5001/PanKou/AddPanKou';
     public function __construct(){
        $this->model = new drawhistory_model();
     }
     public static  $error_code = [
        '5000000'=>'参数非法!',
        '5000001'=>'页码必须为数字!',
        '5000002'=>'开盘参数非法!',
        '5000003'=>'生成盘口彩种出错!',
        '5000004'=>'生成盘口种子错误!',
     ];
     public function historyList($data){
        try{

           if(is_numeric($data['id'])&&!empty($data)){
             $sql='select * from ds_kaijiang_'.$data['id'] .' where 1 order by ds_qishu desc ';	
             $page=$data['page'];
             $page = empty($data['page'])?0:$data['page'];
             if(is_numeric($page)){
                 $start = DEFAULT_PER_PAGE*$page;
                 $sql .= " limit $start,".DEFAULT_PER_PAGE;
                 if($list['data'] = $this->model->query($sql)){
                   $sql_count = "select count(*)  from ds_kaijiang_".$data['id'] ." where 1";
                   $pacgecount = $this->model->query($sql_count);
                   $list['page']['count'] = $pacgecount[0]['count(*)'];
                   $list['page']['total'] = ceil($list['page']['count']/DEFAULT_PER_PAGE);
                   $list['page']['pre'] = ($page-1)<=0?0:($page -1);
                   $list['page']['next'] = $page+1;
                   $list['page']['start'] = $start+1;
                   $list['page']['end'] = DEFAULT_PER_PAGE*($page+1);
                   return  put_encode($list);
                 }
                
             }    
               return put_encode(false,'5000001',self::$error_code['5000001']);
           }else{
               throw new Exception(self::$error_code['5000000'],'5000000');
           }
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }

     }

     public function issuesList($data){
        try{
           if(is_numeric($data['id'])&&!empty($data)){
              $sql='select * from ds_pankou_'.$data['id'].' where 1 order by ds_qishu desc';	
              $page=$data['page'];
              $page = empty($data['page'])?0:$data['page'];
             if(is_numeric($page)){
                 $start = DEFAULT_PER_PAGE*$page;
                 $sql .= " limit $start,".DEFAULT_PER_PAGE;
                 if($list['data'] = $this->model->query($sql)){
                   $sql_count = "select count(*)  from ds_pankou_".$data['id'] ." where 1";
                   $pacgecount = $this->model->query($sql_count);
                   $list['page']['count'] = $pacgecount[0]['count(*)'];
                   $list['page']['total'] = ceil($list['page']['count']/DEFAULT_PER_PAGE);
                   $list['page']['pre'] = ($page-1)<=0?0:($page -1);
                   $list['page']['next'] = $page+1;
                   $list['page']['start'] = $start+1;
                   $list['page']['end'] = DEFAULT_PER_PAGE*($page+1);
                   return  put_encode($list);
                 }
                
             }   
              return put_encode(false,'5000001',self::$error_code['5000001']); 
           }else{
               throw new Exception(self::$error_code['5000000'],'5000000');
           }
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
     }
    public function logsList($data){
    	try{
            if(is_array($data)){
               if(is_numeric($data['ds_lid'])){
                     $sql='select * from  ds_log_'.$data['ds_lid']." where 1 and ds_qishu='{$data['ds_qishu']}' order by ds_time desc";
                     $text=$this->model->query($sql);
                     return put_encode($text);
               }
            }
            	throw new Exception(self::$error_code['5000000'],'5000000');
            
    	}catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
    	}
    }
  //订单详细，开奖号码
    public function orderIssue($data){
       try{
           if(is_numeric($data['qishu']) && is_numeric($data['lid'])){
              $sql="select ds_balls from ds_kaijiang_".$data['lid']." where 1 and ds_qishu ={$data['qishu']} and ds_is_result=1";
              $text=$this->model->query($sql);
              if(empty($text)){
                return false;
              }else{
                return $text['0']['ds_balls'];
              }
           }
           throw new Exception(self::$error_code['5000000'],'5000000');
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
      }
    }

    public function kaijiang($data){
       try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_array($data['balls'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['Lid']=$data['lid'];
            $text['IsReload']=true;
            //true 自动结算派奖，false手动结算派奖
            $text['IsAuto']=false;
            $text['KaiJiang']['QiShu']=$data['qishu'];
            $text['KaiJiang']['Time']=date('Y-m-d h:i:s');
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['KaiJiang']['Balls']=$data['balls'];
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetKaiJiang_url'));
            return $datas;
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }

    public function jiesuan($data){
        try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['Lid']=$data['lid'];
            $text['QiShu']=$data['qishu'];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetPanKouFinish_url'));
            return $datas;
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }

    public function paijiang($data){
        try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['Lid']=$data['lid'];
            $text['QiShu']=$data['qishu'];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetPanKouPay_url'));
            return $datas;
            
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }

    public function chexiao($data){
       try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['Lid']=$data['lid'];
            $text['QiShu']=$data['qishu'];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetPanKouCancel_url'));
            return $datas;
            
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }
    //回滚接口
    public function huigun($data){
      try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['Lid']=$data['lid'];
            $text['QiShu']=$data['qishu'];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['User']['IP']=$data['ip'];      
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetPanKouRollback_url'));
            return $datas;
            
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }
    public function kaipan($data){
         try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if($data['state']!=='1'){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['State']=$data['state'];
            $text['Lid']=$data['lid'];
            $text['QiShu']=$data['qishu'];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetPanKouStateBySingle_url'));
            return $datas;
            
       }catch(Exception $e){
           return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }
    public function fenpan($data){
         try{
            if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if(!is_numeric($data['qishu'])){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            if($data['state']!=='2'){
                throw new Exception(self::$error_code['5000002'],'5000002');
            }
            $text['State']=$data['state'];
            $text['Lid']=$data['lid'];
            $text['QiShu']=$data['qishu'];
            $text['User']['OperateType']=session('level');
            $text['User']['AccountName']=session('admin_auth_name');
            $text['User']['IP']=$data['ip'];
            $text=json_encode($text); 
            $DS= new DS();
            $datas=$DS->issueRemote($text,config('SetPanKouStateBySingle_url'));
            return $datas;
            
       }catch(Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }
    //盘口生成
    public function pankouAdd($data){
       $arr=array(6,28,29);
       try{
          if(!is_numeric($data['lid'])){
                throw new Exception(self::$error_code['500003'],'5000003');
          }
          
          if(in_array($data['lid'],$arr)){
             if(!is_numeric($data['zhongzi'])){

                throw new Exception(self::$error_code['5000004'],'5000004');
             }
             // 盘口生成调用带种子
             $BuildPanKouListByFirstQiShu = config('BuildPanKouListByFirstQiShu_url');
             $datas=file_get_contents($BuildPanKouListByFirstQiShu."?lid=".$data['lid']."&time=".$data['start_time']."&firstQiShu=".$data['zhongzi']);
             $text=json_decode($datas,true);
             if(empty($text['Result'])){
                return  put_encode(false,'',$text['Message']);
             }else{

                return  put_encode(true,'',$text['Result']);
             }
          }
          //盘口生成调用非种子
             $BuildPanKouListByDate_url = config('BuildPanKouListByDate_url');
             $datas=file_get_contents($BuildPanKouListByDate_url."?lid=".$data['lid']."&date=".$data['start_time']);
             $text=json_decode($datas,true);   
             if(empty($text['Result'])){
                return  put_encode(false,'',$text['Message']);
             }else{

                return  put_encode(true,'',$text['Result']);
             }

       }catch(Exception $e){
             return  put_encode(false,$e->getCode(),$e->getMessage());
       }
    }
    //盘口插入期数
    public function addJiangqi($data){
      try{
          $arr=json_decode($data['text'],true);    
          foreach ($arr as &$v) {         
               $v['IsResult'] = true;
               $v['IsFinish'] = true;
               $v['IsPay'] = true;
               $v['IsCancel'] = true;
               $v['State'] = 0;
               $v['Balls'] ='';
               $v['BallList']=array(0);
          }
          $text['List']=$arr;
          $text['IsReload']=$data['state'];
          $text['Lid']=$data['lid'];
          $text['User']['OperateType']=session('level');
          $text['User']['AccountName']=session('admin_auth_name');
          $text['User']['IP']=$data['ip'];
          $text=json_encode($text);        
          $DS= new DS();
          $datas=$DS->issueRemote($text,config('AddPanKou_url'));
          $datas=json_decode($datas,true);
          if($datas['Result']){
                return  put_encode(true);
             }else{

               return  put_encode(false,'',$datas['Message']);
             }
      
      }catch(Exception $e){
          return  put_encode(false,$e->getCode(),$e->getMessage());
      }
    }
}