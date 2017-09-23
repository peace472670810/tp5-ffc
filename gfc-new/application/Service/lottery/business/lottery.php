<?php

/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/23
 * Time: 15:33
 */
namespace app\Service\lottery\business;

use app\Service\lottery\model\lottery as lottery_model;

class lottery
{
    public static $error_code = [
        '30000000' => '彩种id不正确！',
        '30000001' => '彩种不存在！',
        '30000002' => '数据有误！'
    ];
    public $model = null;

    public function __construct()
    {
        $this->model = new lottery_model();
    }

    /**
     * 获取彩种信息
     * @param int $lottery_id
     * @return string
     */
    public function getLottery($lottery_id = 1)
    {
        if (!is_numeric($lottery_id)) {
            return put_encode(false, '30000000', self::$error_code['30000000']);
        }
        if (empty($this->model->lottery_list[$lottery_id])) {
            return put_encode(false, '30000001', self::$error_code['30000001']);
        }
        $lottery_detail = $this->model->getItem($lottery_id);
        if (empty($lottery_detail)) {
            return put_encode(false, '30000002', self::$error_code['30000002']);
        } else {
            return put_encode($lottery_detail, '', '');
        }
    }

    /**
     * 获取彩种列表
     * $data
     */
    public function getList($data = [])
    {
        $list = $this->model->getLotreryList($data);
        return put_encode($list, '', '');
    }

    /**
     * 获取彩种列表
     * $data
     */
    public function getLot($data = [])
    {
        $list = $this->model->getLotList($data);
        return put_encode($list, '', '');
    }
     /**
     * 后台获取彩种列表
     * $data
     */
    public function getAdmin()
    {
       $list = $this->model->getlottery();
       return put_encode($list, '', '');
        
    }
}