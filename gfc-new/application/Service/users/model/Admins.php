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
        '20000015'=>'登录失败：用户已被冻结！',
        '20000016'=>'登录失败：用户信息有误！',
    ];
    /**
     * 登录验证
     * 先去admins表里面查 没有的话就去uses
     * users表不存在在则提示不存在该用户  存在的话就用users 表里面的数据添加一个admin用户
     * @param $username
     * @param $pwd
     * @return int|mixed
     */
    public function login($username, $pwd,$ip)
    {
        if (!preg_match('`^[0-9a-zA-Z]\w{3,50}$`Uims', $username)) {
            throw  new Exception(self::$ADMIN_CODE['20000010'],'20000010');
        }
        $admin = $this->table('ffc_admins')->where('u_username','eq',$username)->find();
        $now = date('Y-m-d H:i:s');
        if (!$admin) {
            $res = $this->query("select * from  ffc_users where u_username = '{$username}' and u_level != 0  limit 1");
            if(empty($res)){//users 表不存在
                throw  new Exception(self::$ADMIN_CODE['20000011'],'20000011');
            }else{//users表存在则admin新增
                $user = $res[0];
                if ($user['u_pwd'] !== $this->setPassword($pwd)) {
                    throw  new Exception(self::$ADMIN_CODE['20000012'],'20000012');
                }
                if($user['u_status'] == '8'){//正常上级才能创建登录
                    $admin['u_username'] = $user['u_username'];
                    $admin['u_name'] = $user['u_username'];
                    $admin['u_pwd'] = $user['u_pwd'];
                    $admin['u_nickname'] = $user['u_nick_name'];
                    $admin['u_reg_time'] = $now;
                    $admin['u_last_time']= $now;
                    $admin['u_level'] = $user['u_level'];
                    switch ($user['u_level']){
                        case 1:
                            $admin['u_group_id']='1,2,15,16,17,21,33,34,35,36,37,38,39,40,41';
                            break;
                        case 2:
                            $admin['u_group_id']='1,2,12,13,14,15,16,17,21,33,34,35,36,37,38,39,40,41';
                            break;
                        case 3:
                            $admin['u_group_id']='1,2,9,10,11,12,13,14,15,16,17,21,33,34,35,36,37,38,39,40,41';
                            break;
                        case 4:
                            $admin['u_group_id']='1,2,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,33,34,35,36,37,38,39,40,41,56';
                            break;
                    }
                    $admin['u_is_enabled'] = $user['u_status'];
                    $admin['u_id'] = $user['u_id'];
                    $admin['u_admin_id'] = $this->table('ffc_admins')->insertGetId($admin);
                    if(!$admin['u_admin_id']){
                        throw  new Exception(self::$ADMIN_CODE['20000016'],'20000016');
                    }
                    session('u_name',$admin['u_name']);
                }else{
                    throw  new Exception(self::$ADMIN_CODE['20000015'],'20000015');
                }
            }
        }else{
            $admin = $admin->data;
            if ($admin['u_pwd'] !== $this->setPassword($pwd)) {
                throw  new Exception(self::$ADMIN_CODE['20000012'],'20000012');
            }
            if ($admin['u_is_enabled'] != 8) {
                throw  new Exception(self::$ADMIN_CODE['20000013'],'20000013');
            }
            if(!empty($admin['u_name'])){//不是子账户登录
                $text=Db::table('ffc_users')->where("u_id",$admin['u_id'])->where("u_status","8")->find();
                if(empty($text)){
                    throw  new Exception(self::$ADMIN_CODE['20000013'],'20000013');
                }
                session('u_name',$admin['u_name']);
            }else{//子账户登录
                $text=Db::table('ffc_users')->where("u_username",$admin['u_parent_name'])->where("u_status","8")->find();
                if(empty($text)){
                    throw  new Exception(self::$ADMIN_CODE['20000013'],'20000013');
                }
                session('is_child',1);
                session('u_name',$admin['u_parent_name']);
            }
        }
        $sql = "update `ffc_users` set u_last_time='{$now}',u_last_ip='{$ip}'  where  u_username='{$username}'";
        $ssql= "update `ffc_admins` set u_last_time='{$now}',u_last_ip='{$ip}'  where  u_username='{$username}'";
        $this->query($sql);
        $this->query($ssql);
        session('admin_auth_id',$admin['u_admin_id']);
        session('admin_auth_name',$admin['u_username']);
        session('u_id',$admin['u_id']);
        session('level',$admin['u_level']);
        session('admin_auth',$admin);
        if(empty($admin['u_parent_name'])){//不是子账户  用本身自己用户名去ffc_users 表查询账号 并记录
            $userInfo = $this->query("select * from  ffc_users where u_username ='{$admin['u_username']}' limit 1");
        }else{//子账户的话查询去ffc_users 表查询主账号 记录
            $userInfo = $this->query("select * from  ffc_users where u_username ='{$admin['u_parent_name']}' limit 1");
        }
        session('userInfo',$userInfo[0]);
        return $admin;
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