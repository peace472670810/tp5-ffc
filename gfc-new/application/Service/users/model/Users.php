<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/17
 * Time: 15:07
 */

namespace app\Service\users\model;
use think\image\Exception;
use think\Model;
use think\Db;


/**
 * 用户管理模块
 * Class Users
 * @package app\Service\model
 */
class Users extends Model
{
    static  public  $user_code = [

    ];
    /**获取用户列表
     * @param int $limit
     * @return false|static[]
     */
    public function getList($data){
        $userlist = $this->where($data)->select();
        return $userlist;
    }
    /**
     *添加用户
     */
    public function addUser($data = array()){
        if(empty($data)){
            throw  new Exception("数据不能为空");
        }
            return  $this->save($data);
    }
        /**
     *修改用户
     */
    public function editUser($data,$dataes){
          
    }




}