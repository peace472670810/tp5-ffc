<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 19:28
 */

namespace app\Service\usersLogs\model;
use think\Model;
class Userlogs extends  Model
{
    /**
     * 日志添加
     * @param array $arr
     * @return bool
     */
        public function addUserLogs($arr=[]){
            $res = $this->save($arr);
            if($res){
                return true;
            }
            return false;
        }

    /**
     * 日志删除
     */
        public function removeLogs($data){
            $res = $this->destroy($data);
            if($res){
                return true;
            }
            return false;
        }



}