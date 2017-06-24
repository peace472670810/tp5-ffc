<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/15
 * Time: 14:25
 */

namespace app\admin\controller;

class Index extends Base
{

    public function index(){
        $this->isLogin();
        return $this->fetch('index/index');
    }
    public function welcome(){
        $this->isLogin();
        return $this->fetch('index/welcome');
    }
    /**
     * 管理员登录
     *   'error_code' =>$code,
     *   'data' => $data,
     *   'message'=>$message
     */
    public function login(){
        //用户登录处理
        $data = [];
        if($this->request->isPost()){
            $data['username'] = $this->request->post('username');
            $data['pwd'] = $this->request->post('password');
            $data['verifyCode'] = $this->request->post('verifyCode');
            $data = json_decode(forwarding('UserForwarding','\app\Service\users\business\admins','admin_login',data_encode($data)),true);
            if($data['data']){
                return  $this->error('登录成功！',url('index/index'),'',3);
            }else{
                return  $this->success($data['message'],url('index/login'),'',3);
            }
        }else{
            $content = [
                'title'=>'分分彩后台',
                'description'=>'分分彩后台',
                'keywords'=>'分分彩后台'
            ];
            $this->assign('content',$content);
            return  $this->fetch('/login');
        }
    }

    /**
     * 退出登录
     */
    public function signOut(){
        session(null);
        return $this->redirect('admin/index/login');
    }
}