<?php 
namespace app\Service\order\business;
use think\image\Exception;
use app\Service\order\model\Order as orderData;
class Order{
     public   $model = null;
     public function __construct(){
        $this->model = new orderData();
     }
	    public static  $error_code = [
        '3000000'=>'参数非法!',
        '3000001'=>'没有查询到订单!',
        '3000002'=>'没有权限查看该订单!',
        '3000003'=>'订单编号错误!',
        '3000004'=>'彩种编号错误!',
        '3000005'=>'追号编号不符合规则!',
        '3000006'=>'没有权限查看该订单!',
        '3000007'=>'订单不存在!',
    ];
    public function search($data){
            // $wid=$this->wrapId('1','20170620-111','17');
            // halt($wid) ; 
       if($data['order_state']==='1'){
            //crate.DB已经派彩
           $sql='select * from ffc_order where 1 ';
       }elseif($data['order_state']==='2'){
            //mysql未派彩视图
            //$sql="select * from ffc_order_temp where 1";         
           if(empty($data['ffc_lid'])){
               $sql="select * from ffc_order_temp where 1";             
           }else{
               $sql="select * from ffc_order_".$data['ffc_lid']."_temp where 1";            
           }        
       }else{
           throw new Exception(self::$error_code['3000000'],'3000000');
       }
       if(!empty($data['ffc_id'])){    
           $data['ffc_id']=trim($data['ffc_id']);
           $data['ffc_id']=$this->dewrapId($data['ffc_id']);
           if(!empty($data['ffc_id'])){
               $sql.=" and ffc_id='{$data['ffc_id']}'";
               //可以直接查了
               return  $this->model->getOrder($sql,$data['order_state']);
           }else{
               throw new Exception(self::$error_code['3000003'],'3000003');
           }  
       }  
       if(!empty($data['ffc_username'])){
           $data['ffc_username']=trim($data['ffc_username']);
           $sql.=" and ffc_username='{$data['ffc_username']}'";
       }
       if(!empty($data['start_time'])&&!empty($data['end_time'])){
           $sql.=" and ffc_add_time between '{$data['start_time']}' and '{$data['end_time']}'";
       }
       if(!empty($data['ffc_lid'])){
          if($data['order_state']==='1'){
             $sql.=" and ffc_lid='{$data['ffc_lid']}'";
           }       
           if(!empty($data['ffc_m_id'])){
               $sql.=" and ffc_m_id='{$data['ffc_m_id']}'";
           }
           if(!empty($data['ffc_issue'])){
               $sql.=" and ffc_issue='{$data['ffc_issue']}'";
           }
       }
       if($data['order_state']==='1'){
            //crate.DB已经派彩
         return    $this->model->getOrder($sql,$data['order_state']);
       }elseif($data['order_state']==='2'){
            //mysql未派彩视图
            //$sql="select * from ffc_order_temp where 1";         
         return   $this->model->getOrder($sql,$data['order_state']);                     
       }else{
           throw new Exception(self::$error_code['3000000'],'3000000');
       }
     }
     //追号订单
     public function tracelist($data){
        try{
           $sql="select * from ffc_traces where 1";
           if(!empty($data['ffc_id'])){
             $data['ffc_id']=trim($data['ffc_id']);
             $ffc_id=$this->tracedewrapId($data['ffc_id']);
             if($ffc_id){
               $sql.=" and t_id='{$ffc_id}'";
               $text=Db::query($sql);
               if($text){
                  if($text['0']['t_top_'.$data['ffc_level']]===$data['ffc_name']){
                    return $text;
                  }
                    throw new Exception(self::$error_code['3000006'],'3000006');
               }else{
                  throw new Exception(self::$error_code['3000007'],'3000007');
               }
             }else{
               throw new Exception(self::$error_code['3000005'],'3000005');
             }          
          } 
          if(!empty($data['ffc_username'])){
             $data['ffc_username']=trim($data['ffc_username']);
             $sql.=" and t_username='{$data['ffc_username']}'";
          } 
          if(!empty($data['ffc_lid'])){
            if(is_numeric($data['ffc_lid'])){
             $sql.=" and t_lid='{$data['ffc_lid']}'";
            }else{           
             throw new Exception(self::$error_code['3000004'],'3000004');
            }
          }
          if(!empty($data['t_start_issue'])){
             $sql.=" and t_start_issue='{$data['t_start_issue']}'";
          }
          switch ($data['ffc_level']){
              case '5':
                $sql.=" and t_top_5='{$data['ffc_name']}'";
                break;
              case '4':
                $sql.=" and t_top_4='{$data['ffc_name']}'";
                break;
              case '3':
                $sql.=" and t_top_3='{$data['ffc_name']}'";
                break;
              case '2':
                $sql.=" and t_top_2='{$data['ffc_name']}'";
                break;
              case '1':
                $sql.=" and t_top_1='{$data['ffc_name']}'";
                break;
              default:
                throw new Exception(self::$error_code['3000000'],'3000000');
                break;
          }
          if(!empty($data['start_time'])&&!empty($data['end_time'])){
             $sql.=" and t_add_time between '{$data['start_time']}' and '{$data['end_time']}'";
          }       
          $text=Db::query($sql);
          if($text){
            return $text;  
          }else{
            return false;
          }
       }catch(Exception $e){
             return false;          
       }
             
     }
     public function traceDetail($data){
        if(!empty($data['ffc_id'])){
           $data['ffc_id']=trim($data['ffc_id']);
           $ffc_id=$this->tracedewrapId($data['ffc_id']);
           if($ffc_id){
             $sql="select * from ffc_traces where 1";
             $sql.=" and t_id='{$ffc_id}'";
             $text=Db::query($sql);
             if($text){
                if($text['0']['t_top_'.$data['ffc_level']]===$data['ffc_name']){
                  return $text;
                }
                  throw new Exception(self::$error_code['3000006'],'3000006');
             }else{
                throw new Exception(self::$error_code['3000007'],'3000007');
             }
           }else{
             throw new Exception(self::$error_code['3000005'],'3000005');
           }          
        } 
           
     }
     //订单编码解析
     public function dewrapId($str){  
        if(!preg_match('`^(\w{10,25})P$`Ui', $str, $match)) {
            return 0;
        }        
         $result = ltrim(substr($str, -13, 12), '0');   
         return $result;
     }
      //追号订单编码解析
     static public function tracedewrapId($str) {  //, $issue, $lottery_id
        if (!preg_match('`^(\w{15,25})T$`Ui', $str, $match)) {
            return 0;
        }
        $result = ltrim(substr($str, -8, 7), '0');
        return $result;
     }
     public function ajax($lid){
        if(is_numeric($lid)){
            $sql="SELECT a.*,b.mg_name as mg_name FROM ffc_methods a LEFT JOIN ffc_method_groups b ON a.m_mg_id=b.mg_id WHERE m_lid='$lid'  ORDER BY m_mg_id ASC";
            $data=Db::query($sql);
            return $data;
        }
     }
         //按规则生成唯一订单编号 P表示package
     public function wrapId($package_id, $issue, $lottery_id) {
        //CQ30714120141716P
        switch ($lottery_id) {
            case '1':
                $str = 'CQ';
                break;
            case '2':
                $str = 'SD';
                break;
            case '3':
                $str = 'HLJ';
                break;
            case '4':
                $str = 'XJ';
                break;
            case '5':
                $str = 'CQ';
                break;
            case '6':
                $str = 'JX';
                break;
            case '7':
                $str = 'GD';
                break;
            case '8':
                $str = 'TJ';
                break;
            case '9':
                $str = '3D';
                break;
            case '10':
                $str = 'P3';
                break;
            case '11':
                $str = 'FF';
                break;
            case '12':
                $str = 'JS';
                break;
            case '13':
                $str = 'KF';
                break;
            case '14':
                $str = 'PK';
                break;
            case '15':
                $str = 'JXS';
                break;
            case '16':
                $str = 'P10';
                break;
            case '17':
                $str = 'HBKS';
                break;

            case '18':
                $str = '5FC';
                break;

            case '19':
                $str = 'HN';
                break;
            case '20':
                $str = 'LHC';
                break;

            default:
                throw new Exception("Unknown rules for lottery {$lottery_id}");
                break;
        }
        $str .= substr(str_replace('-', '', $issue), 8);
        $str .= str_pad($package_id, 12, '0', STR_PAD_LEFT);
        $result = "{$str}P";
        return $result;
     }
}