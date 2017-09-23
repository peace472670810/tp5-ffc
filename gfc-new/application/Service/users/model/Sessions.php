<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/8
 * Time: 14:31
 */

namespace app\Service\users\model;


use think\Model;

class Sessions extends Model
{
    /**
     * 更新session用户登陆信息
     */
    public function updateSession($data = []){
        $username = $data['s_username'];
        unset($data['s_username']);
        $res = $this->where('s_username','eq',$username)->update($data);
        if($res){
            return $res;
        }
        return false;
    }

    /**
     * 添加用户session信息
     */
    public  function addSession($data = []){
       $s_id = $this->insertGetId($data);
       return $s_id;
    }

    /**
     * 判断session表里面是否用用户信息 有的话返回用户数据 return false;
     */
    public  function findUserSession($data = []){
        $username = $data['s_username'];
        $res = $this->query("select * from  ffc_sessions where s_username ='{$username}' limit 1");
        if($res){
            return $res[0];
        }
        return false;
    }
    /**
     * 获取某代理下的在线用户信息
     */
    public  function getUserSessions($data =[]){

    }
}