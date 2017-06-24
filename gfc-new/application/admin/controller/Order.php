<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
class Order extends Base{
	 public static $lottery=[
                 '2'=>'重庆时时彩',
		         '8'=>'新疆时时彩',
		         '14'=>'天津时时彩',
		         '30'=>'湖北快三',
		         '9'=>'江苏快三',
		         '24'=>'广东11选5',
		         '26'=>'山东11选5',
		         '27'=>'江西11选5',
		         '28'=>'福彩3D',
		         '29'=>'排列三/五',
		         '6'=>'PK10',
	 ];
	 public function getOrder(){
	 	 $list='';
	 	 // $data=new pdo;
	 	 // $a=$data->pdo()->query('SELECT * FROM ds_order limit 1000');
	     // var_dump($a->fetchall());
	 	 // exit;
	 	 $data['start_time']=date('Y-m-d 00:00:00');
	 	 $data['end_time']=date('Y-m-d 23:59:59');
	 	 $data['ffc_id']='';
	 	 $data['ffc_username']='';
	 	 $data['ffc_issue']='';
	 	 if($this->request->isPost()){
             $data['ffc_id']=$this->request->Post('ffc_id');
             $data['ffc_lid']=$this->request->Post('ffc_lid');
             $data['ffc_m_id']=$this->request->Post('ffc_m_id');
             $data['ffc_issue']=$this->request->Post('ffc_issue');
             $data['ffc_username']=$this->request->Post('ffc_username');
             $data['start_time']=$this->request->Post('start_time');
             $data['end_time']=$this->request->Post('end_time');
             $data['order_state']=$this->request->Post('order_state');
             $data['ffc_uid']=session('u_id');
	 	     $data['ffc_name']=session('u_name');
	 	     $data['ffc_level']=session('level');
             $list = json_decode(forwarding('UserForwarding','\app\Service\order\business\order','search',$data),true);
	 	 }     
	 	// $list = json_decode(forwarding('UserForwarding','\app\Service\order\business\order','Orderlist',$data),true);
	 	 $this->assign('data',$data);
	 	 $this->assign('list',$list);
	 	 $this->assign('lottery',self::$lottery);
	 	 return $this->fetch('order/getOrder');
	 }
	 public function getTrace(){
	 	 $data['start_time']=date('Y-m-d 00:00:00');
	 	 $data['end_time']=date('Y-m-d 23:59:59');
	 	 $data['ffc_id']='';
	 	 $data['ffc_lid']='';
	 	 $data['ffc_username']='';
	 	 $data['t_start_issue']='';
	 	 $list='';
	     if($this->request->isPost()){
             $data['ffc_id']=$this->request->Post('ffc_id');
             $data['ffc_lid']=$this->request->Post('ffc_lid');
             $data['t_start_issue']=$this->request->Post('t_start_issue');   
             $data['ffc_username']=$this->request->Post('ffc_username');
             $data['start_time']=$this->request->Post('start_time');
             $data['end_time']=$this->request->Post('end_time');
             $data['ffc_uid']=session('u_id');
	       	 $data['ffc_name']=session('u_name');
	 	     $data['ffc_level']=session('level');
             $list = forwarding('UserForwarding','\app\Service\order\business\order','tracelist',$data);
	      }
	      $this->assign('data',$data);
	      $this->assign('lottery',self::$lottery);
		  $this->assign('list',$list);
		  return $this->fetch('order/getTrace');
	 }
	 public function traceDetail(){
	 	$data['ffc_id']=$this->request->Get('id');
	 	$data['ffc_uid']=session('u_id');
	    $data['ffc_name']=session('u_name');
        $data['ffc_level']=session('level');
	 	$list= forwarding('UserForwarding','\app\Service\order\business\order','traceDetail',$data);
	 	$this->assign('list',$list);
		return $this->fetch('order/traceDetail');
	 }
	 public function ajax(){
	    $lid=$this->request->get('lid');
	 	$data = forwarding('UserForwarding','\app\Service\order\business\order','ajax',$lid);
	 	return $data;
     }

 }?>