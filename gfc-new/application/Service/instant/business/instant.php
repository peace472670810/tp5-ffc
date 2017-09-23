<?php 
namespace app\Service\instant\business;
use app\Service\lottery\business\method_groups as method_groups;
use app\Service\order\business\order as order;
class instant{
    public function getInstant($data){
    	$method_groups=new method_groups();
    	$arr=json_decode($method_groups->getMethodGroupList($data),true)['data'];
        $order=new order();
        $text=$order->getInstant($data);
        $datas=array();
        foreach ($arr as $key => $value) { 	
        	$datas[$key]['mg_name']=$value['mg_name'];
        	        $datas[$key]['lid']=$value['mg_lid'];
        			$datas[$key]['mg_id']=$value['mg_id'];
        			$datas[$key]['o_issue']=$data['issue'];
        			$datas[$key]['count']='';
        			$datas[$key]['o_amount']='';
        	foreach ($text as $k => $v) {	
        		if($value['mg_id'] == $v['o_mg_id']){    		    	
        			$datas[$key]['count']=$v['count'];
        			$datas[$key]['o_amount']=$v['o_amount'];
        		}
        	}	 	
        }
    	return put_encode($datas,'','');
    }
    

 }
