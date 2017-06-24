<?php

/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/16
 * Time: 16:21
 */
namespace  app\Service\users\model;
use think\image\Exception;
use think\Model;
use think\Db;
/**
 * 后台管理员模型
 * Class admin
 *
 *
 *
 * @package app\admin\model
 */
class Admins extends  Model
{
    static $ADMIN_CODE = [
        '20000010'=>'用户名非法',
        '20000011'=>'登录失败：无此用户',
        '20000012'=>'登录失败：密码错误',
        '20000013'=>'登录失败：已被冻结',
        '20000014'=>'登录失败：非法IP',
    ];
    /**
     * 登录验证
     * @param $username
     * @param $pwd
     * @return int|mixed
     */
    public function login($username, $pwd)
    {
        if (!preg_match('`^[a-zA-Z]\w{3,20}$`Uims', $username)) {
            throw  new Exception(self::$ADMIN_CODE['20000010'],'20000010');
        }
        $map = '';
        $map['u_username'] = $username;   
        $admin = $this->get($map);      
        if (!$admin) {
            throw  new Exception(self::$ADMIN_CODE['20000011'],'20000011');
        }
        if ($admin['u_pwd'] !== $this->setPassword($pwd)) {
            throw  new Exception(self::$ADMIN_CODE['20000012'],'20000012');
        }
        if ($admin['u_is_enabled'] != 8) {
            throw  new Exception(self::$ADMIN_CODE['20000013'],'20000013');
        }

        $data = $admin->data;
       
        if(!empty($data['u_name'])){
          $text=Db::table('ffc_users')->where("u_id",$data['u_id'])->where("u_status","8")->select();
          if(empty($text)){
             throw  new Exception(self::$ADMIN_CODE['20000013'],'20000013');
           }
            session('u_name',$data['u_name']);
        }else{
          $text=Db::table('ffc_users')->where("u_username",$data['u_parent_name'])->where("u_status","8")->select();
          if(empty($text)){
             throw  new Exception(self::$ADMIN_CODE['20000013'],'20000013');
           }
            session('is_child',1);
            session('u_name',$data['u_parent_name']);
        }
        session('admin_auth_id',$data['u_admin_id']);
        session('admin_auth_name',$data['u_username']);
        session('u_id',$data['u_id']);      
        session('level',$data['u_level']);
        session('admin_auth',$data);
        return $admin->data;
    }

    /**
     * 密码加密
     * @param $value
     * @return string
     */
    public function setPassword($value){
        return md5($value);
    }

    /**获取ip
     * @return mixed
     */
    public function setSignupIpAttr()
    {
        return get_client_ip(1);
    }

    /**
     * 判断是否登录
     * @return int
     */
    public function isLogin(){
        $user = session('admin_auth');
        if (empty($user)) {
            // 判断是否记住登录
            if (cookie('?uid') && cookie('?signin_token')) {
                $user = $this::get(cookie('uid'));
                if ($user) {
                        return $user->id;
                    }
            };
            return 0;
        }else{
            return session('admin_auth_id');
        }
    }

    /**
     *管理员列表
     */
    public function  admin_list(){
        $user = $this->all();
        return $user;
    }
    /**
     * 登出
     */
    public function logout(){
        session(null);
        return  true;
    }
}