<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/8
 * Time: 14:30
 * session 表 用户统计用户是否在线信息
 */

namespace app\Service\users\business;
use app\Service\users\model\Sessions as model_session;
use think\image\Exception;
use think\Log;

class sessions
{
    public $model = null;
    public  static  $error_code = [
        '230000000'=>'session添加用户参数有误!',
        '230000001'=>'mysql 服务器异常!',
        '230000002'=>'session修改用户参数有误',
        '230000003'=>'用户名不能为空!',
    ];

    public function __construct()
    {
        $this->model = new model_session();
    }
    /**
     * 前台添加用户session信息
     */
    public  function addFrontSession($data = []){
        try{
            $arr['s_username'] = $data['s_username'];
            $arr['s_pan'] = $data['s_pan'];
            $arr['s_top4'] = $data['s_top4'];
            $arr['s_top3'] = $data['s_top3'];
            $arr['s_top2'] = $data['s_top2'];
            $arr['s_top1'] = $data['s_top1'];
            $arr['s_login_time'] = $data['s_login_time'];
            $arr['s_update_time'] = $data['s_update_time'];
            $arr['s_client_ip'] = $data['s_client_ip'];
            $arr['s_server_ip'] = $data['s_server_ip'];
            $s_id = $this->model->addSession($arr);
            if($s_id){
                return put_encode($s_id,'','');
            }else{
                return  put_encode(false,'230000001',self::$error_code['230000001']);
            }
        }catch (Exception $e){
            return  put_encode(false,'230000000',self::$error_code['230000000'].$e->getMessage());
        }
    }
    /**
     * 后台添加用户session信息
     */
    public  function addAdminSession($data = []){
        try{
            $arr['s_username'] = $data['s_username'];
            $arr['s_level'] = $data['s_level'];
            $arr['s_top4'] = $data['s_top4'];
            $arr['s_top3'] = $data['s_top3'];
            $arr['s_top2'] = $data['s_top2'];
            $arr['s_top1'] = $data['s_top1'];
            $arr['s_login_time'] = $data['s_login_time'];
            $arr['s_update_time'] = $data['s_update_time'];
            $arr['s_client_ip'] = $data['s_client_ip'];
            $arr['s_server_ip'] = $data['s_server_ip'];
            $s_id = $this->model->addSession($arr);
            if($s_id){
                return put_encode($s_id,'','');
            }else{
                return  put_encode(false,'230000001',self::$error_code['230000001']);
            }
        }catch (Exception $e){
            return  put_encode(false,'230000000',self::$error_code['230000000'].$e->getMessage());
        }
    }

    /**
     * 更新session用户登陆信息
     * 因为有可能有重复相同的用户名 所以更新用session_id
     */
    public function updateFrontSession($data = []){
      try{
          $s_id = $data['s_id'];
          unset($data['s_id']);
          $res = $this->model->where('s_id','eq',$s_id)->update($data);
          if($res){
            return put_encode($res,'','');
          }else{
            return  put_encode(false,'230000001',self::$error_code['230000001']);
          }
      }catch (Exception $e){
          return  put_encode(false,'230000002',self::$error_code['230000002'].$e->getMessage());
      }
    }
    /**
     * 判断session表里面是否用用户信息 有的话返回用户数据 return false;
     */
    public  function findUserSession($data = []){
        try{
            $arr['s_username'] = $data['s_username'];
            $res = $this->model->findUserSession($arr);
            if($res){
                return put_encode($res,'','');
            }
            return  put_encode(false,'230000001',self::$error_code['230000001']);
        }catch (Exception $e){
            return  put_encode(false,'230000003',self::$error_code['230000003'].$e->getMessage());
        }
    }
    /**
     * 获取某代理下的在线用户信息
     */
    public  function getUserSessions($data =[]){

    }

}