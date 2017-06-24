<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;

class Logs extends  Base{
         /** 
         * 操作日志管理
         */
     public function getLogs(){
	   	$data['u_username'] = $this->request->get('u_username');
	   	$data['u_client_ip'] = $this->request->get('u_client_ip');
	   	$data['start_time'] = $this->request->get('start_time');
	   	$data['end_time'] = $this->request->get('end_time');
	   	$data['page'] = $this->request->get('page');
   	    $dataes=forwarding('UserForwarding','\app\Service\usersLogs\business\logs','getList',$data);
   	    $dataes=json_decode($dataes,true);
   	    if($dataes['data']){
            $url = $this->request->baseUrl().'?u_username='.$data['u_username'].'&u_client_ip='.$data['u_client_ip'].'&start_time='.$data['start_time'].'&end_time='.$data['end_time'];
            $this->assign('page',$this->getPage($url,$data['page']+1,$dataes['data']['page']['count'],$dataes['data']['page']['start'],$dataes['data']['page']['end']));
            $this->assign('data',$data);
            $this->assign('list',$dataes['data']['data']);
            return $this->fetch('logs/getlogs');
        }
   	        return  $this->error($data['message'],url('index/welcome'),'',3);
   } 

       /** 
       * 登陆日志管理
       */
      public function getUserlogs(){
          $data['u_username'] = $this->request->get('u_username');
          $data['u_client_ip'] = $this->request->get('u_client_ip');
          $data['start_time'] = $this->request->get('start_time');
          $data['end_time'] = $this->request->get('end_time');
          $data['page'] = $this->request->get('page');
      	  $dataes=forwarding('UserForwarding','\app\Service\usersLogs\business\userlogs','getList',$data);
      	  $dataes=json_decode($dataes,true);
      	  if($dataes['data']){
              $url = $this->request->baseUrl().'?u_username='.$data['u_username'].'&u_client_ip='.$data['u_client_ip'].'&start_time='.$data['start_time'].'&end_time='.$data['end_time'];
              $this->assign('page',$this->getPage($url,$data['page']+1,$dataes['data']['page']['count'],$dataes['data']['page']['start'],$dataes['data']['page']['end']));
              $this->assign('data',$data);
              $this->assign('list',$dataes['data']['data']);
              return $this->fetch('logs/getUserlogs');
          }
          return  $this->error($data['message'],url('index/welcome'),'',3);
   } 		

 }