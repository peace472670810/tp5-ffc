<?php

/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 19:27
 */
namespace app\Service\usersLogs\model;
use think\Model;
class Logs extends  Model
{
    /**
     * 日志添加
     */
    public function addLogs($arr=[]){
        $res = $this->save($arr);
        if($res){
            return true;
        }
        return false;
    }
    /**
     * 删除
     */
    public function removeLogs($data=[]){
        $res = $this->destroy($data);
        if($res){
            return true;
        }
        return false;
    }
}