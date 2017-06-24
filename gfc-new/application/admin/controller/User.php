<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/17
 * Time: 14:49
 */

namespace app\admin\controller;
use app\admin\controller\Base;
/** 用户管理
 * Class User
 * @package app\admin\controller
 */
class User extends  Base
{

        public function _initialize(){
             parent::_initialize();
            $this->isLogin();
        }

        /**
         * 分公司用户列表
         * u_level
         * u_username
         * u_is_test
         * u_status
         * page
         */
        public  function getUser4(){
            $search['u_username'] = '';
            $search['u_is_test'] = '';
            $search['u_status'] = '';
            $search['u_level']='4';
            $data['u_level'] = $this->request->get('u_level');
            $data['u_username'] = $this->request->get('u_username');
            $data['u_top_5'] = $this->request->get('u_top_5');
            $data['u_is_test'] = $this->request->get('u_is_test');
            $data['u_status'] = $this->request->get('u_status');
            $data['page'] = $this->request->get('page');
            $data['op'] = 4;
            $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','Userlist',$data),true);
            if($res['data']){
                $this->assign('level',4);
                $this->assign('post',$search);
                $this->assign('list',$res['data']['list']);
                $url = $this->request->baseUrl().'?u_level='.$data['u_level'].'&u_username='.$data['u_username'].'&u_is_test='.$data['u_is_test'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$res['data']['page']['count'],$res['data']['page']['start'],$res['data']['page']['end']));
                return $this->fetch('user/getUser4');
            }else{
                return $this->error($res['message'],url('index/welcome'),'',1);
            }
        }

    /**
     * 股东列表
     * @return mixed|void
     */
        public function getUser3(){
            $search['u_username'] = '';
            $search['u_is_test'] = '';
            $search['u_status'] = '';
            $search['u_level'] = '3';
            $data['u_level'] = $this->request->get('u_level');
            $data['u_username'] = $this->request->get('u_username');
            $data['u_top_5'] = $this->request->get('u_top_5');
            $data['u_top_4'] = $this->request->get('u_top_4');
            $data['u_is_test'] = $this->request->get('u_is_test');
            $data['u_status'] = $this->request->get('u_status');
            $data['page'] = $this->request->get('page');
            $data['u_top_3']=$this->request->get('u_top_3');
            $data['op'] = 3;
            $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','Userlist',$data),true);
            if($res['data']){
                $this->assign('level',3);
                $this->assign('post',$search);
                $this->assign('list',$res['data']['list']);
                $url = $this->request->baseUrl().'?u_level='.$data['u_level'].'&u_username='.$data['u_username'].'&u_is_test='.$data['u_is_test'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$res['data']['page']['count'],$res['data']['page']['start'],$res['data']['page']['end']));
                return $this->fetch('user/getUser3');
            }else{
                return $this->error($res['message'],url('index/welcome'),'',1);
            }
        }
        public function getUser2(){
            $search['u_username'] = '';
            $search['u_is_test'] = '';
            $search['u_status'] = '';
             $search['u_level'] = '2';
            $data['u_level'] = $this->request->get('u_level');
            $data['u_username'] = $this->request->get('u_username');
            $data['u_top_5'] = $this->request->get('u_top_5');
            $data['u_top_4'] = $this->request->get('u_top_4');
            $data['u_top_3'] = $this->request->get('u_top_3');
            $data['u_is_test'] = $this->request->get('u_is_test');
            $data['u_status'] = $this->request->get('u_status');
            $data['page'] = $this->request->get('page');
            $data['op'] = 2;
            $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','Userlist',$data),true);
            if($res['data']){
                $this->assign('level',2);
                $this->assign('post',$search);
                $this->assign('list',$res['data']['list']);
                $url = $this->request->baseUrl().'?u_level='.$data['u_level'].'&u_username='.$data['u_username'].'&u_is_test='.$data['u_is_test'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$res['data']['page']['count'],$res['data']['page']['start'],$res['data']['page']['end']));
                return $this->fetch('user/getUser2');
            }else{
                return $this->error($res['message'],url('index/welcome'),'',1);
            }
        }
        public function getUser1(){
            $search['u_username'] = '';
            $search['u_is_test'] = '';
            $search['u_status'] = '';
             $search['u_level'] = '1';
            $data['u_level'] = $this->request->get('u_level');
            $data['u_username'] = $this->request->get('u_username');
            $data['u_top_5'] = $this->request->get('u_top_5');
            $data['u_top_4'] = $this->request->get('u_top_4');
            $data['u_top_3'] = $this->request->get('u_top_3');
            $data['u_top_2'] = $this->request->get('u_top_2');
            $data['u_is_test'] = $this->request->get('u_is_test');
            $data['u_status'] = $this->request->get('u_status');
            $data['page'] = $this->request->get('page');
            $data['op'] = 1;
            $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','Userlist',$data),true);
            if($res['data']){
                $this->assign('level',1);
                $this->assign('post',$search);
                $this->assign('list',$res['data']['list']);
                $url = $this->request->baseUrl().'?u_level='.$data['u_level'].'&u_username='.$data['u_username'].'&u_is_test='.$data['u_is_test'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$res['data']['page']['count'],$res['data']['page']['start'],$res['data']['page']['end']));
                return $this->fetch('user/getUser1');
            }else{
                return $this->error($res['message'],url('index/welcome'),'',1);
            }
        }
        public function getUser0(){
            $search['u_username'] = '';
            $search['u_is_test'] = '';
            $search['u_status'] = '';
             $search['u_level'] = '0';
            $data['u_level'] = $this->request->get('u_level');
            $data['u_username'] = $this->request->get('u_username');
            $data['u_top_5'] = $this->request->get('u_top_5');
            $data['u_top_4'] = $this->request->get('u_top_4');
            $data['u_top_3'] = $this->request->get('u_top_3');
            $data['u_top_2'] = $this->request->get('u_top_2');
            $data['u_top_1'] = $this->request->get('u_top_1');
            $data['u_is_test'] = $this->request->get('u_is_test');
            $data['u_status'] = $this->request->get('u_status');
            $data['page'] = $this->request->get('page');
            $data['op'] = 0;
            $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','Userlist',$data),true);
            if($res['data']){
                $this->assign('level',0);
                $this->assign('post',$search);
                $this->assign('list',$res['data']['list']);
                $url = $this->request->baseUrl().'?u_level='.$data['u_level'].'&u_username='.$data['u_username'].'&u_is_test='.$data['u_is_test'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$res['data']['page']['count'],$res['data']['page']['start'],$res['data']['page']['end']));
                return $this->fetch('user/getUser0');
            }else{
                return $this->error($res['message'],url('index/welcome'),'',1);
            }
        }
      /**
     * 添加分公司
     */
        public function addUser4(){
           if($this->request->isPost()){
               $data = $this->request->post();
                $data['u_top_5'] = session('u_name');
                $data['u_id'] = session('u_id');
                return forwarding('UserForwarding','\app\Service\users\business\users','addUser4',$data);
           }
                return  $this->fetch('user/addUser4');
            
        }

    /**
     *添加股东
     */
        public function addUser3(){
            if($this->request->isPost()){
                $data = $this->request->post();
                return forwarding('UserForwarding','\app\Service\users\business\users','addUser3',$data);
            }else{
                $data['u_id'] = $this->request->get('u_id');
                $user_detail =  json_decode( forwarding('UserForwarding','\app\Service\users\business\users','getUserById',$data),true);
                $user_detail['data']['proportion_3'] =  $user_detail['data']['u_proportion_4'];//股东可以调的最大占成
                $this->assign('user',$user_detail['data']);
                return  $this->fetch('user/addUser3');
            }
        }
    /**
     * 修改股东
     * op 0 获取
     *    1 修改
     */
    public function editUser3(){
        if($this->request->isPost()){           
            $data = $this->request->post();    
            $data['op'] = 1;
            return  forwarding('UserForwarding','\app\Service\users\business\users','editUser3',$data);
        }
        $data['u_id'] = $this->request->get('u_id');
        $data['op'] = 0;
        $res = (forwarding('UserForwarding','\app\Service\users\business\users','editUser3',$data));
        $this->assign('list',$res);
       
        return $this->fetch('user/editUser3');
    }
    /**
     *添加总代
     */
    public function addUser2(){
        if($this->request->isPost()){
            $data = $this->request->post();
            return forwarding('UserForwarding','\app\Service\users\business\users','addUser2',$data);
        }else{
            $data['u_id'] = $this->request->get('u_id');
            $user_detail =  json_decode( forwarding('UserForwarding','\app\Service\users\business\users','getUserById',$data),true);
            $user_detail['data']['proportion_2'] =  $user_detail['data']['u_proportion_3'] ;//总代可以调的最大占成
            $this->assign('user',$user_detail['data']);
            return  $this->fetch('user/addUser2');
        }
    }
        /**
     * 修改总代
     * op 0 获取
     *    1 修改
     */
    public function editUser2(){

        if($this->request->isPost()){
            $data = $this->request->post();
            $data['op'] = 1;
            return  forwarding('UserForwarding','\app\Service\users\business\users','editUser2',$data);
        }
        $data['u_id'] = $this->request->get('u_id');
        $data['op'] = 0;
        $res = (forwarding('UserForwarding','\app\Service\users\business\users','editUser2',$data));
        $this->assign('list',$res);
        return $this->fetch('user/editUser2');
    }
    /**
     *添加代理
     */
    public function addUser1(){
        if($this->request->isPost()){
            $data = $this->request->post();
            return forwarding('UserForwarding','\app\Service\users\business\users','addUser1',$data);
        }else{
            $data['u_id'] = $this->request->get('u_id');
            $user_detail =  json_decode( forwarding('UserForwarding','\app\Service\users\business\users','getUserById',$data),true);
            $user_detail['data']['proportion_1'] =  $user_detail['data']['u_proportion_2']  ;//代理可以调的最大占成
            $this->assign('user',$user_detail['data']);
            return  $this->fetch('user/addUser1');
        }
    }
            /**
     * 修改代理
     * op 0 获取
     *    1 修改
     */
    public function editUser1(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $data['op'] = 1;

            return  forwarding('UserForwarding','\app\Service\users\business\users','editUser1',$data);
        }
        $data['u_id'] = $this->request->get('u_id');
        $data['op'] = 0;
        $res = (forwarding('UserForwarding','\app\Service\users\business\users','editUser1',$data));
        $this->assign('list',$res);
        return $this->fetch('user/editUser1');
    }
                /**
     * 修改会员
     * op 0 获取
     *    1 修改
     */
    public function editUser0(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $data['op'] = 1;
            return  forwarding('UserForwarding','\app\Service\users\business\users','editUser0',$data);
        }
        $data['u_id'] = $this->request->get('u_id');
        $data['op'] = 0;
        $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','editUser0',$data),true);
        $this->assign('list',$res['data']);
       
        return $this->fetch('user/editUser0');
    }
    /**
     *添加用户
     */
    public function addUser0(){
        if($this->request->isPost()){
            $data = $this->request->post();
            return forwarding('UserForwarding','\app\Service\users\business\users','addUser0',$data);
        }else{
            $data['u_id'] = $this->request->get('u_id');
            $user_detail =  json_decode( forwarding('UserForwarding','\app\Service\users\business\users','getUserById',$data),true);

            $this->assign('user',$user_detail['data']);
            
            return  $this->fetch('user/addUser0');
        }
    }
    /**
     * 修改分公司用户
     * op 0 获取
     *    1 修改
     */
        public function editUser4(){
            if($this->request->isPost()){
                $data = $this->request->post();
                $data['op'] = 1;
                return  forwarding('UserForwarding','\app\Service\users\business\users','editUser4',$data);
            }
            $data['u_id'] = $this->request->get('u_id');
            $data['op'] = 0;
            $res = json_decode(forwarding('UserForwarding','\app\Service\users\business\users','editUser4',$data),true);
            $this->assign('list',$res['data']);
            return $this->fetch('user/editUser4');
        }
       /**
     * 搜索
     */
       public function search(){
          if($this->request->isPost()){
                $data=$this->request->post();
                $data["u_top"]=$this->request->session('u_name');
                $level=$this->request->session('level');
                $data['top']=$level;
                if($level>$data['u_level']){              
                $dataes=forwarding('UserForwarding','\app\Service\users\business\users','search',$data); 
                $dataes=json_decode($dataes,true);
              if($dataes['data']){        
                $this->assign('list',$dataes['message']);                   
              }
                $arr=array(
                     'u_level'=>$data['u_level'],
                      'u_top'.$data['top']=>$data['u_top']
                    );
               
               // $url='?u_level='.$data['u_level'].'&u_top_'.$data['top'].'='.$data['u_top'];
                $this->assign('post',$data);
                $this->assign('u_level',$data['u_level']);
                $this->assign('u_top_'.$data['top'],$data['u_top']);
              return $this->fetch('user/getUser'.$data['u_level']);
           }
              return $this->error('非法搜索！','index/welcome');
          }  
       }
      
}