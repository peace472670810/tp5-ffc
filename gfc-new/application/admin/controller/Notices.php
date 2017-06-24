<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
class Notices extends Base{
  /**
     * 显示公告
     */
  public function getNotice(){
	   $data='';
	   $dataes=forwarding('UserForwarding','\app\Service\notices\business\notices','getNotice',$data);
       $this->assign('list',$dataes);
	 return  $this->fetch('notices/getnotice');  

  }
  /**
     * 添加公告
     */
    public function addNotice(){
       if($this->request->isPost()){
      	  $data=input('post.');	
      	  $data['n_update_time']= $data['n_add_time']=date('Y-m-d h:i:s'); 
          $data['n_status']='1';
          $dataes= forwarding('UserForwarding','\app\Service\notices\business\notices','addNotice',$data);
          $dataes=data_decode($dataes);
              if(!empty($dataes['0'])){
                  return 1;
              }else{
                  return 0;
              }         
    	  }
    	  return  $this->fetch('notices/addnotice');  
    }
    /**
     * 修改公告
     */
    public function editNotice(){
        	if ($this->request->isGet()){
          		$data['n_id']=input('param.n_id');
          		$data['op']='0';
          		$dataes=forwarding('UserForwarding','\app\Service\notices\business\notices','editNotice',$data);
          		$dataes=data_decode($dataes);         
             if (array_key_exists("0",$dataes)){
                 return $this->success('参数错误！',url('gogo'),'',1);;
              }else{
                 $this->assign('dataes',$dataes);
                 return  $this->fetch('notices/editNotice');  
              }
        	}
      	if ($this->request->isPost()){
      		$data=input('post.');
      		$data['n_update_time']=date('Y-m-d h:i:s');
      		$data['op']='1';
      		$dataes=forwarding('UserForwarding','\app\Service\notices\business\notices','editNotice',$data);
      		$dataes=data_decode($dataes);
        		if(!empty($dataes['0'])){
                 return 1;
              }else{
                 return 0;
              }
        	}

    }
     /**
     * 删除公告
     */
    public function delNotice(){
    	if (Request::instance()->isGet()){
    		   $n_id=input('get.n_id');
           $data['n_id']=$n_id;
    		   $dataes= forwarding('UserForwarding','\app\Service\notices\business\notices','delNotice',$data);
         	return data_decode($dataes);
    	}
    }

 }?>