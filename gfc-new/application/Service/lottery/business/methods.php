<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/30
 * Time: 19:20
 */

namespace app\Service\lottery\business;
use app\Service\lottery\model\Methods as methods_model;

class methods
{
    public static  $error_code = [
        '60000000' => '玩法组id参数有误！',
        '60000002' => '玩法参数有误！',
        '60000001' => '不存在该玩法！',
        '60000003' => '彩种lid参数有误！',
    ];
    public  $model = null;

    /**
     * 玩法初始化
     * methods constructor.
     */
    public function __construct()
    {
        $this->model = new methods_model();
    }

    /**
     * 根据玩法组获取玩法列表
     */
    public  function getMethodList($data){
        if(!is_numeric($data['mg_id'])){
            return   put_encode(false,'60000000',self::$error_code['60000000']);
        }
        $list =  $this->model->getMothodList($data['mg_id']);
        if($list){
            return  put_encode($list,'','');
        }
        return   put_encode(false,'60000001',self::$error_code['60000001']);
    }
    /**
     * 根据彩种获取玩法列表
     */
    public  function getMethodBylid($data){
        if(!is_numeric($data['lid'])){
            return   put_encode(false,'60000003',self::$error_code['60000003']);
        }
        $list =  $this->model->getMethodBylid($data['lid']);
        if($list){
            return  $list;
        }
        return  [];
    }
    /**
     * 获取玩法详情
     */
    public function  getMothodDetail($data){
        if(!is_numeric($data['m_id'])){
            return  put_encode(false,'60000002',self::$error_code['60000002']);
        }
        $detail = $this->model->getMothodDetail($data['m_id']);
        if($detail){
            return  put_encode($detail,'','');
        }
        return  put_encode(false,'60000001',self::$error_code['60000001']);
    }


}