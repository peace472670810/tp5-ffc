<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
class Order extends Base{
	 public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->isLogin();
    }
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
	 	 $list['message']='';
	 	 $data['ffc_id']=$this->request->get('ffc_id','');
         $data['ffc_lid']=$this->request->get('ffc_lid','');
         $data['ffc_mg_id']=$this->request->get('ffc_mg_id','');
         $data['ffc_issue']=$this->request->get('ffc_issue','');
         $data['ffc_username']=$this->request->get('ffc_username','');
         $data['start_time']=$this->request->get('start_time',date('Y-m-d 00:00:00'));
         $data['end_time']=$this->request->get('end_time',date('Y-m-d 23:59:59'));
         $data['order_state']=$this->request->get('order_state',1);
         $data['bytype']=$this->request->get('bytype','');
         $data['page'] = $this->request->get('page');
         $data['page'] = empty($data['page'])?0:$data['page'];
         $data['ffc_uid']=session('u_id');
         $data['ffc_name']=session('u_name');
         $data['ffc_level']=session('level');
         $data['is_submit'] = $this->request->get('is_submit');
         if($data['is_submit']){
             $res = json_decode(forwarding('UserForwarding','\app\Service\order\business\order','search',$data),true);
             if(!$res['data']){
                 return $this->error($res['message'],url('order/getOrder'),'',1);
             }
             $list = $res['data'];
             $url = $this->request->baseUrl().'?is_submit=1&ffc_id='.$data['ffc_id'].'&ffc_lid='.$data['ffc_lid'].'&ffc_mg_id='.$data['ffc_mg_id'].'&ffc_issue='.$data['ffc_issue'].'&ffc_username='.$data['ffc_username'].'&start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&order_state='.$data['order_state'].'&bytype='.$data['bytype'];
             $this->assign('page',$this->getPage($url,$data['page']+1,$list['page']['count'],$list['page']['start'],$list['page']['end']));
             $this->assign('list',$list['list']);
         }else{
             $this->assign('list',[]);
         }
         $this->assign('data',$data);
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
	 	 $data['is_submit'] = $this->request->get('is_submit');
	 	 $data['page'] = $this->request->get('page');
         $data['page'] = empty($data['page'])?0: $data['page'];
         $data['bytype']=$this->request->get('bytype','');
	 	 if($data['is_submit']){
             $data['ffc_id']=$this->request->get('ffc_id');
             $data['ffc_lid']=$this->request->get('ffc_lid');
             $data['t_start_issue']=$this->request->get('t_start_issue');
             $data['ffc_username']=$this->request->get('ffc_username');
             $data['start_time']=$this->request->get('start_time');
             $data['end_time']=$this->request->get('end_time');
             $data['ffc_uid']=session('u_id');
             $data['ffc_name']=session('u_name');
             $data['ffc_level']=session('level');
             $res = json_decode(forwarding('UserForwarding','\app\Service\order\business\order','tracelist',$data),true);
             $list = $res['data'];
             $url = $this->request->baseUrl().'?is_submit=1&ffc_id='.$data['ffc_id'].'&ffc_lid='.$data['ffc_lid'].'&ffc_username='.$data['ffc_username'].'&start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&t_start_issue='.$data['t_start_issue'].'&bytype='.$data['bytype'];
             $this->assign('page',$this->getPage($url,$data['page']+1,$list['page']['count'],$list['page']['start'],$list['page']['end']));
             $this->assign('list',$list['list']);
         }else{
             $this->assign('list',[]);
         }
	      $this->assign('data',$data);
	      $this->assign('lottery',self::$lottery);
		  return $this->fetch('order/getTrace');
	 }

    /**
     * 获取追号详情
     * @return mixed
     */
	 public function traceDetail(){
	 	$data['ffc_id']=$this->request->get('id');
	 	$data['ffc_uid']=session('u_id');
	    $data['ffc_name']=session('u_name');
        $data['ffc_level']=session('level');
	 	$list= forwarding('UserForwarding','\app\Service\order\business\order','traceDetail',$data); 
        if(is_array($list)){
            $text= forwarding('UserForwarding','\app\Service\order\business\order','traceIssue',$list);
            $this->assign('list',$list);
            $this->assign('text',$text);
            return $this->fetch('order/traceDetail');
        }
        $arr=json_decode($list,true);
        if(!$arr['data']){
        return    $this->error($arr['message'],'Order/getTrace');
          }
	 	
	 }

    /**
     * 获取注单详情
     * @return mixed|void
     */
	 public function orderDetail(){
	 	$data['o_id']=$this->request->get('id');
	 	$data['lid']=$this->request->get('lid');
	 	$data['mg_id']=$this->request->get('mg_id');
	 	$data['issue']=$this->request->get('issue');
	 	$data['ffc_uid']=session('u_id');
	    $data['ffc_name']=session('u_name');
        $data['ffc_level']=session('level');   
        $list= json_decode(forwarding('UserForwarding','\app\Service\order\business\order','orderDetail',$data),true);
        if(!$list['data']){
          return 	$this->error($list['message'],'Order/getOrder');
        }
	 	$this->assign('list',$list['message']);
		return $this->fetch('order/orderDetail');
	 }
	 public function ajax(){
	    $data['lid']=$this->request->get('lid');
	 	$text = json_decode(forwarding('UserForwarding','\app\Service\lottery\business\method_groups','getMethodGroupList',$data),true);
	 	return $text['data'];
     }
     public function transferRecord(){
        $data['username'] = $this->request->get('username','');
        $data['type'] = $this->request->get('type/a','');
        $data['siteid'] = $this->request->get('siteid','');
        $data['start_time'] = $this->request->get('start_time',date('Y-m-d 00:00:00'));
        $data['end_time']   =  $this->request->get('end_time',date('Y-m-d 23:59:59'));
        $data['state'] = $this->request->get('state');
        $data['page'] = $this->request->get('page','0');
        $list=[];
        if( $data['state'] == '6666'){
            $data['ffc_name']=session('u_name');
            $data['ffc_level']=session('level');
            $list= json_decode(forwarding('UserForwarding','\app\Service\order\business\order','transferRecord',$data),true);
            if(!$list['data']){
               return    $this->error($list['message'],'Order/transferRecord');
            }
            
        }
        if(!empty($list['message']['data'])){
            $this->assign('list',$list['message']['data']);
            $var='';
            foreach ($data['type'] as $key => $value) {
                 $var.= "&type[]=".$value;
            }
            $url = $this->request->baseUrl().'?state='.$data['state'].'&username='.$data['username'].$var.'&siteid='.$data['siteid'].'&start_time='.$data['start_time'].'&end_time='.$data['end_time'];
            $this->assign('page',$this->getPage($url,$list['message']["pagation"]['page'],$list['message']["pagation"]['totalNumber'],0,ceil($list['message']["pagation"]['totalNumber']/DEFAULT_PER_PAGE)));

            }else{

                 $this->assign('list',[]);
            }
        $this->assign('data',$data);
        return $this->fetch('order/transferRecord');
     }

 }
 ?>